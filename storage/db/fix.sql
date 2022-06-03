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
            REFERENCES `a_shop`.`ax_main_ips` (`id`)
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

DROP TABLE IF EXISTS `a_shop`.`ax_post_category`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_post_category`
(
    `id`                  BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `category_id`         BIGINT(20) UNSIGNED NULL,
    `render_id`           BIGINT(20) UNSIGNED NULL,
    `is_published`        TINYINT(1) UNSIGNED NULL DEFAULT 1,
    `is_favourites`       TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `is_watermark`        TINYINT(1)          NULL DEFAULT 1,
    `image`               VARCHAR(255)        NULL DEFAULT NULL,
    `show_image`          TINYINT(1)          NULL DEFAULT 1,
    `url`                 VARCHAR(500)        NOT NULL,
    `alias`               VARCHAR(255)        NOT NULL,
    `title`               VARCHAR(255)        NOT NULL,
    `title_short`         VARCHAR(150)        NULL DEFAULT NULL,
    `description`         TEXT                NULL DEFAULT NULL,
    `preview_description` TEXT                NULL,
    `sort`                TINYINT(3) UNSIGNED NULL DEFAULT 0,
    `created_at`          INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`          INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`          INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    UNIQUE INDEX `alias_UNIQUE` (`alias` ASC),
    INDEX `fk_ax_post_category_ax_render1_idx` (`render_id` ASC),
    UNIQUE INDEX `url_UNIQUE` (`url` ASC),
    INDEX `fk_ax_post_category_ax_post_category1_idx` (`category_id` ASC),
    CONSTRAINT `fk_ax_post_category_ax_render1`
        FOREIGN KEY (`render_id`)
            REFERENCES `a_shop`.`ax_render` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_post_category_ax_post_category1`
        FOREIGN KEY (`category_id`)
            REFERENCES `a_shop`.`ax_post_category` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

DROP TABLE IF EXISTS `a_shop`.`ax_post`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_post`
(
    `id`                  BIGINT(20) UNSIGNED  NOT NULL AUTO_INCREMENT,
    `user_id`             BIGINT(20) UNSIGNED  NOT NULL,
    `render_id`           BIGINT(20) UNSIGNED  NULL,
    `category_id`         BIGINT(20) UNSIGNED  NULL,
    `is_published`        TINYINT(1) UNSIGNED  NULL DEFAULT 1,
    `is_favourites`       TINYINT(1) UNSIGNED  NULL DEFAULT 0,
    `is_comments`         TINYINT(1) UNSIGNED  NULL DEFAULT 0,
    `is_image_post`       TINYINT(1) UNSIGNED  NULL DEFAULT 1,
    `is_image_category`   TINYINT(1) UNSIGNED  NULL DEFAULT 1,
    `is_watermark`        TINYINT(1) UNSIGNED  NULL DEFAULT 1,
    `media`               VARCHAR(255)         NULL DEFAULT NULL,
    `url`                 VARCHAR(500)         NOT NULL,
    `alias`               VARCHAR(255)         NOT NULL,
    `title`               VARCHAR(255)         NOT NULL,
    `title_short`         VARCHAR(155)         NULL DEFAULT NULL,
    `preview_description` TEXT                 NULL DEFAULT NULL,
    `description`         TEXT                 NULL DEFAULT NULL,
    `show_date`           TINYINT(1)           NULL DEFAULT 1,
    `date_pub`            INT(11)              NULL DEFAULT 0,
    `date_end`            INT(11)              NULL DEFAULT 0,
    `control_date_pub`    TINYINT(1)           NULL DEFAULT 0,
    `control_date_end`    TINYINT(1)           NULL DEFAULT 0,
    `image`               VARCHAR(255)         NULL DEFAULT NULL,
    `hits`                INT(11) UNSIGNED     NULL DEFAULT 0,
    `sort`                INT(11)              NULL DEFAULT 0,
    `stars`               FLOAT(1, 1) UNSIGNED NULL DEFAULT '0.0',
    `created_at`          INT(11) UNSIGNED     NULL DEFAULT NULL,
    `updated_at`          INT(11) UNSIGNED     NULL DEFAULT NULL,
    `deleted_at`          INT(11) UNSIGNED     NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `user_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    UNIQUE INDEX `alias_UNIQUE` (`alias` ASC),
    INDEX `fk_ax_post_ax_user1_idx` (`user_id` ASC),
    INDEX `fk_ax_post_ax_render1_idx` (`render_id` ASC),
    INDEX `fk_ax_post_ax_post_category1_idx` (`category_id` ASC),
    UNIQUE INDEX `url_UNIQUE` (`url` ASC),
    CONSTRAINT `fk_ax_post_ax_user1`
        FOREIGN KEY (`user_id`)
            REFERENCES `a_shop`.`ax_user` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_post_ax_render1`
        FOREIGN KEY (`render_id`)
            REFERENCES `a_shop`.`ax_render` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_post_ax_post_category1`
        FOREIGN KEY (`category_id`)
            REFERENCES `a_shop`.`ax_post_category` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

