/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50739 (5.7.39)
 Source Host           : localhost:3306
 Source Schema         : a_shop

 Target Server Type    : MySQL
 Target Server Version : 50799
 File Encoding         : 65001

 Date: 22/02/2023 20:53:18
*/

SET NAMES utf8;
SET
FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Records of ax_catalog_basket
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_basket` (`id`, `user_id`, `catalog_product_id`, `document_order_id`, `currency_id`, `quantity`,
                                 `status`, `created_at`, `updated_at`, `deleted_at`)
VALUES (8, 11, 44, 5, NULL, 1, 1, 1657608927, 1657608930, NULL),
       (12, 6, 77, 6, NULL, 1, 1, 1664610894, 1664612863, NULL),
       (16, 20, 72, 7, NULL, 1, 1, 1666448303, 1666448335, NULL),
       (17, 6, 104, NULL, NULL, 1, 2, 1670000549, 1670000549, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_category
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_category` (`id`, `category_id`, `render_id`, `is_published`, `is_favourites`, `is_watermark`,
                                   `image`, `show_image`, `title`, `title_short`, `description`, `preview_description`,
                                   `sort`, `created_at`, `updated_at`, `deleted_at`, `alias`, `url`)
VALUES (2, NULL, NULL, 0, 0, 0, NULL, 0, 'Разделочные | Сервировочные доски', NULL, NULL, NULL, NULL, 1651611600,
        1651653211, NULL, 'razdelochnye-servirovochnye-doski', 'razdelochnye-servirovochnye-doski'),
       (3, NULL, NULL, 0, 0, 0, NULL, 0, 'доска \"Камень\"', NULL, NULL, NULL, NULL, 1651611600, 1651653234, NULL,
        'doska-kamen', 'doska-kamen'),
       (4, NULL, NULL, 0, 0, 0, NULL, 0, 'Торцевые доски', NULL, NULL, NULL, NULL, 1651611600, 1651653255, NULL,
        'torcevye-doski', 'torcevye-doski'),
       (5, NULL, NULL, 0, 0, 0, NULL, 0, 'Подносы', NULL, NULL, NULL, NULL, 1651611600, 1651653276, NULL, 'podnosy',
        'podnosy'),
       (6, NULL, NULL, 0, 0, 0, NULL, 0, 'Подставка для телефона', NULL, NULL, NULL, NULL, 1651611600, 1651653306, NULL,
        'podstavka-dlya-telefona', 'podstavka-dlya-telefona'),
       (7, NULL, NULL, 0, 0, 0, NULL, 0, 'Сопутствующие товары', NULL, NULL, NULL, NULL, 1651611600, 1651653413, NULL,
        'soputstvuyushie-tovary', 'soputstvuyushie-tovary');
COMMIT;

-- ----------------------------
-- Records of ax_catalog_coupon
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_delivery_status
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_delivery_status` (`id`, `title`, `key`, `description`, `image`, `sort`, `created_at`,
                                          `updated_at`, `deleted_at`)
VALUES (1, 'В обработке', 'in_processing', NULL, NULL, 100, 1656279103, 1656279103, NULL),
       (2, 'Доставляется', 'is_delivered', NULL, NULL, 100, 1656279103, 1656279103, NULL),
       (3, 'Доставлен', 'delivered', NULL, NULL, 100, 1656279103, 1656279103, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_delivery_type
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_delivery_type` (`id`, `is_active`, `title`, `alias`, `cost`, `description`, `image`, `sort`,
                                        `created_at`, `updated_at`, `deleted_at`)
