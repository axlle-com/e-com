DROP TABLE IF EXISTS `a_shop`.`ax_catalog_storage`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_storage`
(
    `id`                       BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `catalog_storage_place_id` BIGINT(20) UNSIGNED NOT NULL,
    `catalog_product_id`       BIGINT(20) UNSIGNED NOT NULL,
    `in_stock`                 INT UNSIGNED        NOT NULL DEFAULT 0,
    `in_reserve`               INT UNSIGNED        NULL     DEFAULT 0,
    `reserve_expired_at`       INT(11) UNSIGNED    NULL,
    `price_in`                 DECIMAL UNSIGNED    NULL     DEFAULT 0.0,
    `price_out`                DECIMAL UNSIGNED    NULL     DEFAULT 0.0,
    `created_at`               INT(11) UNSIGNED    NULL     DEFAULT NULL,
    `updated_at`               INT(11) UNSIGNED    NULL     DEFAULT NULL,
    `deleted_at`               INT(11) UNSIGNED    NULL     DEFAULT NULL,
    PRIMARY KEY (`id`, `catalog_storage_place_id`, `catalog_product_id`),
    INDEX `fk_ax_catalog_storage_ax_catalog_product1_idx` (`catalog_product_id` ASC),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    CONSTRAINT `fk_ax_catalog_storage_ax_catalog_storage_place1`
        FOREIGN KEY (`catalog_storage_place_id`)
            REFERENCES `a_shop`.`ax_catalog_storage_place` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_storage_ax_catalog_product1`
        FOREIGN KEY (`catalog_product_id`)
            REFERENCES `a_shop`.`ax_catalog_product` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;
