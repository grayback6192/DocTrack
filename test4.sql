-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: test4
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
-- Table structure for table `by`
--

DROP TABLE IF EXISTS `by`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `by` (
  `by_id` int(11) NOT NULL,
  `byName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`by_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `by`
--

LOCK TABLES `by` WRITE;
/*!40000 ALTER TABLE `by` DISABLE KEYS */;
/*!40000 ALTER TABLE `by` ENABLE KEYS */;
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
INSERT INTO `document` VALUES (37728,'TEst','file/37728.docx',630,78546,'Feb 12, 2018','16:29:40pm'),(45937,'Acquiantance Party','file/45937.docx',630,78546,'Feb 12, 2018','00:46:34am'),(81232,'Excuse Letter','file/81232.docx',18,78546,'Feb 13, 2018','20:26:35pm'),(98166,'TestTestTest','file/98166.docx',18,74433,'Feb 14, 2018','10:50:13am');
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
  `groupDescription` varchar(45) DEFAULT NULL,
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
INSERT INTO `group` VALUES (11858,'I.T.','Information Technology Department',405596,81420,'active',81420,'testit'),(16839,'JPIA','Junior Philippine Institute of Accountants',405596,42297,'active',81420,'testjpia'),(35941,'Commerce','Commerce Dep',405596,81420,'active',81420,'testcommerce'),(42297,'Accounting',NULL,405596,35941,'active',81420,'testaccounting'),(43710,'CS','Computer Science',405596,11858,'active',81420,'testcs'),(58633,'Marketing','Marketing Department',405596,35941,'active',81420,'testmarketing'),(66206,'Vice President','VP',405596,81420,'active',81420,'testvp'),(81420,'Test School','',405596,NULL,'Active',NULL,'test123'),(88167,'President',NULL,405596,81420,'active',81420,'testpres');
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
  `istatus` varchar(45) DEFAULT NULL,
  `time` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `readtime` varchar(45) DEFAULT NULL,
  `readdate` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`inbox_id`),
  KEY `fk_inbox_doc_id_idx` (`doc_id`),
  CONSTRAINT `fk_inbox_doc_id` FOREIGN KEY (`doc_id`) REFERENCES `document` (`doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=428 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inbox`
--

LOCK TABLES `inbox` WRITE;
/*!40000 ALTER TABLE `inbox` DISABLE KEYS */;
INSERT INTO `inbox` VALUES (421,45937,74433,'read','00:46:35am','Feb 12, 2018',NULL,NULL),(422,45937,86456,'read','00:51:04am','Feb 12, 2018','01:08:24am','Feb 12, 2018'),(423,37728,74433,'read','16:29:46pm','Feb 12, 2018','04:30:40pm','Feb 12, 2018'),(424,37728,86456,'unread','16:31:09pm','Feb 12, 2018',NULL,NULL),(425,81232,86456,'read','20:26:36pm','Feb 13, 2018','08:27:05pm','Feb 13, 2018'),(426,81232,2526,'read','20:27:26pm','Feb 13, 2018','09:13:04pm','Feb 13, 2018'),(427,98166,86456,'read','10:50:13am','Feb 14, 2018','10:50:54am','Feb 14, 2018');
/*!40000 ALTER TABLE `inbox` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `action` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
INSERT INTO `next` VALUES (32177,74996,'3424'),(55459,11722,''),(57541,50510,'17179'),(60852,3424,'11722'),(90298,17179,'');
/*!40000 ALTER TABLE `next` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
  `orgchartnode_id` int(11) NOT NULL,
  `orgchart_id` int(11) DEFAULT NULL,
  `pos_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `upg_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`orgchartnode_id`),
  KEY `position_id_idx` (`orgchart_id`),
  KEY `org_group_id_idx` (`pos_id`),
  KEY `upg_id_idx` (`upg_id`),
  KEY `group_id_idx` (`group_id`),
  CONSTRAINT `group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `pos_id` FOREIGN KEY (`pos_id`) REFERENCES `position` (`pos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `upg_id` FOREIGN KEY (`upg_id`) REFERENCES `userpositiongroup` (`upg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
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
INSERT INTO `position` VALUES (1066,'School President',NULL,'active',81420),(3007,'College Dean',NULL,'active',81420),(3248,'School Vice President',NULL,'active',81420),(4540,'College Chairperson',NULL,'active',81420),(6274,'School Secretary',NULL,'active',81420),(9894,'College Secretary',NULL,'active',81420),(77049,'masteradmin','masteradmin','active',81420),(83153,'Student',NULL,'active',81420);
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
INSERT INTO `previous` VALUES (9399,17179,'50510'),(24532,50510,''),(64396,74996,''),(81750,3424,'74996'),(96464,11722,'3424');
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
-- Table structure for table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscription` (
  `subscription_id` int(11) NOT NULL,
  `subscriptionName` varchar(45) DEFAULT NULL,
  `expirationDate` varchar(45) DEFAULT NULL,
  `user_user_id` int(11) NOT NULL,
  PRIMARY KEY (`subscription_id`),
  KEY `fk_subscription_user_idx` (`user_user_id`),
  CONSTRAINT `fk_subscription_user` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription`
--

LOCK TABLES `subscription` WRITE;
/*!40000 ALTER TABLE `subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscription` ENABLE KEYS */;
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
INSERT INTO `template` VALUES (18,'Excuse_Letter','templates/Excuse_Letter.docx',88167,77929,81420,'active'),(60,'Joke_Template','templates/Joke_Template.docx',66206,27183,81420,'inactive'),(630,'Activity_Permit','templates/Activity_Permit.docx',66206,27183,81420,'active');
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
  `status` varchar(45) DEFAULT NULL,
  `next` varchar(100) DEFAULT NULL,
  `time` varchar(45) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tran_id`),
  KEY `fk_transaction_document1_idx` (`document_doc_id`),
  CONSTRAINT `fk_transaction_document1` FOREIGN KEY (`document_doc_id`) REFERENCES `document` (`doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=482 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (472,45937,74433,74996,1,'approved','3424','00:50:48am','Feb 12, 2018'),(473,45937,86456,3424,2,'rejected','11722','01:09:04am','Feb 12, 2018'),(474,45937,2526,11722,3,'pending','',NULL,NULL),(475,37728,74433,74996,1,'approved','3424','16:30:57pm','Feb 12, 2018'),(476,37728,86456,3424,2,'pending','11722',NULL,NULL),(477,37728,2526,11722,3,'pending','',NULL,NULL),(478,81232,86456,50510,1,'approved','17179','20:27:12pm','Feb 13, 2018'),(479,81232,2526,17179,2,'approved','','21:13:18pm','Feb 13, 2018'),(480,98166,86456,50510,1,'pending','17179',NULL,NULL),(481,98166,2526,17179,2,'pending','',NULL,NULL);
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
INSERT INTO `user` VALUES (287503,'$2y$10$w4ZLwE3vhmRgbCgvTWYKkOfCHpkV8W5l1bnIxtwiaoRkgy2zDeh2a','Moreno','Richard','Male','Talisay Cityy','richard@test.com','2435465','Active','','signature/287503.png','bq3H0VE324nh3MDs9exky3dm543uRyCFuAIRWwuSHwSUc52936njb89Cx66r'),(405596,'$2y$10$eoz/xi8Eot7q8h3xmQnyY.vM0zmrkWoWm/jVQ5WsLASjLVaKkNC7a','Trina Mae','Abarquez','female','Talisay City','trina@test.com','2726588','active','','signature/405596.png','VdKrOnYUQ4afRBRuyppbh8Rvi3ur13ayfBw8XBNwXI6PcN1tdeGvtKj5yoxb'),(580251,'$2y$10$c9DiK74U1KahdrXk0QXzPeclc4bmsoX3C0eB7tYNwttZziSTcfis6','Pool','Robert','Male','USA','robert@test.com','234567','Active','','signature/580251.png','Xo3WSfn7OfeWUqbqYC1uPIZLgkyDdZ68wsMnFHcTbWA1OZFon9zZiUjd1kJS'),(709718,'$2y$10$Dw/7bpXJmsBTRe0M0juSDeBebts86oOlTkAtt83ZqFidy2c5U5t9K','Solar','Dexter','male','Talisay Cityy','dexter@test.com','1234567','Active','','signature/709718.png','JjUR6ruGPIgYJDNq5BzgCSDL4TOoNFhkl8hChSzPqkGiHZpSN3ElBxsud2qs');
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
  KEY `fk_userpositiongroup_position1_idx` (`position_pos_id`),
  KEY `fk_userpositiongroup_rights1_idx` (`rights_rights_id`),
  KEY `fk_userpositiongroup_user1_idx` (`user_user_id`),
  KEY `fk_userpositiongroup_groups1_idx` (`group_group_id`),
  CONSTRAINT `fk_userpositiongroup_groups1` FOREIGN KEY (`group_group_id`) REFERENCES `group` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_userpositiongroup_position1` FOREIGN KEY (`position_pos_id`) REFERENCES `position` (`pos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_userpositiongroup_rights1` FOREIGN KEY (`rights_rights_id`) REFERENCES `rights` (`rights_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_userpositiongroup_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userpositiongroup`
--

LOCK TABLES `userpositiongroup` WRITE;
/*!40000 ALTER TABLE `userpositiongroup` DISABLE KEYS */;
INSERT INTO `userpositiongroup` VALUES (2526,1066,2,405596,81420,88167,'active'),(74433,3007,2,287503,81420,11858,'active'),(78546,83153,2,580251,81420,11858,'active'),(86456,3248,2,709718,81420,66206,'active'),(99287,77049,1,405596,81420,81420,'active');
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
INSERT INTO `workflow` VALUES (27183,'Activity Permit','active',81420),(77929,'Excuse Letter','active',81420);
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
INSERT INTO `workflowsteps` VALUES (3424,27183,3248,'2','sign'),(11722,27183,1066,'3','cc'),(17179,77929,1066,'2','sign'),(50510,77929,3248,'1','sign'),(74996,27183,3007,'1','sign');
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
INSERT INTO `wsreceiver` VALUES (27410,3424,'All'),(58419,11722,'All'),(63978,74996,'All'),(71176,50510,'All'),(94117,17179,'All');
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

-- Dump completed on 2018-02-19 21:16:29
