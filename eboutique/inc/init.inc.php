<?php

// Ce fichier contient les outils necessaires au bon fonctionnement de notre site.

// Connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=eboutique', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8', ));


// Variable permettant d'afficher des messages utilisateur. Cette variable sera appelée sur toutes nos pages, par défaut vide. En revanche si on place un message dedans il sera affiché
$msg = "";

// on ouvre une session
session_start();

//déclaration de constante

// url racine du projet
define("URL", 'http://localhost/php/eboutique/'); // représente l'url absolue d'accès à la racine du projet.

// racine serveur
define('RACINE_SERVEUR', $_SERVER['DOCUMENT_ROOT']); // racine serveur nécessaire pour copier l'image sur gestion_produit.php

// racine site
define('RACINE_SITE', '/php/eboutique/'); // chemin depuis la racine serveur pour accéder à la racine projet.





















