-- Progettazione Web 
DROP DATABASE if exists tetris; 
CREATE DATABASE tetris; 
USE tetris; 
-- MySQL dump 10.13  Distrib 5.6.20, for Win32 (x86)
--
-- Host: localhost    Database: tetris
-- ------------------------------------------------------
-- Server version	5.7.19-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `score` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scores`
--

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;
INSERT INTO `scores` VALUES (1,'nedo',30,'2017-09-26 19:21:47'),(3,'antonio',220,'2017-09-26 20:00:33'),(4,'antonio',120,'2017-09-27 13:35:06'),(5,'geghina',60,'2017-09-27 17:00:58'),(6,'geghina',10,'2017-09-27 17:47:58'),(7,'geghina',240,'2017-09-27 17:54:23'),(8,'rain',150,'2017-09-27 19:03:22'),(9,'rain',180,'2017-09-27 19:07:45'),(10,'rain',30,'2017-09-27 19:10:22'),(11,'rain',180,'2017-09-27 19:14:35'),(16,'rain',410,'2017-10-05 06:22:30'),(24,'admin',20,'2017-10-05 15:44:54'),(27,'ojiji',20,'2017-10-15 21:21:32'),(28,'ojiji',10,'2017-10-15 21:25:21');
/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `Banned` int(11) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('admin','cantfuckwiththeadmin@iseeyoubro.snipe','b4b8daf4b8ea9d39568719e1e320076f',0),('antonio','lol.lll.@aa.it','6e6bc4e49dd477ebc98ef4046c067b5f',0),('Geghi','Geghivincesempre@rankone.it','514b5825640eb00e4242a5eec8b22702',0),('geghina','marti97@live.it','9b3c6f494bc7751f158a9d6b3a143ced',0),('jiec','dd@a.it','6e6bc4e49dd477ebc98ef4046c067b5f',1),('luca','ddd@a.it','6e6bc4e49dd477ebc98ef4046c067b5f',0),('marilu','pippopippi@gmail.com','620f5cf24fca672a81c0310f15cebe08',0),('nedo','lol@gmail.xd','6e6bc4e49dd477ebc98ef4046c067b5f',1),('neee','dd@a.it','6e6bc4e49dd477ebc98ef4046c067b5f',1),('ojiji','ccc@ddd.it','6e6bc4e49dd477ebc98ef4046c067b5f',0),('paola','hfht@g.it','4fe330506e905a77d07db90836a6a11e',0),('rain','ll@aa.it','6e6bc4e49dd477ebc98ef4046c067b5f',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-10-17 10:29:40
