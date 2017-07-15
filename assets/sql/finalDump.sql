-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Sam 15 Juillet 2017 à 18:46
-- Version du serveur :  5.6.35
-- Version de PHP :  7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `bookerz`
--

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `author` varchar(255) NOT NULL,
  `published` date NOT NULL,
  `editor` varchar(255) NOT NULL,
  `collection` varchar(255) NOT NULL,
  `ISBN10` varchar(255) NOT NULL,
  `ISBN13` varchar(255) NOT NULL,
  `statut` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `book_category`
--

CREATE TABLE `book_category` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_book` int(11) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `book_note`
--

CREATE TABLE `book_note` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `chatroom_to_salon`
--

CREATE TABLE `chatroom_to_salon` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_salon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `has_book`
--

CREATE TABLE `has_book` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_book` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `messages_salon`
--

CREATE TABLE `messages_salon` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_salon` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `report`
--

CREATE TABLE `report` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_user_reported` int(11) NOT NULL,
  `id_salon` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `salon`
--

CREATE TABLE `salon` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `id_livre` int(11) NOT NULL,
  `nb_max_user` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `nb_max_report_needed` int(11) NOT NULL,
  `closed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `status_book`
--

CREATE TABLE `status_book` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users_salon`
--

CREATE TABLE `users_salon` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_salon` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `nb_signaled` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


-- --------------------------------------------------------

--
-- Structure de la table `suggest`
--

CREATE TABLE `suggest`(
    `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id_user` int(11) NOT NULL,
    `id_book` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Structure de la table `banned_user`
--

CREATE TABLE `banned_user`(
    `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `id_user` int(11) NOT NULL,
    `reason` varchar(255) NOT NULL,
    `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;


--
-- Index pour la table `book_category`
--
ALTER TABLE `book_category`
  ADD KEY `BOOK_CATEGORY_fk0` (`id_book`),
  ADD KEY `BOOK_CATEGORY_fk1` (`id_category`);

--
-- Index pour la table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `book_category`
--
ALTER TABLE `book_category`
  ADD CONSTRAINT `book_category_fk0` FOREIGN KEY (`id_book`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `book_category_fk1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);
