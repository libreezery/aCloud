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

 Date: 26/12/2023 16:17:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for acloud_picinfo
-- ----------------------------
DROP TABLE IF EXISTS `acloud_picinfo`;
CREATE TABLE `acloud_picinfo`  (
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `md5` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `upload_time` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `expire_time` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
