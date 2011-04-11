-- phpMyAdmin SQL Dump
-- version 3.3.7deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 05 Novembre 2010 à 00:22
-- Version du serveur: 5.1.49
-- Version de PHP: 5.3.3-1ubuntu9.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `kinaf`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE IF NOT EXISTS `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `admin`
--

INSERT INTO `administrator` (`id`, `nom`, `prenom`, `login`, `password`) VALUES
(1, 'Verbinnen', 'Christophe', 'djpate', 'ade972a26def473f900b4a5e06093f0d1d2ca028a0e2f151eb8c79aca19b0426c9aecf0292cd8b3521ecd9df45913eb90a888c4ac538a01211f01f63e22c61d7');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `dateFormat` varchar(20) NOT NULL,
  `dateTimeFormat` varchar(20) NOT NULL,
  `decimalSeperator` varchar(1) NOT NULL,
  `thousandSeperator` varchar(1) NOT NULL,
  `symbolPrepend` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `language` (`id`, `code`, `dateFormat`, `dateTimeFormat`, `decimalSeperator`, `thousandSeperator`, `symbolPrepend`) VALUES
(1, 'FR', 'd/m/Y', 'd/m/Y G:i:s', ',' ,' ', 0),
(2, 'EN', 'm/d/Y', 'm/d/Y G:i:s', '.', ',', 0);

