-- --------------------------------------------------------
-- 主机:                           localhost
-- 服务器版本:                        5.7.19 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 newoa 的数据库结构
CREATE DATABASE IF NOT EXISTS `newoa` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `newoa`;

-- 导出  表 newoa.apartment 结构
CREATE TABLE IF NOT EXISTS `apartment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL,
  `pid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `resident_number` int(11) DEFAULT NULL COMMENT '可入住人数',
  `status` int(11) NOT NULL DEFAULT '1',
  `sex` varchar(50) CHARACTER SET latin1 DEFAULT '1' COMMENT '1为男生宿舍 2为女生宿舍',
  `checked_number` tinyint(4) DEFAULT '0' COMMENT '已入住人数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='公寓';

-- 正在导出表  newoa.apartment 的数据：~19 rows (大约)
/*!40000 ALTER TABLE `apartment` DISABLE KEYS */;
INSERT INTO `apartment` (`id`, `name`, `pid`, `level`, `resident_number`, `status`, `sex`, `checked_number`) VALUES
	(1, 'SEA', 0, 1, NULL, 1, 'null', 0),
	(2, 'SHELL', 0, 1, NULL, 1, 'null', 0),
	(3, 'Skyland', 0, 1, NULL, 1, 'null', 0),
	(4, 'A107', 1, 2, 1000, 1, '1', 35),
	(5, 'A108', 1, 2, 2, 1, '1', 0),
	(6, 'C', 1, 2, 2, 1, '2', 0),
	(7, 'D', 2, 2, 2, 1, '1', 0),
	(8, 'E', 2, 2, 2, 1, '2', 1),
	(9, 'G', 3, 2, 3, 1, '1', 0),
	(10, 'F', 2, 2, 6, 1, '1', 1),
	(11, 'zzl', 0, 1, NULL, 0, 'null', 0),
	(12, 'columns', 0, 1, NULL, 1, 'null', 0),
	(13, 'cosmopolitan', 0, 1, NULL, 1, 'null', 0),
	(14, 'H', 12, 2, 3, 1, '1', 0),
	(15, 'I', 13, 2, 2, 1, '1', 0),
	(16, 'peak tower', 0, 1, NULL, 1, 'null', 0),
	(17, 'shore', 0, 1, NULL, 1, 'null', 0),
	(18, 'J', 16, 2, 2, 1, '1', 0),
	(19, 'K', 17, 2, 3, 1, '1', 0);
/*!40000 ALTER TABLE `apartment` ENABLE KEYS */;

