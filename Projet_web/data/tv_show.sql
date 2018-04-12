-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 12 avr. 2018 à 02:23
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tv_show`
--

-- --------------------------------------------------------

--
-- Structure de la table `badge`
--

DROP TABLE IF EXISTS `badge`;
CREATE TABLE IF NOT EXISTS `badge` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `picture` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `episode`
--

DROP TABLE IF EXISTS `episode`;
CREATE TABLE IF NOT EXISTS `episode` (
  `idUser` int(11) NOT NULL,
  `idSerie` int(11) NOT NULL,
  `idEpisode` int(11) NOT NULL,
  `note` float NOT NULL,
  KEY `idUser` (`idUser`),
  KEY `idSerie` (`idSerie`),
  KEY `idEpisode` (`idEpisode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `privilege`
--

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `privilege`
--

INSERT INTO `privilege` (`id`, `value`) VALUES
(1, 'Administrateur'),
(2, 'Utilisateur');

-- --------------------------------------------------------

--
-- Structure de la table `serie`
--

DROP TABLE IF EXISTS `serie`;
CREATE TABLE IF NOT EXISTS `serie` (
  `idUser` int(11) NOT NULL,
  `idSerie` int(11) NOT NULL,
  `episodeRestant` int(11) NOT NULL,
  `episodeVue` int(11) NOT NULL,
  `note` float NOT NULL,
  `favoris` tinyint(1) NOT NULL DEFAULT '0',
  KEY `idUser` (`idUser`),
  KEY `idSerie` (`idSerie`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `stats`
--

DROP TABLE IF EXISTS `stats`;
CREATE TABLE IF NOT EXISTS `stats` (
  `idUser` int(11) NOT NULL,
  `idBadge` int(11) NOT NULL,
  `obtenu` tinyint(1) NOT NULL DEFAULT '0',
  KEY `idUser` (`idUser`),
  KEY `idBadge` (`idBadge`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `mail` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `picture` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `mail`, `password`, `salt`, `picture`) VALUES
(1, 'admin', 'admin@admin.fr', '9e95dca6bfafbffb3b9ae0b3a27df91a3819bd53e6bea7d5e883afb54e8e43fd', 'E1F53135E559C253', ''),
(2, 'user', 'user@user.fr', '3863f65c6609ece2964e1e4c52a4338771b9438ced88bffbb705de0bbce2dca5', '84B03D034B409D4E', '');

-- --------------------------------------------------------

--
-- Structure de la table `userprivilege`
--

DROP TABLE IF EXISTS `userprivilege`;
CREATE TABLE IF NOT EXISTS `userprivilege` (
  `idUser` int(11) NOT NULL,
  `idPrivilege` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `userprivilege`
--

INSERT INTO `userprivilege` (`idUser`, `idPrivilege`) VALUES
(1, 1),
(2, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
