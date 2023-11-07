-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 nov. 2023 à 20:02
-- Version du serveur : 8.0.31
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `baselaprairie`
--

-- --------------------------------------------------------

--
-- Structure de la table `contenu`
--

DROP TABLE IF EXISTS `contenu`;
CREATE TABLE IF NOT EXISTS `contenu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `update_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ponderation` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_89C2003F67B3B43D` (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contenu`
--

INSERT INTO `contenu` (`id`, `users_id`, `title`, `content`, `created_at`, `update_at`, `image`, `ponderation`) VALUES
(1, 2, 'Nos valeurs', 'This is a wider card with supporting text below as a natural lead-in to additional content.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This content is a little bit longer.', '2023-10-16 20:22:49', NULL, '\\img\\site\\tipi_2.jpg', 1),
(2, 3, 'Nos Engagements', 'This is a wider card with supporting text below as a natural\r\n                                    lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.', '2023-10-16 20:22:49', NULL, '\\img\\site\\tipi_2.jpg', 2),
(3, 2, 'Fonctionnement', 'This is a wider card with supporting text below as a natural lead-in to additional content.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This content is a little bit longer.', '2023-10-16 20:22:49', NULL, '\\img\\site\\tipi_2.jpg', 5),
(4, 3, 'Nos partenaires', 'This is a wider card with supporting text below as a natural\r\n                                    lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.', '2023-10-16 20:22:49', NULL, '\\img\\site\\partenairemain.png', 6),
(5, 2, 'Notre projet', 'This is a wider card with supporting text below as a natural lead-in to additional content.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. This content is a little bit longer.', '2023-10-16 20:22:49', NULL, '\\img\\site\\tipi_2.jpg', 3),
(6, 3, 'Charte', 'This is a wider card with supporting text below as a natural\r\n                                    lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.', '2023-10-16 20:22:49', NULL, '\\img\\site\\tipi_2.jpg', 4),
(7, 3, 'Infos pratiques', 'This is a wider card with supporting text below as a natural\r\n                                    lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.This is a wider card with supporting\r\n                                    text below as a natural lead-in to additional\r\n                                    content. This content is a little bit longer.', '2023-10-16 20:22:49', NULL, '\\img\\site\\infopratique.jpg', 7);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenu`
--
ALTER TABLE `contenu`
  ADD CONSTRAINT `FK_89C2003F67B3B43D` FOREIGN KEY (`users_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
