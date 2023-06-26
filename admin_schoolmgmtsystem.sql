/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.25-MariaDB : Database - admin_schoolmgmtsystem
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`admin_schoolmgmtsystem` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `admin_schoolmgmtsystem`;

/*Table structure for table `blood_groups` */

DROP TABLE IF EXISTS `blood_groups`;

CREATE TABLE `blood_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `blood_groups` */

insert  into `blood_groups`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'O-','2022-06-17 00:38:08','2022-06-17 00:38:08'),
(2,'O+','2022-06-17 00:38:08','2022-06-17 00:38:08'),
(3,'A+','2022-06-17 00:38:08','2022-06-17 00:38:08'),
(4,'A-','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(5,'B+','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(6,'B-','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(7,'AB+','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(8,'AB-','2022-06-17 00:38:09','2022-06-17 00:38:09');

/*Table structure for table `bom_pa_records` */

DROP TABLE IF EXISTS `bom_pa_records`;

CREATE TABLE `bom_pa_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `bom_pa_records_code_unique` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `bom_pa_records` */

insert  into `bom_pa_records`(`id`,`user_id`,`code`,`emp_date`,`group_id`,`created_at`,`updated_at`) values 
(2,120,'4TIPg731ODW8ocIoijKy',NULL,'1,4','2022-08-17 16:07:57','2023-01-09 08:51:46');

/*Table structure for table `book_requests` */

DROP TABLE IF EXISTS `book_requests`;

CREATE TABLE `book_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `start_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `returned` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `book_requests_book_id_foreign` (`book_id`) USING BTREE,
  KEY `book_requests_user_id_foreign` (`user_id`) USING BTREE,
  CONSTRAINT `book_requests_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `book_requests` */

/*Table structure for table `books` */

DROP TABLE IF EXISTS `books`;

CREATE TABLE `books` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `my_class_id` int(10) unsigned DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_copies` int(11) DEFAULT NULL,
  `issued_copies` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `books_my_class_id_foreign` (`my_class_id`) USING BTREE,
  CONSTRAINT `books_my_class_id_foreign` FOREIGN KEY (`my_class_id`) REFERENCES `my_classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `books` */

/*Table structure for table `calevents` */

DROP TABLE IF EXISTS `calevents`;

CREATE TABLE `calevents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `participants` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specific_teacher` int(10) DEFAULT NULL,
  `specific_form` int(10) DEFAULT NULL,
  `date_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_date` datetime DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `calevents` */

insert  into `calevents`(`id`,`name`,`participants`,`specific_teacher`,`specific_form`,`date_type`,`event_date`,`start_date`,`end_date`,`created_at`,`updated_at`) values 
(16,'parent meeting','parent',1,1,'single','2022-07-01 13:23:00',NULL,NULL,'2022-07-21 15:23:55','2022-07-21 15:26:28'),
(17,'teacher meeting','teacher',1,NULL,'range',NULL,'2022-07-04 13:26:00','2022-07-07 13:26:00','2022-07-21 15:26:09','2022-07-21 15:26:09'),
(18,'parent meeting3','parent',NULL,2,'single','2022-07-19 14:11:00','2022-07-20 14:10:00','2022-07-21 14:10:00','2022-07-21 16:10:41','2022-07-21 16:11:27');

/*Table structure for table `class_subjects` */

DROP TABLE IF EXISTS `class_subjects`;

CREATE TABLE `class_subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `my_class_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `class_subjects` */

insert  into `class_subjects`(`id`,`my_class_id`,`subject_id`,`teacher_id`,`created_at`,`updated_at`) values 
(156,74,5,72,'2023-03-21 07:53:42','2023-04-09 04:20:55'),
(157,74,7,72,'2023-03-21 07:53:42','2023-03-21 07:58:31'),
(158,74,27,72,'2023-03-21 07:53:42','2023-03-21 07:58:33'),
(159,75,5,72,'2023-03-21 07:53:58','2023-03-21 08:07:33'),
(160,75,7,72,'2023-03-21 07:53:58','2023-03-21 08:07:33'),
(161,75,27,72,'2023-03-21 07:53:58','2023-03-21 08:07:36'),
(162,76,9,NULL,'2023-03-21 07:54:07','2023-03-21 07:54:07'),
(163,76,10,NULL,'2023-03-21 07:54:07','2023-03-21 07:54:07'),
(164,76,12,NULL,'2023-03-21 07:54:07','2023-03-21 07:54:07'),
(165,76,27,NULL,'2023-03-21 07:54:07','2023-03-21 07:54:07'),
(166,76,26,NULL,'2023-03-21 07:54:07','2023-03-21 07:54:07');

/*Table structure for table `class_types` */

DROP TABLE IF EXISTS `class_types`;

CREATE TABLE `class_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `class_types` */

insert  into `class_types`(`id`,`name`,`code`,`created_at`,`updated_at`) values 
(26,'sample','E8mVL','2022-12-02 09:49:09','2022-12-02 09:49:09');

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `contacts` */

insert  into `contacts`(`id`,`name`,`email`,`message`,`phone`,`created_at`,`updated_at`) values 
(89,'Daniel','daniel@gmail.com','herry',NULL,'2022-10-11 18:58:33','2022-10-11 18:58:33');

/*Table structure for table `dorms` */

DROP TABLE IF EXISTS `dorms`;

CREATE TABLE `dorms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `dorms_name_unique` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `dorms` */

insert  into `dorms`(`id`,`name`,`description`,`created_at`,`updated_at`) values 
(1,'Faith Hostel',NULL,NULL,NULL),
(2,'Peace Hostel',NULL,NULL,NULL),
(3,'Grace Hostel',NULL,NULL,NULL),
(4,'Success Hostel',NULL,NULL,NULL),
(5,'Trust Hostel',NULL,NULL,NULL);

/*Table structure for table `exam_forms` */

DROP TABLE IF EXISTS `exam_forms`;

CREATE TABLE `exam_forms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `min_subject_cnt` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `state` tinyint(1) DEFAULT NULL,
  `flag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `exam_forms` */

insert  into `exam_forms`(`id`,`exam_id`,`form_id`,`min_subject_cnt`,`created_at`,`updated_at`,`state`,`flag`) values 
(226,145,1,10,'2023-03-24 06:25:55','2023-04-13 07:16:06',0,1),
(227,145,2,10,'2023-03-24 06:25:55','2023-03-24 06:25:55',0,NULL),
(228,145,3,10,'2023-03-24 06:25:55','2023-03-24 06:25:55',0,NULL),
(229,145,4,10,'2023-03-24 06:25:55','2023-03-24 06:25:55',0,NULL);

/*Table structure for table `exam_records` */

DROP TABLE IF EXISTS `exam_records`;

CREATE TABLE `exam_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `section_id` int(10) unsigned NOT NULL,
  `total` int(11) DEFAULT NULL,
  `ave` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class_ave` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `xy` int(10) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL,
  `af` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ps` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `p_comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `t_comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `flag` int(10) DEFAULT NULL,
  `is_upload` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=532 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `exam_records` */

insert  into `exam_records`(`id`,`exam_id`,`student_id`,`my_class_id`,`section_id`,`total`,`ave`,`class_ave`,`xy`,`pos`,`af`,`ps`,`p_comment`,`t_comment`,`year`,`created_at`,`updated_at`,`flag`,`is_upload`) values 
(526,145,162,74,24,NULL,NULL,NULL,0,20,'5','1','30',NULL,'2023','2023-03-24 06:27:29','2023-03-24 08:29:30',2,1),
(527,145,163,74,24,NULL,NULL,NULL,0,20,'5','1','30',NULL,'2023','2023-03-24 06:27:29','2023-03-24 08:29:30',2,1),
(528,145,162,74,23,NULL,NULL,NULL,0,2,'7','1','30',NULL,'2023','2023-03-24 08:28:17','2023-03-24 08:29:30',2,1),
(529,145,163,74,23,NULL,NULL,NULL,0,20,'7','1','30',NULL,'2023','2023-03-24 08:28:18','2023-03-24 08:29:30',2,1),
(530,145,162,74,27,NULL,NULL,NULL,0,20,'27','1','30',NULL,'2023','2023-03-24 08:28:35','2023-03-24 08:29:30',2,1),
(531,145,163,74,27,NULL,NULL,NULL,0,20,'27','1','30',NULL,'2023','2023-03-24 08:28:35','2023-03-24 08:29:30',2,1);

/*Table structure for table `exams` */

DROP TABLE IF EXISTS `exams`;

CREATE TABLE `exams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` tinyint(4) NOT NULL,
  `year` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `exams` */

insert  into `exams`(`id`,`type`,`name`,`term`,`year`,`created_at`,`updated_at`) values 
(145,'Ordinary_Exam','ZORAKI',1,'2023','2023-03-24 06:25:55','2023-03-24 06:25:55');

/*Table structure for table `forms` */

DROP TABLE IF EXISTS `forms`;

CREATE TABLE `forms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `forms` */

insert  into `forms`(`id`,`name`,`teacher_id`,`created_at`,`updated_at`) values 
(1,1,70,'2022-06-18 09:12:48','2023-03-21 08:06:51'),
(2,2,0,'2022-06-18 09:12:49','2023-03-23 15:05:15'),
(3,3,0,'2022-06-18 09:12:50','2023-03-06 13:37:03'),
(4,4,0,'2022-06-18 09:12:54','2023-03-06 13:37:04');

/*Table structure for table `grades` */

DROP TABLE IF EXISTS `grades`;

CREATE TABLE `grades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_type_id` int(10) unsigned DEFAULT NULL,
  `mark_from` tinyint(4) NOT NULL,
  `mark_to` tinyint(4) NOT NULL,
  `remark` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `grades_name_class_type_id_remark_unique` (`class_type_id`,`remark`,`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `grades` */