DROP TABLE IF EXISTS `a_shop`.`ax_page`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_page`
(
    `id`            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`       BIGINT(20) UNSIGNED NOT NULL,
    `page_type_id`  BIGINT(20) UNSIGNED NOT NULL,
    `render_id`     BIGINT(20) UNSIGNED NULL,
    `is_published`  TINYINT(1) UNSIGNED NULL DEFAULT 1,
    `is_favourites` TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `is_comments`   TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `is_watermark`  TINYINT(1) UNSIGNED NULL DEFAULT 1,
    `url`           VARCHAR(500)        NOT NULL,
    `alias`         VARCHAR(255)        NOT NULL,
    `title`         VARCHAR(255)        NOT NULL,
    `title_short`   VARCHAR(155)        NULL DEFAULT NULL,
    `description`   TEXT                NULL DEFAULT NULL,
    `image`         VARCHAR(255)        NULL DEFAULT NULL,
    `media`         VARCHAR(255)        NULL DEFAULT NULL,
    `hits`          INT(11) UNSIGNED    NULL DEFAULT 0,
    `sort`          INT(11)             NULL DEFAULT 0,
    `created_at`    INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`    INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`    INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `user_id`, `page_type_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    UNIQUE INDEX `alias_UNIQUE` (`alias` ASC),
    INDEX `fk_ax_post_ax_user1_idx` (`user_id` ASC),
    INDEX `fk_ax_post_ax_render1_idx` (`render_id` ASC),
    UNIQUE INDEX `url_UNIQUE` (`url` ASC),
    INDEX `fk_ax_page_ax_page_type1_idx` (`page_type_id` ASC),
    CONSTRAINT `fk_ax_post_ax_user10`
        FOREIGN KEY (`user_id`)
            REFERENCES `a_shop`.`ax_user` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_post_ax_render10`
        FOREIGN KEY (`render_id`)
            REFERENCES `a_shop`.`ax_render` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_page_ax_page_type1`
        FOREIGN KEY (`page_type_id`)
            REFERENCES `a_shop`.`ax_page_type` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_catalog_category`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_category`
(
    `id`                  BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `category_id`         BIGINT(20) UNSIGNED NULL,
    `render_id`           BIGINT(20) UNSIGNED NULL,
    `is_published`        TINYINT(1) UNSIGNED NULL DEFAULT 1,
    `is_favourites`       TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `is_watermark`        TINYINT(1)          NULL DEFAULT 1,
    `image`               VARCHAR(255)        NULL DEFAULT NULL,
    `show_image`          TINYINT(1)          NULL DEFAULT 1,
    `url`                 VARCHAR(500)        NOT NULL,
    `alias`               VARCHAR(255)        NOT NULL,
    `title`               VARCHAR(255)        NOT NULL,
    `title_short`         VARCHAR(150)        NULL DEFAULT NULL,
    `description`         TEXT                NULL DEFAULT NULL,
    `preview_description` TEXT                NULL,
    `sort`                INT(11) UNSIGNED    NULL DEFAULT 0,
    `created_at`          INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`          INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`          INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_catalog_category_ax_catalog_category1_idx` (`category_id` ASC),
    UNIQUE INDEX `url_UNIQUE` (`url` ASC),
    UNIQUE INDEX `alias_UNIQUE` (`alias` ASC),
    INDEX `fk_ax_catalog_category_ax_render1_idx` (`render_id` ASC),
    CONSTRAINT `fk_ax_catalog_category_ax_catalog_category1`
        FOREIGN KEY (`category_id`)
            REFERENCES `a_shop`.`ax_catalog_category` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_category_ax_render1`
        FOREIGN KEY (`render_id`)
            REFERENCES `a_shop`.`ax_render` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_catalog_product`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_product`
(
    `id`                  BIGINT(20) UNSIGNED     NOT NULL AUTO_INCREMENT,
    `category_id`         BIGINT(20) UNSIGNED     NULL,
    `render_id`           BIGINT(20) UNSIGNED     NULL,
    `is_published`        TINYINT(1) UNSIGNED     NOT NULL DEFAULT 0,
    `is_favourites`       TINYINT(1) UNSIGNED     NULL     DEFAULT 0,
    `is_comments`         TINYINT(1) UNSIGNED     NULL     DEFAULT 0,
    `is_watermark`        TINYINT(1) UNSIGNED     NULL     DEFAULT 1,
    `is_single`           TINYINT(1) UNSIGNED     NULL     DEFAULT 0,
    `media`               VARCHAR(255)            NULL     DEFAULT NULL,
    `url`                 VARCHAR(500)            NOT NULL,
    `alias`               VARCHAR(255)            NOT NULL,
    `title`               VARCHAR(255)            NOT NULL,
    `price`               DECIMAL(10, 2)          NULL     DEFAULT 0.0,
    `title_short`         VARCHAR(155)            NULL     DEFAULT NULL,
    `preview_description` TEXT                    NULL     DEFAULT NULL,
    `description`         TEXT                    NULL     DEFAULT NULL,
    `show_date`           TINYINT(1)              NULL     DEFAULT 1,
    `image`               VARCHAR(255)            NULL     DEFAULT NULL,
    `hits`                INT(11) UNSIGNED        NULL     DEFAULT 0,
    `sort`                INT(11)                 NULL     DEFAULT 0,
    `stars`               DECIMAL(10, 2) UNSIGNED NULL     DEFAULT 0.0,
    `created_at`          INT(11) UNSIGNED        NULL     DEFAULT NULL,
    `updated_at`          INT(11) UNSIGNED        NULL     DEFAULT NULL,
    `deleted_at`          INT(11) UNSIGNED        NULL     DEFAULT NULL,
    UNIQUE INDEX `url_UNIQUE` (`url` ASC),
    UNIQUE INDEX `alias_UNIQUE` (`alias` ASC),
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_catalog_product_ax_render1_idx` (`render_id` ASC),
    INDEX `fk_ax_catalog_product_ax_catalog_category1_idx` (`category_id` ASC),
    CONSTRAINT `fk_ax_catalog_product_ax_render1`
        FOREIGN KEY (`render_id`)
            REFERENCES `a_shop`.`ax_render` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_product_ax_catalog_category1`
        FOREIGN KEY (`category_id`)
            REFERENCES `a_shop`.`ax_catalog_category` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

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

DROP TABLE IF EXISTS `a_shop`.`ax_catalog_storage_reserve`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_storage_reserve`
(
    `id`                       BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `catalog_product_id`       BIGINT(20) UNSIGNED NOT NULL,
    `catalog_document_id`      BIGINT(20) UNSIGNED NOT NULL,
    `catalog_storage_place_id` BIGINT(20) UNSIGNED NOT NULL,
    `status`                   TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `in_reserve`               INT UNSIGNED        NULL DEFAULT 0,
    `expired_at`               INT(11) UNSIGNED    NULL,
    `created_at`               INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`               INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`               INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `catalog_product_id`, `catalog_document_id`, `catalog_storage_place_id`),
    INDEX `fk_ax_catalog_storage_ax_catalog_product1_idx` (`catalog_product_id` ASC),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_catalog_storage_reserve_ax_catalog_storage_place1_idx` (`catalog_storage_place_id` ASC),
    INDEX `fk_ax_catalog_storage_reserve_ax_catalog_document1_idx` (`catalog_document_id` ASC),
    CONSTRAINT `fk_ax_catalog_storage_ax_catalog_product10`
        FOREIGN KEY (`catalog_product_id`)
            REFERENCES `a_shop`.`ax_catalog_product` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_storage_reserve_ax_catalog_storage_place1`
        FOREIGN KEY (`catalog_storage_place_id`)
            REFERENCES `a_shop`.`ax_catalog_storage_place` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_storage_reserve_ax_catalog_document1`
        FOREIGN KEY (`catalog_document_id`)
            REFERENCES `a_shop`.`ax_catalog_document` (`id`)
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
    `catalog_document_id`         BIGINT(20) UNSIGNED NULL DEFAULT NULL,
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
    INDEX `fk_ax_catalog_document_ax_catalog_document1_idx` (`catalog_document_id` ASC),
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
            REFERENCES `a_shop`.`ax_main_ips` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_document_ax_catalog_document1`
        FOREIGN KEY (`catalog_document_id`)
            REFERENCES `a_shop`.`ax_catalog_document` (`id`)
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