VALUES (1, 1, 'Служба доставки СДЭК', 'sluzhba-dostavki-sdek', 350, NULL, NULL, 100, 1651608269, 1656279103, NULL),
       (2, 1, 'Курьером по г.Краснодару', 'kurerom-po-g-krasnodaru', 350, NULL, NULL, 100, 1651608269, 1656279103,
        NULL),
       (3, 1, 'Почта Россия', 'pochta-rossiya', 350, NULL, NULL, 100, 1651608269, 1656279103, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_payment_status
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_payment_status` (`id`, `title`, `key`, `description`, `image`, `sort`, `created_at`,
                                         `updated_at`, `deleted_at`)
VALUES (1, 'Оплачен', 'paid', NULL, NULL, 100, 1656279103, 1656279103, NULL),
       (2, 'Не оплачен', 'not_paid', NULL, NULL, 100, 1656279103, 1656279103, NULL),
       (3, 'В обработке', 'in_processing', NULL, NULL, 100, 1656279103, 1656279103, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_payment_type
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_payment_type` (`id`, `is_active`, `title`, `alias`, `description`, `image`, `sort`,
                                       `created_at`, `updated_at`, `deleted_at`)
VALUES (1, 1, 'Банковской картой', 'bankovskoj-kartoj', NULL, NULL, 100, 1651608269, 1651608269, NULL),
       (2, 0, 'Электронными деньгами', 'elektronnymi-dengami', NULL, NULL, 100, 1651608269, 1651608269, NULL),
       (3, 0, 'Переводом через интернет-банк', 'perevodom-cherez-internet-bank', NULL, NULL, 100, 1651608269,
        1651608269, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_product
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_product` (`id`, `category_id`, `render_id`, `is_published`, `is_favourites`, `is_comments`,
                                  `is_watermark`, `is_single`, `media`, `title`, `price`, `title_short`,
                                  `preview_description`, `description`, `show_date`, `image`, `hits`, `sort`, `stars`,
                                  `created_at`, `updated_at`, `deleted_at`, `alias`, `url`)
VALUES (2, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Закат ✶', 2000.00, NULL, NULL,
        '<p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 12pt; line-height: 107%; font-family: \" times=\"\" new=\"\" roman\",=\"\" serif;=\"\" background-image:=\"\" initial;=\"\" background-position:=\"\" background-size:=\"\" background-repeat:=\"\" background-attachment:=\"\" background-origin:=\"\" background-clip:=\"\" initial;\"=\"\">На кухне мы ежедневно используем посуду, доски и другие предметы. <o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 12pt; line-height: 107%; font-family: \" times=\"\" new=\"\" roman\",=\"\" serif;=\"\" background-image:=\"\" initial;=\"\" background-position:=\"\" background-size:=\"\" background-repeat:=\"\" background-attachment:=\"\" background-origin:=\"\" background-clip:=\"\" initial;\"=\"\">В основном мы готовим на них, еще на досках мы можем подавать любые нарезки, брускетты, фрукты, закуски.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 12pt; line-height: 107%; font-family: \" times=\"\" new=\"\" roman\",=\"\" serif;=\"\" background-image:=\"\" initial;=\"\" background-position:=\"\" background-size:=\"\" background-repeat:=\"\" background-attachment:=\"\" background-origin:=\"\" background-clip:=\"\" initial;\"=\"\">Эта доска выполнена из прекрасного дерева Абрикос и что бы вы на ней не подали, все будет выглядеть шикарно, как (в уютном ресторане).<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 12pt; line-height: 107%; font-family: \" times=\"\" new=\"\" roman\",=\"\" serif;=\"\" background-image:=\"\" initial;=\"\" background-position:=\"\" background-size:=\"\" background-repeat:=\"\" background-attachment:=\"\" background-origin:=\"\" background-clip:=\"\" initial;\"=\"\">Друзья оценят такую подачу.<o:p></o:p></span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 12pt; line-height: 107%; font-family: \" times=\"\" new=\"\" roman\",=\"\" serif;=\"\" background-image:=\"\" initial;=\"\" background-position:=\"\" background-size:=\"\" background-repeat:=\"\" background-attachment:=\"\" background-origin:=\"\" background-clip:=\"\" initial;\"=\"\">Согласитесь, куда приятнее кушать красиво ведь это задает определенную атмосферу.</span><span style=\"font-size:12.0pt;line-height:107%;font-family:\" times=\"\" new=\"\" roman\",serif\"=\"\"><br> <br> <span style=\"background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Создавая такие вещи, с умилением думаю как вы будете радоваться и рассказывать своим друзьям и близким как ее нашли, как в нее влюбились и теперь она ваша, и такая только у вас. <o:p></o:p></span></span></p><p><br></p>',
        1, '/upload/ax_catalog_product/zakat/I4M5AzlzUdEhSJM1zEVRyp0v0mJNPJogSPFIUVvp.jpeg', 0, 1, 0.00, 1651785420,
        1656279103, NULL, 'zakat', 'zakat'),
       (3, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Розмарин ✶', 1100.00, NULL, NULL,
        '<p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">У Вас на кухне тоже есть доски разного калибра?</span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">У меня, да.</span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">Иногда, чтоб отрезать что-то небольшое, кусочек сыра, зелень нарезать или лимончик к чаю, совсем не хочется брать большую доску.</span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">Именно для этих целей и делаю таких малышек. </span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><br></p>',
        1, '/upload/ax_catalog_product/rozmarin/LRdZmXFINVIPEINGeRVN5EH7fdqOSTcoJr1fkakF.jpeg', 0, 3, 0.00, 1651785360,
        1656279103, NULL, 'rozmarin', 'rozmarin'),
       (4, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Круассан ✶', 1800.00, NULL, NULL,
        '<h6 style=\"margin-left:-7.1pt\">Утро, вы выходите на террасу или балкон, у вас на доске стоит чашечка ароматного кофе и рядом пристроился круассан или бутерброд. </h6><h6 style=\"margin-left:-7.1pt\">Отличное начало дня, как встретишь утро так и проведешь день. </h6><h6 style=\"margin-left:-7.1pt\">Такая доска удобна как нарезки, так и для подачи.</h6><p style=\"margin-left: -7.1pt;\"><br></p>',
        1, '/upload/ax_catalog_product/kruassan/t1jUF8NpGuvCAmXgIJj0fVntf45wCZ8hp3G0BpTz.jpeg', 0, 6, 0.00, 1651784760,
        1656279103, NULL, 'kruassan', 'kruassan'),
       (5, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Артишок ✶', 2000.00, NULL, NULL,
        '<p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">Режем все и много.</span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">Один из удобных размеров для работы на кухне.</span></p>',
        1, '/upload/ax_catalog_product/artishok/Y1URWayGpmI4z7kR7Q9Jfgahbvy2IwMoTVo48N79.jpeg', 0, 6, 0.00, 1651785120,
        1656279103, NULL, 'artishok', 'artishok'),
       (6, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Морковь ✶', 2000.00, NULL, NULL,
        '<p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">Все готовим и режем.</span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">А еще и подаем красиво.</span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">На одной стороне режем, другую оставляем без порезов для красивой подачи.</span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><br></p>',
        1, '/upload/ax_catalog_product/morkov/sY4zEEhOmWFgk8cTkoQXQoXBP9oNF4hKpwtIriF5.jpeg', 0, 7, 0.00, 1651786080,
        1656279103, NULL, 'morkov', 'morkov'),
       (7, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Сыр ✶', 2200.00, NULL, NULL,
        '<p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">Когда места надо много. </span></p><p class=\"MsoNormal\" style=\"margin-left:-7.1pt\"><span style=\"font-size: 16px;\">Режем большой сыр. </span></p>',
        1, '/upload/ax_catalog_product/syr/HFlK4SUANdyRRFtEa6hVHZQlW32vXqUQzJgGVZJ4.jpeg', 0, 12, 0.00, 1651784940,
        1656279103, NULL, 'syr', 'syr'),
       (8, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Воробушек ✶', 2500.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Когда хочется необычного на кухне. Например доску нетрадиционного вида.</span></p><p><span style=\"font-size: 16px;\"> Доска создавалась как для нарезки, так и для интересной сервировки. </span></p><p><span style=\"font-size: 16px;\">Мне нравится такая форма доски, доска \"камушек\". </span></p><p><span style=\"font-size: 16px;\">Поверьте, она удивит ваших гостей. </span></p>',
        1, '/upload/ax_catalog_product/vorobushek/iz9EGYTYvTpEW0zFY7M1JjbLFD4K4OFqSKmlteRq.jpeg', 0, 8, 0.00,
        1651784880, 1656279103, NULL, 'vorobushek', 'vorobushek'),
       (9, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Форель ✶', 2800.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Вы тоже используете для каждых продуктов свою доску?</span></p><p><span style=\"font-size: 16px;\">Это правильно и удобно.</span></p>',
        1, '/upload/ax_catalog_product/forel/M0CR8f6T8xlLuBJpz7eyco5JTVoR6cawebs3ZmOJ.jpeg', 0, 9, 0.00, 1651785720,
        1656279103, NULL, 'forel', 'forel'),
       (10, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Штопор ✶', 2300.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Идеальный намёк на чудесный вечер.</span></p>', 1,
        '/upload/ax_catalog_product/shtopor/3kjaLFGThRo7azz2oSutNqUlatUnvlr2elROpTUa.jpeg', 0, 11, 0.00, 1651785900,
        1656279103, NULL, 'shtopor', 'shtopor'),
       (11, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Папоротник ✶', 1500.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Готовим вкусно, подаем красиво.</span></p>', 1,
        '/upload/ax_catalog_product/paporotnik/DJiOIvhybxRTee79lp5j914jUfb2ai4dMCXNFXAy.jpeg', 0, 2, 0.00, 1651784700,
        1656279103, NULL, 'paporotnik', 'paporotnik'),
       (12, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Глаз зебры ✶', 1600.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Интересная получилась доска. </span></p><p><span style=\"font-size: 16px;\">Годовые кольца дерева затушевала пирографом, подчеркнула природную красоту и вуаля. </span></p><p><span style=\"font-size: 16px;\">Идеальна для подачи. </span></p><p><span style=\"font-size: 16px;\">Помним, что одну сторону используем для нарезки, другую для подачи.</span></p><p><br></p>',
        1, '/upload/ax_catalog_product/glaz-zebry/MII1UI6mHTDd1oEoS827cFoJF8KSd7X0u0DXLaV7.jpeg', 0, 5, 0.00,
        1651784640, 1656279103, NULL, 'glaz-zebry', 'glaz-zebry'),
       (13, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Морская Звезда ✶', 1100.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Звёздочка, доска-малышка будет прекрасным напоминанием и лете и море. </span></p><p><br></p><p><br></p>',
        1, '/upload/ax_catalog_product/morskaya-zvezda/i2uYlN5T2j0pAm2d7VGhXxHhm5tIDzZtEVHKmLcW.jpeg', 0, NULL, 0.00,
        1651787520, 1656279103, NULL, 'morskaya-zvezda', 'morskaya-zvezda'),
       (14, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Солнышко ✶', 1200.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Для любителей досок потолще. </span></p><p><span style=\"font-size: 16px;\">Небольшая но толстенькая доска прекрасно приживется у вас на кухне. </span></p><p><span style=\"font-size: 16px;\">А солнышко всегда будут радовать и наполнять ваш стол лучиками света и тепла. </span></p>',
        1, '/upload/ax_catalog_product/solnce/nPmsGwtsUM9CJZellFeISOmWiZpo6tNvTs4yw2Pe.jpeg', 0, NULL, 0.00, 1651784580,
        1656279103, NULL, 'solnce', 'solnce'),
       (15, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Бамбук ✶', 1000.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Небольшие доски прекрасные помощницы на кухне.</span></p><p><span style=\"font-size: 16px;\">У досочки неповторимая текстура и прекрасный рисунок. </span></p><p><span style=\"font-size: 16px;\">Мы же помним, на одной стороне режим, на другой подаем. </span></p><p><br></p>',
        1, '/upload/ax_catalog_product/bambuk/7G60T1lkNIn2Ncel5ddOv3ANtkS1jJqaTvFDtUaN.jpeg', 0, NULL, 0.00, 1651784520,
        1656279103, NULL, 'bambuk', 'bambuk'),
       (16, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Солнце ✶', 1200.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска Солнце, небольшая, лёгкая, удобная для повседневной работы и подачи.</span><br></p>',
        1, '/upload/ax_catalog_product/solnce-1/trjbrIit2qcSB5VGTZ1Ght1N49Lx5k3LnHkmLNKB.jpeg', 0, NULL, 0.00,
        1651785600, 1656279103, NULL, 'solnce-1', 'solnce-1'),
       (17, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Луна ✶', 1200.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска Луна, небольшая, лёгкая, удобная для повседневной работы и подачи.</span><br></p>',
        1, '/upload/ax_catalog_product/luna/BHsXgprlPbEdLjVUz1Kxt7g7KyUjWMqmbVtk59xv.jpeg', 0, NULL, 0.00, 1651787160,
        1656279103, NULL, 'luna', 'luna'),
       (18, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Шоколадная Карамель ✶', 1200.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Есть доски красивы сами по себе, самодостаточны, не хочется дополнять их рисунком. </span></p><p><span style=\"font-size: 16px;\">Как эта, из яркого и фактурного ясеня.</span><br></p>',
        1, '/upload/ax_catalog_product/shokoladnaya-karamel/cf6oShTigUpraezMoAXESwefkeP1IayHG7xqIJx4.jpeg', 0, NULL,
        0.00, 1651784460, 1656279103, NULL, 'shokoladnaya-karamel', 'shokoladnaya-karamel'),
       (19, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лодочка ✶', 1200.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска Лодочка HARMONIE будет однозначно привлекать внимание на вашем столе с любой нарезкой.</span><br></p>',
        1, '/upload/ax_catalog_product/lodochka/O6Tpw32brf1I987nOzV55ITkW734vmGkOkNM07Q3.jpeg', 0, NULL, 0.00,
        1651786020, 1656279103, NULL, 'lodochka', 'lodochka'),
       (20, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лодочка ◉ ✶', 1200.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска Лодочка HARMONIE с небольшим сучком, будет однозначно привлекать внимание на вашем столе с любой нарезкой.</span><br></p>',
        1, '/upload/ax_catalog_product/lodochka-1/vQ9A0b7vvtFjV38zLVt0RKRNvN253jsLNyh4f0TG.jpeg', 0, NULL, 0.00,
        1651786740, 1656279103, NULL, 'lodochka-1', 'lodochka-1'),
       (21, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лодочка mini ◉ ✶', 600.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска Лодочка mini HARMONIE с маленьким сучком, будет помощницей на вашей кухне. </span></p><p><span style=\"font-size: 16px;\">Или прекрасно будет смотреться со свечой на вашем столе, создавая романтическое настроение.</span><br></p>',
        1, '/upload/ax_catalog_product/lodochka-mini/qil8sk5AIJPu3Ff53uZx7xlTG1WGZVUYXvgF65ex.jpeg', 0, NULL, 0.00,
        1651785660, 1656279103, NULL, 'lodochka-mini', 'lodochka-mini'),
       (22, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лодочка mini ✶', 600.00, NULL, NULL,
        '<p style=\"font-size: 12.8px;\"><span style=\"font-size: 16px;\">Доска Лодочка mini HARMONIE будет помощницей на вашей кухне.</span></p><p style=\"font-size: 12.8px;\"><span style=\"font-size: 16px;\">Или прекрасно будет смотреться со свечой на вашем столе, создавая романтическое настроение.</span></p>',
        1, '/upload/ax_catalog_product/lodochka-mini-1/3yY7fW0w0KIL3tRvwa7J58WRbjfimMTA2h4faJee.jpeg', 0, NULL, 0.00,
        1651786980, 1656279103, NULL, 'lodochka-mini-1', 'lodochka-mini-1'),
       (23, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ AHOY ✶', 1400.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска с забавной рыбкой, всегда будет поднимать вам настроение и помогать на кухне.</span><br></p>',
        1, '/upload/ax_catalog_product/ahoy/OtIEoNibq4BOK0ayJvZRPZMlgoIOTyn3NvrDob1m.jpeg', 0, NULL, 0.00, 1651786800,
        1656279103, NULL, 'ahoy', 'ahoy'),
       (24, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Листик-Пёрышко ✶', 1000.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Листик или Пёрышко? </span></p><p><span style=\"font-size: 16px;\">Вот так, начинаешь выжигать один рисунок а выходит другой. </span></p><p><span style=\"font-size: 16px;\">Получилась изящная доска, красивый сучок и элегантный лист. </span><br></p>',
        1, '/upload/ax_catalog_product/listik-pyoryshko/LvyYJP4QGHa3zzkyOA4FQewTnYWeWgIoxWyhGyfF.jpeg', 0, NULL, 0.00,
        1651787280, 1656279103, NULL, 'listik-pyoryshko', 'listik-pyoryshko'),
       (25, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Авокадо ✶', 1300.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска с изящной ручкой и рисунком Авокадо, идеально подойдёт для нарезки небольших овощей.</span><br></p>',
        1, '/upload/ax_catalog_product/avokado/9WxM6Vo4QUD3NKbaLmpb0BrI9V88wwFKJNNPMCkU.jpeg', 0, NULL, 0.00,
        1651786440, 1656279103, NULL, 'avokado', 'avokado'),
       (26, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Укроп ✶', 1600.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска с изящной ручкой и укропчиком, напомнит что тут мы режим зелень и овощи. </span><br></p>',
        1, '/upload/ax_catalog_product/ukrop/sPaxCuGHHKEETmssd0uB96HQ3Q0kOMxNikgPI5wG.jpeg', 0, NULL, 0.00, 1651785180,
        1656279103, NULL, 'ukrop', 'ukrop'),
       (27, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Пламя фитилька ✶', 1000.00, NULL, NULL,
        '<p style=\"font-size: 12.8px;\"><span style=\"font-size: 16px;\">Есть доски красивы сами по себе, самодостаточны, не хочется дополнять их рисунком.</span></p><p style=\"font-size: 12.8px;\"><span style=\"font-size: 16px;\">Как эта, из яркого и фактурного ясеня с изящной ручкой.</span></p>',
        1, '/upload/ax_catalog_product/plamya-fitilka/HrAYjd2F01MlxJXvDeRAzOsGQlV9J6HFxbpsDgZu.jpeg', 0, NULL, 0.00,
        1651785060, 1656279103, NULL, 'plamya-fitilka', 'plamya-fitilka'),
       (28, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Колоказия ✶', 1500.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска с изящным листом цветка Колоказия, будет радовать ваш взор, ведь такая есть только у вас.</span><br></p>',
        1, '/upload/ax_catalog_product/kolokaziya/bDAf2b5fQljgNNrroHDO88W6pRD5ZnXIQkGG51xo.jpeg', 0, NULL, 0.00,
        1651786380, 1656279103, NULL, 'kolokaziya', 'kolokaziya'),
       (29, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Оберег ✶', 1000.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Еще одна доска для любителей потолще. </span></p><p><span style=\"font-size: 16px;\">Изящные перышки в виде оберега помогут вам создавать шедевры на вашей кухне. </span><br></p>',
        1, '/upload/ax_catalog_product/obereg/kqdZUPBaHXWmxHdIbFrFNT2N4O82GSswUAbEWSKp.jpeg', 0, NULL, 0.00, 1651786860,
        1656279103, NULL, 'obereg', 'obereg'),
       (30, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Карамель max ✶', 2500.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Удивите ваших гостей необычной подачей, они будут в восторге.</span></p><p><br></p>',
        1, '/upload/ax_catalog_product/karamel-max/9SjDUIdV13SMyqHHRGxNbsIFqO5O25Txdi09ZG6H.jpeg', 0, NULL, 0.00,
        1651786920, 1656279103, NULL, 'karamel-max', 'karamel-max'),
       (31, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Карамель max ◉ ✶', 2500.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Удивите ваших гостей необычной подачей, они будут в восторге.</span><br></p>',
        1, '/upload/ax_catalog_product/karamel-max-1/cfp5dz8SAcR18dzNDD67grqOdVSCBeXGf4Wb5F8P.jpeg', 0, NULL, 0.00,
        1651786680, 1656279103, NULL, 'karamel-max-1', 'karamel-max-1'),
       (32, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Луковка ✶', 1100.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">У каждого вида продуктов своя доска.</span><br></p>', 1,
        '/upload/ax_catalog_product/lukovka/K9ttcfu8qbSUApw5rVEF3pCbb6gtZrjJAjkKwx78.jpeg', 0, NULL, 0.00, 1651787100,
        1656279103, NULL, 'lukovka', 'lukovka'),
       (33, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Фуксия ✶', 1600.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Универсальная доска. Для каких продуктов и подачи чего, выбирать вам.</span><br></p>',
        1, '/upload/ax_catalog_product/fuksiya/8cU8p5hwfflkg0l7OeSkwVCheFyi5ahPjoK2HsOC.jpeg', 0, NULL, 0.00,
        1651785960, 1656279103, NULL, 'fuksiya', 'fuksiya'),
       (34, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Зебра ✶', 1800.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Яркая, выразительная доска. </span></p><p><span style=\"font-size: 16px;\">А эта зебра всегда будет </span><span style=\"font-size: 16px;\">вас</span><span style=\"font-size: 16px;\"> радовать и ассоциироваться с самыми приятными и веселыми моментами.</span></p>',
        1, '/upload/ax_catalog_product/zebra/nqIT8DkYd2Z0wMpfZATmzpwWNFEcxrM0rfMVBKOY.jpeg', 0, NULL, 0.00, 1651787040,
        1656279103, NULL, 'zebra', 'zebra'),
       (35, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Бабочка ✶', 1200.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">На доске с бабочкой будет прекрасно смотреться любая нарезка. </span></p><p><span style=\"font-size: 16px;\">А другую сторону используем по назначению, режем.</span><br></p>',
        1, '/upload/ax_catalog_product/babochka/hBsyCCIFrm9rfVPpOwx01Y1j3yJ0k87HWk9hMKqI.jpeg', 0, NULL, 0.00,
        1651786500, 1656279103, NULL, 'babochka', 'babochka'),
       (36, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Baguette ✶', 2800.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Хлебная доска Baguette прекрасно подойдет для нарезки батона, колбас да всего чего захотите.</span></p>',
        1, '/upload/ax_catalog_product/baguette/Y4PuPO4IjIH33b3GLWoS3eMkvSFBOeIAJvKbnVMw.jpeg', 0, NULL, 0.00,
        1651786260, 1656279103, NULL, 'baguette', 'baguette'),
       (37, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лимон ✶', 2700.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Один из самых удобных размеров для работы с любыми продуктами. </span></p><p><span style=\"font-size: 16px;\">Она станет прекрасной помощницей на вашей кухне. </span><br></p>',
        1, '/upload/ax_catalog_product/limon/y1XaroBOiG2bpEwbtMUeDmZvK8tbH2yaQopZeFyk.jpeg', 0, NULL, 0.00, 1651785840,
        1656279103, NULL, 'limon', 'limon'),
       (38, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Синий Кит ✶', 2700.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска из серии самых удобных размеров на кухне.</span><br></p>', 1,
        '/upload/ax_catalog_product/sinij-kit/iyFc6uUzI5olqrcrRbwzY0fbT4yA9Y9W7PQGJs0L.jpeg', 0, NULL, 0.00, 1651786560,
        1656279103, NULL, 'sinij-kit', 'sinij-kit'),
       (39, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Форель карандашом ✶', 3000.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Режем много и всё сразу.</span><br></p>', 1,
        '/upload/ax_catalog_product/forel-karandashom/TYfjuvxL4v56Mo11uLrgR3smzpeRLYAkpdpIzLLu.jpeg', 0, NULL, 0.00,
        1651786200, 1656279103, NULL, 'forel-karandashom', 'forel-karandashom'),
       (40, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Цветок Мандала ✶', 1600.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Еще один экземпляр для любителей толстеньких досок.</span><br></p>', 1,
        '/upload/ax_catalog_product/cvetok-mandala/izZNiM0o2dGF6iRzvAdaiWQ8Vl0YHJxzp0TYjCK9.jpeg', 0, NULL, 0.00,
        1651786140, 1656279103, NULL, 'cvetok-mandala', 'cvetok-mandala'),
       (41, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Изящный Розмарин ✶', 2000.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска  живыми краями и легким рисунком розмарина прекрасно впишется в любой интерьер кухни.</span><br></p>',
        1, '/upload/ax_catalog_product/izyashnyj-rozmarin/IJ228m0P6Lyx82kuIZczlXJdIo1VCqZw5Rq1ShDn.jpeg', 0, NULL, 0.00,
        1651787220, 1656279103, NULL, 'izyashnyj-rozmarin', 'izyashnyj-rozmarin'),
       (42, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Нептунея ✶', 1500.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска с моллюском Нептунея напомнит вам о лете и море.</span><br></p>', 1,
        '/upload/ax_catalog_product/neptuneya/LYnvItD79YTfSvtkVjxZIlL4BltSpjmeFp8RFRKH.jpeg', 0, NULL, 0.00, 1651786620,
        1656279103, NULL, 'neptuneya', 'neptuneya'),
       (43, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Наутилида ✶', 1000.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска с ракушкой Наутилида напомнит вам о лете и море.</span><br></p>', 1,
        '/upload/ax_catalog_product/nautilida/VhCoI6tPEiff6IiRFCzR3VVeqZAoP2TFyFMgLwUR.jpeg', 0, NULL, 0.00, 1651787400,
        1656279103, NULL, 'nautilida', 'nautilida'),
       (44, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Рыбы-Рыбы ✶', 1300.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Как в том мультике, арменфильм, \"В синем море....\". </span></p><p><span style=\"font-size: 16px;\">При взгляде на эту доску она будет вызывать у вас улыбку.</span><br></p>',
        1, '/upload/ax_catalog_product/ryby-ryby/4gvvWxM4BCqAaIL2efCGojOaPi0gpyDeQg2wZXYX.jpeg', 0, NULL, 0.00,
        1651787340, 1656279103, NULL, 'ryby-ryby', 'ryby-ryby'),
       (45, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Трубач ✶', 500.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска - малышка с изящной ручкой, прекрасно подойдет для того чтоб отрезать лимончик к чаю.  </span><br></p>',
        1, '/upload/ax_catalog_product/trubach/adrWjsc211tO4JHUT0J7nNCOjEG6FsfuoF1kEd4A.jpeg', 0, NULL, 0.00,
        1651787580, 1656279103, NULL, 'trubach', 'trubach'),
       (46, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Кубики Льда ✶', 400.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Еще доска - малышка.  </span></p><p><span style=\"font-size: 16px;\">Отлично подойдет для небольшой нарезки или для свечи, чтоб создать уют у вас дома.</span><br></p>',
        1, '/upload/ax_catalog_product/kubiki-lda/RYtrt8ym4Byy6vulHk6LHCcCtscLa24UPmglpZBp.jpeg', 0, NULL, 0.00,
        1651786320, 1656279103, NULL, 'kubiki-lda', 'kubiki-lda'),
       (47, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Сардины Морячки ✶', 1400.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Выбираем доску под настроение.  </span><br></p>', 1,
        '/upload/ax_catalog_product/sardiny-moryachki/NacrXeIxJYsha5F5LZanmePGVRCs4DzISqOK0rjy.jpeg', 0, NULL, 0.00,
        1651787460, 1656279103, NULL, 'sardiny-moryachki', 'sardiny-moryachki'),
       (48, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лисички ✶', 1300.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Овальная форма доски с отверстием под пальчик, очень удобна для подачи.  </span></p><p><span style=\"font-size: 16px;\">И конечно же не забываем о прямом назначении.</span><br></p>',
        1, '/upload/ax_catalog_product/lisichki/qrQ7TnUYb8OfgOZiAiWtiGslhI6L0yNeaacqaG9s.jpeg', 0, NULL, 0.00,
        1653339600, 1656279103, NULL, 'lisichki', 'lisichki'),
       (49, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лев ✶', 2200.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска - камень притянет внимание ваших гостей, это точно. </span></p><p><span style=\"font-size: 16px;\">Мясная и сырная нарезка на ней дополнит чудесный вечер.</span></p><p><span style=\"font-size: 16px;\">А так-же необычная, для дома, подача роллов. </span><br></p>',
        1, '/upload/ax_catalog_product/lev/N6ZkpUPZLNzHnl5XJwJ6018xT3VnWVUDLCU6h5m8.jpeg', 0, NULL, 0.00, 1653339600,
        1656279103, NULL, 'lev', 'lev'),
       (50, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Моллюски ✶', 2000.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Такая доска подойдет как для подачи так и нарезки.</span><br></p>', 1,
        '/upload/ax_catalog_product/mollyuski/uLkEuvVp18KzXiezwzGPaCcrRInzMpeAw7eIxeQh.jpeg', 0, NULL, 0.00, 1653339600,
        1656279103, NULL, 'mollyuski', 'mollyuski'),
       (51, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Батон ✶', 2000.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Хлебная доска прекрасно подойдет для нарезки батона, колбас да всего чего захотите.</span><br></p>',
        1, '/upload/ax_catalog_product/baton/8rQZhcxkl2KBKfNFltHZZyGWfltimFL0G8waf7su.jpeg', 0, NULL, 0.00, 1653339600,
        1656279103, NULL, 'baton', 'baton'),
       (52, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Ежевика ✶', 1300.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска - камушек, красиво подаем или красиво ставим. </span></p><p><span style=\"font-size: 16px;\">И конечно-же на другой стороне режем.</span><br></p>',
        1, '/upload/ax_catalog_product/ezhevika/nv1szLGy6F1JPif5xmHeaRdqrz9fJ0JITP9TIiH9.jpeg', 0, NULL, 0.00,
        1653339600, 1656279103, NULL, 'ezhevika', 'ezhevika'),
       (53, 7, NULL, 1, 0, 0, 0, 0, NULL, 'Масло-Воск', 180.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Масло-воск для обработки разделочных досок.</span></p><p><span style=\"font-size: 16px;\"> </span></p><p><span style=\"font-size: 16px;\">Подходит для всех видов деревянных досок.</span></p><p><span style=\"font-size: 16px;\">В его состав входит пчелиный воск и масло медицинское вазелиновое.</span><br></p>',
        1, '/upload/ax_catalog_product/maslo-vosk/HPRQqBH66Rd5rR2GJoxpd3yDXlgWLeohurnYMd8c.jpeg', 0, NULL, 0.00,
        1656324912, 1656324912, NULL, 'maslo-vosk', 'maslo-vosk'),
       (54, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Изящный Бамбук ✶', 1800.00, NULL, NULL,
        '<p><span style=\"font-size: 16px;\">Доска с элегантной ручкой и изящным рисунком прекрасно будет смотреться в любом интерьере кухни.</span><br></p>',
        1, '/upload/ax_catalog_product/izyashnyj-bambuk/aPUJ9xd7Xw71TiWdwYgmXp9neDrqbTtp6N8XghLz.jpeg', 0, NULL, 0.00,
        1653339600, 1656279103, NULL, 'izyashnyj-bambuk', 'izyashnyj-bambuk'),
       (55, 7, NULL, 1, 0, 0, 0, 1, NULL, 'test', 1.00, NULL, NULL, NULL, 1,
        '/upload/ax_catalog_product/test/hebyxkM9FT70LsTCeHgw5bm21jijMhoDhHthpgqp.png', 0, NULL, 0.00, 1656331784,
        1656331784, NULL, 'test', 'test'),
       (56, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Баклан ✶', 2200.00, NULL, NULL,
        '<p>Доска с птичкой - Баклан поднимет вам настроение и окунет в воспоминание о лете.<br></p>', 1,
        '/upload/ax_catalog_product/baklan/SIOjpDmymx9obaRtBeu6MwHHQHeJZ8o5wNYdUbVe.jpeg', 0, NULL, 0.00, 1656338677,
        1656338677, NULL, 'baklan', 'baklan'),
       (57, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Шмель ✶', 2900.00, NULL, NULL,
        '<p>Доска из категории одних из удобных размеров. </p><p>Идеальна для каждодневного использования и еще удобна для подачи закусок на большую компанию.</p>',
        1, '/upload/ax_catalog_product/shmel/QhR7WtFBso5JUc0JOJ3QN2RINuc40AhFHxpubnqB.jpeg', 0, NULL, 0.00, 1656277200,
        1656331543, NULL, 'shmel', 'shmel'),
       (58, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Сыр А. ✶', 2700.00, NULL, NULL,
        '<p>Подаем красиво и удивляем гостей.</p><p>Помним наше правило, на одной стороне режем, на другой подаем. </p><p>Так мы используем доску по назначению а вторая сторона остается без царапин для красивой подачи.</p><p>Особые ценители, которым жалко использовать по назначению, используют их в интерьере, для свечей и всего что придумают. </p>',
        1, '/upload/ax_catalog_product/syr-1/T5k3qfUj90DDMdLP4iWTkdxMq3uLS9fpf4Ccu8gp.jpeg', 0, NULL, 0.00, 1656487025,
        1656487025, NULL, 'syr A.', 'syr A.'),
       (59, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Брокколи ✶', 3200.00, NULL, NULL,
        '<p>Широкая доска удобна, особенно когда надо резать много или большие овощи.</p><p>Маркированная доска - для овощей. Точно уже не перепутаете.</p><p>Не просто так говорят что надо иметь разные доски для разных категорий продуктов.</p>',
        1, '/upload/ax_catalog_product/brokkoli/9tPC7MZ0s8bIIiA0AewdTVxiOewLyFvN84A01J1m.jpeg', 0, NULL, 0.00,
        1656277200, 1656331543, NULL, 'brokkoli', 'brokkoli'),
       (60, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ H. Akazie ✶', 800.00, NULL, NULL,
        '<p>Камушек для легкой, небольшой, романтической подачи. </p><p><br></p>', 1,
        '/upload/ax_catalog_product/h-akazie/pZjJSch0JWpSe1ksMKOHsSWV2nmdCgqhGzON3XVR.jpeg', 0, NULL, 0.00, 1656277200,
        1656331543, NULL, 'h-akazie', 'h-akazie'),
       (61, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Базилик ✶', 2800.00, NULL, NULL,
        '<p><span style=\"font-size: 12.8px;\">Массив акации невероятно красив, цвет вообще бесподобен.</span><br></p><p>Края обработаны так, как будто вы держите в руках морской камушек, который годами оттесывало море.</p><p>Доска такая же гладкая, приятная, не хочется выпускать из рук.</p><p><span style=\"font-size: 12.8px;\">Удобная доска-камень как для подачи так и для использования в быту.</span><br></p>',
        1, '/upload/ax_catalog_product/bazilik/X7vjmolDqLreA6wB2HPi8smyCs1nHD4SrYUzY95O.jpeg', 0, NULL, 0.00,
        1656277200, 1656331543, NULL, 'bazilik', 'bazilik'),
       (62, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Ананас ✶', 1300.00, NULL, NULL,
        '<p>Яркая и красивая подача обеспечена.</p>', 1,
        '/upload/ax_catalog_product/ananas/T9ZYEeIeAPTrOaFvTwkk20NDel1MorRWhQrRbLox.jpeg', 0, NULL, 0.00, 1656277200,
        1656331543, NULL, 'ananas', 'ananas'),
       (63, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Ласточка ✶', 2700.00, NULL, NULL,
        '<p>Широкая, красивая, удобная доска.</p><p>Режем и красиво подаем.</p>', 1,
        '/upload/ax_catalog_product/lastochka/mQyCT8CAa3dMYyvTSxfIzPNIY8dCGKhByLzYZ3gg.jpeg', 0, NULL, 0.00, 1656277200,
        1656331543, NULL, 'lastochka', 'lastochka'),
       (64, 4, NULL, 1, 0, 0, 0, 1, NULL, '✶ Безмятежность ✶', 4500.00, NULL, NULL,
        '<p>Торцевая разделочная доска - доска шеф-поваров, прочная, не тупит ножи, настоящий долгожитель на кухне.</p><p>Доска односторонняя, оснащена черными силиконовыми ножками. </p><p>Устойчиво стоит на поверхности стола.</p>',
        1, '/upload/ax_catalog_product/bezmyatezhnost/TntMhqHG0LvJ4BY9XXxQyNjJc01Fy5MDAhScOup0.jpeg', 0, NULL, 0.00,
        1656277200, 1656339698, NULL, 'bezmyatezhnost', 'bezmyatezhnost'),
       (65, 4, NULL, 1, 0, 0, 0, 1, NULL,
        '✶ Садо\'м ✶', 3700.00, NULL, NULL, '<p>Доска с хаотичным рисунком не даёт воображению покоя, \n каждый раз
        смотришь на нее и каждый раз видишь разный рисунок или образ созданный природой.</ p><p>Две стороны позволяют
        доску использовать под разные продукты или одну сторону использовать для подачи.</ p>', 1, ' / upload /
        ax_catalog_product / sado - m / X6dPenD7Cu3TTdmZ2PfAW3vKJl7Xwol1LkVGl3ZW.jpeg
        ', 0, NULL, 0.00, 1656277200, 1656339698, NULL, ' sado - m ', ' sado - m
        '), (66, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Lotus ✶', 2500.00, NULL, NULL, '<p>Абрикос на столе, \n не только
        вкусно но и красиво.</ p><p>Необычная подача закусок будет радовать не только гостей но вас.</ p><p><br></ p>
        ', 1, ' / upload / ax_catalog_product / lotus / HFuEiZN44SK7qvThYzK12YnufvDTEWdvDgEceDfa.jpeg
        ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' lotus ', ' lotus '), (67, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Лист Монстеры ✶', 1600.00, NULL, NULL, '<p>Доска не только для нарезки, \n но и для подачи.</ p><p>Подать можно
        все что угодно, \n от бутербродов на завтрак до закуски к приятному вечеру.</ p>', 1, ' / upload /
        ax_catalog_product / list - monstery / hKZTf9YgTzDAqORuhQApLEEFxZ3SQeMsA6GQZinL.jpeg
        ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' list - monstery ', ' list - monstery
        '), (68, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Orange mini ✶', 1600.00, NULL, NULL, ' Ваша помощница на кухне для
        повседневного творения шедевров.', 1, ' / upload / ax_catalog_product / orange - mini /
        IZu34NMRbUXKTgG2d1GvoPh1y89RQYWGq24FS9Jh.jpeg ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' orange - mini
        ', ' orange - mini '), (69, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Мята ✶', 1600.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / myata / 5sqzVqGjojJxGyKVRxMJ81HFeoN3ArRivsiIo2y1.jpeg
        ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' myata ', ' myata '), (70, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Эвкалипт ✶', 1600.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / evkalipt /
        nKOEBTcSZQplTZxxZmVKt2P0G3FOcWrJHjmE83wf.jpeg ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' evkalipt ', '
        evkalipt '), (71, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Ptero ✶', 1600.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / ptero / CVsa4a8nCrNnJy4031FWWScrAgfxO6MJ3HC0n10I.jpeg
        ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' ptero ', ' ptero '), (72, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Лист банана ✶', 1499.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / list - banana /
        GPG5Dl36TGELyCFTUwW9tqujAQsNituzyEpoMYmP.jpeg ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' list - banana
        ', ' list - banana '), (73, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лист Mons ✶', 1000.00, NULL, NULL, NULL, 1, ' /
        upload / ax_catalog_product / list - mons / G0rSNoeFzm6pZ9DqQ6OkeWgl4xrimc3xmxBwSTb5.jpeg
        ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' list - mons ', ' list - mons
        '), (74, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Сannabis ✶', 2100.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / sannabis / QBRW2Kv7flg3WqO11a93ZKxVJn7U9aq7jyaREUtR.jpeg
        ', 0, NULL, 0.00, 1666956048, 1666956048, NULL, ' sannabis ', ' sannabis
        '), (75, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Банановый лист✶', 1300.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / bananovyj - list / ciLp2gh0dOkjggAiZpnX09ptUsf6yYgNcxXNp0If.jpeg
        ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' bananovyj - list ', ' bananovyj - list
        '), (76, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Чай ✶', 1600.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product
        / chaj / IPABlhUrdUNky5RqsZhX6A41CFS89b6b6BHtWiTN.jpeg ', 0, NULL, 0.00, 1659906000, 1659981285, NULL, ' chaj
        ', ' chaj '), (77, 4, NULL, 1, 0, 0, 0, 0, NULL, '✶ Mulberry & Walnut ✶', 50000.00, NULL, NULL, '<p>Невероятно
        красивая доска из редких пород дерева.</ p><p>Такая эксклюзивная доска будут только у вас.</ p>', 1, ' / upload
        / ax_catalog_product / mulberry - walnut / uWFstri71mC9ZYylr7hexZYG9j26gn6mkrmxucIf.jpeg
        ', 0, NULL, 0.00, 1664571600, 1664609162, NULL, ' mulberry - walnut ', ' mulberry - walnut
        '), (78, 2, NULL, 1, 0, 0, 0, 0, NULL, ' Тест1
        ', 1.00, NULL, NULL, NULL, 1, NULL, 0, NULL, 0.00, 1666381933, 1666381933, NULL, ' test1 ', ' test1
        '), (79, 2, NULL, 1, 0, 0, 0, 1, NULL, ' test 2 ', 1.00, NULL, NULL, NULL, 1, '/ upload / ax_catalog_product /
        test - 2 / MQoCOHFFzJPW7uot4yMbbk7KKnLUn14CIliRzCMh.jpeg ', 0, NULL, 0.00, 1666299600, 1666382524, NULL, ' test
        - 2 ', ' test - 2 '), (80, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Чай Цейлон ✶', 900.00, NULL, NULL, NULL, 1, ' /
        upload / ax_catalog_product / chaj - cejlon / gusT9Qu9gWAM33XDqaExRzFXb7qmm10RN6Eni9Sx.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' chaj - cejlon ', ' chaj - cejlon
        '), (81, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Хлопок ✶', 1900.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / hlopok / 73DXGMpWKvdVY2VdElbf46F28cSpBKIb53bNM5Et.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' hlopok ', ' hlopok '), (82, 5, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Чашечка чая ✶', 2500.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / chashechka - chaya /
        LCGy1TawbUwV97yxKOfhwSmOVPJViK7Nixyn6H7F.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' chashechka -
        chaya ', ' chashechka - chaya '), (83, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Морская звёздочка ✶', 1300.00, NULL, NULL, NULL, 1, '
        / upload / ax_catalog_product / morskaya - zvyozdochka / SbJgafbqrKexOsW76RivMcSisFGkZ2BktOA5lET5.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' morskaya - zvyozdochka ', ' morskaya - zvyozdochka
        '), (84, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Monstera ✶', 2100.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / monstera / tDMhSI1pwTQC50S2UkQcl0gGo1JbFenYJNKV51Im.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' monstera ', ' monstera
        '), (85, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Кот сластёна ✶', 1600.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / kot - slastyona / qpgKglPMG0qLQOXh5hIMtt5762m0cW3N2CfgTd5H.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' kot - slastyona ', ' kot - slastyona
        '), (86, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Кот подозревака ✶', 1700.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / kot - podozrevaka / qYsvDaY0Yw2id2MXBv1LM4Od0er2zEEtqGMAMCNM.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' kot - podozrevaka ', ' kot - podozrevaka
        '), (87, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Квадратик сыра ✶', 1400.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / kvadratik - syra / VhDiepzL1O1ZxPm2pAAOTggFBRPvn81ceAyh12gb.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' kvadratik - syra ', ' kvadratik - syra
        '), (88, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Ломтики сыры ✶', 1600.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / lomtiki - syry / oLCr9DK1Gr3vJN5LMHkAy6BpnyPgpceARdAvxa1x.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' lomtiki - syry ', ' lomtiki - syry
        '), (91, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Степной шмель ✶', 3500.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / stepnoj - shmel / GPCa90rUvW5JrkBgrJQsKfg040vgIeS6Zsf2UlDs.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' stepnoj - shmel ', ' stepnoj - shmel
        '), (92, 4, NULL, 1, 0, 0, 0, 1, NULL, '✶ Max oak ✶', 6200.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / max - oak / n2KjFHyhoGeyhQCQzMLPNhcgJXGBiTxZaL6ISaou.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' max - oak ', ' max - oak
        '), (93, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Плющ ✶', 1500.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product
        / plyush / zuG4APgRIMDD8kiWg6FDwavp2swQ2gKEnXmAu7pK.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, '
        plyush ', ' plyush '), (94, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Рускус✶', 1700.00, NULL, NULL, NULL, 1, ' / upload
        / ax_catalog_product / ruskus / ECF1LRhIOVFWanc73sjOeWIgVotJ9qRgeHFQxLmp.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' ruskus ', ' ruskus '), (95, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Джомолунгма ✶', 1600.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / dzhomolungma /
        vlUecy3QInVTelQCnubO6yZCt4tAF0UQrGNPwJRP.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' dzhomolungma
        ', ' dzhomolungma '), (96, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Королевна ✶', 2200.00, NULL, NULL, NULL, 1, ' /
        upload / ax_catalog_product / korolevna / k4ysugMSD5PRb8RsvXMtOhBMQOKvmldeVbQ1Jq1m.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' korolevna ', ' korolevna
        '), (97, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Листопад ✶', 1700.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / listopad / COqFh9cDspMdJwRotNSSggtfwPhHuzFFZwtjIcln.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' listopad ', ' listopad
        '), (98, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Гинкго ✶', 1600.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / ginkgo / 0wIghCIg6fHTjYxUNPPh9vpaLIkCeNZZ0xtsOSur.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' ginkgo ', ' ginkgo '), (99, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Monstera delicat ✶', 2100.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / monstera - delicat /
        ayr8I6cft7YItqsXJWRsdWjjSFjYPKc4HBfgyb8O.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' monstera -
        delicat ', ' monstera - delicat '), (100, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Калатея Мисти ✶', 2400.00, NULL, NULL, NULL, 1, '
        / upload / ax_catalog_product / kalateya - misti / QlMXDpQSXOFppuSNBVFO4u2CVp7GEmrJxAVfaYmq.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' kalateya - misti ', ' kalateya - misti
        '), (101, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Арт 1 ✶', 2100.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / art - 1 / D9Q7xt0u8Ng1J9cQLdIyQcMoJ67iPJawSn4UzZf4.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' art - 1 ', ' art -
        1 '), (102, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Тигр ✶', 2200.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / tigr / l7znyoE40HiK1WDCHtGyDUCX2tLHqq9BcFypnRpX.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' tigr ', ' tigr '), (103, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Лисичка ✶', 1100.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / lisichka /
        O2XXHIaDShjECkmKDUZRLmSVcIupnMGKiFhDWy7x.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' lisichka ', '
        lisichka '), (104, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Кофе ветвь ✶', 1800.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / kofe - vetv / 4qbWFmIFET7BmjEhbWyQSpdzwHQZzvfBD5yXU9Js.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' kofe - vetv ', ' kofe - vetv
        '), (105, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Колосок ✶', 1300.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / kolosok / nETPYsg84kqjO0C3zUNzHNhFyWiwUXdV5NqzRpvA.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' kolosok ', ' kolosok '), (106, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Круассан штрих ✶', 1300.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / kruassan - shtrih /
        9sDX7zVTamUvnK9vfk6soUzSMMjtnMhrm2gDQjUA.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' kruassan -
        shtrih ', ' kruassan - shtrih '), (108, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Мята веточка ✶', 2200.00, NULL, NULL, NULL, 1, '
        / upload / ax_catalog_product / myata - vetochka / KxvyW5lDLDcYSS8PiKCBlw52ueMfkAOsICRuThva.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' myata - vetochka ', ' myata - vetochka
        '), (109, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Крапива ✶', 1600.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / krapiva / mJSQzU4XqXuXvQem3GY55WzyUW8IYaqVVbp3STjQ.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' krapiva ', ' krapiva '), (110, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Зебра принт✶', 2000.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / zebra - print /
        fFSKNN9UNcKsZt3tF6QpS92KUTDvW2cGfEtxji8c.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' zebra - print
        ', ' zebra - print '), (111, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лилия ✶', 1900.00, NULL, NULL, NULL, 1, ' / upload
        / ax_catalog_product / liliya / LaslYvZWHk5z4BKcwGfkoAoEXhs7WXCV85FsqyJd.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' liliya ', ' liliya '), (112, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Фисташка ✶', 2000.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / fistashka /
        XcBeEZc1MWz40v7R2AlnsMXo1Y6LblIsUBUpTBJb.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' fistashka ', '
        fistashka '), (113, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ 4 Пёрышка ✶', 1700.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / 4 - pyoryshka / X8tkugoYm0Oxxr4Z31aROxxzFkN88o4ERnPd5pOH.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' 4- pyoryshka ', ' 4- pyoryshka
        '), (114, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Шеф ✶', 3000.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product
        / shef / 8lg3du35TPvmYcF5QVAVyrdgppeiMfaFiuEaJ6bo.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' shef
        ', ' shef '), (115, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Енот ✶', 2100.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / enot / 05f86fM2vcgxwUNCwe6YulPDzwLBOTYjbORVCdLk.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' enot ', ' enot '), (116, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Кинза ✶', 2300.00, NULL, NULL, NULL, 1, ' / upload / ax_catalog_product / kinza /
        42g6RDj1HEpAIXk9h97okqTwO2aljshLhGpx707K.jpeg ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' kinza ', ' kinza
        '), (118, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Папоротник Хилла ✶', 1900.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / paporotnik - hilla / Sz7v59CR4zh5eHlK4bqfEJOrzmzHlwGnaykLNNPQ.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' paporotnik - hilla ', ' paporotnik - hilla
        '), (119, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Арт 2 ✶', 2500.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / art - 2 / rUpnISDklbT7exmudFkbikbysStKZTbp6ZxzoGxi.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' art - 2 ', ' art -
        2 '), (120, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Карп ✶', 3100.00, NULL, NULL, NULL, 1, ' / upload /
        ax_catalog_product / karp / ScIAWzH1npaIPnBouh79g5h6enYmUgM9AapJ3vWg.jpeg
        ', 0, NULL, 0.00, 1667336400, 1667386554, NULL, ' karp ', ' karp '), (121, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶
        Дуэт ✶', 5000.00, NULL, NULL, '<p>Комплект камушков из дуба \"Дуэт\"</p><p>Размеры первого камушка, большого:</p><p>Длина: 33 см.</p><p>Ширина сверху: 18 см.</p><p>Ширина снизу: 16 см.</p><p>Толщина: 4 см.</p><p>Вес: 1467 г.</p><p>Размеры второго камушка:</p>', 1, '/upload/ax_catalog_product/duet/QcKqKvjZM7qSV2NCl5jpukGAgNj1n1Bhg3j64aqQ.jpeg', 0, NULL, 0.00, 1667415723, 1667415723, NULL, 'duet', 'duet'), (122, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Акация Орео ✶', 2500.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/akaciya-oreo/FjsN4GkJNCVy080NyQRDpJhQjiuQjmfgJLN7mC0i.jpeg', 0, NULL, 0.00, 1667336400, 1667414715, NULL, 'akaciya-oreo', 'akaciya-oreo'), (123, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Акация Пята ✶', 1500.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/akaciya-pyata/NmiETzqSrvgCYAF7PHK3rz36cZUbFGGJMTWf43hV.jpeg', 0, NULL, 0.00, 1667336400, 1667414715, NULL, 'akaciya-pyata', 'akaciya-pyata'), (124, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Абрикос Озеро ✶', 2500.00, NULL, NULL, '<p><span style=\"color: rgb(119, 119, 119); font-family: \"Open Sans\", Arial, sans-serif; font-size: 15px;\">Цвета на мониторе могут отличаться от реальных цветов!</span></p><p><span style=\"color: rgb(119, 119, 119); font-family: \"Open Sans\", Arial, sans-serif; font-size: 15px;\">Я сделала всё возможное, чтобы цвета изделий на экране компьютера или мобильного устройства соответствовали действительности. Однако цвета на экране могут изменяться в зависимости от настроек цветового профиля и разрешения монитора. </span></p><p><span style=\"color: rgb(119, 119, 119); font-family: \"Open Sans\", Arial, sans-serif; font-size: 15px;\">Поэтому при выборе товара нельзя полагаться исключительно на те цвета, которые вы видите на сайте!</span></p>', 1, '/upload/ax_catalog_product/abrikos-ozero/X4Gon1qNoX3LGX2yA4LVqaQQn0D60t2ygYDTmT3k.jpeg', 0, NULL, 0.00, 1667336400, 1667414715, NULL, 'abrikos-ozero', 'abrikos-ozero'), (125, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Акация MAX ✶', 2700.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/akaciya-max/hXBIXejvzL0rh492T70enXmjRPcEtphYxiFPuUUS.jpeg', 0, NULL, 0.00, 1667336400, 1667414715, NULL, 'akaciya-max', 'akaciya-max'), (126, 3, NULL, 1, 0, 0, 0, 1, NULL, '✶ Абрикос Сет ✶', 3200.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/abrikos-set/TWwBJSEyA1d9TEUVmla4ostB2zvO8fdj3G76VHqs.jpeg', 0, NULL, 0.00, 1667336400, 1667414715, NULL, 'abrikos-set', 'abrikos-set'), (127, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Ёжик ✶', 1300.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/yozhik/xEvhAlYr7HoOFyWTJwTDK5y9IBftJtLVSa6jsd2o.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'yozhik', 'yozhik'), (128, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Пёрышко ✶', 1300.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/pyoryshko/XWrIiFUzse0GaZi6QfPiqETy15lGX6gyTXxxyy1v.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'pyoryshko', 'pyoryshko'), (129, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Альпы ✶', 1600.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/alpy/nD26oWCmO1X58Dgiq1rgMjmGfYq4LUGpFL6A7lpC.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'alpy', 'alpy'), (130, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Филин ✶', 2500.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/filin/y0tkmasFSAikYpqt3kyfxZd6ZcN7KUaP7DZj6Bcy.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'filin', 'filin'), (131, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Олеандр ✶', 1900.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/oleandr/GBv4K2jDaxmBmkgs0OAEQbcaKNDKJNu9id3Zt6e0.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'oleandr', 'oleandr'), (132, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Соло ✶', 2100.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/solo/630gtYRGloYEhlcLaVdunv2p8hXsWnqrDS6ui9H8.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'solo', 'solo'), (133, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лаванда ✶', 1800.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/lavanda/NUhunb5SgmOS3qHUSN2I3Bj6JuHy2cgOpApMnfxW.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'lavanda', 'lavanda'), (134, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ Суккулент ✶', 2800.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/sukkulent/UCx0OLmzqvFwi0M4mAU6Gpg827fWKCvraNmOSYlH.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'sukkulent', 'sukkulent'), (135, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ D-S ✶', 1000.00, NULL, NULL, '<p>Можно собрать прекрасный комплект из досок этой коллекции.</p><p>4 доски с разным диаметром выполнены в едином стиле.</p><p>При покупке комплекта досок D-S; D-M; D-L и D-XL будет действовать скидка.</p><p>Стоимость комплекта составит 5\'000 ₽ < /\r\n        p > < p > Уточнить информацию можно в WhatsApp<font size=\"2\"> (ссылка в чат находится справа внизу сайта).</font></p>', 1, '/upload/ax_catalog_product/d-s/hZx5rYvfpVdaiLPJChbMqQGEXWzLtXGvSj06G4WI.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'd-s', 'd-s'), (136, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ D-M ✶', 1200.00, NULL, NULL, '<p>Можно собрать прекрасный комплект из досок этой коллекции.</p><p>4 доски с разным диаметром выполнены в едином стиле.</p><p>При покупке комплекта досок D-S; D-M; D-L и D-XL будет действовать скидка.</p><p>Стоимость комплекта составит 5\'000 ₽ < /\r\n        p > < p > Уточнить информацию можно в WhatsApp<font size=\"2\"> (ссылка в чат находится справа внизу сайта).</font></p>', 1, '/upload/ax_catalog_product/d-m/6jbyB0BdPzuevcjSBIVXeSOarMVhG2kzSGLPoq7P.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'd-m', 'd-m'), (137, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ D-L ✶', 1500.00, NULL, NULL, '<p>Можно собрать прекрасный комплект из досок этой коллекции.</p><p>4 доски с разным диаметром выполнены в едином стиле.</p><p>При покупке комплекта досок D-S; D-M; D-L и D-XL будет действовать скидка.</p><p>Стоимость комплекта составит 5\'000 ₽ < /\r\n        p > < p > Уточнить информацию можно в WhatsApp<font size=\"2\"> (ссылка в чат находится справа внизу сайта).</font></p>', 1, '/upload/ax_catalog_product/d-l/snSfJWVpvHqnHaTW7DnhFEfEWtZUM6fclu2RuXQC.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'd-l', 'd-l'), (138, 2, NULL, 1, 0, 0, 0, 1, NULL, '✶ D-XL ✶', 1800.00, NULL, NULL, '<p>Можно собрать прекрасный комплект из досок этой коллекции. </p><p>4 доски с разным диаметром выполнены в едином стиле.</p><p>При покупке комплекта досок D-S; D-M; D-L и D-XL будет действовать скидка. </p><p>Стоимость комплекта составит 5\'000 ₽ < /\r\n        p > < p > Уточнить информацию можно в WhatsApp<font size=\"2\"> (ссылка в чат находится справа внизу сайта).</font></p>', 1, '/upload/ax_catalog_product/d-xl/wB41FMDp7QLP9RNc88zXornNdZV5b88mFTNxb0xE.jpeg', 0, NULL, 0.00, 1670360400, 1670408205, NULL, 'd-xl', 'd-xl'), (139, 7, NULL, 1, 0, 0, 0, 0, NULL, '✶ Лопатка Ray ✶', 500.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/lopatka-ray/uRu6GcSQQ46w2RdIcmgbj4K7B3LBDaMrrAYqrSkl.jpeg', 0, NULL, 0.00, 1670360400, 1670422814, NULL, 'lopatka-ray', 'lopatka-ray'), (140, 7, NULL, 1, 0, 0, 0, 1, NULL, '✶ Лопатка Kant ✶', 500.00, NULL, NULL, NULL, 1, '/upload/ax_catalog_product/lopatka-kant/69FI6uCVj9IQQval82EKwxrkIfOIaCpzi3pb0dPS.jpeg', 0, NULL, 0.00, 1670360400, 1670422814, NULL, 'lopatka-kant', 'lopatka-kant'), (141, 7, NULL, 1, 0, 0, 0, 0, NULL, '✶ Нож Konha ✶', 550.00, NULL, NULL, '<p>Нож для любых мягких продуктов. </p><p>Для масла и джема, паштета, сливочного сыра. </p><p>Для всего что хочется намазать на хрустящий багет или тост.</p><p><br></p><p>Помним про уход:<br></p><p>- не моем в посудомоечной машине.</p><p>- не оставляем в сырой раковине.</p><p>- после мытья сразу вытираем насухо.</p><p>- храним в сухом месте.</p><p>- периодически протираем вазелиновым маслом.</p><p><br></p><p>Материал: Абрикос, Шелковица, Карагач, Дуб<br></p>', 1, '/upload/ax_catalog_product/nozh-konha/UnaFKMBhj0Cl6FpENN0ukcZ4HXv7HZoy1TzdyvVI.jpeg', 0, NULL, 0.00, 1670426484, 1670426484, NULL, 'nozh-konha', 'nozh-konha');
        COMMIT;

-- ----------------------------
-- Records of ax_catalog_product_has_currency
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_product_has_value_decimal
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_product_has_value_decimal` (`id`, `catalog_product_id`, `catalog_property_id`,
                                                    `catalog_property_unit_id`, `value`, `sort`, `created_at`,
                                                    `updated_at`, `deleted_at`)
VALUES (1, 2, 5, 2, 33.00, 2, 1651665295, 1652124088, NULL),
       (2, 2, 4, 2, 18.50, 3, 1651665295, 1652124088, NULL),
       (3, 2, 3, 2, 2.80, 4, 1651665295, 1652124088, NULL),
       (8, 8, 5, 2, 37.00, 2, 1651687835, 1653291077, NULL),
       (9, 8, 4, 2, 17.00, 3, 1651687835, 1653291077, NULL),
       (10, 3, 5, 2, 20.00, 2, 1651693957, 1653286089, NULL),
       (11, 3, 4, 2, 15.00, 3, 1651693957, 1653286089, NULL),
       (12, 4, 5, 2, 30.00, 2, 1651694072, 1653290775, NULL),
       (13, 4, 4, 2, 16.00, 3, 1651694072, 1653290775, NULL),
       (16, 5, 5, 2, 33.00, 2, 1651694389, 1653290895, NULL),
       (17, 5, 4, 2, 18.00, 3, 1651694389, 1653290895, NULL),
       (18, 6, 5, 2, 32.00, 2, 1651694563, 1653290933, NULL),
       (19, 6, 4, 2, 18.00, 3, 1651694563, 1653290933, NULL),
       (20, 7, 5, 2, 32.00, 2, 1651694793, 1653285769, NULL),
       (21, 7, 4, 2, 20.00, 3, 1651694793, 1653285769, NULL),
       (22, 9, 5, 2, 45.00, 2, 1651696120, 1653291150, NULL),
       (23, 9, 4, 2, 18.00, 3, 1651696120, 1653291150, NULL),
       (24, 10, 5, 2, 44.00, 2, 1651696887, 1653291221, NULL),
       (25, 10, 4, 2, 16.00, 3, 1651696887, 1653291221, NULL),
       (26, 11, 5, 2, 33.00, 2, 1651697509, 1653291401, NULL),
       (27, 11, 4, 2, 13.00, 3, 1651697509, 1653291401, NULL),
       (28, 12, 5, 2, 34.00, 2, 1651698934, 1653287309, NULL),
       (29, 12, 4, 2, 13.00, 3, 1651698934, 1653287309, NULL),
       (30, 13, 5, 2, 19.50, 2, 1653288715, 1653290560, NULL),
       (31, 13, 4, 2, 13.00, 3, 1653288715, 1653290560, NULL),
       (32, 14, 5, 2, 25.00, 2, 1653290119, 1653292439, NULL),
       (33, 14, 4, 2, 11.00, 3, 1653290119, 1653292439, NULL),
       (34, 14, 3, 2, 2.90, 4, 1653290119, 1653292439, NULL),
       (35, 13, 3, 2, 2.50, 4, 1653290516, 1653290560, NULL),
       (36, 4, 3, 2, 2.70, 4, 1653290751, 1653290775, NULL),
       (37, 5, 3, 2, 2.60, 6, 1653290895, 1653290895, NULL),
       (38, 6, 3, 2, 3.00, 4, 1653290933, 1653290933, NULL),
       (39, 8, 3, 2, 4.00, 4, 1653291077, 1653291077, NULL),
       (40, 9, 3, 2, 2.60, 4, 1653291150, 1653291150, NULL),
       (41, 10, 3, 2, 2.60, 4, 1653291222, 1653291222, NULL),
       (42, 11, 3, 2, 2.70, 5, 1653291401, 1653291401, NULL),
       (43, 15, 5, 2, 23.00, 2, 1653292160, 1653297093, NULL),
       (45, 15, 3, 2, 2.30, 5, 1653292160, 1653297093, NULL),
       (46, 16, 5, 2, 25.50, 2, 1653293717, 1653296857, NULL),
       (48, 16, 3, 2, 1.90, 5, 1653293717, 1653296857, NULL),
       (49, 17, 5, 2, 25.50, 2, 1653294751, 1653296998, NULL),
       (51, 17, 3, 2, 1.90, 5, 1653294751, 1653296998, NULL),
       (52, 18, 5, 2, 31.00, 2, 1653295313, 1653302211, NULL),
       (54, 18, 3, 2, 2.20, 5, 1653295313, 1653302211, NULL),
       (56, 16, 8, 2, 9.00, 3, 1653296857, 1653296857, NULL),
       (57, 16, 7, 2, 11.00, 4, 1653296857, 1653296857, NULL),
       (58, 17, 8, 2, 9.00, 3, 1653296998, 1653296998, NULL),
       (59, 17, 7, 2, 11.00, 4, 1653296998, 1653296998, NULL),
       (60, 15, 8, 2, 10.50, 3, 1653297093, 1653297093, NULL),
       (61, 15, 7, 2, 12.00, 4, 1653297093, 1653297093, NULL),
       (62, 19, 5, 2, 20.00, 2, 1653297753, 1653297794, NULL),
       (63, 19, 4, 2, 14.00, 3, 1653297753, 1653297794, NULL),
       (64, 19, 3, 2, 2.30, 4, 1653297753, 1653297794, NULL),
       (65, 20, 5, 2, 20.00, 2, 1653298136, 1653298136, NULL),
       (66, 20, 4, 2, 14.00, 3, 1653298136, 1653298136, NULL),
       (67, 20, 3, 2, 4.00, 4, 1653298136, 1653298136, NULL),
       (68, 21, 5, 2, 17.00, 2, 1653298828, 1653298828, NULL),
       (69, 21, 4, 2, 11.00, 3, 1653298828, 1653298828, NULL),
       (70, 21, 3, 2, 2.30, 4, 1653298828, 1653298828, NULL),
       (71, 22, 5, 2, 17.00, 2, 1653299413, 1653299413, NULL),
       (72, 22, 4, 2, 11.00, 3, 1653299413, 1653299413, NULL),
       (73, 22, 3, 2, 2.30, 4, 1653299413, 1653299413, NULL),
       (74, 23, 5, 2, 23.50, 2, 1653300004, 1653300004, NULL),
       (75, 23, 4, 2, 14.00, 3, 1653300004, 1653300004, NULL),
       (76, 23, 3, 2, 2.60, 4, 1653300004, 1653300004, NULL),
       (77, 24, 5, 2, 22.50, 2, 1653300798, 1653300832, NULL),
       (78, 24, 8, 2, 10.00, 3, 1653300798, 1653300832, NULL),
       (79, 24, 7, 2, 11.50, 4, 1653300798, 1653300832, NULL),
       (80, 24, 3, 2, 2.00, 5, 1653300798, 1653300832, NULL),
       (81, 25, 5, 2, 28.00, 2, 1653301239, 1653301239, NULL),
       (82, 25, 4, 2, 12.50, 3, 1653301239, 1653301239, NULL),
       (83, 25, 3, 2, 2.00, 4, 1653301239, 1653301239, NULL),
       (84, 26, 5, 2, 30.50, 2, 1653301580, 1653301580, NULL),
       (85, 26, 4, 2, 12.00, 3, 1653301580, 1653301580, NULL),
       (86, 26, 3, 2, 2.30, 4, 1653301580, 1653301580, NULL),
       (87, 27, 5, 2, 28.50, 2, 1653302115, 1653302115, NULL),
       (88, 27, 4, 2, 14.00, 3, 1653302115, 1653302115, NULL),
       (89, 27, 3, 2, 3.00, 4, 1653302115, 1653302115, NULL),
       (90, 18, 8, 2, 11.00, 3, 1653302211, 1653302211, NULL),
       (91, 18, 7, 2, 12.00, 4, 1653302211, 1653302211, NULL),
       (92, 28, 5, 2, 35.00, 2, 1653303010, 1653303010, NULL),
       (93, 28, 4, 2, 13.00, 3, 1653303010, 1653303010, NULL),
       (94, 28, 3, 2, 2.70, 4, 1653303010, 1653303010, NULL),
       (95, 29, 5, 2, 23.00, 2, 1653367609, 1653367609, NULL),
       (96, 29, 4, 2, 14.00, 3, 1653367609, 1653367609, NULL),
       (97, 29, 3, 2, 3.00, 4, 1653367609, 1653367609, NULL),
       (98, 30, 5, 2, 34.00, 2, 1653369320, 1653369320, NULL),
       (99, 30, 4, 2, 14.50, 3, 1653369320, 1653369320, NULL),
       (100, 30, 3, 2, 4.40, 4, 1653369320, 1653369320, NULL),
       (101, 31, 5, 2, 31.00, 2, 1653369906, 1653369971, NULL),
       (102, 31, 4, 2, 14.50, 3, 1653369906, 1653369971, NULL),
       (103, 31, 3, 2, 4.40, 4, 1653369906, 1653369971, NULL),
       (104, 32, 5, 2, 26.00, 2, 1653371682, 1653371682, NULL),
       (105, 32, 8, 2, 10.00, 3, 1653371682, 1653371682, NULL),
       (106, 32, 7, 2, 11.50, 4, 1653371682, 1653371682, NULL),
       (107, 32, 3, 2, 2.00, 5, 1653371682, 1653371682, NULL),
       (108, 33, 5, 2, 40.00, 2, 1653372215, 1653372215, NULL),
       (109, 33, 4, 2, 13.00, 3, 1653372215, 1653372215, NULL),
       (110, 33, 3, 2, 2.50, 4, 1653372215, 1653372215, NULL),
       (111, 34, 5, 2, 39.00, 2, 1653373045, 1653373045, NULL),
       (112, 34, 4, 2, 13.50, 3, 1653373045, 1653373045, NULL),
       (113, 34, 3, 2, 3.30, 4, 1653373045, 1653373045, NULL),
       (114, 35, 5, 2, 28.50, 2, 1653373820, 1653373820, NULL),
       (115, 35, 4, 2, 14.00, 3, 1653373820, 1653373820, NULL),
       (116, 35, 3, 2, 3.00, 4, 1653373820, 1653373820, NULL),
       (117, 36, 5, 2, 50.00, 2, 1653374302, 1653374302, NULL),
       (118, 36, 4, 2, 15.00, 3, 1653374302, 1653374302, NULL),
       (119, 36, 3, 2, 2.40, 4, 1653374302, 1653374302, NULL),
       (120, 37, 5, 2, 23.50, 2, 1653375243, 1653375243, NULL),
       (121, 37, 4, 2, 26.00, 3, 1653375243, 1653375243, NULL),
       (122, 37, 3, 2, 2.40, 4, 1653375243, 1653375243, NULL),
       (123, 38, 5, 2, 27.00, 2, 1653376122, 1653376122, NULL),
       (124, 38, 4, 2, 26.00, 3, 1653376122, 1653376122, NULL),
       (125, 38, 3, 2, 2.50, 4, 1653376122, 1653376122, NULL),
       (126, 39, 5, 2, 30.00, 2, 1653377011, 1653377011, NULL),
       (127, 39, 4, 2, 26.50, 3, 1653377011, 1653377011, NULL),
       (128, 39, 3, 2, 3.00, 4, 1653377011, 1653377011, NULL),
       (129, 40, 5, 2, 36.00, 2, 1653377639, 1653377639, NULL),
       (130, 40, 4, 2, 16.50, 3, 1653377639, 1653377639, NULL),
       (131, 40, 3, 2, 3.70, 4, 1653377639, 1653377639, NULL),
       (132, 41, 5, 2, 39.00, 2, 1653379570, 1653379570, NULL),
       (133, 41, 8, 2, 13.00, 3, 1653379570, 1653379570, NULL),
       (134, 41, 7, 2, 16.00, 4, 1653379570, 1653379570, NULL),
       (135, 41, 3, 2, 2.70, 5, 1653379570, 1653379570, NULL),
       (136, 42, 5, 2, 29.00, 2, 1653381142, 1653381142, NULL),
       (137, 42, 8, 2, 14.00, 3, 1653381142, 1653381142, NULL),
       (138, 42, 7, 2, 13.00, 4, 1653381142, 1653381142, NULL),
       (139, 42, 3, 2, 2.50, 5, 1653381142, 1653381142, NULL),
       (140, 43, 5, 2, 19.00, 2, 1653381908, 1653381908, NULL),
       (141, 43, 8, 2, 10.00, 3, 1653381908, 1653381908, NULL),
       (142, 43, 7, 2, 11.00, 4, 1653381908, 1653381908, NULL),
       (143, 43, 3, 2, 2.40, 5, 1653381908, 1653381908, NULL),
       (144, 44, 5, 2, 25.00, 2, 1653382697, 1653382697, NULL),
       (145, 44, 8, 2, 10.50, 3, 1653382697, 1653382697, NULL),
       (146, 44, 7, 2, 11.00, 4, 1653382697, 1653382697, NULL),
       (147, 44, 3, 2, 3.10, 5, 1653382697, 1653382697, NULL),
       (148, 45, 5, 2, 19.00, 2, 1653383699, 1653383699, NULL),
       (149, 45, 4, 2, 12.00, 3, 1653383699, 1653383699, NULL),
       (150, 45, 3, 2, 2.60, 4, 1653383699, 1653383699, NULL),
       (151, 46, 5, 2, 18.00, 2, 1653384501, 1653384501, NULL),
       (152, 46, 8, 2, 9.50, 3, 1653384502, 1653384502, NULL),
       (153, 46, 7, 2, 10.50, 4, 1653384502, 1653384502, NULL),
       (154, 46, 3, 2, 2.80, 5, 1653384502, 1653384502, NULL),
       (155, 47, 5, 2, 22.00, 2, 1653385050, 1653385050, NULL),
       (156, 47, 4, 2, 15.50, 3, 1653385050, 1653385050, NULL),
       (157, 47, 3, 2, 2.60, 4, 1653385050, 1653385050, NULL),
       (158, 48, 5, 2, 25.00, 2, 1653385494, 1653385494, NULL),
       (159, 48, 4, 2, 13.00, 3, 1653385494, 1653385494, NULL),
       (160, 48, 3, 2, 2.70, 4, 1653385494, 1653385494, NULL),
       (161, 49, 5, 2, 52.00, 2, 1653388341, 1653388341, NULL),
       (162, 49, 4, 2, 13.00, 3, 1653388341, 1653388341, NULL),
       (163, 49, 3, 2, 2.50, 4, 1653388341, 1653388341, NULL),
       (164, 50, 5, 2, 43.50, 2, 1653388971, 1653388971, NULL),
       (165, 50, 8, 2, 10.00, 3, 1653388971, 1653388971, NULL),
       (166, 50, 7, 2, 11.50, 4, 1653388971, 1653388971, NULL),
       (167, 50, 3, 2, 2.70, 5, 1653388971, 1653388971, NULL),
       (168, 51, 5, 2, 43.50, 2, 1653390063, 1653390063, NULL),
       (169, 51, 4, 2, 11.50, 3, 1653390063, 1653390063, NULL),
       (170, 51, 3, 2, 2.60, 4, 1653390063, 1653390063, NULL),
       (171, 52, 5, 2, 28.00, 2, 1653390495, 1653390495, NULL),
       (172, 52, 4, 2, 12.50, 3, 1653390495, 1653390495, NULL),
       (173, 52, 3, 2, 4.00, 4, 1653390495, 1653390495, NULL),
       (174, 54, 5, 2, 50.00, 2, 1653391682, 1653391682, NULL),
       (175, 54, 4, 2, 10.00, 3, 1653391682, 1653391682, NULL),
       (176, 54, 3, 2, 2.20, 4, 1653391682, 1653391682, NULL),
       (177, 56, 5, 2, 26.50, 2, 1656326085, 1656338677, NULL),
       (178, 56, 4, 2, 20.00, 3, 1656326085, 1656338677, NULL),
       (179, 56, 3, 2, 2.60, 4, 1656326085, 1656338677, NULL),
       (180, 57, 5, 2, 26.00, 2, 1656327069, 1656327069, NULL),
       (181, 57, 4, 2, 26.00, 3, 1656327069, 1656327069, NULL),
       (182, 57, 3, 2, 2.90, 4, 1656327069, 1656327069, NULL),
       (183, 58, 5, 2, 35.50, 2, 1656327903, 1656487025, NULL),
       (184, 58, 4, 2, 14.00, 3, 1656327903, 1656487025, NULL),
       (185, 58, 3, 2, 3.90, 4, 1656327903, 1656487025, NULL),
       (186, 59, 5, 2, 29.50, 2, 1656328324, 1656328324, NULL),
       (187, 59, 8, 2, 27.00, 3, 1656328324, 1656328324, NULL),
       (188, 59, 7, 2, 28.00, 4, 1656328324, 1656328324, NULL),
       (189, 59, 3, 2, 3.10, 5, 1656328324, 1656328324, NULL),
       (190, 60, 5, 2, 25.00, 2, 1656329296, 1656329296, NULL),
       (191, 60, 8, 2, 6.00, 3, 1656329296, 1656329296, NULL),
       (192, 60, 7, 2, 9.70, 4, 1656329296, 1656329296, NULL),
       (193, 60, 3, 2, 3.90, 5, 1656329296, 1656329296, NULL),
       (194, 61, 5, 2, 40.00, 2, 1656329802, 1656329802, NULL),
       (195, 61, 4, 2, 17.00, 3, 1656329802, 1656329802, NULL),
       (196, 61, 3, 2, 4.20, 14, 1656329802, 1656329802, NULL),
       (198, 62, 5, 1, 27.00, 2, 1656330555, 1656330555, NULL),
       (199, 62, 4, 2, 13.50, 3, 1656330555, 1656330555, NULL),
       (200, 62, 3, 2, 3.90, 4, 1656330555, 1656330555, NULL),
       (202, 63, 5, 2, 37.50, 2, 1656331248, 1656331248, NULL),
       (203, 63, 4, 2, 18.00, 3, 1656331248, 1656331248, NULL),
       (204, 63, 3, 2, 3.40, 4, 1656331248, 1656331248, NULL),
       (206, 64, 5, 2, 40.00, 2, 1656339124, 1656339124, NULL),
       (207, 64, 4, 2, 27.50, 3, 1656339124, 1656339124, NULL),
       (208, 64, 3, 2, 2.80, 4, 1656339124, 1656339124, NULL),
       (209, 65, 5, 2, 34.50, 2, 1656339649, 1656339649, NULL),
       (210, 65, 4, 2, 26.50, 3, 1656339649, 1656339649, NULL),
       (211, 65, 3, 2, 3.00, 4, 1656339649, 1656339649, NULL),
       (212, 66, 5, 2, 34.00, 2, 1659976602, 1659976958, NULL),
       (213, 66, 8, 2, 13.00, 3, 1659976602, 1659976958, NULL),
       (214, 66, 7, 2, 16.50, 4, 1659976602, 1659976958, NULL),
       (215, 66, 3, 2, 2.70, 5, 1659976602, 1659976958, NULL),
       (216, 67, 5, 2, 38.00, 2, 1659976943, 1659976943, NULL),
       (217, 67, 4, 2, 13.50, 3, 1659976943, 1659976943, NULL),
       (218, 67, 3, 2, 3.30, 4, 1659976943, 1659976943, NULL),
       (219, 68, 5, 2, 29.50, 2, 1659977608, 1659977608, NULL),
       (220, 68, 4, 2, 15.00, 3, 1659977608, 1659977608, NULL),
       (221, 68, 3, 2, 3.00, 4, 1659977608, 1659977608, NULL),
       (222, 69, 5, 2, 31.00, 2, 1659977888, 1659977888, NULL),
       (223, 69, 8, 2, 15.00, 3, 1659977888, 1659977888, NULL),
       (224, 69, 7, 2, 13.00, 4, 1659977888, 1659977888, NULL),
       (225, 69, 3, 2, 3.10, 5, 1659977888, 1659977888, NULL),
       (226, 70, 5, 2, 30.00, 2, 1659978247, 1659978247, NULL),
       (227, 70, 8, 2, 10.00, 3, 1659978247, 1659978247, NULL),
       (228, 70, 7, 2, 15.00, 4, 1659978247, 1659978247, NULL),
       (229, 70, 3, 2, 3.20, 5, 1659978247, 1659978247, NULL),
       (230, 71, 5, 2, 33.00, 2, 1659978712, 1659978712, NULL),
       (231, 71, 4, 2, 14.00, 3, 1659978712, 1659978712, NULL),
       (232, 71, 3, 2, 3.20, 4, 1659978712, 1659978712, NULL),
       (233, 72, 5, 2, 32.50, 2, 1659978904, 1659978904, NULL),
       (234, 72, 4, 2, 12.50, 3, 1659978904, 1659978904, NULL),
       (235, 72, 3, 2, 3.00, 4, 1659978904, 1659978904, NULL),
       (236, 73, 5, 2, 29.00, 2, 1659979509, 1659979509, NULL),
       (237, 73, 4, 2, 11.00, 3, 1659979509, 1659979509, NULL),
       (238, 73, 3, 2, 3.00, 4, 1659979509, 1659979509, NULL),
       (239, 74, 5, 2, 31.50, 2, 1659979681, 1666956048, NULL),
       (240, 74, 8, 2, 17.00, 3, 1659979681, 1666956048, NULL),
       (241, 74, 7, 2, 16.00, 4, 1659979681, 1666956048, NULL),
       (242, 74, 3, 2, 2.90, 5, 1659979681, 1666956048, NULL),
       (243, 75, 5, 2, 30.00, 2, 1659979847, 1659979847, NULL),
       (244, 75, 4, 2, 12.50, 3, 1659979847, 1659979847, NULL),
       (245, 75, 3, 2, 3.00, 4, 1659979847, 1659979847, NULL),
       (246, 76, 5, 2, 29.50, 2, 1659980279, 1659980279, NULL),
       (247, 76, 4, 2, 15.00, 3, 1659980279, 1659980279, NULL),
       (248, 76, 3, 2, 3.00, 4, 1659980279, 1659980279, NULL),
       (249, 77, 5, 2, 52.00, 2, 1664609162, 1664609162, NULL),
       (250, 77, 4, 2, 32.00, 3, 1664609162, 1664609162, NULL),
       (251, 77, 3, 2, 5.50, 4, 1664609162, 1664609162, NULL),
       (252, 80, 5, 2, 17.50, 2, 1667374276, 1667374276, NULL),
       (253, 80, 4, 2, 10.50, 3, 1667374276, 1667374276, NULL),
       (254, 80, 3, 2, 2.70, 4, 1667374276, 1667374276, NULL),
       (255, 81, 5, 2, 25.00, 2, 1667374562, 1667374562, NULL),
       (256, 81, 8, 2, 19.00, 3, 1667374562, 1667374562, NULL),
       (257, 81, 7, 2, 21.50, 4, 1667374562, 1667374562, NULL),
       (258, 81, 3, 2, 2.50, 5, 1667374562, 1667374562, NULL),
       (259, 82, 5, 2, 36.00, 2, 1667374812, 1667374812, NULL),
       (260, 82, 4, 2, 20.00, 3, 1667374812, 1667374812, NULL),
       (261, 82, 3, 2, 2.50, 4, 1667374812, 1667374812, NULL),
       (262, 83, 5, 2, 21.00, 2, 1667375010, 1667375010, NULL),
       (263, 83, 4, 2, 16.00, 3, 1667375010, 1667375010, NULL),
       (264, 83, 3, 2, 2.40, 4, 1667375010, 1667375010, NULL),
       (265, 84, 5, 2, 31.00, 2, 1667375269, 1667375269, NULL),
       (266, 84, 4, 2, 16.00, 3, 1667375269, 1667375269, NULL),
       (267, 84, 3, 2, 3.30, 4, 1667375269, 1667375269, NULL),
       (268, 85, 5, 2, 29.50, 2, 1667375549, 1667375549, NULL),
       (269, 85, 4, 2, 15.50, 3, 1667375549, 1667375549, NULL),
       (270, 85, 3, 2, 3.20, 4, 1667375549, 1667375549, NULL),
       (271, 86, 5, 2, 30.50, 2, 1667375790, 1667375790, NULL),
       (272, 86, 8, 2, 13.00, 3, 1667375790, 1667375790, NULL),
       (273, 86, 7, 2, 17.00, 4, 1667375790, 1667375790, NULL),
       (274, 86, 3, 2, 2.70, 5, 1667375790, 1667375790, NULL),
       (275, 87, 5, 2, 20.00, 2, 1667376017, 1667376017, NULL),
       (276, 87, 8, 2, 15.00, 3, 1667376017, 1667376017, NULL),
       (277, 87, 7, 2, 16.00, 4, 1667376017, 1667376017, NULL),
       (278, 87, 3, 2, 2.80, 5, 1667376017, 1667376017, NULL),
       (279, 88, 5, 2, 23.50, 2, 1667376219, 1667376219, NULL),
       (280, 88, 8, 2, 16.00, 3, 1667376219, 1667376219, NULL),
       (281, 88, 7, 2, 17.00, 4, 1667376219, 1667376219, NULL),
       (282, 88, 3, 2, 2.90, 5, 1667376219, 1667376219, NULL),
       (283, 91, 5, 2, 35.50, 2, 1667377514, 1667377514, NULL),
       (284, 91, 4, 2, 25.00, 3, 1667377514, 1667377514, NULL),
       (285, 91, 3, 2, 2.80, 4, 1667377514, 1667377514, NULL),
       (286, 92, 5, 2, 45.00, 2, 1667377799, 1667377799, NULL),
       (287, 92, 4, 2, 31.00, 3, 1667377799, 1667377799, NULL),
       (288, 92, 3, 2, 3.70, 4, 1667377799, 1667377799, NULL),
       (289, 93, 5, 2, 33.50, 2, 1667378053, 1667378053, NULL),
       (290, 93, 8, 2, 11.00, 3, 1667378053, 1667378053, NULL),
       (291, 93, 7, 2, 13.00, 4, 1667378053, 1667378053, NULL),
       (292, 93, 3, 2, 2.40, 5, 1667378053, 1667378053, NULL),
       (293, 94, 5, 2, 35.50, 2, 1667378703, 1667378703, NULL),
       (294, 94, 4, 2, 11.50, 3, 1667378703, 1667378703, NULL),
       (295, 94, 3, 2, 2.80, 4, 1667378703, 1667378703, NULL),
       (296, 95, 5, 2, 22.00, 2, 1667379095, 1667379095, NULL),
       (297, 95, 8, 2, 15.00, 3, 1667379095, 1667379095, NULL),
       (298, 95, 7, 2, 17.50, 4, 1667379095, 1667379095, NULL),
       (299, 95, 3, 2, 2.90, 5, 1667379095, 1667379095, NULL),
       (300, 96, 5, 2, 27.00, 2, 1667379303, 1667379303, NULL),
       (301, 96, 4, 2, 17.00, 3, 1667379303, 1667379303, NULL),
       (302, 96, 3, 2, 2.90, 4, 1667379303, 1667379303, NULL),
       (303, 97, 5, 2, 25.00, 2, 1667379524, 1667379524, NULL),
       (304, 97, 8, 2, 15.50, 3, 1667379524, 1667379524, NULL),
       (305, 97, 7, 2, 16.50, 4, 1667379524, 1667379524, NULL),
       (306, 97, 3, 2, 2.80, 5, 1667379524, 1667379524, NULL),
       (307, 98, 5, 2, 28.00, 2, 1667379796, 1667379796, NULL),
       (308, 98, 8, 2, 12.50, 3, 1667379796, 1667379796, NULL),
       (309, 98, 7, 2, 13.50, 4, 1667379796, 1667379796, NULL),
       (310, 98, 3, 2, 3.10, 5, 1667379796, 1667379796, NULL),
       (311, 99, 5, 2, 31.00, 2, 1667380233, 1667380233, NULL),
       (312, 99, 4, 2, 15.50, 3, 1667380233, 1667380233, NULL),
       (313, 99, 3, 2, 3.10, 4, 1667380233, 1667380233, NULL),
       (314, 100, 5, 2, 24.50, 2, 1667380438, 1667380438, NULL),
       (315, 100, 8, 2, 24.00, 3, 1667380438, 1667380438, NULL),
       (316, 100, 7, 2, 25.50, 4, 1667380438, 1667380438, NULL),
       (317, 100, 3, 2, 2.70, 5, 1667380438, 1667380438, NULL),
       (318, 101, 5, 2, 31.50, 2, 1667380850, 1667380850, NULL),
       (319, 101, 4, 2, 16.00, 3, 1667380850, 1667380850, NULL),
       (320, 101, 3, 2, 3.00, 4, 1667380850, 1667380850, NULL),
       (321, 102, 5, 2, 33.00, 2, 1667381105, 1667381105, NULL),
       (322, 102, 8, 2, 15.00, 3, 1667381105, 1667381105, NULL),
       (323, 102, 7, 2, 17.00, 4, 1667381105, 1667381105, NULL),
       (324, 102, 3, 2, 3.00, 5, 1667381105, 1667381105, NULL),
       (325, 103, 5, 2, 17.50, 2, 1667381270, 1667381270, NULL),
       (326, 103, 4, 2, 12.00, 3, 1667381270, 1667381270, NULL),
       (327, 103, 3, 2, 2.70, 4, 1667381270, 1667381270, NULL),
       (328, 104, 5, 2, 23.50, 2, 1667381593, 1667381593, NULL),
       (329, 104, 8, 2, 17.00, 3, 1667381593, 1667381593, NULL),
       (330, 104, 7, 2, 18.00, 4, 1667381593, 1667381593, NULL),
       (331, 104, 3, 2, 3.20, 5, 1667381593, 1667381593, NULL),
       (332, 105, 5, 2, 24.00, 2, 1667381764, 1667381764, NULL),
       (333, 105, 8, 2, 12.00, 3, 1667381764, 1667381764, NULL),
       (334, 105, 7, 2, 13.00, 4, 1667381764, 1667381764, NULL),
       (335, 105, 3, 2, 2.70, 5, 1667381764, 1667381764, NULL),
       (336, 106, 5, 2, 28.00, 2, 1667382059, 1667382059, NULL),
       (337, 106, 4, 2, 14.00, 3, 1667382059, 1667382059, NULL),
       (338, 106, 3, 2, 2.70, 4, 1667382059, 1667382059, NULL),
       (339, 108, 5, 2, 30.00, 2, 1667382297, 1667382297, NULL),
       (340, 108, 4, 2, 17.00, 3, 1667382297, 1667382297, NULL),
       (341, 108, 3, 2, 3.20, 4, 1667382297, 1667382297, NULL),
       (342, 109, 5, 2, 31.00, 2, 1667382556, 1667382556, NULL),
       (343, 109, 8, 2, 14.00, 3, 1667382556, 1667382556, NULL),
       (344, 109, 7, 2, 15.00, 4, 1667382556, 1667382556, NULL),
       (345, 109, 3, 2, 2.70, 5, 1667382556, 1667382556, NULL),
       (346, 110, 5, 2, 30.00, 2, 1667382801, 1667382801, NULL),
       (347, 110, 8, 2, 15.00, 3, 1667382801, 1667382801, NULL),
       (348, 110, 7, 2, 14.50, 4, 1667382801, 1667382801, NULL),
       (349, 110, 3, 2, 2.90, 5, 1667382801, 1667382801, NULL),
       (350, 111, 5, 2, 28.00, 2, 1667382937, 1667382937, NULL),
       (351, 111, 4, 2, 15.00, 3, 1667382937, 1667382937, NULL),
       (352, 111, 3, 2, 2.80, 4, 1667382937, 1667382937, NULL),
       (353, 112, 5, 2, 32.00, 2, 1667383211, 1667383211, NULL),
       (354, 112, 8, 2, 12.00, 3, 1667383211, 1667383211, NULL),
       (355, 112, 7, 2, 15.00, 4, 1667383211, 1667383211, NULL),
       (356, 112, 3, 2, 2.80, 5, 1667383211, 1667383211, NULL),
       (357, 113, 5, 2, 28.50, 2, 1667383453, 1667383453, NULL),
       (358, 113, 4, 2, 13.00, 3, 1667383453, 1667383453, NULL),
       (359, 113, 3, 2, 3.00, 4, 1667383453, 1667383453, NULL),
       (360, 114, 5, 2, 37.00, 2, 1667383640, 1667383640, NULL),
       (361, 114, 8, 2, 20.00, 3, 1667383640, 1667383640, NULL),
       (362, 114, 7, 2, 21.50, 4, 1667383640, 1667383640, NULL),
       (363, 114, 3, 2, 2.30, 5, 1667383640, 1667383640, NULL),
       (364, 115, 5, 2, 27.00, 2, 1667383806, 1667383806, NULL),
       (365, 115, 8, 2, 17.50, 3, 1667383806, 1667383806, NULL),
       (366, 115, 7, 2, 18.00, 4, 1667383806, 1667383806, NULL),
       (367, 115, 3, 2, 2.90, 5, 1667383806, 1667383806, NULL),
       (368, 116, 5, 2, 37.00, 2, 1667383945, 1667383945, NULL),
       (369, 116, 8, 2, 12.50, 3, 1667383945, 1667383945, NULL),
       (370, 116, 7, 2, 19.00, 4, 1667383945, 1667383945, NULL),
       (371, 116, 3, 2, 2.70, 5, 1667383945, 1667383945, NULL),
       (372, 118, 5, 2, 31.50, 2, 1667384251, 1667384251, NULL),
       (373, 118, 4, 2, 13.50, 3, 1667384251, 1667384251, NULL),
       (374, 118, 3, 2, 3.00, 4, 1667384251, 1667384251, NULL),
       (375, 119, 5, 2, 32.00, 2, 1667384405, 1667384405, NULL),
       (376, 119, 8, 2, 17.00, 3, 1667384405, 1667384405, NULL),
       (377, 119, 7, 2, 21.50, 4, 1667384405, 1667384405, NULL),
       (378, 119, 3, 2, 3.00, 5, 1667384405, 1667384405, NULL),
       (379, 120, 5, 2, 44.50, 2, 1667384621, 1667384621, NULL),
       (380, 120, 8, 2, 18.50, 3, 1667384621, 1667384621, NULL),
       (381, 120, 7, 2, 22.50, 4, 1667384621, 1667384621, NULL),
       (382, 120, 3, 2, 3.70, 5, 1667384621, 1667384621, NULL),
       (383, 121, 5, 2, 22.00, 8, 1667412921, 1667415723, NULL),
       (384, 121, 8, 2, 17.00, 9, 1667412921, 1667415723, NULL),
       (385, 121, 7, 2, 10.00, 10, 1667412921, 1667415723, NULL),
       (386, 121, 3, 2, 4.00, 11, 1667412921, 1667415723, NULL),
       (387, 122, 5, 2, 32.00, 2, 1667413219, 1667413219, NULL),
       (388, 122, 8, 2, 11.50, 3, 1667413219, 1667413219, NULL),
       (389, 122, 7, 2, 14.00, 4, 1667413219, 1667413219, NULL),
       (390, 122, 3, 2, 3.00, 5, 1667413219, 1667413219, NULL),
       (391, 123, 5, 2, 25.00, 2, 1667413424, 1667413424, NULL),
       (392, 123, 4, 2, 12.00, 3, 1667413424, 1667413424, NULL),
       (393, 123, 3, 2, 2.40, 4, 1667413424, 1667413424, NULL),
       (394, 124, 5, 2, 29.00, 2, 1667413938, 1667413938, NULL),
       (395, 124, 8, 2, 11.50, 3, 1667413938, 1667413938, NULL),
       (396, 124, 7, 2, 14.00, 4, 1667413938, 1667413938, NULL),
       (397, 124, 3, 2, 2.80, 5, 1667413938, 1667413938, NULL),
       (398, 125, 5, 2, 31.50, 2, 1667414188, 1667414188, NULL),
       (399, 125, 8, 2, 15.00, 3, 1667414188, 1667414188, NULL),
       (400, 125, 7, 2, 19.00, 4, 1667414188, 1667414188, NULL),
       (401, 125, 3, 2, 3.00, 5, 1667414188, 1667414188, NULL),
       (402, 126, 5, 2, 42.50, 2, 1667414462, 1667414462, NULL),
       (403, 126, 8, 2, 15.00, 3, 1667414462, 1667414462, NULL),
       (404, 126, 7, 2, 13.00, 4, 1667414462, 1667414462, NULL),
       (405, 126, 3, 2, 2.70, 5, 1667414462, 1667414462, NULL),
       (406, 127, 4, 2, 22.00, 2, 1670403893, 1670403893, NULL),
       (407, 127, 8, 2, 12.00, 3, 1670403893, 1670403893, NULL),
       (408, 127, 7, 2, 15.00, 4, 1670403893, 1670403893, NULL),
       (409, 127, 3, 2, 3.00, 5, 1670403893, 1670403893, NULL),
       (410, 128, 5, 2, 19.00, 2, 1670404068, 1670404068, NULL),
       (411, 128, 8, 2, 14.00, 3, 1670404068, 1670404068, NULL),
       (412, 128, 7, 2, 16.50, 4, 1670404068, 1670404068, NULL),
       (413, 128, 3, 2, 3.00, 5, 1670404068, 1670404068, NULL),
       (414, 129, 5, 2, 23.00, 2, 1670404361, 1670404361, NULL),
       (415, 129, 8, 2, 14.00, 3, 1670404361, 1670404361, NULL),
       (416, 129, 7, 2, 15.50, 4, 1670404361, 1670404361, NULL),
       (417, 129, 3, 2, 3.00, 5, 1670404361, 1670404361, NULL),
       (418, 130, 5, 2, 24.00, 2, 1670404535, 1670404535, NULL),
       (419, 130, 4, 2, 22.00, 3, 1670404535, 1670404535, NULL),
       (420, 130, 3, 2, 3.10, 4, 1670404535, 1670404535, NULL),
       (421, 131, 5, 2, 30.00, 2, 1670405268, 1670405268, NULL),
       (422, 131, 4, 2, 17.00, 3, 1670405268, 1670405268, NULL),
       (423, 131, 3, 2, 3.00, 4, 1670405268, 1670405268, NULL),
       (424, 132, 5, 2, 25.00, 2, 1670405445, 1670405445, NULL),
       (425, 132, 4, 2, 20.00, 3, 1670405445, 1670405445, NULL),
       (426, 132, 3, 2, 2.60, 4, 1670405445, 1670405445, NULL),
       (427, 133, 5, 2, 32.00, 2, 1670405594, 1670405594, NULL),
       (428, 133, 8, 2, 12.00, 3, 1670405594, 1670405594, NULL),
       (429, 133, 7, 2, 13.50, 4, 1670405594, 1670405594, NULL),
       (430, 133, 3, 2, 3.00, 5, 1670405594, 1670405594, NULL),
       (431, 134, 5, 2, 38.50, 2, 1670405826, 1670405826, NULL),
       (432, 134, 8, 2, 17.50, 3, 1670405826, 1670405826, NULL),
       (433, 134, 7, 2, 19.50, 4, 1670405826, 1670405826, NULL),
       (434, 134, 3, 2, 3.10, 5, 1670405826, 1670405826, NULL),
       (435, 135, 10, 2, 13.50, 2, 1670406574, 1670407795, NULL),
       (436, 135, 5, 2, 22.50, 3, 1670406574, 1670407795, NULL),
       (437, 135, 3, 2, 2.20, 4, 1670406574, 1670407795, NULL),
       (438, 136, 10, 2, 16.50, 2, 1670406798, 1670407769, NULL),
       (439, 136, 5, 2, 26.00, 3, 1670406798, 1670407769, NULL),
       (440, 136, 3, 2, 2.60, 4, 1670406798, 1670407769, NULL),
       (441, 137, 10, 2, 19.00, 2, 1670407007, 1670407723, NULL),
       (442, 137, 5, 2, 28.50, 3, 1670407007, 1670407723, NULL),
       (443, 137, 3, 2, 2.30, 4, 1670407007, 1670407723, NULL),
       (444, 138, 10, 2, 21.50, 2, 1670407495, 1670407707, NULL),
       (445, 138, 5, 2, 32.00, 3, 1670407496, 1670407707, NULL),
       (446, 138, 3, 2, 2.30, 4, 1670407496, 1670407707, NULL),
       (447, 139, 5, 2, 26.00, 2, 1670421593, 1670421593, NULL),
       (448, 139, 7, 2, 6.00, 3, 1670421593, 1670421593, NULL),
       (449, 140, 5, 2, 30.00, 2, 1670421735, 1670421735, NULL),
       (450, 140, 7, 2, 5.00, 3, 1670421735, 1670421735, NULL),
       (451, 141, 5, 2, 23.00, 5, 1670422540, 1670426484, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_product_has_value_int
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_product_has_value_int` (`id`, `catalog_product_id`, `catalog_property_id`,
                                                `catalog_property_unit_id`, `value`, `sort`, `created_at`, `updated_at`,
                                                `deleted_at`)
VALUES (1, 80, 6, 4, 348, 5, 1667374276, 1667374276, NULL),
       (2, 81, 6, 4, 887, 6, 1667374562, 1667374562, NULL),
       (3, 82, 6, 4, 1356, 5, 1667374812, 1667374812, NULL),
       (4, 83, 6, 4, 557, 5, 1667375010, 1667375010, NULL),
       (5, 84, 6, 4, 1130, 5, 1667375269, 1667375269, NULL),
       (6, 85, 6, 4, 1031, 5, 1667375549, 1667375549, NULL),
       (7, 86, 6, 4, 956, 6, 1667375790, 1667375790, NULL),
       (8, 87, 6, 4, 646, 6, 1667376017, 1667376017, NULL),
       (9, 88, 6, 4, 833, 6, 1667376219, 1667376219, NULL),
       (10, 91, 6, 4, 1901, 5, 1667377514, 1667377514, NULL),
       (11, 92, 6, 4, 4082, 5, 1667377799, 1667377799, NULL),
       (12, 93, 6, 4, 513, 6, 1667378053, 1667378053, NULL),
       (13, 94, 6, 4, 764, 5, 1667378703, 1667378703, NULL),
       (14, 95, 6, 4, 766, 6, 1667379095, 1667379095, NULL),
       (15, 96, 6, 4, 1016, 5, 1667379303, 1667379303, NULL),
       (16, 97, 6, 4, 839, 6, 1667379524, 1667379524, NULL),
       (17, 98, 6, 4, 815, 6, 1667379796, 1667379796, NULL),
       (18, 99, 6, 4, 1005, 5, 1667380233, 1667380233, NULL),
       (19, 100, 6, 4, 1212, 6, 1667380438, 1667380438, NULL),
       (20, 101, 6, 4, 1128, 5, 1667380850, 1667380850, NULL),
       (21, 102, 6, 4, 1187, 6, 1667381105, 1667381105, NULL),
       (22, 103, 6, 4, 422, 5, 1667381270, 1667381270, NULL),
       (23, 104, 6, 4, 1026, 6, 1667381593, 1667381593, NULL),
       (24, 105, 6, 4, 581, 6, 1667381764, 1667381764, NULL),
       (25, 106, 6, 4, 767, 5, 1667382059, 1667382059, NULL),
       (26, 108, 6, 4, 1289, 5, 1667382297, 1667382297, NULL),
       (27, 109, 6, 4, 954, 6, 1667382556, 1667382556, NULL),
       (28, 110, 6, 4, 942, 6, 1667382801, 1667382801, NULL),
       (29, 111, 6, 4, 842, 5, 1667382937, 1667382937, NULL),
       (30, 112, 6, 4, 887, 6, 1667383211, 1667383211, NULL),
       (31, 113, 6, 4, 823, 5, 1667383453, 1667383453, NULL),
       (32, 114, 6, 4, 1273, 6, 1667383640, 1667383640, NULL),
       (33, 115, 6, 4, 1078, 6, 1667383806, 1667383806, NULL),
       (34, 116, 6, 4, 1169, 6, 1667383945, 1667383945, NULL),
       (35, 118, 6, 4, 854, 5, 1667384251, 1667384251, NULL),
       (36, 119, 6, 4, 1414, 6, 1667384405, 1667384405, NULL),
       (37, 120, 6, 4, 2163, 6, 1667384621, 1667384621, NULL),
       (38, 121, 6, 4, 821, 12, 1667412921, 1667415723, NULL),
       (39, 122, 6, 4, 851, 5, 1667413219, 1667413219, NULL),
       (40, 123, 6, 4, 457, 5, 1667413424, 1667413424, NULL),
       (41, 124, 6, 4, 706, 6, 1667413938, 1667413938, NULL),
       (42, 125, 6, 4, 1194, 6, 1667414188, 1667414188, NULL),
       (43, 126, 6, 4, 981, 6, 1667414462, 1667414462, NULL),
       (44, 127, 6, 4, 640, 6, 1670403893, 1670403893, NULL),
       (45, 128, 6, 4, 641, 6, 1670404068, 1670404068, NULL),
       (46, 129, 6, 4, 756, 6, 1670404361, 1670404361, NULL),
       (47, 130, 6, 4, 1234, 5, 1670404535, 1670404535, NULL),
       (48, 131, 6, 4, 946, 5, 1670405268, 1670405268, NULL),
       (49, 132, 6, 4, 864, 5, 1670405445, 1670405445, NULL),
       (50, 133, 6, 4, 790, 6, 1670405594, 1670405594, NULL),
       (51, 134, 6, 4, 1425, 6, 1670405826, 1670405826, NULL),
       (52, 135, 6, 4, 273, 5, 1670406574, 1670407795, NULL),
       (53, 136, 6, 4, 454, 5, 1670406798, 1670407769, NULL),
       (54, 137, 6, 4, 531, 5, 1670407007, 1670407723, NULL),
       (55, 138, 6, 4, 662, 5, 1670407496, 1670407707, NULL),
       (56, 139, 6, 4, 69, 4, 1670421593, 1670421593, NULL),
       (57, 140, 6, 4, 55, 4, 1670421735, 1670421735, NULL),
       (58, 141, 6, 4, 15, 6, 1670422540, 1670426484, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_product_has_value_text
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_product_has_value_varchar
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_product_has_value_varchar` (`id`, `catalog_product_id`, `catalog_property_id`,
                                                    `catalog_property_unit_id`, `value`, `sort`, `created_at`,
                                                    `updated_at`, `deleted_at`)
VALUES (2, 2, 1, NULL, 'Абрикос', 1, 1651660444, 1652124088, NULL),
       (3, 3, 1, NULL, 'Дуб', 1, 1651686459, 1653286088, NULL),
       (4, 4, 1, NULL, 'Дуб', 1, 1651686895, 1653290775, NULL),
       (8, 8, 1, NULL, 'Ясень', 1, 1651687835, 1653291077, NULL),
       (9, 5, 1, NULL, 'Дуб', 1, 1651694263, 1653290895, NULL),
       (10, 6, 1, NULL, 'Дуб', 1, 1651694563, 1653290933, NULL),
       (11, 7, 1, NULL, 'Дуб', 1, 1651694793, 1653285769, NULL),
       (12, 9, 1, NULL, 'Дуб', 1, 1651696120, 1653291150, NULL),
       (13, 10, 1, NULL, 'Дуб', 1, 1651696887, 1653291221, NULL),
       (14, 11, 1, NULL, 'Дуб', 1, 1651697509, 1653291401, NULL),
       (15, 12, 1, NULL, 'Акация', 1, 1651698934, 1653287309, NULL),
       (16, 13, 1, NULL, 'Дуб', 1, 1653288715, 1653290560, NULL),
       (17, 14, 1, NULL, 'Дуб', 1, 1653290119, 1653292439, NULL),
       (18, 15, 1, NULL, 'Ясень', 1, 1653292160, 1653297093, NULL),
       (19, 16, 1, NULL, 'Дуб', 1, 1653293717, 1653296857, NULL),
       (20, 17, 1, NULL, 'Дуб', 1, 1653294751, 1653296998, NULL),
       (21, 18, 1, NULL, 'Ясень', 1, 1653295313, 1653302211, NULL),
       (22, 19, 1, NULL, 'Дуб', 1, 1653297753, 1653297794, NULL),
       (23, 20, 1, NULL, 'Дуб', 1, 1653298136, 1653298136, NULL),
       (24, 21, 1, NULL, 'Дуб', 1, 1653298828, 1653298828, NULL),
       (25, 22, 1, NULL, 'Дуб', 1, 1653299413, 1653299413, NULL),
       (26, 23, 1, NULL, 'Дуб', 1, 1653300004, 1653300004, NULL),
       (27, 24, 1, NULL, 'Ясень', 1, 1653300798, 1653300832, NULL),
       (28, 25, 1, NULL, 'Дуб', 1, 1653301239, 1653301239, NULL),
       (29, 26, 1, NULL, 'Дуб', 1, 1653301580, 1653301580, NULL),
       (30, 27, 1, NULL, 'Ясень', 1, 1653302115, 1653302115, NULL),
       (31, 28, 1, NULL, 'Дуб', 1, 1653303010, 1653303010, NULL),
       (32, 29, 1, NULL, 'Ясень', 1, 1653367609, 1653367609, NULL),
       (33, 30, 1, NULL, 'Ясень', 1, 1653369320, 1653369320, NULL),
       (34, 31, 1, NULL, 'Ясень', 1, 1653369906, 1653369971, NULL),
       (35, 32, 1, NULL, 'Ясень', 1, 1653371682, 1653371682, NULL),
       (36, 33, 1, NULL, 'Дуб', 1, 1653372215, 1653372215, NULL),
       (37, 34, 1, NULL, 'Ясень', 1, 1653373045, 1653373045, NULL),
       (38, 35, 1, NULL, 'Ясень', 1, 1653373820, 1653373820, NULL),
       (39, 36, 1, NULL, 'Дуб', 1, 1653374302, 1653374302, NULL),
       (40, 37, 1, NULL, 'Дуб', 1, 1653375243, 1653375243, NULL),
       (41, 38, 1, NULL, 'Дуб', 1, 1653376122, 1653376122, NULL),
       (42, 39, 1, NULL, 'Дуб', 1, 1653377011, 1653377011, NULL),
       (43, 40, 1, NULL, 'Ясень', 1, 1653377639, 1653377639, NULL),
       (44, 41, 1, NULL, 'Дуб', 1, 1653379570, 1653379570, NULL),
       (45, 42, 1, NULL, 'Дуб', 1, 1653381142, 1653381142, NULL),
       (46, 43, 1, NULL, 'Дуб', 1, 1653381908, 1653381908, NULL),
       (47, 44, 1, NULL, 'Дуб', 1, 1653382697, 1653382697, NULL),
       (48, 45, 1, NULL, 'Дуб', 1, 1653383699, 1653383699, NULL),
       (49, 46, 1, NULL, 'Дуб', 1, 1653384501, 1653384501, NULL),
       (50, 47, 1, NULL, 'Дуб', 1, 1653385050, 1653385050, NULL),
       (51, 48, 1, NULL, 'Дуб', 1, 1653385494, 1653385494, NULL),
       (52, 49, 1, NULL, 'Черешня', 1, 1653388341, 1653388341, NULL),
       (53, 50, 1, NULL, 'Дуб', 1, 1653388971, 1653388971, NULL),
       (54, 51, 1, NULL, 'Дуб', 1, 1653390063, 1653390063, NULL),
       (55, 52, 1, NULL, 'Орех', 1, 1653390495, 1653390495, NULL),
       (56, 54, 1, NULL, 'Дуб', 1, 1653391682, 1653391682, NULL),
       (57, 56, 1, NULL, 'Дуб', 1, 1656326085, 1656338677, NULL),
       (58, 57, 1, NULL, 'Дуб', 1, 1656327069, 1656327069, NULL),
       (59, 58, 1, NULL, 'Акация', 1, 1656327903, 1656487025, NULL),
       (60, 59, 1, NULL, 'Дуб', 1, 1656328324, 1656328324, NULL),
       (61, 60, 1, NULL, 'Акация', 1, 1656329296, 1656329296, NULL),
       (62, 61, 1, NULL, 'Акация', 1, 1656329802, 1656329802, NULL),
       (63, 62, 1, NULL, 'Акация', 1, 1656330555, 1656330555, NULL),
       (64, 63, 1, NULL, 'Черешня', 1, 1656331248, 1656331248, NULL),
       (65, 64, 1, NULL, 'Дуб', 1, 1656339124, 1656339124, NULL),
       (66, 65, 1, NULL, 'Дуб', 1, 1656339649, 1656339649, NULL),
       (67, 66, 1, NULL, 'Абрикос', 1, 1659976602, 1659976958, NULL),
       (68, 67, 1, NULL, 'Дуб', 1, 1659976943, 1659976943, NULL),
       (69, 68, 1, NULL, 'Дуб', 1, 1659977608, 1659977608, NULL),
       (70, 69, 1, NULL, 'Дуб', 1, 1659977888, 1659977888, NULL),
       (71, 70, 1, NULL, 'Дуб', 1, 1659978247, 1659978247, NULL),
       (72, 71, 1, NULL, 'Дуб', 1, 1659978712, 1659978712, NULL),
       (73, 72, 1, NULL, 'Дуб', 1, 1659978904, 1659978904, NULL),
       (74, 73, 1, NULL, 'Дуб', 1, 1659979509, 1659979509, NULL),
       (75, 74, 1, NULL, 'Дуб', 1, 1659979681, 1666956048, NULL),
       (76, 75, 1, NULL, 'Дуб', 1, 1659979847, 1659979847, NULL),
       (77, 76, 1, NULL, 'Дуб', 1, 1659980279, 1659980279, NULL),
       (78, 77, 1, NULL, 'Шелковица + Орех', 1, 1664609162, 1664609162, NULL),
       (79, 79, 1, NULL, '1', NULL, 1666382524, 1666382524, NULL),
       (80, 80, 1, NULL, 'Дуб', 1, 1667374276, 1667374276, NULL),
       (81, 81, 1, NULL, 'Ясень', 1, 1667374562, 1667374562, NULL),
       (82, 82, 1, NULL, 'Бук', 1, 1667374812, 1667374812, NULL),
       (83, 83, 1, NULL, 'Ясень', 1, 1667375010, 1667375010, NULL),
       (84, 84, 1, NULL, 'Дуб', 1, 1667375269, 1667375269, NULL),
       (85, 85, 1, NULL, 'Дуб', 11, 1667375549, 1667375549, NULL),
       (86, 86, 1, NULL, 'Дуб', 1, 1667375790, 1667375790, NULL),
       (87, 87, 1, NULL, 'Дуб', 1, 1667376017, 1667376017, NULL),
       (88, 88, 1, NULL, 'Дуб', 1, 1667376219, 1667376219, NULL),
       (89, 91, 1, NULL, 'Дуб', 1, 1667377514, 1667377514, NULL),
       (90, 92, 1, NULL, 'Дуб', 1, 1667377799, 1667377799, NULL),
       (91, 93, 1, NULL, 'Ясень', 1, 1667378053, 1667378053, NULL),
       (92, 94, 1, NULL, 'Ясень', 1, 1667378703, 1667378703, NULL),
       (93, 95, 1, NULL, 'Дуб', 1, 1667379095, 1667379095, NULL),
       (94, 96, 1, NULL, 'Дуб', 1, 1667379303, 1667379303, NULL),
       (95, 97, 1, NULL, 'Дуб', 1, 1667379524, 1667379524, NULL),
       (96, 98, 1, NULL, 'Дуб', 1, 1667379796, 1667379796, NULL),
       (97, 99, 1, NULL, 'Дуб', 1, 1667380233, 1667380233, NULL),
       (98, 100, 1, NULL, 'Дуб', 1, 1667380438, 1667380438, NULL),
       (99, 101, 1, NULL, 'Дуб', 1, 1667380849, 1667380849, NULL),
       (100, 102, 1, NULL, 'Дуб', 1, 1667381105, 1667381105, NULL),
       (101, 103, 1, NULL, 'Дуб', 1, 1667381270, 1667381270, NULL),
       (102, 104, 1, NULL, 'Дуб', 1, 1667381593, 1667381593, NULL),
       (103, 105, 1, NULL, 'Дуб', 1, 1667381764, 1667381764, NULL),
       (104, 106, 1, NULL, 'Дуб', 1, 1667382059, 1667382059, NULL),
       (105, 108, 1, NULL, 'Дуб', 1, 1667382297, 1667382297, NULL),
       (106, 109, 1, NULL, 'Дуб', 1, 1667382556, 1667382556, NULL),
       (107, 110, 1, NULL, 'Дуб', 1, 1667382801, 1667382801, NULL),
       (108, 111, 1, NULL, 'Дуб', 1, 1667382937, 1667382937, NULL),
       (109, 112, 1, NULL, 'Дуб', 1, 1667383211, 1667383211, NULL),
       (110, 113, 1, NULL, 'Дуб', 1, 1667383453, 1667383453, NULL),
       (111, 114, 1, NULL, 'Ясень', 1, 1667383640, 1667383640, NULL),
       (112, 115, 1, NULL, 'Дуб', 1, 1667383806, 1667383806, NULL),
       (113, 116, 1, NULL, 'Дуб', 1, 1667383945, 1667383945, NULL),
       (114, 118, 1, NULL, 'Дуб', 1, 1667384251, 1667384251, NULL),
       (115, 119, 1, NULL, 'Дуб', 1, 1667384405, 1667384405, NULL),
       (116, 120, 1, NULL, 'Дуб', 1, 1667384621, 1667384621, NULL),
       (117, 121, 1, NULL, 'Дуб', 7, 1667412921, 1667415723, NULL),
       (118, 122, 1, NULL, 'Акация', 1, 1667413219, 1667413219, NULL),
       (119, 123, 1, NULL, 'Акация', 1, 1667413424, 1667413424, NULL),
       (120, 124, 1, NULL, 'Абрикос', 1, 1667413938, 1667413938, NULL),
       (121, 125, 1, NULL, 'Акация', 1, 1667414188, 1667414188, NULL),
       (122, 126, 1, NULL, 'Абрикос', 1, 1667414462, 1667414462, NULL),
       (123, 127, 1, NULL, 'Дуб', 1, 1670403893, 1670403893, NULL),
       (124, 128, 1, NULL, 'Дуб', 1, 1670404068, 1670404068, NULL),
       (125, 129, 1, NULL, 'Дуб', 1, 1670404361, 1670404361, NULL),
       (126, 130, 1, NULL, 'Дуб', 1, 1670404535, 1670404535, NULL),
       (127, 131, 1, NULL, 'Дуб', 1, 1670405268, 1670405268, NULL),
       (128, 132, 1, NULL, 'Ясень', 1, 1670405445, 1670405445, NULL),
       (129, 133, 1, NULL, 'Дуб', 1, 1670405594, 1670405594, NULL),
       (130, 134, 1, NULL, 'Дуб', 1, 1670405826, 1670405826, NULL),
       (131, 135, 1, NULL, 'Ясень', 1, 1670406574, 1670407795, NULL),
       (132, 136, 1, NULL, 'Ясень', 1, 1670406798, 1670407769, NULL),
       (133, 137, 1, NULL, 'Ясень', 1, 1670407007, 1670407723, NULL),
       (134, 138, 1, NULL, 'Ясень', 1, 1670407495, 1670407707, NULL),
       (135, 139, 1, NULL, 'Абрикос', 1, 1670421593, 1670421593, NULL),
       (136, 140, 1, NULL, 'Абрикос', 1, 1670421735, 1670421735, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_product_widgets
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_product_widgets_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_property` (`id`, `catalog_property_type_id`, `catalog_property_unit_id`, `is_hidden`, `title`,
                                   `description`, `sort`, `image`, `created_at`, `updated_at`, `deleted_at`)
VALUES (1, 1, 0, NULL, 'Материал', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (2, 1, 0, NULL, 'Цвет', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (3, 4, 2, NULL, 'Толщина', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (4, 4, 2, NULL, 'Ширина', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (5, 4, 2, NULL, 'Длина', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (6, 3, 4, NULL, 'Вес', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (7, 4, 2, 0, 'Ширина снизу', NULL, NULL, NULL, 1653296082, 1667377959, NULL),
       (8, 4, 2, NULL, 'Ширина сверху', NULL, NULL, NULL, 1653296768, 1653296768, NULL),
       (10, 4, 2, 0, 'Диаметр', NULL, NULL, NULL, 1670406220, 1670406220, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_group
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_has_category
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_has_group
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_has_product
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_type
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_property_type` (`id`, `resource`, `title`, `description`, `sort`, `image`, `created_at`,
                                        `updated_at`, `deleted_at`)
VALUES (1, 'ax_catalog_product_has_value_varchar', 'Строка', NULL, 0, NULL, 1651608269, 1651608269, NULL),
       (2, 'ax_catalog_product_has_value_varchar', 'Ссылка', NULL, 6, NULL, 1651608269, 1651608269, NULL),
       (3, 'ax_catalog_product_has_value_int', 'Число', NULL, 1, NULL, 1651608269, 1651608269, NULL),
       (4, 'ax_catalog_product_has_value_decimal', 'Дробное число 0.00', NULL, 2, NULL, 1651608269, 1651608269, NULL),
       (5, 'ax_catalog_product_has_value_text', 'Большой текст', NULL, 3, NULL, 1651608269, 1651608269, NULL),
       (6, 'ax_catalog_product_has_value_varchar', 'Файл', NULL, 5, NULL, 1651608269, 1651608269, NULL),
       (7, 'ax_catalog_product_has_value_varchar', 'Изображение', NULL, 4, NULL, 1651608269, 1651608269, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_unit
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_property_unit` (`id`, `unit_okei_id`, `title`, `national_symbol`, `international_symbol`,
                                        `description`, `sort`, `image`, `created_at`, `updated_at`, `deleted_at`)
VALUES (1, 1, 'Миллиметр', 'мм', 'ММ', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (2, 2, 'Сантиметр', 'см', 'СМ', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (3, 4, 'Метр', 'м', 'М', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (4, 36, 'Грамм', 'г', 'Г', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (5, 37, 'Килограмм', 'кг', 'КГ', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (6, 11, 'Квадратный миллиметр', 'мм^2', 'ММ2', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (7, 12, 'Квадратный сантиметр', 'см^2', 'СМ2', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (8, 14, 'Квадратный метр', 'м^2', 'М2', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (9, 121, 'Набор', 'набор', 'НАБОР', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (10, 122, 'Пара (2 шт.)', 'пар', 'ПАР', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (11, 131, 'Элемент', 'элем', 'ЭЛЕМ', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (12, 132, 'Упаковка', 'упак', 'УПАК', NULL, NULL, NULL, 1651608270, 1651608270, NULL),
       (13, 135, 'Штука', 'шт', 'ШТ', NULL, NULL, NULL, 1651608270, 1651608270, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_value_decimal
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_value_int
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_value_text
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_property_value_varchar
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_catalog_storage
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_storage` (`id`, `catalog_storage_place_id`, `catalog_product_id`, `in_stock`, `in_reserve`,
                                  `reserve_expired_at`, `price_in`, `price_out`, `created_at`, `updated_at`,
                                  `deleted_at`)
VALUES (1, 1, 2, 0, 0, NULL, 0, 0, 1656279103, 1656279104, NULL),
       (2, 1, 3, 0, 0, NULL, 0, 1100, 1656279103, 1657289183, NULL),
       (3, 1, 4, 1, 0, NULL, 0, 1800, 1656279103, 1667050394, NULL),
       (4, 1, 5, 0, 0, NULL, 0, 2000, 1656279103, 1662794581, NULL),
       (5, 1, 6, 1, 0, NULL, 0, 2000, 1656279103, 1656279103, NULL),
       (6, 1, 7, 0, 0, NULL, 0, 0, 1656279103, 1656279104, NULL),
       (7, 1, 8, 1, 0, NULL, 0, 2500, 1656279103, 1656279103, NULL),
       (8, 1, 9, 0, 0, NULL, 0, 2800, 1656279103, 1657399101, NULL),
       (9, 1, 10, 0, 0, NULL, 0, 2300, 1656279103, 1656310641, NULL),
       (10, 1, 11, 0, 0, NULL, 0, 1500, 1656279103, 1657399051, NULL),
       (11, 1, 12, 0, 0, NULL, 0, 0, 1656279103, 1656279104, NULL),
       (12, 1, 13, 0, 0, NULL, 0, 0, 1656279103, 1656279104, NULL),
       (13, 1, 14, 0, 0, NULL, 0, 1200, 1656279103, 1662794605, NULL),
       (14, 1, 15, 0, 0, NULL, 0, 1000, 1656279103, 1657399187, NULL),
       (15, 1, 16, 0, 0, NULL, 0, 1200, 1656279103, 1659881834, NULL),
       (16, 1, 17, 0, 0, NULL, 0, 1200, 1656279103, 1659885905, NULL),
       (17, 1, 18, 0, 0, NULL, 0, 1200, 1656279103, 1657398948, NULL),
       (18, 1, 19, 0, 0, NULL, 0, 1200, 1656279103, 1659878352, NULL),
       (19, 1, 20, 0, 0, NULL, 0, 1200, 1656279103, 1659722275, NULL),
       (20, 1, 21, 0, 0, NULL, 0, 600, 1656279103, 1659878316, NULL),
       (21, 1, 22, 0, 0, NULL, 0, 600, 1656279103, 1657289138, NULL),
       (22, 1, 23, 1, 0, NULL, 0, 1400, 1656279103, 1656279103, NULL),
       (23, 1, 24, 0, 0, NULL, 0, 1000, 1656279103, 1657292408, NULL),
       (24, 1, 25, 0, 0, NULL, 0, 1300, 1656279103, 1657297534, NULL),
       (25, 1, 26, 0, 0, NULL, 0, 1600, 1656279103, 1657285462, NULL),
       (26, 1, 27, 0, 0, NULL, 0, 1000, 1656279103, 1657398980, NULL),
       (27, 1, 28, 0, 0, NULL, 0, 1500, 1656279103, 1657399117, NULL),
       (28, 1, 29, 0, 0, NULL, 0, 1000, 1656279103, 1657398995, NULL),
       (29, 1, 30, 0, 0, NULL, 0, 2500, 1656279103, 1657398963, NULL),
       (30, 1, 31, 0, 0, NULL, 0, 2500, 1656279103, 1657399023, NULL),
       (31, 1, 32, 0, 0, NULL, 0, 1100, 1656279103, 1657468485, NULL),
       (32, 1, 33, 0, 0, NULL, 0, 1600, 1656279103, 1659878387, NULL),
       (33, 1, 34, 1, 0, NULL, 0, 1800, 1656279103, 1656279103, NULL),
       (34, 1, 35, 0, 0, NULL, 0, 1200, 1656279103, 1657297564, NULL),
       (35, 1, 36, 0, 0, NULL, 0, 2800, 1656279103, 1657460517, NULL),
       (36, 1, 37, 0, 0, NULL, 0, 2700, 1656279103, 1657305074, NULL),
       (37, 1, 38, 0, 0, NULL, 0, 2700, 1656279103, 1663044183, NULL),
       (38, 1, 39, 0, 0, NULL, 0, 3000, 1656279103, 1657304930, NULL),
       (39, 1, 40, 1, 0, NULL, 0, 1900, 1656279103, 1667066456, NULL),
       (40, 1, 41, 0, 0, NULL, 0, 2000, 1656279103, 1657399087, NULL),
       (41, 1, 42, 0, 0, NULL, 0, 1500, 1656279103, 1658311933, NULL),
       (42, 1, 43, 0, 0, NULL, 0, 1000, 1656279103, 1657532007, NULL),
       (43, 1, 44, 0, 0, NULL, 1300, 1300, 1656279103, 1657609520, NULL),
       (44, 1, 45, 0, 0, NULL, 0, 500, 1656279103, 1657297609, NULL),
       (45, 1, 46, 0, 0, NULL, 0, 400, 1656279103, 1657297552, NULL),
       (46, 1, 47, 0, 0, NULL, 0, 1400, 1656279103, 1657452939, NULL),
       (47, 1, 48, 0, 0, NULL, 0, 1300, 1656279104, 1659878335, NULL),
       (48, 1, 49, 0, 0, NULL, 0, 2200, 1656279104, 1657399068, NULL),
       (49, 1, 50, 1, 0, NULL, 0, 2000, 1656279104, 1656279104, NULL),
       (50, 1, 51, 0, 0, NULL, 0, 2000, 1656279104, 1657399138, NULL),
       (51, 1, 52, 0, 0, NULL, 0, 1300, 1656279104, 1657568200, NULL),
       (52, 1, 53, 32, 0, NULL, 0, 180, 1656279104, 1656279104, NULL),
       (53, 1, 54, 1, 0, NULL, 0, 1800, 1656279104, 1656279104, NULL),
       (54, 1, 55, 0, 0, NULL, 1, 1, 1656279591, 1656329683, NULL),
       (55, 1, 56, 0, 0, NULL, 1, 2200, 1656326085, 1657297576, NULL),
       (56, 1, 63, 0, 0, NULL, 0, 2700, 1656331543, 1657305012, NULL),
       (57, 1, 62, 1, 0, NULL, 0, 1300, 1656331543, 1656331543, NULL),
       (58, 1, 61, 0, 0, NULL, 0, 2800, 1656331543, 1667066868, NULL),
       (59, 1, 60, 0, 0, NULL, 0, 800, 1656331543, 1657399161, NULL),
       (60, 1, 59, 0, 0, NULL, 0, 3200, 1656331543, 1658311913, NULL),
       (61, 1, 58, 0, 0, NULL, 0, 2700, 1656331543, 1657470393, NULL),
       (62, 1, 57, 0, 0, NULL, 0, 2900, 1656331543, 1657475105, NULL),
       (63, 1, 64, 0, 0, NULL, 0, 4500, 1656339698, 1657466732, NULL),
       (64, 1, 65, 0, 0, NULL, 0, 3700, 1656339698, 1659722291, NULL),
       (65, 1, 66, 0, 0, NULL, 2500, 2500, 1659981285, 1663044103, NULL),
       (66, 1, 67, 0, 0, NULL, 1600, 1600, 1659981285, 1663044263, NULL),
       (67, 1, 68, 1, 0, NULL, 1600, 1600, 1659981285, 1667066838, NULL),
       (68, 1, 69, 0, 0, NULL, 1600, 1600, 1659981285, 1663044207, NULL),
       (69, 1, 70, 1, 0, NULL, 1600, 1600, 1659981285, 1667066649, NULL),
       (70, 1, 71, 1, 0, NULL, 1600, 1800, 1659981285, 1667066607, NULL),
       (71, 1, 72, 0, 0, NULL, 1500, 1500, 1659981285, 1666451619, NULL),
       (72, 1, 73, 1, 0, NULL, 1000, 1000, 1659981285, 1667066939, NULL),
       (73, 1, 74, 1, 0, NULL, 1900, 2100, 1659981285, 1667066749, NULL),
       (74, 1, 75, 0, 0, NULL, 1300, 1300, 1659981285, 1662801147, NULL),
       (75, 1, 76, 1, 0, NULL, 1600, 1600, 1659981285, 1667066796, NULL),
       (76, 1, 77, 0, 0, NULL, 1, 50000, 1664609162, 1664612982, NULL),
       (77, 1, 78, 0, 0, NULL, 1, 1, 1666381464, 1667199531, NULL),
       (78, 1, 79, 0, 0, NULL, 1, 1, 1666382524, 1666434010, NULL),
       (79, 1, 111, 1, 0, NULL, 1900, 1900, 1667386554, 1667386554, NULL),
       (80, 1, 101, 1, 0, NULL, 2100, 2100, 1667386554, 1667386554, NULL),
       (81, 1, 102, 1, 0, NULL, 2200, 2200, 1667386554, 1667386554, NULL),
       (82, 1, 103, 1, 0, NULL, 1100, 1100, 1667386554, 1667386554, NULL),
       (83, 1, 104, 1, 0, NULL, 1800, 1800, 1667386554, 1667386554, NULL),
       (84, 1, 105, 1, 0, NULL, 1300, 1300, 1667386554, 1667386554, NULL),
       (85, 1, 106, 1, 0, NULL, 1300, 1300, 1667386554, 1667386554, NULL),
       (86, 1, 108, 1, 0, NULL, 2200, 2200, 1667386554, 1667386554, NULL),
       (87, 1, 109, 1, 0, NULL, 1600, 1600, 1667386554, 1667386554, NULL),
       (88, 1, 110, 1, 0, NULL, 2000, 2000, 1667386554, 1667386554, NULL),
       (89, 1, 100, 1, 0, NULL, 2400, 2400, 1667386554, 1667386554, NULL),
       (90, 1, 112, 1, 0, NULL, 2000, 2000, 1667386554, 1667386554, NULL),
       (91, 1, 113, 1, 0, NULL, 1700, 1700, 1667386554, 1667386554, NULL),
       (92, 1, 114, 0, 0, NULL, 3000, 3000, 1667386554, 1667487440, NULL),
       (93, 1, 115, 0, 0, NULL, 2100, 2100, 1667386554, 1667570945, NULL),
       (94, 1, 116, 1, 0, NULL, 2300, 2300, 1667386554, 1667386554, NULL),
       (95, 1, 118, 1, 0, NULL, 1900, 1900, 1667386554, 1667386554, NULL),
       (96, 1, 119, 1, 0, NULL, 2500, 2500, 1667386554, 1667386554, NULL),
       (97, 1, 120, 1, 0, NULL, 3100, 3100, 1667386554, 1667386554, NULL),
       (98, 1, 91, 0, 0, NULL, 3500, 3500, 1667386554, 1667487425, NULL),
       (99, 1, 81, 1, 0, NULL, 1900, 1900, 1667386554, 1667386554, NULL),
       (100, 1, 82, 1, 0, NULL, 2500, 2500, 1667386554, 1667386554, NULL),
       (101, 1, 83, 1, 0, NULL, 1300, 1300, 1667386554, 1667386554, NULL),
       (102, 1, 84, 1, 0, NULL, 2100, 2100, 1667386554, 1667386554, NULL),
       (103, 1, 85, 1, 0, NULL, 1600, 1600, 1667386554, 1667386554, NULL),
       (104, 1, 86, 1, 0, NULL, 1700, 1700, 1667386554, 1667386554, NULL),
       (105, 1, 87, 1, 0, NULL, 1400, 1400, 1667386554, 1667386554, NULL),
       (106, 1, 88, 1, 0, NULL, 1600, 1600, 1667386554, 1667386554, NULL),
       (107, 1, 80, 1, 0, NULL, 900, 900, 1667386554, 1667386554, NULL),
       (108, 1, 92, 1, 0, NULL, 6200, 6200, 1667386554, 1667386554, NULL),
       (109, 1, 93, 1, 0, NULL, 1500, 1500, 1667386554, 1667386554, NULL),
       (110, 1, 94, 1, 0, NULL, 1700, 1700, 1667386554, 1667386554, NULL),
       (111, 1, 95, 1, 0, NULL, 1600, 1600, 1667386554, 1667386554, NULL),
       (112, 1, 96, 1, 0, NULL, 2200, 2200, 1667386554, 1667386554, NULL),
       (113, 1, 97, 1, 0, NULL, 1700, 1700, 1667386554, 1667386554, NULL),
       (114, 1, 98, 1, 0, NULL, 1600, 1600, 1667386554, 1667386554, NULL),
       (115, 1, 99, 1, 0, NULL, 2100, 2100, 1667386554, 1667386554, NULL),
       (116, 1, 121, 1, 0, NULL, 5000, 5000, 1667414715, 1667414715, NULL),
       (117, 1, 122, 1, 0, NULL, 2500, 2500, 1667414715, 1667414715, NULL),
       (118, 1, 123, 1, 0, NULL, 1500, 1500, 1667414715, 1667414715, NULL),
       (119, 1, 124, 1, 0, NULL, 2500, 2500, 1667414715, 1667414715, NULL),
       (120, 1, 125, 1, 0, NULL, 2700, 2700, 1667414715, 1667414715, NULL),
       (121, 1, 126, 1, 0, NULL, 3200, 3200, 1667414715, 1667414715, NULL),
       (122, 1, 127, 1, 0, NULL, 0, 1300, 1670408205, 1670408205, NULL),
       (123, 1, 128, 1, 0, NULL, 0, 1300, 1670408205, 1670408205, NULL),
       (124, 1, 129, 1, 0, NULL, 0, 1600, 1670408205, 1670408205, NULL),
       (125, 1, 130, 1, 0, NULL, 0, 2500, 1670408205, 1670408205, NULL),
       (126, 1, 131, 1, 0, NULL, 0, 1900, 1670408205, 1670408205, NULL),
       (127, 1, 132, 1, 0, NULL, 0, 2100, 1670408205, 1670408205, NULL),
       (128, 1, 133, 1, 0, NULL, 0, 1800, 1670408205, 1670408205, NULL),
       (129, 1, 134, 1, 0, NULL, 0, 2800, 1670408205, 1670408205, NULL),
       (130, 1, 135, 1, 0, NULL, 0, 1000, 1670408205, 1670408205, NULL),
       (131, 1, 136, 1, 0, NULL, 0, 1200, 1670408205, 1670408205, NULL),
       (132, 1, 137, 1, 0, NULL, 0, 1500, 1670408205, 1670408205, NULL),
       (133, 1, 138, 1, 0, NULL, 0, 1800, 1670408205, 1670408205, NULL),
       (134, 1, 139, 6, 0, NULL, 0, 500, 1670422814, 1670422814, NULL),
       (135, 1, 140, 1, 0, NULL, 0, 500, 1670422814, 1670422814, NULL),
       (136, 1, 141, 21, 0, NULL, 0, 550, 1670422814, 1670422814, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_storage_place
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_storage_place` (`id`, `catalog_storage_place_id`, `is_place`, `title`, `created_at`,
                                        `updated_at`, `deleted_at`)
VALUES (1, NULL, 1, 'Главный склад', 1651608269, 1651608269, NULL),
       (2, NULL, 1, 'Запасной склад', 1656279103, 1656279103, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_catalog_storage_reserve
-- ----------------------------
BEGIN;
INSERT INTO `ax_catalog_storage_reserve` (`id`, `catalog_product_id`, `catalog_storage_place_id`, `document`,
                                          `document_id`, `status`, `in_reserve`, `expired_at`, `created_at`,
                                          `updated_at`, `deleted_at`)
VALUES (2, 55, 1, 'ax_document_order', 2, 0, 0, NULL, 1656329588, 1656329683, NULL),
       (3, 52, 1, 'ax_document_order', 3, 0, 0, NULL, 1657567826, 1657568200, NULL),
       (4, 44, 1, 'ax_document_order', 4, 0, 0, NULL, 1657608471, 1657609113, NULL),
       (5, 44, 1, 'ax_document_order', 5, 0, 0, NULL, 1657608930, 1657609490, NULL),
       (6, 77, 1, 'ax_document_order', 6, 0, 0, NULL, 1664612863, 1664612982, NULL),
       (7, 72, 1, 'ax_document_order', 7, 0, 0, NULL, 1666448335, 1666450929, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_comment
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_counterparty
-- ----------------------------
BEGIN;
INSERT INTO `ax_counterparty` (`id`, `user_id`, `is_individual`, `name`, `name_full`, `created_at`, `updated_at`,
                               `deleted_at`)
VALUES (1, 7, 1, NULL, NULL, 1656279103, 1656279103, NULL),
       (2, 6, 1, NULL, NULL, 1656279203, 1656279203, NULL),
       (4, 11, 1, NULL, NULL, 1657567747, 1657567747, NULL),
       (5, 9, 1, NULL, NULL, 1659633798, 1659633798, NULL),
       (13, 19, 1, NULL, NULL, 1660420870, 1660420870, NULL),
       (14, 20, 1, NULL, NULL, 1666448303, 1666448303, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_currency
-- ----------------------------
BEGIN;
INSERT INTO `ax_currency` (`id`, `global_id`, `num_code`, `char_code`, `title`, `created_at`, `updated_at`,
                           `deleted_at`)
VALUES (1, 'R00000', 810, 'RUB', 'Российский рубль', 1651608268, 1651608268, NULL),
       (2, 'R01010', 36, 'AUD', 'Австралийский доллар', 1651608268, 1651608268, NULL),
       (3, 'R01020A', 944, 'AZN', 'Азербайджанский манат', 1651608268, 1651608268, NULL),
       (4, 'R01035', 826, 'GBP', 'Фунт стерлингов Соединенного королевства', 1651608268, 1651608268, NULL),
       (5, 'R01060', 51, 'AMD', 'Армянских драмов', 1651608268, 1651608268, NULL),
       (6, 'R01090B', 933, 'BYN', 'Белорусский рубль', 1651608268, 1651608268, NULL),
       (7, 'R01100', 975, 'BGN', 'Болгарский лев', 1651608268, 1651608268, NULL),
       (8, 'R01115', 986, 'BRL', 'Бразильский реал', 1651608268, 1651608268, NULL),
       (9, 'R01135', 348, 'HUF', 'Венгерских форинтов', 1651608268, 1651608268, NULL),
       (10, 'R01200', 344, 'HKD', 'Гонконгских долларов', 1651608268, 1651608268, NULL),
       (11, 'R01215', 208, 'DKK', 'Датская крона', 1651608268, 1651608268, NULL),
       (12, 'R01235', 840, 'USD', 'Доллар США', 1651608268, 1651608268, NULL),
       (13, 'R01239', 978, 'EUR', 'Евро', 1651608268, 1651608268, NULL),
       (14, 'R01270', 356, 'INR', 'Индийских рупий', 1651608268, 1651608268, NULL),
       (15, 'R01335', 398, 'KZT', 'Казахстанских тенге', 1651608268, 1651608268, NULL),
       (16, 'R01350', 124, 'CAD', 'Канадский доллар', 1651608268, 1651608268, NULL),
       (17, 'R01370', 417, 'KGS', 'Киргизских сомов', 1651608268, 1651608268, NULL),
       (18, 'R01375', 156, 'CNY', 'Китайский юань', 1651608268, 1651608268, NULL),
       (19, 'R01500', 498, 'MDL', 'Молдавских леев', 1651608268, 1651608268, NULL),
       (20, 'R01535', 578, 'NOK', 'Норвежских крон', 1651608268, 1651608268, NULL),
       (21, 'R01565', 985, 'PLN', 'Польский злотый', 1651608268, 1651608268, NULL),
       (22, 'R01585F', 946, 'RON', 'Румынский лей', 1651608268, 1651608268, NULL),
       (23, 'R01589', 960, 'XDR', 'СДР (специальные права заимствования)', 1651608268, 1651608268, NULL),
       (24, 'R01625', 702, 'SGD', 'Сингапурский доллар', 1651608268, 1651608268, NULL),
       (25, 'R01670', 972, 'TJS', 'Таджикских сомони', 1651608268, 1651608268, NULL),
       (26, 'R01700J', 949, 'TRY', 'Турецких лир', 1651608268, 1651608268, NULL),
       (27, 'R01710A', 934, 'TMT', 'Новый туркменский манат', 1651608268, 1651608268, NULL),
       (28, 'R01717', 860, 'UZS', 'Узбекских сумов', 1651608268, 1651608268, NULL),
       (29, 'R01720', 980, 'UAH', 'Украинских гривен', 1651608268, 1651608268, NULL),
       (30, 'R01760', 203, 'CZK', 'Чешских крон', 1651608268, 1651608268, NULL),
       (31, 'R01770', 752, 'SEK', 'Шведских крон', 1651608268, 1651608268, NULL),
       (32, 'R01775', 756, 'CHF', 'Швейцарский франк', 1651608268, 1651608268, NULL),
       (33, 'R01810', 710, 'ZAR', 'Южноафриканских рэндов', 1651608268, 1651608268, NULL),
       (34, 'R01815', 410, 'KRW', 'Вон Республики Корея', 1651608268, 1651608268, NULL),
       (35, 'R01820', 392, 'JPY', 'Японских иен', 1651608268, 1651608268, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_currency_exchange_rate
-- ----------------------------
BEGIN;
INSERT INTO `ax_currency_exchange_rate` (`id`, `currency_id`, `value`, `date_rate`, `created_at`, `updated_at`,
                                         `deleted_at`)
VALUES (1, 2, 51, 1651266000, 1651608268, 1651608268, NULL),
       (2, 3, 42, 1651266000, 1651608268, 1651608268, NULL),
       (3, 4, 88, 1651266000, 1651608268, 1651608268, NULL),
       (4, 5, 16, 1651266000, 1651608268, 1651608268, NULL),
       (5, 6, 27, 1651266000, 1651608268, 1651608268, NULL),
       (6, 7, 38, 1651266000, 1651608268, 1651608268, NULL),
       (7, 8, 14, 1651266000, 1651608268, 1651608268, NULL),
       (8, 9, 20, 1651266000, 1651608268, 1651608268, NULL),
       (9, 10, 91, 1651266000, 1651608268, 1651608268, NULL),
       (10, 11, 10, 1651266000, 1651608268, 1651608268, NULL),
       (11, 12, 71, 1651266000, 1651608268, 1651608268, NULL),
       (12, 13, 75, 1651266000, 1651608268, 1651608268, NULL),
       (13, 14, 93, 1651266000, 1651608268, 1651608268, NULL),
       (14, 15, 16, 1651266000, 1651608268, 1651608268, NULL),
       (15, 16, 55, 1651266000, 1651608268, 1651608268, NULL),
       (16, 17, 87, 1651266000, 1651608268, 1651608268, NULL),
       (17, 18, 11, 1651266000, 1651608268, 1651608268, NULL),
       (18, 19, 38, 1651266000, 1651608268, 1651608268, NULL),
       (19, 20, 75, 1651266000, 1651608268, 1651608268, NULL),
       (20, 21, 16, 1651266000, 1651608268, 1651608268, NULL),
       (21, 22, 15, 1651266000, 1651608268, 1651608268, NULL),
       (22, 23, 95, 1651266000, 1651608268, 1651608268, NULL),
       (23, 24, 51, 1651266000, 1651608268, 1651608268, NULL),
       (24, 25, 57, 1651266000, 1651608268, 1651608268, NULL),
       (25, 26, 48, 1651266000, 1651608268, 1651608268, NULL),
       (26, 27, 20, 1651266000, 1651608268, 1651608268, NULL),
       (27, 28, 64, 1651266000, 1651608268, 1651608268, NULL),
       (28, 29, 23, 1651266000, 1651608268, 1651608268, NULL),
       (29, 30, 30, 1651266000, 1651608268, 1651608268, NULL),
       (30, 31, 73, 1651266000, 1651608268, 1651608268, NULL),
       (31, 32, 73, 1651266000, 1651608268, 1651608268, NULL),
       (32, 33, 45, 1651266000, 1651608268, 1651608268, NULL),
       (33, 34, 57, 1651266000, 1651608268, 1651608268, NULL),
       (34, 35, 55, 1651266000, 1651608268, 1651608268, NULL);
COMMIT;

-- ----------------------------
-- Records of ax_document_coming
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_coming_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_fin_invoice
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_fin_invoice_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_invoice
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_invoice_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_order
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_order_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_refund
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_refund_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_reservation
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_reservation_cancel
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_reservation_cancel_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_reservation_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_sale
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_sale_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_transfer
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_transfer_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_write_off
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_document_write_off_content
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_frm_category
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_frm_message
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_gallery
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_gallery_has_resource
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_gallery_image
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_address
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_favorites
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_history
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_ips
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_jobs
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_jobs_failed
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_letter
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_logger
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_migration
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_page_settings
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_redirect
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_search
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_seo
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_setting
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_main_url
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_menu
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_menu_has_resource
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_menu_item
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_page
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_phone
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_phone_has_resource
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_post
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_post_category
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_render
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_rights_model_has_permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_rights_model_has_roles
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_rights_permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_rights_role_has_permissions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_rights_roles
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_tag
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_tag_has_resource
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_telegram_message
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_telegram_user
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_unit_okei
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_user
-- ----------------------------

-- ----------------------------
-- Records of ax_user_guest
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_user_profile
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_user_token
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_wallet
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_wallet_currency
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_wallet_transaction
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_wallet_transaction_subject
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets_has_resource
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets_has_value_decimal
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets_has_value_int
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets_has_value_text
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets_has_value_varchar
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets_property
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets_property_group
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets_property_has_group
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Records of ax_widgets_property_type
-- ----------------------------
BEGIN;
COMMIT;

SET
FOREIGN_KEY_CHECKS = 1;
