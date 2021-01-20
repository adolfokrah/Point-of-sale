-- MySQL dump 10.18  Distrib 10.3.27-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: biztxsie_pos
-- ------------------------------------------------------
-- Server version	10.3.27-MariaDB-log-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `cart_p_NAME` varchar(50) NOT NULL,
  `cart_p_PRICE` double NOT NULL,
  `cart_p_ID` int(11) NOT NULL,
  `cart_p_AMOUNT` double NOT NULL,
  `cart_p_QTY` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` (`cart_id`, `order_id`, `cart_p_NAME`, `cart_p_PRICE`, `cart_p_ID`, `cart_p_AMOUNT`, `cart_p_QTY`, `status`) VALUES (1,1,'HOOD (STAREX H1) - \'07-\'15',6,12,12,2,'returned'),(2,1,'HOOD (SONATA) - \'10-\'14',234,18,468,2,'active'),(3,1,'HOOD (STAREX H1) - \'07-\'15',6,12,18,3,'active'),(4,2,'FENDER RH (SONATA) - \'10-\'14',342,17,342,1,'active'),(5,3,'FENDER LH (SONATA) - \'10-\'14',34,16,34,1,'active'),(6,4,'FENDER RH (STAREX H1) - \'07-\'15',44,11,220,5,'active'),(7,4,'FENDER RH (SONATA) - \'10-\'14',342,17,4446,13,'active'),(8,5,'FENDER LH (STAREX H1) - \'07-\'15',43,10,86,2,'active'),(9,6,'FENDER LH (STAREX H1) - \'07-\'15',43,10,43,1,'active');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_details`
--

