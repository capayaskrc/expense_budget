# EXPENSE_BUDGET_DB : MySQL database backup
#
# Generated: Saturday 22. April 2023
# Hostname: localhost
# Database: expense_budget_db
# --------------------------------------------------------


#
# Delete any existing table `categories`
#

DROP TABLE IF EXISTS `categories`;


#
# Table structure of table `categories`
#



CREATE TABLE `categories` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `category` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `balance` float NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO categories VALUES("9","Road widening","&lt;p&gt;From 2022 - 2023&lt;/p&gt;","1","22000000","2023-03-06 15:56:05","2023-03-06 15:57:54");
INSERT INTO categories VALUES("10","SK Project","","1","900000","2023-03-27 11:41:26","2023-03-28 11:46:33");



#
# Delete any existing table `running_balance`
#

DROP TABLE IF EXISTS `running_balance`;


#
# Table structure of table `running_balance`
#



CREATE TABLE `running_balance` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `balance_type` tinyint(1) NOT NULL COMMENT '1=budget, 2=expense',
  `category_id` int(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `amount` float NOT NULL,
  `remarks` text NOT NULL,
  `user_id` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `daterelease` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `running_balance_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO running_balance VALUES("53","1","9","Budget","22000000","&lt;p&gt;Deadline&lt;/p&gt;","1","2023-03-06 03:56:00","","");
INSERT INTO running_balance VALUES("54","1","10","Budget","1000000","","1","2023-03-27 11:41:00","","");
INSERT INTO running_balance VALUES("55","2","10","Expense","100000","&lt;p&gt;&lt;b&gt;Basketball&lt;/b&gt;&lt;/p&gt;","1","2023-03-28 11:45:00","","2023-03-28 11:45:00");



#
# Delete any existing table `schedule_list`
#

DROP TABLE IF EXISTS `schedule_list`;


#
# Table structure of table `schedule_list`
#



CREATE TABLE `schedule_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `activities` varchar(500) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO schedule_list VALUES("16","Preparation","2023-02-05 20:44:00","2023-02-05 20:44:00");
INSERT INTO schedule_list VALUES("17","Updating of LDIS","2023-02-06 20:45:00","2023-02-11 20:45:00");
INSERT INTO schedule_list VALUES("18","-Planning","2023-02-12 08:13:00","2023-02-12 08:13:00");



#
# Delete any existing table `system_info`
#

DROP TABLE IF EXISTS `system_info`;


#
# Table structure of table `system_info`
#



CREATE TABLE `system_info` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO system_info VALUES("1","name","Naguilian LGU Monitoring and Evaluation System");
INSERT INTO system_info VALUES("6","short_name","Naguilian");
INSERT INTO system_info VALUES("11","logo","uploads/1675579380_1668490560_logo2.jfif");



#
# Delete any existing table `users`
#

DROP TABLE IF EXISTS `users`;


#
# Table structure of table `users`
#



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

INSERT INTO users VALUES("1","Adminstrator","Admin","admin","0192023a7bbd73250516f069df18b500","uploads/1624240500_avatar.png","0000-00-00 00:00:00","1","2021-01-20 14:02:37","2021-06-21 09:55:07");
INSERT INTO users VALUES("4","John","Smith","jsmith","1254737c076cf867dc53d60a0364f38e","","0000-00-00 00:00:00","0","2021-06-19 08:36:09","2021-06-19 10:53:12");
INSERT INTO users VALUES("5","Claire","Blake","cblake","4744ddea876b11dcb1d169fadf494418","","0000-00-00 00:00:00","0","2021-06-19 10:01:51","2021-06-19 12:03:23");

