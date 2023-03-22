<?php
require_once '../inc/init.inc.php';
require_once '../inc/functions.inc.php';

// mettre en place une restriction d'accès à cette page, si l'utilisateur n'est pas admin on le redirige sur connexion.php
if(!user_is_admin()) {
	header('location:' . URL . 'connexion.php');
	exit(); // bloque l'exécution du code de cette page après le header location
}
/*
if(!empty($_SESSION['message'])) {
	// si un message existe dans la $_SESSION
	$msg .= $_SESSION['message']; // on le récupère pour l'affichage
	$_SESSION['message'] = ''; // on vide le message puisque déjà affiché.
}
*/
//*******************************************************************
//*******************************************************************
//*******************************************************************
// SUPPRESSION PRODUIT
//*******************************************************************
//*******************************************************************
//*******************************************************************
if(isset($_GET['action']) && $_GET['action'] == 'suppression' && !empty($_GET['id_article'])) {
	// on récupère les informations du produit en bdd pour avoir le chemin de sa photo et pouvoir la supprimer également.
	$infos_produit = $pdo->prepare("SELECT * FROM article WHERE id_article = :id_article");
	$infos_produit->bindParam(':id_article', $_GET['id_article'], PDO::PARAM_STR);
	$infos_produit->execute();
	if($infos_produit->rowCount() > 0) {
		// s'il y a une ligne alors le produit existe
		$infos = $infos_produit->fetch(PDO::FETCH_ASSOC);
		$chemin_photo_suppression = RACINE_SERVEUR . RACINE_SITE . $infos['photo'];
		// on vérifie si la photo existe
		if(!empty($infos['photo']) && file_exists($chemin_photo_suppression)) {
			unlink($chemin_photo_suppression); // unlink() permet de suprimer un fichier du serveur correspondant au chemin fourni en argument.
		}
		$suppression_produit = $pdo->prepare("DELETE FROM article WHERE id_article = :id_article");
		$suppression_produit->bindParam(':id_article', $_GET['id_article'], PDO::PARAM_STR);
		$suppression_produit->execute();
		
		$_GET['action'] = 'affichage';
		
	}
}

//*******************************************************************
//*******************************************************************
//*******************************************************************
// FIN SUPPRESSION PRODUIT
//*******************************************************************
//*******************************************************************
//*******************************************************************




//*******************************************************************
//*******************************************************************
//*******************************************************************
// CREATION PRODUIT
//*******************************************************************
//*******************************************************************
//*******************************************************************
$id_article = '';
$reference = "";
$titre = "";
$prix = "";
$stock = "";
$sexe = "";
$categorie = "";
$couleur = "";
$taille = "";
$description = "";
$src = ""; // le src de la photo

