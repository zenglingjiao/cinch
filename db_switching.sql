/*
 Navicat Premium Data Transfer

 Source Server         : swg
 Source Server Type    : MySQL
 Source Server Version : 100136
 Source Host           : 61.222.197.34:3306
 Source Schema         : db_switching

 Target Server Type    : MySQL
 Target Server Version : 100136
 File Encoding         : 65001

 Date: 27/12/2019 09:48:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for aauth_group_to_group
-- ----------------------------
DROP TABLE IF EXISTS `aauth_group_to_group`;
CREATE TABLE `aauth_group_to_group`  (
  `group_id` int(11) UNSIGNED NOT NULL,
  `subgroup_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`group_id`, `subgroup_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aauth_groups
-- ----------------------------
DROP TABLE IF EXISTS `aauth_groups`;
CREATE TABLE `aauth_groups`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `definition` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aauth_groups
-- ----------------------------
INSERT INTO `aauth_groups` VALUES (1, 'Admin', 'Super Admin Group');
INSERT INTO `aauth_groups` VALUES (2, 'Public', 'Public Access Group');
INSERT INTO `aauth_groups` VALUES (3, 'Default', 'Default Access Group');
INSERT INTO `aauth_groups` VALUES (4, 'Store', '店鋪');

-- ----------------------------
-- Table structure for aauth_login_attempts
-- ----------------------------
DROP TABLE IF EXISTS `aauth_login_attempts`;
CREATE TABLE `aauth_login_attempts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(39) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `timestamp` datetime(0) NULL DEFAULT NULL,
  `login_attempts` tinyint(2) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aauth_login_attempts
-- ----------------------------
INSERT INTO `aauth_login_attempts` VALUES (4, '127.0.0.1', '2019-04-11 15:22:59', 1);
INSERT INTO `aauth_login_attempts` VALUES (6, '127.0.0.1', '2019-07-13 19:38:08', 5);
INSERT INTO `aauth_login_attempts` VALUES (8, '127.0.0.1', '2019-07-13 19:51:29', 3);
INSERT INTO `aauth_login_attempts` VALUES (9, '127.0.0.1', '2019-07-13 20:02:18', 1);
INSERT INTO `aauth_login_attempts` VALUES (10, '127.0.0.1', '2019-07-13 20:41:41', 1);
INSERT INTO `aauth_login_attempts` VALUES (11, '127.0.0.1', '2019-07-19 10:29:11', 3);
INSERT INTO `aauth_login_attempts` VALUES (12, '127.0.0.1', '2019-07-19 15:48:31', 1);
INSERT INTO `aauth_login_attempts` VALUES (13, '127.0.0.1', '2019-08-28 15:18:07', 3);
INSERT INTO `aauth_login_attempts` VALUES (14, '127.0.0.1', '2019-08-28 15:33:07', 6);
INSERT INTO `aauth_login_attempts` VALUES (17, '127.0.0.1', '2019-08-29 09:25:14', 1);
INSERT INTO `aauth_login_attempts` VALUES (18, '127.0.0.1', '2019-08-29 09:30:46', 1);

-- ----------------------------
-- Table structure for aauth_perm_to_group
-- ----------------------------
DROP TABLE IF EXISTS `aauth_perm_to_group`;
CREATE TABLE `aauth_perm_to_group`  (
  `perm_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`perm_id`, `group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aauth_perm_to_user
-- ----------------------------
DROP TABLE IF EXISTS `aauth_perm_to_user`;
CREATE TABLE `aauth_perm_to_user`  (
  `perm_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`perm_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aauth_perms
-- ----------------------------
DROP TABLE IF EXISTS `aauth_perms`;
CREATE TABLE `aauth_perms`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `definition` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `controller_method` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `parent_id` int(11) NULL DEFAULT 0,
  `level` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aauth_perms
-- ----------------------------
INSERT INTO `aauth_perms` VALUES (1, 'admin', '管理員', '', 0, 1);
INSERT INTO `aauth_perms` VALUES (2, 'admin_list', '管理員列表，查看', 'admin/admin_list', 1, 2);
INSERT INTO `aauth_perms` VALUES (3, 'admin_edit', '管理員新增編輯', 'admin/admin_edit', 1, 2);
INSERT INTO `aauth_perms` VALUES (4, 'admin_delete', '管理員刪除', 'admin/admin_delete', 1, 2);

-- ----------------------------
-- Table structure for aauth_pms
-- ----------------------------
DROP TABLE IF EXISTS `aauth_pms`;
CREATE TABLE `aauth_pms`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) UNSIGNED NOT NULL,
  `receiver_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `date_sent` datetime(0) NULL DEFAULT NULL,
  `date_read` datetime(0) NULL DEFAULT NULL,
  `pm_deleted_sender` int(1) NULL DEFAULT NULL,
  `pm_deleted_receiver` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `full_index`(`id`, `sender_id`, `receiver_id`, `date_read`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aauth_user_to_group
-- ----------------------------
DROP TABLE IF EXISTS `aauth_user_to_group`;
CREATE TABLE `aauth_user_to_group`  (
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_id`, `group_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aauth_user_to_group
-- ----------------------------
INSERT INTO `aauth_user_to_group` VALUES (1, 1);
INSERT INTO `aauth_user_to_group` VALUES (1, 3);
INSERT INTO `aauth_user_to_group` VALUES (28, 3);
INSERT INTO `aauth_user_to_group` VALUES (28, 4);
INSERT INTO `aauth_user_to_group` VALUES (31, 3);
INSERT INTO `aauth_user_to_group` VALUES (31, 4);
INSERT INTO `aauth_user_to_group` VALUES (32, 3);
INSERT INTO `aauth_user_to_group` VALUES (33, 3);
INSERT INTO `aauth_user_to_group` VALUES (33, 4);
INSERT INTO `aauth_user_to_group` VALUES (34, 3);
INSERT INTO `aauth_user_to_group` VALUES (34, 4);
INSERT INTO `aauth_user_to_group` VALUES (35, 3);
INSERT INTO `aauth_user_to_group` VALUES (35, 4);
INSERT INTO `aauth_user_to_group` VALUES (36, 3);
INSERT INTO `aauth_user_to_group` VALUES (36, 4);
INSERT INTO `aauth_user_to_group` VALUES (37, 3);
INSERT INTO `aauth_user_to_group` VALUES (37, 4);
INSERT INTO `aauth_user_to_group` VALUES (38, 3);
INSERT INTO `aauth_user_to_group` VALUES (38, 4);
INSERT INTO `aauth_user_to_group` VALUES (39, 3);
INSERT INTO `aauth_user_to_group` VALUES (39, 4);
INSERT INTO `aauth_user_to_group` VALUES (40, 3);
INSERT INTO `aauth_user_to_group` VALUES (40, 4);
INSERT INTO `aauth_user_to_group` VALUES (41, 3);
INSERT INTO `aauth_user_to_group` VALUES (41, 4);
INSERT INTO `aauth_user_to_group` VALUES (42, 3);
INSERT INTO `aauth_user_to_group` VALUES (42, 4);
INSERT INTO `aauth_user_to_group` VALUES (43, 3);
INSERT INTO `aauth_user_to_group` VALUES (43, 4);
INSERT INTO `aauth_user_to_group` VALUES (44, 3);
INSERT INTO `aauth_user_to_group` VALUES (44, 4);
INSERT INTO `aauth_user_to_group` VALUES (45, 3);
INSERT INTO `aauth_user_to_group` VALUES (45, 4);
INSERT INTO `aauth_user_to_group` VALUES (46, 3);
INSERT INTO `aauth_user_to_group` VALUES (46, 4);
INSERT INTO `aauth_user_to_group` VALUES (47, 3);
INSERT INTO `aauth_user_to_group` VALUES (47, 4);
INSERT INTO `aauth_user_to_group` VALUES (48, 3);
INSERT INTO `aauth_user_to_group` VALUES (48, 4);
INSERT INTO `aauth_user_to_group` VALUES (49, 3);
INSERT INTO `aauth_user_to_group` VALUES (49, 4);
INSERT INTO `aauth_user_to_group` VALUES (50, 3);
INSERT INTO `aauth_user_to_group` VALUES (50, 4);
INSERT INTO `aauth_user_to_group` VALUES (51, 3);
INSERT INTO `aauth_user_to_group` VALUES (51, 4);
INSERT INTO `aauth_user_to_group` VALUES (52, 3);
INSERT INTO `aauth_user_to_group` VALUES (52, 4);
INSERT INTO `aauth_user_to_group` VALUES (53, 3);
INSERT INTO `aauth_user_to_group` VALUES (53, 4);
INSERT INTO `aauth_user_to_group` VALUES (54, 3);
INSERT INTO `aauth_user_to_group` VALUES (54, 4);
INSERT INTO `aauth_user_to_group` VALUES (55, 3);
INSERT INTO `aauth_user_to_group` VALUES (55, 4);
INSERT INTO `aauth_user_to_group` VALUES (56, 3);
INSERT INTO `aauth_user_to_group` VALUES (56, 4);
INSERT INTO `aauth_user_to_group` VALUES (57, 3);
INSERT INTO `aauth_user_to_group` VALUES (57, 4);
INSERT INTO `aauth_user_to_group` VALUES (58, 3);
INSERT INTO `aauth_user_to_group` VALUES (58, 4);
INSERT INTO `aauth_user_to_group` VALUES (59, 3);
INSERT INTO `aauth_user_to_group` VALUES (59, 4);
INSERT INTO `aauth_user_to_group` VALUES (60, 3);
INSERT INTO `aauth_user_to_group` VALUES (60, 4);
INSERT INTO `aauth_user_to_group` VALUES (61, 3);
INSERT INTO `aauth_user_to_group` VALUES (61, 4);
INSERT INTO `aauth_user_to_group` VALUES (62, 3);
INSERT INTO `aauth_user_to_group` VALUES (62, 4);
INSERT INTO `aauth_user_to_group` VALUES (63, 3);
INSERT INTO `aauth_user_to_group` VALUES (63, 4);
INSERT INTO `aauth_user_to_group` VALUES (64, 3);
INSERT INTO `aauth_user_to_group` VALUES (64, 4);
INSERT INTO `aauth_user_to_group` VALUES (65, 3);
INSERT INTO `aauth_user_to_group` VALUES (65, 4);
INSERT INTO `aauth_user_to_group` VALUES (66, 3);
INSERT INTO `aauth_user_to_group` VALUES (66, 4);
INSERT INTO `aauth_user_to_group` VALUES (67, 3);
INSERT INTO `aauth_user_to_group` VALUES (67, 4);
INSERT INTO `aauth_user_to_group` VALUES (68, 3);
INSERT INTO `aauth_user_to_group` VALUES (68, 4);
INSERT INTO `aauth_user_to_group` VALUES (69, 3);
INSERT INTO `aauth_user_to_group` VALUES (69, 4);
INSERT INTO `aauth_user_to_group` VALUES (70, 3);
INSERT INTO `aauth_user_to_group` VALUES (70, 4);
INSERT INTO `aauth_user_to_group` VALUES (71, 3);
INSERT INTO `aauth_user_to_group` VALUES (71, 4);
INSERT INTO `aauth_user_to_group` VALUES (72, 3);
INSERT INTO `aauth_user_to_group` VALUES (72, 4);
INSERT INTO `aauth_user_to_group` VALUES (73, 3);
INSERT INTO `aauth_user_to_group` VALUES (73, 4);
INSERT INTO `aauth_user_to_group` VALUES (74, 3);
INSERT INTO `aauth_user_to_group` VALUES (74, 4);
INSERT INTO `aauth_user_to_group` VALUES (75, 3);
INSERT INTO `aauth_user_to_group` VALUES (75, 4);
INSERT INTO `aauth_user_to_group` VALUES (76, 3);
INSERT INTO `aauth_user_to_group` VALUES (76, 4);
INSERT INTO `aauth_user_to_group` VALUES (77, 3);
INSERT INTO `aauth_user_to_group` VALUES (77, 4);
INSERT INTO `aauth_user_to_group` VALUES (78, 3);
INSERT INTO `aauth_user_to_group` VALUES (78, 4);
INSERT INTO `aauth_user_to_group` VALUES (79, 3);
INSERT INTO `aauth_user_to_group` VALUES (79, 4);
INSERT INTO `aauth_user_to_group` VALUES (80, 3);
INSERT INTO `aauth_user_to_group` VALUES (80, 4);
INSERT INTO `aauth_user_to_group` VALUES (81, 3);
INSERT INTO `aauth_user_to_group` VALUES (81, 4);
INSERT INTO `aauth_user_to_group` VALUES (82, 3);
INSERT INTO `aauth_user_to_group` VALUES (82, 4);
INSERT INTO `aauth_user_to_group` VALUES (83, 3);
INSERT INTO `aauth_user_to_group` VALUES (83, 4);
INSERT INTO `aauth_user_to_group` VALUES (84, 3);
INSERT INTO `aauth_user_to_group` VALUES (84, 4);
INSERT INTO `aauth_user_to_group` VALUES (85, 3);
INSERT INTO `aauth_user_to_group` VALUES (85, 4);
INSERT INTO `aauth_user_to_group` VALUES (86, 3);
INSERT INTO `aauth_user_to_group` VALUES (86, 4);
INSERT INTO `aauth_user_to_group` VALUES (87, 3);
INSERT INTO `aauth_user_to_group` VALUES (87, 4);
INSERT INTO `aauth_user_to_group` VALUES (88, 3);
INSERT INTO `aauth_user_to_group` VALUES (88, 4);
INSERT INTO `aauth_user_to_group` VALUES (89, 3);
INSERT INTO `aauth_user_to_group` VALUES (89, 4);
INSERT INTO `aauth_user_to_group` VALUES (90, 3);
INSERT INTO `aauth_user_to_group` VALUES (90, 4);
INSERT INTO `aauth_user_to_group` VALUES (91, 3);
INSERT INTO `aauth_user_to_group` VALUES (91, 4);
INSERT INTO `aauth_user_to_group` VALUES (92, 3);
INSERT INTO `aauth_user_to_group` VALUES (92, 4);
INSERT INTO `aauth_user_to_group` VALUES (93, 3);
INSERT INTO `aauth_user_to_group` VALUES (93, 4);
INSERT INTO `aauth_user_to_group` VALUES (94, 3);
INSERT INTO `aauth_user_to_group` VALUES (94, 4);
INSERT INTO `aauth_user_to_group` VALUES (95, 3);
INSERT INTO `aauth_user_to_group` VALUES (95, 4);
INSERT INTO `aauth_user_to_group` VALUES (96, 3);
INSERT INTO `aauth_user_to_group` VALUES (96, 4);
INSERT INTO `aauth_user_to_group` VALUES (97, 3);
INSERT INTO `aauth_user_to_group` VALUES (97, 4);
INSERT INTO `aauth_user_to_group` VALUES (98, 3);
INSERT INTO `aauth_user_to_group` VALUES (98, 4);
INSERT INTO `aauth_user_to_group` VALUES (99, 3);
INSERT INTO `aauth_user_to_group` VALUES (99, 4);
INSERT INTO `aauth_user_to_group` VALUES (100, 3);
INSERT INTO `aauth_user_to_group` VALUES (100, 4);
INSERT INTO `aauth_user_to_group` VALUES (101, 3);
INSERT INTO `aauth_user_to_group` VALUES (101, 4);
INSERT INTO `aauth_user_to_group` VALUES (102, 3);
INSERT INTO `aauth_user_to_group` VALUES (102, 4);
INSERT INTO `aauth_user_to_group` VALUES (103, 3);
INSERT INTO `aauth_user_to_group` VALUES (103, 4);
INSERT INTO `aauth_user_to_group` VALUES (104, 3);
INSERT INTO `aauth_user_to_group` VALUES (104, 4);
INSERT INTO `aauth_user_to_group` VALUES (105, 3);
INSERT INTO `aauth_user_to_group` VALUES (105, 4);
INSERT INTO `aauth_user_to_group` VALUES (106, 3);
INSERT INTO `aauth_user_to_group` VALUES (106, 4);
INSERT INTO `aauth_user_to_group` VALUES (107, 3);
INSERT INTO `aauth_user_to_group` VALUES (107, 4);
INSERT INTO `aauth_user_to_group` VALUES (108, 3);
INSERT INTO `aauth_user_to_group` VALUES (108, 4);
INSERT INTO `aauth_user_to_group` VALUES (109, 3);
INSERT INTO `aauth_user_to_group` VALUES (109, 4);
INSERT INTO `aauth_user_to_group` VALUES (110, 3);
INSERT INTO `aauth_user_to_group` VALUES (110, 4);
INSERT INTO `aauth_user_to_group` VALUES (111, 3);
INSERT INTO `aauth_user_to_group` VALUES (111, 4);
INSERT INTO `aauth_user_to_group` VALUES (112, 3);
INSERT INTO `aauth_user_to_group` VALUES (112, 4);
INSERT INTO `aauth_user_to_group` VALUES (113, 3);
INSERT INTO `aauth_user_to_group` VALUES (113, 4);
INSERT INTO `aauth_user_to_group` VALUES (114, 3);
INSERT INTO `aauth_user_to_group` VALUES (114, 4);
INSERT INTO `aauth_user_to_group` VALUES (115, 3);
INSERT INTO `aauth_user_to_group` VALUES (115, 4);
INSERT INTO `aauth_user_to_group` VALUES (116, 3);
INSERT INTO `aauth_user_to_group` VALUES (116, 4);
INSERT INTO `aauth_user_to_group` VALUES (117, 3);
INSERT INTO `aauth_user_to_group` VALUES (117, 4);
INSERT INTO `aauth_user_to_group` VALUES (118, 3);
INSERT INTO `aauth_user_to_group` VALUES (118, 4);
INSERT INTO `aauth_user_to_group` VALUES (119, 3);
INSERT INTO `aauth_user_to_group` VALUES (119, 4);
INSERT INTO `aauth_user_to_group` VALUES (120, 3);
INSERT INTO `aauth_user_to_group` VALUES (120, 4);
INSERT INTO `aauth_user_to_group` VALUES (121, 3);
INSERT INTO `aauth_user_to_group` VALUES (121, 4);
INSERT INTO `aauth_user_to_group` VALUES (122, 3);
INSERT INTO `aauth_user_to_group` VALUES (122, 4);
INSERT INTO `aauth_user_to_group` VALUES (123, 3);
INSERT INTO `aauth_user_to_group` VALUES (123, 4);
INSERT INTO `aauth_user_to_group` VALUES (124, 3);
INSERT INTO `aauth_user_to_group` VALUES (124, 4);
INSERT INTO `aauth_user_to_group` VALUES (125, 3);
INSERT INTO `aauth_user_to_group` VALUES (125, 4);
INSERT INTO `aauth_user_to_group` VALUES (126, 3);
INSERT INTO `aauth_user_to_group` VALUES (126, 4);
INSERT INTO `aauth_user_to_group` VALUES (127, 3);
INSERT INTO `aauth_user_to_group` VALUES (127, 4);
INSERT INTO `aauth_user_to_group` VALUES (128, 3);
INSERT INTO `aauth_user_to_group` VALUES (128, 4);
INSERT INTO `aauth_user_to_group` VALUES (129, 3);
INSERT INTO `aauth_user_to_group` VALUES (129, 4);
INSERT INTO `aauth_user_to_group` VALUES (130, 3);
INSERT INTO `aauth_user_to_group` VALUES (130, 4);
INSERT INTO `aauth_user_to_group` VALUES (131, 3);
INSERT INTO `aauth_user_to_group` VALUES (131, 4);
INSERT INTO `aauth_user_to_group` VALUES (132, 3);
INSERT INTO `aauth_user_to_group` VALUES (132, 4);
INSERT INTO `aauth_user_to_group` VALUES (133, 3);
INSERT INTO `aauth_user_to_group` VALUES (133, 4);
INSERT INTO `aauth_user_to_group` VALUES (134, 3);
INSERT INTO `aauth_user_to_group` VALUES (134, 4);
INSERT INTO `aauth_user_to_group` VALUES (135, 3);
INSERT INTO `aauth_user_to_group` VALUES (135, 4);
INSERT INTO `aauth_user_to_group` VALUES (136, 3);
INSERT INTO `aauth_user_to_group` VALUES (136, 4);
INSERT INTO `aauth_user_to_group` VALUES (137, 3);
INSERT INTO `aauth_user_to_group` VALUES (137, 4);
INSERT INTO `aauth_user_to_group` VALUES (138, 3);
INSERT INTO `aauth_user_to_group` VALUES (138, 4);
INSERT INTO `aauth_user_to_group` VALUES (139, 3);
INSERT INTO `aauth_user_to_group` VALUES (139, 4);
INSERT INTO `aauth_user_to_group` VALUES (140, 3);
INSERT INTO `aauth_user_to_group` VALUES (140, 4);
INSERT INTO `aauth_user_to_group` VALUES (141, 3);
INSERT INTO `aauth_user_to_group` VALUES (141, 4);
INSERT INTO `aauth_user_to_group` VALUES (142, 3);
INSERT INTO `aauth_user_to_group` VALUES (142, 4);
INSERT INTO `aauth_user_to_group` VALUES (143, 3);
INSERT INTO `aauth_user_to_group` VALUES (143, 4);
INSERT INTO `aauth_user_to_group` VALUES (144, 3);
INSERT INTO `aauth_user_to_group` VALUES (144, 4);
INSERT INTO `aauth_user_to_group` VALUES (145, 3);
INSERT INTO `aauth_user_to_group` VALUES (145, 4);
INSERT INTO `aauth_user_to_group` VALUES (146, 3);
INSERT INTO `aauth_user_to_group` VALUES (146, 4);
INSERT INTO `aauth_user_to_group` VALUES (147, 3);
INSERT INTO `aauth_user_to_group` VALUES (147, 4);
INSERT INTO `aauth_user_to_group` VALUES (148, 3);
INSERT INTO `aauth_user_to_group` VALUES (148, 4);
INSERT INTO `aauth_user_to_group` VALUES (149, 3);
INSERT INTO `aauth_user_to_group` VALUES (149, 4);
INSERT INTO `aauth_user_to_group` VALUES (150, 3);
INSERT INTO `aauth_user_to_group` VALUES (150, 4);
INSERT INTO `aauth_user_to_group` VALUES (151, 3);
INSERT INTO `aauth_user_to_group` VALUES (151, 4);
INSERT INTO `aauth_user_to_group` VALUES (152, 3);
INSERT INTO `aauth_user_to_group` VALUES (152, 4);
INSERT INTO `aauth_user_to_group` VALUES (153, 3);
INSERT INTO `aauth_user_to_group` VALUES (153, 4);
INSERT INTO `aauth_user_to_group` VALUES (154, 3);
INSERT INTO `aauth_user_to_group` VALUES (154, 4);
INSERT INTO `aauth_user_to_group` VALUES (155, 3);
INSERT INTO `aauth_user_to_group` VALUES (155, 4);
INSERT INTO `aauth_user_to_group` VALUES (156, 3);
INSERT INTO `aauth_user_to_group` VALUES (156, 4);
INSERT INTO `aauth_user_to_group` VALUES (157, 3);
INSERT INTO `aauth_user_to_group` VALUES (157, 4);
INSERT INTO `aauth_user_to_group` VALUES (158, 3);
INSERT INTO `aauth_user_to_group` VALUES (158, 4);
INSERT INTO `aauth_user_to_group` VALUES (159, 3);
INSERT INTO `aauth_user_to_group` VALUES (159, 4);
INSERT INTO `aauth_user_to_group` VALUES (160, 3);
INSERT INTO `aauth_user_to_group` VALUES (160, 4);
INSERT INTO `aauth_user_to_group` VALUES (161, 3);
INSERT INTO `aauth_user_to_group` VALUES (161, 4);
INSERT INTO `aauth_user_to_group` VALUES (162, 3);
INSERT INTO `aauth_user_to_group` VALUES (162, 4);
INSERT INTO `aauth_user_to_group` VALUES (163, 3);
INSERT INTO `aauth_user_to_group` VALUES (163, 4);
INSERT INTO `aauth_user_to_group` VALUES (164, 3);
INSERT INTO `aauth_user_to_group` VALUES (164, 4);
INSERT INTO `aauth_user_to_group` VALUES (165, 3);
INSERT INTO `aauth_user_to_group` VALUES (165, 4);
INSERT INTO `aauth_user_to_group` VALUES (166, 3);
INSERT INTO `aauth_user_to_group` VALUES (166, 4);
INSERT INTO `aauth_user_to_group` VALUES (167, 3);
INSERT INTO `aauth_user_to_group` VALUES (167, 4);
INSERT INTO `aauth_user_to_group` VALUES (168, 3);
INSERT INTO `aauth_user_to_group` VALUES (168, 4);
INSERT INTO `aauth_user_to_group` VALUES (169, 3);
INSERT INTO `aauth_user_to_group` VALUES (169, 4);
INSERT INTO `aauth_user_to_group` VALUES (170, 3);
INSERT INTO `aauth_user_to_group` VALUES (170, 4);
INSERT INTO `aauth_user_to_group` VALUES (171, 3);
INSERT INTO `aauth_user_to_group` VALUES (171, 4);
INSERT INTO `aauth_user_to_group` VALUES (172, 3);
INSERT INTO `aauth_user_to_group` VALUES (172, 4);
INSERT INTO `aauth_user_to_group` VALUES (173, 3);
INSERT INTO `aauth_user_to_group` VALUES (173, 4);
INSERT INTO `aauth_user_to_group` VALUES (174, 3);
INSERT INTO `aauth_user_to_group` VALUES (174, 4);
INSERT INTO `aauth_user_to_group` VALUES (175, 3);
INSERT INTO `aauth_user_to_group` VALUES (175, 4);
INSERT INTO `aauth_user_to_group` VALUES (176, 3);
INSERT INTO `aauth_user_to_group` VALUES (176, 4);
INSERT INTO `aauth_user_to_group` VALUES (177, 3);
INSERT INTO `aauth_user_to_group` VALUES (177, 4);
INSERT INTO `aauth_user_to_group` VALUES (178, 3);
INSERT INTO `aauth_user_to_group` VALUES (178, 4);
INSERT INTO `aauth_user_to_group` VALUES (179, 3);
INSERT INTO `aauth_user_to_group` VALUES (179, 4);
INSERT INTO `aauth_user_to_group` VALUES (180, 3);
INSERT INTO `aauth_user_to_group` VALUES (180, 4);
INSERT INTO `aauth_user_to_group` VALUES (181, 3);
INSERT INTO `aauth_user_to_group` VALUES (181, 4);
INSERT INTO `aauth_user_to_group` VALUES (182, 3);
INSERT INTO `aauth_user_to_group` VALUES (182, 4);
INSERT INTO `aauth_user_to_group` VALUES (183, 3);
INSERT INTO `aauth_user_to_group` VALUES (183, 4);
INSERT INTO `aauth_user_to_group` VALUES (184, 3);
INSERT INTO `aauth_user_to_group` VALUES (184, 4);
INSERT INTO `aauth_user_to_group` VALUES (185, 3);
INSERT INTO `aauth_user_to_group` VALUES (185, 4);
INSERT INTO `aauth_user_to_group` VALUES (186, 3);
INSERT INTO `aauth_user_to_group` VALUES (186, 4);
INSERT INTO `aauth_user_to_group` VALUES (187, 3);
INSERT INTO `aauth_user_to_group` VALUES (187, 4);
INSERT INTO `aauth_user_to_group` VALUES (188, 3);
INSERT INTO `aauth_user_to_group` VALUES (188, 4);
INSERT INTO `aauth_user_to_group` VALUES (189, 3);
INSERT INTO `aauth_user_to_group` VALUES (189, 4);
INSERT INTO `aauth_user_to_group` VALUES (190, 3);
INSERT INTO `aauth_user_to_group` VALUES (190, 4);
INSERT INTO `aauth_user_to_group` VALUES (191, 3);
INSERT INTO `aauth_user_to_group` VALUES (191, 4);
INSERT INTO `aauth_user_to_group` VALUES (192, 3);
INSERT INTO `aauth_user_to_group` VALUES (192, 4);
INSERT INTO `aauth_user_to_group` VALUES (193, 3);
INSERT INTO `aauth_user_to_group` VALUES (193, 4);
INSERT INTO `aauth_user_to_group` VALUES (194, 3);
INSERT INTO `aauth_user_to_group` VALUES (194, 4);
INSERT INTO `aauth_user_to_group` VALUES (195, 3);
INSERT INTO `aauth_user_to_group` VALUES (195, 4);
INSERT INTO `aauth_user_to_group` VALUES (196, 3);
INSERT INTO `aauth_user_to_group` VALUES (196, 4);
INSERT INTO `aauth_user_to_group` VALUES (197, 3);
INSERT INTO `aauth_user_to_group` VALUES (197, 4);
INSERT INTO `aauth_user_to_group` VALUES (198, 3);
INSERT INTO `aauth_user_to_group` VALUES (198, 4);
INSERT INTO `aauth_user_to_group` VALUES (199, 3);
INSERT INTO `aauth_user_to_group` VALUES (199, 4);
INSERT INTO `aauth_user_to_group` VALUES (200, 3);
INSERT INTO `aauth_user_to_group` VALUES (200, 4);
INSERT INTO `aauth_user_to_group` VALUES (201, 3);
INSERT INTO `aauth_user_to_group` VALUES (201, 4);
INSERT INTO `aauth_user_to_group` VALUES (202, 3);
INSERT INTO `aauth_user_to_group` VALUES (202, 4);
INSERT INTO `aauth_user_to_group` VALUES (203, 3);
INSERT INTO `aauth_user_to_group` VALUES (203, 4);
INSERT INTO `aauth_user_to_group` VALUES (204, 3);
INSERT INTO `aauth_user_to_group` VALUES (204, 4);
INSERT INTO `aauth_user_to_group` VALUES (205, 3);
INSERT INTO `aauth_user_to_group` VALUES (205, 4);
INSERT INTO `aauth_user_to_group` VALUES (206, 3);
INSERT INTO `aauth_user_to_group` VALUES (206, 4);
INSERT INTO `aauth_user_to_group` VALUES (207, 3);
INSERT INTO `aauth_user_to_group` VALUES (207, 4);
INSERT INTO `aauth_user_to_group` VALUES (208, 3);
INSERT INTO `aauth_user_to_group` VALUES (208, 4);
INSERT INTO `aauth_user_to_group` VALUES (209, 3);
INSERT INTO `aauth_user_to_group` VALUES (209, 4);
INSERT INTO `aauth_user_to_group` VALUES (210, 3);
INSERT INTO `aauth_user_to_group` VALUES (210, 4);
INSERT INTO `aauth_user_to_group` VALUES (211, 3);
INSERT INTO `aauth_user_to_group` VALUES (211, 4);
INSERT INTO `aauth_user_to_group` VALUES (212, 3);
INSERT INTO `aauth_user_to_group` VALUES (212, 4);
INSERT INTO `aauth_user_to_group` VALUES (213, 3);
INSERT INTO `aauth_user_to_group` VALUES (213, 4);
INSERT INTO `aauth_user_to_group` VALUES (214, 3);
INSERT INTO `aauth_user_to_group` VALUES (214, 4);
INSERT INTO `aauth_user_to_group` VALUES (215, 3);
INSERT INTO `aauth_user_to_group` VALUES (215, 4);
INSERT INTO `aauth_user_to_group` VALUES (216, 3);
INSERT INTO `aauth_user_to_group` VALUES (216, 4);
INSERT INTO `aauth_user_to_group` VALUES (217, 3);
INSERT INTO `aauth_user_to_group` VALUES (217, 4);
INSERT INTO `aauth_user_to_group` VALUES (218, 3);
INSERT INTO `aauth_user_to_group` VALUES (218, 4);
INSERT INTO `aauth_user_to_group` VALUES (219, 3);
INSERT INTO `aauth_user_to_group` VALUES (219, 4);
INSERT INTO `aauth_user_to_group` VALUES (220, 3);
INSERT INTO `aauth_user_to_group` VALUES (220, 4);
INSERT INTO `aauth_user_to_group` VALUES (221, 3);
INSERT INTO `aauth_user_to_group` VALUES (221, 4);
INSERT INTO `aauth_user_to_group` VALUES (222, 3);
INSERT INTO `aauth_user_to_group` VALUES (222, 4);
INSERT INTO `aauth_user_to_group` VALUES (223, 3);
INSERT INTO `aauth_user_to_group` VALUES (223, 4);
INSERT INTO `aauth_user_to_group` VALUES (224, 3);
INSERT INTO `aauth_user_to_group` VALUES (224, 4);
INSERT INTO `aauth_user_to_group` VALUES (225, 3);
INSERT INTO `aauth_user_to_group` VALUES (225, 4);
INSERT INTO `aauth_user_to_group` VALUES (226, 3);
INSERT INTO `aauth_user_to_group` VALUES (226, 4);
INSERT INTO `aauth_user_to_group` VALUES (227, 3);
INSERT INTO `aauth_user_to_group` VALUES (227, 4);
INSERT INTO `aauth_user_to_group` VALUES (228, 3);
INSERT INTO `aauth_user_to_group` VALUES (228, 4);
INSERT INTO `aauth_user_to_group` VALUES (229, 3);
INSERT INTO `aauth_user_to_group` VALUES (229, 4);
INSERT INTO `aauth_user_to_group` VALUES (230, 3);
INSERT INTO `aauth_user_to_group` VALUES (230, 4);
INSERT INTO `aauth_user_to_group` VALUES (231, 3);
INSERT INTO `aauth_user_to_group` VALUES (231, 4);
INSERT INTO `aauth_user_to_group` VALUES (232, 3);
INSERT INTO `aauth_user_to_group` VALUES (232, 4);
INSERT INTO `aauth_user_to_group` VALUES (233, 3);
INSERT INTO `aauth_user_to_group` VALUES (233, 4);
INSERT INTO `aauth_user_to_group` VALUES (234, 3);
INSERT INTO `aauth_user_to_group` VALUES (234, 4);
INSERT INTO `aauth_user_to_group` VALUES (235, 3);
INSERT INTO `aauth_user_to_group` VALUES (235, 4);
INSERT INTO `aauth_user_to_group` VALUES (236, 3);
INSERT INTO `aauth_user_to_group` VALUES (236, 4);
INSERT INTO `aauth_user_to_group` VALUES (237, 3);
INSERT INTO `aauth_user_to_group` VALUES (237, 4);
INSERT INTO `aauth_user_to_group` VALUES (238, 3);
INSERT INTO `aauth_user_to_group` VALUES (238, 4);
INSERT INTO `aauth_user_to_group` VALUES (239, 3);
INSERT INTO `aauth_user_to_group` VALUES (239, 4);
INSERT INTO `aauth_user_to_group` VALUES (240, 3);
INSERT INTO `aauth_user_to_group` VALUES (240, 4);
INSERT INTO `aauth_user_to_group` VALUES (241, 3);
INSERT INTO `aauth_user_to_group` VALUES (241, 4);
INSERT INTO `aauth_user_to_group` VALUES (242, 3);
INSERT INTO `aauth_user_to_group` VALUES (242, 4);
INSERT INTO `aauth_user_to_group` VALUES (243, 3);
INSERT INTO `aauth_user_to_group` VALUES (243, 4);
INSERT INTO `aauth_user_to_group` VALUES (244, 3);
INSERT INTO `aauth_user_to_group` VALUES (244, 4);
INSERT INTO `aauth_user_to_group` VALUES (245, 3);
INSERT INTO `aauth_user_to_group` VALUES (245, 4);
INSERT INTO `aauth_user_to_group` VALUES (246, 3);
INSERT INTO `aauth_user_to_group` VALUES (246, 4);
INSERT INTO `aauth_user_to_group` VALUES (247, 3);
INSERT INTO `aauth_user_to_group` VALUES (247, 4);
INSERT INTO `aauth_user_to_group` VALUES (248, 3);
INSERT INTO `aauth_user_to_group` VALUES (248, 4);
INSERT INTO `aauth_user_to_group` VALUES (249, 3);
INSERT INTO `aauth_user_to_group` VALUES (249, 4);
INSERT INTO `aauth_user_to_group` VALUES (250, 3);
INSERT INTO `aauth_user_to_group` VALUES (250, 4);
INSERT INTO `aauth_user_to_group` VALUES (251, 3);
INSERT INTO `aauth_user_to_group` VALUES (251, 4);
INSERT INTO `aauth_user_to_group` VALUES (252, 3);
INSERT INTO `aauth_user_to_group` VALUES (252, 4);
INSERT INTO `aauth_user_to_group` VALUES (253, 3);
INSERT INTO `aauth_user_to_group` VALUES (253, 4);
INSERT INTO `aauth_user_to_group` VALUES (254, 3);
INSERT INTO `aauth_user_to_group` VALUES (254, 4);
INSERT INTO `aauth_user_to_group` VALUES (255, 3);
INSERT INTO `aauth_user_to_group` VALUES (255, 4);
INSERT INTO `aauth_user_to_group` VALUES (256, 3);
INSERT INTO `aauth_user_to_group` VALUES (256, 4);
INSERT INTO `aauth_user_to_group` VALUES (257, 3);
INSERT INTO `aauth_user_to_group` VALUES (257, 4);
INSERT INTO `aauth_user_to_group` VALUES (258, 3);
INSERT INTO `aauth_user_to_group` VALUES (258, 4);
INSERT INTO `aauth_user_to_group` VALUES (259, 3);
INSERT INTO `aauth_user_to_group` VALUES (259, 4);
INSERT INTO `aauth_user_to_group` VALUES (260, 3);
INSERT INTO `aauth_user_to_group` VALUES (260, 4);
INSERT INTO `aauth_user_to_group` VALUES (261, 3);
INSERT INTO `aauth_user_to_group` VALUES (261, 4);
INSERT INTO `aauth_user_to_group` VALUES (262, 3);
INSERT INTO `aauth_user_to_group` VALUES (262, 4);
INSERT INTO `aauth_user_to_group` VALUES (263, 3);
INSERT INTO `aauth_user_to_group` VALUES (263, 4);
INSERT INTO `aauth_user_to_group` VALUES (264, 3);
INSERT INTO `aauth_user_to_group` VALUES (264, 4);
INSERT INTO `aauth_user_to_group` VALUES (265, 3);
INSERT INTO `aauth_user_to_group` VALUES (265, 4);
INSERT INTO `aauth_user_to_group` VALUES (266, 3);
INSERT INTO `aauth_user_to_group` VALUES (266, 4);
INSERT INTO `aauth_user_to_group` VALUES (267, 3);
INSERT INTO `aauth_user_to_group` VALUES (267, 4);
INSERT INTO `aauth_user_to_group` VALUES (268, 3);
INSERT INTO `aauth_user_to_group` VALUES (268, 4);
INSERT INTO `aauth_user_to_group` VALUES (269, 3);
INSERT INTO `aauth_user_to_group` VALUES (269, 4);
INSERT INTO `aauth_user_to_group` VALUES (270, 3);
INSERT INTO `aauth_user_to_group` VALUES (270, 4);
INSERT INTO `aauth_user_to_group` VALUES (271, 3);
INSERT INTO `aauth_user_to_group` VALUES (271, 4);
INSERT INTO `aauth_user_to_group` VALUES (272, 3);
INSERT INTO `aauth_user_to_group` VALUES (272, 4);
INSERT INTO `aauth_user_to_group` VALUES (273, 3);
INSERT INTO `aauth_user_to_group` VALUES (273, 4);
INSERT INTO `aauth_user_to_group` VALUES (274, 3);
INSERT INTO `aauth_user_to_group` VALUES (274, 4);
INSERT INTO `aauth_user_to_group` VALUES (275, 3);
INSERT INTO `aauth_user_to_group` VALUES (275, 4);
INSERT INTO `aauth_user_to_group` VALUES (276, 3);
INSERT INTO `aauth_user_to_group` VALUES (276, 4);
INSERT INTO `aauth_user_to_group` VALUES (277, 3);
INSERT INTO `aauth_user_to_group` VALUES (277, 4);
INSERT INTO `aauth_user_to_group` VALUES (278, 3);
INSERT INTO `aauth_user_to_group` VALUES (278, 4);
INSERT INTO `aauth_user_to_group` VALUES (279, 3);
INSERT INTO `aauth_user_to_group` VALUES (279, 4);
INSERT INTO `aauth_user_to_group` VALUES (280, 3);
INSERT INTO `aauth_user_to_group` VALUES (280, 4);
INSERT INTO `aauth_user_to_group` VALUES (281, 3);
INSERT INTO `aauth_user_to_group` VALUES (281, 4);
INSERT INTO `aauth_user_to_group` VALUES (282, 3);
INSERT INTO `aauth_user_to_group` VALUES (282, 4);
INSERT INTO `aauth_user_to_group` VALUES (283, 3);
INSERT INTO `aauth_user_to_group` VALUES (283, 4);
INSERT INTO `aauth_user_to_group` VALUES (284, 3);
INSERT INTO `aauth_user_to_group` VALUES (284, 4);
INSERT INTO `aauth_user_to_group` VALUES (285, 3);
INSERT INTO `aauth_user_to_group` VALUES (285, 4);
INSERT INTO `aauth_user_to_group` VALUES (286, 3);
INSERT INTO `aauth_user_to_group` VALUES (286, 4);
INSERT INTO `aauth_user_to_group` VALUES (287, 3);
INSERT INTO `aauth_user_to_group` VALUES (287, 4);
INSERT INTO `aauth_user_to_group` VALUES (288, 3);
INSERT INTO `aauth_user_to_group` VALUES (288, 4);
INSERT INTO `aauth_user_to_group` VALUES (289, 3);
INSERT INTO `aauth_user_to_group` VALUES (289, 4);
INSERT INTO `aauth_user_to_group` VALUES (290, 3);
INSERT INTO `aauth_user_to_group` VALUES (290, 4);
INSERT INTO `aauth_user_to_group` VALUES (291, 3);
INSERT INTO `aauth_user_to_group` VALUES (291, 4);
INSERT INTO `aauth_user_to_group` VALUES (292, 3);
INSERT INTO `aauth_user_to_group` VALUES (292, 4);
INSERT INTO `aauth_user_to_group` VALUES (293, 3);
INSERT INTO `aauth_user_to_group` VALUES (293, 4);
INSERT INTO `aauth_user_to_group` VALUES (294, 3);
INSERT INTO `aauth_user_to_group` VALUES (294, 4);
INSERT INTO `aauth_user_to_group` VALUES (295, 3);
INSERT INTO `aauth_user_to_group` VALUES (295, 4);
INSERT INTO `aauth_user_to_group` VALUES (296, 3);
INSERT INTO `aauth_user_to_group` VALUES (296, 4);
INSERT INTO `aauth_user_to_group` VALUES (297, 3);
INSERT INTO `aauth_user_to_group` VALUES (297, 4);
INSERT INTO `aauth_user_to_group` VALUES (298, 3);
INSERT INTO `aauth_user_to_group` VALUES (298, 4);
INSERT INTO `aauth_user_to_group` VALUES (299, 3);
INSERT INTO `aauth_user_to_group` VALUES (299, 4);
INSERT INTO `aauth_user_to_group` VALUES (300, 3);
INSERT INTO `aauth_user_to_group` VALUES (300, 4);
INSERT INTO `aauth_user_to_group` VALUES (301, 3);
INSERT INTO `aauth_user_to_group` VALUES (301, 4);
INSERT INTO `aauth_user_to_group` VALUES (302, 3);
INSERT INTO `aauth_user_to_group` VALUES (302, 4);
INSERT INTO `aauth_user_to_group` VALUES (303, 3);
INSERT INTO `aauth_user_to_group` VALUES (303, 4);
INSERT INTO `aauth_user_to_group` VALUES (304, 3);
INSERT INTO `aauth_user_to_group` VALUES (304, 4);
INSERT INTO `aauth_user_to_group` VALUES (305, 3);
INSERT INTO `aauth_user_to_group` VALUES (305, 4);
INSERT INTO `aauth_user_to_group` VALUES (306, 3);
INSERT INTO `aauth_user_to_group` VALUES (306, 4);
INSERT INTO `aauth_user_to_group` VALUES (307, 3);
INSERT INTO `aauth_user_to_group` VALUES (307, 4);
INSERT INTO `aauth_user_to_group` VALUES (308, 3);
INSERT INTO `aauth_user_to_group` VALUES (308, 4);
INSERT INTO `aauth_user_to_group` VALUES (309, 3);
INSERT INTO `aauth_user_to_group` VALUES (309, 4);
INSERT INTO `aauth_user_to_group` VALUES (310, 3);
INSERT INTO `aauth_user_to_group` VALUES (310, 4);
INSERT INTO `aauth_user_to_group` VALUES (311, 3);
INSERT INTO `aauth_user_to_group` VALUES (311, 4);
INSERT INTO `aauth_user_to_group` VALUES (312, 3);
INSERT INTO `aauth_user_to_group` VALUES (312, 4);
INSERT INTO `aauth_user_to_group` VALUES (313, 3);
INSERT INTO `aauth_user_to_group` VALUES (313, 4);
INSERT INTO `aauth_user_to_group` VALUES (314, 3);
INSERT INTO `aauth_user_to_group` VALUES (314, 4);
INSERT INTO `aauth_user_to_group` VALUES (315, 3);
INSERT INTO `aauth_user_to_group` VALUES (315, 4);
INSERT INTO `aauth_user_to_group` VALUES (316, 3);
INSERT INTO `aauth_user_to_group` VALUES (316, 4);
INSERT INTO `aauth_user_to_group` VALUES (317, 3);
INSERT INTO `aauth_user_to_group` VALUES (317, 4);
INSERT INTO `aauth_user_to_group` VALUES (318, 3);
INSERT INTO `aauth_user_to_group` VALUES (318, 4);
INSERT INTO `aauth_user_to_group` VALUES (319, 3);
INSERT INTO `aauth_user_to_group` VALUES (319, 4);
INSERT INTO `aauth_user_to_group` VALUES (320, 3);
INSERT INTO `aauth_user_to_group` VALUES (320, 4);
INSERT INTO `aauth_user_to_group` VALUES (321, 3);
INSERT INTO `aauth_user_to_group` VALUES (321, 4);
INSERT INTO `aauth_user_to_group` VALUES (322, 3);
INSERT INTO `aauth_user_to_group` VALUES (322, 4);
INSERT INTO `aauth_user_to_group` VALUES (323, 3);
INSERT INTO `aauth_user_to_group` VALUES (323, 4);
INSERT INTO `aauth_user_to_group` VALUES (324, 3);
INSERT INTO `aauth_user_to_group` VALUES (324, 4);
INSERT INTO `aauth_user_to_group` VALUES (325, 3);
INSERT INTO `aauth_user_to_group` VALUES (325, 4);
INSERT INTO `aauth_user_to_group` VALUES (326, 3);
INSERT INTO `aauth_user_to_group` VALUES (326, 4);
INSERT INTO `aauth_user_to_group` VALUES (327, 3);
INSERT INTO `aauth_user_to_group` VALUES (327, 4);
INSERT INTO `aauth_user_to_group` VALUES (328, 3);
INSERT INTO `aauth_user_to_group` VALUES (328, 4);
INSERT INTO `aauth_user_to_group` VALUES (329, 3);
INSERT INTO `aauth_user_to_group` VALUES (329, 4);
INSERT INTO `aauth_user_to_group` VALUES (330, 3);
INSERT INTO `aauth_user_to_group` VALUES (330, 4);
INSERT INTO `aauth_user_to_group` VALUES (331, 3);
INSERT INTO `aauth_user_to_group` VALUES (331, 4);
INSERT INTO `aauth_user_to_group` VALUES (332, 3);
INSERT INTO `aauth_user_to_group` VALUES (332, 4);
INSERT INTO `aauth_user_to_group` VALUES (333, 3);
INSERT INTO `aauth_user_to_group` VALUES (333, 4);
INSERT INTO `aauth_user_to_group` VALUES (334, 3);
INSERT INTO `aauth_user_to_group` VALUES (334, 4);
INSERT INTO `aauth_user_to_group` VALUES (335, 3);
INSERT INTO `aauth_user_to_group` VALUES (335, 4);
INSERT INTO `aauth_user_to_group` VALUES (336, 3);
INSERT INTO `aauth_user_to_group` VALUES (336, 4);
INSERT INTO `aauth_user_to_group` VALUES (337, 3);
INSERT INTO `aauth_user_to_group` VALUES (337, 4);
INSERT INTO `aauth_user_to_group` VALUES (338, 3);
INSERT INTO `aauth_user_to_group` VALUES (338, 4);
INSERT INTO `aauth_user_to_group` VALUES (339, 3);
INSERT INTO `aauth_user_to_group` VALUES (339, 4);
INSERT INTO `aauth_user_to_group` VALUES (340, 3);
INSERT INTO `aauth_user_to_group` VALUES (340, 4);

-- ----------------------------
-- Table structure for aauth_user_variables
-- ----------------------------
DROP TABLE IF EXISTS `aauth_user_variables`;
CREATE TABLE `aauth_user_variables`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `data_key` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for aauth_users
-- ----------------------------
DROP TABLE IF EXISTS `aauth_users`;
CREATE TABLE `aauth_users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pass` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `banned` tinyint(1) NULL DEFAULT 0,
  `last_login` datetime(0) NULL DEFAULT NULL,
  `last_activity` datetime(0) NULL DEFAULT NULL,
  `date_created` datetime(0) NULL DEFAULT NULL,
  `forgot_exp` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `remember_time` datetime(0) NULL DEFAULT NULL,
  `remember_exp` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `verification_code` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `totp_secret` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ip_address` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `base_id` int(11) NULL DEFAULT 0,
  `is_ok` int(2) NULL DEFAULT 1,
  `full_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 341 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aauth_users
-- ----------------------------
INSERT INTO `aauth_users` VALUES (1, 'admin@example.com', '$2y$10$iSGAqyzkpkXc0MZ/Hlii..qYr809Flzgem5CkGVOEeI0NDNaVj2qi', 'admin', 0, '2019-12-26 14:10:40', '2019-12-26 14:10:40', NULL, NULL, '2019-11-24 00:00:00', '0bRcQol32AOtydZz', '', NULL, '113.246.106.189', 0, 1, NULL);
INSERT INTO `aauth_users` VALUES (28, 'store_admin@hdd.store.com', '$2y$10$zwXhUfgHoqoQJN44RQQN0.i5E7S0uaZFe43P6/DGpKrn8filCnYvK', 'store_admin', 0, '2019-10-20 23:11:02', '2019-10-20 23:11:02', '2019-09-06 18:26:26', NULL, NULL, NULL, NULL, NULL, '127.0.0.1', 0, 1, '');
INSERT INTO `aauth_users` VALUES (31, 'store1_admin@hdd.store.com', '$2y$10$XLISajzuJ/pVjZmj0oPitePDvkNiI0BSZQIxH5xvTIroHEx043szy', 'store1_admin', 0, NULL, NULL, '2019-09-09 10:27:19', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (32, 'forestdai@vip.qq.com', '$2y$10$Wg/Rki8ZXjWOzQjPmjgWTuYDJiaRRw4q9qtXpNqP4YN8VGNUrKrG6', 'senlin', 0, NULL, NULL, '2019-10-09 10:56:36', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 'senln');
INSERT INTO `aauth_users` VALUES (33, 'A0001@hdd.store.com', '$2y$10$uneG086/BAVfGn.2fcpGQ.TUJVewW21X9CfBCypqmoteqqoH/eZTq', 'A0001', 0, NULL, NULL, '2019-10-16 10:44:35', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (34, 'A0002@hdd.store.com', '$2y$10$0k4u9Y0s5OXGOqGtmRiwj.cHEfbGDikRpenFh8gT6.c8CR9AVPIY6', 'A0002', 0, NULL, NULL, '2019-10-16 10:44:36', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (35, 'A0003@hdd.store.com', '$2y$10$mH1xn9bZzt70BZzWKFN9EOJUkm/KyGCkQxm9/LEw5d7bn8CjDaJUa', 'A0003', 0, NULL, NULL, '2019-10-16 10:44:38', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (36, 'A0004@hdd.store.com', '$2y$10$qc783kkrpjsFrZgCIp5PjuY3.Mr9vpgPAgOp4ympqs0WpnMeyNdYi', 'A0004', 0, NULL, NULL, '2019-10-16 10:44:38', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (37, 'A0005@hdd.store.com', '$2y$10$sAnKvsKwofu6Jwibzm59EukpbU4O0xlkxSVGPHNL9ZhE/6//J6qpu', 'A0005', 0, NULL, NULL, '2019-10-16 10:44:40', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (38, 'A0006@hdd.store.com', '$2y$10$dYo3BKt1qfcTCETIkIhfeeuu8sSYiVaR9s1NtJ/gPMVW6tfvGmk/q', 'A0006', 0, NULL, NULL, '2019-10-16 10:44:42', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (39, 'A0009@hdd.store.com', '$2y$10$g8UEzmskbIXMtskAzwG0vOwHLFYY8fr68umRyoHnAisqenOeRFNFK', 'A0009', 0, NULL, NULL, '2019-10-16 10:44:44', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (40, 'A0010@hdd.store.com', '$2y$10$A1pL4f0izdZ9x/h5ZssP0.nwftxGueQjciirlwq9PgZDk1Z23119C', 'A0010', 0, NULL, NULL, '2019-10-16 10:44:44', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (41, 'A0011@hdd.store.com', '$2y$10$TSvCBxTddlRs5LCukFZNe.aR5DNWksW3m63fdOYNSfAbiA56PLU9a', 'A0011', 0, NULL, NULL, '2019-10-16 10:44:46', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (42, 'A0012@hdd.store.com', '$2y$10$thMK4NpsYTT7/M5MDxR1XO4I3RYUf.bmvbuWRbcDZnA/9HrSAr5Aq', 'A0012', 0, NULL, NULL, '2019-10-16 10:44:46', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (43, 'A0013@hdd.store.com', '$2y$10$UMBxNaUnx.HinXpQ3ZGbsuWG2jj0EN/F403VGBkeRWmHVPnzZowZG', 'A0013', 0, NULL, NULL, '2019-10-16 10:44:48', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (44, 'A0014@hdd.store.com', '$2y$10$mi1HHPWWYSmO.Aptjnw/i.Hif1SOOBpsKVb6ZC1E5NXs97zDJ00Ha', 'A0014', 0, NULL, NULL, '2019-10-16 10:44:49', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (45, 'A0015@hdd.store.com', '$2y$10$37uxbZs/IZ/wLla9Cum5y.rl5ZuU601GQFrzmbK3vKNFFJLeAV5gW', 'A0015', 0, NULL, NULL, '2019-10-16 10:44:51', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (46, 'A0016@hdd.store.com', '$2y$10$JM5t3U4dLn1MIaa.op8KIO7unlpXxZ5HAov42t7jajQl9Vgn9eoA2', 'A0016', 0, NULL, NULL, '2019-10-16 10:44:51', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (47, 'A0017@hdd.store.com', '$2y$10$beUKzStYErBWQtLoQCCRSuYAywcUM.IYNxrO01.1HlLvS2Ed8/uvm', 'A0017', 0, NULL, NULL, '2019-10-16 10:44:52', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (48, 'A0018@hdd.store.com', '$2y$10$h6G1JqWx68IKMXf8piucx./thr104kmukbMr3qb8OvcGxEqlXXcty', 'A0018', 0, NULL, NULL, '2019-10-16 10:44:53', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (49, 'A0019@hdd.store.com', '$2y$10$3ZMWBkb3GX5sZZZpollPNOI3SFwy6exextob8BWFOuyKIO8fIlPrW', 'A0019', 0, NULL, NULL, '2019-10-16 10:44:54', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (50, 'A0020@hdd.store.com', '$2y$10$liIe7aoSA5gZPNw2HrV/Beb2URpgAjWojI9YSWpAZlOACaQtqqKRO', 'A0020', 0, NULL, NULL, '2019-10-16 10:44:55', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (51, 'A0021@hdd.store.com', '$2y$10$ZI2nSwSN5vYAgY8PfoQcVOmgc/cAb0kqRYyKkqo/hEGr0bu7oWP1y', 'A0021', 0, NULL, NULL, '2019-10-16 10:44:55', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (52, 'A0022@hdd.store.com', '$2y$10$8WKqOtuDKO3MRpWSDuecJegv8QzeikkpBxTFHMW3dcixPr/rtH9lK', 'A0022', 0, NULL, NULL, '2019-10-16 10:44:56', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (53, 'A0023@hdd.store.com', '$2y$10$T8MnY95h3SzVYq.2HdhTLOpzuZKdXG2rkyF/rz6qoVS1PabjNtU96', 'A0023', 0, NULL, NULL, '2019-10-16 10:44:57', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (54, 'A0026@hdd.store.com', '$2y$10$hSKkLAJwbWCR0YdC8pjYpuqkObjXAZgltXfzi1ZmWTqDQOUisvkMa', 'A0026', 0, NULL, NULL, '2019-10-16 10:44:58', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (55, 'A0027@hdd.store.com', '$2y$10$rjLLoBAo879Wbq/kL9cyxuDjxbwSzGh.x1UCLEqY2Q29KlWz3.xVS', 'A0027', 0, NULL, NULL, '2019-10-16 10:44:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (56, 'A0028@hdd.store.com', '$2y$10$RESxXypDmpR1fIgXI0YJSOhlF818kt/I7nB7C5g67mZeSrZp0zAkO', 'A0028', 0, NULL, NULL, '2019-10-16 10:45:00', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (57, 'A0029@hdd.store.com', '$2y$10$1TDW/uvi.S9YeepRUPhMEebsX/YlCJF674eUCqVif2NKDJ.rDhfUa', 'A0029', 0, NULL, NULL, '2019-10-16 10:45:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (58, 'A0030@hdd.store.com', '$2y$10$AF3k91B5ZiDUOqWQquXqH.eP3faXHYVBzqn8EPjaNUNIGDGBy9kfG', 'A0030', 0, NULL, NULL, '2019-10-16 10:45:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (59, 'A0031@hdd.store.com', '$2y$10$fJLzoqLKc6N8ed3FygNiJ.8ISF.j9SLij7.0PBYWIYowSgZMO07H.', 'A0031', 0, NULL, NULL, '2019-10-16 10:45:03', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (60, 'A0032@hdd.store.com', '$2y$10$bkhyR6f3dOo2DLPDp3ARH.kzYxgxbPV/CUBGLeyuY6MLObWWam2VS', 'A0032', 0, NULL, NULL, '2019-10-16 10:45:04', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (61, 'A0033@hdd.store.com', '$2y$10$KmUAp5DQdsie8D4Zkp6A.umKtSu8Mko6qUYYz3anQcXZkzpdI6/em', 'A0033', 0, NULL, NULL, '2019-10-16 10:45:05', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (62, 'A0034@hdd.store.com', '$2y$10$q4t8dtbB8wO2Ex./bbpmGe5ZOSZhcmHkZgF44UW.iUVAT9ZAM2NSu', 'A0034', 0, NULL, NULL, '2019-10-16 10:45:06', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (63, 'A0035@hdd.store.com', '$2y$10$eccqmd.DWssDqQwVlIkuEekY2PmeTB6HqMLukuSTfLPF.hWsGdr1a', 'A0035', 0, NULL, NULL, '2019-10-16 10:45:07', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (64, 'A0036@hdd.store.com', '$2y$10$hDxcn.xZjleSUmOW/49EXOsftB70V8I0rybtC.1.isx.jBXt7FUoq', 'A0036', 0, NULL, NULL, '2019-10-16 10:45:07', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (65, 'A0037@hdd.store.com', '$2y$10$j6Dvb6xc26wmSeUVlz4r7e5nqzGYl/toWQ54Xclwn.UBI02GOQ5nu', 'A0037', 0, NULL, NULL, '2019-10-16 10:45:08', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (66, 'A0038@hdd.store.com', '$2y$10$MTc6LEGqyEWjviVaVEDEC.Q3kfvYegxiFHt8oMv0xJrdVxf6eMOi6', 'A0038', 0, NULL, NULL, '2019-10-16 10:45:09', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (67, 'A0039@hdd.store.com', '$2y$10$E1cPML5AQnuJE/StcEwJQOccMNiw7ld.hUog/zQ3XrVR195Um63TO', 'A0039', 0, NULL, NULL, '2019-10-16 10:45:12', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (68, 'A0040@hdd.store.com', '$2y$10$qWn0ptfcQ8U9Rbu1VX2NoONoPW2.6GBxJM7TJ1egIHsOO8SAL4P9e', 'A0040', 0, NULL, NULL, '2019-10-16 10:45:12', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (69, 'A0041@hdd.store.com', '$2y$10$x5mlHk7HRSiats/9q9twfOeo1lIkarYU8P/2/qIpYIDK5SqjD.NWy', 'A0041', 0, NULL, NULL, '2019-10-16 10:45:14', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (70, 'A0042@hdd.store.com', '$2y$10$gnUIk4IwAfauOxmRsrZeyOzcS1WfYWzwOZKT9mDdrtnJZi9wTpFCO', 'A0042', 0, NULL, NULL, '2019-10-16 10:45:15', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (71, 'A0043@hdd.store.com', '$2y$10$5kOPcxLnTFd/GTJh460EfO.LTMxp2z/YdSotR.6QgfMW4.bGwe08u', 'A0043', 0, NULL, NULL, '2019-10-16 10:45:16', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (72, 'A0044@hdd.store.com', '$2y$10$49biTbiFbESlA8gQAtW0D.xtgehwidoDJThutCcL1z1YHHl.dtD9O', 'A0044', 0, NULL, NULL, '2019-10-16 10:45:17', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (73, 'A0045@hdd.store.com', '$2y$10$XLqDnR9ulJ6/KQOwTQOJB.EQInyu5svNS14rl.r5.I9lCmyAWNHfW', 'A0045', 0, NULL, NULL, '2019-10-16 10:45:19', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (74, 'A0046@hdd.store.com', '$2y$10$/zBUrgzhRTtNKWPGv.0JNe9gKBIe1Nth/juYzezu80lAx.s5T3d0q', 'A0046', 0, NULL, NULL, '2019-10-16 10:45:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (75, 'A0047@hdd.store.com', '$2y$10$bgP/jTIM.Eg0mz3lY0QWEec/KKe1P/.mCtjYYjVAqYnZm8flio8fO', 'A0047', 0, NULL, NULL, '2019-10-16 10:45:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (76, 'A0048@hdd.store.com', '$2y$10$r6ZP.y2.OGp0Sa/4d2ZvwOYXOUF/2KcNpRQRRmfwPCCdchtDcGKGO', 'A0048', 0, NULL, NULL, '2019-10-16 10:45:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (77, 'A0049@hdd.store.com', '$2y$10$lzftlT92TdqxGCJxRCdC6.M0h2UTs6wCGF9zLZTgocHhLK9pJ1d3a', 'A0049', 0, NULL, NULL, '2019-10-16 10:45:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (78, 'A0050@hdd.store.com', '$2y$10$ZqJsBkbI1LDZKuGh3GdSt.YXOVg6UI.vqpEMf4GVRVITOTPcWIwaG', 'A0050', 0, NULL, NULL, '2019-10-16 10:45:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (79, 'A0051@hdd.store.com', '$2y$10$PKecbMUclBvSQicztaPYIehxp/bE3bmPSvHdE4sP0K0Hfp0rYuXtG', 'A0051', 0, NULL, NULL, '2019-10-16 10:45:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (80, 'A0052@hdd.store.com', '$2y$10$ldXm9rtRbjFdrM0rGSpMNuXrlXbmJ.YOsWHgZhSKMqxosMsnhTKoW', 'A0052', 0, NULL, NULL, '2019-10-16 10:45:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (81, 'A0053@hdd.store.com', '$2y$10$bPfQKbYaHDtc4lio2vv.9uW8ls.mIzH/3YhdnS0kpCV71lXqHB0L6', 'A0053', 0, NULL, NULL, '2019-10-16 10:45:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (82, 'A0054@hdd.store.com', '$2y$10$nV9dnNp/saUw0X1Rm8KNKO6.GqgX3Smk1DqonpCr30UxjAwHClPp6', 'A0054', 0, NULL, NULL, '2019-10-16 10:45:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (83, 'A0055@hdd.store.com', '$2y$10$H.nqn5qqUoYTlrhGgN/L1Ow0glEpuaXvXwLrXopFXntcRAAfGsh8W', 'A0055', 0, NULL, NULL, '2019-10-16 10:45:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (84, 'A0056@hdd.store.com', '$2y$10$I7j68PjiqyucaO5kZS.On.03k86gTWTPw77ETfBRrj9Hzabk4li/q', 'A0056', 0, NULL, NULL, '2019-10-16 10:45:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (85, 'A0057@hdd.store.com', '$2y$10$e.mq6k9y5Cof..p2EQ8CYOtWRdpqTwgq7njJc.r.rPXJ3yRgZ0Qny', 'A0057', 0, NULL, NULL, '2019-10-16 10:45:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (86, 'A0058@hdd.store.com', '$2y$10$YLy3LhG03OYHhitPLY/y0.5JD3M.SmV2fMTvjeNBMsZEgv.glJis6', 'A0058', 0, NULL, NULL, '2019-10-16 10:45:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (87, 'A0059@hdd.store.com', '$2y$10$yVUl7hxHwmcgtCOy2hnnRuqa7npjDnleYuuoCeZya8IBsjo0szUCi', 'A0059', 0, NULL, NULL, '2019-10-16 10:45:34', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (88, 'A0060@hdd.store.com', '$2y$10$0vGr9sYeAcuuxGpSesyfQOs2jUwRB5sLXXjyERNr6gKcgrm6kIeoS', 'A0060', 0, NULL, NULL, '2019-10-16 10:45:35', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (89, 'A0061@hdd.store.com', '$2y$10$HX22wnKuj0UsZLIhF7nSue6RhjnUlO6aoWy6ropVc4nDmdNAuYS36', 'A0061', 0, NULL, NULL, '2019-10-16 10:45:37', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (90, 'A0062@hdd.store.com', '$2y$10$raAHX7D4kjrNgkJmI9IDg.TE6Knp5xG145ysKvQutkhGXnMmwCmPC', 'A0062', 0, NULL, NULL, '2019-10-16 10:45:38', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (91, 'A0063@hdd.store.com', '$2y$10$oInF6NIzBm0XBb3.8RPqmeOBVQzyG3b6.rPSjyLkB0VXLUdCsdK5.', 'A0063', 0, NULL, NULL, '2019-10-16 10:45:39', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (92, 'A0064@hdd.store.com', '$2y$10$OyzDheH3CXnFZhKQyPtbd.QB9wXNLKK8r2RmorT6Wi5TdCiTsixvy', 'A0064', 0, NULL, NULL, '2019-10-16 10:45:40', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (93, 'A0065@hdd.store.com', '$2y$10$43u0CN4CZq/fnNHv1XyrJumAxKADu8yH8XHnwJD.rbggpCn1ZKlO2', 'A0065', 0, NULL, NULL, '2019-10-16 10:45:41', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (94, 'A0066@hdd.store.com', '$2y$10$Obv0DArwgRGV0fT2h7hoQO2CJ9yk2uhl8hcMHV.qdvVE6hlqs5j9.', 'A0066', 0, NULL, NULL, '2019-10-16 10:45:41', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (95, 'A0067@hdd.store.com', '$2y$10$k.C/da/7FH0QOm/Xd9q/Ce27I/EsA3gaS4UHVyU29L./HPkAPm4Mu', 'A0067', 0, NULL, NULL, '2019-10-16 10:45:42', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (96, 'A0068@hdd.store.com', '$2y$10$l4AG/e1NE.2qVa1gMXSlZe5hmaXeEIIV667NtiJOl1yCvi/ge0YP2', 'A0068', 0, NULL, NULL, '2019-10-16 10:45:43', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (97, 'A0069@hdd.store.com', '$2y$10$Zr3dkMHJir/fH2IW/OMkp.eQAis.tLUOX3hKPIsZmo99noNd6RbV.', 'A0069', 0, NULL, NULL, '2019-10-16 10:45:44', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (98, 'A0070@hdd.store.com', '$2y$10$2vtnOs1FAEiMIWCv9pc2S.w1PIn013yHWhKLITt9LJxkVXwsoCjGS', 'A0070', 0, NULL, NULL, '2019-10-16 10:45:45', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (99, 'A0071@hdd.store.com', '$2y$10$vKGcrW3uK.zrrksaq/ZorORTJhkHlr3R.ucfe8C1NwUVmjIUkq/1S', 'A0071', 0, NULL, NULL, '2019-10-16 10:45:46', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (100, 'A0072@hdd.store.com', '$2y$10$VlzsKNjU4IORxwU4vg40ve.W9XajIAajdqtBhfG26QYoT68nQala6', 'A0072', 0, NULL, NULL, '2019-10-16 10:45:47', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (101, 'A0073@hdd.store.com', '$2y$10$kShHo1E5cfES69CYiK8kZeJS6OXuOeIsUz.8u9jNfKd.UU8wfGBgy', 'A0073', 0, NULL, NULL, '2019-10-16 10:45:48', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (102, 'A0074@hdd.store.com', '$2y$10$3urnyIb8boo1kc3PQM9NmuLoM9nILfWiNlTTCvraxDAEMP8of9S2W', 'A0074', 0, NULL, NULL, '2019-10-16 10:45:48', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (103, 'A0075@hdd.store.com', '$2y$10$Y68UXNs./JKSrdE3rEt.q.4dO3jQE3grQAZVq4E5rCFfJ4o0iydb2', 'A0075', 0, NULL, NULL, '2019-10-16 10:45:49', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (104, 'A0076@hdd.store.com', '$2y$10$GZVnsDi3KUGVTiwwchNPwO397wWoWgLR.T1oFFgdGFZbElPGeN46y', 'A0076', 0, NULL, NULL, '2019-10-16 10:45:50', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (105, 'A0077@hdd.store.com', '$2y$10$xNkwzRNzOxg/pWwwerSRHuX/9OBTPtHwqzspjw6OK8Gj8VcA1n9EC', 'A0077', 0, NULL, NULL, '2019-10-16 10:45:51', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (106, 'A0078@hdd.store.com', '$2y$10$u3TT3OnYtZsmdaL1KcWCWuLpUxy3fvOSmiVURPAUhwHT7GIED3elm', 'A0078', 0, NULL, NULL, '2019-10-16 10:45:52', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (107, 'A0080@hdd.store.com', '$2y$10$C9Iz84.eoHJuLSdPz6ENCuoBaWlyy5mMLePd9A8JZhd4u4rbhPAmW', 'A0080', 0, NULL, NULL, '2019-10-16 10:45:53', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (108, 'A0081@hdd.store.com', '$2y$10$AVSk27tdxx/6qLjt4/km.OWC4cW9cMvd54J3Sjl.zKnhmQCcSlY8O', 'A0081', 0, NULL, NULL, '2019-10-16 10:45:54', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (109, 'A0082@hdd.store.com', '$2y$10$d.7mXf3NnkryiUir9LIfVu3MaevVxEE0Qe/brppElMfNWul443e.y', 'A0082', 0, NULL, NULL, '2019-10-16 10:45:54', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (110, 'A0083@hdd.store.com', '$2y$10$8KoCH4/v6hVBqiPCvQng0.FBxhxj.qX4Q/7ss9y4CRH4lmVzigyOG', 'A0083', 0, NULL, NULL, '2019-10-16 10:45:56', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (111, 'A0084@hdd.store.com', '$2y$10$Y49jjwlnCLxpyRwWVhN5V.CVDewyqmwTeCNJlduY.zCoUPOTHimB2', 'A0084', 0, NULL, NULL, '2019-10-16 10:45:56', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (112, 'A0085@hdd.store.com', '$2y$10$HQH3IP0Pg24XMP50pf0ePeefkaL5wGjN/A1QdvWRfSZ.2VMzgRu1y', 'A0085', 0, NULL, NULL, '2019-10-16 10:45:57', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (113, 'A0086@hdd.store.com', '$2y$10$dQnQQrQSfCvVECM7Wnr1F.vTIihGh8eRAV1JaKNR1sWct99OjmzCC', 'A0086', 0, NULL, NULL, '2019-10-16 10:45:58', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (114, 'A0087@hdd.store.com', '$2y$10$ZxLzheOnBmDqa3f0hb5WgeS83ExetcWRHe07A3aiosKdOoQzeyuYC', 'A0087', 0, NULL, NULL, '2019-10-16 10:45:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (115, 'A0088@hdd.store.com', '$2y$10$a49yV5YRJ.UgDjp/yV5ZN.xl5HugObFj1EHTAjwsTUZBb7YFt/IgG', 'A0088', 0, NULL, NULL, '2019-10-16 10:46:00', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (116, 'A0089@hdd.store.com', '$2y$10$PkEF85UgJTa1.7aDxVWYXeo3XW.Z8i0yinJ0dDT3TmDeZBGLK8eQ.', 'A0089', 0, NULL, NULL, '2019-10-16 10:46:01', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (117, 'A0090@hdd.store.com', '$2y$10$x3GYIucYu5kbBfyVix.9mOroiYoXgfFR7KE0cg4nwrwtmP23Ug2yC', 'A0090', 0, NULL, NULL, '2019-10-16 10:46:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (118, 'A0091@hdd.store.com', '$2y$10$JBommI5XTzLtseY7WlwIbOOR8hMwUCCFotKhUBE7JP/8mKsRfcmBi', 'A0091', 0, NULL, NULL, '2019-10-16 10:46:03', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (119, 'A0093@hdd.store.com', '$2y$10$wr2.EvMM84qY8gnodrVssOJ3MJ2iWZ6/peooj6w6jUScyxhjJ1DMu', 'A0093', 0, NULL, NULL, '2019-10-16 10:46:04', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (120, 'A0094@hdd.store.com', '$2y$10$Jofl.63XGYysUw2t3RsBVeSF.k8rEPE6BOGRz1GsILktRNYk/5GQa', 'A0094', 0, NULL, NULL, '2019-10-16 10:46:05', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (121, 'A0095@hdd.store.com', '$2y$10$CaH6SLg5fYoVipZpv/jmCOjrmooWOsARycg/TOe6AUDJPOiqcefyS', 'A0095', 0, NULL, NULL, '2019-10-16 10:46:06', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (122, 'A0096@hdd.store.com', '$2y$10$77Os6xQ5WqH.IdbbTPBCjuWfP.oI5Rr3gPWqVlvz6snsuoMS2q6Tq', 'A0096', 0, NULL, NULL, '2019-10-16 10:46:07', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (123, 'A0097@hdd.store.com', '$2y$10$tlHCQWDo.m0GeNJKt2yQqu5hmyWjCXPakg0sysXDEhLe3Rgjufg/6', 'A0097', 0, NULL, NULL, '2019-10-16 10:46:08', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (124, 'A0098@hdd.store.com', '$2y$10$RnYaFw.HFdCbbiYEMR18g.EsPUmBOw3W5vhdyepzod3ZpDR3it6R2', 'A0098', 0, NULL, NULL, '2019-10-16 10:46:08', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (125, 'A0099@hdd.store.com', '$2y$10$eF00X8xtkXgIyaeWzZGdjeO8tDw8Ewi4LFqPFjg7cvIc0CcbNiBaW', 'A0099', 0, NULL, NULL, '2019-10-16 10:46:10', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (126, 'A0100@hdd.store.com', '$2y$10$JrtaWUqKFWMvsiarcKGfXeXo/u46mO9D/IkptPYmvMyqDL6VcosdK', 'A0100', 0, NULL, NULL, '2019-10-16 10:46:11', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (127, 'A0101@hdd.store.com', '$2y$10$v9d79r8sDyFzOtmKGgB7iuP8j93nnJXNWqsiUs9kBB14PHTZl2coe', 'A0101', 0, NULL, NULL, '2019-10-16 10:46:12', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (128, 'A0102@hdd.store.com', '$2y$10$Nta8fXyyBYE7OtMXErYzH.9S75IiAW3hLBu.w3KFZriamsosxeg2m', 'A0102', 0, NULL, NULL, '2019-10-16 10:46:13', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (129, 'A0103@hdd.store.com', '$2y$10$gIpicawfjFeChbUphQ7tBux3ovAjDzoLKCN466uOZQ0SVNRrqcKwy', 'A0103', 0, NULL, NULL, '2019-10-16 10:46:14', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (130, 'A0105@hdd.store.com', '$2y$10$.oj1P7hPnTKtG6hUHe77Ku0qD606J5zeIUkYDQVa7rEXUXzHwJeW6', 'A0105', 0, NULL, NULL, '2019-10-16 10:46:15', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (131, 'A0106@hdd.store.com', '$2y$10$oVjyF7J1LMsjIpsMa8c3A.KCH.MMi1WIi9VHcy.sN96t53b5912z6', 'A0106', 0, NULL, NULL, '2019-10-16 10:46:16', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (132, 'A0107@hdd.store.com', '$2y$10$XUicDlx3iv3P43ndzLN32ey53Z7rGHOV2nBwIaeMIEZyBskzy5yWm', 'A0107', 0, NULL, NULL, '2019-10-16 10:46:17', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (133, 'A0108@hdd.store.com', '$2y$10$M0aWhDu6EtYho0Dnh2CFZ.6mzjT0UdJPn1XC0i/8/8B8i6t1aOS2C', 'A0108', 0, NULL, NULL, '2019-10-16 10:46:18', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (134, 'A0109@hdd.store.com', '$2y$10$QaznH9suypSareOEWIKpX.SPoHS0VA9zYsacqsUeIxilCd0o0f.4W', 'A0109', 0, NULL, NULL, '2019-10-16 10:46:19', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (135, 'A0110@hdd.store.com', '$2y$10$NxyEcppPQQZdsmbLvgzVjuey..HoXnYihjDPo.GdyqSPHIIwQpOJu', 'A0110', 0, NULL, NULL, '2019-10-16 10:46:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (136, 'A0111@hdd.store.com', '$2y$10$bnvYgkChn8VXSl9CMKY8X.rMYyhcaLrFIJgPZKw7w/VuHW8YBRdFW', 'A0111', 0, NULL, NULL, '2019-10-16 10:46:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (137, 'A0112@hdd.store.com', '$2y$10$JIQBTBruzG0SDGenlLqz0uO2VClWIu0g.eAWS0/gjE5WUzx/jjLiq', 'A0112', 0, NULL, NULL, '2019-10-16 10:46:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (138, 'A0113@hdd.store.com', '$2y$10$NlUIFb6KkCi.E5eilHv1aOospgTwqOLJZmevDYK7nXBYRPX6MFK0y', 'A0113', 0, NULL, NULL, '2019-10-16 10:46:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (139, 'A0114@hdd.store.com', '$2y$10$R4qujgVN4FJU441xXl59/.VE2hB1u5hHRVntC4F0fUakZxpbmQQWO', 'A0114', 0, NULL, NULL, '2019-10-16 10:46:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (140, 'A0115@hdd.store.com', '$2y$10$E/PCuX1qQv.sP7MpF12Sc.hXSSVFnG4zbTzvAZVEiQLfg3/kd3866', 'A0115', 0, NULL, NULL, '2019-10-16 10:46:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (141, 'A0116@hdd.store.com', '$2y$10$TzOQ/NarzgGgg8W7fKeoeOHAp3m2siLT5NokvpgCqbF2seSq6LGo.', 'A0116', 0, NULL, NULL, '2019-10-16 10:46:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (142, 'A0117@hdd.store.com', '$2y$10$B/kwGOXBZ1ecJ.QWl8h7Ie5QDvQAn9ZMwpxuQoXYFE9Au3mybubc6', 'A0117', 0, NULL, NULL, '2019-10-16 10:46:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (143, 'A0118@hdd.store.com', '$2y$10$zAoInfDRgbUA/0yW8TR9.O/80i67nlE8jHCPgRazYJktmCBIMdN52', 'A0118', 0, NULL, NULL, '2019-10-16 10:46:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (144, 'A0119@hdd.store.com', '$2y$10$AKSemdvxPfzWBVEGhUkbb.V0pWSHBOZCPetjC6SXzfQHSYigrpn4e', 'A0119', 0, NULL, NULL, '2019-10-16 10:46:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (145, 'A0120@hdd.store.com', '$2y$10$Hc24vUEZGs2JZbOoudd4.ufyf2Ot/eRUtwgsVvVjxAWPBw56qlF7.', 'A0120', 0, NULL, NULL, '2019-10-16 10:46:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (146, 'A0121@hdd.store.com', '$2y$10$jB6orBVv8Mmrlxa4gLhWheWHC6j5BDPfwbCkskuBrZTCoeS0u4Hju', 'A0121', 0, NULL, NULL, '2019-10-16 10:46:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (147, 'A0122@hdd.store.com', '$2y$10$ntkQWjo4Z/MTEvf3zvXIF.BojpyXOueoFRgWyqtT0TiZPaRaRm3d6', 'A0122', 0, NULL, NULL, '2019-10-16 10:46:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (148, 'A0123@hdd.store.com', '$2y$10$YykIaqGmsSbYng3rVX1HP.xrLevU4r1maeqGrwsCKk93tk70iDdya', 'A0123', 0, NULL, NULL, '2019-10-16 10:46:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (149, 'A0124@hdd.store.com', '$2y$10$muqNRuXjS0ErD2v/y7RC8e01rY.M/KwldM4R14/ddoYOVgugOl.J6', 'A0124', 0, NULL, NULL, '2019-10-16 10:46:34', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (150, 'A0125@hdd.store.com', '$2y$10$NIYRQ2wuLCeuUirkTiNobOVuFEsv2/JbJcsYimiDzNtyduKWH2dtG', 'A0125', 0, NULL, NULL, '2019-10-16 10:46:35', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (151, 'A0126@hdd.store.com', '$2y$10$FHGVM4x7D1xdZ52IpJLWUeMcZIGNk0CwOl5AcHlRBBb8Wzf91ebS2', 'A0126', 0, NULL, NULL, '2019-10-16 10:46:36', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (152, 'A0127@hdd.store.com', '$2y$10$hhpaCMVeVa1XlGHc7QsCTO0pjEzbUZ./PtE/wR9AIiQeFCxhv5w1y', 'A0127', 0, NULL, NULL, '2019-10-16 10:46:37', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (153, 'A0128@hdd.store.com', '$2y$10$MWqQrA8rS/7/NZbzy8Vlj.lAt9nbhFx7M9BcDF6A8tcL2kMKoNcxe', 'A0128', 0, NULL, NULL, '2019-10-16 10:46:38', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (154, 'A0129@hdd.store.com', '$2y$10$48Bl/VLjFjaFPRdcRFxthepobHUrmxE7kqRwxDHQ3R/fIsktAEF8a', 'A0129', 0, NULL, NULL, '2019-10-16 10:46:39', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (155, 'A0131@hdd.store.com', '$2y$10$/09.DXv4lpMSACIAQNPcROWcQyHWJfLT7tPQjXedj90bOOdT9TnEu', 'A0131', 0, NULL, NULL, '2019-10-16 10:46:40', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (156, 'A0132@hdd.store.com', '$2y$10$xnbHSevEp0hD9Vw3g6FIKezlvNxknfV1B0JNAN3IoEp3bChe3FO76', 'A0132', 0, NULL, NULL, '2019-10-16 10:46:41', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (157, 'A0133@hdd.store.com', '$2y$10$j2..Pr1bfQw4sgbXPCq/eeRQl5DWwBchO.Y9ZdmXkF5rkfaOau0za', 'A0133', 0, NULL, NULL, '2019-10-16 10:46:42', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (158, 'A0134@hdd.store.com', '$2y$10$xNkn7Exji12UbU2Ryvq.U.RPKQVPy6A7TRuAAwbo8G1GSLlPymYA6', 'A0134', 0, NULL, NULL, '2019-10-16 10:46:43', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (159, 'A0135@hdd.store.com', '$2y$10$d1buN8kgX0lCsVv506Dne.AH4B0qalJMcnpBk4E9v.gBin69Dau/i', 'A0135', 0, NULL, NULL, '2019-10-16 10:46:44', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (160, 'A0136@hdd.store.com', '$2y$10$o6GWT.4u3kRmdLRWqT6jy.2iT5PfAnyz8aJTeUo/m7bnAbveDU7Na', 'A0136', 0, NULL, NULL, '2019-10-16 10:46:45', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (161, 'A0137@hdd.store.com', '$2y$10$gS.5qAIroUTVoTt4.4wOCeIo9OOt5s6AzgWY3FkOLI0rXuueD4YqW', 'A0137', 0, NULL, NULL, '2019-10-16 10:46:46', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (162, 'A0138@hdd.store.com', '$2y$10$pAYJrYLkopByVDD2d810Mu8A.WjwzSgkoUWuIKiLvOXvJXF3Q79sO', 'A0138', 0, NULL, NULL, '2019-10-16 10:46:47', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (163, 'A0139@hdd.store.com', '$2y$10$eNpD7cM69v53oyV1we87a.zVCjPKXhubx2qSKhPa43RryGb1FKzDe', 'A0139', 0, NULL, NULL, '2019-10-16 10:46:47', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (164, 'A0140@hdd.store.com', '$2y$10$ry8ytLB0zLtKxBw0YtYI7.fkgSiuLYUmcHslkhywSb1iEK3H0.gn6', 'A0140', 0, NULL, NULL, '2019-10-16 10:46:48', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (165, 'A0141@hdd.store.com', '$2y$10$IHIo13UE96XklEuHi/cMFO6JKJ/6I9Rdt8T/1cQBMSbAbhz0KDThm', 'A0141', 0, NULL, NULL, '2019-10-16 10:46:49', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (166, 'A0142@hdd.store.com', '$2y$10$rJw.Gizbl3MTg1Kh/apie.7xuNgGOgtIBnSbTerw447glOGmgpLH.', 'A0142', 0, NULL, NULL, '2019-10-16 10:46:50', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (167, 'A0143@hdd.store.com', '$2y$10$qV0pSZM2VSZkthBgrFfipeIRZYm1g73syclLN3WEoLsvKFtnu2C2G', 'A0143', 0, NULL, NULL, '2019-10-16 10:46:51', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (168, 'A0144@hdd.store.com', '$2y$10$kTE.qf7hrpprYvQdtLnRa.tMyGXCTStXtBcsFFFJpUR3dBQBl3YIu', 'A0144', 0, NULL, NULL, '2019-10-16 10:46:52', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (169, 'A0145@hdd.store.com', '$2y$10$qyuUQkZFymq1xDkibkluAuENruKUApiUf9UYmTMCS/2Foy0Q.1r26', 'A0145', 0, NULL, NULL, '2019-10-16 10:46:53', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (170, 'A0146@hdd.store.com', '$2y$10$HFy6n/K4826qUL1mSY8GG..SyUjkoDZV8gyvpljXf/kydLNs.1EOS', 'A0146', 0, NULL, NULL, '2019-10-16 10:46:54', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (171, 'A0147@hdd.store.com', '$2y$10$7Axr.mlCXaUOQ62b2nle5eG1TJro8K0lZ/038Zk9f08rr4D2/rOf2', 'A0147', 0, NULL, NULL, '2019-10-16 10:46:55', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (172, 'A0148@hdd.store.com', '$2y$10$plOAZm6VG23udkDfQU7GZu2fPQnBbkXi9J33UW7vGhsPpPR85u64y', 'A0148', 0, NULL, NULL, '2019-10-16 10:46:56', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (173, 'A0149@hdd.store.com', '$2y$10$WqdjDw2KvVtMIRvcHQn1nOG0ph6Oe2kQlcJtHLQH/4X0i8PReBxF2', 'A0149', 0, NULL, NULL, '2019-10-16 10:46:57', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (174, 'A0150@hdd.store.com', '$2y$10$5d.JdBAbFf2VsYTHRp0nne51X4UoWnI44m7pkdR3/RSEQJamVgq0O', 'A0150', 0, NULL, NULL, '2019-10-16 10:46:58', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (175, 'A0151@hdd.store.com', '$2y$10$3HLao77HeMsGFdSF/CCapO8o4d4IKmEJPOK7CMZWh.n7GfAx1VsaO', 'A0151', 0, NULL, NULL, '2019-10-16 10:46:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (176, 'A0152@hdd.store.com', '$2y$10$jddqGJOfyF5DKZu7yjdQ2uBgrq/amYFqCavE3KA.8KPQvKWdAgJ6G', 'A0152', 0, NULL, NULL, '2019-10-16 10:47:00', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (177, 'A0153@hdd.store.com', '$2y$10$dknKmmDJT9L3t0fibplz2eax1Dpv.JdoxLGVqTjSnTWFm3W/3sgD.', 'A0153', 0, NULL, NULL, '2019-10-16 10:47:00', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (178, 'A0154@hdd.store.com', '$2y$10$oArjm2Npe9XudMtcuiKJ6uCla9fzBB66DmyP1r7bC0Zpq1hX3jqOe', 'A0154', 0, NULL, NULL, '2019-10-16 10:47:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (179, 'A0155@hdd.store.com', '$2y$10$lRDCzxj/yikswO310nDCaem3qXgiCQoDFpRnsEsfnMFzIulckHMFi', 'A0155', 0, NULL, NULL, '2019-10-16 10:47:03', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (180, 'A0156@hdd.store.com', '$2y$10$URCJ22PdQ5DmWsnmao9hNevKC4I/QgRgz9Ilp75.zciOsVZyj2KHS', 'A0156', 0, NULL, NULL, '2019-10-16 10:47:04', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (181, 'A0157@hdd.store.com', '$2y$10$4Qvap80PbKfxT/KU13WL0.77ezdKQfljd.HNxUvHRIXiMa6wh.X8y', 'A0157', 0, NULL, NULL, '2019-10-16 10:47:05', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (182, 'A0158@hdd.store.com', '$2y$10$SnHNsmp2cfP8yTmSwnKZk.9il5vha63h8M6nw8LJNPnrSgxe/IbMC', 'A0158', 0, NULL, NULL, '2019-10-16 10:47:05', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (183, 'A0159@hdd.store.com', '$2y$10$4eMWKuFfIRuTpVytTmWjmeXxmusa.QQWzDFIjR0f97n7l1XnuBHYW', 'A0159', 0, NULL, NULL, '2019-10-16 10:47:07', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (184, 'A0160@hdd.store.com', '$2y$10$lPpdVGYqF0XipWk6Ipyc3OYCzFk8aSR3zHd2E3RCrNJZepwBdMbuu', 'A0160', 0, NULL, NULL, '2019-10-16 10:47:08', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (185, 'A0161@hdd.store.com', '$2y$10$3f/70bfpKgggbZDFdcsKTu0pt76G1x8a6O6hYgp8iHhAADvOly0vS', 'A0161', 0, NULL, NULL, '2019-10-16 10:47:09', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (186, 'A0162@hdd.store.com', '$2y$10$IXAda7aBT08uED1./kVEN.lQtyEEA.PV0HH6S5WQ3zkgJpl27ddjq', 'A0162', 0, NULL, NULL, '2019-10-16 10:47:10', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (187, 'A0163@hdd.store.com', '$2y$10$cyKIPBMhwSxIAeAsJRAZFuMEqi0SxZukKuN/GCbjplDKA.QE0fS1O', 'A0163', 0, NULL, NULL, '2019-10-16 10:47:10', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (188, 'A0165@hdd.store.com', '$2y$10$JOnQ2SWV2jqdD/J0H74Tc.B7JjXgX3RSx5Rfq4uSzRL1ULyR9FGyi', 'A0165', 0, NULL, NULL, '2019-10-16 10:47:11', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (189, 'A0166@hdd.store.com', '$2y$10$MF2g1IwZH0WQQBldv7TOUuJPIqhiz8sqhrdNP.8pP6PT87gH4UXY6', 'A0166', 0, NULL, NULL, '2019-10-16 10:47:12', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (190, 'A0167@hdd.store.com', '$2y$10$uQUaiycwe1qCQLa85nJzD.O7NvYLGApeInflwTaLlLmNSphkBv0te', 'A0167', 0, NULL, NULL, '2019-10-16 10:47:13', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (191, 'A0168@hdd.store.com', '$2y$10$28Nl0CRQnIxLNxYBUHpuZ.Ll6I93ARaKEwtQ.o26n.EfVS.DXGZNu', 'A0168', 0, NULL, NULL, '2019-10-16 10:47:14', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (192, 'A0169@hdd.store.com', '$2y$10$v/kk.LwhEHoil7/HTc2WpONQPjEmR8bjAIAQ9igZEwY8XzUcPXVYe', 'A0169', 0, NULL, NULL, '2019-10-16 10:47:15', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (193, 'A0170@hdd.store.com', '$2y$10$FfNszX0pDs8kbApPKR4w7ONAObU8SZtxeLsQeaNQq26r1kRGR4eJG', 'A0170', 0, NULL, NULL, '2019-10-16 10:47:16', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (194, 'A0171@hdd.store.com', '$2y$10$Y3rBdaT3t4O93qKc5vpMF.lzfbITA.RV2nrNC1rpWIong6F6eVz4G', 'A0171', 0, NULL, NULL, '2019-10-16 10:47:16', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (195, 'A0172@hdd.store.com', '$2y$10$tN9Bs9i400rq1.MyTnXg/eYKE9wephVqAIDqeHIyaGvnOA6mkf1Ty', 'A0172', 0, NULL, NULL, '2019-10-16 10:47:17', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (196, 'A0173@hdd.store.com', '$2y$10$h..6OCZn4Os3mF.YoMRVoOOPJdP60duN2Zgq8YYnj7kRvRugICqfa', 'A0173', 0, NULL, NULL, '2019-10-16 10:47:18', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (197, 'A0174@hdd.store.com', '$2y$10$HKnu5VrQ2y.0SyvG9zDVkeTM2YAjT0MrQzvhFOCREOe4Pp2vnqRJS', 'A0174', 0, NULL, NULL, '2019-10-16 10:47:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (198, 'A0175@hdd.store.com', '$2y$10$5NcEpwIQCh2SZyVT9dWD4uiP3cIs8VITc4d7UCPkCensTZF3QJyua', 'A0175', 0, NULL, NULL, '2019-10-16 10:47:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (199, 'A0176@hdd.store.com', '$2y$10$VxaNWFtDryrUu6cAiv2SFe130JRH1FkCLy5031PBehWOYJsAcfp8C', 'A0176', 0, NULL, NULL, '2019-10-16 10:47:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (200, 'A0177@hdd.store.com', '$2y$10$D57tBJaCzVkX2DxXoSXkx.cjC5tF8zTKMREc/L7mAc8aiW91Pzw1G', 'A0177', 0, NULL, NULL, '2019-10-16 10:47:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (201, 'A0178@hdd.store.com', '$2y$10$f5pjlNeJlldUBaDhbzvDaO5qaaxMfVOELKwG/clp1tFmzahvwczD2', 'A0178', 0, NULL, NULL, '2019-10-16 10:47:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (202, 'A0179@hdd.store.com', '$2y$10$9xRDYWBx29sGJhIuB/6hGe59Jku3VlFes6N2bOM9K8/GXgRrYN1Ey', 'A0179', 0, NULL, NULL, '2019-10-16 10:47:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (203, 'A0180@hdd.store.com', '$2y$10$UaD5ZwV10nfuFSZvSeAJjeAs3gbNRbq6bEHv0fZkWKqylYsM0gp22', 'A0180', 0, NULL, NULL, '2019-10-16 10:47:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (204, 'A0181@hdd.store.com', '$2y$10$hU.ur5crntfEOCBHE3yhZOui2DsicHVZN9pMA3UQVxTib3L7nOKJ.', 'A0181', 0, NULL, NULL, '2019-10-16 10:47:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (205, 'A0182@hdd.store.com', '$2y$10$dIBOfpRO/c7X20Aj5qM59OQHE7gflrWbuTxhuWRncJFMD62508Kz6', 'A0182', 0, NULL, NULL, '2019-10-16 10:47:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (206, 'A0183@hdd.store.com', '$2y$10$QBzEDKKJMa587LSPhI3xMecpMoUq0TdjqqbxYRRfDN9umM3DG3YO2', 'A0183', 0, NULL, NULL, '2019-10-16 10:47:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (207, 'A0184@hdd.store.com', '$2y$10$u5S.YXNF00FgcqdwhRclUOKIMJ6fxiYO1TwxIPe2D1nFU3WiSITCm', 'A0184', 0, NULL, NULL, '2019-10-16 10:47:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (208, 'A0185@hdd.store.com', '$2y$10$HTejU51WU51WkmL77JJVGej1HL5qKZoXPrl6iMAflZYlK.SW3I2Mq', 'A0185', 0, NULL, NULL, '2019-10-16 10:47:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (209, 'A0186@hdd.store.com', '$2y$10$okK5EfT.QZkkpt1wZjAZiuw5oIgRBm06pY2dE.DTfLj0u0uJ7avJq', 'A0186', 0, NULL, NULL, '2019-10-16 10:47:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (210, 'A0187@hdd.store.com', '$2y$10$.fklrs2Gv2qwQc4LgWm/rOkR8XB2XSLqmh4qWJPaYvfLEvXeX.b5G', 'A0187', 0, NULL, NULL, '2019-10-16 10:47:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (211, 'A0188@hdd.store.com', '$2y$10$05R/4uWrroc.hRYBojjXC.cJpHtS6RwVHAHy.Ps20neriQixSQY7S', 'A0188', 0, NULL, NULL, '2019-10-16 10:47:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (212, 'A0189@hdd.store.com', '$2y$10$7Wj0CTwPeMFX.kN4BFi4wOHHvRAb6c.zUKTVxv1Z/KdIdJ1iSy5H2', 'A0189', 0, NULL, NULL, '2019-10-16 10:47:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (213, 'A0190@hdd.store.com', '$2y$10$610iF7gKeGG908A8/bISUu1s4jXBlkeLek8qnhOqKmDH0MTEWc42a', 'A0190', 0, NULL, NULL, '2019-10-16 10:47:34', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (214, 'A0191@hdd.store.com', '$2y$10$fj42mk7lg3SqXaInrDjXh.4wWVUztnZktRHaZKVR8CsWfxOu4sufK', 'A0191', 0, NULL, NULL, '2019-10-16 10:47:35', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (215, 'A0192@hdd.store.com', '$2y$10$Hk5G/vYfoMWNq8WT9002NunvlGy7ws646.VYHGnA4qaMacsD76ZG2', 'A0192', 0, NULL, NULL, '2019-10-16 10:47:36', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (216, 'A0193@hdd.store.com', '$2y$10$BCr4WxzLHs3y3ju3A/.Ule/A6s.4FMTM9uKDJwal7fTDu1/f4.nEq', 'A0193', 0, NULL, NULL, '2019-10-16 10:47:37', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (217, 'A0194@hdd.store.com', '$2y$10$aipwkgM4LdpuUsaD9OaaHuAnnL1lcNQfPsfj1Ql9.Wt7DwZpqej1q', 'A0194', 0, NULL, NULL, '2019-10-16 10:47:38', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (218, 'A0195@hdd.store.com', '$2y$10$j/a1BUudF1ihS/d/4JB1L.NPYVOXS/k9MFAOB/bnWIGWMB0mo56Ue', 'A0195', 0, NULL, NULL, '2019-10-16 10:47:38', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (219, 'A0196@hdd.store.com', '$2y$10$3/sL.462vVgc/71O61.XRehrzA.DwG9RZBWQPWqyBPzGSLIG3/SVC', 'A0196', 0, NULL, NULL, '2019-10-16 10:47:39', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (220, 'A0197@hdd.store.com', '$2y$10$q1Hb668NHOWM2pjwYlN.xOr.ysAC6phWwgj5rwe.MYQn3uCo7/Jx6', 'A0197', 0, NULL, NULL, '2019-10-16 10:47:40', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (221, 'A0198@hdd.store.com', '$2y$10$YlaKXpCX3fZ5J6tkx9K2HO8VYp.aqrZ201BqP.kW5IchHJQMe4ay2', 'A0198', 0, NULL, NULL, '2019-10-16 10:47:41', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (222, 'A0199@hdd.store.com', '$2y$10$fgtFi.qLP5NbH/wzAEKKZeGuTmNMNFRGbTymYopZSlsDB5g.DA4pq', 'A0199', 0, NULL, NULL, '2019-10-16 10:47:41', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (223, 'A0200@hdd.store.com', '$2y$10$saqSc3wCDgq1p00b3eEHCe16I04h2G2m30xpwta32fEGF9SJHud2e', 'A0200', 0, NULL, NULL, '2019-10-16 10:47:42', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (224, 'A0201@hdd.store.com', '$2y$10$8I9vw0I8a352ObkIUfAsseFJSxiIyuewq.yy07gb0d/auf5WCmsPS', 'A0201', 0, NULL, NULL, '2019-10-16 10:47:43', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (225, 'A0202@hdd.store.com', '$2y$10$e7hNF4tcBsKD2FnFe32HLO6Lpzu1pQYYXERD1WqsARlZkXy00.2LK', 'A0202', 0, NULL, NULL, '2019-10-16 10:47:44', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (226, 'A0203@hdd.store.com', '$2y$10$2CkaJJm8LxAr8QtX03oyjOZ0hF8XQpp1v39xlDbvRKeDWwybUFJPS', 'A0203', 0, NULL, NULL, '2019-10-16 10:47:45', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (227, 'A0204@hdd.store.com', '$2y$10$6qEGml.3NIXu3XJnscs0tOWqyh6jqdarmRQwqTJgchfL0GwG7QPp.', 'A0204', 0, NULL, NULL, '2019-10-16 10:47:46', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (228, 'A0205@hdd.store.com', '$2y$10$Yo182cVdNOqOFSNvQ7NYDuef6JVcr1PusYfrmp9IlVDEFsoDqW1v.', 'A0205', 0, NULL, NULL, '2019-10-16 10:47:47', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (229, 'A0206@hdd.store.com', '$2y$10$0Ls6c5MPoDZwaVlZVGGAW.Qw8n7GRGGUj/zEVeBxxb8IQYMNc8P6m', 'A0206', 0, NULL, NULL, '2019-10-16 10:47:48', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (230, 'A0207@hdd.store.com', '$2y$10$Gjem6gDh2Vel/iukjpGqWeyJfQGF.3ILLXUF0bssUI7xTMRGst.Uy', 'A0207', 0, NULL, NULL, '2019-10-16 10:47:49', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (231, 'A0208@hdd.store.com', '$2y$10$bgUcYPF94XOJ7wl68Zlx8e0N3vPwFvgjIFtxxbavJ7J0gQrfkhwMG', 'A0208', 0, NULL, NULL, '2019-10-16 10:47:49', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (232, 'A0209@hdd.store.com', '$2y$10$E1N9vY89BWeBu8DFhq8dlONfAgKhmr63RZ/ysmjyuMufNOFaxExCu', 'A0209', 0, NULL, NULL, '2019-10-16 10:47:50', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (233, 'A0210@hdd.store.com', '$2y$10$YkzIXFlkIpKYGqj5RVE2i.3pTwl5imnJdtZYXMiF5mmhBbTP8QVqa', 'A0210', 0, NULL, NULL, '2019-10-16 10:47:51', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (234, 'A0211@hdd.store.com', '$2y$10$kyUhSg7Y15p65H9PJUODfOuzTxH.BVVBB.CdNrpR5MlvFLctKounC', 'A0211', 0, NULL, NULL, '2019-10-16 10:47:52', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (235, 'A0212@hdd.store.com', '$2y$10$INm.WM6F18ekT5wWXY7eZ.51ey17txdqFJLle6PDMfzUIBSDQYy7u', 'A0212', 0, NULL, NULL, '2019-10-16 10:47:52', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (236, 'A0213@hdd.store.com', '$2y$10$dHAUlYCUbEXQX0ugu4oiIeFQ0SVJuem9koHzSyIoRD9LofJGaRVu.', 'A0213', 0, NULL, NULL, '2019-10-16 10:47:53', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (237, 'A0214@hdd.store.com', '$2y$10$JV38HbkoVnAZYjzoImyhu.gV/HuOf4p66aRJW.SclBZcwcBIVZTmS', 'A0214', 0, NULL, NULL, '2019-10-16 10:47:54', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (238, 'A0215@hdd.store.com', '$2y$10$Fvo8aYRbcBwc.u7D4djNMu54cdJ7JwDkfPpVhweTa0oUpphSmNK0C', 'A0215', 0, NULL, NULL, '2019-10-16 10:47:55', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (239, 'A0216@hdd.store.com', '$2y$10$N2IjEfAimtpg5i0vHljHvebEqTN3Y.w7rmnpb.n2l9EICsCA/h7mK', 'A0216', 0, NULL, NULL, '2019-10-16 10:47:56', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (240, 'A0217@hdd.store.com', '$2y$10$2YaenpeRa30qscS72JZoeOA6k2UHjQCbRVjbKT.z44tWewxmrFc9q', 'A0217', 0, NULL, NULL, '2019-10-16 10:47:56', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (241, 'A0218@hdd.store.com', '$2y$10$g3ulR2aHhkK6CliNpf8TH.7zYmQdOyw/j1lqeuglMpzapojNnV5lu', 'A0218', 0, NULL, NULL, '2019-10-16 10:47:57', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (242, 'A0219@hdd.store.com', '$2y$10$PToKTHsOPb6pNEtPG8xdFuagZAjAKiz6xDixz0OiMM52jWNzYDmNC', 'A0219', 0, NULL, NULL, '2019-10-16 10:47:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (243, 'A0220@hdd.store.com', '$2y$10$S52ThOUokNqlJAkYirG6cOROS8tZ/CMZT5uRjM7Z15RMi.ZLurKtm', 'A0220', 0, NULL, NULL, '2019-10-16 10:48:00', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (244, 'A0221@hdd.store.com', '$2y$10$bO0duYZjM1oLjHR5h5qv6ed9aE/wALT0i88F0mtIDNoqzUM6WIA62', 'A0221', 0, NULL, NULL, '2019-10-16 10:48:01', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (245, 'A0222@hdd.store.com', '$2y$10$iUcfCcYtI1JUkkEBIDUK7.0dZpItW8K0LUEPIvmtdGcbaUuwFswWG', 'A0222', 0, NULL, NULL, '2019-10-16 10:48:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (246, 'A0223@hdd.store.com', '$2y$10$5kxrHHIlw9mIvEsI9KMUXenkFS/fTWmRaFwRgB7/eT1T6DhZaCGI2', 'A0223', 0, NULL, NULL, '2019-10-16 10:48:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (247, 'A0224@hdd.store.com', '$2y$10$tlTltd/Bv5bnknBf4ERvZeqJZQ1zmXknUiHbSDtkzwFpe1/cK2ePy', 'A0224', 0, NULL, NULL, '2019-10-16 10:48:03', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (248, 'A0225@hdd.store.com', '$2y$10$eVbowcXm71ul9D4kMZtGgeLiLStR3Sqzly9xo7qn516b0Di3E2qlO', 'A0225', 0, NULL, NULL, '2019-10-16 10:48:04', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (249, 'A0226@hdd.store.com', '$2y$10$3PIuqaa.5IjNITSufvWHDOoNfxI4xOmbZXMWhl0aJXzwrfQDJp0ta', 'A0226', 0, NULL, NULL, '2019-10-16 10:48:04', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (250, 'A0227@hdd.store.com', '$2y$10$1NN4IslGKW3z.Gx6Vm35yOPug6qbD9q1.6nWokNcLh1q5lM0gcpbO', 'A0227', 0, NULL, NULL, '2019-10-16 10:48:06', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (251, 'A0228@hdd.store.com', '$2y$10$t7XQrYUFpkyazPfQGI7LTOpaOlFHZatjqoWudIhJkQ2kuujP6gife', 'A0228', 0, NULL, NULL, '2019-10-16 10:48:08', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (252, 'A0229@hdd.store.com', '$2y$10$RGDTh5KXMgRT4WfYVJUY5.PBfy4fh4YOKwUcguG8lnmxEwQKq3jea', 'A0229', 0, NULL, NULL, '2019-10-16 10:48:09', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (253, 'A0230@hdd.store.com', '$2y$10$6.n6P/26tUITzzMVA8wM1egiJobZNW7WyxXVpMg0pW6eAQc3Q0il.', 'A0230', 0, NULL, NULL, '2019-10-16 10:48:09', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (254, 'A0231@hdd.store.com', '$2y$10$MI/FbnuKu/WCTgT.2sWW4.DbpGF/5q0qNwR.ph1OqAxSxBAUpaYwO', 'A0231', 0, NULL, NULL, '2019-10-16 10:48:10', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (255, 'A0232@hdd.store.com', '$2y$10$SM7GKp3/hS559u.wjVqC3e9WXQCkCxXZGcgS6skjQbypHzjijNyF6', 'A0232', 0, NULL, NULL, '2019-10-16 10:48:11', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (256, 'A0233@hdd.store.com', '$2y$10$vj6uV85SNaIp8SJ9KBbSre1yhC1ItJfcAFHMNNrAlG2Pq4VW9z5s.', 'A0233', 0, NULL, NULL, '2019-10-16 10:48:11', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (257, 'A0235@hdd.store.com', '$2y$10$hBVDSSKALbQMRVjfWu4BR.P5etmD.S4sN3MUkhe98G0L7.umIC9Xu', 'A0235', 0, NULL, NULL, '2019-10-16 10:48:12', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (258, 'A0236@hdd.store.com', '$2y$10$vqIbSybvLP5j0MOjzWaBXe4bX.lkUYBPJ2D8VVLgVWvUe5om00FuK', 'A0236', 0, NULL, NULL, '2019-10-16 10:48:13', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (259, 'A0237@hdd.store.com', '$2y$10$AfafFiA8iInfZBG9bAK3zOfkWpN5r0hNQ.mB6pTV4gWHL1X6IWCRa', 'A0237', 0, NULL, NULL, '2019-10-16 10:48:14', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (260, 'A0238@hdd.store.com', '$2y$10$34M25gBUgzqePwnCVaBIg.54a6QW5eZxLGfJrd.cXtK60QQIjuMrq', 'A0238', 0, NULL, NULL, '2019-10-16 10:48:15', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (261, 'A0239@hdd.store.com', '$2y$10$SQ5zVJf0l6hU0cnvjTVwze5T2JMTIfFnV.KSGkl9VGOOPXyYjw8NG', 'A0239', 0, NULL, NULL, '2019-10-16 10:48:15', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (262, 'A0240@hdd.store.com', '$2y$10$OmAlVypJDe.2PJMCw3fYH.BrpQPtwlJk13rH4pjBJG99ca/SAvUjS', 'A0240', 0, NULL, NULL, '2019-10-16 10:48:16', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (263, 'A0241@hdd.store.com', '$2y$10$iscJ8TQXf460SFmQBkTgMed1pZlGnvZYZMhPxxE6WvT.fuaYmNz4e', 'A0241', 0, NULL, NULL, '2019-10-16 10:48:17', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (264, 'A0242@hdd.store.com', '$2y$10$1TonnDRqUAL7nK1CbVvlUujuI.5408zhLgUrYLGvQxd.Vb05Wya5S', 'A0242', 0, NULL, NULL, '2019-10-16 10:48:18', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (265, 'A0243@hdd.store.com', '$2y$10$sbjUlzpOBX2Nq972PTfljeW2JbMwNetPuL/97IT3RvirEcLzADfsC', 'A0243', 0, NULL, NULL, '2019-10-16 10:48:18', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (266, 'A0244@hdd.store.com', '$2y$10$ovr6VLKiPAgZRqlVN1OHKuEvOtlQVnvJB6TFeWnNoZGLwukbvclK6', 'A0244', 0, NULL, NULL, '2019-10-16 10:48:19', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (267, 'A0245@hdd.store.com', '$2y$10$K4w965l2Yp8hGhA8ZLeVJ.TMcQ4LAKxRkLBv.UCqj2.rgGHQs7A5a', 'A0245', 0, NULL, NULL, '2019-10-16 10:48:20', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (268, 'A0246@hdd.store.com', '$2y$10$k5H/id9COhuv2qli0owQIO2fqZexbYZabtqnXtemhbtYHOEIHmGpy', 'A0246', 0, NULL, NULL, '2019-10-16 10:48:21', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (269, 'A0247@hdd.store.com', '$2y$10$QuQpuDIbAjxfF2B6eoNWbesfFKq7rN/7KDPSUfSNS8N2CNG1gPSFG', 'A0247', 0, NULL, NULL, '2019-10-16 10:48:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (270, 'A0248@hdd.store.com', '$2y$10$U34uGMeOXOOS1PNHyhoLdOWsVH5KmB2TYJHjQh9GqSJL89Iyiclxi', 'A0248', 0, NULL, NULL, '2019-10-16 10:48:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (271, 'A0249@hdd.store.com', '$2y$10$/Plx/cd7kbEN0sZnB1UhUehdBXTmE56B44TfnhsKgpW53XEk8IiES', 'A0249', 0, NULL, NULL, '2019-10-16 10:48:23', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (272, 'A0250@hdd.store.com', '$2y$10$r68C1HYydtgJjDHHTiTZPOrlHTNig18u58YNdP327b1fw5fAKojda', 'A0250', 0, NULL, NULL, '2019-10-16 10:48:24', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (273, 'A0251@hdd.store.com', '$2y$10$t1ehi68ptN604NX20aBLHeeHa6aksm2uLOIAcRuHtW5KnSDrbcs.6', 'A0251', 0, NULL, NULL, '2019-10-16 10:48:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (274, 'A0252@hdd.store.com', '$2y$10$6r5RW.L8aXNbV1zT1j23i.VKXV7HpOICisOV71z8LaR6TL2WWMG16', 'A0252', 0, NULL, NULL, '2019-10-16 10:48:26', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (275, 'A0253@hdd.store.com', '$2y$10$rPCbc92uBgH0TJaswsic3.cqDKxRjDwayPoJN9RNqFZmLYMOL57Ey', 'A0253', 0, NULL, NULL, '2019-10-16 10:48:27', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (276, 'A0254@hdd.store.com', '$2y$10$6egcgCvjkLjLk8LR12RlzOfdWEy3jicpP/EDAyoFkIFlOtNPTTarG', 'A0254', 0, NULL, NULL, '2019-10-16 10:48:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (277, 'A0255@hdd.store.com', '$2y$10$CHvRjL.27dEXmHS8tyzMfuyiGFfcvXhlMOv6FWULPY1JvVGOroX22', 'A0255', 0, NULL, NULL, '2019-10-16 10:48:29', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (278, 'A0256@hdd.store.com', '$2y$10$DE6SccYbrHvH4ZjMwn.wNOHTN5mnVCf0j7Z/zc5wW6lQr9TenQEgm', 'A0256', 0, NULL, NULL, '2019-10-16 10:48:30', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (279, 'A0257@hdd.store.com', '$2y$10$f3Qgz3.I2T6RwZoBwUb9MeOgR/zcOBlFh6/RJCDShJYP/K4jzp9sa', 'A0257', 0, NULL, NULL, '2019-10-16 10:48:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (280, 'A0258@hdd.store.com', '$2y$10$1qes7USgwHz3YtNccD5bi.6hLCDzsyLNp/KK1Vd4nKMOSdeSXfMLO', 'A0258', 0, NULL, NULL, '2019-10-16 10:48:31', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (281, 'A0259@hdd.store.com', '$2y$10$Iv5rHMetoHnyr51Y/4lytO2GGqr1wXwyCSHNzsoywz7JiiXeZqPm2', 'A0259', 0, NULL, NULL, '2019-10-16 10:48:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (282, 'A0260@hdd.store.com', '$2y$10$1v4/2RSL2C70nirRG4cpbeeuGGrqHay4/PZyE1qaxZME5jLJZ2JA6', 'A0260', 0, NULL, NULL, '2019-10-16 10:48:33', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (283, 'A0261@hdd.store.com', '$2y$10$Fd5xLrS9CGA6RvCIEoi8lOriBjF4FDq6FUldlY7WeRxD/m0fUsYbW', 'A0261', 0, NULL, NULL, '2019-10-16 10:48:34', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (284, 'A0262@hdd.store.com', '$2y$10$IG64JeidWNcqKQx1slL/r..IoKG1LmNq9mpi0g1q0rvx1eDgtMS.y', 'A0262', 0, NULL, NULL, '2019-10-16 10:48:36', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (285, 'A0263@hdd.store.com', '$2y$10$7IQP16QnXYl0R.lYXc3iQ.nncjAGxQdbYCQfML77W8eMZ5deLq5la', 'A0263', 0, NULL, NULL, '2019-10-16 10:48:37', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (286, 'A0264@hdd.store.com', '$2y$10$VlPKk/JIuqu/2FEDSs6SeeJiqppnsRxXn/aD4QO0lrfijSCiVyPrG', 'A0264', 0, NULL, NULL, '2019-10-16 10:48:37', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (287, 'A0265@hdd.store.com', '$2y$10$9m1l2swMDGYQBP2ph0s/9eymVi.YQZfGKVF48yaL4RIGOK0/1jOni', 'A0265', 0, NULL, NULL, '2019-10-16 10:48:38', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (288, 'A0266@hdd.store.com', '$2y$10$y/nkTCSBtGEXnR3PvmmsEOTkncp1wee4lf.Lm/HzwNwGLGxOjhWkm', 'A0266', 0, NULL, NULL, '2019-10-16 10:48:39', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (289, 'A0267@hdd.store.com', '$2y$10$yYp5OmQg8YrLrx1sTUa0R.ngBczR1XfaaWq.yx9b/ZchZ0k23xabK', 'A0267', 0, NULL, NULL, '2019-10-16 10:48:40', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (290, 'A0268@hdd.store.com', '$2y$10$jxbRD6YK3sGW4nDbkt2BhequA5nhQWo9eIRe4B7RzreMLjFhClkIO', 'A0268', 0, NULL, NULL, '2019-10-16 10:48:41', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (291, 'A0269@hdd.store.com', '$2y$10$VDwWb.hTNcI3NAwFabUJxuPBRio.Iol6vrRyCSyGjQvK.MMSERFHO', 'A0269', 0, NULL, NULL, '2019-10-16 10:48:42', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (292, 'A0270@hdd.store.com', '$2y$10$rXyOydHAQYjIveSbwj/rduEoSJ8xWp7tjN/o9IQwE4FrkZFWnDga6', 'A0270', 0, NULL, NULL, '2019-10-16 10:48:42', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (293, 'A0271@hdd.store.com', '$2y$10$ba3uggCA.z3vx50I0nX6yOIhFN5nk.OWowLovMaHUW.2nzr5z76HW', 'A0271', 0, NULL, NULL, '2019-10-16 10:48:43', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (294, 'A0272@hdd.store.com', '$2y$10$8p.NbbwPaC7IR2vdoG860.L9eFGyZCf505hncJFLpX32U.kGGUuiK', 'A0272', 0, NULL, NULL, '2019-10-16 10:48:44', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (295, 'A0273@hdd.store.com', '$2y$10$zPaDxdkHtMlAejKABa.CROj8OrudTintJi8wkQQt85.Wvqw8GmvbC', 'A0273', 0, NULL, NULL, '2019-10-16 10:48:45', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (296, 'A0274@hdd.store.com', '$2y$10$NCgzld4exEEFnuXrrZkEfuwn7jcuQUr/1sW2SIqNZ8tH2du0XJWza', 'A0274', 0, NULL, NULL, '2019-10-16 10:48:46', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (297, 'A0275@hdd.store.com', '$2y$10$fOKNamI2vrmzofFYJiMY6eOCRXZaBuogyU7WoW3RsxIKXZ2yCaVlK', 'A0275', 0, NULL, NULL, '2019-10-16 10:48:47', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (298, 'A0276@hdd.store.com', '$2y$10$1NR57B0VQzaYbhD/IarU0uYloQi3WOsHsjwrPWe92FXAgv8afsedC', 'A0276', 0, NULL, NULL, '2019-10-16 10:48:48', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (299, 'A0277@hdd.store.com', '$2y$10$wYe9kJW1HMkTjs9KEkw.HOgjN45bk6m4iPjAC6dB0W2Hbx./i6il2', 'A0277', 0, NULL, NULL, '2019-10-16 10:48:49', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (300, 'A0278@hdd.store.com', '$2y$10$xaGOTloU1bhAftq.0lu3K.4bqrdGwo1z8imv.H7MAuyBQvBhUKcha', 'A0278', 0, NULL, NULL, '2019-10-16 10:48:49', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (301, 'A0279@hdd.store.com', '$2y$10$S8rEkYLxwysipMukfqCD.OYl3VXRFKmw4g2iAWWeiI.okVuvrVFwm', 'A0279', 0, NULL, NULL, '2019-10-16 10:48:50', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (302, 'A0280@hdd.store.com', '$2y$10$SOFWBu49HwYl4.kXvpQAaefLI4GBbLz/.kjmwDHGkHWiucAYbXgcG', 'A0280', 0, NULL, NULL, '2019-10-16 10:48:51', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (303, 'A0281@hdd.store.com', '$2y$10$jg165rhf98yhsO3iSKpOZu25cZL2U1EQtvjyMI4f6Exk.x5yEwiNG', 'A0281', 0, NULL, NULL, '2019-10-16 10:48:52', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (304, 'A0282@hdd.store.com', '$2y$10$ahrmai5CvwaB65x/fdstt.pkhKqAwbNbGCBWB0TbJvn5U0F.y/I9y', 'A0282', 0, NULL, NULL, '2019-10-16 10:48:53', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (305, 'A0283@hdd.store.com', '$2y$10$DU0MEK0gWU27mPjihpzLyuSEj/fhdlmtfhW5FkpXaMTTWYCfjYfpq', 'A0283', 0, NULL, NULL, '2019-10-16 10:48:54', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (306, 'A0284@hdd.store.com', '$2y$10$ZBdUZaXoBD.gD5zLZO0/xe.ZVdKR3BWloIx1BDl5m/UCZNr8u.sCG', 'A0284', 0, NULL, NULL, '2019-10-16 10:48:55', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (307, 'A0285@hdd.store.com', '$2y$10$HbmPm/sLbCnmpwck.BS78OxxFeIiPpV3ScmSqriZ0gYyIm7g1ehRe', 'A0285', 0, NULL, NULL, '2019-10-16 10:48:56', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (308, 'A0286@hdd.store.com', '$2y$10$ebc2RQO2NFpUZZy/OYQF2OM0bVigvEiJ2ozOwDGUk7KLfD7VLHGbm', 'A0286', 0, NULL, NULL, '2019-10-16 10:48:56', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (309, 'A0287@hdd.store.com', '$2y$10$ifT7sIxcdwZvSoYcET6SaOwGPSaD1y1l4K6BCmj4GZHWeXt.7wWJG', 'A0287', 0, NULL, NULL, '2019-10-16 10:48:58', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (310, 'A0288@hdd.store.com', '$2y$10$5bIxj4Z.R6IRMLunoax2FuawvBXV6BxyF0vtSN37kktFiq4ZAJbLO', 'A0288', 0, NULL, NULL, '2019-10-16 10:48:58', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (311, 'A0289@hdd.store.com', '$2y$10$L3M0Fuvw7nvev9tuHYBB/uIVW/u.WyvLT3kWXg4BNoXwUrQwo1/6K', 'A0289', 0, NULL, NULL, '2019-10-16 10:48:59', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (312, 'A0290@hdd.store.com', '$2y$10$yXiWuwAJLlMpJgJlXl4yF.1js7bLrpucxJdNF5VZxlkTWcz8zUloW', 'A0290', 0, NULL, NULL, '2019-10-16 10:49:00', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (313, 'A0291@hdd.store.com', '$2y$10$Up47kIv3A5Aq.CV5cecQxOJri.Jxmgs7Q0SEWktIu3jnLvI3HWXMu', 'A0291', 0, NULL, NULL, '2019-10-16 10:49:01', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (314, 'A0292@hdd.store.com', '$2y$10$T1lT1QA6H0NBPa9.TIq5C.WozdaFXKOLx.YrYK4.5maoeCZJrdsMC', 'A0292', 0, NULL, NULL, '2019-10-16 10:49:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (315, 'A0293@hdd.store.com', '$2y$10$5JF5E1cCgHZK4bx7eWg5TuOLyMtAvFisjhuzoXZRrgcjCR1yN2UjG', 'A0293', 0, NULL, NULL, '2019-10-16 10:49:03', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (316, 'A0294@hdd.store.com', '$2y$10$YX88KqSrffVTnMhnFKmNauayaSZz7vt5yU1VjIT4kyHnXBpaTscvG', 'A0294', 0, NULL, NULL, '2019-10-16 10:49:04', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (317, 'A0295@hdd.store.com', '$2y$10$Ga4Jr2pN0kdKLD4uVYrPTuqdkHzEW91aLpPI0H6wUa6A4dgAvxCFO', 'A0295', 0, NULL, NULL, '2019-10-16 10:49:04', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (318, 'A0296@hdd.store.com', '$2y$10$B6zA79Yj8mbK.fGcDMLC1.SbC37Y1bVwuFatn7lsi0WhhCdxEeE9O', 'A0296', 0, NULL, NULL, '2019-10-16 10:49:05', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (319, 'A0297@hdd.store.com', '$2y$10$Ij6tqDX.TUUeh/AfA/IcNuX.IBoINW8cpmyKIfSMEJb3.wZ9ITEum', 'A0297', 0, NULL, NULL, '2019-10-16 10:49:06', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (320, 'A0298@hdd.store.com', '$2y$10$tHHGWCUaRGBSQPrvgs..auaTD/b2F2H5kL2X76XV8q3B5bCS34axC', 'A0298', 0, NULL, NULL, '2019-10-16 10:49:07', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (321, 'A0299@hdd.store.com', '$2y$10$ld6rYvFnxfrZ.6XnKl2lXe0FXhNh4.YkJKtcFTxAb6R9qfkTw4mrm', 'A0299', 0, NULL, NULL, '2019-10-16 10:49:08', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (322, 'A0300@hdd.store.com', '$2y$10$BKUj0tUjip.TlQStY0PJZe17Ua/NXWPRLD5kPw3zt0s8cV8joT/xG', 'A0300', 0, '2019-10-16 10:50:46', '2019-10-16 10:50:46', '2019-10-16 10:49:09', NULL, NULL, NULL, NULL, NULL, '127.0.0.1', 0, 1, '');
INSERT INTO `aauth_users` VALUES (323, 'A0301@hdd.store.com', '$2y$10$Av9Lg8QW92oZbgGHBpx0NeHp5saSZWnNJfFFWN/6X8oQFcubAx/tK', 'A0301', 0, NULL, NULL, '2019-10-21 17:39:22', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (324, 'A0302@hdd.store.com', '$2y$10$6wiWmE83YlmwQwsWqgWfZukwFxnXwaOc2.8m625vMsMsOQ1FMR8H6', 'A0302', 0, NULL, NULL, '2019-10-21 17:39:45', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (325, 'A0303@hdd.store.com', '$2y$10$XWIjSN4376Hq.jnNAOOZNuReLtF47dVCEw3hTpDnWYS4UJAm3iWt.', 'A0303', 0, NULL, NULL, '2019-10-21 17:40:10', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (326, 'A0304@hdd.store.com', '$2y$10$fUdy0zkz9azP59iD1AEzY.czTDCSAut0.X/stbby7zsKQ7CUal0Ge', 'A0304', 0, NULL, NULL, '2019-10-21 17:40:32', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (327, 'A0305@hdd.store.com', '$2y$10$AqbTbNH77vN6w5qBAezdGulF94wc67DZcbS1Bmxroq41S122CrTJ.', 'A0305', 0, NULL, NULL, '2019-10-21 17:40:55', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (328, 'A0306@hdd.store.com', '$2y$10$mWkkbc2M2GoAOsD3licVgeS2ZkfAIriAYHQKq.XLce9Slq520gue6', 'A0306', 0, NULL, NULL, '2019-10-21 17:41:17', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (329, 'A0307@hdd.store.com', '$2y$10$DHT5Z9jDYM0bOpdAeUBBHu1dNbGpoLTHdwDi50QeIlfPLDtqXnKou', 'A0307', 0, NULL, NULL, '2019-10-21 17:41:40', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (330, 'A0308@hdd.store.com', '$2y$10$bbU91B5rxV8rNYXAgp0cU.oWX.CUDX/zqh.DdKnXsMvEro1YoprhK', 'A0308', 0, NULL, NULL, '2019-10-21 17:42:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (331, 'A0309@hdd.store.com', '$2y$10$wrfDVsaKYQYVoMCucC3Tp.HjzOcbDnPRh9yf8DqsD01Gdi/uzeSa.', 'A0309', 0, NULL, NULL, '2019-10-21 17:42:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (332, 'A0310@hdd.store.com', '$2y$10$mtUZOKkl3udwyy.rU8PjkeVSmhBhlRXxMwZAnEyOrbVjlxsZQfW3i', 'A0310', 0, NULL, NULL, '2019-10-21 17:42:48', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (333, 'A0311@hdd.store.com', '$2y$10$tu6er5uOPyG4tfgbhOHmyeOweUee10axEjlxEkfCmV6qLJIfHjiLG', 'A0311', 0, NULL, NULL, '2019-10-21 17:43:17', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (334, 'A0312@hdd.store.com', '$2y$10$C385bpB4yUwaHk1PBsizeeZAqjoD02cH4CVCIk.Zlh6Ma6Xh/zmha', 'A0312', 0, NULL, NULL, '2019-10-21 17:43:39', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (335, 'A0313@hdd.store.com', '$2y$10$/N/OJQBeF8oN39sf/ISlxeaLfnGtRKogovj5uWJyMJw9JL5Omndy.', 'A0313', 0, NULL, NULL, '2019-10-21 17:44:02', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (336, 'A0314@hdd.store.com', '$2y$10$4..eeNlg6yOivFLgeF/3u.g81aPinDl5KVTrPLsSs.T/cIXZfvwni', 'A0314', 0, NULL, NULL, '2019-10-21 17:44:25', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (337, 'A0315@hdd.store.com', '$2y$10$8AYq/2paEPFC3mERlPYBHuUe3Y676XqwLqmAmc823nD08bTVim.3u', 'A0315', 0, NULL, NULL, '2019-10-21 17:44:49', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (338, 'A0316@hdd.store.com', '$2y$10$wWZwOiKc5bibSkAA3a0O/.OXAF0uHmSM2KdxgGLwu59GLDWU/hyTK', 'A0316', 0, NULL, NULL, '2019-10-21 17:45:14', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (339, 'A0317@hdd.store.com', '$2y$10$OMDTH17Nhx06QH3WH6557u1YnrjQkcWJXp5WAZL8mhH0AIOmC8oxy', 'A0317', 0, NULL, NULL, '2019-10-21 17:45:42', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');
INSERT INTO `aauth_users` VALUES (340, 'A0318@hdd.store.com', '$2y$10$jbZNZmuQ/F.tLcfzzC..OesC6vO3zNTuYZsU6/GiCFQfyiVG.Y0CC', 'A0318', 0, NULL, NULL, '2019-10-21 17:46:06', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '');

-- ----------------------------
-- Table structure for evaluate
-- ----------------------------
DROP TABLE IF EXISTS `evaluate`;
CREATE TABLE `evaluate`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NULL DEFAULT NULL COMMENT '订单id',
  `matter` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '评价内容',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of evaluate
-- ----------------------------
INSERT INTO `evaluate` VALUES (1, 1, '2', '2019-12-24 09:20:42', NULL);

-- ----------------------------
-- Table structure for exchange_activities
-- ----------------------------
DROP TABLE IF EXISTS `exchange_activities`;
CREATE TABLE `exchange_activities`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `integral` int(11) NULL DEFAULT NULL COMMENT '积分',
  `activities_time_start` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `activities_time_end` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of exchange_activities
-- ----------------------------
INSERT INTO `exchange_activities` VALUES (1, '12229', 126, '2019-12-08 00:00:00', '2020-01-11 00:11:00', '1111', 'updata/Exchange_activities/2019-12/20191219115045.jpg', 1, 1, '2019-12-19 11:25:40', '2019-12-25 14:07:36');

-- ----------------------------
-- Table structure for faq
-- ----------------------------
DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分类',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容',
  `sort` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '排序',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of faq
-- ----------------------------
INSERT INTO `faq` VALUES (1, '111', '賬戶相關', '111', '11', 1, '2019-12-18 14:58:31', '2019-12-26 14:41:17');

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '物品名稱',
  `up_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '上傳帳號',
  `pic` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '物品圖',
  `goods_type_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '物品分類',
  `purchase_way` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '取物方式',
  `m_place` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '面交地點',
  `use_number` int(11) NULL DEFAULT NULL COMMENT '使用次數',
  `storage_titme` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '存放時間',
  `storage_titme_units` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '存放时间单位',
  `state_label` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT '狀態標籤',
  `custom_label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '自定义标签',
  `freight` int(11) NULL DEFAULT NULL COMMENT '運費',
  `freight_pt` int(11) NULL DEFAULT 0 COMMENT '0贈物方出1取物方付',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `deleted_at` datetime(0) NULL DEFAULT NULL COMMENT '刪除時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES (1, '2121212', '55555', 'updata/goods/2019-12/20191220165701.png,updata/goods/2019-12/20191220165702.png', '除濕', '面交', '[\"11\",\"535\",\"啊啊\"]', 11, '11', '', '[\"\\u50c5\\u8a66\\u7a7f\\u8a66\\u7528\",\"\\u9650\\u6210\\u4eba\"]', '[\"1112\",\"12312\"]', 11, 0, '2019-12-20 16:57:02', NULL, '2019-12-23 11:55:23');
INSERT INTO `goods` VALUES (2, '1312312', '121312', 'updata/goods/2019-12/20191223120041.png,updata/goods/2019-12/20191223120041.jpg', '地暖', '面交', '[\"1\",\"555\",\"11\"]', 11, '22', '日', '[\"\\u6709\\u526f\\u4f5c\\u7528\",\"\\u5373\\u671f\\u8ca8\"]', NULL, 11, 0, '2019-12-23 12:00:41', NULL, NULL);
INSERT INTO `goods` VALUES (3, '1222', '55689', 'updata/goods/2019-12/20191223120605.png', '除濕', '全家店到店', '[\"\"]', 111, '1', '日', '[\"\\u5373\\u671f\\u8ca8\",\"\\u50c5\\u8a66\\u7a7f\\u8a66\\u7528\"]', '[\"121\",\"123\"]', 12111, 0, '2019-12-23 12:06:05', NULL, NULL);

-- ----------------------------
-- Table structure for goods_class
-- ----------------------------
DROP TABLE IF EXISTS `goods_class`;
CREATE TABLE `goods_class`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '物品分類名稱',
  `class_type` int(11) NULL DEFAULT NULL COMMENT '1為大分類2為小分類',
  `parent_id` int(11) NULL DEFAULT NULL COMMENT '小分類的大分類id',
  `pic` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '分類圖',
  `state` int(11) NULL DEFAULT 0 COMMENT '狀態',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `deleted_at` datetime(0) NULL DEFAULT NULL COMMENT '刪除時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of goods_class
-- ----------------------------
INSERT INTO `goods_class` VALUES (1, 'wo', 1, NULL, 'updata/goods_class/2019-11/20191118110512.jpg', 1, '2019-11-17 17:42:09', NULL, '2019-11-20 11:53:11');
INSERT INTO `goods_class` VALUES (2, '第二个', 2, 4, 'updata/goods_class/2019-11/20191118152833.jpg', 1, '2019-11-18 15:28:33', NULL, '2019-11-19 18:28:25');
INSERT INTO `goods_class` VALUES (6, '弟弟', 2, 1, 'updata/goods_class/2019-11/20191120101417.jpg', 1, '2019-11-20 10:13:40', NULL, '2019-12-25 11:37:55');
INSERT INTO `goods_class` VALUES (5, '小分类', 2, 4, 'updata/goods_class/2019-11/20191120110436.jpg', 1, '2019-11-19 17:50:28', NULL, '2019-11-20 11:04:36');
INSERT INTO `goods_class` VALUES (4, '短袖', 1, NULL, 'updata/goods_class/2019-11/20191119171238.jpg', 0, '2019-11-19 17:12:38', NULL, '2019-12-25 11:38:29');
INSERT INTO `goods_class` VALUES (7, '名称', 2, 1, 'updata/goods_class/2019-11/20191120104415.jpg', 1, '2019-11-20 10:44:15', NULL, '2019-12-25 11:37:50');
INSERT INTO `goods_class` VALUES (8, '刘昊然手办', 2, 4, 'updata/goods_class/2019-11/20191120113219.jpg', 1, '2019-11-20 11:32:19', NULL, NULL);
INSERT INTO `goods_class` VALUES (9, '裤子', 1, NULL, 'updata/goods_class/2019-11/20191120115306.jpg', 1, '2019-11-20 11:53:06', NULL, '2019-11-25 15:16:53');
INSERT INTO `goods_class` VALUES (10, '裙子', 1, NULL, 'updata/goods_class/2019-12/20191218110553.png', 1, '2019-11-21 15:03:28', NULL, '2019-12-18 11:05:53');

-- ----------------------------
-- Table structure for impeach
-- ----------------------------
DROP TABLE IF EXISTS `impeach`;
CREATE TABLE `impeach`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NULL DEFAULT NULL COMMENT '订单id',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类型',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '检举内容',
  `imgs` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '图片',
  `reply` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '回复内容',
  `status` int(11) NULL DEFAULT NULL COMMENT '状态1已回复0未回复',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of impeach
-- ----------------------------
INSERT INTO `impeach` VALUES (1, 3, '物品瑕疵', 'Lorem ipsum dolor sit amet, consectetur adipiscing Lorem ipsum dolor sit amet,\r\n\r\n', NULL, '1', 0, '2019-12-19 14:03:04', '2019-12-25 14:17:33');

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NULL DEFAULT NULL,
  `date_time` datetime(0) NULL DEFAULT NULL,
  `code` int(11) NULL DEFAULT NULL,
  `message` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ip_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `third_login` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '第三方登入',
  `hash_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'hash key',
  `nick_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `user_head` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '照片',
  `push` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '推播平台key',
  `lev` tinyint(20) NULL DEFAULT NULL COMMENT '評級',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `last_login` datetime(0) NULL DEFAULT NULL COMMENT '最後登入時間',
  `deleted_at` datetime(0) NULL DEFAULT NULL COMMENT '刪除時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'token',
  `sex` int(1) NULL DEFAULT 1,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手機號碼',
  `birthday` date NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '電子信箱',
  `address` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '地址',
  `integral` int(11) NULL DEFAULT 0 COMMENT '積分0',
  `userpassword` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '密碼',
  `hobby` varchar(2000) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '興趣分類',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '會員表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of members
-- ----------------------------
INSERT INTO `members` VALUES (3, NULL, NULL, '小弟or', NULL, NULL, 1, '2019-11-17 15:41:54', '2019-12-25 10:27:38', NULL, '2019-12-24 14:46:23', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIzIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI1VDEwOjI3OjM4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.44s5tIkJjaNdt462DbXPVzSYvDlfnXLRP9GcwzpuMTA', 1, '0961818173', NULL, 'dreams01@vip.qq.com', '台北', 38917, 'e10adc3949ba59abbe56e057f20f883e', '[\"發\",\"是\"]');
INSERT INTO `members` VALUES (4, NULL, NULL, '第二', NULL, NULL, 2, '2019-11-19 10:45:20', NULL, NULL, NULL, NULL, 1, '0763818173', NULL, 'dreams0@vip.qq.com', '台中', 85, '$2a$08$A/Jej2HGVbyDPhsgIIgwXeUZukrMAYRsQlp6IfJcwuCHXUfodSaJq', '[\"的\"]');
INSERT INTO `members` VALUES (5, NULL, NULL, '刘昊然', NULL, NULL, 2, '2019-11-19 11:26:37', NULL, NULL, '2019-12-17 16:27:36', NULL, 1, '18670385912', NULL, 'dreams010@vip.qq.com', '新营', 100, '$2a$08$1RW00PK69l0t5sfgUab9geH1uhNal7C1I2m2h99H6wYBihsP3jgBC', '[\"爱\",\"我\",\"钱\"]');
INSERT INTO `members` VALUES (6, NULL, NULL, NULL, NULL, NULL, NULL, '2019-12-24 15:22:56', NULL, NULL, NULL, NULL, 1, '15211057400', NULL, '1222222@qq.com', NULL, 0, NULL, NULL);
INSERT INTO `members` VALUES (7, NULL, NULL, '啊啊啊', '111111', NULL, NULL, '2019-12-25 15:03:45', '2019-12-25 15:26:14', NULL, '2019-12-25 15:15:44', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiI3IiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI1VDE1OjI2OjE0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.9FzpDcmHNnm3Sod8VvElbXmPEPBCFNUDFmoT5cnFJtU', 1, '15211057402', NULL, '12222232@qq.com', '台南市', 0, 'e10adc3949ba59abbe56e057f20f883e', '[\"發\",\"是\"]');
INSERT INTO `members` VALUES (8, NULL, NULL, '啊啊啊', '111111', NULL, NULL, '2019-12-25 15:34:28', '2019-12-25 15:46:30', NULL, '2019-12-25 15:50:49', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiI4IiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI1VDE1OjQ2OjMwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.KG7AN0_eNgnVqQadsNskN79WXGZbjBCHPtw2iL1K8gI', 1, '15211057433', NULL, '122222312@qq.com', '台南市', 0, 'fcea920f7412b5da7be0cf42b8c93759', '[\"發\",\"是\"]');
INSERT INTO `members` VALUES (9, NULL, NULL, 'asda', '11', NULL, NULL, '2019-12-25 17:25:16', '2019-12-26 14:40:08', NULL, NULL, 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiI5IiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjQwOjA4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.NrQusz6HUaEc10FN3kt_-JXhdXMsNlvFKZ9aYxXB7dg', 1, '15211057422', NULL, '1213123@qq.com', NULL, 0, 'fcea920f7412b5da7be0cf42b8c93759', '[\"發\",\"是\"]');
INSERT INTO `members` VALUES (10, NULL, NULL, '123456', 'updata/user_head/2019-12/20191226180646.jpg', NULL, NULL, '2019-12-26 18:06:56', '2019-12-27 09:44:02', NULL, NULL, 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMCIsImlzc3VlZEF0IjoiMjAxOS0xMi0yN1QwOTo0NDowMiswODAwIiwidHRsIjo0MzIwMDB9.x5LRDUSvttBVsPN4ttz7WTfpkHMI0LdyS-06iYw68PU', 1, '123', NULL, '123456', NULL, 0, 'e10adc3949ba59abbe56e057f20f883e', '[]');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` bigint(20) NULL DEFAULT NULL COMMENT '订单编号',
  `member_account` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '会员帐号',
  `goods_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品类别',
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '商品名',
  `donor_account` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '赠方帐号',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态1待加压2已浓缩3已完成',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (1, 10000, NULL, NULL, NULL, NULL, 3, NULL, '2019-12-25 14:25:48');
INSERT INTO `orders` VALUES (2, 10001, '11', '面交', '1222', '55689', NULL, '2019-12-23 14:43:59', NULL);
INSERT INTO `orders` VALUES (3, 10002, '12222', '全家店到店', '1222', '55689', 2, '2019-12-23 14:44:53', '2019-12-23 15:00:45');

-- ----------------------------
-- Table structure for status_label
-- ----------------------------
DROP TABLE IF EXISTS `status_label`;
CREATE TABLE `status_label`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '狀態標籤名稱',
  `state` int(11) NULL DEFAULT 0 COMMENT '狀態',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `deleted_at` datetime(0) NULL DEFAULT NULL COMMENT '刪除時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of status_label
-- ----------------------------
INSERT INTO `status_label` VALUES (1, '沒有開封', 0, '2019-11-21 11:10:56', NULL, '2019-12-25 13:59:16');
INSERT INTO `status_label` VALUES (2, '即期貨', 1, '2019-11-21 14:44:21', NULL, '2019-11-21 16:55:17');
INSERT INTO `status_label` VALUES (3, '有副作用', 1, '2019-11-21 14:45:31', NULL, NULL);
INSERT INTO `status_label` VALUES (4, '僅試穿試用', 1, '2019-11-21 14:47:04', NULL, NULL);
INSERT INTO `status_label` VALUES (6, '限成人', 1, '2019-11-21 15:01:33', NULL, '2019-12-23 16:46:08');

-- ----------------------------
-- Table structure for user_ratings
-- ----------------------------
DROP TABLE IF EXISTS `user_ratings`;
CREATE TABLE `user_ratings`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_ratings
-- ----------------------------
INSERT INTO `user_ratings` VALUES (1, '测试', '11111', 'updata/user_ratings/2019-12/20191218140028.png', 1, 1, '2019-12-18 14:00:28', '2019-12-25 13:59:49');

-- ----------------------------
-- Table structure for verify
-- ----------------------------
DROP TABLE IF EXISTS `verify`;
CREATE TABLE `verify`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` int(11) NULL DEFAULT NULL COMMENT '验证码',
  `phone` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '电话',
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'token',
  `stale_time` datetime(0) NULL DEFAULT NULL COMMENT '过期时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 128 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of verify
-- ----------------------------
INSERT INTO `verify` VALUES (1, 1277, '15211057422', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxNTIxMTA1NzQyMiIsImlzc3VlZEF0IjoiMjAxOS0xMi0yNlQwOTo1NzowOSswODAwIiwidHRsIjo0MzIwMDB9.OerNv9s76oeM6-O6cd4rsR9rKz8FQoo5_OJFlTR8Ccc', '2019-12-26 10:07:09');
INSERT INTO `verify` VALUES (2, 7861, '111111', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMTExMTEiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMDk6NTc6MTQrMDgwMCIsInR0bCI6NDMyMDAwfQ.G6zya0jkvzyODk0yo8v7wQL8Pq9w8e7X5shf-mdsgbs', '2019-12-26 10:07:14');
INSERT INTO `verify` VALUES (3, 1896, '15211057422', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxNTIxMTA1NzQyMiIsImlzc3VlZEF0IjoiMjAxOS0xMi0yNlQwOTo1Nzo0OCswODAwIiwidHRsIjo0MzIwMDB9.jgqIU_IuVnIQP9Pk49u-g7I_j8f_QhwSBOMLUz2U0N8', '2019-12-26 10:07:48');
INSERT INTO `verify` VALUES (4, 9034, '158555', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxNTg1NTUiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTA6MDE6NDMrMDgwMCIsInR0bCI6NDMyMDAwfQ.7KqbYvkZiVcVOVjZ4VA1TtDQKqxbCoZW3--iDfmvmTY', '2019-12-26 10:11:43');
INSERT INTO `verify` VALUES (5, 1420, '159753', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxNTk3NTMiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTA6MTY6NDIrMDgwMCIsInR0bCI6NDMyMDAwfQ.stbG1EwrfaNqrgRqN-HJ3hod-cSofZCQ1_9U2Ua0qhY', '2019-12-26 10:26:42');
INSERT INTO `verify` VALUES (6, 2365, '111', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMTEiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTA6MTY6NTgrMDgwMCIsInR0bCI6NDMyMDAwfQ.JOU6Rr8kRMAMoZmotkya5tXcxc_osMSky_LBvCQtye8', '2019-12-26 10:26:58');
INSERT INTO `verify` VALUES (7, 2847, '11', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMSIsImlzc3VlZEF0IjoiMjAxOS0xMi0yNlQxMDoxODo0MCswODAwIiwidHRsIjo0MzIwMDB9.eKfpyyscB45iAEFpRxFF-tnWlJ4dhLktwsO8gM3SRAs', '2019-12-26 10:28:40');
INSERT INTO `verify` VALUES (8, 7265, '11', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMSIsImlzc3VlZEF0IjoiMjAxOS0xMi0yNlQxMDoxODo0NyswODAwIiwidHRsIjo0MzIwMDB9.qscAtwXkBE8KvdKVM-FsZ4ey-0X_E5jUMt88W4KURYc', '2019-12-26 10:28:47');
INSERT INTO `verify` VALUES (9, 8059, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEwOjE5OjUyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.7gR6KgEuhqcrca5SfXXVNgvCTOxIP146E8-yBL9qyMY', '2019-12-26 10:29:52');
INSERT INTO `verify` VALUES (10, 6591, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEwOjMwOjI1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.gBr_J6pQao7vb5mGh--oL4tk9-rHbr7S1JrK_nmi9c4', '2019-12-26 10:40:25');
INSERT INTO `verify` VALUES (11, 7043, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEwOjMxOjMzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.BWCBarGozM3emPkTqXT_SRneLolUgimDBnUYHKZpavE', '2019-12-26 10:41:33');
INSERT INTO `verify` VALUES (12, 4239, '5555', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiI1NTU1IiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEwOjMyOjM2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.Cmqr18_Ui0TsQLlTqiIWv_vMTAl441aLHxeRFWYhmIU', '2019-12-26 10:42:36');
INSERT INTO `verify` VALUES (13, 5316, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEwOjMyOjQ2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.Qmj8sC02bYOa9NuMd6q3g6uZrT8mgq-gOrZEcPeY6b4', '2019-12-26 10:42:46');
INSERT INTO `verify` VALUES (14, 4629, '1111', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMTExIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEwOjU0OjU0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.nndE3UEJ7m8DoNbpHkSVhnHee1kGjWSIriXCcH-IzsQ', '2019-12-26 11:04:54');
INSERT INTO `verify` VALUES (15, 2371, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjAyOjUwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.KwkHUDnT_RMkufQ17tBzbDKxNbdZL7dPB7RKTldO2kU', '2019-12-26 11:12:50');
INSERT INTO `verify` VALUES (16, 6986, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjE2OjU2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.7ESxc12DuosC7ynZAgdKjk1LN5HyZ-g5Wgn0ZEfIta4', '2019-12-26 11:26:56');
INSERT INTO `verify` VALUES (17, 6304, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjE4OjMxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.JV5RNOgjJOOWRD_h1TmJYGfMPbXw4HKidXmu_8u-rS8', '2019-12-26 11:28:31');
INSERT INTO `verify` VALUES (18, 1609, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjIxOjMzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.UEfXToxabQZxCaeCo18d-OQ3cUbXpetyyar2qDYlQnA', '2019-12-26 11:31:33');
INSERT INTO `verify` VALUES (19, 7189, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjMwOjM2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.wblqX1cWniAwMDkL4NUkBmJotcbTBrz4xYbKTBy3XxQ', '2019-12-26 11:40:36');
INSERT INTO `verify` VALUES (20, 5740, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjMwOjQyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.0YKfVSC595Ox68Q4OHCceMju1oxeoiQQV0nxGrAJOLo', '2019-12-26 11:40:42');
INSERT INTO `verify` VALUES (21, 1286, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjMxOjIyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.u8r-emiSBqAjW2hnH5y3u-q6_tkGdBea9koX9GwCuJQ', '2019-12-26 11:41:22');
INSERT INTO `verify` VALUES (22, 1499, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjMzOjQwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.IeVVO_-1L84-GsPLl4EwVuEj8mWUYYbBA0FDhZzZOSE', '2019-12-26 11:43:40');
INSERT INTO `verify` VALUES (23, 3862, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjM5OjA1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.jMw9RLly-h7-txmedo4X-jMSJiPT-UzG6IBrD_2Avl0', '2019-12-26 11:49:05');
INSERT INTO `verify` VALUES (24, 1807, '2', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIyIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQyOjA4KzA4MDAiLCJ0dGwiOjQzMjAwMH0._ZKuuWtGprafRJ8QcmHhtOqqqV_EYb0WRbPbp1fXBzE', '2019-12-26 11:52:08');
INSERT INTO `verify` VALUES (25, 1492, '8', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiI4IiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQyOjIwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.2S6eyjDNqIRGm40yGsWL1sP1UhWu06WAErXIAlvqYKc', '2019-12-26 11:52:20');
INSERT INTO `verify` VALUES (26, 1945, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQzOjI1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.ifCMXosugi3nwoWlOQ9y-O_yqBy2qh3C7ql7zsdm9sk', '2019-12-26 11:53:25');
INSERT INTO `verify` VALUES (27, 6816, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQ0OjQzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.MGmJN4mnar0V9gkiK8AoTqU_zydA-GK0l_8s-uBSDCQ', '2019-12-26 11:54:43');
INSERT INTO `verify` VALUES (28, 8892, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQ0OjQ4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.yK5vWiUNUD7L6V58R4PdlWthADe0K7wAJvaLvwpyf6s', '2019-12-26 11:54:48');
INSERT INTO `verify` VALUES (29, 5692, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQ1OjE5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.Z4SDLMoMv2cA1VK4Yi5L5A7VDH62DlSmS5kIjoXqAYk', '2019-12-26 11:55:19');
INSERT INTO `verify` VALUES (30, 8191, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQ2OjA1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.vM3WIHHAVm6C7Y34Rba12vRIF6Q0AoRRa8TiaQQsM2w', '2019-12-26 11:56:05');
INSERT INTO `verify` VALUES (31, 5319, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQ2OjQ4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.YUtCuaORLe7mogI7OJ1ri5_TZMGAKJLSlMnzl-6ocXo', '2019-12-26 11:56:48');
INSERT INTO `verify` VALUES (32, 9705, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQ2OjU2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.26U5tZAqmi08tLiPrRtW9al-66eIWhecZqxupuCjrHI', '2019-12-26 11:56:56');
INSERT INTO `verify` VALUES (33, 1969, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjQ4OjE1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.vI9E9-AyoO31KcFpWtVL4nDlhGTEQNlfsSqqlPzYqKo', '2019-12-26 11:58:15');
INSERT INTO `verify` VALUES (34, 8960, '555', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiI1NTUiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTE6NDk6MjYrMDgwMCIsInR0bCI6NDMyMDAwfQ.rrKWMhsFMRZV-YOl8XDRh-oatQ26wTWALEQGxNDsKDM', '2019-12-26 11:59:26');
INSERT INTO `verify` VALUES (35, 4858, '2', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIyIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjUwOjA5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.y9SJnAtlxjXRPCGYdY-CWLnY3iDzfWb3YQPz5GIsxIU', '2019-12-26 12:00:09');
INSERT INTO `verify` VALUES (36, 9291, '555', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiI1NTUiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTE6NTE6MTArMDgwMCIsInR0bCI6NDMyMDAwfQ.6YfJwKjR2WnpX1lY3SYjcVjOi3j7URrSsKszYkDYVSA', '2019-12-26 12:01:10');
INSERT INTO `verify` VALUES (37, 5687, '5', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiI1IiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjUxOjE2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.OwxJ_kV3AQKD6zyTcWVA9oSqJFoCJKLlwLvBr1PKii4', '2019-12-26 12:01:16');
INSERT INTO `verify` VALUES (38, 3146, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjUyOjMyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.CfQugdqf5tcALaGkWHp98MxrwRjPdNjGc3RwsPRTG_I', '2019-12-26 12:02:32');
INSERT INTO `verify` VALUES (39, 1115, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjUzOjIwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.ctsUJX9thGsQCSGF6Ca1Ku4EhqCAyC582YNcWKB8p5A', '2019-12-26 12:03:20');
INSERT INTO `verify` VALUES (40, 6933, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjU2OjI5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.x7UmHIUGYJzkQCgMKVD62P0EmByFwpEtBmTJW9LeNgw', '2019-12-26 12:06:29');
INSERT INTO `verify` VALUES (41, 6653, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDExOjU3OjEwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.ivHvjcLg_EEzMlU8YiRIgER6g3EQ7YQD_VHGPGrz1To', '2019-12-26 12:07:10');
INSERT INTO `verify` VALUES (42, 1539, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEyOjAwOjM0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.ZAuLsM5xfZbMSRtuoBvRZLJ4onam7_0LtubAYGr4Kzg', '2019-12-26 12:10:34');
INSERT INTO `verify` VALUES (43, 8546, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEyOjAzOjM1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.gSaGxVyt0uxzK8XiRs5oMNJJ3weSqY97Hb66zp_y_dI', '2019-12-26 12:13:35');
INSERT INTO `verify` VALUES (44, 5379, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEyOjA1OjQwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.J4rAyQcT5Bl3ZsZW625AQSHnDh_wxsptquBkVlVQtNw', '2019-12-26 12:15:40');
INSERT INTO `verify` VALUES (45, 7657, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEyOjA3OjI2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.INvCmYw-3ghet0VDy07kXm-_4HAw73cNTRhTgIPs_pQ', '2019-12-26 12:17:26');
INSERT INTO `verify` VALUES (46, 9605, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEyOjA4OjIyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.9V_TQtjN71nyzpQRg7nwnXUw83rhhOBLlr0jEsgJTy4', '2019-12-26 12:18:22');
INSERT INTO `verify` VALUES (47, 4503, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEyOjA5OjQ0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.eMykZVu9ndWjcyajP4bYeCqd_FmosY7YOc_hdTOvPb4', '2019-12-26 12:19:44');
INSERT INTO `verify` VALUES (48, 3151, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEyOjA5OjUwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.Cc2AHv7RB5EQ_7YqDP_QCMmj4OxB6ns01QbOjGn2uNU', '2019-12-26 12:19:50');
INSERT INTO `verify` VALUES (49, 2220, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEyOjEwOjU0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.IOuRApGXNGvOPPqx4KFDMvoXhB9_2BCrOd5D2pLu7Kw', '2019-12-26 12:20:54');
INSERT INTO `verify` VALUES (50, 7356, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEyOjExOjAzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.NbHwQgEXGRP6qEWmNZ6fpHrLcuH_LN6QFDk8gRkOa5c', '2019-12-26 12:21:03');
INSERT INTO `verify` VALUES (51, 5563, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjA0OjEyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.aYX44_utouBuL4KW_62rOMf28Y2rcuUq5v_Bd3ykI84', '2019-12-26 13:14:12');
INSERT INTO `verify` VALUES (52, 6815, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjE3OjQwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.NLEz419CEtWBt-8jcT1P-FPLeQktvIirzwhAbzrNju4', '2019-12-26 13:27:40');
INSERT INTO `verify` VALUES (53, 2210, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjE3OjQ3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.jQewtjNkttWjvXrG_nqYzIveyFw1KAVkoesILZlrgeg', '2019-12-26 13:27:47');
INSERT INTO `verify` VALUES (54, 7962, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjI5OjMzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.ppmGYKzP3SIREGjSY7PI3QTQMLGXMsubNi5FVtn9COs', '2019-12-26 13:39:33');
INSERT INTO `verify` VALUES (55, 8169, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjI5OjU3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.DXcIrY6_JwJ5HmQi5MkdU-VV50xJUxhbw3bsl14GEdY', '2019-12-26 13:39:57');
INSERT INTO `verify` VALUES (56, 3775, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjMxOjA3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.RLXFlCGZGSMonahqqPFpISMut8UsjEd5rd4BbOxaCY0', '2019-12-26 13:41:07');
INSERT INTO `verify` VALUES (57, 2687, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjM0OjIxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.p2FFd05OnJnhNdqkf9HW30YVmEfUgSVfwksC8uAIjes', '2019-12-26 13:44:21');
INSERT INTO `verify` VALUES (58, 7489, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjM3OjM3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.emqtC24jyN4OC-gv4-ZTn9_vYJlLbd7Px64m-btAluQ', '2019-12-26 13:47:37');
INSERT INTO `verify` VALUES (59, 4373, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjQxOjUzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.FSzVMBPyIkOFXO3d0cXoly_gL1SMRM2tTek0j8qkN3w', '2019-12-26 13:51:53');
INSERT INTO `verify` VALUES (60, 2841, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjQ0OjQ0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.yjBX_77mNeNcp7Q-RZX3n7vVIY6JLfDHDUYWBzUrzGs', '2019-12-26 13:54:44');
INSERT INTO `verify` VALUES (61, 9277, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjQ1OjQ5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.xBzUulSlGuD0L4HLzBE3D3soFWl1PH29X8D6HQZGRNM', '2019-12-26 13:55:49');
INSERT INTO `verify` VALUES (62, 5616, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjQ3OjIyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.ixm5d0TWgh4V5Px7F2ATXUiRSEFG8tf0m9isF-iXqAg', '2019-12-26 13:57:22');
INSERT INTO `verify` VALUES (63, 3835, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjQ4OjU1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.YKWQBDFykDXhBmxnGIQSNFoPFuR_0hDXfJeY6qvjCh4', '2019-12-26 13:58:55');
INSERT INTO `verify` VALUES (64, 2258, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjUyOjA1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.nahQjoEpxQcpO6bFTX--EVjrg3NroaBxMBEiWXO9I44', '2019-12-26 14:02:05');
INSERT INTO `verify` VALUES (65, 8599, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjUzOjI1KzA4MDAiLCJ0dGwiOjQzMjAwMH0._b82B3yB_ejcCkL-HZcljzEEg-ONJjzy_g7e5oI6CAM', '2019-12-26 14:03:25');
INSERT INTO `verify` VALUES (66, 4000, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjU3OjU2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.jIH1MP9crpSNK0d7rVORGVW597T5SMZMiK--u8pRMcA', '2019-12-26 14:07:56');
INSERT INTO `verify` VALUES (67, 6461, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjU4OjQyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.QIoSdwiyuAPPCC1MV8P5NmOhNG5oNPmEFa-4i6-Z_ik', '2019-12-26 14:08:42');
INSERT INTO `verify` VALUES (68, 7486, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDEzOjU5OjM2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.N_XrnZ31ynvcmPF-HqKGS57oeC1hHfp_dWmcMl8vbNw', '2019-12-26 14:09:36');
INSERT INTO `verify` VALUES (69, 5358, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjAxOjE5KzA4MDAiLCJ0dGwiOjQzMjAwMH0._9xoW0FGmE342SBXEwQLm--1-7ZS0luq_l0fmh6i1SM', '2019-12-26 14:11:19');
INSERT INTO `verify` VALUES (70, 4631, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjAyOjQ3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.ACG-bUZHeg-j0kH7PPjpWRke9CKlP7Aoch77BFvaHWk', '2019-12-26 14:12:47');
INSERT INTO `verify` VALUES (71, 9257, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjA0OjMzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.t6vhX7p1NJBZLWDdXBJfOYrwBKDjRxHA7J8J7fvTb4E', '2019-12-26 14:14:33');
INSERT INTO `verify` VALUES (72, 7658, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjA2OjAyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.8wbzHd1ubXxNnNOZKkFfygdxrS1uWdqp1io7WpigkK8', '2019-12-26 14:16:02');
INSERT INTO `verify` VALUES (73, 5958, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjA2OjE3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.Z0SEMSpfYhDqIV36P8i4wQ5LJMDFkaiKzgcgkY6ZnZI', '2019-12-26 14:16:17');
INSERT INTO `verify` VALUES (74, 1838, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjA3OjE5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.bIXMj_4e8DkhDGbnSkjeJQdHZuSJRHCvtHSgtHnrqZg', '2019-12-26 14:17:19');
INSERT INTO `verify` VALUES (75, 4601, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjA4OjMzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.iCG-4HLxUqKzRpXYlVJKlYr8e2R0k8x-HVWQm2IwkdE', '2019-12-26 14:18:33');
INSERT INTO `verify` VALUES (76, 1789, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjA5OjUzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.-62-S-0R7uf5GKdOS-KbOeehv30iQqepj4w741EsYAk', '2019-12-26 14:19:53');
INSERT INTO `verify` VALUES (77, 1071, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjExOjI2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.XF5dUDRYQDx0DOpvF64Rpsn34RfQekEF6tMJ61zRjYo', '2019-12-26 14:21:26');
INSERT INTO `verify` VALUES (78, 1452, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjEyOjAyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.vUJFTXDAEX-n6cjuCUINvzlJDw_IFVZM4l3CZw7fiFc', '2019-12-26 14:22:02');
INSERT INTO `verify` VALUES (79, 9989, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjEyOjQ3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.OE3ijANuVl5sb9RizMZ6UQWhbwyHu40LRU4oS_ogb08', '2019-12-26 14:22:47');
INSERT INTO `verify` VALUES (80, 6024, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjE2OjAwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.bBvH3verqzc7TgKUxC1StU7eVwyrHy7wrx0hnhDfazI', '2019-12-26 14:26:00');
INSERT INTO `verify` VALUES (81, 2170, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjE4OjA3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.Nfjo4OUCOsZSqeqNS2UMYMf_kJI0lgpZaxZiDGt82tk', '2019-12-26 14:28:07');
INSERT INTO `verify` VALUES (82, 4622, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjE4OjQzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.wATjQFk9IGzTmju8q7mTjNfDsU9i8qnWIc0ogP4n6_o', '2019-12-26 14:28:43');
INSERT INTO `verify` VALUES (83, 6072, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjE5OjQ0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.KJYD15yyPILbahVVEdjsnrwUP3xUk-MM4LQFOtHGdS8', '2019-12-26 14:29:44');
INSERT INTO `verify` VALUES (84, 2298, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjIwOjU2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.K4DNVrMXwZKNTvKbSaBnfOrEALIhi7h8Xu-RgqM0JCs', '2019-12-26 14:30:56');
INSERT INTO `verify` VALUES (85, 3593, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjIxOjI0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.CnbHHFR8fcK_q4bPWMvndwcAp2jav4KZGbQkDNRvgCg', '2019-12-26 14:31:24');
INSERT INTO `verify` VALUES (86, 4610, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjIyOjQ5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.-lsAm91EcZ-bldi8gUVCXj0W3-M5az50v86C2f22WKM', '2019-12-26 14:32:49');
INSERT INTO `verify` VALUES (87, 8936, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjIzOjMwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.ZjoGogFGGgILi1QPGbf3j6hu88-7smmjZvs_hs_j7Ok', '2019-12-26 14:33:30');
INSERT INTO `verify` VALUES (88, 9660, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjI0OjE3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.D82F7ws3UgAo9dlsArdel5mvHrACzFncDklrkMtn50E', '2019-12-26 14:34:17');
INSERT INTO `verify` VALUES (89, 4360, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjI1OjE5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.mOtJaVFmECge0B_PCxE8SQ54b_rzh-GQ_IOKPuLEYo4', '2019-12-26 14:35:19');
INSERT INTO `verify` VALUES (90, 2011, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjI2OjUwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.WBCL7NgItkOPUlxm11izBW3ANgjXz1k6gzGnZCP5F4A', '2019-12-26 14:36:50');
INSERT INTO `verify` VALUES (91, 2174, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjMwOjIyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.RrulALs1g4f1RQqUOK8DOYH6fEBHM9cLZUR117a6H-g', '2019-12-26 14:40:22');
INSERT INTO `verify` VALUES (92, 2435, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjMyOjE0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.gTFYnQEpvjGGlyULaEARTnUvOOAJGlJik-szLSUzDlY', '2019-12-26 14:42:14');
INSERT INTO `verify` VALUES (93, 8213, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjM0OjI3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.bRb9HiPx1IzCW0x_-7RPN349uC30hlX8f36Umfj2cMU', '2019-12-26 14:44:27');
INSERT INTO `verify` VALUES (94, 4533, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjM2OjI1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.4Gig3wiz01yJRWWfUbyiGyFTSI8tuLTZzM_-NdePsRU', '2019-12-26 14:46:25');
INSERT INTO `verify` VALUES (95, 8814, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjM3OjA3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.iYJxi0GPNVR3FC_feHPSgHucusMWiiuD36EO0SKG5i4', '2019-12-26 14:47:07');
INSERT INTO `verify` VALUES (96, 8530, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjM3OjQwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.wJUowzI_p1_qtOv7IOwBg42JZt--4alI_T7xyR_SsUU', '2019-12-26 14:47:40');
INSERT INTO `verify` VALUES (97, 5237, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjM3OjU5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.2ZgKOQuBlcV0e50-S2uZbXuLtcOw-rzS6rFSSbv0RpY', '2019-12-26 14:47:59');
INSERT INTO `verify` VALUES (98, 9032, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjM5OjQ1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.b1RaRbl_HEXdrHsgzf3FdaZt12dyFBFuHC6txBBDRGI', '2019-12-26 14:49:45');
INSERT INTO `verify` VALUES (99, 4024, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjQxOjMzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.8OfjbIZeNfndx_SKAMnHaVpOyRd_FUlmKPNh_ixC3xc', '2019-12-26 14:51:33');
INSERT INTO `verify` VALUES (100, 7368, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjQzOjI2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.NVIBQWQ8WRPmC1cyhwhxjq36rVTFg2eBLnE081wIP_w', '2019-12-26 14:53:26');
INSERT INTO `verify` VALUES (101, 3137, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE0OjU1OjAyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.abCjricxnqBlUoZOm9xQ8ClrLFmXB_8Iee2olrTMKOQ', '2019-12-26 15:05:02');
INSERT INTO `verify` VALUES (102, 8757, '17652210745', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxNzY1MjIxMDc0NSIsImlzc3VlZEF0IjoiMjAxOS0xMi0yNlQxNTowOTowMSswODAwIiwidHRsIjo0MzIwMDB9.0cJAPXHZRIE36kwVAbFUJjoN8QeSxZR2-C7pgfy6ffg', '2019-12-26 15:19:01');
INSERT INTO `verify` VALUES (103, 7015, '11', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMSIsImlzc3VlZEF0IjoiMjAxOS0xMi0yNlQxNTo0ODoyNyswODAwIiwidHRsIjo0MzIwMDB9.NtIeEzUwmfLnUw1ffJtDCfU-qVP2jwg7SJys_vwTEc4', '2019-12-26 15:58:27');
INSERT INTO `verify` VALUES (104, 6419, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE1OjU1OjIxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.8P_XxbJ8GKAeOGJZm30gn_-6sVL6XcpuJXUvKgluqOs', '2019-12-26 16:05:21');
INSERT INTO `verify` VALUES (105, 8573, '123', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjMiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTU6NTc6MTUrMDgwMCIsInR0bCI6NDMyMDAwfQ.EIVI4hg7Z35sHWDlc4x_1LpEeK1eFOTeWUX6AcjJfRU', '2019-12-26 16:07:15');
INSERT INTO `verify` VALUES (106, 2870, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE2OjI3OjIyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.JH1jEQgVo-l_NKsQUFgJ-d5wVOPKyOQ4qCaEFDAEvRw', '2019-12-26 16:37:22');
INSERT INTO `verify` VALUES (107, 6812, '111', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMTEiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTY6Mzg6NTUrMDgwMCIsInR0bCI6NDMyMDAwfQ.HeWU91C8w9KDkArVDz82eYVyrD40tnccZuS05riUlfQ', '2019-12-26 16:48:55');
INSERT INTO `verify` VALUES (108, 2601, '17652210745', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxNzY1MjIxMDc0NSIsImlzc3VlZEF0IjoiMjAxOS0xMi0yNlQxNjo0MDozNCswODAwIiwidHRsIjo0MzIwMDB9.6HXEyYy6UYeD10Duj7toOLGvyoDnhWyy6arwri90CWw', '2019-12-26 16:50:34');
INSERT INTO `verify` VALUES (109, 1157, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTY6NDI6NDIrMDgwMCIsInR0bCI6NDMyMDAwfQ.pITlnzE6sa5sV8G2G5pgE8Xj04QgqXPAvT3jhMCv7nc', '2019-12-26 16:52:42');
INSERT INTO `verify` VALUES (110, 3071, '123', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjMiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTY6NDk6MDIrMDgwMCIsInR0bCI6NDMyMDAwfQ.9CWksPQkBwhZEOUkeOmoKjKaDdR_W34ftXpkspGIL5A', '2019-12-26 16:59:02');
INSERT INTO `verify` VALUES (111, 7538, '123', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjMiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTY6NTM6MjArMDgwMCIsInR0bCI6NDMyMDAwfQ.zNREx_g-mUBJ2F_VyH9aoQ2793xqTss42H3HqtZ6hB4', '2019-12-26 17:03:20');
INSERT INTO `verify` VALUES (112, 5520, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTY6NTc6NTMrMDgwMCIsInR0bCI6NDMyMDAwfQ.jNxLBZjdZElQy9Ex2N2The11kA_cL8-sikoqk13q_jc', '2019-12-26 17:07:53');
INSERT INTO `verify` VALUES (113, 8484, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTY6NTk6MDgrMDgwMCIsInR0bCI6NDMyMDAwfQ.weCP83BSe6I8aPyMYN2QfHyvCMZpeRYMD3vVQYM9kUQ', '2019-12-26 17:09:08');
INSERT INTO `verify` VALUES (114, 4802, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6MDA6NTErMDgwMCIsInR0bCI6NDMyMDAwfQ.7tmlcg6Bz2sFpkC6pj5a5-USJRFl0yQU6_i5nYPVI70', '2019-12-26 17:10:51');
INSERT INTO `verify` VALUES (115, 6148, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6MDI6MTgrMDgwMCIsInR0bCI6NDMyMDAwfQ.ol2iUnR5aRvy3vOOsExowmqfavV5d_-fr-OhzXNn2Fg', '2019-12-26 17:12:18');
INSERT INTO `verify` VALUES (116, 7892, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6MDM6NDUrMDgwMCIsInR0bCI6NDMyMDAwfQ.fHy2RJwUl73sa0NSUX21qv-7V2CeMBMz28k2OAsfJMQ', '2019-12-26 17:13:45');
INSERT INTO `verify` VALUES (117, 1804, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6MDU6MDkrMDgwMCIsInR0bCI6NDMyMDAwfQ.xeyT2hgS2klN-6MT8AQ4_1PeShKn9y0n_Fxz_qHpgJI', '2019-12-26 17:15:09');
INSERT INTO `verify` VALUES (118, 3079, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6MDc6NTErMDgwMCIsInR0bCI6NDMyMDAwfQ.6m8VBQaYFfDXGcDnrdyWQcT3x05dDfESiSQu6AZumBA', '2019-12-26 17:17:51');
INSERT INTO `verify` VALUES (119, 3992, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6MTg6NTYrMDgwMCIsInR0bCI6NDMyMDAwfQ.bPXeJegfIqAUOa_NI2VVq9mrDb8DYQfafcbgTdFBMi4', '2019-12-26 17:28:56');
INSERT INTO `verify` VALUES (120, 7037, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6MjI6MjIrMDgwMCIsInR0bCI6NDMyMDAwfQ.iOP_Cfbk9WWJTnsZkFELvbOjnLAsx3vatGK7UVQ_H0g', '2019-12-26 17:32:22');
INSERT INTO `verify` VALUES (121, 5103, '1', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxIiwiaXNzdWVkQXQiOiIyMDE5LTEyLTI2VDE3OjQ5OjAyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.dDbkADL8JYh0irPUgxbfV8ogD3YApCLw0SH3eu6e6xo', '2019-12-26 17:59:02');
INSERT INTO `verify` VALUES (122, 5645, '111', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMTEiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6NDk6MzErMDgwMCIsInR0bCI6NDMyMDAwfQ.HA85PtotCi1Jrr7l_YdBFP6mEPjcyGmBP6Hi19FC64Q', '2019-12-26 17:59:31');
INSERT INTO `verify` VALUES (123, 4969, '12', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMiIsImlzc3VlZEF0IjoiMjAxOS0xMi0yNlQxNzo1MDozNyswODAwIiwidHRsIjo0MzIwMDB9.6m05wMJkFwoBYGlB3NJ4cZ2kzyQ7wDw_z63fzvSSmnw', '2019-12-26 18:00:37');
INSERT INTO `verify` VALUES (124, 5012, '123456', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjM0NTYiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6NTI6MTQrMDgwMCIsInR0bCI6NDMyMDAwfQ.THjcfqcQ6Qm13mo27bIIFCPLaWnVGtQumDU7fmLoeLY', '2019-12-26 18:02:14');
INSERT INTO `verify` VALUES (125, 4066, '123', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjMiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6NTU6MjMrMDgwMCIsInR0bCI6NDMyMDAwfQ.sYsBPMDpvrAerd3b6H6Uxv83IiQigr9thq_d7PsibhA', '2019-12-26 18:05:23');
INSERT INTO `verify` VALUES (126, 2647, '123', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjMiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTc6NTk6NDQrMDgwMCIsInR0bCI6NDMyMDAwfQ.LulHHFo5PcMIPVhHsKMre-lBw8R1CrxHveuia5cM83I', '2019-12-26 18:09:44');
INSERT INTO `verify` VALUES (127, 1551, '123', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIxMjMiLCJpc3N1ZWRBdCI6IjIwMTktMTItMjZUMTg6MDY6MjgrMDgwMCIsInR0bCI6NDMyMDAwfQ.2LMZ81HExzywDnuDv9VUw-6XXoGKCpbLkSslkLml-W8', '2019-12-26 18:16:28');

-- ----------------------------
-- Table structure for version
-- ----------------------------
DROP TABLE IF EXISTS `version`;
CREATE TABLE `version`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '版本编号',
  `create_date` datetime(0) NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of version
-- ----------------------------
INSERT INTO `version` VALUES (1, '111', '2019-12-25 13:58:35');

SET FOREIGN_KEY_CHECKS = 1;
