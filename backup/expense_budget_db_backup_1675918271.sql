# EXPENSE_BUDGET_DB : MySQL database backup
#
# Generated: Thursday 9. February 2023
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

INSERT INTO categories VALUES("1","Main Budget","A budget is an estimate of income and expenses for a given future period of time that is often created and reviewed on a regular basis. Any organization that wishes to spend money, including businesses and governments, as well as individuals and households of any economic level, can create a budget.","1","2000","2021-07-30 09:21:36","2023-02-09 11:33:45");
INSERT INTO categories VALUES("2","Maintenance"," maintenance budget is one of the most underestimated parts of asset management. It sets out the expected cost of meeting maintenance objectives for the year. It should include the expected costs for all of the different maintenance types and how they apply to different assets or asset groups. It can create an operating budget to forecast costs for all of the maintenance across the business or a project budget, which is concerned specifically with the costs associated with a one-off project. It can create a maintenance budget by looking at historical budgets, determining your maintenance strategy for each asset, and factoring in seasonality and hidden costs","1","1500","2021-07-30 09:21:52","2023-02-09 11:39:37");
INSERT INTO categories VALUES("3","Electricity","Energy efficiency measures can deliver financial benefits to public budgets through both increased income and decreased expenses. Local governments can directly reduce operational costs by implementing energy efficiency measures, which lead to energy savings, and therefore less spent on energy bills. Furthermore, Governments can achieve increased income through sales tax on more valuable energy efficient products and services, as well as increased real estate tax on more valuable energy efficient buildings. Governments also receive indirect financial savings through reduced social welfare expenses spent on energy subsidies.","1","1004","2021-07-30 09:22:22","2023-02-09 11:39:37");
INSERT INTO categories VALUES("4","Water","Calculating the natural input and output of a water system is done using a water budget. This system does not account for the influence of people and is simply intended to analyze the seasonal variations in water availability. The water budget enables us to comprehend how much is organically deposited and taken during the year if we consider the land to be a bank for water. The amount we have to work with will then become clear.","1","2000","2021-07-30 09:23:22","2023-02-09 10:03:48");
INSERT INTO categories VALUES("5","Others","A forecast includes future spending and savings in addition to anticipated income and expenses. Individuals and businesses can both use budgeting to determine whether or not their predicted income and expenses will allow them to continue operating.For each fiscal year, a budget can be created and filled with data on projected sales and cost values. This allows us to predict how the upcoming accounting period will probably end. The business actual performance can be compared to this suggested plan.","1","1000","2021-07-30 09:23:53","2023-02-09 11:39:37");



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

INSERT INTO system_info VALUES("1","name","Naguilian LGU Monitoring and Evaluation System");
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