// Si le formulaire a été validé
if(	isset($_POST['titre']) && 
	isset($_POST['reference']) &&
	isset($_POST['prix']) && 
	isset($_POST['stock']) && 
	isset($_POST['sexe']) && 
	isset($_POST['categorie']) && 
	isset($_POST['couleur']) && 
	isset($_POST['taille']) && 
	isset($_POST['description']) &&
	isset($_POST['id_article'])) {
		
	foreach($_POST AS $indice => $valeur) {
		$_POST[$indice] = trim($valeur); 
		// on enlève les espaces en début et fin de chaine de toutes informations présentent dans $_POST
	}
	
	$id_article = $_POST['id_article']; // soit vide car ajout soit avec un id dans le cas d'une modif
	$reference = $_POST['reference'];
	$titre = $_POST['titre'];
	$prix = $_POST['prix'];
	$stock = $_POST['stock'];
	$sexe = $_POST['sexe'];
	$categorie = $_POST['categorie'];
	$couleur = $_POST['couleur'];
	$taille = $_POST['taille'];
	$description = $_POST['description'];
	
	// contrôle sur la référence car unique en BDD
	$verif_reference = $pdo->prepare("SELECT * FROM article WHERE reference = :reference");
	$verif_reference->bindParam(':reference', $reference, PDO::PARAM_STR);
	$verif_reference->execute();
	
	if($verif_reference->rowCount() > 0 && empty($id_article)) {
		$msg .= '<div class="alert alert-danger">Attention la référence : ' . $reference . ' est indisponible</div>';
		
	} else {
		// controles sur la photo
		// les champs input type="file" se retrouvent dans la superglobale $_FILES
		// pour retrouver le(s) fichier(s) le formulaire doit avoir l'attribut enctype="multipart/form-data"
		// $_FILES est multidimensionnel
		
		// si on est dans le cas d'une modif, on conserve l'ancienne photo dans la variable $src qui sera écrasée si l'utilisateur charge une nouvelle photo.
		if(!empty($_POST['ancienne_photo'])) {
			$src = $_POST['ancienne_photo'];
		}
		
		if(!empty($_FILES['photo']['name'])) {
			// si une fichier a été chargé.
			
			// on récupère l'extension du fichier présente dans le name
			$extension = strrchr($_FILES['photo']['name'], '.');
			// strrchr() permet de découper une chaine en partant de la fin selon un caractère fourni en deuxièmme argument.
			// exemple pour image.jpg on récupère .jpg
			// echo 'Extension après strrchr : '; var_dump($extension); echo '<hr>';
			$tab_extension_valide = array('gif', 'jpg', 'jpeg', 'png');
			// echo 'Contenu du tableau des extensions : '; var_dump($tab_extension_valide); echo '<hr>';
			// on coupe le point sur $extension et on transforme en minuscule
			$extension = strtolower(substr($extension, 1));
			// echo 'Extension après mise en minuscule et découpe : '; var_dump($extension); echo '<hr>';
			// exemple : pour .PNG on récupère png
			
			// on vérifie si $extension fait partie des valeurs présentent dans $tab_extension_valide
			// in_array() renvoie true si le premier argument correspond à une des valeurs d'un tableau fourni en deuxième argument.
			$verif_extension = in_array($extension, $tab_extension_valide);
			// echo 'Valeur de controle : '; var_dump($verif_extension); echo '<hr>';
			
			if($verif_extension) {
				
				// on renomme le nom du fichier pour ne pas écraser un fichier du même nom déjà présent sur le serveur. Pour cela on rajoute la référence (unique) sur le nom
				$nom_photo = $reference . '-' . $_FILES['photo']['name'];
				
				// on prépare le chemin de la photo qui sera enregistré en bdd
				$src = "assets/photo/" . $nom_photo;
				// var_dump($nom_photo); echo '<hr>';
				// var_dump($src); echo '<hr>';
				
				$chemin_dossier = RACINE_SERVEUR . RACINE_SITE . $src; // chemin où la photo va être enregistrée
				// var_dump($chemin_dossier); echo '<hr>';
				
				// copy() permet de copier un fichier depuis un emplacement fourni en premier argument vers un emplacement fourni en deuxième argument.
				copy($_FILES['photo']['tmp_name'], $chemin_dossier);
				
			} else {
				$msg .= '<div class="alert alert-danger">La photo n\'est pas valide, extension acceptées : jpg, jpeg, png, gif</div>';
			}
			
			
		}// fin du if(!empty($_FILES['photo']['name']))
		
		// enregistrement des produits
		if(empty($msg)) {
			// si $msg est vide, il n'y pas eu d'erreur dans nos traitement, on lance l'enregistrement
			
			if(empty($id_article)) {
				// Ajout
				$enregistrement_produit = $pdo->prepare("INSERT INTO article (reference, categorie, titre, description, couleur, taille, sexe, photo, prix, stock) VALUES (:reference, :categorie, :titre, :description, :couleur, :taille, :sexe, :photo, :prix, :stock)");
			} else {
				// Modif
				$enregistrement_produit = $pdo->prepare("UPDATE article SET reference = :reference, categorie = :categorie, titre = :titre, description = :description, couleur = :couleur, taille = :taille, sexe = :sexe, photo = :photo, prix = :prix, stock = :stock WHERE id_article = :id_article");
				$enregistrement_produit->bindParam(":id_article", $id_article, PDO::PARAM_STR);
			}				
			
			$enregistrement_produit->bindParam(":reference", $reference, PDO::PARAM_STR);
			$enregistrement_produit->bindParam(":categorie", $categorie, PDO::PARAM_STR);
			$enregistrement_produit->bindParam(":titre", $titre, PDO::PARAM_STR);
			$enregistrement_produit->bindParam(":description", $description, PDO::PARAM_STR);
			$enregistrement_produit->bindParam(":couleur", $couleur, PDO::PARAM_STR);
			$enregistrement_produit->bindParam(":taille", $taille, PDO::PARAM_STR);
			$enregistrement_produit->bindParam(":sexe", $sexe, PDO::PARAM_STR);
			$enregistrement_produit->bindParam(":photo", $src, PDO::PARAM_STR);
			$enregistrement_produit->bindParam(":prix", $prix, PDO::PARAM_STR);
			$enregistrement_produit->bindParam(":stock", $stock, PDO::PARAM_STR);
			$enregistrement_produit->execute();
			
			// $_SESSION['message'] = '<div class="alert alert-success">Ok</div>'; 
			// pour conserver un message après la redirection en dessous, on le place dans la $_SESSION
			
			header('location:' . $_SERVER['PHP_SELF']); // on redirige sur la même page pour perdre les informations provenant de POST et éviter une double insertion avec F5
			
		}		
	}		
}




