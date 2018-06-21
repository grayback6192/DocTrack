-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: doctrack
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
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgchart`
--

LOCK TABLES `orgchart` WRITE;
/*!40000 ALTER TABLE `orgchart` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=1175 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgchartnode`
--

LOCK TABLES `orgchartnode` WRITE;
/*!40000 ALTER TABLE `orgchartnode` DISABLE KEYS */;
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

-- Dump completed on 2018-06-21 19:52:18
