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
-- Table structure for table `exe_choices`
--

DROP TABLE IF EXISTS `exe_choices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exe_choices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `choice_text` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `choice_graphics` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct` enum('TRUE','FALSE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exe_question_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exe_choices_exe_question_id_foreign` (`exe_question_id`),
  CONSTRAINT `exe_choices_exe_question_id_foreign` FOREIGN KEY (`exe_question_id`) REFERENCES `exe_questions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exe_choices`
--

LOCK TABLES `exe_choices` WRITE;
/*!40000 ALTER TABLE `exe_choices` DISABLE KEYS */;
INSERT INTO `exe_choices` VALUES (1,'a','https://drive.google.com/file/d/12jBz0WIR15Re0EpZbAMx0xdVrhXDJz2t/preview','TRUE',1,NULL,'2023-10-30 15:49:59'),(2,'b','https://drive.google.com/file/d/12j_tRKerxKD_SXhlni5bZZRSj_WAO4nX/preview','FALSE',1,NULL,'2023-10-30 15:50:39'),(3,'a','https://drive.google.com/file/d/12m16z6L9DDeLsTs5VEow9kd1iep1uuqP/preview','FALSE',2,'2023-10-30 15:55:41','2023-10-30 15:55:41'),(4,'b','https://drive.google.com/file/d/12sm0HGrvKyU1PuZOaKhvEhkVIDXxsyQ0/preview','TRUE',2,'2023-10-30 15:55:41','2023-10-30 16:06:23'),(5,'a','https://drive.google.com/file/d/12wodlqA5ZAoEWzYPY5H4P1bn6Dghq7Pa/preview','FALSE',3,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(6,'b','https://drive.google.com/file/d/130BX5nFAWjtAXTLfqhwEfWhoMacJbGBE/preview','TRUE',3,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(7,'a','https://drive.google.com/file/d/132xJHM0SehAdEIIvQNO-1J7GA7uhmWuJ/preview','FALSE',4,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(8,'b','https://drive.google.com/file/d/135QyBOHIW9fABH8qBYK9T6ClryQOXb-W/preview','FALSE',4,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(9,'a','https://drive.google.com/file/d/130BX5nFAWjtAXTLfqhwEfWhoMacJbGBE/preview','TRUE',5,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(10,'b','https://drive.google.com/file/d/12wodlqA5ZAoEWzYPY5H4P1bn6Dghq7Pa/preview','FALSE',5,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(11,'a','https://drive.google.com/file/d/132xJHM0SehAdEIIvQNO-1J7GA7uhmWuJ/preview','FALSE',6,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(12,'b','https://drive.google.com/file/d/135QyBOHIW9fABH8qBYK9T6ClryQOXb-W/preview','TRUE',6,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(13,'a','https://drive.google.com/file/d/130BX5nFAWjtAXTLfqhwEfWhoMacJbGBE/preview','TRUE',7,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(14,'b','https://drive.google.com/file/d/12wodlqA5ZAoEWzYPY5H4P1bn6Dghq7Pa/preview','FALSE',7,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(15,'a','https://drive.google.com/file/d/132xJHM0SehAdEIIvQNO-1J7GA7uhmWuJ/preview','FALSE',8,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(16,'b','https://drive.google.com/file/d/135QyBOHIW9fABH8qBYK9T6ClryQOXb-W/preview','TRUE',8,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(17,'a','https://drive.google.com/file/d/130BX5nFAWjtAXTLfqhwEfWhoMacJbGBE/preview','TRUE',9,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(18,'a','https://drive.google.com/file/d/12wodlqA5ZAoEWzYPY5H4P1bn6Dghq7Pa/preview','FALSE',9,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(19,'a','https://drive.google.com/file/d/132xJHM0SehAdEIIvQNO-1J7GA7uhmWuJ/preview','FALSE',10,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(20,'b','https://drive.google.com/file/d/135QyBOHIW9fABH8qBYK9T6ClryQOXb-W/preview','TRUE',10,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(21,'a. There are 3 tens and 5 ones',NULL,'TRUE',11,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(22,'b. There are 4 tens and 5 ones',NULL,'FALSE',11,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(23,'c. There are 5 tens and 3 ones',NULL,'FALSE',11,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(24,'30 + 5',NULL,'TRUE',12,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(25,'35',NULL,'TRUE',13,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(26,'35',NULL,'TRUE',14,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(27,'a. There are 3 tens and 5 ones',NULL,'TRUE',15,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(28,'b. There are 4 tens and 5 ones',NULL,'FALSE',15,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(29,'c. There are 5 tens and 3 ones',NULL,'FALSE',15,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(30,'30 + 5',NULL,'TRUE',16,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(31,'35',NULL,'TRUE',17,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(32,'35',NULL,'TRUE',18,'2023-10-30 18:35:33','2023-10-30 18:35:33');
/*!40000 ALTER TABLE `exe_choices` ENABLE KEYS */;
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
