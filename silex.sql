-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 31 Août 2015 à 13:04
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `silex`
--
CREATE DATABASE IF NOT EXISTS `silex` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `silex`;

-- --------------------------------------------------------

--
-- Structure de la table `object`
--

CREATE TABLE IF NOT EXISTS `object` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `text` text,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `object`
--

INSERT INTO `object` (`id`, `title`, `summary`, `text`, `img`) VALUES
(1, 'Hitman', 'Action, Aventure', 'Jeux d''action et jeux d''aventure dans le monde du réel.', 'untitled (4).png'),
(2, 'Max payne 3', 'Action', 'Jeux d''action et jeux d''aventure dans le monde du réel. ', 'untitled (7).png');

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `page`
--

INSERT INTO `page` (`id`, `title`, `text`, `url`) VALUES
(1, 'Site de vente de jeu vidéo le plus populaire au monde', 'Pc nouvauté dans le marché\r\nIncludes 180 glyphs in font format from the Glyphicon Halflings set. Halflings are normally not available for free, but their creator has made them available for Bootstrap free of cost. As a thank you, we only ask that you to include a link back to Glyphicons whenever possible.\r\nXBOX Game\r\nIncludes 180 glyphs in font format from the Glyphicon Halflings set. Halflings are normally not available for free, but their creator has made them available for Bootstrap free of cost. ', 'homepage'),
(2, 'Contact page', 'Des commentaires?\r\nfuture-team@webcup.fr', 'contactpage');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