//*******************************************************************
//*******************************************************************
//*******************************************************************
// FIN CREATION PRODUIT
//*******************************************************************
//*******************************************************************
//*******************************************************************


//*******************************************************************
//*******************************************************************
//*******************************************************************
// MODIFICATION PRODUIT
//*******************************************************************
//*******************************************************************
//*******************************************************************
if(isset($_GET['action']) && $_GET['action'] == 'modification' && !empty($_GET['id_article'])) {
	$infos_produit_modif = $pdo->prepare("SELECT * FROM article WHERE id_article = :id_article");
	$infos_produit_modif->bindParam(':id_article', $_GET['id_article'], PDO::PARAM_STR);
	$infos_produit_modif->execute();
	
	if($infos_produit_modif->rowCount() > 0) {
		$infos_modif = $infos_produit_modif->fetch(PDO::FETCH_ASSOC);
		
		$id_article = $infos_modif['id_article'];
		$reference = $infos_modif['reference'];
		$titre = $infos_modif['titre'];
		$prix = $infos_modif['prix'];
		$stock = $infos_modif['stock'];
		$sexe = $infos_modif['sexe'];
		$categorie = $infos_modif['categorie'];
		$couleur = $infos_modif['couleur'];
		$taille = $infos_modif['taille'];
		$description = $infos_modif['description'];
		$ancienne_photo =  $infos_modif['photo'];
	}
}

//*******************************************************************
//*******************************************************************
//*******************************************************************
// FIN MODIFICATION PRODUIT
//*******************************************************************
//*******************************************************************
//*******************************************************************





