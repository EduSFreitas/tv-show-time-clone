-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 08, 2018 at 04:43 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabouret_corp`
--

-- --------------------------------------------------------

--
-- Table structure for table `metadata`
--

DROP TABLE IF EXISTS `metadata`;
CREATE TABLE IF NOT EXISTS `metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `metadata`
--

INSERT INTO `metadata` (`id`, `name`, `value`) VALUES
(1, 'nbElements', 3),
(2, 'stuff', 2);

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) NOT NULL,
  `idProduct` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `panier`
--

INSERT INTO `panier` (`id`, `idUser`, `idProduct`, `quantity`) VALUES
(39, 1, 12, 1),
(38, 1, 35, 1),
(40, 1, 33, 1);

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `value`) VALUES
(1, 'Administrateur'),
(2, 'Utilisateur');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`) VALUES
(35, 'Tabouret en mousse', 'Très joli tabouret en mousse', 10),
(12, 'Tabouret en titane', 'Très joli tabouret en titane', 220),
(33, 'Tabouret en or', 'Très joli tabouret en or', 500),
(34, 'Tabouret en argent', 'Très joli tabouret en argent', 30),
(17, 'Tabouret en Lithium', 'Très joli tabouret en Lithium', 30),
(18, 'Tabouret en tungsten', 'Très joli tabouret en tungsten', 740),
(19, 'Tabouret en platine', 'Très joli tabouret en platine', 780),
(20, 'Tabouret en zinc', 'Très joli tabouret en zinc', 300),
(21, 'Tabouret en aluminium', 'Très joli tabouret en aluminium', 130),
(22, 'Tabouret en carbone', 'Très joli tabouret en carbone', 60),
(23, 'Tabouret en cobalt', 'Très joli tabouret en cobalt', 270),
(24, 'Tabouret chromé', 'Très joli tabouret chromé', 240),
(25, 'Tabouret en zirconium', 'Très joli tabouret en zirconium', 400),
(26, 'Tabouret en radium', 'Très joli tabouret en radium', 880),
(27, 'Tabouret en souffre', 'Très joli tabouret en souffre', 160),
(28, 'Tabouret en silicone', 'Très joli tabouret en silicone', 140),
(36, 'Tabouret en bois', 'Très joli tabouret en bois', 60),
(37, 'Tabouret exotique', 'Très joli tabouret exotique', 600);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `mail` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `mail`, `password`, `salt`) VALUES
(1, 'admin', 'admin@admin.fr', '9e95dca6bfafbffb3b9ae0b3a27df91a3819bd53e6bea7d5e883afb54e8e43fd', 'E1F53135E559C253'),
(2, 'user', 'user@user.fr', '3863f65c6609ece2964e1e4c52a4338771b9438ced88bffbb705de0bbce2dca5', '84B03D034B409D4E');

-- --------------------------------------------------------

--
-- Table structure for table `userprivilege`
--

DROP TABLE IF EXISTS `userprivilege`;
CREATE TABLE IF NOT EXISTS `userprivilege` (
  `idUser` int(11) NOT NULL,
  `idPrivilege` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userprivilege`
--

INSERT INTO `userprivilege` (`idUser`, `idPrivilege`) VALUES
(1, 1),
(2, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