DROP TABLE IF EXISTS `a_shop`.`ax_catalog_document`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_document`
(
    `id`                          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`                     BIGINT(20) UNSIGNED NOT NULL,
    `catalog_document_subject_id` BIGINT(20) UNSIGNED NOT NULL,
    `currency_id`                 BIGINT(20) UNSIGNED NULL,
    `ips_id`                      BIGINT(20) UNSIGNED NULL,
    `status`                      TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `created_at`                  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`                  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`                  INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `user_id`, `catalog_document_subject_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_catalog_document_ax_user1_idx` (`user_id` ASC),
    INDEX `fk_ax_catalog_document_ax_currency1_idx` (`currency_id` ASC),
    INDEX `fk_ax_catalog_document_ax_catalog_document_subject1_idx` (`catalog_document_subject_id` ASC),
    INDEX `fk_ax_catalog_document_ax_ips1_idx` (`ips_id` ASC),
    CONSTRAINT `fk_ax_catalog_document_ax_user1`
        FOREIGN KEY (`user_id`)
            REFERENCES `a_shop`.`ax_user` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_document_ax_currency1`
        FOREIGN KEY (`currency_id`)
            REFERENCES `a_shop`.`ax_currency` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_document_ax_catalog_document_subject1`
        FOREIGN KEY (`catalog_document_subject_id`)
            REFERENCES `a_shop`.`ax_catalog_document_subject` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_document_ax_ips1`
        FOREIGN KEY (`ips_id`)
            REFERENCES `a_shop`.`ax_ips` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;


DROP TABLE IF EXISTS `a_shop`.`ax_catalog_document_content`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_document_content`
(
    `id`                  BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `catalog_document_id` BIGINT(20) UNSIGNED NOT NULL,
    `catalog_product_id`  BIGINT(20) UNSIGNED NOT NULL,
    `catalog_storage_id`  BIGINT(20) UNSIGNED NULL,
    `price_in`            DECIMAL UNSIGNED    NULL DEFAULT 0.0,
    `price_out`           DECIMAL UNSIGNED    NULL DEFAULT 0.0,
    `quantity`            INT(11) UNSIGNED    NULL DEFAULT 1,
    `description`         VARCHAR(255)        NULL,
    `created_at`          INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`          INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`          INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `catalog_document_id`, `catalog_product_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_document_content_ax_catalog_document1_idx` (`catalog_document_id` ASC),
    INDEX `fk_ax_document_content_ax_catalog_product1_idx` (`catalog_product_id` ASC),
    INDEX `fk_ax_catalog_document_content_ax_catalog_storage1_idx` (`catalog_storage_id` ASC),
    CONSTRAINT `fk_ax_document_content_ax_catalog_document1`
        FOREIGN KEY (`catalog_document_id`)
            REFERENCES `a_shop`.`ax_catalog_document` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_document_content_ax_catalog_product1`
        FOREIGN KEY (`catalog_product_id`)
            REFERENCES `a_shop`.`ax_catalog_product` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_document_content_ax_catalog_storage1`
        FOREIGN KEY (`catalog_storage_id`)
            REFERENCES `a_shop`.`ax_catalog_storage` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_coupon`;
DROP TABLE IF EXISTS `a_shop`.`ax_catalog_coupon`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_coupon`
(
    `id`          BIGINT(20) UNSIGNED  NOT NULL AUTO_INCREMENT,
    `resource`    VARCHAR(255)         NULL,
    `resource_id` BIGINT(20) UNSIGNED  NULL,
    `value`       VARCHAR(255)         NOT NULL,
    `discount`    SMALLINT(3) UNSIGNED NOT NULL DEFAULT 10,
    `status`      SMALLINT(2) UNSIGNED NULL     DEFAULT 0,
    `image`       VARCHAR(255)         NULL     DEFAULT NULL,
    `expired_at`  INT(11) UNSIGNED     NULL     DEFAULT NULL,
    `created_at`  INT(11) UNSIGNED     NULL     DEFAULT NULL,
    `updated_at`  INT(11) UNSIGNED     NULL     DEFAULT NULL,
    `deleted_at`  INT(11) UNSIGNED     NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    UNIQUE INDEX `value_UNIQUE` (`value` ASC)
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_address`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_address`
(
    `id`          BIGINT(20) UNSIGNED  NOT NULL AUTO_INCREMENT,
    `resource`    VARCHAR(255)         NOT NULL,
    `resource_id` BIGINT(20) UNSIGNED  NOT NULL,
    `type`        SMALLINT(3) UNSIGNED NOT NULL,
    `is_delivery` TINYINT(1) UNSIGNED  NULL DEFAULT 0,
    `index`       INT(11)              NULL,
    `country`     VARCHAR(255)         NULL,
    `region`      VARCHAR(255)         NULL,
    `city`        VARCHAR(255)         NULL,
    `street`      VARCHAR(255)         NULL,
    `house`       VARCHAR(255)         NULL,
    `apartment`   VARCHAR(255)         NULL,
    `description` TEXT                 NULL DEFAULT NULL,
    `image`       VARCHAR(255)         NULL DEFAULT NULL,
    `created_at`  INT(11) UNSIGNED     NULL DEFAULT NULL,
    `updated_at`  INT(11) UNSIGNED     NULL DEFAULT NULL,
    `deleted_at`  INT(11) UNSIGNED     NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `resource`, `resource_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_catalog_basket`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_basket`
(
    `id`                 BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`            BIGINT(20) UNSIGNED NOT NULL,
    `catalog_product_id` BIGINT(20) UNSIGNED NOT NULL,
    `catalog_order_id`   BIGINT(20) UNSIGNED NULL,
    `currency_id`        BIGINT(20) UNSIGNED NULL,
    `ips_id`             BIGINT(20) UNSIGNED NULL,
    `quantity`           INT(11)             NULL,
    `status`             TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `created_at`         INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`         INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`         INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `user_id`, `catalog_product_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_catalog_basket_ax_user1_idx` (`user_id` ASC),
    INDEX `fk_ax_catalog_basket_ax_ips1_idx` (`ips_id` ASC),
    INDEX `fk_ax_catalog_basket_ax_currency1_idx` (`currency_id` ASC),
    INDEX `fk_ax_catalog_basket_ax_catalog_product1_idx` (`catalog_product_id` ASC),
    INDEX `fk_ax_catalog_basket_ax_catalog_order1_idx` (`catalog_order_id` ASC),
    CONSTRAINT `fk_ax_catalog_basket_ax_user1`
        FOREIGN KEY (`user_id`)
            REFERENCES `a_shop`.`ax_user` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_basket_ax_ips1`
        FOREIGN KEY (`ips_id`)
            REFERENCES `a_shop`.`ax_ips` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_basket_ax_currency1`
        FOREIGN KEY (`currency_id`)
            REFERENCES `a_shop`.`ax_currency` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_basket_ax_catalog_product1`
        FOREIGN KEY (`catalog_product_id`)
            REFERENCES `a_shop`.`ax_catalog_product` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_basket_ax_catalog_order1`
        FOREIGN KEY (`catalog_order_id`)
            REFERENCES `a_shop`.`ax_catalog_order` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_catalog_order`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_order`
(
    `id`                       BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`                  BIGINT(20) UNSIGNED NOT NULL,
    `catalog_payment_type_id`  BIGINT(20) UNSIGNED NOT NULL,
    `catalog_delivery_type_id` BIGINT(20) UNSIGNED NOT NULL,
    `catalog_document_id`      BIGINT(20) UNSIGNED NULL,
    `ips_id`                   BIGINT(20) UNSIGNED NULL,
    `status`                   TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `created_at`               INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`               INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`               INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `user_id`, `catalog_payment_type_id`, `catalog_delivery_type_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_catalog_order_ax_catalog_payment_type1_idx` (`catalog_payment_type_id` ASC),
    INDEX `fk_ax_catalog_order_ax_catalog_delivery_type1_idx` (`catalog_delivery_type_id` ASC),
    INDEX `fk_ax_catalog_order_ax_catalog_document1_idx` (`catalog_document_id` ASC),
    INDEX `fk_ax_catalog_order_ax_user1_idx` (`user_id` ASC),
    INDEX `fk_ax_catalog_order_ax_ips1_idx` (`ips_id` ASC),
    CONSTRAINT `fk_ax_catalog_order_ax_catalog_payment_type1`
        FOREIGN KEY (`catalog_payment_type_id`)
            REFERENCES `a_shop`.`ax_catalog_payment_type` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_order_ax_catalog_delivery_type1`
        FOREIGN KEY (`catalog_delivery_type_id`)
            REFERENCES `a_shop`.`ax_catalog_delivery_type` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_order_ax_catalog_document1`
        FOREIGN KEY (`catalog_document_id`)
            REFERENCES `a_shop`.`ax_catalog_document` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_order_ax_user1`
        FOREIGN KEY (`user_id`)
            REFERENCES `a_shop`.`ax_user` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_order_ax_ips1`
        FOREIGN KEY (`ips_id`)
            REFERENCES `a_shop`.`ax_ips` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_favorites`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_favorites`
(
    `id`          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `resource`    VARCHAR(255)        NOT NULL,
    `resource_id` BIGINT(20) UNSIGNED NOT NULL,
    `description` TEXT                NULL DEFAULT NULL,
    `created_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `resource`, `resource_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
    ENGINE = InnoDB;


