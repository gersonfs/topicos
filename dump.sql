-- MySQL dump 10.11
--
-- Host: localhost    Database: onehost_topicos
-- ------------------------------------------------------
-- Server version	5.0.45-log

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
-- Table structure for table `acoes`
--

DROP TABLE IF EXISTS `acoes`;
CREATE TABLE `acoes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `acoes_unique_acao` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acoes`
--

LOCK TABLES `acoes` WRITE;
/*!40000 ALTER TABLE `acoes` DISABLE KEYS */;
INSERT INTO `acoes` VALUES (2,'editar'),(1,'novo'),(3,'remover');
/*!40000 ALTER TABLE `acoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apto_tipos`
--

DROP TABLE IF EXISTS `apto_tipos`;
CREATE TABLE `apto_tipos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apto_tipos`
--

LOCK TABLES `apto_tipos` WRITE;
/*!40000 ALTER TABLE `apto_tipos` DISABLE KEYS */;
INSERT INTO `apto_tipos` VALUES (1,'Luxo'),(2,'Standart'),(3,'Max');
/*!40000 ALTER TABLE `apto_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aptos`
--

DROP TABLE IF EXISTS `aptos`;
CREATE TABLE `aptos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `apto_tipo_id` int(10) unsigned NOT NULL,
  `capacidade` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `aptos_FKIndex1` (`apto_tipo_id`),
  CONSTRAINT `aptos_ibfk_1` FOREIGN KEY (`apto_tipo_id`) REFERENCES `apto_tipos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aptos`
--

LOCK TABLES `aptos` WRITE;
/*!40000 ALTER TABLE `aptos` DISABLE KEYS */;
INSERT INTO `aptos` VALUES (13,3,5),(14,3,5),(15,1,5);
/*!40000 ALTER TABLE `aptos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aptos_reservas`
--

DROP TABLE IF EXISTS `aptos_reservas`;
CREATE TABLE `aptos_reservas` (
  `apto_id` int(10) unsigned NOT NULL,
  `reserva_id` int(10) unsigned NOT NULL,
  `ocupacao` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`apto_id`,`reserva_id`),
  KEY `aptos_has_reservas_FKIndex1` (`apto_id`),
  KEY `aptos_has_reservas_FKIndex2` (`reserva_id`),
  CONSTRAINT `aptos_reservas_ibfk_1` FOREIGN KEY (`apto_id`) REFERENCES `aptos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `aptos_reservas_ibfk_2` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aptos_reservas`
--

LOCK TABLES `aptos_reservas` WRITE;
/*!40000 ALTER TABLE `aptos_reservas` DISABLE KEYS */;
INSERT INTO `aptos_reservas` VALUES (13,14,5),(14,13,5),(15,12,5),(15,15,5),(15,16,5),(15,17,4);
/*!40000 ALTER TABLE `aptos_reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hospedes`
--

DROP TABLE IF EXISTS `hospedes`;
CREATE TABLE `hospedes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(150) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `hospedes_unique_cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hospedes`
--

LOCK TABLES `hospedes` WRITE;
/*!40000 ALTER TABLE `hospedes` DISABLE KEYS */;
INSERT INTO `hospedes` VALUES (5,'gerson','01013252071'),(6,'gustavo','00680490051');
/*!40000 ALTER TABLE `hospedes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nomes`
--

DROP TABLE IF EXISTS `nomes`;
CREATE TABLE `nomes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nomes`
--

LOCK TABLES `nomes` WRITE;
/*!40000 ALTER TABLE `nomes` DISABLE KEYS */;
INSERT INTO `nomes` VALUES (1,'gerson'),(2,'gustavo'),(3,'claudio'),(4,'jacques'),(5,'jaques'),(6,'marcus'),(7,'paulo'),(8,'joao'),(9,'renato'),(10,'cristiano');
/*!40000 ALTER TABLE `nomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `numeros`
--

DROP TABLE IF EXISTS `numeros`;
CREATE TABLE `numeros` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL,
  `valor` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `numeros`
--

LOCK TABLES `numeros` WRITE;
/*!40000 ALTER TABLE `numeros` DISABLE KEYS */;
INSERT INTO `numeros` VALUES (1,'uma',1),(2,'duas',2),(3,'tres',3),(4,'quatro',4),(5,'cinco',5),(6,'um',1),(7,'dois',2);
/*!40000 ALTER TABLE `numeros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagamento_formas`
--

DROP TABLE IF EXISTS `pagamento_formas`;
CREATE TABLE `pagamento_formas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagamento_formas`
--

LOCK TABLES `pagamento_formas` WRITE;
/*!40000 ALTER TABLE `pagamento_formas` DISABLE KEYS */;
INSERT INTO `pagamento_formas` VALUES (1,'vista'),(2,'prazo');
/*!40000 ALTER TABLE `pagamento_formas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paginas`
--

DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pagina` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paginas`
--

LOCK TABLES `paginas` WRITE;
/*!40000 ALTER TABLE `paginas` DISABLE KEYS */;
INSERT INTO `paginas` VALUES (1,'teste_02.html'),(2,'teste.html');
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `palavras`
--

