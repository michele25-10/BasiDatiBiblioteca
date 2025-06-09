-- MySQL dump 10.13  Distrib 8.4.5, for Linux (x86_64)
--
-- Host: localhost    Database: library
-- ------------------------------------------------------
-- Server version	8.4.5-0ubuntu0.1

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

--
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `author` (
  `name` varchar(50) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  PRIMARY KEY (`name`,`surname`,`birth_date`,`birth_place`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES ('Anna','Bianchi','1970-11-23','Milan'),('Carlos','Gomez','1975-09-14','Madrid'),('Hans','Müller','1962-01-30','Berlin'),('Jean','Dupont','1958-04-10','Paris'),('Mario','Rossi','1965-07-12','Rome');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book` (
  `ISBN` varchar(17) NOT NULL,
  `title` varchar(255) NOT NULL,
  `publication_year` int DEFAULT NULL,
  `language` varchar(25) NOT NULL,
  PRIMARY KEY (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES ('978-0-123-45678-9','Engineering Modern Systems',2015,'Spanish'),('978-0-14-044913-6','The Law of Civil Societies',2010,'German'),('978-0-262-13472-9','Physics Beyond the Standard Model',2018,'French'),('978-1-4028-9462-6','Economic Strategies for the Future',2012,'English'),('978-3-16-148410-0','The Architecture of Space',2005,'Italian');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_author`
--

DROP TABLE IF EXISTS `book_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_author` (
  `ISBN` varchar(17) NOT NULL,
  `author_name` varchar(50) NOT NULL,
  `author_surname` varchar(25) NOT NULL,
  `author_birth_date` date NOT NULL,
  `author_birth_place` varchar(255) NOT NULL,
  PRIMARY KEY (`ISBN`,`author_name`,`author_surname`,`author_birth_date`,`author_birth_place`),
  KEY `author_name` (`author_name`,`author_surname`,`author_birth_date`,`author_birth_place`),
  CONSTRAINT `book_author_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `book_author_ibfk_2` FOREIGN KEY (`author_name`, `author_surname`, `author_birth_date`, `author_birth_place`) REFERENCES `author` (`name`, `surname`, `birth_date`, `birth_place`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_author`
--

LOCK TABLES `book_author` WRITE;
/*!40000 ALTER TABLE `book_author` DISABLE KEYS */;
INSERT INTO `book_author` VALUES ('978-1-4028-9462-6','Anna','Bianchi','1970-11-23','Milan'),('978-0-123-45678-9','Carlos','Gomez','1975-09-14','Madrid'),('978-1-4028-9462-6','Carlos','Gomez','1975-09-14','Madrid'),('978-0-14-044913-6','Hans','Müller','1962-01-30','Berlin'),('978-0-262-13472-9','Jean','Dupont','1958-04-10','Paris'),('978-3-16-148410-0','Mario','Rossi','1965-07-12','Rome');
/*!40000 ALTER TABLE `book_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `copy`
--

DROP TABLE IF EXISTS `copy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `copy` (
  `code` int NOT NULL AUTO_INCREMENT,
  `ISBN` varchar(17) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `ISBN` (`ISBN`),
  KEY `department_name` (`department_name`),
  CONSTRAINT `copy_ibfk_1` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `copy_ibfk_2` FOREIGN KEY (`department_name`) REFERENCES `department` (`name`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `copy`
--

LOCK TABLES `copy` WRITE;
/*!40000 ALTER TABLE `copy` DISABLE KEYS */;
INSERT INTO `copy` VALUES (1,'978-3-16-148410-0','Architettura'),(2,'978-1-4028-9462-6','Economia e Managment'),(3,'978-0-262-13472-9','Fisica e Scienze della Terra'),(4,'978-0-14-044913-6','Giurisprudenza'),(5,'978-0-123-45678-9','Ingegneria'),(6,'978-0-123-45678-9','Ingegneria');
/*!40000 ALTER TABLE `copy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `name` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES ('Architettura','Via Ghiara, 36 - 44121 Ferrara'),('Economia e Managment','Via Voltapaletto n.11 - 44121 Ferrara'),('Fisica e Scienze della Terra','Via Saragat, 1 - 44121 Ferrara'),('Giurisprudenza','Corso Ercole l d\'Este n. 37 - 44121 Ferrara'),('Ingegneria','Via Saragat, 1 - 44121 Ferrara'),('Matematica e Informatica','Via Macchiavelli, 30 - 44121 Ferrara'),('Medicina Traslazionale e per la Romagna','Via Luigi Borsarsi, 46 - 44121 Ferrara'),('Neuroscienze e Riabilitazione','Via Luigi Borsari, 46 - 44121 Ferrara'),('Scienze Chimiche, Farmaceutiche ed Agrarie','Via Luigi Borsari, 46 - 44121 Ferrara'),('Scienze dell\'Ambiente e della Prevenzione','Via Luigi Borsari, 46 - 44121 Ferrara'),('Scienze della Vita e Biotecnologie','Via Luigi Borsari, 46 - 44121 Ferrara'),('Scienze Mediche','Via Fossato di Mortara, 64/B - 44121 Ferrara'),('Studi Umanistici','Via Paradiso, 12 - 44121 Ferrara');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loan`
--

DROP TABLE IF EXISTS `loan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loan` (
  `copy_code` int NOT NULL,
  `serial_number` varchar(6) NOT NULL,
  `start_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` date DEFAULT NULL,
  PRIMARY KEY (`copy_code`,`serial_number`,`start_date`),
  KEY `serial_number` (`serial_number`),
  CONSTRAINT `loan_ibfk_1` FOREIGN KEY (`copy_code`) REFERENCES `copy` (`code`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `loan_ibfk_2` FOREIGN KEY (`serial_number`) REFERENCES `user` (`serial_number`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loan`
--

LOCK TABLES `loan` WRITE;
/*!40000 ALTER TABLE `loan` DISABLE KEYS */;
INSERT INTO `loan` VALUES (1,'U00001','2025-06-09 17:19:09',NULL),(1,'U00002','2025-06-09 17:11:10','2025-06-09'),(1,'U00003','2025-04-30 18:00:00','2025-06-09'),(2,'U00002','2025-06-09 17:19:00',NULL),(3,'U00003','2025-05-08 18:00:00',NULL);
/*!40000 ALTER TABLE `loan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `serial_number` varchar(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `telephone` varchar(13) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`serial_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('U00001','Luigi','Verdi','+390531234567','Via Roma 1, Ferrara'),('U00002','Giulia','Neri','+390532345678','Via Bologna 15, Ferrara'),('U00003','Luca','Bruni','+390533456789','Via Modena 20, Ferrara');
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

-- Dump completed on 2025-06-09 18:01:21
