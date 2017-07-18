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
  `ISBN10` varchar(255) NOT NULL,
  `ISBN13` varchar(255) NOT NULL,
  `accepted` BOOLEAN NOT NULL,
  `cover` varchar(500) NOT NULL
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


-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

CREATE TABLE `pages` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	`label` VARCHAR(100) NOT NULL,
	`title` VARCHAR(150) NOT NULL,
	`text` VARCHAR(2000) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `templates` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL,
	`label` VARCHAR(100) NOT NULL,
	`title` VARCHAR(150) NOT NULL,
	`text` VARCHAR(2000) NOT NULL,
	PRIMARY KEY (`id`)
);


CREATE TABLE `config` (
	`key` VARCHAR(50) NOT NULL,
	`value` VARCHAR(2000) NOT NULL,
	PRIMARY KEY (`key`)
);


CREATE TABLE `on_top` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`id_book` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`)
);
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
ALTER TABLE `on_top`
  ADD CONSTRAINT `on_top_fk0` FOREIGN KEY (`id_book`) REFERENCES `book` (`id`);
--
-- Contraintes pour la table `book_category`
--
ALTER TABLE `book_category`
  ADD CONSTRAINT `book_category_fk0` FOREIGN KEY (`id_book`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `book_category_fk1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);

  INSERT INTO `config` (`key`, `value`) VALUES
('home_template', 'home-main');



INSERT INTO `templates` (`name`, `label`, `title`, `text`) VALUES
('error-page', 'Le Club des Critiques', 'Error', 'This is not the page you are looking for'),
('home-main', 'Le Club des Critiques', 'Le concept', 'This is an example to show the potential of an offcanvas layout pattern in Bootstrap. Try some responsive-range viewport sizes to see it in action. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.'),
('home-light', 'Le Club des Critiques', 'Light template', 'This is an example to show the potential of an offcanvas layout pattern in Bootstrap. Try some responsive-range viewport sizes to see it in action. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.');


INSERT INTO `category`(`name`, `description`) VALUES
('Fantasy','Fantasy'),
('Anthologie','Anthologie'),
('Anthropologie','Anthropologie'),
('Arts','Arts'),
('Autobiographie','Autobiographie'),
('Autoportrait','Autoportrait'),
('Bd','Bd'),
('Beaux-Livres','Beaux-Livres'),
('Biographie','Biographie'),
('Chroniques','Chroniques'),
('Comics','Comics'),
('Dictionnaire','Dictionnaire'),
('Espionnage','Espionnage'),
('Fantastique','Fantastique'),
('Humour','Humour'),
('Philosophie','Philosophie'),
('Roman','Roman'),
('Tragédie','Tragédie');


INSERT INTO `book`(`title`, `description`, `date`, `author`, `published`, `editor`, `ISBN10`, `ISBN13`, `accepted`,`cover`) VALUES
('Les Torrents d’argent','Drizzt et ses compagnons partent en quête de la cité de Castelmithral, le berceau légendaire du peuple de Bruenor. Confronté au racisme, Drizzt envisage sérieusement de regagner les ténèbres de l’Outreterre. De son côté, Wulfgar commence à surmonter son aversion atavique pour la magie. Quant à Régis, il cherche à échapper à un redoutable assassin qui s’est allié à des magiciens maléfiques. Ces derniers ont juré la perte des compagnons et CattiBrie est la seule à pouvoir contrecarrer leurs plans.','2017-07-16','R.A. Salvatore','2010-11-24','Milady','2820500552',' 9782820500557',FALSE,'https://books.google.fr/books/content?id=VXmGAQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71f2u1t3-snXEJdN6eYzsmt9M3c7_19jbG5uKMtd5OIN--ZaT1-C90OawwTeYjiR7ou9UP15dmQLJDsKXeUIA2emT4KdJ_qpyL5WYtDgfM1DEV45U7Kx6md26eoW12RqWjhHgof'),
('Les Compagnons','Mailikki, déesse de la nature, offre aux Compagnons de la Halle une chance d’aider Drizzt : ils vivront une nouvelle existence, sans jamais se croiser, jusqu’au jour où ils retrouveront leur ami et le sauveront des griffes de Lloth, la terrible déesse-araignée. Aux quatre coins des Royaumes Oubliés, une jeune sorcière maniant la magie interdite, un voleur aussi malingre que féroce et un nain à la force surnaturelle luttent pour rencontrer leur destin... mais rien ne dit qu’ils survivront jusqu’à ce jour, alors que dans l’ombre une cabale de sorciers les surveille de près et que des dieux oubliés renaissent de leurs cendres.','2017-07-16','R.A. Salvatore','2015-05-29','Milady','2820519792',' 9782820519795',TRUE,'https://books.google.fr/books/content?id=PPpwCQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73AIXtxUHWmcOy0oQ0QRNrBPO93oGsWOpjeYb5euRU-_qv9UlyW3vdvb99tWT3zLCWbxoMaQrqJpWL9k3EzXb_kLgybqidH0WfyrtNNWWplpoynQS_U3BVfxVETsupKO7knJCJe');

INSERT INTO `book_category`(`id_book`, `id_category`) VALUES
(1,1),
(2,1),
(1,14);
