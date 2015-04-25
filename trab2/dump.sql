-- MySQL dump 10.11
--
-- Host: localhost    Database: onehost_topicos
-- ------------------------------------------------------
-- Server version	5.0.45-community-nt-log

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
-- Table structure for table `paginas`
--

DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pagina` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paginas`
--

LOCK TABLES `paginas` WRITE;
/*!40000 ALTER TABLE `paginas` DISABLE KEYS */;
INSERT INTO `paginas` VALUES (1,'lipsum.htm'),(2,'ServiceLogin.htm'),(3,'terra.htm'),(4,'teste.html'),(5,'ola_testando.html');
/*!40000 ALTER TABLE `paginas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `palavras`
--

DROP TABLE IF EXISTS `palavras`;
CREATE TABLE `palavras` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `palavra` varchar(100) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `palavras_unique_palavra` (`palavra`),
  KEY `palavras_index2446` (`palavra`)
) ENGINE=InnoDB AUTO_INCREMENT=4405 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `palavras`
--

LOCK TABLES `palavras` WRITE;
/*!40000 ALTER TABLE `palavras` DISABLE KEYS */;
INSERT INTO `palavras` VALUES (4399,'algumas'),(4395,'aqui'),(4403,'colocar'),(4398,'com'),(4401,'eu'),(4397,'frase'),(4394,'ola'),(4404,'outras'),(4400,'palavras'),(4393,'testando'),(4396,'uma'),(4402,'vou');
/*!40000 ALTER TABLE `palavras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `palavras_paginas`
--

DROP TABLE IF EXISTS `palavras_paginas`;
CREATE TABLE `palavras_paginas` (
  `palavra_id` int(10) unsigned NOT NULL,
  `pagina_id` int(10) unsigned NOT NULL,
  `peso` decimal(10,8) NOT NULL,
  PRIMARY KEY  (`palavra_id`,`pagina_id`),
  KEY `palavras_has_paginas_FKIndex1` (`palavra_id`),
  KEY `palavras_has_paginas_FKIndex2` (`pagina_id`),
  CONSTRAINT `palavras_paginas_ibfk_1` FOREIGN KEY (`palavra_id`) REFERENCES `palavras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `palavras_paginas_ibfk_2` FOREIGN KEY (`pagina_id`) REFERENCES `paginas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `palavras_paginas`
--

LOCK TABLES `palavras_paginas` WRITE;
/*!40000 ALTER TABLE `palavras_paginas` DISABLE KEYS */;
INSERT INTO `palavras_paginas` VALUES (4393,4,'0.14285714'),(4393,5,'0.25000000'),(4395,4,'0.14285714'),(4395,5,'0.12500000'),(4396,5,'0.12500000'),(4397,5,'0.12500000'),(4398,5,'0.12500000'),(4399,5,'0.12500000'),(4400,4,'0.14285714'),(4400,5,'0.12500000'),(4401,4,'0.14285714'),(4402,4,'0.14285714'),(4403,4,'0.14285714'),(4404,4,'0.14285714');
/*!40000 ALTER TABLE `palavras_paginas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stop_words`
--

DROP TABLE IF EXISTS `stop_words`;
CREATE TABLE `stop_words` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `palavras` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stop_words`
--

LOCK TABLES `stop_words` WRITE;
/*!40000 ALTER TABLE `stop_words` DISABLE KEYS */;
/*!40000 ALTER TABLE `stop_words` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-04-10 20:50:52
