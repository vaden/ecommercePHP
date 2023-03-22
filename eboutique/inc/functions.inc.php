<?php

function user_is_connected() {
	if(isset($_SESSION['membre'])) {
		// si l'indice membre existe dans SESSION alors l'utilisateur est passé par la connexion et est donc connecté.
		return true;
	} else {
		return false;
	}
}

function user_is_admin() {
	if(user_is_connected() && $_SESSION['membre']['statut'] == 2) {
		return true;
	}
	return false;
}

function displayColor($color) {
	$color = strtolower($color);
	switch($color) {
		case 'blanc':
			return 'white';
		break;
		case 'noir':
			return 'black';
		break;
		case 'rouge':
			return 'red';
		break;
		case 'rose':
			return 'pink';
		break;
		case 'beige':
			return 'Wheat';
		break;
		case 'jaune':
			return 'yellow';
		break;
		case 'bleu':
			return 'blue';
		break;
		case 'vert':
			return 'green';
		break;
		case 'gris':
			return 'gray';
		break;
		case 'marron':
			return 'SaddleBrown';
		break;
	}
}

function creation_panier() {
	if(!isset($_SESSION['panier'])) {
		$_SESSION['panier'] = array();
		$_SESSION['panier']['titre'] = array();
		$_SESSION['panier']['id_article'] = array();
		$_SESSION['panier']['prix'] = array();
		$_SESSION['panier']['quantite'] = array();
		$_SESSION['panier']['photo'] = array();
	}
	return true;
	// soit le panier existe déjà, on ne fait rien sinon on le crée
}

function ajouter_article_dans_panier($titre, $id_article, $prix, $quantite, $photo) {
	// lors d'un ajout au panier, nous devons vérifier si l'article est déjà présent dans le panier. Si c'est le cas on ne change que sa quantité sinon on rajoute une nouvelle ligne.
	$position_article = array_search($id_article, $_SESSION['panier']['id_article']);
	// array_search() renvoie l'indice du tableau array fourni en deuxième argument où se trouve la valeur fournie en premier argument
	// nous devons faire une comparaison stricte car il est possible de recevoir l'indice 0 (à différencier de false)
	
	if($position_article !== false) {
		// si l'article est présent on change la quantité
		$_SESSION['panier']['quantite'][$position_article] += $quantite;
	} else {
		// sinon on enregistre un nouvel article dans le panier
		$_SESSION['panier']['titre'][] = $titre;
		$_SESSION['panier']['id_article'][] = $id_article;
		$_SESSION['panier']['prix'][] = $prix;
		$_SESSION['panier']['quantite'][] = $quantite;
		$_SESSION['panier']['photo'][] = $photo;
	}
}

// Retirer un article du panier
function retirer_article_panier($id_article) {
	
	// on récupère l'indice où se trouve l'article
	$position_article = array_search($id_article, $_SESSION['panier']['id_article']);
	
	if($position_article !== false) {
		array_splice($_SESSION['panier']['titre'], $position_article, 1);
		array_splice($_SESSION['panier']['id_article'], $position_article, 1);
		array_splice($_SESSION['panier']['prix'], $position_article, 1);
		array_splice($_SESSION['panier']['quantite'], $position_article, 1);
		array_splice($_SESSION['panier']['photo'], $position_article, 1);
		// array_splice() permet de retirer un ou des éléments d'un tableau array mais également de réordonner les indices afin qu'il n'y ai pas de trou dans notre tableau
	}
}

// montant total du panier
function montant_total () {
	$total = 0;
	for($i = 0; $i < count($_SESSION['panier']['photo']); $i++) {
		$total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
	}
	// ajout de 20% de tva
	$total *= 1.2;
	
	return round($total, 2);
}














