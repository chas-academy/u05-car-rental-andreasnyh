-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: carRental
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4

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
-- Table structure for table `Cars`
--

DROP TABLE IF EXISTS `Cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cars` (
  `registration` varchar(100) NOT NULL,
  `year` year(4) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `make` varchar(256) DEFAULT NULL,
  `model` varchar(256) DEFAULT NULL,
  `color` varchar(256) DEFAULT NULL,
  `renter` bigint(20) DEFAULT NULL,
  `rentStart` datetime DEFAULT NULL,
  PRIMARY KEY (`registration`),
  UNIQUE KEY `registration` (`registration`),
  KEY `rentStart` (`rentStart`),
  KEY `make` (`make`),
  KEY `color` (`color`),
  KEY `renter` (`renter`),
  CONSTRAINT `Cars_ibfk_1` FOREIGN KEY (`make`) REFERENCES `Makes` (`make`),
  CONSTRAINT `Cars_ibfk_2` FOREIGN KEY (`color`) REFERENCES `Colors` (`color`),
  CONSTRAINT `Cars_ibfk_3` FOREIGN KEY (`renter`) REFERENCES `Customers` (`socialSecurityNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cars`
--

LOCK TABLES `Cars` WRITE;
/*!40000 ALTER TABLE `Cars` DISABLE KEYS */;
INSERT INTO `Cars` VALUES ('ABC123',2019,500,'Ford','Focus','Black',NULL,NULL),('BCD234',2019,495,'Volkswagen','Golf GTE','White',8205030789,'2020-01-18 19:13:02'),('CDE345',2017,200,'Toyota','Aygo','Gray',NULL,NULL),('DAD987',2016,795,'Volkswagen','Polo GTI','White',NULL,NULL),('DEF456',2019,450,'Hyundai','i30 N','Blue',NULL,NULL),('EFG567',2019,295,'Chevrolet','Spark','Gray',NULL,NULL),('OPK443',1999,500.5,'Volkswagen','Passat','White',2905039497,'2020-01-17 11:12:59'),('PHP666',2019,1995,'Ford','Mustang','Orange',NULL,NULL);
/*!40000 ALTER TABLE `Cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Colors`
--

DROP TABLE IF EXISTS `Colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Colors` (
  `color` varchar(256) NOT NULL,
  PRIMARY KEY (`color`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Colors`
--

LOCK TABLES `Colors` WRITE;
/*!40000 ALTER TABLE `Colors` DISABLE KEYS */;
INSERT INTO `Colors` VALUES ('Black'),('Blue'),('Gray'),('Green'),('Orange'),('Red'),('Silver'),('White');
/*!40000 ALTER TABLE `Colors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Customers`
--

DROP TABLE IF EXISTS `Customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Customers` (
  `socialSecurityNumber` bigint(20) NOT NULL,
  `customerName` varchar(256) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `postalAddress` varchar(256) DEFAULT NULL,
  `phoneNumber` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`socialSecurityNumber`),
  UNIQUE KEY `socialSecurityNumber` (`socialSecurityNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Customers`
--

LOCK TABLES `Customers` WRITE;
/*!40000 ALTER TABLE `Customers` DISABLE KEYS */;
INSERT INTO `Customers` VALUES (1412148197,'Fred McDougal','Seafield Rd 6','Iverness','0734242424'),(1802222685,'Frida Fridh','Eksätravägen 471','126 54 Stockholm','0763452722'),(2905039497,'Göran Persson','Lingonstigen 8','181 64 Lidingö','0733456456'),(4604279796,'Hjördis Hansson','Älvkarlevägen 17','115 43 Stockholm','0712430556'),(6505088283,'Leif \"Loket\" Olsson','Drottninggatan 60','411 07 Göteborg','0700867768'),(7001266894,'Richard Faußt','Glaciärvägen 5','806 30 Gävle','0763456234'),(8205030789,'Glen Hysen','Kungsportsavenyen 2','411 38 Göteborg','0709123432'),(8608141621,'Jolene Larsen Kilan','Gudmundrågatan 8','16253 Vällingby','0762291021'),(9601248876,'Theodor af Gryta','Gamla Brogatan 29','111 20 Stockholm','0709876678'),(9905085115,'Kristina Kristen','Kyrkängsbacken 14','141 35 Huddinge','0702456776');
/*!40000 ALTER TABLE `Customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `History`
--

DROP TABLE IF EXISTS `History`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `History` (
  `registrationHistory` varchar(100) DEFAULT NULL,
  `renterHistory` bigint(20) DEFAULT NULL,
  `rentStartHistory` datetime DEFAULT NULL,
  `returnTimeHistory` datetime DEFAULT NULL,
  KEY `registrationHistory` (`registrationHistory`),
  KEY `renterHistory` (`renterHistory`),
  CONSTRAINT `History_ibfk_1` FOREIGN KEY (`registrationHistory`) REFERENCES `Cars` (`registration`),
  CONSTRAINT `History_ibfk_2` FOREIGN KEY (`renterHistory`) REFERENCES `Customers` (`socialSecurityNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `History`
--

LOCK TABLES `History` WRITE;
/*!40000 ALTER TABLE `History` DISABLE KEYS */;
INSERT INTO `History` VALUES ('ABC123',1802222685,'2020-01-14 13:30:33','2020-01-14 13:30:50'),('PHP666',6505088283,'2020-01-14 13:45:01','2020-01-14 13:45:55'),('BCD234',8205030789,'2020-01-10 13:32:12','2020-01-14 13:49:51'),('EFG567',2905039497,'2020-01-10 13:52:45','2020-01-14 13:55:53'),('BCD234',NULL,'2020-01-15 08:37:45','2020-01-15 08:38:00'),('PHP666',8205030789,'2020-01-15 08:42:41','2020-01-15 08:42:51'),('ABC123',NULL,'2020-01-10 09:51:37','2020-01-10 10:51:37'),('ABC123',8205030789,'2020-01-10 10:00:00','2020-01-11 10:00:00'),('ABC123',NULL,'2020-01-10 10:00:00','2020-01-11 10:00:01'),('ABC123',4604279796,'2020-01-10 10:00:00','2020-01-10 10:00:00'),('ABC123',4604279796,'2020-01-10 10:00:00','2020-01-10 11:00:00'),('ABC123',4604279796,'2020-01-10 10:00:00','2020-01-10 11:00:01');
/*!40000 ALTER TABLE `History` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Makes`
--

DROP TABLE IF EXISTS `Makes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Makes` (
  `make` varchar(256) NOT NULL,
  PRIMARY KEY (`make`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Makes`
--

LOCK TABLES `Makes` WRITE;
/*!40000 ALTER TABLE `Makes` DISABLE KEYS */;
INSERT INTO `Makes` VALUES ('Chevrolet'),('Ford'),('Honda'),('Hyundai'),('Kia'),('Mazda'),('Toyota'),('Volkswagen');
/*!40000 ALTER TABLE `Makes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-19 22:49:28
