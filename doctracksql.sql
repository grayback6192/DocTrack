-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: test4
-- ------------------------------------------------------
-- Server version	5.7.18-log

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
INSERT INTO `archive` VALUES (347,29811),(470,31599),(534,81380),(978,18572),(1085,95003),(1201,30948),(1333,39624),(1753,22831),(1970,44387),(2228,93913),(2353,40006),(2406,77085),(2409,30948),(2679,93784),(2827,30948),(2875,19354),(3049,84767),(3053,31794),(3099,27453),(3194,30580),(3398,80762),(3572,30948),(3646,48933),(3851,16147),(4103,68106),(4113,77082),(4223,30948),(4674,96813),(4694,86072),(4930,35301),(5266,22189),(5364,16089),(5513,89008),(5673,80762),(6105,99535),(6363,30948),(6480,61155),(6491,16784),(6668,96796),(7333,13014),(7521,72569),(9004,40572),(9129,30948),(9271,30948),(9507,84767),(9592,50198);
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
INSERT INTO `document` VALUES (13014,'Lab Reserve','file/13014.docx',364,10247,'12-11-2017','10:30:47pm'),(16147,'Excuse Letter','file/16147.docx',620,92944,'12-13-2017','05:17:30pm'),(22831,'Cielotest2','file/22831.docx',364,10247,'12-14-2017','12:15:43pm'),(30580,'LabReserve','file/30580.docx',364,47249,'12-11-2017','11:24:04pm'),(30948,'CieloExcuse','file/30948.docx',620,10247,'12-11-2017','10:44:25pm'),(40498,'ExcuseGregg','file/40498.docx',620,81218,'12-11-2017','09:58:31pm'),(40572,'TEstLab','file/40572.docx',364,47249,'12-08-2017','10:55:22am'),(68106,'ExcuseGregg','file/68106.docx',620,81218,'12-11-2017','10:06:33pm'),(71497,'Cielotest2','file/71497.docx',364,10247,'12-14-2017','12:13:32pm'),(98919,'ExcuseGregg','file/98919.docx',620,81218,'12-11-2017','10:01:30pm');
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
  `user_user_id` int(11) DEFAULT NULL,
  `group_group_id` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `left` int(11) DEFAULT NULL,
  `right` int(11) DEFAULT NULL,
  `depth` int(11) DEFAULT NULL,
  `businessKey` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  KEY `fk_groups_user1_idx` (`user_user_id`),
  KEY `fk_group_group_idx` (`group_group_id`),
  CONSTRAINT `fk_group_group` FOREIGN KEY (`group_group_id`) REFERENCES `group` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_groups_user1` FOREIGN KEY (`user_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group`
--

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
INSERT INTO `group` VALUES (11988,'College of Engineering',NULL,199227,29014,'active',99175,NULL,NULL,NULL,'eng'),(12872,'IT','IT',920850,73153,'active',73153,NULL,NULL,NULL,'tma123'),(14866,'CICCT',NULL,897722,44079,'active',44079,NULL,NULL,NULL,'cicct'),(15520,'College of Education','coe',199227,99175,'active',99175,NULL,NULL,NULL,'usccoe'),(15902,'VP-Finance','Finance',897722,44079,'active',44079,NULL,NULL,NULL,'finance'),(19777,'Affairs',NULL,199227,99175,'active',99175,NULL,NULL,NULL,'affairs'),(21346,'univdep',NULL,927681,64829,'active',64829,NULL,NULL,NULL,'dep1'),(21793,'COE',NULL,897722,29728,'active',44079,NULL,NULL,NULL,'coe'),(24263,'Dep of Dummy',NULL,150228,50732,'active',50732,NULL,NULL,NULL,'dummy'),(29014,'Vice President','vice president',199227,99175,'active',99175,NULL,NULL,NULL,'vice'),(29728,'VP-Academics','This is VP-Academics',897722,44079,'active',44079,NULL,NULL,NULL,'acad'),(38152,'IT',NULL,475854,82978,'active',82978,NULL,NULL,NULL,'it'),(43403,'Major in Fashion Designing','fashion designing',199227,75321,'active',99175,NULL,NULL,NULL,'fashion'),(44079,'University of San Jose-Recoletos','Nice',897722,NULL,'active',NULL,NULL,NULL,NULL,'usjr123'),(46990,'SAO',NULL,897722,44079,'active',44079,NULL,NULL,NULL,'sao'),(50732,'dummyschool','Nice',150228,NULL,'active',NULL,NULL,NULL,NULL,'dummy'),(55486,'IT','IT',401532,92425,'active',92425,NULL,NULL,NULL,'montery123'),(61171,'Property Administration',NULL,897722,44079,'active',44079,NULL,NULL,NULL,'pao'),(63440,'Security',NULL,199227,99175,'active',99175,NULL,NULL,NULL,'securityy'),(64829,'cebuuniv','Nice',927681,NULL,'Active',NULL,NULL,NULL,NULL,'univ'),(65513,'Inventory',NULL,897722,61171,'active',44079,NULL,NULL,NULL,'inventory'),(68969,'Accounting','This is accounting department',897722,44079,'active',44079,NULL,NULL,NULL,'accounting'),(73153,'TMA','Nice',920850,NULL,'Active',NULL,NULL,NULL,NULL,'tma123'),(73737,'College of Architecture and Fine Arts',NULL,199227,99175,'inactive',99175,NULL,NULL,NULL,'cafa'),(75321,'College of Architecture and Fine Arts',NULL,199227,29014,'active',99175,NULL,NULL,NULL,'cafa'),(75687,'VP-Welfare','welfare',897722,44079,'active',44079,NULL,NULL,NULL,'welfare'),(79430,'IT','it',967516,90244,'active',90244,NULL,NULL,NULL,'central123'),(82978,'up','Nice',475854,NULL,'active',NULL,NULL,NULL,NULL,'up'),(90244,'Central','Nice',967516,NULL,'active',NULL,NULL,NULL,NULL,'central123'),(91307,'Registrar',NULL,897722,44079,'active',44079,NULL,NULL,NULL,'reg'),(92425,'Montery School','Nice',401532,NULL,'active',NULL,NULL,NULL,NULL,'montery123'),(93625,'TEst','test',475854,82978,'active',82978,NULL,NULL,NULL,'test'),(94677,'College of IT',NULL,199227,99175,'active',99175,NULL,NULL,NULL,'uscit'),(99175,'University of San Carlos','Nice',199227,NULL,'active',NULL,NULL,NULL,NULL,'usc123');
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
  PRIMARY KEY (`inbox_id`),
  KEY `fk_inbox_doc_id_idx` (`doc_id`),
  CONSTRAINT `fk_inbox_doc_id` FOREIGN KEY (`doc_id`) REFERENCES `document` (`doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inbox`
--

LOCK TABLES `inbox` WRITE;
/*!40000 ALTER TABLE `inbox` DISABLE KEYS */;
INSERT INTO `inbox` VALUES (228,40572,18497,'read','10:55:25am','12-08-2017'),(229,40572,81218,'read','11:45:32am','12-08-2017'),(232,68106,81218,'read','10:06:33pm','12-11-2017'),(233,68106,34966,'read','10:10:41pm','12-11-2017'),(235,13014,18497,'read','10:30:48pm','12-11-2017'),(236,13014,81218,'read','10:40:16pm','12-11-2017'),(237,30948,81218,'read','10:44:25pm','12-11-2017'),(238,30948,34966,'read','10:45:01pm','12-11-2017'),(239,30580,18497,'read','11:24:04pm','12-11-2017'),(240,30580,81218,'read','11:24:43pm','12-11-2017'),(241,16147,23853,'read','05:17:31pm','12-13-2017'),(242,16147,34966,'read','05:20:55pm','12-13-2017'),(243,22831,18497,'read','12:15:44pm','12-14-2017'),(244,22831,81218,'read','12:30:05pm','12-14-2017');
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
-- Table structure for table `orgchart`
--

DROP TABLE IF EXISTS `orgchart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orgchart` (
  `node_id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(45) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`node_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgchart`
