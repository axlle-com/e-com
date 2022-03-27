SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `v_temp` DEFAULT CHARACTER SET utf8 ;
USE `v_temp` ;

DROP TABLE IF EXISTS `v_temp`.`ax_user` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_user` (
                                                  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                  `email` VARCHAR(255) NOT NULL,
                                                  `first_name` VARCHAR(255) NOT NULL DEFAULT 'Undefined',
                                                  `last_name` VARCHAR(255) NOT NULL DEFAULT 'Undefined',
                                                  `patronymic` VARCHAR(255) NOT NULL DEFAULT 'Undefined',
                                                  `name_short` VARCHAR(255) NOT NULL DEFAULT 'Undefined',
                                                  `password_hash` VARCHAR(255) NOT NULL,
                                                  `status` SMALLINT(6) NOT NULL DEFAULT 0,
                                                  `remember_token` VARCHAR(500) NULL DEFAULT NULL,
                                                  `auth_key` VARCHAR(32) NULL DEFAULT NULL,
                                                  `password_reset_token` VARCHAR(255) NULL DEFAULT NULL,
                                                  `verification_token` VARCHAR(255) NULL DEFAULT NULL,
                                                  `created_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                  `updated_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                  `deleted_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                  PRIMARY KEY (`id`),
                                                  UNIQUE INDEX `email` (`email` ASC),
                                                  UNIQUE INDEX `password_reset_token` (`password_reset_token` ASC),
                                                  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

