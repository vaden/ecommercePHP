<?php
require_once 'inc/init.inc.php';
require_once 'inc/functions.inc.php';

if(user_is_connected()) {
	header('location:profil.php');
}

$pseudo = "";
$nom = '';
$prenom = '';
$email = '';
$sexe = "";
$adresse = "";
$ville = "";
$cp = "";

if(	isset($_POST['pseudo']) && 
	isset($_POST['mdp']) &&
	isset($_POST['mdp_confirm']) &&
	isset($_POST['nom']) &&
	isset($_POST['prenom']) &&
	isset($_POST['email']) &&
	isset($_POST['sexe']) &&
	isset($_POST['adresse']) &&
	isset($_POST['ville']) &&
	isset($_POST['cp']) ) {
		
	foreach($_POST AS $indice => $valeur) {
		$_POST[$indice] = trim($valeur); 
		// on enlève les espaces en début et fin de chaine de toutes informations présentent dans $_POST
	}
	
	// on met les informations provenants de $_POST dans des variables pour faciliter l'écriture et aussi pour que l'information soit affichée dans les champs du formulaire (voir dans les value="" des champs)
	$pseudo = $_POST['pseudo'];
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$email = $_POST['email'];
	$sexe = $_POST['sexe'];
	$adresse = $_POST['adresse'];
	$ville = $_POST['ville'];
	$cp = $_POST['cp'];	
	$mdp = $_POST['mdp'];	
	$mdp_confirm = $_POST['mdp_confirm'];	
	
	$verif_pseudo = preg_match('#^[a-zA-Z0-9._-]+$#', $pseudo);
	// preg_match() permet de tester une chaine de caractère fournie en deuxième argument (ici $pseudo) selon une expression reguliere fournie en premier argument.
	/*
		les deux ## représente le début et la fin de l'expression reguliere (ça pourrait aussi être des antislash)
		^ représente le début de la chaine, signifie que la chaine ne peut pas commencer par autre chose que les caractères contenus dans l'expression
		$ représente la fin de la chaine, signifie que la chaine ne peut pas finir par autre chose que les caractères de l'expression.
		+ permet d'autoriser la présence multiple d'un caractère.
		entre [] sont les caractères autorisés.
		preg_match() est sensible à la casse.
		preg_match() renvoie 1 (true) si tout est ok ou 0 (false) s'il y a un souci.		
	*/
	
	// vérification via l'expression régulière de la validité du pseudo
	if(!$verif_pseudo) {
		// si $verif_pseudo renvoie 0 alors il y a une erreur
		$msg .= '<div class="alert alert-danger">Erreur sur le pseudo,<br>Caractères autorisés: A à Z , 0 à 9 et les caractères suivants: _ - .</div>';
	}
	
	// vérification de la taille du pseudo (entre 4 et 14 caractères)
	if(iconv_strlen($pseudo) < 4 || iconv_strlen($pseudo) > 14) {
		$msg .= '<div class="alert alert-danger">Erreur sur le pseudo,<br>Le pseudo doit avoir entre 4 et 14 caractères inclus</div>';
	}
	
	// vérification du mdp
	if(empty($mdp)) {
		$msg .= '<div class="alert alert-danger">Le mot de passe est obligatoire !</div>';
	}
	
	// vérification du mdp avec le confirm mdp
	if($mdp != $mdp_confirm && !empty($mdp)) {
		$msg .= '<div class="alert alert-danger">Erreur sur le mot de passe,<br>Le mot doit être identique dans les deux champs !</div>';
	}
	
	// vérification de la validité du format email
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$msg .= '<div class="alert alert-danger">Erreur sur l\'email,<br>Le format n\'est pas valide !</div>';
	}
	
	if(empty($msg)) {
		// si $msg est vide, alors il n'y a pas eu d'erreur.
		
		// vérification si le pseudo est disponible
		$pseudo_dispo = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
		$pseudo_dispo->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
		$pseudo_dispo->execute();
		
		if($pseudo_dispo->rowCount() > 0) {
			// s'il y au moins une ligne, alors le pseudo n'est pas disponible
			$msg .= '<div class="alert alert-danger">Pseudo indisponible !</div>';
		} else {
			// tout est ok on enregistre
			$enregistrement = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, sexe, ville, cp, adresse, statut) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :sexe, :ville, :cp, :adresse, 1)");
			
			$mdp = password_hash($mdp, PASSWORD_DEFAULT); // on hash (cryptage) le mdp
			
			$enregistrement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
			$enregistrement->bindParam(':mdp', $mdp, PDO::PARAM_STR);
			$enregistrement->bindParam(':nom', $nom, PDO::PARAM_STR);
			$enregistrement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
			$enregistrement->bindParam(':email', $email, PDO::PARAM_STR);
			$enregistrement->bindParam(':sexe', $sexe, PDO::PARAM_STR);
			$enregistrement->bindParam(':ville', $ville, PDO::PARAM_STR);
			$enregistrement->bindParam(':cp', $cp, PDO::PARAM_STR);
			$enregistrement->bindParam(':adresse', $adresse, PDO::PARAM_STR);
			$enregistrement->execute();
			
			// on redirige vers la page connexion
			header("location:connexion.php");
		}		
	}	
}




