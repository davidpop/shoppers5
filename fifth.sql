-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 31 jan. 2019 à 16:59
-- Version du serveur :  5.7.25-0ubuntu0.16.04.2
-- Version de PHP :  7.2.13-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `fifth`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `trad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `nom`, `description`, `trad`, `updated_at`) VALUES
(1, 'chaises', 'des chaises pour s\'asseoir', 'chairs', '2019-01-28 10:41:49'),
(2, 'chaussure', 'les chaussures', 'shoes', NULL),
(3, 'chaussettes', 'les chaussettes', 'socks', NULL),
(4, 'chaussettes', NULL, 'socks', NULL),
(5, 'shorts', 'les shorts', 'shorts', NULL),
(6, 't-shirt', 'les t-shirts', 't-shirt', NULL),
(7, 'sweats', NULL, 'sweats', NULL),
(8, 'lunettes', NULL, 'glasses', NULL),
(9, 'pulls', 'pour se protéger de l\'hiver', 'sweaters', NULL),
(10, 'caleçons', 'les caleçons', 'underpants', NULL),
(11, 'pantalons', 'les pantalons', 'pants', '2019-01-28 10:57:05'),
(12, 'visière', 'les visières test', 'visor', NULL),
(13, 'casquettes', NULL, 'caps', NULL),
(14, 'chemises', NULL, 'shirt', NULL),
(17, 'perruques', 'pour changer de coiffure sans coiffeur', '', NULL),
(18, 'ecouteurs', 'pour écouter du son discrètement', 'earphone', NULL),
(19, 'casque', 'afin que tous le voie', 'headphones', NULL),
(20, 'boxers', 'les boxers', 'boxers', NULL),
(21, 'stylos', 'un stylo pour écrire', 'pen', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `charge_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `montant` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `created_at`, `user_id`, `payment_status`, `charge_id`, `montant`) VALUES
(1, '2019-01-23 16:34:17', 3, 0, NULL, 49.5),
(2, '2019-01-23 16:39:06', 3, 0, NULL, 39.99),
(3, '2019-01-23 16:44:41', 3, 0, NULL, 89.49),
(4, '2019-01-23 16:45:44', 3, 0, '0', 89.49),
(5, '2019-01-23 16:57:14', 3, 0, 'ch_1Dvo6hBHsqkyYjVrSllRZkec', 332.99),
(6, '2019-01-23 17:07:43', 3, 0, 'ch_1DvoH0BHsqkyYjVr1xzvqT55', 219.5),
(7, '2019-01-23 17:11:18', 3, 0, 'ch_1DvoOfBHsqkyYjVr5jQxM4ht', 39.99),
(8, '2019-01-23 17:16:53', 3, 0, 'ch_1DvoPYBHsqkyYjVrnMKsMv7G', 39.99),
(9, '2019-01-23 17:17:51', 3, 0, 'ch_1DvoQbBHsqkyYjVr8LJPurNB', 89.49),
(10, '2019-01-23 17:24:13', 3, 0, NULL, 169.47),
(11, '2019-01-24 09:38:39', 3, 1, 'ch_1Dw3jjBHsqkyYjVrd2Yw18E8', 40),
(12, '2019-01-24 11:06:41', 3, 0, NULL, 686.49),
(13, '2019-01-24 11:06:56', 3, 1, 'ch_1Dw571BHsqkyYjVrKlXejlxP', 686.49),
(14, '2019-01-29 11:07:44', 3, 0, NULL, 39.99);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `alt` longtext COLLATE utf8_unicode_ci NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `photo_principale`
--

