/*
Navicat MySQL Data Transfer

Source Server         : c.lmis
Source Server Version : 50710
Source Host           : 202.83.164.74:3306
Source Database       : clmis

Target Server Type    : MYSQL
Target Server Version : 50710
File Encoding         : 65001

Date: 2018-06-01 12:51:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for system_settings
-- ----------------------------
DROP TABLE IF EXISTS `system_settings`;
CREATE TABLE `system_settings` (
  `pk_id` int(255) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) DEFAULT NULL,
  `setting_value` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `last_modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`pk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of system_settings
-- ----------------------------
INSERT INTO `system_settings` VALUES ('1', 'dashboard_email', 'active', 'Enable Emails from fp2020 dashboard (active/inactive)', '2018-02-27 11:59:05');
INSERT INTO `system_settings` VALUES ('2', 'dashboard_sms', 'active', 'Enable SMS from fp2020 dashboard (active/inactive)', '2018-02-27 11:59:16');
INSERT INTO `system_settings` VALUES ('3', 'dashboard_call', 'active', 'Enable Calls from fp2020 dashboard (active/inactive)', '2018-02-06 13:53:36');
SET FOREIGN_KEY_CHECKS=1;
