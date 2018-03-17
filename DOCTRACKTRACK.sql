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
INSERT INTO `archive` VALUES (901,6210514),(2141,3378678),(4284,13501),(4433,32330),(4928,62279),(5908,78068),(7127,79608),(8294,68850);
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
INSERT INTO `comment` VALUES (3480,'comment here',32330,74433,'Mar 07, 2018','21:39:09pm'),(4222,'This is a test',13501,2526,'Mar 07, 2018','17:07:46pm'),(4736,'This is comment',97598,30887,'Mar 05, 2018','15:14:50pm'),(5008,'dsfsdafsdafsdafsdafs',17579,74433,'Mar 07, 2018','21:51:20pm'),(5154,'comment 1',32330,74433,'Mar 07, 2018','21:39:31pm'),(5515,'This is a test',13501,2526,'Mar 07, 2018','17:07:45pm'),(9236,'comment2',97598,30887,'Mar 05, 2018','15:16:23pm'),(4370678,'Amping mo :))',3378678,58221,'Mar 08, 2018','13:11:20pm'),(6910353,'Wrong spelling',6210514,64798,'Mar 08, 2018','16:21:47pm');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
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
INSERT INTO `document` VALUES (283,'dhdadasdadasd','file/283.docx',NULL,78546,NULL,NULL),(328,'ExampleScratch','file/328.docx',NULL,78546,NULL,NULL),(331,'dh','file/331.docx',NULL,78546,NULL,NULL),(347,'ScratchDoc','file/347.docx',NULL,78546,NULL,NULL),(354,'d','file/354.docx',NULL,78546,NULL,NULL),(511,'FirstScratchDoc','file/511.docx',NULL,78546,NULL,NULL),(707,'d','file/707.docx',NULL,78546,NULL,NULL),(998,'FirstScratchDoc2','file/998.docx',NULL,78546,NULL,NULL),(10301,NULL,'file/10301.docx',194,88113,'Mar 04, 2018','22:32:52pm'),(13077,'TestRobert','file/13077.docx',886,78546,'Feb 22, 2018','09:38:15am'),(13501,'Template With Space','file/13501.docx',343,78546,'Mar 07, 2018','16:57:37pm'),(14594,'sturm','file/14594.docx',936,88113,'Mar 01, 2018','23:06:57pm'),(15640,'Excuse Letter','file/15640.docx',18,78546,'Feb 22, 2018','10:56:13am'),(17579,'Excuse_Letter111112','file/17579.docx',18,78546,'Mar 07, 2018','21:50:35pm'),(21456,'ExcuseRobert','file/21456.docx',18,78546,'Feb 22, 2018','10:08:45am'),(21996,'PracticeSign','file/21996.docx',397,78546,'Feb 23, 2018','05:43:08am'),(28318,'Test Dean','file/28318.docx',703,78546,'Feb 23, 2018','01:53:23am'),(31523,'ajdajdj','file/31523.docx',658,78546,'Feb 23, 2018','07:07:21am'),(32330,'Excuse_Letter','file/32330.docx',18,78546,'Mar 07, 2018','15:46:30pm'),(34822,'Leave','file/34822.docx',658,78546,'Feb 23, 2018','15:17:20pm'),(36885,'TestAct','file/36885.docx',18,78546,'Feb 21, 2018','22:24:06pm'),(37728,'TEst','file/37728.docx',630,78546,'Feb 12, 2018','16:29:40pm'),(38347,'Sign5','file/38347.docx',397,78546,'Feb 23, 2018','06:17:03am'),(45937,'Acquiantance Party','file/45937.docx',630,78546,'Feb 12, 2018','00:46:34am'),(47202,'subjectsad','file/47202.docx',936,78546,'Mar 01, 2018','22:48:54pm'),(49607,'Excuse2','file/49607.docx',18,78546,'Feb 28, 2018','10:28:49am'),(56037,'Borrow_Material','file/56037.docx',194,78546,'Mar 07, 2018','15:44:31pm'),(58009,'Parallel Test','file/58009.docx',936,88113,'Feb 28, 2018','12:16:05pm'),(58783,'Leave Absence','file/58783.docx',658,78546,'Feb 23, 2018','16:52:33pm'),(60572,'Excuse2','file/60572.docx',18,78546,'Feb 28, 2018','10:28:26am'),(62279,'HealthGordon222','file/62279.docx',34,78546,'Mar 07, 2018','22:09:01pm'),(62893,'Test4','file/62893.docx',658,88113,'Mar 07, 2018','16:12:09pm'),(63802,'HISUBJECT','file/63802.docx',936,78546,'Mar 01, 2018','21:54:52pm'),(64274,'teeeeest','file/64274.docx',936,78546,'Mar 01, 2018','22:19:02pm'),(65291,'Subject','file/65291.docx',936,88113,'Mar 01, 2018','23:02:32pm'),(66317,'Parallel Test','file/66317.docx',936,88113,'Feb 28, 2018','12:17:05pm'),(68207,'Subject','file/68207.docx',936,78546,'Feb 28, 2018','13:31:28pm'),(68850,'TESTEST2','file/68850.docx',886,88113,'Mar 04, 2018','12:21:29pm'),(74263,'Test','file/74263.docx',886,78546,'Feb 21, 2018','22:05:23pm'),(75573,'Leave Form','file/75573.docx',658,78546,'Feb 25, 2018','16:46:40pm'),(76924,'subject','file/76924.docx',703,88113,'Feb 28, 2018','11:03:34am'),(78068,'TESTESTESTS','file/78068.docx',397,78546,'Mar 04, 2018','11:27:11am'),(79608,'Permit_to_Enter','file/79608.docx',67,78546,'Mar 07, 2018','15:52:25pm'),(79771,'Excuse 1','file/79771.docx',18,78546,'Feb 28, 2018','10:20:16am'),(79944,'teeeest','file/79944.docx',936,86456,'Mar 01, 2018','22:17:06pm'),(81232,'Excuse Letter','file/81232.docx',18,78546,'Feb 13, 2018','20:26:35pm'),(84255,'CC','file/84255.docx',936,88113,'Feb 28, 2018','14:13:57pm'),(86330,'TEstExcuse','file/86330.docx',18,78546,'Feb 21, 2018','22:40:11pm'),(88433,'RobertTest3','file/88433.docx',18,78546,'Feb 22, 2018','10:20:00am'),(88757,'SIgn2','file/88757.docx',397,78546,'Feb 23, 2018','06:05:19am'),(94350,'ExcuseTest','file/94350.docx',18,78546,'Feb 22, 2018','10:30:06am'),(97598,'Permit_to_Enter','file/97598.docx',67,23712,'Mar 05, 2018','15:09:35pm'),(97986,'Sign4','file/97986.docx',397,78546,'Feb 23, 2018','06:12:55am'),(98842,'Excuse_Letter','file/98842.docx',18,78546,'Mar 07, 2018','15:38:39pm'),(3378678,'Bus_Reservation_Slip','file/3378678.docx',42,90858,'Mar 08, 2018','01:06pm'),(4654896,'Change of Grade','file/4654896.docx',198,84070,'Mar 08, 2018','05:13pm'),(6210514,'Change of Grade','file/6210514.docx',198,65197,'Mar 08, 2018','04:10pm');
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
INSERT INTO `group` VALUES (338,'Registrar','Registrar',439235,44838,'active',44838,'usjrregistrar'),(439,'SDPC','Student Development and Placement Center',439235,92117,'active',44838,'usjrsdpc'),(2935,'Finance Department',NULL,405596,81420,'active',81420,'testfinance'),(3903,'Business Administration','BA',439235,9309,'active',44838,'ba'),(4688,'Marketing','Marketing',439235,9309,'active',44838,'marketing'),(5087,'VP-Finance',NULL,439235,44838,'active',44838,'usjrvpfinance'),(5322,'CICCT','College of Information Computer and Communications Technology',439235,94724,'active',44838,'usjrcicct'),(5536,'Hospitality Management','HM',439235,9309,'active',44838,'hm'),(5723,'Comptroller',NULL,405596,2935,'active',81420,'testcomp'),(6188,'PAO','Property Administrator\'s Office',439235,44838,'active',44838,'usjrpao'),(8690,'SAO','Student Affairs Office',439235,92117,'active',44838,'usjrsao'),(8857,'Accounting and Finance','AF',439235,9309,'active',44838,'af'),(9263,'ICTO','Information College and Technology Organization',439235,5322,'active',44838,'usjricto'),(9309,'Commerce','Commerce',439235,94724,'active',44838,'usjrcommerce'),(9644,'Medical Dental Clinic',NULL,439235,44838,'active',44838,'usjrclinic'),(11858,'I.T.','Information Technology Department',405596,81420,'active',81420,'testit'),(16498,'IT Organization','IT Organization',405596,11858,'active',81420,'testitorg'),(16839,'JPIA','Junior Philippine Institute of Accountants',405596,42297,'active',81420,'testjpia'),(17154,'President','Office of the President',439235,44838,'active',44838,'usjrpresident'),(29279,'Engineering',NULL,405596,81420,'active',81420,'testeng'),(35941,'Commerce','Commerce Dep',405596,81420,'active',81420,'testcommerce'),(42297,'Accounting',NULL,405596,35941,'active',81420,'testaccounting'),(43710,'CS','Computer Science',405596,11858,'active',81420,'testcs'),(44838,'University of San Jose- Recoletos','',439235,NULL,'Active',NULL,'usjr123'),(52199,'Department of Health','Health',405596,81420,'active',81420,'health'),(58633,'Marketing','Marketing Department',405596,35941,'active',81420,'testmarketing'),(60458,'Registrar Office','Registrar',405596,81420,'active',81420,'register'),(66206,'Vice President','VP',405596,81420,'active',81420,'testvp'),(81420,'Test School','This is a test school.',405596,NULL,'Active',NULL,'test123'),(88167,'President',NULL,405596,81420,'active',81420,'testpres'),(88835,'UV','',351919,NULL,'Active',NULL,'uv'),(91848,'Computer Engineering',NULL,405596,29279,'active',81420,'testcompeng'),(92117,'VP-Welfare',NULL,439235,44838,'active',44838,'usjrvpwelfare'),(94724,'VP-Academics',NULL,439235,44838,'active',44838,'usjrvpacad'),(98825,'Civil Engineering','Civil Engineering',405596,29279,'active',81420,'testcivileng');
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
) ENGINE=InnoDB AUTO_INCREMENT=536 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inbox`
--

LOCK TABLES `inbox` WRITE;
/*!40000 ALTER TABLE `inbox` DISABLE KEYS */;
INSERT INTO `inbox` VALUES (421,45937,74433,'read','00:46:35am','Feb 12, 2018',NULL,NULL),(422,45937,86456,'read','00:51:04am','Feb 12, 2018','01:08:24am','Feb 12, 2018'),(423,37728,74433,'read','16:29:46pm','Feb 12, 2018','04:30:40pm','Feb 12, 2018'),(424,37728,86456,'unread','16:31:09pm','Feb 12, 2018',NULL,NULL),(425,81232,86456,'read','20:26:36pm','Feb 13, 2018','08:27:05pm','Feb 13, 2018'),(426,81232,2526,'read','20:27:26pm','Feb 13, 2018','09:13:04pm','Feb 13, 2018'),(427,74263,74433,'read','22:05:24pm','Feb 21, 2018','10:05:47pm','Feb 21, 2018'),(428,36885,86456,'read','22:24:10pm','Feb 21, 2018','10:24:42pm','Feb 21, 2018'),(429,36885,2526,'read','22:25:27pm','Feb 21, 2018','10:36:07pm','Feb 21, 2018'),(430,86330,74433,'read','22:40:11pm','Feb 21, 2018','10:40:48pm','Feb 21, 2018'),(431,86330,2526,'unread','22:41:38pm','Feb 21, 2018',NULL,NULL),(432,13077,74433,'read','09:38:17am','Feb 22, 2018','09:38:43am','Feb 22, 2018'),(433,13077,2526,'read','10:01:57am','Feb 22, 2018','10:06:42am','Feb 22, 2018'),(434,21456,74433,'read','10:08:46am','Feb 22, 2018','10:09:08am','Feb 22, 2018'),(435,21456,2526,'unread','10:09:14am','Feb 22, 2018',NULL,NULL),(436,88433,74433,'read','10:20:00am','Feb 22, 2018','10:20:22am','Feb 22, 2018'),(437,88433,2526,'unread','10:20:31am','Feb 22, 2018',NULL,NULL),(438,94350,74433,'read','10:30:07am','Feb 22, 2018','10:30:30am','Feb 22, 2018'),(439,94350,2526,'unread','10:30:36am','Feb 22, 2018',NULL,NULL),(440,15640,74433,'read','10:56:16am','Feb 22, 2018','10:57:27am','Feb 22, 2018'),(441,15640,2526,'read','10:57:34am','Feb 22, 2018','10:59:23am','Feb 22, 2018'),(442,28318,74433,'read','01:53:25am','Feb 23, 2018','01:54:02am','Feb 23, 2018'),(443,28318,2526,'read','01:54:09am','Feb 23, 2018','01:54:32am','Feb 23, 2018'),(444,21996,74433,'read','05:43:09am','Feb 23, 2018','05:43:33am','Feb 23, 2018'),(445,21996,2526,'read','05:45:57am','Feb 23, 2018','05:46:37am','Feb 23, 2018'),(446,88757,74433,'read','06:05:19am','Feb 23, 2018','06:05:38am','Feb 23, 2018'),(447,88757,2526,'unread','06:05:44am','Feb 23, 2018',NULL,NULL),(448,97986,74433,'read','06:12:56am','Feb 23, 2018','06:13:14am','Feb 23, 2018'),(449,97986,2526,'read','06:13:20am','Feb 23, 2018','06:28:24am','Feb 23, 2018'),(450,38347,74433,'read','06:17:03am','Feb 23, 2018','06:17:55am','Feb 23, 2018'),(451,38347,2526,'read','06:18:13am','Feb 23, 2018','06:25:19am','Feb 23, 2018'),(452,31523,74433,'read','07:07:21am','Feb 23, 2018','07:08:02am','Feb 23, 2018'),(453,31523,2526,'unread','07:08:33am','Feb 23, 2018',NULL,NULL),(454,34822,74433,'read','15:17:21pm','Feb 23, 2018','03:17:43pm','Feb 23, 2018'),(455,34822,2526,'read','15:18:42pm','Feb 23, 2018','03:19:27pm','Feb 23, 2018'),(456,58783,74433,'read','16:52:34pm','Feb 23, 2018','04:52:56pm','Feb 23, 2018'),(457,58783,2526,'unread','16:53:24pm','Feb 23, 2018',NULL,NULL),(458,511,74433,'unread','15:53:52pm','Feb 25, 2018',NULL,NULL),(459,998,74433,'read','15:55:45pm','Feb 25, 2018','03:56:56pm','Feb 25, 2018'),(460,998,2526,'read','15:57:23pm','Feb 25, 2018','03:57:48pm','Feb 25, 2018'),(461,347,74433,'read','16:40:10pm','Feb 25, 2018','04:41:38pm','Feb 25, 2018'),(462,347,2526,'read','16:41:59pm','Feb 25, 2018','04:42:31pm','Feb 25, 2018'),(463,75573,74433,'read','16:46:41pm','Feb 25, 2018','04:47:01pm','Feb 25, 2018'),(464,75573,2526,'read','16:47:28pm','Feb 25, 2018','04:48:28pm','Feb 25, 2018'),(465,328,74433,'read','16:49:05pm','Feb 26, 2018','04:49:53pm','Feb 26, 2018'),(466,328,2526,'read','16:50:31pm','Feb 26, 2018','04:52:51pm','Feb 26, 2018'),(467,79771,30887,'unread','10:20:22am','Feb 28, 2018',NULL,NULL),(468,49607,30887,'read','10:28:49am','Feb 28, 2018','10:29:25am','Feb 28, 2018'),(469,49607,74433,'read','10:28:49am','Feb 28, 2018','10:32:01am','Feb 28, 2018'),(470,49607,2526,'read','10:32:20am','Feb 28, 2018','10:32:32am','Feb 28, 2018'),(471,76924,17556,'read','11:03:35am','Feb 28, 2018','11:04:43am','Feb 28, 2018'),(472,76924,2526,'read','11:05:02am','Feb 28, 2018','11:05:43am','Feb 28, 2018'),(473,66317,17556,'read','12:17:06pm','Feb 28, 2018','12:17:46pm','Feb 28, 2018'),(474,66317,53339,'read','12:18:08pm','Feb 28, 2018','12:19:06pm','Feb 28, 2018'),(475,66317,86456,'read','12:19:23pm','Feb 28, 2018','12:20:01pm','Feb 28, 2018'),(476,66317,2526,'read','12:19:23pm','Feb 28, 2018','12:20:57pm','Feb 28, 2018'),(477,68207,30887,'read','13:31:28pm','Feb 28, 2018','01:35:48pm','Feb 28, 2018'),(478,68207,74433,'read','13:31:28pm','Feb 28, 2018','01:38:22pm','Feb 28, 2018'),(479,68207,86456,'read','13:41:07pm','Feb 28, 2018','01:42:05pm','Feb 28, 2018'),(480,68207,2526,'read','13:41:07pm','Feb 28, 2018','01:47:19pm','Feb 28, 2018'),(481,68207,53339,'read','13:47:38pm','Feb 28, 2018','01:50:21pm','Feb 28, 2018'),(482,84255,17556,'read','14:13:57pm','Feb 28, 2018','02:15:54pm','Feb 28, 2018'),(483,84255,86456,'read','14:16:37pm','Feb 28, 2018','02:17:47pm','Feb 28, 2018'),(484,84255,2526,'read','14:16:37pm','Feb 28, 2018','02:18:07pm','Feb 28, 2018'),(485,84255,53339,'unread','14:24:05pm','Feb 28, 2018',NULL,NULL),(486,63802,30887,'read','21:54:57pm','Mar 01, 2018','10:03:36pm','Mar 01, 2018'),(487,63802,74433,'read','21:54:57pm','Mar 01, 2018','09:55:45pm','Mar 01, 2018'),(488,63802,86456,'read','22:04:32pm','Mar 01, 2018','10:05:12pm','Mar 01, 2018'),(489,79944,17556,'unread','22:17:07pm','Mar 01, 2018',NULL,NULL),(490,79944,30887,'unread','22:17:07pm','Mar 01, 2018',NULL,NULL),(491,79944,74433,'unread','22:17:07pm','Mar 01, 2018',NULL,NULL),(492,64274,30887,'unread','22:19:02pm','Mar 01, 2018',NULL,NULL),(493,64274,74433,'read','22:19:02pm','Mar 01, 2018','10:19:28pm','Mar 01, 2018'),(494,47202,30887,'read','22:48:59pm','Mar 01, 2018','10:51:50pm','Mar 01, 2018'),(495,47202,74433,'read','22:48:59pm','Mar 01, 2018','10:49:41pm','Mar 01, 2018'),(496,47202,86456,'read','22:54:43pm','Mar 01, 2018','10:55:58pm','Mar 01, 2018'),(497,47202,2526,'read','22:54:43pm','Mar 01, 2018','10:55:33pm','Mar 01, 2018'),(498,47202,53339,'read','22:56:19pm','Mar 01, 2018','10:56:47pm','Mar 01, 2018'),(499,65291,17556,'unread','23:02:32pm','Mar 01, 2018',NULL,NULL),(500,14594,17556,'read','23:06:58pm','Mar 01, 2018','11:09:26pm','Mar 01, 2018'),(501,14594,86456,'read','23:09:48pm','Mar 01, 2018','11:10:19pm','Mar 01, 2018'),(502,14594,2526,'read','23:10:25pm','Mar 01, 2018','11:11:14pm','Mar 01, 2018'),(503,14594,53339,'unread','23:10:36pm','Mar 01, 2018',NULL,NULL),(504,78068,30887,'read','11:27:18am','Mar 04, 2018','11:29:35am','Mar 04, 2018'),(505,78068,74433,'read','11:27:18am','Mar 04, 2018','11:28:35am','Mar 04, 2018'),(506,78068,2526,'read','11:29:52am','Mar 04, 2018','11:30:17am','Mar 04, 2018'),(507,68850,17556,'read','12:21:34pm','Mar 04, 2018','12:22:13pm','Mar 04, 2018'),(508,68850,2526,'read','12:22:46pm','Mar 04, 2018','12:23:17pm','Mar 04, 2018'),(509,10301,17556,'unread','22:32:54pm','Mar 04, 2018',NULL,NULL),(510,97598,30887,'read','15:09:36pm','Mar 05, 2018','03:11:21pm','Mar 05, 2018'),(511,97598,74433,'read','15:09:36pm','Mar 05, 2018','03:19:38pm','Mar 05, 2018'),(512,98842,30887,'read','15:38:44pm','Mar 07, 2018','03:40:15pm','Mar 07, 2018'),(513,56037,30887,'unread','15:44:32pm','Mar 07, 2018',NULL,NULL),(514,56037,74433,'unread','15:44:32pm','Mar 07, 2018',NULL,NULL),(515,32330,30887,'read','15:46:31pm','Mar 07, 2018','03:47:07pm','Mar 07, 2018'),(516,32330,74433,'read','15:46:31pm','Mar 07, 2018','03:48:05pm','Mar 07, 2018'),(517,32330,2526,'read','15:49:12pm','Mar 07, 2018','03:49:44pm','Mar 07, 2018'),(518,79608,30887,'read','15:52:26pm','Mar 07, 2018','04:05:50pm','Mar 07, 2018'),(519,79608,74433,'read','15:52:26pm','Mar 07, 2018','03:52:56pm','Mar 07, 2018'),(520,79608,2526,'read','16:06:04pm','Mar 07, 2018','04:08:06pm','Mar 07, 2018'),(521,62893,17556,'read','16:12:09pm','Mar 07, 2018','04:12:55pm','Mar 07, 2018'),(522,62893,2526,'unread','16:13:21pm','Mar 07, 2018',NULL,NULL),(523,13501,30887,'read','16:57:37pm','Mar 07, 2018','04:58:27pm','Mar 07, 2018'),(524,13501,74433,'read','16:57:38pm','Mar 07, 2018','05:00:22pm','Mar 07, 2018'),(525,13501,2526,'read','17:00:41pm','Mar 07, 2018','05:02:02pm','Mar 07, 2018'),(526,17579,30887,'unread','21:50:40pm','Mar 07, 2018',NULL,NULL),(527,17579,74433,'read','21:50:40pm','Mar 07, 2018','09:51:15pm','Mar 07, 2018'),(528,62279,38270,'read','22:09:01pm','Mar 07, 2018','10:09:33pm','Mar 07, 2018'),(529,62279,86456,'read','22:10:00pm','Mar 07, 2018','10:10:59pm','Mar 07, 2018'),(530,3378678,64798,'read','13:06:23pm','Mar 08, 2018','01:06:58pm','Mar 08, 2018'),(531,3378678,58221,'read','13:07:45pm','Mar 08, 2018','01:09:02pm','Mar 08, 2018'),(532,6210514,84070,'read','16:10:40pm','Mar 08, 2018','04:11:29pm','Mar 08, 2018'),(533,6210514,64798,'read','16:12:48pm','Mar 08, 2018','04:14:34pm','Mar 08, 2018'),(534,4654896,84070,'read','17:13:51pm','Mar 08, 2018','05:14:03pm','Mar 08, 2018'),(535,4654896,64798,'read','17:14:35pm','Mar 08, 2018','05:15:16pm','Mar 08, 2018');
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
INSERT INTO `next` VALUES (2303,20012,''),(2997,44661,''),(4152,70153,'26327'),(6468,44994,''),(6560,10966,''),(12267,94061,'20012'),(15034,40146,'37339'),(18770,86840,'36674'),(20528,77503,''),(21959,6437,''),(29303,44619,'44994'),(32177,74996,'3424'),(34032,38721,''),(37134,44244,'97245'),(38564,37339,'86626'),(46199,64102,'44244'),(47010,5478,''),(49103,17044,''),(50005,28899,'17179'),(55459,11722,''),(59281,98834,'76006'),(60852,3424,'11722'),(66070,73916,'74586'),(66729,36674,'70153'),(67338,93949,''),(67852,74586,''),(69191,11829,'38721'),(76569,97245,'93949'),(78839,86626,''),(81238,26327,'17044'),(85536,69440,'5478'),(85732,76006,''),(90298,17179,''),(94161,87627,'11829'),(96992,67970,'44661');
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
) ENGINE=InnoDB AUTO_INCREMENT=9843 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgchart`
--

