# EXPENSE_BUDGET_DB : MySQL database backup
#
# Generated: Tuesday 7. February 2023
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

INSERT INTO categories VALUES("1","Main Budget","&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed semper imperdiet tortor et rhoncus. Etiam suscipit egestas faucibus. Aenean condimentum ullamcorper turpis, vestibulum maximus eros sollicitudin ut. Morbi interdum ante quis sollicitudin consectetur. Nulla urna urna, gravida et urna eu, pretium consectetur nunc. Quisque id sem porta, blandit lectus vel, feugiat ante. Pellentesque at suscipit tellus, eget posuere augue. Etiam tristique sit amet erat ut porttitor. Duis ut tortor sagittis, mattis mauris non, luctus mauris. Phasellus nec quam a augue eleifend varius nec vel tellus. Integer cursus in nibh in semper.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;","1","2000","2021-07-30 09:21:36","2023-02-07 18:56:03");
INSERT INTO categories VALUES("2","Maintenance","&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Nullam sed ipsum ut ligula ullamcorper ornare nec et tortor. Suspendisse dui erat, pulvinar ut sapien et, varius convallis tellus. Nulla facilisi. In ante felis, lacinia a ornare nec, interdum nec enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec venenatis orci in laoreet consectetur. Sed lobortis at sapien et fermentum. Pellentesque eros turpis, tincidunt id enim eu, lobortis laoreet neque. Quisque ut justo risus.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;","1","1500","2021-07-30 09:21:52","2023-02-07 18:45:50");
INSERT INTO categories VALUES("3","Electricity","&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Nullam sed ipsum ut ligula ullamcorper ornare nec et tortor. Suspendisse dui erat, pulvinar ut sapien et, varius convallis tellus. Nulla facilisi. In ante felis, lacinia a ornare nec, interdum nec enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec venenatis orci in laoreet consectetur. Sed lobortis at sapien et fermentum. Pellentesque eros turpis, tincidunt id enim eu, lobortis laoreet neque. Quisque ut justo risus.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;","1","1004","2021-07-30 09:22:22","2023-02-07 17:59:23");
INSERT INTO categories VALUES("4","Water","&lt;p&gt;&lt;span style=&quot;color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Praesent dignissim ante id sem semper scelerisque. Maecenas ac lacus egestas, cursus odio quis, tristique diam. Donec maximus congue metus at tincidunt. Suspendisse potenti. Nunc vel quam in metus aliquam placerat sed vitae lectus. Vivamus est nisl, consequat tincidunt blandit feugiat, sagittis sit amet risus. Curabitur congue est in risus mattis, malesuada tincidunt eros sodales. Donec convallis efficitur tincidunt. Etiam tellus nulla, sollicitudin tristique lacus ac, tincidunt placerat sapien.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;","1","2000","2021-07-30 09:23:22","2023-02-05 16:12:12");
INSERT INTO categories VALUES("5","Others","&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;Nulla libero urna, sodales id justo sed, feugiat semper neque. Quisque sollicitudin tellus a condimentum sagittis. Nunc aliquet libero nec justo semper, ut condimentum neque mattis. Donec tincidunt, ipsum vel pulvinar pulvinar, leo ante lobortis justo, et ultricies quam sem vitae metus. Aliquam vel sagittis lorem. Curabitur ac sem orci. Nulla nec varius turpis.&lt;/p&gt;&lt;p style=&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &amp;quot;Open Sans&amp;quot;, Arial, sans-serif; font-size: 14px;&quot;&gt;Pellentesque quis tristique augue. In convallis, ipsum nec pellentesque scelerisque, libero nunc auctor urna, nec hendrerit mauris ante a dolor. Vivamus scelerisque magna vitae massa tristique, vel eleifend odio condimentum. Nullam suscipit ornare imperdiet. Aliquam eu orci eu nisl pharetra sagittis varius eu nisi. Nullam nec ligula tellus. Ut magna odio, imperdiet id rutrum at, pretium sit amet felis.&lt;/p&gt;","1","1000","2021-07-30 09:23:53","2023-02-05 10:36:02");



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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4;

INSERT INTO running_balance VALUES("32","2","3","Expense","66","&lt;p&gt;haha&lt;/p&gt;","1","2023-02-05 10:32:00","2023-02-05 12:35:47","2023-02-05 10:32:00");
INSERT INTO running_balance VALUES("33","2","2","Expense","500","&lt;p&gt;dapat 5000 nalang&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;","1","2023-02-06 10:33:00","2023-02-05 12:35:47","2023-02-06 10:33:00");
INSERT INTO running_balance VALUES("34","1","1","Budget","1000","","1","2023-02-05 10:35:00","2023-02-05 12:35:14","2023-02-05 10:35:19");
INSERT INTO running_balance VALUES("35","1","3","Budget","1000","","1","2023-02-05 10:35:00","2023-02-05 12:35:14","2023-02-05 10:35:32");
INSERT INTO running_balance VALUES("36","1","2","Budget","1000","","1","2023-02-05 10:35:00","2023-02-05 12:35:14","2023-02-05 10:35:48");
INSERT INTO running_balance VALUES("37","1","5","Budget","1000","","1","2023-02-05 10:35:00","2023-02-05 12:35:14","2023-02-05 10:36:02");
INSERT INTO running_balance VALUES("38","1","4","Budget","1000","","1","2023-02-05 10:36:00","2023-02-05 12:35:14","2023-02-05 10:36:17");
INSERT INTO running_balance VALUES("39","2","3","Expense","900","","1","2023-02-07 11:38:00","","2023-02-08 11:38:00");
INSERT INTO running_balance VALUES("41","2","3","Expense","30","","1","2023-02-05 12:47:00","","2023-02-05 12:47:00");
INSERT INTO running_balance VALUES("47","1","4","Budget","1000","","1","2023-02-09 04:11:00","","2023-02-09 04:11:00");
INSERT INTO running_balance VALUES("50","1","3","Budget","1000","&lt;p&gt;December 2022&lt;/p&gt;","1","2022-12-08 05:58:00","2023-02-07 18:46:03","");
INSERT INTO running_balance VALUES("51","1","2","Budget","1000","&lt;p&gt;November 2022&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;","1","2022-11-07 06:45:00","","");
INSERT INTO running_balance VALUES("52","1","1","Budget","1000","&lt;p&gt;2021&lt;/p&gt;","1","2021-11-04 06:55:00","","");



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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

INSERT INTO system_info VALUES("1","name","Budget and Expense Tracker System - PHP");
INSERT INTO system_info VALUES("6","short_name","B&E Tracker");
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

INSERT INTO users VALUES("1","Adminstrator","Admin","admin","0192023a7bbd73250516f069df18b500","uploads/1624240500_avatar.png","","1","2021-01-20 14:02:37","2021-06-21 09:55:07");
INSERT INTO users VALUES("4","John","Smith","jsmith","1254737c076cf867dc53d60a0364f38e","","","0","2021-06-19 08:36:09","2021-06-19 10:53:12");
INSERT INTO users VALUES("5","Claire","Blake","cblake","4744ddea876b11dcb1d169fadf494418","","","0","2021-06-19 10:01:51","2021-06-19 12:03:23");