LOCK TABLES `palavras` WRITE;
/*!40000 ALTER TABLE `palavras` DISABLE KEYS */;
INSERT INTO `palavras` VALUES (10,'administration'),(17,'adquirida'),(8,'aeronautics'),(4,'cruz'),(16,'deficiencia'),(15,'imuno'),(13,'interconection'),(7,'national'),(11,'open'),(3,'santa'),(14,'sindrome'),(9,'space'),(5,'sul'),(12,'systems'),(1,'unisc'),(6,'universal'),(2,'universidade');
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
INSERT INTO `palavras_paginas` VALUES (1,1,'0.05882353'),(2,1,'0.05882353'),(2,2,'0.16666667'),(3,1,'0.05882353'),(3,2,'0.16666667'),(4,1,'0.05882353'),(4,2,'0.16666667'),(5,1,'0.05882353'),(5,2,'0.16666667'),(6,1,'0.05882353'),(7,1,'0.05882353'),(8,1,'0.05882353'),(9,1,'0.05882353'),(10,1,'0.05882353'),(11,1,'0.05882353'),(12,1,'0.05882353'),(13,1,'0.05882353'),(14,1,'0.05882353'),(14,2,'0.08333333'),(15,1,'0.05882353'),(15,2,'0.08333333'),(16,1,'0.05882353'),(16,2,'0.08333333'),(17,1,'0.05882353'),(17,2,'0.08333333');
/*!40000 ALTER TABLE `palavras_paginas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preposicoes`
--

DROP TABLE IF EXISTS `preposicoes`;
CREATE TABLE `preposicoes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `preposicoes_unique_prep` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `preposicoes`
--

LOCK TABLES `preposicoes` WRITE;
/*!40000 ALTER TABLE `preposicoes` DISABLE KEYS */;
INSERT INTO `preposicoes` VALUES (2,'a'),(6,'algum'),(12,'de'),(10,'do modelo'),(8,'do tipo'),(11,'modelo'),(1,'o'),(3,'para'),(7,'qualquer'),(9,'tipo'),(4,'um'),(5,'uma');
/*!40000 ALTER TABLE `preposicoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pronomes`
--

DROP TABLE IF EXISTS `pronomes`;
CREATE TABLE `pronomes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `pronomes_unique_pronome` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pronomes`
--

LOCK TABLES `pronomes` WRITE;
/*!40000 ALTER TABLE `pronomes` DISABLE KEYS */;
INSERT INTO `pronomes` VALUES (2,'ele'),(1,'eu'),(3,'nos');
/*!40000 ALTER TABLE `pronomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `hospede_id` int(10) unsigned NOT NULL,
  `pagamento_forma_id` int(10) unsigned NOT NULL,
  `inicio` datetime NOT NULL,
  `fim` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `reservas_FKIndex3` (`pagamento_forma_id`),
  KEY `reservas_FKIndex2` (`hospede_id`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`pagamento_forma_id`) REFERENCES `pagamento_formas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`hospede_id`) REFERENCES `hospedes` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservas`
--

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
INSERT INTO `reservas` VALUES (12,5,1,'2009-09-30 00:00:00','2009-10-30 00:00:00'),(13,5,1,'2008-07-20 00:00:00','2008-08-20 00:00:00'),(14,5,2,'2008-07-20 00:00:00','2008-08-20 00:00:00'),(15,5,1,'2009-03-10 00:00:00','2009-03-20 00:00:00'),(16,5,2,'2009-01-10 00:00:00','2009-01-20 00:00:00'),(17,6,1,'2009-05-02 00:00:00','2009-05-02 00:00:00');
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `substantivos`
--

DROP TABLE IF EXISTS `substantivos`;
CREATE TABLE `substantivos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `substantivos_unique_subs` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `substantivos`
--

LOCK TABLES `substantivos` WRITE;
/*!40000 ALTER TABLE `substantivos` DISABLE KEYS */;
INSERT INTO `substantivos` VALUES (2,'apartamento'),(1,'quarto'),(3,'reserva');
/*!40000 ALTER TABLE `substantivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verbos`
--

DROP TABLE IF EXISTS `verbos`;
CREATE TABLE `verbos` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `acao_id` int(10) unsigned default NULL,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `verbos_FKIndex1` (`acao_id`),
  CONSTRAINT `verbos_ibfk_1` FOREIGN KEY (`acao_id`) REFERENCES `acoes` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `verbos`
--

LOCK TABLES `verbos` WRITE;
/*!40000 ALTER TABLE `verbos` DISABLE KEYS */;
INSERT INTO `verbos` VALUES (1,1,'reservar'),(2,1,'cadastrar'),(3,1,'alugar'),(4,1,'fazer'),(5,1,'adquirir'),(6,2,'alterar'),(7,3,'excluir'),(8,3,'cancelar'),(9,3,'remover'),(10,NULL,'quero'),(11,NULL,'pagarei'),(12,NULL,'vou pagar'),(13,NULL,'vou quer'),(14,NULL,'quer'),(15,NULL,'queremos'),(16,1,'quero'),(18,NULL,'vou'),(19,NULL,'desejo'),(20,NULL,'desejamos'),(21,NULL,'deseja'),(22,NULL,'necessito'),(23,NULL,'necessitamos'),(24,NULL,'necessita'),(25,NULL,'gostaria'),(26,NULL,'gostariamos'),(27,NULL,'preciso'),(28,NULL,'precisamos'),(29,NULL,'precisa'),(30,2,'editar'),(32,2,'mudar');
/*!40000 ALTER TABLE `verbos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-06-30 19:47:12
