DROP DATABASE IF EXISTS `futures_bazaar`;

/**********************************
* Basics - setting up a database *
**********************************/
CREATE DATABASE futures;

# RENAME DATABASE futures TO futures_bazaar; #not valid
SHOW DATABASES;
DROP DATABASE futures;
CREATE DATABASE futures_bazaar;
USE futures_bazaar;


/********************
* Creating a table *
********************/

/**
General tips on table definitions:

- choose the smallest data type that you don’t think you’ll exceed.
- avoid NULL if possible (NULL values make queries harder to optimize and comparisons difficult)
- INT types can optionally have the UNSIGNED attribute, which disallows negative values
and ~ doubles the upper limit of positive values you can store. E.g., a TINYINT UNSIGNED
can store values ranging from 0 to 255 instead of from −128 to 127
- INT(1) and INT(20) are the same thing, the number is a format hint specifying
the number of characters that tools (like the console) will reserve for display purposes.
- Check actual storage requirements here: https://dev.mysql.com/doc/refman/8.0/en/storage-requirements.html
- For VARCHAR columns, size matters, apparently - a larger column can use much more memory,
because MySQL often allocates fixed-size chunks of memory to hold values internally.
*/

CREATE TABLE `product` ( # table names are singular!
  `id`    INT(11)       UNSIGNED NOT NULL     AUTO_INCREMENT COMMENT 'Product ID',
  `name`  VARCHAR(255)           NOT NULL     DEFAULT ''     COMMENT 'Product Name', # variable-length string
  `price` DECIMAL(12,4)          DEFAULT NULL                COMMENT 'Price',        # 12 digits max, of which 4 decimals
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COMMENT='Product Table';


# Character set = set of symbols and encodings. Collation = set of rules for comparing characters in a character set.
# If not specified, the default settings will be used.
SHOW VARIABLES LIKE 'char%';
SHOW CHARACTER SET WHERE CHARSET = 'utf8'; #default collation for utf8 charset.


/*************************************
* Finding out details about a table *
*************************************/
DESCRIBE `product`;
SHOW CREATE TABLE `product`;


/********************
* Deleting a table *
********************/
DROP TABLE `product`;


/*********************************
* Inserting values into a table *
*********************************/
INSERT INTO `product` (`name`, `price`)
VALUES ('Programmer', 1000000), ('Dictator', 150), ('Athlete', 180.50),
  ('Scientist', 200), ('Cat', 1500), ('Horror from beyond spacetime', 9000), ('Jewel-covered bridge troll', 200),
  ('Mother of Mechanical Beetles', 3000), ('Father of Weaponized Hedgehogs', 3000), ('Death', 1500),
  ('Fire-breathing fruitfly', 20), ('Time golem', 4000), ('Dark Lord', 2000), ('Dark Queen', 2000),
  ('Mildly dim knight with heart of gold', 5), ('Evil witch with dark dark dark intentions', 750),
  ('Half-wyvern half-library', 3000), ('Scientist', 700), ('Failed scientific experiment', 1);

/******************************
* Updating values in a table *
******************************/
UPDATE `product` SET `price` = 290 WHERE `name` = 'scientist'; #case-insensitive!

INSERT INTO `product` (`id`,`name`, `price`)
VALUES (10000, 'PHP programmer', 5000)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `price` = VALUES(`price`); #VALUES(name) means you are using the value in the insert statement

/************************************************************************************************
* Deleting values from a table                                                                 *
*                                                                                              *
* Tip: to make sure you're unable to run an update or delete statement without a where clause, *
* connect to the database with the --i-am-a-dummy flag (not a joke)                            *
************************************************************************************************/
TRUNCATE `product`;
DELETE FROM `product` WHERE `name` = 'cat';
DELETE FROM `product` WHERE `id` = (SELECT `id` FROM `product` WHERE `name` = 'cat');


/****************************************
* Selecting values from a single table *
****************************************/
SELECT * FROM `product`;
#SELECT * FROM `product` \G - which I can't run here, but you try it in the console
SELECT `id`, `name` FROM `product` LIMIT 5;
SELECT `id`, `name` FROM `product` LIMIT 2 OFFSET 2; #pagination anyone?
SELECT DISTINCT `name`, `price` FROM `product`;
SELECT * FROM  `product` ORDER BY `price` ASC, `name` DESC;
SELECT * FROM `product` WHERE `name` LIKE 'sc%';
SELECT GROUP_CONCAT(`name` SEPARATOR ' +++ ') AS 'names_list', COUNT(`id`) AS 'group_size', `price` FROM `product` GROUP BY `price` HAVING COUNT(`id`) > 1 AND `price` < 3000;
SELECT SUM(`price`) FROM `product` WHERE `id` BETWEEN 8 AND 9;
SELECT `id`, `name`, `price` FROM `product` WHERE price BETWEEN 200 AND 1500;

/****************************************************************
* Fulltext search features                                     *
*                                                              *
* https://dev.mysql.com/doc/refman/8.0/en/fulltext-search.html *
****************************************************************/
ALTER TABLE `product` ADD FULLTEXT INDEX `fulltext_idx` (`name`);
SELECT * FROM `product` WHERE MATCH (`name`) AGAINST ('+dark -queen' IN BOOLEAN MODE);
SELECT * FROM `product` WHERE MATCH (`name`) AGAINST ('"horror spacetime" @6' IN BOOLEAN MODE); #words in total, not between
SELECT `name`, MATCH (`name`) AGAINST ('dark' IN NATURAL LANGUAGE MODE ) AS `score` FROM (`product`) ORDER BY `score` DESC;
ALTER TABLE `product` DROP INDEX `fulltext_idx`;


/***************************
* Foreign key constraints *
***************************/
CREATE TABLE `rating` (
  `id`          INT(11) UNSIGNED NOT NULL     AUTO_INCREMENT COMMENT 'Rating ID',
  `product_id`  INT(11) UNSIGNED NOT NULL                    COMMENT 'Product ID',
  `value`       TINYINT UNSIGNED DEFAULT NULL                COMMENT 'Rating value',
  FOREIGN KEY (`product_id`) REFERENCES `product`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (`id`)
);

INSERT INTO `rating` (`product_id`, `value`) VALUES (5000, 5); # fails because of constraint
INSERT INTO `rating` (`product_id`, `value`) VALUES (1, 5); # now we're talking
DELETE FROM `product` WHERE `id` = 1;
INSERT INTO `rating` (`product_id`, `value`) VALUES (2, 5);
UPDATE `product` SET `id` = 70 WHERE `id` = 2;

INSERT INTO `rating` (`product_id`, `value`) VALUES (4, 4), (6, 4), (7, 3), (10, 2), (12, 5), (17, 10), (18, 0);

/************************************************************************************************************
* So ... why not add rating column to product table directly?                                              *
* Because then, with every new rating, we'd need a new row duplicating all product data except for rating. *
*                                                                                                          *
* The concept we're after is normalization. In a normalized database, each piece of info is                *
* represented only once (cons: expensive joins). Conversely, in a denormalized database, info              *
* is duplicated, or stored in multiple places. (cons: everything but performance).                         *
************************************************************************************************************/
CREATE TABLE `user` (
  `id`          INT(11)      UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User ID',
  `email`       VARCHAR(255)          NOT NULL                COMMENT 'Email',
  `name`        VARCHAR(255)          NOT NULL                COMMENT 'Name',
  `password`    CHAR(32)              NOT NULL                COMMENT 'Password', # assume md5() is used on passwords, which results in a 32-char long string
  PRIMARY KEY (`id`)
);

ALTER TABLE `rating` ADD `user_id` INT(11) UNSIGNED DEFAULT NULL;
DESCRIBE `rating`; # meh, could we add the column after user_id instead?
ALTER TABLE `rating` DROP COLUMN `user_id`;
ALTER TABLE `rating` ADD `user_id` INT(11) UNSIGNED DEFAULT NULL AFTER `product_id`;
ALTER TABLE `rating` ADD FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON UPDATE CASCADE ON DELETE SET NULL;
ALTER TABLE `rating` DROP FOREIGN KEY `rating_ibfk_2`;
SHOW CREATE TABLE `rating`;

INSERT INTO `user` (`email`, `name`, `password`) VALUES ('testuser@test.com', 'testuser', MD5('testuser'));
SELECT * FROM `user`;

INSERT INTO `rating` (`product_id`, `user_id`, `value`) VALUES (1, 5, 1); # fails!
INSERT INTO `rating` (`product_id`, `user_id`, `value`) VALUES (5, 1, 10);
DELETE FROM `user` WHERE `id` = 1;

# careful with null values!
SELECT 1 IS NULL, 1 IS NOT NULL;
SELECT 1 = NULL, 1 <> NULL, 1 < NULL, 1 > NULL, NULL = NULL;

# and yes, you can select function results
SELECT NOW();

# check the results of the following queries:
SELECT * FROM `rating`;
SELECT * FROM `rating` WHERE `user_id` = NULL;
SELECT * FROM `rating` WHERE `user_id` != 65;
SELECT * FROM `rating` WHERE `user_id` IS NOT NULL;
SELECT * FROM `rating` WHERE (`user_id` != 65 OR `user_id` IS NULL);

/*******************************************************************************************
* Transactions - read about ACID -> https://en.wikipedia.org/wiki/ACID_(computer_science) *
*******************************************************************************************/
START TRANSACTION;
INSERT INTO `user` (`id`, `email`, `name`, `password`) VALUES (65, 'successful_transaction@winner.com', 'success', MD5('success'));
INSERT INTO `rating` (`product_id`, `user_id`, `value`) VALUES (5, 65, 199);
COMMIT;

START TRANSACTION;
INSERT INTO `user` (`id`, `email`, `name`, `password`) VALUES (350, 'failed_transaction@loser.com', 'fail', MD5('fail'));
INSERT INTO `rating` (`product_id`, `user_id`, `value`) VALUES (12, 350, 2);
ROLLBACK;

/*********************************************
* Joins                                      *
*                                            *
* https://www.w3schools.com/sql/sql_join.asp *
**********************************************/
# inner
SELECT *
FROM `user`
  INNER JOIN `rating` ON `user`.`id` = `rating`.id
  INNER JOIN `product` ON `rating`.`product_id` = `product`.`id`;

# left
SELECT *
FROM `user`
  LEFT JOIN `rating` ON `user`.`id` = `rating`.user_id
  LEFT JOIN `product` ON `rating`.`product_id` = `product`.`id`;

# right
SELECT * FROM `rating` RIGHT JOIN `user` ON rating.`user_id` = `user`.`id`;

# but what questions are we trying to answer?
# which users rated which products and what was the rating?
SELECT `user`.`name` AS 'user_name', `product`.`name` AS product_name, `rating`.`value`
FROM `user`
  INNER JOIN `rating` ON `user`.`id` = `rating`.user_id
  INNER JOIN `product` ON `rating`.`product_id` = `product`.`id`;

# what users do we have? if they submitted ratings, what products did they rate and what was the rating?
SELECT `user`.`name` AS 'user_name', `product`.`name` AS product_name, `rating`.`value`
FROM `user`
  LEFT JOIN `rating` ON `user`.`id` = `rating`.user_id
  LEFT JOIN `product` ON `rating`.`product_id` = `product`.`id`;


/***************************************************************************
 * Exporting a database                                                    *
 * https://dev.mysql.com/doc/refman/8.0/en/mysqldump.html#mysqldump-syntax *
 ***************************************************************************/
# entire database:
# > mysqldump -u user -p [database_name] > [database_name].sql

# specific table:
# > mysqldump -u user -p [database_name] [table_name] > [table_name].sql

# To export only data / only table structures, please check the usage of mysql options --no-data and --no-create-info

/************************
 * Importing a database *
 ************************/
# > mysql -u user -p
# > create [database_name] ** if the dump is of an entire database, skip this step if the export is of a single table **

# VERSION A
# > use [database_name]
# > source [path to export file]

# VERSION B
# exit;
# > mysql -u user -p [database_name] < [path to export file].sql
