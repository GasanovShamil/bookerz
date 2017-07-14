-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Ven 14 Juillet 2017 à 11:46
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
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `author` varchar(255) NOT NULL,
  `published` date NOT NULL,
  `editor` varchar(255) NOT NULL,
  `collection` varchar(255) NOT NULL,
  `ISBN10` varchar(255) NOT NULL,
  `ISBN13` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `BOOK_CATEGORY`
--

CREATE TABLE `BOOK_CATEGORY` (
  `id` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `id_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `book_note`
--

CREATE TABLE `book_note` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `note` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `CATEGORY`
--

CREATE TABLE `CATEGORY` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `chatroom_to_salon`
--

CREATE TABLE `chatroom_to_salon` (
  `id` int(11) NOT NULL,
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
-- Structure de la table `messages_salon`
--

CREATE TABLE `messages_salon` (
  `id` int(11) NOT NULL,
  `id_salon` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `salon`
--

CREATE TABLE `salon` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `id_livre` int(11) NOT NULL,
  `nb_max_user` int(11) NOT NULL,
  `statut` int(11) NOT NULL,
  `nb_max_report_needed` int(11) NOT NULL,
  `closed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users_salon`
--

CREATE TABLE `users_salon` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_salon` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `nb_signaled` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `BOOK_CATEGORY`
--
ALTER TABLE `BOOK_CATEGORY`
  ADD PRIMARY KEY (`id`),
  ADD KEY `BOOK_CATEGORY_fk0` (`id_book`),
  ADD KEY `BOOK_CATEGORY_fk1` (`id_category`);

--
-- Index pour la table `book_note`
--
ALTER TABLE `book_note`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `CATEGORY`
--
ALTER TABLE `CATEGORY`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chatroom_to_salon`
--
ALTER TABLE `chatroom_to_salon`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Index pour la table `messages_salon`
--
ALTER TABLE `messages_salon`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `salon`
--
ALTER TABLE `salon`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_salon`
--
ALTER TABLE `users_salon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `BOOK_CATEGORY`
--
ALTER TABLE `BOOK_CATEGORY`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `book_note`
--
ALTER TABLE `book_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `CATEGORY`
--
ALTER TABLE `CATEGORY`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `chatroom_to_salon`
--
ALTER TABLE `chatroom_to_salon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `messages_salon`
--
ALTER TABLE `messages_salon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT pour la table `salon`
--
ALTER TABLE `salon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `users_salon`
--
ALTER TABLE `users_salon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `BOOK_CATEGORY`
--
ALTER TABLE `BOOK_CATEGORY`
  ADD CONSTRAINT `BOOK_CATEGORY_fk0` FOREIGN KEY (`id_book`) REFERENCES `BOOK` (`id`),
  ADD CONSTRAINT `BOOK_CATEGORY_fk1` FOREIGN KEY (`id_category`) REFERENCES `CATEGORY` (`id`);
