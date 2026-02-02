-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               9.5.0 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.13.0.7147
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for quiz_db
DROP DATABASE IF EXISTS `quiz_db`;
CREATE DATABASE IF NOT EXISTS `quiz_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `quiz_db`;

-- Dumping structure for table quiz_db.choices
DROP TABLE IF EXISTS `choices`;
CREATE TABLE IF NOT EXISTS `choices` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int unsigned NOT NULL,
  `choice_text` varchar(500) NOT NULL,
  `is_correct` tinyint unsigned NOT NULL DEFAULT (0),
  PRIMARY KEY (`id`),
  KEY `choice_question` (`question_id`),
  CONSTRAINT `choice_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=333 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table quiz_db.choices: ~0 rows (approximately)
INSERT INTO `choices` (`id`, `question_id`, `choice_text`, `is_correct`) VALUES
	(325, 82, 'yes', 0),
	(326, 82, 'no ', 0),
	(327, 82, 'yes 2', 0),
	(328, 82, 'this is a test, nothing matters', 1);

-- Dumping structure for table quiz_db.questions
DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` int unsigned NOT NULL,
  `question_text` varchar(500) NOT NULL DEFAULT '',
  `media_type` enum('image','video','audio') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `media_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_quiz` (`quiz_id`),
  CONSTRAINT `question_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table quiz_db.questions: ~2 rows (approximately)
INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `media_type`, `media_path`) VALUES
	(82, 45, 'is prune juice best?', 'image', 'uploads/quiz_45/q82.webp');

-- Dumping structure for table quiz_db.quiz_scores
DROP TABLE IF EXISTS `quiz_scores`;
CREATE TABLE IF NOT EXISTS `quiz_scores` (
  `quiz_id` int unsigned NOT NULL,
  `score_id` int unsigned NOT NULL,
  KEY `quiz` (`quiz_id`),
  KEY `score` (`score_id`),
  CONSTRAINT `quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  CONSTRAINT `score` FOREIGN KEY (`score_id`) REFERENCES `scores` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table quiz_db.quiz_scores: ~0 rows (approximately)

-- Dumping structure for table quiz_db.quizzes
DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0',
  `image` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `owner_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_user` (`owner_id`),
  CONSTRAINT `owner_user` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table quiz_db.quizzes: ~2 rows (approximately)
INSERT INTO `quizzes` (`id`, `title`, `description`, `image`, `owner_id`) VALUES
	(45, 'The CRK Quiz!!!', 'THE BEST QUIZ EVER!!!!! cookie run kingdom is so swag and awesome', 'uploads/quiz_45/quiz_image.jpg', 11);

-- Dumping structure for table quiz_db.scores
DROP TABLE IF EXISTS `scores`;
CREATE TABLE IF NOT EXISTS `scores` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `quiz_id` int unsigned NOT NULL,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `amount_correct` int unsigned NOT NULL DEFAULT '0',
  `total_questions` int unsigned NOT NULL DEFAULT '0',
  `time_taken` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `user_id` (`user_id`,`quiz_id`) USING BTREE,
  CONSTRAINT `score_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table quiz_db.scores: ~0 rows (approximately)
INSERT INTO `scores` (`id`, `quiz_id`, `user_id`, `amount_correct`, `total_questions`, `time_taken`) VALUES
	(82, 45, 11, 1, 1, 5);

-- Dumping structure for table quiz_db.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `reset_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `reset_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table quiz_db.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`, `email`, `reset_token`, `reset_expires`) VALUES
	(11, 'admin', '$2y$12$8w3jY7b6HE13yAme7vERS.Zhr7XbvWa5rvLs3TKCxguY/A6PZjq3O', 'egle20161130@gmail.com', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
