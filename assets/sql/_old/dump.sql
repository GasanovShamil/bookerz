

CREATE TABLE `USER` (
	`id` INT NOT NULL,
	`role` varchar(100) NOT NULL,
	`email` varchar(100) NOT NULL UNIQUE,
	`name` varchar(100) NOT NULL,
	`surname` varchar(100) NOT NULL,
	'password' varchar(8) NOT NULL,
	`blocked` boolean NOT NULL,
	`block_date` DATE,
	`date_inscription` DATE NOT NULL,
	`ip_adress` varchar(11) NOT NULL,
	`booktuber` boolean NOT NULL,
	'token' varchar(255),
	PRIMARY KEY (`id`)
);

CREATE TABLE `CATEGORY` (
	`id` int NOT NULL,
	`name` varchar(25) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `BOOK` (
	`id` int NOT NULL,
	`title` varchar(50) NOT NULL,
	`description` varchar(255) NOT NULL,
	`date` DATE NOT NULL,
	`author` varchar(25) NOT NULL,
	`published` int(1) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `BOOK_CATEGORY` (
	`id` int NOT NULL,
	`id_book` int NOT NULL,
	`id_category` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `SALON` (
	`id` int NOT NULL,
	`name` varchar(25) NOT NULL,
	`start_date` DATE NOT NULL,
	`end_date` DATE NOT NULL,
	`id_livre` int NOT NULL,
	`nb_max_user` int NOT NULL,
	`status` int NOT NULL,
	`nb_max_report_needed` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `MESSAGES_SALON` (
	`id` int NOT NULL,
	`id_salon` int NOT NULL,
	`id_user` int NOT NULL,
	`message` TEXT NOT NULL,
	`date` DATE NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `USERS_SALON` (
	`id` int NOT NULL,
	`id_user` int NOT NULL,
	`id_salon` int NOT NULL,
	`moderator` boolean NOT NULL,
	`nb_signaled` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `FRIEND` (
	`id` int NOT NULL,
	`id_user1` int NOT NULL,
	`id_user2` int NOT NULL,
	`date` DATE NOT NULL,
	`confirm` boolean NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `INTERFACE` (
	`id` int NOT NULL,
	`name` varchar(25) NOT NULL,
	`content` TEXT NOT NULL,
	`modified_by` int NOT NULL,
	`last_modification` DATE NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `BOOK_NOTE` (
	`id` int NOT NULL,
	`id_user` int NOT NULL,
	`id_book` int NOT NULL,
	`note` int(1) NOT NULL,
	`date` DATE NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `COMMENTS` (
	`id` int NOT NULL,
	`id_user` int NOT NULL,
	`id_book` int NOT NULL,
	`content` varchar(255) NOT NULL,
	`date` DATE NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `BANNED_USER` (
	`id_user` int NOT NULL,
	`blocked_date` DATE NOT NULL,
	`reason` varchar(50) NOT NULL
);

CREATE TABLE `SHARE` (
	`id` int NOT NULL,
	`id_user_share` int NOT NULL,
	`id_user_get` int,
	`id_book` int NOT NULL,
	`date` DATE NOT NULL,
	`status` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `REPORT` (
	`id` int NOT NULL,
	`id_user` int NOT NULL,
	`id_user_reported` int NOT NULL,
	`reason` varchar(50) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `USER_NOTE` (
	`id` int NOT NULL,
	`id_user` int NOT NULL,
	`id_user_voted` int NOT NULL,
	`note` int NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `BOOK_CATEGORY` ADD CONSTRAINT `BOOK_CATEGORY_fk0` FOREIGN KEY (`id_book`) REFERENCES `BOOK`(`id`);

ALTER TABLE `BOOK_CATEGORY` ADD CONSTRAINT `BOOK_CATEGORY_fk1` FOREIGN KEY (`id_category`) REFERENCES `CATEGORY`(`id`);

ALTER TABLE `SALON` ADD CONSTRAINT `SALON_fk0` FOREIGN KEY (`id_livre`) REFERENCES `BOOK`(`id`);

ALTER TABLE `MESSAGES_SALON` ADD CONSTRAINT `MESSAGES_SALON_fk0` FOREIGN KEY (`id_salon`) REFERENCES `SALON`(`id`);

ALTER TABLE `MESSAGES_SALON` ADD CONSTRAINT `MESSAGES_SALON_fk1` FOREIGN KEY (`id_user`) REFERENCES `USER`(`id`);

ALTER TABLE `USERS_SALON` ADD CONSTRAINT `USERS_SALON_fk0` FOREIGN KEY (`id_user`) REFERENCES `USER`(`id`);

ALTER TABLE `USERS_SALON` ADD CONSTRAINT `USERS_SALON_fk1` FOREIGN KEY (`id_salon`) REFERENCES `SALON`(`id`);

ALTER TABLE `FRIEND` ADD CONSTRAINT `FRIEND_fk0` FOREIGN KEY (`id_user1`) REFERENCES `USER`(`id`);

ALTER TABLE `FRIEND` ADD CONSTRAINT `FRIEND_fk1` FOREIGN KEY (`id_user2`) REFERENCES `USER`(`id`);

ALTER TABLE `INTERFACE` ADD CONSTRAINT `INTERFACE_fk0` FOREIGN KEY (`modified_by`) REFERENCES `USER`(`id`);

ALTER TABLE `BOOK_NOTE` ADD CONSTRAINT `BOOK_NOTE_fk0` FOREIGN KEY (`id_user`) REFERENCES `USER`(`id`);

ALTER TABLE `BOOK_NOTE` ADD CONSTRAINT `BOOK_NOTE_fk1` FOREIGN KEY (`id_book`) REFERENCES `BOOK`(`id`);

ALTER TABLE `COMMENTS` ADD CONSTRAINT `COMMENTS_fk0` FOREIGN KEY (`id_user`) REFERENCES `USER`(`id`);

ALTER TABLE `COMMENTS` ADD CONSTRAINT `COMMENTS_fk1` FOREIGN KEY (`id_book`) REFERENCES `BOOK`(`id`);

ALTER TABLE `BANNED_USER` ADD CONSTRAINT `BANNED_USER_fk0` FOREIGN KEY (`id_user`) REFERENCES `USER`(`id`);

ALTER TABLE `SHARE` ADD CONSTRAINT `SHARE_fk0` FOREIGN KEY (`id_user_share`) REFERENCES `USER`(`id`);

ALTER TABLE `SHARE` ADD CONSTRAINT `SHARE_fk1` FOREIGN KEY (`id_user_get`) REFERENCES `USER`(`id`);

ALTER TABLE `SHARE` ADD CONSTRAINT `SHARE_fk2` FOREIGN KEY (`id_book`) REFERENCES `BOOK`(`id`);

ALTER TABLE `REPORT` ADD CONSTRAINT `REPORT_fk0` FOREIGN KEY (`id_user`) REFERENCES `USER`(`id`);

ALTER TABLE `REPORT` ADD CONSTRAINT `REPORT_fk1` FOREIGN KEY (`id_user_reported`) REFERENCES `USER`(`id`);

ALTER TABLE `USER_NOTE` ADD CONSTRAINT `USER_NOTE_fk0` FOREIGN KEY (`id_user`) REFERENCES `USER`(`id`);

ALTER TABLE `USER_NOTE` ADD CONSTRAINT `USER_NOTE_fk1` FOREIGN KEY (`id_user_voted`) REFERENCES `USER`(`id`);

