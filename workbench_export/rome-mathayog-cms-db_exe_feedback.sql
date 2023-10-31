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
-- Table structure for table `exe_feedback`
--

DROP TABLE IF EXISTS `exe_feedback`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exe_feedback` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exercise_feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exe_choice_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exe_feedback_exe_choice_id_foreign` (`exe_choice_id`),
  CONSTRAINT `exe_feedback_exe_choice_id_foreign` FOREIGN KEY (`exe_choice_id`) REFERENCES `exe_choices` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exe_feedback`
--

LOCK TABLES `exe_feedback` WRITE;
/*!40000 ALTER TABLE `exe_feedback` DISABLE KEYS */;
INSERT INTO `exe_feedback` VALUES (1,'Good job!',1,NULL,'2023-10-30 15:49:59'),(2,'Nice try!',2,NULL,'2023-10-30 15:50:39'),(3,'Nice try!',3,'2023-10-30 15:55:41','2023-10-30 15:55:41'),(4,'Good job!',4,'2023-10-30 15:55:41','2023-10-30 15:55:41'),(5,'Nice try!',5,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(6,'Good job!',6,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(7,'Nice try!',7,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(8,'Good job!',8,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(9,'Good job!',9,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(10,'Nice try!',10,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(11,'Nice try!',11,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(12,'Good job!',12,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(13,'Good job!',13,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(14,'Nice try!',14,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(15,'Nice try!',15,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(16,'Good job!',16,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(17,'Good job!',17,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(18,'Nice try!',18,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(19,'Nice try!',19,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(20,'Good job!',20,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(21,'Good job!',21,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(22,'Nice try!',22,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(23,'Nice try!',23,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(24,'Good job!',24,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(25,'Good job!',25,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(26,'Good job!',26,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(27,'Good job!',27,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(28,'Nice try!',28,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(29,'Nice try!',29,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(30,'Good job!',30,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(31,'Good job!',31,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(32,'Good job!',32,'2023-10-30 18:35:33','2023-10-30 18:35:33');
/*!40000 ALTER TABLE `exe_feedback` ENABLE KEYS */;
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
