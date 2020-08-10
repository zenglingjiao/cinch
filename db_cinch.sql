/*
 Navicat Premium Data Transfer

 Source Server         : cinch
 Source Server Type    : MySQL
 Source Server Version : 100136
 Source Host           : 61.222.197.34:3306
 Source Schema         : db_cinch

 Target Server Type    : MySQL
 Target Server Version : 100136
 File Encoding         : 65001

 Date: 10/08/2020 09:33:03
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
) ENGINE = InnoDB AUTO_INCREMENT = 283 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

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
INSERT INTO `aauth_login_attempts` VALUES (31, '220.133.225.33', '2020-01-03 17:54:38', 1);
INSERT INTO `aauth_login_attempts` VALUES (160, '223.104.131.248', '2020-05-30 20:54:32', 4);
INSERT INTO `aauth_login_attempts` VALUES (166, '223.104.131.248', '2020-05-30 20:59:52', 1);
INSERT INTO `aauth_login_attempts` VALUES (281, '59.124.123.104', '2020-08-06 18:47:56', 1);
INSERT INTO `aauth_login_attempts` VALUES (282, '101.10.5.14', '2020-08-06 18:49:12', 2);

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of aauth_users
-- ----------------------------
INSERT INTO `aauth_users` VALUES (1, 'admin@example.com', '$2y$10$Qb9KF3CjlRhPoLXoU/hYfuc7LsQMKfbQX53M48GIfEzDvOCGtDTgO', 'admin', 0, '2020-07-13 11:10:33', '2020-07-13 11:10:33', NULL, NULL, '2020-07-16 00:00:00', '3NEjUfAzF4kKwLmD', '', NULL, '127.0.0.1', 0, 1, NULL);
INSERT INTO `aauth_users` VALUES (2, '155545@gmail.com', '$2y$10$/V2ca/k.LCmPZUzD3p4ck.tBcMXCxu2IBQ/UF.zvdr31bgtu3ISf.', 'cs1234', 0, NULL, NULL, '2020-06-15 18:07:28', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '测试');

-- ----------------------------
-- Table structure for about_us
-- ----------------------------
DROP TABLE IF EXISTS `about_us`;
CREATE TABLE `about_us`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  `activities_time_start` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `activities_time_end` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of about_us
-- ----------------------------
INSERT INTO `about_us` VALUES (8, '認識我們banner', 'updata/About/2020-05/20200525164031.png', 0, 1, '2020-05-16 13:14:42', '2020-05-25 16:40:31', '2020-05-25 16:45:00', '2020-06-01 23:59:59');

-- ----------------------------
-- Table structure for activities_details
-- ----------------------------
DROP TABLE IF EXISTS `activities_details`;
CREATE TABLE `activities_details`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NULL DEFAULT NULL COMMENT '类型1团体2个人',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `qualification` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '报名资格',
  `announcements_activities` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '活动注意事项',
  `announcements_apply` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '报名注意事项',
  `entry` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '參賽辦法',
  `competition_period` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '比赛期间',
  `apply_period` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '报名期间',
  `img_schedule` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '赛程图片',
  `img_schedule_app` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '赛程图片(手机版)',
  `img_scoring` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '计分图片',
  `img_scoring_app` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '计分图片(手机版)',
  `added_at` datetime(0) NULL DEFAULT NULL COMMENT '上架时间',
  `awards_imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '奖项图片',
  `awards_explain` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '奖项说明',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of activities_details
-- ----------------------------
INSERT INTO `activities_details` VALUES (1, 1, '131', 'qqqq', 'ww', 'eee', 'rrr', '2020-07-18 00:00:00~2020-07-25 23:59:59', '2020-04-07 00:00:00~2020-04-17 23:59:59', 'updata/goods/2020-05/202005291014211.jpg', 'updata/goods/2020-07/20200707135336.jpeg', 'updata/goods/2020-07/20200707135336.jpg', '', NULL, '[\"updata\\/goods\\/2020-05\\/20200529101421.jpg\"]', '[\"1231\",\"\"]', 1, '2020-03-02 15:38:46', '2020-07-07 13:53:36');
INSERT INTO `activities_details` VALUES (2, 2, '123', '123', '123', '121', '1111', '2020-07-01 00:00:00~2020-07-10 23:59:59', '2020-06-16 10:00:00~2020-06-24 09:57:59', 'updata/goods/2020-05/202005290952192.jpg', 'updata/goods/2020-06/20200610140817.png', 'updata/goods/2020-05/202005290952193.jpg', NULL, '2020-06-16 09:56:00', '[\"updata\\/goods\\/2020-05\\/20200529095219.jpg\",\"updata\\/goods\\/2020-05\\/202005290952191.jpg\"]', '[\"123\",\"321\"]', 0, '2020-03-02 15:40:26', '2020-07-03 09:21:04');
INSERT INTO `activities_details` VALUES (3, 1, '6y', '6y', '6y', 'y6', 'y6', '2020-03-12 00:00:00~2020-03-14 23:59:59', '2020-03-12 00:00:00~2020-03-14 23:59:59', 'updata/goods/2020-05/202005181652101.jpg', NULL, 'updata/goods/2020-05/202005181652102.jpg', NULL, '2020-05-31 00:00:00', '[\"updata\\/goods\\/2020-05\\/20200518165210.jpg\"]', '[\"22\"]', 0, '2020-03-12 11:07:31', '2020-05-18 16:52:10');
INSERT INTO `activities_details` VALUES (6, 1, '11', '12', '', '', '4444', '2020-06-17 00:00:00~2020-06-21 23:59:59', '2020-06-10 00:00:00~2020-06-14 23:59:59', 'updata/goods/2020-04/20200416112707.jpg', 'updata/goods/2020-06/20200602150656.jpg', 'updata/goods/2020-04/20200416112717.jpg', NULL, NULL, '[\"updata\\/goods\\/2020-04\\/20200416112726.jpg\",\"updata\\/goods\\/2020-06\\/20200615010116.jpeg\"]', '[\"111\",\"Hshhc\"]', 0, '2020-04-16 11:05:42', '2020-06-24 10:23:22');
INSERT INTO `activities_details` VALUES (7, 1, '1qw', '233', '23', NULL, '211', '2020-07-03 00:00:00~2020-07-30 23:59:59', '2020-07-01 00:00:00~2020-07-17 23:59:59', 'updata/goods/2020-07/202007021800441.jpg', 'updata/goods/2020-07/202007021800442.jpg', 'updata/goods/2020-07/202007021800443.jpg', NULL, NULL, '[\"updata\\/goods\\/2020-07\\/20200702180044.jpg\"]', '[\"\"]', 0, '2020-07-02 18:00:44', '2020-07-03 09:44:50');
INSERT INTO `activities_details` VALUES (8, 2, 'uiol', 'uil', 'iuliu', NULL, 'iluii', '2020-07-06 00:00:00~2020-07-10 23:59:59', '2020-07-03 00:00:00~2020-07-05 23:59:59', 'updata/goods/2020-07/20200703101117.png', 'updata/goods/2020-07/20200703101541.jpg', 'updata/goods/2020-07/202007031011171.png', 'updata/goods/2020-07/202007031015411.jpg', NULL, '[\"updata\\/goods\\/2020-07\\/20200703101541.jpeg\"]', '[\"\"]', 0, '2020-07-03 09:21:00', '2020-07-07 09:28:17');
INSERT INTO `activities_details` VALUES (9, 2, 'vbv', 'zxccxz', 'kuyk', NULL, 'ukyky', '2020-07-13 00:00:00~2020-07-18 23:59:59', '2020-07-07 00:00:00~2020-07-12 23:59:59', 'updata/goods/2020-07/202007070929131.jpg', 'updata/goods/2020-07/20200707092913.jpeg', 'updata/goods/2020-07/202007070929132.jpg', 'updata/goods/2020-07/202007070929131.jpeg', NULL, '[\"updata\\/goods\\/2020-07\\/20200707092913.jpg\"]', '[\"\"]', 0, '2020-07-07 09:29:13', '2020-07-07 15:22:15');
INSERT INTO `activities_details` VALUES (10, 2, 'sscsc', 'scsc', 'annoying', NULL, 'really annoying', '2020-07-10 00:00:00~2020-07-12 23:59:59', '2020-07-07 00:00:00~2020-07-09 23:59:59', 'updata/goods/2020-07/202007071522131.jpg', 'updata/goods/2020-07/202007071522132.jpg', 'updata/goods/2020-07/202007071522133.jpg', 'updata/goods/2020-07/202007071522134.jpg', NULL, '[\"updata\\/goods\\/2020-07\\/20200707152213.jpg\"]', '[\"\"]', 1, '2020-07-07 15:22:13', '2020-07-07 15:22:16');

-- ----------------------------
-- Table structure for apply
-- ----------------------------
DROP TABLE IF EXISTS `apply`;
CREATE TABLE `apply`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '队名',
  `poll` int(11) NOT NULL COMMENT '票数',
  `type` int(11) NULL DEFAULT NULL COMMENT '类型1团体2个人',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `no` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '编号',
  `manifesto` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '宣言',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `crew1_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组员1姓名',
  `crew1_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组员1编号',
  `crew2_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组员2姓名',
  `crew2_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组员2编号',
  `crew3_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组员3姓名',
  `crew3_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组员3编号',
  `crew4_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组员4姓名',
  `crew4_no` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '组员4编号',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 123 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of apply
-- ----------------------------
INSERT INTO `apply` VALUES (1, NULL, 1, 2, '111', '11', '22', 'updata/Apply/2020-04/20200416111100.jpg', '', '', '', '', '', '', '', '', '', '2020-04-16 11:09:46', '2020-04-16 11:11:00');
INSERT INTO `apply` VALUES (2, NULL, 0, 1, '3', '3', '', 'updata/Apply/2020-04/20200416111224.jpg', '', '', '', '', '', '', '', '', '', '2020-04-16 11:12:24', NULL);
INSERT INTO `apply` VALUES (3, NULL, 0, 1, '2', '34', '4', '', '2', '1', '23', '4', '4', '5', '5', '6', '6', '2020-05-28 16:10:23', NULL);
INSERT INTO `apply` VALUES (4, NULL, 0, 2, '321321', '666666', '321321321', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:44:15', NULL);
INSERT INTO `apply` VALUES (5, NULL, 0, 2, '321321', '666666', '321321321', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:46:06', NULL);
INSERT INTO `apply` VALUES (6, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:46:27', NULL);
INSERT INTO `apply` VALUES (7, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:46:45', NULL);
INSERT INTO `apply` VALUES (8, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:46:49', NULL);
INSERT INTO `apply` VALUES (9, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:47:01', NULL);
INSERT INTO `apply` VALUES (10, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:47:02', NULL);
INSERT INTO `apply` VALUES (11, NULL, 3, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:47:19', NULL);
INSERT INTO `apply` VALUES (12, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:47:39', NULL);
INSERT INTO `apply` VALUES (13, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:47:44', NULL);
INSERT INTO `apply` VALUES (14, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:48:08', NULL);
INSERT INTO `apply` VALUES (15, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:49:31', NULL);
INSERT INTO `apply` VALUES (16, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:52:02', NULL);
INSERT INTO `apply` VALUES (17, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:52:42', NULL);
INSERT INTO `apply` VALUES (18, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:06', NULL);
INSERT INTO `apply` VALUES (19, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:08', NULL);
INSERT INTO `apply` VALUES (20, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:11', NULL);
INSERT INTO `apply` VALUES (21, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:13', NULL);
INSERT INTO `apply` VALUES (22, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:13', NULL);
INSERT INTO `apply` VALUES (23, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:14', NULL);
INSERT INTO `apply` VALUES (24, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:15', NULL);
INSERT INTO `apply` VALUES (25, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:15', NULL);
INSERT INTO `apply` VALUES (26, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:15', NULL);
INSERT INTO `apply` VALUES (27, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:15', NULL);
INSERT INTO `apply` VALUES (28, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:16', NULL);
INSERT INTO `apply` VALUES (29, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:16', NULL);
INSERT INTO `apply` VALUES (30, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:16', NULL);
INSERT INTO `apply` VALUES (31, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:18', NULL);
INSERT INTO `apply` VALUES (32, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:36', NULL);
INSERT INTO `apply` VALUES (33, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:38', NULL);
INSERT INTO `apply` VALUES (34, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:40', NULL);
INSERT INTO `apply` VALUES (35, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:40', NULL);
INSERT INTO `apply` VALUES (36, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:41', NULL);
INSERT INTO `apply` VALUES (37, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:41', NULL);
INSERT INTO `apply` VALUES (38, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:44', NULL);
INSERT INTO `apply` VALUES (39, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:54', NULL);
INSERT INTO `apply` VALUES (40, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:54', NULL);
INSERT INTO `apply` VALUES (41, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:55', NULL);
INSERT INTO `apply` VALUES (42, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:55', NULL);
INSERT INTO `apply` VALUES (43, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:55', NULL);
INSERT INTO `apply` VALUES (44, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:55', NULL);
INSERT INTO `apply` VALUES (45, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:56', NULL);
INSERT INTO `apply` VALUES (46, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:56', NULL);
INSERT INTO `apply` VALUES (47, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:56', NULL);
INSERT INTO `apply` VALUES (48, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:57', NULL);
INSERT INTO `apply` VALUES (49, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:57', NULL);
INSERT INTO `apply` VALUES (50, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:53:58', NULL);
INSERT INTO `apply` VALUES (51, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:54:06', NULL);
INSERT INTO `apply` VALUES (52, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:54:27', NULL);
INSERT INTO `apply` VALUES (53, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:54:31', NULL);
INSERT INTO `apply` VALUES (54, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:54:31', NULL);
INSERT INTO `apply` VALUES (55, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:54:31', NULL);
INSERT INTO `apply` VALUES (56, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:54:32', NULL);
INSERT INTO `apply` VALUES (57, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:54:32', NULL);
INSERT INTO `apply` VALUES (58, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:54:33', NULL);
INSERT INTO `apply` VALUES (59, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:54:33', NULL);
INSERT INTO `apply` VALUES (60, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:47', NULL);
INSERT INTO `apply` VALUES (61, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:49', NULL);
INSERT INTO `apply` VALUES (62, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:53', NULL);
INSERT INTO `apply` VALUES (63, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:53', NULL);
INSERT INTO `apply` VALUES (64, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:53', NULL);
INSERT INTO `apply` VALUES (65, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:53', NULL);
INSERT INTO `apply` VALUES (66, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:54', NULL);
INSERT INTO `apply` VALUES (67, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:55', NULL);
INSERT INTO `apply` VALUES (68, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:56', NULL);
INSERT INTO `apply` VALUES (69, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:57:58', NULL);
INSERT INTO `apply` VALUES (70, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:58:17', NULL);
INSERT INTO `apply` VALUES (71, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:58:18', NULL);
INSERT INTO `apply` VALUES (72, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:58:18', NULL);
INSERT INTO `apply` VALUES (73, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:58:18', NULL);
INSERT INTO `apply` VALUES (74, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:58:18', NULL);
INSERT INTO `apply` VALUES (75, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:58:18', NULL);
INSERT INTO `apply` VALUES (76, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 19:58:19', NULL);
INSERT INTO `apply` VALUES (77, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:00:41', NULL);
INSERT INTO `apply` VALUES (78, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:00:41', NULL);
INSERT INTO `apply` VALUES (79, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:00:41', NULL);
INSERT INTO `apply` VALUES (80, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:00:41', NULL);
INSERT INTO `apply` VALUES (81, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:00:42', NULL);
INSERT INTO `apply` VALUES (82, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:00:42', NULL);
INSERT INTO `apply` VALUES (83, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:00:43', NULL);
INSERT INTO `apply` VALUES (84, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:00:46', NULL);
INSERT INTO `apply` VALUES (85, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:01:00', NULL);
INSERT INTO `apply` VALUES (86, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:01:06', NULL);
INSERT INTO `apply` VALUES (87, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:34:20', NULL);
INSERT INTO `apply` VALUES (88, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 20:41:41', NULL);
INSERT INTO `apply` VALUES (89, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-28 21:02:26', NULL);
INSERT INTO `apply` VALUES (90, NULL, 0, 2, '3333', '666666', '3333', 'updata/home/2020-05/20200529094051.jpg', '', '', '', '', '', '', '', '', '', '2020-05-29 09:40:55', NULL);
INSERT INTO `apply` VALUES (91, NULL, 0, 2, '', '666666', '', '', '', '', '', '', '', '', '', '', '', '2020-05-29 09:41:35', NULL);
INSERT INTO `apply` VALUES (92, NULL, 0, 1, '666666', '111111', '321321', 'updata/home/2020-05/20200529101115.jpg', '3333', '666666', '222222', '666666', '333333', '666666', '444444', '666666', '555555', '2020-05-29 10:11:32', NULL);
INSERT INTO `apply` VALUES (93, NULL, 0, 1, '321', '111111', '321', 'updata/home/2020-05/20200529101831.jpg', '321', '321', '222222', '321', '333333', '321', '444444', '321', '555555', '2020-05-29 10:18:40', NULL);
INSERT INTO `apply` VALUES (94, NULL, 0, 2, 'ㄎ', '666666', 'ㄨ', 'updata/home/2020-05/20200529164330.png', '', '', '', '', '', '', '', '', '', '2020-05-29 16:43:34', NULL);
INSERT INTO `apply` VALUES (95, NULL, 0, 2, 'ㄎ', '666666', 'ㄨ', 'updata/home/2020-05/20200529164330.png', '', '', '', '', '', '', '', '', '', '2020-05-29 16:43:40', NULL);
INSERT INTO `apply` VALUES (96, NULL, 0, 1, 'ㄇ', '111111', 'ㄇ', 'updata/home/2020-05/20200529164437.png', 'ㄇ', 'ㄋ', '222222', 'ㄎ', '333333', 'ˇ', '444444', 'ㄐ', '555555', '2020-05-29 16:44:48', NULL);
INSERT INTO `apply` VALUES (97, '1', 0, 1, 'ㄇ', '111111', 'ㄇ', 'updata/home/2020-05/20200529164437.png', 'ㄇ', 'ㄋ', '222222', 'ㄎ', '333333', 'ˇ', '444444', 'ㄐ', '555555', '2020-05-29 16:45:01', '2020-05-29 17:16:02');
INSERT INTO `apply` VALUES (98, NULL, 4, 2, '喔', '666666', '我', '', '', '', '', '', '', '', '', '', '', '2020-05-29 16:46:23', NULL);
INSERT INTO `apply` VALUES (99, '', 28, 2, '6666', '666666', '66', '', '', '', '', '', '', '', '', '', '', '2020-06-01 09:15:09', NULL);
INSERT INTO `apply` VALUES (100, '', 0, 2, '6666', '666666', '66', 'updata/home/2020-06/20200601091509.jpg', '', '', '', '', '', '', '', '', '', '2020-06-01 09:15:11', NULL);
INSERT INTO `apply` VALUES (101, '', 7, 2, '321321', '666666', '321321', 'updata/home/2020-06/20200601184719.jpg', '', '', '', '', '', '', '', '', '', '2020-06-01 18:47:22', NULL);
INSERT INTO `apply` VALUES (102, '', 7, 2, '333', '666666', '333', 'updata/home/2020-06/20200601184823.jpg', '', '', '', '', '', '', '', '', '', '2020-06-01 18:48:24', NULL);
INSERT INTO `apply` VALUES (103, '666666', 1, 1, '666666', '111111', '666666', 'updata/home/2020-06/20200601185102.jpg', '666666', '666666', '222222', '666666', '333333', '666666', '444444', '666666', '555555', '2020-06-01 18:51:09', NULL);
INSERT INTO `apply` VALUES (104, '', 2, 1, '3321', '666666', '', '', '3213', '321321', '666666', '32132', '666666', '321', '666666', '321', '666666', '2020-06-03 11:15:05', NULL);
INSERT INTO `apply` VALUES (105, '', 2, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '2020-06-03 14:37:32', NULL);
INSERT INTO `apply` VALUES (106, '', 8, 2, '我說', '8159675', '你啊', 'updata/home/2020-06/20200604110116.png', '', '', '', '', '', '', '', '', '', '2020-06-04 11:01:32', NULL);
INSERT INTO `apply` VALUES (107, '321', 2, 1, '32132', '8159675', '3213', 'updata/home/2020-06/20200604113709.jpg', '13213', '21', '8159675', '321', '8159675', '321', '8159675', '321', '8159675', '2020-06-04 11:37:16', NULL);
INSERT INTO `apply` VALUES (108, '', 0, 1, '', '', '', 'updata/Apply/2020-06/20200622112422.jpg', '', '', '', '', '', '', '', '', '', '2020-06-04 13:46:53', '2020-06-22 11:24:23');
INSERT INTO `apply` VALUES (109, '', 1, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '2020-06-04 13:46:54', NULL);
INSERT INTO `apply` VALUES (110, '', 1, 2, 'z', '8159675', 'zz', 'updata/home/2020-06/20200605110017.jpg', '', '', '', '', '', '', '', '', '', '2020-06-05 11:00:37', NULL);
INSERT INTO `apply` VALUES (111, '', 1, 2, 'Aa', '8159675', 'Kk', 'updata/home/2020-06/20200605115622.jpeg', '', '', '', '', '', '', '', '', '', '2020-06-05 11:56:38', NULL);
INSERT INTO `apply` VALUES (112, '321', 1, 1, '321', '', '321', 'updata/home/2020-06/20200605163040.jpg', '321', '321', '', '321', '', '321', '', '321', '', '2020-06-05 16:30:50', NULL);
INSERT INTO `apply` VALUES (113, 'cascs', 0, 1, 'c', '8159675', 'sc', 'updata/home/2020-06/20200605180410.png', '0987878787', 's', '8161410', 'a', '8160462', '', '', '', '', '2020-06-05 18:04:27', NULL);
INSERT INTO `apply` VALUES (114, 'aa', 1, 1, 'ww', '8159675', 'axa', 'updata/home/2020-06/20200610140001.png', '09765656567', 'dd', '8161409', 'rr', '8161410', NULL, NULL, NULL, NULL, '2020-06-10 14:04:36', NULL);
INSERT INTO `apply` VALUES (115, 'j', 0, 1, 'xx', '8150675', 'jklj', 'updata/Apply/2020-06/20200622111250.jpg', '0945422456', 'rr', '8161409', 'kk', '8161410', NULL, NULL, NULL, NULL, '2020-06-11 16:27:26', '2020-06-22 11:12:50');
INSERT INTO `apply` VALUES (116, '', 0, 2, '王小明', '8019063', '我一定變超帥喔吧', 'updata/home/2020-06/20200615004950.jpeg', '', '', '', '', '', NULL, NULL, NULL, NULL, '2020-06-15 00:49:55', '2020-06-15 00:51:01');
INSERT INTO `apply` VALUES (117, '', 0, 2, 'aa', '8159675', 'cscsc', 'updata/Apply/2020-07/20200707152604.jpg', '', '', '', '', '', NULL, NULL, NULL, NULL, '2020-07-07 15:26:04', NULL);
INSERT INTO `apply` VALUES (118, '', 0, 2, 'ssccs', '8159675', 'sccs', 'updata/home/2020-07/20200708142006.jpg', '', '', '', '', '', NULL, NULL, NULL, NULL, '2020-07-08 14:20:10', NULL);
INSERT INTO `apply` VALUES (119, '', 0, 2, '我', '8159675', '這', 'updata/home/2020-07/20200708142102.jpeg', '', '', '', '', '', NULL, NULL, NULL, NULL, '2020-07-08 14:21:03', NULL);
INSERT INTO `apply` VALUES (120, '', 0, 2, '哈', '8159675', '有', 'updata/home/2020-07/20200710162945.jpeg', '', '', '', '', '', NULL, NULL, NULL, NULL, '2020-07-10 16:29:56', NULL);
INSERT INTO `apply` VALUES (121, '', 0, 2, '不', '8159610', '不', 'updata/home/2020-07/20200710163936.jpeg', '', '', '', '', '', NULL, NULL, NULL, NULL, '2020-07-10 16:39:38', NULL);
INSERT INTO `apply` VALUES (122, '', 0, 2, '不', '8159610', '這', 'updata/home/2020-07/20200710171604.png', '', '', '', '', '', NULL, NULL, NULL, NULL, '2020-07-10 17:16:05', NULL);

-- ----------------------------
-- Table structure for cinch_product
-- ----------------------------
DROP TABLE IF EXISTS `cinch_product`;
CREATE TABLE `cinch_product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classify` int(11) NULL DEFAULT NULL COMMENT '分类1cleanse清2nourish調3energize活4推薦組合',
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产品名',
  `subhead` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '副标题',
  `crosshead1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小标题1',
  `content1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容1',
  `crosshead2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小标题2',
  `content2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容2',
  `crosshead3` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小标题3',
  `content3` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容3',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `product_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产品网址',
  `shop_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '购物网址',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 25 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cinch_product
-- ----------------------------
INSERT INTO `cinch_product` VALUES (2, 1, '紫花苜蓿 錠狀食品', '鹼性好食物 體內環保一身輕', '精選原料　純淨品質', '種植在天氣宜人的加州農場，不添加化肥、農藥、除草劑、殺草劑的紫花苜蓿品種，確保品', '嚴謹程序　掌握關鍵營養', '紫花苜蓿葉子的營養價值最高也最為豐富，嘉康利僅取用處在成熟期、葉綠素含量最高且位', '由內而外　清除廢物', '紫花苜蓿是優質的鹼性食物，其能提供人體完整又多樣的營養素。讓您精神好氣色佳、清爽', 'updata/Cinch_product/2020-05/20200530160321.png', 5, '', '', 1, '2020-04-09 11:01:34', '2020-05-30 16:03:21');
INSERT INTO `cinch_product` VALUES (3, 4, '纖奇清潤活套組', '簡單卻也不簡單的日常套組', '清 · 潤 · 活  更新你的美力', '清－邁立纖+暢益菌+紫花苜蓿，體內環保\n潤－雪克全方位補足營養\n活－能量茶促代謝', '套組超優惠 就是喜歡Fit生活', '邁立纖1瓶、暢益菌1瓶、紫花苜蓿1瓶、Life纖奇雪克2罐、纖奇能量茶1盒。', '提供香草及拿鐵兩種口味選擇', '', 'updata/Cinch_product/2020-05/20200530165650.png', 2, '', '', 1, '2020-04-30 09:43:24', '2020-05-30 16:56:50');
INSERT INTO `cinch_product` VALUES (8, 3, '纖奇能量茶-紅石榴口', '讓您能量提升 精神活力一把罩', '4種茶多酚 喝的活力來源', '來自充滿異國風味的博士茶、抹茶、白茶及綠茶，能促進新陳代謝，幫助去油解膩。', '牛磺酸 能量補給胺基酸', '身體製造其他胺基酸的重要物質，能讓您迅速增強體力、精神飽滿、電力滿格的能量來源。', '低熱量 獨特絕妙風味', '取代咖啡、碳酸飲料的聰明選擇！\n微酸甜，添加紅石榴及接骨木果萃取，提升健康保護力', 'updata/Cinch_product/2020-05/20200530165505.png', 2, '', '', 1, '2020-04-30 10:54:13', '2020-05-30 16:55:05');
INSERT INTO `cinch_product` VALUES (9, 3, '纖奇能量茶-原味', '讓您能量提升 精神活力一把罩', '4種茶多酚 喝的活力來源', '來自充滿異國風味的博士茶、抹茶、白茶及綠茶，能促進新陳代謝，幫助去油解膩。', '牛磺酸 能量補給胺基酸', '身體製造其他胺基酸的重要物質，能讓您迅速增強體力、精神飽滿、電力滿格的能量來源。', '低熱量 獨特絕妙風味', '能取代咖啡、飲料、碳酸飲料的聰明選擇，既提神又健康！\n便利包隨手沖泡，冷熱皆宜。', 'updata/Cinch_product/2020-05/20200530165307.png', 1, '', '', 1, '2020-04-30 10:56:43', '2020-05-30 16:53:07');
INSERT INTO `cinch_product` VALUES (10, 4, '纖奇七日啟動套組', '簡單卻也不簡單的日常套組', '清 · 潤 · 活  一周就有感覺', '清－7日隨身包重新啟動身體機能\n潤－雪克全方位補足營養\n活－能量茶促代謝增活力', '入門最推薦 立即展開Fit生活', '纖奇七日隨身包１盒、纖奇雪克1罐、纖奇能量茶1盒。\n再送你1個纖奇專屬搖搖杯。', '香草、拿鐵兩種口味', '', 'updata/Cinch_product/2020-05/20200530165154.png', 1, '', '', 1, '2020-04-30 10:58:30', '2020-05-30 16:51:54');
INSERT INTO `cinch_product` VALUES (11, 1, '暢益菌 膠囊食品', '好菌in 壞菌out 消化自然好順暢', '獨特配方  4種優勢益生菌', '4益菌可以改變消化道內細菌叢生態，讓好菌健康的生長，確實抵達發揮支持消化道的效果', '每天一顆  50億好菌確實補充', '每顆提供50億好菌，調整因生活及飲食造成的消化改變，幫助排便順暢，同時調整體質', '生活必備  消化好人健康', '針對生活節奏快、外食頻率高、壓力大運動少的現代人，好菌能幫助你的生活更健康！', 'updata/Cinch_product/2020-05/20200530164706.png', 4, '', '', 1, '2020-04-30 12:14:07', '2020-05-30 16:47:06');
INSERT INTO `cinch_product` VALUES (12, 1, '邁立纖 錠狀食品', '本草配方有效控醣 代謝力UP', '醣類對策 代謝穩妥當：', '獨特巴拿巴葉、礦物質釩及鉻，有助維持醣類正常代謝。特適合愛吃米飯，無法抗拒甜食者', '邁力加倍 促進新陳代謝', '綠茶萃取物，含關鍵成分兒茶素EGCG，幫助擁有健康與活力。', '本草萃取 調節生理機能：', '吳茱萸果實萃取及紫玉米萃取，調節生理機能，發揮幫助促進新陳代謝的作用。', 'updata/Cinch_product/2020-05/20200530164848.png', 3, '', '', 1, '2020-04-30 12:15:44', '2020-05-30 16:48:48');
INSERT INTO `cinch_product` VALUES (13, 1, '纖奇西梅暢飲', '滿滿優質複合莓果 給你一個暢快', '天然莓果力量  排便好順暢', '嚴選自智利的高品質歐洲西梅+專利三階段發酵製程，再加上10種莓果植物萃取。', '水溶性膳食纖維  消化好健康', '來自法國新一代水溶性膳食纖維Nutriose，搭配菊糖及乳糖醇，提升消化道健康。', '5國精華集結，打造消化好體質', '智利高品質西梅、比利時菊糖、法國膳食纖維、日本山茶花萃取及以色列綜合水果汁。', 'updata/Cinch_product/2020-05/20200530164113.png', 2, '', '', 1, '2020-04-30 12:24:51', '2020-05-30 16:41:13');
INSERT INTO `cinch_product` VALUES (22, 2, '纖奇雪克-拿鐵口味', '口味不凡的美型管理師', '活力輕盈 獨特白胺酸比例', '非基因改造大豆蛋白結合白胺酸、米蛋白的獨特比例，天天喝，讓你越喝越有型。', '營養滿點 多種維生素礦物質', '補充每日所需多元營養，添加B群、鈣、鐵、鉻等，符合健康營養原則，為健康打好基礎。', '強化消化力＋代謝力', '美國專利益生菌及益菌生，幫助排便順暢；Omega-3脂肪酸，幫助循環健康。', 'updata/Cinch_product/2020-05/20200530164251.png', 2, '', '', 1, '2020-04-30 12:49:50', '2020-05-30 16:42:51');
INSERT INTO `cinch_product` VALUES (23, 2, '纖奇雪克-香草口味', '口味不凡的美型管理師', '活力輕盈 獨特白胺酸比例', '非基因改造大豆蛋白結合白胺酸、米蛋白的獨特比例，天天喝，讓你越喝越有型。', '營養滿點 多種維生素礦物質', '補充每日所需多元營養，添加B群、鈣、鐵、鉻等，符合健康營養原則，為健康打好基礎。', '強化消化力＋代謝力', '美國專利益生菌及益菌生，幫助排便順暢；Omega-3脂肪酸，幫助循環健康。', 'updata/Cinch_product/2020-05/20200530164307.png', 1, 'https://www.shaklee.com.tw/products/10669', '', 1, '2020-04-30 17:49:20', '2020-06-15 18:11:59');
INSERT INTO `cinch_product` VALUES (24, 1, '纖奇7日隨身包', '一點都不麻煩 它給我輕盈健康的感覺', '健康益處 7天就感受不同', '現代人各種體質皆適合體驗的聰明保養法\n促進新陳代謝、維持消化道機能、啟動體內環保', '三種產品 一次體驗', '蘊含大地深層營養的紫花苜蓿、添加鉻可維持醣類正常代謝的邁立纖及支持化道機能暢益菌', '早晚一包 簡單、方便而且有效', '早晚隨身包設計，方便攜帶，讓你日夜都能輕鬆補充有益營養，隨時做好健康管理！', 'updata/Cinch_product/2020-05/20200530162255.png', 1, '', '', 1, '2020-05-16 13:36:22', '2020-06-01 16:12:44');

-- ----------------------------
-- Table structure for cinch_product_image
-- ----------------------------
DROP TABLE IF EXISTS `cinch_product_image`;
CREATE TABLE `cinch_product_image`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  `activities_time_start` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `activities_time_end` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cinch_product_image
-- ----------------------------
INSERT INTO `cinch_product_image` VALUES (3, '纖奇產品banner', 'updata/Cinch_product_image/2020-05/20200525154926.png', 1, '2020-04-30 09:47:27', '2020-05-25 15:49:26', '2020-05-25 15:55:00', '2020-06-01 23:59:59');

-- ----------------------------
-- Table structure for client_claim
-- ----------------------------
DROP TABLE IF EXISTS `client_claim`;
CREATE TABLE `client_claim`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名/昵称',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '手机',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '邮箱',
  `line_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Line ID',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 38 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of client_claim
-- ----------------------------
INSERT INTO `client_claim` VALUES (1, '12312', '123123', '123211', '121', '2020-02-19 14:39:49', '2020-02-19 14:42:54');
INSERT INTO `client_claim` VALUES (2, '1', '2', '3', '4', '2020-04-10 14:09:20', NULL);
INSERT INTO `client_claim` VALUES (3, '2', '3', '4', '5', '2020-04-10 14:17:10', NULL);
INSERT INTO `client_claim` VALUES (4, '', '', '', '', '2020-04-26 09:34:54', NULL);
INSERT INTO `client_claim` VALUES (5, '', '', '', '', '2020-04-26 09:35:00', NULL);
INSERT INTO `client_claim` VALUES (6, '321321', '3', '21', '321', '2020-04-26 09:36:58', NULL);
INSERT INTO `client_claim` VALUES (7, '', '', '', '', '2020-04-26 09:37:33', NULL);
INSERT INTO `client_claim` VALUES (8, '', '', '', '', '2020-04-26 09:37:43', NULL);
INSERT INTO `client_claim` VALUES (9, '', '', '', '', '2020-04-26 09:39:39', NULL);
INSERT INTO `client_claim` VALUES (10, '', '', '', '', '2020-04-26 09:39:53', NULL);
INSERT INTO `client_claim` VALUES (11, '', '', '', '', '2020-04-26 09:39:56', NULL);
INSERT INTO `client_claim` VALUES (12, '', '', '', '', '2020-04-26 09:39:58', NULL);
INSERT INTO `client_claim` VALUES (13, '', '', '', '', '2020-04-26 09:39:59', NULL);
INSERT INTO `client_claim` VALUES (14, '', '', '', '', '2020-04-26 09:40:00', NULL);
INSERT INTO `client_claim` VALUES (15, '', '', '', '', '2020-04-26 09:40:01', NULL);
INSERT INTO `client_claim` VALUES (16, '', '', '', '', '2020-04-26 09:40:03', NULL);
INSERT INTO `client_claim` VALUES (17, '', '', '', '', '2020-04-26 09:40:04', NULL);
INSERT INTO `client_claim` VALUES (18, '', '', '', '', '2020-04-26 09:42:10', NULL);
INSERT INTO `client_claim` VALUES (19, '', '', '', '', '2020-04-26 09:42:16', NULL);
INSERT INTO `client_claim` VALUES (20, '', '', '', '', '2020-04-26 09:47:25', NULL);
INSERT INTO `client_claim` VALUES (21, '', '', '', '', '2020-04-26 09:48:13', NULL);
INSERT INTO `client_claim` VALUES (22, '', '', '', '', '2020-04-26 10:27:37', NULL);
INSERT INTO `client_claim` VALUES (23, '', '', '', '', '2020-04-26 10:27:54', NULL);
INSERT INTO `client_claim` VALUES (24, '', '', '', '', '2020-04-26 10:29:25', NULL);
INSERT INTO `client_claim` VALUES (25, '', '', '', '', '2020-04-26 10:29:25', NULL);
INSERT INTO `client_claim` VALUES (26, '', '', '', '', '2020-04-26 10:31:29', NULL);
INSERT INTO `client_claim` VALUES (27, '', '', '', '', '2020-04-26 10:31:31', NULL);
INSERT INTO `client_claim` VALUES (28, '', '', '', '', '2020-04-26 10:31:31', NULL);
INSERT INTO `client_claim` VALUES (29, '', '', '', '', '2020-04-26 10:32:17', NULL);
INSERT INTO `client_claim` VALUES (30, '', '', '', '', '2020-04-27 09:55:23', NULL);
INSERT INTO `client_claim` VALUES (31, '', '', '', '', '2020-04-27 10:08:59', NULL);
INSERT INTO `client_claim` VALUES (32, '33', '33', '33', '33', '2020-04-28 09:29:24', NULL);
INSERT INTO `client_claim` VALUES (33, '321', '321', '321', '321', '2020-04-29 17:19:56', NULL);
INSERT INTO `client_claim` VALUES (34, 'aaa', 'qqq', '111', '23123', '2020-04-29 17:48:58', NULL);
INSERT INTO `client_claim` VALUES (35, 'andra', '0900000000', 'qqq@gmail.com', 'qqq@gmail.com', '2020-04-30 09:55:42', NULL);
INSERT INTO `client_claim` VALUES (36, 'qq', '0988888888', '88@gmail.com', '88@qq.com', '2020-06-09 17:11:49', NULL);
INSERT INTO `client_claim` VALUES (37, 'Linda', '0916853618', 'Juiling0503@gmail.com', '', '2020-06-15 00:41:42', NULL);

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
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of exchange_activities
-- ----------------------------
INSERT INTO `exchange_activities` VALUES (1, '12229', 126, '2019-12-08 00:00:00', '2020-01-11 00:11:00', '1111', 'updata/Exchange_activities/2019-12/20191219115045.jpg', 1, 1, '2019-12-19 11:25:40', '2019-12-25 14:07:36');
INSERT INTO `exchange_activities` VALUES (2, '12131', 123123, '2020-02-15 00:00:00', '2020-03-12 23:59:59', '2131231', 'updata/Exchange_activities/2020-02/20200205210648.png', 12312, 0, '2020-02-05 21:06:48', NULL);
INSERT INTO `exchange_activities` VALUES (3, '1231', 1231, '2020-02-14 00:00:00', '2020-03-15 23:59:59', 'aa', 'updata/Exchange_activities/2020-02/20200205211052.png', 1, 1, '2020-02-05 21:10:52', '2020-02-05 21:11:18');

-- ----------------------------
-- Table structure for guestbook
-- ----------------------------
DROP TABLE IF EXISTS `guestbook`;
CREATE TABLE `guestbook`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '发送账号',
  `receiver` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '接收账号',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `created_date` date NULL DEFAULT NULL COMMENT '创建时间（date）',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for hot_film
-- ----------------------------
DROP TABLE IF EXISTS `hot_film`;
CREATE TABLE `hot_film`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网址',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hot_film
-- ----------------------------
INSERT INTO `hot_film` VALUES (1, '影片五', 'https://www.youtube.com/embed/Kr0uUv1khng', 12, 1, '2020-02-19 16:36:39', '2020-06-03 10:02:39');
INSERT INTO `hot_film` VALUES (2, '影片四', 'https://www.youtube.com/embed/_kkFZ3JKsaU', 0, 1, '2020-03-12 11:13:23', '2020-06-03 10:00:58');
INSERT INTO `hot_film` VALUES (3, '影片三', 'https://www.youtube.com/embed/2pC8Jk2FDO4', 0, 1, '2020-03-12 11:17:21', '2020-06-03 09:59:55');
INSERT INTO `hot_film` VALUES (4, '影片二', 'https://www.youtube.com/embed/hhf_MupyfIA', 0, 1, '2020-03-12 11:17:27', '2020-06-03 14:36:23');
INSERT INTO `hot_film` VALUES (5, '影片一', 'https://www.youtube.com/embed/W9Pi_BvOiZ4', 0, 1, '2020-03-12 11:17:38', '2020-06-03 14:24:01');

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
-- Table structure for major_product
-- ----------------------------
DROP TABLE IF EXISTS `major_product`;
CREATE TABLE `major_product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产品名',
  `subhead` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '副标题',
  `crosshead1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小标题1',
  `content1` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容1',
  `crosshead2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小标题2',
  `content2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容2',
  `crosshead3` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '小标题3',
  `content3` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容3',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `product_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '产品网址',
  `shop_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '购物网址',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of major_product
-- ----------------------------
INSERT INTO `major_product` VALUES (2, '纖奇能量茶', '讓您能量提升 精神活力一把罩', '4種茶多酚 喝的活力來源', '來自充滿異國風味的博士茶、抹茶、白茶及綠茶，能促進新陳代謝，幫助去油解膩。', '牛磺酸 能量補給胺基酸', '能讓您迅速增強體力、精神飽滿、電力滿格的能量來源！ ', '低熱量 獨特絕妙風味', '能取代咖啡、飲料、碳酸飲料的聰明選擇，既提神又健康！\n便利包隨手沖泡，冷熱皆宜', 'updata/Major_product/2020-05/20200530165755.png', 3, '', '', 1, '2020-03-11 11:22:51', '2020-05-30 16:57:55');
INSERT INTO `major_product` VALUES (8, '纖奇雪克', '口味不凡的美型管理師', '活力輕盈 獨特白胺酸比例', '非基因改造大豆蛋白結合白胺酸、米蛋白的獨特比例，天天喝，讓你越喝越有型。', '營養滿點 多種維生素礦物質', '補充每日所需多元營養，添加B群、鈣、鐵、鉻等，符合健康營養原則，為健康打好基礎。', '強化消化力＋代謝力', '美國專利益生菌及益菌生，幫助排便順暢；Omega-3脂肪酸，幫助循環健康。', 'updata/Major_product/2020-05/20200530165834.png', 2, '', '', 1, '2020-05-16 13:07:25', '2020-05-30 16:58:34');
INSERT INTO `major_product` VALUES (9, '纖奇7日隨身包', '一點都不麻煩 它給我輕盈健康的感覺', '健康益處 7天就感受不同', '現代人各種體質皆適合體驗的聰明保養法，促進新陳代謝、維持消化道機能、啟動體內環保', '三種產品 一次體驗', '蘊含大地深層營養的紫花苜蓿、添加鉻可維持醣類正常代謝的邁立纖及支持化道機能暢益菌', '早晚一包 簡單、方便而且有效', '早晚隨身包設計，方便攜帶，讓你日夜都能輕鬆補充有益營養，隨時做好健康管理！', 'updata/Major_product/2020-05/20200530165718.png', 1, '', '', 0, '2020-05-20 12:26:48', '2020-06-29 09:18:51');

-- ----------------------------
-- Table structure for master_image
-- ----------------------------
DROP TABLE IF EXISTS `master_image`;
CREATE TABLE `master_image`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `activities_time_start` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `activities_time_end` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_image
-- ----------------------------
INSERT INTO `master_image` VALUES (14, '纖奇懂你要的FIT', '2020-05-30 14:10:00', '2044-06-30 23:59:59', 'updata/Master_image/2020-05/20200530140749.jpg', 1, '2020-05-30 14:07:49', '2020-05-30 14:08:13');
INSERT INTO `master_image` VALUES (12, '主頁banner', '2020-05-25 16:55:00', '2020-06-01 23:59:59', 'updata/Master_image/2020-05/20200525165025.png', 0, '2020-05-16 12:22:31', '2020-05-30 14:08:03');

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
  `registration_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '推播平台registration_id',
  `push` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '推播平台key',
  `lev` tinyint(20) NULL DEFAULT 1 COMMENT '評級',
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '會員表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片大',
  `imgs_small` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片小',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容',
  `added_time` datetime(0) NULL DEFAULT NULL COMMENT '上架时间',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES (1, '123', 'updata/News/2020-06/20200624104046.jpg', 'updata/News/2020-06/202006241040461.jpg', '123', '2020-07-23 00:00:00', 1, '2020-02-19 16:28:53', '2020-06-24 10:40:46');
INSERT INTO `news` VALUES (2, '買書？借書？我們直接送書！', 'updata/News/2020-06/20200603144256.jpg', 'updata/News/2020-06/20200629112259.png', '這裡有很多書跟紙，想要的可以拿，如果都沒人拿走就要回收了這裡有很多書跟紙，想要的可以拿，如果都沒人拿走就要回收了這裡有很多書跟紙，想要的可以拿，如果都沒人拿走就要回收了這裡有很多書跟紙，想要的可以拿，如果都沒人拿走就要回收了', '2020-06-29 11:25:00', 1, '2020-06-03 14:42:56', '2020-06-29 11:22:59');
INSERT INTO `news` VALUES (3, '啊什麼時候可以出國', 'updata/News/2020-06/20200603144442.jpg', 'updata/News/2020-06/20200629112326.png', '快悶壞了啊啊啊啊啊啊啊好想出國玩，手機相簿都停在去年泰國的旅行了啦齁四月本來要去韓國九月本來想去澳洲的欸可惡', '2020-06-29 11:25:00', 1, '2020-06-03 14:44:42', '2020-06-29 11:23:26');
INSERT INTO `news` VALUES (4, 'cs', 'updata/News/2020-06/20200629094331.jpg', 'updata/News/2020-06/202006290943311.jpg', 'cs1', '2020-08-16 00:00:00', 1, '2020-06-29 09:41:57', '2020-06-29 09:43:31');
INSERT INTO `news` VALUES (5, 'zxzx', 'updata/News/2020-06/20200629111922.png', 'updata/News/2020-06/20200629111922.jpg', 'zxzxz', '2020-06-29 11:20:00', 1, '2020-06-29 11:19:22', NULL);
INSERT INTO `news` VALUES (6, 'test', 'updata/News/2020-06/20200630095112.png', 'updata/News/2020-07/20200702151725.jpeg', 'hjhljhl', '2020-07-02 15:20:00', 1, '2020-06-30 09:51:12', '2020-07-02 15:17:25');

-- ----------------------------
-- Table structure for picture_button
-- ----------------------------
DROP TABLE IF EXISTS `picture_button`;
CREATE TABLE `picture_button`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类型1图片2按钮',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `activities_time_start` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `activities_time_end` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of picture_button
-- ----------------------------
INSERT INTO `picture_button` VALUES (1, '1', '12', '2020-07-16 00:00:00', '2020-07-26 23:59:59', 'updata/Picture_button/2020-06/20200616171247.jpg', 0, '2020-02-19 16:11:15', '2020-06-16 17:12:47');
INSERT INTO `picture_button` VALUES (11, '1', 'TEST', '2020-05-29 16:30:00', '2020-06-17 23:59:59', 'updata/Picture_button/2020-05/20200529162938.png', 1, '2020-05-29 16:29:38', NULL);
INSERT INTO `picture_button` VALUES (3, '2', '7899', '2020-04-10 00:00:00', '2020-04-12 23:59:59', 'updata/Picture_button/2020-03/20200311173932.jpg', 0, '2020-03-11 17:39:32', '2020-04-09 17:30:50');
INSERT INTO `picture_button` VALUES (4, '2', '9888', '2020-04-10 00:00:00', '2020-04-15 23:59:59', 'updata/Picture_button/2020-03/20200311174028.jpg', 1, '2020-03-11 17:40:28', '2020-04-09 16:54:45');
INSERT INTO `picture_button` VALUES (6, '2', '66', '2020-04-10 00:00:00', '2020-04-15 23:59:59', 'updata/Picture_button/2020-03/20200311174131.jpg', 1, '2020-03-11 17:41:31', '2020-04-09 16:54:14');
INSERT INTO `picture_button` VALUES (7, '2', '111', '2020-04-10 00:00:00', '2020-04-15 23:59:59', 'updata/Picture_button/2020-03/20200311174343.jpg', 1, '2020-03-11 17:43:43', '2020-04-09 16:53:28');
INSERT INTO `picture_button` VALUES (8, '2', 'rrr', '2020-04-10 00:00:00', '2020-04-15 23:59:59', 'updata/Picture_button/2020-03/20200312094823.jpg', 1, '2020-03-12 09:48:23', '2020-04-09 16:53:56');
INSERT INTO `picture_button` VALUES (9, '1', 'www', '2020-04-11 00:00:00', '2020-04-15 23:59:59', 'updata/Picture_button/2020-04/20200409162102.png', 0, '2020-04-09 16:21:02', '2020-05-29 16:29:42');
INSERT INTO `picture_button` VALUES (10, '2', 'qqq', '2020-04-11 00:00:00', '2020-04-14 23:59:59', 'updata/Picture_button/2020-04/20200409162121.png', 1, '2020-04-09 16:21:21', '2020-04-09 16:52:44');

-- ----------------------------
-- Table structure for pledge_image
-- ----------------------------
DROP TABLE IF EXISTS `pledge_image`;
CREATE TABLE `pledge_image`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  `activities_time_start` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `activities_time_end` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pledge_image
-- ----------------------------
INSERT INTO `pledge_image` VALUES (6, 'Z', 'updata/Pledge_image/2020-07/20200709173809.png', 1, '2020-07-09 17:38:09', NULL, '2020-07-09 17:40:00', '2020-07-12 23:59:59');
INSERT INTO `pledge_image` VALUES (5, '保證', 'updata/Pledge_image/2020-05/20200508172643.png', 1, '2020-05-08 17:26:43', '2020-05-08 17:26:49', '2020-05-08 17:27:00', '2020-05-24 23:59:59');

-- ----------------------------
-- Table structure for prediction_win_image
-- ----------------------------
DROP TABLE IF EXISTS `prediction_win_image`;
CREATE TABLE `prediction_win_image`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  `activities_time_start` datetime(0) NULL DEFAULT NULL COMMENT '开始时间',
  `activities_time_end` datetime(0) NULL DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of prediction_win_image
-- ----------------------------
INSERT INTO `prediction_win_image` VALUES (1, 'qwe', 'updata/Prediction_win_image/2020-03/20200312112216.jpg', 1, '2020-03-12 11:22:16', '2020-03-12 11:27:10', '2020-03-14 00:00:00', '2020-03-15 23:59:59');
INSERT INTO `prediction_win_image` VALUES (2, 'qt', 'updata/Prediction_win_image/2020-04/20200407151304.jpg', 1, '2020-03-12 11:26:08', '2020-05-28 16:19:16', '2020-05-20 00:00:00', '2020-05-31 23:59:59');
INSERT INTO `prediction_win_image` VALUES (3, '我不會輸的', 'updata/Prediction_win_image/2020-04/20200409112920.png', 1, '2020-04-09 11:29:20', '2020-06-22 17:46:00', '2020-06-22 17:46:00', '2020-06-28 23:59:59');

-- ----------------------------
-- Table structure for products_for
-- ----------------------------
DROP TABLE IF EXISTS `products_for`;
CREATE TABLE `products_for`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of products_for
-- ----------------------------
INSERT INTO `products_for` VALUES (1, '7天健康管理   一日三餐這樣吃!', '營養師專業傳授！\n豐富多變又不用挨餓的健康管理食譜。\n想開始又不知道從何起步，\n跟著做讓你健康又窈窕！', 'updata/Products_for/2020-06/20200615181242.jpg', NULL, '2020-06-15 18:36:42');

-- ----------------------------
-- Table structure for propaganda_film
-- ----------------------------
DROP TABLE IF EXISTS `propaganda_film`;
CREATE TABLE `propaganda_film`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网址',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of propaganda_film
-- ----------------------------
INSERT INTO `propaganda_film` VALUES (1, '纖奇七日隨身包', 'https://www.youtube.com/embed/TuTJB_FtRbI', 12, 1, '2020-02-19 11:32:21', '2020-05-21 17:46:26');
INSERT INTO `propaganda_film` VALUES (2, '纖奇西梅暢飲', 'https://www.youtube.com/embed/C4YeenYdQJw', 2, 1, '2020-03-11 10:35:59', '2020-05-21 17:47:58');

-- ----------------------------
-- Table structure for proposita
-- ----------------------------
DROP TABLE IF EXISTS `proposita`;
CREATE TABLE `proposita`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '网址',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `sort` int(11) NULL DEFAULT NULL COMMENT '排序',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of proposita
-- ----------------------------
INSERT INTO `proposita` VALUES (1, '123', '12321', 'https://www.youtube.com/embed/RZuP-2h97DQ', 'updata/Proposita/2020-04/20200429145140.jpg', 123, 0, '2020-02-19 14:19:43', '2020-06-09 00:43:31');
INSERT INTO `proposita` VALUES (2, '11', '12', '123', 'updata/Proposita/2020-04/20200429145132.jpg', 132, 0, '2020-03-11 17:04:39', '2020-05-16 13:23:25');
INSERT INTO `proposita` VALUES (3, '1qqq', 'qq', 'qq', 'updata/Proposita/2020-05/20200518152122.jpg', 0, 0, '2020-03-11 17:05:37', '2020-06-15 18:05:27');
INSERT INTO `proposita` VALUES (4, '14qrr', 'rrrrr', '4444', 'updata/Proposita/2020-04/20200429145110.jpg', 0, 1, '2020-03-11 17:06:36', '2020-06-15 18:05:18');
INSERT INTO `proposita` VALUES (5, '纖奇 值得我Fit', '5555', 'https://www.youtube.com/embed/Z1Fvd-mx2Jc', 'updata/Proposita/2020-06/20200609004204.jpg', 0, 1, '2020-03-11 17:07:02', '2020-06-09 00:42:04');
INSERT INTO `proposita` VALUES (6, '纖奇 幫我找回S曲線', '產品見證 超人媽媽 林欣穎\n三寶媽的我，深深理解產後的困擾!\n試過許多品牌效果都不好，直到遇見嘉康利\n纖奇雪克不僅讓我恢復到產前狀態\n營養素充足的狀況下，也沒有鬧奶荒\n這是讓我最開心的事!', 'https://www.youtube.com/embed/Wgmcp0IXPGU', 'updata/Proposita/2020-06/20200609003749.jpg', 0, 1, '2020-03-11 17:07:29', '2020-06-09 00:37:49');
INSERT INTO `proposita` VALUES (7, '林怡君   值得我Fit', '勇於挑戰更好的我\n我覺得人都應該勇於改變遇到更好的自己，當初決定由科技業轉換到健康產業，在最近全球疫情動盪不安的局面下，我更深深相信當初正確的決定！\n起初接觸纖奇是想維持亮麗自信的外型，提升自我的競爭力，固定食用後發現，纖奇雪克帶給我的，不只是維持外在的體態，裡面有含的：\n大豆蛋白質、多種礦物質、益生菌/膳食纖維、Omega-3不飽和脂肪酸\n更能給身體足夠營養素!\n輕鬆吃吃喝喝，身體就有感!!', 'https://www.youtube.com/embed/KYsOp7o4ggY', 'updata/Proposita/2020-06/20200609004056.png', 1, 1, '2020-05-16 13:22:43', '2020-06-09 00:40:56');

-- ----------------------------
-- Table structure for proposition
-- ----------------------------
DROP TABLE IF EXISTS `proposition`;
CREATE TABLE `proposition`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NULL DEFAULT NULL COMMENT '1清2润3活',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '内容',
  `imgs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '图片',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of proposition
-- ----------------------------
INSERT INTO `proposition` VALUES (3, 1, '內在淨化了，\n健康才能真正進化！', 'updata/Proposition/2020-05/20200525172037.png', 1, '2020-03-11 11:04:47', '2020-05-25 17:20:37');
INSERT INTO `proposition` VALUES (7, 3, '能量時刻充沛補給了，\n活力自然精氣十足！', 'updata/Proposition/2020-05/20200525172126.png', 1, '2020-04-30 09:17:59', '2020-05-25 17:23:17');
INSERT INTO `proposition` VALUES (8, 2, '營養平衡飽足了，\n身體自然美力滋潤！', 'updata/Proposition/2020-05/20200525172109.png', 1, '2020-05-16 13:00:36', '2020-06-29 09:20:48');

-- ----------------------------
-- Table structure for push_broadcast
-- ----------------------------
DROP TABLE IF EXISTS `push_broadcast`;
CREATE TABLE `push_broadcast`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '标题',
  `schedule_time` datetime(0) NULL DEFAULT NULL COMMENT '发布时间',
  `schedule_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '极光定时任务id',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for relationship
-- ----------------------------
DROP TABLE IF EXISTS `relationship`;
CREATE TABLE `relationship`  (
  `user_id` int(11) NOT NULL COMMENT '我账号',
  `chat_user` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '对方账号',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  PRIMARY KEY (`user_id`, `chat_user`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for roulette
-- ----------------------------
DROP TABLE IF EXISTS `roulette`;
CREATE TABLE `roulette`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NULL DEFAULT NULL COMMENT '1中奖2未中奖',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '赠物名',
  `odds` int(11) NULL DEFAULT NULL COMMENT '几率',
  `stock` int(11) NULL DEFAULT NULL COMMENT '库存',
  `state` int(11) NULL DEFAULT NULL COMMENT '状态',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roulette
-- ----------------------------
INSERT INTO `roulette` VALUES (1, 1, 'qw', 2, 110, 1, '2020-03-12 11:33:38', NULL);
INSERT INTO `roulette` VALUES (2, 1, 'qw', 11, 42, 1, '2020-03-12 11:33:55', NULL);
INSERT INTO `roulette` VALUES (3, 1, 'qa', 11, 16, 1, '2020-03-12 11:34:06', NULL);
INSERT INTO `roulette` VALUES (4, 1, 'qv', 11, 0, 1, '2020-03-12 11:34:15', '2020-05-29 14:51:46');
INSERT INTO `roulette` VALUES (5, 1, 'qy', 11, 6, 1, '2020-03-12 11:34:26', NULL);
INSERT INTO `roulette` VALUES (6, 1, 'q1', 11, 0, 1, '2020-03-12 11:34:34', NULL);
INSERT INTO `roulette` VALUES (7, 1, 'q2', 11, 8, 1, '2020-03-12 11:34:45', '2020-06-04 10:31:56');
INSERT INTO `roulette` VALUES (8, 2, 'q3233', 10, 2, 1, '2020-03-12 11:34:51', '2020-06-16 11:42:47');
INSERT INTO `roulette` VALUES (9, NULL, 'q4', 11, 1, 0, '2020-03-12 11:35:39', NULL);
INSERT INTO `roulette` VALUES (10, NULL, 'cs', 1, 11, 0, '2020-06-16 11:43:02', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 307 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of verify
-- ----------------------------
INSERT INTO `verify` VALUES (230, 9112, '0907453922', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTA3NDUzOTIyIiwiaXNzdWVkQXQiOiIyMDIwLTAxLTA4VDEwOjE5OjA5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.wP5i0bldyHcSIxen0VKuylSdrFpJX3NC5lqrrXiGm8o', '2020-01-08 10:29:09');
INSERT INTO `verify` VALUES (231, 1802, '0987878785', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTg3ODc4Nzg1IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTA4VDE3OjE0OjU4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.qX60PKCnV2zBLT8wGSRj89heG6KZRKka9-PtOAlYVAA', '2020-01-08 17:24:58');
INSERT INTO `verify` VALUES (232, 4093, '0907453933', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTA3NDUzOTMzIiwiaXNzdWVkQXQiOiIyMDIwLTAxLTA5VDExOjM4OjMzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.NH3LmhE76Sgvj2MhUCCJQsm0aBKLqPbS2zDtECmNeH0', '2020-01-09 11:48:33');
INSERT INTO `verify` VALUES (233, 7243, '0987685401', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTg3Njg1NDAxIiwiaXNzdWVkQXQiOiIyMDIwLTAxLTA5VDExOjU3OjE5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.4q4uns3aSxi2uks8XT7efyoV3AOkOw1Y9pEPdAsXa_o', '2020-01-09 12:07:19');
INSERT INTO `verify` VALUES (234, 7260, '0907453944', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTA3NDUzOTQ0IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTEwVDE0OjIzOjU2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.92BkYh_YS02if2SMQKs3-pMlPjtMdy9sCriHXOvLZJM', '2020-01-10 14:33:56');
INSERT INTO `verify` VALUES (235, 5603, '0907453944', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTA3NDUzOTQ0IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTEwVDE0OjI4OjE1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.rBXP43DwgevZYZ0v6Fl5td1nAVCuf5cqxeRmnhqpZ7Y', '2020-01-10 14:38:15');
INSERT INTO `verify` VALUES (236, 6804, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTEwVDE2OjU1OjAzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.9iqeUcBSgN1CkrwTF6XrTIf30-0Jefs_bicdeUFHuQA', '2020-01-10 17:05:03');
INSERT INTO `verify` VALUES (237, 3976, '0999999999', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTk5OTk5OTk5IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTEwVDE3OjE2OjQwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.Zd01YvCeccOKVWmiU0ZmpPpR9BFXtauG0TTgcq6mDKM', '2020-01-10 17:26:40');
INSERT INTO `verify` VALUES (238, 2583, '0939794189', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTM5Nzk0MTg5IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMwVDE3OjM4OjEzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.NbuWYl6lalCY_sEYISc-c-td7xt8fUSjA69xmrnGZQI', '2020-01-30 17:48:13');
INSERT INTO `verify` VALUES (239, 6952, '0939794189', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTM5Nzk0MTg5IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMwVDE3OjU3OjQ2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.gNovUf0gjbvqMmL2UlGovFIEgJBXk7n80rzse0-ZCK8', '2020-01-30 18:07:46');
INSERT INTO `verify` VALUES (240, 1911, '0987303820', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTg3MzAzODIwIiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMwVDE4OjA1OjE0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.u4JAN_4UEumePGcbQI-iP4wLinwnrl3ZNs4v2L3RnVI', '2020-01-30 18:15:14');
INSERT INTO `verify` VALUES (241, 7436, '0978907890', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTc4OTA3ODkwIiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMwVDE4OjA2OjM4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.DUh5CDTP2kpOVWwoSftrZ4_Y_kKYeTTjiDCfBKJTRNk', '2020-01-30 18:16:38');
INSERT INTO `verify` VALUES (242, 5644, '0939794189', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTM5Nzk0MTg5IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMxVDE0OjU1OjE4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.EYBZUwv95YL4DVzVa5pyFomo3Z5aC7vlryjx8Gog0I0', '2020-01-31 15:05:18');
INSERT INTO `verify` VALUES (243, 7974, '0936363636', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTM2MzYzNjM2IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMxVDE2OjA1OjUxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.PCfCpNkIMYLDDo4pHPgdmJ773iorpB2a-NOBgCop8qg', '2020-01-31 16:15:51');
INSERT INTO `verify` VALUES (244, 1887, '0910857444', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3NDQ0IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMxVDE2OjA2OjE5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.RNwSr5EhW19exCowgNqOaQd0x4sjvj_BLPBTHZyN8RY', '2020-01-31 16:16:19');
INSERT INTO `verify` VALUES (245, 5306, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMxVDE2OjA5OjM4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.PIOfflC6w4hRT07VP-JT7Jw6ReYAhHroBDpH8brG1Qw', '2020-01-31 16:19:38');
INSERT INTO `verify` VALUES (246, 7313, '0936363636', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTM2MzYzNjM2IiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMxVDE3OjQxOjA3KzA4MDAiLCJ0dGwiOjQzMjAwMH0._UUQUuDu6ehjj7l58NgxOXJT-94J7m08ol1husi32og', '2020-01-31 17:51:07');
INSERT INTO `verify` VALUES (247, 7856, '0911222333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTExMjIyMzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAxLTMxVDE3OjQ1OjE1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.XVtZX2Awy6uxb_ARpuA-ZTiQ_Cs9ukxFPINsdYoMSHI', '2020-01-31 17:55:15');
INSERT INTO `verify` VALUES (248, 1300, '0954545454', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTU0NTQ1NDU0IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE0OjA2OjMxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.kAFrOJr1EdLbGe5UjEp_VnFbk3kUm_whdI9nc_6w_lg', '2020-02-05 14:16:31');
INSERT INTO `verify` VALUES (249, 5029, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE0OjIwOjM1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.dB2XM_oP-HZOmkWzFKIzYI19Y_Fh-vwk1gmI-I0no9o', '2020-02-05 14:30:35');
INSERT INTO `verify` VALUES (250, 1675, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE0OjIxOjU4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.eCXZsreqKEtFxQllonOyQBko5cPJn9TgfIjt2-scjAY', '2020-02-05 14:31:58');
INSERT INTO `verify` VALUES (251, 7147, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE0OjM1OjI2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.7lfMaeeIKWdIUS9VMD0qC_NRfpvQ2JqDZbF90Mxrays', '2020-02-05 14:45:26');
INSERT INTO `verify` VALUES (252, 9415, '0910857432', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3NDMyIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjA3OjAxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.0eBd4shcd477FJRsIoVef4VBcXGUMnrgPLsKUT3BeZI', '2020-02-05 15:17:01');
INSERT INTO `verify` VALUES (253, 4686, '0910857432', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3NDMyIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjA3OjAyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.MTyD4_0OgK4A9A7-e2zaQ-ppghKCODB8lPZ6r4_YTJ4', '2020-02-05 15:17:02');
INSERT INTO `verify` VALUES (254, 3331, '0910857666', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3NjY2IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjE0OjIxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.MS5EhuD6zZs5q2ttQM-UR7vp2JlGS6TM83Tqj-r2kI4', '2020-02-05 15:24:21');
INSERT INTO `verify` VALUES (255, 3234, '0910857666', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3NjY2IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjE1OjQyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.G0CDDyskhvmP2evRvgBc9aKTYVJBY2clu9wvxfL1Oc4', '2020-02-05 15:25:42');
INSERT INTO `verify` VALUES (256, 4534, '0910857666', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3NjY2IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjE4OjU3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.iSjlKt9bdjdMJEcDvcHt0DB_H9tci8pOdkfQDVXgwKo', '2020-02-05 15:28:57');
INSERT INTO `verify` VALUES (257, 1701, '0910867555', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODY3NTU1IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjE5OjE0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.NJXD7Skpyi8Yj1YsqC5ftEBYZje1bpk5ecgX3V2NHl4', '2020-02-05 15:29:14');
INSERT INTO `verify` VALUES (258, 1912, '0923456788', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg4IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjI0OjIyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.uby7KXBPt5EOxIiKu6CeEV09POWi7BR4oL5a9APHDkg', '2020-02-05 15:34:22');
INSERT INTO `verify` VALUES (259, 3495, '0912356789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEyMzU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjI0OjU2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.5LnMHDaVmKCaiM29hhxqiPEhWeA2ZyTpMsUuvvTT2bY', '2020-02-05 15:34:56');
INSERT INTO `verify` VALUES (260, 5304, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjM1OjQyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.7IuiZnRZc8m_SfUMEzPWFXwmeURBygIIDgwfvgdQkQg', '2020-02-05 15:45:42');
INSERT INTO `verify` VALUES (261, 7337, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjQwOjA2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.uJDhdngSKFADDGRer24MQDEESfspRcQb8sEgxH2GWow', '2020-02-05 15:50:06');
INSERT INTO `verify` VALUES (262, 4792, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjQwOjA4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.MJu_lPn8g5COqEuI1WjeitqabdgJLCZK5KwxJdaAUgs', '2020-02-05 15:50:08');
INSERT INTO `verify` VALUES (263, 1037, '0945784578', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTQ1Nzg0NTc4IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE1OjUyOjExKzA4MDAiLCJ0dGwiOjQzMjAwMH0.AQvvnN0aFRqN-zq4M_BNYATvGwb7mSQgVQI3KhbDH7Y', '2020-02-05 16:02:11');
INSERT INTO `verify` VALUES (264, 3501, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE2OjU3OjMwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.W1lrIiibi1lXeY7AGyihBp9HXvr3W3sIl7G4ffEQ1C0', '2020-02-05 17:07:30');
INSERT INTO `verify` VALUES (265, 5824, '0939794189', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTM5Nzk0MTg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE4OjUwOjUxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.0TOZFkt1-zmyp6YZyq1doFq3jGmEhFfNMVKLIve4Ybg', '2020-02-05 19:00:51');
INSERT INTO `verify` VALUES (266, 2969, '0911222333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTExMjIyMzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE4OjUyOjA5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.HHpVVI5J_AY0KDna7pnjaKy5KsKI3A0Qi6382yC3IPE', '2020-02-05 19:02:09');
INSERT INTO `verify` VALUES (267, 2331, '0999999999', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTk5OTk5OTk5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA1VDE5OjE5OjAzKzA4MDAiLCJ0dGwiOjQzMjAwMH0._bk8l89WqiOuumFWQ-d2fgtH3ywJYq_7Qd4IdTX0N40', '2020-02-05 19:29:03');
INSERT INTO `verify` VALUES (268, 2869, '0999999991', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTk5OTk5OTkxIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA2VDEzOjU4OjQ5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.NGSpY4EzC1zKmWvSpDJGFHMrYpJCKFRuLaqkmelxWPM', '2020-02-06 14:08:49');
INSERT INTO `verify` VALUES (269, 1810, '0999999991', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTk5OTk5OTkxIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA2VDEzOjU4OjU3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.2mng7RSy0oSD21iHmZ2IlZ2c-pQ4GcfLG8L42wg_r0g', '2020-02-06 14:08:57');
INSERT INTO `verify` VALUES (270, 1496, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA2VDE0OjE0OjE4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.7J-GAaIpqVzJnl31dSq7kqqcARqmf0ieb5WG4bb4zwI', '2020-02-06 14:24:18');
INSERT INTO `verify` VALUES (271, 2805, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA2VDE0OjQzOjIxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.ZABaj0QKwsSLDsr8KtadM6coFO10mEoDy7S6636ElT0', '2020-02-06 14:53:21');
INSERT INTO `verify` VALUES (272, 4686, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjE1OjE4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.0cOoCYUqBHlRSYy_LeDpzC4ojopWSqpHfySrlPjCsC0', '2020-02-07 11:25:18');
INSERT INTO `verify` VALUES (273, 9266, '0956565451', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTU2NTY1NDUxIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjE1OjUzKzA4MDAiLCJ0dGwiOjQzMjAwMH0.dy9YUjkGPfIooJpXEIMV51vTldLIL3jdahsyx17LtzU', '2020-02-07 11:25:53');
INSERT INTO `verify` VALUES (274, 4797, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjE3OjEyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.N7QoPp9KT5GVNh1sj5V8JALT0SaNAfwLpzgJOdClM4Q', '2020-02-07 11:27:12');
INSERT INTO `verify` VALUES (275, 7108, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjE4OjA4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.uu6M9uZGEszbgzGPHH8u-T9rtoyNWRZbkq7Wfj25Kio', '2020-02-07 11:28:08');
INSERT INTO `verify` VALUES (276, 2572, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjE4OjM1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.SxM3LjhQc9p4CyBnvYjvciBpxQRIGYOg23ezW-CSn64', '2020-02-07 11:28:35');
INSERT INTO `verify` VALUES (277, 7318, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjE5OjA3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.peGGH-58sMk9i6JBBv9Rg1NTPU7XguTCnyKXUG5LeJk', '2020-02-07 11:29:07');
INSERT INTO `verify` VALUES (278, 9101, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjE5OjMwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.3Qc_WpqH7scz1iSdX4Chcta5tnalTTo6rzBnqNkhg_Q', '2020-02-07 11:29:30');
INSERT INTO `verify` VALUES (279, 3275, '0978945612', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTc4OTQ1NjEyIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjMwOjI5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.plW7FKR07p62RU8cWe0c0vT68eKe8WzgwPrZKv1c9EY', '2020-02-07 11:40:29');
INSERT INTO `verify` VALUES (280, 5333, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjM3OjMxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.Le6q1NwS0qdEgG3vMvLAMO9EcxjgSUIjU4gd6zFOaXc', '2020-02-07 11:47:31');
INSERT INTO `verify` VALUES (281, 5907, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDExOjQ1OjQ1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.C64thX3blbN4SEQHJXubBbgpqQ2VmHRQu31_xYIYKx8', '2020-02-07 11:55:45');
INSERT INTO `verify` VALUES (282, 7535, '0910857999', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3OTk5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDEzOjMzOjQ1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.I99zf3KyIMpsHlxL7T4k9byffhk0-GGqbHg5QlykpJ8', '2020-02-07 13:43:45');
INSERT INTO `verify` VALUES (283, 8391, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDE1OjMzOjAxKzA4MDAiLCJ0dGwiOjQzMjAwMH0.uDOVOvMBZwq-6iyQMhetyCXL15HAe7LG4dhVLxvaf5o', '2020-02-07 15:43:01');
INSERT INTO `verify` VALUES (284, 8723, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTA3VDE1OjM0OjQ4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.YfufN9T2sn9ljqLdRQ4PPiALPQFyklyTKC2ZH8_0cf0', '2020-02-07 15:44:48');
INSERT INTO `verify` VALUES (285, 6376, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDExOjE2OjQ2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.B6jBATYl0MAq1JAndywQqBAi3_1BoJnGtS4v4zrRRAc', '2020-02-10 11:26:46');
INSERT INTO `verify` VALUES (286, 2291, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDEzOjU4OjA2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.YkjwO_atizyS7fIPpd3KGvc6il59vUVTylOXolxFvSQ', '2020-02-10 14:08:06');
INSERT INTO `verify` VALUES (287, 2793, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDE0OjAwOjAyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.4XINVF9IuDdeOqx-3naT4lpDcYCBQgirhVYaEXBBNEM', '2020-02-10 14:10:02');
INSERT INTO `verify` VALUES (288, 6860, '0910857999', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3OTk5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDE0OjA5OjQ4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.ac5CTqZeIPcezDI1u7GjSWiYTxr6PVBE5LnLUbkNv4k', '2020-02-10 14:19:48');
INSERT INTO `verify` VALUES (289, 7999, '0910857999', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3OTk5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDE0OjEyOjI4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.lx24bd-w5DSd2-Ig83oUnJpCGVs1ucKjlkWvX7nv6Dg', '2020-02-10 14:22:28');
INSERT INTO `verify` VALUES (290, 4745, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIxOjM4OjMyKzA4MDAiLCJ0dGwiOjQzMjAwMH0.aUYHOl2EOqQZ67bsoIG9MUynA8mcW_uvYw6gbQolBNo', '2020-02-10 21:48:32');
INSERT INTO `verify` VALUES (291, 6610, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIxOjM4OjM4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.UA1K5jb8soDUEmY9uOj2uVbL1evRJQWcRyEPRtUaS0w', '2020-02-10 21:48:38');
INSERT INTO `verify` VALUES (292, 1795, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIxOjQwOjI2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.z6IfFoHHXr2DwiaG4NbKH574YvTAd-XwnbLz7BQ7Vs8', '2020-02-10 21:50:26');
INSERT INTO `verify` VALUES (293, 5035, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIxOjQwOjI2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.z6IfFoHHXr2DwiaG4NbKH574YvTAd-XwnbLz7BQ7Vs8', '2020-02-10 21:50:26');
INSERT INTO `verify` VALUES (294, 9447, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIxOjQwOjI2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.z6IfFoHHXr2DwiaG4NbKH574YvTAd-XwnbLz7BQ7Vs8', '2020-02-10 21:50:26');
INSERT INTO `verify` VALUES (295, 1544, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIxOjQwOjI2KzA4MDAiLCJ0dGwiOjQzMjAwMH0.z6IfFoHHXr2DwiaG4NbKH574YvTAd-XwnbLz7BQ7Vs8', '2020-02-10 21:50:26');
INSERT INTO `verify` VALUES (296, 9477, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIxOjQwOjI3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.3fQ4lzfMhCjMXsp8DoIIScvnxdZLWMAaX2uSt0UMBRo', '2020-02-10 21:50:27');
INSERT INTO `verify` VALUES (297, 3652, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIxOjQyOjA4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.MHuwlymDPqddRBZ6itDwxiUwoUfRhwh0ycLj9f1xXqs', '2020-02-10 21:52:08');
INSERT INTO `verify` VALUES (298, 9865, '0910857333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3MzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIxOjQzOjA0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.FJmz3Uiuss7vOWfwZUeY8Aby_d0lR_NUYpUTQHtst20', '2020-02-10 21:53:04');
INSERT INTO `verify` VALUES (299, 1094, '0910857693', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODU3NjkzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIyOjA3OjQ4KzA4MDAiLCJ0dGwiOjQzMjAwMH0.iaSCg4EykX63LgEw5Akm2osf3l8gNHWg-5qh7lKeh1c', '2020-02-10 22:17:48');
INSERT INTO `verify` VALUES (300, 2852, '0910875436', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTEwODc1NDM2IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTEwVDIyOjA5OjA1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.INCOyt9wE9G5LAbFLPW1AskHpCECeq0E-EAlgnnI0EY', '2020-02-10 22:19:05');
INSERT INTO `verify` VALUES (301, 2452, '0911222333', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTExMjIyMzMzIiwiaXNzdWVkQXQiOiIyMDIwLTAyLTExVDA5OjI1OjQ5KzA4MDAiLCJ0dGwiOjQzMjAwMH0.0af1AZX94bg-roFgdpX8D636Ol9C_bl5kI_UTA4UXNs', '2020-02-11 09:35:49');
INSERT INTO `verify` VALUES (302, 9551, '0939794189', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTM5Nzk0MTg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTExVDA5OjI2OjA0KzA4MDAiLCJ0dGwiOjQzMjAwMH0.nKjwXlqBgXjLnTpmFGGVKCeF6A6vyO3BqAaLSCOMv88', '2020-02-11 09:36:04');
INSERT INTO `verify` VALUES (303, 3742, '0999999999', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTk5OTk5OTk5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTExVDA5OjI4OjAwKzA4MDAiLCJ0dGwiOjQzMjAwMH0.FVmiuF3D7eGisnImNic6AdLhssL9KET94jDzCbtL_64', '2020-02-11 09:38:00');
INSERT INTO `verify` VALUES (304, 8609, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTExVDEwOjM4OjI2KzA4MDAiLCJ0dGwiOjQzMjAwMH0._7Bv8s_HlFUqe3Ny9CIFnuLal_t404caUO60WNJTbuE', '2020-02-11 10:48:26');
INSERT INTO `verify` VALUES (305, 7988, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTExVDEwOjM5OjI1KzA4MDAiLCJ0dGwiOjQzMjAwMH0.USgtTyTkGuz93mQqk33qen5qtzAj4f-F6jLd7mkj2bM', '2020-02-11 10:49:25');
INSERT INTO `verify` VALUES (306, 5441, '0923456789', 'eyJ0eXAiOiJqd3QiLCJhbGciOiJIUzI1NiJ9.eyJjb25zdW1lcktleSI6Imh1aWR1b2R1b2tleTIwMTkiLCJ1c2VySWQiOiIwOTIzNDU2Nzg5IiwiaXNzdWVkQXQiOiIyMDIwLTAyLTExVDEwOjQwOjI3KzA4MDAiLCJ0dGwiOjQzMjAwMH0.85QfGjjA9ePL0-dMRTJ-JlgniuUhmWJ4kxxSnvj-i38', '2020-02-11 10:50:27');

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
INSERT INTO `version` VALUES (1, '1', '2020-06-15 15:23:25');

-- ----------------------------
-- Table structure for vote
-- ----------------------------
DROP TABLE IF EXISTS `vote`;
CREATE TABLE `vote`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '账号',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 75 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of vote
-- ----------------------------
INSERT INTO `vote` VALUES (1, 'aa', '123123', '2020-03-04 11:53:53', NULL);
INSERT INTO `vote` VALUES (2, '112312', '123123', '2020-05-29 14:32:56', NULL);
INSERT INTO `vote` VALUES (3, '112312', '12312311', '2020-05-29 20:41:14', NULL);
INSERT INTO `vote` VALUES (4, '112312', '123123111', '2020-05-29 20:41:47', NULL);
INSERT INTO `vote` VALUES (5, '123123123', NULL, '2020-06-02 14:19:33', NULL);
INSERT INTO `vote` VALUES (6, '', NULL, '2020-06-02 14:38:20', NULL);
INSERT INTO `vote` VALUES (7, '1231312', NULL, '2020-06-02 14:40:25', NULL);
INSERT INTO `vote` VALUES (8, '32132321', NULL, '2020-06-02 15:33:34', NULL);
INSERT INTO `vote` VALUES (9, '321321', NULL, '2020-06-02 15:38:35', NULL);
INSERT INTO `vote` VALUES (10, '432', NULL, '2020-06-02 15:40:21', NULL);
INSERT INTO `vote` VALUES (11, '4444', NULL, '2020-06-02 15:51:43', NULL);
INSERT INTO `vote` VALUES (12, '321111', NULL, '2020-06-02 18:00:03', NULL);
INSERT INTO `vote` VALUES (13, '333333', NULL, '2020-06-02 18:00:48', NULL);
INSERT INTO `vote` VALUES (14, '1131', NULL, '2020-06-02 18:01:45', NULL);
INSERT INTO `vote` VALUES (15, '1111111111111', NULL, '2020-06-02 18:02:27', NULL);
INSERT INTO `vote` VALUES (16, 'qqqqq', NULL, '2020-06-02 18:03:07', NULL);
INSERT INTO `vote` VALUES (17, '9999999999', NULL, '2020-06-02 18:04:34', NULL);
INSERT INTO `vote` VALUES (18, '33331', NULL, '2020-06-02 18:05:05', NULL);
INSERT INTO `vote` VALUES (19, 'qaz', NULL, '2020-06-02 18:07:25', NULL);
INSERT INTO `vote` VALUES (20, '331d', NULL, '2020-06-02 18:08:36', NULL);
INSERT INTO `vote` VALUES (21, '4ddfr', NULL, '2020-06-02 18:09:16', NULL);
INSERT INTO `vote` VALUES (22, '1222222222', NULL, '2020-06-02 18:09:57', NULL);
INSERT INTO `vote` VALUES (23, '00000', NULL, '2020-06-02 18:10:35', NULL);
INSERT INTO `vote` VALUES (24, '456789trd', NULL, '2020-06-02 18:10:55', NULL);
INSERT INTO `vote` VALUES (25, '3aaaaaa', NULL, '2020-06-02 18:14:20', NULL);
INSERT INTO `vote` VALUES (26, '5789098765', NULL, '2020-06-02 18:25:32', NULL);
INSERT INTO `vote` VALUES (27, '12313123', NULL, '2020-06-02 18:36:52', NULL);
INSERT INTO `vote` VALUES (28, '7686876', NULL, '2020-06-02 18:41:58', NULL);
INSERT INTO `vote` VALUES (29, '1wswwads', NULL, '2020-06-02 18:42:23', NULL);
INSERT INTO `vote` VALUES (30, '111111111111111111', NULL, '2020-06-02 18:43:06', NULL);
INSERT INTO `vote` VALUES (31, 'bnm,', NULL, '2020-06-02 18:44:53', NULL);
INSERT INTO `vote` VALUES (32, 'hnhj', NULL, '2020-06-02 18:46:05', NULL);
INSERT INTO `vote` VALUES (33, '33313ew', NULL, '2020-06-02 18:46:28', NULL);
INSERT INTO `vote` VALUES (34, '3qwds', NULL, '2020-06-02 18:46:40', NULL);
INSERT INTO `vote` VALUES (35, 'efdcscsa', NULL, '2020-06-02 18:47:33', NULL);
INSERT INTO `vote` VALUES (36, '32edscx', NULL, '2020-06-02 18:50:31', NULL);
INSERT INTO `vote` VALUES (37, 'gtr', NULL, '2020-06-02 18:51:40', NULL);
INSERT INTO `vote` VALUES (38, 'dcx zXz', NULL, '2020-06-02 18:53:16', NULL);
INSERT INTO `vote` VALUES (39, 'wsza', NULL, '2020-06-02 18:53:48', NULL);
INSERT INTO `vote` VALUES (40, 'VBM,MY', NULL, '2020-06-02 18:55:39', NULL);
INSERT INTO `vote` VALUES (41, 'WSADA', NULL, '2020-06-02 18:56:31', NULL);
INSERT INTO `vote` VALUES (42, '321321dd', NULL, '2020-06-02 18:58:25', NULL);
INSERT INTO `vote` VALUES (43, '321321eqeee', NULL, '2020-06-02 18:59:58', NULL);
INSERT INTO `vote` VALUES (44, 'ewqewqfc', NULL, '2020-06-02 19:00:26', NULL);
INSERT INTO `vote` VALUES (45, 'oo@gmail.com', NULL, '2020-06-04 10:30:10', NULL);
INSERT INTO `vote` VALUES (46, 'ww@gmail.com', NULL, '2020-06-04 10:32:10', NULL);
INSERT INTO `vote` VALUES (47, '0918281828', NULL, '2020-06-04 10:34:00', NULL);
INSERT INTO `vote` VALUES (48, '0999890989', NULL, '2020-06-04 10:36:01', NULL);
INSERT INTO `vote` VALUES (49, '0934333333', NULL, '2020-06-04 10:37:06', NULL);
INSERT INTO `vote` VALUES (50, '321321', NULL, '2020-06-04 10:49:46', NULL);
INSERT INTO `vote` VALUES (51, 'fsdfds', NULL, '2020-06-04 10:52:24', NULL);
INSERT INTO `vote` VALUES (52, 'qaqsasa', NULL, '2020-06-04 10:55:24', NULL);
INSERT INTO `vote` VALUES (53, 'vdcxzvcx', NULL, '2020-06-04 10:57:15', NULL);
INSERT INTO `vote` VALUES (54, '33333333333', NULL, '2020-06-04 10:58:33', NULL);
INSERT INTO `vote` VALUES (55, '而我却', NULL, '2020-06-04 11:01:15', NULL);
INSERT INTO `vote` VALUES (56, 'edzcxz', NULL, '2020-06-04 11:01:58', NULL);
INSERT INTO `vote` VALUES (57, '33333333333333333333333333333', NULL, '2020-06-04 11:02:53', NULL);
INSERT INTO `vote` VALUES (58, '3dad', NULL, '2020-06-04 11:06:10', NULL);
INSERT INTO `vote` VALUES (59, '333333333333q', NULL, '2020-06-04 11:06:56', NULL);
INSERT INTO `vote` VALUES (60, '123123123', NULL, '2020-06-04 14:28:03', NULL);
INSERT INTO `vote` VALUES (61, '1231231232', NULL, '2020-06-04 14:28:22', NULL);
INSERT INTO `vote` VALUES (62, '0912121212', NULL, '2020-06-05 10:57:24', NULL);
INSERT INTO `vote` VALUES (63, '0900000000', NULL, '2020-06-05 10:58:55', NULL);
INSERT INTO `vote` VALUES (64, '321321323', NULL, '2020-06-05 11:18:03', NULL);
INSERT INTO `vote` VALUES (65, 'vvvvvvv', NULL, '2020-06-05 11:21:56', NULL);
INSERT INTO `vote` VALUES (66, '1111111111111111', NULL, '2020-06-05 11:22:09', NULL);
INSERT INTO `vote` VALUES (67, 'fgbghg', NULL, '2020-06-05 11:23:36', NULL);
INSERT INTO `vote` VALUES (68, 'eeed', NULL, '2020-06-05 11:23:49', NULL);
INSERT INTO `vote` VALUES (69, '09878788788', NULL, '2020-06-05 11:49:13', NULL);
INSERT INTO `vote` VALUES (70, '0988989989', NULL, '2020-06-05 11:49:45', NULL);
INSERT INTO `vote` VALUES (71, '0912123312', NULL, '2020-06-05 11:54:36', NULL);
INSERT INTO `vote` VALUES (72, 'awq@gmail.com', NULL, '2020-06-05 12:25:05', NULL);
INSERT INTO `vote` VALUES (73, '0912123456', NULL, '2020-06-05 18:04:59', NULL);
INSERT INTO `vote` VALUES (74, 'juiling0503@gmail.com', NULL, '2020-06-15 12:34:36', NULL);

-- ----------------------------
-- Table structure for winning
-- ----------------------------
DROP TABLE IF EXISTS `winning`;
CREATE TABLE `winning`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '姓名',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系电话',
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '地址',
  `awards` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '奖项',
  `created_at` datetime(0) NULL DEFAULT NULL COMMENT '建立時間',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '更新時間',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of winning
-- ----------------------------
INSERT INTO `winning` VALUES (1, '8755666', '7777', '666', NULL, '2020-03-04 11:39:41', NULL);
INSERT INTO `winning` VALUES (2, '', '请问', '请问', '7', '2020-05-29 20:44:38', NULL);
INSERT INTO `winning` VALUES (3, '', '请问', '请问', '7', '2020-05-29 20:45:34', NULL);
INSERT INTO `winning` VALUES (4, '', '请问', '请问', '2', '2020-05-29 20:53:13', NULL);
INSERT INTO `winning` VALUES (5, '', '321', '321', '1', '2020-06-02 16:12:56', NULL);
INSERT INTO `winning` VALUES (6, '', '321321', 'ffff', '4', '2020-06-02 18:58:39', NULL);
INSERT INTO `winning` VALUES (7, '', 'ewq', 'qewq', '4', '2020-06-02 19:00:37', NULL);
INSERT INTO `winning` VALUES (8, '', '09090909090', 'jk;jl', '6', '2020-06-04 10:33:32', NULL);
INSERT INTO `winning` VALUES (9, '', '09090909090', 'jk;jl', '2', '2020-06-04 10:34:13', NULL);
INSERT INTO `winning` VALUES (10, '', '09090909090', 'jk;jl', '3', '2020-06-04 10:37:15', NULL);
INSERT INTO `winning` VALUES (11, '', '', '', '3', '2020-06-04 10:55:31', NULL);
INSERT INTO `winning` VALUES (12, '', '0900000123', 'as', '3', '2020-06-05 10:58:25', NULL);
INSERT INTO `winning` VALUES (13, '', '0900000123', 'as', '5', '2020-06-05 10:59:34', NULL);
INSERT INTO `winning` VALUES (14, '', 'ewqewq', 'ewqew', '3', '2020-06-05 11:22:05', NULL);
INSERT INTO `winning` VALUES (15, '', '333', '2223', '5', '2020-06-05 11:23:45', NULL);
INSERT INTO `winning` VALUES (16, '', 'Vbnm', 'Ghj', '3', '2020-06-05 11:55:01', NULL);
INSERT INTO `winning` VALUES (17, '', '0912312321', 'asas', '5', '2020-06-05 12:25:25', NULL);
INSERT INTO `winning` VALUES (18, '', '2', '3', '5', '2020-06-05 14:59:40', NULL);
INSERT INTO `winning` VALUES (19, '1', '2', '3', '5', '2020-06-05 15:00:32', NULL);

SET FOREIGN_KEY_CHECKS = 1;
