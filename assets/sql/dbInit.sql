DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
	`userId` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`name` varchar(100) NOT NULL,
	`surname` varchar(100) NOT NULL,
	`email` varchar(100) NOT NULL UNIQUE,
	`password` varchar(100) NOT NULL
);