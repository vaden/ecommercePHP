<?php
require_once 'inc/init.inc.php';
require_once 'inc/functions.inc.php';
// Suppression du panier.
if(isset($_GET['action']) && $_GET['action'] == 'vider') {
		unset($_SESSION['panier']);
}

// Paiement du panier
if(isset($_GET['action']) && $_GET['action'] == 'payer' && !empty($_SESSION['panier']['id_article'])) {
	// pour valider la commande, nous devons comparer la quantité demandée avec le stock en BDD
	for($i = 0; $i < sizeof($_SESSION['panier']['titre']); $i++) {
		// on récupère le stock en BDD de chaque article 
		$resultat = $pdo->prepare("SELECT * FROM article WHERE id_article = :id_article");
		$resultat->bindParam(':id_article', $_SESSION['panier']['id_article'][$i], PDO::PARAM_STR);
		$resultat->execute();
		
		$produit_en_cours = $resultat->fetch(PDO::FETCH_ASSOC);
		
		// on compare la quantité du panier de cet article avec son stock de la BDD
		if($produit_en_cours['stock'] < $_SESSION['panier']['quantite'][$i]) {
			// si on rentre ici, il y a une erreur
			$erreur = true; // variable de controle pour valider le panier ensuite ou pas.
			if($produit_en_cours['stock'] > 0) {
				// il reste du stock mais moins que la quantité, on modifie la quantité dans le panier
				$_SESSION['panier']['quantite'][$i] = $produit_en_cours['stock'];
				$msg .= '<div class="alert alert-danger">La quantité de l\'article n° ' . $_SESSION['panier']['id_article'][$i] . ' ' . $_SESSION['panier']['titre'][$i] . ' a été réduite car le stock restant est insuffisant<br>Veuillez vérifier votre panier.</div>';
			} else {
				// stock à zéro, on retire l'article du panier				
				$msg .= '<div class="alert alert-danger">L\'article n° ' . $_SESSION['panier']['id_article'][$i] . ' ' . $_SESSION['panier']['titre'][$i] . ' a été retiré de votre panier car nous sommes en rupture de stock<br>Veuillez vérifier votre panier.</div>';
				
				retirer_article_panier($_SESSION['panier']['id_article'][$i]);
				
				$i--; // lorsque l'on retire un article, les indices sont réordonnés, donc on enlève 1 à la valeur de $i pour ne pas rater l'article ayant remplacer celui qu'on vient de retirer.
				
			}
		}
	}
	if(!isset($erreur)) {
		// si $erreur n'existe pas alors les quantités sont ok, on enregistre la commande.
		$id_membre = $_SESSION['membre']['id_membre'];
		$total = montant_total();
		$pdo->query("INSERT INTO commande (id_membre, montant, date_commande) VALUES ($id_membre, $total, NOW())");
		
		// on récupère l'id_commande
		$id_commande = $pdo->lastInsertId();
		for($i = 0; $i < count($_SESSION['panier']['prix']); $i++) {
			
			$id_article = $_SESSION['panier']['id_article'][$i];
			$prix = $_SESSION['panier']['prix'][$i];
			$quantite = $_SESSION['panier']['quantite'][$i];
			
			$enregistrement_details_commande = $pdo->prepare("INSERT INTO details_commande (id_commande, id_article, quantite, prix) VALUES (:id_commande, :id_article, :quantite, :prix)");
			$enregistrement_details_commande->bindParam(':id_commande', $id_commande, PDO::PARAM_STR);
			$enregistrement_details_commande->bindParam(':id_article', $id_article, PDO::PARAM_STR);
			$enregistrement_details_commande->bindParam(':quantite', $quantite, PDO::PARAM_STR);
			$enregistrement_details_commande->bindParam(':prix', $prix, PDO::PARAM_STR);
			$enregistrement_details_commande->execute();
			
			// mise à jour du stock en BDD
			$maj_stock = $pdo->prepare("UPDATE article SET stock = stock - :quantite WHERE id_article = :id_article");
			$maj_stock->bindParam(':id_article', $id_article, PDO::PARAM_STR);
			$maj_stock->bindParam(':quantite', $quantite, PDO::PARAM_STR);
			$maj_stock->execute();
		}		
		unset($_SESSION['panier']); // on vide le panier
		// mail($_SESSION['membre']['email'], "Confirmation de la commande", "Bonjour, merci pour votre commande. Votre numéro de commande est $id_commande", "From:vendeur@mail.fr");
		$msg .= '<div class="alert alert-success">Merci pour votre commande. Votre numéro de commande est ' . $id_commande . '.</div>';
		
	}
}

creation_panier(); // création du panier