-- 导出  表 newoa.department 结构
CREATE TABLE IF NOT EXISTS `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `pid` mediumint(9) NOT NULL,
  `order` tinyint(4) DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `remarks` varchar(50) DEFAULT NULL COMMENT '备注顶级部门 配合薪资表用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='部门';

-- 正在导出表  newoa.department 的数据：~42 rows (大约)
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` (`id`, `name`, `level`, `pid`, `order`, `created_at`, `updated_at`, `remarks`) VALUES
	(2, '行政部', 1, 0, 0, '2018-09-01 14:01:53', '2018-09-03 22:41:28', '行政部'),
	(3, '推广部', 1, 0, 1, '2018-09-01 14:01:59', '2018-09-03 22:41:21', '推广部'),
	(4, 'V1', 2, 3, 0, '2018-09-01 14:02:11', '2018-09-01 14:02:11', NULL),
	(9, 'v2', 2, 3, 0, '2018-09-02 06:57:36', '2018-09-03 17:37:41', NULL),
	(11, 'v3', 2, 3, 0, '2018-09-02 06:57:56', '2018-09-02 06:57:56', NULL),
	(12, '网络部', 1, 0, 0, '2018-09-02 07:00:19', '2018-09-02 07:00:19', '网络部'),
	(13, '运维', 2, 12, 0, '2018-09-02 07:00:34', '2018-09-02 07:00:34', NULL),
	(16, '行政', 2, 2, 0, '2018-09-02 15:24:31', '2018-09-22 19:35:39', NULL),
	(21, '客服部', 1, 0, 0, '2018-09-03 17:45:46', '2018-09-03 22:41:34', '客服部'),
	(22, '客服组', 2, 21, 0, '2018-09-03 17:45:57', '2018-09-22 15:28:40', NULL),
	(23, 'v5', 2, 3, 0, '2018-09-04 22:40:53', '2018-09-04 22:40:53', NULL),
	(24, 'v6', 2, 3, 0, '2018-09-04 22:41:00', '2018-09-04 22:41:00', NULL),
	(25, 'v7', 2, 3, 0, '2018-09-04 22:41:12', '2018-09-04 22:41:12', NULL),
	(26, 'v8', 2, 3, 0, '2018-09-04 22:41:19', '2018-09-04 22:41:19', NULL),
	(27, 'v9', 2, 3, 0, '2018-09-04 22:41:37', '2018-09-04 22:41:37', NULL),
	(28, '德甲', 3, 4, 0, '2018-09-11 16:10:27', '2018-09-22 15:12:38', NULL),
	(29, '法甲', 3, 4, 0, '2018-09-11 16:32:16', '2018-09-22 15:12:56', NULL),
	(30, '雷霆', 3, 9, 0, '2018-09-11 16:38:26', '2018-09-22 15:16:53', NULL),
	(31, '皇马', 3, 11, 0, '2018-09-11 16:38:52', '2018-09-22 15:19:43', NULL),
	(32, '雄鹰', 3, 23, 0, '2018-09-11 16:39:02', '2018-09-22 15:21:40', NULL),
	(33, '闪电', 3, 24, 0, '2018-09-11 16:39:10', '2018-09-22 15:23:12', NULL),
	(34, '海军', 3, 25, 0, '2018-09-11 16:39:18', '2018-09-22 15:23:31', NULL),
	(35, '超人', 3, 26, 0, '2018-09-11 16:39:29', '2018-09-22 15:24:44', NULL),
	(36, '巨人', 3, 27, 0, '2018-09-11 16:39:38', '2018-09-22 15:25:23', NULL),
	(37, '火箭', 3, 9, 0, '2018-09-11 22:54:51', '2018-09-22 15:17:09', NULL),
	(38, '海豹', 3, 23, 0, '2018-09-11 23:08:03', '2018-09-22 15:22:02', NULL),
	(39, 'v10', 2, 3, 0, '2018-09-20 14:07:40', '2018-09-20 14:07:40', NULL),
	(40, '鲨鱼', 3, 39, 0, '2018-09-20 14:08:18', '2018-09-22 15:25:39', NULL),
	(41, '西甲', 3, 4, 0, '2018-09-22 15:15:23', '2018-09-22 15:15:23', NULL),
	(42, '勇士', 3, 9, 0, '2018-09-22 15:17:50', '2018-09-22 15:17:50', NULL),
	(43, '霹雳', 3, 9, 0, '2018-09-22 15:19:08', '2018-09-22 15:19:08', NULL),
	(44, '热刺', 3, 11, 0, '2018-09-22 15:20:12', '2018-09-22 15:20:12', NULL),
	(45, '巴萨', 3, 11, 0, '2018-09-22 15:20:35', '2018-09-22 15:20:35', NULL),
	(46, '曼联', 3, 11, 0, '2018-09-22 15:21:06', '2018-09-22 15:21:06', NULL),
	(47, '战狼', 3, 23, 0, '2018-09-22 15:22:41', '2018-09-22 15:22:41', NULL),
	(48, '空军', 3, 25, 0, '2018-09-22 15:24:03', '2018-09-22 15:24:03', NULL),
	(49, '人事部', 1, 0, 0, '2018-09-22 15:29:32', '2018-09-22 15:29:32', '人事部'),
	(50, '人事', 2, 49, 0, '2018-09-22 15:29:41', '2018-09-22 15:29:41', NULL),
	(51, '后厨部', 1, 0, 0, '2018-09-22 15:30:20', '2018-09-22 15:30:20', '后厨部'),
	(52, '厨师', 2, 51, 0, '2018-09-22 15:30:29', '2018-09-22 15:30:29', NULL),
	(53, '安保部', 1, 0, 0, '2018-09-22 15:31:24', '2018-09-22 15:31:24', '安保部'),
	(54, '安保', 2, 53, 0, '2018-09-22 15:31:42', '2018-09-22 15:31:42', NULL);
