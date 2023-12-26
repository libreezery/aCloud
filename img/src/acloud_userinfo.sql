/*
 Navicat Premium Data Transfer

 Source Server         : 云主机
 Source Server Type    : MySQL
 Source Server Version : 50651
 Source Host           : hk1.panel.net.cn:3306
 Source Schema         : s9271372

 Target Server Type    : MySQL
 Target Server Version : 50651
 File Encoding         : 65001

 Date: 26/12/2023 16:18:07
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for acloud_userinfo
-- ----------------------------
DROP TABLE IF EXISTS `acloud_userinfo`;
CREATE TABLE `acloud_userinfo`  (
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `identity` int(10) NULL DEFAULT NULL,
  `identity_expire` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  UNIQUE INDEX `username`(`username`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
