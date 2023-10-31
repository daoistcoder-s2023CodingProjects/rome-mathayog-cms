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
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `activity_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `objective` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `solo_framework` enum('Pre-Stractural','Uni-Stractural','Multi-Stractural','Relational','Extended-Abstract') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lesson_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_lesson_id_foreign` (`lesson_id`),
  CONSTRAINT `activities_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (1,'Activity 1','Find the number of tens and ones using the given blocks. ','Uni-Stractural',1,NULL,'2023-10-26 16:39:27'),(2,'Activity 2','Counting numbers to 1,000 using blocks','Uni-Stractural',1,NULL,NULL),(3,'Activity 3','Objective: Identify the number illustrated by base 10 blocks and single blocks. (up to 100)','Uni-Stractural',2,NULL,'2023-10-26 23:29:30'),(4,'Activity 4','Find the number of hundreds using the given blocks. ','Uni-Stractural',13,NULL,'2023-10-30 17:10:38'),(5,'Activity 5','Identify the number illustrated by base 100 blocks, base 10 blocks and single blocks. (up to 1000)','Uni-Stractural',13,NULL,'2023-10-30 16:29:49'),(13,'Activity 1','Identifying the number of blocks using the place value table.','Uni-Stractural',3,'2023-10-30 17:45:20','2023-10-30 17:45:20'),(14,'Activity 2','Identifying the number of blocks using the place value table.','Uni-Stractural',3,'2023-10-30 17:45:20','2023-10-30 17:45:20'),(15,'Activity 3','Identifying the number of blocks using the place value table.','Uni-Stractural',3,'2023-10-30 17:45:20','2023-10-30 17:45:20'),(16,'Activity 1','Illustrate numbers to 100 using blocks','Uni-Stractural',15,'2023-10-30 17:52:30','2023-10-30 17:52:30'),(17,'Activity 2','Illustrate numbers to 1,000 using blocks','Uni-Stractural',15,'2023-10-30 17:52:30','2023-10-30 17:52:30');
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-31 10:38:20