/*!40000 ALTER TABLE `department` ENABLE KEYS */;

-- 导出  表 newoa.department_flow 结构
CREATE TABLE IF NOT EXISTS `department_flow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total_amount` decimal(10,2) NOT NULL COMMENT '金额',
  `number` varchar(50) NOT NULL COMMENT '员工编号',
  `department_id` int(11) NOT NULL DEFAULT '0' COMMENT '部门ID',
  `fraction` int(11) NOT NULL DEFAULT '0' COMMENT '分数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='部门流水';

-- 正在导出表  newoa.department_flow 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `department_flow` DISABLE KEYS */;
INSERT INTO `department_flow` (`id`, `total_amount`, `number`, `department_id`, `fraction`) VALUES
	(16, 1700.00, 'F0002', 28, 34),
	(17, 1900.00, 'F0016', 28, 38),
	(18, 810.00, 'F0025', 28, 54),
	(19, 465.00, 'F0218', 28, 31),
	(20, 160.00, 'F0426', 28, 8);
/*!40000 ALTER TABLE `department_flow` ENABLE KEYS */;

-- 导出  表 newoa.dormitory 结构
CREATE TABLE IF NOT EXISTS `dormitory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) NOT NULL DEFAULT '0' COMMENT '员工编号ID',
  `g_id` tinyint(3) NOT NULL COMMENT '公寓ID',
  `f_id` tinyint(3) NOT NULL COMMENT '房间号ID',
  `status` int(11) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='入住情况';

-- 正在导出表  newoa.dormitory 的数据：~8 rows (大约)
/*!40000 ALTER TABLE `dormitory` DISABLE KEYS */;
INSERT INTO `dormitory` (`id`, `number`, `g_id`, `f_id`, `status`) VALUES
	(1, 'F1210', 1, 4, 1),
	(2, 'F1201', 1, 4, 1),
	(3, 'F1303', 1, 4, 1),
	(4, 'F1302', 1, 4, 1),
	(5, 'F0002', 1, 4, 1),
	(6, 'F0016', 1, 4, 1),
	(7, 'F0025', 1, 4, 1),
	(8, 'F0218', 1, 4, 1),
	(9, 'F0426', 1, 4, 1);
/*!40000 ALTER TABLE `dormitory` ENABLE KEYS */;

-- 导出  表 newoa.exchange_rate 结构
CREATE TABLE IF NOT EXISTS `exchange_rate` (
  `rate` varchar(50) NOT NULL DEFAULT '6.00',
  `id` tinyint(4) NOT NULL DEFAULT '6',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='汇率';

-- 正在导出表  newoa.exchange_rate 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `exchange_rate` DISABLE KEYS */;
INSERT INTO `exchange_rate` (`rate`, `id`) VALUES
	('7.58', 1);
/*!40000 ALTER TABLE `exchange_rate` ENABLE KEYS */;

-- 导出  表 newoa.flowing_water 结构
CREATE TABLE IF NOT EXISTS `flowing_water` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) NOT NULL COMMENT '操作员ID',
  `fraction` int(11) NOT NULL COMMENT '得分',
  `point` int(11) NOT NULL DEFAULT '0' COMMENT '有效数',
  `month` tinyint(4) DEFAULT NULL COMMENT '记录新人转正月数',
  `fractional_column` text COMMENT '得分列',
  `is_input` tinyint(4) NOT NULL DEFAULT '0',
  `fraction_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '得分金额',
  `point_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '有效数金额',
  `total_moeny` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总金额',
  `group_moeny` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '组长金额',
  `special_moeny` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '特殊金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='流水';

-- 正在导出表  newoa.flowing_water 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `flowing_water` DISABLE KEYS */;
INSERT INTO `flowing_water` (`id`, `number`, `fraction`, `point`, `month`, `fractional_column`, `is_input`, `fraction_money`, `point_money`, `total_moeny`, `group_moeny`, `special_moeny`) VALUES
	(16, 'F0002', 34, 14, NULL, '1\r,4\r,6\r,2\r,4\r,2\r,0\r,3\r,3\r,1\r,1\r,1\r,3\r,2\r,0\r,1\r,0,', 1, 0.00, 0.00, 0.00, 0.00, 0.00),
	(17, 'F0016', 38, 13, NULL, '6\r,1\r,2\r,5\r,6\r,2\r,2\r,1\r,2\r,2\r,1\r,3\r,5\r,0,', 1, 0.00, 0.00, 0.00, 0.00, 0.00),
	(18, 'F0025', 54, 23, NULL, '1\r,0\r,0\r,1\r,0\r,0\r,2\r,1\r,2\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,4\r,2\r,0\r,2\r,0\r,0\r,6\r,0\r,1\r,2\r,0\r,0\r,0\r,1\r,3\r,1\r,1\r,2\r,6\r,4\r,4\r,1\r,3\r,3\r,1\r,0,', 1, 1890.00, 2000.00, 3890.00, 0.00, 0.00),
	(19, 'F0218', 31, 15, NULL, '2\r,0\r,0\r,0\r,0\r,0\r,2\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,0\r,6\r,0\r,2\r,2\r,0\r,5\r,1\r,1\r,1\r,1\r,1\r,3\r,1\r,2\r,1\r,0,', 1, 1085.00, 1100.00, 2185.00, 0.00, 0.00),
	(20, 'F0426', 8, 4, 4, '2\r,2\r,0\r,0\r,0\r,2\r,2\r,0\r,0\r,0,', 1, 240.00, 0.00, 240.00, 0.00, 0.00);
/*!40000 ALTER TABLE `flowing_water` ENABLE KEYS */;

-- 导出  表 newoa.mynotes 结构
CREATE TABLE IF NOT EXISTS `mynotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) NOT NULL,
  `content` varchar(200) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1 COMMENT='便签';