LOCK TABLES `orgchart` WRITE;
/*!40000 ALTER TABLE `orgchart` DISABLE KEYS */;
INSERT INTO `orgchart` VALUES (919,NULL,'5723'),(969,NULL,'2935'),(5791,'5464502orgchart.txt','44838');
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
  KEY `upg_id_idx` (`upg_id`),
  CONSTRAINT `upg_id` FOREIGN KEY (`upg_id`) REFERENCES `userpositiongroup` (`upg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orgchartnode`
--

LOCK TABLES `orgchartnode` WRITE;
/*!40000 ALTER TABLE `orgchartnode` DISABLE KEYS */;
INSERT INTO `orgchartnode` VALUES (132,919,NULL,NULL,8225),(895,969,NULL,NULL,8225),(2801,5791,4613,44838,5631),(3896,5791,3107,44838,49856),(9460,5791,7074,44838,87294);
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
  `posLevel` int(11) DEFAULT NULL,
  `motherPos` int(11) DEFAULT NULL,
  PRIMARY KEY (`pos_id`),
  KEY `motherpos_fk_idx` (`motherPos`),
  CONSTRAINT `motherpos_fk` FOREIGN KEY (`motherPos`) REFERENCES `position` (`pos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position`
--

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` VALUES (423,'Admin','','active',81420,NULL,NULL),(1066,'School President',NULL,'active',81420,NULL,NULL),(1635,'Finance Head',NULL,'active',81420,1,NULL),(2126,'Medical Dental Clinic Head',NULL,'active',44838,NULL,NULL),(2443,'Dean',NULL,'active',44838,NULL,NULL),(3007,'College Dean',NULL,'active',81420,NULL,NULL),(3107,'VP-Welfare',NULL,'active',44838,2,4613),(3225,'VP-Finance',NULL,'active',44838,NULL,NULL),(3248,'School Vice President',NULL,'active',81420,NULL,NULL),(3805,'Finance Secretary',NULL,'active',81420,2,1635),(4201,'Secretary',NULL,'active',44838,NULL,NULL),(4540,'College Chairperson','College Chairperson','active',81420,NULL,NULL),(4613,'University President',NULL,'active',44838,1,NULL),(5083,'Admin','','active',44838,NULL,NULL),(5106,'President2',NULL,'active',81420,1,NULL),(5302,'qwesrdtghjkj',NULL,'inactive',81420,NULL,NULL),(5388,'SAO Director',NULL,'active',44838,NULL,NULL),(6108,'Organization President',NULL,'active',44838,NULL,NULL),(6274,'School Secretary',NULL,'active',81420,NULL,NULL),(6425,'Faculty',NULL,'active',81420,NULL,NULL),(6540,'Assistant Registrar',NULL,'active',81420,NULL,NULL),(6574,'Chairperson',NULL,'active',44838,NULL,NULL),(6997,'Head Registrars',NULL,'active',81420,NULL,NULL),(7023,'Organization Secretary',NULL,'active',81420,NULL,NULL),(7074,'VP-Academics',NULL,'active',44838,2,4613),(7371,'Comptroller',NULL,'active',44838,NULL,NULL),(9061,'Head Registrar',NULL,'active',44838,NULL,NULL),(9117,'Vice President2',NULL,'active',81420,2,5106),(9153,'Teacher',NULL,'active',44838,NULL,NULL),(9326,'SDPC Head',NULL,'active',44838,NULL,NULL),(9617,'PresHealth',NULL,'active',81420,NULL,NULL),(9764,'Organizational Secretary',NULL,'active',44838,NULL,NULL),(9894,'College Secretary',NULL,'active',81420,NULL,NULL),(9930,'Property Administrator',NULL,'active',44838,NULL,NULL),(30410,'Student',NULL,'active',44838,NULL,NULL),(52390,'masteradmin','masteradmin','active',88835,NULL,NULL),(77049,'masteradmin','masteradmin','active',81420,NULL,NULL),(78512,'masteradmin','masteradmin','active',44838,NULL,NULL),(83153,'Student',NULL,'active',81420,NULL,NULL);
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
INSERT INTO `previous` VALUES (3344,11829,'87627'),(6066,26327,'70153'),(7293,44661,'67970'),(14418,5478,'69440'),(19465,74586,'73916'),(20187,86626,'37339'),(23471,86840,''),(23623,44244,'64102'),(30290,44619,''),(31327,93949,'97245'),(40399,87627,''),(47039,37339,'40146'),(48428,76006,'98834'),(49665,17044,'26327'),(56574,38721,'11829'),(56872,44994,'44619'),(60329,77503,''),(61162,97245,'44244'),(62560,28899,''),(64396,74996,''),(68596,70153,'36674'),(69354,20012,'94061'),(70506,40146,''),(71839,36674,'86840'),(80952,94061,''),(81750,3424,'74996'),(82955,69440,''),(83117,64102,''),(83995,67970,''),(92799,10966,''),(95878,17179,'28899'),(96112,98834,''),(96295,6437,''),(96464,11722,'3424'),(99051,73916,'');
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
INSERT INTO `template` VALUES (18,'Excuse_Letter','templates/Excuse_Letter.docx',88167,77929,81420,'active'),(34,'HealthGordon','templates/HealthGordon.docx',52199,44740,81420,'active'),(42,'Bus_Reservation_Slip','templates/Bus Reservation Slip.docx',6188,70841,44838,'active'),(60,'Joke_Template','templates/Joke_Template.docx',66206,27183,81420,'inactive'),(67,'Permit_to_Enter','templates/Permit_to_Enter.docx',88167,56751,81420,'active'),(74,'Borrower\'s Slip','templates/Borrower\'s Slip.docx',8690,2378,44838,'active'),(111,'Medical Consultation Expenditures','templates/Medical Consultation Expenditures.docx',9644,63323,44838,'active'),(127,'Chad','templates/Chad.docx',29279,39895,81420,'active'),(192,'Chad','templates/Chad.docx',29279,39895,81420,'active'),(194,'Borrow_Material','templates/Borrow_Material.docx',66206,77929,81420,'active'),(198,'Change of Grade','templates/Change of Grade.docx',338,45441,44838,'active'),(343,'Template With Space','templates/Template With Space.docx',66206,56751,81420,'active'),(397,'Practice_Sign','templates/Practice_Sign.docx',66206,39895,81420,'active'),(408,'Medicine Kit Request','templates/Medicine Kit Request.docx',9644,46845,44838,'active'),(493,'Request Office and Maintenance Supplies','templates/Request Office and Maintenance Supplies.docx',6188,85312,44838,'active'),(630,'Activity_Permit','templates/Activity_Permit.docx',66206,27183,81420,'active'),(658,'Test4','templates/Test4.docx',88167,39895,81420,'active'),(703,'Test2','templates/Test2.docx',88167,39895,81420,'active'),(764,'Chad','templates/Chad.docx',29279,39895,81420,'active'),(886,'Test','templates/Test.docx',88167,39895,81420,'active'),(936,'ParallelTest','templates/ParallelTest.docx',88167,77297,81420,'active'),(958,'Test_Template22','templates/Test_Template2.docx',88167,14824,81420,'inactive'),(961,'Requisition for Capital Expenditures','templates/Requisition for Capital Expenditures.docx',5087,71064,44838,'active');
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
) ENGINE=InnoDB AUTO_INCREMENT=615 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction`
--

LOCK TABLES `transaction` WRITE;
/*!40000 ALTER TABLE `transaction` DISABLE KEYS */;
INSERT INTO `transaction` VALUES (472,45937,74433,74996,1,'approved','3424','00:50:48am','Feb 12, 2018'),(473,45937,86456,3424,2,'rejected','11722','01:09:04am','Feb 12, 2018'),(474,45937,2526,11722,3,'pending','',NULL,NULL),(475,37728,74433,74996,1,'approved','3424','16:30:57pm','Feb 12, 2018'),(476,37728,86456,3424,2,'pending','11722',NULL,NULL),(477,37728,2526,11722,3,'pending','',NULL,NULL),(478,81232,86456,50510,1,'approved','17179','20:27:12pm','Feb 13, 2018'),(479,81232,2526,17179,2,'approved','','21:13:18pm','Feb 13, 2018'),(480,74263,74433,73916,1,'pending','74586','',''),(481,74263,2526,74586,2,'pending','',NULL,NULL),(482,36885,86456,50510,1,'approved','17179','22:24:47pm','Feb 21, 2018'),(483,36885,2526,17179,2,'pending','',NULL,NULL),(484,86330,74433,28899,1,'approved','17179','22:40:55pm','Feb 21, 2018'),(485,86330,2526,17179,2,'pending','',NULL,NULL),(486,13077,74433,73916,1,'approved','74586','10:01:51am','Feb 22, 2018'),(487,13077,2526,74586,2,'approved','','10:06:52am','Feb 22, 2018'),(488,21456,74433,28899,1,'approved','17179','10:09:14am','Feb 22, 2018'),(489,21456,2526,17179,2,'pending','',NULL,NULL),(490,88433,74433,28899,1,'approved','17179','10:20:30am','Feb 22, 2018'),(491,88433,2526,17179,2,'pending','',NULL,NULL),(492,94350,74433,28899,1,'approved','17179','10:30:36am','Feb 22, 2018'),(493,94350,2526,17179,2,'pending','',NULL,NULL),(494,15640,74433,28899,1,'approved','17179','10:57:33am','Feb 22, 2018'),(495,15640,2526,17179,2,'approved','','10:59:41am','Feb 22, 2018'),(496,28318,74433,73916,1,'approved','74586','01:54:07am','Feb 23, 2018'),(497,28318,2526,74586,2,'approved','','01:54:36am','Feb 23, 2018'),(498,21996,74433,73916,1,'approved','74586','05:45:56am','Feb 23, 2018'),(499,21996,2526,74586,2,'approved','','05:46:44am','Feb 23, 2018'),(500,88757,74433,73916,1,'approved','74586','06:05:44am','Feb 23, 2018'),(501,88757,2526,74586,2,'pending','',NULL,NULL),(502,97986,74433,73916,1,'approved','74586','06:13:20am','Feb 23, 2018'),(503,97986,2526,74586,2,'approved','','06:40:19am','Feb 23, 2018'),(504,38347,74433,73916,1,'approved','74586','06:18:00am','Feb 23, 2018'),(505,38347,2526,74586,2,'approved','','06:25:58am','Feb 23, 2018'),(506,31523,74433,73916,1,'approved','74586','07:08:12am','Feb 23, 2018'),(507,31523,2526,74586,2,'pending','',NULL,NULL),(508,34822,74433,73916,1,'approved','74586','15:18:23pm','Feb 23, 2018'),(509,34822,2526,74586,2,'approved','','15:19:34pm','Feb 23, 2018'),(510,58783,74433,73916,1,'approved','74586','16:53:09pm','Feb 23, 2018'),(511,58783,2526,74586,2,'pending','',NULL,NULL),(512,511,74433,73916,1,'pending','74586',NULL,NULL),(513,511,2526,74586,2,'pending','',NULL,NULL),(514,998,74433,28899,1,'approved','17179','15:57:05pm','Feb 25, 2018'),(515,998,2526,17179,2,'approved','','15:57:52pm','Feb 25, 2018'),(516,347,74433,73916,1,'approved','74586','16:41:44pm','Feb 25, 2018'),(517,347,2526,74586,2,'approved','','16:42:35pm','Feb 25, 2018'),(518,75573,74433,73916,1,'approved','74586','16:47:17pm','Feb 25, 2018'),(519,75573,2526,74586,2,'approved','','16:48:33pm','Feb 25, 2018'),(520,328,74433,73916,1,'approved','74586','16:50:15pm','Feb 26, 2018'),(521,328,2526,74586,2,'approved','','16:52:56pm','Feb 26, 2018'),(522,79771,30887,28899,1,'pending','17179',NULL,NULL),(523,79771,74433,28899,1,'pending','17179',NULL,NULL),(524,79771,2526,17179,2,'pending','',NULL,NULL),(525,60572,30887,28899,1,'pending','17179',NULL,NULL),(526,60572,74433,28899,1,'pending','17179',NULL,NULL),(527,60572,2526,17179,2,'pending','',NULL,NULL),(528,49607,30887,28899,1,'approved','17179','10:30:15am','Feb 28, 2018'),(529,49607,74433,28899,1,'approved','17179','10:32:07am','Feb 28, 2018'),(530,49607,2526,17179,2,'approved','','10:32:38am','Feb 28, 2018'),(531,76924,17556,73916,1,'approved','74586','11:04:48am','Feb 28, 2018'),(532,76924,2526,74586,2,'approved','','11:05:47am','Feb 28, 2018'),(533,66317,17556,64102,1,'approved','3291','12:17:56pm','Feb 28, 2018'),(534,66317,53339,3291,2,'approved','44244','12:19:11pm','Feb 28, 2018'),(535,66317,86456,44244,3,'approved','','12:20:12pm','Feb 28, 2018'),(536,66317,2526,86433,3,'approved','','12:21:02pm','Feb 28, 2018'),(537,68207,30887,64102,1,'approved','86433','13:35:58pm','Feb 28, 2018'),(538,68207,74433,64102,1,'approved','86433','13:40:52pm','Feb 28, 2018'),(539,68207,86456,44244,2,'approved','97245','13:42:14pm','Feb 28, 2018'),(540,68207,2526,86433,2,'approved','97245','13:47:24pm','Feb 28, 2018'),(541,68207,53339,97245,3,'approved','','13:50:26pm','Feb 28, 2018'),(542,84255,17556,64102,1,'approved','86433','14:16:12pm','Feb 28, 2018'),(543,84255,86456,44244,2,'approved','97245','14:23:44pm','Feb 28, 2018'),(544,84255,2526,86433,2,'approved','97245','14:16:12pm','Feb 28, 2018'),(545,84255,53339,97245,3,'pending','',NULL,NULL),(546,63802,30887,64102,1,'approved','86433','22:04:20pm','Mar 01, 2018'),(547,63802,74433,64102,1,'approved','86433','22:01:52pm','Mar 01, 2018'),(548,63802,86456,44244,2,'pending','97245',NULL,NULL),(549,63802,2526,86433,2,'approved','97245','22:01:52pm','Mar 01, 2018'),(550,63802,53339,97245,3,'pending','',NULL,NULL),(551,79944,17556,64102,1,'pending','86433',NULL,NULL),(552,79944,30887,64102,1,'pending','86433',NULL,NULL),(553,79944,74433,64102,1,'pending','86433',NULL,NULL),(554,79944,86456,44244,2,'pending','97245',NULL,NULL),(555,79944,2526,86433,2,'pending','97245',NULL,NULL),(556,79944,53339,97245,3,'pending','',NULL,NULL),(557,64274,30887,64102,1,'pending','86433',NULL,NULL),(558,64274,74433,64102,1,'approved','86433','22:47:59pm','Mar 01, 2018'),(559,64274,86456,44244,2,'pending','97245',NULL,NULL),(560,64274,2526,86433,2,'pending','97245','',''),(561,64274,53339,97245,3,'pending','',NULL,NULL),(562,47202,30887,64102,1,'approved','86433','22:53:33pm','Mar 01, 2018'),(563,47202,74433,64102,1,'approved','86433','22:54:32pm','Mar 01, 2018'),(564,47202,86456,44244,2,'approved','97245','22:56:06pm','Mar 01, 2018'),(565,47202,2526,86433,2,'approved','97245','22:54:32pm','Mar 01, 2018'),(566,47202,53339,97245,3,'approved','','22:56:52pm','Mar 01, 2018'),(567,65291,17556,64102,1,'pending','44244',NULL,NULL),(568,65291,86456,44244,2,'pending','97245',NULL,NULL),(569,65291,53339,97245,3,'pending','93949',NULL,NULL),(570,65291,2526,93949,4,'pending','',NULL,NULL),(571,14594,17556,64102,1,'approved','44244','23:09:35pm','Mar 01, 2018'),(572,14594,86456,44244,2,'approved','97245','23:10:25pm','Mar 01, 2018'),(573,14594,53339,97245,3,'approved','93949','23:10:25pm','Mar 01, 2018'),(574,14594,2526,93949,4,'approved','','23:11:19pm','Mar 01, 2018'),(575,78068,30887,73916,1,'approved','74586','11:29:40am','Mar 04, 2018'),(576,78068,74433,73916,1,'approved','74586','11:28:41am','Mar 04, 2018'),(577,78068,2526,74586,2,'approved','','11:40:02am','Mar 04, 2018'),(578,68850,17556,73916,1,'approved','74586','12:22:28pm','Mar 04, 2018'),(579,68850,2526,74586,2,'approved','','12:23:22pm','Mar 04, 2018'),(580,10301,17556,28899,1,'pending','17179',NULL,NULL),(581,10301,2526,17179,2,'pending','',NULL,NULL),(582,97598,30887,98834,1,'approved','76006','03:13:31 pm','Mar 05, 2018'),(583,97598,74433,98834,1,'approved','76006','03:19:46 pm','Mar 05, 2018'),(584,97598,2526,76006,2,'pending','',NULL,NULL),(585,98842,30887,28899,1,'approved','17179','03:41 pm','Mar 07, 2018'),(586,98842,74433,28899,1,'pending','17179',NULL,NULL),(587,98842,2526,17179,2,'pending','',NULL,NULL),(588,56037,30887,28899,1,'pending','17179',NULL,NULL),(589,56037,74433,28899,1,'pending','17179',NULL,NULL),(590,56037,2526,17179,2,'pending','',NULL,NULL),(591,32330,30887,28899,1,'approved','17179','03:47 pm','Mar 07, 2018'),(592,32330,74433,28899,1,'approved','17179','03:49 pm','Mar 07, 2018'),(593,32330,2526,17179,2,'approved','','03:50 pm','Mar 07, 2018'),(594,79608,30887,98834,1,'approved','76006','04:05 pm','Mar 07, 2018'),(595,79608,74433,98834,1,'approved','76006','03:54 pm','Mar 07, 2018'),(596,79608,2526,76006,2,'approved','','04:08 pm','Mar 07, 2018'),(597,62893,17556,73916,1,'approved','74586','04:13 pm','Mar 07, 2018'),(598,62893,2526,74586,2,'pending','',NULL,NULL),(599,13501,30887,98834,1,'approved','76006','04:58 pm','Mar 07, 2018'),(600,13501,74433,98834,1,'approved','76006','05:00 pm','Mar 07, 2018'),(601,13501,2526,76006,2,'approved','','05:02 pm','Mar 07, 2018'),(602,17579,30887,28899,1,'pending','17179',NULL,NULL),(603,17579,74433,28899,1,'pending','17179',NULL,NULL),(604,17579,2526,17179,2,'pending','',NULL,NULL),(605,62279,38270,69440,1,'approved','5478','10:09 pm','Mar 07, 2018'),(606,62279,86456,5478,2,'approved','','10:11 pm','Mar 07, 2018'),(607,3378678,64798,67970,1,'approved','44661','01:07 pm','Mar 08, 2018'),(608,3378678,58221,44661,2,'approved','','01:09 pm','Mar 08, 2018'),(609,6210514,84070,87627,1,'approved','11829','04:12 pm','Mar 08, 2018'),(610,6210514,64798,11829,2,'rejected','38721','16:14:41pm','Mar 08, 2018'),(611,6210514,15996,38721,3,'pending','',NULL,NULL),(612,4654896,84070,87627,1,'approved','11829','05:14 pm','Mar 08, 2018'),(613,4654896,64798,11829,2,'pending','38721',NULL,NULL),(614,4654896,15996,38721,3,'pending','',NULL,NULL);
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
INSERT INTO `user` VALUES (141987,'$2y$10$RimxI/vVTn1MSChA9DB1q.fDq7PMEve/e.ghZUJmj74.0Y/jxKF7m','Raras','Nestor','Male','Cebu City','raras@usjr.com','2537900','active','default.png','','hkpJerWtbucrlFRmCeFniAZj5R7KtoJDLGBzidjwZJIY6tD0veWnr4J8VxmU'),(151875,'$2y$10$b3z3VAH4FmJnvZDoA1Q9KeznY3TNvsZgTWPJxlK7CMTxBQcRBijum','Gabison','Gregg Victor','Male','Cebu City','gregg@usjr.com','2537900','active','default.png','signature/151875.png','OuYrors4Ab1T3SAGUT4oL1yXF1j5R7WGrKB1PBjRG701soZ7T3TCMF3K0Yo9'),(163997,'$2y$10$ED4NHR7x/Wytj7Iy6YGi5evvNfB4sWgCJKhOEk16NtJkrX5KV5bmu','Jao','Chef','Male','Cebu City','jao@usjr.com','999','active','default.png','','RMeqL9WN29ZzGpPPtwr7jOo1DRuPRb6rk0clXSCclpBvl712QsZQROnGWhHO'),(178906,'$2y$10$VvkEQpKc1QsgJIZDUgB53erOHijZ8YD7QjT9RXGhn3nzMG5zVUzAe','Uy','Christine','Female','Cebu City','uy@usjr.com','666','active','default.png','','4gnsJlIOJQXKtRK0c7W4lgA0mNU13CExi4GxBwVVGTAGcTz1xUc8j5m97ldT'),(186208,'$2y$10$Bag1bXeaupP272iGj8t5d.HTfDY/bTbICM5ndnsdMMS85EN0A9O92','Co','Elena','Female','Cebu City','co@usjr.com','09876','active','default.png','','rvDUHPxcgAGgEZAZ8dVxB83ExL9PAoMmc9jwzOk6lEK4l7XsrOPtutbcB5wa'),(245709,'$2y$10$je2UCVrMijMrx.NhnUAZNuCITa1./umQlbClXx0ETQ2GChWpsPdla','Abarquez','Trina Mae','Female','Talisay City','trina@usjr.com','2537900','active','default.png','','6tB6Qe7v1RlaJkbEq5wH85fAFdpua2QMGYDP7ppXHEqJOaE9wz93QTqVgHvm'),(280755,'$2y$10$lxzn7hl5FxCMC8wcVtYxZuB1ZEml9k2N./jaTEd.H1r7w3wsYgW9O','Sturm','Terry','Male','Cebu City','terry@test.com','2345','active','default.png','','6kzmw48fyEsWEsSCs5QLU63xHN12fQSVqcagukQuCAS1FVhFBztL8HqM5XQA'),(287503,'$2y$10$w4ZLwE3vhmRgbCgvTWYKkOfCHpkV8W5l1bnIxtwiaoRkgy2zDeh2a','Moreno','Richard','male','Talisay Cityy','richard@test.com','2435465','Active','5BNlWMk7NzCdCyCrxZ7oK8ebwPitKuhUioIGUa84.png','signature/287503.png','sk5JwLY1GF5pTv3YC0uMxAzCa6URCnRh2BnV9yWkIxrnGKKMvMEEN3ZSWjqQ'),(298688,'$2y$10$pizCGhvQuC1ntuDXJ5VUze9n3bdQHVErnBdMxcVIxy3yEJ8I3ctbK','Baruc','Marlon','Male','Cebu City','baruc@usjr.com','2537900','active','default.png','','xoceNFgJpczeRcfI2twhBnfS79JrihAWSIPgzD4N0fmrYw6cEpQo7Aabp15E'),(351919,'$2y$10$tuwfKN5ad/3M92yjBD.ob.yukV63Yjr6edDAqaQiLf4zAFOg34pXO','Tonya','Cox','Female','Cebu City','tonya@uv.com','234567','active',NULL,NULL,'LJBLBTqhENNsw9YiDhDH9gZCGo80fi5qDw5XWJyy2I3DsD5FP3ViA2DKY5LS'),(362396,'$2y$10$9KWArgotECZGhBWskUvEQ.j4UnepKEvzK8fB35rtWlHYEphxamxJ6','Ramota','Rayo','Male','Cebu City','reyo@usjr.com','09876','active','default.png','','BnGsMu1ALG1OAk0IzIOfangQRhM9jKpNAWjpl4PLBLhYHuDhElE8uZxELj1P'),(379642,'$2y$10$fjJqzUMSTqn4SKuVO.QJmeOb3xJyU7RlFUduA8KHRtUsNXbjBf9EK','Detoya','Edgar','Male','Cebu City','detoya@usjr.com','09430863143','active','default.png','','vYy0CQLWNVpGe1TDJSRbi6WJTmXGM888imhvIxcohHeIsuN77tXdzYmfjFsp'),(405596,'$2y$10$eoz/xi8Eot7q8h3xmQnyY.vM0zmrkWoWm/jVQ5WsLASjLVaKkNC7a','Abarquez','Trina Mae','female','Cansojong, Talisay City','trina@test.com','2726588','active','lCZBj5wfrrAjh80iMDhSWU4jo2ibPA5fBaOtiPJ6.jpeg','signature/405596.png','bIOLKW1DkXAqte44D81HXvogXF3en3pdE4znoInDbKkjzqN1tz8w6IM9hRGm'),(427660,'$2y$10$QOrgzZmY3ATNQcnFbn3hvu2MUOxpZe2vjE6ZygYy9Fnjimtc0Oazm','Hairwood','Aimee','Female','Cebu City','aimee@test.com','23456','Active','default.png','','wRcm1brhGgZiRYULDjkKRYF33XALoP50i9TsTVHJCOXhhzYxGyDe0Gf1UZQA'),(439235,'$2y$10$iJqNTluQ.NMaQFLVCS66yezJjzKNXUktATmqpRnPyVgFOPqvhlSEm','Christopher','Maspara','Male','Cebu City','maspara@usjr.com','123456','active','',NULL,'qQaMkj0fNAGFAhVFNKtqrBY2xZkZqjP2IwxK5bRA2K7BeN5k0uwbZcUcZXnO'),(440601,'$2y$10$HqyffP6uN8YLZ7gw62yizur3o1oECNMjtAfJDnZSetfsYItv1wVhm','Grose','Kristina','Female','Cebu City','kristina@test.com','2345678','active','default.png','',NULL),(449316,'$2y$10$NfL/JTZjiTlIoJbBcSqJv.LmXpJedjrkAtuNjHyPbyyMa85SzYQQG','Abarquez','Trisha','Female','Talisay City','trisha@test.com','32345678','Active','default.png','','umj2456zWXQKeANCCQanPl0gxHGUIWwWTYdjHYn4WkrC2grRYHtJQ2Uu2L3H'),(558833,'$2y$10$fgd7ZhCEM/acqVS3Vd/mI.CG0OxVXofnpp3M8rkseKzCNbPs98pFa','Miro','Lorna','Female','Cebu City','miro@usjr.com','2537900','active','default.png','','8ZTZULjO0hXdte9UPaVBE9zLj6KfxCmJWtSwTIbZGv1t2ey2kvdGoT81dFAL'),(580251,'$2y$10$c9DiK74U1KahdrXk0QXzPeclc4bmsoX3C0eB7tYNwttZziSTcfis6','Pool','Robert','Male','USA','robert@test.com','234567','Active','','signature/580251.png','RCgRMcHRXdIk6sYnsgAmPHSzhWX6X1HAamNPF20mCs2zsS3apIJkcZAo5ZAV'),(590940,'$2y$10$R7YD33l9dt.1Z3viPERndeGcUQCHO5U1X26E3K4apY0.4To7E/lt.','Lim','Duint','Female','Cebu City','lim@usjr.com','09235281640','active','default.png','','QHZTRCy5KyI2tNP4rtyP9J6oerDZnvkWm57VAzV80YuQ7xxg0kWzzDhgsSAk'),(618515,'$2y$10$UqdjkT8oxLBJgvAXxw4Dwexxjj9hJPtpqDmnObCmxBtEFPcp.DH6y','Albite','Faye','Female','Cebu City','faye@usjr.com','2537900','active','default.png','','qXvfaZNg7B8kh86uG1zo4Oo1NcWANVghxRt2H8LA5T3wTBmUpUc4EYHGETzR'),(621381,'$2y$10$rQtBUfkA2WBviqAv7SIsIuIJVaWQiKmKQPWcLRhnZpH6eoj9YXmzO','Gordon','Dick','Male','Cebu City','gordon@test.com','1234','active','default.png','','MrLwTu0MMI408wzFYjWNGR8jAlilXKvsMckzxwONlBEQQ23j7YURfDSXKYZI'),(630614,'$2y$10$QFPWPB70w1AOmLzrpQC6VemuQAOcljKKcfT8JQVTo1ZuQUWssrfSq','Tejana','Carmel','Female','Cebu City','carmel@usjr.com','2537900','active','default.png','','rPOF6CaTTwXnndtSFjT27lXurSQkRsQ2iTWHTDQ13o6UfEP05VncdcFU6K4f'),(646739,'$2y$10$oLvqM3xiJ7GIy//jUkC.9erjmFh4/z1KHM4EVTwLqQMPq5Otj00Ou','Stone','Kyle','male','Talisay City','kyle@test.com','234567','active','p26cMp5wDYTSO08oyhiXXepNcdyoW9UlTdxNnzE1.jpeg','','zruzwrhlVSJlh6lAFRh5qcBos1KBQen8tuuPKOFLUxoiQLYPGk4LdrYrho7X'),(656552,'$2y$10$ZdvV2S6rwFkGkHHlPENu5OJ0xRAT/4nirfC6Vp0WwqiPSbWrY2MJW','Hannah','Mary','Female','Cebu City','hannah@test.com','23456','Active','default.png','','z6GfQZPjZ8vmchrIalhtBon4Ox1HMIPcrBZRqZr1DzAZDkHcCAGw8zKanHuO'),(701069,'$2y$10$DJnVFJi5crUQ9PZzOdvEyudvFiVpgZ.qrsc68ToQLVtvlt57IwMwa','Dean2','Dean2','Male','Cebu','dean2@test.com','2345','active','default.png','','hOKiO7TpwQkwl9EN9oL9Ii9UjY9ww6jMiLhNyOLfZJpvV6hkMOatSTHaGOZn'),(709718,'$2y$10$Dw/7bpXJmsBTRe0M0juSDeBebts86oOlTkAtt83ZqFidy2c5U5t9K','Solar','Dexter','male','Talisay Cityy','dexter@test.com','1234567','Active','','signature/709718.png','UPeme846KHJHUP0pXhIT7FBznD2mLvxs5JNZdtdSYDzmybrwrvZPO5RQxD5F'),(715497,'$2y$10$Uo65W3lvkuKWh.VLMhOckOtKz42kc.5J7n99XdBLg9XW1ZxaQy36e','Bumangabang','James','Male','Cebu City','james@usjr.com','2537900','active','default.png','signature/715497.png','8ZEGlNgwQ4U3wTa72SAewsiL7nZQ1y9KFHtRzjRc2P6LHlYnUWxZglJUTFMZ'),(718662,'$2y$10$9hKW965YiB7Y/sRwGhbX3O46ZdozsKEaS7W9KyI7oprcLnEqpYrda','Mathew','Emilio','Male','Cebu City','emilio@usjr.com','678','active','default.png','','XyZnODr2XwiThC0xOwmu6B0sRLKMXE5NtGY3duHdkZSod1n5MeQ98zhOpDbC'),(737270,'$2y$10$3ul97EhS5UhOrnp49apJ.u0YMronexnxOsiVLdXONp1Rme30Bxlvq','Velez','Jesus','Male','Cebu City','velez@usjr.com','2537900','active','default.png','signature/737270.png','4Fz1WwgkyKQCFzWuUD69cDD90iAi9pgtyJZ7sj0ORZs2sqvBllLV9CyGAD1Q'),(743582,'$2y$10$PdgWX76c1B7x27RQ5d0n5.l2GVPybHt4JS61EGc661cVG/a3foMti','Cuizon','Jovelyn','Female','Cebu City','cuizon@usjr.com','2537900','active','default.png','','rqiPFQxfo8nCPNXiKSrmxY0H8UqduYkfLOkwj5bRHbL8WqZdEOz09x2Gq80r'),(789000,'$2y$10$pfyKFjgbaLtD3UwqJVsORO653Awy4rnvp7Mv1hf13WamYCzMy/0ki','Tacmo','Alma Vicencia','Female','Cebu City','tacmo@usjr.com','2537900','active','default.png','','8UbxPkPHFBiWqObi2YTsJqZq9I7pLG7ed6matlxbV9DYZMCnF6kSEzZUcG1B'),(814271,'$2y$10$32CZRzdYnxrljg.QSUn6TO1Pw2uIptsqziCxvBn4mtTVWmOPW.qj6','Morenos','Richards','Male','Talsay City','richardmor@test.com','0932432','active','default.png','','WO0Uh28VqLV27aT11hHPrxzEiy66CWNZ2A18I1YaZIyqrEspDXLnlydlDcrZ'),(826122,'$2y$10$rL.Q49U3uU9iJta/vywHBOYaY9nXV/.QRJSAZ9RQAFiAo4W97pH7S','Abarquez','Trisha','Female','Talisay City','trisha@usjr.com','2537900','active','default.png','','ACJ6E6CAwEmkQ6DUzm72ieo9lE8c8gRFFT7hT8qS5zadp5YCP5hDdd9WB1GR'),(828914,'$2y$10$SkbTlCla2oVdhdiOgwk9jeP9qX/aacbp4AwKU6pSfT7IADrvugDkm','Legaspino','Antoinette','Female','Cebu City','legaspino@usjr.com','2537900','active','default.png','','BtXJC3gYSI9NPQVwJnWDdoZgqMBIXgF0HKbQuZUF9iT4gB1bqTsnAX70Fg3d'),(890656,'$2y$10$OKmyG2/0JZ8h4dSMBK91ne53mkOUszqpY01Yy6JzNUqv1fkhUvR1m','Gudio','Jeoffrey','Female','Cebu City','gudio@usjr.com','2537900','active','default.png','','VDoZMaAgcb69Qteo8VvIVtMALrro1WwoD4mwThOxXcm3GeSzJ8u1O9nEK8cT'),(920692,'$2y$10$qD5JTlZizKuE4HBdNAGuD.9gqBf/FWPZOYOP9CTqbLQjp5wb.hlKS','Ramon','Vicente','Male','Cebu City','ramon@usjr.com','2537900','active','default.png','','7W3DJ4GyhIE0WVt1adu5Ob1qBaBzVkbKF6TpObAEfKVS1d0nroZOIEJVUCG7'),(947231,'$2y$10$NhZz7FRTsX/M0VgCuYHS8OXW90BosxQg3HBP.jW4SPI6w4QMW/xue','Cerio','Ace','Male','Cebu City','ace@usjr.com','2537900','active','default.png','','vqbbqgMoFuMudQRJeUnGpmSurvX1STxiRtbDcW13TVtNhal4uePIkp7WiyCq'),(981141,'$2y$10$mIc1Y45ZkI.BkvZEjCUDhOZskatcGtBaASuVTCu80n0p.lyeewjzK','Gonzalez','Phillip','Male','Talisay City','phillip@test.com','2345','active','A7TKJfUwyObMGSW70l5mZ7IlL5Bns4NPP7x8NFEN.jpeg','','6RB1XERMdoNO0AEIi0SYjwCNGFkRKm7f09B5BGzbxzaNDNFkXnmEuqGpkzUT'),(986079,'$2y$10$HdMF7uHsd5vl8gsgx2/x4OZhM5vwYZPLUwNdXJJufJ1Z/xcs2O36y','Jakosalem','Jaazael','Male','Cebu City','jakosalem@usjr.com','2537900','active','default.png','','C7oGetKRY23trQoufW2gJVQ0zKeUB5XdUFvCf9O58GkpG8sYUZKJVWd08Txs'),(988937,'$2y$10$nrRJkibeSAHFrHIgl9AZleg3dzf1t1qzTAisaEUPX.pIQqi4q/Rnq','Solars','Dexters','Male','Talisay City','dextersolar@test.com','092345566','active','default.png','','vpniBQKqK0UmY4uT5rUAOBG4ChG1FXdPMkYzDv7DmqasvqfVOBjmFxDYK7U8');
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
INSERT INTO `userpositiongroup` VALUES (415,5083,1,947231,44838,9263,'active'),(1043,423,1,580251,81420,60458,'active'),(1689,7023,2,580251,81420,16498,'active'),(2369,6108,2,947231,44838,9263,'active'),(2526,1066,2,405596,81420,88167,'active'),(2803,1635,2,280755,81420,2935,'active'),(3072,NULL,2,449316,81420,16498,'inactive'),(3509,5083,1,151875,44838,94724,'active'),(4275,9764,2,618515,44838,9263,'active'),(4874,5083,1,439235,44838,17154,'inactive'),(5631,4613,2,439235,44838,17154,'active'),(5730,5083,1,828914,44838,439,'active'),(6194,5083,1,789000,44838,9644,'active'),(6385,5083,1,590940,44838,338,'active'),(6802,423,1,405596,81420,52199,'active'),(7269,423,1,287503,81420,81420,'inactive'),(8225,1635,2,280755,81420,2935,'active'),(8418,423,1,709718,81420,81420,'active'),(9100,6425,2,427660,81420,11858,'active'),(9131,6540,2,988937,81420,60458,'active'),(15259,6574,2,178906,44838,8857,'active'),(15899,9326,2,828914,44838,439,'active'),(15996,9061,2,590940,44838,338,'active'),(17309,30410,2,826122,44838,5322,'active'),(17556,3007,2,656552,81420,29279,'active'),(17894,78512,1,439235,44838,44838,'active'),(23712,83153,2,814271,81420,11858,'inactive'),(30887,3007,2,701069,81420,11858,'active'),(33753,30410,2,947231,44838,5322,'active'),(38270,9617,2,621381,81420,52199,'active'),(39126,2443,2,379642,44838,9309,'active'),(39841,5388,2,737270,44838,8690,'active'),(42895,2126,2,789000,44838,9644,'active'),(49856,3107,2,141987,44838,92117,'active'),(52832,7371,2,298688,44838,5087,'active'),(53339,6274,2,646739,81420,88167,'active'),(56864,3225,2,920692,44838,5087,'active'),(58221,9930,2,986079,44838,6188,'active'),(60338,6574,2,186208,44838,3903,'active'),(61347,6574,2,362396,44838,5536,'active'),(62950,6574,2,718662,44838,4688,'active'),(64798,2443,2,151875,44838,5322,'active'),(65197,9153,2,558833,44838,5322,'active'),(66712,4540,2,981141,81420,98825,'active'),(67881,9153,2,163997,44838,5536,'active'),(74433,3007,2,287503,81420,11858,'active'),(76990,3805,2,440601,81420,2935,'inactive'),(78546,83153,2,580251,81420,11858,'active'),(82537,52390,1,351919,88835,88835,'active'),(84070,6574,2,743582,44838,5322,'active'),(86456,3248,2,709718,81420,66206,'active'),(87294,7074,2,715497,44838,94724,'active'),(88113,1635,2,280755,81420,98825,'active'),(90858,30410,2,245709,44838,5322,'active'),(92272,6540,2,988937,81420,60458,'inactive'),(93061,4201,2,890656,44838,5322,'active'),(97301,9153,2,630614,44838,5322,'active'),(98645,6425,2,427660,81420,11858,'inactive'),(99287,77049,1,405596,81420,81420,'active'),(99325,83153,2,449316,81420,11858,'active'),(99717,30410,2,618515,44838,5322,'active');
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
INSERT INTO `workflow` VALUES (2378,'Borrower\'s Slip','active',44838),(11741,'Test22','inactive',81420),(14824,'Test2','active',81420),(27183,'Activity Permit','active',81420),(39895,'Test Workflow','active',81420),(44740,'HealthExpress','active',81420),(45441,'Change of Grade','active',44838),(46845,'Medicine Kit Request','active',44838),(48084,'Activity Permit','inactive',44838),(56751,'Permit to Enter','active',81420),(63323,'Medical Consultation Expenditures','active',44838),(70841,'Reservation Slip','active',44838),(71064,'Requisition for Capital Expenditures','active',44838),(77297,'ParallelTest','active',81420),(77929,'Excuse Letter','active',81420),(85312,'Request Office and Maintenance Supplies','active',44838);
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
INSERT INTO `workflowsteps` VALUES (3424,27183,3248,'2','sign'),(5478,44740,3248,'2','sign'),(6437,46845,2126,'1','sign'),(10966,63323,2126,'1','sign'),(11722,27183,1066,'3','cc'),(11829,45441,2443,'2','sign'),(17044,14824,3248,'5','cc'),(17179,77929,1066,'2','sign'),(20012,11741,1066,'2','sign'),(26327,14824,1066,'4','sign'),(28899,77929,3007,'1','sign'),(36674,14824,4540,'2','sign'),(37339,71064,7371,'2','sign'),(38721,45441,9061,'3','sign'),(40146,71064,3107,'1','sign'),(44244,77297,3248,'2','sign'),(44619,2378,2443,'1','sign'),(44661,70841,9930,'2','sign'),(44994,2378,5388,'2','sign'),(64102,77297,3007,'1','sign'),(67970,70841,2443,'1','sign'),(69440,44740,9617,'1','sign'),(70153,14824,9894,'3','cc'),(73916,39895,3007,'1','sign'),(74586,39895,1066,'2','sign'),(74996,27183,3007,'1','sign'),(76006,56751,1066,'2','sign'),(77503,85312,9930,'1','sign'),(86626,71064,3225,'3','sign'),(86840,14824,3007,'1','sign'),(87627,45441,6574,'1','sign'),(93949,77297,1066,'4','sign'),(94061,11741,3007,'1','sign'),(97245,77297,6274,'3','cc'),(98834,56751,3007,'1','sign');
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
INSERT INTO `wsreceiver` VALUES (5440,10966,'All'),(9563,44661,'All'),(10268,94061,'All'),(10449,86626,'All'),(14804,5478,'All'),(15362,36674,'All'),(20203,77503,'All'),(23416,97245,'All'),(24095,67970,'All'),(25189,74586,'All'),(25709,37339,'All'),(25854,28899,'All'),(26397,44244,'All'),(27410,3424,'All'),(29139,73916,'All'),(32256,70153,'All'),(34794,40146,'All'),(38154,38721,'All'),(39501,76006,'All'),(46141,11829,'All'),(51620,20012,'All'),(53215,64102,'All'),(58419,11722,'All'),(58959,93949,'All'),(62643,87627,'All'),(63647,86840,'All'),(63978,74996,'All'),(65475,6437,'All'),(68737,69440,'All'),(73992,44994,'All'),(74406,26327,'All'),(74468,98834,'All'),(76292,17044,'All'),(87700,44619,'All'),(94117,17179,'All');
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

-- Dump completed on 2018-03-11 15:18:02
