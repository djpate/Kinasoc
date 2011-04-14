-- MySQL dump 10.13  Distrib 5.1.41, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: askfex
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.10-log

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
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` int(11) NOT NULL,
  `creationDate` datetime NOT NULL,
  `modificationDate` datetime NOT NULL,
  `content` text NOT NULL,
  `user` int(11) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question` (`question`),
  KEY `user` (`user`),
  CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `answer_ibfk_1` FOREIGN KEY (`question`) REFERENCES `question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (1,2,'2011-04-13 13:33:19','0000-00-00 00:00:00','Il faut faire un sudo reboot ! attention a ton init.d !!',1,0),(6,2,'2011-04-13 17:56:33','0000-00-00 00:00:00','qsdf wfsd gfdgxdfg sdfg wdfg dfg sdf sddfg sdfg sdfg ',1,0);
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answer_comment`
--

DROP TABLE IF EXISTS `answer_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `answer` int(11) NOT NULL,
  `creationDate` datetime NOT NULL,
  `modificationDate` datetime NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `answer` (`answer`),
  CONSTRAINT `answer_comment_ibfk_2` FOREIGN KEY (`answer`) REFERENCES `answer` (`id`) ON DELETE CASCADE,
  CONSTRAINT `answer_comment_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer_comment`
--

LOCK TABLES `answer_comment` WRITE;
/*!40000 ALTER TABLE `answer_comment` DISABLE KEYS */;
INSERT INTO `answer_comment` VALUES (1,1,1,'2011-04-13 14:17:04','0000-00-00 00:00:00','Trop bien ta réponse !'),(2,2,1,'2011-04-13 14:27:31','0000-00-00 00:00:00','orem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et enim mi. Ut iaculis nulla dolor. Donec consequat odio quis nibh porttitor porttitor vel nec turpis. Nulla viverra purus congue neque egestas eu gravida velit condimentum. Pellentesque nec magna velit.'),(5,1,1,'2011-04-13 15:21:31','0000-00-00 00:00:00','dsfqsd qsdf qsd f'),(6,1,1,'2011-04-13 15:23:55','0000-00-00 00:00:00','qfgq sdqsdfg qsdfg '),(7,1,1,'2011-04-13 15:25:11','0000-00-00 00:00:00','qsdf qsdf qsd f'),(8,1,1,'2011-04-13 15:25:27','0000-00-00 00:00:00','salult c tro bien ce site'),(9,1,1,'2011-04-13 15:26:26','0000-00-00 00:00:00','hasellus dapibus semper consectetuer hendrerit. '),(10,1,1,'2011-04-13 15:26:42','0000-00-00 00:00:00','Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.'),(11,1,1,'2011-04-13 15:28:03','0000-00-00 00:00:00','gsdfdsgdfgsgdfg sggsb sggfd gsfd'),(12,1,1,'2011-04-13 15:39:03','0000-00-00 00:00:00','qsdfqsdf qdsf qsdf qsd f'),(13,1,1,'2011-04-13 15:39:18','0000-00-00 00:00:00','sdfg sdf gsdf sdf gsdf g'),(14,1,1,'2011-04-13 15:39:23','0000-00-00 00:00:00','sfdgd qsfd gsdfg sdf '),(15,1,1,'2011-04-13 15:39:34','0000-00-00 00:00:00','qsdf qsd fqsd'),(16,1,1,'2011-04-13 15:40:19','0000-00-00 00:00:00','qsd fqsdf qsd fqdsf qdsf qsdf ');
/*!40000 ALTER TABLE `answer_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answer_vote`
--

DROP TABLE IF EXISTS `answer_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer_vote` (
  `answer` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`answer`,`user`),
  KEY `user` (`user`),
  CONSTRAINT `answer_vote_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `answer_vote_ibfk_1` FOREIGN KEY (`answer`) REFERENCES `answer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer_vote`
--

LOCK TABLES `answer_vote` WRITE;
/*!40000 ALTER TABLE `answer_vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `answer_vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creationDate` datetime NOT NULL,
  `modificationDate` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `user` int(11) NOT NULL,
  `views` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (2,'2011-04-13 13:27:26','1970-01-01 01:00:00','Mon serveur unix ne démarre plus !','Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.',2,148),(4,'2011-04-14 14:52:34','1970-01-01 01:00:00','Comment faire pour faire ceci !','Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.',1,1);
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_comment`
--

DROP TABLE IF EXISTS `question_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `creationDate` datetime NOT NULL,
  `modificationDate` datetime NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question` (`question`),
  KEY `user` (`user`),
  CONSTRAINT `question_comment_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_comment_ibfk_1` FOREIGN KEY (`question`) REFERENCES `question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_comment`
--

LOCK TABLES `question_comment` WRITE;
/*!40000 ALTER TABLE `question_comment` DISABLE KEYS */;
INSERT INTO `question_comment` VALUES (8,1,2,'2011-04-13 18:04:12','0000-00-00 00:00:00','sfdg qqdsf qsdf qsdf ');
/*!40000 ALTER TABLE `question_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_tag`
--

DROP TABLE IF EXISTS `question_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_tag` (
  `question` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  PRIMARY KEY (`question`,`tag`),
  KEY `question` (`question`),
  KEY `tag` (`tag`),
  CONSTRAINT `question_tag_ibfk_2` FOREIGN KEY (`tag`) REFERENCES `tag` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_tag_ibfk_1` FOREIGN KEY (`question`) REFERENCES `question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_tag`
--

LOCK TABLES `question_tag` WRITE;
/*!40000 ALTER TABLE `question_tag` DISABLE KEYS */;
INSERT INTO `question_tag` VALUES (2,2),(2,6),(2,7),(4,1),(4,2);
/*!40000 ALTER TABLE `question_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_vote`
--

DROP TABLE IF EXISTS `question_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_vote` (
  `question` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`question`,`user`),
  KEY `user` (`user`),
  CONSTRAINT `question_vote_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `question_vote_ibfk_1` FOREIGN KEY (`question`) REFERENCES `question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_vote`
--

LOCK TABLES `question_vote` WRITE;
/*!40000 ALTER TABLE `question_vote` DISABLE KEYS */;
INSERT INTO `question_vote` VALUES (2,1,1,'2011-04-14 14:54:41');
/*!40000 ALTER TABLE `question_vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'PHP'),(2,'MySQL'),(3,'ASP'),(4,'Oracle'),(5,'Windows'),(6,'Linux'),(7,'Unix');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `openid_identifier` varchar(500) NOT NULL,
  `first` varchar(50) NOT NULL,
  `last` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'djpate','toto','djpate@gmail.com','','',''),(2,'korben','toto','gaultier.monier@gmail.com','','',''),(6,'','','pascal.denis.75@gmail.com','https://www.google.com/accounts/o8/id?id=AItOawk2fgCTolsq1wcT24E1ApHde69-wmCK0yw','pascal','denis');
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

-- Dump completed on 2011-04-14 17:04:32