-- 正在导出表  newoa.mynotes 的数据：~22 rows (大约)
/*!40000 ALTER TABLE `mynotes` DISABLE KEYS */;
INSERT INTO `mynotes` (`id`, `number`, `content`) VALUES
	(4, 'F0354', 'aaaaaaaaaa'),
	(5, 'F0354', 'BBBBBBBBBBBBBB'),
	(6, 'F0354', '啊啊啊啊'),
	(7, 'F0354', '苏三啊'),
	(8, 'F0354', '今天要做的事情'),
	(9, 'F0354', '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊1'),
	(10, 'F0354', '安迪'),
	(11, 'F0354', '是的'),
	(12, 'F0354', '省省省'),
	(13, 'F0354', '凄凄切切'),
	(14, 'F0354', 'lol'),
	(23, 'F0325', '今天工作清单'),
	(24, 'F0325', '嘤嘤嘤'),
	(27, 'F0325', '明天要准备的事情'),
	(28, 'F0010', '今天的任务清单'),
	(30, 'F0010', '小便签功能测试'),
	(32, 'F0016', 'oj8k'),
	(34, 'F0309', 'aaaaa'),
	(35, 'F0002', '交换机'),
	(36, 'F0002', '路由器'),
	(37, 'F0016', '晚上记得收被子奥'),
	(39, 'F0016', 'php是世界上最好的语言');
/*!40000 ALTER TABLE `mynotes` ENABLE KEYS */;