DROP TABLE IF EXISTS `a_shop`.`ax_catalog_order`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_catalog_order`
(
    `id`                          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid`                        VARCHAR(100)        NOT NULL,
    `user_id`                     BIGINT(20) UNSIGNED NOT NULL,
    `catalog_payment_type_id`     BIGINT(20) UNSIGNED NOT NULL,
    `catalog_delivery_type_id`    BIGINT(20) UNSIGNED NOT NULL,
    `catalog_sale_document_id`    BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `catalog_reserve_document_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `payment_order_id`            VARCHAR(100)        NULL DEFAULT NULL,
    `ips_id`                      BIGINT(20) UNSIGNED NULL DEFAULT NULL,
    `status`                      TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `created_at`                  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`                  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`                  INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `user_id`, `catalog_payment_type_id`, `catalog_delivery_type_id`, `uuid`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_catalog_order_ax_catalog_payment_type1_idx` (`catalog_payment_type_id` ASC),
    INDEX `fk_ax_catalog_order_ax_catalog_delivery_type1_idx` (`catalog_delivery_type_id` ASC),
    INDEX `fk_ax_catalog_order_ax_catalog_document1_idx` (`catalog_sale_document_id` ASC),
    INDEX `fk_ax_catalog_order_ax_user1_idx` (`user_id` ASC),
    INDEX `fk_ax_catalog_order_ax_ips1_idx` (`ips_id` ASC),
    INDEX `fk_ax_catalog_order_ax_catalog_document2_idx` (`catalog_reserve_document_id` ASC),
    UNIQUE INDEX `uuid_UNIQUE` (`uuid` ASC),
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
        FOREIGN KEY (`catalog_sale_document_id`)
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
            REFERENCES `a_shop`.`ax_main_ips` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_catalog_order_ax_catalog_document2`
        FOREIGN KEY (`catalog_reserve_document_id`)
            REFERENCES `a_shop`.`ax_catalog_document` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_main_seo`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_seo`
(
    `id`          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `resource`    VARCHAR(255)        NOT NULL,
    `resource_id` BIGINT(20) UNSIGNED NOT NULL,
    `title`       VARCHAR(255)        NULL DEFAULT NULL,
    `description` VARCHAR(255)        NULL DEFAULT NULL,
    `created_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `resource`, `resource_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_main_page_settings`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_page_settings`
(
    `id`          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `resource`    VARCHAR(255)        NOT NULL,
    `resource_id` BIGINT(20) UNSIGNED NOT NULL,
    `script`      LONGTEXT            NULL,
    `css`         LONGTEXT            NULL,
    `created_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `resource`, `resource_id`)
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_favorites`;
DROP TABLE IF EXISTS `a_shop`.`ax_main_favorites`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_favorites`
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

