/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100125
Source Host           : 127.0.0.1:3306
Source Database       : edoc

Target Server Type    : MYSQL
Target Server Version : 100125
File Encoding         : 65001

Date: 2018-05-28 09:25:20
*/

SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO `role_actions` VALUES ('8', '2', 'INSERT', 'TRUE');
INSERT INTO `role_actions` VALUES ('9', '3', 'SELECT', 'TRUE');
SET FOREIGN_KEY_CHECKS=1;