-- 导出  表 newoa.other_posts 结构
CREATE TABLE IF NOT EXISTS `other_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(50) NOT NULL COMMENT 'ID',
  `remarks_money` varchar(500) NOT NULL COMMENT '备注和金额 json',
  `hydropower` decimal(10,0) NOT NULL COMMENT '水电',
  `attendance_days` decimal(10,1) NOT NULL COMMENT '考勤天数',
  `is_input` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否录入',
  `total_price` decimal(10,2) NOT NULL COMMENT '总金额',
  `basic_salary` decimal(10,2) NOT NULL COMMENT '基本薪资',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='其他岗位';

-- 正在导出表  newoa.other_posts 的数据：~8 rows (大约)
/*!40000 ALTER TABLE `other_posts` DISABLE KEYS */;
INSERT INTO `other_posts` (`id`, `number`, `remarks_money`, `hydropower`, `attendance_days`, `is_input`, `total_price`, `basic_salary`) VALUES
	(21, 'F1210', '[\r\n  {\r\n    "remarks": "机票补贴",\r\n    "money": "460"\r\n  },\r\n  {\r\n    "remarks": "加班费",\r\n    "money": "249"\r\n  },\r\n  {\r\n    "remarks": "签证",\r\n    "money": "-700"\r\n  },\r\n  {\r\n    "remarks": "压低",\r\n    "money": "-1000"\r\n  }\r\n]', 2349, 27.0, 1, 7542.33, 8533.33),
	(22, 'F1201', '[\r\n  {\r\n    "remarks": "机票",\r\n    "money": "644"\r\n  },\r\n  {\r\n    "remarks": "开组",\r\n    "money": "1000"\r\n  }\r\n]', 2511, 29.0, 1, 11844.00, 10200.00),
	(23, 'F1303', '[\r\n  {\r\n    "remarks": "机票",\r\n    "money": "922"\r\n  },\r\n  {\r\n    "remarks": "报关",\r\n    "money": "-1000"\r\n  },\r\n  {\r\n    "remarks": "签证",\r\n    "money": "-720"\r\n  },\r\n  {\r\n    "remarks": "压低",\r\n    "money": "-1000"\r\n  }\r\n]', 740, 17.0, 1, 7474.73, 9272.73),
	(24, 'F1302', '[\r\n  {\r\n    "remarks": "机票",\r\n    "money": "1877"\r\n  },\r\n  {\r\n    "remarks": "压低",\r\n    "money": "3000"\r\n  },\r\n  {\r\n    "remarks": "工签",\r\n    "money": "-758"\r\n  },\r\n  {\r\n    "remarks": "报到费",\r\n    "money": "-186"\r\n  }\r\n]', 684, 25.0, 1, 14933.00, 11000.00),
	(25, 'F0002', '[\r\n  {\r\n    "remarks": "工龄",\r\n    "money": "500"\r\n  },\r\n  {\r\n    "remarks": "机票",\r\n    "money": "6000"\r\n  },\r\n  {\r\n    "remarks": "团队经费",\r\n    "money": "1660"\r\n  },\r\n  {\r\n    "remarks": "加班",\r\n    "money": "6971"\r\n  }\r\n]', 1181, 30.0, 1, 27964.33, 12833.33),
	(26, 'F0016', '[\r\n  {\r\n    "remarks": "工龄",\r\n    "money": "500"\r\n  },\r\n  {\r\n    "remarks": "分数",\r\n    "money": "2000"\r\n  },\r\n  {\r\n    "remarks": "机票",\r\n    "money": "6000"\r\n  },\r\n  {\r\n    "remarks": "加班",\r\n    "money": "3479"\r\n  },\r\n  {\r\n    "remarks": "任务",\r\n    "money": "2000"\r\n  }\r\n]', 0, 31.0, 1, 25379.00, 11400.00),
	(27, 'F0025', '[\r\n  {\r\n    "remarks": "机票",\r\n    "money": "2354"\r\n  },\r\n  {\r\n    "remarks": "加班",\r\n    "money": "5572"\r\n  }\r\n]', 0, 28.0, 1, 15626.00, 7700.00),
	(28, 'F0218', '[\r\n  {\r\n    "remarks": "机票",\r\n    "money": "1416"\r\n  },\r\n  {\r\n    "remarks": "加班",\r\n    "money": "2619"\r\n  }\r\n]', 1277, 29.0, 1, 11968.33, 7933.33),
	(29, 'F0426', '[\r\n  {\r\n    "remarks": "机票",\r\n    "money": "986"\r\n  },\r\n  {\r\n    "remarks": "压低",\r\n    "money": "-1000"\r\n  }\r\n]', 1112, 31.0, 1, 8386.00, 8400.00);
/*!40000 ALTER TABLE `other_posts` ENABLE KEYS */;

-- 导出  表 newoa.rbac_menu 结构
CREATE TABLE IF NOT EXISTS `rbac_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `pid` smallint(5) unsigned NOT NULL COMMENT '父id',
  `level` tinyint(3) unsigned NOT NULL COMMENT '级别',
  `order` tinyint(3) unsigned DEFAULT '1',
  `icons` varchar(50) DEFAULT NULL,
  `router` varchar(50) DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- 正在导出表  newoa.rbac_menu 的数据：~54 rows (大约)