DROP TABLE IF EXISTS `v_temp`.`ax_user_token` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_user_token` (
                                                        `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                        `user_id` BIGINT(20) UNSIGNED NOT NULL,
                                                        `type` VARCHAR(45) NOT NULL,
                                                        `token` VARCHAR(800) NOT NULL,
                                                        `created_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                        `updated_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                        `deleted_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                        `expired_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                        PRIMARY KEY (`id`, `user_id`),
                                                        UNIQUE INDEX `id_UNIQUE` (`id` ASC),
                                                        INDEX `fk_table1_ax_user1_idx` (`user_id` ASC),
                                                        UNIQUE INDEX `value_UNIQUE` (`token` ASC),
                                                        CONSTRAINT `fk_table1_ax_user1`
                                                            FOREIGN KEY (`user_id`)
                                                                REFERENCES `v_temp`.`ax_user` (`id`)
                                                                ON DELETE NO ACTION
                                                                ON UPDATE NO ACTION)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `v_temp`.`ax_migrations` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_migrations` (
                                                        `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                        `migration` VARCHAR(255) NOT NULL,
                                                        `batch` INT(11) NOT NULL,
                                                        PRIMARY KEY (`id`),
                                                        UNIQUE INDEX `id_UNIQUE` (`id` ASC))
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `v_temp`.`ax_currency` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_currency` (
                                                      `id` VARCHAR(10) NOT NULL,
                                                      `title` VARCHAR(255) NOT NULL,
                                                      `num_code` INT NOT NULL,
                                                      `char_code` VARCHAR(10) NOT NULL,
                                                      `created_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                      `updated_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                      `deleted_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                      PRIMARY KEY (`id`),
                                                      UNIQUE INDEX `char_code_UNIQUE` (`char_code` ASC),
                                                      UNIQUE INDEX `id_UNIQUE` (`id` ASC))
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `v_temp`.`ax_wallet_currency` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_wallet_currency` (
                                                             `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                             `currency_id` VARCHAR(10) NULL DEFAULT 0,
                                                             `name` VARCHAR(45) NOT NULL,
                                                             `title` VARCHAR(255) NOT NULL,
                                                             `is_national` TINYINT(1) NOT NULL DEFAULT 0,
                                                             `created_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                             `updated_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                             `deleted_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                             PRIMARY KEY (`id`),
                                                             UNIQUE INDEX `id_UNIQUE` (`id` ASC),
                                                             UNIQUE INDEX `email_UNIQUE` (`title` ASC),
                                                             UNIQUE INDEX `name_UNIQUE` (`name` ASC),
                                                             INDEX `fk_ax_wallet_currency_ax_currency1_idx` (`currency_id` ASC),
                                                             CONSTRAINT `fk_ax_wallet_currency_ax_currency1`
                                                                 FOREIGN KEY (`currency_id`)
                                                                     REFERENCES `v_temp`.`ax_currency` (`id`)
                                                                     ON DELETE NO ACTION
                                                                     ON UPDATE NO ACTION)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `v_temp`.`ax_wallet` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_wallet` (
                                                    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                    `user_id` BIGINT(20) UNSIGNED NOT NULL,
                                                    `wallet_currency_id` BIGINT(20) UNSIGNED NOT NULL,
                                                    `balance` DOUBLE NOT NULL,
                                                    `created_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                    `updated_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                    `deleted_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                    PRIMARY KEY (`id`, `user_id`, `wallet_currency_id`),
                                                    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
                                                    INDEX `fk_ax_wallet_ax_user1_idx` (`user_id` ASC),
                                                    INDEX `fk_ax_wallet_ax_wallet_currency1_idx` (`wallet_currency_id` ASC),
                                                    CONSTRAINT `fk_ax_wallet_ax_user1`
                                                        FOREIGN KEY (`user_id`)
                                                            REFERENCES `v_temp`.`ax_user` (`id`)
                                                            ON DELETE NO ACTION
                                                            ON UPDATE NO ACTION,
                                                    CONSTRAINT `fk_ax_wallet_ax_wallet_currency1`
                                                        FOREIGN KEY (`wallet_currency_id`)
                                                            REFERENCES `v_temp`.`ax_wallet_currency` (`id`)
                                                            ON DELETE NO ACTION
                                                            ON UPDATE NO ACTION)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `v_temp`.`ax_wallet_transaction_type` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_wallet_transaction_type` (
                                                                     `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                     `name` VARCHAR(100) NOT NULL,
                                                                     `title` VARCHAR(100) NOT NULL,
                                                                     `created_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                     `updated_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                     `deleted_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                     PRIMARY KEY (`id`),
                                                                     UNIQUE INDEX `id_UNIQUE` (`id` ASC),
                                                                     UNIQUE INDEX `name_UNIQUE` (`name` ASC),
                                                                     UNIQUE INDEX `title_UNIQUE` (`title` ASC))
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `v_temp`.`ax_wallet_transaction_reason` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_wallet_transaction_reason` (
                                                                       `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                       `name` VARCHAR(100) NOT NULL,
                                                                       `title` VARCHAR(100) NOT NULL,
                                                                       `created_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                       `updated_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                       `deleted_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                       PRIMARY KEY (`id`),
                                                                       UNIQUE INDEX `id_UNIQUE` (`id` ASC),
                                                                       UNIQUE INDEX `title_UNIQUE` (`title` ASC),
                                                                       UNIQUE INDEX `name_UNIQUE` (`name` ASC))
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `v_temp`.`ax_wallet_transaction` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_wallet_transaction` (
                                                                `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                `wallet_id` BIGINT(20) UNSIGNED NOT NULL,
                                                                `wallet_currency_id` BIGINT(20) UNSIGNED NOT NULL,
                                                                `transaction_type_id` BIGINT(20) UNSIGNED NOT NULL,
                                                                `transaction_reason_id` BIGINT(20) UNSIGNED NOT NULL,
                                                                `value` DOUBLE NOT NULL,
                                                                `created_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                `updated_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                `deleted_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                PRIMARY KEY (`id`, `wallet_id`, `wallet_currency_id`, `transaction_type_id`, `transaction_reason_id`),
                                                                UNIQUE INDEX `id_UNIQUE` (`id` ASC),
                                                                INDEX `fk_ax_wallet_transaction_ax_wallet_transaction_type1_idx` (`transaction_type_id` ASC),
                                                                INDEX `fk_ax_wallet_transaction_ax_wallet1_idx` (`wallet_id` ASC),
                                                                INDEX `fk_ax_wallet_transaction_ax_wallet_transaction_reason1_idx` (`transaction_reason_id` ASC),
                                                                INDEX `fk_ax_wallet_transaction_ax_wallet_currency1_idx` (`wallet_currency_id` ASC),
                                                                CONSTRAINT `fk_ax_wallet_transaction_ax_wallet_transaction_type1`
                                                                    FOREIGN KEY (`transaction_type_id`)
                                                                        REFERENCES `v_temp`.`ax_wallet_transaction_type` (`id`)
                                                                        ON DELETE NO ACTION
                                                                        ON UPDATE NO ACTION,
                                                                CONSTRAINT `fk_ax_wallet_transaction_ax_wallet1`
                                                                    FOREIGN KEY (`wallet_id`)
                                                                        REFERENCES `v_temp`.`ax_wallet` (`id`)
                                                                        ON DELETE NO ACTION
                                                                        ON UPDATE NO ACTION,
                                                                CONSTRAINT `fk_ax_wallet_transaction_ax_wallet_transaction_reason1`
                                                                    FOREIGN KEY (`transaction_reason_id`)
                                                                        REFERENCES `v_temp`.`ax_wallet_transaction_reason` (`id`)
                                                                        ON DELETE NO ACTION
                                                                        ON UPDATE NO ACTION,
                                                                CONSTRAINT `fk_ax_wallet_transaction_ax_wallet_currency1`
                                                                    FOREIGN KEY (`wallet_currency_id`)
                                                                        REFERENCES `v_temp`.`ax_wallet_currency` (`id`)
                                                                        ON DELETE NO ACTION
                                                                        ON UPDATE NO ACTION)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `v_temp`.`ax_currency_exchange_rate` ;

CREATE TABLE IF NOT EXISTS `v_temp`.`ax_currency_exchange_rate` (
                                                                    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                                                                    `currency_id` VARCHAR(10) NOT NULL,
                                                                    `value` DOUBLE NOT NULL,
                                                                    `date_rate` INT(11) UNSIGNED NOT NULL,
                                                                    `created_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                    `updated_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                    `deleted_at` INT(11) UNSIGNED NULL DEFAULT NULL,
                                                                    PRIMARY KEY (`id`, `currency_id`),
                                                                    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
                                                                    INDEX `fk_ax_currency_exchange_rate_ax_currency1_idx` (`currency_id` ASC),
                                                                    CONSTRAINT `fk_ax_currency_exchange_rate_ax_currency1`
                                                                        FOREIGN KEY (`currency_id`)
                                                                            REFERENCES `v_temp`.`ax_currency` (`id`)
                                                                            ON DELETE NO ACTION
                                                                            ON UPDATE NO ACTION)
    ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

START TRANSACTION;
USE `v_temp`;
INSERT INTO `v_temp`.`ax_user` (`id`, `email`, `first_name`, `last_name`, `patronymic`, `name_short`, `password_hash`, `status`, `remember_token`, `auth_key`, `password_reset_token`, `verification_token`, `created_at`, `updated_at`, `deleted_at`) VALUES (6, 'axlle@mail.ru', 'Алексей', 'Алексеев', 'Александрович', 'Алексеев А.А.', '$2y$13$DMqEjJJL9gjftb80gCt5n.fOTyoTfAEv/HsQPh2IEQa42bfNsfF5S', 10, 'kyyBBbb80b3ZflMDdsynKC0B4skxf_gF', 'kyyBBbb80b3ZflMDdsynKC0B4skxf_gF', NULL, 'vp5HeulN9jabEM6VezE-DxbiySdd8-VY_1612026130', UNIX_TIMESTAMP(), NULL, NULL);

COMMIT;

