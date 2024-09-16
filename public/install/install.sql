-- MySQL dump 10.13  Distrib 8.0.28, for macos11 (x86_64)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company` bigint NOT NULL,
  `user` bigint NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_code` int NOT NULL,
  `phone` int NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company` (`company`),
  KEY `user` (`user`),
  FULLTEXT KEY `full_text` (`name`,`surname`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `holidays` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `holiday` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `holiday` (`holiday`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `my_services`
--

DROP TABLE IF EXISTS `my_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `my_services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint NOT NULL,
  `service` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `service` (`service`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `important` smallint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created` (`created`),
  KEY `important` (`important`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications_status`
--

DROP TABLE IF EXISTS `notifications_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications_status` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint NOT NULL,
  `notification` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `notification` (`notification`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`(191))
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phone_area_codes`
--

DROP TABLE IF EXISTS `phone_area_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phone_area_codes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `photo_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_5` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_6` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_7` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_8` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_9` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_10` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `renewals`
--

DROP TABLE IF EXISTS `renewals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `renewals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint NOT NULL,
  `notified` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `notified` (`notified`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `user` bigint NOT NULL,
  `customer` bigint NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `user` (`user`),
  KEY `customer` (`customer`),
  KEY `start` (`start`),
  KEY `end` (`end`),
  KEY `price` (`price`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `vote` tinyint NOT NULL,
  `impression` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `vote` (`vote`),
  KEY `created` (`created`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint NOT NULL,
  `category` bigint NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `services_cat`
--

DROP TABLE IF EXISTS `services_cat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services_cat` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` int DEFAULT NULL,
  `taxid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_email` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking` int DEFAULT '4',
  `view` int DEFAULT '1',
  `mode` tinyint DEFAULT '1',
  `slot_mode` tinyint DEFAULT '1',
  `currency_sign` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_code` int DEFAULT NULL,
  `currency_format` tinyint DEFAULT '1',
  `time_format` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `company` (`company`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sms_marketing`
--

DROP TABLE IF EXISTS `sms_marketing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_marketing` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_code` int NOT NULL,
  `enabled` tinyint DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `area_code` (`area_code`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sms_marketing_send_status`
--

DROP TABLE IF EXISTS `sms_marketing_send_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_marketing_send_status` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `campaign` bigint NOT NULL,
  `customer` bigint NOT NULL,
  `sent` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `campaign` (`campaign`),
  KEY `customer` (`customer`),
  KEY `sent` (`sent`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sms_send_status`
--

DROP TABLE IF EXISTS `sms_send_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_send_status` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `reservation` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reservation` (`reservation`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sms_settings`
--

DROP TABLE IF EXISTS `sms_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `account_sid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notify` int DEFAULT '60',
  `enabled` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `enabled` (`enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occupation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_code` int DEFAULT NULL,
  `phone` int DEFAULT NULL,
  `about` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `include_profile` tinyint DEFAULT NULL,
  `valid_to` datetime DEFAULT NULL,
  `privilege` tinyint DEFAULT '1',
  `member` bigint DEFAULT NULL,
  `template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `valid_to` (`valid_to`),
  KEY `url` (`url`),
  KEY `privilege` (`privilege`),
  KEY `member` (`member`),
  KEY `token` (`remember_token`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vacations`
--

DROP TABLE IF EXISTS `vacations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vacations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `user` bigint NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `websites`
--

DROP TABLE IF EXISTS `websites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `websites` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` int DEFAULT NULL,
  `font` int DEFAULT '1',
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `work_hours`
--

DROP TABLE IF EXISTS `work_hours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_hours` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `mon_from` time DEFAULT NULL,
  `mon_to` time DEFAULT NULL,
  `mon_closed` tinyint DEFAULT NULL,
  `tue_from` time DEFAULT NULL,
  `tue_to` time DEFAULT NULL,
  `tue_closed` tinyint DEFAULT NULL,
  `wed_from` time DEFAULT NULL,
  `wed_to` time DEFAULT NULL,
  `wed_closed` tinyint DEFAULT NULL,
  `thu_from` time DEFAULT NULL,
  `thu_to` time DEFAULT NULL,
  `thu_closed` tinyint DEFAULT NULL,
  `fri_from` time DEFAULT NULL,
  `fri_to` time DEFAULT NULL,
  `fri_closed` tinyint DEFAULT NULL,
  `sat_from` time DEFAULT NULL,
  `sat_to` time DEFAULT NULL,
  `sat_closed` tinyint DEFAULT NULL,
  `sun_from` time DEFAULT NULL,
  `sun_to` time DEFAULT NULL,
  `sun_closed` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `work_times`
--

DROP TABLE IF EXISTS `work_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_times` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site` bigint NOT NULL,
  `user` bigint NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `lunch_from` time DEFAULT NULL,
  `lunch_to` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `site` (`site`),
  KEY `user` (`user`),
  KEY `date_from` (`date_from`),
  KEY `date_to` (`date_to`),
  KEY `time_from` (`time_from`),
  KEY `time_to` (`time_to`),
  KEY `lunch_from` (`lunch_from`),
  KEY `lunch_to` (`lunch_to`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

LOCK TABLES `phone_area_codes` WRITE;
/*!40000 ALTER TABLE `phone_area_codes` DISABLE KEYS */;
INSERT INTO `phone_area_codes` VALUES (1,'355','Albania'),(2,'376','Andorra'),(3,'43','Austria'),(4,'375','Belarus'),(5,'32','Belgium'),(6,'387','Bosnia and Herzegovina'),(7,'359','Bulgaria'),(8,'385','Croatia'),(9,'357','Cyprus'),(10,'420','Czech Republic'),(11,'45','Denmark'),(12,'372','Estonia'),(13,'358','Finland'),(14,'33','France'),(15,'49','Germany'),(16,'350','Gibraltar'),(17,'30','Greece'),(18,'36','Hungary'),(19,'354','Iceland'),(20,'353','Ireland'),(21,'39','Italy'),(22,'7','Kazakhstan'),(23,'383','Kosovo'),(24,'371','Latvia'),(25,'423','Liechtenstein'),(26,'370','Lithuania'),(27,'352','Luxembourg'),(28,'356','Malta'),(29,'373','Moldova'),(30,'377','Monaco'),(31,'382','Montenegro'),(32,'31','Netherlands'),(33,'389','North Macedonia'),(34,'47','Norway'),(35,'48','Poland'),(36,'351','Portugal'),(37,'40','Romania'),(38,'7','Russian Federation'),(39,'378','San Marino'),(40,'381','Serbia'),(41,'421','Slovakia'),(42,'386','Slovenia'),(43,'34','Spain'),(44,'46','Sweden'),(45,'41','Switzerland'),(46,'90','Turkey'),(47,'380','Ukraine'),(48,'44','United Kingdom'),(49,'39','Vatican City State'),(50,'93','Afghanistan'),(51,'213','Algeria'),(52,'1684','American Samoa'),(53,'244','Angola'),(54,'1264','Anguilla'),(55,'672','Antarctica'),(56,'1268','Antigua and Barbuda'),(57,'54','Argentina'),(58,'374','Armenia'),(59,'297','Aruba'),(60,'61','Australia'),(61,'994','Azerbaijan'),(62,'1242','Bahamas'),(63,'973','Bahrain'),(64,'880','Bangladesh'),(65,'1246','Barbados'),(66,'501','Belize'),(67,'229','Benin'),(68,'1441','Bermuda'),(69,'975','Bhutan'),(70,'591','Bolivia'),(71,'267','Botswana'),(72,'55','Brazil'),(73,'673','Brunei Darussalam'),(74,'226','Burkina Faso'),(75,'257','Burundi'),(76,'855','Cambodia'),(77,'237','Cameroon'),(78,'1','Canada'),(79,'238','Cape Verde'),(80,'1345','Cayman Islands'),(81,'236','Central African Republic'),(82,'235','Chad'),(83,'56','Chile'),(84,'86','China'),(85,'61','Christmas Island'),(86,'61','Cocos  Islands'),(87,'57','Colombia'),(88,'269','Comoros'),(89,'242','Congo'),(90,'682','Cook Islands'),(91,'506','Costa Rica'),(92,'225','Cote D\'Ivoire'),(93,'53','Cuba'),(94,'253','Djibouti'),(95,'1767','Dominica'),(96,'1809','Dominican Republic'),(97,'593','Ecuador'),(98,'20','Egypt'),(99,'503','El Salvador'),(100,'240','Equatorial Guinea'),(101,'291','Eritrea'),(102,'251','Ethiopia'),(103,'500','Falkland Islands'),(104,'298','Faroe Islands'),(105,'679','Fiji'),(106,'594','French Guiana'),(107,'689','French Polynesia'),(108,'262','French Southern Territories'),(109,'241','Gabon'),(110,'220','Gambia'),(111,'995','Georgia'),(112,'233','Ghana'),(113,'299','Greenland'),(114,'1473','Grenada'),(115,'590','Guadeloupe'),(116,'1671','Guam'),(117,'502','Guatemala'),(118,'224','Guinea'),(119,'245','Guinea-Bissau'),(120,'592','Guyana'),(121,'509','Haiti'),(122,'504','Honduras'),(123,'852','Hong Kong'),(124,'91','India'),(125,'62','Indonesia'),(126,'98','Iran'),(127,'964','Iraq'),(128,'972','Israel'),(129,'1876','Jamaica'),(130,'81','Japan'),(131,'962','Jordan'),(132,'254','Kenya'),(133,'686','Kiribati'),(134,'82','Korea'),(135,'850','Korea'),(136,'965','Kuwait'),(137,'996','Kyrgyzstan'),(138,'856','Laos'),(139,'961','Lebanon'),(140,'266','Lesotho'),(141,'231','Liberia'),(142,'218','Libya'),(143,'853','Macau'),(144,'261','Madagascar'),(145,'265','Malawi'),(146,'60','Malaysia'),(147,'960','Maldives'),(148,'223','Mali'),(149,'692','Marshall Islands'),(150,'596','Martinique'),(151,'222','Mauritania'),(152,'230','Mauritius'),(153,'262','Mayotte'),(154,'52','Mexico'),(155,'691','Micronesia'),(156,'976','Mongolia'),(157,'1664','Montserrat'),(158,'212','Morocco'),(159,'258','Mozambique'),(160,'95','Myanmar'),(161,'264','Namibia'),(162,'674','Nauru'),(163,'977','Nepal'),(164,'687','New Caledonia'),(165,'64','New Zealand'),(166,'505','Nicaragua'),(167,'227','Niger'),(168,'234','Nigeria'),(169,'683','Niue'),(170,'6723','Norfolk Island'),(171,'1670','Northern Mariana Islands'),(172,'968','Oman'),(173,'92','Pakistan'),(174,'680','Palau'),(175,'507','Panama'),(176,'675','Papua New Guinea'),(177,'595','Paraguay'),(178,'51','Peru'),(179,'63','Philippines'),(180,'870','Pitcairn'),(181,'1','Puerto Rico'),(182,'974','Qatar'),(183,'262','Reunion'),(184,'250','Rwanda'),(185,'1869','Saint Kitts and Nevis'),(186,'1758','Saint Lucia'),(187,'590','Saint Martin'),(188,'1784','Saint Vincent and the Grenadines'),(189,'685','Samoa'),(190,'239','Sao Tome and Principe'),(191,'966','Saudi Arabia'),(192,'221','Senegal'),(193,'248','Seychelles'),(194,'232','Sierra Leone'),(195,'65','Singapore'),(196,'677','Solomon Islands'),(197,'252','Somalia'),(198,'27','South Africa'),(199,'94','Sri Lanka'),(200,'290','St. Helena'),(201,'508','St. Pierre and Miquelon'),(202,'249','Sudan'),(203,'597','Suriname'),(204,'47','Svalbard and Jan Mayen Islands'),(205,'268','Swaziland'),(206,'963','Syria'),(207,'886','Taiwan'),(208,'992','Tajikistan'),(209,'255','Tanzania'),(210,'66','Thailand'),(211,'228','Togo'),(212,'690','Tokelau'),(213,'676','Tonga'),(214,'1868','Trinidad and Tobago'),(215,'216','Tunisia'),(216,'993','Turkmenistan'),(217,'1649','Turks and Caicos Islands'),(218,'688','Tuvalu'),(219,'256','Uganda'),(220,'971','United Arab Emirates'),(221,'1','United States'),(222,'598','Uruguay'),(223,'998','Uzbekistan'),(224,'678','Vanuatu'),(225,'58','Venezuela'),(226,'84','Viet Nam'),(227,'1284','Virgin Islands'),(228,'1340','Virgin Islands'),(229,'681','Wallis and Futuna Islands'),(230,'967','Yemen'),(231,'260','Zambia'),(232,'263','Zimbabwe');
/*!40000 ALTER TABLE `phone_area_codes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-30 11:08:17