/*!40000 ALTER TABLE `rbac_menu` DISABLE KEYS */;
INSERT INTO `rbac_menu` (`id`, `name`, `pid`, `level`, `order`, `icons`, `router`, `status`) VALUES
	(1, '个人办公', 0, 1, 101, NULL, NULL, 1),
	(2, '系统', 0, 1, 100, NULL, NULL, 1),
	(3, '个人中心', 1, 2, 105, '6c7', NULL, 1),
	(4, '会议', 1, 2, 101, '724', NULL, 1),
	(5, '个人设置', 3, 3, 101, NULL, NULL, 1),
	(6, '个人资料', 3, 3, 101, NULL, NULL, 1),
	(7, '我的薪资', 3, 3, 101, NULL, '/personal/salary', 1),
	(8, '今日会议', 4, 3, 101, NULL, NULL, 1),
	(9, '会议室情况', 4, 3, 101, NULL, NULL, 1),
	(10, '权限设置', 2, 2, 101, '6fc', NULL, 1),
	(11, '菜单', 10, 3, 101, NULL, '/rbac/menu', 1),
	(12, '角色', 10, 3, 101, NULL, '/rbac/role', 1),
	(13, '行政', 0, 1, 101, NULL, NULL, 1),
	(14, '组织结构', 13, 2, 101, '6ce', NULL, 1),
	(15, '部门', 14, 3, 101, NULL, '/department', 1),
	(16, '员工', 14, 3, 101, NULL, '/staff', 1),
	(18, '财务', 0, 1, 101, NULL, NULL, 1),
	(19, '统计', 18, 2, 101, '74e', NULL, 1),
	(21, '部门添加', 15, 4, 101, NULL, '/department/add', 1),
	(22, '部门修改', 15, 4, 101, NULL, '/department/edit', 1),
	(23, '部门删除', 15, 4, 101, NULL, '/department/delete', 1),
	(24, '员工添加', 16, 4, 101, NULL, '/staff/add', 1),
	(25, '员工修改', 16, 4, 101, NULL, '/staff/edit', 1),
	(26, '员工删除', 16, 4, 101, NULL, '/staff/delete', 1),
	(27, '添加菜单', 11, 4, 101, NULL, '/rbac/menu/add', 1),
	(28, '菜单修改', 11, 4, 101, NULL, '/rbac/menu/edit', 1),
	(29, '菜单删除', 11, 4, 101, NULL, '/rbac/menu/delete', 1),
	(30, '角色添加', 12, 4, 101, NULL, '/rbac/role/add', 1),
	(31, '角色修改', 12, 4, 101, NULL, '/rbac/role/edit', 1),
	(32, '角色删除', 12, 4, 101, NULL, '/rbac/role/delete', 1),
	(36, '员工生日', 14, 3, 99, NULL, '/salary/todays_birthday', 1),
	(43, '宿舍管理', 13, 2, 101, '839', NULL, 1),
	(44, '员工入住', 43, 3, 101, NULL, '/dormitory_management/dormitory', 1),
	(45, '公寓设置', 43, 3, 102, NULL, '/dormitory_management/apartment', 1),
	(46, '公寓添加', 45, 4, 101, NULL, '/dormitory_management/apartment/add', 1),
	(47, '公寓修改', 45, 4, 100, NULL, '/dormitory_management/apartment/edit', 1),
	(48, '公寓删除', 45, 4, 90, NULL, '/dormitory_management/apartment/delete', 1),
	(49, '员工入住修改', 44, 4, 101, NULL, '/dormitory_management/dormitory/edit', 1),
	(50, '薪资结构', 19, 3, 105, NULL, '/salary_structure', 1),
	(51, '薪资添加', 50, 4, 101, NULL, '/salary_structure/add', 1),
	(52, '薪资修改', 50, 4, 101, NULL, '/salary_structure/edit', 1),
	(53, '薪资删除', 50, 4, 101, NULL, '/salary_structure/delete', 1),
	(54, '我的便签', 3, 3, 101, NULL, '/personal/mynotes', 1),
	(55, '添加便签', 54, 4, 101, NULL, '/personal/mynotes/add', 1),
	(56, '删除便签', 54, 4, 101, NULL, '/personal/mynotes/delete', 1),
	(57, '设置角色权限', 12, 4, 101, NULL, '/rbac/role/set_auth', 1),
	(60, '其他岗位', 19, 3, 101, NULL, '/other/posts', 1),
	(61, '薪资计算', 60, 4, 101, NULL, '/other/posts/calculation', 1),
	(62, '查看', 60, 4, 101, NULL, '/other/posts/see', 1),
	(63, '汇率设置', 19, 3, 104, NULL, '/rate/setting', 1),
	(64, '推广岗位', 19, 3, 101, NULL, '/promotion/posts', 1),
	(65, '添加绩效', 64, 4, 101, NULL, '/promotion/posts/add', 1),
	(66, '工资计算', 64, 4, 101, NULL, '/promotion/posts/calculation', 1),
	(67, '查看', 64, 4, 101, NULL, '/promotion/posts/see', 1);