DROP TABLE IF EXISTS `a_shop`.`ax_settings`;
DROP TABLE IF EXISTS `a_shop`.`ax_main_settings`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_settings`
(
    `id`                   BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `currency_update_rate` INT(11)             NULL,
    `script`               LONGTEXT            NULL,
    `css`                  LONGTEXT            NULL,
    `robots`               TEXT                NULL,
    `google_verification`  VARCHAR(255)        NULL,
    `yandex_verification`  VARCHAR(255)        NULL,
    `yandex_metrika`       TEXT                NULL,
    `google_analytics`     TEXT                NULL,
    `logo_general`         VARCHAR(255)        NULL,
    `logo_second`          VARCHAR(255)        NULL,
    `company_name`         VARCHAR(255)        NULL,
    `company_name_full`    VARCHAR(500)        NULL,
    `company_phone`        VARCHAR(255)        NULL,
    `company_email`        VARCHAR(500)        NULL,
    `company_address`      VARCHAR(500)        NULL,
    `redirect_on`          TINYINT(1) UNSIGNED NULL DEFAULT 1,
    `created_at`           INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`           INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`           INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_redirect`;
DROP TABLE IF EXISTS `a_shop`.`ax_main_redirect`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_redirect`
(
    `id`         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `url`        VARCHAR(500)        NOT NULL,
    `url_old`    VARCHAR(500)        NOT NULL,
    `created_at` INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at` INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at` INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_address`;
