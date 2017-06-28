-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Mer 28 Juin 2017 à 10:26
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

--
-- Contenu de la table `book`
--

INSERT INTO `book` (`id`, `title`, `description`, `date`, `author`, `published`, `editor`, `collection`, `ISBN10`, `ISBN13`) VALUES
(1, 'Miss Peregrine et les enfants particuliers - Tome 1', 'Jacob Portman, seize ans, écoute depuis son enfance les récits fabuleux de son grand-père. Ce dernier, un juif polonais, a passé une partie de sa vie sur une minuscule île du pays de Galles, où ses parents l\'avaient envoyé pour le protéger de la menace nazie. Le jeune Abe Portman y a été recueilli par Miss Peregrine Faucon, la directrice d\'un oprphelinat pour enfants \"particuliers\". Abe y côtoyait une ribambelle d\'enfants doués de capacités surnaturelles, censées les protéger des \"Monstres\".', '2017-05-30', 'Ransom Riggs', '2016-10-05', 'Livre de poche jeunesse', 'Livre de poche jeunesse', '2019110156', '978-2019110154');

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
-- Structure de la table `CATEGORY`
--

CREATE TABLE `CATEGORY` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL
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

--
-- Contenu de la table `messages_salon`
--

INSERT INTO `messages_salon` (`id`, `id_salon`, `id_user`, `message`, `date`) VALUES
(55, 1, 4, 'test', '2017-06-14 14:51:48'),
(56, 1, 4, '1', '2017-06-14 14:55:07'),
(57, 1, 4, '2', '2017-06-14 14:55:08'),
(58, 1, 4, '3', '2017-06-14 14:55:08'),
(59, 1, 4, '1', '2017-06-14 14:55:49'),
(60, 1, 4, '2', '2017-06-14 14:55:50'),
(61, 1, 4, '3', '2017-06-14 14:55:51'),
(62, 1, 5, 'test', '2017-06-14 15:04:56'),
(63, 1, 5, 'mdr ?', '2017-06-14 15:05:22'),
(64, 2, 4, 'ah ok ', '2017-06-14 15:05:25'),
(65, 2, 4, 'test', '2017-06-14 15:08:29'),
(66, 2, 4, 'ok?', '2017-06-14 15:08:49'),
(67, 1, 5, 'cool', '2017-06-14 15:08:53'),
(68, 2, 5, 'oops', '2017-06-14 15:09:00'),
(69, 2, 4, 'wjaiaz', '2017-06-14 15:09:02'),
(70, 1, 5, 'test', '2017-06-14 15:23:06'),
(71, 1, 5, 'test', '2017-06-14 15:24:16'),
(72, 1, 4, 'alleeeer', '2017-06-14 15:24:21'),
(73, 1, 4, 'salut', '2017-06-15 21:48:17'),
(74, 1, 4, 'salut', '2017-06-15 21:48:20'),
(75, 1, 4, 'salut', '2017-06-15 21:48:26'),
(76, 1, 4, 'salut', '2017-06-15 21:49:23'),
(77, 1, 4, 'salut', '2017-06-15 21:49:39'),
(78, 1, 4, 'salut', '2017-06-15 21:49:49'),
(79, 1, 5, 'coucou', '2017-06-15 21:49:52'),
(80, 1, 4, 'woaw', '2017-06-15 21:49:54'),
(81, 1, 5, 'génial', '2017-06-15 21:49:56'),
(82, 1, 4, 'oui', '2017-06-19 21:40:51');

-- --------------------------------------------------------

--
-- Structure de la table `salon`
--

CREATE TABLE `salon` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `id_livre` int(11) NOT NULL,
  `nb_max_user` int(11) NOT NULL,
  `statut` int(11) NOT NULL,
  `nb_max_report_needed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users_salon`
--

CREATE TABLE `users_salon` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `pseudo_user` varchar(255) NOT NULL,
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
-- Index pour la table `CATEGORY`
--
ALTER TABLE `CATEGORY`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `BOOK_CATEGORY`
--
ALTER TABLE `BOOK_CATEGORY`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `CATEGORY`
--
ALTER TABLE `CATEGORY`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `messages_salon`
--
ALTER TABLE `messages_salon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT pour la table `salon`
--
ALTER TABLE `salon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users_salon`
--
ALTER TABLE `users_salon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `BOOK_CATEGORY`
--
ALTER TABLE `BOOK_CATEGORY`
  ADD CONSTRAINT `BOOK_CATEGORY_fk0` FOREIGN KEY (`id_book`) REFERENCES `BOOK` (`id`),
  ADD CONSTRAINT `BOOK_CATEGORY_fk1` FOREIGN KEY (`id_category`) REFERENCES `CATEGORY` (`id`);
