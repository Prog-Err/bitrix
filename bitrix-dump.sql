/*
SQLyog Trial v13.1.9 (64 bit)
MySQL - 8.0.30 : Database - bitrix
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bitrix` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `bitrix`;

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `contacts` */

insert  into `contacts`(`id`,`full_name`,`phone`) values 
(6842,'Ольга Петрова ','89003343401'),
(121710,'Иванов Иван Алексеевич','89001111222');

/*Table structure for table `deals` */

DROP TABLE IF EXISTS `deals`;

CREATE TABLE `deals` (
  `id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `jk` varchar(255) DEFAULT NULL,
  `type_id` varchar(50) DEFAULT NULL,
  `contact_id` int DEFAULT NULL,
  `opportunity` decimal(10,2) DEFAULT NULL,
  `begindate` datetime DEFAULT NULL,
  `closedate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `deals` */

insert  into `deals`(`id`,`title`,`jk`,`type_id`,`contact_id`,`opportunity`,`begindate`,`closedate`) values 
(91418,'test','','SALE',121710,0.00,'2023-06-23 03:00:00','2023-06-30 03:00:00'),
(97042,'/2-5-01','','SALE',6842,4506135.00,'2023-11-20 03:00:00','2023-12-02 03:00:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
