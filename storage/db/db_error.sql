-- MySQL Script generated by MySQL Workbench
-- Tue Jun 28 00:54:16 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE =
    'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

DROP TABLE IF EXISTS `a_shop`.`ax_main_errors_type`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_errors_type`
(
    `id`         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`      VARCHAR(500)        NOT NULL,
    `name`       VARCHAR(500)        NOT NULL,
    `created_at` INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at` INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at` INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_main_errors`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_errors`
(
    `id`             BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `errors_type_id` BIGINT(20) UNSIGNED NOT NULL,
    `user_id`        BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `ips_id`         BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `model`          VARCHAR(255)        NULL DEFAULT NULL,
    `body`           JSON                NULL DEFAULT NULL,
    `created_at`     INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`     INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`     INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `errors_type_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_main_errors_ax_user1_idx` (`user_id` ASC),
    INDEX `fk_ax_main_errors_ax_main_errors_type1_idx` (`errors_type_id` ASC),
    INDEX `fk_ax_main_errors_ax_main_ips1_idx` (`ips_id` ASC),
    CONSTRAINT `fk_ax_main_errors_ax_user1`
        FOREIGN KEY (`user_id`)
            REFERENCES `a_shop`.`ax_user` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_main_errors_ax_main_errors_type1`
        FOREIGN KEY (`errors_type_id`)
            REFERENCES `a_shop`.`ax_main_errors_type` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_main_errors_ax_main_ips1`
        FOREIGN KEY (`ips_id`)
            REFERENCES `a_shop`.`ax_main_ips` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB;


SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;