/*!40000 ALTER TABLE `rbac_menu` ENABLE KEYS */;

-- 导出  表 newoa.rbac_role 结构
CREATE TABLE IF NOT EXISTS `rbac_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `auth_ids` text COMMENT '权限 ids "1,2,5"',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- 正在导出表  newoa.rbac_role 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `rbac_role` DISABLE KEYS */;
INSERT INTO `rbac_role` (`id`, `name`, `auth_ids`, `status`) VALUES
	(1, '总经理', '13,14,15,21,22,23,16,24,25,26,36,43,45,46,47,48,44,49,18,19,50,51,52,53,63,20,39,41,42,40,60,61,62,64,65,66,67,1,3,5,6,7,54,55,56,4,8,9,2,10,11,27,28,29,12,30,31,32,57', 1),
	(2, '行政', '13,14,15,21,22,23,16,24,25,26,36,43,45,46,47,48,44,49', 1),
	(3, '客服', '1,3,5', 1),
	(4, '普通员工', '1,3,5,6,7,54,55,56,58,59', 1);
/*!40000 ALTER TABLE `rbac_role` ENABLE KEYS */;

-- 导出  表 newoa.salary_structure 结构
CREATE TABLE IF NOT EXISTS `salary_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `salary` int(11) NOT NULL,
  `remarks` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='薪资结构';

-- 正在导出表  newoa.salary_structure 的数据：~19 rows (大约)
/*!40000 ALTER TABLE `salary_structure` DISABLE KEYS */;
INSERT INTO `salary_structure` (`id`, `pid`, `name`, `salary`, `remarks`) VALUES
	(1, 0, '推广主管(15000)', 15000, '推广部'),
	(2, 0, '行政主管(13000)', 13000, '行政部'),
	(3, 0, '人事主管', 12000, '人事部'),
	(4, 0, '客服主管', 11500, '客服部'),
	(5, 0, 'IT主管(12000)', 12000, '网络部'),
	(6, 1, '组长(11000)', 11000, '推广部'),
	(7, 1, '副组长(9500)', 9500, '推广部'),
	(8, 1, '推广组员(7000)', 7000, '推广部'),
	(9, 2, '行政组员(8000)', 8000, '行政部'),
	(10, 3, '人事组员', 7000, '人事部'),
	(11, 4, '客服组员(5000)', 5000, '客服部'),
	(12, 5, 'IT组员(10000)', 10000, '网络部'),
	(13, 0, '后厨主管', 20, '后厨部'),
	(14, 13, '后厨组员', 10, '后厨部'),
	(15, 0, '保安主管', 2000, '安保部'),
	(16, 15, '保安组员', 1000, '安保部'),
	(18, 2, '行政(9000)', 9000, '行政部'),
	(19, 4, '客服档次(7000)', 7000, '客服部'),
	(20, 4, '客服档次(8000)', 8000, '客服部'),
	(21, 1, '组长(12000)', 12000, '推广部'),
	(22, 2, '行政(6000)', 6000, '行政部');
