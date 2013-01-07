/*
SQLyog Enterprise v10.3 
MySQL - 5.5.24 : Database - ancluiche
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`ancluiche` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `ancluiche`;

/*Table structure for table `matches` */

DROP TABLE IF EXISTS `matches`;

CREATE TABLE `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `season` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `grade` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `competition` varchar(30) DEFAULT NULL,
  `team1` varchar(30) DEFAULT NULL,
  `score1` varchar(10) DEFAULT NULL,
  `stage` varchar(30) DEFAULT NULL,
  `team2` varchar(30) DEFAULT NULL,
  `score2` varchar(10) DEFAULT NULL,
  `venue` varchar(20) DEFAULT NULL,
  `address` varchar(30) DEFAULT NULL,
  `referee_firstname` varchar(20) DEFAULT NULL,
  `referee_lastname` varchar(20) DEFAULT NULL,
  `referee_county` varchar(20) DEFAULT NULL,
  `referee_club` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
