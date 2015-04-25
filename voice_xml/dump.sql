-- MySQL dump 10.10
--
-- Host: localhost    Database: onehost_voicexml
-- ------------------------------------------------------
-- Server version	5.0.27-community-nt

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `aptos`
--

LOCK TABLES `aptos` WRITE;
/*!40000 ALTER TABLE `aptos` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hospedes`
--

LOCK TABLES `hospedes` WRITE;
/*!40000 ALTER TABLE `hospedes` DISABLE KEYS */;
/*!40000 ALTER TABLE `hospedes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagamento_formas`
--

DROP TABLE IF EXISTS `pagamento_formas`;
CREATE TABLE `pagamento_formas` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagamento_formas`
--

LOCK TABLES `pagamento_formas` WRITE;
/*!40000 ALTER TABLE `pagamento_formas` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagamento_formas` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `preposicoes`
--

LOCK TABLES `preposicoes` WRITE;
/*!40000 ALTER TABLE `preposicoes` DISABLE KEYS */;
INSERT INTO `preposicoes` VALUES (2,'a'),(1,'o'),(3,'para'),(4,'um'),(5,'uma');
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservas`
--

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  UNIQUE KEY `verbos_unique_verbo` (`nome`),
  KEY `verbos_FKIndex1` (`acao_id`),
  CONSTRAINT `verbos_ibfk_1` FOREIGN KEY (`acao_id`) REFERENCES `acoes` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `verbos`
--

LOCK TABLES `verbos` WRITE;
/*!40000 ALTER TABLE `verbos` DISABLE KEYS */;
INSERT INTO `verbos` VALUES (1,1,'reservar'),(2,1,'cadastrar'),(3,1,'alugar'),(4,1,'fazer'),(5,1,'adquirir'),(6,2,'alterar'),(7,3,'excluir'),(8,3,'cancelar'),(9,3,'remover'),(10,NULL,'quero'),(11,NULL,'pagarei'),(12,NULL,'vou pagar'),(13,NULL,'vou quer'),(14,NULL,'quer'),(15,NULL,'queremos');
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

-- Dump completed on 2008-06-12 18:43:05
