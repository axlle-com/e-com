DROP TABLE IF EXISTS `a_shop`.`ax_catalog_storage_reserve`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_storage_reserve`
(
    `id`                 BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `catalog_product_id` BIGINT(20) UNSIGNED NOT NULL,
    `resource`           VARCHAR(255)        NOT NULL,
    `resource_id`        BIGINT(20) UNSIGNED NOT NULL,
    `status`             TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `in_reserve`         INT UNSIGNED        NULL DEFAULT 0,
    `expired_at`         INT(11) UNSIGNED    NULL,
    `created_at`         INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`         INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`         INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `catalog_product_id`),
    INDEX `fk_ax_catalog_storage_ax_catalog_product1_idx` (`catalog_product_id` ASC),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    CONSTRAINT `fk_ax_catalog_storage_ax_catalog_product10`
        FOREIGN KEY (`catalog_product_id`)
            REFERENCES `a_shop`.`ax_catalog_product` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;