--

LOCK TABLES `orgchart` WRITE;
/*!40000 ALTER TABLE `orgchart` DISABLE KEYS */;
INSERT INTO `orgchart` VALUES (2,'1983orgchart.txt',14866),(3,'4365orgchart.txt',21793),(4,'698orgchart.txt',68969),(6,'972orgchart.txt',46990),(7,'3728orgchart.txt',29728),(8,'2771orgchart.txt',91307),(10,'4301orgchart.txt',44079);
/*!40000 ALTER TABLE `orgchart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orgstructure`
--

DROP TABLE IF EXISTS `orgstructure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orgstructure` (
  `orgstruct_id` int(11) NOT NULL,
  `pos_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`orgstruct_id`),
  KEY `position_id_idx` (`pos_id`),
  KEY `org_group_id_idx` (`group_id`),
  CONSTRAINT `org_group_id` FOREIGN KEY (`group_id`) REFERENCES `group` (`group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `position_id` FOREIGN KEY (`pos_id`) REFERENCES `position` (`pos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgstructure`
--

LOCK TABLES `orgstructure` WRITE;
/*!40000 ALTER TABLE `orgstructure` DISABLE KEYS */;
/*!40000 ALTER TABLE `orgstructure` ENABLE KEYS */;
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
INSERT INTO `position` VALUES (1009,'Dean',NULL,'active',44079),(1131,'Secretary',NULL,'active',99175),(1462,'Organization President',NULL,'inactive',99175),(1463,'President',NULL,'active',82978),(1499,'Comptroller',NULL,'active',44079),(1648,'VP-Finance',NULL,'active',44079),(2216,'VP-A',NULL,'active',50732),(2290,'Faculty',NULL,'active',44079),(2590,'Head Registrar',NULL,'active',44079),(2764,'Dean',NULL,'active',92425),(3290,'Student',NULL,'active',99175),(3361,'Dean',NULL,'active',73153),(3670,'Secretary',NULL,'active',82978),(3679,'Pao-Administrator',NULL,'active',44079),(3758,'Dean',NULL,'active',99175),(3924,'Student',NULL,'active',92425),(4515,'Affairs Head',NULL,'active',99175),(4615,'Registrar',NULL,'active',73153),(4648,'Student',NULL,'active',64829),(5016,'President',NULL,'active',64829),(5291,'Admin',NULL,'active',44079),(6013,'VP',NULL,'active',64829),(6096,'Student',NULL,'active',82978),(6317,'Principal',NULL,'active',73153),(6362,'Secretary',NULL,'active',44079),(7694,'VP-Welfare',NULL,'active',44079),(7785,'Security Head',NULL,'active',99175),(7821,'Registrar',NULL,'active',92425),(8464,'Student',NULL,'active',44079),(8702,'Dean',NULL,'active',90244),(9593,'Vice President',NULL,'active',99175),(9652,'Organization President',NULL,'active',99175),(9662,'Chairperson',NULL,'active',99175),(9777,'Student',NULL,'active',90244),(9814,'SAO Director',NULL,'active',44079),(9861,'Chairperson',NULL,'active',44079),(9896,'VP-Academics',NULL,'active',44079),(9965,'Student',NULL,'active',73153),(23360,'masteradmin','masteradmin','active',44079),(30284,'masteradmin','masteradmin','active',64829),(56744,'masteradmin','masteradmin','active',50732),(71902,'masteradmin','masteradmin','active',82978),(73582,'masteradmin','masteradmin','active',73153),(84933,'masteradmin','masteradmin','active',99175),(90897,'masteradmin','masteradmin','active',92425),(93888,'masteradmin','masteradmin','active',90244);
/*!40000 ALTER TABLE `position` ENABLE KEYS */;
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
INSERT INTO `template` VALUES (136,'test5','templates/test5.docx',14866,48113,44079,'inactive'),(202,'Budget_Request','templates/Budget_Request.docx',15902,58170,44079,'active'),(297,'Test222','templates/Test222.docx',46990,29245,44079,'inactive'),(302,'test','templates/test.docx',46990,64757,44079,'inactive'),(363,'test2','templates/test2.docx',14866,62056,44079,'inactive'),(364,'Computer_Laboratory_Reservation','templates/Computer_Laboratory_Reservation.docx',14866,75086,44079,'active'),(447,'Borrow_Laptop','templates/Borrow_Laptop.docx',94677,31635,99175,'active'),(509,'Activity_Letter','templates/Activity_Letter.docx',29014,19943,99175,'active'),(558,'Error_check','templates/Error_check.docx',14866,41421,44079,'active'),(586,'Waiver','templates/Waiver.docx',91307,90679,44079,'inactive'),(620,'Excuse_Letter','templates/Excuse_Letter.docx',46990,41421,44079,'active'),(625,'Monitor_Requisition','templates/Monitor_Requisition.docx',61171,50941,44079,'active'),(664,'Test4','templates/Test4.docx',14866,57563,44079,'inactive'),(755,'test','templates/test.docx',21346,9891,64829,'active'),(802,'Test_Template','templates/Test_Template.docx',14866,22867,44079,'active'),(901,'Entry_Permit','templates/Entry_Permit.docx',19777,81797,99175,'active'),(926,'Budget_Request','templates/Budget_Request.docx',29014,55769,99175,'active'),(986,'Change_of_Grade','templates/Change_of_Grade.docx',91307,80525,44079,'active'),(1000,'test3','templates/test3.docx',14866,50654,44079,'inactive');
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
) ENGINE=InnoDB AUTO_INCREMENT=326 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (308,40572,18497,5045,1,'approved','78609','11:45:32am','12-08-2017'),(309,40572,81218,78609,2,'approved','','11:48:47am','12-08-2017'),(314,68106,81218,55409,1,'approved','52137','10:12:15pm','12-11-2017'),(315,68106,34966,52137,2,'approved','','10:14:46pm','12-11-2017'),(316,13014,18497,5045,1,'approved','78609','10:40:15pm','12-11-2017'),(317,13014,81218,78609,2,'approved','','10:41:00pm','12-11-2017'),(318,30948,81218,55409,1,'approved','52137','10:45:01pm','12-11-2017'),(319,30948,34966,52137,2,'approved','','11:22:50pm','12-11-2017'),(320,30580,18497,5045,1,'approved','78609','11:24:43pm','12-11-2017'),(321,30580,81218,78609,2,'approved','','11:25:20pm','12-11-2017'),(322,16147,23853,55409,1,'approved','52137','05:20:55pm','12-13-2017'),(323,16147,34966,52137,2,'approved','','05:21:43pm','12-13-2017'),(324,22831,18497,5045,1,'approved','78609','12:30:04pm','12-14-2017'),(325,22831,81218,78609,2,'approved','','12:33:46pm','12-14-2017');
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
INSERT INTO `user` VALUES (111260,'$2y$10$Verp3xkTiuOmALLWpWG9teCgQoNIW5nXF.U100XMpdbZ6NRP5ziu6','Taylor','Connie','Female','Cebu','connie@usc.com','Active',NULL,NULL,'X2EoE1NGe938NEJb2tXuieIFXPbuLnZhwP58BJa0ia8Mqjc91aS5xT6Rw1Bm'),(116699,'$2y$10$JYOr5Wzg65Y9p62blC8pv.ft8YLTFiV3Puw1jpVtJQv/G6aSwUCay','Gonzales','Juan','Male','Cebu','juan@usc.com','Active',NULL,'6xr6O','wMCnm9QQYGwXNvdrlX6LfLmkJhAwV9uRkdcnBXlh57hZCcIRhzyrc3sO4u8p'),(126119,'$2y$10$Ham1oosuQwtIjRzozr0MbexvdurbPMhy0q.i4jJrikCh6a3zLHxFG','Justy','Kris','Male','Cebu','kris@usc.com','Active',NULL,NULL,'rshEsc2Hx5Zv5CUYvBgUmxM3QiPEq4VSQZr71jqiPyI05bfJCjysC0HPqYIv'),(150228,'$2y$10$my6b//qDCWfIKynhCUp2FOAf2I.gxj9Y60nc0nCjpolaLBALaJQHi','dname','dlname','Male','fdsa','dummy@domaim.com','Active',NULL,NULL,'JcFI9nQ0hxgG4zT2z4FW9TzclI0d49agde093xNfJpWyd1ujYv4Ls7pWQq4X'),(161111,'$2y$10$ucGlEA1yTqkHQwqgoiBSHOA5z3BodxG1xXuVi95VRIIkd2NW9OvMm','Tibby','Alex','Male','Cebu','alex@usc.com','Active',NULL,NULL,'i659ZQxbeRtjJqN8AXYdmRNGVN9PgIDIJNoZVZsjf0P4boJiWT6JgxYUJ3n6'),(161633,'$2y$10$SHXmiarUlSZ5EpiuQpUhreoHA5KpnO2iRtIM/WMu36Ky0lr53unBG','Ginyard','Elizabeth','Female','Cebu','el@usc.com','Active',NULL,'RbtS8','mhEK4EZbzjYUwuA0SBJyvMvRex9JtjuQDdocANQuDqVS6injM2pzAtmMyjxm'),(175283,'$2y$10$fj8VKj090CKG93Bc9dyis.jYmb1.So4/DMPuIx0VcrazC3Me84e0q','Gabison','Gregg','male','Cebu','gregg@usjr.com','Active',NULL,'697112.png','tpDdAWflBsoEHI9D7ODvOgm38a21uOnJbo1US6uYTVaNh9vPxVvLOAGB9u5N'),(176437,'$2y$10$OjExD1x.C53v2vIxIYjzseeHWwEyrVklaMk1btrLNTHMvlNKw680W','Pope','Mary','Female','Cebu','mary@usc.com','Active',NULL,'pMMHX','o42FeThHubade6ePIvr27VnFYcI46rrHeQMBq3ZY0tX4rK5pKCmt6jeYI96P'),(178359,'$2y$10$fj8VKj090CKG93Bc9dyis.jYmb1.So4/DMPuIx0VcrazC3Me84e0q','Solar','Dexter','Male','Cebu','dexter@usjr.com','Active',NULL,NULL,'8Nk49GwmzyMWs6L1F3YQ3ORXPJ00xwvRhvCc2X8FDuxgIMtcsVDSzBaHxMoU'),(199227,'$2y$10$5cVeLd9pFm2C28ZrPKulfO9NblFfo6WKPBIqn6xRJODlJa78nIrjO','Lyndon','Fran','Male','Cebu','fran@usc.com','Active',NULL,NULL,'V4SfgfuU4250LrOR7vK00W6655GtpRDg2xgO8ea7XOU0r1npw5YMHlpo6Oki'),(204067,'$2y$10$sqL94y9cVVforZ9uBeEm/uR0S/.B/IG/rwNs6BsC10pwKRNiw6sRy','Jackson','Percy','Male','Cebu','percy@usc.com','Active',NULL,NULL,'CdTrnp3Cdh5ADfL18dWR7z97e0mca8V5opjVXZZhj4C3Kus1E5Z1ZNmbKkGi'),(214505,'$2y$10$fBgCkf/JZH3vZrQxGvPCo.nVkFMMQHtefRdb0R1HwsWz8Xmjda3Qe','Raras','Nestor','Male','Cebu','raras@usjr.com','Active',NULL,'NAytr','ZtD8HZlBKYzbCNDyyGbH03ZgNSRRuW7AcRkd8f0cDqRs932D3OFpCI7QsFdP'),(235021,'$2y$10$uCFBWNScSg4sAqW3O7kpduvN2RfNNzpK/KEFi8IXaZ6e.UuO3pEXu','marisa','Mahilum','Female','Cebu City','marisa@usjr.com','Active',NULL,NULL,'aDfjGQHC0AP1murbeItA3gct6F49MuMjcA3kK9JXoaDQNeleb7453IogMkIz'),(256665,'$2y$10$JX/GWaxUEQS1dvUqyVPHI.qf0F0KOgfZbrQJdceJLKjMzfooi3Wgu','Zhang','Frank','Male','Cebu','frank@usc.com','Active',NULL,NULL,'9uwsnRVadXAixjAy99hjGO6TmAvN7twaT3HECW56fx3IC3k49tGCIGwgdF0W'),(258477,'$2y$10$ThNGEFkOwl5CgXy5qRCSVufAAhKmu3U9j8L46.KMthPxlfVNx6Phi','Miro','Lorna','Female','Cebu','miro@usjr.com','Active',NULL,NULL,'74c64i35dRw8ZW7T2Hdc86ODtZbXXVCUgD0gGGNdq47oVbxtvRfzcm79KIIT'),(278775,'$2y$10$M8gdjvdB2bMa4ZZJ24knGeiq0wAbqqtRSxXZoHsmdzK9Sa3TSesOC','Baroc','Marlon','Male','Cebu','baroc@usjr.com','Active',NULL,NULL,'aURHuueITn3wyf6tLzxtv0hVyd5XW52B7IWSXchhVTXi3cpKpnv0mDi8lSEu'),(288497,'$2y$10$uvP2yorqZubi5oxNFJypQOGMFKc6QI2P4.QziWzRjjq4REu1pXg8K','Dewar','Edward','Male','Cebu','edward@usc.com','Active',NULL,'VcnWE','Jld21WM2vTSP5qT59U3NvbTDV5LvwEkrFfsuYWYStcElwbfiATuKyq0E9Oow'),(305252,'$2y$10$fj8VKj090CKG93Bc9dyis.jYmb1.So4/DMPuIx0VcrazC3Me84e0q','Cuizon','Jovelyn',NULL,'Cebu','cuizon@usjr.com','Active',NULL,'399607.png','iD26JVDVr7l5D25xJ6omCX9nwsCZb4KzZwEPz26zpLmQSoPoSZG9Jslm0W2k'),(335519,'$2y$10$TJzjYnn5WNPpzEh0qx8oI.CH/eFwo2FAwaQDiH9TecDqthrJ8zFGW','Shannon','Darnell','Male','Cebu','darnell@usjr.com','Active',NULL,NULL,'HjUlwncFA2672ozY6MoOWTnHqOghtPsxue8yebfX5w1XHYKQZQDmFM6GiV3u'),(355404,'$2y$10$5qSB5Osu7BIpqE6vJm7FHeIeZPrcHMJNbuolO9FA7NLYz.LOSAb5K','Parker','Terry','Male','Cebu','terry@usc.com','Active',NULL,NULL,'4gfyJfTN53OoGLS3PYkzpLwja6c8ZC3bUGxMAbU5qQmhVrw5D4X1ICXNHlHB'),(384957,'$2y$10$RbF3WQiUcb5/imkrJTLFcuYdKI7fIBSMZSt85/ndmUBKDnCcxkCpi','Catipay','Julieta',NULL,'Cebu','julieta@usjr.com','Active',NULL,'597965.png','D5EDpaMl7UEtasTnwqo5MOk4uku3zpxfMLgP0bXEmTvjGIc3RBW0NHz7rpsQ'),(401025,'$2y$10$2ba7jHfOn/7DJgTTqi0ZAuVXvOVty0VWYdZWDJRq/A8vH75FANsZu','Chase','Annabeth','Female','Cebu','chase@usc.com','Active',NULL,NULL,'AjbUWqYRhyFgbWhzcd64fei4KNk8GrqIUnBh5MsqNqgNdoeJKyHSlugD7B35'),(401532,'$2y$10$OJxKrS6mlkEmQDzmT1Yrl.gB3f7NO6kJmGgH2.MBHsE6dbOiMG16y','Jonathan','Villarmia','Male','Cebu City','jonathan@montery.com','Active',NULL,NULL,'h4wyTMXLvuYh6lnPsitgH50RPT01E4TOLe202vVWJSxBagD48EHYTzqaOHxV'),(411764,'$2y$10$2x0rB4YRnlxn9GPun3tK4utOahVjuajToVhG9jgfojNMHXiG89Ngy','Epili','Jercy','Female','Cebu City','epili@usjr.com','Active',NULL,NULL,'gFV8VgDsL69C2UOuZTFS7UUnuYLdEZS3ZiNononoCehbFgnEFtzESCCQBmtm'),(413604,'$2y$10$6vDqf02pZu67KzPzZw80s.yCnIJJvlXcXt11wi8.kFBqHaxB1L9uW','Roble','Bryan','Male','Cebu','roble@usjr.com','Active',NULL,'nHgv8','MDkOhszX23KmDD61ZuYy2XVCVBlijxRwj80PUDIVcwqGJ29OGoDXBSgkYW2O'),(427832,'$2y$10$C2x59vIc0.Ta1mFOJyue3u5ILeyVIMbe1txOA.WjaQoxO5Hwb4q6C','Santillan','Jeremy','Male','Cebu City','jeremy@usjr.com','Active',NULL,NULL,'SAuztScBVII5p85hzPyv33ou9xYE8EIx4mAF0UCOzokoU9dmO07vMzi3JsXQ'),(429397,'$2y$10$fRRYLS.lIqYb/gUTKnTlc.FVjdsDHS4AbLBT7.qyquqSEDm5YI1d.','Gimena','Gene','Male','Cebu','croix@usjr.com','Active',NULL,NULL,'K9WOP9SmN9lQZkd1whY8JmlomIWiQFtuwOhfDACx3J2BAK4CF7WHAReAFRk1'),(456369,'$2y$10$sRr9Uwdcozmyx/Zx2c1N9uqStC6umRvzqsaiPT.QJmuFhNbydbTDu','Madison','Tristan','Male','Cebu','tristan@usc.com','Active',NULL,NULL,'sllppRvCuwceLfNJ7FbVZkqG41eSwcHuc30beDeRdtl9jJhw1JV8yNg3zY5z'),(475854,'$2y$10$cpTc1ix0i6nGAeaYt4lm9Ocxr1xtbfYonMySj4SanNUR6fqKjEMG2','client1','client22','Male','dsf','client1@domain.com','Active',NULL,NULL,'1aF7qBu8DlrkXlDcyVE5Jlukx7NZ7x9HSl3TXNmLnOq3X8grpoR9bag8VlKh'),(489959,'$2y$10$xSCnlFh1nEZHwXsaFli7beEU2fDcp6wpbYIaKAZShZTQaiBuUr9O6','Doe','John','Male','Cebu','doe@usjr.com','Active',NULL,NULL,'o0k2Ni1IsEpflVxF6ycWf6g2B498sWu0s4p3kNH0CjjGlwpxo4Ios2kCpw8k'),(512097,'$2y$10$hEd2wOuaHI8Q88qqEyzHeu/JUY5VLVmXUWb.u3404/c6.tegUUCXO','Pulse','Mark','Male','Cebu','mark@usjr.com','Active',NULL,'sqTq4','KEFuHf4e69G4BFddi7ifvhkAac477ezNP3D6bBKwHsrOKhvuYZOcPDNBWvnM'),(513333,'$2y$10$iHvFB1KMyx0sthn1sucUY.gp7S.5CZIEvCzPLpc7/dSg6oI5bYuly','Lim','Duint','Female','Cebu','lim@usjr.com','Active',NULL,NULL,'DloMGGhdhV7GlqtmVKyvHNcaWJkhY0Ome1TKHNbcNTOmhC9KZ3eJPqfMjiaR'),(537393,'$2y$10$1KQwRwfBADplbMjnrUegO.ha4UuSWWJfDlCRGyHsnk3.GwWJUa4wS','White','Kim','Female','Cebu','kim@usc.com','Active',NULL,NULL,'RJYBcYwYOYsaDVU3nY58jO8tqqF3tztJj72VhumcxGY4t0oZrqJRBkdcKi9V'),(559915,'$2y$10$PI2vTN/PRM5MX2F9.S3O8.aJOsu3SeClp7.zxVEpmbVOso2m4LWvu','Tejana','Carmel','Female','Cebu','carmel@usjr.com','Active',NULL,NULL,'gbUk2m3bIPqmj1SKORDI8IsRQNN9eSFdnPjuoSLXxkoUr6ra80tHtFrPOI01'),(570022,'$2y$10$.D9HriInSWP8z0TsSTPquuRiCjYh6hly1c.1C3VSkPKogJA3Is91W','testname','testname','Male','dfsaf','test2@domain.com','Active',NULL,NULL,'CMVtJydUggUm88iAIF0w9GFKIQsOQvrwLSCPoDg56Xo2LrLQQT29TaKBbR3o'),(589056,'$2y$10$1cmvgmJTn.ALYUqQfg0X/uHGS0oKK7wsiZ3gmGrzddhC8ZsvN1Zpe','Ramon','Vicente','Male','Cebu','ramon@usjr.com','Active',NULL,'5jo37','lU8y0Du3xbAgOSR826fOc5GDMBzC5y1XaVYaBbVxcH5jf6S4PDYZ43LfSzlz'),(591500,'$2y$10$KrA4RuWqvhxeoY9bO/rQ.e4uYeFQCvuuNh3HT1bgSufp3TrWS8rIy','Verdin','Robert','Male','Cebu','robert@usc.com','Active',NULL,'TgxKa','ltqq9NwVYv1HzBWCA8d5qbQ8Uvgjgc6TYBmij8vytfcrmXHt4bjNNlLWjUKp'),(593148,'$2y$10$IH/sBgzbROdUKayYYt7JVesI/loVc3UPwwTsRsUsmhI411eEELveS','Dawn','Parker','Male','Cebu','parker@usjr.com','Active',NULL,NULL,'hpZAWFtiuivQt5hBoFFpTAHmQel5z3rkYPjsuP4ycyiPKcM4pDt1wLrymmC6'),(602734,'$2y$10$0StXaUeQjlwoQ4ZJQXz5G.LaI.vaXpCbKPo/eClj57CtNV4cLFQy.','Abarquez','Trisha','Female','sdfasd','trisha@usjr.com','Active',NULL,NULL,'U2mcVQdfdi2K7MpRj0YNLkIb1ghnu0UfNTqMi7FaZBTksXbP170H5d8ImtU0'),(613391,'$2y$10$7T2Gr5ki79ueV/v6S.9TM.mhu8wTZm8xKNmY82Kr38tFyZUEt4In.','Issy','Val','Female','Cebu','val@usc.com','Active',NULL,NULL,'8hFbi7DPeLhMcoUjfkWsKIijFLQRS3IjRO9f5vBC2T7Q8m5vPutVLxKmOuaq'),(624295,'$2y$10$4Av0OUkKkbjrcsgRKatt.e5/8P5eWsV7e1WmhynPYpNB0qK2hru56','Bumangabang','James','Male','Cebu','james@usjr.com','Active',NULL,NULL,'RMMYWq97X3DeCRrmXOvQtSEArTMqOu54bWSlmnV6aBWGWR2VaZw7q8Ltjmnd'),(646020,'$2y$10$VpThRDTfTIyzckUPvp.KbO9JxdPyJ1JVLOFFGkq7EHUyoLG4UshRO','Catingub','Jereco','Male','Cebu City','jereco@usjr.com','Active',NULL,NULL,'aUl2VZpZby2C5RFS3isqRd0X3019E6iAc6lmQzpFTOmw5jBHPn3ARwM5bdCd'),(674694,'$2y$10$Q8CWc3Y/ePNIJgzk4iWjEO1EeE6tW0lTy9.FseLsOVT6091Wx8iea','Petralba','Josephine','Female','Cebu City','petralba@usjr.com','Active',NULL,NULL,'dSstcO9mEMZT7VuQg0DGzfpAd3bjJkrudMUeyyvqinMOnVE3xkQfcKThBJeL'),(675601,'$2y$10$mAz6ClYRdphpBwLdM3X4HulXmO44ozehxFARoy1rPizodB1FceYNy','magto','Eric','Male','Cebu City','magto@usjr.com','Active',NULL,NULL,'AJNd0CN9X1ndLbjsPpfBChB08EhvtiDPq632vZ6vm6Flfs4K0GEEyXG5e081'),(686972,'$2y$10$oTEPiD.G1bIfVosOQwzBqeSlI0tN4hT40APaX/.IHlm9k6dBgrkIa','Saldua','Miraflor','Female','Cebu City','miraflor@usjr.com','Active',NULL,NULL,'qYFaMC2rJtz9zYnpg7Ca2xAlnYxO856Z7Oeeeg8N4FsU5G4obVtWBKr8vd4d'),(697711,'$2y$10$rYIv7BJ.EIA6KBOmytTz2eG9K.HClkQfbtgJdSGVObzIfUHpjVQCe','Green','Rachel','Female','Cebu','rachel@usjr.com','Active',NULL,NULL,'aVgxNK6kCPq1ptYDr7zZ9NtZdpx9Eq89513ARct8QtN8v2D1DbegzojGdmRJ'),(707351,'$2y$10$gxOoQ.QFxeMWL3LMsQ9.VuS/pUOI9Sm5cy1Elor9A9ntBgAlZp8xq','bandalan','roderick','Male','Cebu','bandalan@usjr.com','Active',NULL,NULL,'YJmUUyz4MzdwSon56WuvvfogwrWoHuVCi6qqwb3bu8hf96XiLHbvBsoLwyYf'),(708944,'$2y$10$ciTkXtNT2kcEU1obmz3soeMj6EsCACAFfM0T9Nms48CA0NwXAHS2y','Molly','Dustin','Male','Cebu','dustin@usjr.com','Active',NULL,NULL,'KnCbQw76paEtTzmwLqp3qvX7364AewP3b6K4I8SGdXtlF2u5XCZ6Jo2li498'),(729379,'$2y$10$1ZNa03Ld/jNt5jnm4Fx8OOp.5JfI.p1balqcokDVickQHuiCurrQ6','Stanley','Corrin','Female','Cebu','corrin@usc.com','Active',NULL,'cQzS1','8dskYIpaEYJpixd7Um5aCx4OHnnpaPLqq2Ggu0vBaplabIa6NYztxbtoHYK1'),(736795,'$2y$10$Cb2kdV6ueB2F/23kHvqPpeaRQHQgerxlQsmN4SJ8RYOVYDKEt5cMq','Bolt','Piper','Female','Cebu','piper@usc.com','Active',NULL,NULL,'XVDxyqqLvm5WLycOgKeEv4L4RRc8DZItlMBeTFNovPKuteV2C0JMPeqPneDV'),(742837,'$2y$10$ucF4SbjuusqBa8da2vrSuuZZZK1do7w1LOqz1fJyCDHnbZcPWThUC','Gudio','Jeoffrey','Male','Cebu','gudio@usjr.com','Active',NULL,NULL,'vZrwwnDy4yJrqrTCKdt7O1v3g5pcbJRBjXca1xntCuktclyj5N2annaHsP0G'),(745089,'$2y$10$b2P.qLIEM78hEfoEe7v8HuN./6luBLqp3r8gdXTftduWhiQS64ST2','Devon','Cam','Female','Cebu','cam@usc.com','Active',NULL,NULL,'3D5B3B9SRZ64TrRqsxzq3R4JtLVFDYi4cDiiAJPelIIautX3D6Dteb8JmAs6'),(749594,'$2y$10$uMSP4hOHkaoaZsw5WC8G3ON8PwJTe/MA6ohzyvPkbAIABXe3XtZkS','Ernest','Russel','Male','Cebu','russel@domain.com','Active',NULL,NULL,'sN9fLxCpKunEOJGkSQLOsyCisaEMhkII9kiaNbW40HVzvMXNxrdVO4yvS3Dj'),(786344,'$2y$10$eovah5Lgy3ha.Sy7lz0eKeHWC0qjQH/lUWsxanp6/3wYWng0uptP6','Uy','Johnny','Male','Cebu City','johnny@usjr.com','Active',NULL,'signature/786344.png','l6EY2lYC1h7MTlDtsDLk36yWtqol0mqArKSDd2ItdQ1DT6GbDLS7cqGNzAS9'),(787332,'$2y$10$BTxmcfluFAX1F41tAFuTj.1LCh7cB1hjHjalg51joNX.vh8FMuJWK','Grey','Hayden','Male','Cebu','hayden@usc.com','Active',NULL,NULL,'RAV03nYH3UVItuOpbYO6wVHgX9aZoVRd0rS5iR0fvPsVFMJjVmCgzerXRn0a'),(799417,'$2y$10$liVpRnSA4oJw1uGx8RTNDuY69Ca10.zwGJQd5VdJVfZu1774fwfrq','Ariel','John','Male','Cebu','john@usc.com','Active',NULL,NULL,'YK9Cx9Vu9aHiZBweynNgl5rcrtFqjHa7neUs4eV1q2HhWbhRgnUf4owG7UD3'),(811221,'$2y$10$UhQ1fkC/1KvUx1x.KiD9DuyhsRWnBSSAfGFLlp1VOvd3SqHLrlaI2','Antonino','Mark',NULL,'Cebu','antonino@usjr.com','Active',NULL,'signature/811221.png','LRgLL0oH9BoGX1FAI6bGAS3KAdWT9se8iZwMFHaOTkjAWxi0NkQRhQQ926HT'),(819549,'$2y$10$2IXr0AvneQ3Jyf5/MBkULuUQM8O4a/wSqAzs3ZP0aVgWs96k75X3G','Grant','John','Male','Cebu','grant@usc.com','Active',NULL,'GqIjf','fvwjbAjSvodY6B6aJeeVQLPzlMNYXGynCHTqzCIEVL3CDClo4Xy10RTxh784'),(831387,'$2y$10$zIkGrHnmkLQXpHxkB9ax1.iz1cjkUcT1KHkph.Pn/DClqJD5J9YvS','Pangilinan','Cielo','Female','Cebu','cielo@usjr.com','Active',NULL,'hTLmR','hs5qfDlP4Noyy1DQDcgqlH4vavjeDxxqTFh90ORrEn1lMv9atkvyk516kVJq'),(845312,'$2y$10$ekX4hG5aJ5LiUOJqVLfz9e6a9BIRsVZcXG0RPGhynfcJ2gnUnpOCC','Wick','Rose','Female','Cebu','rose@usjr.com','Active',NULL,'OgJSq',NULL),(897722,'$2y$10$CMh2K1eGRIgJ3Ld5cqTFk.XnR9qgKfta5EghgvQZ0txT9bfxWRqGO','Christopher','Maspara','Male','Cebu','maspara@usjr.com','Active',NULL,NULL,'XU1Hai8YKy2hj9XnShqSpzKftTcbHNjbtfT8yEw5LDymvDg3M4auCjs7PvA2'),(915927,'$2y$10$GASgdqW/O6VX.QeBKV/MF.lBdZn8oODggy1EhHd5wb4F.Z8IJLRi.','Ashley','Grace','Female','Cebu','grace@usc.com','Active',NULL,'JfEjK','F7tk9q1AOeFDeO52MqcnhHMMgPwUt4XzUIhk6hkolWiFqlIN5XJGnNyn8Qq8'),(920850,'$2y$10$QqIkncKftGdQ5MZ//L7eg..MH2.emouXxFr8g0helKm6BTVTRQf1C','Oliva','Solar','Female','Cebu City','tma@gmail.com','Active',NULL,NULL,'M9lnvgJh7w6LtjyNcdjtapPWLiYLYg4Yyq62YhG6iqRkS7T6xgOg6PLpX4YQ'),(921640,'$2y$10$lzYiim4C6cBtDUBXEyn59uFIyFGe.lBtnu1U/UmZsgrsCu/mrscYm','Mo','Finley','Male','Cebu','finley@usc.com','Active',NULL,NULL,'P8xMyLVxuGptFJVtZHQvZy4HZjFMoupYaSjY8CJGsUEs6lo4POP2TGGUFNxY'),(927681,'$2y$10$2ecqJpDFfrxxdbXiVSyh0uTPTx83drGCZ2SLnkqpMEjJn15796hGi','fnamne','lname','Male','ceu','test@domain.com','Active',NULL,NULL,'ZfK9Yx78cTEmP4bdrZNbr9hhfHZH5imn8QsBhulDhGSHnzjPFennpJLpDUbQ'),(929550,'$2y$10$Y/Nw0KE6Bw5LXG8Buh4JzusDqNlvkzlCwJicqMl53qKWfgH6jYpoe','Woodall','Laura','Female','Cebu','laura@usc.com','Active',NULL,'4ztL5','81nhVfLqeRQQ6o6aCvSwZGhqmOrEVYvUtUnbCpEE9ODKZCKyN9sPaTBwegBw'),(941030,'$2y$10$WdW.m45ILSJREko/DLU5B.wx3oHDDy9anNzmV0sIOrbcsC.0PmXya','Aba','Mae','female','Cebu','mae@usjr.com','Active','ZFvLg4EhqTi3rHekURwWX3RvzPCJe9tNGPthPdZE.png','ZNZs3Q71lIyloGRhYMAV3r6NmCiBV8KU3wjhCiLj.jpeg',NULL),(956906,'$2y$10$9as/U3tk1CAUFEB9ead7PuJNw9YFKAHZKvRXl8vHSBeLl.FiwMHGq','Biscocho','Dave','Male','Cebu','dave@usjr.com','Active',NULL,NULL,'ytbZrRPF5wG7Ki20EUG7IKm8PgrSt5iR5InZDTIiqgLahgWLH9D5zB8D2w5M'),(966189,'$2y$10$cyUixQ0YXdeIPZWXHXAgTuULw4K1BMCPCXEPc54Ub..heDkIFO252','De la Crus','Richard','Male','Cebu City','richard@usjr.com','Active',NULL,NULL,'YMcEKxn5ldxvbOi3PfPTNZdM0zIo5AGaeoC4nbPyvpPhWW0RU66k58gTcN2d'),(967516,'$2y$10$3.FgGOcBte04jRBct.3Gb.C53/7l12cnpPYFnyWuRQQK/GOrJJLVW','Jenylyn','Villarmia','Female','Cebu City','jenylyn@central.com','Active',NULL,NULL,'IRzPBvbXTCpfJ2XxreEcHotp6KdyzeMUNwDYssXvWwFpQuMSKHEeZe1ReYME'),(972918,'$2y$10$Sd6Fh9lGEwGCkcYx4LWRtut8bRG3Zl9QrDmGZtO2nKOXW/IrHv75y','salares','roy','Male','sdfdas','roy@usjr.com','Active',NULL,NULL,'SeTvPi5cyzqhNKI3PKpDqYQGxD7pWl1KB3DQbfBFt5rYpB1yB25zd9HPYMAF'),(975308,'$2y$10$v2fFsiZhSEKYdJgTMxBTaOUYxgeZUIneE2VWFqAS4iXNiJDCkytDe','Jayden','Lyn','Female','Cebu','lyn@usc.com','Active',NULL,NULL,'f4FjTmjokgAfXlNIZzdTlvbEj2EjewP9q03pibfLI8HqOM7yfkCXolahkJ7x'),(991567,'$2y$10$fj8VKj090CKG93Bc9dyis.jYmb1.So4/DMPuIx0VcrazC3Me84e0q','Velez','Jesus','male','Cebu','velez@usjr.com','Active',NULL,'668614.png','yrmcxDQ39IZJ9DqZ9w6wiN2zFk6Tq4ZCvGlCkYS4b7beH4Vzw4ZNoi3kPPGP');
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
INSERT INTO `userpositiongroup` VALUES (691,5291,1,305252,44079,14866,'active'),(3206,2290,2,512097,NULL,21793,NULL),(4257,5291,1,175283,44079,14866,'active'),(5628,7694,2,214505,NULL,75687,NULL),(6831,5291,1,384957,44079,21793,'active'),(10247,8464,2,831387,44079,14866,NULL),(10701,NULL,2,811221,44079,NULL,'active'),(13883,2290,2,707351,44079,14866,NULL),(14339,8464,2,956906,44079,14866,NULL),(15020,3758,2,126119,99175,75321,NULL),(15575,2290,2,559915,44079,14866,NULL),(18497,9861,2,305252,44079,14866,NULL),(22433,1648,2,589056,44079,15902,'active'),(22716,3679,2,966189,44079,61171,'active'),(23546,8464,2,411764,44079,21793,NULL),(23853,1009,2,384957,44079,21793,NULL),(25985,1131,2,456369,99175,75321,NULL),(28135,8464,2,413604,44079,14866,'active'),(30305,3290,2,256665,99175,94677,'active'),(30670,3290,2,787332,99175,75321,NULL),(31066,9896,2,624295,44079,29728,NULL),(32782,2290,2,972918,44079,14866,NULL),(32821,71902,1,475854,82978,NULL,NULL),(33711,8464,2,602734,44079,14866,NULL),(34966,9814,2,991567,44079,46990,NULL),(35084,3290,2,161633,99175,43403,NULL),(36224,9861,2,335519,44079,21793,NULL),(36240,30284,1,927681,64829,NULL,NULL),(37663,90897,1,401532,92425,NULL,NULL),(39750,56744,1,150228,50732,NULL,NULL),(40563,4515,2,921640,99175,19777,NULL),(41190,3758,2,288497,99175,43403,NULL),(41390,NULL,2,512097,44079,21793,NULL),(44013,9593,2,749594,99175,29014,NULL),(47249,8464,2,178359,44079,14866,NULL),(47521,2290,2,235021,44079,14866,NULL),(47683,2290,2,686972,44079,21793,NULL),(48671,1131,2,729379,99175,15520,'active'),(48759,6362,2,593148,44079,21793,NULL),(50523,1499,2,278775,44079,68969,'active'),(55433,8464,2,429397,44079,14866,NULL),(56029,2290,2,489959,44079,21793,NULL),(58246,6013,2,570022,64829,21346,NULL),(58705,2290,2,674694,44079,14866,NULL),(60234,3758,2,975308,99175,11988,NULL),(62185,8464,2,708944,44079,21793,NULL),(62275,8464,2,427832,44079,14866,NULL),(62583,9662,2,401025,99175,94677,'active'),(62588,3290,2,111260,99175,75321,NULL),(67365,3290,2,161111,99175,11988,NULL),(67812,2290,2,845312,44079,21793,'active'),(68211,1131,2,537393,99175,11988,NULL),(68804,6362,2,742837,44079,14866,NULL),(69751,2290,2,258477,44079,14866,NULL),(70172,9662,2,591500,99175,15520,'active'),(75604,NULL,2,214505,44079,75687,NULL),(78428,2290,2,675601,44079,14866,NULL),(81218,1009,2,175283,44079,14866,NULL),(81784,3290,2,929550,99175,15520,'active'),(83646,9662,2,799417,99175,11988,NULL),(85130,84933,1,199227,99175,NULL,NULL),(87316,3758,2,736795,99175,94677,'active'),(89280,8464,2,646020,44079,14866,NULL),(89359,93888,1,967516,90244,NULL,NULL),(89848,9662,2,355404,99175,75321,NULL),(90540,7785,2,745089,99175,63440,NULL),(90793,3758,2,915927,99175,15520,'active'),(90928,9662,2,116699,99175,43403,'active'),(91216,3290,2,204067,99175,94677,'active'),(91611,8464,2,941030,44079,14866,NULL),(92400,73582,1,920850,73153,NULL,NULL),(92831,2590,2,513333,44079,91307,NULL),(92944,2290,2,786344,44079,21793,'active'),(93559,3290,2,819549,99175,15520,'active'),(98192,23360,1,897722,44079,44079,'active'),(98645,2290,2,697711,44079,21793,NULL),(99244,3290,2,613391,99175,11988,NULL);
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
INSERT INTO `workflow` VALUES (6906,'Test2','inactive',44079),(9891,'test','active',64829),(19943,'Activity Letter','active',99175),(21592,'Tes3','inactive',44079),(22867,'Activity Letter','active',44079),(28358,'test','inactive',44079),(29245,'Test2','inactive',44079),(31635,'Borrow Laptop','active',99175),(41421,'Excuse Letter','active',44079),(43481,'test3','inactive',44079),(48113,'test5','inactive',44079),(50654,'test3','inactive',44079),(50941,'Monitor_Requisition','active',44079),(55769,'Budget Request','active',99175),(57563,'test4','inactive',44079),(58170,'Budget Request','active',44079),(62056,'test2','inactive',44079),(64757,'test','inactive',44079),(75086,'Computer Laboratory Reservation','active',44079),(80525,'Change of grade','active',44079),(81797,'Entry Permit','active',99175),(90679,'Test Workflow','inactive',44079);
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
  `prev` varchar(100) DEFAULT NULL,
  `next` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ws_id`),
  KEY `fk_workflowsteps_workflow1_idx` (`workflow_w_id`),
  KEY `fk_workflowsteps_position1_idx` (`position_pos_id`),
  KEY `fk_wfs_prev_idx` (`prev`),
  CONSTRAINT `fk_workflowsteps_position1` FOREIGN KEY (`position_pos_id`) REFERENCES `position` (`pos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_workflowsteps_workflow1` FOREIGN KEY (`workflow_w_id`) REFERENCES `workflow` (`w_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workflowsteps`
--

LOCK TABLES `workflowsteps` WRITE;
/*!40000 ALTER TABLE `workflowsteps` DISABLE KEYS */;
INSERT INTO `workflowsteps` VALUES (1740,19943,9662,'2','86211','49370'),(5045,75086,9861,'1','','78609'),(5099,81797,3758,'2','85220','17299'),(7610,50941,3679,'4','8537',''),(8299,57563,9896,'2','37892',''),(8537,50941,1499,'3','80180','7610,96776'),(10794,9891,5016,'2','40895',''),(11762,28358,1009,'2','46936',''),(11849,22867,2590,'1','','59164'),(13326,50654,1009,'1','','20653'),(15728,29245,9896,'2','52705',''),(17299,81797,4515,'3','5099,81443',''),(17740,31635,9662,'1','','36173'),(20653,50654,9896,'2','13326',''),(21731,22867,9896,'4','44167,65802',''),(22257,64757,1009,'1','','35046'),(23985,90679,9814,'2','96129','81102'),(24293,80525,9861,'1','','31161'),(31161,80525,1009,'2','24293','97522'),(33783,50941,9861,'1','','80180'),(35046,64757,9861,'2','22257','90990'),(36173,31635,3758,'2','17740',''),(37892,57563,1009,'1','','8299'),(40895,9891,6013,'1','','10794'),(43372,55769,9662,'1','','51895'),(44167,22867,6362,'3','59164','21731'),(46936,28358,9861,'1','','11762'),(49370,19943,3758,'3','1740','72914'),(51895,55769,3758,'2','43372','94534'),(52137,41421,9814,'2','55409',''),(52705,29245,1009,'1','','15728'),(53037,58170,9861,'1','','55046'),(55046,58170,1009,'2','53037','99244'),(55409,41421,1009,'1','','52137'),(56769,90679,9861,'2','96129','81102'),(59164,22867,1009,'2','11849','44167,65802'),(65802,22867,9861,'3','59164','21731'),(67878,48113,9896,'2','84419',''),(72914,19943,9593,'4','49370',''),(76923,90679,6362,'2','96129','81102'),(78609,75086,1009,'2','5045',''),(80180,50941,1009,'2','33783','8537'),(81102,90679,9896,'3','23985,56769,76923','93008'),(81443,81797,9662,'2','85220','17299'),(82346,62056,1009,'1','','90924'),(84419,48113,1009,'1','','67878'),(85220,81797,1131,'1','','5099,81443'),(86211,19943,1131,'1','','1740'),(90924,62056,9861,'2','82346',''),(90990,64757,9814,'3','35046',''),(93008,90679,2590,'4','81102',''),(94534,55769,9593,'3','51895',''),(96129,90679,1009,'1','','23985,56769,76923'),(96196,80525,9896,'4','97522',''),(96776,50941,1648,'4','8537',''),(97522,80525,2590,'3','31161','96196'),(99244,58170,1648,'3','55046','');
/*!40000 ALTER TABLE `workflowsteps` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-14 19:41:31
