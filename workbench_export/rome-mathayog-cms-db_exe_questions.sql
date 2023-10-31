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
-- Table structure for table `exe_questions`
--

DROP TABLE IF EXISTS `exe_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exe_questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exercise_question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_type` enum('multiple choice','graphic choice','fill in the blanks','drag and drop') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `learning_tools` enum('selection','pencil','calculator','white board') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_graphics` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exercise_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exe_questions_exercise_id_foreign` (`exercise_id`),
  CONSTRAINT `exe_questions_exercise_id_foreign` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exe_questions`
--

LOCK TABLES `exe_questions` WRITE;
/*!40000 ALTER TABLE `exe_questions` DISABLE KEYS */;
INSERT INTO `exe_questions` VALUES (1,'1-A. Choose the figure that shows the correct grouping of single blocks to form base 10 blocks.','graphic choice','selection','https://drive.google.com/file/d/12iA1KrrwtjyY-9T6OE_8a3nK5CSpg0VA/preview',1,NULL,'2023-10-30 15:49:59'),(2,'1-B. Which figure shows the correct way of forming the base 10 blocks?','graphic choice','selection','https://drive.google.com/file/d/12iA1KrrwtjyY-9T6OE_8a3nK5CSpg0VA/preview',1,'2023-10-30 15:55:41','2023-10-30 15:55:41'),(3,'2-A. Choose the figure that shows the correct grouping of single blocks to form base 10 blocks.','graphic choice','selection','https://drive.google.com/file/d/12vdlGtDqRdYpMfAPV-DxNHa_kgtjdner/preview',1,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(4,'2-B. Which figure shows the correct way of forming the base 10 blocks?','graphic choice','selection','https://drive.google.com/file/d/12vdlGtDqRdYpMfAPV-DxNHa_kgtjdner/preview',1,'2023-10-30 16:01:25','2023-10-30 16:01:25'),(5,'3-A. Choose the figure that shows the correct grouping of single blocks to form base 10 blocks.','graphic choice','selection','https://drive.google.com/file/d/12vdlGtDqRdYpMfAPV-DxNHa_kgtjdner/preview',1,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(6,'3-B. Which figure shows the correct way of forming the base 10 blocks?','graphic choice','selection','https://drive.google.com/file/d/12vdlGtDqRdYpMfAPV-DxNHa_kgtjdner/preview',1,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(7,'4-A. Choose the figure that shows the correct grouping of single blocks to form base 10 blocks.','graphic choice','selection','https://drive.google.com/file/d/12vdlGtDqRdYpMfAPV-DxNHa_kgtjdner/preview',1,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(8,'4-B. Which figure shows the correct way of forming the base 10 blocks?','graphic choice','selection','https://drive.google.com/file/d/12vdlGtDqRdYpMfAPV-DxNHa_kgtjdner/preview',1,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(9,'5-A. Choose the figure that shows the correct grouping of single blocks to form base 10 blocks.','graphic choice','selection','https://drive.google.com/file/d/12vdlGtDqRdYpMfAPV-DxNHa_kgtjdner/preview',1,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(10,'5-B. Which figure shows the correct way of forming the base 10 blocks?','graphic choice','selection','https://drive.google.com/file/d/12vdlGtDqRdYpMfAPV-DxNHa_kgtjdner/preview',1,'2023-10-30 16:06:23','2023-10-30 16:06:23'),(11,'1-A. Count the number of base 10 blocks and single blocks. Click the letter that shows the correct number of tens and ones.','multiple choice','selection','https://drive.google.com/file/d/13iKvU6C2dkmlLLXSnuhoYqkD8UCrby0u/preview',4,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(12,'1-B. Type the equivalent values of tens and ones in the blanks provided.  3 tens and 5 ones = ____ + ____','multiple choice','selection','https://drive.google.com/file/d/13iKvU6C2dkmlLLXSnuhoYqkD8UCrby0u/preview',4,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(13,'1-C. Combine the resulting numbers in Letter B. Type the answer in the blank.  30 + 5  = ____     ','multiple choice','selection','https://drive.google.com/file/d/13iKvU6C2dkmlLLXSnuhoYqkD8UCrby0u/preview',4,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(14,'1-D.  Complete the sentence below. Type the answer in the blank.  3 tens and 5 ones make ____	','multiple choice','selection','https://drive.google.com/file/d/13iKvU6C2dkmlLLXSnuhoYqkD8UCrby0u/preview',4,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(15,'2-A. Count the number of base 10 blocks and single blocks. Click the letter that shows the correct number of tens and ones.','multiple choice','selection','https://drive.google.com/file/d/13iKvU6C2dkmlLLXSnuhoYqkD8UCrby0u/preview',4,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(16,'2-B. Type the equivalent values of tens and ones in the blanks provided.  3 tens and 5 ones = ____ + ____','multiple choice','selection','https://drive.google.com/file/d/13iKvU6C2dkmlLLXSnuhoYqkD8UCrby0u/preview',4,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(17,'2-C. Combine the resulting numbers in Letter B. Type the answer in the blank.  30 + 5  = ____     ','multiple choice','selection','https://drive.google.com/file/d/13iKvU6C2dkmlLLXSnuhoYqkD8UCrby0u/preview',4,'2023-10-30 18:35:33','2023-10-30 18:35:33'),(18,'2-D.  Complete the sentence below. Type the answer in the blank.  3 tens and 5 ones make ____	','multiple choice','selection','https://drive.google.com/file/d/13iKvU6C2dkmlLLXSnuhoYqkD8UCrby0u/preview',4,'2023-10-30 18:35:33','2023-10-30 18:35:33');
/*!40000 ALTER TABLE `exe_questions` ENABLE KEYS */;
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
