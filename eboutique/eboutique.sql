-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 30 oct. 2019 à 16:50
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `eboutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id_article` int(5) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `couleur` varchar(255) NOT NULL,
  `taille` varchar(255) NOT NULL,
  `sexe` enum('m','f') NOT NULL,
  `photo` varchar(255) NOT NULL,
  `prix` double(7,2) NOT NULL,
  `stock` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `sexe`, `photo`, `prix`, `stock`) VALUES
(6, '103', 'Tshirt', 'Tshirt bleu', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Bleu', 'XS', 'm', 'assets/photo/103-tshirt_bleu.jpg', 9.00, 50),
(7, '104', 'Tshirt', 'Tshirt jaune', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Jaune', 'L', 'm', 'assets/photo/104-tshirt_jaune.jpg', 11.00, 50),
(8, '105', 'Tshirt', 'Tshirt gris', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Gris', 'S', 'm', 'assets/photo/105-tshirt_girs.jpg', 11.00, 50),
(9, '106', 'Tshirt', 'Tshirt noir', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Noir', 'S', 'm', 'assets/photo/106-tshirt_noir.jpg', 9.00, 50),
(10, '107', 'Tshirt', 'Tshirt rouge', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Rouge', 'S', 'm', 'assets/photo/107-tshirt_rouge.jpg', 9.00, 50),
(11, '201', 'Pantalon', 'Pantalon noir', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Noir', 'M', 'm', 'assets/photo/201-pantalon_noir.jpg', 35.00, 50),
(12, '202', 'Pantalon', 'Pantalon gris', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Gris', 'M', 'm', 'assets/photo/202-pantalon_gris.jpg', 35.00, 50),
(13, '203', 'Pantalon', 'Pantalon blanc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Blanc', 'M', 'm', 'assets/photo/203-pantalon_blanc.jpg', 35.00, 50),
(14, '204', 'Pantalon', 'Pantalon bleu', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Bleu', 'L', 'm', 'assets/photo/204-pantalon_bleu.jpg', 35.00, 50),
(15, '205', 'Pantalon', 'Pantalon beige', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Beige', 'L', 'm', 'assets/photo/205-pantalon_beige.jpg', 42.00, 50),
(16, '301', 'Chemise', 'Chemise blanche', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Blanc', 'M', 'm', 'assets/photo/301-chemise_blanche.jpg', 21.00, 50),
(17, '302', 'Chemise', 'Chemise bleue', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Bleu', 'S', 'm', 'assets/photo/302-chemise_bleue.jpg', 21.00, 50),
(18, '303', 'Chemise', 'Chemise grise', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Gris', 'L', 'm', 'assets/photo/303-chemise_grise.jpg', 21.00, 50),
(19, '304', 'Chemise', 'Chemise noire', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Noir', 'L', 'm', 'assets/photo/304-chemise_noire.jpg', 28.00, 50),
(20, '305', 'Chemise', 'Chemise rose', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Rose', 'L', 'm', 'assets/photo/305-chemise_rose.jpg', 28.00, 44),
(21, '401', 'Ceinture', 'Ceinture marron', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Marron', 'M', 'm', 'assets/photo/401-ceinture_marron.jpg', 14.00, 48),
(22, '402', 'Ceinture', 'Ceinture noire', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Noir', 'M', 'm', 'assets/photo/402-ceinture_noire.jpg', 14.00, 50),
(23, '501', 'Chaussettes', 'Chaussettes blanches', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Blanc', 'M', 'm', 'assets/photo/501-chaussettes_blanches.jpg', 7.00, 50),
(24, '502', 'Chaussettes', 'Chaussettes bleues', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Bleu', 'M', 'm', 'assets/photo/502-chaussettes_bleues.jpg', 7.00, 48),
(25, '503', 'Chaussettes', 'Chaussettes grises', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Gris', 'M', 'm', 'assets/photo/503-chaussettes_grises.jpg', 7.00, 50),
(26, '504', 'Chaussettes', 'Chaussettes jaunes', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Jaune', 'M', 'm', 'assets/photo/504-chaussettes_jaunes.jpg', 7.00, 50),
(27, '505', 'Chaussettes', 'Chaussettes noires', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Noir', 'M', 'm', 'assets/photo/505-chaussettes_noires.jpg', 7.00, 50),
(28, '601', 'Polo', 'Polo blanc', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Blanc', 'S', 'm', 'assets/photo/601-polo_blanc.jpg', 20.00, 50),
(29, '602', 'Polo', 'Polo bleu', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Bleu', 'L', 'm', 'assets/photo/602-polo_bleu.jpg', 20.00, 50),
(30, '603', 'Polo', 'Polo gris', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Gris', 'L', 'm', 'assets/photo/603-polo_gris.jpg', 20.00, 50),
(31, '604', 'Polo', 'Polo jaune', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Jaune', 'M', 'm', 'assets/photo/604-polo_jaune.jpg', 20.00, 50),
(32, '605', 'Polo', 'Polo rose', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Rose', 'M', 'f', 'assets/photo/605-polo_rose.jpg', 20.00, 50),
(33, '701', 'Veste', 'Veste bleue', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Bleu', 'M', 'm', 'assets/photo/701-veste_bleue.jpg', 49.00, 50),
(34, '702', 'Veste', 'Veste grise', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Gris', 'L', 'm', 'assets/photo/702-veste_grise.jpg', 49.00, 50),
(35, '703', 'Veste', 'Veste noire', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Noir', 'L', 'm', 'assets/photo/703-veste_noire.jpg', 49.00, 50),
(36, '801', 'Echarpe', 'Echarpe rouge', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Rouge', 'M', 'm', 'assets/photo/801-echarpe_rouge.jpg', 14.00, 0),
(37, '802', 'Echarpe', 'Echarpe bleue', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse pharetra vel velit in porttitor. In nisl elit, suscipit et ultricies ut, fermentum vitae augue. Etiam interdum ante quis purus facilisis, venenatis tincidunt lorem pretium. Aenean porta dui vel aliquam scelerisque. Donec non libero vestibulum, consequat tellus non, condimentum erat.', 'Bleu', 'M', 'm', 'assets/photo/802-echarpe_bleue.jpg', 14.00, 0);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(5) NOT NULL,
  `id_membre` int(5) DEFAULT NULL,
  `montant` double(7,2) NOT NULL,
  `date_commande` datetime NOT NULL,
  `etat` enum('en cours de traitement','envoyé','livré') NOT NULL DEFAULT 'en cours de traitement'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `montant`, `date_commande`, `etat`) VALUES
(2, 1, 126.00, '2019-10-30 15:33:25', 'en cours de traitement'),
(3, 1, 126.00, '2019-10-30 16:37:04', 'en cours de traitement');

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE `details_commande` (
  `id_details_commande` int(5) NOT NULL,
  `id_commande` int(5) NOT NULL,
  `id_article` int(5) DEFAULT NULL,
  `quantite` int(3) NOT NULL,
  `prix` double(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `details_commande`
--

INSERT INTO `details_commande` (`id_details_commande`, `id_commande`, `id_article`, `quantite`, `prix`) VALUES
(1, 2, 21, 1, 14.00),
(2, 2, 24, 1, 7.00),
(3, 2, 20, 3, 28.00),
(4, 3, 21, 1, 14.00),
(5, 3, 24, 1, 7.00),
(6, 3, 20, 3, 28.00);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(5) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sexe` enum('m','f') NOT NULL,
  `ville` varchar(255) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `adresse` text NOT NULL,
  `statut` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `sexe`, `ville`, `cp`, `adresse`, `statut`) VALUES
(1, 'admin', '$2y$10$X5bbUsLc54x7wSmLVWNQOutpZHPsvngSZI2flIRIlxQKc0pNTjkTO', 'Nom Admin', 'Prénom Admin', 'admin@mail.fr', 'm', 'Paris', '75000', 'Rue de l\'arbre.', 2),
(2, 'test', '$2y$10$.8tn7PHZQYyuQbcZNeXMwuOjqbqYFHcnkiqdJqxKi3m0i2jnlu4Hu', 'Lorem', 'Ipsum', 'lorem@mail.fr', 'f', 'Paris', '75000', 'Rue de l\'arbre.', 1),
(3, 'Mathieu', '$2y$10$K1Xxj5VubVERWWqHIisZVep4J49tgzRblfCEVZumTvF7WrqQ9pDjq', 'Quittard', 'Mathieu', 'mathieuquittard@evogue.fr', 'm', 'Paris', '75000', 'Rue de l\'arbre.', 1),
(4, 'Mathieutherhe', '$2y$10$MnpzOVh4EnZsZqyeKdtnGeNuX3nlk7Yx2YSscWQzMUKxbwnGtuhA6', 'Quittard', 'Mathieu', 'mathieuquittard@evogue.fr', 'm', 'Paris', '75000', 'Rue de l\'arbre.', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_membre` (`id_membre`);

--
-- Index pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id_details_commande`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `details_commande`
--
ALTER TABLE `details_commande`
  MODIFY `id_details_commande` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `details_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `details_commande_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
