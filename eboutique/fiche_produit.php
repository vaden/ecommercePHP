<?php
require_once 'inc/init.inc.php';
require_once 'inc/functions.inc.php';

if(empty($_GET['id_article'])) {
	// si l'id_article n'existe pas ou est vide, on redirige sur la page d'accueil
	header('location:index.php');
}
	
$infos_produit = $pdo->prepare("SELECT * FROM article WHERE id_article = :id_article");
$infos_produit->bindParam(':id_article', $_GET['id_article'], PDO::PARAM_STR);
$infos_produit->execute();

if($infos_produit->rowCount() < 1) {
	// si le produit n'existe pas en BDD car id_article potentiellement manipulé par l'utilisateur dans l'url, on redirige.
	header('location:index.php');
}

$produit = $infos_produit->fetch(PDO::PARAM_STR);



require_once 'inc/header.inc.php';
require_once 'inc/nav.inc.php';
// echo '<pre>'; print_r($produit); echo '</pre>';
?>

		<div class="starter-template">
			<h1><i class="fas fa-tshirt text-danger"></i> <?php echo $produit['titre']; ?> <i class="fas fa-tshirt text-danger"></i></h1>
			<p class="lead">lorem ipsum</p>
			<hr>
			<?php echo $msg; // affichage des messages utilisateur ?>
		</div>
		
		<div class="row">
			<div class="col-6"><?php echo '<img src="' . URL . $produit['photo'] . '" class="img-thumbnail w-100" alt="image produit">'; ?></div>
			<div class="col-6">
				<ul class="list-group">
					<li class="list-group-item active"><b>Informations produit</b></li>
					<li class="list-group-item"><b>Titre : </b><?php echo $produit['titre']; ?></li>
					<li class="list-group-item"><b>Catégorie : </b><?php echo $produit['categorie']; ?></li>
					<li class="list-group-item"><b>Prix : </b><?php echo $produit['prix']; ?> €</li>
					<li class="list-group-item"><b>Couleur : </b><?php echo $produit['couleur']; ?> <span class="float-right" style="display: inline-block; width: 30px; height: 30px; border-radius: 50%; border: 1px solid black; background-color: <?php echo displayColor($produit['couleur']); ?>;"></span></li>
					<li class="list-group-item"><b>Taille : </b><?php echo $produit['taille']; ?></li>
					<li class="list-group-item"><b>Sexe : </b><?php if($produit['sexe'] == 'f') { echo 'féminin'; } else { echo 'masculin'; } ?></li>
					<li class="list-group-item"><b>Description : </b><?php echo $produit['description']; ?></li>
					<li class="list-group-item"><b>Disponibilité : </b>
					<?php 
					if($produit['stock'] > 0) { 
						echo '<span class="text-success">En stock</span>'; 
						
						// formulaire d'ajout au panier
						echo '<hr><form method="post" action="panier.php">';						
						echo '<div class="form-row">';
						echo '<div class="form-group col-4"><label for="quantite">Quantité</label>';
						
						echo '<select class="form-control" name="quantite" id="quantite">';
						for($i = 1; $i <= $produit['stock'] && $i <= 5; $i++) {
							// on limite la quantité selon le stock ou maximum à 5
							echo '<option>' . $i . '</option>';
						}
						echo '</select>';
						echo '</div>';
						
						echo '<div class="form-group col-8"><label>Ajouter</label>';
						echo '<input type="hidden" name="id_article" value="' . $produit['id_article'] . '">';
						echo '<button type="submit" class="btn btn-danger w-100" name="ajout_panier" value="ajout_panier"><i class="fas fa-shopping-cart "></i></button>';
						echo '</div>';	
						
						echo '</div>';						
						echo '</form>';
						
						
						
						
					} else { 
						echo '<span class="text-danger">Rupture de stock pour ce produit</span>
								<br>
								<a href="' . URL . 'index.php?categorie=' . $produit['categorie'] . '" class="btn btn-primary w-100">Retour vers la catégorie de ce produit<a>'; 
					} ?></li>
				</ul>
				
			</div>
			
			
			
			
			
			
			
			
			
			
			
			
			<div class="col-12"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></div>
		</div>

<?php
require_once 'inc/footer.inc.php';