require_once 'inc/header.inc.php';
require_once 'inc/nav.inc.php';
// echo '<pre>'; var_dump($_POST); echo '</pre>';
?>

		<div class="starter-template">
			<h1><i class="fas fa-user text-danger"></i> Inscription <i class="fas fa-user text-danger"></i></h1>
			<p class="lead">Bienvenue sur notre site, vous pouvez vous inscrire en utilisant le formulaire de cette page.</p>
			<hr>
			<?php echo $msg; // affichage des messages utilisateur ?>
		</div>
		
		
		
<div class="row">
	<div class="col-12 ">
		<form method="post" action="">
		
			<div class="row">
				<div class="col-6 ">
				
			<div class="form-group">
				<label for="pseudo">Pseudo</label>
				<input type="text" id="pseudo" name="pseudo" class="form-control" value="<?php echo $pseudo; ?>">
			</div>
			<div class="form-group">
				<label for="mdp">Mot de passe</label>
				<input type="text" id="mdp" name="mdp" class="form-control" value="">
			</div>
			<div class="form-group">
				<label for="mdp_confirm">Confirmation mot de passe</label>
				<input type="text" id="mdp_confirm" name="mdp_confirm" class="form-control" value="">
			</div>
			<div class="form-group">
				<label for="nom">Nom</label>
				<input type="text" id="nom" name="nom" class="form-control" value="<?php echo $nom; ?>">
			</div>
			<div class="form-group">
				<label for="prenom">Prénom</label>
				<input type="text" id="prenom" name="prenom" class="form-control" value="<?php echo $prenom; ?>">
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
			</div>
			
			</div>
			<div class="col-6">
			
			<div class="form-group">
				<label for="sexe">Sexe</label>
				<select class="form-control" id="sexe" name="sexe">
					<option value="m">Homme</option>
					<option value="f" <?php if($sexe == 'f') { echo "selected"; } ?> >Femme</option>
				</select>
			</div>
			<div class="form-group">
				<label for="ville">Ville</label>
				<input type="text" id="ville" name="ville" class="form-control" value="<?php echo $ville; ?>">
			</div>
			<div class="form-group">
				<label for="cp">Code postal</label>
				<input type="text" id="cp" name="cp" class="form-control" value="<?php echo $cp; ?>">
			</div>
			<div class="form-group">
				<label for="adresse">Adresse</label>
				<textarea name="adresse" id="adresse" class="form-control" rows="5"><?php echo $adresse; ?></textarea>
			</div>
			<div class="form-group">
				<br>
				<button type="submit" name="inscription" id="inscription" class="btn btn-success w-100">S'inscrire</button>
			</div>
			
			</div><!-- fermeture col-6 -->
		</form>
		
		
		
		
		
		
		
		
		
		
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
		
		

<?php
require_once 'inc/footer.inc.php';










