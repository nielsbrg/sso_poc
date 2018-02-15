DROP DATABASE IF EXISTS sso_sp1_db;

CREATE DATABASE sso_sp1_db;

USE sso_sp1_db;

CREATE TABLE `users` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(255) NULL DEFAULT NULL,
	`password` VARCHAR(255) NULL DEFAULT NULL,
	`taalcode` VARCHAR(2) NULL DEFAULT NULL,
	`startdatum` DATE NULL DEFAULT '0000-00-00',
	`einddatum` DATE NULL DEFAULT NULL,
	`actief` TINYINT(1) UNSIGNED NULL DEFAULT '1',
	`aanhef` VARCHAR(255) NULL DEFAULT NULL,
	`voornaam` VARCHAR(255) NULL DEFAULT NULL,
	`tussenvoegsel` VARCHAR(255) NULL DEFAULT NULL,
	`achternaam` VARCHAR(255) NULL DEFAULT NULL,
	`geslacht` VARCHAR(1) NULL DEFAULT NULL,
	`straat` VARCHAR(255) NULL DEFAULT NULL,
	`huisnummer` VARCHAR(255) NULL DEFAULT NULL,
	`huisnummertoevoeging` VARCHAR(255) NULL DEFAULT NULL,
	`postcode` VARCHAR(255) NULL DEFAULT NULL,
	`plaats` VARCHAR(255) NULL DEFAULT NULL,
	`landcode` VARCHAR(2) NULL DEFAULT NULL,
	`telefoon` VARCHAR(255) NULL DEFAULT NULL,
	`email` VARCHAR(255) NULL DEFAULT NULL,
	`bedrijfsnaam` VARCHAR(255) NULL DEFAULT NULL,
	`afbeelding` VARCHAR(255) NULL DEFAULT NULL,
	`role_id` INT(11) NOT NULL,
	`created` DATETIME NULL DEFAULT NULL,
	`creator` INT(10) UNSIGNED NULL DEFAULT NULL,
	`modified` DATETIME NULL DEFAULT NULL,
	`modifier` INT(10) UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `created` (`created`),
	INDEX `modified` (`modified`),
	INDEX `username` (`username`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
AUTO_INCREMENT=241
;
