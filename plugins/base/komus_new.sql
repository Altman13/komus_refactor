-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.1.37-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win32
-- HeidiSQL Версия:              10.2.0.5762
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных komus_new
CREATE DATABASE IF NOT EXISTS `komus_new` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `komus_new`;

-- Дамп структуры для таблица komus_new.calls
CREATE TABLE IF NOT EXISTS `calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `begin_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `recall_time` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `contacts_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_calls_contacts1_idx` (`contacts_id`),
  CONSTRAINT `fk_calls_contacts1` FOREIGN KEY (`contacts_id`) REFERENCES `contacts` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 PACK_KEYS=0 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица komus_new.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_time` datetime DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `organization` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `fio` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `subcategory` varchar(255) DEFAULT NULL,
  `question` text,
  `allow_call` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `comment` text CHARACTER SET cp1251,
  `regions_id` int(11) NOT NULL,
  `users_user_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contacts_regions1_idx` (`regions_id`),
  KEY `fk_contacts_users1_idx` (`users_user_id`),
  CONSTRAINT `fk_contacts_regions1` FOREIGN KEY (`regions_id`) REFERENCES `regions` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_contacts_users1` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 PACK_KEYS=0 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица komus_new.groups_users
CREATE TABLE IF NOT EXISTS `groups_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groups` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gru_groupid` (`id`),
  KEY `gru_userid` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица komus_new.maillog
CREATE TABLE IF NOT EXISTS `maillog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `DATETIME_` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log` text NOT NULL,
  `contacts_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_maillog_contacts1_idx` (`contacts_id`),
  CONSTRAINT `fk_maillog_contacts1` FOREIGN KEY (`contacts_id`) REFERENCES `contacts` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 PACK_KEYS=0 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица komus_new.regions
CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `subcode` tinyint(2) unsigned DEFAULT NULL,
  `timezone_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_regions_timezones1_idx` (`timezone_id`),
  CONSTRAINT `fk_regions_timezones1` FOREIGN KEY (`timezone_id`) REFERENCES `timezone` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица komus_new.timezone
CREATE TABLE IF NOT EXISTS `timezone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица komus_new.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(100) CHARACTER SET utf8 NOT NULL,
  `user_password` varchar(32) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(64) CHARACTER SET utf8 NOT NULL,
  `user_firstname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_lastname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_gender` enum('мужчина','женщина','не указано') CHARACTER SET utf8 NOT NULL DEFAULT 'не указано',
  `user_birthdate` date DEFAULT NULL,
  `user_lastvisit` datetime DEFAULT NULL,
  `user_ban` tinyint(1) DEFAULT NULL,
  `timezone_id` int(11) NOT NULL,
  `groups_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_password` (`user_password`),
  KEY `fk_users_timezones_idx` (`timezone_id`),
  KEY `fk_users_groups_users1_idx` (`groups_id`),
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`groups_id`) REFERENCES `groups_users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_users_timezones` FOREIGN KEY (`timezone_id`) REFERENCES `timezone` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Экспортируемые данные не выделены.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
