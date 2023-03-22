<?php
require_once 'inc/init.inc.php';
require_once 'inc/functions.inc.php';

if(!empty($_GET["categorie"])) {
	$liste_produit = $pdo->prepare("SELECT * FROM article WHERE categorie = :categorie ORDER BY titre");
	$liste_produit->bindParam(":categorie", $_GET['categorie'], PDO::PARAM_STR);
	$liste_produit->execute();
} else {
	$liste_produit = $pdo->query("SELECT * FROM article ORDER BY titre");
}



$liste_categorie = $pdo->query("SELECT DISTINCT categorie FROM article ORDER BY categorie");




require_once 'inc/header.inc.php';
require_once 'inc/nav.inc.php';
?>

		<div class="starter-template">
			<h1><i class="fas fa-shopping-cart text-primary"></i> Ma boutique <i class="fas fa-shopping-cart text-primary"></i></h1>
			<p class="lead">lorem ipsum</p>
			<hr>
			<?php echo $msg; // affichage des messages utilisateur ?>
		</div>
		
		<div class="row">
			<div class="col-3">
				<ul class="list-group">
					<li class="list-group-item active">Catégories</li>
			<?php
				// Afficher la liste des categories (ul li (bootstrap : list-group)) dans des liens a href avec ?categorie=nom_de_la_categorie_en_cours
				while($categorie = $liste_categorie->fetch(PDO::FETCH_ASSOC)) {
					// print_r($categorie);
					echo '<li class="list-group-item"><a href="?categorie=' . $categorie['categorie'] . '">' . $categorie['categorie'] . '</a></li>';
				}
			?>
				</ul>
			</div>
			<div class="col-9">
				<div class="row">
				
	<?php 
		while($produit = $liste_produit->fetch(PDO::FETCH_ASSOC)) {
			echo '	<div class="col-4 mb-3">
						<div class="card">
							<img src="' . URL . '/assets/img/logo.jpg" class="card-img-top" alt="...">
							<div class="card-body text-center">								
								<h5 class="card-title">' . ucfirst($produit['titre']) . '</h5>
								<img src="' . URL . $produit['photo'] . '" class="img-thumbnail" alt="...">
								<p class="card-text font-weight-bold">' . $produit['prix'] . ' €</p>
								
								<a href="' . URL . 'fiche_produit.php?id_article=' . $produit['id_article'] . '" class="btn btn-primary">Voir détails produit</a>
								
							</div>
						</div>
					</div>';
		}
	?>




				</div>
			</div>
		</div>

<?php
require_once 'inc/footer.inc.php';