require_once '../inc/header.inc.php';
require_once '../inc/nav.inc.php';
// echo '<pre>'; var_dump($_POST); echo '</pre>';
// echo '<pre>'; var_dump($_FILES); echo '</pre>';
// echo '<pre>'; var_dump($_SERVER); echo '</pre>';
?>

		<div class="starter-template">
			<h1><i class="fas fa-socks text-primary"></i> Gestion produit <i class="fas fa-socks text-primary"></i></h1>
			<p class="lead">lorem ipsum</p>
			<hr>
			<a href="?action=ajouter" class="btn btn-outline-primary">Ajout produit</a> 
			<a href="?action=affichage" class="btn btn-outline-danger">Affichage des produits</a>
			<hr>
			<?php echo $msg; // affichage des messages utilisateur ?>
			<?php // echo addslashes("C'est un beau jour aujourd'hui"); // exemple pour addslashes() ?>
		</div>
		
		<?php 
		// *****************************************************
		// **************** AJOUT PRODUIT **********************
		// *****************************************************		
		if(isset($_GET['action']) && ($_GET['action'] == 'ajouter' || $_GET['action'] == 'modification' )) { 
		
		?>
		
		<div class="row">
			<div class="col-12">
				<form method="post" action="" enctype="multipart/form-data" >
					<div class="row">
						<div class="col-6">
							<div class="form-group">								
								<label for="titre">Titre <i class="fas fa-heading text-primary"></i></label>
								<input type="text" class="form-control" name="titre" id="titre" value="<?php echo $titre; ?>">
							</div>
							<div class="form-group">
								<label for="reference">Référence <i class="fas fa-asterisk text-primary"></i></label>
								<input type="text" class="form-control" name="reference" id="reference" value="<?php echo $reference; ?>">
							</div>
							<div class="form-group">
								<label for="prix">Prix <i class="fas fa-euro-sign text-primary"></i></label>
								<input type="text" class="form-control" name="prix" id="prix" value="<?php echo $prix; ?>">
							</div>
							<div class="form-group">
								<label for="stock">Stock <i class="fas fa-layer-group text-primary"></i></label>
								<input type="text" class="form-control" name="stock" id="stock" value="<?php echo $stock; ?>">
							</div>
							
							<?php 
								if(!empty($ancienne_photo)) {
									echo '<div class="form-group text-center">';
									echo '<label>Photo actuelle</label><hr>';
									echo '<img src="' . URL . $ancienne_photo . '" alt="Ancienne photo" width="200" class="img-thumbnail">';
									echo '<input type="hidden" name="ancienne_photo" value="' . $ancienne_photo . '">';
									echo '</div>';

								}
							?>
							
							<div class="form-group">
								<label for="photo">Photo <i class="fas fa-image text-primary"></i></label>
								<input type="file" class="form-control" name="photo" id="photo" >
							</div>
							<div class="form-group">
								<label for="sexe">Sexe <i class="fas fa-male text-primary"></i><i class="fas fa-female text-primary"></i></label>
								<select class="form-control" id="sexe" name="sexe">
									<option value="m">Homme</option>
									<option value="f" <?php if($sexe == 'f') { echo "selected"; } ?> >Femme</option>
								</select>
							</div>
						</div>
						<div class="col-6">
							<div class="form-group">
								<label for="categorie">Catégorie <i class="fas fa-list text-primary"></i></label>
								<select class="form-control" id="categorie" name="categorie">
									<option>Tshirt</option>
									<option <?php if($categorie == 'Pantalon') { echo "selected"; } ?> >Pantalon</option>
									<option <?php if($categorie == 'Chemise') { echo "selected"; } ?> >Chemise</option>
									<option <?php if($categorie == 'Veste') { echo "selected"; } ?> >Veste</option>
									<option <?php if($categorie == 'Polo') { echo "selected"; } ?> >Polo</option>
									<option <?php if($categorie == 'Ceinture') { echo "selected"; } ?> >Ceinture</option>
									<option <?php if($categorie == 'Chaussettes') { echo "selected"; } ?> >Chaussettes </option>
									<option <?php if($categorie == 'Echarpe') { echo "selected"; } ?> >Echarpe</option>
								</select>
							</div>
							<div class="form-group">
								<label for="couleur">Couleur <i class="fas fa-tint text-primary"></i></label>
								<select class="form-control" id="couleur" name="couleur">
									<option>Noir</option>
									<option <?php if($couleur == 'Blanc') { echo "selected"; } ?> >Blanc</option>
									<option <?php if($couleur == 'Rouge') { echo "selected"; } ?> >Rouge</option>
									<option <?php if($couleur == 'Bleu') { echo "selected"; } ?> >Bleu</option>
									<option <?php if($couleur == 'Jaune') { echo "selected"; } ?> >Jaune</option>
									<option <?php if($couleur == 'Beige') { echo "selected"; } ?> >Beige</option>
									<option <?php if($couleur == 'Vert') { echo "selected"; } ?> >Vert</option>
									<option <?php if($couleur == 'Gris') { echo "selected"; } ?> >Gris</option>
									<option <?php if($couleur == 'Rose') { echo "selected"; } ?> >Rose</option>
									<option <?php if($couleur == 'Marron') { echo "selected"; } ?> >Marron</option>
								</select>
							</div>
							<div class="form-group">
								<label for="taille">Taille <i class="fas fa-arrows-alt-v text-primary"></i></label>
								<select class="form-control" id="taille" name="taille">
									<option>XS</option>
									<option <?php if($taille == 'S') { echo "selected"; } ?> >S</option>
									<option <?php if($taille == 'M') { echo "selected"; } ?> >M</option>
									<option <?php if($taille == 'L') { echo "selected"; } ?> >L</option>
									<option <?php if($taille == 'XL') { echo "selected"; } ?> >XL</option>
								</select>
							</div>
							<div class="form-group">
								<label for="description">Description <i class="fas fa-file-alt text-primary"></i></label>
								<textarea name="description" id="description" class="form-control" rows="5"><?php echo $description; ?></textarea>
							</div>
							<div class="form-group">
								<!-- champ nécessaire pour la modification. -->
								<input type="hidden" name="id_article" value="<?php echo $id_article; ?>">
								<label></label>
								<button type="submit" name="enregistrer" id="enregistrer" class="btn btn-primary w-100"><i class="far fa-save"></i> <?php echo ucfirst($_GET['action']); ?></button>
							</div>
						</div>
				</form>
				
				
				</div>
				
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				<br>
				
				
				
			</div>
		</div>
		<?php } // fin du if(isset($_GET['action']) && $_GET['action'] == 'ajouter')  
			
		// echo '</main>';
		// echo '<div class="container-fluid">';
		// **************************************************************
		// **************** AFFICHAGE DES PRODUITS **********************
		// **************************************************************		
		if(isset($_GET['action']) && $_GET['action'] == 'affichage') { 
		
			$liste_produit = $pdo->query("SELECT * FROM article");
			
			echo '<div class="row">';
			echo '<div class="col-12">';
			echo '<p>Il y a <span class="text-danger font-weight-bold">' . $liste_produit->rowCount() . '</span> produits</p>';
			echo '<table class="table table-bordered">';
			echo '<thead><tr>
				<th>Id article</th>
				<th>Titre</th>				
				<th>Réf</th>
				<th>Prix</th>
				<th>Stock</th>
				<th>Photo</th>
				<th>Catégorie</th>
				<th>Sexe</th>
				<th>Couleur</th>
				<th>Taille</th>
				<th>Description</th>
				<th>Modif</th>
				<th>Suppr</th>
				</tr></thead><tbody>';
				
			// affichage des produits
			while($produit = $liste_produit->fetch(PDO::FETCH_ASSOC)) {
				echo '<tr>';
				
				echo '<td>' . $produit['id_article'] . '</td>';
				echo '<td>' . $produit['titre'] . '</td>';
				echo '<td>' . $produit['reference'] . '</td>';
				echo '<td>' . $produit['prix'] . '€</td>';
				echo '<td>' . $produit['stock'] . '</td>';
				echo '<td><img src="' . URL . $produit['photo'] . '" class="img-thumbnail" width="140" alt="une image produit"></td>';
				echo '<td>' . $produit['categorie'] . '</td>';
				echo '<td>' . $produit['sexe'] . '</td>';
				echo '<td>' . $produit['couleur'] . '</td>';
				echo '<td>' . $produit['taille'] . '</td>';
				echo '<td>' . substr($produit['description'], 0, 20) . ' <a href="">...</a></td>';
				
				echo '<td><a href="?action=modification&id_article=' . $produit['id_article'] . '" class="btn btn-warning text-white"><i class="fas fa-edit"></i></a></td>';
				
				echo '<td><a href="?action=suppression&id_article=' . $produit['id_article'] . '" class="btn btn-danger" onclick="return(confirm(\' Etes vous sûr ? \'))" ><i class="fas fa-trash-alt"></i></a></td>';
				
				echo '</tr>';				
			}
			
			echo '</tbody></table>';
			echo '</div></div>'; // fermeture div class row et div class col-12			
		
		}
		// echo '</div>';
		// echo '<main>';
		?>

<?php
require_once '../inc/footer.inc.php';










