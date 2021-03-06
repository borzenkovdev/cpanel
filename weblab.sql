-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.37 - MySQL Community Server (GPL)
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных weblab
CREATE DATABASE IF NOT EXISTS `weblab` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `weblab`;

-- Дамп структуры для таблица weblab.buttons
CREATE TABLE IF NOT EXISTS `buttons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) NOT NULL,
  `perform_on` varchar(50) NOT NULL,
  `perform_off` varchar(50) NOT NULL,
  `program` varchar(50) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы weblab.buttons: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `buttons` DISABLE KEYS */;
INSERT INTO `buttons` (`id`, `position`, `perform_on`, `perform_off`, `program`, `updated_at`) VALUES
	(1, 1, 'on', 'off', 'BathroomLight', '2017-10-19 23:30:35'),
	(2, 2, 'open', 'close', 'Door', NULL),
	(3, 3, 'open', 'close', 'Garage', NULL),
	(4, 4, 'on', 'off', 'Macros', '2017-10-20 08:29:53'),
	(5, 5, 'turnOn', 'turnOff', 'Jacuzzi', NULL),
	(6, 6, 'up', 'down', 'Jalousie', NULL),
	(7, 7, 'on', 'off', 'Kettle', NULL);
/*!40000 ALTER TABLE `buttons` ENABLE KEYS */;

-- Дамп структуры для таблица weblab.operations
CREATE TABLE IF NOT EXISTS `operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `button_id` int(11) DEFAULT NULL,
  `prev_action` varchar(50) DEFAULT NULL,
  `program` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы weblab.operations: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `operations` DISABLE KEYS */;
INSERT INTO `operations` (`id`, `button_id`, `prev_action`, `program`, `created_at`) VALUES
	(50, 7, 'perform_off', 'Kettle', '2017-10-20 08:22:57'),
	(55, 4, 'perform_off', 'Macros', '2017-10-20 08:30:01'),
	(56, 4, 'perform_off', 'Macros', '2017-10-20 08:32:09'),
	(57, 4, 'perform_off', 'Macros', '2017-10-20 08:33:04'),
	(58, 4, 'perform_on', 'Macros', '2017-10-20 08:33:09');
/*!40000 ALTER TABLE `operations` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
