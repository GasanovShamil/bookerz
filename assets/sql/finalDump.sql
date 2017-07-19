SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de donnÃ©es :  `bookerz`
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
-- Structure de la table `invitation`
--
CREATE TABLE `invitation` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `url` varchar(20) NOT NULL,
  `chatroom_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('Tragï¿½die','Tragï¿½die');


INSERT INTO `book`(`title`, `description`, `date`, `author`, `published`, `editor`, `ISBN10`, `ISBN13`, `accepted`,`cover`) VALUES
('Les Torrents dï¿½argent','Drizzt et ses compagnons partent en quï¿½te de la citï¿½ de Castelmithral, le berceau lï¿½gendaire du peuple de Bruenor. Confrontï¿½ au racisme, Drizzt envisage sï¿½rieusement de regagner les tï¿½nï¿½bres de lï¿½Outreterre. De son cï¿½tï¿½, Wulfgar commence ï¿½ surmonter son aversion atavique pour la magie. Quant ï¿½ Rï¿½gis, il cherche ï¿½ ï¿½chapper ï¿½ un redoutable assassin qui sï¿½est alliï¿½ ï¿½ des magiciens malï¿½fiques. Ces derniers ont jurï¿½ la perte des compagnons et CattiBrie est la seule ï¿½ pouvoir contrecarrer leurs plans.','2017-07-16','R.A. Salvatore','2010-11-24','Milady','2820500552',' 9782820500557',FALSE,'https://books.google.fr/books/content?id=VXmGAQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE71f2u1t3-snXEJdN6eYzsmt9M3c7_19jbG5uKMtd5OIN--ZaT1-C90OawwTeYjiR7ou9UP15dmQLJDsKXeUIA2emT4KdJ_qpyL5WYtDgfM1DEV45U7Kx6md26eoW12RqWjhHgof'),
('Les Compagnons','Mailikki, dï¿½esse de la nature, offre aux Compagnons de la Halle une chance dï¿½aider Drizzt : ils vivront une nouvelle existence, sans jamais se croiser, jusquï¿½au jour oï¿½ ils retrouveront leur ami et le sauveront des griffes de Lloth, la terrible dï¿½esse-araignï¿½e. Aux quatre coins des Royaumes Oubliï¿½s, une jeune sorciï¿½re maniant la magie interdite, un voleur aussi malingre que fï¿½roce et un nain ï¿½ la force surnaturelle luttent pour rencontrer leur destin... mais rien ne dit quï¿½ils survivront jusquï¿½ï¿½ ce jour, alors que dans lï¿½ombre une cabale de sorciers les surveille de prï¿½s et que des dieux oubliï¿½s renaissent de leurs cendres.','2017-07-16','R.A. Salvatore','2015-05-29','Milady','2820519792',' 9782820519795',TRUE,'https://books.google.fr/books/content?id=PPpwCQAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&imgtk=AFLRE73AIXtxUHWmcOy0oQ0QRNrBPO93oGsWOpjeYb5euRU-_qv9UlyW3vdvb99tWT3zLCWbxoMaQrqJpWL9k3EzXb_kLgybqidH0WfyrtNNWWplpoynQS_U3BVfxVETsupKO7knJCJe');

INSERT INTO `book_category`(`id_book`, `id_category`) VALUES
(1,1),
(2,1),
(1,14);

INSERT INTO `status_book` (`id`, `libelle`) VALUES
(1, 'Disponible'),
(2, 'Prêté'),
(3, 'Je le veux'),
(4, 'Je ne veux pas prêter');

