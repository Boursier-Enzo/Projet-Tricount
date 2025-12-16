CREATE TABLE IF NOT EXISTS `users` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`username` varchar(50) NOT NULL,
	`email` varchar(100) NOT NULL,
	`password_hash` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `groups` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`name` varchar(100) NOT NULL,
	`created_by` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `group_members` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`group_id` int NOT NULL,
	`user_id` int NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `expenses` (
	`id` int AUTO_INCREMENT NOT NULL UNIQUE,
	`group_id` int NOT NULL,
	`paid_by` int NOT NULL,
	`title` varchar(150) NOT NULL,
	`amount` decimal(10,2) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `users` ADD CONSTRAINT `users_fk0` FOREIGN KEY (`id`) REFERENCES `groups`(`created_by`);
ALTER TABLE `groups` ADD CONSTRAINT `groups_fk0` FOREIGN KEY (`id`) REFERENCES `group_members`(`group_id`);

ALTER TABLE `groups` ADD CONSTRAINT `groups_fk2` FOREIGN KEY (`created_by`) REFERENCES `users`(`id`);
ALTER TABLE `group_members` ADD CONSTRAINT `group_members_fk1` FOREIGN KEY (`group_id`) REFERENCES `null`(`id`);

ALTER TABLE `group_members` ADD CONSTRAINT `group_members_fk2` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`);
ALTER TABLE `expenses` ADD CONSTRAINT `expenses_fk1` FOREIGN KEY (`group_id`) REFERENCES `groups`(`id`);

ALTER TABLE `expenses` ADD CONSTRAINT `expenses_fk2` FOREIGN KEY (`paid_by`) REFERENCES `users`(`id`);