DROP TABLE IF EXISTS `a_shop`.`ax_main_address`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_address`
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

DROP TABLE IF EXISTS `a_shop`.`ax_migrations`;
DROP TABLE IF EXISTS `a_shop`.`ax_main_migrations`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_migrations`
(
    `id`        BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255)        NOT NULL,
    `batch`     INT(11)             NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC)
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_letters`;
DROP TABLE IF EXISTS `a_shop`.`ax_main_letters`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_letters`
(
    `id`          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `resource`    VARCHAR(255)        NOT NULL,
    `resource_id` BIGINT(20) UNSIGNED NOT NULL,
    `person`      VARCHAR(255)        NOT NULL,
    `person_id`   BIGINT(20)          NOT NULL,
    `ips_id`      BIGINT(20) UNSIGNED NULL,
    `subject`     VARCHAR(255)        NULL,
    `text`        TEXT                NULL,
    `is_viewed`   TINYINT(1)          NULL DEFAULT 0,
    `created_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `resource`, `resource_id`, `person`, `person_id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_letters_ax_ips1_idx` (`ips_id` ASC),
    CONSTRAINT `fk_ax_letters_ax_ips1`
        FOREIGN KEY (`ips_id`)
            REFERENCES `a_shop`.`ax_main_ips` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_ips`;
DROP TABLE IF EXISTS `a_shop`.`ax_main_ips`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_ips`
(
    `id`         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `ip`         VARCHAR(255)        NOT NULL,
    `status`     TINYINT(1)          NULL DEFAULT 1,
    `created_at` INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at` INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at` INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    UNIQUE INDEX `ip_UNIQUE` (`ip` ASC)
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_ips_has_resource`;
DROP TABLE IF EXISTS `a_shop`.`ax_main_ips_has_resource`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_main_ips_has_resource`
(
    `ips_id`      BIGINT(20) UNSIGNED NOT NULL,
    `resource`    VARCHAR(255)        NOT NULL,
    `resource_id` BIGINT(20) UNSIGNED NOT NULL,
    PRIMARY KEY (`ips_id`, `resource`, `resource_id`),
    INDEX `fk_ax_ips_has_ax_visitors_ax_ips1_idx` (`ips_id` ASC),
    CONSTRAINT `fk_ax_ips_has_ax_visitors_ax_ips1`
        FOREIGN KEY (`ips_id`)
            REFERENCES `a_shop`.`ax_main_ips` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_comments`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_comments`
(
    `id`          BIGINT(20) UNSIGNED NOT NULL,
    `resource`    VARCHAR(255)        NOT NULL,
    `resource_id` BIGINT(20) UNSIGNED NOT NULL,
    `person`      VARCHAR(255)        NOT NULL,
    `person_id`   BIGINT(20)          NOT NULL,
    `comments_id` BIGINT(20) UNSIGNED NULL,
    `ips_id`      BIGINT(20) UNSIGNED NULL,
    `status`      TINYINT(1) UNSIGNED NULL DEFAULT 0,
    `is_viewed`   TINYINT(1)          NULL DEFAULT 0,
    `text`        TEXT                NOT NULL,
    `created_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `updated_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    `deleted_at`  INT(11) UNSIGNED    NULL DEFAULT NULL,
    PRIMARY KEY (`id`, `resource`, `resource_id`, `person_id`, `person`),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    INDEX `fk_ax_post_comments_ax_post_comments1_idx` (`comments_id` ASC),
    INDEX `fk_ax_post_comments_ax_ips1_idx` (`ips_id` ASC),
    CONSTRAINT `fk_ax_post_comments_ax_post_comments1`
        FOREIGN KEY (`comments_id`)
            REFERENCES `a_shop`.`ax_comments` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT `fk_ax_post_comments_ax_ips1`
        FOREIGN KEY (`ips_id`)
            REFERENCES `a_shop`.`ax_main_ips` (`id`)
            ON DELETE CASCADE
            ON UPDATE CASCADE
)
    ENGINE = InnoDB;

DROP TABLE IF EXISTS `a_shop`.`ax_user`;
CREATE TABLE IF NOT EXISTS `a_shop`.`ax_user`
(
    `id`                   BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name`           VARCHAR(255)        NOT NULL DEFAULT 'Undefined',
    `last_name`            VARCHAR(255)        NOT NULL DEFAULT 'Undefined',
    `patronymic`           VARCHAR(255)        NULL     DEFAULT NULL,
    `phone`                VARCHAR(255)        NULL,
    `email`                VARCHAR(255)        NULL,
    `is_email`             TINYINT(1) UNSIGNED NULL     DEFAULT 0,
    `is_phone`             TINYINT(1) UNSIGNED NULL     DEFAULT 0,
    `status`               SMALLINT(6)         NOT NULL DEFAULT 0,
    `password_hash`        VARCHAR(255)        NOT NULL,
    `remember_token`       VARCHAR(500)        NULL     DEFAULT NULL,
    `auth_key`             VARCHAR(32)         NULL     DEFAULT NULL,
    `password_reset_token` VARCHAR(255)        NULL     DEFAULT NULL,
    `created_at`           INT(11) UNSIGNED    NULL     DEFAULT NULL,
    `updated_at`           INT(11) UNSIGNED    NULL     DEFAULT NULL,
    `deleted_at`           INT(11) UNSIGNED    NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `email` (`email` ASC),
    UNIQUE INDEX `password_reset_token` (`password_reset_token` ASC),
    UNIQUE INDEX `id_UNIQUE` (`id` ASC),
    UNIQUE INDEX `phone_UNIQUE` (`phone` ASC)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

START TRANSACTION;
USE `a_shop`;
INSERT INTO `a_shop`.`ax_user` (`id`, `first_name`, `last_name`, `patronymic`, `phone`, `email`, `is_email`, `is_phone`,
                                `status`, `password_hash`, `remember_token`, `auth_key`, `password_reset_token`,
                                `created_at`, `updated_at`, `deleted_at`)
VALUES (6, 'Алексей', 'Алексеев', 'Александрович', '79621829550', 'axlle@mail.ru', 0, 0, 8,
        '$2y$13$DMqEjJJL9gjftb80gCt5n.fOTyoTfAEv/HsQPh2IEQa42bfNsfF5S', 'kyyBBbb80b3ZflMDdsynKC0B4skxf_gF',
        'kyyBBbb80b3ZflMDdsynKC0B4skxf', NULL, 1651608268, NULL, NULL);

COMMIT;