CREATE TABLE `photo_principale` (
  `id` int(11) NOT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` longtext COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `photo_principale`
--

INSERT INTO `photo_principale` (`id`, `image_name`, `alt`, `updated_at`) VALUES
(1, 'lacet-elastique-chaussure-ville-rond-marron.jpg', 'des chaussures de ville', '2019-01-18 12:58:59'),
(2, 'basketsdeville.jpg', 'baskets de ville', '2019-01-18 14:07:11'),
(3, 'nikeairmax270.jpeg', 'Nike Air Max 270', '2019-01-18 14:11:58'),
(4, 'reebokpump.jpg', 'les Reebok \"PumP\", à l\'ancienne pour tous ceux qui se rappellent...', '2019-01-18 14:28:19'),
(5, 'chaussettesblanches.jpg', 'chaussettes de sport', '2019-01-18 14:41:47'),
(6, 'chaussettesbleues.jpg', 'chaussettes bleues', '2019-01-18 14:42:51'),
(7, 'chaussettesrougesetjaunes.jpeg', 'chaussettes rouges et jaunes à petits pois', '2019-01-18 14:46:02'),
(8, 'shortrouge.jpg', 'short rouge', '2019-01-18 14:48:10'),
(9, 'short1.jpg', 'short gris', '2019-01-18 14:48:50'),
(10, 'tshirtgeek.jpg', 't-shirt geek', '2019-01-18 14:52:19'),
(11, 'tshirtmartine.jpg', 't-shirt martine', '2019-01-18 14:52:49'),
(12, 'tshirtlinux.jpg', 't-shirt linux', '2019-01-18 14:53:35'),
(13, 'sweatchampion.jpeg', 'sweat champion', '2019-01-18 15:10:57'),
(14, 'sweatFB.jpg', 'sweat facebook', '2019-01-18 15:11:47'),
(15, 'sweatgoogle.jpeg', 'sweat google', '2019-01-18 15:12:34'),
(16, 'sweatMS.jpeg', 'sweat Microsoft', '2019-01-18 15:14:07'),
(17, 'lunettesprada.jpg', 'lunettes prada', '2019-01-18 15:17:44'),
(18, 'lunettesrayban.jpg', 'lunettes ray-ban', '2019-01-18 15:18:38'),
(19, 'lunettespersepolis.jpg', 'lunettes persepolis', '2019-01-18 15:19:28'),
(20, 'stylo-bille-bic-bleu.jpg', 'le classique stylo bic bleu', '2019-01-25 09:29:06');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `photo_principale_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `quantite` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `photo_principale_id`, `nom`, `description`, `prix`, `quantite`, `updated_at`) VALUES
(1, 1, 'chaussures de ville', 'des chaussures de ville', 39.99, 10, NULL),
(2, 2, 'baskets de ville', 'baskets de ville', 49.5, 50, NULL),
(3, 3, 'Nike Air Max 270', 'Nike Air Max 270', 150, 22, NULL),
(4, 4, 'Reebok Pump', 'les \"PumP\", à l\'ancienne pour tous ceux qui se rappellent...', 140, 40, NULL),
(5, 5, 'chaussettes de sport', 'chaussettes de sport', 10, 123, NULL),
(6, 6, 'chaussettes bleues', 'chaussettes bleues', 8, 60, NULL),
(7, 7, 'chaussettes rouges et jaunes à petits pois', 'chaussettes rouges et jaunes à petits pois', 5, 55, NULL),
(8, 8, 'short rouge', 'short rouge', 13, 14, NULL),
(9, 9, 'short gris', 'short gris', 14, 140, NULL),
(10, 10, 't-shirt geek', 't-shirt geek', 20, 44, NULL),
(11, 11, 't-shirt martine', 't-shirt martine', 23, 32, NULL),
(12, 12, 't-shirt linux', 't-shirt linux', 21, 101, NULL),
(13, 13, 'sweat champion', 'sweat champion', 17, 50, NULL),
(14, 14, 'sweat facebook', 'sweat facebook', 15, 50, NULL),
(15, 15, 'sweat google', 'sweat google', 20, 50, NULL),
(16, 16, 'sweat Microsoft', 'sweat Microsoft', 22, 50, NULL),
(17, 17, 'lunettes prada', 'lunettes prada', 500, 50, NULL),
(18, 18, 'lunettes ray-ban', 'lunettes ray-ban', 123, 50, NULL),
(19, 19, 'lunettes persepolis', 'lunettes persepolis', 150, 50, NULL),
(20, 20, 'stylo bic bleu', 'le classique stylo bic bleu', 0.25, 100, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `product_category`
--

CREATE TABLE `product_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 3),
(6, 3),
(7, 3),
(8, 5),
(9, 5),
(10, 6),
(11, 6),
(12, 6),
(13, 7),
(14, 7),
(15, 7),
(16, 7),
(17, 8),
(18, 8),
(19, 8),
(20, 21);

-- --------------------------------------------------------

--
-- Structure de la table `product_commande`
--

CREATE TABLE `product_commande` (
  `id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` double NOT NULL,
  `product_id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `product_commande`
--

INSERT INTO `product_commande` (`id`, `quantite`, `prix`, `product_id`, `commande_id`) VALUES
(1, 1, 49.5, 2, 1),
(2, 1, 39.99, 1, 4),
(3, 1, 49.5, 2, 4),
(4, 1, 39.99, 1, 5),
(5, 1, 150, 3, 5),
(6, 3, 30, 5, 5),
(7, 5, 100, 10, 5),
(8, 1, 13, 8, 5),
(9, 1, 49.5, 2, 6),
(10, 1, 20, 10, 6),
(11, 1, 123, 18, 6),
(12, 1, 14, 9, 6),
(13, 1, 13, 8, 6),
(14, 1, 39.99, 1, 7),
(15, 1, 39.99, 1, 8),
(16, 1, 23, 11, 11),
(17, 1, 17, 13, 11),
(18, 1, 39.99, 1, 13),
(19, 7, 346.5, 2, 13),
(20, 1, 140, 4, 13),
(21, 1, 150, 3, 13),
(22, 1, 10, 5, 13);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` longtext COLLATE utf8_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codePostal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `charge_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `nom`, `prenom`, `adresse`, `ville`, `codePostal`, `charge_id`) VALUES
(1, 'davidpop', 'davidpop', 'davidpopotte@hotmail.com', 'davidpopotte@hotmail.com', 1, NULL, '$2y$13$sYYMRSB1SID5kuL1Meklz.4z1Vmxyr1L.ahxZe3Vt2D7VPEQ2pHzu', '2019-01-18 10:12:36', NULL, NULL, 'a:0:{}', '', '', '', '', '', NULL),
(2, 'admin', 'admin', 'admin@example.com', 'admin@example.com', 1, NULL, '$2y$13$Er0n9Wsr0BvHwG4ui/Ud5OURja51IiREz9i8opTx.YJNRneVdLVn6', '2019-01-28 10:32:45', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', '', '', '', '', '', NULL),
(3, 'davidpop2', 'davidpop2', 'davidpopotte@gmail.com', 'davidpopotte@gmail.com', 1, NULL, '$2y$13$Cn9UUYAnqvjhTlUtBhNfgeGgTvgg5yO.FnwTq8TUg.okndPgls66u', '2019-01-29 16:13:14', NULL, NULL, 'a:0:{}', 'ken', 'Ron', 'allé de lorem ipsum', 'laVilleInconnue', '12345', 'ch_1DvkALBHsqkyYjVrFGmNXDtn');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6EEAA67DA76ED395` (`user_id`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C53D045F4584665A` (`product_id`);

--
-- Index pour la table `photo_principale`
--
ALTER TABLE `photo_principale`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D34A04AD51C718BE` (`photo_principale_id`);

--
-- Index pour la table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `IDX_CDFC73564584665A` (`product_id`),
  ADD KEY `IDX_CDFC735612469DE2` (`category_id`);

--
-- Index pour la table `product_commande`
--
ALTER TABLE `product_commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A55ACCEA4584665A` (`product_id`),
  ADD KEY `IDX_A55ACCEA82EA2E54` (`commande_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `photo_principale`
--
ALTER TABLE `photo_principale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `product_commande`
--
ALTER TABLE `product_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045F4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD51C718BE` FOREIGN KEY (`photo_principale_id`) REFERENCES `photo_principale` (`id`);

--
-- Contraintes pour la table `product_category`
--
ALTER TABLE `product_category`
  ADD CONSTRAINT `FK_CDFC735612469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CDFC73564584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `product_commande`
--
ALTER TABLE `product_commande`
  ADD CONSTRAINT `FK_A55ACCEA4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_A55ACCEA82EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
