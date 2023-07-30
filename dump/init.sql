-- MySQL dump 10.13  Distrib 8.0.33, for Linux (x86_64)
--
-- Host: localhost    Database: todolist
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE IF NOT EXISTS todolist;
USE todolist;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20230720011656','2023-07-20 03:17:10',132),('DoctrineMigrations\\Version20230729232737','2023-07-30 01:27:53',162),('DoctrineMigrations\\Version20230729233709','2023-07-30 01:37:21',28);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `task` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_527EDB25F675F31B` (`author_id`),
  CONSTRAINT `FK_527EDB25F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` VALUES (68,30,'1995-05-21 09:45:03','Voluptas occaecati quisquam iusto voluptatem ut.','Consequuntur sed optio minima. Dolores delectus quas qui voluptas.',1),(69,27,'1976-06-10 06:31:54','Necessitatibus sit totam enim qui.','Quidem sit odio voluptatem sequi quo odit. Nulla fugit quae autem aut non.',0),(70,29,'1986-07-30 07:05:31','Qui non amet sed sunt est accusamus.','Ipsam quo non minima dicta accusantium. Quae officiis vitae dolorum consectetur at.',0),(71,28,'2016-05-19 01:10:51','Sunt atque culpa tenetur magni velit autem.','Voluptatem quam cum ut quasi eius. Perspiciatis nisi quis voluptates aut est eos.',1),(72,28,'1990-06-03 13:04:17','Eum voluptates ut sapiente qui.','Repellendus aperiam dolorem dolores. Magnam veniam perferendis rerum assumenda vel id.',1),(73,27,'2015-12-10 04:09:22','Quis qui quisquam non ab impedit.','Quam suscipit quos eius cum quidem odit. Fuga molestias est quisquam optio assumenda magni.',1),(74,28,'1999-12-22 10:26:10','Dolor est ducimus amet doloremque sunt rerum.','Quaerat et omnis molestiae et et praesentium. Quidem maiores consequatur nihil nam dolorum.',0),(75,30,'2012-03-08 13:09:48','Suscipit adipisci eveniet voluptate.','Debitis sed minus laudantium est voluptas. Ab quisquam sunt consequuntur eveniet et et.',0),(76,28,'2005-11-30 19:15:29','Quia nihil aperiam quibusdam deserunt aut dolorem.','Nesciunt eos reiciendis nam quo commodi velit. Praesentium sed quo beatae magnam ut.',1),(77,27,'2003-08-16 12:13:50','Velit libero et temporibus ea.','Ex fugit aut provident qui ut. Et ullam velit voluptas aliquam.',0),(78,28,'1996-09-11 09:01:07','Et voluptate sint voluptas.','Quae at exercitationem doloribus optio. Velit fugit necessitatibus eveniet magnam soluta.',0),(79,27,'1986-10-03 11:44:21','Totam nihil ab dolor accusamus harum accusantium.','Accusamus et voluptatem neque nisi et. Qui doloribus culpa sunt. Nihil omnis ut qui odit.',0),(80,NULL,'1991-10-28 20:57:12','Enim delectus nesciunt dolorem aut accusamus.','Excepturi ex non aut sed aliquam nemo sed. Illo eos et quasi neque repellat a.',0),(81,NULL,'2007-09-30 11:35:14','Itaque fuga quibusdam rerum ea.','Minima voluptatibus at ut tempora accusantium odit autem. Explicabo culpa animi itaque.',1),(82,NULL,'1998-08-02 17:21:24','Et assumenda temporibus et dolores perferendis sunt.','Numquam sed perspiciatis natus sed totam. Fuga sapiente veritatis perferendis repudiandae a.',0),(83,NULL,'2023-06-07 10:30:59','Temporibus fugit pariatur aliquam dolores necessitatibus doloribus.','Odio quos hic sint est molestiae labore eligendi. Aliquam perferendis quas et ut veniam.',1),(84,NULL,'1996-11-28 15:58:03','Et qui fuga non similique ex maiores.','Ut magnam ex aut. Non repellat quis odit accusamus nemo. Optio officiis voluptatum nesciunt odit.',0),(85,NULL,'2015-06-21 23:52:31','Est doloribus ad pariatur amet.','Delectus sed id ut enim aspernatur dolor magnam labore. Autem dolorem deserunt et error repellat.',1);
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (27,'Admin','$2y$13$O5y2Lk8PP8Qz89m8hnxx7.uM6h.XOHL.AMgmN/XTihUhYskKrfhmq','admin@foobar.net','[\"ROLE_ADMIN\"]'),(28,'Test User','$2y$13$WPtOXB9RBvz8zDGxc7HPE.O8ayQAMvunAkH83IF8T16tmFsCwpH5C','test@test.net','[\"ROLE_USER\"]'),(29,'mbreitenberg','$2y$13$hfdtbUQcM0NxgWeI7TBs.OlGiIAb1j/Pvay9OB2ISKusH5n8Q1W7i','witting.rodger@hotmail.com','[\"ROLE_USER\"]'),(30,'lulu54','$2y$13$c8ZHAOSvfoO/mO7a7IfQsOC9Ehf5uZUg22xoOvsP1SKvT1mimVAAS','littel.gino@barrows.com','[\"ROLE_USER\"]'),(31,'runte.samson','$2y$13$4JBgf2atwvL5ZqcmHMXHzu2lbUfRdt8yEqx5oELgaebCZbyqozpHG','kautzer.doris@hotmail.com','[\"ROLE_USER\"]');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;