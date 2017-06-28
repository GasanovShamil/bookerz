DROP TABLE IF EXISTS ci_sessions;

CREATE TABLE IF NOT EXISTS `ci_sessions` (
`id` varchar(40) NOT NULL,
`ip_address` varchar(45) NOT NULL,
`timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
`data` blob NOT NULL,
KEY `ci_sessions_timestamp` (`timestamp`)
);

CREATE TABLE `CATEGORY` (
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(40) NOT NULL,
	PRIMARY KEY (`id`)
);
CREATE TABLE `BOOK_CATEGORY` (
	`id` int NOT NULL AUTO_INCREMENT,
	`id_book` int NOT NULL,
	`id_category` int NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `BOOK_CATEGORY` ADD CONSTRAINT `BOOK_CATEGORY_fk0` FOREIGN KEY (`id_book`) REFERENCES `BOOK`(`id`);

ALTER TABLE `BOOK_CATEGORY` ADD CONSTRAINT `BOOK_CATEGORY_fk1` FOREIGN KEY (`id_category`) REFERENCES `CATEGORY`(`id`);