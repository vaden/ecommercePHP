<?php
require_once 'inc/init.inc.php';
require_once 'inc/functions.inc.php';

// déconnexion utilisateur
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion') {
	session_destroy();
}



if(user_is_connected()) {
	header('location:profil.php');
}





$pseudo = "";
$mdp = "";
if(isset($_POST['pseudo']) && isset($_POST['mdp'])) {
	
	foreach($_POST AS $indice => $valeur) {
		$_POST[$indice] = trim($valeur); 
		// on enlève les espaces en début et fin de chaine de toutes informations présentent dans $_POST
	}
	
	$pseudo = $_POST['pseudo'];
	$mdp = $_POST['mdp'];
	
	// on récupère en bdd les informations d'un utilisateur sur la base du pseudo
	$membre = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
	$membre->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
	$membre->execute();
	
	if($membre->rowCount() > 0) {
		// s'il y a une ligne alors le pseudo est ok
		$infos_membre = $membre->fetch(PDO::FETCH_ASSOC);
		// echo '<pre>'; print_r($infos_membre); echo '</pre>';
		
		// vérification du mot de passe
		if(password_verify($mdp, $infos_membre['mdp'])) {
			// password_verify() permet de tester une saisie utilisateur (ici $mdp) avec un mot de passe crypté avec la fonction password_hash() (ici $infos_membre['mdp'])
			// renvoie true ou false
			
			// si on se trouve dans ce if, l'utilisateur a donné un pseudo et mdp corrects
			// on enregistre ses informations dans la session
			$_SESSION['membre']['id_membre'] = $infos_membre['id_membre'];
			$_SESSION['membre']['pseudo'] = $infos_membre['pseudo'];
			$_SESSION['membre']['nom'] = $infos_membre['nom'];
			$_SESSION['membre']['prenom'] = $infos_membre['prenom'];
			$_SESSION['membre']['sexe'] = $infos_membre['sexe'];
			$_SESSION['membre']['ville'] = $infos_membre['ville'];
			$_SESSION['membre']['cp'] = $infos_membre['cp'];
			$_SESSION['membre']['adresse'] = $infos_membre['adresse'];
			$_SESSION['membre']['email'] = $infos_membre['email'];
			$_SESSION['membre']['statut'] = $infos_membre['statut'];
			
			/*
			foreach($infos_membre AS $indice => $valeur) {
				if($indice != 'mdp') {
					$_SESSION['membre'][$indice] = $valeur;
				}				
			}
			*/
			// si l'utilisateur est connecté, on le redirige vers la page profil.
			header('location:profil.php');
			
			
			
						
			
		} else {
			$msg .= '<div class="alert alert-danger">Erreur sur le pseudo et/ou le mot de passe</div>';
		}
		
	} else {
		$msg .= '<div class="alert alert-danger">Erreur sur le pseudo et/ou le mot de passe</div>';
	}
	
	
	
}




require_once 'inc/header.inc.php';
require_once 'inc/nav.inc.php';
//echo '<pre>'; print_r($_SESSION); echo '</pre>';
?>

		<div class="starter-template">
			<h1><i class="fas fa-tshirt text-danger"></i> Connexion <i class="fas fa-tshirt text-danger"></i></h1>
			<p class="lead">lorem ipsum</p>
			<hr>
			<?php echo $msg; // affichage des messages utilisateur ?>
		</div>
		
		<div class="row">
			<div class="col-6 mx-auto">
				<form method="post" action="">
								
				
			<div class="form-group">
				<label for="pseudo">Pseudo</label>
				<input type="text" id="pseudo" name="pseudo" class="form-control" value="<?php echo $pseudo; ?>">
			</div>
			<div class="form-group">
				<label for="mdp">Mot de passe</label>
				<input type="text" id="mdp" name="mdp" class="form-control" value="">
			</div>	

			<div class="form-group">
				<br>
				<button type="submit" name="connexion" id="connexion" class="btn btn-primary w-100">Connexion</button>
			</div>			
			
			
				</form>
			</div>
		</div>

<?php
require_once 'inc/footer.inc.php';