DROP TABLE IF EXISTS `company_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company_details` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `vat_charges` double NOT NULL,
  `address` varchar(56) NOT NULL,
  `phone` varchar(57) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_details`
--

LOCK TABLES `company_details` WRITE;
/*!40000 ALTER TABLE `company_details` DISABLE KEYS */;
INSERT INTO `company_details` (`c_id`, `company_name`, `vat_charges`, `address`, `phone`, `message`) VALUES (1,'God is love auto parts',10,'Accra','0242342342, 0303344231','Thanks for shopping with us, see you soon');
/*!40000 ALTER TABLE `company_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `gr_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`gr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`gr_id`, `group_name`, `permissions`) VALUES (3,'admin','[\r\n  {\r\n    \"module_name\": \"Dashboard\",\r\n    \"permissions\": [\r\n      \"view\"\r\n    ]\r\n  },\r\n  {\r\n    \"module_name\": \"Users\",\r\n    \"permissions\": [\r\n      \"create\",\r\n      \"view\",\r\n      \"delete\",\r\n      \"update\"\r\n    ]\r\n  },\r\n  {\r\n    \"module_name\": \"Groups\",\r\n    \"permissions\": [\r\n      \"create\",\r\n      \"view\",\r\n      \"update\",\r\n      \"delete\"\r\n    ]\r\n  },\r\n  {\r\n    \"module_name\": \"Products\",\r\n    \"permissions\": [\r\n      \"create\",\r\n      \"view\",\r\n      \"update\",\r\n      \"delete\"\r\n    ]\r\n  },\r\n  {\r\n    \"module_name\": \"Stock\",\r\n    \"permissions\": [\r\n      \"view\",\r\n      \"update\"\r\n    ]\r\n  },\r\n  {\r\n    \"module_name\": \"Orders\",\r\n    \"permissions\": [\r\n      \"create\",\r\n      \"view\",\r\n      \"update\"\r\n    ]\r\n  },\r\n  {\r\n    \"module_name\": \"Elements\",\r\n    \"permissions\": [\r\n       \"view\",\r\n       \"create\",\r\n       \"update\",\r\n       \"delete\"\r\n    ]\r\n  },\r\n  {\r\n    \"module_name\": \"Company\",\r\n    \"permissions\": [\r\n      \"view\"\r\n    ]\r\n  }\r\n]'),(4,'Sales girl','[{\"module_name\":\"Dashboard\",\"permissions\":[]},{\"module_name\":\"Users\",\"permissions\":[]},{\"module_name\":\"Groups\",\"permissions\":[]},{\"module_name\":\"Products\",\"permissions\":[\"create\",\"view\",\"update\"]},{\"module_name\":\"Stock\",\"permissions\":[\"view\",\"update\"]},{\"module_name\":\"Orders\",\"permissions\":[\"create\",\"view\",\"update\"]},{\"module_name\":\"Elements\",\"permissions\":[]},{\"module_name\":\"Company\",\"permissions\":[]}]'),(10,'Staff2','[{\"module_name\":\"Dashboard\",\"permissions\":[]},{\"module_name\":\"Users\",\"permissions\":[\"create\",\"view\"]},{\"module_name\":\"Groups\",\"permissions\":[]},{\"module_name\":\"Products\",\"permissions\":[]},{\"module_name\":\"Stock\",\"permissions\":[\"view\",\"update\"]},{\"module_name\":\"Orders\",\"permissions\":[]},{\"module_name\":\"Elements\",\"permissions\":[]},{\"module_name\":\"Company\",\"permissions\":[]}]'),(11,'Auditors','[{\"module_name\":\"Dashboard\",\"permissions\":[\"view\"]},{\"module_name\":\"Users\",\"permissions\":[]},{\"module_name\":\"Groups\",\"permissions\":[]},{\"module_name\":\"Products\",\"permissions\":[\"view\"]},{\"module_name\":\"Stock\",\"permissions\":[\"view\"]},{\"module_name\":\"Orders\",\"permissions\":[\"view\"]},{\"module_name\":\"Elements\",\"permissions\":[\"view\"]},{\"module_name\":\"Company\",\"permissions\":[]}]');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `or_gross_amount` double NOT NULL,
  `or_vat` double NOT NULL,
  `or_discount` double NOT NULL,
  `or_net_amount` double NOT NULL,
  `or_payment_status` varchar(10) NOT NULL,
  `or_amount_received` double NOT NULL,
  `or_customer_name` varchar(30) NOT NULL,
  `or_customer_address` text NOT NULL,
  `or_customer_phone` varchar(20) NOT NULL,
  `or_order_id` text NOT NULL,
  `date_time` datetime NOT NULL,
  `or_vat_percentage` int(11) NOT NULL,
  `sold_by` varchar(50) NOT NULL,
  `modified_by` varchar(50) NOT NULL,
  UNIQUE KEY `order_id` (`order_id`),
  KEY `order_id_2` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`order_id`, `user_id`, `or_gross_amount`, `or_vat`, `or_discount`, `or_net_amount`, `or_payment_status`, `or_amount_received`, `or_customer_name`, `or_customer_address`, `or_customer_phone`, `or_order_id`, `date_time`, `or_vat_percentage`, `sold_by`, `modified_by`) VALUES (1,1,486,48.6,10,524.6,'Paid',600,'','','','','2020-11-13 22:29:00',10,'adolf','admin'),(2,1,342,34.2,0,376.2,'Unpaid',0,'','','','','2020-11-14 10:55:00',10,'adolf',''),(3,1,34,3.4,0,37.4,'Unpaid',0,'','','','','2020-11-20 16:48:00',10,'admin',''),(4,1,4666,466.6,0,5132.6,'Unpaid',0,'','','','','2020-11-20 17:22:00',10,'admin',''),(5,1,86,8.6,0,94.6,'Paid',95,'','','','','2020-12-22 13:11:00',10,'admin',''),(6,1,43,4.3,0,47.3,'Unpaid',0,'Joe','Dtff','0247777896','','2020-12-24 10:55:00',10,'admin','admin');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_statement`
--

DROP TABLE IF EXISTS `product_statement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_statement` (
  `ps_ID` int(11) NOT NULL AUTO_INCREMENT,
  `p_ID` int(11) NOT NULL,
  `ps_action` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  PRIMARY KEY (`ps_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_statement`
--

LOCK TABLES `product_statement` WRITE;
/*!40000 ALTER TABLE `product_statement` DISABLE KEYS */;
INSERT INTO `product_statement` (`ps_ID`, `p_ID`, `ps_action`, `user_id`, `date_time`) VALUES (1,1,'Product inserted',1,'2020-11-13 22:26:00'),(2,2,'Product inserted',1,'2020-11-13 22:26:00'),(3,3,'Product inserted',1,'2020-11-13 22:26:00'),(4,4,'Product inserted',1,'2020-11-13 22:26:00'),(5,5,'Product inserted',1,'2020-11-13 22:26:00'),(6,6,'Product inserted',1,'2020-11-13 22:26:00'),(7,7,'Product inserted',1,'2020-11-13 22:26:00'),(8,8,'Product inserted',1,'2020-11-13 22:26:00'),(9,9,'Product inserted',1,'2020-11-13 22:26:00'),(10,10,'Product inserted',1,'2020-11-13 22:26:00'),(11,11,'Product inserted',1,'2020-11-13 22:26:00'),(12,12,'Product inserted',1,'2020-11-13 22:26:00'),(13,13,'Product inserted',1,'2020-11-13 22:26:00'),(14,14,'Product inserted',1,'2020-11-13 22:26:00'),(15,15,'Product inserted',1,'2020-11-13 22:26:00'),(16,16,'Product inserted',1,'2020-11-13 22:26:00'),(17,17,'Product inserted',1,'2020-11-13 22:26:00'),(18,18,'Product inserted',1,'2020-11-13 22:26:00'),(19,19,'Product inserted',1,'2020-11-13 22:26:00'),(20,20,'Product inserted',1,'2020-11-13 22:26:00'),(21,21,'Product inserted',1,'2020-11-13 22:26:00'),(22,22,'Product inserted',1,'2020-11-13 22:26:00'),(23,23,'Product inserted',1,'2020-11-13 22:26:00'),(24,12,'Product sold <strong>(-2)</strong> from order <a href=\"edit_order.php?order=1\">OD-00001</a>',1,'2020-11-13 22:29:00'),(25,18,'Product sold <strong>(-1)</strong> from order <a href=\"edit_order.php?order=1\">OD-00001</a>',1,'2020-11-13 22:29:00'),(26,12,'Product sold <strong>(-1)</strong>',1,'2020-11-13 22:41:00'),(27,12,'Product returned <strong>(2)</strong> from order <a href=\"edit_order.php?order=1\">OD-00001</a>',1,'2020-11-13 22:41:00'),(28,18,'Product sold <strong>(-1)</strong> from order <a href=\"edit_order.php?order=1\">OD-00001</a>',1,'2020-11-14 10:37:00'),(29,12,'Product sold <strong>(-2)</strong> from order <a href=\"edit_order.php?order=1\">OD-00001</a>',1,'2020-11-14 10:37:00'),(30,17,'Product sold <strong>(-1)</strong> from order <a href=\"edit_order.php?order=2\">OD-00002</a>',1,'2020-11-14 10:55:00'),(31,23,'Product quantity added <strong>(-200)</strong>',1,'2020-11-19 03:25:00'),(32,23,'Product quantity updated <strong>(57)</strong>',1,'2020-11-19 03:25:00'),(33,23,'Product quantity added <strong>(-50)</strong>',1,'2020-11-19 03:48:00'),(34,23,'Product quantity updated <strong>(7)</strong>',1,'2020-11-19 03:48:00'),(35,16,'Product sold <strong>(-1)</strong> from order <a href=\"edit_order.php?order=3\">OD-00003</a>',1,'2020-11-20 16:48:00'),(36,23,'Product quantity added <strong>(3)</strong>',1,'2020-11-20 17:06:00'),(37,23,'Product quantity updated <strong>(10)</strong>',1,'2020-11-20 17:06:00'),(38,23,'Product quantity added <strong>(-5)</strong>',1,'2020-11-20 17:06:00'),(39,23,'Product quantity updated <strong>(5)</strong>',1,'2020-11-20 17:06:00'),(40,22,'Product quantity added <strong>(3)</strong>',1,'2020-11-20 17:06:00'),(41,22,'Product quantity updated <strong>(259)</strong>',1,'2020-11-20 17:06:00'),(42,11,'Product sold <strong>(-5)</strong> from order <a href=\"edit_order.php?order=4\">OD-00004</a>',1,'2020-11-20 17:22:00'),(43,17,'Product sold <strong>(-13)</strong> from order <a href=\"edit_order.php?order=4\">OD-00004</a>',1,'2020-11-20 17:22:00'),(44,10,'Product sold <strong>(-2)</strong> from order <a href=\"edit_order.php?order=5\">OD-00005</a>',1,'2020-12-22 13:11:00'),(45,10,'Product sold <strong>(-1)</strong> from order <a href=\"edit_order.php?order=6\">OD-00006</a>',1,'2020-12-24 10:55:00');
/*!40000 ALTER TABLE `product_statement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `p_ID` int(11) NOT NULL AUTO_INCREMENT,
  `p_SKU` varchar(50) NOT NULL,
  `p_QTY` int(11) NOT NULL,
  `p_LOW_ALERT` int(11) NOT NULL,
  `p_CAT` varchar(50) NOT NULL,
  `p_NAME` varchar(50) NOT NULL,
  `p_PRICE` double NOT NULL,
  `p_AVAILABILITY` varchar(10) NOT NULL,
  `p_MODEL` varchar(50) NOT NULL,
  `p_YEAR` varchar(10) NOT NULL,
  `p_STATUS` varchar(10) NOT NULL,
  PRIMARY KEY (`p_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`p_ID`, `p_SKU`, `p_QTY`, `p_LOW_ALERT`, `p_CAT`, `p_NAME`, `p_PRICE`, `p_AVAILABILITY`, `p_MODEL`, `p_YEAR`, `p_STATUS`) VALUES (1,'CVFD023 F LA',234,2,'CHEVROLET CRUZE 2009-2010','FRONT DOOR LH',44,'yes','CRUZE','\'09','active'),(2,'CVFD023 F RA',235,3,'CHEVROLET CRUZE 2009-2010','FRONT DOOR RH',12,'yes','CRUZE','\'09','active'),(3,'CVFD023 R LA',236,4,'CHEVROLET CRUZE 2009-2010','REAR DOOR LH',44,'yes','CRUZE','\'09','active'),(4,'CVFD023 R RA',76,5,'CHEVROLET CRUZE 2009-2010','REAR DOOR RH',34,'yes','CRUZE','\'09','active'),(5,'CVT023 NA',238,6,'CHEVROLET CRUZE 2009-2010','TAIL GATE',37,'yes','CRUZE','\'09','active'),(6,'CVFD071 F RA',240,8,'CHEVROLET AVEO SONIC 2012-2013','FRONT DOOR RH',39,'yes','AVEO SONIC','\'12-\'16','active'),(7,'CVFD071 R LA',241,9,'CHEVROLET AVEO SONIC 2012-2013','REAR DOOR SEDAN LH',100,'yes','AVEO SONIC','\'12-\'16','active'),(8,'CVFD071 R RA',242,10,'CHEVROLET AVEO SONIC 2012-2013','REAR DOOR SEDAN RH',41,'yes','AVEO SONIC','\'12-\'16','active'),(9,'CVT071 NA',43,11,'CHEVROLET AVEO SONIC 2012-2013','TRUCK LID SEDAN',74,'yes','AVEO SONIC','\'12-\'16','active'),(10,'HYF045 LA',244,12,'HYUNDAI STAREX H1 2007-2015','FENDER LH',43,'yes','STAREX H1','\'07-\'15','active'),(11,'HYF045 RA',34,13,'HYUNDAI STAREX H1 2007-2015','FENDER RH',44,'yes','STAREX H1','\'07-\'15','active'),(12,'HYH045 NA',246,14,'HYUNDAI STAREX H1 2007-2015','HOOD',6,'yes','STAREX H1','\'07-\'15','active'),(13,'HYFD045 LA',247,15,'HYUNDAI STAREX H1 2007-2015','FRONT DOOR LH',55,'yes','STAREX H1','\'07-\'15','active'),(14,'HYFD045 RA',66,16,'HYUNDAI STAREX H1 2007-2015','FRONT DOOR RH',47,'yes','STAREX H1','\'07-\'15','active'),(15,'HYT045 NA',249,17,'HYUNDAI STAREX H1 2007-2015','TAIL GATE',33,'yes','STAREX H1','\'07-\'15','active'),(16,'HYF019 LA',250,18,'HYUNDAI SONATA 2010-2014','FENDER LH',34,'yes','SONATA','\'10-\'14','active'),(17,'HYF019 RA',89,19,'HYUNDAI SONATA 2010-2014','FENDER RH',342,'yes','SONATA','\'10-\'14','active'),(18,'HYH019 NA',252,20,'HYUNDAI SONATA 2010-2014','HOOD',234,'yes','SONATA','\'10-\'14','active'),(19,'HYFD019 LA',253,21,'HYUNDAI SONATA 2010-2014','FRONT DOOR LH',33,'yes','SONATA','\'10-\'14','active'),(20,'HYFD019 RA',254,22,'HYUNDAI SONATA 2010-2014','FRONT DOOR RH',23,'yes','SONATA','\'10-\'14','active'),(21,'HYFD019 R LA',55,23,'HYUNDAI SONATA 2010-2014','REAR DOOR LH',55,'yes','SONATA','\'10-\'14','active'),(22,'HYFD019 R RA',259,24,'HYUNDAI SONATA 2010-2014','REAR DOOR RH',45,'yes','SONATA','\'10-\'14','active'),(23,'HYT019 NA',5,25,'HYUNDAI SONATA 2010-2014','TRUND LID',63,'yes','SONATA','\'10-\'14','active');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(34) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` varchar(23) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `gender` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_name`, `password`, `user_type`, `first_name`, `last_name`, `phone`, `gender`) VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','admin','john','doe','02423423423','Male'),(7,'grace123','c5fe25896e49ddfe996db7508cf00534','Auditors','grace','okrah','02342342342','Female');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'biztxsie_pos'
--

--
-- Dumping routines for database 'biztxsie_pos'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-20 13:33:08