/*!40000 ALTER TABLE `salary_structure` ENABLE KEYS */;

-- 导出  表 newoa.special_position_scorel 结构
CREATE TABLE IF NOT EXISTS `special_position_scorel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='特殊岗位评分';

-- 正在导出表  newoa.special_position_scorel 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `special_position_scorel` DISABLE KEYS */;
INSERT INTO `special_position_scorel` (`id`, `department_id`, `score`) VALUES
	(15, 28, 84);
/*!40000 ALTER TABLE `special_position_scorel` ENABLE KEYS */;

-- 导出  表 newoa.staff 结构
CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nick_name` varchar(30) NOT NULL COMMENT '外号',
  `is_formal` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否转正 0 未转正 1转正',
  `salary_structure_id` int(11) NOT NULL COMMENT '关联薪资结构表',
  `business_type` int(11) NOT NULL COMMENT '针对推广人员 是推广 还是特殊',
  `number` varchar(50) NOT NULL COMMENT '员工唯一编号',
  `place` varchar(15) NOT NULL COMMENT '籍贯',
  `phone` varchar(15) NOT NULL COMMENT '联系电话',
  `age` varchar(50) NOT NULL COMMENT '生日',
  `date_of_entry` varchar(50) NOT NULL COMMENT '入职日期',
  `department_id` int(11) NOT NULL COMMENT '入职部门',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '4',
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`),
  KEY `age` (`age`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='员工表';

-- 正在导出表  newoa.staff 的数据：~8 rows (大约)
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` (`id`, `nick_name`, `is_formal`, `salary_structure_id`, `business_type`, `number`, `place`, `phone`, `age`, `date_of_entry`, `department_id`, `status`, `password`, `created_at`, `updated_at`, `role_id`) VALUES
	(1, 'zero', 1, 9, 2, 'F1210', '上海', '131311', '01-20', '2019-01-20 00:00:00', 16, 1, '123456', '2019-01-20 06:53:55', '2019-01-20 06:53:55', 1),
	(2, '露西', 1, 18, 2, 'F1201', '上海', '131311', '01-20', '2019-01-20 00:00:00', 16, 1, '123456', '2019-01-20 07:11:06', '2019-01-20 07:11:27', 4),
	(3, 'susan', 1, 5, 2, 'F1303', '上海', '131311', '01-20', '2019-01-20 00:00:00', 13, 1, '123456', '2019-01-20 07:23:51', '2019-01-20 07:23:51', 4),
	(4, '土匪', 1, 12, 2, 'F1302', '上海', '131311', '01-20', '2019-01-20 00:00:00', 13, 1, '123456', '2019-01-20 07:27:25', '2019-01-20 07:27:25', 4),
	(5, '阿松', 1, 6, 2, 'F0002', '上海', '131311', '01-20', '2019-01-20 00:00:00', 28, 1, '123456', '2019-01-20 11:20:59', '2019-01-20 11:20:59', 4),
	(6, '阿涛', 1, 7, 2, 'F0016', '上海', '131311', '01-20', '2019-01-20 00:00:00', 28, 1, '123456', '2019-01-20 11:21:31', '2019-01-20 11:21:31', 4),
	(7, '冰淇淋', 1, 8, 1, 'F0025', '上海', '131311', '01-20', '2019-01-20 00:00:00', 28, 1, '123456', '2019-01-20 11:22:03', '2019-01-20 11:22:03', 4),
	(8, '小婷', 1, 8, 1, 'F0218', '上海', '131311', '01-20', '2019-01-20 00:00:00', 28, 1, '123456', '2019-01-20 11:22:32', '2019-01-20 11:22:32', 4),
	(9, '小李', 0, 8, 1, 'F0426', '上海', '131311', '01-20', '2019-01-20 00:00:00', 28, 1, '123456', '2019-01-20 11:23:04', '2019-01-20 11:23:04', 4);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