insert  into `grades`(`id`,`name`,`class_type_id`,`mark_from`,`mark_to`,`remark`,`created_at`,`updated_at`) values 
(1,'E',NULL,0,29,'1','2022-09-25 00:21:23','2022-11-22 23:20:52'),
(2,'D-',NULL,30,34,'2','2022-09-25 00:21:23','2022-11-22 23:20:52'),
(3,'D',NULL,35,39,'3','2022-09-25 00:21:23','2022-11-22 23:20:52'),
(4,'D+',NULL,40,44,'4','2022-09-25 00:21:23','2022-11-22 23:20:52'),
(5,'C-',NULL,45,49,'5','2022-09-25 00:21:23','2022-11-22 23:20:53'),
(6,'C',NULL,50,54,'6','2022-09-25 00:21:23','2022-11-22 23:20:53'),
(70,'C+',NULL,55,59,'7','2022-11-08 10:20:59','2022-11-22 23:20:53'),
(71,'B-',NULL,60,64,'8','2022-11-08 10:23:54','2022-11-22 23:20:53'),
(72,'B',NULL,65,69,'9','2022-11-08 10:23:54','2022-11-22 23:20:53'),
(91,'B+',NULL,70,74,'10','2022-11-21 08:05:02','2022-11-22 23:20:53'),
(92,'A-',NULL,75,79,'11','2022-11-22 23:21:56','2022-11-22 23:21:56'),
(93,'A',NULL,80,100,'12','2022-11-22 23:21:57','2022-11-22 23:21:57'),
(94,'E',26,0,29,'1','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(95,'D-',26,30,34,'2','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(96,'D',26,35,39,'3','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(97,'D+',26,40,44,'4','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(98,'C-',26,45,49,'5','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(99,'C',26,50,54,'6','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(100,'C+',26,55,59,'7','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(101,'B-',26,60,64,'8','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(102,'B',26,65,69,'9','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(103,'B+',26,70,74,'10','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(104,'A-',26,75,79,'11','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(105,'A',26,80,100,'12','2022-12-02 09:49:09','2022-12-02 09:49:09'),
(130,'E',29,0,29,'1','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(131,'D-',29,30,34,'2','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(132,'D',29,35,39,'3','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(133,'D+',29,40,44,'4','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(134,'C-',29,45,49,'5','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(135,'C',29,50,54,'6','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(136,'C+',29,55,59,'7','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(137,'B-',29,60,64,'8','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(138,'B',29,65,69,'9','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(139,'B+',29,70,74,'10','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(140,'A-',29,75,79,'11','2023-03-15 10:45:01','2023-03-15 10:45:01'),
(141,'A',29,80,100,'12','2023-03-15 10:45:01','2023-03-15 10:45:01');

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `groups` */

insert  into `groups`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Group11','2022-06-24 01:59:50','2022-10-11 10:29:12'),
(2,'Group22','2022-06-24 01:59:54','2023-01-17 07:50:32'),
(3,'Group3','2022-06-24 01:59:58','2022-06-24 22:23:53'),
(4,'Group4','2022-06-23 18:03:26','2022-06-24 22:23:54'),
(5,'Group5','2022-06-23 18:06:47','2022-06-24 22:23:55'),
(15,'test','2022-07-24 10:34:42','2022-07-24 10:34:42');

/*Table structure for table `lgas` */

DROP TABLE IF EXISTS `lgas`;

CREATE TABLE `lgas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `lgas_state_id_foreign` (`state_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=775 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `lgas` */

insert  into `lgas`(`id`,`state_id`,`name`,`created_at`,`updated_at`) values 
(1,1,'Aba North','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(2,1,'Aba South','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(3,1,'Arochukwu','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(4,1,'Bende','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(5,1,'Ikwuano','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(6,1,'Isiala Ngwa North','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(7,1,'Isiala Ngwa South','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(8,1,'Isuikwuato','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(9,1,'Obi Ngwa','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(10,1,'Ohafia','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(11,1,'Osisioma','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(12,1,'Ugwunagbo','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(13,1,'Ukwa East','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(14,1,'Ukwa West','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(15,1,'Umuahia North','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(16,1,'Umuahia South','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(17,1,'Umu Nneochi','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(18,2,'Demsa','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(19,2,'Fufure','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(20,2,'Ganye','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(21,2,'Gayuk','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(22,2,'Gombi','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(23,2,'Grie','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(24,2,'Hong','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(25,2,'Jada','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(26,2,'Larmurde','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(27,2,'Madagali','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(28,2,'Maiha','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(29,2,'Mayo Belwa','2022-06-17 00:38:23','2022-06-17 00:38:23'),
(30,2,'Michika','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(31,2,'Mubi North','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(32,2,'Mubi South','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(33,2,'Numan','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(34,2,'Shelleng','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(35,2,'Song','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(36,2,'Toungo','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(37,2,'Yola North','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(38,2,'Yola South','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(39,3,'Abak','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(40,3,'Eastern Obolo','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(41,3,'Eket','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(42,3,'Esit Eket','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(43,3,'Essien Udim','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(44,3,'Etim Ekpo','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(45,3,'Etinan','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(46,3,'Ibeno','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(47,3,'Ibesikpo Asutan','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(48,3,'Ibiono-Ibom','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(49,3,'Ika','2022-06-17 00:38:24','2022-06-17 00:38:24'),
(50,3,'Ikono','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(51,3,'Ikot Abasi','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(52,3,'Ikot Ekpene','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(53,3,'Ini','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(54,3,'Itu','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(55,3,'Mbo','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(56,3,'Mkpat-Enin','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(57,3,'Nsit-Atai','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(58,3,'Nsit-Ibom','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(59,3,'Nsit-Ubium','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(60,3,'Obot Akara','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(61,3,'Okobo','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(62,3,'Onna','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(63,3,'Oron','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(64,3,'Oruk Anam','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(65,3,'Udung-Uko','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(66,3,'Ukanafun','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(67,3,'Uruan','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(68,3,'Urue-Offong/Oruko','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(69,3,'Uyo','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(70,4,'Aguata','2022-06-17 00:38:25','2022-06-17 00:38:25'),
(71,4,'Anambra East','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(72,4,'Anambra West','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(73,4,'Anaocha','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(74,4,'Awka North','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(75,4,'Awka South','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(76,4,'Ayamelum','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(77,4,'Dunukofia','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(78,4,'Ekwusigo','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(79,4,'Idemili North','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(80,4,'Idemili South','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(81,4,'Ihiala','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(82,4,'Njikoka','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(83,4,'Nnewi North','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(84,4,'Nnewi South','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(85,4,'Ogbaru','2022-06-17 00:38:26','2022-06-17 00:38:26'),
(86,4,'Onitsha North','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(87,4,'Onitsha South','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(88,4,'Orumba North','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(89,4,'Orumba South','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(90,4,'Oyi','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(91,5,'Alkaleri','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(92,5,'Bauchi','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(93,5,'Bogoro','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(94,5,'Damban','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(95,5,'Darazo','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(96,5,'Dass','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(97,5,'Gamawa','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(98,5,'Ganjuwa','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(99,5,'Giade','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(100,5,'Itas/Gadau','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(101,5,'Jama\'are','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(102,5,'Katagum','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(103,5,'Kirfi','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(104,5,'Misau','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(105,5,'Ningi','2022-06-17 00:38:27','2022-06-17 00:38:27'),
(106,5,'Shira','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(107,5,'Tafawa Balewa','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(108,5,'Toro','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(109,5,'Warji','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(110,5,'Zaki','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(111,6,'Brass','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(112,6,'Ekeremor','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(113,6,'Kolokuma/Opokuma','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(114,6,'Nembe','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(115,6,'Ogbia','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(116,6,'Sagbama','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(117,6,'Southern Ijaw','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(118,6,'Yenagoa','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(119,7,'Agatu','2022-06-17 00:38:28','2022-06-17 00:38:28'),
(120,7,'Apa','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(121,7,'Ado','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(122,7,'Buruku','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(123,7,'Gboko','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(124,7,'Guma','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(125,7,'Gwer East','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(126,7,'Gwer West','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(127,7,'Katsina-Ala','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(128,7,'Konshisha','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(129,7,'Kwande','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(130,7,'Logo','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(131,7,'Makurdi','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(132,7,'Obi','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(133,7,'Ogbadibo','2022-06-17 00:38:29','2022-06-17 00:38:29'),
(134,7,'Ohimini','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(135,7,'Oju','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(136,7,'Okpokwu','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(137,7,'Oturkpo','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(138,7,'Tarka','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(139,7,'Ukum','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(140,7,'Ushongo','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(141,7,'Vandeikya','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(142,8,'Abadam','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(143,8,'Askira/Uba','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(144,8,'Bama','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(145,8,'Bayo','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(146,8,'Biu','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(147,8,'Chibok','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(148,8,'Damboa','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(149,8,'Dikwa','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(150,8,'Gubio','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(151,8,'Guzamala','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(152,8,'Gwoza','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(153,8,'Hawul','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(154,8,'Jere','2022-06-17 00:38:30','2022-06-17 00:38:30'),
(155,8,'Kaga','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(156,8,'Kala/Balge','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(157,8,'Konduga','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(158,8,'Kukawa','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(159,8,'Kwaya Kusar','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(160,8,'Mafa','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(161,8,'Magumeri','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(162,8,'Maiduguri','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(163,8,'Marte','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(164,8,'Mobbar','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(165,8,'Monguno','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(166,8,'Ngala','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(167,8,'Nganzai','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(168,8,'Shani','2022-06-17 00:38:31','2022-06-17 00:38:31'),
(169,9,'Abi','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(170,9,'Akamkpa','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(171,9,'Akpabuyo','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(172,9,'Bakassi','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(173,9,'Bekwarra','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(174,9,'Biase','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(175,9,'Boki','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(176,9,'Calabar Municipal','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(177,9,'Calabar South','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(178,9,'Etung','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(179,9,'Ikom','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(180,9,'Obanliku','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(181,9,'Obubra','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(182,9,'Obudu','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(183,9,'Odukpani','2022-06-17 00:38:32','2022-06-17 00:38:32'),
(184,9,'Ogoja','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(185,9,'Yakuur','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(186,9,'Yala','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(187,10,'Aniocha North','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(188,10,'Aniocha South','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(189,10,'Bomadi','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(190,10,'Burutu','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(191,10,'Ethiope East','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(192,10,'Ethiope West','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(193,10,'Ika North East','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(194,10,'Ika South','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(195,10,'Isoko North','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(196,10,'Isoko South','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(197,10,'Ndokwa East','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(198,10,'Ndokwa West','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(199,10,'Okpe','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(200,10,'Oshimili North','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(201,10,'Oshimili South','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(202,10,'Patani','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(203,10,'Sapele, Delta','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(204,10,'Udu','2022-06-17 00:38:33','2022-06-17 00:38:33'),
(205,10,'Ughelli North','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(206,10,'Ughelli South','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(207,10,'Ukwuani','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(208,10,'Uvwie','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(209,10,'Warri North','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(210,10,'Warri South','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(211,10,'Warri South West','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(212,11,'Abakaliki','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(213,11,'Afikpo North','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(214,11,'Afikpo South','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(215,11,'Ebonyi','2022-06-17 00:38:34','2022-06-17 00:38:34'),
(216,11,'Ezza North','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(217,11,'Ezza South','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(218,11,'Ikwo','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(219,11,'Ishielu','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(220,11,'Ivo','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(221,11,'Izzi','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(222,11,'Ohaozara','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(223,11,'Ohaukwu','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(224,11,'Onicha','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(225,12,'Akoko-Edo','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(226,12,'Egor','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(227,12,'Esan Central','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(228,12,'Esan North-East','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(229,12,'Esan South-East','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(230,12,'Esan West','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(231,12,'Etsako Central','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(232,12,'Etsako East','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(233,12,'Etsako West','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(234,12,'Igueben','2022-06-17 00:38:35','2022-06-17 00:38:35'),
(235,12,'Ikpoba Okha','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(236,12,'Orhionmwon','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(237,12,'Oredo','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(238,12,'Ovia North-East','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(239,12,'Ovia South-West','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(240,12,'Owan East','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(241,12,'Owan West','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(242,12,'Uhunmwonde','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(243,13,'Ado Ekiti','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(244,13,'Efon','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(245,13,'Ekiti East','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(246,13,'Ekiti South-West','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(247,13,'Ekiti West','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(248,13,'Emure','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(249,13,'Gbonyin','2022-06-17 00:38:36','2022-06-17 00:38:36'),
(250,13,'Ido Osi','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(251,13,'Ijero','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(252,13,'Ikere','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(253,13,'Ikole','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(254,13,'Ilejemeje','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(255,13,'Irepodun/Ifelodun','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(256,13,'Ise/Orun','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(257,13,'Moba','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(258,13,'Oye','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(259,14,'Aninri','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(260,14,'Awgu','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(261,14,'Enugu East','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(262,14,'Enugu North','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(263,14,'Enugu South','2022-06-17 00:38:37','2022-06-17 00:38:37'),
(264,14,'Ezeagu','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(265,14,'Igbo Etiti','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(266,14,'Igbo Eze North','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(267,14,'Igbo Eze South','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(268,14,'Isi Uzo','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(269,14,'Nkanu East','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(270,14,'Nkanu West','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(271,14,'Nsukka','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(272,14,'Oji River','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(273,14,'Udenu','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(274,14,'Udi','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(275,14,'Uzo Uwani','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(276,15,'Abaji','2022-06-17 00:38:38','2022-06-17 00:38:38'),
(277,15,'Bwari','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(278,15,'Gwagwalada','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(279,15,'Kuje','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(280,15,'Kwali','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(281,15,'Municipal Area Council','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(282,16,'Akko','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(283,16,'Balanga','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(284,16,'Billiri','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(285,16,'Dukku','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(286,16,'Funakaye','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(287,16,'Gombe','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(288,16,'Kaltungo','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(289,16,'Kwami','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(290,16,'Nafada','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(291,16,'Shongom','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(292,16,'Yamaltu/Deba','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(293,17,'Aboh Mbaise','2022-06-17 00:38:39','2022-06-17 00:38:39'),
(294,17,'Ahiazu Mbaise','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(295,17,'Ehime Mbano','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(296,17,'Ezinihitte','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(297,17,'Ideato North','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(298,17,'Ideato South','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(299,17,'Ihitte/Uboma','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(300,17,'Ikeduru','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(301,17,'Isiala Mbano','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(302,17,'Isu','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(303,17,'Mbaitoli','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(304,17,'Ngor Okpala','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(305,17,'Njaba','2022-06-17 00:38:40','2022-06-17 00:38:40'),
(306,17,'Nkwerre','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(307,17,'Nwangele','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(308,17,'Obowo','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(309,17,'Oguta','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(310,17,'Ohaji/Egbema','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(311,17,'Okigwe','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(312,17,'Orlu','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(313,17,'Orsu','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(314,17,'Oru East','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(315,17,'Oru West','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(316,17,'Owerri Municipal','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(317,17,'Owerri North','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(318,17,'Owerri West','2022-06-17 00:38:41','2022-06-17 00:38:41'),
(319,17,'Unuimo','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(320,18,'Auyo','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(321,18,'Babura','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(322,18,'Biriniwa','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(323,18,'Birnin Kudu','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(324,18,'Buji','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(325,18,'Dutse','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(326,18,'Gagarawa','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(327,18,'Garki','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(328,18,'Gumel','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(329,18,'Guri','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(330,18,'Gwaram','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(331,18,'Gwiwa','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(332,18,'Hadejia','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(333,18,'Jahun','2022-06-17 00:38:42','2022-06-17 00:38:42'),
(334,18,'Kafin Hausa','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(335,18,'Kazaure','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(336,18,'Kiri Kasama','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(337,18,'Kiyawa','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(338,18,'Kaugama','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(339,18,'Maigatari','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(340,18,'Malam Madori','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(341,18,'Miga','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(342,18,'Ringim','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(343,18,'Roni','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(344,18,'Sule Tankarkar','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(345,18,'Taura','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(346,18,'Yankwashi','2022-06-17 00:38:43','2022-06-17 00:38:43'),
(347,19,'Birnin Gwari','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(348,19,'Chikun','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(349,19,'Giwa','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(350,19,'Igabi','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(351,19,'Ikara','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(352,19,'Jaba','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(353,19,'Jema\'a','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(354,19,'Kachia','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(355,19,'Kaduna North','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(356,19,'Kaduna South','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(357,19,'Kagarko','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(358,19,'Kajuru','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(359,19,'Kaura','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(360,19,'Kauru','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(361,19,'Kubau','2022-06-17 00:38:44','2022-06-17 00:38:44'),
(362,19,'Kudan','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(363,19,'Lere','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(364,19,'Makarfi','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(365,19,'Sabon Gari','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(366,19,'Sanga','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(367,19,'Soba','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(368,19,'Zangon Kataf','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(369,19,'Zaria','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(370,20,'Ajingi','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(371,20,'Albasu','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(372,20,'Bagwai','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(373,20,'Bebeji','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(374,20,'Bichi','2022-06-17 00:38:45','2022-06-17 00:38:45'),
(375,20,'Bunkure','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(376,20,'Dala','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(377,20,'Dambatta','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(378,20,'Dawakin Kudu','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(379,20,'Dawakin Tofa','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(380,20,'Doguwa','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(381,20,'Fagge','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(382,20,'Gabasawa','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(383,20,'Garko','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(384,20,'Garun Mallam','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(385,20,'Gaya','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(386,20,'Gezawa','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(387,20,'Gwale','2022-06-17 00:38:46','2022-06-17 00:38:46'),
(388,20,'Gwarzo','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(389,20,'Kabo','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(390,20,'Kano Municipal','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(391,20,'Karaye','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(392,20,'Kibiya','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(393,20,'Kiru','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(394,20,'Kumbotso','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(395,20,'Kunchi','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(396,20,'Kura','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(397,20,'Madobi','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(398,20,'Makoda','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(399,20,'Minjibir','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(400,20,'Nasarawa','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(401,20,'Rano','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(402,20,'Rimin Gado','2022-06-17 00:38:47','2022-06-17 00:38:47'),
(403,20,'Rogo','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(404,20,'Shanono','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(405,20,'Sumaila','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(406,20,'Takai','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(407,20,'Tarauni','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(408,20,'Tofa','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(409,20,'Tsanyawa','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(410,20,'Tudun Wada','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(411,20,'Ungogo','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(412,20,'Warawa','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(413,20,'Wudil','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(414,21,'Bakori','2022-06-17 00:38:48','2022-06-17 00:38:48'),
(415,21,'Batagarawa','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(416,21,'Batsari','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(417,21,'Baure','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(418,21,'Bindawa','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(419,21,'Charanchi','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(420,21,'Dandume','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(421,21,'Danja','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(422,21,'Dan Musa','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(423,21,'Daura','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(424,21,'Dutsi','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(425,21,'Dutsin Ma','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(426,21,'Faskari','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(427,21,'Funtua','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(428,21,'Ingawa','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(429,21,'Jibia','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(430,21,'Kafur','2022-06-17 00:38:49','2022-06-17 00:38:49'),
(431,21,'Kaita','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(432,21,'Kankara','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(433,21,'Kankia','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(434,21,'Katsina','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(435,21,'Kurfi','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(436,21,'Kusada','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(437,21,'Mai\'Adua','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(438,21,'Malumfashi','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(439,21,'Mani','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(440,21,'Mashi','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(441,21,'Matazu','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(442,21,'Musawa','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(443,21,'Rimi','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(444,21,'Sabuwa','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(445,21,'Safana','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(446,21,'Sandamu','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(447,21,'Zango','2022-06-17 00:38:50','2022-06-17 00:38:50'),
(448,22,'Aleiro','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(449,22,'Arewa Dandi','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(450,22,'Argungu','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(451,22,'Augie','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(452,22,'Bagudo','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(453,22,'Birnin Kebbi','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(454,22,'Bunza','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(455,22,'Dandi','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(456,22,'Fakai','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(457,22,'Gwandu','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(458,22,'Jega','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(459,22,'Kalgo','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(460,22,'Koko/Besse','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(461,22,'Maiyama','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(462,22,'Ngaski','2022-06-17 00:38:51','2022-06-17 00:38:51'),
(463,22,'Sakaba','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(464,22,'Shanga','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(465,22,'Suru','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(466,22,'Wasagu/Danko','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(467,22,'Yauri','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(468,22,'Zuru','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(469,23,'Adavi','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(470,23,'Ajaokuta','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(471,23,'Ankpa','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(472,23,'Bassa','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(473,23,'Dekina','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(474,23,'Ibaji','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(475,23,'Idah','2022-06-17 00:38:52','2022-06-17 00:38:52'),
(476,23,'Igalamela Odolu','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(477,23,'Ijumu','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(478,23,'Kabba/Bunu','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(479,23,'Kogi','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(480,23,'Lokoja','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(481,23,'Mopa Muro','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(482,23,'Ofu','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(483,23,'Ogori/Magongo','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(484,23,'Okehi','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(485,23,'Okene','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(486,23,'Olamaboro','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(487,23,'Omala','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(488,23,'Yagba East','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(489,23,'Yagba West','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(490,24,'Asa','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(491,24,'Baruten','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(492,24,'Edu','2022-06-17 00:38:53','2022-06-17 00:38:53'),
(493,24,'Ekiti, Kwara State','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(494,24,'Ifelodun','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(495,24,'Ilorin East','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(496,24,'Ilorin South','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(497,24,'Ilorin West','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(498,24,'Irepodun','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(499,24,'Isin','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(500,24,'Kaiama','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(501,24,'Moro','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(502,24,'Offa','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(503,24,'Oke Ero','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(504,24,'Oyun','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(505,24,'Pategi','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(506,25,'Agege','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(507,25,'Ajeromi-Ifelodun','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(508,25,'Alimosho','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(509,25,'Amuwo-Odofin','2022-06-17 00:38:54','2022-06-17 00:38:54'),
(510,25,'Apapa','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(511,25,'Badagry','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(512,25,'Epe','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(513,25,'Eti Osa','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(514,25,'Ibeju-Lekki','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(515,25,'Ifako-Ijaiye','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(516,25,'Ikeja','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(517,25,'Ikorodu','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(518,25,'Kosofe','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(519,25,'Lagos Island','2022-06-17 00:38:55','2022-06-17 00:38:55'),
(520,25,'Lagos Mainland','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(521,25,'Mushin','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(522,25,'Ojo','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(523,25,'Oshodi-Isolo','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(524,25,'Shomolu','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(525,25,'Surulere, Lagos State','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(526,26,'Akwanga','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(527,26,'Awe','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(528,26,'Doma','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(529,26,'Karu','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(530,26,'Keana','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(531,26,'Keffi','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(532,26,'Kokona','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(533,26,'Lafia','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(534,26,'Nasarawa','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(535,26,'Nasarawa Egon','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(536,26,'Obi','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(537,26,'Toto','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(538,26,'Wamba','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(539,27,'Agaie','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(540,27,'Agwara','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(541,27,'Bida','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(542,27,'Borgu','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(543,27,'Bosso','2022-06-17 00:38:56','2022-06-17 00:38:56'),
(544,27,'Chanchaga','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(545,27,'Edati','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(546,27,'Gbako','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(547,27,'Gurara','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(548,27,'Katcha','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(549,27,'Kontagora','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(550,27,'Lapai','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(551,27,'Lavun','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(552,27,'Magama','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(553,27,'Mariga','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(554,27,'Mashegu','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(555,27,'Mokwa','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(556,27,'Moya','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(557,27,'Paikoro','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(558,27,'Rafi','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(559,27,'Rijau','2022-06-17 00:38:57','2022-06-17 00:38:57'),
(560,27,'Shiroro','2022-06-17 00:38:58','2022-06-17 00:38:58'),
(561,27,'Suleja','2022-06-17 00:38:58','2022-06-17 00:38:58'),
(562,27,'Tafa','2022-06-17 00:38:58','2022-06-17 00:38:58'),
(563,27,'Wushishi','2022-06-17 00:38:58','2022-06-17 00:38:58'),
(564,28,'Abeokuta North','2022-06-17 00:38:58','2022-06-17 00:38:58'),
(565,28,'Abeokuta South','2022-06-17 00:38:58','2022-06-17 00:38:58'),
(566,28,'Ado-Odo/Ota','2022-06-17 00:38:58','2022-06-17 00:38:58'),
(567,28,'Egbado North','2022-06-17 00:38:58','2022-06-17 00:38:58'),
(568,28,'Egbado South','2022-06-17 00:38:58','2022-06-17 00:38:58'),
(569,28,'Ewekoro','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(570,28,'Ifo','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(571,28,'Ijebu East','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(572,28,'Ijebu North','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(573,28,'Ijebu North East','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(574,28,'Ijebu Ode','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(575,28,'Ikenne','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(576,28,'Imeko Afon','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(577,28,'Ipokia','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(578,28,'Obafemi Owode','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(579,28,'Odeda','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(580,28,'Odogbolu','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(581,28,'Ogun Waterside','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(582,28,'Remo North','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(583,28,'Shagamu','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(584,29,'Akoko North-East','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(585,29,'Akoko North-West','2022-06-17 00:38:59','2022-06-17 00:38:59'),
(586,29,'Akoko South-West','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(587,29,'Akoko South-East','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(588,29,'Akure North','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(589,29,'Akure South','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(590,29,'Ese Odo','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(591,29,'Idanre','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(592,29,'Ifedore','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(593,29,'Ilaje','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(594,29,'Ile Oluji/Okeigbo','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(595,29,'Irele','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(596,29,'Odigbo','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(597,29,'Okitipupa','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(598,29,'Ondo East','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(599,29,'Ondo West','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(600,29,'Ose','2022-06-17 00:39:00','2022-06-17 00:39:00'),
(601,29,'Owo','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(602,30,'Atakunmosa East','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(603,30,'Atakunmosa West','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(604,30,'Aiyedaade','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(605,30,'Aiyedire','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(606,30,'Boluwaduro','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(607,30,'Boripe','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(608,30,'Ede North','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(609,30,'Ede South','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(610,30,'Ife Central','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(611,30,'Ife East','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(612,30,'Ife North','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(613,30,'Ife South','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(614,30,'Egbedore','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(615,30,'Ejigbo','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(616,30,'Ifedayo','2022-06-17 00:39:01','2022-06-17 00:39:01'),
(617,30,'Ifelodun','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(618,30,'Ila','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(619,30,'Ilesa East','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(620,30,'Ilesa West','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(621,30,'Irepodun','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(622,30,'Irewole','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(623,30,'Isokan','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(624,30,'Iwo','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(625,30,'Obokun','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(626,30,'Odo Otin','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(627,30,'Ola Oluwa','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(628,30,'Olorunda','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(629,30,'Oriade','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(630,30,'Orolu','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(631,30,'Osogbo','2022-06-17 00:39:02','2022-06-17 00:39:02'),
(632,31,'Afijio','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(633,31,'Akinyele','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(634,31,'Atiba','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(635,31,'Atisbo','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(636,31,'Egbeda','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(637,31,'Ibadan North','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(638,31,'Ibadan North-East','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(639,31,'Ibadan North-West','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(640,31,'Ibadan South-East','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(641,31,'Ibadan South-West','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(642,31,'Ibarapa Central','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(643,31,'Ibarapa East','2022-06-17 00:39:03','2022-06-17 00:39:03'),
(644,31,'Ibarapa North','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(645,31,'Ido','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(646,31,'Irepo','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(647,31,'Iseyin','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(648,31,'Itesiwaju','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(649,31,'Iwajowa','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(650,31,'Kajola','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(651,31,'Lagelu','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(652,31,'Ogbomosho North','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(653,31,'Ogbomosho South','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(654,31,'Ogo Oluwa','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(655,31,'Olorunsogo','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(656,31,'Oluyole','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(657,31,'Ona Ara','2022-06-17 00:39:04','2022-06-17 00:39:04'),
(658,31,'Orelope','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(659,31,'Ori Ire','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(660,31,'Oyo','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(661,31,'Oyo East','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(662,31,'Saki East','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(663,31,'Saki West','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(664,31,'Surulere, Oyo State','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(665,32,'Bokkos','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(666,32,'Barkin Ladi','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(667,32,'Bassa','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(668,32,'Jos East','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(669,32,'Jos North','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(670,32,'Jos South','2022-06-17 00:39:05','2022-06-17 00:39:05'),
(671,32,'Kanam','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(672,32,'Kanke','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(673,32,'Langtang South','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(674,32,'Langtang North','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(675,32,'Mangu','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(676,32,'Mikang','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(677,32,'Pankshin','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(678,32,'Qua\'an Pan','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(679,32,'Riyom','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(680,32,'Shendam','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(681,32,'Wase','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(682,33,'Abua/Odual','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(683,33,'Ahoada East','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(684,33,'Ahoada West','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(685,33,'Akuku-Toru','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(686,33,'Andoni','2022-06-17 00:39:06','2022-06-17 00:39:06'),
(687,33,'Asari-Toru','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(688,33,'Bonny','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(689,33,'Degema','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(690,33,'Eleme','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(691,33,'Emuoha','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(692,33,'Etche','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(693,33,'Gokana','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(694,33,'Ikwerre','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(695,33,'Khana','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(696,33,'Obio/Akpor','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(697,33,'Ogba/Egbema/Ndoni','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(698,33,'Ogu/Bolo','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(699,33,'Okrika','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(700,33,'Omuma','2022-06-17 00:39:07','2022-06-17 00:39:07'),
(701,33,'Opobo/Nkoro','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(702,33,'Oyigbo','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(703,33,'Port Harcourt','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(704,33,'Tai','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(705,34,'Binji','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(706,34,'Bodinga','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(707,34,'Dange Shuni','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(708,34,'Gada','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(709,34,'Goronyo','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(710,34,'Gudu','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(711,34,'Gwadabawa','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(712,34,'Illela','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(713,34,'Isa','2022-06-17 00:39:08','2022-06-17 00:39:08'),
(714,34,'Kebbe','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(715,34,'Kware','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(716,34,'Rabah','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(717,34,'Sabon Birni','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(718,34,'Shagari','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(719,34,'Silame','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(720,34,'Sokoto North','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(721,34,'Sokoto South','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(722,34,'Tambuwal','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(723,34,'Tangaza','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(724,34,'Tureta','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(725,34,'Wamako','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(726,34,'Wurno','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(727,34,'Yabo','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(728,35,'Ardo Kola','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(729,35,'Bali','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(730,35,'Donga','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(731,35,'Gashaka','2022-06-17 00:39:09','2022-06-17 00:39:09'),
(732,35,'Gassol','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(733,35,'Ibi','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(734,35,'Jalingo','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(735,35,'Karim Lamido','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(736,35,'Kumi','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(737,35,'Lau','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(738,35,'Sardauna','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(739,35,'Takum','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(740,35,'Ussa','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(741,35,'Wukari','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(742,35,'Yorro','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(743,35,'Zing','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(744,36,'Bade','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(745,36,'Bursari','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(746,36,'Damaturu','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(747,36,'Fika','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(748,36,'Fune','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(749,36,'Geidam','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(750,36,'Gujba','2022-06-17 00:39:10','2022-06-17 00:39:10'),
(751,36,'Gulani','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(752,36,'Jakusko','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(753,36,'Karasuwa','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(754,36,'Machina','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(755,36,'Nangere','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(756,36,'Nguru','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(757,36,'Potiskum','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(758,36,'Tarmuwa','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(759,36,'Yunusari','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(760,36,'Yusufari','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(761,37,'Anka','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(762,37,'Bakura','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(763,37,'Birnin Magaji/Kiyaw','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(764,37,'Bukkuyum','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(765,37,'Bungudu','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(766,37,'Gummi','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(767,37,'Gusau','2022-06-17 00:39:11','2022-06-17 00:39:11'),
(768,37,'Kaura Namoda','2022-06-17 00:39:12','2022-06-17 00:39:12'),
(769,37,'Maradun','2022-06-17 00:39:12','2022-06-17 00:39:12'),
(770,37,'Maru','2022-06-17 00:39:12','2022-06-17 00:39:12'),
(771,37,'Shinkafi','2022-06-17 00:39:12','2022-06-17 00:39:12'),
(772,37,'Talata Mafara','2022-06-17 00:39:12','2022-06-17 00:39:12'),
(773,37,'Chafe','2022-06-17 00:39:12','2022-06-17 00:39:12'),
(774,37,'Zurmi','2022-06-17 00:39:12','2022-06-17 00:39:12');

/*Table structure for table `marks` */

DROP TABLE IF EXISTS `marks`;

CREATE TABLE `marks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `subject_id` int(10) unsigned NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `section_id` int(10) unsigned NOT NULL,
  `exam_id` int(10) unsigned NOT NULL,
  `t1` int(11) DEFAULT NULL,
  `t2` int(11) DEFAULT NULL,
  `t3` int(11) DEFAULT NULL,
  `t4` int(11) DEFAULT NULL,
  `tca` int(11) DEFAULT NULL,
  `exm` int(11) DEFAULT NULL,
  `tex1` int(11) DEFAULT NULL,
  `tex2` int(11) DEFAULT NULL,
  `tex3` int(11) DEFAULT NULL,
  `sub_pos` tinyint(4) DEFAULT NULL,
  `cum` int(11) DEFAULT NULL,
  `cum_ave` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_id` int(10) unsigned DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `marks_student_id_foreign` (`student_id`) USING BTREE,
  KEY `marks_my_class_id_foreign` (`my_class_id`) USING BTREE,
  KEY `marks_section_id_foreign` (`section_id`) USING BTREE,
  KEY `marks_subject_id_foreign` (`subject_id`) USING BTREE,
  KEY `marks_exam_id_foreign` (`exam_id`) USING BTREE,
  KEY `marks_grade_id_foreign` (`grade_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `marks` */

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL,
  `message_type` int(11) NOT NULL,
  `receiver_type` int(11) NOT NULL,
  `receiver` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `state` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `messages` */

insert  into `messages`(`id`,`sender_id`,`message_type`,`receiver_type`,`receiver`,`subject`,`content`,`created_at`,`updated_at`,`state`) values 
(14,1,1,11,'+254203570095,+254729891801, +254715223003','Meetting','testvvvvvvvvvvvvvvvvvvvvv','2022-08-16 05:58:20','2022-08-16 05:58:20',1),
(20,1,1,22,'+254784714863','Meetting','qqq','2022-08-16 15:16:47','2022-12-29 23:14:31',1),
(21,1,1,23,'+254784714863,+4 444 444 1234,+4 444 444 1234,123','Meetting','a','2022-08-16 15:51:50','2022-08-16 15:51:50',1),
(22,1,1,23,'+254784714863,+4 444 444 1234,+4 444 444 1234,123','Meetting','aa','2022-08-16 15:52:18','2022-08-16 15:52:18',1),
(23,1,1,21,'+254784714863,+4 444 444 1234,444444412341234,+4 444 444 1234,123','Test','aaa','2022-08-16 18:13:09','2022-08-16 18:13:09',1),
(25,1,1,33,'1234566','Meetting','test','2022-08-16 18:22:21','2022-08-16 18:22:21',0),
(26,1,1,33,'1234566','Meetting','aaaaaaaaaaaaaaaaaaa','2022-08-16 18:24:00','2022-08-16 18:24:00',0),
(27,1,1,43,'1234566,123,1234566,123,123','Test','ssss','2022-08-16 18:31:41','2022-08-16 18:31:41',1),
(71,1,1,61,'123456.456789.','test','test','2022-08-24 07:51:18','2022-08-24 07:51:18',1),
(75,1,1,22,'+254715223003','Meetting','heyaaaaaaaaaa','2022-08-24 08:05:13','2022-08-24 08:05:13',0),
(76,1,1,61,'+254715223003.+254784714863.','Test','heloo people','2022-08-24 08:12:12','2022-08-24 08:12:12',1),
(77,1,1,22,'+254715223003','All Every body','heloo teacher','2022-08-24 08:14:16','2022-08-24 08:14:16',0),
(78,2,1,22,'+254715223003','Metting','heyyyy.....','2022-08-24 18:35:19','2022-08-24 18:35:19',0),
(79,2,1,22,'+254715223003,123','testing','heloooo zs','2022-08-24 18:36:56','2022-08-24 18:36:56',1),
(80,2,1,32,'+254745718810,+254715223003','test','heloo BOM/PA','2022-08-24 18:38:57','2022-08-24 18:38:57',1),
(81,2,1,42,'+254715223003,+254745718810','Metting','HELOO STAFF','2022-08-24 18:41:07','2022-08-24 18:41:07',1),
(82,2,1,61,'0715223003.','test','HELOO OTHERS','2022-08-24 18:41:58','2022-08-24 18:41:58',0),
(83,1,1,61,'0784714863','Meetting','heloooooooooooooooooooo','2022-08-31 06:04:14','2022-12-29 23:14:31',1);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2013_09_20_121733_create_blood_groups_table',1),
(2,'2013_09_22_124750_create_states_table',1),
(3,'2013_09_22_124806_create_lgas_table',1),
(4,'2013_09_26_121148_create_nationalities_table',1),
(5,'2014_10_12_000000_create_users_table',1),
(6,'2014_10_12_100000_create_password_resets_table',1),
(7,'2018_09_20_100249_create_user_types_table',1),
(9,'2018_09_22_073005_create_my_classes_table',1),
(10,'2018_09_22_073526_create_sections_table',1),
(11,'2018_09_22_080555_create_settings_table',1),
(12,'2018_09_22_081302_create_subjects_table',1),
(13,'2018_09_22_151514_create_student_records_table',1),
(14,'2018_09_26_124241_create_dorms_table',1),
(16,'2018_10_06_224846_create_marks_table',1),
(17,'2018_10_06_224944_create_grades_table',1),
(18,'2018_10_06_225007_create_pins_table',1),
(19,'2018_10_18_205550_create_skills_table',1),
(21,'2018_10_31_191358_create_books_table',1),
(22,'2018_10_31_192540_create_book_requests_table',1),
(23,'2018_11_01_132115_create_staff_records_table',1),
(24,'2018_11_03_210758_create_payments_table',1),
(25,'2018_11_03_210817_create_payment_records_table',1),
(26,'2018_11_06_083707_create_receipts_table',1),
(27,'2018_11_27_180401_create_time_tables_table',1),
(28,'2019_09_22_142514_create_fks',1),
(29,'2019_09_26_132227_create_promotions_table',1),
(30,'2022_06_17_152725_create_forms_table',2),
(31,'2022_06_17_152912_create_forms_table',3),
(32,'2022_06_17_163441_create_my_classes_table',4),
(33,'2022_06_17_174543_create_subjects_table',5),
(34,'2022_06_17_175033_create_subject_types_table',6),
(35,'2022_06_18_103111_class_subjects',7),
(36,'2022_06_18_103509_create_class_subjects_table',8),
(38,'2022_06_18_130849_create_forms_table',10),
(39,'2022_06_22_122729_create_subject_teachers_table',11),
(43,'2022_06_23_140102_create_student_subjects_table',12),
(44,'2022_06_23_150108_create_students_table',12),
(45,'2022_06_18_125242_create_teachers_table',13),
(46,'2022_06_23_222747_create_groups_table',14),
(47,'2022_06_28_015022_create_residences_table',15),
(48,'2022_06_29_005414_create_test_excels_table',16),
(49,'2022_06_29_033414_create_student_temps_table',17),
(51,'2018_10_04_224910_create_exams_table',18),
(52,'2018_10_18_205842_create_exam_records_table',18),
(53,'2022_07_06_043323_create_exam_forms_table',19),
(54,'2022_07_21_080945_create_calevents_table',20),
(55,'2022_07_21_094806_create_sitecomments_table',20),
(56,'2022_07_23_234435_add_column_to_staff_records',21),
(57,'2022_07_25_082532_create_bom_pa_records_table',22),
(58,'2022_07_29_053502_create_messages_table',23),
(59,'2018_09_20_150906_create_class_types_table',24),
(63,'2022_09_29_041339_add_column_to_class_subjects_table',25),
(64,'2022_09_29_041339_add_column_to_subjects_table',26),
(65,'2022_10_03_121016_add_column_to_exam_forms_table',27),
(66,'2022_10_06_063900_create_contacts_table',28),
(67,'2022_12_24_122544_add_column_to_users_table',29),
(68,'2022_12_24_214306_create_schools_table',30),
(69,'2022_12_24_215223_add_column_to_schools_table',31),
(70,'2022_12_24_222148_add_column_to_users_table',32),
(71,'2022_12_26_190824_add_column_to_messages_table',33),
(72,'2022_12_29_225427_add_column_to_users_table',34),
(74,'2023_01_05_114501_change_field_to_users_table',35),
(76,'2023_01_09_064704_change_field_to_bompa_table',36),
(77,'2023_01_09_073457_change_field_to_staff_table',37),
(78,'2023_01_09_083610_change_field_to_teacher_table',38);

/*Table structure for table `my_classes` */

DROP TABLE IF EXISTS `my_classes`;

CREATE TABLE `my_classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(11) DEFAULT NULL,
  `stream` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `my_classes` */

insert  into `my_classes`(`id`,`form_id`,`stream`,`teacher_id`,`created_at`,`updated_at`) values 
(74,1,'west',72,'2023-03-21 07:53:41','2023-03-23 15:46:00'),
(75,2,'first',71,'2023-03-21 07:53:58','2023-03-21 08:07:27'),
(76,1,'east',70,'2023-03-21 07:54:07','2023-03-21 07:58:47');

/*Table structure for table `nationalities` */

DROP TABLE IF EXISTS `nationalities`;

CREATE TABLE `nationalities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `nationalities` */

insert  into `nationalities`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Afghan','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(2,'Albanian','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(3,'Algerian','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(4,'American','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(5,'Andorran','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(6,'Angolan','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(7,'Antiguans','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(8,'Argentinean','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(9,'Armenian','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(10,'Australian','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(11,'Austrian','2022-06-17 00:38:09','2022-06-17 00:38:09'),
(12,'Azerbaijani','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(13,'Bahamian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(14,'Bahraini','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(15,'Bangladeshi','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(16,'Barbadian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(17,'Barbudans','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(18,'Batswana','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(19,'Belarusian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(20,'Belgian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(21,'Belizean','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(22,'Beninese','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(23,'Bhutanese','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(24,'Bolivian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(25,'Bosnian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(26,'Brazilian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(27,'British','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(28,'Bruneian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(29,'Bulgarian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(30,'Burkinabe','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(31,'Burmese','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(32,'Burundian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(33,'Cambodian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(34,'Cameroonian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(35,'Canadian','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(36,'Cape Verdean','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(37,'Central African','2022-06-17 00:38:10','2022-06-17 00:38:10'),
(38,'Chadian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(39,'Chilean','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(40,'Chinese','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(41,'Colombian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(42,'Comoran','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(43,'Congolese','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(44,'Costa Rican','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(45,'Croatian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(46,'Cuban','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(47,'Cypriot','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(48,'Czech','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(49,'Danish','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(50,'Djibouti','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(51,'Dominican','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(52,'Dutch','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(53,'East Timorese','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(54,'Ecuadorean','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(55,'Egyptian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(56,'Emirian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(57,'Equatorial Guinean','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(58,'Eritrean','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(59,'Estonian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(60,'Ethiopian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(61,'Fijian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(62,'Filipino','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(63,'Finnish','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(64,'French','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(65,'Gabonese','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(66,'Gambian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(67,'Georgian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(68,'German','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(69,'Ghanaian','2022-06-17 00:38:11','2022-06-17 00:38:11'),
(70,'Greek','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(71,'Grenadian','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(72,'Guatemalan','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(73,'Guinea-Bissauan','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(74,'Guinean','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(75,'Guyanese','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(76,'Haitian','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(77,'Herzegovinian','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(78,'Honduran','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(79,'Hungarian','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(80,'I-Kiribati','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(81,'Icelander','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(82,'Indian','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(83,'Indonesian','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(84,'Iranian','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(85,'Iraqi','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(86,'Irish','2022-06-17 00:38:12','2022-06-17 00:38:12'),
(87,'Israeli','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(88,'Italian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(89,'Ivorian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(90,'Jamaican','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(91,'Japanese','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(92,'Jordanian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(93,'Kazakhstani','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(94,'Kenyan','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(95,'Kittian and Nevisian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(96,'Kuwaiti','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(97,'Kyrgyz','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(98,'Laotian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(99,'Latvian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(100,'Lebanese','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(101,'Liberian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(102,'Libyan','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(103,'Liechtensteiner','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(104,'Lithuanian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(105,'Luxembourger','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(106,'Macedonian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(107,'Malagasy','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(108,'Malawian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(109,'Malaysian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(110,'Maldivan','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(111,'Malian','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(112,'Maltese','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(113,'Marshallese','2022-06-17 00:38:13','2022-06-17 00:38:13'),
(114,'Mauritanian','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(115,'Mauritian','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(116,'Mexican','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(117,'Micronesian','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(118,'Moldovan','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(119,'Monacan','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(120,'Mongolian','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(121,'Moroccan','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(122,'Mosotho','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(123,'Motswana','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(124,'Mozambican','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(125,'Namibian','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(126,'Nauruan','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(127,'Nepalese','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(128,'New Zealander','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(129,'Nicaraguan','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(130,'Nigerian','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(131,'Nigerien','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(132,'North Korean','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(133,'Northern Irish','2022-06-17 00:38:14','2022-06-17 00:38:14'),
(134,'Norwegian','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(135,'Omani','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(136,'Pakistani','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(137,'Palauan','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(138,'Panamanian','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(139,'Papua New Guinean','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(140,'Paraguayan','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(141,'Peruvian','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(142,'Polish','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(143,'Portuguese','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(144,'Qatari','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(145,'Romanian','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(146,'Russian','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(147,'Rwandan','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(148,'Saint Lucian','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(149,'Salvadoran','2022-06-17 00:38:15','2022-06-17 00:38:15'),
(150,'Samoan','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(151,'San Marinese','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(152,'Sao Tomean','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(153,'Saudi','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(154,'Scottish','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(155,'Senegalese','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(156,'Serbian','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(157,'Seychellois','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(158,'Sierra Leonean','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(159,'Singaporean','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(160,'Slovakian','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(161,'Slovenian','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(162,'Solomon Islander','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(163,'Somali','2022-06-17 00:38:16','2022-06-17 00:38:16'),
(164,'South African','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(165,'South Korean','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(166,'Spanish','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(167,'Sri Lankan','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(168,'Sudanese','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(169,'Surinamer','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(170,'Swazi','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(171,'Swedish','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(172,'Swiss','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(173,'Syrian','2022-06-17 00:38:17','2022-06-17 00:38:17'),
(174,'Taiwanese','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(175,'Tajik','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(176,'Tanzanian','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(177,'Thai','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(178,'Togolese','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(179,'Tongan','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(180,'Trinidadian/Tobagonian','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(181,'Tunisian','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(182,'Turkish','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(183,'Tuvaluan','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(184,'Ugandan','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(185,'Ukrainian','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(186,'Uruguayan','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(187,'Uzbekistani','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(188,'Venezuelan','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(189,'Vietnamese','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(190,'Welsh','2022-06-17 00:38:18','2022-06-17 00:38:18'),
(191,'Yemenite','2022-06-17 00:38:19','2022-06-17 00:38:19'),
(192,'Zambian','2022-06-17 00:38:19','2022-06-17 00:38:19'),
(193,'Zimbabwean','2022-06-17 00:38:19','2022-06-17 00:38:19');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `password_resets` */

insert  into `password_resets`(`email`,`token`,`created_at`) values 
('cj@cj.com','$2y$10$dx/vso7rGF5uqqgwOEf23ei/XQ8FzYNkYzbLrfkDQm4avyjKR6.BO','2022-10-11 13:37:10');

/*Table structure for table `payment_records` */

DROP TABLE IF EXISTS `payment_records`;

CREATE TABLE `payment_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `ref_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amt_paid` int(11) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT 0,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `payment_records_ref_no_unique` (`ref_no`) USING BTREE,
  KEY `payment_records_payment_id_foreign` (`payment_id`) USING BTREE,
  KEY `payment_records_student_id_foreign` (`student_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `payment_records` */

/*Table structure for table `payments` */

DROP TABLE IF EXISTS `payments`;

CREATE TABLE `payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `ref_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `my_class_id` int(10) unsigned DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `payments_ref_no_unique` (`ref_no`) USING BTREE,
  KEY `payments_my_class_id_foreign` (`my_class_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `payments` */

/*Table structure for table `pins` */

DROP TABLE IF EXISTS `pins`;

CREATE TABLE `pins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `used` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `times_used` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned DEFAULT NULL,
  `student_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `pins_code_unique` (`code`) USING BTREE,
  KEY `pins_user_id_foreign` (`user_id`) USING BTREE,
  KEY `pins_student_id_foreign` (`student_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `pins` */

/*Table structure for table `promotions` */

DROP TABLE IF EXISTS `promotions`;

CREATE TABLE `promotions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `from_class` int(10) unsigned NOT NULL,
  `from_section` int(10) unsigned NOT NULL,
  `to_class` int(10) unsigned NOT NULL,
  `to_section` int(10) unsigned NOT NULL,
  `grad` tinyint(4) NOT NULL,
  `from_session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_session` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `promotions_student_id_foreign` (`student_id`) USING BTREE,
  KEY `promotions_from_class_foreign` (`from_class`) USING BTREE,
  KEY `promotions_from_section_foreign` (`from_section`) USING BTREE,
  KEY `promotions_to_section_foreign` (`to_section`) USING BTREE,
  KEY `promotions_to_class_foreign` (`to_class`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `promotions` */

/*Table structure for table `receipts` */

DROP TABLE IF EXISTS `receipts`;

CREATE TABLE `receipts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pr_id` int(10) unsigned NOT NULL,
  `amt_paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `receipts_pr_id_foreign` (`pr_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `receipts` */

/*Table structure for table `report3` */

DROP TABLE IF EXISTS `report3`;

CREATE TABLE `report3` (
  `ComputerDepartmentID` int(11) DEFAULT NULL,
  `ComputerType` varchar(255) DEFAULT NULL,
  `EXPIRATION` date DEFAULT NULL,
  `CerNumber` int(11) DEFAULT NULL,
  `CustomerNumber` int(11) DEFAULT NULL,
  `Office` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `report3` */

/*Table structure for table `residences` */

DROP TABLE IF EXISTS `residences`;

CREATE TABLE `residences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `residences` */

insert  into `residences`(`id`,`name`,`created_at`,`updated_at`) values 
(19,'hi','2022-06-28 03:27:33','2022-06-28 03:27:33'),
(20,'who1','2022-06-28 03:27:33','2022-06-28 03:27:33'),
(21,'who4','2022-06-28 03:27:33','2022-06-28 03:27:33'),
(22,'woh','2022-06-28 03:27:33','2022-06-28 03:27:33'),
(23,'res1','2022-06-28 03:27:33','2022-06-28 03:27:33');

/*Table structure for table `schools` */

DROP TABLE IF EXISTS `schools`;

CREATE TABLE `schools` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `head_id` int(10) unsigned DEFAULT NULL,
  `title_id` int(10) unsigned DEFAULT NULL,
  `hod_id` int(10) unsigned DEFAULT NULL,
  `postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender_id` int(10) unsigned DEFAULT NULL,
  `status_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `schools_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `schools` */

/*Table structure for table `sections` */

DROP TABLE IF EXISTS `sections`;

CREATE TABLE `sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `teacher_id` int(10) unsigned DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `sections_name_my_class_id_unique` (`name`,`my_class_id`) USING BTREE,
  KEY `sections_my_class_id_foreign` (`my_class_id`) USING BTREE,
  KEY `sections_teacher_id_foreign` (`teacher_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `sections` */

insert  into `sections`(`id`,`name`,`my_class_id`,`teacher_id`,`active`,`created_at`,`updated_at`) values 
(20,'Paper1',50,3,0,'2022-10-03 03:24:53','2022-10-03 03:24:53'),
(21,'Paper2',50,3,0,'2022-10-03 03:32:24','2022-10-03 03:32:24'),
(22,'Paper3',50,2,0,'2022-11-17 06:13:41','2022-11-17 06:13:41'),
(23,'Paper7',63,59,0,'2023-03-09 06:16:33','2023-03-09 06:16:33'),
(24,'Paper5',63,59,0,'2023-03-09 10:15:28','2023-03-09 10:15:28'),
(25,'Paper6',70,68,0,'2023-03-16 19:06:50','2023-03-16 19:06:50'),
(26,'Paper8',70,68,0,'2023-03-16 19:07:16','2023-03-16 19:07:16'),
(27,'Paper27',74,72,0,'2023-03-22 11:39:26','2023-03-22 11:39:26');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `settings` */

insert  into `settings`(`id`,`type`,`description`,`created_at`,`updated_at`) values 
(1,'current_session','2018-2019',NULL,'2022-12-21 07:24:05'),
(2,'system_title','CJIA',NULL,'2022-12-21 07:24:05'),
(3,'system_name','School Management System',NULL,'2022-12-21 07:24:05'),
(4,'term_ends','07/10/2018',NULL,'2022-12-21 07:24:06'),
(5,'term_begins','7/10/2018',NULL,'2022-12-21 07:24:06'),
(6,'phone','0123456789',NULL,'2022-12-21 07:24:05'),
(7,'address','18B North Central Park, Behind Central Square Tourist Center',NULL,'2022-12-21 07:24:06'),
(8,'system_email','cjacademy@cj.com',NULL,'2022-12-21 07:24:06'),
(9,'alt_email','',NULL,NULL),
(10,'email_host','',NULL,NULL),
(11,'email_pass','',NULL,NULL),
(12,'lock_exam','0',NULL,'2022-12-21 07:24:06'),
(13,'logo','http://127.0.0.1:8000/storage/uploads/logo.png',NULL,'2022-12-21 07:24:06'),
(14,'next_term_fees_j','20000',NULL,'2022-06-17 13:21:49'),
(15,'next_term_fees_pn','25000',NULL,'2022-06-17 13:21:49'),
(16,'next_term_fees_p','25000',NULL,'2022-06-17 13:21:49'),
(17,'next_term_fees_n','25600',NULL,'2022-06-17 13:21:49'),
(18,'next_term_fees_s','15600',NULL,'2022-06-17 13:21:49'),
(19,'next_term_fees_c','1600',NULL,'2022-06-17 13:21:49');

/*Table structure for table `sitecomments` */

DROP TABLE IF EXISTS `sitecomments`;

CREATE TABLE `sitecomments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `sitecomments` */

insert  into `sitecomments`(`id`,`user_id`,`content`,`created_at`,`updated_at`) values 
(1,1,'qwerasdf','2022-07-20 20:54:32','2022-07-20 20:54:32'),
(2,1,'qwerasdf','2022-07-20 20:56:21','2022-07-20 20:56:21'),
(3,1,'qwerasdf','2022-07-20 20:56:45','2022-07-20 20:56:45'),
(4,1,'qwerasdf','2022-07-20 20:56:47','2022-07-20 20:56:47'),
(5,1,'qwerasdf','2022-07-20 20:58:03','2022-07-20 20:58:03'),
(6,1,'qwerasdf','2022-07-20 20:58:04','2022-07-20 20:58:04'),
(7,1,'qwerasdf','2022-07-20 20:58:05','2022-07-20 20:58:05'),
(8,1,'qwerasdf','2022-07-20 20:58:05','2022-07-20 20:58:05'),
(9,1,'qwerasdf','2022-07-20 20:58:05','2022-07-20 20:58:05'),
(10,1,'qwerasdf','2022-07-20 20:58:05','2022-07-20 20:58:05'),
(11,1,'qwerasdf','2022-07-20 20:58:06','2022-07-20 20:58:06'),
(12,1,'qwerasdf','2022-07-20 20:58:58','2022-07-20 20:58:58'),
(13,1,'qwerasdf','2022-07-20 20:59:47','2022-07-20 20:59:47'),
(14,1,'I like this site.','2022-07-20 21:02:20','2022-07-20 21:02:20');

/*Table structure for table `skills` */

DROP TABLE IF EXISTS `skills`;

CREATE TABLE `skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skill_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `skills` */

insert  into `skills`(`id`,`name`,`skill_type`,`class_type`,`created_at`,`updated_at`) values 
(1,'PUNCTUALITY','AF',NULL,NULL,NULL),
(2,'NEATNESS','AF',NULL,NULL,NULL),
(3,'HONESTY','AF',NULL,NULL,NULL),
(4,'RELIABILITY','AF',NULL,NULL,NULL),
(5,'RELATIONSHIP WITH OTHERS','AF',NULL,NULL,NULL),
(6,'POLITENESS','AF',NULL,NULL,NULL),
(7,'ALERTNESS','AF',NULL,NULL,NULL),
(8,'HANDWRITING','PS',NULL,NULL,NULL),
(9,'GAMES & SPORTS','PS',NULL,NULL,NULL),
(10,'DRAWING & ARTS','PS',NULL,NULL,NULL),
(11,'PAINTING','PS',NULL,NULL,NULL),
(12,'CONSTRUCTION','PS',NULL,NULL,NULL),
(13,'MUSICAL SKILLS','PS',NULL,NULL,NULL),
(14,'FLEXIBILITY','PS',NULL,NULL,NULL);

/*Table structure for table `staff_records` */

DROP TABLE IF EXISTS `staff_records`;

CREATE TABLE `staff_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `staff_records_code_unique` (`code`) USING BTREE,
  KEY `staff_records_user_id_foreign` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `staff_records` */

insert  into `staff_records`(`id`,`user_id`,`code`,`emp_date`,`created_at`,`updated_at`,`group_id`) values 
(2,121,'H9OFUCxtcqUXU6gIg6JZ',NULL,'2022-07-24 10:32:10','2023-01-14 23:09:02','');

/*Table structure for table `states` */

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `states` */

insert  into `states`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Abia','2022-06-17 00:38:19','2022-06-17 00:38:19'),
(2,'Adamawa','2022-06-17 00:38:19','2022-06-17 00:38:19'),
(3,'Akwa Ibom','2022-06-17 00:38:19','2022-06-17 00:38:19'),
(4,'Anambra','2022-06-17 00:38:19','2022-06-17 00:38:19'),
(5,'Bauchi','2022-06-17 00:38:19','2022-06-17 00:38:19'),
(6,'Bayelsa','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(7,'Benue','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(8,'Borno','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(9,'Cross River','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(10,'Delta','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(11,'Ebonyi','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(12,'Edo','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(13,'Ekiti','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(14,'Enugu','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(15,'FCT','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(16,'Gombe','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(17,'Imo','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(18,'Jigawa','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(19,'Kaduna','2022-06-17 00:38:20','2022-06-17 00:38:20'),
(20,'Kano','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(21,'Katsina','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(22,'Kebbi','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(23,'Kogi','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(24,'Kwara','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(25,'Lagos','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(26,'Nasarawa','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(27,'Niger','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(28,'Ogun','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(29,'Ondo','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(30,'Osun','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(31,'Oyo','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(32,'Plateau','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(33,'Rivers','2022-06-17 00:38:21','2022-06-17 00:38:21'),
(34,'Sokoto','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(35,'Taraba','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(36,'Yobe','2022-06-17 00:38:22','2022-06-17 00:38:22'),
(37,'Zamfara','2022-06-17 00:38:22','2022-06-17 00:38:22');

/*Table structure for table `student_subjects` */

DROP TABLE IF EXISTS `student_subjects`;

CREATE TABLE `student_subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `class_subject_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `student_subjects` */

/*Table structure for table `student_temps` */

DROP TABLE IF EXISTS `student_temps`;

CREATE TABLE `student_temps` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `adm_no` int(11) NOT NULL,
  `form` int(11) NOT NULL,
  `stream` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'male',
  `upi` int(11) NOT NULL,
  `dob` date NOT NULL,
  `kcpe` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `student_temps` */

/*Table structure for table `students` */

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT 0,
  `my_class_id` int(11) DEFAULT 0,
  `adm_no` int(11) DEFAULT 0,
  `upi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kcpe` decimal(11,0) DEFAULT 0,
  `destination_class_id` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `students` */

insert  into `students`(`id`,`user_id`,`my_class_id`,`adm_no`,`upi`,`kcpe`,`destination_class_id`,`created_at`,`updated_at`) values 
(162,214,74,1,NULL,0,0,'2023-03-21 07:56:14','2023-03-21 07:56:14'),
(163,215,74,2,NULL,0,0,'2023-03-21 07:56:36','2023-03-21 07:56:36'),
(164,216,76,3,NULL,0,0,'2023-03-21 07:56:59','2023-03-21 07:56:59'),
(165,217,76,4,NULL,0,0,'2023-03-21 07:57:19','2023-03-21 07:57:19'),
(166,218,75,5,NULL,0,0,'2023-03-21 07:57:47','2023-03-21 07:57:47'),
(167,219,75,6,NULL,0,0,'2023-03-21 07:58:09','2023-03-21 07:58:09');

/*Table structure for table `subject_teachers` */

DROP TABLE IF EXISTS `subject_teachers`;

CREATE TABLE `subject_teachers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `subject_teachers` */

/*Table structure for table `subject_types` */

DROP TABLE IF EXISTS `subject_types`;

CREATE TABLE `subject_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `subject_types` */

insert  into `subject_types`(`id`,`name`,`created_at`,`updated_at`) values 
(1,'Language','2022-06-17 13:53:06','2022-06-17 13:53:06'),
(2,'Mathematics','2022-06-17 13:53:16','2022-06-17 13:53:16'),
(3,'Sciences','2022-06-17 13:53:21','2022-06-17 13:53:21'),
(4,'Humanities','2022-06-17 13:53:28','2022-06-17 13:53:28'),
(5,'Technicals','2022-06-17 13:53:35','2022-06-17 13:53:35'),
(6,'Optionals','2022-06-17 13:53:46','2022-06-17 13:53:46');

/*Table structure for table `subjects` */

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subject_type_id` int(50) NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `out_x` int(11) NOT NULL,
  `out_y` int(11) NOT NULL,
  `out_z` int(11) NOT NULL,
  `con_x` int(11) NOT NULL,
  `con_y` int(11) NOT NULL,
  `con_z` int(11) NOT NULL,
  `status_x` tinyint(1) NOT NULL,
  `status_y` tinyint(1) NOT NULL,
  `status_z` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `subjects` */

insert  into `subjects`(`id`,`subject_type_id`,`title`,`created_at`,`updated_at`,`out_x`,`out_y`,`out_z`,`con_x`,`con_y`,`con_z`,`status_x`,`status_y`,`status_z`) values 
(5,1,'English','2022-06-17 13:49:41','2023-01-17 08:46:40',50,50,0,50,50,0,1,1,0),
(6,1,'Kiswahili','2022-06-17 13:49:20','2022-06-24 22:52:04',0,0,0,0,0,0,0,0,0),
(7,2,'Mathematics','2022-06-17 13:49:24','2022-06-24 22:52:03',0,0,0,0,0,0,0,0,0),
(8,3,'Chemistry','2022-06-17 13:49:30','2023-01-17 08:46:39',10,10,10,10,10,10,1,1,1),
(9,3,'Physics','2022-06-17 13:49:36','2022-06-24 22:52:02',0,0,0,0,0,0,0,0,0),
(10,3,'Biology','2022-06-24 22:45:36','2022-06-24 22:45:58',0,0,0,0,0,0,0,0,0),
(11,4,'Histofy and Government','2022-06-24 22:46:18','2022-06-24 22:46:18',0,0,0,0,0,0,0,0,0),
(12,4,'Geography','2022-06-24 22:46:29','2022-06-24 22:46:32',0,0,0,0,0,0,0,0,0),
(13,4,'C.R.E','2022-06-24 22:46:42','2022-06-24 22:46:42',0,0,0,0,0,0,0,0,0),
(14,4,'I.R.E','2022-06-24 22:46:50','2022-06-24 22:46:50',0,0,0,0,0,0,0,0,0),
(15,4,'H.R.E','2022-06-24 22:46:57','2022-06-24 22:46:57',0,0,0,0,0,0,0,0,0),
(16,5,'Home Science','2022-06-24 22:47:33','2022-06-24 22:47:33',0,0,0,0,0,0,0,0,0),
(17,5,'Art and Design','2022-06-24 22:47:41','2023-01-17 08:46:39',1,0,0,0,0,0,1,0,0),
(18,5,'Woodwork','2022-06-24 22:48:13','2022-06-24 22:48:13',0,0,0,0,0,0,0,0,0),
(19,5,'Metalwork','2022-06-24 22:48:20','2022-06-24 22:49:21',0,0,0,0,0,0,0,0,0),
(20,5,'Building Construction','2022-06-24 22:48:29','2022-06-24 22:49:20',0,0,0,0,0,0,0,0,0),
(21,5,'Power Mechanics','2022-06-24 22:48:40','2022-06-24 22:49:20',0,0,0,0,0,0,0,0,0),
(22,5,'Electricity','2022-06-24 22:48:45','2022-06-24 22:49:19',0,0,0,0,0,0,0,0,0),
(23,5,'Drawing andDesign','2022-06-24 22:48:50','2022-06-24 22:49:19',0,0,0,0,0,0,0,0,0),
(24,5,'Aviation','2022-06-24 22:48:54','2023-01-17 08:46:39',100,100,0,50,50,0,1,1,0),
(25,5,'Computer Studies','2022-06-24 22:49:00','2022-06-24 22:49:18',0,0,0,0,0,0,0,0,0),
(26,5,'Music','2022-06-24 22:49:03','2022-06-24 22:49:18',0,0,0,0,0,0,0,0,0),
(27,5,'Braille','2022-06-24 22:49:07','2022-06-24 22:49:17',0,0,0,0,0,0,0,0,0),
(28,5,'Business Studies','2022-06-24 22:49:14','2022-06-24 22:49:17',0,0,0,0,0,0,0,0,0),
(29,6,'Mathematics - Option B','2022-06-24 22:49:42','2022-06-24 22:51:47',0,0,0,0,0,0,0,0,0),
(30,6,'Fasihi','2022-06-24 22:49:48','2023-01-17 08:46:40',10,10,10,10,10,10,1,1,1),
(31,6,'Literature','2022-06-24 22:49:52','2022-06-24 22:51:46',0,0,0,0,0,0,0,0,0),
(32,6,'Bilogy for the Blind','2022-06-24 22:49:59','2023-01-17 08:46:39',100,100,0,100,100,100,1,1,0),
(33,6,'General Science','2022-06-24 22:50:07','2022-06-24 22:51:45',0,0,0,0,0,0,0,0,0),
(34,6,'French','2022-06-24 22:50:13','2022-06-24 22:51:44',0,0,0,0,0,0,0,0,0),
(35,6,'German','2022-06-24 22:50:18','2022-06-24 22:51:44',0,0,0,0,0,0,0,0,0),
(36,6,'Kenya Sign Language','2022-06-24 22:50:32','2022-06-24 22:51:44',0,0,0,0,0,0,0,0,0),
(37,6,'Arabic','2022-06-24 22:50:35','2023-01-17 08:46:38',100,90,100,100,90,100,1,1,1),
(38,6,'Mandrin','2022-06-24 22:50:39','2022-06-24 22:51:43',0,0,0,0,0,0,0,0,0),
(39,6,'Computer Literacy','2022-06-24 22:50:47','2023-01-17 08:46:39',100,100,0,50,50,0,1,1,0),
(40,6,'Adapted Home Science','2022-06-24 22:50:55','2023-01-17 08:46:38',10,10,10,9,10,9,1,1,1),
(41,6,'Adapted Agriculture','2022-06-24 22:51:01','2023-01-17 08:46:37',50,50,0,50,50,0,1,1,0),
(42,6,'P.E','2022-06-24 22:51:04','2022-06-24 22:51:41',0,0,0,0,0,0,0,0,0),
(43,6,'Library','2022-06-24 22:51:24','2022-06-24 22:51:40',0,0,0,0,0,0,0,0,0),
(44,6,'Postoral','2022-06-24 22:51:30','2022-06-24 22:51:40',0,0,0,0,0,0,0,0,0),
(45,6,'Life Skills','2022-06-24 22:51:36','2022-06-24 22:51:39',0,0,0,0,0,0,0,0,0);

/*Table structure for table `teachers` */

DROP TABLE IF EXISTS `teachers`;

CREATE TABLE `teachers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `group_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `teachers` */

insert  into `teachers`(`id`,`user_id`,`group_id`,`created_at`,`updated_at`) values 
(70,211,'2','2023-03-21 07:54:55','2023-03-21 07:54:55'),
(71,212,'2','2023-03-21 07:55:13','2023-03-21 07:55:13'),
(72,213,'2','2023-03-21 07:55:34','2023-03-21 07:55:34');

/*Table structure for table `test_excels` */

DROP TABLE IF EXISTS `test_excels`;

CREATE TABLE `test_excels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sort_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `test_excels` */

insert  into `test_excels`(`id`,`sort_id`,`name`,`created_at`,`updated_at`) values 
(77,1,'Creche','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(78,2,'Junior Secondary','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(79,3,'Junior Secondary','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(80,4,'Creche','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(81,5,'Junior Secondary','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(82,6,'Junior Secondary','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(83,7,'Creche','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(84,8,'Junior Secondary','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(85,9,'Junior Secondary','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(86,10,'Creche','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(87,11,'Junior Secondary','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(88,12,'Junior Secondary','2022-06-28 13:40:28','2022-06-28 13:40:28'),
(89,1,'a','2022-06-29 13:08:49','2022-06-29 13:08:49'),
(90,2,'b','2022-06-29 13:08:49','2022-06-29 13:08:49'),
(91,3,'c','2022-06-29 13:08:49','2022-06-29 13:08:49'),
(92,4,'d','2022-06-29 13:08:49','2022-06-29 13:08:49'),
(93,5,'e','2022-06-29 13:08:49','2022-06-29 13:08:49'),
(94,6,'f','2022-06-29 13:08:49','2022-06-29 13:08:49'),
(95,7,'g','2022-06-29 13:08:49','2022-06-29 13:08:49'),
(96,8,'h','2022-06-29 13:08:49','2022-06-29 13:08:49'),
(97,9,'i','2022-06-29 13:08:49','2022-06-29 13:08:49'),
(98,10,'j','2022-06-29 13:08:49','2022-06-29 13:08:49');

/*Table structure for table `time_slots` */

DROP TABLE IF EXISTS `time_slots`;

CREATE TABLE `time_slots` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ttr_id` int(10) unsigned NOT NULL,
  `hour_from` tinyint(4) NOT NULL,
  `min_from` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meridian_from` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hour_to` tinyint(4) NOT NULL,
  `min_to` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meridian_to` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_from` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_to` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp_from` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp_to` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `time_slots_timestamp_from_timestamp_to_ttr_id_unique` (`timestamp_from`,`timestamp_to`,`ttr_id`) USING BTREE,
  KEY `time_slots_ttr_id_foreign` (`ttr_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `time_slots` */

/*Table structure for table `time_table_records` */

DROP TABLE IF EXISTS `time_table_records`;

CREATE TABLE `time_table_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `my_class_id` int(10) unsigned NOT NULL,
  `exam_id` int(10) unsigned DEFAULT NULL,
  `year` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `time_table_records_name_unique` (`name`) USING BTREE,
  UNIQUE KEY `time_table_records_my_class_id_exam_id_year_unique` (`my_class_id`,`exam_id`,`year`) USING BTREE,
  KEY `time_table_records_exam_id_foreign` (`exam_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `time_table_records` */

/*Table structure for table `time_tables` */

DROP TABLE IF EXISTS `time_tables`;

CREATE TABLE `time_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ttr_id` int(10) unsigned NOT NULL,
  `ts_id` int(10) unsigned NOT NULL,
  `subject_id` int(10) unsigned DEFAULT NULL,
  `exam_date` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp_from` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp_to` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day_num` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `time_tables_ttr_id_ts_id_day_unique` (`ttr_id`,`ts_id`,`day`) USING BTREE,
  UNIQUE KEY `time_tables_ttr_id_ts_id_exam_date_unique` (`ttr_id`,`ts_id`,`exam_date`) USING BTREE,
  KEY `time_tables_ts_id_foreign` (`ts_id`) USING BTREE,
  KEY `time_tables_subject_id_foreign` (`subject_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `time_tables` */

/*Table structure for table `user_types` */

DROP TABLE IF EXISTS `user_types`;

CREATE TABLE `user_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `user_types` */

insert  into `user_types`(`id`,`title`,`name`,`level`,`created_at`,`updated_at`) values 
(1,'staff','Staff','5',NULL,NULL),
(2,'student','Student','4',NULL,NULL),
(3,'teacher','Teacher','3',NULL,NULL),
(4,'admin','Admin','2',NULL,NULL),
(5,'super_admin','Super Admin','1',NULL,NULL),
(6,'bom/pa','BOM/PA','6',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type_id` int(11) NOT NULL DEFAULT 1,
  `dob` int(11) DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'male',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user.png',
  `sign` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_by` enum('admission_number','index_number') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admission_number',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id_no` int(255) DEFAULT NULL,
  `tsc_no` int(255) DEFAULT NULL,
  `bg_id` int(10) unsigned DEFAULT NULL,
  `state_id` int(10) unsigned DEFAULT NULL,
  `lga_id` int(10) unsigned DEFAULT NULL,
  `nal_id` int(10) unsigned DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `school_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_short_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_head_id` int(10) unsigned DEFAULT NULL,
  `school_title_id` int(10) unsigned DEFAULT NULL,
  `school_hod_id` int(10) unsigned DEFAULT NULL,
  `school_postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `school_gender_id` int(10) unsigned DEFAULT NULL,
  `school_status_id` int(10) unsigned DEFAULT NULL,
  `school_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_code_unique` (`code`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE,
  UNIQUE KEY `users_school_email_unique` (`school_email`) USING BTREE,
  KEY `users_state_id_foreign` (`state_id`) USING BTREE,
  KEY `users_lga_id_foreign` (`lga_id`) USING BTREE,
  KEY `users_bg_id_foreign` (`bg_id`) USING BTREE,
  KEY `users_nal_id_foreign` (`nal_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`code`,`user_type_id`,`dob`,`gender`,`photo`,`sign`,`photo_by`,`phone`,`phone2`,`national_id_no`,`tsc_no`,`bg_id`,`state_id`,`lga_id`,`nal_id`,`address`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`,`school_name`,`school_short_name`,`school_email`,`school_phone`,`school_head_id`,`school_title_id`,`school_hod_id`,`school_postal`,`school_gender_id`,`school_status_id`,`school_logo`,`state`) values 
(1,'CJ Inspired','cj@cj.com','gzsvL',5,NULL,'male','user.png','','admission_number','+254203570012',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u','xYjFjFW3EAkZsLdJdSy8H90fL0HOs3yFHrPgkFtfuyzwPz4kuPq93jwDKbab',NULL,'2022-10-31 02:47:22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'',0),
(211,'A_teacher','A_teacher@bibirionihigh','4NhDZ',3,NULL,'male','user.png',NULL,'admission_number','0715223003',NULL,121,603659,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u',NULL,'2023-03-21 07:54:54','2023-03-21 07:54:54',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(212,'B_teacher','B_teacher@bibirionihigh','Vy5NX',3,NULL,'male','user.png',NULL,'admission_number','1234654231',NULL,1212,2121,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u',NULL,'2023-03-21 07:55:12','2023-03-21 07:55:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(213,'C_teacher','C_teacher@bibirionihigh','lBFFm',3,NULL,'male','user.png',NULL,'admission_number','0715223003',NULL,1212,2121,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u',NULL,'2023-03-21 07:55:34','2023-03-21 07:55:34',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(214,'A_student','A_stu@gmail.com','eYkRL',2,NULL,'male','user.png',NULL,'admission_number',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u',NULL,'2023-03-21 07:56:14','2023-03-21 07:56:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(215,'B_student','B_stu@gmail.com','lqLXS',2,NULL,'male','user.png',NULL,'admission_number',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u',NULL,'2023-03-21 07:56:36','2023-03-21 07:56:36',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(216,'C_student','C_stu@gmail.com','Q9tih',2,NULL,'male','user.png',NULL,'admission_number',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u',NULL,'2023-03-21 07:56:59','2023-03-21 07:56:59',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(217,'D_student','D_stu@gmail.com','tdnBn',2,NULL,'male','user.png',NULL,'admission_number',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u',NULL,'2023-03-21 07:57:19','2023-03-21 07:57:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(218,'E_student','E_stu@gmail.com','ugVLI',2,NULL,'male','user.png',NULL,'admission_number',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u',NULL,'2023-03-21 07:57:46','2023-03-21 07:57:46',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(219,'F_student','F_stu@gmail.com','XcosF',2,NULL,'male','user.png',NULL,'admission_number',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$ftKx60gZMnFAeQv47XD1auuEAwr9Cxxe2TwX1Dfd42xxqnpYXtn.u',NULL,'2023-03-21 07:58:09','2023-03-21 07:58:09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
