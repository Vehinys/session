-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de table session. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.category : ~4 rows (environ)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'BUREAUTIQUE'),
	(2, 'DEV WEB'),
	(3, 'DESIGN'),
	(4, 'COMPTA');

-- Listage de la structure de table session. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table session. programme
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int DEFAULT NULL,
  `unit_id` int DEFAULT NULL,
  `nb_days` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  KEY `IDX_3DDCB9FFF8BD700D` (`unit_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFF8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.programme : ~17 rows (environ)
INSERT INTO `programme` (`id`, `session_id`, `unit_id`, `nb_days`) VALUES
	(1, 1, 2, 30),
	(2, 5, 1, 2),
	(3, 5, 2, 2),
	(4, 5, 7, 4),
	(5, 5, 8, 4),
	(6, 5, 9, 3),
	(7, 2, 1, 6),
	(8, 2, 2, 6),
	(9, 3, 7, 10),
	(10, 3, 8, 10),
	(11, 3, 9, 10),
	(12, 4, 1, 2),
	(13, 4, 2, 2),
	(14, 4, 3, 1),
	(15, 6, 4, 45),
	(16, 6, 5, 15),
	(17, 6, 6, 30);

-- Listage de la structure de table session. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_session` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `end_session` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `nb_places` int NOT NULL,
  `nb_places_reserved` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.session : ~6 rows (environ)
INSERT INTO `session` (`id`, `name`, `start_session`, `end_session`, `nb_places`, `nb_places_reserved`) VALUES
	(1, 'Initiation Comptabilité', '2018-06-10', '2018-07-20', 10, 2),
	(2, 'Initiation à Word et Excel', '2018-06-17', '2018-06-29', 8, 3),
	(3, 'Initiation infographie ( PS, INDD, AI )', '2018-06-17', '2018-07-20', 10, 1),
	(4, 'Perfectionnement Word, Excel,Powerpoint', '2018-07-08', '2018-07-12', 10, 1),
	(5, 'Initiation Bureautique et infographie', '2018-07-12', '2018-08-07', 10, 1),
	(6, 'Initiation en PHP / SQL', '2018-09-01', '2018-12-12', 12, 2);

-- Listage de la structure de table session. trainee
CREATE TABLE IF NOT EXISTS `trainee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_birth` date NOT NULL COMMENT '(DC2Type:date_immutable)',
  `town` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.trainee : ~2 rows (environ)
INSERT INTO `trainee` (`id`, `name`, `first_name`, `sex`, `date_birth`, `town`, `email`, `telephone`) VALUES
	(1, 'LECOMTE', 'Albert', 'Homme', '1989-07-13', 'MULHOUSE', 'albert.lecomte1989@gmail.com', '06 00 00 00 00'),
	(2, 'MURMANN', 'Mickael', 'Homme', '1985-01-17', 'STRASBOURG', 'mickael.murmann@gmail.com', '06 00 00 00 00'),
	(12, 'MAURUTTO', 'Geoffroy', 'Homme', '2000-06-15', 'DIDENHEIM', 'maurutto.geoffroy@gmail.com', '06 00 00 00 00'),
	(13, 'AYACHE', 'Kenza', 'Femme', '2003-02-21', 'Saint-Louis', 'ayache.kenza@gmail.com', '06 00 00 00 00'),
	(14, 'FRANCK', 'Pauline', 'Femme', '1995-02-26', 'Mulhouse', 'franck.pauline@gmail.com', '06 00 00 00 00'),
	(16, 'MONTMIRAIL', 'Anthony', 'Homme', '1983-06-08', 'Colmar', 'montmirail.anthony@gmail.com', '06 00 00 00 00');

-- Listage de la structure de table session. trainee_session
CREATE TABLE IF NOT EXISTS `trainee_session` (
  `trainee_id` int NOT NULL,
  `session_id` int NOT NULL,
  PRIMARY KEY (`trainee_id`,`session_id`),
  KEY `IDX_D4DAC3A336C682D0` (`trainee_id`),
  KEY `IDX_D4DAC3A3613FECDF` (`session_id`),
  CONSTRAINT `FK_D4DAC3A336C682D0` FOREIGN KEY (`trainee_id`) REFERENCES `trainee` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D4DAC3A3613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.trainee_session : ~6 rows (environ)
INSERT INTO `trainee_session` (`trainee_id`, `session_id`) VALUES
	(1, 3),
	(1, 4),
	(1, 6),
	(2, 1),
	(2, 2),
	(2, 5),
	(12, 2),
	(12, 3),
	(12, 6),
	(13, 3),
	(13, 5),
	(13, 6),
	(14, 1),
	(14, 2),
	(14, 6),
	(16, 1),
	(16, 3),
	(16, 4),
	(16, 6);

-- Listage de la structure de table session. unit
CREATE TABLE IF NOT EXISTS `unit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DCBB0C5312469DE2` (`category_id`),
  CONSTRAINT `FK_DCBB0C5312469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table session.unit : ~9 rows (environ)
INSERT INTO `unit` (`id`, `name`, `category_id`) VALUES
	(1, 'Word', 1),
	(2, 'Excel', 1),
	(3, 'PowerPoint', 1),
	(4, 'PHP', 2),
	(5, 'SQL', 2),
	(6, 'JavaScript', 2),
	(7, 'Photoshop', 3),
	(8, 'Illustrator', 3),
	(9, 'InDesign', 3);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
