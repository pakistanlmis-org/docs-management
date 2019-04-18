/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100125
Source Host           : 127.0.0.1:3306
Source Database       : edoc

Target Server Type    : MYSQL
Target Server Version : 100125
File Encoding         : 65001

Date: 2018-04-26 09:53:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for edoc_departments
-- ----------------------------
DROP TABLE IF EXISTS `edoc_departments`;
CREATE TABLE `edoc_departments` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of edoc_departments
-- ----------------------------
INSERT INTO `edoc_departments` VALUES ('1', 'Finance', '1', '1', '2018-03-07 15:30:38', '2018-03-07 15:30:38');
INSERT INTO `edoc_departments` VALUES ('2', 'Admin', '1', '1', '2018-03-07 15:30:39', '2018-03-07 15:30:39');
INSERT INTO `edoc_departments` VALUES ('3', 'Operations', '1', '1', '2018-03-07 15:30:39', '2018-03-07 15:30:39');

-- ----------------------------
-- Table structure for edoc_files
-- ----------------------------
DROP TABLE IF EXISTS `edoc_files`;
CREATE TABLE `edoc_files` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_no` varchar(255) DEFAULT NULL,
  `file_title` varchar(255) DEFAULT NULL,
  `file_description` text,
  `file_department` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `receive_from` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of edoc_files
-- ----------------------------
INSERT INTO `edoc_files` VALUES ('2', 'TEst', 'test', 'Test', '1', '1', '1', '1', '2018-04-04 07:53:22', '2018-04-04 07:53:22', 'Test');

-- ----------------------------
-- Table structure for edoc_tracking
-- ----------------------------
DROP TABLE IF EXISTS `edoc_tracking`;
CREATE TABLE `edoc_tracking` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `edoc_file_id` int(11) DEFAULT NULL,
  `in_date` datetime DEFAULT NULL,
  `out_date` datetime DEFAULT NULL,
  `source` int(11) DEFAULT NULL,
  `destination` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `contents` text,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `file_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pk_id`),
  KEY `edoc_file_id` (`edoc_file_id`),
  CONSTRAINT `edoc_tracking_ibfk_1` FOREIGN KEY (`edoc_file_id`) REFERENCES `edoc_files` (`pk_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of edoc_tracking
-- ----------------------------

-- ----------------------------
-- Table structure for edoc_users
-- ----------------------------
DROP TABLE IF EXISTS `edoc_users`;
CREATE TABLE `edoc_users` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `login_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of edoc_users
-- ----------------------------
INSERT INTO `edoc_users` VALUES ('1', 'Ajmal Hussain', 'SE Specialist', '1', 'ajmal', '202cb962ac59075b964b07152d234b70', 'ahussain@ghsc-psm.org', '03339652360', '1', '1', '1', '1', '2018-03-08 11:29:38', '2018-03-08 11:29:38');
INSERT INTO `edoc_users` VALUES ('2', 'Ijaz Haider', 'Manager', '1', 'ijaz', '202cb962ac59075b964b07152d234b70', 'ahussain@ghsc-psm.org', '03339652360', '1', '1', '1', '1', '2018-03-08 11:29:38', '2018-03-08 11:29:38');
INSERT INTO `edoc_users` VALUES ('3', 'Wasif Raza', 'Manager', '2', 'wasif', '202cb962ac59075b964b07152d234b70', 'ahussain@ghsc-psm.org', '03339652360', '1', '1', '1', '1', '2018-03-08 11:29:38', '2018-03-08 11:29:38');

-- ----------------------------
-- Table structure for file_attachments
-- ----------------------------
DROP TABLE IF EXISTS `file_attachments`;
CREATE TABLE `file_attachments` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk_id`),
  KEY `file_id` (`file_id`),
  CONSTRAINT `file_attachments_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `edoc_files` (`pk_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of file_attachments
-- ----------------------------

-- ----------------------------
-- Table structure for role_actions
-- ----------------------------
DROP TABLE IF EXISTS `role_actions`;
CREATE TABLE `role_actions` (
  `pk_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `action` enum('SELECT','UPDATE','DELETE','INSERT') DEFAULT NULL,
  `allow` enum('TRUE','FALSE') DEFAULT NULL,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of role_actions
-- ----------------------------
INSERT INTO `role_actions` VALUES ('1', '1', 'SELECT', 'TRUE');
INSERT INTO `role_actions` VALUES ('2', '1', 'UPDATE', 'TRUE');
INSERT INTO `role_actions` VALUES ('3', '1', 'DELETE', 'TRUE');
INSERT INTO `role_actions` VALUES ('4', '1', 'INSERT', 'TRUE');
INSERT INTO `role_actions` VALUES ('5', '2', 'SELECT', 'TRUE');
INSERT INTO `role_actions` VALUES ('6', '2', 'UPDATE', 'FALSE');
INSERT INTO `role_actions` VALUES ('7', '2', 'DELETE', 'FALSE');
INSERT INTO `role_actions` VALUES ('8', '2', 'INSERT', 'TRUE');
INSERT INTO `role_actions` VALUES ('9', '3', 'SELECT', 'TRUE');
INSERT INTO `role_actions` VALUES ('10', '3', 'UPDATE', 'FALSE');
INSERT INTO `role_actions` VALUES ('11', '3', 'DELETE', 'FALSE');
INSERT INTO `role_actions` VALUES ('12', '3', 'INSERT', 'TRUE');
SET FOREIGN_KEY_CHECKS=1;
