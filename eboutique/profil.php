<?php
require_once 'inc/init.inc.php';
require_once 'inc/functions.inc.php';

// si l'utilisateur n'est pas conecté, il ne doit arriver sur cette page. Du coup on le redirige vers connexion.php
if(!user_is_connected()) {
	header('location:connexion.php');
}




require_once 'inc/header.inc.php';
require_once 'inc/nav.inc.php';
//echo '<pre>'; print_r($_SESSION); echo '</pre>';
?>

		<div class="starter-template">
			<h1><i class="far fa-id-badge text-primary"></i></i> Profil <i class="far fa-id-badge text-primary"></i></h1>
			<p class="lead">lorem ipsum</p>
			<hr>
			<?php echo $msg; // affichage des messages utilisateur ?>
		</div>
		
		<div class="row">
			<?php 
				// Afficher les informations de l'utilisateur dans une structure html
				// Afficher si l'utilisateur est membre ou s'il est admin				
			?>
			<div class="col-6">
				<ul class="list-group" id="infos_profil">
					<li class="list-group-item active">Vos informations</li>
					<li class="list-group-item"><span>Pseudo : </span><i class="fas fa-user"></i> &nbsp;&nbsp;&nbsp;<?php echo $_SESSION['membre']['pseudo']; ?></li>
					<li class="list-group-item"><span>Nom : </span> <i class="fas fa-signature"></i> &nbsp;&nbsp;&nbsp;<?php echo $_SESSION['membre']['nom']; ?></li>
					<li class="list-group-item"><span>Prénom : </span> <i class="fas fa-signature"></i> &nbsp;&nbsp;&nbsp;<?php echo $_SESSION['membre']['prenom']; ?></li>
					<li class="list-group-item"><span>Email : </span> <i class="fas fa-envelope"></i> &nbsp;&nbsp;&nbsp;<?php echo $_SESSION['membre']['email']; ?></li>
					<li class="list-group-item"><span>Sexe : </span> 
					<?php 
						if($_SESSION['membre']['sexe'] == 'm') {
							echo '<i class="fas fa-male"></i> &nbsp;&nbsp;&nbsp;masculin';
						} else {
							echo '<i class="fas fa-female"></i> &nbsp;&nbsp;&nbsp;féminin';
						}
					?>
					</li>
					<li class="list-group-item"><span>Adresse : </span> <i class="fas fa-address-card"></i> &nbsp;&nbsp;&nbsp;<?php echo $_SESSION['membre']['adresse'] . ' ' . $_SESSION['membre']['cp'] . ' - ' . $_SESSION['membre']['ville']; ?></li>
					<li class="list-group-item"><span>Statut : </span> <?php 
						if($_SESSION['membre']['statut'] == 1) {
							echo '<i class="fas fa-user-tie"></i> &nbsp;&nbsp;&nbsp;membre';
						} else {
							echo '<i class="fas fa-user-secret"></i> &nbsp;&nbsp;&nbsp;administrateur';
						}
					?>
					</li>

				</ul>
			</div>
			<div class="col-6">
				<img src="assets/img/profil.jpg" class="img-responsive w-100">
			</div>
			<div class="col-12">
				<hr>
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










