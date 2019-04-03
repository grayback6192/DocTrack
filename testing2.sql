-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: testinging
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
-- Table structure for table `archive`
--

DROP TABLE IF EXISTS `archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archive` (
  `idarchive` int(11) NOT NULL,
  `docid` int(11) DEFAULT NULL,
  PRIMARY KEY (`idarchive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive`
--

LOCK TABLES `archive` WRITE;
/*!40000 ALTER TABLE `archive` DISABLE KEYS */;
INSERT INTO `archive` VALUES (1715,84974),(3118,13064),(4414,43722),(8403,98921);
/*!40000 ALTER TABLE `archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment` longtext,
  `comment_doc_id` int(11) DEFAULT NULL,
  `comment_upg_id` int(11) DEFAULT NULL,
  `comment_date` varchar(45) DEFAULT NULL,
  `comment_time` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `comment_doc_id_idx` (`comment_doc_id`),
  KEY `comment_upg_id_idx` (`comment_upg_id`),
  CONSTRAINT `comment_doc_id` FOREIGN KEY (`comment_doc_id`) REFERENCES `document` (`doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `comment_upg_id` FOREIGN KEY (`comment_upg_id`) REFERENCES `userpositiongroup` (`upg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (106,'nice one',72715,52053,'Apr 06, 2018','08:35:47am');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deppos`
--

DROP TABLE IF EXISTS `deppos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deppos` (
  `deppos_id` int(11) NOT NULL,
  `pos_id` int(11) DEFAULT NULL,
  `pos_group_id` int(11) DEFAULT NULL,
  `deppos_status` varchar(45) DEFAULT NULL,
  `posLevel` int(11) DEFAULT NULL,
  `motherPos` int(11) DEFAULT NULL,
  PRIMARY KEY (`deppos_id`),
  KEY `deppos_pos_id_idx` (`pos_id`),
  KEY `deppos_group_id_idx` (`pos_group_id`),
  KEY `deppos_motherPos_idx` (`motherPos`),
  CONSTRAINT `deppos_group_id` FOREIGN KEY (`pos_group_id`) REFERENCES `group` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `deppos_motherPos` FOREIGN KEY (`motherPos`) REFERENCES `deppos` (`deppos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `deppos_pos_id` FOREIGN KEY (`pos_id`) REFERENCES `position` (`pos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deppos`
--

LOCK TABLES `deppos` WRITE;
/*!40000 ALTER TABLE `deppos` DISABLE KEYS */;
INSERT INTO `deppos` VALUES (252,8169,4765,'active',2,5902),(308,4315,6127,'active',3,6150),(724,9384,3616,'active',0,NULL),(742,9000,7342,'active',0,NULL),(1377,4315,485,'active',3,7719),(1404,8422,4765,'inactive',2,5902),(2017,2489,683,'active',1,7256),(2165,1831,686,'active',4,8227),(2268,9677,4246,'active',4,5208),(2593,6558,4062,'active',1,742),(3504,7851,9276,'active',1,742),(3728,9384,1485,'active',0,NULL),(3841,9677,897,'active',4,8140),(4127,8169,6870,'active',2,5902),(4700,69470,8721,'active',0,NULL),(5208,7762,4246,'active',3,252),(5486,6621,9359,'active',3,6150),(5559,6621,8721,'active',3,6150),(5848,69470,586,'active',0,NULL),(5850,9384,897,'active',0,NULL),(5902,6191,6076,'active',1,7256),(6150,9969,6127,'active',2,3504),(6159,9384,4246,'active',0,NULL),(6671,7762,1485,'active',3,4127),(7243,9677,1485,'active',4,6671),(7256,2512,683,'active',0,NULL),(7517,2489,4765,'active',3,252),(7538,1831,9359,'active',4,5486),(7719,9969,485,'active',2,3504),(7751,5028,5715,'active',2,2593),(7818,7762,3616,'active',3,252),(7969,4315,5715,'inactive',3,7751),(8140,7762,897,'active',3,252),(8227,6621,686,'active',3,6150),(8456,69470,686,'active',0,NULL),(9009,1831,586,'active',4,9156),(9156,6621,586,'active',3,7719),(9395,2489,6870,'active',3,4127),(9872,9677,3616,'active',4,7818),(9912,6320,683,'active',1,7256),(9936,1831,8721,'active',4,5559);
/*!40000 ALTER TABLE `deppos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `doc_id` int(11) NOT NULL,
  `docname` varchar(45) DEFAULT NULL,
  `doc_path` varchar(45) DEFAULT NULL,
  `template_template_id` int(11) DEFAULT NULL,
  `userpositiongroup_upg_id` int(11) DEFAULT NULL,
  `sentDate` varchar(45) DEFAULT NULL,
  `sentTime` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`doc_id`),
  KEY `fk_document_template1_idx` (`template_template_id`),
  KEY `fk_document_userpositiongroup1_idx` (`userpositiongroup_upg_id`),
  CONSTRAINT `fk_document_template1` FOREIGN KEY (`template_template_id`) REFERENCES `template` (`template_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_document_userpositiongroup1` FOREIGN KEY (`userpositiongroup_upg_id`) REFERENCES `userpositiongroup` (`upg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
INSERT INTO `document` VALUES (13064,'SAO Borrower\'s Slip','file/13064.docx',686,19693,'Apr 10, 2018','11:05:16 pm'),(43722,'test Template','file/43722.docx',466,98829,'Apr 06, 2018','01:14:44 pm'),(71097,'SAO Borrower\'s Slip','file/71097.docx',686,52602,'Apr 11, 2018','09:58:07 am'),(72715,'test Template','file/72715.docx',466,33019,'Apr 06, 2018','08:28:57 am'),(84974,'SAO Borrower\'s Slip','file/84974.docx',686,52602,'Apr 10, 2018','11:01:00 pm'),(98921,'test Template','file/98921.docx',466,98829,'Apr 05, 2018','11:57:32 pm');
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group` (
  `group_id` int(11) NOT NULL,
  `groupName` varchar(45) DEFAULT NULL,
  `groupDescription` varchar(300) DEFAULT NULL,
  `creator_user_id` int(11) DEFAULT NULL,
  `group_group_id` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `businessKey` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `fk_groups_user1_idx` (`creator_user_id`),
  KEY `fk_group_group_idx` (`group_group_id`),
  CONSTRAINT `fk_group_group` FOREIGN KEY (`group_group_id`) REFERENCES `group` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_groups_user1` FOREIGN KEY (`creator_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group`
--

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
INSERT INTO `group` VALUES (485,'CICCT',NULL,978627,9276,'active',97984,'usjrcicct'),(586,'CS/IT Department',NULL,978627,485,'active',97984,'usjrcsit'),(683,'President',NULL,502699,92380,'active',92380,'pres2'),(686,'Accounting and Finance',NULL,978627,6127,'active',97984,'usjraccounting'),(897,'Marketing',NULL,502699,4765,'active',92380,'marketing2'),(1485,'IT/CS Department',NULL,502699,6870,'active',92380,'itcs2'),(3616,'THMD',NULL,502699,4765,'active',92380,'thmd2'),(4062,'VP-Welfare',NULL,978627,7342,'active',97984,'usjrvpwelfare'),(4246,'Accountancy',NULL,502699,4765,'active',92380,'accountancy2'),(4765,'Commerce',NULL,502699,6076,'active',92380,'commerce2'),(5715,'SAO',NULL,978627,4062,'active',97984,'usjrsao'),(6076,'Vice President',NULL,502699,683,'active',92380,'vicepres2'),(6127,'Commerce',NULL,978627,9276,'active',97984,'usjrcommerce'),(6870,'IT College',NULL,502699,6076,'active',92380,'it2'),(7342,'President',NULL,978627,97984,'active',97984,'usjrpresident'),(8721,'Marketing',NULL,978627,6127,'active',97984,'usjrmarketing'),(9276,'VP-Academics',NULL,978627,7342,'active',97984,'usjrvpacad'),(9359,'THMD',NULL,978627,6127,'active',97984,'usjrthmd'),(92380,'Test School Cebu','',502699,NULL,'Active',NULL,'cebu123'),(97984,'University of San Jose- Recoletos','',978627,NULL,'Active',NULL,'usjr123');
/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inbox`
--

DROP TABLE IF EXISTS `inbox`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inbox` (
  `inbox_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) DEFAULT NULL,
  `upg_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`inbox_id`),
  KEY `fk_inbox_doc_id_idx` (`doc_id`),
  CONSTRAINT `fk_inbox_doc_id` FOREIGN KEY (`doc_id`) REFERENCES `document` (`doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inbox`
--

LOCK TABLES `inbox` WRITE;
/*!40000 ALTER TABLE `inbox` DISABLE KEYS */;
INSERT INTO `inbox` VALUES (56,98921,55706),(57,98921,48145),(58,98921,2999),(59,72715,52053),(60,72715,48145),(61,43722,55706),(62,43722,48145),(63,43722,2999),(64,84974,38335),(65,84974,76750),(66,13064,88739),(67,13064,76750),(68,71097,38335),(69,71097,76750);
/*!40000 ALTER TABLE `inbox` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `tran_id` int(11) DEFAULT NULL,
  `inbox_id` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `datetime` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `log_tran_id_idx` (`tran_id`),
  CONSTRAINT `log_tran_id` FOREIGN KEY (`tran_id`) REFERENCES `transaction` (`tran_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=72131 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (72042,61,NULL,'pending','Apr 05, 2018 23:57:33 pm'),(72043,NULL,'56','unread','Apr 05, 2018 23:57:33 pm'),(72044,NULL,'56','read','Apr 05, 2018 23:58:26 pm'),(72045,61,NULL,'approved','Apr 05, 2018 23:58:35 pm'),(72046,62,NULL,'pending','Apr 05, 2018 23:58:35 pm'),(72047,NULL,'57','unread','Apr 05, 2018 23:58:35 pm'),(72048,NULL,'57','read','Apr 05, 2018 23:59:11 pm'),(72049,62,NULL,'rejected','Apr 05, 2018 23:59:31 pm'),(72050,61,NULL,'pending','Apr 05, 2018 23:59:31 pm'),(72051,NULL,'56','unread','Apr 05, 2018 23:59:31 pm'),(72052,NULL,'56','read','Apr 05, 2018 23:59:55 pm'),(72053,61,NULL,'approved','Apr 06, 2018 00:00:02 am'),(72054,62,NULL,'pending','Apr 06, 2018 00:00:02 am'),(72055,NULL,'57','unread','Apr 06, 2018 00:00:02 am'),(72056,NULL,'57','read','Apr 06, 2018 00:00:30 am'),(72057,62,NULL,'approved','Apr 06, 2018 00:00:39 am'),(72058,63,NULL,'pending','Apr 06, 2018 00:00:39 am'),(72059,NULL,'58','unread','Apr 06, 2018 00:00:39 am'),(72060,NULL,'58','read','Apr 06, 2018 00:01:04 am'),(72061,63,NULL,'approved','Apr 06, 2018 00:01:23 am'),(72062,64,NULL,'pending','Apr 06, 2018 08:29:03 am'),(72063,NULL,'59','unread','Apr 06, 2018 08:29:03 am'),(72064,NULL,'59','read','Apr 06, 2018 08:34:00 am'),(72065,64,NULL,'approved','Apr 06, 2018 08:35:52 am'),(72066,65,NULL,'pending','Apr 06, 2018 08:35:52 am'),(72067,NULL,'60','unread','Apr 06, 2018 08:35:53 am'),(72068,67,NULL,'pending','Apr 06, 2018 13:14:44 pm'),(72069,NULL,'61','unread','Apr 06, 2018 13:14:44 pm'),(72070,NULL,'61','read','Apr 06, 2018 13:22:27 pm'),(72071,67,NULL,'approved','Apr 06, 2018 13:22:34 pm'),(72072,68,NULL,'pending','Apr 06, 2018 13:22:34 pm'),(72073,NULL,'62','unread','Apr 06, 2018 13:22:34 pm'),(72074,NULL,'62','read','Apr 06, 2018 13:23:09 pm'),(72075,68,NULL,'rejected','Apr 06, 2018 13:23:17 pm'),(72076,67,NULL,'pending','Apr 06, 2018 13:23:17 pm'),(72077,NULL,'61','unread','Apr 06, 2018 13:23:17 pm'),(72078,NULL,'61','read','Apr 06, 2018 15:09:12 pm'),(72079,67,NULL,'approved','Apr 06, 2018 15:11:51 pm'),(72080,68,NULL,'pending','Apr 06, 2018 15:11:51 pm'),(72081,NULL,'62','unread','Apr 06, 2018 15:11:51 pm'),(72082,NULL,'62','read','Apr 06, 2018 15:12:28 pm'),(72083,68,NULL,'approved','Apr 06, 2018 15:12:34 pm'),(72084,69,NULL,'pending','Apr 06, 2018 15:12:34 pm'),(72085,NULL,'63','unread','Apr 06, 2018 15:12:34 pm'),(72086,NULL,'63','read','Apr 06, 2018 15:12:55 pm'),(72087,69,NULL,'rejected','Apr 06, 2018 15:12:59 pm'),(72088,68,NULL,'pending','Apr 06, 2018 15:12:59 pm'),(72089,NULL,'62','unread','Apr 06, 2018 15:12:59 pm'),(72090,NULL,'62','read','Apr 06, 2018 15:13:25 pm'),(72091,68,NULL,'approved','Apr 06, 2018 15:22:06 pm'),(72092,69,NULL,'pending','Apr 06, 2018 15:22:06 pm'),(72093,NULL,'63','unread','Apr 06, 2018 15:22:06 pm'),(72094,NULL,'63','read','Apr 06, 2018 15:23:08 pm'),(72095,69,NULL,'approved','Apr 06, 2018 15:23:14 pm'),(72096,70,NULL,'pending','Apr 10, 2018 23:01:01 pm'),(72097,NULL,'64','unread','Apr 10, 2018 23:01:01 pm'),(72098,NULL,'64','read','Apr 10, 2018 23:01:37 pm'),(72099,70,NULL,'approved','Apr 10, 2018 23:01:55 pm'),(72100,71,NULL,'pending','Apr 10, 2018 23:01:55 pm'),(72101,NULL,'65','unread','Apr 10, 2018 23:01:55 pm'),(72102,NULL,'65','read','Apr 10, 2018 23:02:22 pm'),(72103,71,NULL,'rejected','Apr 10, 2018 23:02:27 pm'),(72104,70,NULL,'pending','Apr 10, 2018 23:02:27 pm'),(72105,NULL,'64','unread','Apr 10, 2018 23:02:27 pm'),(72106,NULL,'64','read','Apr 10, 2018 23:02:56 pm'),(72107,70,NULL,'approved','Apr 10, 2018 23:03:13 pm'),(72108,71,NULL,'pending','Apr 10, 2018 23:03:13 pm'),(72109,NULL,'65','unread','Apr 10, 2018 23:03:13 pm'),(72110,NULL,'65','read','Apr 10, 2018 23:03:43 pm'),(72111,71,NULL,'approved','Apr 10, 2018 23:03:48 pm'),(72112,72,NULL,'pending','Apr 10, 2018 23:05:16 pm'),(72113,NULL,'66','unread','Apr 10, 2018 23:05:17 pm'),(72114,NULL,'66','read','Apr 10, 2018 23:16:42 pm'),(72115,72,NULL,'approved','Apr 10, 2018 23:17:21 pm'),(72116,73,NULL,'pending','Apr 10, 2018 23:17:21 pm'),(72117,NULL,'67','unread','Apr 10, 2018 23:17:21 pm'),(72118,NULL,'67','read','Apr 10, 2018 23:17:45 pm'),(72119,73,NULL,'approved','Apr 10, 2018 23:17:49 pm'),(72120,74,NULL,'pending','Apr 11, 2018 09:58:12 am'),(72121,NULL,'68','unread','Apr 11, 2018 09:58:12 am'),(72122,NULL,'68','read','Apr 11, 2018 10:00:26 am'),(72123,74,NULL,'approved','Apr 11, 2018 10:00:43 am'),(72124,75,NULL,'pending','Apr 11, 2018 10:00:43 am'),(72125,NULL,'69','unread','Apr 11, 2018 10:00:43 am'),(72126,NULL,'69','read','Apr 11, 2018 10:01:08 am'),(72127,75,NULL,'rejected','Apr 11, 2018 10:01:22 am'),(72128,74,NULL,'pending','Apr 11, 2018 10:01:22 am'),(72129,NULL,'68','unread','Apr 11, 2018 10:01:22 am'),(72130,NULL,'68','read','Apr 11, 2018 10:01:46 am');
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `next`
--

DROP TABLE IF EXISTS `next`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `next` (
  `next_id` int(11) NOT NULL,
  `ws_id` int(11) DEFAULT NULL,
  `next_wsid` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`next_id`),
  KEY `next_wsid_fk_idx` (`ws_id`),
  CONSTRAINT `next_wsid_fk` FOREIGN KEY (`ws_id`) REFERENCES `workflowsteps` (`ws_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `next`
--

LOCK TABLES `next` WRITE;
/*!40000 ALTER TABLE `next` DISABLE KEYS */;
INSERT INTO `next` VALUES (40879,33491,''),(57454,58029,'76119'),(61048,76119,'33491'),(71004,74758,'15164'),(96194,15164,'');
/*!40000 ALTER TABLE `next` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `not_id` int(11) NOT NULL AUTO_INCREMENT,
  `from_upg_id` int(11) DEFAULT NULL,
  `message` varchar(300) DEFAULT NULL,
  `notificationcol` varchar(45) DEFAULT NULL,
  `to_upg_id` int(11) DEFAULT NULL,
  `not_status` varchar(45) DEFAULT NULL,
  `not_datetime` varchar(45) DEFAULT NULL,
  `doc_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`not_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (7,48145,'test Template has been rejected by Erica June. Document is sent back to you.',NULL,55706,'unread','Apr 05, 2018 23:59:31 pm',NULL),(8,48145,'test Template has been rejected by Erica June. Document is sent back to you.',NULL,55706,'read','Apr 06, 2018 13:23:17 pm',43722),(9,2999,'test Template has been rejected by Chris Brown. Document is sent back to you.',NULL,48145,'read','Apr 06, 2018 15:12:59 pm',43722),(10,76750,'SAO Borrower\'s Slip has been rejected by Jesus Velez. Document is sent back to you.',NULL,38335,'read','Apr 10, 2018 23:02:27 pm',84974),(11,76750,'SAO Borrower\'s Slip has been rejected by Jesus Velez. Document is sent back to you.',NULL,38335,'read','Apr 11, 2018 10:01:22 am',71097);
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orgchart`
--

DROP TABLE IF EXISTS `orgchart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orgchart` (
  `orgchart_id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(45) DEFAULT NULL,
  `group_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`orgchart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=961 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgchart`
--

LOCK TABLES `orgchart` WRITE;
/*!40000 ALTER TABLE `orgchart` DISABLE KEYS */;
INSERT INTO `orgchart` VALUES (105,NULL,'6127'),(213,NULL,'6870'),(229,NULL,'3616'),(230,NULL,'9359'),(340,NULL,'4062'),(360,NULL,'6076'),(443,NULL,'4765'),(480,NULL,'586'),(485,NULL,'683'),(511,NULL,'4246'),(638,NULL,'485'),(665,NULL,'5715'),(815,NULL,'897'),(837,NULL,'8721'),(852,NULL,'9276'),(878,NULL,'7342'),(896,NULL,'686'),(960,NULL,'1485');
/*!40000 ALTER TABLE `orgchart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orgchartnode`
--

DROP TABLE IF EXISTS `orgchartnode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orgchartnode` (
  `orgchartnode_id` int(11) NOT NULL AUTO_INCREMENT,
  `orgchart_id` int(11) DEFAULT NULL,
  `upg_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`orgchartnode_id`),
  KEY `position_id_idx` (`orgchart_id`),
  KEY `upg_id_idx` (`upg_id`),
  CONSTRAINT `upg_id` FOREIGN KEY (`upg_id`) REFERENCES `userpositiongroup` (`upg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1198 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgchartnode`
--

LOCK TABLES `orgchartnode` WRITE;
/*!40000 ALTER TABLE `orgchartnode` DISABLE KEYS */;
INSERT INTO `orgchartnode` VALUES (1111,485,2999),(1112,360,2999),(1113,443,2999),(1114,213,2999),(1115,815,2999),(1116,229,2999),(1117,511,2999),(1118,960,2999),(1119,360,48145),(1120,443,48145),(1121,213,48145),(1122,815,48145),(1123,229,48145),(1124,511,48145),(1125,960,48145),(1126,213,55706),(1127,960,55706),(1128,213,66870),(1129,960,66870),(1130,960,40378),(1131,960,84013),(1132,511,52632),(1133,511,15120),(1134,443,52053),(1135,815,52053),(1136,229,52053),(1137,511,52053),(1138,443,73658),(1139,815,73658),(1140,229,73658),(1141,511,73658),(1142,878,3789),(1143,852,3789),(1144,638,3789),(1145,480,3789),(1146,852,96010),(1147,638,96010),(1148,480,96010),(1149,638,38335),(1150,480,38335),(1151,638,82090),(1152,480,82090),(1153,480,80806),(1154,480,43413),(1155,480,52602),(1156,105,3789),(1157,105,96010),(1158,896,3789),(1159,896,96010),(1160,230,3789),(1161,230,96010),(1162,837,3789),(1163,837,96010),(1164,105,88739),(1165,896,88739),(1166,837,88739),(1167,230,88739),(1168,896,34547),(1169,837,15143),(1170,340,3789),(1171,665,3789),(1172,340,88425),(1173,665,88425),(1174,665,76750),(1185,480,54205),(1186,896,6753),(1187,480,4702),(1188,878,1985),(1189,340,1985),(1190,852,1985),(1191,665,1985),(1192,638,1985),(1193,105,1985),(1194,480,1985),(1195,896,1985),(1196,837,1985),(1197,230,1985);
/*!40000 ALTER TABLE `orgchartnode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `position` (
  `pos_id` int(11) NOT NULL,
  `posName` varchar(45) DEFAULT NULL,
  `posDescription` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position`
--

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` VALUES (1831,'Faculty',NULL,'active',97984),(2489,'Secretary',NULL,'active',92380),(2512,'President',NULL,'active',92380),(4187,'test position 2',NULL,'inactive',92380),(4315,'Secretary',NULL,'active',97984),(5028,'SAO Director',NULL,'active',97984),(5299,'test position',NULL,'inactive',92380),(6191,'Vice President',NULL,'active',92380),(6320,'Staff',NULL,'active',92380),(6558,'VP-Welfare',NULL,'active',97984),(6621,'Chairperson',NULL,'active',97984),(7762,'Chairperson',NULL,'active',92380),(7851,'VP-Academics',NULL,'active',97984),(8169,'Dean',NULL,'active',92380),(8422,'Dean 2',NULL,'inactive',92380),(9000,'University President',NULL,'active',97984),(9384,'Student',NULL,'active',92380),(9677,'Faculty',NULL,'active',92380),(9969,'College Dean',NULL,'active',97984),(36499,'masteradmin','masteradmin','active',92380),(69470,'Student',NULL,'active',97984),(99511,'masteradmin','masteradmin','active',97984),(3168081,'Admin','','active',97984),(9532156,'Admin','','active',92380);
/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `previous`
--

DROP TABLE IF EXISTS `previous`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `previous` (
  `prev_id` int(11) NOT NULL,
  `ws_id` int(11) DEFAULT NULL,
  `prev_wsid` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`prev_id`),
  KEY `prev_wsid_fk_idx` (`ws_id`),
  CONSTRAINT `prev_wsid_fk` FOREIGN KEY (`ws_id`) REFERENCES `workflowsteps` (`ws_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `previous`
--

LOCK TABLES `previous` WRITE;
/*!40000 ALTER TABLE `previous` DISABLE KEYS */;
INSERT INTO `previous` VALUES (12554,74758,''),(15888,76119,'58029'),(55717,58029,''),(76203,33491,'76119'),(98347,15164,'74758');
/*!40000 ALTER TABLE `previous` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rights`
--

DROP TABLE IF EXISTS `rights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rights` (
  `rights_id` int(11) NOT NULL,
  `rightsName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`rights_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rights`
--

LOCK TABLES `rights` WRITE;
/*!40000 ALTER TABLE `rights` DISABLE KEYS */;
INSERT INTO `rights` VALUES (1,'Admin'),(2,'User');
/*!40000 ALTER TABLE `rights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `template`
--

DROP TABLE IF EXISTS `template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `template` (
  `template_id` int(11) NOT NULL,
  `templatename` varchar(200) DEFAULT NULL,
  `template_path` varchar(200) DEFAULT NULL,
  `group_group_id` int(11) DEFAULT NULL,
  `workflow_w_id` int(11) DEFAULT NULL,
  `filterView` varchar(45) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`template_id`),
  KEY `fk_template_groups1_idx` (`group_group_id`),
  KEY `fk_template_workflow1_idx` (`workflow_w_id`),
  CONSTRAINT `fk_template_groups1` FOREIGN KEY (`group_group_id`) REFERENCES `group` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_template_workflow1` FOREIGN KEY (`workflow_w_id`) REFERENCES `workflow` (`w_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `template`
--

LOCK TABLES `template` WRITE;
/*!40000 ALTER TABLE `template` DISABLE KEYS */;
INSERT INTO `template` VALUES (466,'test Template','templates/test Template.docx',683,67850,'All',92380,'active'),(686,'SAO Borrower\'s Slip','templates/SAO Borrower\'s Slip.docx',5715,66889,'All',97984,'active');
/*!40000 ALTER TABLE `template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transaction` (
  `tran_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_doc_id` int(11) NOT NULL,
  `upg_id` int(11) DEFAULT NULL,
  `wd_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `next` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`tran_id`),
  KEY `fk_transaction_document1_idx` (`document_doc_id`),
  CONSTRAINT `fk_transaction_document1` FOREIGN KEY (`document_doc_id`) REFERENCES `document` (`doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (61,98921,55706,58029,1,'76119'),(62,98921,48145,76119,2,'33491'),(63,98921,2999,33491,3,''),(64,72715,52053,58029,1,'76119'),(65,72715,48145,76119,2,'33491'),(66,72715,2999,33491,3,''),(67,43722,55706,58029,1,'76119'),(68,43722,48145,76119,2,'33491'),(69,43722,2999,33491,3,''),(70,84974,38335,74758,1,'15164'),(71,84974,76750,15164,2,''),(72,13064,88739,74758,1,'15164'),(73,13064,76750,15164,2,''),(74,71097,38335,74758,1,'15164'),(75,71097,76750,15164,2,'');
/*!40000 ALTER TABLE `transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contactnum` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `profilepic` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (112663,'$2y$10$g68MUbAKC6pPqLC0LMVzn.AsmgvFiBkeaac0PvM842w4wJ.FnRtSO','Miro','Lorna','Female','Cebu','miro@usjr.com','345343565','active','default.png','','ljVMNyNxsacoBRGxJVhelddojF8QZaOFtlsmWBTQKQjXHhNEGHXPIANbQcbJ'),(114649,'$2y$10$5IlmQ7dHI3N0.dANk2bmte9ubAeIBnqeUKQS3QJVGq8qngQxPQ6fu','Solar','Dexter','Male','Cebu','dexter@usjr.com','234567','active','default.png','','J17tlT0WzPS2baL4euO9XrBIgkmnDVo2tIPspgAuZNV6tAYp85e1jam3sZNE'),(146218,'$2y$10$bUS35TMyY8DrIVb1vApTIOEEfld5nBdUu2mS.inIj/e.q2.gyKFAi','Hwang','Nene','Female','Cebu','nene@usjr.com','234565','active','default.png','','XATqk50PRnXM1vTmlpwPKAqj3rOnLGakhPMItOJ7lDLdaKcCWR0L7Kfnf7vB'),(147154,'$2y$10$H6abmUxAHo1pDEYwiXcFQuuq4vfgLIXC2IfafYW1X/t9IZ.84llx2','solll','dexxx','Male','fdas','dexxx@usjr.com','213','active','default.png','','tChlA6u2ryC3RQWc9wvJxgE5SKQluGy7SkcM8nj157rUbX7mHI6TGbepQhxP'),(151707,'$2y$10$KFejdO6fZUgDLZJpW/Nyju7B9mMungAb1gOen2TBnvihQY0NvAwGe','Wing','Ethel','Female','Cebu','ethel@test2.com','34567','active','default.png','','tOEcBrYX1WZ9whCOTwTTDAjNigYslsBeKd1R8kaDNmYJNsRc8aze4zuaCv8a'),(152558,'$2y$10$UDJfnqtlfP5tBVvT.tGMAOaiz5/vmCAf20EGBSrWMlSdjS075xmDu','Doe','John','Male','Cebu','john@test2.com','3456','active','default.png','','WnLRyRvj4BcENFNgFZFFPe65aWW255IJ37eHCeJp95ohcTTSzUOo95guAsWx'),(206885,'$2y$10$6IQxjfuZ7UuNwyHZfdQ/vu9uvQqrqvOU4tdzVRG/hMExdAbYsGw/.','Turn','Allan','Male','Cebu','allan@test2.com','243455','active','default.png','','1e8ht2d0a0VVxEnQhGk26O2JbnaiFZvUZvyrSaWHuC2HdXgMPlqalo0CGAFV'),(212160,'$2y$10$TtrP/yW2Ij7GB27sLmaW1OCI8t74DaqzlaY/nqgGIQic6cvr2RoGO','Gabison','Gregg','Male','Cebu City','gregg@usjr.com','5674565','active','default.png','','cxhqLhDO2jJnwMZjAk1MLN0unbnwbQVhEKYYdl5BTijyM0ZnGEkVbVMVperU'),(243309,'$2y$10$HSI1x7RQJsp8zPOK3FZOY.06vAoGLMacN4DikhgieIFi.ZRLWdLB2','June','Erica','Female','Cebu','erica@test2.com','234567','active','default.png','','vAnsPs5hxrE5Am8KVO5lIxGiDDEwVkNx32KbfRFrNTfYa8fWYJIvhSFn6N6O'),(267904,'$2y$10$hm6vp173npbJIRHmLBq.WuQ2hOJPwSJzzB.0NFbAh29SvZVx7Zo2e','Smith','Will','Male','fds','smith@usjr.com','123','inactive','default.png','','b5F7EZ4VpOgD2Ybb2ahguLGygNrpOZAFPVosCOqNIfXX6JDgf7u3YBQvSQXj'),(390840,'$2y$10$tFa/hVFYcwX9IZB0biEFzu2oIqHPIk0Cc4iF3yxaZOK/lGYcVgcY6','Uy','Christine','Female','Cebu','christine@usjr.com','32344556','active','default.png','','TyJSB33x4CMJ4F7cXgYp1OgYA5TOqbztVyRN6w1UEyuqcpUFhyoPrjZziUnN'),(472117,'$2y$10$gog3AobfkWmnB5mNThLWSe2lUqH/JjExtTpuoK0zrSFxcqHtzY/rK','Detoya','Edgar','Male','Cebu','edgar@usjr.com','23456678','active','default.png','','uQwansU4MF1EBfxXTbze5xOkKVboZUhgphtEj9KIKYYOBojLT6UipeV6FE4i'),(478708,'$2y$10$I73Kx2iCw1lPAN9iW0pzDOGVIR.klC/zr3CX/w8kdUJzSgfYW01Ie','Doe','Jane','Female','Cebu','jane@usjr.com','234567','active','default.png','','7JdAxbcvLr3ZzPDhQU7ZzmlmJHGiVWfqgulvqA1fEL4bH81OTZlpTPaFIQTp'),(491638,'$2y$10$x4aim4gg7Dg1rV6bw6fuJONuC9831U2Rp6JoUfhwUtSDjoV.Xctfi','Abarquez','Trina','Female','Cebu','trina@usjr.com','234567','active','default.png','','Cre6yA2xo1EtBLLB7ncpxiru51NhFngXICu6nqSXutPiILRBdpw6uIGXHy35'),(502699,'$2y$10$kPbzmfuFB77AcnOkgrrgUuCgZIDH2xIeA8Xp1uqUTHYs/JR888wYG','Brown','Chris','Male','Cebu','chris@test2.com','45667','active',NULL,NULL,'c9bwMmbKULrIN5uxSz5bvhc5lu53B84hN2URKiQrrt03uK6lsRyEngIom7vc'),(584906,'$2y$10$kdVIXTI9CyL0mJcm8dIZl.ImRHToySBQWHpjCMk2ljM8/1lZFWeE6','Shell','Pearl','Female','Cebu','pearl@test2.com','2345','active','default.png','','mSB7sWQbYyE6DnophRrtgJ8gajxhiawKC6doTF2DP8lm7LhLvsVkHmAWJyQC'),(592883,'$2y$10$Bs9j28BaBrw10Fv9vXpu9ugyH5hVxvPt76S67sNvEpn8H3a5eww5m','Rose','Rita','Female','Cebu','rita@test2.com','34456','active','default.png','','QcottU4dW7bJjvNfwlPiyVrc2UQntTm3OaJ0p995yzjZpO9syxaxj45abCV7'),(615211,'$2y$10$d.6tJd4uy2A/.gZz1Uw6M.jfc2M.ZiTTPzVlvFdPRP.51y8jdO2m6','Walls','Joseph','Male','Cebu','joseph@test2.com','2345','active','default.png','','qLB1MzpGyU7gqv5o0hZHiXd1LFWPsS1jr0ktouSebdppP3LrVtWLoqjRsf9y'),(670048,'$2y$10$6eIej7zkcoy3lmDuIfMFiewJe3IzmdvpmdVOYOAsQXb7fYVv2Sw.O','Law','Marcus','Male','Cebu','marcus@test2.com','234567','active','default.png','','QuBkDyzxswQKpd0pL5pV4UsUNF7O7Ip00CtlenWOZpcbvTdilUwcSYlV3rN8'),(672662,'$2y$10$WQPRBUpFJdRCXv9mnPMw2ey6MsfpJJX7KygLttIUpurK9VoHsHf9O','Gudio','Jeoffrey','Male','Cebu City','gudio@usjr.com','35465','active','default.png','','P6bl5G28ghiaUU8xyqUPzH8s5sVIiVeGYZcfNjUiAJ27vBuLzLsbOJotwYrp'),(721146,'$2y$10$5g200htkybvW6OSl8DwYaOtJZajKQ0Jg7vvckKzQTbi86UVIcRVjq','Grace','Harian','Female','Cebu','harian@test2.com','23456','active','default.png','','37tovLvs3dZcvnUONgX8uesG5uJ3giV60ZDq2RPnVe3yGMkRY2TbCb0ewbE5'),(759974,'$2y$10$FQr8ifbFP1ktFcVeY.5kieUvMyBPeIU7i6fE5FX5vEiPsRqE9x.66','Raras','Nestor','Male','Cebu','raras@usjr.com','23456','active','default.png','','k4k2GTgbPZ7fPt5JmIblI7FCDsojfDEZaRUSoFJnPCk9HXQHd3iA9bCrfgqD'),(797974,'$2y$10$Fey5SutQiU.O1pN3RtjIPe0FWrnsUh4Qx8KSRnvIvcNGGayWJcu1S','Fair','Angela','Female','Cebu','angela@test2.com','2345676','active','default.png','','uqWshCcax59t3aHPhr2TqprypB2W0ftNB1UHw8JxjjcUT2SWD0OZnAhEbgXN'),(825012,'$2y$10$prP/3q4D6HJ8DJ5.S75zkefdd0Ej0EJInyyA5hz/5JR3.5ESI6n.G','Mart','Walton','Male','Cebu','walton@test2.com','3234','active','default.png','','gNyitT0Vizjp5VbUcnCfKaQipCmIvJFOyePjsNtfqcmDW4mH8gVw5z094ehb'),(836493,'$2y$10$APUz1k9VkV5ypK3ekqNMXeQ.LA0cgBqphdRYT/vE51U0Up/VWohay','Bumangabang','James','Male','Cebu City','james@usjr.com','345678','active','default.png','','t4fNoPzg8X0wj2KExxXo9Jl3l0tBSHPc4qPONemW2193C2kxcZ1hDDN7Kdad'),(847913,'$2y$10$IAzvNmQCxqVZiQX./9zhx.HhTmtn6kFi7k54hQkTMVCuSl8ObCVWu','Sanchez','Ken','Male','Talisay City Cebu','sanchez@usjr.com','0921334','active','default.png','',NULL),(871105,'$2y$10$sdS4V8jBOkAtBLLJqIWvAewUUk6Tf47gaRM5OxN/1EqOQ40G87ssq','Velez','Jesus','Male','Cebu','velez@usjr.com','34567','active','default.png','','tHbWq8UaMaDmz8IOxGtStMzgtsZCKU7Lr6QPZgMwf3jrNBJMA9zyjyYaZHRp'),(978627,'$2y$10$vDvKltTLfVmN9Yph7IknkOk/iSi/S1s0zjHOZK8us0E/bnpnjXbvS','Maspara','Christopher','Male','Cebu City','maspara@usjr.com','24345','active','default.png',NULL,'1rY9ijUIknuDjbFUkYawSonRCogivC1OLjoNyouZeNXEtKxLSt7c4nDtDMf5'),(993809,'$2y$10$kdo1lNm2gN6UDNZYMOd9D.ZSK2ApcrcLTxmOIpuZ6erbjc2FQ/hBG','Cuizon','Jovelyn','Female','Cebu City','cuizon@usjr.com','3456','active','default.png','','eSPsDvu0C9lY6208eIUz52JcMNjh37B6x4rwSR5gINTi9ZmrFRbYyokDKPYS'),(996244,'$2y$10$pcdzuPfm/7TiUB34McD4OeRn9x3bn5QfwszHwpw9ebGrIEeEG51fy','Mateo','Emilio','Male','Cebu','emilio@usjr.com','2345678','active','default.png','','LmTUf0WmhBf9dwAG0Ppr9iOGYp8e9IzOmQgXFmKnSAqECxfVyX7CR103OCPy');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userpositiongroup`
--

DROP TABLE IF EXISTS `userpositiongroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userpositiongroup` (
  `upg_id` int(11) NOT NULL,
  `position_pos_id` int(11) DEFAULT NULL,
  `rights_rights_id` int(11) DEFAULT NULL,
  `user_user_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `group_group_id` int(11) DEFAULT NULL,
  `upg_status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`upg_id`),
  KEY `fk_userpositiongroup_rights1_idx` (`rights_rights_id`),
  KEY `fk_userpositiongroup_user1_idx` (`user_user_id`),
  KEY `fk_userpositiongroup_groups1_idx` (`group_group_id`),
  CONSTRAINT `fk_userpositiongroup_groups1` FOREIGN KEY (`group_group_id`) REFERENCES `group` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_userpositiongroup_rights1` FOREIGN KEY (`rights_rights_id`) REFERENCES `rights` (`rights_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_userpositiongroup_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userpositiongroup`
--

LOCK TABLES `userpositiongroup` WRITE;
/*!40000 ALTER TABLE `userpositiongroup` DISABLE KEYS */;
INSERT INTO `userpositiongroup` VALUES (1285,2165,2,147154,97984,686,'inactive'),(1985,742,2,NULL,97984,7342,'active'),(2999,7256,2,502699,92380,683,'active'),(3789,742,2,978627,97984,7342,'active'),(4702,9009,2,147154,97984,586,'active'),(6753,1831,2,147154,97984,686,'active'),(15120,2268,2,670048,92380,4246,'active'),(15143,5559,2,996244,97984,8721,'active'),(15635,99511,1,978627,97984,97984,'active'),(19693,8456,2,478708,97984,686,'active'),(21543,9156,2,847913,97984,586,'inactive'),(23593,5848,2,114649,97984,586,'active'),(32608,4700,2,146218,97984,8721,'active'),(33019,6159,2,206885,92380,4246,'active'),(34102,36499,1,502699,92380,92380,'active'),(34547,8227,2,390840,97984,686,'active'),(38335,7719,2,212160,97984,485,'active'),(40378,6671,2,797974,92380,1485,'active'),(43413,9009,2,112663,97984,586,'active'),(48145,5902,2,243309,92380,6076,'active'),(52053,252,2,592883,92380,4765,'active'),(52602,5848,2,491638,97984,586,'active'),(52632,5208,2,584906,92380,4246,'active'),(54205,1831,2,147154,97984,586,'active'),(55706,4127,2,151707,92380,6870,'active'),(66870,9395,2,615211,92380,6870,'active'),(73658,7517,2,152558,92380,4765,'active'),(76750,7751,2,871105,97984,5715,'active'),(80806,9156,2,993809,97984,586,'active'),(82090,1377,2,672662,97984,485,'active'),(84013,7243,2,825012,92380,1485,'active'),(88425,2593,2,759974,97984,4062,'active'),(88739,6150,2,472117,97984,6127,'active'),(96010,3504,2,836493,97984,9276,'active'),(98829,3728,2,721146,92380,1485,'active');
/*!40000 ALTER TABLE `userpositiongroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflow`
--

DROP TABLE IF EXISTS `workflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow` (
  `w_id` int(11) NOT NULL,
  `workflowName` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`w_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workflow`
--

LOCK TABLES `workflow` WRITE;
/*!40000 ALTER TABLE `workflow` DISABLE KEYS */;
INSERT INTO `workflow` VALUES (66889,'Dean to SAO Director','active',97984),(67850,'Dean to President','active',92380);
/*!40000 ALTER TABLE `workflow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workflowsteps`
--

DROP TABLE IF EXISTS `workflowsteps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflowsteps` (
  `ws_id` int(11) NOT NULL,
  `workflow_w_id` int(11) NOT NULL,
  `position_pos_id` int(11) NOT NULL,
  `order` varchar(45) DEFAULT NULL,
  `action` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ws_id`),
  KEY `fk_workflowsteps_workflow1_idx` (`workflow_w_id`),
  KEY `fk_workflowsteps_position1_idx` (`position_pos_id`),
  CONSTRAINT `fk_workflowsteps_position1` FOREIGN KEY (`position_pos_id`) REFERENCES `position` (`pos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_workflowsteps_workflow1` FOREIGN KEY (`workflow_w_id`) REFERENCES `workflow` (`w_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workflowsteps`
--

LOCK TABLES `workflowsteps` WRITE;
/*!40000 ALTER TABLE `workflowsteps` DISABLE KEYS */;
INSERT INTO `workflowsteps` VALUES (15164,66889,5028,'2','sign'),(33491,67850,2512,'3','sign'),(58029,67850,8169,'1','sign'),(74758,66889,9969,'1','sign'),(76119,67850,6191,'2','sign');
/*!40000 ALTER TABLE `workflowsteps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wsreceiver`
--

DROP TABLE IF EXISTS `wsreceiver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wsreceiver` (
  `wsrec_id` int(11) NOT NULL,
  `ws_id` int(11) DEFAULT NULL,
  `receiver` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`wsrec_id`),
  KEY `wsrec_ws_id_fk_idx` (`ws_id`),
  CONSTRAINT `wsrec_ws_id_fk` FOREIGN KEY (`ws_id`) REFERENCES `workflowsteps` (`ws_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wsreceiver`
--

LOCK TABLES `wsreceiver` WRITE;
/*!40000 ALTER TABLE `wsreceiver` DISABLE KEYS */;
INSERT INTO `wsreceiver` VALUES (28693,15164,'All'),(38197,76119,'All'),(42775,33491,'All'),(70124,74758,'All'),(96070,58029,'All');
/*!40000 ALTER TABLE `wsreceiver` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-15 11:35:14
