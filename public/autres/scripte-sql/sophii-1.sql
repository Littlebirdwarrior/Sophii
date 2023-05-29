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


-- Listage de la structure de la base pour sophii
DROP DATABASE IF EXISTS `sophii`;
CREATE DATABASE IF NOT EXISTS `sophii` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sophii`;

-- Listage de la structure de table sophii. activite
DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupeconsignes_id` int DEFAULT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B875551532465C36` (`groupeconsignes_id`),
  CONSTRAINT `FK_B875551532465C36` FOREIGN KEY (`groupeconsignes_id`) REFERENCES `groupe_consignes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.activite : ~0 rows (environ)

-- Listage de la structure de table sophii. activite_feuille_route
DROP TABLE IF EXISTS `activite_feuille_route`;
CREATE TABLE IF NOT EXISTS `activite_feuille_route` (
  `activite_id` int NOT NULL,
  `feuille_route_id` int NOT NULL,
  PRIMARY KEY (`activite_id`,`feuille_route_id`),
  KEY `IDX_6EF2BF3D9B0F88B1` (`activite_id`),
  KEY `IDX_6EF2BF3DAC0556AA` (`feuille_route_id`),
  CONSTRAINT `FK_6EF2BF3D9B0F88B1` FOREIGN KEY (`activite_id`) REFERENCES `activite` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_6EF2BF3DAC0556AA` FOREIGN KEY (`feuille_route_id`) REFERENCES `feuille_route` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.activite_feuille_route : ~0 rows (environ)

-- Listage de la structure de table sophii. activite_groupe_competences
DROP TABLE IF EXISTS `activite_groupe_competences`;
CREATE TABLE IF NOT EXISTS `activite_groupe_competences` (
  `activite_id` int NOT NULL,
  `groupe_competences_id` int NOT NULL,
  PRIMARY KEY (`activite_id`,`groupe_competences_id`),
  KEY `IDX_E7CBAD469B0F88B1` (`activite_id`),
  KEY `IDX_E7CBAD46C1218EC1` (`groupe_competences_id`),
  CONSTRAINT `FK_E7CBAD469B0F88B1` FOREIGN KEY (`activite_id`) REFERENCES `activite` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_E7CBAD46C1218EC1` FOREIGN KEY (`groupe_competences_id`) REFERENCES `groupe_competences` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.activite_groupe_competences : ~0 rows (environ)

-- Listage de la structure de table sophii. bulletin
DROP TABLE IF EXISTS `bulletin`;
CREATE TABLE IF NOT EXISTS `bulletin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `niveau_id` int DEFAULT NULL,
  `trimeste` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2B7D8942B3E9C81` (`niveau_id`),
  CONSTRAINT `FK_2B7D8942B3E9C81` FOREIGN KEY (`niveau_id`) REFERENCES `niveau` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.bulletin : ~0 rows (environ)

-- Listage de la structure de table sophii. bulletin_groupe_competences
DROP TABLE IF EXISTS `bulletin_groupe_competences`;
CREATE TABLE IF NOT EXISTS `bulletin_groupe_competences` (
  `bulletin_id` int NOT NULL,
  `groupe_competences_id` int NOT NULL,
  PRIMARY KEY (`bulletin_id`,`groupe_competences_id`),
  KEY `IDX_A0016ADAD1AAB236` (`bulletin_id`),
  KEY `IDX_A0016ADAC1218EC1` (`groupe_competences_id`),
  CONSTRAINT `FK_A0016ADAC1218EC1` FOREIGN KEY (`groupe_competences_id`) REFERENCES `groupe_competences` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A0016ADAD1AAB236` FOREIGN KEY (`bulletin_id`) REFERENCES `bulletin` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.bulletin_groupe_competences : ~0 rows (environ)

-- Listage de la structure de table sophii. classe
DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.classe : ~1 rows (environ)
INSERT INTO `classe` (`id`) VALUES
	(1);

-- Listage de la structure de table sophii. competence
DROP TABLE IF EXISTS `competence`;
CREATE TABLE IF NOT EXISTS `competence` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groupecompetences_id` int DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `acquisition` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_94D4687F9545A4ED` (`groupecompetences_id`),
  CONSTRAINT `FK_94D4687F9545A4ED` FOREIGN KEY (`groupecompetences_id`) REFERENCES `groupe_competences` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.competence : ~0 rows (environ)

-- Listage de la structure de table sophii. consigne
DROP TABLE IF EXISTS `consigne`;
CREATE TABLE IF NOT EXISTS `consigne` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.consigne : ~0 rows (environ)

-- Listage de la structure de table sophii. consigne_groupe_consignes
DROP TABLE IF EXISTS `consigne_groupe_consignes`;
CREATE TABLE IF NOT EXISTS `consigne_groupe_consignes` (
  `consigne_id` int NOT NULL,
  `groupe_consignes_id` int NOT NULL,
  PRIMARY KEY (`consigne_id`,`groupe_consignes_id`),
  KEY `IDX_720806A58C063686` (`consigne_id`),
  KEY `IDX_720806A59F75AFC2` (`groupe_consignes_id`),
  CONSTRAINT `FK_720806A58C063686` FOREIGN KEY (`consigne_id`) REFERENCES `consigne` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_720806A59F75AFC2` FOREIGN KEY (`groupe_consignes_id`) REFERENCES `groupe_consignes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.consigne_groupe_consignes : ~0 rows (environ)

-- Listage de la structure de table sophii. doctrine_migration_versions
DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table sophii.doctrine_migration_versions : ~1 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230528215517', '2023-05-28 21:55:36', 840);

-- Listage de la structure de table sophii. eleve
DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `id` int NOT NULL AUTO_INCREMENT,
  `famille_id` int DEFAULT NULL,
  `classe_id` int DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_usage` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` varchar(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anniversaire` datetime DEFAULT NULL,
  `droit_image` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ECA105F797A77B84` (`famille_id`),
  KEY `IDX_ECA105F78F5EA509` (`classe_id`),
  CONSTRAINT `FK_ECA105F78F5EA509` FOREIGN KEY (`classe_id`) REFERENCES `classe` (`id`),
  CONSTRAINT `FK_ECA105F797A77B84` FOREIGN KEY (`famille_id`) REFERENCES `famille` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.eleve : ~3 rows (environ)
INSERT INTO `eleve` (`id`, `famille_id`, `classe_id`, `nom`, `prenom`, `nom_usage`, `genre`, `anniversaire`, `droit_image`) VALUES
	(1, 1, 1, 'Abricot', 'Lili', 'Abricot', '1', '2022-12-28 16:35:48', 1),
	(2, 2, 1, 'Bananier', 'Ben', 'Bananier', '1', '2023-10-29 16:36:54', 1),
	(3, 3, 1, 'Caramel', 'Clem', 'Caramel', '2', '2023-04-19 17:37:54', 2);

-- Listage de la structure de table sophii. enseignant
DROP TABLE IF EXISTS `enseignant`;
CREATE TABLE IF NOT EXISTS `enseignant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `classe_id` int DEFAULT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_usage` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_81A72FA18F5EA509` (`classe_id`),
  CONSTRAINT `FK_81A72FA18F5EA509` FOREIGN KEY (`classe_id`) REFERENCES `classe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.enseignant : ~1 rows (environ)
INSERT INTO `enseignant` (`id`, `classe_id`, `nom`, `prenom`, `nom_usage`, `mail`, `password`, `tel`) VALUES
	(1, 1, 'Crayon', 'Cathy', 'Stylo', 'cc@ecole.fr', '123', '0647648844');

-- Listage de la structure de table sophii. famille
DROP TABLE IF EXISTS `famille`;
CREATE TABLE IF NOT EXISTS `famille` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.famille : ~4 rows (environ)
INSERT INTO `famille` (`id`) VALUES
	(1),
	(2),
	(3),
	(4);

-- Listage de la structure de table sophii. feuille_route
DROP TABLE IF EXISTS `feuille_route`;
CREATE TABLE IF NOT EXISTS `feuille_route` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eleve_id` int DEFAULT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `semaine` int DEFAULT NULL,
  `validation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6EB74052A6CC7B2` (`eleve_id`),
  CONSTRAINT `FK_6EB74052A6CC7B2` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.feuille_route : ~0 rows (environ)

-- Listage de la structure de table sophii. groupe_competences
DROP TABLE IF EXISTS `groupe_competences`;
CREATE TABLE IF NOT EXISTS `groupe_competences` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.groupe_competences : ~0 rows (environ)

-- Listage de la structure de table sophii. groupe_consignes
DROP TABLE IF EXISTS `groupe_consignes`;
CREATE TABLE IF NOT EXISTS `groupe_consignes` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.groupe_consignes : ~0 rows (environ)

-- Listage de la structure de table sophii. messenger_messages
DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table sophii. niveau
DROP TABLE IF EXISTS `niveau`;
CREATE TABLE IF NOT EXISTS `niveau` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.niveau : ~0 rows (environ)

-- Listage de la structure de table sophii. parent_eleve
DROP TABLE IF EXISTS `parent_eleve`;
CREATE TABLE IF NOT EXISTS `parent_eleve` (
  `id` int NOT NULL AUTO_INCREMENT,
  `famille_id` int DEFAULT NULL,
  `authorite` tinyint(1) NOT NULL,
  `qualite` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_usage` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `situation_familiale` int NOT NULL,
  `adresse` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cp` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2090915497A77B84` (`famille_id`),
  CONSTRAINT `FK_2090915497A77B84` FOREIGN KEY (`famille_id`) REFERENCES `famille` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sophii.parent_eleve : ~4 rows (environ)
INSERT INTO `parent_eleve` (`id`, `famille_id`, `authorite`, `qualite`, `nom`, `nom_usage`, `prenom`, `profession`, `situation_familiale`, `adresse`, `cp`, `ville`, `mail`, `tel`, `password`) VALUES
	(1, 1, 1, 'mère', 'Abricot', 'Abricot', 'Julie', 'comptable', 1, '2, rue du Nimp', '67100', 'Nimp', 'abricot@mail.com', '0601020304', '123'),
	(2, 2, 1, 'mère', 'Banane', 'Bananier', 'Coco', 'coiffeuse', 2, '4, rue du Nimp', '87100', 'Nimp', 'banane@mail.com', '0701020304', '123'),
	(3, 2, 1, 'père', 'Bananier', 'Bananier', 'Timeo', 'coiffeur', 2, '4, rue du Nimp', '87100', 'Nimp', 'bananier@mail.com', '0340404040', '123'),
	(4, 3, 1, 'père', 'Caramel', 'Caramel', 'Giono', 'patissier', 1, '5, rue du Truc', 'l-2828', 'Luxembourg', 'caramel@mail.com', '0704515154', '123');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
