# ************************************************************
# Sequel Pro SQL dump
# Version 5426
#
# https://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 8.0.13)
# Database: books
# Generation Time: 2020-02-11 11:38:58 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Block
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Block`;

CREATE TABLE `Block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `Block` WRITE;
/*!40000 ALTER TABLE `Block` DISABLE KEYS */;

INSERT INTO `Block` (`id`, `created_at`, `updated_at`, `visible`, `name`)
VALUES
	(2,NULL,NULL,1,'slider_block');

/*!40000 ALTER TABLE `Block` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table BlockTranslation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `BlockTranslation`;

CREATE TABLE `BlockTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `BlockTranslation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_2B6C4AD62C2AC5D3` (`translatable_id`),
  CONSTRAINT `FK_2B6C4AD62C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `block` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `BlockTranslation` WRITE;
/*!40000 ALTER TABLE `BlockTranslation` DISABLE KEYS */;

INSERT INTO `BlockTranslation` (`id`, `translatable_id`, `content`, `title`, `locale`)
VALUES
	(1,2,'<p>Контент блок</p>','Контент тайтл','ru'),
	(2,2,'<p>Contenten Block</p>','Contenten Block','de'),
	(3,2,'<p>Content Block</p>','Content Title','en');

/*!40000 ALTER TABLE `BlockTranslation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Feedback
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Feedback`;

CREATE TABLE `Feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `Feedback` WRITE;
/*!40000 ALTER TABLE `Feedback` DISABLE KEYS */;

INSERT INTO `Feedback` (`id`, `firstname`, `lastname`, `email`, `phone`, `message`)
VALUES
	(1,'Dmitry','Sazonov','sazon@nxt.ru','+79889917443','Message'),
	(2,'Dmitry','Sazonov','sazon@nxt.ru','+79889917443','Message');

/*!40000 ALTER TABLE `Feedback` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migration_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration_versions`;

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;

INSERT INTO `migration_versions` (`version`, `executed_at`)
VALUES
	('20200203121427','2020-02-03 12:14:35'),
	('20200204072504','2020-02-04 07:25:26'),
	('20200211072358','2020-02-11 07:24:14');

/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Page
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Page`;

CREATE TABLE `Page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_keywords` longtext COLLATE utf8_unicode_ci,
  `meta_description` longtext COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `visible` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `Page` WRITE;
/*!40000 ALTER TABLE `Page` DISABLE KEYS */;

INSERT INTO `Page` (`id`, `meta_keywords`, `meta_description`, `created`, `updated`, `visible`)
VALUES
	(1,'Meta','Meta',NULL,NULL,1),
	(2,NULL,NULL,NULL,NULL,1),
	(3,NULL,NULL,NULL,NULL,1);

/*!40000 ALTER TABLE `Page` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table PageTranslation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `PageTranslation`;

CREATE TABLE `PageTranslation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `translatable_id` int(11) DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `PageTranslation_unique_translation` (`translatable_id`,`locale`),
  KEY `IDX_D29B35C02C2AC5D3` (`translatable_id`),
  CONSTRAINT `FK_D29B35C02C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `page` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `PageTranslation` WRITE;
/*!40000 ALTER TABLE `PageTranslation` DISABLE KEYS */;

INSERT INTO `PageTranslation` (`id`, `translatable_id`, `content`, `title`, `name`, `locale`)
VALUES
	(1,1,'<p>Контент статьи&nbsp;</p>\r\n\r\n<p>[slider_block][other_block]</p>','Заголовок','Наименование','ru'),
	(2,1,'<p>Artikelinhalt</p>\r\n\r\n<p>[slider_block][other_block]</p>','Überschrift','Bezeichnung','de'),
	(3,1,'<p>Content of page</p>\r\n\r\n<p>[slider_block][other_block]</p>','Title','Name','en'),
	(4,2,'<p>О нас контент</p>','О нас заголовок','О нас наименование','ru'),
	(5,2,'<p>Ou nasen contenten</p>','Ou nasent zagolovken','Ou nasen naimenovanien','de'),
	(6,2,'<p>About us</p>',NULL,NULL,'en'),
	(7,3,'<pre>\r\nЦель и задачи проектного офиса</pre>','Цель и задачи проектного офиса Заголовок','Цель и задачи проектного офиса имя','ru'),
	(8,3,'<p>Goalsen und projecten headen oficen</p>','Goalsen und projecten headen oficen title','Goalsen und projecten headen oficen name','de'),
	(9,3,'<p>Goals and tasks projects office</p>','Goals and tasks projects office title','Goals and tasks projects office name','en');

/*!40000 ALTER TABLE `PageTranslation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table PageUrl
# ------------------------------------------------------------

DROP TABLE IF EXISTS `PageUrl`;

CREATE TABLE `PageUrl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_69819C0681257D5D` (`entity_id`),
  CONSTRAINT `FK_69819C0681257D5D` FOREIGN KEY (`entity_id`) REFERENCES `page` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `PageUrl` WRITE;
/*!40000 ALTER TABLE `PageUrl` DISABLE KEYS */;

INSERT INTO `PageUrl` (`id`, `entity_id`, `url`, `created`)
VALUES
	(1,NULL,'фывафывафыва/','2020-02-10 17:51:51'),
	(2,NULL,'asdfasdf/','2020-02-10 17:52:45'),
	(3,NULL,'test/','2020-02-10 18:16:19'),
	(4,NULL,'asdfasdf123/','2020-02-10 18:34:24'),
	(5,1,'projects/','2020-02-11 11:23:49'),
	(6,2,'about-us/','2020-02-11 14:32:24'),
	(7,3,'goals-and-tasks/','2020-02-11 14:34:04');

/*!40000 ALTER TABLE `PageUrl` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D5428AEDE7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `roles`, `password`, `gender`, `firstname`, `lastname`, `created`, `phone`)
VALUES
	(1,'sazon@nxt.ru','[\"ROLE_ADMIN\"]','$argon2id$v=19$m=65536,t=4,p=1$DZAgbZILN/WNkSbZXmiKtg$tbUZECLAT8ZS96d0EAxDrguJTsNfPkRR65tyXqS0c8g',NULL,NULL,NULL,'2020-02-03 13:32:54',NULL),
	(2,'kudinov_kirill@mail.ru','[\"ROLE_ADMIN\"]','$argon2id$v=19$m=65536,t=4,p=1$JBvY7talpew+DpoTs12Iqg$Hp2XXbpOP2k5pSBjwAKCzHFb+Gs3OGvaqvbgK7M157Q',NULL,NULL,NULL,'2020-02-03 13:32:56',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
