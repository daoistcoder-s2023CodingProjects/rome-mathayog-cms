-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: rome-mathayog-cms-db
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `video_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lesson_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `videos_lesson_id_foreign` (`lesson_id`),
  CONSTRAINT `videos_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
INSERT INTO `videos` VALUES (2,'Video 2','https://drive.google.com/file/d/1RwI5mmcam0yziqj9u9BN910NbGurwDxN/preview','Counting Numbers to 1,000 Using Blocks',2,NULL,'2023-10-30 17:12:14'),(3,'Video 3','https://drive.google.com/file/d/1XctieZEJvcnCvQlFqQpTe82T0qurIjn8/preview','Counting Numbers to 1,000 Using Blocks',13,NULL,'2023-10-30 16:29:48'),(4,'Video  1','https://drive.google.com/file/d/12vg-Equ1oAuoeQo2X0pHpLtBbbMlG8ym/preview','Video  1 for Counting to 1,000',1,'2023-10-24 23:02:05','2023-10-30 17:36:56'),(5,'Video 4','yjUklUFcEABosYFG5tqoZSWpTAxaIV-metaaHVuZHJlZHMuUE5H-.png','this is a video yeah',NULL,'2023-10-26 14:17:37','2023-10-26 14:17:37'),(12,'Video 1','https://docs.google.com/presentation/d/1sJTkT3L5-pmCXGOX4bfp50CCPo4e_VnhI1VPs34F-YI/edit?usp=drive_link','Identifying Numbers to 1,000 Using Place Values',3,'2023-10-30 17:45:20','2023-10-30 17:45:20'),(13,'Video 2','https://docs.google.com/presentation/d/1Y-rD3lDs3BQtzneGuWRk5XYU8CjkQzs0wF2gYCF5JCc/edit#slide=id.g28de2a204a1_0_0','Identifying Numbers to 1,000 Using Place Values',3,'2023-10-30 17:45:20','2023-10-30 17:45:20'),(14,'Video 1','https://drive.google.com/file/d/1XraiyzqYHfyquiZ91mgYJwimsJg4exjW/preview','Illustrating Numbers to 1,000 Using Blocks',15,'2023-10-30 17:52:30','2023-10-30 17:52:30'),(15,'Video 2','https://drive.google.com/file/d/1tqM0Hs5ZRQsDTqxbzuypL2BYa7E4r-Og/preview','Illustrating Numbers to 1,000 Using Blocks',15,'2023-10-30 17:52:30','2023-10-30 17:52:30');
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-31 10:38:19