if(isset($_POST['ajout_panier']) && !empty($_POST['id_article']) && !empty($_POST['quantite'])) {
	// les $_POST de ce if proviennent de la page fiche_produit lorsque l'on clic sur Ajouter au panier
	$infos_produit = $pdo->prepare("SELECT * FROM article where id_article = :id_article");
	$infos_produit->bindParam(':id_article', $_POST['id_article'], PDO::PARAM_STR);
	$infos_produit->execute();
	
	if($infos_produit->rowCount() > 0) {
		$produit = $infos_produit->fetch(PDO::FETCH_ASSOC);
		// on ajoute dans le panier.
		ajouter_article_dans_panier($produit['titre'], $_POST['id_article'], $produit['prix'], $_POST['quantite'], $produit['photo']);
		header('location:' . $_SERVER['PHP_SELF']); // on redirige sur la même page pour perdre les informations provenant de POST et éviter une double insertion avec F5
	}
	
}

// retirer un article du panier
if(isset($_GET['action']) && $_GET['action'] == 'retirer' && !empty($_GET['id_article']) && is_numeric($_GET['id_article'])) {
	retirer_article_panier($_GET['id_article']); // appel de la fonction pour retirer
}




require_once 'inc/header.inc.php';
require_once 'inc/nav.inc.php';
//echo '<pre>'; print_r($_POST); echo '</pre>';
//echo '<pre>'; print_r($_SESSION['panier']); echo '</pre>';
//echo '<pre>'; print_r($_SERVER); echo '</pre>';
?>

		<div class="starter-template">
			<h1><i class="fas fa-tshirt text-danger"></i> Panier <i class="fas fa-tshirt text-danger"></i></h1>
			<p class="lead">lorem ipsum</p>
			<hr>
			<?php echo $msg; // affichage des messages utilisateur ?>
		</div>
		
		<div class="row">
			<div class="col-8 mx-auto">
			
				<table class="table table-bordered">
					<tr>
					<?php
						if(empty($_SESSION['panier']['quantite'])) {
							echo '<th colspan="6">Panier</th>';
						} else {
							echo '<th colspan="4">Panier</th>
						<th colspan="2"><a href="?action=vider" class="btn btn-danger w-100">Vider le panier</a></th>';
						}

					?>						
					</tr>
					<tr><th>N°produit</th><th>Titre</th><th>Photo</th><th>Quantité</th><th>Prix HT</th><th>Retirer</th></tr>
					
					<?php 
						// afficher le contenu du panier dans le tableau s'il y a quelque chose sinon un message votre panier est vide.
						// Afficher les informations de livraison dans la page 
						
						// si le panier n'est pas vide, rajouter une ligne avec un bouton action=payer SI l'utilisateur est connecté SINON mettre du texte proposant la connexion ou l'inscription sous forme de lien vers ces pages.
						
						if(empty($_SESSION['panier']['photo'])) {
							echo '<tr><td colspan="6">Votre panier est vide</td></tr>';
						} else {
							$taille_panier = count($_SESSION['panier']['quantite']);
							for($i = 0; $i < $taille_panier; $i++) {
								echo '<tr>';
								echo '<td class="align-middle">' . $_SESSION['panier']['id_article'][$i] . '</td>';
								echo '<td class="align-middle">' . $_SESSION['panier']['titre'][$i] . '</td>';
								echo '<td class="text-center align-middle"><img src="' . URL . $_SESSION['panier']['photo'][$i] . '" class="img-thumbnail" width="70" alt="' . $_SESSION['panier']['titre'][$i] . '"></td>';
								echo '<td class="align-middle">' . $_SESSION['panier']['quantite'][$i] . '</td>';
								echo '<td class="align-middle">' . $_SESSION['panier']['prix'][$i] . '</td>';
								
								echo '<td class="align-middle"><a href="?action=retirer&id_article=' . $_SESSION['panier']['id_article'][$i] . '" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a></td>';
								
								echo '</tr>';
							}
							echo '<tr><td colspan="6" class="text-right">';
							echo '<b>Montant total du panier TTC</b> <span class="small">(TVA : 20%)</span> : &nbsp;&nbsp;&nbsp;&nbsp;<b>' . montant_total() . ' €</b>';
							echo '</td></tr>';
							
							echo '<tr><td colspan="6">';
							
							if(user_is_connected()) {
								echo '<a href="?action=payer" class="btn btn-success">Payer le panier</a>';
							} else {
								echo 'Veuillez vous <a href="' . URL . 'connexion.php">connecter</a> ou vous <a href="' . URL . 'inscription.php">inscrire</a> pour payer votre panier';
							}
							
							echo '</td></tr>';
						}
					?>
					
				</table>
				<p>Paiement par chèque uniquement à l'adresse : 14 rue du truc 75000 Paris</p>
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

<?php
require_once 'inc/footer.inc.php';










