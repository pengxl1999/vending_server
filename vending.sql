/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 100131
Source Host           : localhost:3306
Source Database       : vending

Target Server Type    : MYSQL
Target Server Version : 100131
File Encoding         : 65001

Date: 2019-05-03 21:10:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for customer_appointment
-- ----------------------------
DROP TABLE IF EXISTS `customer_appointment`;
CREATE TABLE `customer_appointment` (
  `ca_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `ca_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  `v_id` int(11) DEFAULT NULL,
  `deadline` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `num` int(11) DEFAULT '1',
  `img` varchar(255) DEFAULT NULL,
  `pa_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ca_id`),
  KEY `c_id` (`c_id`),
  KEY `m_id` (`m_id`),
  KEY `v_id` (`v_id`),
  KEY `pa_id` (`pa_id`),
  CONSTRAINT `customer_appointment_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_appointment_ibfk_2` FOREIGN KEY (`m_id`) REFERENCES `medicine` (`m_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_appointment_ibfk_3` FOREIGN KEY (`v_id`) REFERENCES `vem` (`vem_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_appointment_ibfk_4` FOREIGN KEY (`pa_id`) REFERENCES `pharmacist_appointment` (`pa_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for customer_car
-- ----------------------------
DROP TABLE IF EXISTS `customer_car`;
CREATE TABLE `customer_car` (
  `cc_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cc_medicine` int(11) NOT NULL,
  `cc_num` int(11) NOT NULL,
  PRIMARY KEY (`cc_id`),
  KEY `cc_medicine` (`cc_medicine`),
  KEY `c_id` (`c_id`),
  CONSTRAINT `customer_car_ibfk_1` FOREIGN KEY (`cc_medicine`) REFERENCES `medicine` (`m_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_car_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for customer_purchase
-- ----------------------------
DROP TABLE IF EXISTS `customer_purchase`;
CREATE TABLE `customer_purchase` (
  `cp_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `m_id` int(11) NOT NULL,
  `cp_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  `v_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT '1',
  `img` varchar(255) DEFAULT NULL,
  `pa_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cp_id`),
  KEY `c_id` (`c_id`),
  KEY `m_id` (`m_id`),
  KEY `v_id` (`v_id`),
  KEY `pa_id` (`pa_id`),
  CONSTRAINT `customer_purchase_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_purchase_ibfk_2` FOREIGN KEY (`m_id`) REFERENCES `medicine` (`m_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_purchase_ibfk_3` FOREIGN KEY (`v_id`) REFERENCES `vem` (`vem_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `customer_purchase_ibfk_4` FOREIGN KEY (`pa_id`) REFERENCES `pharmacist_appointment` (`pa_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for medicine
-- ----------------------------
DROP TABLE IF EXISTS `medicine`;
CREATE TABLE `medicine` (
  `m_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `commodity_name` varchar(255) DEFAULT NULL,
  `common_name` varchar(255) DEFAULT NULL,
  `other_name` varchar(255) DEFAULT NULL,
  `english_name` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `composition` varchar(255) DEFAULT NULL,
  `usage` varchar(1024) DEFAULT NULL,
  `symptom` varchar(1024) DEFAULT NULL,
  `attention` varchar(1024) DEFAULT NULL,
  `interaction` varchar(1024) DEFAULT NULL,
  `dose` varchar(10) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `guarantee` int(11) NOT NULL,
  `fomulation` int(11) DEFAULT NULL,
  `brand` int(11) DEFAULT NULL,
  `cert` varchar(20) NOT NULL,
  `manufacturer` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`m_id`),
  KEY `type` (`type`),
  KEY `manufacturer` (`manufacturer`),
  KEY `brand` (`brand`),
  KEY `fomulation` (`fomulation`),
  CONSTRAINT `medicine_ibfk_1` FOREIGN KEY (`type`) REFERENCES `medicine_type` (`mt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `medicine_ibfk_2` FOREIGN KEY (`manufacturer`) REFERENCES `medicine_man` (`mm_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `medicine_ibfk_3` FOREIGN KEY (`brand`) REFERENCES `medicine_brand` (`mb_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `medicine_ibfk_4` FOREIGN KEY (`fomulation`) REFERENCES `medicine_formulation` (`mft_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for medicine_brand
-- ----------------------------
DROP TABLE IF EXISTS `medicine_brand`;
CREATE TABLE `medicine_brand` (
  `mb_id` int(11) NOT NULL,
  `mb_name` varchar(255) NOT NULL,
  `mb_img` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for medicine_formulation
-- ----------------------------
DROP TABLE IF EXISTS `medicine_formulation`;
CREATE TABLE `medicine_formulation` (
  `mft_id` int(11) NOT NULL,
  `mtf_name` varchar(255) NOT NULL,
  PRIMARY KEY (`mft_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for medicine_man
-- ----------------------------
DROP TABLE IF EXISTS `medicine_man`;
CREATE TABLE `medicine_man` (
  `mm_id` int(11) NOT NULL,
  `mm_name` varchar(255) NOT NULL,
  PRIMARY KEY (`mm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for medicine_type
-- ----------------------------
DROP TABLE IF EXISTS `medicine_type`;
CREATE TABLE `medicine_type` (
  `mt_id` int(11) NOT NULL,
  `mt_name` varchar(255) NOT NULL,
  PRIMARY KEY (`mt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for pharmacist
-- ----------------------------
DROP TABLE IF EXISTS `pharmacist`;
CREATE TABLE `pharmacist` (
  `u_id` int(11) NOT NULL,
  `p_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for pharmacist_appointment
-- ----------------------------
DROP TABLE IF EXISTS `pharmacist_appointment`;
CREATE TABLE `pharmacist_appointment` (
  `pa_id` int(11) NOT NULL,
  `p_id` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(20) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pa_id`),
  KEY `p_id` (`p_id`),
  CONSTRAINT `pharmacist_appointment_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `pharmacist` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_type` int(11) DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `authKey` varchar(100) NOT NULL DEFAULT '',
  `accessToken` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for vem
-- ----------------------------
DROP TABLE IF EXISTS `vem`;
CREATE TABLE `vem` (
  `vem_id` int(11) NOT NULL,
  `vem_name` varchar(255) NOT NULL,
  `vem_location` varchar(255) DEFAULT NULL,
  `vem_type` int(11) NOT NULL,
  PRIMARY KEY (`vem_id`),
  KEY `vem_type` (`vem_type`),
  CONSTRAINT `vem_ibfk_1` FOREIGN KEY (`vem_type`) REFERENCES `vem_type` (`vt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for vem_status
-- ----------------------------
DROP TABLE IF EXISTS `vem_status`;
CREATE TABLE `vem_status` (
  `vemc_id` int(11) NOT NULL AUTO_INCREMENT,
  `vem_id` int(11) DEFAULT NULL,
  `m_id` int(11) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  PRIMARY KEY (`vemc_id`),
  KEY `vem_id` (`vem_id`),
  KEY `m_id` (`m_id`),
  CONSTRAINT `vem_status_ibfk_1` FOREIGN KEY (`vem_id`) REFERENCES `vem` (`vem_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vem_status_ibfk_2` FOREIGN KEY (`m_id`) REFERENCES `medicine` (`m_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Table structure for vem_type
-- ----------------------------
DROP TABLE IF EXISTS `vem_type`;
CREATE TABLE `vem_type` (
  `vt_id` int(11) NOT NULL,
  `vt_name` varchar(255) NOT NULL,
  PRIMARY KEY (`vt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
