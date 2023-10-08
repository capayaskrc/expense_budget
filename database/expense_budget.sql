/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 10.4.28-MariaDB : Database - expense_budget_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`expense_budget_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `expense_budget_db`;

/*Table structure for table `amounts` */

DROP TABLE IF EXISTS `amounts`;

CREATE TABLE `amounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `balance_type` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `amounts` */

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `category` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `balance` float NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`category`,`description`,`status`,`balance`,`date_created`,`date_updated`) values 
(1,'Main Budget','&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper imperdiet tortor et rhoncus. Etiam suscipit egestas faucibus. Aenean condimentum ullamcorper turpis, vestibulum maximus eros sollicitudin ut. Morbi interdum ante quis sollicitudin consectetur. Nulla urna urna, gravida et urna eu, pretium consectetur nunc. Quisque id sem porta, blandit lectus vel, feugiat ante. Pellentesque at suscipit tellus, eget posuere augue. Etiam tristique sit amet erat ut porttitor. Duis ut tortor sagittis, mattis mauris non, luctus mauris. Phasellus nec quam a augue eleifend varius nec vel tellus. Integer cursus in nibh in semper.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;',1,980000,'2021-07-30 09:21:36','2023-10-08 20:54:38'),
(2,'Maintenance','&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Nullam sed ipsum ut ligula ullamcorper ornare nec et tortor. Suspendisse dui erat, pulvinar ut sapien et, varius convallis tellus. Nulla facilisi. In ante felis, lacinia a ornare nec, interdum nec enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec venenatis orci in laoreet consectetur. Sed lobortis at sapien et fermentum. Pellentesque eros turpis, tincidunt id enim eu, lobortis laoreet neque. Quisque ut justo risus.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;',1,17640,'2021-07-30 09:21:52','2023-10-08 20:40:22'),
(3,'Electricity','&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Nullam sed ipsum ut ligula ullamcorper ornare nec et tortor. Suspendisse dui erat, pulvinar ut sapien et, varius convallis tellus. Nulla facilisi. In ante felis, lacinia a ornare nec, interdum nec enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec venenatis orci in laoreet consectetur. Sed lobortis at sapien et fermentum. Pellentesque eros turpis, tincidunt id enim eu, lobortis laoreet neque. Quisque ut justo risus.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;',1,0,'2021-07-30 09:22:22','2023-10-08 14:38:03'),
(4,'Water','&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Praesent dignissim ante id sem semper scelerisque. Maecenas ac lacus egestas, cursus odio quis, tristique diam. Donec maximus congue metus at tincidunt. Suspendisse potenti. Nunc vel quam in metus aliquam placerat sed vitae lectus. Vivamus est nisl, consequat tincidunt blandit feugiat, sagittis sit amet risus. Curabitur congue est in risus mattis, malesuada tincidunt eros sodales. Donec convallis efficitur tincidunt. Etiam tellus nulla, sollicitudin tristique lacus ac, tincidunt placerat sapien.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;',1,0,'2021-07-30 09:23:22','2023-10-08 14:38:04'),
(5,'Others','&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;Nulla libero urna, sodales id justo sed, feugiat semper neque. Quisque sollicitudin tellus a condimentum sagittis. Nunc aliquet libero nec justo semper, ut condimentum neque mattis. Donec tincidunt, ipsum vel pulvinar pulvinar, leo ante lobortis justo, et ultricies quam sem vitae metus. Aliquam vel sagittis lorem. Curabitur ac sem orci. Nulla nec varius turpis.&lt;/p&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;Pellentesque quis tristique augue. In convallis, ipsum nec pellentesque scelerisque, libero nunc auctor urna, nec hendrerit mauris ante a dolor. Vivamus scelerisque magna vitae massa tristique, vel eleifend odio condimentum. Nullam suscipit ornare imperdiet. Aliquam eu orci eu nisl pharetra sagittis varius eu nisi. Nullam nec ligula tellus. Ut magna odio, imperdiet id rutrum at, pretium sit amet felis.&lt;/p&gt;',1,0,'2021-07-30 09:23:53','2023-10-08 14:38:08');

/*Table structure for table `running_balance` */

DROP TABLE IF EXISTS `running_balance`;

CREATE TABLE `running_balance` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `balance_type` tinyint(1) NOT NULL COMMENT '1=budget, 2=expense',
  `category_id` int(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `expense_title` varchar(50) NOT NULL,
  `amount` float NOT NULL,
  `remarks` text NOT NULL,
  `user_id` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `daterelease` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `running_balance_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `running_balance` */

insert  into `running_balance`(`id`,`balance_type`,`category_id`,`type`,`expense_title`,`amount`,`remarks`,`user_id`,`date_created`,`date_updated`,`daterelease`) values 
(65,1,1,'Budget','',1000000,'','1','2023-10-08 02:38:00',NULL,NULL),
(68,1,2,'Budget','',20000,'','1','2023-10-08 07:46:00',NULL,NULL),
(70,2,2,'Expense','asdas',2360,'','1','2023-10-08 08:40:00',NULL,'2023-10-08 08:40:00'),
(71,2,1,'Expense','buldog',20000,'','1','2023-10-08 08:54:00',NULL,'2023-10-08 08:54:00');

/*Table structure for table `schedule_list` */

DROP TABLE IF EXISTS `schedule_list`;

CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `activities` varchar(500) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `schedule_list` */

insert  into `schedule_list`(`id`,`activities`,`start_datetime`,`end_datetime`) values 
(16,'Preparation','2023-02-05 20:44:00','2023-02-05 20:44:00'),
(17,'Updating of LDIS','2023-02-06 20:45:00','2023-02-11 20:45:00'),
(18,'-Planning','2023-02-12 08:13:00','2023-02-12 08:13:00');

/*Table structure for table `system_info` */

DROP TABLE IF EXISTS `system_info`;

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `system_info` */

insert  into `system_info`(`id`,`meta_field`,`meta_value`) values 
(1,'name','Budget and Expense Tracker System - PHP'),
(6,'short_name','B&E Tracker'),
(11,'logo','uploads/1675579380_1668490560_logo2.jfif');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`firstname`,`lastname`,`username`,`password`,`avatar`,`last_login`,`type`,`date_added`,`date_updated`) values 
(1,'Adminstrator','Admin','admin','0192023a7bbd73250516f069df18b500','uploads/1624240500_avatar.png','0000-00-00 00:00:00',1,'2021-01-20 14:02:37','2021-06-21 09:55:07'),
(4,'John','Smith','jsmith','1254737c076cf867dc53d60a0364f38e','','0000-00-00 00:00:00',0,'2021-06-19 08:36:09','2021-06-19 10:53:12'),
(5,'Claire','Blake','cblake','4744ddea876b11dcb1d169fadf494418','','0000-00-00 00:00:00',0,'2021-06-19 10:01:51','2021-06-19 12:03:23');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
