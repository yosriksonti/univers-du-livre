-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2021 at 05:33 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `symfony`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nomCat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateAjout` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `nomCat`, `dateAjout`) VALUES
(11, 'Ancien Bouquin', '2021-02-25 20:09:48'),
(13, 'Conte pour Enfants', '2021-02-25 20:13:44'),
(16, 'Geographie', '2021-03-05 00:05:13'),
(17, 'Roman', '2021-03-05 00:17:53'),
(18, 'Drame', '2021-03-07 16:32:44'),
(19, 'Comédie', '2021-03-09 16:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `nomProprietaire` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emailProprietaire` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `etat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idClient` int(11) NOT NULL,
  `dateAjout` datetime NOT NULL,
  `addProprietaire` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telProprietaire` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id`, `nomProprietaire`, `emailProprietaire`, `etat`, `idClient`, `dateAjout`, `addProprietaire`, `telProprietaire`) VALUES
(72, 'ali', 'ali@gmail.com', 'Confirmée', 23, '2021-03-05 00:16:49', '63 rue de l\'ecole', '22 222 222'),
(74, 'aziz', 'aziz@esprit.tn', 'Confirmée', 16, '2021-03-08 20:25:48', '45 rue de l\'enfance', '22 222 222'),
(75, 'aziz', 'aziz@esprit.tn', 'Confirmée', 16, '2021-03-08 20:25:48', '45 rue de l\'enfance', '22 222 222');

-- --------------------------------------------------------

--
-- Table structure for table `fos_user`
--

CREATE TABLE `fos_user` (
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
  `addresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `addresse`, `telephone`) VALUES
(16, 'aziz', 'aziz', 'aziz@esprit.tn', 'aziz@esprit.tn', 1, NULL, '$2y$13$75a8Vt6IBlz5.TvcHwLCw.HYL54doPbFqTtLYNYh.yUuU5ROHzoS2', '2021-03-04 23:25:54', NULL, NULL, 'a:0:{}', '45 rue de l\'enfance', '22 222 222'),
(17, 'ramzi', 'ramzi', 'ramzi@esprit.tn', 'ramzi@esprit.tn', 1, NULL, '$2y$13$XpHg1Js/k7yp4X48YBf.4e9f8tz4.GCAfO6rHU8gxoL3pZI/3Qh7K', '2021-03-13 20:34:04', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '63 rue de l\'ecole', '33 333 333'),
(23, 'ali', 'ali', 'ali@gmail.com', 'ali@gmail.com', 1, NULL, '$2y$13$vVtuCuoaGrzlNiAuZ2MTv.uFwhMX2Zk.PMWJbkwFyzLGuXJRdNJpy', '2021-03-05 00:19:34', NULL, NULL, 'a:0:{}', '63 rue de l\'ecole', '22 444 555');

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `nomP` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `quantite` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateAjout` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id`, `nomP`, `prix`, `quantite`, `description`, `categorie_id`, `image`, `dateAjout`) VALUES
(30, 'les miserables', 22, 1, 'un roman français populaire ecrit par Victor Hugo', 11, 'les miserables-6037f718ea986.jpeg', '2021-02-25 20:14:32'),
(31, 'La ferme des animeaux', 15, 1, 'une conte pour enfants qui décrit la vie à la campagne .', 13, 'single_product_3-5fd3a7e7cbad3-6037f7998bbee.png', '2021-02-25 20:16:41'),
(32, 'Ferme les yeux et fais un voeu', 35, 1, 'une conte pour adulte qui .......', 13, 'single_product_2-5fca94cd94a7f-6037f7d6b3e8d.png', '2021-02-25 20:17:42'),
(33, 'La ferme des animeaux 2.0', 45, 1, 'Deuxieme partie du roman La ferme des animeaux ......', 13, 'single_product_1-5fc7f42d08a48-6037fdc096143.png', '2021-02-25 20:42:56'),
(37, 'Les Miserables (Alternative)', 25, 4, 'Un Roman Français Populaire Ecrit par Victor Hugo', 17, 'lmvh-6046592c4315b.jpeg', '2021-03-08 18:04:40');

-- --------------------------------------------------------

--
-- Table structure for table `prod_com`
--

CREATE TABLE `prod_com` (
  `id` int(11) NOT NULL,
  `nomProduit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantiteProduit` int(11) NOT NULL,
  `idCommande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `prod_com`
--

INSERT INTO `prod_com` (`id`, `nomProduit`, `quantiteProduit`, `idCommande`) VALUES
(120, 'les miserables', 1, 72),
(121, 'La ferme des animeaux', 1, 72),
(122, 'Ferme les yeux et fais un voeu', 5, 73);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC27BCF5E72D` (`categorie_id`);

--
-- Indexes for table `prod_com`
--
ALTER TABLE `prod_com`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `prod_com`
--
ALTER TABLE `prod_com`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC27BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
