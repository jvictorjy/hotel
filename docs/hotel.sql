/*
 Navicat Premium Data Transfer

 Source Server         : Localhost/Mysql
 Source Server Type    : MySQL
 Source Server Version : 50611
 Source Host           : localhost
 Source Database       : hotel

 Target Server Type    : MySQL
 Target Server Version : 50611
 File Encoding         : utf-8

 Date: 04/29/2014 20:52:38 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `hoteis`
-- ----------------------------
DROP TABLE IF EXISTS `hoteis`;
CREATE TABLE `hoteis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `estrelas` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `hoteis`
-- ----------------------------
BEGIN;
INSERT INTO `hoteis` VALUES ('1', 'X', '3'), ('2', 'Y', '5'), ('3', 'Z', '4');
COMMIT;

-- ----------------------------
--  Table structure for `precos`
-- ----------------------------
DROP TABLE IF EXISTS `precos`;
CREATE TABLE `precos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` int(11) NOT NULL,
  `valor` float NOT NULL,
  `tipo_id` int(11) NOT NULL,
  `tipo_cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `precos`
-- ----------------------------
BEGIN;
INSERT INTO `precos` VALUES ('1', '1', '100', '1', '1'), ('2', '1', '120', '2', '1'), ('3', '1', '90', '1', '2'), ('4', '1', '60', '2', '2'), ('5', '2', '130', '1', '1'), ('6', '2', '150', '2', '1'), ('7', '2', '100', '1', '2'), ('8', '2', '95', '2', '2'), ('9', '3', '195', '1', '1'), ('10', '3', '150', '2', '1'), ('11', '3', '120', '1', '2'), ('12', '3', '90', '2', '2');
COMMIT;

-- ----------------------------
--  Table structure for `tipo_cliente`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_cliente`;
CREATE TABLE `tipo_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `tipo_cliente`
-- ----------------------------
BEGIN;
INSERT INTO `tipo_cliente` VALUES ('1', 'Regular'), ('2', 'Rewardee');
COMMIT;

-- ----------------------------
--  Table structure for `tipo_preco`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_preco`;
CREATE TABLE `tipo_preco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `tipo_preco`
-- ----------------------------
BEGIN;
INSERT INTO `tipo_preco` VALUES ('1', 'Semana'), ('2', 'Final de semana');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
