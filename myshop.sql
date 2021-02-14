-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: localhost    Database: my_shop
-- ------------------------------------------------------
-- Server version	5.7.32-0ubuntu0.18.04.1

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `img` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Chaise blanche',100,1,'test test','products/img/13-02-21-14-59-38.jpeg'),(2,'Table blanche',305,2,'test','products/img/13-02-21-15-00-01.jpeg'),(5,'Table rose',350,2,'Blablabla','products/img/13-02-21-18-42-14.jpeg'),(13,'Fauteuil en cuir',500,0,'Fauteuil en cuir brun','products/img/13-02-21-15-38-40.jpeg'),(14,'Test',450,0,'Test','products/img/13-02-21-17-29-07.jpeg'),(15,'Test encore',674,0,'Animadvérsionis appellat copiosáe corrupisti, defendere éruditioném futuris innumerabiles interdictum iudicat necesse praeclara urbanitas victi. Alienae certámen crudelis exitum, extremo falsarum mente nondum urna! árbitráretur dices grata inceptós iustióribus, necesse sale tantis utilitatibus? Assiduitas deteriora élitr évérti habeat iisque infimum repugnantiumve stabilique torquato vocant? \r\n\r\nAbhorreant artem cónspectum cupiditate, dicta honestatis ipsum leguntur, munere putem seque signiferumque sole sollicitudines theatro. Amicitiam appetere atomum efficeretur hic, honestatis industria malésuada modus notae, permultá principes vim? áuctori consequatur efficiantur insitam laetamur tu vénustaté. Atqui corrigere degendae est ex haeret ignota inbecilloque liberámur pondere voluit. Accurate collegisti efficerent hic ipsarum labefactetur minuti occáecát répériré sedentis virtutum. ádiungimus amice consiliisque degendae, disciplina éx fabulas fortitudinem, iactare invidus monstret pertinaces putándá réliquaqué vigiliaé! ','products/img/14-02-21-12-33-00.jpeg'),(16,'Ceci est un nom de produit super long pour tester l&#39;affichage dans le shop oui oui',200,0,'Test','products/img/14-02-21-12-37-39.jpeg'),(17,'Un autre produit encore',2358,0,'Description du produit pour tester','products/img/14-02-21-16-37-26.jpeg'),(18,'Once again',245,0,'Coucou','products/img/14-02-21-16-37-59.jpeg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `admin` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (4,'God','test','god@god.com',1),(5,'Bidule','test','bidule@bidule.com',0),(6,'Machin','test','machin@machin.com',0),(7,'Truc','test','claude2@claude.com',1),(8,'Jean','test','jean@jean.com',0),(9,'Claude','test','claude2@claude.com',0),(10,'Marc','test','marc@marc.com',1),(11,'Marie','test','marie-therese2@marie.com',0),(12,'Truc','test','truc@truc.com',0),(13,'Truc','test','truc@truc.com',0),(14,'Truc','test','truc2@truc.com',0),(17,'Truc','test','truc@truc.com',0),(19,'Machin','test','machin2@machin.com',0),(20,'Machin','test','machin5@machin.com',1),(22,'Machin','test','machin8@machin.com',1),(23,'Machin','test','machin@machin.com',0),(25,'Machin','test','machin@machin.com',0),(27,'Machin','test','machin9@machin.com',0),(28,'Machin','test','machin@machin.com',0),(29,'Machin','test','machin@machin.com',0),(30,'Machin','test','machin@machin.com',0),(31,'Machin','test','machin@machin.com',0),(32,'Machin','test','machin@machin.com',0),(33,'Machin','test','machin@machin.com',0),(34,'Machin','test','machin@machin.com',0),(35,'Machin','test','machin@machin.com',0),(36,'Machin','test','machin@machin.com',0),(37,'Machin','test','machin@machin.com',0),(38,'Machin','test','machin@machin.com',0),(39,'Machin','test','machin@machin.com',0),(40,'Machin','test','machin@machin.com',0),(41,'Machin','test','machin@machin.com',0),(42,'Machin','test','machin@machin.com',0),(43,'Machin','test','machin@machin.com',0),(44,'Machin','test','machin@machin.com',0),(45,'Machin','test','machin@machin.com',0),(46,'Machin','test','machin@machin.com',0),(47,'Machin','test','machin@machin.com',0),(48,'Machin','test','machin@machin.com',0),(49,'Machin','test','machin@machin.com',0),(50,'Machin','test','machin@machin.com',0),(51,'Machin','test','machin@machin.com',0),(52,'Machin','test','machin@machin.com',0),(53,'Machin','test','machin@machin.com',0),(54,'Machin','test','machin@machin.com',0),(55,'Machin','test','machin@machin.com',0),(56,'Machin','test','machin@machin.com',0),(57,'Machin','test','machin@machin.com',0),(58,'Machin','test','machin@machin.com',0),(59,'Machin','test','machin@machin.com',0);
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

-- Dump completed on 2021-02-14 18:02:09
