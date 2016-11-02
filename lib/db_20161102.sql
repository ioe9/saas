-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-02 10:25:47
-- 服务器版本： 10.1.13-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ioego`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_assert`
--

CREATE TABLE `admin_assert` (
  `assert_id` int(10) UNSIGNED NOT NULL COMMENT 'Assert ID',
  `assert_type` varchar(20) DEFAULT NULL COMMENT 'Assert Type',
  `assert_data` text COMMENT 'Assert Data'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin Assert Table';

-- --------------------------------------------------------

--
-- 表的结构 `admin_role`
--

CREATE TABLE `admin_role` (
  `role_id` int(10) UNSIGNED NOT NULL COMMENT 'Role ID',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Parent Role ID',
  `tree_level` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Role Tree Level',
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Role Sort Order',
  `role_type` varchar(1) NOT NULL DEFAULT '0' COMMENT 'Role Type',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'User ID',
  `role_name` varchar(50) DEFAULT NULL COMMENT 'Role Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin Role Table';

--
-- 转存表中的数据 `admin_role`
--

INSERT INTO `admin_role` (`role_id`, `parent_id`, `tree_level`, `sort_order`, `role_type`, `user_id`, `role_name`) VALUES
(1, 0, 1, 1, 'G', 0, '超级管理员'),
(3, 1, 2, 0, 'U', 1, 'admin'),
(4, 0, 1, 0, 'G', 0, '产品总监'),
(5, 0, 1, 0, 'G', 0, '运营总监'),
(6, 0, 1, 0, 'G', 0, '运营人员'),
(9, 0, 1, 0, 'G', 0, '产品人员'),
(14, 6, 2, 0, 'U', 5, '宏芸'),
(15, 6, 2, 0, 'U', 6, '青'),
(16, 5, 2, 0, 'U', 4, '席军'),
(17, 4, 2, 0, 'U', 3, '吕兰'),
(19, 1, 2, 0, 'U', 2, '杨琼'),
(24, 1, 2, 0, 'U', 18, 'yang002');

-- --------------------------------------------------------

--
-- 表的结构 `admin_rule`
--

CREATE TABLE `admin_rule` (
  `rule_id` int(10) UNSIGNED NOT NULL COMMENT 'Rule ID',
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Role ID',
  `resource_id` varchar(255) DEFAULT NULL COMMENT 'Resource ID',
  `privileges` varchar(20) DEFAULT NULL COMMENT 'Privileges',
  `assert_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Assert ID',
  `role_type` varchar(1) DEFAULT NULL COMMENT 'Role Type',
  `permission` varchar(10) DEFAULT NULL COMMENT 'Permission'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin Rule Table';

--
-- 转存表中的数据 `admin_rule`
--

INSERT INTO `admin_rule` (`rule_id`, `role_id`, `resource_id`, `privileges`, `assert_id`, `role_type`, `permission`) VALUES
(2, 1, 'all', NULL, 0, 'G', 'allow'),
(247, 4, 'all', NULL, 0, 'G', 'allow'),
(248, 9, 'all', NULL, 0, 'G', 'deny'),
(249, 9, 'admin', NULL, 0, 'G', 'deny'),
(250, 9, 'admin/dashboard', NULL, 0, 'G', 'deny'),
(251, 9, 'admin/system', NULL, 0, 'G', 'deny'),
(252, 9, 'admin/system/acl', NULL, 0, 'G', 'deny'),
(253, 9, 'admin/system/acl/roles', NULL, 0, 'G', 'deny'),
(254, 9, 'admin/system/acl/users', NULL, 0, 'G', 'deny'),
(255, 9, 'admin/system/acl/variables', NULL, 0, 'G', 'deny'),
(256, 9, 'admin/system/acl/blocks', NULL, 0, 'G', 'deny'),
(257, 9, 'admin/system/store', NULL, 0, 'G', 'deny'),
(258, 9, 'admin/system/design', NULL, 0, 'G', 'deny'),
(259, 9, 'admin/system/config', NULL, 0, 'G', 'deny'),
(260, 9, 'admin/system/config/general', NULL, 0, 'G', 'deny'),
(261, 9, 'admin/system/config/web', NULL, 0, 'G', 'deny'),
(262, 9, 'admin/system/config/design', NULL, 0, 'G', 'deny'),
(263, 9, 'admin/system/config/system', NULL, 0, 'G', 'deny'),
(264, 9, 'admin/system/config/advanced', NULL, 0, 'G', 'deny'),
(265, 9, 'admin/system/config/trans_email', NULL, 0, 'G', 'deny'),
(266, 9, 'admin/system/config/dev', NULL, 0, 'G', 'deny'),
(267, 9, 'admin/system/config/currency', NULL, 0, 'G', 'deny'),
(268, 9, 'admin/system/config/sendfriend', NULL, 0, 'G', 'deny'),
(269, 9, 'admin/system/config/admin', NULL, 0, 'G', 'deny'),
(270, 9, 'admin/system/config/payment', NULL, 0, 'G', 'deny'),
(271, 9, 'admin/system/config/payment_services', NULL, 0, 'G', 'deny'),
(272, 9, 'admin/system/config/api', NULL, 0, 'G', 'deny'),
(273, 9, 'admin/system/config/oauth', NULL, 0, 'G', 'deny'),
(274, 9, 'admin/system/config/persistent', NULL, 0, 'G', 'deny'),
(275, 9, 'admin/system/config/plan', NULL, 0, 'G', 'deny'),
(276, 9, 'admin/system/currency', NULL, 0, 'G', 'deny'),
(277, 9, 'admin/system/email_template', NULL, 0, 'G', 'deny'),
(278, 9, 'admin/system/variable', NULL, 0, 'G', 'deny'),
(279, 9, 'admin/system/myaccount', NULL, 0, 'G', 'deny'),
(280, 9, 'admin/system/tools', NULL, 0, 'G', 'deny'),
(281, 9, 'admin/system/tools/compiler', NULL, 0, 'G', 'deny'),
(282, 9, 'admin/system/convert', NULL, 0, 'G', 'deny'),
(283, 9, 'admin/system/convert/gui', NULL, 0, 'G', 'deny'),
(284, 9, 'admin/system/convert/profiles', NULL, 0, 'G', 'deny'),
(285, 9, 'admin/system/convert/import', NULL, 0, 'G', 'deny'),
(286, 9, 'admin/system/convert/export', NULL, 0, 'G', 'deny'),
(287, 9, 'admin/system/cache', NULL, 0, 'G', 'deny'),
(288, 9, 'admin/system/extensions', NULL, 0, 'G', 'deny'),
(289, 9, 'admin/system/extensions/local', NULL, 0, 'G', 'deny'),
(290, 9, 'admin/system/extensions/custom', NULL, 0, 'G', 'deny'),
(291, 9, 'admin/system/adminnotification', NULL, 0, 'G', 'deny'),
(292, 9, 'admin/system/adminnotification/show_toolbar', NULL, 0, 'G', 'deny'),
(293, 9, 'admin/system/adminnotification/show_list', NULL, 0, 'G', 'deny'),
(294, 9, 'admin/system/adminnotification/mark_as_read', NULL, 0, 'G', 'deny'),
(295, 9, 'admin/system/adminnotification/remove', NULL, 0, 'G', 'deny'),
(296, 9, 'admin/system/index', NULL, 0, 'G', 'deny'),
(297, 9, 'admin/system/api', NULL, 0, 'G', 'deny'),
(298, 9, 'admin/system/api/users', NULL, 0, 'G', 'deny'),
(299, 9, 'admin/system/api/roles', NULL, 0, 'G', 'deny'),
(300, 9, 'admin/system/api/consumer', NULL, 0, 'G', 'deny'),
(301, 9, 'admin/system/api/consumer/edit', NULL, 0, 'G', 'deny'),
(302, 9, 'admin/system/api/consumer/delete', NULL, 0, 'G', 'deny'),
(303, 9, 'admin/system/api/authorizedTokens', NULL, 0, 'G', 'deny'),
(304, 9, 'admin/system/api/oauth_admin_token', NULL, 0, 'G', 'deny'),
(305, 9, 'admin/system/api/rest_roles', NULL, 0, 'G', 'deny'),
(306, 9, 'admin/system/api/rest_roles/add', NULL, 0, 'G', 'deny'),
(307, 9, 'admin/system/api/rest_roles/edit', NULL, 0, 'G', 'deny'),
(308, 9, 'admin/system/api/rest_roles/delete', NULL, 0, 'G', 'deny'),
(309, 9, 'admin/system/api/rest_attributes', NULL, 0, 'G', 'deny'),
(310, 9, 'admin/system/api/rest_attributes/edit', NULL, 0, 'G', 'deny'),
(311, 9, 'admin/global_search', NULL, 0, 'G', 'deny'),
(312, 9, 'admin/cms', NULL, 0, 'G', 'deny'),
(313, 9, 'admin/cms/widget_instance', NULL, 0, 'G', 'deny'),
(314, 9, 'admin/page_cache', NULL, 0, 'G', 'deny'),
(315, 9, 'admin/customize', NULL, 0, 'G', 'deny'),
(316, 9, 'admin/customize/category', NULL, 0, 'G', 'deny'),
(317, 9, 'admin/customize/photo', NULL, 0, 'G', 'deny'),
(318, 9, 'admin/customize/theme', NULL, 0, 'G', 'deny'),
(319, 9, 'admin/customize/theme_category', NULL, 0, 'G', 'deny'),
(320, 9, 'admin/customize/design', NULL, 0, 'G', 'deny'),
(321, 9, 'admin/customize/design_category', NULL, 0, 'G', 'deny'),
(322, 9, 'admin/plan_product', NULL, 0, 'G', 'deny'),
(323, 9, 'admin/plan_plan', NULL, 0, 'G', 'deny'),
(324, 9, 'admin/plan_case', NULL, 0, 'G', 'deny'),
(325, 9, 'admin/review', NULL, 0, 'G', 'deny'),
(326, 9, 'admin/scene', NULL, 0, 'G', 'deny'),
(327, 9, 'admin/wiki', NULL, 0, 'G', 'deny'),
(328, 9, 'admin/sentence', NULL, 0, 'G', 'deny'),
(329, 6, 'all', NULL, 0, 'G', 'allow'),
(330, 5, 'all', NULL, 0, 'G', 'allow');

-- --------------------------------------------------------

--
-- 表的结构 `admin_user`
--

CREATE TABLE `admin_user` (
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'User ID',
  `firstname` varchar(32) DEFAULT NULL COMMENT 'User First Name',
  `lastname` varchar(32) DEFAULT NULL COMMENT 'User Last Name',
  `email` varchar(128) DEFAULT NULL COMMENT 'User Email',
  `username` varchar(40) DEFAULT NULL COMMENT 'User Login',
  `password` varchar(100) DEFAULT NULL COMMENT 'User Password',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'User Created Time',
  `modified` timestamp NULL DEFAULT NULL COMMENT 'User Modified Time',
  `logdate` timestamp NULL DEFAULT NULL COMMENT 'User Last Login Time',
  `lognum` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'User Login Number',
  `reload_acl_flag` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Reload ACL',
  `is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'User Is Active',
  `extra` text COMMENT 'User Extra Data',
  `rp_token` text COMMENT 'Reset Password Link Token',
  `rp_token_created_at` timestamp NULL DEFAULT NULL COMMENT 'Reset Password Link Token Creation Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin User Table';

--
-- 转存表中的数据 `admin_user`
--

INSERT INTO `admin_user` (`user_id`, `firstname`, `lastname`, `email`, `username`, `password`, `created`, `modified`, `logdate`, `lognum`, `reload_acl_flag`, `is_active`, `extra`, `rp_token`, `rp_token_created_at`) VALUES
(1, 'Yang', 'Gary', 'yanggaojiao@qq.com', 'admin', '0192023a7bbd73250516f069df18b500', '2015-12-24 21:16:24', '2016-03-13 16:17:23', '2016-10-27 00:50:23', 251, 0, 1, 'a:1:{s:11:"configState";a:27:{s:12:"dev_restrict";s:1:"0";s:9:"dev_debug";s:1:"0";s:12:"dev_template";s:1:"0";s:20:"dev_translate_inline";s:1:"0";s:7:"dev_log";s:1:"0";s:6:"dev_js";s:1:"1";s:7:"dev_css";s:1:"1";s:7:"web_url";s:1:"0";s:7:"web_seo";s:1:"1";s:12:"web_unsecure";s:1:"0";s:10:"web_secure";s:1:"0";s:11:"web_default";s:1:"0";s:9:"web_polls";s:1:"0";s:10:"web_cookie";s:1:"0";s:11:"web_session";s:1:"0";s:24:"web_browser_capabilities";s:1:"0";s:14:"design_package";s:1:"0";s:12:"design_theme";s:1:"0";s:11:"design_head";s:1:"1";s:13:"design_header";s:1:"1";s:13:"design_footer";s:1:"0";s:16:"design_watermark";s:1:"1";s:17:"design_pagination";s:1:"0";s:12:"design_email";s:1:"0";s:13:"plan_settings";s:1:"1";s:11:"system_csrf";s:1:"0";s:16:"edm_txt_analysis";s:1:"1";}}', NULL, NULL),
(2, '杨琼', '杨', '3313029632@qq.com', 'lisa', '0192023a7bbd73250516f069df18b500', '2016-02-17 02:12:24', '2016-05-18 09:07:15', '2016-02-18 23:47:07', 1, 0, 1, 'N;', NULL, NULL),
(3, '吕兰', '吕', '3252476610@qq.com', 'locas', '3496f35f3d24652ec79b1867b2fca721:kEIaTqVa5G6sYTPurw4WXukuaWyOK1BV', '2016-02-17 02:14:49', '2016-03-13 17:08:51', NULL, 0, 0, 1, 'N;', NULL, NULL),
(4, '韩席军', '韩', '251880795@qq.com', 'neal', '5ad8e0f1a22cfa08028f1606e2ad86a1:jAQzKgkz37XmG1brKv3ZJKzbTpnvkl9n', '2016-02-17 02:16:18', '2016-02-19 00:23:26', '2016-02-19 00:23:26', 1, 0, 1, 'N;', NULL, NULL),
(5, '宏芸', '许', '514504483@qq.com', 'shirley', 'c77005370f7b4ae622d5c610b1355c73:YMyV3y8kAXp45OJ25MTI2qWswMzsV9pC', '2016-02-17 02:19:43', '2016-02-17 02:19:43', NULL, 0, 1, 1, 'N;', NULL, NULL),
(6, '青', '付', '648842003@qq.com', 'summar', '28f6c47362e0558853c3672471dca139:ZVb9wzagThWDCKU122VSqfZ3zVkmADmG', '2016-02-17 02:20:54', '2016-02-18 23:59:02', '2016-02-18 23:59:02', 2, 0, 1, 'N;', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `approve_apply`
--

CREATE TABLE `approve_apply` (
  `apply_id` int(11) UNSIGNED NOT NULL,
  `apply_template` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `apply_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `apply_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `apply_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `apply_phone` varchar(100) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `apply_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `approve_apply_audit`
--

CREATE TABLE `approve_apply_audit` (
  `audit_id` int(11) UNSIGNED NOT NULL,
  `audit_apply` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `audit_create` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '审批人',
  `date_create` datetime DEFAULT NULL COMMENT '审批时间',
  `audit_desc` text,
  `audit_status` tinyint(2) DEFAULT '0' COMMENT '审批状态 0待审 1审批通过 -1驳回'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `approve_apply_link`
--

CREATE TABLE `approve_apply_link` (
  `link_id` int(11) UNSIGNED NOT NULL,
  `link_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0关注人',
  `link_apply` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `link_user` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `link_suggest` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `approve_template`
--

CREATE TABLE `approve_template` (
  `template_id` int(11) UNSIGNED NOT NULL,
  `tpl_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tpl_name` varchar(100) NOT NULL,
  `tpl_desc` text,
  `tpl_position` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(2) UNSIGNED DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `approve_template_audit`
--

CREATE TABLE `approve_template_audit` (
  `audit_id` int(11) UNSIGNED NOT NULL,
  `audit_template` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `audit_user` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `attendance_attendance`
--

CREATE TABLE `attendance_attendance` (
  `attendance_id` int(11) UNSIGNED NOT NULL,
  `att_create` int(11) UNSIGNED NOT NULL COMMENT '考勤人',
  `att_in` datetime DEFAULT NULL,
  `att_in_ip` varchar(20) DEFAULT NULL,
  `att_out` datetime DEFAULT NULL,
  `att_out_ip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `attendance_fieldwork`
--

CREATE TABLE `attendance_fieldwork` (
  `fieldwork_id` int(11) UNSIGNED NOT NULL,
  `fieldwork_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `fieldwork_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `fieldwork_address` varchar(100) NOT NULL,
  `fieldwork_hour` decimal(9,1) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '小时数',
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `fieldwork_reason` text NOT NULL,
  `fieldwork_status` tinyint(2) NOT NULL DEFAULT '0',
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `attendance_leave`
--

CREATE TABLE `attendance_leave` (
  `leave_id` int(11) UNSIGNED NOT NULL,
  `leave_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `leave_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `leave_type` smallint(6) NOT NULL DEFAULT '0',
  `leave_hour` decimal(9,1) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '小时数',
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `leave_reason` text NOT NULL,
  `leave_status` tinyint(2) NOT NULL DEFAULT '0',
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `attendance_overtime`
--

CREATE TABLE `attendance_overtime` (
  `overtime_id` int(11) UNSIGNED NOT NULL,
  `overtime_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `overtime_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `overtime_hour` decimal(9,1) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '小时数',
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `overtime_reason` text NOT NULL,
  `overtime_status` tinyint(2) NOT NULL DEFAULT '0',
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `attendance_travel`
--

CREATE TABLE `attendance_travel` (
  `travel_id` int(11) UNSIGNED NOT NULL,
  `travel_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `travel_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `travel_address` varchar(100) NOT NULL,
  `travel_hour` decimal(9,1) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '小时数',
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `travel_reason` text NOT NULL,
  `travel_status` tinyint(2) NOT NULL DEFAULT '0',
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_file`
--

CREATE TABLE `bill_file` (
  `file_id` int(11) UNSIGNED NOT NULL,
  `file_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '1报销附件 2借款附件 3 营收附件',
  `file_object` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `file_path` varchar(255) NOT NULL,
  `file_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_link`
--

CREATE TABLE `bill_link` (
  `link_id` int(11) UNSIGNED NOT NULL,
  `link_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `link_object` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `link_user` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_loan`
--

CREATE TABLE `bill_loan` (
  `loan_id` int(11) UNSIGNED NOT NULL,
  `loan_code` varchar(100) DEFAULT NULL,
  `date_loan` datetime DEFAULT NULL COMMENT '借款日期',
  `date_repay` datetime DEFAULT NULL COMMENT '还款日期',
  `loan_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `loan_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `loan_mobile` varchar(100) DEFAULT NULL,
  `loan_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `loan_reason` text,
  `loan_method` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '借款方式 0现金 1银行卡',
  `loan_status` smallint(6) DEFAULT '0' COMMENT '状态 0待送审 1送审 2财务审核中 3已办结 -1被驳回',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_loan_audit`
--

CREATE TABLE `bill_loan_audit` (
  `audit_id` int(11) UNSIGNED NOT NULL,
  `audit_loan` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `audit_create` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '审批人',
  `date_create` datetime DEFAULT NULL COMMENT '审批时间',
  `audit_desc` text,
  `audit_status` tinyint(2) DEFAULT '0' COMMENT '审批状态 0待审 1审批通过 -1驳回'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_loan_bank`
--

CREATE TABLE `bill_loan_bank` (
  `bank_id` int(11) UNSIGNED NOT NULL,
  `bank_loan` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `bank_payee` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_loan_item`
--

CREATE TABLE `bill_loan_item` (
  `item_id` int(11) UNSIGNED NOT NULL,
  `item_loan` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `item_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '借款类型',
  `item_memo` varchar(255) DEFAULT NULL,
  `total_loan` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_reimburse`
--

CREATE TABLE `bill_reimburse` (
  `reimburse_id` int(11) UNSIGNED NOT NULL,
  `rei_code` varchar(100) DEFAULT NULL,
  `rei_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '报销类型 0日常报销 1差旅费报销 2人力成本报 3对公付款销',
  `rei_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `rei_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `rei_mobile` varchar(100) DEFAULT NULL,
  `total_bill` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `rei_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `rei_reason` text,
  `rei_method` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '报销方式 0现金 1银行卡',
  `rei_status` smallint(6) DEFAULT '0' COMMENT '状态 0待送审 1送审 2财务审核中 3已办结 -1被驳回',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_reimburse_audit`
--

CREATE TABLE `bill_reimburse_audit` (
  `audit_id` int(11) UNSIGNED NOT NULL,
  `audit_rei` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `audit_create` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '审批人',
  `date_create` datetime DEFAULT NULL COMMENT '审批时间',
  `audit_desc` text,
  `audit_status` tinyint(2) DEFAULT '0' COMMENT '审批状态 0待审 1审批通过 -1驳回'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_reimburse_bank`
--

CREATE TABLE `bill_reimburse_bank` (
  `bank_id` int(11) UNSIGNED NOT NULL,
  `bank_rei` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `bank_payee` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_reimburse_item`
--

CREATE TABLE `bill_reimburse_item` (
  `item_id` int(11) UNSIGNED NOT NULL,
  `item_rei` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `item_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '费用类型',
  `item_memo` varchar(255) DEFAULT NULL,
  `total_rei` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_revenue`
--

CREATE TABLE `bill_revenue` (
  `revenue_id` int(11) UNSIGNED NOT NULL,
  `revenue_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `revenue_payer` varchar(100) DEFAULT NULL,
  `revenue_code` varchar(100) DEFAULT NULL,
  `revenue_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `total_revenue` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT '应收金额',
  `revenue_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `revenue_desc` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_revenue_item`
--

CREATE TABLE `bill_revenue_item` (
  `item_id` int(11) UNSIGNED NOT NULL,
  `item_revenue` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `total_revenue` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `total_confirm` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `item_memo` varchar(255) DEFAULT NULL,
  `date_item` date DEFAULT NULL COMMENT '收款日期',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_setting_project`
--

CREATE TABLE `bill_setting_project` (
  `project_id` int(11) UNSIGNED NOT NULL,
  `project_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `project_name` varchar(100) NOT NULL,
  `project_status` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '状态 0未启用 1启用中'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bill_setting_type`
--

CREATE TABLE `bill_setting_type` (
  `type_id` int(11) UNSIGNED NOT NULL,
  `type_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type_name` varchar(100) NOT NULL,
  `type_position` smallint(6) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bulletin_msg`
--

CREATE TABLE `bulletin_msg` (
  `msg_id` int(11) UNSIGNED NOT NULL,
  `msg_name` varchar(255) NOT NULL,
  `msg_type` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `msg_company_int` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `msg_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `msg_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `need_audit` tinyint(2) UNSIGNED ZEROFILL NOT NULL DEFAULT '00' COMMENT '是否签发',
  `msg_desc` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bulletin_msg_audit`
--

CREATE TABLE `bulletin_msg_audit` (
  `audit_id` int(11) UNSIGNED NOT NULL,
  `audit_user` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `audit_msg` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `audit_reply` text,
  `audit_status` tinyint(2) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bulletin_msg_file`
--

CREATE TABLE `bulletin_msg_file` (
  `file_id` int(11) UNSIGNED NOT NULL,
  `file_msg` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `file_path` varchar(255) NOT NULL,
  `date_create` datetime DEFAULT NULL,
  `file_create` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bulletin_msg_visible`
--

CREATE TABLE `bulletin_msg_visible` (
  `visible_id` int(11) UNSIGNED NOT NULL,
  `visible_msg` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `visible_type` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0同时 1部门',
  `visible_object` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `bulletin_setting_type`
--

CREATE TABLE `bulletin_setting_type` (
  `type_id` int(11) UNSIGNED NOT NULL,
  `type_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type_name` varchar(100) NOT NULL,
  `type_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `type_maker` varchar(255) DEFAULT NULL,
  `need_audit` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `type_audit` varchar(255) DEFAULT NULL,
  `type_desc` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `cms_block`
--

CREATE TABLE `cms_block` (
  `block_id` smallint(6) NOT NULL COMMENT 'Block ID',
  `title` varchar(255) NOT NULL COMMENT 'Block Title',
  `identifier` varchar(255) NOT NULL COMMENT 'Block String Identifier',
  `content` mediumtext COMMENT 'Block Content',
  `creation_time` timestamp NULL DEFAULT NULL COMMENT 'Block Creation Time',
  `update_time` timestamp NULL DEFAULT NULL COMMENT 'Block Modification Time',
  `is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Is Block Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CMS Block Table';

-- --------------------------------------------------------

--
-- 表的结构 `cms_page`
--

CREATE TABLE `cms_page` (
  `page_id` smallint(6) NOT NULL COMMENT 'Page ID',
  `title` varchar(255) DEFAULT NULL COMMENT 'Page Title',
  `root_template` varchar(255) DEFAULT NULL COMMENT 'Page Template',
  `meta_keywords` text COMMENT 'Page Meta Keywords',
  `meta_description` text COMMENT 'Page Meta Description',
  `identifier` varchar(100) DEFAULT NULL COMMENT 'Page String Identifier',
  `content_heading` varchar(255) DEFAULT NULL COMMENT 'Page Content Heading',
  `content` mediumtext COMMENT 'Page Content',
  `creation_time` timestamp NULL DEFAULT NULL COMMENT 'Page Creation Time',
  `update_time` timestamp NULL DEFAULT NULL COMMENT 'Page Modification Time',
  `is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Is Page Active',
  `sort_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Page Sort Order',
  `layout_update_xml` text COMMENT 'Page Layout Update Content',
  `custom_theme` varchar(100) DEFAULT NULL COMMENT 'Page Custom Theme',
  `custom_root_template` varchar(255) DEFAULT NULL COMMENT 'Page Custom Template',
  `custom_layout_update_xml` text COMMENT 'Page Custom Layout Update Content',
  `custom_theme_from` date DEFAULT NULL COMMENT 'Page Custom Theme Active From Date',
  `custom_theme_to` date DEFAULT NULL COMMENT 'Page Custom Theme Active To Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='CMS Page Table';

--
-- 转存表中的数据 `cms_page`
--

INSERT INTO `cms_page` (`page_id`, `title`, `root_template`, `meta_keywords`, `meta_description`, `identifier`, `content_heading`, `content`, `creation_time`, `update_time`, `is_active`, `sort_order`, `layout_update_xml`, `custom_theme`, `custom_root_template`, `custom_layout_update_xml`, `custom_theme_from`, `custom_theme_to`) VALUES
(7, '关于我们', 'one_column', NULL, NULL, 'about-us.html', NULL, '关于我们内容', '2016-03-15 08:29:01', '2016-03-21 16:58:05', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '系统说明', 'empty', NULL, NULL, 'readme', NULL, '系统功能：<br />A. 客户分析：<br />1. 自动分析客户的类别：有助于理解客户可能的偏好，比如对于大型的连锁超市，和一个小的网店，他们的关注点可能是非常不同的。大型连锁超市可能会更加关注价格和产能。而小的网店更加关注你的MOQ。<br /><br />2. 自动分析客户的定位：每个客户在质量，价格，服务，设计等几个不同维度之间的定位是不同的。比如有的客户采用的是低价策略，他可能对质量或者款式的要求就没有那么严格。相反一些高端客户，对于款式设计和质量要求非常高，相对而言，也可以接受相对较高的价格。<br /><br />B. 针对不同客户定制不同的开发信：<br />1. 每封开发信都是针对每个不同的客户的特殊情况定制的，并且针对关切点不同的客户，展示你不同的优势。例如，对于一个高度重视设计的客户，开发信就会展示你的原创设计能力。而对于一个价格极为敏感的客户，系统就会展示你的成本控制能力和产能等。<br />2. 除了系统提供的模板，你也可以写自己的模板。<br /><br />C. 需要你做我的设置：<br />1. 基本信息会出现在你的签名里<br />2. 公司优势非常重要，虽然有点烦，但这个是你脱颖而出的关键，只需设置一次，成功率可以大幅提升。<br />3. 推广产品：对比客户的产品范围，你可以选择你的不同产品推广给该客户。<br /><br />D. 发送邮件：为保证邮件的到达率，邮件是通过海外的专业邮件服务器发送的。客户收到的邮件显示发件人为你提供的邮箱。你可以输入一个你自己的邮箱，测试一下。（系统不支持给QQ邮箱发送邮件）<br /><br />E. 图片附件：我们采用的海外专业邮件发送服务器是知名邮件商，一般不会因为有插图片被客户服务器拒收。我们鼓励你在邮件里插入图片，这对于吸引海外买家完整阅读你的开发信很有帮助。</p>', NULL, '2016-05-27 06:30:23', 1, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `core_cache`
--

CREATE TABLE `core_cache` (
  `id` varchar(200) NOT NULL COMMENT 'Cache Id',
  `data` mediumblob COMMENT 'Cache Data',
  `create_time` int(11) DEFAULT NULL COMMENT 'Cache Creation Time',
  `update_time` int(11) DEFAULT NULL COMMENT 'Time of Cache Updating',
  `expire_time` int(11) DEFAULT NULL COMMENT 'Cache Expiration Time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Caches';

-- --------------------------------------------------------

--
-- 表的结构 `core_cache_option`
--

CREATE TABLE `core_cache_option` (
  `code` varchar(32) NOT NULL COMMENT 'Code',
  `value` smallint(6) DEFAULT NULL COMMENT 'Value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Cache Options';

--
-- 转存表中的数据 `core_cache_option`
--

INSERT INTO `core_cache_option` (`code`, `value`) VALUES
('block_html', 0),
('collections', 0),
('config', 0),
('layout', 0);

-- --------------------------------------------------------

--
-- 表的结构 `core_cache_tag`
--

CREATE TABLE `core_cache_tag` (
  `tag` varchar(100) NOT NULL COMMENT 'Tag',
  `cache_id` varchar(200) NOT NULL COMMENT 'Cache Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tag Caches';

-- --------------------------------------------------------

--
-- 表的结构 `core_config_data`
--

CREATE TABLE `core_config_data` (
  `config_id` int(10) UNSIGNED NOT NULL COMMENT 'Config Id',
  `path` varchar(255) NOT NULL DEFAULT 'general' COMMENT 'Config Path',
  `value` text COMMENT 'Config Value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Config Data';

--
-- 转存表中的数据 `core_config_data`
--

INSERT INTO `core_config_data` (`config_id`, `path`, `value`) VALUES
(9, 'web/unsecure/base_url', 'http://ioe9.com/'),
(10, 'web/secure/base_url', 'http://ioe9.com/'),
(16, 'design/head/default_title', '艾欧外贸云办公'),
(21, 'design/head/default_robots', 'INDEX,FOLLOW'),
(25, 'design/header/logo_alt', '艾欧外贸云办公'),
(26, 'system/csrf/use_form_key', '0'),
(27, 'ins/txt_analysis/stopword', 'a\r\nabout\r\nabove\r\nacross\r\nafter\r\nagain\r\nagainst\r\nall\r\nalmost\r\nalone\r\nalong\r\nalready\r\nalso\r\nalthough\r\nalways\r\namong\r\nan\r\nand\r\nanother\r\nany\r\nanybody\r\nanyone\r\nanything\r\nanywhere\r\nare\r\narea\r\nareas\r\naround\r\nas\r\nask\r\nasked\r\nasking\r\nasks\r\nat\r\naway\r\nb\r\nback\r\nbacked\r\nbacking\r\nbacks\r\nbe\r\nbecame\r\nbecause\r\nbecome\r\nbecomes\r\nbeen\r\nbefore\r\nbegan\r\nbehind\r\nbeing\r\nbeings\r\nbest\r\nbetter\r\nbetween\r\nbig\r\nboth\r\nbut\r\nby\r\nc\r\ncame\r\ncan\r\ncannot\r\ncase\r\ncases\r\ncertain\r\ncertainly\r\nclear\r\nclearly\r\ncome\r\ncould\r\nd\r\ndid\r\ndiffer\r\ndifferent\r\ndifferently\r\ndo\r\ndoes\r\ndone\r\ndown\r\ndown\r\ndowned\r\ndowning\r\ndowns\r\nduring\r\ne\r\neach\r\nearly\r\neither\r\nend\r\nended\r\nending\r\nends\r\nenough\r\neven\r\nevenly\r\never\r\nevery\r\neverybody\r\neveryone\r\neverything\r\neverywhere\r\nf\r\nface\r\nfaces\r\nfact\r\nfacts\r\nfar\r\nfelt\r\nfew\r\nfind\r\nfinds\r\nfirst\r\nfor\r\nfour\r\nfrom\r\nfull\r\nfully\r\nfurther\r\nfurthered\r\nfurthering\r\nfurthers\r\ng\r\ngave\r\ngeneral\r\ngenerally\r\nget\r\ngets\r\ngive\r\ngiven\r\ngives\r\ngo\r\ngoing\r\ngood\r\ngoods\r\ngot\r\ngreat\r\ngreater\r\ngreatest\r\ngroup\r\ngrouped\r\ngrouping\r\ngroups\r\nh\r\nhad\r\nhas\r\nhave\r\nhaving\r\nhe\r\nher\r\nhere\r\nherself\r\nhigh\r\nhigh\r\nhigh\r\nhigher\r\nhighest\r\nhim\r\nhimself\r\nhis\r\nhow\r\nhowever\r\ni\r\nif\r\nimportant\r\nin\r\ninterest\r\ninterested\r\ninteresting\r\ninterests\r\ninto\r\nis\r\nit\r\nits\r\nitself\r\nj\r\njust\r\nk\r\nkeep\r\nkeeps\r\nkind\r\nknew\r\nknow\r\nknown\r\nknows\r\nl\r\nlarge\r\nlargely\r\nlast\r\nlater\r\nlatest\r\nleast\r\nless\r\nlet\r\nlets\r\nlike\r\nlikely\r\nlong\r\nlonger\r\nlongest\r\nm\r\nmade\r\nmake\r\nmaking\r\nman\r\nmany\r\nmay\r\nme\r\nmember\r\nmembers\r\nmen\r\nmight\r\nmore\r\nmost\r\nmostly\r\nmr\r\nmrs\r\nmuch\r\nmust\r\nmy\r\nmyself\r\nn\r\nnecessary\r\nneed\r\nneeded\r\nneeding\r\nneeds\r\nnever\r\nnext\r\nno\r\nnobody\r\nnon\r\nnoone\r\nnot\r\nnothing\r\nnow\r\nnowhere\r\nnumber\r\nnumbers\r\no\r\nof\r\noff\r\noften\r\non\r\nonce\r\none\r\nonly\r\nopen\r\nopened\r\nopening\r\nopens\r\nor\r\norder\r\nordered\r\nordering\r\norders\r\nother\r\nothers\r\nour\r\nout\r\nover\r\np\r\npart\r\nparted\r\nparting\r\nparts\r\nper\r\nperhaps\r\nplace\r\nplaces\r\npoint\r\npointed\r\npointing\r\npoints\r\npossible\r\npresent\r\npresented\r\npresenting\r\npresents\r\nproblem\r\nproblems\r\nput\r\nputs\r\nq\r\nquite\r\nr\r\nrather\r\nreally\r\nright\r\nright\r\nroom\r\nrooms\r\ns\r\nsaid\r\nsame\r\nsaw\r\nsay\r\nsays\r\nsecond\r\nseconds\r\nsee\r\nseem\r\nseemed\r\nseeming\r\nseems\r\nsees\r\nseveral\r\nshall\r\nshe\r\nshould\r\nshow\r\nshowed\r\nshowing\r\nshows\r\nside\r\nsides\r\nsince\r\nsmall\r\nsmaller\r\nsmallest\r\nso\r\nsome\r\nsomebody\r\nsomeone\r\nsomething\r\nsomewhere\r\nstate\r\nstates\r\nstill\r\nstill\r\nsuch\r\nsure\r\nt\r\ntake\r\ntaken\r\nthan\r\nthat\r\nthe\r\ntheir\r\nthem\r\nthen\r\nthere\r\ntherefore\r\nthese\r\nthey\r\nthing\r\nthings\r\nthink\r\nthinks\r\nthis\r\nthose\r\nthough\r\nthought\r\nthoughts\r\nthree\r\nthrough\r\nthus\r\nto\r\ntoday\r\ntogether\r\ntoo\r\ntook\r\ntoward\r\nturn\r\nturned\r\nturning\r\nturns\r\ntwo\r\nu\r\nunder\r\nuntil\r\nup\r\nupon\r\nus\r\nuse\r\nused\r\nuses\r\nv\r\nvery\r\nw\r\nwant\r\nwanted\r\nwanting\r\nwants\r\nwas\r\nway\r\nways\r\nwe\r\nwell\r\nwells\r\nwent\r\nwere\r\nwhat\r\nwhen\r\nwhere\r\nwhether\r\nwhich\r\nwhile\r\nwho\r\nwhole\r\nwhose\r\nwhy\r\nwill\r\nwith\r\nwithin\r\nwithout\r\nwork\r\nworked\r\nworking\r\nworks\r\nwould\r\nx\r\ny\r\nyear\r\nyears\r\nyet\r\nyou\r\nyoung\r\nyounger\r\nyoungest\r\nyour\r\nyours\r\nz\r\na\r\na''s\r\nable\r\nabout\r\nabove\r\nabroad\r\naccording\r\naccordingly\r\nacross\r\nactually\r\nadj\r\nafter\r\nafterwards\r\nagain\r\nagainst\r\nago\r\nahead\r\nain''t\r\nall\r\nallow\r\nallows\r\nalmost\r\nalone\r\nalong\r\nalongside\r\nalready\r\nalso\r\nalthough\r\nalways\r\nam\r\namid\r\namidst\r\namong\r\namongst\r\nan\r\nand\r\nanother\r\nany\r\nanybody\r\nanyhow\r\nanyone\r\nanything\r\nanyway\r\nanyways\r\nanywhere\r\napart\r\nappear\r\nappreciate\r\nappropriate\r\nare\r\naren''t\r\naround\r\nas\r\naside\r\nask\r\nasking\r\nassociated\r\nat\r\navailable\r\naway\r\nawfully\r\nb\r\nback\r\nbackward\r\nbackwards\r\nbe\r\nbecame\r\nbecause\r\nbecome\r\nbecomes\r\nbecoming\r\nbeen\r\nbefore\r\nbeforehand\r\nbegin\r\nbehind\r\nbeing\r\nbelieve\r\nbelow\r\nbeside\r\nbesides\r\nbest\r\nbetter\r\nbetween\r\nbeyond\r\nboth\r\nbrief\r\nbut\r\nby\r\nc\r\nc''mon\r\nc''s\r\ncame\r\ncan\r\ncan''t\r\ncannot\r\ncant\r\ncaption\r\ncause\r\ncauses\r\ncertain\r\ncertainly\r\nchanges\r\nclearly\r\nco\r\nco.\r\ncom\r\ncome\r\ncomes\r\nconcerning\r\nconsequently\r\nconsider\r\nconsidering\r\ncontain\r\ncontaining\r\ncontains\r\ncorresponding\r\ncould\r\ncouldn''t\r\ncourse\r\ncurrently\r\nd\r\ndare\r\ndaren''t\r\ndefinitely\r\ndescribed\r\ndespite\r\ndid\r\ndidn''t\r\ndifferent\r\ndirectly\r\ndo\r\ndoes\r\ndoesn''t\r\ndoing\r\ndon''t\r\ndone\r\ndown\r\ndownwards\r\nduring\r\ne\r\neach\r\nedu\r\neg\r\neight\r\neighty\r\neither\r\nelse\r\nelsewhere\r\nend\r\nending\r\nenough\r\nentirely\r\nespecially\r\net\r\netc\r\neven\r\never\r\nevermore\r\nevery\r\neverybody\r\neveryone\r\neverything\r\neverywhere\r\nex\r\nexactly\r\nexample\r\nexcept\r\nf\r\nfairly\r\nfar\r\nfarther\r\nfew\r\nfewer\r\nfifth\r\nfirst\r\nfive\r\nfollowed\r\nfollowing\r\nfollows\r\nfor\r\nforever\r\nformer\r\nformerly\r\nforth\r\nforward\r\nfound\r\nfour\r\nfrom\r\nfurther\r\nfurthermore\r\ng\r\nget\r\ngets\r\ngetting\r\ngiven\r\ngives\r\ngo\r\ngoes\r\ngoing\r\ngone\r\ngot\r\ngotten\r\ngreetings\r\nh\r\nhad\r\nhadn''t\r\nhalf\r\nhappens\r\nhardly\r\nhas\r\nhasn''t\r\nhave\r\nhaven''t\r\nhaving\r\nhe\r\nhe''d\r\nhe''ll\r\nhe''s\r\nhello\r\nhelp\r\nhence\r\nher\r\nhere\r\nhere''s\r\nhereafter\r\nhereby\r\nherein\r\nhereupon\r\nhers\r\nherself\r\nhi\r\nhim\r\nhimself\r\nhis\r\nhither\r\nhopefully\r\nhow\r\nhowbeit\r\nhowever\r\nhundred\r\ni\r\ni''d\r\ni''ll\r\ni''m\r\ni''ve\r\nie\r\nif\r\nignored\r\nimmediate\r\nin\r\ninasmuch\r\ninc\r\ninc.\r\nindeed\r\nindicate\r\nindicated\r\nindicates\r\ninner\r\ninside\r\ninsofar\r\ninstead\r\ninto\r\ninward\r\nis\r\nisn''t\r\nit\r\nit''d\r\nit''ll\r\nit''s\r\nits\r\nitself\r\nj\r\njust\r\nk\r\nkeep\r\nkeeps\r\nkept\r\nknow\r\nknown\r\nknows\r\nl\r\nlast\r\nlately\r\nlater\r\nlatter\r\nlatterly\r\nleast\r\nless\r\nlest\r\nlet\r\nlet''s\r\nlike\r\nliked\r\nlikely\r\nlikewise\r\nlittle\r\nlook\r\nlooking\r\nlooks\r\nlow\r\nlower\r\nltd\r\nm\r\nmade\r\nmainly\r\nmake\r\nmakes\r\nmany\r\nmay\r\nmaybe\r\nmayn''t\r\nme\r\nmean\r\nmeantime\r\nmeanwhile\r\nmerely\r\nmight\r\nmightn''t\r\nmine\r\nminus\r\nmiss\r\nmore\r\nmoreover\r\nmost\r\nmostly\r\nmr\r\nmrs\r\nmuch\r\nmust\r\nmustn''t\r\nmy\r\nmyself\r\nn\r\nname\r\nnamely\r\nnd\r\nnear\r\nnearly\r\nnecessary\r\nneed\r\nneedn''t\r\nneeds\r\nneither\r\nnever\r\nneverf\r\nneverless\r\nnevertheless\r\nnew\r\nnext\r\nnine\r\nninety\r\nno\r\nno-one\r\nnobody\r\nnon\r\nnone\r\nnonetheless\r\nnoone\r\nnor\r\nnormally\r\nnot\r\nnothing\r\nnotwithstanding\r\nnovel\r\nnow\r\nnowhere\r\no\r\nobviously\r\nof\r\noff\r\noften\r\noh\r\nok\r\nokay\r\nold\r\non\r\nonce\r\none\r\none''s\r\nones\r\nonly\r\nonto\r\nopposite\r\nor\r\nother\r\nothers\r\notherwise\r\nought\r\noughtn''t\r\nour\r\nours\r\nourselves\r\nout\r\noutside\r\nover\r\noverall\r\nown\r\np\r\nparticular\r\nparticularly\r\npast\r\nper\r\nperhaps\r\nplaced\r\nplease\r\nplus\r\npossible\r\npresumably\r\nprobably\r\nprovided\r\nprovides\r\nq\r\nque\r\nquite\r\nqv\r\nr\r\nrather\r\nrd\r\nre\r\nreally\r\nreasonably\r\nrecent\r\nrecently\r\nregarding\r\nregardless\r\nregards\r\nrelatively\r\nrespectively\r\nright\r\nround\r\ns\r\nsaid\r\nsame\r\nsaw\r\nsay\r\nsaying\r\nsays\r\nsecond\r\nsecondly\r\nsee\r\nseeing\r\nseem\r\nseemed\r\nseeming\r\nseems\r\nseen\r\nself\r\nselves\r\nsensible\r\nsent\r\nserious\r\nseriously\r\nseven\r\nseveral\r\nshall\r\nshan''t\r\nshe\r\nshe''d\r\nshe''ll\r\nshe''s\r\nshould\r\nshouldn''t\r\nsince\r\nsix\r\nso\r\nsome\r\nsomebody\r\nsomeday\r\nsomehow\r\nsomeone\r\nsomething\r\nsometime\r\nsometimes\r\nsomewhat\r\nsomewhere\r\nsoon\r\nsorry\r\nspecified\r\nspecify\r\nspecifying\r\nstill\r\nsub\r\nsuch\r\nsup\r\nsure\r\nt\r\nt''s\r\ntake\r\ntaken\r\ntaking\r\ntell\r\ntends\r\nth\r\nthan\r\nthank\r\nthanks\r\nthanx\r\nthat\r\nthat''ll\r\nthat''s\r\nthat''ve\r\nthats\r\nthe\r\ntheir\r\ntheirs\r\nthem\r\nthemselves\r\nthen\r\nthence\r\nthere\r\nthere''d\r\nthere''ll\r\nthere''re\r\nthere''s\r\nthere''ve\r\nthereafter\r\nthereby\r\ntherefore\r\ntherein\r\ntheres\r\nthereupon\r\nthese\r\nthey\r\nthey''d\r\nthey''ll\r\nthey''re\r\nthey''ve\r\nthing\r\nthings\r\nthink\r\nthird\r\nthirty\r\nthis\r\nthorough\r\nthoroughly\r\nthose\r\nthough\r\nthree\r\nthrough\r\nthroughout\r\nthru\r\nthus\r\ntill\r\nto\r\ntogether\r\ntoo\r\ntook\r\ntoward\r\ntowards\r\ntried\r\ntries\r\ntruly\r\ntry\r\ntrying\r\ntwice\r\ntwo\r\nu\r\nun\r\nunder\r\nunderneath\r\nundoing\r\nunfortunately\r\nunless\r\nunlike\r\nunlikely\r\nuntil\r\nunto\r\nup\r\nupon\r\nupwards\r\nus\r\nuse\r\nused\r\nuseful\r\nuses\r\nusing\r\nusually\r\nv\r\nvalue\r\nvarious\r\nversus\r\nvery\r\nvia\r\nviz\r\nvs\r\nw\r\nwant\r\nwants\r\nwas\r\nwasn''t\r\nway\r\nwe\r\nwe''d\r\nwe''ll\r\nwe''re\r\nwe''ve\r\nwelcome\r\nwell\r\nwent\r\nwere\r\nweren''t\r\nwhat\r\nwhat''ll\r\nwhat''s\r\nwhat''ve\r\nwhatever\r\nwhen\r\nwhence\r\nwhenever\r\nwhere\r\nwhere''s\r\nwhereafter\r\nwhereas\r\nwhereby\r\nwherein\r\nwhereupon\r\nwherever\r\nwhether\r\nwhich\r\nwhichever\r\nwhile\r\nwhilst\r\nwhither\r\nwho\r\nwho''d\r\nwho''ll\r\nwho''s\r\nwhoever\r\nwhole\r\nwhom\r\nwhomever\r\nwhose\r\nwhy\r\nwill\r\nwilling\r\nwish\r\nwith\r\nwithin\r\nwithout\r\nwon''t\r\nwonder\r\nwould\r\nwouldn''t\r\nx\r\ny\r\nyes\r\nyet\r\nyou\r\nyou''d\r\nyou''ll\r\nyou''re\r\nyou''ve\r\nyour\r\nyours\r\nyourself\r\nyourselves\r\nz\r\nzero'),
(28, 'admin/emails/forgot_email_template', 'admin_emails_forgot_email_template'),
(29, 'admin/emails/forgot_email_identity', 'general'),
(30, 'admin/startup/page', NULL),
(31, 'system/smtp/host', 'smtp.exmail.qq.com'),
(32, 'system/smtp/port', '465'),
(33, 'system/smtp/disable', '0'),
(36, 'system/smtp/username', 'cs@ioe6.com'),
(37, 'system/smtp/password', 'Yang1984'),
(41, 'trans_email/ident_general/name', '艾欧外贸云办公'),
(42, 'trans_email/ident_general/email', 'cs@ioe6.com');

-- --------------------------------------------------------

--
-- 表的结构 `core_email_template`
--

CREATE TABLE `core_email_template` (
  `template_id` int(10) UNSIGNED NOT NULL COMMENT 'Template Id',
  `template_code` varchar(150) NOT NULL COMMENT 'Template Name',
  `template_text` text NOT NULL COMMENT 'Template Content',
  `template_styles` text COMMENT 'Templste Styles',
  `template_type` int(10) UNSIGNED DEFAULT NULL COMMENT 'Template Type',
  `template_subject` varchar(200) NOT NULL COMMENT 'Template Subject',
  `template_sender_name` varchar(200) DEFAULT NULL COMMENT 'Template Sender Name',
  `template_sender_email` varchar(200) DEFAULT NULL COMMENT 'Template Sender Email',
  `added_at` timestamp NULL DEFAULT NULL COMMENT 'Date of Template Creation',
  `modified_at` timestamp NULL DEFAULT NULL COMMENT 'Date of Template Modification',
  `orig_template_code` varchar(200) DEFAULT NULL COMMENT 'Original Template Code',
  `orig_template_variables` text COMMENT 'Original Template Variables'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Email Templates';

-- --------------------------------------------------------

--
-- 表的结构 `core_layout_link`
--

CREATE TABLE `core_layout_link` (
  `layout_link_id` int(10) UNSIGNED NOT NULL COMMENT 'Link Id',
  `area` varchar(64) DEFAULT NULL COMMENT 'Area',
  `package` varchar(64) DEFAULT NULL COMMENT 'Package',
  `theme` varchar(64) DEFAULT NULL COMMENT 'Theme',
  `layout_update_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Layout Update Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Layout Link';

-- --------------------------------------------------------

--
-- 表的结构 `core_layout_update`
--

CREATE TABLE `core_layout_update` (
  `layout_update_id` int(10) UNSIGNED NOT NULL COMMENT 'Layout Update Id',
  `handle` varchar(255) DEFAULT NULL COMMENT 'Handle',
  `xml` text COMMENT 'Xml',
  `sort_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Sort Order'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Layout Updates';

-- --------------------------------------------------------

--
-- 表的结构 `core_resource`
--

CREATE TABLE `core_resource` (
  `code` varchar(50) NOT NULL COMMENT 'Resource Code',
  `version` varchar(50) DEFAULT NULL COMMENT 'Resource Version',
  `data_version` varchar(50) DEFAULT NULL COMMENT 'Data Version'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Resources';

-- --------------------------------------------------------

--
-- 表的结构 `core_session`
--

CREATE TABLE `core_session` (
  `session_id` varchar(255) NOT NULL COMMENT 'Session Id',
  `session_expires` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Date of Session Expiration',
  `session_data` mediumblob NOT NULL COMMENT 'Session Data'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Database Sessions Storage';

-- --------------------------------------------------------

--
-- 表的结构 `core_url_rewrite`
--

CREATE TABLE `core_url_rewrite` (
  `url_rewrite_id` int(10) UNSIGNED NOT NULL COMMENT 'Rewrite Id',
  `id_path` varchar(255) DEFAULT NULL COMMENT 'Id Path',
  `request_path` varchar(255) DEFAULT NULL COMMENT 'Request Path',
  `target_path` varchar(255) DEFAULT NULL COMMENT 'Target Path',
  `is_system` smallint(5) UNSIGNED DEFAULT '1' COMMENT 'Defines is Rewrite System',
  `options` varchar(255) DEFAULT NULL COMMENT 'Options',
  `description` varchar(255) DEFAULT NULL COMMENT 'Deascription',
  `category_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Category Id',
  `product_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'Product Id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Url Rewrites';

-- --------------------------------------------------------

--
-- 表的结构 `core_variable`
--

CREATE TABLE `core_variable` (
  `variable_id` int(10) UNSIGNED NOT NULL COMMENT 'Variable Id',
  `code` varchar(255) DEFAULT NULL COMMENT 'Variable Code',
  `name` varchar(255) DEFAULT NULL COMMENT 'Variable Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Variables';

-- --------------------------------------------------------

--
-- 表的结构 `core_variable_value`
--

CREATE TABLE `core_variable_value` (
  `value_id` int(10) UNSIGNED NOT NULL COMMENT 'Variable Value Id',
  `variable_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Variable Id',
  `plain_value` text COMMENT 'Plain Text Value',
  `html_value` text COMMENT 'Html Value'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Variable Value';

-- --------------------------------------------------------

--
-- 表的结构 `crm_activity`
--

CREATE TABLE `crm_activity` (
  `activity_id` int(11) UNSIGNED NOT NULL,
  `charge` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `charge_team` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `address` text,
  `type` smallint(6) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `cost_plan` decimal(12,2) NOT NULL DEFAULT '0.00',
  `cost_real` decimal(12,2) NOT NULL DEFAULT '0.00',
  `income_plan` decimal(12,2) NOT NULL DEFAULT '0.00',
  `income_real` decimal(12,2) NOT NULL DEFAULT '0.00',
  `plan_desc` text,
  `result` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `crm_chance`
--

CREATE TABLE `crm_chance` (
  `chance_id` int(11) UNSIGNED NOT NULL,
  `chance_name` varchar(25) NOT NULL,
  `chance_charge` varchar(255) DEFAULT NULL,
  `chance_charge_team` smallint(6) NOT NULL DEFAULT '0',
  `chance_client` int(11) NOT NULL DEFAULT '0',
  `chance_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `chance_deal_date` datetime DEFAULT NULL,
  `chance_status` smallint(6) NOT NULL DEFAULT '0',
  `chance_product` varchar(255) DEFAULT NULL,
  `chance_activity` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `chance_level` smallint(6) NOT NULL,
  `chance_source` smallint(6) UNSIGNED DEFAULT '0',
  `chance_memo` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `crm_client`
--

CREATE TABLE `crm_client` (
  `client_id` int(11) UNSIGNED NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_charge` varchar(255) DEFAULT NULL COMMENT '负责人',
  `website` varchar(255) DEFAULT NULL,
  `country` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `province` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL COMMENT 'Linkedin账号',
  `facebook` varchar(255) DEFAULT NULL COMMENT 'facebook账号',
  `memo` text,
  `department` varchar(255) DEFAULT NULL COMMENT '所属部门',
  `client_level` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客户级别',
  `client_parent` varchar(255) DEFAULT NULL COMMENT '上级客户',
  `client_source` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客户来源',
  `client_status` smallint(6) NOT NULL DEFAULT '0' COMMENT '客户状态',
  `industry` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属行业',
  `product` text,
  `staff_total` smallint(6) NOT NULL DEFAULT '0',
  `sales_volume` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '销售额',
  `date_create` datetime DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `crm_clue`
--

CREATE TABLE `crm_clue` (
  `clue_id` int(11) UNSIGNED NOT NULL,
  `clue_name` varchar(255) NOT NULL,
  `clue_charge` varchar(255) DEFAULT NULL,
  `clue_charge_team` smallint(6) NOT NULL DEFAULT '0',
  `clue_telephone` varchar(100) DEFAULT NULL,
  `clue_company` varchar(255) NOT NULL,
  `clue_industry` tinyint(6) NOT NULL DEFAULT '0',
  `clue_product` varchar(255) DEFAULT NULL,
  `clue_gender` tinyint(2) NOT NULL DEFAULT '0',
  `clue_source` smallint(6) NOT NULL DEFAULT '0',
  `clue_department` varchar(255) DEFAULT NULL,
  `clue_position` varchar(255) DEFAULT NULL,
  `clue_skype` varchar(100) DEFAULT NULL,
  `clue_email` varchar(100) DEFAULT NULL,
  `clue_dob` date DEFAULT NULL,
  `clue_address` varchar(100) DEFAULT NULL,
  `clue_postcode` varchar(100) DEFAULT NULL,
  `clue_memo` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `crm_competitor`
--

CREATE TABLE `crm_competitor` (
  `comp_id` int(11) UNSIGNED NOT NULL,
  `comp_name` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `country` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `province` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `fax` varchar(100) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL COMMENT 'Linkedin账号',
  `facebook` varchar(255) DEFAULT NULL COMMENT 'facebook账号',
  `memo` text,
  `comp_level` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '对手级别',
  `comp_status` smallint(6) NOT NULL DEFAULT '0' COMMENT '对手状态',
  `industry` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属行业',
  `product` text,
  `staff_total` smallint(6) NOT NULL DEFAULT '0',
  `sales_volume` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '销售额',
  `date_create` datetime DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `crm_contact`
--

CREATE TABLE `crm_contact` (
  `contact_id` int(11) UNSIGNED NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_charge` varchar(255) DEFAULT NULL,
  `contact_charge_team` smallint(6) NOT NULL DEFAULT '0',
  `contact_client` int(11) NOT NULL DEFAULT '0' COMMENT '所属客户',
  `contact_role` smallint(6) NOT NULL DEFAULT '0',
  `contact_telephone` varchar(100) DEFAULT NULL,
  `contact_department` varchar(255) DEFAULT NULL,
  `contact_position` varchar(255) DEFAULT NULL,
  `contact_gender` tinyint(2) NOT NULL DEFAULT '0',
  `contact_mobile` varchar(100) DEFAULT NULL,
  `contact_skype` varchar(100) DEFAULT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_dob` date DEFAULT NULL,
  `contact_address` varchar(100) DEFAULT NULL,
  `contact_postcode` varchar(100) DEFAULT NULL,
  `contact_memo` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `crm_media`
--

CREATE TABLE `crm_media` (
  `media_id` int(11) NOT NULL,
  `media_path` varchar(255) NOT NULL,
  `media_name` varchar(255) DEFAULT NULL,
  `media_object_type` smallint(6) NOT NULL DEFAULT '0',
  `media_object` int(11) NOT NULL DEFAULT '0',
  `media_company` int(11) UNSIGNED DEFAULT '0',
  `media_user` int(11) UNSIGNED DEFAULT '0',
  `media_type` smallint(6) UNSIGNED DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `crm_order`
--

CREATE TABLE `crm_order` (
  `order_id` int(11) UNSIGNED NOT NULL,
  `order_name` varchar(255) NOT NULL,
  `outer_id` int(11) NOT NULL DEFAULT '0',
  `order_charge_team` int(11) NOT NULL DEFAULT '0',
  `order_charge` int(11) NOT NULL DEFAULT '0',
  `order_client` int(11) NOT NULL DEFAULT '0',
  `order_money` decimal(12,2) NOT NULL DEFAULT '0.00',
  `order_deal_date` datetime DEFAULT NULL,
  `order_product` varchar(255) DEFAULT NULL,
  `order_deliver_date` datetime DEFAULT NULL,
  `order_chance` int(11) NOT NULL DEFAULT '0',
  `order_activity` int(11) NOT NULL DEFAULT '0',
  `payment_method` smallint(6) NOT NULL DEFAULT '0',
  `order_status` tinyint(2) NOT NULL DEFAULT '0',
  `order_type` smallint(6) NOT NULL DEFAULT '0',
  `order_contact` varchar(255) DEFAULT NULL,
  `order_telephone` varchar(255) DEFAULT NULL,
  `order_memo` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_aff`
--

CREATE TABLE `edm_aff` (
  `aff_id` int(11) UNSIGNED NOT NULL,
  `aff_name` varchar(255) DEFAULT NULL,
  `aff_code` varchar(255) DEFAULT NULL,
  `count_limit` int(10) UNSIGNED DEFAULT '1' COMMENT '0 无限制',
  `count_used` int(10) UNSIGNED DEFAULT '0',
  `status` tinyint(2) UNSIGNED DEFAULT '1' COMMENT '状态 0暂停',
  `date_deadline` datetime DEFAULT NULL,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_article`
--

CREATE TABLE `edm_article` (
  `article_id` int(11) UNSIGNED NOT NULL,
  `outer_id` int(11) DEFAULT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_image` varchar(255) DEFAULT NULL,
  `article_sdesc` text,
  `article_desc` text,
  `article_wx` int(11) NOT NULL DEFAULT '0',
  `position` smallint(6) UNSIGNED DEFAULT '0',
  `is_hot` tinyint(2) UNSIGNED DEFAULT '0',
  `date_publish` datetime DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_article_category`
--

CREATE TABLE `edm_article_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `keyword` text,
  `desc` text,
  `level` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `position` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_article_wx`
--

CREATE TABLE `edm_article_wx` (
  `id` int(11) UNSIGNED NOT NULL,
  `outer_id` int(11) NOT NULL DEFAULT '0',
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sdesc` text,
  `url` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `position` int(10) NOT NULL DEFAULT '0',
  `is_hot` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_cert`
--

CREATE TABLE `edm_cert` (
  `cert_id` smallint(5) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(255) DEFAULT NULL,
  `syno_json` text COMMENT '同义词 JSON',
  `date_from` datetime DEFAULT NULL,
  `duration` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '有效期限 单位月',
  `position` int(10) UNSIGNED DEFAULT '0',
  `Weight` smallint(5) UNSIGNED NOT NULL DEFAULT '50' COMMENT '权重 0-100之间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client`
--

CREATE TABLE `edm_client` (
  `client_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` smallint(5) DEFAULT NULL,
  `industry_category` int(11) UNSIGNED DEFAULT NULL COMMENT '主行业分类',
  `email_domain` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `lang_first` varchar(10) DEFAULT NULL COMMENT '第一语言',
  `lang_second` varchar(10) DEFAULT NULL COMMENT '第二语言',
  `index_quality` smallint(5) NOT NULL DEFAULT '0',
  `index_price` smallint(5) NOT NULL DEFAULT '0',
  `index_design` smallint(5) NOT NULL DEFAULT '0',
  `index_service` smallint(5) DEFAULT '0',
  `index_delivery` smallint(5) DEFAULT '0',
  `scale_pro` varchar(255) DEFAULT NULL COMMENT '采购规模',
  `country` varchar(10) DEFAULT NULL,
  `province` int(10) DEFAULT NULL,
  `scale` varchar(255) DEFAULT NULL COMMENT '人数范围 500-1000',
  `gdp` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '年产值 单位 万',
  `keywords` text,
  `sdesc` text,
  `desc` text,
  `date_create` datetime DEFAULT NULL,
  `admin_only` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '仅管理员可见',
  `node_analysis_flag` tinyint(2) UNSIGNED DEFAULT '0' COMMENT 'node分析状态: 1分析结束'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户表';

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_attr`
--

CREATE TABLE `edm_client_attr` (
  `attr_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `attr_type` varchar(100) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `attr_json` mediumtext,
  `required` tinyint(2) DEFAULT '0',
  `visible_front` tinyint(2) DEFAULT '0',
  `date_create` int(11) DEFAULT '0',
  `enable_rule` tinyint(2) DEFAULT '0',
  `enable_template` tinyint(2) DEFAULT '0',
  `enable_advantage` tinyint(2) DEFAULT '0',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_attr_option`
--

CREATE TABLE `edm_client_attr_option` (
  `option_id` int(11) UNSIGNED NOT NULL,
  `attr_id` int(11) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_attr_value`
--

CREATE TABLE `edm_client_attr_value` (
  `value_id` bigint(20) NOT NULL,
  `attr_id` int(10) NOT NULL,
  `client_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_attr_value_copy`
--

CREATE TABLE `edm_client_attr_value_copy` (
  `value_id` bigint(20) NOT NULL,
  `attr_id` int(10) NOT NULL,
  `client_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_category`
--

CREATE TABLE `edm_client_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_email`
--

CREATE TABLE `edm_client_email` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(200) DEFAULT NULL,
  `source` smallint(5) UNSIGNED DEFAULT '0' COMMENT '来源 0:手工录入  1 whois 2 website 3 linkedin 4 google',
  `confirmed` char(1) DEFAULT '0',
  `confirmcode` varchar(32) DEFAULT NULL,
  `requestdate` int(11) DEFAULT '0',
  `requestip` varchar(20) DEFAULT NULL,
  `confirmdate` int(11) DEFAULT '0',
  `confirmip` varchar(20) DEFAULT NULL,
  `subscribedate` int(11) DEFAULT '0',
  `bounced` int(11) DEFAULT '0',
  `unsubscribed` int(11) DEFAULT '0',
  `unsubscribeconfirmed` char(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_email_attr`
--

CREATE TABLE `edm_client_email_attr` (
  `attr_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `attr_type` varchar(100) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `attr_json` mediumtext,
  `required` tinyint(2) DEFAULT '0',
  `visible_front` tinyint(2) DEFAULT '0',
  `date_create` int(11) DEFAULT '0',
  `enable_rule` tinyint(2) DEFAULT '0',
  `enable_template` tinyint(2) DEFAULT '0',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_email_attr_option`
--

CREATE TABLE `edm_client_email_attr_option` (
  `option_id` int(11) UNSIGNED NOT NULL,
  `attr_id` int(11) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_email_attr_value`
--

CREATE TABLE `edm_client_email_attr_value` (
  `value_id` bigint(20) NOT NULL,
  `attr_id` int(10) NOT NULL,
  `email_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_rule`
--

CREATE TABLE `edm_client_rule` (
  `rule_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `admin_user` int(11) NOT NULL,
  `email_notice` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `desc` text,
  `pagetype` varchar(255) DEFAULT NULL,
  `conditions` mediumtext COMMENT 'Conditions Serialized',
  `actions` mediumtext COMMENT 'Actions Serialized',
  `stop_rules_processing` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Stop Rules Processing',
  `config` text,
  `use_stemmer` tinyint(2) DEFAULT '0',
  `use_stopword` tinyint(2) UNSIGNED DEFAULT '0',
  `custom_stopword` text,
  `is_system` tinyint(2) DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_rule_pagetype`
--

CREATE TABLE `edm_client_rule_pagetype` (
  `type_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `desc` text,
  `node_rule` text COMMENT 'Nodejs 识别的规则',
  `conditions` mediumtext COMMENT '识别规则',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_rule_variable`
--

CREATE TABLE `edm_client_rule_variable` (
  `variable_id` int(10) UNSIGNED NOT NULL COMMENT 'Variable Id',
  `name` varchar(255) DEFAULT NULL COMMENT 'Variable Name',
  `model` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `is_system` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `match_level` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '匹配级别 0:任一匹配 1:短语匹配 2:完全匹配',
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='规则变量表';

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_temp`
--

CREATE TABLE `edm_client_temp` (
  `client_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` smallint(5) DEFAULT NULL,
  `keywords` text COMMENT '主行业分类',
  `email_domain` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `lang_first` varchar(10) DEFAULT NULL COMMENT '第一语言',
  `lang_second` varchar(10) DEFAULT NULL COMMENT '第二语言',
  `index_quality` smallint(5) NOT NULL DEFAULT '0',
  `index_price` smallint(5) NOT NULL DEFAULT '0',
  `index_design` smallint(5) NOT NULL DEFAULT '0',
  `index_service` smallint(5) DEFAULT '0',
  `index_delivery` smallint(5) DEFAULT '0',
  `scale_pro` varchar(255) DEFAULT NULL COMMENT '采购规模',
  `country` varchar(10) DEFAULT NULL,
  `province` int(10) DEFAULT NULL,
  `scale` varchar(255) DEFAULT NULL COMMENT '人数范围 500-1000',
  `gdp` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '年产值 单位 万',
  `sdesc` text,
  `desc` text,
  `date_create` datetime DEFAULT NULL,
  `admin_only` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '仅管理员可见',
  `node_analysis_flag` tinyint(2) UNSIGNED DEFAULT '0' COMMENT 'node分析状态: 1分析结束',
  `whois_flag` tinyint(2) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客户表';

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_text_rule`
--

CREATE TABLE `edm_client_text_rule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rule_id` int(11) NOT NULL,
  `text_id` int(11) NOT NULL,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_client_text_tmp`
--

CREATE TABLE `edm_client_text_tmp` (
  `text_id` int(11) UNSIGNED NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_advantage`
--

CREATE TABLE `edm_company_advantage` (
  `advantage_id` int(10) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `advantage_type` varchar(100) DEFAULT NULL,
  `tips` varchar(255) DEFAULT NULL,
  `optional_content` text,
  `default_value` varchar(255) DEFAULT NULL,
  `advantage_json` mediumtext,
  `enable_image` tinyint(2) UNSIGNED DEFAULT '0',
  `count_image` smallint(6) UNSIGNED DEFAULT '1',
  `all_content` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '是否填写全文',
  `required` tinyint(2) DEFAULT '0',
  `visible_front` tinyint(2) DEFAULT '0',
  `date_create` int(11) DEFAULT '0',
  `enable_scope` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '使用范围 0优势模块 1非优势模块',
  `enable_rule` tinyint(2) DEFAULT '0',
  `enable_template` tinyint(2) DEFAULT '0',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_advantage_attrvalue`
--

CREATE TABLE `edm_company_advantage_attrvalue` (
  `value_id` bigint(20) NOT NULL,
  `attr_id` int(10) NOT NULL,
  `advantage_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_advantage_image`
--

CREATE TABLE `edm_company_advantage_image` (
  `image_id` bigint(20) NOT NULL,
  `advantage_id` int(10) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_advantage_option`
--

CREATE TABLE `edm_company_advantage_option` (
  `option_id` int(11) UNSIGNED NOT NULL,
  `advantage_id` int(11) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_advantage_value`
--

CREATE TABLE `edm_company_advantage_value` (
  `value_id` bigint(20) NOT NULL,
  `advantage_id` int(10) NOT NULL,
  `company_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_attr`
--

CREATE TABLE `edm_company_attr` (
  `attr_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `attr_type` varchar(100) DEFAULT NULL,
  `default_value` varchar(255) DEFAULT NULL,
  `attr_json` mediumtext,
  `required` tinyint(2) DEFAULT '0',
  `visible_front` tinyint(2) DEFAULT '0',
  `date_create` int(11) DEFAULT '0',
  `enable_category` tinyint(2) DEFAULT '0' COMMENT '是否允许细分到分类',
  `enable_rule` tinyint(2) DEFAULT '0',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_attr_value`
--

CREATE TABLE `edm_company_attr_value` (
  `value_id` bigint(20) NOT NULL,
  `attr_id` int(10) NOT NULL,
  `company_id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED DEFAULT '0' COMMENT '指定分类的说明',
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_category`
--

CREATE TABLE `edm_company_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_cert`
--

CREATE TABLE `edm_company_cert` (
  `cert_id` int(11) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `desc` text,
  `cert_json` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_client`
--

CREATE TABLE `edm_company_client` (
  `id` int(11) UNSIGNED NOT NULL,
  `company_id` int(11) UNSIGNED DEFAULT '0',
  `client_id` int(11) UNSIGNED DEFAULT '0',
  `keywords` text,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `data` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_client_category`
--

CREATE TABLE `edm_company_client_category` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `company_id` int(11) DEFAULT '0',
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父分类 0顶级分类',
  `level` smallint(6) UNSIGNED DEFAULT '0' COMMENT '层级0为一级1为二级',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `desc` text,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 0未启用 1启用',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_client_category_relate`
--

CREATE TABLE `edm_company_client_category_relate` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT '0',
  `client_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_client_email`
--

CREATE TABLE `edm_company_client_email` (
  `id` int(11) NOT NULL,
  `email_client` int(11) NOT NULL DEFAULT '0',
  `email_company` int(11) NOT NULL DEFAULT '0',
  `email` varchar(200) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `source` smallint(5) UNSIGNED DEFAULT '0' COMMENT '来源 0:手工录入 1 系统COPY',
  `memo` varchar(0) DEFAULT NULL,
  `count_send` smallint(6) DEFAULT '0',
  `unsubscribe` tinyint(2) DEFAULT '0',
  `date_latest` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_draft`
--

CREATE TABLE `edm_company_draft` (
  `draft_id` int(11) UNSIGNED NOT NULL,
  `draft_name` varchar(255) DEFAULT NULL,
  `draft_user` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `draft_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `draft_content` text,
  `draft_config` text,
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `is_system` tinyint(2) UNSIGNED DEFAULT '0',
  `status` tinyint(2) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_email`
--

CREATE TABLE `edm_company_email` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(200) DEFAULT NULL,
  `unsubscribed` smallint(5) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_email_send`
--

CREATE TABLE `edm_company_email_send` (
  `send_id` bigint(20) UNSIGNED NOT NULL,
  `mid` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) UNSIGNED DEFAULT NULL,
  `email_from` varchar(255) DEFAULT NULL,
  `email_to` varchar(255) DEFAULT NULL,
  `esp_server` varchar(255) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  `email_content` text,
  `send_status` smallint(5) DEFAULT '0' COMMENT '队列状态 1发送中 2已发送',
  `event_reject` smallint(5) NOT NULL DEFAULT '0',
  `event_delivered` smallint(5) NOT NULL DEFAULT '0',
  `event_dropped` smallint(5) NOT NULL DEFAULT '0',
  `event_bounced` smallint(5) NOT NULL DEFAULT '0',
  `event_failed` smallint(5) NOT NULL DEFAULT '0',
  `event_complaine` smallint(5) NOT NULL DEFAULT '0',
  `event_unsubcribe` smallint(5) NOT NULL DEFAULT '0',
  `event_click` smallint(5) NOT NULL DEFAULT '0',
  `event_open` smallint(5) NOT NULL DEFAULT '0',
  `event_send` smallint(5) NOT NULL DEFAULT '0',
  `date_event` datetime DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_group`
--

CREATE TABLE `edm_company_group` (
  `group_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `desc` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_keyword`
--

CREATE TABLE `edm_company_keyword` (
  `keyword_id` int(11) UNSIGNED NOT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `company_id` int(11) UNSIGNED DEFAULT '0',
  `user_id` int(11) UNSIGNED DEFAULT '0',
  `position` int(10) UNSIGNED DEFAULT '0',
  `is_active` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '是否提交关键字搜URL',
  `status` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '搜索URL 状态',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_keyword_url`
--

CREATE TABLE `edm_company_keyword_url` (
  `url_id` int(11) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL COMMENT '关键字名称',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_media`
--

CREATE TABLE `edm_company_media` (
  `media_id` int(11) UNSIGNED NOT NULL,
  `type` smallint(5) UNSIGNED DEFAULT '0',
  `path` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `company_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL,
  `status` tinyint(2) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_media_category`
--

CREATE TABLE `edm_company_media_category` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` smallint(5) DEFAULT NULL,
  `company_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_media_category_relate`
--

CREATE TABLE `edm_company_media_category_relate` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED DEFAULT '0',
  `media_id` int(11) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_template`
--

CREATE TABLE `edm_company_template` (
  `template_id` int(11) NOT NULL,
  `template_company` int(11) NOT NULL DEFAULT '0',
  `template_user` int(11) DEFAULT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `template_parent` int(11) UNSIGNED DEFAULT NULL,
  `template_body` text COMMENT '模版的组织方式',
  `date_create` datetime DEFAULT NULL,
  `memo` text,
  `is_mark` tinyint(2) DEFAULT '0' COMMENT '是否标星',
  `is_system` tinyint(2) DEFAULT '0',
  `is_global` tinyint(2) DEFAULT '0',
  `status` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_template_draft`
--

CREATE TABLE `edm_company_template_draft` (
  `draft_id` int(11) NOT NULL,
  `draft_company` int(11) NOT NULL DEFAULT '0',
  `draft_user` int(11) DEFAULT NULL,
  `draft_name` varchar(255) DEFAULT NULL,
  `draft_receipts` text,
  `format` char(1) DEFAULT NULL,
  `textbody` longtext,
  `htmlbody` longtext,
  `date_create` int(11) DEFAULT '0',
  `memo` text,
  `status` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='保存草稿';

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_template_module`
--

CREATE TABLE `edm_company_template_module` (
  `module_id` int(11) UNSIGNED NOT NULL COMMENT 'Id',
  `module_name` varchar(255) DEFAULT NULL COMMENT '模块名称',
  `module_template` int(11) DEFAULT '0',
  `module_company` int(11) DEFAULT '0',
  `memo` text,
  `status` tinyint(2) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模版模块';

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_template_module_item`
--

CREATE TABLE `edm_company_template_module_item` (
  `item_id` int(11) UNSIGNED NOT NULL COMMENT 'Id',
  `item_parent` int(11) UNSIGNED DEFAULT '0' COMMENT '非0时强制应用父Item的关联关系',
  `item_module` int(11) UNSIGNED NOT NULL,
  `item_company` int(11) UNSIGNED NOT NULL,
  `item_template` int(11) UNSIGNED DEFAULT '0',
  `item_content` text COMMENT '内容',
  `status` tinyint(2) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模块项';

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_template_module_item_attrvalue`
--

CREATE TABLE `edm_company_template_module_item_attrvalue` (
  `value_id` bigint(20) NOT NULL,
  `attr_id` int(10) NOT NULL,
  `item_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_company_template_module_item_relate`
--

CREATE TABLE `edm_company_template_module_item_relate` (
  `relate_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `item_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_config_settings`
--

CREATE TABLE `edm_config_settings` (
  `area` varchar(255) DEFAULT NULL,
  `areavalue` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_country`
--

CREATE TABLE `edm_country` (
  `country_id` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_email_validate`
--

CREATE TABLE `edm_email_validate` (
  `validate_id` int(11) UNSIGNED NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL COMMENT '0',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '权重大的优先验证',
  `validate_times` smallint(5) UNSIGNED DEFAULT '0' COMMENT '验证次数',
  `validate_code` varchar(100) DEFAULT NULL COMMENT '上次验证返回码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_email_white`
--

CREATE TABLE `edm_email_white` (
  `white_id` int(11) UNSIGNED NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `count_click` int(10) NOT NULL DEFAULT '0',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_esp`
--

CREATE TABLE `edm_esp` (
  `esp_id` smallint(5) UNSIGNED NOT NULL,
  `esp_name` varchar(255) DEFAULT NULL,
  `limit_hour` int(10) DEFAULT '0' COMMENT '0 不限',
  `limit_day` int(10) DEFAULT '0' COMMENT '0 不限',
  `limit_week` int(10) DEFAULT '0' COMMENT '0 不限',
  `limit_month` int(10) DEFAULT '0' COMMENT '0 不限'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_esp`
--

INSERT INTO `edm_esp` (`esp_id`, `esp_name`, `limit_hour`, `limit_day`, `limit_week`, `limit_month`) VALUES
(1, '@qq.com', 100, 0, 0, 0),
(2, '@google.com', 100, 0, 0, 0),
(3, '@163.com', 100, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `edm_feedback`
--

CREATE TABLE `edm_feedback` (
  `feedback_id` int(11) UNSIGNED NOT NULL,
  `feedback_company` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `feedback_content` text,
  `feedback_reply` text,
  `feedback_status` tinyint(2) DEFAULT '0' COMMENT '状态 0 未回复 1已回复 -1不做处理',
  `date_reply` datetime DEFAULT NULL,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_feedback`
--

INSERT INTO `edm_feedback` (`feedback_id`, `feedback_company`, `title`, `image`, `feedback_content`, `feedback_reply`, `feedback_status`, `date_reply`, `date_create`) VALUES
(1, 20, NULL, 'feedback/2016052504551005215.png', '搜索太慢了，能不能优化一下', NULL, 0, NULL, '2016-05-25 04:55:10'),
(2, 33, NULL, 'feedback/2016052602441107975.jpg', '这个地方需要做一个排除，这个抓到的是域名隐私保护的Admin的信息。', NULL, 0, NULL, '2016-05-26 02:44:11'),
(3, 1, '我的账号邮件发不出去，好奇怪', NULL, '我的账号邮件发不出去，好奇怪', NULL, 0, NULL, '2016-10-22 02:26:50'),
(4, 1, '生成的邮件模板质量不是很高', 'feedback/2016102202281604692.jpg', '生成的邮件模板质量不是很高', NULL, 0, NULL, '2016-10-22 02:28:16'),
(5, 1, '无法统计我一天发了多少邮件', 'feedback/2016102202590201227.jpg', '无法统计我一天发了多少邮件', NULL, 0, NULL, '2016-10-22 02:59:02');

-- --------------------------------------------------------

--
-- 表的结构 `edm_product`
--

CREATE TABLE `edm_product` (
  `product_id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `category_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属分类ID 0未归类',
  `company_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属公司 0表示管理员',
  `sku` varchar(64) DEFAULT NULL COMMENT 'SKU',
  `name` varchar(255) NOT NULL COMMENT 'Name',
  `image` varchar(255) DEFAULT NULL,
  `small_image` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `sdesc` text,
  `desc` text,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `special_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `keywords` text,
  `url` varchar(255) DEFAULT NULL COMMENT '站外',
  `position` int(10) UNSIGNED DEFAULT '0',
  `free_shipping` smallint(6) NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL COMMENT 'Creation Time',
  `date_update` datetime DEFAULT NULL COMMENT 'Update Time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表';

--
-- 转存表中的数据 `edm_product`
--

INSERT INTO `edm_product` (`product_id`, `category_id`, `company_id`, `sku`, `name`, `image`, `small_image`, `status`, `sdesc`, `desc`, `price`, `special_price`, `keywords`, `url`, `position`, `free_shipping`, `date_create`, `date_update`) VALUES
(1, 0, 0, 'fdfasd', '强大外贸跟进邮件九节鞭--详细解读外贸跟进邮件的九个要素', 'media/wysiwyg/product/2016051612223208372.jpg', NULL, 0, 'dafsdsdfd', 'fadfadsfads', '33.00', '22.00', NULL, '0', 0, 0, '2016-05-16 12:22:32', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `edm_product_category`
--

CREATE TABLE `edm_product_category` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `syn_name` text,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父分类 0顶级分类',
  `level` smallint(6) UNSIGNED DEFAULT '0' COMMENT '层级0为一级1为二级',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `desc` text,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 0未启用 1启用',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_product_category`
--

INSERT INTO `edm_product_category` (`category_id`, `name`, `syn_name`, `parent_id`, `level`, `position`, `desc`, `status`, `date_create`) VALUES
(1, 'Agriculture & Food', NULL, 0, 0, 0, NULL, 1, NULL),
(2, 'Apparel,Textiles & Accessories', NULL, 0, 0, 0, NULL, 1, NULL),
(3, 'Auto & Transportation', NULL, 0, 0, 0, NULL, 1, NULL),
(4, 'Bags, Shoes & Accessories', NULL, 0, 0, 0, NULL, 1, NULL),
(5, 'Electronics', NULL, 0, 0, 0, NULL, 1, NULL),
(6, 'Electrical Equipment, Components & Telecoms', NULL, 0, 0, 0, NULL, 1, NULL),
(7, 'Gifts, Sports & Toys', NULL, 0, 0, 0, NULL, 1, NULL),
(8, 'Health & Beauty', NULL, 0, 0, 0, NULL, 1, NULL),
(9, 'Home, Lights & Construction', NULL, 0, 0, 0, NULL, 1, NULL),
(10, 'Machinery, Industrial Parts & Tools', NULL, 0, 0, 0, NULL, 1, NULL),
(11, 'Metallurgy, Chemicals, Rubber & Plastics', NULL, 0, 0, 0, NULL, 1, NULL),
(12, 'Packaging, Advertising & Office', NULL, 0, 0, 0, NULL, 1, NULL),
(13, 'Agriculture', NULL, 1, 1, 0, NULL, 1, NULL),
(14, 'Food & Beverage', NULL, 1, 1, 0, NULL, 1, NULL),
(15, 'Apparel', NULL, 2, 1, 0, NULL, 1, NULL),
(16, 'Textile & Leather Product', NULL, 2, 1, 0, NULL, 1, NULL),
(17, 'Fashion Accessories', NULL, 2, 1, 0, NULL, 1, NULL),
(18, 'Timepieces, Jewelry, Eyewear', NULL, 2, 1, 0, NULL, 1, NULL),
(19, 'Automobiles & Motorcycles', NULL, 3, 1, 0, NULL, 1, NULL),
(20, 'Transportation', NULL, 3, 1, 0, NULL, 1, NULL),
(21, 'Shoes & Accessories', NULL, 4, 1, 0, NULL, 1, NULL),
(22, 'Luggage, Bags & Cases', NULL, 4, 1, 0, NULL, 1, NULL),
(23, 'Computer Hardware & Software', NULL, 5, 1, 0, NULL, 1, NULL),
(24, 'Home Appliance', NULL, 5, 1, 0, NULL, 1, NULL),
(25, 'Consumer Electronic', NULL, 5, 1, 0, NULL, 1, NULL),
(26, 'Security & Protection', NULL, 5, 1, 0, NULL, 1, NULL),
(27, 'Telecommunication', NULL, 6, 1, 0, NULL, 1, NULL),
(28, 'Electronic Compnents & Supplies', NULL, 6, 1, 0, NULL, 1, NULL),
(29, 'Electrical Equipment & Supplies', NULL, 6, 1, 0, NULL, 1, NULL),
(30, 'Sports & Entertainment', NULL, 7, 1, 0, NULL, 1, NULL),
(31, 'Gifts & Crafts', NULL, 7, 1, 0, NULL, 1, NULL),
(32, 'Toys & Hobbies', NULL, 7, 1, 0, NULL, 1, NULL),
(33, 'Health & Medical', NULL, 8, 1, 0, NULL, 1, NULL),
(34, 'Beauty & Personal Care', NULL, 8, 1, 0, NULL, 1, NULL),
(35, 'Furniture', NULL, 9, 1, 0, NULL, 1, NULL),
(36, 'Lights & Lighting', NULL, 9, 1, 0, NULL, 1, NULL),
(37, 'Home & Garden', NULL, 9, 1, 0, NULL, 1, NULL),
(38, 'Construction & Real Estate', NULL, 9, 1, 0, NULL, 1, NULL),
(39, 'Measurement & Analysis Instruments', NULL, 10, 1, 0, NULL, 1, NULL),
(40, 'Hardware', NULL, 10, 1, 0, NULL, 1, NULL),
(41, 'Tools', NULL, 10, 1, 0, NULL, 1, NULL),
(42, 'Industrial Parts & Fabrication Services', NULL, 10, 1, 0, NULL, 1, NULL),
(43, 'Machinery', NULL, 10, 1, 0, NULL, 1, NULL),
(44, 'Minerals & Metallurgy', NULL, 11, 1, 0, NULL, 1, NULL),
(45, 'Energy', NULL, 11, 1, 0, NULL, 0, NULL),
(46, 'Environment', NULL, 11, 1, 0, NULL, 1, NULL),
(47, 'Rubber & Plastics', NULL, 11, 1, 0, NULL, 1, NULL),
(48, 'Chemicals', NULL, 11, 1, 0, NULL, 1, NULL),
(49, 'Packaging & Printing', NULL, 12, 1, 0, NULL, 1, NULL),
(50, 'Office & School Supplies', NULL, 12, 1, 0, NULL, 1, NULL),
(51, 'Service Equipment', NULL, 12, 1, 0, NULL, 1, NULL),
(52, 'Agricultural Growing Media', NULL, 13, 2, 0, NULL, 1, NULL),
(53, 'Agricultural Waste', NULL, 13, 2, 0, NULL, 1, NULL),
(54, 'Animal Categorys', NULL, 13, 2, 0, NULL, 1, NULL),
(55, 'Beans', NULL, 13, 2, 0, NULL, 1, NULL),
(56, 'Cocoa Beans', NULL, 13, 2, 0, NULL, 1, NULL),
(57, 'Coffee Beans', NULL, 13, 2, 0, NULL, 1, NULL),
(58, 'Farm Machinery & Equipment', NULL, 13, 2, 0, NULL, 1, NULL),
(59, 'Feed', NULL, 13, 2, 0, NULL, 1, NULL),
(60, 'Fresh Seafood', NULL, 13, 2, 0, NULL, 1, NULL),
(61, 'Fruit', NULL, 13, 2, 0, NULL, 1, NULL),
(62, 'Grain', NULL, 13, 2, 0, NULL, 1, NULL),
(63, 'Herbal Cigars & Cigarettes', NULL, 13, 2, 0, NULL, 1, NULL),
(64, 'Mushrooms & Truffles', NULL, 13, 2, 0, NULL, 1, NULL),
(65, 'Nuts & Kernels', NULL, 13, 2, 0, NULL, 1, NULL),
(66, 'Organic Produce', NULL, 13, 2, 0, NULL, 1, NULL),
(67, 'Ornamental Plants', NULL, 13, 2, 0, NULL, 1, NULL),
(68, 'Other Agriculture Categorys', NULL, 13, 2, 0, NULL, 1, NULL),
(69, 'Plant & Animal Oil', NULL, 13, 2, 0, NULL, 1, NULL),
(70, 'Plant Seeds & Bulbs', NULL, 13, 2, 0, NULL, 1, NULL),
(71, 'Timber Raw Materials', NULL, 13, 2, 0, NULL, 1, NULL),
(72, 'Vanilla Beans', NULL, 13, 2, 0, NULL, 1, NULL),
(73, 'Vegetables', NULL, 13, 2, 0, NULL, 1, NULL),
(74, 'Alcoholic Beverage', NULL, 14, 2, 0, NULL, 1, NULL),
(75, 'Baby Food', NULL, 14, 2, 0, NULL, 1, NULL),
(76, 'Baked Goods', NULL, 14, 2, 0, NULL, 1, NULL),
(77, 'Bean Categorys', NULL, 14, 2, 0, NULL, 1, NULL),
(78, 'Canned Food', NULL, 14, 2, 0, NULL, 1, NULL),
(79, 'Coffee', NULL, 14, 2, 0, NULL, 1, NULL),
(80, 'Confectionery', NULL, 14, 2, 0, NULL, 1, NULL),
(81, 'Dairy', NULL, 14, 2, 0, NULL, 1, NULL),
(82, 'Drinking Water', NULL, 14, 2, 0, NULL, 1, NULL),
(83, 'Egg & Egg Categorys', NULL, 14, 2, 0, NULL, 1, NULL),
(84, 'Food Ingredients', NULL, 14, 2, 0, NULL, 1, NULL),
(85, 'Fruit Categorys', NULL, 14, 2, 0, NULL, 1, NULL),
(86, 'Grain Categorys', NULL, 14, 2, 0, NULL, 1, NULL),
(87, 'Honey Categorys', NULL, 14, 2, 0, NULL, 1, NULL),
(88, 'Instant Food', NULL, 14, 2, 0, NULL, 1, NULL),
(89, 'Meat & Poultry', NULL, 14, 2, 0, NULL, 1, NULL),
(90, 'Other Food & Beverage', NULL, 14, 2, 0, NULL, 1, NULL),
(91, 'Seafood', NULL, 14, 2, 0, NULL, 1, NULL),
(92, 'Seasonings & Condiments', NULL, 14, 2, 0, NULL, 1, NULL),
(93, 'Slimming Food', NULL, 14, 2, 0, NULL, 1, NULL),
(94, 'Snack Food', NULL, 14, 2, 0, NULL, 1, NULL),
(95, 'Soft Drinks', NULL, 14, 2, 0, NULL, 1, NULL),
(96, 'Tea', NULL, 14, 2, 0, NULL, 1, NULL),
(97, 'Vegetable Categorys', NULL, 14, 2, 0, NULL, 1, NULL),
(98, 'Apparel Design Services', NULL, 15, 2, 0, NULL, 1, NULL),
(99, 'Apparel Processing Services', NULL, 15, 2, 0, NULL, 1, NULL),
(100, 'Apparel Stock', NULL, 15, 2, 0, NULL, 1, NULL),
(101, 'Boy’s Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(102, 'Children’s Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(103, 'Coats', NULL, 15, 2, 0, NULL, 1, NULL),
(104, 'Costumes', NULL, 15, 2, 0, NULL, 1, NULL),
(105, 'Dresses', NULL, 15, 2, 0, NULL, 1, NULL),
(106, 'Ethnic Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(107, 'Garment Accessories', NULL, 15, 2, 0, NULL, 1, NULL),
(108, 'Girls’ Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(109, 'Hoodies & Sweatshirts', NULL, 15, 2, 0, NULL, 1, NULL),
(110, 'Hosiery', NULL, 15, 2, 0, NULL, 1, NULL),
(111, 'Infant & Toddlers Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(112, 'Jackets', NULL, 15, 2, 0, NULL, 1, NULL),
(113, 'Jeans', NULL, 15, 2, 0, NULL, 1, NULL),
(114, 'Ladies’ Blouses & Tops', NULL, 15, 2, 0, NULL, 1, NULL),
(115, 'Mannequins', NULL, 15, 2, 0, NULL, 1, NULL),
(116, 'Maternity Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(117, 'Men’s Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(118, 'Men’s Shirts', NULL, 15, 2, 0, NULL, 1, NULL),
(119, 'Organic Cotton Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(120, 'Other Apparel', NULL, 15, 2, 0, NULL, 1, NULL),
(121, 'Pants & Trousers', NULL, 15, 2, 0, NULL, 1, NULL),
(122, 'Plus Size Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(123, 'Sewing Supplies', NULL, 15, 2, 0, NULL, 1, NULL),
(124, 'Shorts', NULL, 15, 2, 0, NULL, 1, NULL),
(125, 'Skirts', NULL, 15, 2, 0, NULL, 1, NULL),
(126, 'Sleepwear', NULL, 15, 2, 0, NULL, 1, NULL),
(127, 'Sportswear', NULL, 15, 2, 0, NULL, 1, NULL),
(128, 'Stage & Dance Wear', NULL, 15, 2, 0, NULL, 1, NULL),
(129, 'Suits & Tuxedo', NULL, 15, 2, 0, NULL, 1, NULL),
(130, 'Sweaters', NULL, 15, 2, 0, NULL, 1, NULL),
(131, 'Tag Guns', NULL, 15, 2, 0, NULL, 1, NULL),
(132, 'Tank Tops', NULL, 15, 2, 0, NULL, 1, NULL),
(133, 'T-Shirts', NULL, 15, 2, 0, NULL, 1, NULL),
(134, 'Underwear', NULL, 15, 2, 0, NULL, 1, NULL),
(135, 'Uniforms', NULL, 15, 2, 0, NULL, 1, NULL),
(136, 'Used Clothes', NULL, 15, 2, 0, NULL, 1, NULL),
(137, 'Vests & Waistcoats', NULL, 15, 2, 0, NULL, 1, NULL),
(138, 'Wedding Apparel & Accessories', NULL, 15, 2, 0, NULL, 1, NULL),
(139, 'Women''s Clothing', NULL, 15, 2, 0, NULL, 1, NULL),
(140, 'Workwear', NULL, 15, 2, 0, NULL, 1, NULL),
(141, 'Belt Accessories', NULL, 17, 2, 0, NULL, 1, NULL),
(142, 'Belts', NULL, 17, 2, 0, NULL, 1, NULL),
(143, 'Fashion Accessories Design Services', NULL, 17, 2, 0, NULL, 1, NULL),
(144, 'Fashion Accessories Processing Services', NULL, 17, 2, 0, NULL, 1, NULL),
(145, 'Fashion Accessories Stock', NULL, 17, 2, 0, NULL, 1, NULL),
(146, 'Gloves & Mittens', NULL, 17, 2, 0, NULL, 1, NULL),
(147, 'Headwear', NULL, 17, 2, 0, NULL, 1, NULL),
(148, 'Neckwear', NULL, 17, 2, 0, NULL, 1, NULL),
(149, 'Scarf, Hat & Glove Sets', NULL, 17, 2, 0, NULL, 1, NULL),
(150, 'Hats & Caps', NULL, 17, 2, 0, NULL, 1, NULL),
(151, 'Scarves & Shawls', NULL, 17, 2, 0, NULL, 1, NULL),
(152, 'Hair Accessories', NULL, 17, 2, 0, NULL, 1, NULL),
(153, 'Genuine Leather Belts', NULL, 17, 2, 0, NULL, 1, NULL),
(154, 'Leather Gloves & Mittens', NULL, 17, 2, 0, NULL, 1, NULL),
(155, 'Ties & Accessories', NULL, 17, 2, 0, NULL, 1, NULL),
(156, 'Belt Buckles', NULL, 17, 2, 0, NULL, 1, NULL),
(157, 'PU Belts', NULL, 17, 2, 0, NULL, 1, NULL),
(158, 'Belt Chains', NULL, 17, 2, 0, NULL, 1, NULL),
(159, 'Metal Belts', NULL, 17, 2, 0, NULL, 1, NULL),
(160, 'Suspenders', NULL, 17, 2, 0, NULL, 1, NULL),
(161, 'Eyewear', NULL, 18, 2, 0, NULL, 1, NULL),
(162, 'Jewelry', NULL, 18, 2, 0, NULL, 1, NULL),
(163, 'Watches', NULL, 18, 2, 0, NULL, 1, NULL),
(164, 'Eyeglasses Frames', NULL, 18, 2, 0, NULL, 1, NULL),
(165, 'Sunglasses', NULL, 18, 2, 0, NULL, 1, NULL),
(166, 'Sports Eyewear', NULL, 18, 2, 0, NULL, 1, NULL),
(167, 'Body Jewelry', NULL, 18, 2, 0, NULL, 1, NULL),
(168, 'Bracelets & Bangles', NULL, 18, 2, 0, NULL, 1, NULL),
(169, 'Brooches', NULL, 18, 2, 0, NULL, 1, NULL),
(170, 'Cuff Links & Tie Clips', NULL, 18, 2, 0, NULL, 1, NULL),
(171, 'Earrings', NULL, 18, 2, 0, NULL, 1, NULL),
(172, 'Jewelry Boxes', NULL, 18, 2, 0, NULL, 1, NULL),
(173, 'Jewelry Sets', NULL, 18, 2, 0, NULL, 1, NULL),
(174, 'Jewelry Tools & Equipment', NULL, 18, 2, 0, NULL, 1, NULL),
(175, 'Loose Beads', NULL, 18, 2, 0, NULL, 1, NULL),
(176, 'Loose Gemstone', NULL, 18, 2, 0, NULL, 1, NULL),
(177, 'Necklaces', NULL, 18, 2, 0, NULL, 1, NULL),
(178, 'Pendants & Charms', NULL, 18, 2, 0, NULL, 1, NULL),
(179, 'Rings', NULL, 18, 2, 0, NULL, 1, NULL),
(180, 'Wristwatches', NULL, 18, 2, 0, NULL, 1, NULL),
(181, 'Air Intakes', NULL, 19, 2, 0, NULL, 1, NULL),
(182, 'ATV', NULL, 19, 2, 0, NULL, 1, NULL),
(183, 'ATV Parts', NULL, 19, 2, 0, NULL, 1, NULL),
(184, 'Auto Chassis Parts', NULL, 19, 2, 0, NULL, 1, NULL),
(185, 'Auto Clutch', NULL, 19, 2, 0, NULL, 1, NULL),
(186, 'Auto Electrical System', NULL, 19, 2, 0, NULL, 1, NULL),
(187, 'Auto Electronics', NULL, 19, 2, 0, NULL, 1, NULL),
(188, 'Auto Engine', NULL, 19, 2, 0, NULL, 1, NULL),
(189, 'Auto Ignition System', NULL, 19, 2, 0, NULL, 1, NULL),
(190, 'Auto Steering System', NULL, 19, 2, 0, NULL, 1, NULL),
(191, 'Automobiles', NULL, 19, 2, 0, NULL, 1, NULL),
(192, 'Axles', NULL, 19, 2, 0, NULL, 1, NULL),
(193, 'Body Parts', NULL, 19, 2, 0, NULL, 1, NULL),
(194, 'Brake System', NULL, 19, 2, 0, NULL, 1, NULL),
(195, 'Car Care & Cleaning', NULL, 19, 2, 0, NULL, 1, NULL),
(196, 'Cooling System', NULL, 19, 2, 0, NULL, 1, NULL),
(197, 'Crank Mechanism', NULL, 19, 2, 0, NULL, 1, NULL),
(198, 'Exhaust System', NULL, 19, 2, 0, NULL, 1, NULL),
(199, 'Exterior Accessories', NULL, 19, 2, 0, NULL, 1, NULL),
(200, 'Fuel System', NULL, 19, 2, 0, NULL, 1, NULL),
(201, 'Interior Accessories', NULL, 19, 2, 0, NULL, 1, NULL),
(202, 'Lubrication System', NULL, 19, 2, 0, NULL, 1, NULL),
(203, 'Motorcycle Accessories', NULL, 19, 2, 0, NULL, 1, NULL),
(204, 'Motorcycle Parts', NULL, 19, 2, 0, NULL, 1, NULL),
(205, 'Motorcycles', NULL, 19, 2, 0, NULL, 1, NULL),
(206, 'Other Auto Parts', NULL, 19, 2, 0, NULL, 1, NULL),
(207, 'Suspension System', NULL, 19, 2, 0, NULL, 1, NULL),
(208, 'Transmission', NULL, 19, 2, 0, NULL, 1, NULL),
(209, 'Tricycles', NULL, 19, 2, 0, NULL, 1, NULL),
(210, 'Universal Parts', NULL, 19, 2, 0, NULL, 1, NULL),
(211, 'UTV', NULL, 19, 2, 0, NULL, 1, NULL),
(212, 'Valve Train', NULL, 19, 2, 0, NULL, 1, NULL),
(213, 'Vehicle Equipment', NULL, 19, 2, 0, NULL, 1, NULL),
(214, 'Vehicle Tools', NULL, 19, 2, 0, NULL, 1, NULL),
(215, 'Aircraft', NULL, 20, 2, 0, NULL, 1, NULL),
(216, 'Aviation Accessories', NULL, 20, 2, 0, NULL, 1, NULL),
(217, 'Aviation Parts', NULL, 20, 2, 0, NULL, 1, NULL),
(218, 'Bicycle', NULL, 20, 2, 0, NULL, 1, NULL),
(219, 'Bicycle Accessories', NULL, 20, 2, 0, NULL, 1, NULL),
(220, 'Bicycle Parts', NULL, 20, 2, 0, NULL, 1, NULL),
(221, 'Boats & Ships', NULL, 20, 2, 0, NULL, 1, NULL),
(222, 'Bus', NULL, 20, 2, 0, NULL, 1, NULL),
(223, 'Bus Accessories', NULL, 20, 2, 0, NULL, 1, NULL),
(224, 'Bus Parts', NULL, 20, 2, 0, NULL, 1, NULL),
(225, 'Container', NULL, 20, 2, 0, NULL, 1, NULL),
(226, 'Electric Bicycle', NULL, 20, 2, 0, NULL, 1, NULL),
(227, 'Electric Bicycle Part', NULL, 20, 2, 0, NULL, 1, NULL),
(228, 'Emergency Vehicles', NULL, 20, 2, 0, NULL, 1, NULL),
(229, 'Golf Carts', NULL, 20, 2, 0, NULL, 1, NULL),
(230, 'Locomotive', NULL, 20, 2, 0, NULL, 1, NULL),
(231, 'Marine Supplies', NULL, 20, 2, 0, NULL, 1, NULL),
(232, 'Personal Watercraft', NULL, 20, 2, 0, NULL, 1, NULL),
(233, 'Railway Supplies', NULL, 20, 2, 0, NULL, 1, NULL),
(234, 'Snowmobile', NULL, 20, 2, 0, NULL, 1, NULL),
(235, 'Special Transportation', NULL, 20, 2, 0, NULL, 1, NULL),
(236, 'Trailers', NULL, 20, 2, 0, NULL, 1, NULL),
(237, 'Train Carriage', NULL, 20, 2, 0, NULL, 1, NULL),
(238, 'Train Parts', NULL, 20, 2, 0, NULL, 1, NULL),
(239, 'Truck', NULL, 20, 2, 0, NULL, 1, NULL),
(240, 'Truck Accessories', NULL, 20, 2, 0, NULL, 1, NULL),
(241, 'Truck Parts', NULL, 20, 2, 0, NULL, 1, NULL),
(242, 'Bag & Luggage Making Materials', NULL, 22, 2, 0, NULL, 1, NULL),
(243, 'Bag Parts & Accessories', NULL, 22, 2, 0, NULL, 1, NULL),
(244, 'Business Bags & Cases', NULL, 22, 2, 0, NULL, 1, NULL),
(245, 'Digital Gear & Camera Bags', NULL, 22, 2, 0, NULL, 1, NULL),
(246, 'Handbags & Messenger Bags', NULL, 22, 2, 0, NULL, 1, NULL),
(247, 'Luggage & Travel Bags', NULL, 22, 2, 0, NULL, 1, NULL),
(248, 'Luggage Cart', NULL, 22, 2, 0, NULL, 1, NULL),
(249, 'Other Luggage, Bags & Cases', NULL, 22, 2, 0, NULL, 1, NULL),
(250, 'Special Purpose Bags & Cases', NULL, 22, 2, 0, NULL, 1, NULL),
(251, 'Sports & Leisure Bags', NULL, 22, 2, 0, NULL, 1, NULL),
(252, 'Wallets & Holders', NULL, 22, 2, 0, NULL, 1, NULL),
(253, 'Carry-on Luggage', NULL, 22, 2, 0, NULL, 1, NULL),
(254, 'Luggage Sets', NULL, 22, 2, 0, NULL, 1, NULL),
(255, 'Trolley Bags', NULL, 22, 2, 0, NULL, 1, NULL),
(256, 'Briefcases', NULL, 22, 2, 0, NULL, 1, NULL),
(257, 'Cosmetic Bags & Cases', NULL, 22, 2, 0, NULL, 1, NULL),
(258, 'Shopping Bags', NULL, 22, 2, 0, NULL, 1, NULL),
(259, 'Handbags', NULL, 22, 2, 0, NULL, 1, NULL),
(260, 'Backpacks', NULL, 22, 2, 0, NULL, 1, NULL),
(261, 'Wallets', NULL, 22, 2, 0, NULL, 1, NULL),
(262, 'Baby Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(263, 'Boots', NULL, 21, 2, 0, NULL, 1, NULL),
(264, 'Casual Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(265, 'Children’s Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(266, 'Clogs', NULL, 21, 2, 0, NULL, 1, NULL),
(267, 'Dance Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(268, 'Dress Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(269, 'Genuine Leather Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(270, 'Men’s Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(271, 'Other Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(272, 'Sandals', NULL, 21, 2, 0, NULL, 1, NULL),
(273, 'Shoe Materials', NULL, 21, 2, 0, NULL, 1, NULL),
(274, 'Shoe Parts & Accessories', NULL, 21, 2, 0, NULL, 1, NULL),
(275, 'Shoe Repairing Equipment', NULL, 21, 2, 0, NULL, 1, NULL),
(276, 'Shoes Design Services', NULL, 21, 2, 0, NULL, 1, NULL),
(277, 'Shoes Processing Services', NULL, 21, 2, 0, NULL, 1, NULL),
(278, 'Shoes Stock', NULL, 21, 2, 0, NULL, 1, NULL),
(279, 'Slippers', NULL, 21, 2, 0, NULL, 1, NULL),
(280, 'Special Purpose Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(281, 'Sports Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(282, 'Used Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(283, 'Women’s Shoes', NULL, 21, 2, 0, NULL, 1, NULL),
(284, 'All-In-One PC', NULL, 23, 2, 0, NULL, 1, NULL),
(285, 'Barebone System', NULL, 23, 2, 0, NULL, 1, NULL),
(286, 'Blank Media', NULL, 23, 2, 0, NULL, 1, NULL),
(287, 'Computer Cables & Connectors', NULL, 23, 2, 0, NULL, 1, NULL),
(288, 'Computer Cases & Towers', NULL, 23, 2, 0, NULL, 1, NULL),
(289, 'Computer Cleaners', NULL, 23, 2, 0, NULL, 1, NULL),
(290, 'Desktops', NULL, 23, 2, 0, NULL, 1, NULL),
(291, 'Fans & Cooling', NULL, 23, 2, 0, NULL, 1, NULL),
(292, 'Firewall & VPN', NULL, 23, 2, 0, NULL, 1, NULL),
(293, 'Floppy Drives', NULL, 23, 2, 0, NULL, 1, NULL),
(294, 'Graphics Cards', NULL, 23, 2, 0, NULL, 1, NULL),
(295, 'Hard Drives', NULL, 23, 2, 0, NULL, 1, NULL),
(296, 'HDD Enclosure', NULL, 23, 2, 0, NULL, 1, NULL),
(297, 'Industrial Computer & Accessories', NULL, 23, 2, 0, NULL, 1, NULL),
(298, 'Keyboard Covers', NULL, 23, 2, 0, NULL, 1, NULL),
(299, 'KVM Switches', NULL, 23, 2, 0, NULL, 1, NULL),
(300, 'Laptop Accessories', NULL, 23, 2, 0, NULL, 1, NULL),
(301, 'Laptop Cooling Pads', NULL, 23, 2, 0, NULL, 1, NULL),
(302, 'Laptops', NULL, 23, 2, 0, NULL, 1, NULL),
(303, 'Memory', NULL, 23, 2, 0, NULL, 1, NULL),
(304, 'Modems', NULL, 23, 2, 0, NULL, 1, NULL),
(305, 'Monitors', NULL, 23, 2, 0, NULL, 1, NULL),
(306, 'Motherboards', NULL, 23, 2, 0, NULL, 1, NULL),
(307, 'Mouse & Keyboards', NULL, 23, 2, 0, NULL, 1, NULL),
(308, 'Mouse Pads', NULL, 23, 2, 0, NULL, 1, NULL),
(309, 'Netbooks & UMPC', NULL, 23, 2, 0, NULL, 1, NULL),
(310, 'Network Cabinets', NULL, 23, 2, 0, NULL, 1, NULL),
(311, 'Network Cards', NULL, 23, 2, 0, NULL, 1, NULL),
(312, 'Network Hubs', NULL, 23, 2, 0, NULL, 1, NULL),
(313, 'Network Switches', NULL, 23, 2, 0, NULL, 1, NULL),
(314, 'Networking Storage', NULL, 23, 2, 0, NULL, 1, NULL),
(315, 'Optical Drives', NULL, 23, 2, 0, NULL, 1, NULL),
(316, 'Other Computer Accessories', NULL, 23, 2, 0, NULL, 1, NULL),
(317, 'Other Computer Parts', NULL, 23, 2, 0, NULL, 1, NULL),
(318, 'Other Computer Categorys', NULL, 23, 2, 0, NULL, 1, NULL),
(319, 'Other Drive & Storage Devices', NULL, 23, 2, 0, NULL, 1, NULL),
(320, 'Other Networking Devices', NULL, 23, 2, 0, NULL, 1, NULL),
(321, 'PC Stations', NULL, 23, 2, 0, NULL, 1, NULL),
(322, 'PDAs', NULL, 23, 2, 0, NULL, 1, NULL),
(323, 'Power Supply Units', NULL, 23, 2, 0, NULL, 1, NULL),
(324, 'Printers', NULL, 23, 2, 0, NULL, 1, NULL),
(325, 'Processors', NULL, 23, 2, 0, NULL, 1, NULL),
(326, 'Routers', NULL, 23, 2, 0, NULL, 1, NULL),
(327, 'Scanners', NULL, 23, 2, 0, NULL, 1, NULL),
(328, 'Servers', NULL, 23, 2, 0, NULL, 1, NULL),
(329, 'Software', NULL, 23, 2, 0, NULL, 1, NULL),
(330, 'Sound Cards', NULL, 23, 2, 0, NULL, 1, NULL),
(331, 'Tablet PC', NULL, 23, 2, 0, NULL, 1, NULL),
(332, 'Tablet PC Stands', NULL, 23, 2, 0, NULL, 1, NULL),
(333, 'Tablet Stylus Pen', NULL, 23, 2, 0, NULL, 1, NULL),
(334, 'USB Flash Drives', NULL, 23, 2, 0, NULL, 1, NULL),
(335, 'USB Gadgets', NULL, 23, 2, 0, NULL, 1, NULL),
(336, 'USB Hubs', NULL, 23, 2, 0, NULL, 1, NULL),
(337, 'Used Computers & Accessories', NULL, 23, 2, 0, NULL, 1, NULL),
(338, 'Webcams', NULL, 23, 2, 0, NULL, 1, NULL),
(339, 'Wireless Networking', NULL, 23, 2, 0, NULL, 1, NULL),
(340, 'Workstations', NULL, 23, 2, 0, NULL, 1, NULL),
(341, 'Air Conditioning Appliances', NULL, 24, 2, 0, NULL, 1, NULL),
(342, 'Cleaning Appliances', NULL, 24, 2, 0, NULL, 1, NULL),
(343, 'Hand Dryers', NULL, 24, 2, 0, NULL, 1, NULL),
(344, 'Home Appliance Parts', NULL, 24, 2, 0, NULL, 1, NULL),
(345, 'Home Appliances Stocks', NULL, 24, 2, 0, NULL, 1, NULL),
(346, 'Home Heaters', NULL, 24, 2, 0, NULL, 1, NULL),
(347, 'Kitchen Appliances', NULL, 24, 2, 0, NULL, 1, NULL),
(348, 'Laundry Appliances', NULL, 24, 2, 0, NULL, 1, NULL),
(349, 'Other Home Appliances', NULL, 24, 2, 0, NULL, 1, NULL),
(350, 'Refrigerators & Freezers', NULL, 24, 2, 0, NULL, 1, NULL),
(351, 'Water Heaters', NULL, 24, 2, 0, NULL, 1, NULL),
(352, 'Water Treatment Appliances', NULL, 24, 2, 0, NULL, 1, NULL),
(353, 'Wet Towel Dispensers', NULL, 24, 2, 0, NULL, 1, NULL),
(354, 'Air Conditioners', NULL, 24, 2, 0, NULL, 1, NULL),
(355, 'Fans', NULL, 24, 2, 0, NULL, 1, NULL),
(356, 'Vacuum Cleaners', NULL, 24, 2, 0, NULL, 1, NULL),
(357, 'Solar Water Heaters', NULL, 24, 2, 0, NULL, 1, NULL),
(358, 'Cooking Appliances', NULL, 24, 2, 0, NULL, 1, NULL),
(359, 'Coffee Makers', NULL, 24, 2, 0, NULL, 1, NULL),
(360, 'Blenders', NULL, 24, 2, 0, NULL, 1, NULL),
(361, 'Accessories & Parts', NULL, 25, 2, 0, NULL, 1, NULL),
(362, 'Camera, Photo & Accessories', NULL, 25, 2, 0, NULL, 1, NULL),
(363, 'Electronic Publications', NULL, 25, 2, 0, NULL, 1, NULL),
(364, 'Home Audio, Video & Accessories', NULL, 25, 2, 0, NULL, 1, NULL),
(365, 'Mobile Phone & Accessories', NULL, 25, 2, 0, NULL, 1, NULL),
(366, 'Other Consumer Electronics', NULL, 25, 2, 0, NULL, 1, NULL),
(367, 'Portable Audio, Video & Accessories', NULL, 25, 2, 0, NULL, 1, NULL),
(368, 'Video Game & Accessories', NULL, 25, 2, 0, NULL, 1, NULL),
(369, 'Mobile Phones', NULL, 25, 2, 0, NULL, 1, NULL),
(370, 'Earphone & Headphone', NULL, 25, 2, 0, NULL, 1, NULL),
(371, 'Power Banks', NULL, 25, 2, 0, NULL, 1, NULL),
(372, 'Digital Camera', NULL, 25, 2, 0, NULL, 1, NULL),
(373, 'Radio & TV Accessories', NULL, 25, 2, 0, NULL, 1, NULL),
(374, 'Speaker', NULL, 25, 2, 0, NULL, 1, NULL),
(375, 'Television', NULL, 25, 2, 0, NULL, 1, NULL),
(376, 'Cables', NULL, 25, 2, 0, NULL, 1, NULL),
(377, 'Charger', NULL, 25, 2, 0, NULL, 1, NULL),
(378, 'Digital Battery', NULL, 25, 2, 0, NULL, 1, NULL),
(379, 'Digital Photo Frame', NULL, 25, 2, 0, NULL, 1, NULL),
(380, '3D Glasses', NULL, 25, 2, 0, NULL, 1, NULL),
(381, 'Access Control Systems & Categorys', NULL, 26, 2, 0, NULL, 1, NULL),
(382, 'Alarm', NULL, 26, 2, 0, NULL, 1, NULL),
(383, 'CCTV Categorys', NULL, 26, 2, 0, NULL, 1, NULL),
(384, 'Firefighting Supplies', NULL, 26, 2, 0, NULL, 1, NULL),
(385, 'Key', NULL, 26, 2, 0, NULL, 1, NULL),
(386, 'Lock Parts', NULL, 26, 2, 0, NULL, 1, NULL),
(387, 'Locks', NULL, 26, 2, 0, NULL, 1, NULL),
(388, 'Locksmith Supplies', NULL, 26, 2, 0, NULL, 1, NULL),
(389, 'Other Security & Protection Categorys', NULL, 26, 2, 0, NULL, 1, NULL),
(390, 'Police & Military Supplies', NULL, 26, 2, 0, NULL, 1, NULL),
(391, 'Roadway Safety', NULL, 26, 2, 0, NULL, 1, NULL),
(392, 'Safes', NULL, 26, 2, 0, NULL, 1, NULL),
(393, 'Security Services', NULL, 26, 2, 0, NULL, 1, NULL),
(394, 'Self Defense Supplies', NULL, 26, 2, 0, NULL, 1, NULL),
(395, 'Water Safety Categorys', NULL, 26, 2, 0, NULL, 1, NULL),
(396, 'Workplace Safety Supplies', NULL, 26, 2, 0, NULL, 1, NULL),
(397, 'CCTV Camera', NULL, 26, 2, 0, NULL, 1, NULL),
(398, 'Bullet Proof Vest', NULL, 26, 2, 0, NULL, 1, NULL),
(399, 'Alcohol Tester', NULL, 26, 2, 0, NULL, 1, NULL),
(400, 'Fire Alarm', NULL, 26, 2, 0, NULL, 1, NULL),
(401, 'Batteries', NULL, 29, 2, 0, NULL, 1, NULL),
(402, 'Circuit Breakers', NULL, 29, 2, 0, NULL, 1, NULL),
(403, 'Connectors & Terminals', NULL, 29, 2, 0, NULL, 1, NULL),
(404, 'Contactors', NULL, 29, 2, 0, NULL, 1, NULL),
(405, 'Electrical Plugs & Sockets', NULL, 29, 2, 0, NULL, 1, NULL),
(406, 'Electronic & Instrument Enclosures', NULL, 29, 2, 0, NULL, 1, NULL),
(407, 'Fuse Components', NULL, 29, 2, 0, NULL, 1, NULL),
(408, 'Fuses', NULL, 29, 2, 0, NULL, 1, NULL),
(409, 'Generators', NULL, 29, 2, 0, NULL, 1, NULL),
(410, 'Other Electrical Equipment', NULL, 29, 2, 0, NULL, 1, NULL),
(411, 'Power Accessories', NULL, 29, 2, 0, NULL, 1, NULL),
(412, 'Power Distribution Equipment', NULL, 29, 2, 0, NULL, 1, NULL),
(413, 'Power Supplies', NULL, 29, 2, 0, NULL, 1, NULL),
(414, 'Professional Audio, Video & Lighting', NULL, 29, 2, 0, NULL, 1, NULL),
(415, 'Relays', NULL, 29, 2, 0, NULL, 1, NULL),
(416, 'Switches', NULL, 29, 2, 0, NULL, 1, NULL),
(417, 'Transformers', NULL, 29, 2, 0, NULL, 1, NULL),
(418, 'Wires, Cables & Cable Assemblies', NULL, 29, 2, 0, NULL, 1, NULL),
(419, 'Wiring Accessories', NULL, 29, 2, 0, NULL, 1, NULL),
(420, 'Solar Cells, Solar Panel', NULL, 29, 2, 0, NULL, 1, NULL),
(421, 'Active Components', NULL, 28, 2, 0, NULL, 1, NULL),
(422, 'EL Categorys', NULL, 28, 2, 0, NULL, 1, NULL),
(423, 'Electronic Accessories & Supplies', NULL, 28, 2, 0, NULL, 1, NULL),
(424, 'Electronic Data Systems', NULL, 28, 2, 0, NULL, 1, NULL),
(425, 'Electronic Signs', NULL, 28, 2, 0, NULL, 1, NULL),
(426, 'Electronics Categoryion Machinery', NULL, 28, 2, 0, NULL, 1, NULL),
(427, 'Electronics Stocks', NULL, 28, 2, 0, NULL, 1, NULL),
(428, 'Optoelectronic Displays', NULL, 28, 2, 0, NULL, 1, NULL),
(429, 'Other Electronic Components', NULL, 28, 2, 0, NULL, 1, NULL),
(430, 'Passive Components', NULL, 28, 2, 0, NULL, 1, NULL),
(431, 'LCD Modules', NULL, 28, 2, 0, NULL, 1, NULL),
(432, 'LED Displays', NULL, 28, 2, 0, NULL, 1, NULL),
(433, 'PCB & PCBA', NULL, 28, 2, 0, NULL, 1, NULL),
(434, 'Keypads & Keyboards', NULL, 28, 2, 0, NULL, 1, NULL),
(435, 'Insulation Materials & Elements', NULL, 28, 2, 0, NULL, 1, NULL),
(436, 'Integrated Circuits', NULL, 28, 2, 0, NULL, 1, NULL),
(437, 'Diodes', NULL, 28, 2, 0, NULL, 1, NULL),
(438, 'Transistors', NULL, 28, 2, 0, NULL, 1, NULL),
(439, 'Capacitors', NULL, 28, 2, 0, NULL, 1, NULL),
(440, 'Resistors', NULL, 28, 2, 0, NULL, 1, NULL),
(441, 'Antennas for Communications', NULL, 27, 2, 0, NULL, 1, NULL),
(442, 'Communication Equipment', NULL, 27, 2, 0, NULL, 1, NULL),
(443, 'Telephones & Accessories', NULL, 27, 2, 0, NULL, 1, NULL),
(444, 'Communication Cables', NULL, 27, 2, 0, NULL, 1, NULL),
(445, 'Fiber Optic Equipment', NULL, 27, 2, 0, NULL, 1, NULL),
(446, 'Fixed Wireless Terminals', NULL, 27, 2, 0, NULL, 1, NULL),
(447, 'WiFi Finder', NULL, 27, 2, 0, NULL, 1, NULL),
(448, 'Telephone Accessories', NULL, 27, 2, 0, NULL, 1, NULL),
(449, 'Corded Telephones', NULL, 27, 2, 0, NULL, 1, NULL),
(450, 'Cordless Telephones', NULL, 27, 2, 0, NULL, 1, NULL),
(451, 'Wireless Networking Equipment', NULL, 27, 2, 0, NULL, 1, NULL),
(452, 'Telephone Headsets', NULL, 27, 2, 0, NULL, 1, NULL),
(453, 'VoIP Categorys', NULL, 27, 2, 0, NULL, 1, NULL),
(454, 'Repeater', NULL, 27, 2, 0, NULL, 1, NULL),
(455, 'PBX', NULL, 27, 2, 0, NULL, 1, NULL),
(456, 'Telecom Parts', NULL, 27, 2, 0, NULL, 1, NULL),
(457, 'Phone Cards', NULL, 27, 2, 0, NULL, 1, NULL),
(458, 'Telephone Cords', NULL, 27, 2, 0, NULL, 1, NULL),
(459, 'Answering Machines', NULL, 27, 2, 0, NULL, 1, NULL),
(460, 'Caller ID Boxes', NULL, 27, 2, 0, NULL, 1, NULL),
(461, 'Amusement Park', NULL, 30, 2, 0, NULL, 1, NULL),
(462, 'Artificial Grass & Sports Flooring', NULL, 30, 2, 0, NULL, 1, NULL),
(463, 'Fitness & Body Building', NULL, 30, 2, 0, NULL, 1, NULL),
(464, 'Gambling', NULL, 30, 2, 0, NULL, 1, NULL),
(465, 'Golf', NULL, 30, 2, 0, NULL, 1, NULL),
(466, 'Indoor Sports', NULL, 30, 2, 0, NULL, 1, NULL),
(467, 'Musical Instruments', NULL, 30, 2, 0, NULL, 1, NULL),
(468, 'Other Sports & Entertainment Categorys', NULL, 30, 2, 0, NULL, 1, NULL),
(469, 'Outdoor Sports', NULL, 30, 2, 0, NULL, 1, NULL),
(470, 'Sports Gloves', NULL, 30, 2, 0, NULL, 1, NULL),
(471, 'Sports Safety', NULL, 30, 2, 0, NULL, 1, NULL),
(472, 'Sports Souvenirs', NULL, 30, 2, 0, NULL, 1, NULL),
(473, 'Team Sports', NULL, 30, 2, 0, NULL, 1, NULL),
(474, 'Tennis', NULL, 30, 2, 0, NULL, 1, NULL),
(475, 'Water Sports', NULL, 30, 2, 0, NULL, 1, NULL),
(476, 'Winter Sports', NULL, 30, 2, 0, NULL, 1, NULL),
(477, 'Camping & Hiking', NULL, 30, 2, 0, NULL, 1, NULL),
(478, 'Scooters', NULL, 30, 2, 0, NULL, 1, NULL),
(479, 'Gym Equipment', NULL, 30, 2, 0, NULL, 1, NULL),
(480, 'Swimming & Diving', NULL, 30, 2, 0, NULL, 1, NULL),
(481, 'Antique Imitation Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(482, 'Art & Collectible', NULL, 31, 2, 0, NULL, 1, NULL),
(483, 'Artificial Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(484, 'Arts & Crafts Stocks', NULL, 31, 2, 0, NULL, 1, NULL),
(485, 'Bamboo Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(486, 'Carving Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(487, 'Clay Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(488, 'Cross Stitch', NULL, 31, 2, 0, NULL, 1, NULL),
(489, 'Crystal Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(490, 'Embroidery Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(491, 'Feng Shui Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(492, 'Festive & Party Supplies', NULL, 31, 2, 0, NULL, 1, NULL),
(493, 'Flags, Banners & Accessories', NULL, 31, 2, 0, NULL, 1, NULL),
(494, 'Folk Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(495, 'Gift Sets', NULL, 31, 2, 0, NULL, 1, NULL),
(496, 'Glass Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(497, 'Holiday Gifts', NULL, 31, 2, 0, NULL, 1, NULL),
(498, 'Home Decoration', NULL, 31, 2, 0, NULL, 1, NULL),
(499, 'Key Chains', NULL, 31, 2, 0, NULL, 1, NULL),
(500, 'Knitting & Crocheting', NULL, 31, 2, 0, NULL, 1, NULL),
(501, 'Lacquerware', NULL, 31, 2, 0, NULL, 1, NULL),
(502, 'Lanyard', NULL, 31, 2, 0, NULL, 1, NULL),
(503, 'Leather Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(504, 'Metal Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(505, 'Money Boxes', NULL, 31, 2, 0, NULL, 1, NULL),
(506, 'Music Boxes', NULL, 31, 2, 0, NULL, 1, NULL),
(507, 'Natural Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(508, 'Nautical Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(509, 'Other Gifts & Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(510, 'Paper Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(511, 'Plastic Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(512, 'Pottery & Enamel', NULL, 31, 2, 0, NULL, 1, NULL),
(513, 'Religious Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(514, 'Resin Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(515, 'Sculptures', NULL, 31, 2, 0, NULL, 1, NULL),
(516, 'Semi-Precious Stone Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(517, 'Souvenirs', NULL, 31, 2, 0, NULL, 1, NULL),
(518, 'Stickers', NULL, 31, 2, 0, NULL, 1, NULL),
(519, 'Stone Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(520, 'Textile & Fabric Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(521, 'Wedding Decorations & Gifts', NULL, 31, 2, 0, NULL, 1, NULL),
(522, 'Wicker Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(523, 'Wood Crafts', NULL, 31, 2, 0, NULL, 1, NULL),
(524, 'Action Figure', NULL, 32, 2, 0, NULL, 1, NULL),
(525, 'Baby Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(526, 'Balloons', NULL, 32, 2, 0, NULL, 1, NULL),
(527, 'Candy Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(528, 'Classic Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(529, 'Dolls', NULL, 32, 2, 0, NULL, 1, NULL),
(530, 'Educational Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(531, 'Electronic Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(532, 'Glass Marbles', NULL, 32, 2, 0, NULL, 1, NULL),
(533, 'Inflatable Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(534, 'Light-Up Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(535, 'Noise Maker', NULL, 32, 2, 0, NULL, 1, NULL),
(536, 'Other Toys & Hobbies', NULL, 32, 2, 0, NULL, 1, NULL),
(537, 'Outdoor Toys & Structures', NULL, 32, 2, 0, NULL, 1, NULL),
(538, 'Plastic Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(539, 'Pretend Play & Preschool', NULL, 32, 2, 0, NULL, 1, NULL),
(540, 'Solar Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(541, 'Toy Accessories', NULL, 32, 2, 0, NULL, 1, NULL),
(542, 'Toy Animal', NULL, 32, 2, 0, NULL, 1, NULL),
(543, 'Toy Guns', NULL, 32, 2, 0, NULL, 1, NULL),
(544, 'Toy Parts', NULL, 32, 2, 0, NULL, 1, NULL),
(545, 'Toy Robots', NULL, 32, 2, 0, NULL, 1, NULL),
(546, 'Toy Vehicle', NULL, 32, 2, 0, NULL, 1, NULL),
(547, 'Wind Up Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(548, 'Wooden Toys', NULL, 32, 2, 0, NULL, 1, NULL),
(549, 'Animal Extract', NULL, 33, 2, 0, NULL, 1, NULL),
(550, 'Plant Extracts', NULL, 33, 2, 0, NULL, 1, NULL),
(551, 'Body Weight', NULL, 33, 2, 0, NULL, 1, NULL),
(552, 'Health Care Supplement', NULL, 33, 2, 0, NULL, 1, NULL),
(553, 'Health Care Supplies', NULL, 33, 2, 0, NULL, 1, NULL),
(554, 'Crude Medicine', NULL, 33, 2, 0, NULL, 1, NULL),
(555, 'Prepared Drugs In Pieces', NULL, 33, 2, 0, NULL, 1, NULL),
(556, 'Traditional Patented Medicines', NULL, 33, 2, 0, NULL, 1, NULL),
(557, 'Body Fluid-Processing & Circulation Devices', NULL, 33, 2, 0, NULL, 1, NULL),
(558, 'Clinical Analytical Instruments', NULL, 33, 2, 0, NULL, 1, NULL),
(559, 'Dental Equipment', NULL, 33, 2, 0, NULL, 1, NULL),
(560, 'Emergency & Clinics Apparatuses', NULL, 33, 2, 0, NULL, 1, NULL),
(561, 'Equipments of Traditional Chinese Medicine', NULL, 33, 2, 0, NULL, 1, NULL),
(562, 'General Assay & Diagnostic Apparatuses', NULL, 33, 2, 0, NULL, 1, NULL),
(563, 'Implants & Interventional Materials', NULL, 33, 2, 0, NULL, 1, NULL),
(564, 'Medical Consumable', NULL, 33, 2, 0, NULL, 1, NULL),
(565, 'Medical Cryogenic Equipments', NULL, 33, 2, 0, NULL, 1, NULL),
(566, 'Medical Software', NULL, 33, 2, 0, NULL, 1, NULL),
(567, 'Physical Therapy Equipments', NULL, 33, 2, 0, NULL, 1, NULL),
(568, 'Radiology Equipment & Accessories', NULL, 33, 2, 0, NULL, 1, NULL),
(569, 'Sterilization Equipments', NULL, 33, 2, 0, NULL, 1, NULL),
(570, 'Surgical Instrument', NULL, 33, 2, 0, NULL, 1, NULL),
(571, 'Ultrasonic, Optical, Electronic Equipment', NULL, 33, 2, 0, NULL, 1, NULL),
(572, 'Ward Nursing Equipments', NULL, 33, 2, 0, NULL, 1, NULL),
(573, 'Medicines', NULL, 33, 2, 0, NULL, 1, NULL),
(574, 'Veterinary Instrument', NULL, 33, 2, 0, NULL, 1, NULL),
(575, 'Veterinary Medicine', NULL, 33, 2, 0, NULL, 1, NULL),
(576, 'Baby Care', NULL, 34, 2, 0, NULL, 1, NULL),
(577, 'Bath Supplies', NULL, 34, 2, 0, NULL, 1, NULL),
(578, 'Beauty Equipment', NULL, 34, 2, 0, NULL, 1, NULL),
(579, 'Body Art', NULL, 34, 2, 0, NULL, 1, NULL),
(580, 'Breast Care', NULL, 34, 2, 0, NULL, 1, NULL),
(581, 'Feminine Hygiene', NULL, 34, 2, 0, NULL, 1, NULL),
(582, 'Fragrance & Deodorant', NULL, 34, 2, 0, NULL, 1, NULL),
(583, 'Hair Care', NULL, 34, 2, 0, NULL, 1, NULL),
(584, 'Hair Extensions & Wigs', NULL, 34, 2, 0, NULL, 1, NULL),
(585, 'Hair Salon Equipment', NULL, 34, 2, 0, NULL, 1, NULL),
(586, 'Makeup', NULL, 34, 2, 0, NULL, 1, NULL),
(587, 'Makeup Tools', NULL, 34, 2, 0, NULL, 1, NULL),
(588, 'Men Care', NULL, 34, 2, 0, NULL, 1, NULL),
(589, 'Nail Supplies', NULL, 34, 2, 0, NULL, 1, NULL),
(590, 'Oral Hygiene', NULL, 34, 2, 0, NULL, 1, NULL),
(591, 'Other Beauty & Personal Care Categorys', NULL, 34, 2, 0, NULL, 1, NULL),
(592, 'Sanitary Paper', NULL, 34, 2, 0, NULL, 1, NULL),
(593, 'Shaving & Hair Removal', NULL, 34, 2, 0, NULL, 1, NULL),
(594, 'Skin Care', NULL, 34, 2, 0, NULL, 1, NULL),
(595, 'Skin Care Tool', NULL, 34, 2, 0, NULL, 1, NULL),
(596, 'Spa Supplies', NULL, 34, 2, 0, NULL, 1, NULL),
(597, 'Weight Loss', NULL, 34, 2, 0, NULL, 1, NULL),
(598, 'Aluminum Composite Panels', NULL, 38, 2, 0, NULL, 1, NULL),
(599, 'Balustrades & Handrails', NULL, 38, 2, 0, NULL, 1, NULL),
(600, 'Bathroom', NULL, 38, 2, 0, NULL, 1, NULL),
(601, 'Boards', NULL, 38, 2, 0, NULL, 1, NULL),
(602, 'Building Glass', NULL, 38, 2, 0, NULL, 1, NULL),
(603, 'Ceilings', NULL, 38, 2, 0, NULL, 1, NULL),
(604, 'Corner Guards', NULL, 38, 2, 0, NULL, 1, NULL),
(605, 'Countertops,Vanity Tops & Table Tops', NULL, 38, 2, 0, NULL, 1, NULL),
(606, 'Curtain Walls & Accessories', NULL, 38, 2, 0, NULL, 1, NULL),
(607, 'Decorative Films', NULL, 38, 2, 0, NULL, 1, NULL),
(608, 'Door & Window Accessories', NULL, 38, 2, 0, NULL, 1, NULL),
(609, 'Doors & Windows', NULL, 38, 2, 0, NULL, 1, NULL),
(610, 'Earthwork Categorys', NULL, 38, 2, 0, NULL, 1, NULL),
(611, 'Elevators & Elevator Parts', NULL, 38, 2, 0, NULL, 1, NULL),
(612, 'Escalators & Escalator Parts', NULL, 38, 2, 0, NULL, 1, NULL),
(613, 'Faucets, Mixers & Taps', NULL, 38, 2, 0, NULL, 1, NULL),
(614, 'Fiberglass Wall Meshes', NULL, 38, 2, 0, NULL, 1, NULL),
(615, 'Fireplaces,Stoves', NULL, 38, 2, 0, NULL, 1, NULL),
(616, 'Fireproofing Materials', NULL, 38, 2, 0, NULL, 1, NULL),
(617, 'Floor Heating Systems & Parts', NULL, 38, 2, 0, NULL, 1, NULL),
(618, 'Flooring & Accessories', NULL, 38, 2, 0, NULL, 1, NULL),
(619, 'Formwork', NULL, 38, 2, 0, NULL, 1, NULL),
(620, 'Gates', NULL, 38, 2, 0, NULL, 1, NULL),
(621, 'Heat Insulation Materials', NULL, 38, 2, 0, NULL, 1, NULL),
(622, 'HVAC Systems & Parts', NULL, 38, 2, 0, NULL, 1, NULL),
(623, 'Kitchen', NULL, 38, 2, 0, NULL, 1, NULL),
(624, 'Ladders & Scaffoldings', NULL, 38, 2, 0, NULL, 1, NULL),
(625, 'Landscaping Stone', NULL, 38, 2, 0, NULL, 1, NULL),
(626, 'Masonry Materials', NULL, 38, 2, 0, NULL, 1, NULL),
(627, 'Metal Building Materials', NULL, 38, 2, 0, NULL, 1, NULL),
(628, 'Mosaics', NULL, 38, 2, 0, NULL, 1, NULL),
(629, 'Mouldings', NULL, 38, 2, 0, NULL, 1, NULL),
(630, 'Multifunctional Materials', NULL, 38, 2, 0, NULL, 1, NULL),
(631, 'Other Construction & Real Estate', NULL, 38, 2, 0, NULL, 1, NULL),
(632, 'Plastic Building Materials', NULL, 38, 2, 0, NULL, 1, NULL),
(633, 'Quarry Stone & Slabs', NULL, 38, 2, 0, NULL, 1, NULL),
(634, 'Real Estate', NULL, 38, 2, 0, NULL, 1, NULL),
(635, 'Soundproofing Materials', NULL, 38, 2, 0, NULL, 1, NULL),
(636, 'Stairs & Stair Parts', NULL, 38, 2, 0, NULL, 1, NULL),
(637, 'Stone Carvings and Sculptures', NULL, 38, 2, 0, NULL, 1, NULL),
(638, 'Sunrooms & Glass Houses', NULL, 38, 2, 0, NULL, 1, NULL),
(639, 'Tiles & Accessories', NULL, 38, 2, 0, NULL, 1, NULL),
(640, 'Timber', NULL, 38, 2, 0, NULL, 1, NULL),
(641, 'Tombstones and Monuments', NULL, 38, 2, 0, NULL, 1, NULL),
(642, 'Wallpapers/Wall Coating', NULL, 38, 2, 0, NULL, 1, NULL),
(643, 'Waterproofing Materials', NULL, 38, 2, 0, NULL, 1, NULL),
(644, 'Bakeware', NULL, 37, 2, 0, NULL, 1, NULL),
(645, 'Barware', NULL, 37, 2, 0, NULL, 1, NULL),
(646, 'Bathroom Categorys', NULL, 37, 2, 0, NULL, 1, NULL),
(647, 'Cooking Tools', NULL, 37, 2, 0, NULL, 1, NULL),
(648, 'Cookware', NULL, 37, 2, 0, NULL, 1, NULL),
(649, 'Garden Supplies', NULL, 37, 2, 0, NULL, 1, NULL),
(650, 'Home Decor', NULL, 37, 2, 0, NULL, 1, NULL),
(651, 'Home Storage & Organization', NULL, 37, 2, 0, NULL, 1, NULL),
(652, 'Household Chemicals', NULL, 37, 2, 0, NULL, 1, NULL),
(653, 'Household Cleaning Tools & Accessories', NULL, 37, 2, 0, NULL, 1, NULL),
(654, 'Household Sundries', NULL, 37, 2, 0, NULL, 1, NULL),
(655, 'Kitchen Knives & Accessories', NULL, 37, 2, 0, NULL, 1, NULL),
(656, 'Laundry Categorys', NULL, 37, 2, 0, NULL, 1, NULL),
(657, 'Pet Categorys', NULL, 37, 2, 0, NULL, 1, NULL),
(658, 'Tableware', NULL, 37, 2, 0, NULL, 1, NULL),
(659, 'Dinnerware', NULL, 37, 2, 0, NULL, 1, NULL),
(660, 'Drinkware', NULL, 37, 2, 0, NULL, 1, NULL),
(661, 'Baby Supplies & Categorys', NULL, 37, 2, 0, NULL, 1, NULL),
(662, 'Rain Gear', NULL, 37, 2, 0, NULL, 1, NULL),
(663, 'Lighters & Smoking Accessories', NULL, 37, 2, 0, NULL, 1, NULL),
(664, 'Emergency Lighting', NULL, 36, 2, 0, NULL, 1, NULL),
(665, 'Holiday Lighting', NULL, 36, 2, 0, NULL, 1, NULL),
(666, 'Indoor Lighting', NULL, 36, 2, 0, NULL, 1, NULL),
(667, 'LED Lighting', NULL, 36, 2, 0, NULL, 1, NULL),
(668, 'Lighting Accessories', NULL, 36, 2, 0, NULL, 1, NULL),
(669, 'Lighting Bulbs & Tubes', NULL, 36, 2, 0, NULL, 1, NULL),
(670, 'Other Lights & Lighting Categorys', NULL, 36, 2, 0, NULL, 1, NULL),
(671, 'Outdoor Lighting', NULL, 36, 2, 0, NULL, 1, NULL),
(672, 'Professional Lighting', NULL, 36, 2, 0, NULL, 1, NULL),
(673, 'LED Residential Lighting', NULL, 36, 2, 0, NULL, 1, NULL),
(674, 'LED Outdoor Lighting', NULL, 36, 2, 0, NULL, 1, NULL),
(675, 'Chandeliers & Pendant Lights', NULL, 36, 2, 0, NULL, 1, NULL),
(676, 'Ceiling Lights', NULL, 36, 2, 0, NULL, 1, NULL),
(677, 'Crystal Lights', NULL, 36, 2, 0, NULL, 1, NULL),
(678, 'Stage Lights', NULL, 36, 2, 0, NULL, 1, NULL),
(679, 'Street Lights', NULL, 36, 2, 0, NULL, 1, NULL),
(680, 'Energy Saving & Fluorescent', NULL, 36, 2, 0, NULL, 1, NULL),
(681, 'LED Landscape Lamps', NULL, 36, 2, 0, NULL, 1, NULL),
(682, 'LED Professional Lighting', NULL, 36, 2, 0, NULL, 1, NULL),
(683, 'LED Encapsulation Series', NULL, 36, 2, 0, NULL, 1, NULL),
(684, 'Antique Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(685, 'Baby Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(686, 'Bamboo Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(687, 'Children Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(688, 'Commercial Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(689, 'Folding Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(690, 'Furniture Accessories', NULL, 35, 2, 0, NULL, 1, NULL),
(691, 'Furniture Hardware', NULL, 35, 2, 0, NULL, 1, NULL),
(692, 'Furniture Parts', NULL, 35, 2, 0, NULL, 1, NULL),
(693, 'Glass Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(694, 'Home Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(695, 'Inflatable Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(696, 'Metal Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(697, 'Other Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(698, 'Outdoor Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(699, 'Plastic Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(700, 'Rattan / Wicker Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(701, 'Wood Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(702, 'Living Room Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(703, 'Bedroom Furniture', NULL, 35, 2, 0, NULL, 1, NULL),
(704, 'Agriculture Machinery & Equipment', NULL, 43, 2, 0, NULL, 1, NULL),
(705, 'Apparel & Textile Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(706, 'Building Material Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(707, 'Chemical Machinery & Equipment', NULL, 43, 2, 0, NULL, 1, NULL),
(708, 'Electronic Categorys Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(709, 'Energy & Mineral Equipment', NULL, 43, 2, 0, NULL, 1, NULL),
(710, 'Engineering & Construction Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(711, 'Food & Beverage Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(712, 'General Industrial Equipment', NULL, 43, 2, 0, NULL, 1, NULL),
(713, 'Home Category Making Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(714, 'Industry Laser Equipment', NULL, 43, 2, 0, NULL, 1, NULL),
(715, 'Machine Tool Equipment', NULL, 43, 2, 0, NULL, 1, NULL),
(716, 'Metal & Metallurgy Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(717, 'Other Machinery & Industry Equipment', NULL, 43, 2, 0, NULL, 1, NULL),
(718, 'Packaging Machine', NULL, 43, 2, 0, NULL, 1, NULL),
(719, 'Paper Categoryion Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(720, 'Pharmaceutical Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(721, 'Plastic & Rubber Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(722, 'Printing Machine', NULL, 43, 2, 0, NULL, 1, NULL),
(723, 'Refrigeration & Heat Exchange Equipment', NULL, 43, 2, 0, NULL, 1, NULL),
(724, 'Used Machinery & Equipment', NULL, 43, 2, 0, NULL, 1, NULL),
(725, 'Woodworking Machinery', NULL, 43, 2, 0, NULL, 1, NULL),
(726, 'Ball Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(727, 'Bearing Accessory', NULL, 42, 2, 0, NULL, 1, NULL),
(728, 'Bearings', NULL, 42, 2, 0, NULL, 1, NULL),
(729, 'Brass Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(730, 'Butterfly Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(731, 'Ceramic Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(732, 'Check Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(733, 'Custom Fabrication Services', NULL, 42, 2, 0, NULL, 1, NULL),
(734, 'Diaphragm Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(735, 'Filter Supplies', NULL, 42, 2, 0, NULL, 1, NULL),
(736, 'Flanges', NULL, 42, 2, 0, NULL, 1, NULL),
(737, 'Gaskets', NULL, 42, 2, 0, NULL, 1, NULL),
(738, 'Gate Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(739, 'General Mechanical Components Design Services', NULL, 42, 2, 0, NULL, 1, NULL),
(740, 'General Mechanical Components Stock', NULL, 42, 2, 0, NULL, 1, NULL),
(741, 'Industrial Brake', NULL, 42, 2, 0, NULL, 1, NULL),
(742, 'Linear Motion', NULL, 42, 2, 0, NULL, 1, NULL),
(743, 'Machine Tools Accessory', NULL, 42, 2, 0, NULL, 1, NULL),
(744, 'Manual Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(745, 'Motor Parts', NULL, 42, 2, 0, NULL, 1, NULL),
(746, 'Motors', NULL, 42, 2, 0, NULL, 1, NULL),
(747, 'Moulds', NULL, 42, 2, 0, NULL, 1, NULL),
(748, 'Needle Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(749, 'Other General Mechanical Components', NULL, 42, 2, 0, NULL, 1, NULL),
(750, 'Other Mechanical Parts', NULL, 42, 2, 0, NULL, 1, NULL),
(751, 'Pipe Fittings', NULL, 42, 2, 0, NULL, 1, NULL),
(752, 'Pneumatic & Hydraulic', NULL, 42, 2, 0, NULL, 1, NULL),
(753, 'Power Transmission', NULL, 42, 2, 0, NULL, 1, NULL),
(754, 'Pumps & Parts', NULL, 42, 2, 0, NULL, 1, NULL),
(755, 'Seals', NULL, 42, 2, 0, NULL, 1, NULL),
(756, 'Shafts', NULL, 42, 2, 0, NULL, 1, NULL),
(757, 'Solenoid Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(758, 'Used General Mechanical Components', NULL, 42, 2, 0, NULL, 1, NULL),
(759, 'Vacuum Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(760, 'Valve Parts', NULL, 42, 2, 0, NULL, 1, NULL),
(761, 'Valves', NULL, 42, 2, 0, NULL, 1, NULL),
(762, 'Welding & Soldering Supplies', NULL, 42, 2, 0, NULL, 1, NULL),
(763, 'Construction Tools', NULL, 41, 2, 0, NULL, 1, NULL),
(764, 'Garden Tools', NULL, 41, 2, 0, NULL, 1, NULL),
(765, 'Hand Tools', NULL, 41, 2, 0, NULL, 1, NULL),
(766, 'Lifting Tools', NULL, 41, 2, 0, NULL, 1, NULL),
(767, 'Material Handling Tools', NULL, 41, 2, 0, NULL, 1, NULL),
(768, 'Other Tools', NULL, 41, 2, 0, NULL, 1, NULL),
(769, 'Power Tool Accessories', NULL, 41, 2, 0, NULL, 1, NULL),
(770, 'Power Tools', NULL, 41, 2, 0, NULL, 1, NULL),
(771, 'Tool Design Services', NULL, 41, 2, 0, NULL, 1, NULL),
(772, 'Tool Parts', NULL, 41, 2, 0, NULL, 1, NULL),
(773, 'Tool Processing Services', NULL, 41, 2, 0, NULL, 1, NULL),
(774, 'Tool Sets', NULL, 41, 2, 0, NULL, 1, NULL),
(775, 'Tool Stock', NULL, 41, 2, 0, NULL, 1, NULL),
(776, 'Tools Packaging', NULL, 41, 2, 0, NULL, 1, NULL),
(777, 'Used Tools', NULL, 41, 2, 0, NULL, 1, NULL),
(778, 'Electric Drill', NULL, 41, 2, 0, NULL, 1, NULL),
(779, 'Knife', NULL, 41, 2, 0, NULL, 1, NULL),
(780, 'Hand Carts & Trolleys', NULL, 41, 2, 0, NULL, 1, NULL),
(781, 'Lawn Mower', NULL, 41, 2, 0, NULL, 1, NULL),
(782, 'Sander', NULL, 41, 2, 0, NULL, 1, NULL),
(783, 'Abrasive Tools', NULL, 40, 2, 0, NULL, 1, NULL),
(784, 'Abrasives', NULL, 40, 2, 0, NULL, 1, NULL),
(785, 'Brackets', NULL, 40, 2, 0, NULL, 1, NULL),
(786, 'Chains', NULL, 40, 2, 0, NULL, 1, NULL),
(787, 'Clamps', NULL, 40, 2, 0, NULL, 1, NULL),
(788, 'Fasteners', NULL, 40, 2, 0, NULL, 1, NULL),
(789, 'Hardware Stock', NULL, 40, 2, 0, NULL, 1, NULL),
(790, 'Hooks', NULL, 40, 2, 0, NULL, 1, NULL),
(791, 'Mould Design & Processing Services', NULL, 40, 2, 0, NULL, 1, NULL),
(792, 'Other Hardware', NULL, 40, 2, 0, NULL, 1, NULL),
(793, 'Springs', NULL, 40, 2, 0, NULL, 1, NULL),
(794, 'Used Hardware', NULL, 40, 2, 0, NULL, 1, NULL),
(795, 'Bolts', NULL, 40, 2, 0, NULL, 1, NULL),
(796, 'Screws', NULL, 40, 2, 0, NULL, 1, NULL),
(797, 'Nuts', NULL, 40, 2, 0, NULL, 1, NULL),
(798, 'Nails', NULL, 40, 2, 0, NULL, 1, NULL),
(799, 'Anchors', NULL, 40, 2, 0, NULL, 1, NULL),
(800, 'Rivets', NULL, 40, 2, 0, NULL, 1, NULL),
(801, 'Washers', NULL, 40, 2, 0, NULL, 1, NULL),
(802, 'Other Fasteners', NULL, 40, 2, 0, NULL, 1, NULL),
(803, 'Analyzers', NULL, 39, 2, 0, NULL, 1, NULL),
(804, 'Counters', NULL, 39, 2, 0, NULL, 1, NULL),
(805, 'Electrical Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(806, 'Electronic Measuring Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(807, 'Flow Measuring Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(808, 'Instrument Parts & Accessories', NULL, 39, 2, 0, NULL, 1, NULL),
(809, 'Lab Supplies', NULL, 39, 2, 0, NULL, 1, NULL),
(810, 'Level Measuring Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(811, 'Measuring & Analysing Instrument Design Services', NULL, 39, 2, 0, NULL, 1, NULL),
(812, 'Measuring & Analysing Instrument Processing Services', NULL, 39, 2, 0, NULL, 1, NULL),
(813, 'Measuring & Analysing Instrument Stocks', NULL, 39, 2, 0, NULL, 1, NULL),
(814, 'Measuring & Gauging Tools', NULL, 39, 2, 0, NULL, 1, NULL),
(815, 'Optical Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(816, 'Other Measuring & Analysing Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(817, 'Physical Measuring Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(818, 'Pressure Measuring Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(819, 'Temperature Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(820, 'Testing Equipment', NULL, 39, 2, 0, NULL, 1, NULL),
(821, 'Timers', NULL, 39, 2, 0, NULL, 1, NULL),
(822, 'Used Measuring & Analysing Instruments', NULL, 39, 2, 0, NULL, 1, NULL),
(823, 'Weighing Scales', NULL, 39, 2, 0, NULL, 1, NULL),
(824, 'Aluminum', NULL, 44, 2, 0, NULL, 1, NULL),
(825, 'Asbestos Categorys', NULL, 44, 2, 0, NULL, 1, NULL),
(826, 'Asbestos Sheets', NULL, 44, 2, 0, NULL, 1, NULL),
(827, 'Barbed Wire', NULL, 44, 2, 0, NULL, 1, NULL),
(828, 'Billets', NULL, 44, 2, 0, NULL, 1, NULL),
(829, 'Carbon', NULL, 44, 2, 0, NULL, 1, NULL),
(830, 'Carbon Fiber', NULL, 44, 2, 0, NULL, 1, NULL),
(831, 'Cast & Forged', NULL, 44, 2, 0, NULL, 1, NULL),
(832, 'Cemented Carbide', NULL, 44, 2, 0, NULL, 1, NULL),
(833, 'Ceramic Fiber Categorys', NULL, 44, 2, 0, NULL, 1, NULL),
(834, 'Ceramics', NULL, 44, 2, 0, NULL, 1, NULL),
(835, 'Copper', NULL, 44, 2, 0, NULL, 1, NULL),
(836, 'Copper Forged', NULL, 44, 2, 0, NULL, 1, NULL),
(837, 'Fiberglass Categorys', NULL, 44, 2, 0, NULL, 1, NULL),
(838, 'Glass', NULL, 44, 2, 0, NULL, 1, NULL),
(839, 'Graphite Categorys', NULL, 44, 2, 0, NULL, 1, NULL),
(840, 'Ingots', NULL, 44, 2, 0, NULL, 1, NULL),
(841, 'Iron', NULL, 44, 2, 0, NULL, 1, NULL),
(842, 'Lead', NULL, 44, 2, 0, NULL, 1, NULL),
(843, 'Lime', NULL, 44, 2, 0, NULL, 1, NULL),
(844, 'Magnetic Materials', NULL, 44, 2, 0, NULL, 1, NULL),
(845, 'Metal Scrap', NULL, 44, 2, 0, NULL, 1, NULL),
(846, 'Metal Slabs', NULL, 44, 2, 0, NULL, 1, NULL),
(847, 'Mineral Wool', NULL, 44, 2, 0, NULL, 1, NULL),
(848, 'Molybdenum', NULL, 44, 2, 0, NULL, 1, NULL),
(849, 'Nickel', NULL, 44, 2, 0, NULL, 1, NULL),
(850, 'Non-Metallic Mineral Deposit', NULL, 44, 2, 0, NULL, 1, NULL),
(851, 'Ore', NULL, 44, 2, 0, NULL, 1, NULL),
(852, 'Other Metals & Metal Categorys', NULL, 44, 2, 0, NULL, 1, NULL),
(853, 'Other Non-Metallic Minerals & Categorys', NULL, 44, 2, 0, NULL, 1, NULL),
(854, 'Pig Iron', NULL, 44, 2, 0, NULL, 1, NULL),
(855, 'Quartz Categorys', NULL, 44, 2, 0, NULL, 1, NULL),
(856, 'Rare Earth & Categorys', NULL, 44, 2, 0, NULL, 1, NULL),
(857, 'Rare Earth Magnets', NULL, 44, 2, 0, NULL, 1, NULL),
(858, 'Refractory', NULL, 44, 2, 0, NULL, 1, NULL),
(859, 'Steel', NULL, 44, 2, 0, NULL, 1, NULL),
(860, 'Titanium', NULL, 44, 2, 0, NULL, 1, NULL),
(861, 'Tungsten', NULL, 44, 2, 0, NULL, 1, NULL),
(862, 'Wire Mesh', NULL, 44, 2, 0, NULL, 1, NULL),
(863, 'Zinc', NULL, 44, 2, 0, NULL, 1, NULL),
(864, 'Gas Disposal', NULL, 48, 2, 0, NULL, 1, NULL),
(865, 'Noise Reduction Device', NULL, 48, 2, 0, NULL, 1, NULL),
(866, 'Other Environmental Categorys', NULL, 48, 2, 0, NULL, 1, NULL),
(867, 'Other Excess Inventory', NULL, 48, 2, 0, NULL, 1, NULL),
(868, 'Recycling', NULL, 48, 2, 0, NULL, 1, NULL),
(869, 'Sewer', NULL, 48, 2, 0, NULL, 1, NULL),
(870, 'Waste Management', NULL, 48, 2, 0, NULL, 1, NULL),
(871, 'Water Treatment', NULL, 48, 2, 0, NULL, 1, NULL),
(872, 'Textile Waste', NULL, 48, 2, 0, NULL, 1, NULL),
(873, 'Waste Paper', NULL, 48, 2, 0, NULL, 1, NULL),
(874, 'Other Recycling Categorys', NULL, 48, 2, 0, NULL, 1, NULL),
(875, 'Plastic Processing Service', NULL, 47, 2, 0, NULL, 1, NULL),
(876, 'Plastic Categorys', NULL, 47, 2, 0, NULL, 1, NULL),
(877, 'Plastic Projects', NULL, 47, 2, 0, NULL, 1, NULL),
(878, 'Plastic Raw Materials', NULL, 47, 2, 0, NULL, 1, NULL),
(879, 'Plastic Stocks', NULL, 47, 2, 0, NULL, 1, NULL),
(880, 'Recycled Plastic', NULL, 47, 2, 0, NULL, 1, NULL),
(881, 'Recycled Rubber', NULL, 47, 2, 0, NULL, 1, NULL),
(882, 'Rubber Processing Service', NULL, 47, 2, 0, NULL, 1, NULL),
(883, 'Rubber Categorys', NULL, 47, 2, 0, NULL, 1, NULL),
(884, 'Rubber Projects', NULL, 47, 2, 0, NULL, 1, NULL),
(885, 'Rubber Raw Materials', NULL, 47, 2, 0, NULL, 1, NULL);
INSERT INTO `edm_product_category` (`category_id`, `name`, `syn_name`, `parent_id`, `level`, `position`, `desc`, `status`, `date_create`) VALUES
(886, 'Rubber Stocks', NULL, 47, 2, 0, NULL, 1, NULL),
(887, 'Plastic Cards', NULL, 47, 2, 0, NULL, 1, NULL),
(888, 'PVC', NULL, 47, 2, 0, NULL, 1, NULL),
(889, 'Plastic Tubes', NULL, 47, 2, 0, NULL, 1, NULL),
(890, 'HDPE', NULL, 47, 2, 0, NULL, 1, NULL),
(891, 'Rubber Hoses', NULL, 47, 2, 0, NULL, 1, NULL),
(892, 'Plastic Sheets', NULL, 47, 2, 0, NULL, 1, NULL),
(893, 'LDPE', NULL, 47, 2, 0, NULL, 1, NULL),
(894, 'Agricultural Rubber', NULL, 47, 2, 0, NULL, 1, NULL),
(895, 'Biodiesel', NULL, 45, 2, 0, NULL, 0, NULL),
(896, 'Biogas', NULL, 45, 2, 0, NULL, 0, NULL),
(897, 'Charcoal', NULL, 45, 2, 0, NULL, 0, NULL),
(898, 'Coal', NULL, 45, 2, 0, NULL, 0, NULL),
(899, 'Coal Gas', NULL, 45, 2, 0, NULL, 0, NULL),
(900, 'Coke Fuel', NULL, 45, 2, 0, NULL, 0, NULL),
(901, 'Crude Oil', NULL, 45, 2, 0, NULL, 0, NULL),
(902, 'Electricity Generation', NULL, 45, 2, 0, NULL, 0, NULL),
(903, 'Petrochemical Categorys', NULL, 45, 2, 0, NULL, 0, NULL),
(904, 'Solar Energy Categorys', NULL, 45, 2, 0, NULL, 0, NULL),
(905, 'Industrial Fuel', NULL, 45, 2, 0, NULL, 0, NULL),
(906, 'Natural Gas', NULL, 45, 2, 0, NULL, 0, NULL),
(907, 'Other Energy Related Categorys', NULL, 45, 2, 0, NULL, 0, NULL),
(908, 'Wood Pellets', NULL, 45, 2, 0, NULL, 0, NULL),
(909, 'Solar Energy Systems', NULL, 45, 2, 0, NULL, 0, NULL),
(910, 'Lubricant', NULL, 45, 2, 0, NULL, 0, NULL),
(911, 'Diesel Fuel', NULL, 45, 2, 0, NULL, 0, NULL),
(912, 'Solar Chargers', NULL, 45, 2, 0, NULL, 0, NULL),
(913, 'Solar Collectors', NULL, 45, 2, 0, NULL, 0, NULL),
(914, 'Bitumen', NULL, 45, 2, 0, NULL, 0, NULL),
(915, 'Additives', NULL, 46, 2, 0, NULL, 1, NULL),
(916, 'Adhesives & Sealants', NULL, 46, 2, 0, NULL, 1, NULL),
(917, 'Agrochemicals', NULL, 46, 2, 0, NULL, 1, NULL),
(918, 'Basic Organic Chemicals', NULL, 46, 2, 0, NULL, 1, NULL),
(919, 'Catalysts & Chemical Auxiliary Agents', NULL, 46, 2, 0, NULL, 1, NULL),
(920, 'Chemical Reagent Categorys', NULL, 46, 2, 0, NULL, 1, NULL),
(921, 'Chemical Waste', NULL, 46, 2, 0, NULL, 1, NULL),
(922, 'Custom Chemical Services', NULL, 46, 2, 0, NULL, 1, NULL),
(923, 'Daily Chemical Raw Materials', NULL, 46, 2, 0, NULL, 1, NULL),
(924, 'Flavour & Fragrance', NULL, 46, 2, 0, NULL, 1, NULL),
(925, 'Inorganic Chemicals', NULL, 46, 2, 0, NULL, 1, NULL),
(926, 'Non-Explosive Demolition Agents', NULL, 46, 2, 0, NULL, 1, NULL),
(927, 'Organic Intermediates', NULL, 46, 2, 0, NULL, 1, NULL),
(928, 'Other Chemicals', NULL, 46, 2, 0, NULL, 1, NULL),
(929, 'Paints & Coatings', NULL, 46, 2, 0, NULL, 1, NULL),
(930, 'Pharmaceuticals', NULL, 46, 2, 0, NULL, 1, NULL),
(931, 'Pigment & Dyestuff', NULL, 46, 2, 0, NULL, 1, NULL),
(932, 'Polymer', NULL, 46, 2, 0, NULL, 1, NULL),
(933, 'Food Additive Categorys', NULL, 46, 2, 0, NULL, 1, NULL),
(934, 'Fertilizer', NULL, 46, 2, 0, NULL, 1, NULL),
(935, 'Adhesive Tape', NULL, 49, 2, 0, NULL, 1, NULL),
(936, 'Agricultural Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(937, 'Aluminum Foil', NULL, 49, 2, 0, NULL, 1, NULL),
(938, 'Apparel Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(939, 'Blister Cards', NULL, 49, 2, 0, NULL, 1, NULL),
(940, 'Bottles', NULL, 49, 2, 0, NULL, 1, NULL),
(941, 'Cans', NULL, 49, 2, 0, NULL, 1, NULL),
(942, 'Chemical Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(943, 'Composite Packaging Materials', NULL, 49, 2, 0, NULL, 1, NULL),
(944, 'Cosmetics Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(945, 'Electronics Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(946, 'Food Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(947, 'Gift Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(948, 'Handles', NULL, 49, 2, 0, NULL, 1, NULL),
(949, 'Hot Stamping Foil', NULL, 49, 2, 0, NULL, 1, NULL),
(950, 'Jars', NULL, 49, 2, 0, NULL, 1, NULL),
(951, 'Lids, Bottle Caps, Closures', NULL, 49, 2, 0, NULL, 1, NULL),
(952, 'Media Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(953, 'Metallized Film', NULL, 49, 2, 0, NULL, 1, NULL),
(954, 'Other Packaging Applications', NULL, 49, 2, 0, NULL, 1, NULL),
(955, 'Other Packaging Materials', NULL, 49, 2, 0, NULL, 1, NULL),
(956, 'Packaging Bags', NULL, 49, 2, 0, NULL, 1, NULL),
(957, 'Packaging Boxes', NULL, 49, 2, 0, NULL, 1, NULL),
(958, 'Packaging Labels', NULL, 49, 2, 0, NULL, 1, NULL),
(959, 'Packaging Category Stocks', NULL, 49, 2, 0, NULL, 1, NULL),
(960, 'Packaging Rope', NULL, 49, 2, 0, NULL, 1, NULL),
(961, 'Packaging Trays', NULL, 49, 2, 0, NULL, 1, NULL),
(962, 'Packaging Tubes', NULL, 49, 2, 0, NULL, 1, NULL),
(963, 'Paper & Paperboard', NULL, 49, 2, 0, NULL, 1, NULL),
(964, 'Paper Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(965, 'Pharmaceutical Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(966, 'Plastic Film', NULL, 49, 2, 0, NULL, 1, NULL),
(967, 'Plastic Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(968, 'Printing Materials', NULL, 49, 2, 0, NULL, 1, NULL),
(969, 'Printing Services', NULL, 49, 2, 0, NULL, 1, NULL),
(970, 'Protective Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(971, 'Pulp', NULL, 49, 2, 0, NULL, 1, NULL),
(972, 'Shrink Film', NULL, 49, 2, 0, NULL, 1, NULL),
(973, 'Strapping', NULL, 49, 2, 0, NULL, 1, NULL),
(974, 'Stretch Film', NULL, 49, 2, 0, NULL, 1, NULL),
(975, 'Tobacco Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(976, 'Transport Packaging', NULL, 49, 2, 0, NULL, 1, NULL),
(977, 'Art Supplies', NULL, 50, 2, 0, NULL, 1, NULL),
(978, 'Badge Holder & Accessories', NULL, 50, 2, 0, NULL, 1, NULL),
(979, 'Board', NULL, 50, 2, 0, NULL, 1, NULL),
(980, 'Board Eraser', NULL, 50, 2, 0, NULL, 1, NULL),
(981, 'Book Cover', NULL, 50, 2, 0, NULL, 1, NULL),
(982, 'Books', NULL, 50, 2, 0, NULL, 1, NULL),
(983, 'Calculator', NULL, 50, 2, 0, NULL, 1, NULL),
(984, 'Calendar', NULL, 50, 2, 0, NULL, 1, NULL),
(985, 'Clipboard', NULL, 50, 2, 0, NULL, 1, NULL),
(986, 'Correction Supplies', NULL, 50, 2, 0, NULL, 1, NULL),
(987, 'Desk Organizer', NULL, 50, 2, 0, NULL, 1, NULL),
(988, 'Drafting Supplies', NULL, 50, 2, 0, NULL, 1, NULL),
(989, 'Easels', NULL, 50, 2, 0, NULL, 1, NULL),
(990, 'Educational Supplies', NULL, 50, 2, 0, NULL, 1, NULL),
(991, 'Filing Categorys', NULL, 50, 2, 0, NULL, 1, NULL),
(992, 'Letter Pad / Paper', NULL, 50, 2, 0, NULL, 1, NULL),
(993, 'Magazines', NULL, 50, 2, 0, NULL, 1, NULL),
(994, 'Map', NULL, 50, 2, 0, NULL, 1, NULL),
(995, 'Notebooks & Writing Pads', NULL, 50, 2, 0, NULL, 1, NULL),
(996, 'Office Adhesives & Tapes', NULL, 50, 2, 0, NULL, 1, NULL),
(997, 'Office Binding Supplies', NULL, 50, 2, 0, NULL, 1, NULL),
(998, 'Office Cutting Supplies', NULL, 50, 2, 0, NULL, 1, NULL),
(999, 'Office Equipment', NULL, 50, 2, 0, NULL, 1, NULL),
(1000, 'Office Paper', NULL, 50, 2, 0, NULL, 1, NULL),
(1001, 'Other Office & School Supplies', NULL, 50, 2, 0, NULL, 1, NULL),
(1002, 'Paper Envelopes', NULL, 50, 2, 0, NULL, 1, NULL),
(1003, 'Pencil Cases & Bags', NULL, 50, 2, 0, NULL, 1, NULL),
(1004, 'Pencil Sharpeners', NULL, 50, 2, 0, NULL, 1, NULL),
(1005, 'Printer Supplies', NULL, 50, 2, 0, NULL, 1, NULL),
(1006, 'Stamps', NULL, 50, 2, 0, NULL, 1, NULL),
(1007, 'Stationery Set', NULL, 50, 2, 0, NULL, 1, NULL),
(1008, 'Stencils', NULL, 50, 2, 0, NULL, 1, NULL),
(1009, 'Writing Accessories', NULL, 50, 2, 0, NULL, 1, NULL),
(1010, 'Writing Instruments', NULL, 50, 2, 0, NULL, 1, NULL),
(1011, 'Yellow Pages', NULL, 50, 2, 0, NULL, 1, NULL),
(1012, 'Advertising Equipment', NULL, 51, 2, 0, NULL, 1, NULL),
(1013, 'Cargo & Storage Equipment', NULL, 51, 2, 0, NULL, 1, NULL),
(1014, 'Commercial Laundry Equipment', NULL, 51, 2, 0, NULL, 1, NULL),
(1015, 'Financial Equipment', NULL, 51, 2, 0, NULL, 1, NULL),
(1016, 'Funeral Supplies', NULL, 51, 2, 0, NULL, 1, NULL),
(1017, 'Other Service Equipment', NULL, 51, 2, 0, NULL, 1, NULL),
(1018, 'Restaurant & Hotel Supplies', NULL, 51, 2, 0, NULL, 1, NULL),
(1019, 'Store & Supermarket Supplies', NULL, 51, 2, 0, NULL, 1, NULL),
(1020, 'Trade Show Equipment', NULL, 51, 2, 0, NULL, 1, NULL),
(1021, 'Vending Machines', NULL, 51, 2, 0, NULL, 1, NULL),
(1022, 'Wedding Supplies', NULL, 51, 2, 0, NULL, 1, NULL),
(1023, 'Display Racks', NULL, 51, 2, 0, NULL, 1, NULL),
(1024, 'Advertising Players', NULL, 51, 2, 0, NULL, 1, NULL),
(1025, 'Advertising Light Boxes', NULL, 51, 2, 0, NULL, 1, NULL),
(1026, 'Hotel Amenities', NULL, 51, 2, 0, NULL, 1, NULL),
(1027, 'POS Systems', NULL, 51, 2, 0, NULL, 1, NULL),
(1028, 'Supermarket Shelves', NULL, 51, 2, 0, NULL, 1, NULL),
(1029, 'Stacking Racks & Shelves', NULL, 51, 2, 0, NULL, 1, NULL),
(1030, 'Refrigeration Equipment', NULL, 51, 2, 0, NULL, 1, NULL),
(1031, 'Trade Show Tent', NULL, 51, 2, 0, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `edm_product_category_relate`
--

CREATE TABLE `edm_product_category_relate` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_product_link`
--

CREATE TABLE `edm_product_link` (
  `link_id` int(10) UNSIGNED NOT NULL COMMENT 'Link ID',
  `company_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '会员ID',
  `product_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Product ID',
  `link_type_id` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Link Type ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品归档表';

-- --------------------------------------------------------

--
-- 表的结构 `edm_product_link_type`
--

CREATE TABLE `edm_product_link_type` (
  `link_type_id` smallint(5) UNSIGNED NOT NULL COMMENT 'Link Type ID',
  `code` varchar(32) DEFAULT NULL COMMENT 'Code'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品归档种类';

--
-- 转存表中的数据 `edm_product_link_type`
--

INSERT INTO `edm_product_link_type` (`link_type_id`, `code`) VALUES
(1, 'top_sell'),
(2, 'new_arrival'),
(3, 'flash_sale'),
(4, 'free_shipping');

-- --------------------------------------------------------

--
-- 表的结构 `edm_send_log`
--

CREATE TABLE `edm_send_log` (
  `log_id` bigint(20) UNSIGNED NOT NULL,
  `message_id` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `send_from` varchar(255) DEFAULT NULL,
  `send_to` varchar(255) DEFAULT NULL,
  `type` smallint(5) UNSIGNED DEFAULT '0' COMMENT '0未验证 1灰名单 2白名单  -1黑名单',
  `user_id` int(11) DEFAULT NULL,
  `esp_server` varchar(255) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  `template_code` varchar(255) DEFAULT NULL COMMENT '模版唯一标识 存放md5值',
  `template_content` text,
  `queue_id` int(10) DEFAULT NULL,
  `queue_status` smallint(5) DEFAULT '0' COMMENT '队列状态 1发送中 2已发送',
  `server_id` smallint(5) DEFAULT NULL,
  `event_reject` smallint(5) NOT NULL DEFAULT '0',
  `event_delivered` smallint(5) NOT NULL DEFAULT '0',
  `event_dropped` smallint(5) NOT NULL DEFAULT '0',
  `event_bounced` smallint(5) NOT NULL DEFAULT '0',
  `event_failed` smallint(5) NOT NULL DEFAULT '0',
  `event_complaine` smallint(5) NOT NULL DEFAULT '0',
  `event_unsubcribe` smallint(5) NOT NULL DEFAULT '0',
  `event_click` smallint(5) NOT NULL DEFAULT '0',
  `event_open` smallint(5) NOT NULL DEFAULT '0',
  `event_send` smallint(5) NOT NULL DEFAULT '0',
  `date_event` datetime DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_server`
--

CREATE TABLE `edm_server` (
  `server_id` smallint(5) UNSIGNED NOT NULL,
  `server_name` varchar(255) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `port` int(10) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `api_url` varchar(255) DEFAULT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `count_reject` bigint(20) NOT NULL DEFAULT '0',
  `count_delivered` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_dropped` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_bounced` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_failed` bigint(20) NOT NULL DEFAULT '0',
  `count_complaine` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_unsubcribe` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_click` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_open` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_send` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `rate_lock_complain` decimal(5,2) DEFAULT '0.00',
  `rate_lock` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '锁定率',
  `date_lock` datetime DEFAULT NULL,
  `rate_white` decimal(5,2) UNSIGNED NOT NULL DEFAULT '0.00' COMMENT '白名单率',
  `date_white` datetime DEFAULT NULL,
  `status` smallint(5) NOT NULL DEFAULT '0' COMMENT '0未启用 1已启用 -1已失效',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_server`
--

INSERT INTO `edm_server` (`server_id`, `server_name`, `host`, `username`, `password`, `port`, `ip`, `api_url`, `api_key`, `count_reject`, `count_delivered`, `count_dropped`, `count_bounced`, `count_failed`, `count_complaine`, `count_unsubcribe`, `count_click`, `count_open`, `count_send`, `rate_lock_complain`, `rate_lock`, `date_lock`, `rate_white`, `date_white`, `status`, `date_create`) VALUES
(1, 'ioego.com', 'smtp.mailgun.org', 'postmaster@ioego.com', 'ba730970857080e5112c0ad8709fb55c', 25, '209.61.151.224', 'https://api.mailgun.net/v3/ioego.com', '1950be98b298cc97aa7806d86d0bfde0', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', NULL, '0.00', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `edm_server_log`
--

CREATE TABLE `edm_server_log` (
  `log_id` int(11) UNSIGNED NOT NULL,
  `server_id` smallint(5) UNSIGNED NOT NULL,
  `count_accepted` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_delivered` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_click` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_open` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_failed` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_failed_tem_esp` bigint(20) NOT NULL DEFAULT '0',
  `count_failed_per_sbounce` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_failed_per_sunsubscribe` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count_failed_per_scomplaint` bigint(20) NOT NULL DEFAULT '0',
  `count_failed_per_bounce` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL,
  `log_type` smallint(5) DEFAULT '0' COMMENT '0 month 1 day 2 hour',
  `log_json` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_server_log`
--

INSERT INTO `edm_server_log` (`log_id`, `server_id`, `count_accepted`, `count_delivered`, `count_click`, `count_open`, `count_failed`, `count_failed_tem_esp`, `count_failed_per_sbounce`, `count_failed_per_sunsubscribe`, `count_failed_per_scomplaint`, `count_failed_per_bounce`, `date_create`, `log_type`, `log_json`) VALUES
(16, 14, 8507, 0, 169, 625, 1239, 823, 12, 0, 0, 497, '2016-04-14 10:40:43', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":8507,"total":8507},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":823},"permanent":{"suppress-bounce":12,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":497,"total":1239}},"opened":{"total":625},"clicked":{"total":169},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(17, 13, 10388, 8663, 172, 591, 1559, 665, 15, 0, 0, 612, '2016-04-14 10:40:43', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":10388,"total":10388},"delivered":{"smtp":8663,"http":0,"total":8663},"failed":{"temporary":{"espblock":665},"permanent":{"suppress-bounce":15,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":612,"total":1559}},"opened":{"total":591},"clicked":{"total":172},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(18, 10, 10549, 8783, 198, 687, 1568, 411, 19, 0, 0, 636, '2016-04-14 10:40:43', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":10549,"total":10549},"delivered":{"smtp":8783,"http":0,"total":8783},"failed":{"temporary":{"espblock":411},"permanent":{"suppress-bounce":19,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":636,"total":1568}},"opened":{"total":687},"clicked":{"total":198},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(19, 9, 9231, 7650, 190, 658, 1399, 946, 20, 0, 0, 523, '2016-04-14 10:40:43', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":9231,"total":9231},"delivered":{"smtp":7650,"http":0,"total":7650},"failed":{"temporary":{"espblock":946},"permanent":{"suppress-bounce":20,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":523,"total":1399}},"opened":{"total":658},"clicked":{"total":190},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(20, 8, 10027, 8392, 191, 635, 1496, 1048, 18, 0, 0, 573, '2016-04-14 10:40:43', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":10027,"total":10027},"delivered":{"smtp":8392,"http":0,"total":8392},"failed":{"temporary":{"espblock":1048},"permanent":{"suppress-bounce":18,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":573,"total":1496}},"opened":{"total":635},"clicked":{"total":191},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(21, 4, 0, 7959, 154, 578, 2514, 1569, 26, 0, 0, 588, '2016-04-14 10:40:43', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":7959,"http":0,"total":7959},"failed":{"temporary":{"espblock":1569},"permanent":{"suppress-bounce":26,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":588,"total":2514}},"opened":{"total":578},"clicked":{"total":154},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(22, 3, 14056, 11410, 0, 0, 2405, 12181, 14, 0, 0, 799, '2016-04-14 10:40:43', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":14056,"total":14056},"delivered":{"smtp":11410,"http":0,"total":11410},"failed":{"temporary":{"espblock":12181},"permanent":{"suppress-bounce":14,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":799,"total":2405}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(23, 2, 13658, 11372, 218, 1188, 2195, 4127, 35, 0, 0, 795, '2016-04-14 10:40:43', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":13658,"total":13658},"delivered":{"smtp":11372,"http":0,"total":11372},"failed":{"temporary":{"espblock":4127},"permanent":{"suppress-bounce":35,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":795,"total":2195}},"opened":{"total":1188},"clicked":{"total":218},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(24, 1, 14602, 11987, 242, 1626, 2476, 1427, 93, 0, 4, 687, '2016-04-14 10:40:43', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":14602,"total":14602},"delivered":{"smtp":11987,"http":0,"total":11987},"failed":{"temporary":{"espblock":1427},"permanent":{"suppress-bounce":93,"suppress-unsubscribe":0,"suppress-complaint":4,"bounce":687,"total":2476}},"opened":{"total":1626},"clicked":{"total":242},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(25, 14, 916, 734, 25, 78, 159, 6, 0, 0, 0, 81, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":916,"total":916},"delivered":{"smtp":734,"http":0,"total":734},"failed":{"temporary":{"espblock":6},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":81,"total":159}},"opened":{"total":78},"clicked":{"total":25},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(26, 13, 1297, 1091, 0, 4, 168, 20, 0, 0, 0, 80, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":1297,"total":1297},"delivered":{"smtp":1091,"http":0,"total":1091},"failed":{"temporary":{"espblock":20},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":80,"total":168}},"opened":{"total":4},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(27, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(28, 10, 1524, 1257, 12, 85, 228, 8, 1, 0, 0, 113, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":1524,"total":1524},"delivered":{"smtp":1257,"http":0,"total":1257},"failed":{"temporary":{"espblock":8},"permanent":{"suppress-bounce":1,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":113,"total":228}},"opened":{"total":85},"clicked":{"total":12},"unsubscribed":{"total":0},"complained":{"total":1}}]},"http_response_code":200}'),
(29, 9, 692, 567, 25, 81, 111, 4, 4, 0, 0, 59, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":692,"total":692},"delivered":{"smtp":567,"http":0,"total":567},"failed":{"temporary":{"espblock":4},"permanent":{"suppress-bounce":4,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":59,"total":111}},"opened":{"total":81},"clicked":{"total":25},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(30, 8, 924, 823, 17, 109, 141, 59, 3, 0, 0, 54, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":924,"total":924},"delivered":{"smtp":823,"http":0,"total":823},"failed":{"temporary":{"espblock":59},"permanent":{"suppress-bounce":3,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":54,"total":141}},"opened":{"total":109},"clicked":{"total":17},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(31, 4, 0, 0, 1, 10, 42, 0, 0, 0, 0, 0, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":42}},"opened":{"total":10},"clicked":{"total":1},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(32, 3, 1598, 1275, 0, 0, 272, 1004, 2, 0, 0, 118, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":1598,"total":1598},"delivered":{"smtp":1275,"http":0,"total":1275},"failed":{"temporary":{"espblock":1004},"permanent":{"suppress-bounce":2,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":118,"total":272}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(33, 14, 8585, 7131, 169, 629, 1250, 824, 12, 0, 0, 502, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":8585,"total":8585},"delivered":{"smtp":7131,"http":0,"total":7131},"failed":{"temporary":{"espblock":824},"permanent":{"suppress-bounce":12,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":502,"total":1250}},"opened":{"total":629},"clicked":{"total":169},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(34, 2, 799, 660, 4, 41, 175, 59, 0, 0, 0, 56, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":799,"total":799},"delivered":{"smtp":660,"http":0,"total":660},"failed":{"temporary":{"espblock":59},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":56,"total":175}},"opened":{"total":41},"clicked":{"total":4},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(35, 13, 10419, 8676, 172, 591, 1562, 666, 15, 0, 0, 614, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":10419,"total":10419},"delivered":{"smtp":8676,"http":0,"total":8676},"failed":{"temporary":{"espblock":666},"permanent":{"suppress-bounce":15,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":614,"total":1562}},"opened":{"total":591},"clicked":{"total":172},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(36, 11, 4506, 3757, 121, 352, 596, 984, 6, 0, 0, 274, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":4506,"total":4506},"delivered":{"smtp":3757,"http":0,"total":3757},"failed":{"temporary":{"espblock":984},"permanent":{"suppress-bounce":6,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":274,"total":596}},"opened":{"total":352},"clicked":{"total":121},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(37, 10, 10601, 8824, 198, 693, 1570, 411, 19, 0, 0, 636, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":10601,"total":10601},"delivered":{"smtp":8824,"http":0,"total":8824},"failed":{"temporary":{"espblock":411},"permanent":{"suppress-bounce":19,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":636,"total":1570}},"opened":{"total":693},"clicked":{"total":198},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(38, 1, 1193, 846, 10, 82, 286, 156, 5, 0, 0, 84, '2016-04-14 10:48:27', 1, '{"http_response_body":{"end":"Thu, 14 Apr 2016 00:00:00 UTC","resolution":"day","start":"Thu, 14 Apr 2016 00:00:00 UTC","stats":[{"time":"Thu, 14 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":1193,"total":1193},"delivered":{"smtp":846,"http":0,"total":846},"failed":{"temporary":{"espblock":156},"permanent":{"suppress-bounce":5,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":84,"total":286}},"opened":{"total":82},"clicked":{"total":10},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(39, 9, 9260, 7671, 191, 659, 1399, 946, 20, 0, 0, 523, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":9260,"total":9260},"delivered":{"smtp":7671,"http":0,"total":7671},"failed":{"temporary":{"espblock":946},"permanent":{"suppress-bounce":20,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":523,"total":1399}},"opened":{"total":659},"clicked":{"total":191},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(40, 8, 10051, 8433, 191, 638, 1500, 1048, 19, 0, 0, 574, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":10051,"total":10051},"delivered":{"smtp":8433,"http":0,"total":8433},"failed":{"temporary":{"espblock":1048},"permanent":{"suppress-bounce":19,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":574,"total":1500}},"opened":{"total":638},"clicked":{"total":191},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(41, 5, 12176, 9642, 248, 830, 2248, 996, 15, 0, 0, 651, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":12176,"total":12176},"delivered":{"smtp":9642,"http":0,"total":9642},"failed":{"temporary":{"espblock":996},"permanent":{"suppress-bounce":15,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":651,"total":2248}},"opened":{"total":830},"clicked":{"total":248},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(42, 4, 10476, 7959, 154, 578, 2514, 1569, 26, 0, 0, 588, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":10476,"total":10476},"delivered":{"smtp":7959,"http":0,"total":7959},"failed":{"temporary":{"espblock":1569},"permanent":{"suppress-bounce":26,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":588,"total":2514}},"opened":{"total":578},"clicked":{"total":154},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(43, 3, 14107, 11444, 0, 0, 2416, 12185, 14, 0, 0, 806, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":14107,"total":14107},"delivered":{"smtp":11444,"http":0,"total":11444},"failed":{"temporary":{"espblock":12185},"permanent":{"suppress-bounce":14,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":806,"total":2416}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(44, 2, 13658, 11372, 218, 1188, 2195, 4127, 35, 0, 0, 795, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":13658,"total":13658},"delivered":{"smtp":11372,"http":0,"total":11372},"failed":{"temporary":{"espblock":4127},"permanent":{"suppress-bounce":35,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":795,"total":2195}},"opened":{"total":1188},"clicked":{"total":218},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(45, 1, 14655, 12042, 242, 1629, 2481, 1427, 93, 0, 4, 690, '2016-04-14 10:49:07', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":14655,"total":14655},"delivered":{"smtp":12042,"http":0,"total":12042},"failed":{"temporary":{"espblock":1427},"permanent":{"suppress-bounce":93,"suppress-unsubscribe":0,"suppress-complaint":4,"bounce":690,"total":2481}},"opened":{"total":1629},"clicked":{"total":242},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(46, 14, 9998, 8394, 186, 717, 1525, 838, 14, 0, 0, 591, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":9998,"total":9998},"delivered":{"smtp":8394,"http":0,"total":8394},"failed":{"temporary":{"espblock":838},"permanent":{"suppress-bounce":14,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":591,"total":1525}},"opened":{"total":717},"clicked":{"total":186},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(47, 13, 12052, 10026, 203, 848, 2015, 809, 21, 0, 0, 780, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":12052,"total":12052},"delivered":{"smtp":10026,"http":0,"total":10026},"failed":{"temporary":{"espblock":809},"permanent":{"suppress-bounce":21,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":780,"total":2015}},"opened":{"total":848},"clicked":{"total":203},"unsubscribed":{"total":0},"complained":{"total":4}}]},"http_response_code":200}'),
(48, 11, 4506, 3757, 121, 352, 596, 984, 6, 0, 0, 274, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":4506,"total":4506},"delivered":{"smtp":3757,"http":0,"total":3757},"failed":{"temporary":{"espblock":984},"permanent":{"suppress-bounce":6,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":274,"total":596}},"opened":{"total":352},"clicked":{"total":121},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(49, 10, 11723, 9765, 214, 780, 1865, 418, 23, 0, 0, 720, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":11723,"total":11723},"delivered":{"smtp":9765,"http":0,"total":9765},"failed":{"temporary":{"espblock":418},"permanent":{"suppress-bounce":23,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":720,"total":1865}},"opened":{"total":780},"clicked":{"total":214},"unsubscribed":{"total":0},"complained":{"total":3}}]},"http_response_code":200}'),
(50, 9, 11065, 9175, 208, 758, 1882, 1062, 21, 0, 0, 650, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":11065,"total":11065},"delivered":{"smtp":9175,"http":0,"total":9175},"failed":{"temporary":{"espblock":1062},"permanent":{"suppress-bounce":21,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":650,"total":1882}},"opened":{"total":758},"clicked":{"total":208},"unsubscribed":{"total":0},"complained":{"total":4}}]},"http_response_code":200}'),
(51, 8, 11990, 10065, 208, 759, 1924, 1140, 20, 0, 0, 710, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":11990,"total":11990},"delivered":{"smtp":10065,"http":0,"total":10065},"failed":{"temporary":{"espblock":1140},"permanent":{"suppress-bounce":20,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":710,"total":1924}},"opened":{"total":759},"clicked":{"total":208},"unsubscribed":{"total":0},"complained":{"total":4}}]},"http_response_code":200}'),
(52, 5, 13709, 10714, 257, 911, 3014, 2479, 17, 0, 0, 782, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":13709,"total":13709},"delivered":{"smtp":10714,"http":0,"total":10714},"failed":{"temporary":{"espblock":2479},"permanent":{"suppress-bounce":17,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":782,"total":3014}},"opened":{"total":911},"clicked":{"total":257},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(53, 4, 10476, 7959, 155, 592, 2514, 1569, 26, 0, 0, 588, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":10476,"total":10476},"delivered":{"smtp":7959,"http":0,"total":7959},"failed":{"temporary":{"espblock":1569},"permanent":{"suppress-bounce":26,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":588,"total":2514}},"opened":{"total":592},"clicked":{"total":155},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(54, 3, 15311, 12482, 0, 0, 2833, 13399, 16, 0, 0, 875, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":15311,"total":15311},"delivered":{"smtp":12482,"http":0,"total":12482},"failed":{"temporary":{"espblock":13399},"permanent":{"suppress-bounce":16,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":875,"total":2833}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(55, 2, 13658, 11372, 224, 1238, 2296, 4127, 35, 0, 0, 795, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":13658,"total":13658},"delivered":{"smtp":11372,"http":0,"total":11372},"failed":{"temporary":{"espblock":4127},"permanent":{"suppress-bounce":35,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":795,"total":2296}},"opened":{"total":1238},"clicked":{"total":224},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(56, 1, 15658, 12914, 265, 1725, 2753, 1460, 97, 0, 5, 756, '2016-04-15 03:57:54', 0, '{"http_response_body":{"end":"Fri, 01 Apr 2016 00:00:00 UTC","resolution":"month","start":"Fri, 01 Apr 2016 00:00:00 UTC","stats":[{"time":"Fri, 01 Apr 2016 00:00:00 UTC","accepted":{"incoming":0,"outgoing":15658,"total":15658},"delivered":{"smtp":12914,"http":0,"total":12914},"failed":{"temporary":{"espblock":1460},"permanent":{"suppress-bounce":97,"suppress-unsubscribe":0,"suppress-complaint":5,"bounce":756,"total":2753}},"opened":{"total":1725},"clicked":{"total":265},"unsubscribed":{"total":0},"complained":{"total":2}}]},"http_response_code":200}'),
(57, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(58, 13, 0, 0, 1, 5, 0, 0, 0, 0, 0, 0, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":5},"clicked":{"total":1},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(59, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(60, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(61, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(62, 8, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":1},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(63, 5, 34, 25, 0, 4, 9, 13, 0, 0, 0, 8, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":34,"total":34},"delivered":{"smtp":25,"http":0,"total":25},"failed":{"temporary":{"espblock":13},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":8,"total":9}},"opened":{"total":4},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(64, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(65, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(66, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":0,"total":0},"delivered":{"smtp":0,"http":0,"total":0},"failed":{"temporary":{"espblock":0},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":0,"total":0}},"opened":{"total":0},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}'),
(67, 1, 84, 74, 0, 1, 3, 1, 0, 0, 0, 1, '2016-04-15 05:39:40', 2, '{"http_response_body":{"end":"Fri, 15 Apr 2016 03:00:00 UTC","resolution":"hour","start":"Fri, 15 Apr 2016 03:00:00 UTC","stats":[{"time":"Fri, 15 Apr 2016 03:00:00 UTC","accepted":{"incoming":0,"outgoing":84,"total":84},"delivered":{"smtp":74,"http":0,"total":74},"failed":{"temporary":{"espblock":1},"permanent":{"suppress-bounce":0,"suppress-unsubscribe":0,"suppress-complaint":0,"bounce":1,"total":3}},"opened":{"total":1},"clicked":{"total":0},"unsubscribed":{"total":0},"complained":{"total":0}}]},"http_response_code":200}');

-- --------------------------------------------------------

--
-- 表的结构 `edm_task`
--

CREATE TABLE `edm_task` (
  `task_id` int(11) UNSIGNED NOT NULL,
  `task_title` varchar(255) NOT NULL,
  `task_parent` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父任务ID',
  `task_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '任务类型',
  `task_sdesc` text,
  `task_desc` text,
  `task_memo` text,
  `task_total` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `task_finish` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `task_difficulty` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '难度系数',
  `task_position` smallint(6) NOT NULL DEFAULT '0',
  `task_point` int(10) UNSIGNED DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `user_create` int(11) NOT NULL DEFAULT '0',
  `user_owner` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL,
  `date_update` datetime DEFAULT NULL,
  `date_finish` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_task`
--

INSERT INTO `edm_task` (`task_id`, `task_title`, `task_parent`, `task_type`, `task_sdesc`, `task_desc`, `task_memo`, `task_total`, `task_finish`, `task_difficulty`, `task_position`, `task_point`, `status`, `user_create`, `user_owner`, `date_create`, `date_update`, `date_finish`) VALUES
(1, 'Linkedin五金类行业数据采集', 0, 1, 'Linkedin五金类行业数据采集', 'Linkedin五金类行业数据采集', 'Linkedin五金类行业数据采集', 0, 0, 3, 100, 10, 0, 0, 0, '2016-10-26 00:00:41', '2016-10-26 00:00:47', NULL),
(2, 'Linkedin化工类行业数据采集', 0, 1, 'Linkedin化工类行业数据采集', 'Linkedin化工类行业数据采集', 'Linkedin化工类行业数据采集', 0, 0, 3, 100, 10, 0, 0, 0, '2016-10-26 00:00:41', '2016-10-26 00:00:47', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `edm_template`
--

CREATE TABLE `edm_template` (
  `template_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `format` char(1) DEFAULT NULL,
  `textbody` longtext,
  `htmlbody` longtext,
  `is_active` int(11) DEFAULT '0',
  `is_public` int(11) DEFAULT '0',
  `fee` decimal(10,2) DEFAULT '0.00',
  `company_id` int(11) NOT NULL DEFAULT '0',
  `date_update` datetime DEFAULT NULL,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_template`
--

INSERT INTO `edm_template` (`template_id`, `parent_id`, `name`, `image`, `format`, `textbody`, `htmlbody`, `is_active`, `is_public`, `fee`, `company_id`, `date_update`, `date_create`) VALUES
(1, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(2, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(3, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(4, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(5, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(6, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(7, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(8, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(9, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(10, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(11, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(12, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(13, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(14, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(15, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(16, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(17, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(18, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 1, NULL, NULL),
(19, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(20, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 1, NULL, NULL),
(21, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(22, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(23, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 1, NULL, NULL),
(24, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(25, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 1, NULL, NULL),
(26, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 1, NULL, NULL),
(27, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 1, NULL, NULL),
(28, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(29, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(30, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(31, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(32, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(33, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(34, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(35, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(36, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(37, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(38, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(39, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(41, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(42, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(43, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(44, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(45, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(46, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(47, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(48, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL),
(49, 0, 'Christmas Day Template', 'feedback/1.png', '1', NULL, NULL, 1, 0, '0.00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates`
--

CREATE TABLE `edm_templates` (
  `templateid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `format` char(1) DEFAULT NULL,
  `textbody` longtext,
  `htmlbody` longtext,
  `createdate` int(11) DEFAULT '0',
  `active` int(11) DEFAULT '0',
  `isglobal` int(11) DEFAULT '0',
  `ownerid` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_templates`
--

INSERT INTO `edm_templates` (`templateid`, `name`, `format`, `textbody`, `htmlbody`, `createdate`, `active`, `isglobal`, `ownerid`) VALUES
(1, '外贸开发信模版', NULL, NULL, '<p>[[称呼]][[寒暄]][[自我介绍]][[论点]][[搭桥句]][[公司优势]][[客户评价]][[产品]][[行动召唤]][[结束客套]][[签名]][[PS]]</p>', 2016, 0, 0, 0),
(2, '新品介绍', NULL, NULL, '[[称呼]][[寒暄]][[新品-自我介绍]][[论点]][[搭桥句]][[公司优势]][[产品]][[总结]][[行动召唤]][[结束客套]][[签名]][[PS]]', 2016, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates_category`
--

CREATE TABLE `edm_templates_category` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父分类 0顶级分类',
  `level` smallint(6) UNSIGNED DEFAULT '0' COMMENT '层级0为一级1为二级',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `is_hot` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '是否推荐',
  `sdesc` text,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 0未启用 1启用',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_templates_category`
--

INSERT INTO `edm_templates_category` (`category_id`, `category_name`, `parent_id`, `level`, `position`, `is_hot`, `sdesc`, `status`, `date_create`) VALUES
(1, '海外3C电子邮件模版', 0, 0, 999, 1, NULL, 1, NULL),
(4, '海外3C电子邮件模版-手机配件类', 1, 1, 99, 1, '海外3C电子邮件模版-手机配件类简要描述', 1, '2016-04-13 16:42:41');

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates_category_relate`
--

CREATE TABLE `edm_templates_category_relate` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `templateid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_templates_category_relate`
--

INSERT INTO `edm_templates_category_relate` (`id`, `category_id`, `templateid`) VALUES
(1, 4, 1),
(2, 4, 2);

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates_layout`
--

CREATE TABLE `edm_templates_layout` (
  `layout_id` int(11) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(150) NOT NULL COMMENT '名称',
  `desc` text,
  `image` varchar(255) DEFAULT NULL COMMENT '效果图',
  `bgcolor` varchar(100) DEFAULT NULL,
  `text` text NOT NULL COMMENT '内容',
  `styles` text COMMENT 'css 代码',
  `position` int(10) NOT NULL DEFAULT '0',
  `date_create` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `date_update` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  `orig_layout` varchar(200) NOT NULL COMMENT '原布局ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邮件模版风格布局';

--
-- 转存表中的数据 `edm_templates_layout`
--

INSERT INTO `edm_templates_layout` (`layout_id`, `name`, `desc`, `image`, `bgcolor`, `text`, `styles`, `position`, `date_create`, `date_update`, `orig_layout`) VALUES
(1, 'Basic Template 2 (Basic)', NULL, '/wysiwyg/layout/2016042910441304004.gif', NULL, '<table style="width: 650px;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td class="webview" align="center">\r\n<p style="color: #3e3e3e; font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-weight: normal; padding: 12px 0 25px 0;">Having trouble reading this email? <a href="%%webversion%%">View it in your browser.</a>.</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table class="bgTop" style="width: 650px;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td align="center">\r\n<table class="header" style="width: 650px; height: 130px;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td width="456">\r\n<h1 style="font-family: Georgia, serif; font-size: 35px; font-weight: normal; margin: 0 0 0 30px; padding: 0px;">{%公司名称%}</h1>\r\n<h2 style="font-family: Georgia, serif; font-size: 15px; font-style: italic; font-weight: normal; margin: 0 0 0 30px; padding: 0px;">{%产品关键词%}</h2>\r\n</td>\r\n<td class="date" width="194">\r\n<p style="color: font-family: georgia, serif; font-size: 11px; margin: 15px 0 0 0;">Monday 28th, April 2008</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table class="bg" style="width: 650px;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td align="center" valign="top" width="420">\r\n<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="border-right: 1px solid #f9d2d1; padding: 20px;" align="left">[[称呼]][[寒暄]]<br style="color: #c55e76; font-family: Georgia; font-size: 20px; font-weight: normal; margin: 0 0 5px 0; padding: 25px 0 0 0;" />\r\n<h2 style="border-top: 1px solid #f9d2d1; color: #c55e76; font-family: Georgia; font-size: 20px; font-weight: normal; margin: 0 0 5px 0; padding: 25px 0 0 0;">Our New Facilities</h2>\r\n<img style="border: 1px solid #f9d2d1;" src="http://interspire.com/admin/resources/email_templates/Basic/Basic%20Template%202/testImg.jpg" alt="Insert Image" width="396" height="262" />\r\n<p style="color: #242424; font-family: Georgia; font-size: 12px; font-weight: normal; margin: 0 0 25px 0; padding: 0;">Replace this text with your email content and images.</p>\r\n<h2 style="border-top: 1px solid #f9d2d1; color: #c55e76; font-family: Georgia; font-size: 20px; font-weight: normal; margin: 0 0 5px 0; padding: 25px 0 0 0;">Heading 3</h2>\r\n<p style="color: #242424; font-family: Georgia; font-size: 12px; font-weight: normal; margin: 0 0 25px 0; padding: 0;">Replace this text with your email content and images.</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n<td class="sidebar" align="center" valign="top" width="200">\r\n<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="padding: 0 10px 0 20px;" align="left">\r\n<h3 style="color: #c55e76; font-family: Georgia; font-size: 15px; font-weight: normal; margin: 10px 0 0 0; padding: 45px 0 0 0;">About Us</h3>\r\n<p style="color: #242424; font-family: Georgia; font-size: 12px; font-weight: normal; margin: 0 0 25px 0; padding: 0;">[[自我介绍]]</p>\r\n<h3 style="border-top: 1px solid #f9d2d1; color: #c55e76; font-family: Georgia; font-size: 15px; font-weight: normal; margin: 0; padding: 25px 0 0 0;">Our Location</h3>\r\n<p style="color: #242424; font-family: Georgia; font-size: 12px; font-weight: normal; margin: 0 0 25px 0; padding: 0;">{%公司地址%}</p>\r\n<p style="color: #242424; font-family: Georgia; font-size: 12px; font-weight: normal; margin: 0 0 25px 0; padding: 0;">{%工作时间%}</p>\r\n<p style="color: #242424; font-family: Georgia; font-size: 12px; font-weight: normal; margin: 0 0 25px 0; padding: 0;">{%联系电话[[质量优势]]%}</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table class="bgBottom" style="width: 650px; height: 60px;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td align="center" valign="middle">\r\n<p style="color: #3e3e3e; font-family: Georgia, serif; font-size: 10px; padding: 10px 0 10px 0;">Company Name LLC. | 29798 New Street, Anytown, USA 55555 | O: 555-555-5555 F: 555-555-5555</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table class="footer" style="width: 650px;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td align="center">\r\n<p style="color: #3e3e3e; font-family: Arial; font-size: 11px; font-weight: normal;">This is email was sent to [email], <a href="#">click here</a> to unsubscribe.<br />To read our Privacy Policy, visit: <a style="color: #3e3e3e;" href="#">http://www.website.com/privacy</a>.</p>\r\n<p style="color: #3e3e3e; font-family: Arial; font-size: 11px; font-weight: normal;">Copyright &copy; 2008 Company Name LLC. All rights reserved.</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'body { background-color: #bbe2ea; margin: 0; padding: 0; }\r\np a { color: #44a0df; text-decoration: underline; }\r\np a.noline { text-decoration: none; }\r\ntable.bgTop { background-color: #dd8c9d; }\r\ntable.bg { background-color: #ffffff; }\r\ntable.header td h1 { color: #ffffff; }\r\ntable.header td h2 { color: #ffffff; }\r\ntd.date { color: #ffffff; }\r\ntd.sidebar { background-color: #ffffff; }\r\ntable.bgBottom { background-color: #fabebe; }\r\ntable.footer { margin: 10px 0 25px 0; }', 99, NULL, NULL, '');

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates_module`
--

CREATE TABLE `edm_templates_module` (
  `module_id` int(10) UNSIGNED NOT NULL COMMENT 'Id',
  `template` int(10) UNSIGNED DEFAULT '0',
  `name` varchar(255) DEFAULT NULL COMMENT '模块名称',
  `memo` text,
  `position` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模版模块';

--
-- 转存表中的数据 `edm_templates_module`
--

INSERT INTO `edm_templates_module` (`module_id`, `template`, `name`, `memo`, `position`) VALUES
(1, 1, '邮件标题', '邮件标题', 1),
(2, 1, '称呼', '称呼', 2),
(3, 1, '寒暄', '寒暄', 3),
(4, 1, '触动概述', '触动概述', 4),
(5, 1, '论点', '论点', 5),
(6, 1, '产品', '产品', 6),
(10, 1, '客户好处', '客户好处', 0),
(11, 1, '总结', '总结', 0),
(12, 1, '行动召唤', '行动召唤', 0),
(13, 1, '结束客套', '结束客套', 0),
(14, 1, '签名', '签名', 0),
(15, 1, 'PS', 'PS', 0),
(16, 1, '搭桥句', '搭桥句', 0),
(17, 1, '客户利益', '客户利益', 0),
(18, 1, '产品类目', '产品类目', 0),
(19, 1, '自我介绍', '自我介绍', 0),
(22, 1, '客户评价', '客户评价', 0),
(23, 1, '图片', '图片', 0),
(24, 1, '其他', '其他', 0);

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates_module_item`
--

CREATE TABLE `edm_templates_module_item` (
  `item_id` int(11) UNSIGNED NOT NULL COMMENT 'Id',
  `module_id` int(10) UNSIGNED NOT NULL,
  `item_content` text COMMENT '内容',
  `status` tinyint(2) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模版模块项';

--
-- 转存表中的数据 `edm_templates_module_item`
--

INSERT INTO `edm_templates_module_item` (`item_id`, `module_id`, `item_content`, `status`) VALUES
(1, 1, '<p>A right [%客户产品%] supplier that get you free from quality problem and save money&nbsp;</p>', 1),
(2, 1, '<p>A competent {%推广产品%}&nbsp;supplier for&nbsp;[%客户名称%]&nbsp;</p>', 1),
(3, 1, '<p>Latest design {%推广产品%}&nbsp;you might be interested to consider for your market.&nbsp;</p>', 1),
(4, 1, '<p>You may cut down your sourcing cost for {%推广产品%}&nbsp;considerably, a new competent manufacturing supplier for&nbsp;[%客户名称%].</p>', 1),
(5, 1, '<p>Save big for your&nbsp;{%推广产品%} sourcing, look into this competent producing supplier candidate for&nbsp;[%客户名称%].</p>', 1),
(6, 1, '<p>A potential competent &nbsp;{%推广产品%} supplier for [%客户名称%]</p>', 1),
(8, 1, '<p>New {%推广产品%}&nbsp; that has active market in&nbsp;[%客户国家%]</p>', 1),
(9, 2, '<p>Dear [%联系人%],</p>', 1),
(10, 2, '<p>Hi [%联系人%],</p>', 1),
(11, 2, '<p>Dear Purchasing Manager,</p>', 1),
(12, 2, '<p>Dear General Manager,</p>', 1),
(13, 3, '<p>Good morning!</p>', 1),
(14, 3, '<p>Good afternoon!</p>', 1),
(15, 3, '<p>Wish you have a nice day!</p>', 1),
(16, 3, '<p>How are you!</p>', 1),
(17, 3, '<p>Warm greetings for the day!</p>', 1),
(18, 3, '<p>Hope everything is fine for you!</p>', 1),
(19, 4, '<p>As a successful importer for %%Customer Product%%, you may rely on {%公司名称%}&nbsp;to be even more successful in the market.&nbsp;</p>', 1),
(20, 4, '<p>Many importers business fail just because they lack a good supplier.&nbsp;</p>', 1),
(21, 4, '<p>Lacking a good supplier may cause business failure for the wholesaler or retailers.</p>', 1),
(22, 4, '<p>The risk and cost for lacking a reliable &amp; competent supplier is dear for the wholesale business.Stop exposing your business to the risk, by finding a reliable supplier for&nbsp;{%推广产品%}.</p>', 1),
(23, 4, '<p>A competent supplier can make good contribution to the success of the wholesalers.&nbsp;You can rely on us for&nbsp;{%推广产品%}.</p>', 1),
(24, 5, 'Behind every successful [%客户渠道特征%]&nbsp;there is a reliable supplier. You might be open for a new competent supplier as well. I am confident that we may make good contribution to [%客户名称%] for&nbsp;a greater success.', 1),
(25, 5, 'I sincerely request your attention for a few minutes, it may be very beneficial to your business, for a competent supplier get you free from quality problems, and better your cost.', 1),
(26, 4, '<p>Contended with your existing supplier, or compare &amp; select better-performing new suppliers? {%公司名称%}&nbsp;welcomes tough comparisons. Actually many customers like {%服务的主要大客户%}&nbsp;selected and relied on us for &nbsp;{%推广产品%}after comparison.&nbsp;</p>', 1),
(27, 4, '<p>Are you putting all your eggs in one basket for purchasing {%推广产品%}？You may avoid the supply risk by evaluating a new capable supplier like&nbsp;{%公司名称%}.</p>', 1),
(28, 4, '<p>I used to think a penny saved is a penny earned on purchasing {%推广产品%}. Perhaps you once felt the same. Perhaps now you also realize less could also be more. An inferior quality {%推广产品%}&nbsp;not only brings you the headache of customer complaint, re</p>', 1),
(29, 4, '<p>Selecting a right supplier means saving thousands of dollars for purchasing, saving you free from customer complaints on quality and delivery time. {%公司名称%}&nbsp;are proud to supply quality {%推广产品%}&nbsp;to many satisfied customers like{%服务的主要大客户%}</p', 0),
(30, 4, '<p>Have you ever wished a problem-free &amp; most competitive supplier of {%推广产品%}&nbsp;appears, get you free from customer complaints, and save you money? Now it appears. {%公司名称%}&nbsp;is the one you are looking for！|</p>', 0),
(31, 4, '<p>Are you paying too much for your purchase of {%推广产品%}? {%公司名称%}is offering the best price for the quality&nbsp;{%推广产品%}.</p>', 0),
(32, 4, '<p>Because&nbsp;%%Company Name%% is distributing %%Customer Product%%， like many of our customers, you may also need a very reliable supplier with nice quality and fair price.</p>', 0),
(33, 4, '<p>I need a favor from you.If you want to save your company thousands of dollars purchasing {%推广产品%}，you may want to pass this email to your purchasing colleagues. You do not want your company purchase at a higher price than your competitors for the same', 0),
(34, 4, '<p>Are you loosing sales because of a incapable supplier, inferior quality, and late deliveries? You do not have to. Switch to a most reliable supplier like {%公司名称%}&nbsp;for {%推广产品%}, and say good bye to customer complaints.&nbsp;</p>', 0),
(35, 4, '<p>Are you suffering from bad quality supplier? Seeming cheap price with inferior quality actually cost dear. Customers complaints &amp; replacements is very costly, and hurt your reputation in the market. Why not switch to a most reliable supplier like&n', 0),
(36, 4, '<p>If you''re like many {%推广产品%}&nbsp;importers,you''re probably looking forward to have a competitive supplier with quality problems free. That is a wise thought, behind every successful wholesaler there is a reliable supplier like{%公司名称%}.</p>', 0),
(37, 4, '<p>Our customers are selling fast with new fashion designs. &nbsp;{%公司名称%}&nbsp;has in-house professional designers releasing original new designs, every 6 monthes.</p>', 0),
(38, 4, '<p>Our customers are competitive in the market.With probably the largest production capacity，we have the most competitive price for&nbsp;{%推广产品%}.</p>', 0),
(39, 4, '<p>Our customers are free from quality problems. With a TQM (total quality management) system, we are proud to supply nice quality {%推广产品%}&nbsp;to companies like&nbsp;{%服务的主要大客户%}.</p>', 0),
(40, 4, '<p>Companies like {%服务的主要大客户%}&nbsp;purchase from{%公司名称%} to make their quality problem free.</p>', 0),
(41, 16, '<p>Here are a few reasons why you may be happy to consider us:</p>', 0),
(42, 16, '<p>You may give us a serious consideration for following reasons:</p>', 0),
(43, 16, '<p>You may benefit a lot co-operating with us for:&nbsp;</p>', 0),
(44, 16, '<p>You might be glad to know our following strengths:&nbsp;</p>', 1),
(45, 16, '<p>To name a few of our strengths, which enable us to make good contribution to your greater success:</p>', 1),
(46, 16, '<p>I am confident that we may make good contribution to your greater success with following strengths:</p>', 1),
(66, 12, '<p>Do you need our catalogs to have a look on our latest designs?</p>', 1),
(67, 12, '<p>To evalute our quality &amp; price, please just select a typical current buying model, we will give you a quotation &amp; produce a sample for you fast.&nbsp;</p>', 1),
(68, 12, '<p>What models do you currently purchase? You can send the specifications to me, I will immediately evaluate the cost for you to see how much you can save.</p>', 1),
(69, 12, '<p>What are the models &amp; specifications you currently purchase? To help you evaluate how much you can save, you can just send us the models you currently purchase, so you can compare our prices with your current supplier.&nbsp;</p>', 0),
(70, 12, '<p>When you plan for a new order for {%推广产品%}, &nbsp;do you mind to send me your enquiries? Surely I will give the best prices to you.</p>', 1),
(71, 12, '<p>To conduct an effective vendor evaluation, what information you normally need from vendors?</p>', 1),
(72, 12, '<p>Can you please give me a chance to prove to you, that we can do even better than your current supplier?</p>', 0),
(73, 13, '<p><br />Best regards,</p>', 1),
(74, 13, '<p><br />Sincerely,<br /><br /></p>', 1),
(75, 13, '<p><br />Sincerely yours,<br /><br /></p>', 1),
(76, 13, '<p><br />Regards,<br /><br /></p>', 1),
(77, 4, '<p>Companies like {%服务的主要大客户%}&nbsp;purchase from{%公司名称%} to &nbsp;reduce their costs.</p>', 1),
(78, 4, '<p>Companies like {%服务的主要大客户%}&nbsp;purchase from{%公司名称%} to get the latest fashion designs.</p>', 1),
(79, 4, '<p>We are your candidate supplier for good quality {%推广产品%}. Can you please take a few minutes to find why we can help&nbsp;%%Company Name%% to be more successful?</p>\r\n<p>&nbsp;</p>', 1),
(80, 12, '<p>We are very confident that we can make good contribution to a better success of&nbsp;%%Company Name%%. Can you please give us a chance to be evaluated?</p>', 0),
(82, 17, '<p>-Problem free for reliable quality</p>', 1),
(83, 17, '<p>-To have a full range of {%推广产品%} to suite various customers'' needs</p>', 1),
(84, 17, '<p>-Having a higher profit margin. To find out how much you can earn or save, just send us an enquiry, we will give you our prices for you to evalute.</p>', 1),
(85, 17, '<p>- Realize continued sales growth as more and more people are using {%推广产品%}.</p>\r\n<p>&nbsp;</p>', 1),
(86, 19, '<p>To quickly introduce myself, I am with {%公司名称%}&nbsp;and we supply high quality {%推广产品%} to importers worldwidely. I am writing to you with a purpose to become your reliable supplier for&nbsp;{%推广产品%}.</p>', 1),
(91, 12, '<p>When you plan for your next purchase, I would welcome your sending us an enquiry, and surely I will give you the best prices.</p>', 1),
(92, 4, '<p>Even you have a satisfied supplier, it might still be worthwhile for you to keep an eye on a capable producing supplier like {%公司名称%}. It costs you nothing to look into us, but may yield great returns.</p>', 1),
(93, 1, '<p>Spend more time with your family by working with a problem-free supplier</p>', 1),
(94, 1, '<p>A problem-free supplier that will save you energy, and let you have more time spending with your family.</p>', 1),
(95, 1, '<p>Original new designs {%推广产品%} that your customers may be excited to see</p>', 1),
(96, 1, '<p>A reliable candidate supplier for&nbsp;{%推广产品%}, excellent quality products&nbsp;reasonably priced</p>', 1),
(97, 4, '<p>An optional supplier never hurts. It costs you nothing to give an evaluation on a competent candidate supplier, yet might open a door for a very competent &amp; reliable supplier, &amp; save you much money.</p>\r\n<p>&nbsp;</p>', 1),
(98, 10, '<p>You can spend more time with your family by working with problem-free supplier like&nbsp;{%公司名称%}.</p>', 1),
(99, 10, '<p>You&nbsp;can save much money working with a competent supplier like us.&nbsp;</p>', 1),
(100, 10, '<p>You may introduce original design products to your clients faster, get differentiated from your competitors &amp; have higher margin, with strong support our design capability.&nbsp;</p>', 1),
(101, 10, '<p>It saves much of your energy &amp; time working with an experienced team with professional skills, understanding your business.</p>', 1),
(102, 1, '<p>A competent candidate supplier for&nbsp;{%推广产品%},&nbsp;{%在行业内拥有多少年经验%} years'' professional experience&nbsp;</p>', 1),
(103, 1, '<p>A newly released&nbsp;{%推广产品%}&nbsp;most sellable in [%客户国家%]&nbsp;market</p>', 1),
(104, 1, '<p>As you target high-end customers, design item like {%公司名称%}&nbsp;{%推广产品%}&nbsp;sells.</p>', 1),
(105, 1, '<p>This design {%推广产品%}&nbsp;sells like crazy on [%客户国家%]&nbsp;markets.&nbsp;</p>', 1),
(106, 1, '<p>There is a good&nbsp;market for &nbsp;{%推广产品%} in&nbsp;[%客户国家%].&nbsp;</p>', 1),
(107, 1, '<p>Why this model {%推广产品%}&nbsp;outsells all others on the [%客户国家%]&nbsp;market.</p>', 1),
(108, 1, '<p>There is always a ready sale for high-quality&nbsp;{%推广产品%} with original design&nbsp;.</p>', 1),
(109, 1, '<p>These design&nbsp;{%推广产品%}s&nbsp;are always in active demand.</p>', 1),
(110, 1, '<p>A new original design&nbsp;{%推广产品%}&nbsp;with a big sales potentiality in&nbsp;[%客户国家%].</p>', 1),
(111, 1, '<p>Design {%推广产品%} will sell&nbsp;widely among your clients sought-after styles.</p>', 1),
(112, 1, '<p>Design&nbsp;{%推广产品%} with really affordable prices&nbsp;, it will sell like hot cakes.</p>', 1),
(113, 1, '<p>This new design {%推广产品%}&nbsp;will soon find a good market in [%客户国家%]&nbsp;market.&nbsp;</p>', 1),
(114, 1, '<p>This new original design {%推广产品%}&nbsp;tends to be a big sell.</p>', 1),
(115, 1, '<p>Once released , this new original design {%推广产品%}&nbsp;will be very popular.</p>', 1),
(116, 1, '<p>This new {%推广产品%}&nbsp;is best sellers in many countries.</p>', 1),
(117, 1, '<p>A product your clients will love:&nbsp;{%推广产品%}</p>', 1),
(118, 1, '<p>%%Contact Person%%,work with &nbsp;a&nbsp;right {%推广产品%}&nbsp;supplier will get you free from quality problem and save money&nbsp;</p>', 1),
(119, 18, '<p>Our product line includes:&nbsp;{%产品范围%}.</p>', 1),
(120, 6, '<p>Very briefly product line covers:&nbsp;{%产品范围%}.&nbsp;For more information about our product &amp; company, please visit&nbsp;{%公司官网%}.</p>', 1),
(121, 14, '<p>{%联系人%}<br /><strong>{%公司名称%}<br /></strong>Web:{%公司官网%}&nbsp;<br />Email:{%联系邮箱%}</p>', 1),
(122, 5, 'As we are currently supplying to customers with similar business as&nbsp;[%客户名称%], so I feel that you might also benefit a lot from co-operation with us.', 1),
(123, 19, '<p>To quickly introduce myself, I am with {%公司名称%}&nbsp;and we supply high quality {%推广产品%} to importers worldwidely.&nbsp;</p>', 1),
(124, 19, '<p>May I introduce myself quickly? I am from&nbsp;{%公司名称%}. We produce &amp; supply high quality {%推广产品%}&nbsp;to importing wholesalers.</p>', 1),
(125, 19, '<p>May I have a brief introduction of myself? We produce &amp; supply high quality {%推广产品%} to importers worldwidely.</p>', 1),
(126, 5, 'As a successful importer, you might also be very interested in new competent suppliers, free from quality problem &amp; save much money.', 1),
(128, 19, '<p>I am writing to introduce ourselves as a competent potential supplier for&nbsp;[%客户名称%].&nbsp;</p>', 1),
(129, 22, '<p>{[知名客户]}.&nbsp;{[客户评价]}&nbsp;When you need, we will be pleased to provide you our satisfied customers'' reference.&nbsp;</p>', 1),
(130, 15, '<p><strong>{{widget type="ins/widget_product" type="default" amount="8" amount_row="1" sort_method="position" show_price="1"}} PS: {[促销措施]}</strong></p>', 1),
(131, 23, '<p>{[图片]}</p>', 1);

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates_module_item_attrvalue`
--

CREATE TABLE `edm_templates_module_item_attrvalue` (
  `value_id` bigint(20) NOT NULL,
  `attr_id` int(10) NOT NULL,
  `item_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_templates_module_item_attrvalue`
--

INSERT INTO `edm_templates_module_item_attrvalue` (`value_id`, `attr_id`, `item_id`, `value`) VALUES
(1, 2, 64, '4'),
(2, 8, 64, '15'),
(3, 8, 64, '19'),
(4, 8, 64, '21'),
(5, 2, 79, '1'),
(6, 2, 79, '2'),
(7, 2, 58, '4'),
(8, 2, 53, '1'),
(9, 2, 88, '1'),
(10, 2, 98, '1'),
(11, 8, 98, '15'),
(12, 8, 98, '16'),
(13, 8, 98, '17'),
(14, 8, 98, '18'),
(15, 8, 98, '19'),
(16, 8, 98, '20'),
(17, 8, 98, '21'),
(18, 2, 98, '4'),
(19, 2, 99, '2'),
(20, 8, 99, '15'),
(21, 8, 99, '16'),
(22, 8, 99, '17'),
(23, 8, 99, '18'),
(24, 2, 100, '3'),
(25, 2, 100, '4'),
(26, 8, 100, '15'),
(27, 8, 100, '16'),
(28, 8, 100, '17'),
(29, 8, 100, '18'),
(30, 8, 100, '19'),
(31, 8, 100, '20'),
(32, 8, 100, '21'),
(33, 2, 102, '4'),
(34, 8, 102, '15'),
(35, 8, 102, '16'),
(36, 8, 102, '17'),
(37, 8, 102, '18'),
(38, 8, 102, '19'),
(39, 8, 102, '20'),
(40, 8, 102, '21'),
(41, 2, 102, '1'),
(42, 2, 103, '3'),
(43, 2, 103, '4'),
(44, 8, 103, '15'),
(45, 8, 103, '16'),
(46, 8, 103, '17'),
(47, 8, 103, '18'),
(48, 8, 103, '19'),
(49, 8, 103, '20'),
(50, 8, 103, '21'),
(51, 2, 116, '3'),
(52, 8, 116, '15'),
(53, 8, 116, '16'),
(54, 8, 116, '17'),
(55, 8, 116, '18'),
(56, 8, 116, '19'),
(57, 8, 116, '20'),
(58, 8, 116, '21'),
(59, 2, 115, '3'),
(60, 8, 115, '15'),
(61, 8, 115, '16'),
(62, 8, 115, '17'),
(63, 8, 115, '18'),
(64, 8, 115, '19'),
(65, 8, 115, '20'),
(66, 8, 115, '21'),
(67, 2, 114, '3'),
(68, 8, 114, '15'),
(69, 8, 114, '16'),
(70, 8, 114, '17'),
(71, 8, 114, '18'),
(72, 8, 114, '19'),
(73, 8, 114, '20'),
(74, 8, 114, '21'),
(75, 2, 113, '3'),
(76, 8, 113, '15'),
(77, 8, 113, '16'),
(78, 8, 113, '17'),
(79, 8, 113, '18'),
(80, 8, 113, '19'),
(81, 8, 113, '20'),
(82, 8, 113, '21'),
(83, 2, 112, '3'),
(84, 8, 112, '15'),
(85, 8, 112, '16'),
(86, 8, 112, '17'),
(87, 8, 112, '18'),
(88, 8, 112, '19'),
(89, 8, 112, '20'),
(90, 8, 112, '21'),
(91, 2, 110, '3'),
(92, 8, 110, '15'),
(93, 8, 110, '16'),
(94, 8, 110, '17'),
(95, 8, 110, '18'),
(96, 8, 110, '19'),
(97, 8, 110, '20'),
(98, 8, 110, '21'),
(99, 2, 109, '3'),
(100, 8, 109, '15'),
(101, 8, 109, '16'),
(102, 8, 109, '17'),
(103, 8, 109, '18'),
(104, 8, 109, '19'),
(105, 8, 109, '20'),
(106, 8, 109, '21'),
(107, 2, 108, '3'),
(108, 8, 108, '15'),
(109, 8, 108, '16'),
(110, 8, 108, '17'),
(111, 8, 108, '18'),
(112, 8, 108, '19'),
(113, 8, 108, '20'),
(114, 8, 108, '21'),
(115, 2, 107, '3'),
(116, 8, 107, '15'),
(117, 8, 107, '16'),
(118, 8, 107, '17'),
(119, 8, 107, '18'),
(120, 8, 107, '19'),
(121, 8, 107, '20'),
(122, 8, 107, '21'),
(123, 2, 106, '3'),
(124, 2, 106, '4'),
(125, 8, 106, '15'),
(126, 8, 106, '16'),
(127, 8, 106, '17'),
(128, 8, 106, '18'),
(129, 8, 106, '19'),
(130, 8, 106, '20'),
(131, 8, 106, '21'),
(132, 2, 105, '3'),
(133, 8, 105, '15'),
(134, 8, 105, '16'),
(135, 8, 105, '17'),
(136, 8, 105, '18'),
(137, 8, 105, '19'),
(138, 8, 105, '20'),
(139, 8, 105, '21'),
(140, 2, 104, '3'),
(141, 8, 104, '15'),
(142, 8, 104, '16'),
(143, 8, 104, '17'),
(144, 8, 104, '18'),
(145, 8, 104, '19'),
(146, 8, 104, '20'),
(147, 8, 104, '21'),
(148, 2, 1, '1'),
(149, 2, 1, '4'),
(150, 8, 1, '15'),
(151, 8, 1, '16'),
(152, 8, 1, '17'),
(153, 8, 1, '18'),
(154, 8, 1, '19'),
(155, 8, 1, '20'),
(156, 8, 1, '21'),
(157, 2, 93, '1'),
(158, 8, 93, '15'),
(159, 8, 93, '16'),
(160, 8, 93, '17'),
(161, 8, 93, '18'),
(162, 8, 93, '19'),
(163, 8, 93, '20'),
(164, 8, 93, '21'),
(165, 2, 94, '1'),
(166, 8, 94, '15'),
(167, 8, 94, '16'),
(168, 8, 94, '17'),
(169, 8, 94, '18'),
(170, 8, 94, '19'),
(171, 8, 94, '20'),
(172, 8, 94, '21'),
(173, 2, 2, '2'),
(174, 8, 2, '15'),
(175, 8, 2, '16'),
(176, 8, 2, '17'),
(177, 8, 2, '18'),
(178, 8, 2, '19'),
(179, 8, 2, '20'),
(180, 8, 2, '21'),
(181, 2, 3, '3'),
(182, 8, 3, '15'),
(183, 8, 3, '16'),
(184, 8, 3, '17'),
(185, 8, 3, '18'),
(186, 8, 3, '19'),
(187, 8, 3, '20'),
(188, 8, 3, '21'),
(189, 2, 4, '2'),
(190, 8, 4, '15'),
(191, 8, 4, '16'),
(192, 8, 4, '17'),
(193, 8, 4, '18'),
(194, 8, 4, '19'),
(195, 8, 4, '20'),
(196, 8, 4, '21'),
(197, 2, 5, '2'),
(198, 8, 5, '15'),
(199, 8, 5, '16'),
(200, 8, 5, '17'),
(201, 8, 5, '18'),
(202, 8, 5, '19'),
(203, 8, 5, '20'),
(204, 8, 5, '21'),
(205, 2, 6, '1'),
(206, 2, 6, '2'),
(207, 8, 6, '15'),
(208, 8, 6, '16'),
(209, 8, 6, '17'),
(210, 8, 6, '18'),
(211, 8, 6, '19'),
(212, 8, 6, '20'),
(213, 8, 6, '21'),
(214, 2, 8, '3'),
(215, 2, 8, '4'),
(216, 8, 8, '15'),
(217, 8, 8, '16'),
(218, 8, 8, '17'),
(219, 8, 8, '18'),
(220, 8, 8, '19'),
(221, 8, 8, '20'),
(222, 8, 8, '21'),
(223, 2, 117, '1'),
(224, 2, 117, '2'),
(225, 2, 117, '3'),
(226, 2, 117, '4'),
(227, 8, 117, '15'),
(228, 8, 117, '16'),
(229, 8, 117, '17'),
(230, 8, 117, '18'),
(231, 8, 117, '19'),
(232, 8, 117, '20'),
(233, 8, 117, '21');

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates_module_item_relate`
--

CREATE TABLE `edm_templates_module_item_relate` (
  `relate_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `item_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_templates_module_item_relate`
--

INSERT INTO `edm_templates_module_item_relate` (`relate_id`, `type`, `name`, `item_id`) VALUES
(818, 'company_attr', '产品认证', 50),
(819, 'company_attr', '第三方验厂', 51),
(820, 'company_attr', '设备进口国', 52),
(821, 'company_attr', '进口设备', 53),
(822, 'company_attr', '月产量', 57),
(823, 'company_attr', '在行业内拥有多少年经验', 58),
(833, 'company_attr', '产品关键词', 87),
(834, 'company_advantage', '质量认证体系', 88),
(1006, 'contact_attr', 'Customer Product', 19),
(1007, 'client_attr', '客户渠道特征', 24),
(1008, 'company_attr', '服务的主要大客户', 26),
(1009, 'company_attr', '服务的主要大客户', 29),
(1010, 'contact_attr', 'Company Name', 32),
(1011, 'contact_attr', 'Customer Product', 32),
(1012, 'company_attr', '服务的主要大客户', 39),
(1013, 'company_attr', '服务的主要大客户', 40),
(1014, 'company_attr', '服务的主要大客户', 77),
(1015, 'company_attr', '服务的主要大客户', 78),
(1016, 'contact_attr', 'Company Name', 79),
(1017, 'contact_attr', 'Company Name', 80),
(1018, 'company_attr', '在行业内拥有多少年经验', 102),
(1019, 'contact_attr', 'Contact Person', 118),
(1020, 'company_advantage', '知名客户', 129),
(1021, 'company_advantage', '客户评价', 129),
(1026, 'company_advantage', '图片', 131),
(1027, 'company_advantage', '促销措施', 130);

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates_tag`
--

CREATE TABLE `edm_templates_tag` (
  `tag_id` int(10) UNSIGNED NOT NULL COMMENT 'Tag Id',
  `name` varchar(255) DEFAULT NULL COMMENT 'Variable Name',
  `code` varchar(255) DEFAULT NULL COMMENT 'Code',
  `visible_font` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '前台是否可见',
  `position` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='模版标签';

--
-- 转存表中的数据 `edm_templates_tag`
--

INSERT INTO `edm_templates_tag` (`tag_id`, `name`, `code`, `visible_font`, `position`) VALUES
(1, 'Header', 'header', 0, 0),
(2, 'Footer', 'footer', 0, 0),
(3, 'Content', 'content', 0, 0),
(4, 'Contact Info', 'contact', 0, 0),
(5, 'Product', 'product', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `edm_templates_variable`
--

CREATE TABLE `edm_templates_variable` (
  `variable_id` int(10) UNSIGNED NOT NULL COMMENT 'Variable Id',
  `name` varchar(255) DEFAULT NULL COMMENT 'Variable Name',
  `default_value` varchar(255) DEFAULT NULL COMMENT 'Default Value',
  `expr` text COMMENT '表达式',
  `visible_font` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '前台是否可见',
  `position` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Template Variables';

--
-- 转存表中的数据 `edm_templates_variable`
--

INSERT INTO `edm_templates_variable` (`variable_id`, `name`, `default_value`, `expr`, `visible_font`, `position`) VALUES
(1, 'Good Syn', NULL, '[{good|better|best|big}]', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `edm_template_category`
--

CREATE TABLE `edm_template_category` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `parent_id` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '父分类 0顶级分类',
  `level` smallint(6) UNSIGNED DEFAULT '0' COMMENT '层级0为一级1为二级',
  `position` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `is_hot` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '是否推荐',
  `sdesc` text,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态 0未启用 1启用',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_template_category_relate`
--

CREATE TABLE `edm_template_category_relate` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_template_tag`
--

CREATE TABLE `edm_template_tag` (
  `tag_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_template_tag_relate`
--

CREATE TABLE `edm_template_tag_relate` (
  `id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL DEFAULT '0',
  `tag_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `edm_urlprocess`
--

CREATE TABLE `edm_urlprocess` (
  `url_id` int(11) UNSIGNED NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `client_id` int(11) UNSIGNED DEFAULT '0',
  `position` int(10) UNSIGNED DEFAULT '0' COMMENT '优先度',
  `is_active` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '是否提交1提交处理',
  `status` tinyint(2) DEFAULT '0' COMMENT '处理状态0待处理 1处理中 2处理完成 -1无效URL',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `edm_urlprocess`
--

INSERT INTO `edm_urlprocess` (`url_id`, `url`, `company_id`, `client_id`, `position`, `is_active`, `status`, `date_create`) VALUES
(18, 'www.interway-tarp.com', 1, 100, 0, 1, 2, '2016-05-31 03:43:29'),
(19, 'www.magickeys.com', 1, 101, 99, 1, 0, '2016-05-31 05:40:33'),
(20, 'www.ygjingxi.com', 1, 9, 99, 1, 2, '2016-05-31 06:16:16'),
(21, 'www.roomstogo.com', 1, 88, 99, 1, 2, '2016-05-31 06:59:10'),
(22, 'www.vesselsink.com', 1, 102, 99, 1, 0, '2016-05-31 07:31:26'),
(23, 'www.stonecabinetoutlet.com', 1, 103, 99, 1, 0, '2016-05-31 07:34:31'),
(24, 'www.vesselsinks.com', 1, 3, 99, 1, 0, '2016-05-31 07:57:58'),
(25, 'www.easybuy.com', 1, 5, 99, 1, 0, '2016-05-31 10:17:04'),
(26, 'www.bedbathandbeyond.com', 1, 6, 99, 1, 0, '2016-05-31 10:18:32'),
(27, 'www.mikasa.com', 1, 7, 99, 1, 0, '2016-05-31 10:21:19'),
(28, 'www.lakeside.com', 1, 8, 99, 1, 0, '2016-05-31 10:31:46'),
(29, 'www.webstaurantstore.com', 1, 9, 99, 1, 0, '2016-05-31 10:36:02'),
(30, 'www.4imprint.com', 1, 10, 99, 1, 0, '2016-05-31 10:39:32'),
(31, 'www.jdsmarketing.net', 1, 11, 99, 1, 0, '2016-06-01 00:11:03'),
(32, 'www.refreshglass.com', 1, 12, 99, 1, 0, '2016-06-01 00:13:04'),
(33, 'www.signaturetumblers.com', 1, 13, 99, 1, 0, '2016-06-01 00:17:11'),
(34, 'www.oneinhundred.com', 1, 14, 99, 1, 0, '2016-06-01 00:23:25'),
(35, 'www.barproducts.com', 1, 15, 99, 1, 0, '2016-06-01 00:24:20'),
(36, 'www.inkhead.com', 1, 16, 99, 1, 0, '2016-06-01 00:27:04'),
(37, 'www.crateandbarrel.com', 1, 17, 99, 1, 0, '2016-06-01 00:28:58'),
(38, 'Stone Sinks', 1, 18, 99, 1, 0, '2016-06-02 03:21:49'),
(39, 'www.jd.com', 1, 19, 99, 1, 0, '2016-06-02 07:00:09'),
(40, 'Stone Sink', 1, 20, 99, 1, 0, '2016-06-06 08:25:58'),
(41, 'www.roomstogo.com', 36, 1, 99, 1, 2, '2016-06-06 09:30:41'),
(42, 'www.roomstogo.com', 37, 1, 99, 1, 2, '2016-06-06 09:40:10'),
(43, 'stone', 1, 1365443, 99, 1, 0, '2016-06-19 00:42:10'),
(44, 'marble', 1, 1365444, 99, 1, 0, '2016-06-19 01:59:28'),
(45, 'www.sink', 1, 1365445, 99, 1, 0, '2016-06-19 01:59:50');

-- --------------------------------------------------------

--
-- 表的结构 `edm_url_some`
--

CREATE TABLE `edm_url_some` (
  `id` int(11) UNSIGNED NOT NULL,
  `url` varchar(255) NOT NULL,
  `url_parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `log_url`
--

CREATE TABLE `log_url` (
  `url_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'URL ID',
  `visitor_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Visitor ID',
  `visit_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Visit Time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Log URL Table';

-- --------------------------------------------------------

--
-- 表的结构 `log_url_info`
--

CREATE TABLE `log_url_info` (
  `url_id` bigint(20) UNSIGNED NOT NULL COMMENT 'URL ID',
  `url` varchar(255) DEFAULT NULL COMMENT 'URL',
  `referer` varchar(255) DEFAULT NULL COMMENT 'Referrer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Log URL Info Table';

-- --------------------------------------------------------

--
-- 表的结构 `log_visitor`
--

CREATE TABLE `log_visitor` (
  `visitor_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Visitor ID',
  `session_id` varchar(64) DEFAULT NULL COMMENT 'Session ID',
  `first_visit_at` timestamp NULL DEFAULT NULL COMMENT 'First Visit Time',
  `last_visit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last Visit Time',
  `last_url_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Last URL ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Log Visitors Table';

-- --------------------------------------------------------

--
-- 表的结构 `log_visitor_info`
--

CREATE TABLE `log_visitor_info` (
  `visitor_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Visitor ID',
  `http_referer` varchar(255) DEFAULT NULL COMMENT 'HTTP Referrer',
  `http_user_agent` varchar(255) DEFAULT NULL COMMENT 'HTTP User-Agent',
  `http_accept_charset` varchar(255) DEFAULT NULL COMMENT 'HTTP Accept-Charset',
  `http_accept_language` varchar(255) DEFAULT NULL COMMENT 'HTTP Accept-Language',
  `server_addr` varbinary(16) DEFAULT NULL,
  `remote_addr` varbinary(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Log Visitor Info Table';

-- --------------------------------------------------------

--
-- 表的结构 `material_apply`
--

CREATE TABLE `material_apply` (
  `apply_id` int(11) UNSIGNED NOT NULL,
  `apply_code` varchar(100) DEFAULT NULL,
  `apply_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `apply_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `apply_status` tinyint(2) NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_apply_audit`
--

CREATE TABLE `material_apply_audit` (
  `audit_id` int(11) UNSIGNED NOT NULL,
  `audit_apply` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `audit_create` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '审批人',
  `date_create` datetime DEFAULT NULL COMMENT '审批时间',
  `audit_desc` text,
  `audit_status` tinyint(2) DEFAULT '0' COMMENT '审批状态 0待审 1审批通过 -1驳回'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_apply_material`
--

CREATE TABLE `material_apply_material` (
  `material_id` int(11) UNSIGNED NOT NULL,
  `mat_apply` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mat_material` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mat_type` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `total_apply` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `date_repay` date DEFAULT NULL,
  `mat_reason` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_category`
--

CREATE TABLE `material_category` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `cat_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `cat_name` varchar(255) NOT NULL,
  `cat_parent` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `cat_level` smallint(6) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_material`
--

CREATE TABLE `material_material` (
  `material_id` int(11) UNSIGNED NOT NULL,
  `mat_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mat_name` varchar(255) NOT NULL,
  `mat_image` varchar(255) DEFAULT NULL,
  `mat_code` varchar(100) DEFAULT NULL,
  `mat_unit` varchar(100) DEFAULT NULL,
  `mat_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mat_cat1` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mat_cat2` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `max_loan` varchar(100) DEFAULT NULL,
  `min_audit` varchar(100) DEFAULT NULL,
  `depre_rate` decimal(4,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `is_split` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `mat_desc` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_purchase`
--

CREATE TABLE `material_purchase` (
  `purchase_id` int(11) UNSIGNED NOT NULL,
  `pur_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `pur_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `pur_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `total_purchase` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `date_purchase` date DEFAULT NULL,
  `pur_reason` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_purchase_file`
--

CREATE TABLE `material_purchase_file` (
  `file_id` int(11) UNSIGNED NOT NULL,
  `file_purchase` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `file_path` varchar(255) NOT NULL,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_purchase_material`
--

CREATE TABLE `material_purchase_material` (
  `material_id` int(11) UNSIGNED NOT NULL,
  `mat_purchase` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mat_material` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mat_name` varchar(255) NOT NULL,
  `price_unit` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `total_amount` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `price_total` varchar(100) DEFAULT NULL,
  `mat_supplier` varchar(255) NOT NULL,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_store`
--

CREATE TABLE `material_store` (
  `store_id` int(11) NOT NULL,
  `store_company` int(11) UNSIGNED DEFAULT '0',
  `date_store` date DEFAULT NULL,
  `store_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '入库类型 0采购 1赠与 2借用 3退还 4其他',
  `store_desc` text,
  `date_create` datetime DEFAULT NULL,
  `store_create` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_store_item`
--

CREATE TABLE `material_store_item` (
  `item_id` int(11) UNSIGNED NOT NULL,
  `item_store` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `item_brand` varchar(255) DEFAULT NULL,
  `item_mode` varchar(255) DEFAULT NULL,
  `unit_price` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `item_supplier` varchar(255) DEFAULT NULL,
  `item_phone` varchar(100) DEFAULT NULL,
  `item_period` varchar(100) DEFAULT NULL,
  `total_store` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `item_place` varchar(255) DEFAULT NULL,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `material_store_purchase`
--

CREATE TABLE `material_store_purchase` (
  `link_id` int(11) UNSIGNED NOT NULL,
  `link_store` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `link_purchase` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_contract`
--

CREATE TABLE `project_contract` (
  `contract_id` int(11) UNSIGNED NOT NULL,
  `contract_code` varchar(255) NOT NULL,
  `contract_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `total_amount` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `date_sign` datetime DEFAULT NULL,
  `contract_company` varchar(100) DEFAULT NULL,
  `contract_people` varchar(100) DEFAULT NULL,
  `contract_desc` text,
  `contract_create` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_event`
--

CREATE TABLE `project_event` (
  `event_id` int(11) UNSIGNED NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `event_desc` text,
  `event_participant` text,
  `event_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_exp`
--

CREATE TABLE `project_exp` (
  `exp_id` int(11) UNSIGNED NOT NULL,
  `exp_name` varchar(255) NOT NULL,
  `exp_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `exp_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '经验类型 0项目管理 1问题处理 2操作经验 3分析方法 4解决方案 99其他',
  `exp_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `exp_stage` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `exp_task` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `exp_desc` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_expend`
--

CREATE TABLE `project_expend` (
  `expend_id` int(11) UNSIGNED NOT NULL,
  `expend_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `expend_confirm` varchar(255) DEFAULT NULL,
  `total_expend` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `date_expend` datetime DEFAULT NULL,
  `expend_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `expend_stage` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `expend_task` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `expend_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '支出类型 0其他 1一般费用报销 2商务费用 3项目采购 4差旅',
  `expend_reason` text,
  `expend_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_file`
--

CREATE TABLE `project_file` (
  `file_id` int(11) UNSIGNED NOT NULL,
  `file_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属类型:0项目 1合同 2风险 3质量标准 4分享经验',
  `file_object` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `file_path` varchar(255) NOT NULL,
  `file_user` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_hour`
--

CREATE TABLE `project_hour` (
  `hour_id` int(11) UNSIGNED NOT NULL,
  `date_hour` datetime DEFAULT NULL,
  `hour_stage` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `hour_task` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `hour_normal` decimal(9,1) UNSIGNED NOT NULL DEFAULT '0.0',
  `hour_extra` decimal(9,1) UNSIGNED NOT NULL DEFAULT '0.0',
  `hour_desc` text,
  `hour_create` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_link`
--

CREATE TABLE `project_link` (
  `link_id` int(11) UNSIGNED NOT NULL,
  `link_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '类型:0项目参与人,1项目委员会人',
  `link_user` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_material`
--

CREATE TABLE `project_material` (
  `material_id` int(11) UNSIGNED NOT NULL,
  `mat_name` varchar(255) NOT NULL,
  `mat_type` smallint(6) UNSIGNED DEFAULT '0',
  `mat_admin` varchar(255) DEFAULT NULL,
  `date_buy` datetime DEFAULT NULL,
  `total_cost` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `total_amount` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `mat_project` int(11) NOT NULL,
  `mat_stage` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mat_task` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `mat_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_meet`
--

CREATE TABLE `project_meet` (
  `meet_id` int(11) UNSIGNED NOT NULL,
  `meet_name` varchar(255) NOT NULL,
  `meet_address` varchar(255) DEFAULT NULL,
  `meet_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `meet_record` varchar(255) DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `meet_desc` text,
  `meet_participant` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_milestone`
--

CREATE TABLE `project_milestone` (
  `milestone_id` int(11) UNSIGNED NOT NULL,
  `milestone_date` datetime DEFAULT NULL,
  `milestone_desc` text,
  `milestone_create` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_problem`
--

CREATE TABLE `project_problem` (
  `problem_id` int(11) UNSIGNED NOT NULL,
  `problem_name` varchar(255) NOT NULL,
  `problem_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `problem_status` tinyint(2) NOT NULL DEFAULT '0',
  `problem_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `problem_stage` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `problem_task` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `problem_risk` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `problem_desc` text,
  `problem_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_project`
--

CREATE TABLE `project_project` (
  `project_id` int(11) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_code` varchar(100) NOT NULL,
  `project_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `total_budget` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `total_income` decimal(12,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `project_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `project_department` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `project_desc` text,
  `project_charge` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `need_approve` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否需要审批',
  `need_check` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '验收',
  `project_status` smallint(6) NOT NULL DEFAULT '0' COMMENT '项目状态',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_quality_control`
--

CREATE TABLE `project_quality_control` (
  `control_id` int(11) UNSIGNED NOT NULL,
  `control_name` varchar(255) NOT NULL,
  `control_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL,
  `control_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_quality_guarantee`
--

CREATE TABLE `project_quality_guarantee` (
  `gua_id` int(11) UNSIGNED NOT NULL,
  `gua_name` varchar(255) NOT NULL,
  `gua_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL,
  `gua_desc` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_quality_standard`
--

CREATE TABLE `project_quality_standard` (
  `std_id` int(11) UNSIGNED NOT NULL,
  `std_name` varchar(255) NOT NULL,
  `std_type` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '标准类型 0过程质量标准 1结果质量标准',
  `std_desc` text,
  `std_method` text,
  `date_create` datetime DEFAULT NULL,
  `std_create` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_report`
--

CREATE TABLE `project_report` (
  `report_id` int(11) UNSIGNED NOT NULL,
  `report_name` varchar(255) NOT NULL,
  `report_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `report_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `report_stage` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `report_task` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `report_create` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '汇报人',
  `date_create` datetime DEFAULT NULL,
  `report_desc` text,
  `report_object` varchar(255) DEFAULT NULL COMMENT '回报对象已逗号分隔'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_risk`
--

CREATE TABLE `project_risk` (
  `risk_id` int(11) UNSIGNED NOT NULL,
  `risk_name` varchar(255) NOT NULL,
  `risk_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `risk_level` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `risk_impact` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `risk_status` tinyint(2) NOT NULL DEFAULT '0',
  `risk_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `risk_stage` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `risk_desc` text,
  `risk_precaution` text COMMENT '相应措施',
  `risk_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_stage`
--

CREATE TABLE `project_stage` (
  `stage_id` int(11) UNSIGNED NOT NULL,
  `stage_name` varchar(255) NOT NULL,
  `stage_project` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `stage_code` varchar(100) DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `total_budget` decimal(12,2) DEFAULT NULL,
  `stage_desc` text,
  `stage_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `stage_status` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `project_task`
--

CREATE TABLE `project_task` (
  `task_id` int(11) UNSIGNED NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `task_code` varchar(100) DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `task_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `task_level` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `task_desc` text,
  `need_check` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `task_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL,
  `task_status` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `report_file`
--

CREATE TABLE `report_file` (
  `file_id` int(11) UNSIGNED NOT NULL,
  `file_report` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `file_path` varchar(255) NOT NULL,
  `file_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `report_link`
--

CREATE TABLE `report_link` (
  `link_id` int(11) UNSIGNED NOT NULL,
  `link_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '0汇报对象 1抄送对象',
  `link_report` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `link_object` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `link_status` tinyint(2) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `report_link_reply`
--

CREATE TABLE `report_link_reply` (
  `reply_id` int(11) UNSIGNED NOT NULL,
  `reply_report` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_reply` datetime DEFAULT NULL,
  `reply_desc` text,
  `reply_create` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `report_report`
--

CREATE TABLE `report_report` (
  `report_id` int(11) UNSIGNED NOT NULL,
  `report_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0',
  `report_name` varchar(255) NOT NULL,
  `report_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_report` date DEFAULT NULL,
  `report_desc` text,
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `saas_admin_assert`
--

CREATE TABLE `saas_admin_assert` (
  `assert_id` int(10) UNSIGNED NOT NULL COMMENT 'Assert ID',
  `assert_type` varchar(20) DEFAULT NULL COMMENT 'Assert Type',
  `assert_data` text COMMENT 'Assert Data'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin Assert Table';

-- --------------------------------------------------------

--
-- 表的结构 `saas_admin_company`
--

CREATE TABLE `saas_admin_company` (
  `company_id` int(11) UNSIGNED NOT NULL,
  `company_user` int(11) NOT NULL COMMENT '管理员账号',
  `company_contact` varchar(255) DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_industry` int(11) UNSIGNED DEFAULT '0' COMMENT '主行业分类',
  `company_website` varchar(255) DEFAULT NULL,
  `company_about` text,
  `company_logo` varchar(255) DEFAULT NULL,
  `country` smallint(5) DEFAULT NULL,
  `province` int(10) DEFAULT NULL,
  `city` int(10) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `guide_status` tinyint(2) DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `saas_admin_company`
--

INSERT INTO `saas_admin_company` (`company_id`, `company_user`, `company_contact`, `company_email`, `company_name`, `company_industry`, `company_website`, `company_about`, `company_logo`, `country`, `province`, `city`, `street`, `zip`, `guide_status`, `date_create`) VALUES
(1, 1, '杨高教', '1303387324@qq.com', '上海龙茧信息科技有限公司', 0, 'http://ioe6.com/', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2016-11-01 15:25:00');

-- --------------------------------------------------------

--
-- 表的结构 `saas_admin_company.bak`
--

CREATE TABLE `saas_admin_company.bak` (
  `company_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `industry_category` int(11) UNSIGNED DEFAULT NULL COMMENT '主行业分类',
  `website` varchar(255) DEFAULT NULL,
  `country` smallint(5) DEFAULT NULL,
  `province` int(10) DEFAULT NULL,
  `city` int(10) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `scale` varchar(255) DEFAULT NULL COMMENT '人数范围 500-1000',
  `gdp` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT '年产值 单位 万',
  `partner` text COMMENT '合作伙伴JSON格式',
  `desc_country` text COMMENT '主要销往国家: id1,id2',
  `service_rate` smallint(5) UNSIGNED NOT NULL DEFAULT '50' COMMENT '服务质量指数 1 - 100之间 0 未填写',
  `advantage` text COMMENT 'JSON格式',
  `about` text,
  `guide_status` tinyint(2) DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `saas_admin_company.bak`
--

INSERT INTO `saas_admin_company.bak` (`company_id`, `user_id`, `contact_person`, `contact_email`, `name`, `industry_category`, `website`, `country`, `province`, `city`, `street`, `zip`, `scale`, `gdp`, `partner`, `desc_country`, `service_rate`, `advantage`, `about`, `guide_status`, `date_create`) VALUES
(1, 1, 'Jack Ma', '13472497049@163.com', '上海龙茧信息科技有限公司', NULL, 'http://www.abccompany.com/', 0, NULL, NULL, NULL, NULL, NULL, '5000.00', NULL, NULL, 50, NULL, NULL, 1, '2016-04-27 10:27:11'),
(5, 2, NULL, NULL, 'Second Machine', NULL, 'www.second.com', NULL, NULL, NULL, NULL, NULL, NULL, '100000.00', NULL, NULL, 50, NULL, NULL, 0, '2016-04-27 10:28:32'),
(6, 3, NULL, NULL, 'Third Tire', NULL, 'www.third.com', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-04-27 10:28:52'),
(7, 4, NULL, NULL, 'Fourth Window', NULL, 'www.fourth.com', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-04-27 10:31:12'),
(8, 5, NULL, NULL, 'Fifth Automobile', NULL, 'www.fifth', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-04-27 10:33:36'),
(9, 6, NULL, NULL, 'sixth computer', NULL, 'www.6.com', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-04-27 10:35:01'),
(10, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-18 12:38:02'),
(11, 9, 'Jams Li', 'jams.li@gmail.com', 'Fantat Inc Ltd.', NULL, 'http://www.aliexpress.com/store/1830711', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, 'Description', 1, '2016-05-18 12:40:04'),
(12, 10, 'Hellokitty', 'yesye@gmail.com', 'VeryMachine', NULL, 'www.VeryMachine.com', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-05-20 07:04:35'),
(13, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-20 08:28:05'),
(14, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-20 08:47:01'),
(15, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-20 08:52:49'),
(16, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-20 09:13:17'),
(17, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-20 09:13:45'),
(18, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-20 09:19:11'),
(19, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-20 09:23:03'),
(20, 18, 'John Coker', 'john.coker@gmail.com', 'Lightinthebox Ltd. Inc.', NULL, 'http://www.lightinthebox.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, 'Array', 'The Big Online Retailer in the world!', 1, '2016-05-20 09:28:10'),
(21, 19, 'Sam Jin', 'sam_jin@lautus-marble.com', 'Lautus Marble', NULL, 'www.lautus-marble.com', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-05-23 05:17:22'),
(22, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-23 07:03:26'),
(23, 21, 'Jobs', 'jobs@dhgate.com', 'DHgate Ltd Inc.', NULL, 'http://www.dhgate.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-05-24 07:08:11'),
(24, 22, 'Luke Jams', 'jams@easybuy.com', 'Easybuy Ltd Inc.', NULL, 'http://www.easybuy.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, 'The World Best Wholesaler.', 1, '2016-05-24 07:15:13'),
(25, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-25 06:55:43'),
(26, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-05-25 06:58:40'),
(27, 25, 'Jobs', '1303387324@qq.com', 'Apple Inc.', NULL, 'http://www.apple.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, 'Apple leads the world in innovation with iPhone, iPad, Mac, Apple Watch, iOS, OS X, watchOS and more. Visit the site to learn, buy, and get support.', 1, '2016-05-25 08:10:19'),
(28, 26, 'Jobs', '99@qq.com', 'Apple Inc.', NULL, 'http://www.apple.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, 'Apple leads the world in innovation with iPhone, iPad, Mac, Apple Watch, iOS, OS X, watchOS and more. Visit the site to learn, buy, and get support.', 1, '2016-05-25 08:25:15'),
(29, 27, 'Jobs', 'ee@qq.com', 'Apple Inc.', NULL, 'http://www.apple.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, 'Apple leads the world in innovation with iPhone, iPad, Mac, Apple Watch, iOS, OS X, watchOS and more. Visit the site to learn, buy, and get support.', 1, '2016-05-25 08:25:38'),
(30, 28, 'Jobs', '66@qq.com', 'Apple Inc.', NULL, 'http://www.apple.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, 'Apple leads the world in innovation with iPhone, iPad, Mac, Apple Watch, iOS, OS X, watchOS and more. Visit the site to learn, buy, and get support.', 1, '2016-05-25 08:28:56'),
(31, 29, 'Jack Ma', '7777@qq.com', 'ABC Company', NULL, 'http://www.abccompany.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-05-25 10:40:33'),
(32, 30, 'Jack Ma', '11@W.com', 'ABC Company', NULL, 'http://www.abccompany.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-05-25 11:57:15'),
(33, 31, 'Sam Jin', 'sam_jin@lautus-marble.com', 'Lautus Marble', NULL, 'http://www.lautus-marble.com', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-05-26 02:21:04'),
(34, 32, 'Jack Ma', '12@qq.com', 'ABC Company', NULL, 'http://www.abccompany.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-05-26 07:18:25'),
(35, 33, 'Jack Ma', '13@qq.com', 'ABC Company', NULL, 'http://www.abccompany.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-05-26 07:33:56'),
(36, 34, 'Jack Ma', '123456@qq.com', 'ABC Company', NULL, 'http://www.abccompany.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-06-06 09:29:06'),
(37, 35, 'Jack Ma', '1303387325@qq.com', 'ABC Company', NULL, 'http://www.abccompany.com/', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 1, '2016-06-06 09:38:48'),
(38, 36, 'Micheal', '1303387326@qq.com', 'InkHead, Inc.', NULL, 'www.inkhead.com', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', NULL, NULL, 50, NULL, NULL, 0, '2016-06-06 10:19:54');

-- --------------------------------------------------------

--
-- 表的结构 `saas_admin_department`
--

CREATE TABLE `saas_admin_department` (
  `department_id` int(11) UNSIGNED NOT NULL,
  `dep_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `dep_name` varchar(100) NOT NULL,
  `dep_code` varchar(20) DEFAULT NULL,
  `dep_parent` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '上级部门',
  `dep_level` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT '部门等级0公司',
  `dep_position` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `saas_admin_role`
--

CREATE TABLE `saas_admin_role` (
  `role_id` int(10) UNSIGNED NOT NULL COMMENT 'Role ID',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Parent Role ID',
  `tree_level` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Role Tree Level',
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Role Sort Order',
  `role_type` varchar(1) NOT NULL DEFAULT '0' COMMENT 'Role Type',
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'User ID',
  `role_name` varchar(50) DEFAULT NULL COMMENT 'Role Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin Role Table';

--
-- 转存表中的数据 `saas_admin_role`
--

INSERT INTO `saas_admin_role` (`role_id`, `parent_id`, `tree_level`, `sort_order`, `role_type`, `user_id`, `role_name`) VALUES
(1, 0, 1, 1, 'G', 0, '超级管理员'),
(3, 1, 2, 0, 'U', 1, 'admin'),
(4, 0, 1, 0, 'G', 0, '产品总监'),
(5, 0, 1, 0, 'G', 0, '运营总监'),
(6, 0, 1, 0, 'G', 0, '运营人员'),
(9, 0, 1, 0, 'G', 0, '产品人员'),
(14, 6, 2, 0, 'U', 5, '宏芸'),
(15, 6, 2, 0, 'U', 6, '青'),
(16, 5, 2, 0, 'U', 4, '席军'),
(17, 4, 2, 0, 'U', 3, '吕兰'),
(19, 1, 2, 0, 'U', 2, '杨琼'),
(25, 1, 2, 0, 'U', 7, NULL),
(26, 1, 2, 0, 'U', 8, NULL),
(27, 1, 2, 0, 'U', 9, NULL),
(28, 1, 2, 0, 'U', 10, NULL),
(29, 1, 2, 0, 'U', 11, NULL),
(30, 1, 2, 0, 'U', 12, NULL),
(31, 1, 2, 0, 'U', 13, NULL),
(32, 1, 2, 0, 'U', 14, NULL),
(33, 1, 2, 0, 'U', 15, NULL),
(34, 1, 2, 0, 'U', 16, NULL),
(35, 1, 2, 0, 'U', 17, NULL),
(36, 1, 2, 0, 'U', 18, NULL),
(37, 1, 2, 0, 'U', 19, NULL),
(38, 1, 2, 0, 'U', 20, NULL),
(39, 1, 2, 0, 'U', 21, NULL),
(40, 1, 2, 0, 'U', 22, NULL),
(41, 1, 2, 0, 'U', 23, NULL),
(42, 1, 2, 0, 'U', 24, NULL),
(43, 1, 2, 0, 'U', 25, NULL),
(44, 1, 2, 0, 'U', 28, NULL),
(45, 1, 2, 0, 'U', 29, NULL),
(46, 1, 2, 0, 'U', 30, NULL),
(47, 1, 2, 0, 'U', 31, NULL),
(48, 1, 2, 0, 'U', 32, NULL),
(49, 1, 2, 0, 'U', 33, NULL),
(50, 1, 2, 0, 'U', 34, NULL),
(51, 1, 2, 0, 'U', 35, NULL),
(52, 1, 2, 0, 'U', 36, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `saas_admin_rule`
--

CREATE TABLE `saas_admin_rule` (
  `rule_id` int(10) UNSIGNED NOT NULL COMMENT 'Rule ID',
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Role ID',
  `resource_id` varchar(255) DEFAULT NULL COMMENT 'Resource ID',
  `privileges` varchar(20) DEFAULT NULL COMMENT 'Privileges',
  `assert_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Assert ID',
  `role_type` varchar(1) DEFAULT NULL COMMENT 'Role Type',
  `permission` varchar(10) DEFAULT NULL COMMENT 'Permission'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin Rule Table';

--
-- 转存表中的数据 `saas_admin_rule`
--

INSERT INTO `saas_admin_rule` (`rule_id`, `role_id`, `resource_id`, `privileges`, `assert_id`, `role_type`, `permission`) VALUES
(2, 1, 'all', NULL, 0, 'G', 'allow'),
(247, 4, 'all', NULL, 0, 'G', 'allow'),
(248, 9, 'all', NULL, 0, 'G', 'deny'),
(249, 9, 'admin', NULL, 0, 'G', 'deny'),
(250, 9, 'admin/dashboard', NULL, 0, 'G', 'deny'),
(251, 9, 'admin/system', NULL, 0, 'G', 'deny'),
(252, 9, 'admin/system/acl', NULL, 0, 'G', 'deny'),
(253, 9, 'admin/system/acl/roles', NULL, 0, 'G', 'deny'),
(254, 9, 'admin/system/acl/users', NULL, 0, 'G', 'deny'),
(255, 9, 'admin/system/acl/variables', NULL, 0, 'G', 'deny'),
(256, 9, 'admin/system/acl/blocks', NULL, 0, 'G', 'deny'),
(257, 9, 'admin/system/store', NULL, 0, 'G', 'deny'),
(258, 9, 'admin/system/design', NULL, 0, 'G', 'deny'),
(259, 9, 'admin/system/config', NULL, 0, 'G', 'deny'),
(260, 9, 'admin/system/config/general', NULL, 0, 'G', 'deny'),
(261, 9, 'admin/system/config/web', NULL, 0, 'G', 'deny'),
(262, 9, 'admin/system/config/design', NULL, 0, 'G', 'deny'),
(263, 9, 'admin/system/config/system', NULL, 0, 'G', 'deny'),
(264, 9, 'admin/system/config/advanced', NULL, 0, 'G', 'deny'),
(265, 9, 'admin/system/config/trans_email', NULL, 0, 'G', 'deny'),
(266, 9, 'admin/system/config/dev', NULL, 0, 'G', 'deny'),
(267, 9, 'admin/system/config/currency', NULL, 0, 'G', 'deny'),
(268, 9, 'admin/system/config/sendfriend', NULL, 0, 'G', 'deny'),
(269, 9, 'admin/system/config/admin', NULL, 0, 'G', 'deny'),
(270, 9, 'admin/system/config/payment', NULL, 0, 'G', 'deny'),
(271, 9, 'admin/system/config/payment_services', NULL, 0, 'G', 'deny'),
(272, 9, 'admin/system/config/api', NULL, 0, 'G', 'deny'),
(273, 9, 'admin/system/config/oauth', NULL, 0, 'G', 'deny'),
(274, 9, 'admin/system/config/persistent', NULL, 0, 'G', 'deny'),
(275, 9, 'admin/system/config/plan', NULL, 0, 'G', 'deny'),
(276, 9, 'admin/system/currency', NULL, 0, 'G', 'deny'),
(277, 9, 'admin/system/email_template', NULL, 0, 'G', 'deny'),
(278, 9, 'admin/system/variable', NULL, 0, 'G', 'deny'),
(279, 9, 'admin/system/myaccount', NULL, 0, 'G', 'deny'),
(280, 9, 'admin/system/tools', NULL, 0, 'G', 'deny'),
(281, 9, 'admin/system/tools/compiler', NULL, 0, 'G', 'deny'),
(282, 9, 'admin/system/convert', NULL, 0, 'G', 'deny'),
(283, 9, 'admin/system/convert/gui', NULL, 0, 'G', 'deny'),
(284, 9, 'admin/system/convert/profiles', NULL, 0, 'G', 'deny'),
(285, 9, 'admin/system/convert/import', NULL, 0, 'G', 'deny'),
(286, 9, 'admin/system/convert/export', NULL, 0, 'G', 'deny'),
(287, 9, 'admin/system/cache', NULL, 0, 'G', 'deny'),
(288, 9, 'admin/system/extensions', NULL, 0, 'G', 'deny'),
(289, 9, 'admin/system/extensions/local', NULL, 0, 'G', 'deny'),
(290, 9, 'admin/system/extensions/custom', NULL, 0, 'G', 'deny'),
(291, 9, 'admin/system/adminnotification', NULL, 0, 'G', 'deny'),
(292, 9, 'admin/system/adminnotification/show_toolbar', NULL, 0, 'G', 'deny'),
(293, 9, 'admin/system/adminnotification/show_list', NULL, 0, 'G', 'deny'),
(294, 9, 'admin/system/adminnotification/mark_as_read', NULL, 0, 'G', 'deny'),
(295, 9, 'admin/system/adminnotification/remove', NULL, 0, 'G', 'deny'),
(296, 9, 'admin/system/index', NULL, 0, 'G', 'deny'),
(297, 9, 'admin/system/api', NULL, 0, 'G', 'deny'),
(298, 9, 'admin/system/api/users', NULL, 0, 'G', 'deny'),
(299, 9, 'admin/system/api/roles', NULL, 0, 'G', 'deny'),
(300, 9, 'admin/system/api/consumer', NULL, 0, 'G', 'deny'),
(301, 9, 'admin/system/api/consumer/edit', NULL, 0, 'G', 'deny'),
(302, 9, 'admin/system/api/consumer/delete', NULL, 0, 'G', 'deny'),
(303, 9, 'admin/system/api/authorizedTokens', NULL, 0, 'G', 'deny'),
(304, 9, 'admin/system/api/oauth_admin_token', NULL, 0, 'G', 'deny'),
(305, 9, 'admin/system/api/rest_roles', NULL, 0, 'G', 'deny'),
(306, 9, 'admin/system/api/rest_roles/add', NULL, 0, 'G', 'deny'),
(307, 9, 'admin/system/api/rest_roles/edit', NULL, 0, 'G', 'deny'),
(308, 9, 'admin/system/api/rest_roles/delete', NULL, 0, 'G', 'deny'),
(309, 9, 'admin/system/api/rest_attributes', NULL, 0, 'G', 'deny'),
(310, 9, 'admin/system/api/rest_attributes/edit', NULL, 0, 'G', 'deny'),
(311, 9, 'admin/global_search', NULL, 0, 'G', 'deny'),
(312, 9, 'admin/cms', NULL, 0, 'G', 'deny'),
(313, 9, 'admin/cms/widget_instance', NULL, 0, 'G', 'deny'),
(314, 9, 'admin/page_cache', NULL, 0, 'G', 'deny'),
(315, 9, 'admin/customize', NULL, 0, 'G', 'deny'),
(316, 9, 'admin/customize/category', NULL, 0, 'G', 'deny'),
(317, 9, 'admin/customize/photo', NULL, 0, 'G', 'deny'),
(318, 9, 'admin/customize/theme', NULL, 0, 'G', 'deny'),
(319, 9, 'admin/customize/theme_category', NULL, 0, 'G', 'deny'),
(320, 9, 'admin/customize/design', NULL, 0, 'G', 'deny'),
(321, 9, 'admin/customize/design_category', NULL, 0, 'G', 'deny'),
(322, 9, 'admin/plan_product', NULL, 0, 'G', 'deny'),
(323, 9, 'admin/plan_plan', NULL, 0, 'G', 'deny'),
(324, 9, 'admin/plan_case', NULL, 0, 'G', 'deny'),
(325, 9, 'admin/review', NULL, 0, 'G', 'deny'),
(326, 9, 'admin/scene', NULL, 0, 'G', 'deny'),
(327, 9, 'admin/wiki', NULL, 0, 'G', 'deny'),
(328, 9, 'admin/sentence', NULL, 0, 'G', 'deny'),
(329, 6, 'all', NULL, 0, 'G', 'allow'),
(330, 5, 'all', NULL, 0, 'G', 'allow');

-- --------------------------------------------------------

--
-- 表的结构 `saas_admin_user`
--

CREATE TABLE `saas_admin_user` (
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'User ID',
  `name` varchar(32) DEFAULT NULL COMMENT 'User First Name',
  `email` varchar(128) DEFAULT NULL COMMENT 'User Email',
  `username` varchar(40) DEFAULT NULL COMMENT 'User Login',
  `password` varchar(100) DEFAULT NULL COMMENT 'User Password',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'User Created Time',
  `modified` timestamp NULL DEFAULT NULL COMMENT 'User Modified Time',
  `logdate` timestamp NULL DEFAULT NULL COMMENT 'User Last Login Time',
  `lognum` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'User Login Number',
  `reload_acl_flag` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Reload ACL',
  `is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'User Is Active',
  `company_id` int(11) DEFAULT '0',
  `status_guide_email` tinyint(2) UNSIGNED DEFAULT '0',
  `extra` text COMMENT 'User Extra Data',
  `aff_code` varchar(255) DEFAULT NULL,
  `rp_token` text COMMENT 'Reset Password Link Token',
  `rp_token_created_at` timestamp NULL DEFAULT NULL COMMENT 'Reset Password Link Token Creation Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Admin User Table';

--
-- 转存表中的数据 `saas_admin_user`
--

INSERT INTO `saas_admin_user` (`user_id`, `name`, `email`, `username`, `password`, `created`, `modified`, `logdate`, `lognum`, `reload_acl_flag`, `is_active`, `company_id`, `status_guide_email`, `extra`, `aff_code`, `rp_token`, `rp_token_created_at`) VALUES
(1, '杨高教', 'luke@ioe6.com', 'admin', '0192023a7bbd73250516f069df18b500', '2015-12-24 21:16:24', '2016-11-01 09:06:28', '2016-11-01 17:15:42', 299, 0, 1, 1, 1, 'a:1:{s:11:"configState";a:27:{s:12:"dev_restrict";s:1:"0";s:9:"dev_debug";s:1:"0";s:12:"dev_template";s:1:"0";s:20:"dev_translate_inline";s:1:"0";s:7:"dev_log";s:1:"0";s:6:"dev_js";s:1:"1";s:7:"dev_css";s:1:"1";s:7:"web_url";s:1:"0";s:7:"web_seo";s:1:"1";s:12:"web_unsecure";s:1:"0";s:10:"web_secure";s:1:"0";s:11:"web_default";s:1:"0";s:9:"web_polls";s:1:"0";s:10:"web_cookie";s:1:"0";s:11:"web_session";s:1:"0";s:24:"web_browser_capabilities";s:1:"0";s:14:"design_package";s:1:"0";s:12:"design_theme";s:1:"0";s:11:"design_head";s:1:"1";s:13:"design_header";s:1:"1";s:13:"design_footer";s:1:"0";s:16:"design_watermark";s:1:"1";s:17:"design_pagination";s:1:"0";s:12:"design_email";s:1:"0";s:13:"plan_settings";s:1:"1";s:11:"system_csrf";s:1:"0";s:16:"edm_txt_analysis";s:1:"1";}}', NULL, '3a2c4e2c7fe8684952a141b16ce70762', '2016-11-01 09:06:28'),
(25, NULL, '1303387324@qq.com', 'garyyang', '556018d452903cbac8e8798481304f1a:g4LaVbzfNneoHfq4v98LhsIQQoxeX7kp', '2016-05-25 00:10:19', '2016-05-25 00:10:19', '2016-05-25 00:10:19', 1, 0, 1, 27, 0, 'N;', '937607642b934b3122143257d4d06e40574554ade1e6d', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `task_project`
--

CREATE TABLE `task_project` (
  `project_id` int(11) UNSIGNED NOT NULL,
  `project_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `project_name` varchar(255) NOT NULL,
  `project_desc` text,
  `is_private` tinyint(2) UNSIGNED DEFAULT '0' COMMENT '0公开 1私密',
  `project_create` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `task_project`
--

INSERT INTO `task_project` (`project_id`, `project_company`, `project_name`, `project_desc`, `is_private`, `project_create`, `date_create`) VALUES
(1, 1, 'IOEGO OA线上办公系统开发', 'IOEGO OA线上办公系统开发', 0, 1, '2016-10-31 00:11:01');

-- --------------------------------------------------------

--
-- 表的结构 `task_project_link`
--

CREATE TABLE `task_project_link` (
  `link_id` int(11) UNSIGNED NOT NULL,
  `link_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '类型:0管理员,1验收人，1关注人，2发布人',
  `link_user` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `task_task`
--

CREATE TABLE `task_task` (
  `task_id` int(11) UNSIGNED NOT NULL,
  `task_name` varchar(255) NOT NULL DEFAULT '0',
  `task_project` int(11) UNSIGNED NOT NULL,
  `task_company` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `task_level` tinyint(2) UNSIGNED DEFAULT '0',
  `task_create` int(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发布人',
  `task_desc` text,
  `date_create` datetime DEFAULT NULL,
  `task_status` smallint(6) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `task_task_file`
--

CREATE TABLE `task_task_file` (
  `file_id` int(11) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_user` int(11) UNSIGNED DEFAULT '0',
  `date_create` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `task_task_link`
--

CREATE TABLE `task_task_link` (
  `link_id` int(11) UNSIGNED NOT NULL,
  `link_type` smallint(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '类型:0负责人，1关注人，2验收人',
  `link_user` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_assert`
--
ALTER TABLE `admin_assert`
  ADD PRIMARY KEY (`assert_id`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `IDX_ADMIN_ROLE_PARENT_ID_SORT_ORDER` (`parent_id`,`sort_order`),
  ADD KEY `IDX_ADMIN_ROLE_TREE_LEVEL` (`tree_level`);

--
-- Indexes for table `admin_rule`
--
ALTER TABLE `admin_rule`
  ADD PRIMARY KEY (`rule_id`),
  ADD KEY `IDX_ADMIN_RULE_RESOURCE_ID_ROLE_ID` (`resource_id`,`role_id`),
  ADD KEY `IDX_ADMIN_RULE_ROLE_ID_RESOURCE_ID` (`role_id`,`resource_id`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UNQ_ADMIN_USER_USERNAME` (`username`);

--
-- Indexes for table `approve_apply`
--
ALTER TABLE `approve_apply`
  ADD PRIMARY KEY (`apply_id`);

--
-- Indexes for table `approve_apply_audit`
--
ALTER TABLE `approve_apply_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `approve_apply_link`
--
ALTER TABLE `approve_apply_link`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `approve_template`
--
ALTER TABLE `approve_template`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `approve_template_audit`
--
ALTER TABLE `approve_template_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `attendance_attendance`
--
ALTER TABLE `attendance_attendance`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `attendance_fieldwork`
--
ALTER TABLE `attendance_fieldwork`
  ADD PRIMARY KEY (`fieldwork_id`);

--
-- Indexes for table `attendance_leave`
--
ALTER TABLE `attendance_leave`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `attendance_overtime`
--
ALTER TABLE `attendance_overtime`
  ADD PRIMARY KEY (`overtime_id`);

--
-- Indexes for table `attendance_travel`
--
ALTER TABLE `attendance_travel`
  ADD PRIMARY KEY (`travel_id`);

--
-- Indexes for table `bill_file`
--
ALTER TABLE `bill_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `bill_link`
--
ALTER TABLE `bill_link`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `bill_loan`
--
ALTER TABLE `bill_loan`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `bill_loan_audit`
--
ALTER TABLE `bill_loan_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `bill_loan_bank`
--
ALTER TABLE `bill_loan_bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `bill_loan_item`
--
ALTER TABLE `bill_loan_item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `bill_reimburse`
--
ALTER TABLE `bill_reimburse`
  ADD PRIMARY KEY (`reimburse_id`);

--
-- Indexes for table `bill_reimburse_audit`
--
ALTER TABLE `bill_reimburse_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `bill_reimburse_bank`
--
ALTER TABLE `bill_reimburse_bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `bill_reimburse_item`
--
ALTER TABLE `bill_reimburse_item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `bill_revenue`
--
ALTER TABLE `bill_revenue`
  ADD PRIMARY KEY (`revenue_id`);

--
-- Indexes for table `bill_revenue_item`
--
ALTER TABLE `bill_revenue_item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `bill_setting_project`
--
ALTER TABLE `bill_setting_project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `bill_setting_type`
--
ALTER TABLE `bill_setting_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `bulletin_msg`
--
ALTER TABLE `bulletin_msg`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `bulletin_msg_audit`
--
ALTER TABLE `bulletin_msg_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `bulletin_msg_file`
--
ALTER TABLE `bulletin_msg_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `bulletin_msg_visible`
--
ALTER TABLE `bulletin_msg_visible`
  ADD PRIMARY KEY (`visible_id`);

--
-- Indexes for table `bulletin_setting_type`
--
ALTER TABLE `bulletin_setting_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `cms_block`
--
ALTER TABLE `cms_block`
  ADD PRIMARY KEY (`block_id`);

--
-- Indexes for table `cms_page`
--
ALTER TABLE `cms_page`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `IDX_CMS_PAGE_IDENTIFIER` (`identifier`);

--
-- Indexes for table `core_cache`
--
ALTER TABLE `core_cache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CORE_CACHE_EXPIRE_TIME` (`expire_time`);

--
-- Indexes for table `core_cache_option`
--
ALTER TABLE `core_cache_option`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `core_cache_tag`
--
ALTER TABLE `core_cache_tag`
  ADD PRIMARY KEY (`tag`,`cache_id`),
  ADD KEY `IDX_CORE_CACHE_TAG_CACHE_ID` (`cache_id`);

--
-- Indexes for table `core_config_data`
--
ALTER TABLE `core_config_data`
  ADD PRIMARY KEY (`config_id`),
  ADD UNIQUE KEY `UNQ_CORE_CONFIG_DATA_SCOPE_SCOPE_ID_PATH` (`path`);

--
-- Indexes for table `core_email_template`
--
ALTER TABLE `core_email_template`
  ADD PRIMARY KEY (`template_id`),
  ADD UNIQUE KEY `UNQ_CORE_EMAIL_TEMPLATE_TEMPLATE_CODE` (`template_code`),
  ADD KEY `IDX_CORE_EMAIL_TEMPLATE_ADDED_AT` (`added_at`),
  ADD KEY `IDX_CORE_EMAIL_TEMPLATE_MODIFIED_AT` (`modified_at`);

--
-- Indexes for table `core_layout_link`
--
ALTER TABLE `core_layout_link`
  ADD PRIMARY KEY (`layout_link_id`),
  ADD UNIQUE KEY `UNQ_CORE_LAYOUT_LINK_PACKAGE_THEME_LAYOUT_UPDATE_ID` (`package`,`theme`,`layout_update_id`),
  ADD KEY `IDX_CORE_LAYOUT_LINK_LAYOUT_UPDATE_ID` (`layout_update_id`);

--
-- Indexes for table `core_layout_update`
--
ALTER TABLE `core_layout_update`
  ADD PRIMARY KEY (`layout_update_id`),
  ADD KEY `IDX_CORE_LAYOUT_UPDATE_HANDLE` (`handle`);

--
-- Indexes for table `core_resource`
--
ALTER TABLE `core_resource`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `core_session`
--
ALTER TABLE `core_session`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `core_url_rewrite`
--
ALTER TABLE `core_url_rewrite`
  ADD PRIMARY KEY (`url_rewrite_id`),
  ADD UNIQUE KEY `UNQ_CORE_URL_REWRITE_REQUEST_PATH` (`request_path`),
  ADD UNIQUE KEY `UNQ_CORE_URL_REWRITE_ID_PATH_IS_SYSTEM` (`id_path`,`is_system`),
  ADD KEY `IDX_CORE_URL_REWRITE_TARGET_PATH` (`target_path`),
  ADD KEY `IDX_CORE_URL_REWRITE_ID_PATH` (`id_path`),
  ADD KEY `FK_CORE_URL_REWRITE_CTGR_ID_CAT_CTGR_ENTT_ENTT_ID` (`category_id`),
  ADD KEY `FK_CORE_URL_REWRITE_PRODUCT_ID_CATALOG_CATEGORY_ENTITY_ENTITY_ID` (`product_id`);

--
-- Indexes for table `core_variable`
--
ALTER TABLE `core_variable`
  ADD PRIMARY KEY (`variable_id`),
  ADD UNIQUE KEY `UNQ_CORE_VARIABLE_CODE` (`code`);

--
-- Indexes for table `core_variable_value`
--
ALTER TABLE `core_variable_value`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `UNQ_CORE_VARIABLE_VALUE_VARIABLE_ID` (`variable_id`),
  ADD KEY `IDX_CORE_VARIABLE_VALUE_VARIABLE_ID` (`variable_id`);

--
-- Indexes for table `crm_activity`
--
ALTER TABLE `crm_activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `crm_chance`
--
ALTER TABLE `crm_chance`
  ADD PRIMARY KEY (`chance_id`);

--
-- Indexes for table `crm_client`
--
ALTER TABLE `crm_client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `crm_clue`
--
ALTER TABLE `crm_clue`
  ADD PRIMARY KEY (`clue_id`);

--
-- Indexes for table `crm_competitor`
--
ALTER TABLE `crm_competitor`
  ADD PRIMARY KEY (`comp_id`);

--
-- Indexes for table `crm_contact`
--
ALTER TABLE `crm_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `crm_media`
--
ALTER TABLE `crm_media`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `crm_order`
--
ALTER TABLE `crm_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `edm_aff`
--
ALTER TABLE `edm_aff`
  ADD PRIMARY KEY (`aff_id`);

--
-- Indexes for table `edm_article`
--
ALTER TABLE `edm_article`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `edm_article_category`
--
ALTER TABLE `edm_article_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edm_article_wx`
--
ALTER TABLE `edm_article_wx`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edm_cert`
--
ALTER TABLE `edm_cert`
  ADD PRIMARY KEY (`cert_id`);

--
-- Indexes for table `edm_client`
--
ALTER TABLE `edm_client`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `UNQ_INS_CLIENT_WEBSITE` (`website`);

--
-- Indexes for table `edm_client_attr`
--
ALTER TABLE `edm_client_attr`
  ADD PRIMARY KEY (`attr_id`),
  ADD KEY `IDX_INS_CLIENT_ATTR_NAME` (`name`);

--
-- Indexes for table `edm_client_attr_option`
--
ALTER TABLE `edm_client_attr_option`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `edm_client_attr_value`
--
ALTER TABLE `edm_client_attr_value`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `UNQ_INS_CLIENT_ATTR_VALUE_CLIENT_ATTR_VALUE` (`attr_id`,`client_id`,`value`),
  ADD KEY `IDX_INS_CLIENT_ATTR_VALUE_CLIENT` (`client_id`),
  ADD KEY `IDX_INS_CLIENT_ATTR_VALUE_ATTR` (`attr_id`);

--
-- Indexes for table `edm_client_attr_value_copy`
--
ALTER TABLE `edm_client_attr_value_copy`
  ADD PRIMARY KEY (`value_id`),
  ADD KEY `IDX_INS_CLIENT_ATTR_VALUE_CLIENT` (`client_id`),
  ADD KEY `IDX_INS_CLIENT_ATTR_VALUE_ATTR` (`attr_id`);

--
-- Indexes for table `edm_client_category`
--
ALTER TABLE `edm_client_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_INS_TEMPLATES_CATEGORY_RELATE` (`client_id`,`category_id`);

--
-- Indexes for table `edm_client_email`
--
ALTER TABLE `edm_client_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNQ_INS_CLIENT_EMAIL_EMAIL_CLIENT_ID` (`email`,`client_id`),
  ADD KEY `IDX_INS_CLIENT_EMAIL_CLIENT_ID` (`client_id`);

--
-- Indexes for table `edm_client_email_attr`
--
ALTER TABLE `edm_client_email_attr`
  ADD PRIMARY KEY (`attr_id`),
  ADD KEY `IDX_INS_CLIENT_EMAIL_ATTR_NAME` (`name`);

--
-- Indexes for table `edm_client_email_attr_option`
--
ALTER TABLE `edm_client_email_attr_option`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `edm_client_email_attr_value`
--
ALTER TABLE `edm_client_email_attr_value`
  ADD PRIMARY KEY (`value_id`),
  ADD KEY `IDX_INS_CLIENT_EMAIL_ATTR_VALUE_CLIENT` (`email_id`),
  ADD KEY `IDX_INS_CLIENT_EMAIL_ATTR_VALUE_ATTR` (`attr_id`);

--
-- Indexes for table `edm_client_rule`
--
ALTER TABLE `edm_client_rule`
  ADD PRIMARY KEY (`rule_id`);

--
-- Indexes for table `edm_client_rule_pagetype`
--
ALTER TABLE `edm_client_rule_pagetype`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `edm_client_rule_variable`
--
ALTER TABLE `edm_client_rule_variable`
  ADD PRIMARY KEY (`variable_id`),
  ADD UNIQUE KEY `UNQ_INS_CLIENT_RULE_VARIABLE_NAME` (`name`);

--
-- Indexes for table `edm_client_temp`
--
ALTER TABLE `edm_client_temp`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `UNQ_INS_CLIENT_TEMP_WEBSITE` (`website`);

--
-- Indexes for table `edm_client_text_rule`
--
ALTER TABLE `edm_client_text_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edm_client_text_tmp`
--
ALTER TABLE `edm_client_text_tmp`
  ADD PRIMARY KEY (`text_id`),
  ADD UNIQUE KEY `UNQ_INS_CLIENT_TEXT_URL` (`url`);

--
-- Indexes for table `edm_company_advantage`
--
ALTER TABLE `edm_company_advantage`
  ADD PRIMARY KEY (`advantage_id`),
  ADD UNIQUE KEY `UNQ_INS_CLIENT_ATTR_CODE` (`code`),
  ADD KEY `IDX_INS_CLIENT_ATTR_NAME` (`name`);

--
-- Indexes for table `edm_company_advantage_attrvalue`
--
ALTER TABLE `edm_company_advantage_attrvalue`
  ADD PRIMARY KEY (`value_id`),
  ADD KEY `IDX_INS_COMPANY_ADVANTAGW_ATTRVALUE_ATTR` (`attr_id`),
  ADD KEY `IDX_INS_COMPANY_ADVANTAGW_ATTRVALUE_ADVANTAGE` (`advantage_id`);

--
-- Indexes for table `edm_company_advantage_image`
--
ALTER TABLE `edm_company_advantage_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `IDX_INS_CLIENT_ADVANTAGE_VALUE_CLIENT` (`company_id`),
  ADD KEY `IDX_INS_CLIENT_ADVANTAGE_VALUE_ATTR` (`advantage_id`);

--
-- Indexes for table `edm_company_advantage_option`
--
ALTER TABLE `edm_company_advantage_option`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `edm_company_advantage_value`
--
ALTER TABLE `edm_company_advantage_value`
  ADD PRIMARY KEY (`value_id`),
  ADD UNIQUE KEY `UNQ_INS_CLIENT_ADVANTAGE_VALUE_CLIENT_ADVANTAGE_VALUE` (`advantage_id`,`company_id`,`value`),
  ADD KEY `IDX_INS_CLIENT_ADVANTAGE_VALUE_CLIENT` (`company_id`),
  ADD KEY `IDX_INS_CLIENT_ADVANTAGE_VALUE_ATTR` (`advantage_id`);

--
-- Indexes for table `edm_company_attr`
--
ALTER TABLE `edm_company_attr`
  ADD PRIMARY KEY (`attr_id`),
  ADD KEY `IDX_INS_COMPANY_ATTR_NAME` (`name`);

--
-- Indexes for table `edm_company_attr_value`
--
ALTER TABLE `edm_company_attr_value`
  ADD PRIMARY KEY (`value_id`),
  ADD KEY `IDX_INS_COMPANY_ATTR_VALUE_CLIENT` (`company_id`),
  ADD KEY `IDX_INS_COMPANY_ATTR_VALUE_ATTR` (`attr_id`);

--
-- Indexes for table `edm_company_category`
--
ALTER TABLE `edm_company_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_INS_COMPANY_CATEGORY_RELATE` (`company_id`,`category_id`);

--
-- Indexes for table `edm_company_cert`
--
ALTER TABLE `edm_company_cert`
  ADD PRIMARY KEY (`cert_id`);

--
-- Indexes for table `edm_company_client`
--
ALTER TABLE `edm_company_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UNQ_INS_COMPANY_CLIENT_COMPANY_CLIENT` (`company_id`,`client_id`);

--
-- Indexes for table `edm_company_client_category`
--
ALTER TABLE `edm_company_client_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `edm_company_client_category_relate`
--
ALTER TABLE `edm_company_client_category_relate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UNQ_INS_COMPANY_CLIENT_CATEOGRY_CATEOGRY_CLIENT` (`category_id`,`client_id`);

--
-- Indexes for table `edm_company_client_email`
--
ALTER TABLE `edm_company_client_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNQ_INS_COMPANY_CLIENT_EMAIL_COMPANY_CLIENT_EMAIL` (`email_company`,`email_client`,`email`),
  ADD KEY `IDX_INS_COMPANY_CLIENT_EMAIL_COMPANY_ID` (`email_company`);

--
-- Indexes for table `edm_company_draft`
--
ALTER TABLE `edm_company_draft`
  ADD PRIMARY KEY (`draft_id`);

--
-- Indexes for table `edm_company_email`
--
ALTER TABLE `edm_company_email`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNQ_INS_COMPANY_EMAIL_EMAIL_COMPANY_ID` (`email`,`company_id`),
  ADD KEY `IDX_INS_COMPANY_EMAIL_COMPANY_ID` (`company_id`);

--
-- Indexes for table `edm_company_email_send`
--
ALTER TABLE `edm_company_email_send`
  ADD PRIMARY KEY (`send_id`),
  ADD KEY `IDX_INS_COMPANY_EMAIL_SEND_SUBJECT_FROM_TO` (`subject`,`email_from`,`email_to`);

--
-- Indexes for table `edm_company_group`
--
ALTER TABLE `edm_company_group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `edm_company_keyword`
--
ALTER TABLE `edm_company_keyword`
  ADD PRIMARY KEY (`keyword_id`);

--
-- Indexes for table `edm_company_keyword_url`
--
ALTER TABLE `edm_company_keyword_url`
  ADD PRIMARY KEY (`url_id`);

--
-- Indexes for table `edm_company_media`
--
ALTER TABLE `edm_company_media`
  ADD PRIMARY KEY (`media_id`);

--
-- Indexes for table `edm_company_media_category`
--
ALTER TABLE `edm_company_media_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `edm_company_media_category_relate`
--
ALTER TABLE `edm_company_media_category_relate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UNQ_INS_COMPANY_MEDIA_CATEGORY_RELATE` (`category_id`,`media_id`);

--
-- Indexes for table `edm_company_template`
--
ALTER TABLE `edm_company_template`
  ADD PRIMARY KEY (`template_id`),
  ADD KEY `IDX_INS_COMPANY_TEMPLATE_COMPANY_ID` (`template_company`);

--
-- Indexes for table `edm_company_template_draft`
--
ALTER TABLE `edm_company_template_draft`
  ADD PRIMARY KEY (`draft_id`),
  ADD KEY `IDX_INS_COMPANY_TEMPLATE_DRAFT_COMPANY_ID` (`draft_company`);

--
-- Indexes for table `edm_company_template_module`
--
ALTER TABLE `edm_company_template_module`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `UNQ_INS_COMPANY_TEMPLATE_MODULE_NAME_TEMPLATE` (`module_name`,`module_template`) USING BTREE,
  ADD KEY `IDX_INS_COMPANY_TEMPLATE_MODULE_COMPANY` (`module_company`);

--
-- Indexes for table `edm_company_template_module_item`
--
ALTER TABLE `edm_company_template_module_item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `edm_company_template_module_item_attrvalue`
--
ALTER TABLE `edm_company_template_module_item_attrvalue`
  ADD PRIMARY KEY (`value_id`),
  ADD KEY `IDX_INS_COMPANY_TEMPLSATE_MODULE_ITEM_ATTRVALUE_ATTR` (`attr_id`),
  ADD KEY `IDX_INS_COMPANY_TEMPLSATE_MODULE_ITEM_ATTRVALUE_ITEM` (`item_id`) USING BTREE;

--
-- Indexes for table `edm_company_template_module_item_relate`
--
ALTER TABLE `edm_company_template_module_item_relate`
  ADD PRIMARY KEY (`relate_id`);

--
-- Indexes for table `edm_country`
--
ALTER TABLE `edm_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `edm_email_validate`
--
ALTER TABLE `edm_email_validate`
  ADD PRIMARY KEY (`validate_id`);

--
-- Indexes for table `edm_email_white`
--
ALTER TABLE `edm_email_white`
  ADD PRIMARY KEY (`white_id`);

--
-- Indexes for table `edm_esp`
--
ALTER TABLE `edm_esp`
  ADD PRIMARY KEY (`esp_id`);

--
-- Indexes for table `edm_feedback`
--
ALTER TABLE `edm_feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `edm_product`
--
ALTER TABLE `edm_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `IDX_INS_PRODUCT_NAME` (`name`),
  ADD KEY `IDX_INS_PRODUCT_PRICE` (`price`);

--
-- Indexes for table `edm_product_category`
--
ALTER TABLE `edm_product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `edm_product_category_relate`
--
ALTER TABLE `edm_product_category_relate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_INS_TEMPLATES_CATEGORY_RELATE` (`category_id`,`product_id`);

--
-- Indexes for table `edm_product_link`
--
ALTER TABLE `edm_product_link`
  ADD PRIMARY KEY (`link_id`),
  ADD UNIQUE KEY `UNQ_INS_PRD_LNK_LNK_TYPE_ID_PRD_ID_LNK_PRD_ID` (`company_id`,`link_type_id`,`product_id`),
  ADD KEY `IDX_INS_PRODUCT_LINK_CMP_ID` (`company_id`),
  ADD KEY `IDX_INS_PRODUCT_LINK_LINK_TYPE_ID` (`link_type_id`),
  ADD KEY `IDX_INS_PRODUCT_LINK_PRODUCT_ID` (`product_id`);

--
-- Indexes for table `edm_product_link_type`
--
ALTER TABLE `edm_product_link_type`
  ADD PRIMARY KEY (`link_type_id`);

--
-- Indexes for table `edm_send_log`
--
ALTER TABLE `edm_send_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `IDX_SEND_LOG_SUBJECT_FROM_TO` (`subject`,`send_from`,`send_to`);

--
-- Indexes for table `edm_server`
--
ALTER TABLE `edm_server`
  ADD PRIMARY KEY (`server_id`);

--
-- Indexes for table `edm_server_log`
--
ALTER TABLE `edm_server_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `edm_task`
--
ALTER TABLE `edm_task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `edm_template`
--
ALTER TABLE `edm_template`
  ADD PRIMARY KEY (`template_id`),
  ADD KEY `INS_TEMPLATE_IS_ACTIVE` (`is_active`),
  ADD KEY `INS_TEMPLATE_IS_PUBLIC` (`is_public`),
  ADD KEY `INS_TEMPLATE_COMPANY_ID` (`company_id`);

--
-- Indexes for table `edm_templates`
--
ALTER TABLE `edm_templates`
  ADD PRIMARY KEY (`templateid`),
  ADD KEY `edm_templates_owner_idx` (`ownerid`);

--
-- Indexes for table `edm_templates_category`
--
ALTER TABLE `edm_templates_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `edm_templates_category_relate`
--
ALTER TABLE `edm_templates_category_relate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_INS_TEMPLATES_CATEGORY_RELATE` (`category_id`,`templateid`);

--
-- Indexes for table `edm_templates_layout`
--
ALTER TABLE `edm_templates_layout`
  ADD PRIMARY KEY (`layout_id`,`orig_layout`),
  ADD UNIQUE KEY `UNQ_INS_TEMPLATES_LAYOUT_NAME` (`name`),
  ADD KEY `IDX_INS_TEMPLATES_LAYOUT_ADDED_AT` (`date_create`),
  ADD KEY `IDX_INS_TEMPLATES_LAYOUT_MODIFIED_AT` (`date_update`);

--
-- Indexes for table `edm_templates_module`
--
ALTER TABLE `edm_templates_module`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `UNQ_INS_TEMPLATE_CATEGORY_MODULE_NAME_TEMPLATE` (`name`,`template`) USING BTREE;

--
-- Indexes for table `edm_templates_module_item`
--
ALTER TABLE `edm_templates_module_item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `edm_templates_module_item_attrvalue`
--
ALTER TABLE `edm_templates_module_item_attrvalue`
  ADD PRIMARY KEY (`value_id`),
  ADD KEY `IDX_INS_TEMPLSATES_MODULE_ITEM_ATTRVALUE_ATTR` (`attr_id`),
  ADD KEY `IDX_INS_TEMPLSATES_MODULE_ITEM_ATTRVALUE_ITEM` (`item_id`) USING BTREE;

--
-- Indexes for table `edm_templates_module_item_relate`
--
ALTER TABLE `edm_templates_module_item_relate`
  ADD PRIMARY KEY (`relate_id`);

--
-- Indexes for table `edm_templates_tag`
--
ALTER TABLE `edm_templates_tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `UNQ_INS_TEMPLATE_TAG_CODE` (`code`);

--
-- Indexes for table `edm_templates_variable`
--
ALTER TABLE `edm_templates_variable`
  ADD PRIMARY KEY (`variable_id`),
  ADD UNIQUE KEY `UNQ_INS_TEMPLATE_VARIABLE_NAME` (`name`);

--
-- Indexes for table `edm_template_category`
--
ALTER TABLE `edm_template_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `edm_template_category_relate`
--
ALTER TABLE `edm_template_category_relate`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_INS_TEMPLATE_CATEGORY_RELATE` (`category_id`,`template_id`);

--
-- Indexes for table `edm_template_tag`
--
ALTER TABLE `edm_template_tag`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `edm_template_tag_relate`
--
ALTER TABLE `edm_template_tag_relate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edm_urlprocess`
--
ALTER TABLE `edm_urlprocess`
  ADD PRIMARY KEY (`url_id`);

--
-- Indexes for table `edm_url_some`
--
ALTER TABLE `edm_url_some`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_url`
--
ALTER TABLE `log_url`
  ADD KEY `IDX_LOG_URL_VISITOR_ID` (`visitor_id`),
  ADD KEY `url_id` (`url_id`);

--
-- Indexes for table `log_url_info`
--
ALTER TABLE `log_url_info`
  ADD PRIMARY KEY (`url_id`);

--
-- Indexes for table `log_visitor`
--
ALTER TABLE `log_visitor`
  ADD PRIMARY KEY (`visitor_id`);

--
-- Indexes for table `log_visitor_info`
--
ALTER TABLE `log_visitor_info`
  ADD PRIMARY KEY (`visitor_id`);

--
-- Indexes for table `material_apply`
--
ALTER TABLE `material_apply`
  ADD PRIMARY KEY (`apply_id`);

--
-- Indexes for table `material_apply_audit`
--
ALTER TABLE `material_apply_audit`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `material_apply_material`
--
ALTER TABLE `material_apply_material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `material_category`
--
ALTER TABLE `material_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `material_material`
--
ALTER TABLE `material_material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `material_purchase`
--
ALTER TABLE `material_purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `material_purchase_file`
--
ALTER TABLE `material_purchase_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `material_purchase_material`
--
ALTER TABLE `material_purchase_material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `material_store`
--
ALTER TABLE `material_store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `material_store_item`
--
ALTER TABLE `material_store_item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `material_store_purchase`
--
ALTER TABLE `material_store_purchase`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `project_contract`
--
ALTER TABLE `project_contract`
  ADD PRIMARY KEY (`contract_id`);

--
-- Indexes for table `project_event`
--
ALTER TABLE `project_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `project_exp`
--
ALTER TABLE `project_exp`
  ADD PRIMARY KEY (`exp_id`);

--
-- Indexes for table `project_expend`
--
ALTER TABLE `project_expend`
  ADD PRIMARY KEY (`expend_id`);

--
-- Indexes for table `project_file`
--
ALTER TABLE `project_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `project_hour`
--
ALTER TABLE `project_hour`
  ADD PRIMARY KEY (`hour_id`);

--
-- Indexes for table `project_link`
--
ALTER TABLE `project_link`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `project_material`
--
ALTER TABLE `project_material`
  ADD PRIMARY KEY (`material_id`);

--
-- Indexes for table `project_meet`
--
ALTER TABLE `project_meet`
  ADD PRIMARY KEY (`meet_id`);

--
-- Indexes for table `project_milestone`
--
ALTER TABLE `project_milestone`
  ADD PRIMARY KEY (`milestone_id`);

--
-- Indexes for table `project_problem`
--
ALTER TABLE `project_problem`
  ADD PRIMARY KEY (`problem_id`);

--
-- Indexes for table `project_project`
--
ALTER TABLE `project_project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_quality_control`
--
ALTER TABLE `project_quality_control`
  ADD PRIMARY KEY (`control_id`);

--
-- Indexes for table `project_quality_guarantee`
--
ALTER TABLE `project_quality_guarantee`
  ADD PRIMARY KEY (`gua_id`);

--
-- Indexes for table `project_quality_standard`
--
ALTER TABLE `project_quality_standard`
  ADD PRIMARY KEY (`std_id`);

--
-- Indexes for table `project_report`
--
ALTER TABLE `project_report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `project_risk`
--
ALTER TABLE `project_risk`
  ADD PRIMARY KEY (`risk_id`);

--
-- Indexes for table `project_stage`
--
ALTER TABLE `project_stage`
  ADD PRIMARY KEY (`stage_id`);

--
-- Indexes for table `project_task`
--
ALTER TABLE `project_task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `report_file`
--
ALTER TABLE `report_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `report_link`
--
ALTER TABLE `report_link`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `report_link_reply`
--
ALTER TABLE `report_link_reply`
  ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `report_report`
--
ALTER TABLE `report_report`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `saas_admin_assert`
--
ALTER TABLE `saas_admin_assert`
  ADD PRIMARY KEY (`assert_id`);

--
-- Indexes for table `saas_admin_company`
--
ALTER TABLE `saas_admin_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `saas_admin_company.bak`
--
ALTER TABLE `saas_admin_company.bak`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `saas_admin_department`
--
ALTER TABLE `saas_admin_department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `saas_admin_role`
--
ALTER TABLE `saas_admin_role`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `IDX_INS_ADMIN_ROLE_PARENT_ID_SORT_ORDER` (`parent_id`,`sort_order`),
  ADD KEY `IDX_INS_ADMIN_ROLE_TREE_LEVEL` (`tree_level`);

--
-- Indexes for table `saas_admin_rule`
--
ALTER TABLE `saas_admin_rule`
  ADD PRIMARY KEY (`rule_id`),
  ADD KEY `IDX_INS_ADMIN_RULE_RESOURCE_ID_ROLE_ID` (`resource_id`,`role_id`),
  ADD KEY `IDX_INS_ADMIN_RULE_ROLE_ID_RESOURCE_ID` (`role_id`,`resource_id`);

--
-- Indexes for table `saas_admin_user`
--
ALTER TABLE `saas_admin_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UNQ_INS_ADMIN_USER_USERNAME` (`username`);

--
-- Indexes for table `task_project`
--
ALTER TABLE `task_project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `task_project_link`
--
ALTER TABLE `task_project_link`
  ADD PRIMARY KEY (`link_id`);

--
-- Indexes for table `task_task`
--
ALTER TABLE `task_task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `task_task_file`
--
ALTER TABLE `task_task_file`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `task_task_link`
--
ALTER TABLE `task_task_link`
  ADD PRIMARY KEY (`link_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_assert`
--
ALTER TABLE `admin_assert`
  MODIFY `assert_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Assert ID';
--
-- AUTO_INCREMENT for table `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Role ID', AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `admin_rule`
--
ALTER TABLE `admin_rule`
  MODIFY `rule_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Rule ID', AUTO_INCREMENT=331;
--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User ID', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `approve_apply`
--
ALTER TABLE `approve_apply`
  MODIFY `apply_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `approve_apply_audit`
--
ALTER TABLE `approve_apply_audit`
  MODIFY `audit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `approve_apply_link`
--
ALTER TABLE `approve_apply_link`
  MODIFY `link_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `approve_template`
--
ALTER TABLE `approve_template`
  MODIFY `template_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `approve_template_audit`
--
ALTER TABLE `approve_template_audit`
  MODIFY `audit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_attendance`
--
ALTER TABLE `attendance_attendance`
  MODIFY `attendance_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_fieldwork`
--
ALTER TABLE `attendance_fieldwork`
  MODIFY `fieldwork_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_leave`
--
ALTER TABLE `attendance_leave`
  MODIFY `leave_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_overtime`
--
ALTER TABLE `attendance_overtime`
  MODIFY `overtime_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `attendance_travel`
--
ALTER TABLE `attendance_travel`
  MODIFY `travel_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_file`
--
ALTER TABLE `bill_file`
  MODIFY `file_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_link`
--
ALTER TABLE `bill_link`
  MODIFY `link_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_loan`
--
ALTER TABLE `bill_loan`
  MODIFY `loan_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_loan_audit`
--
ALTER TABLE `bill_loan_audit`
  MODIFY `audit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_loan_bank`
--
ALTER TABLE `bill_loan_bank`
  MODIFY `bank_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_loan_item`
--
ALTER TABLE `bill_loan_item`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_reimburse`
--
ALTER TABLE `bill_reimburse`
  MODIFY `reimburse_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_reimburse_audit`
--
ALTER TABLE `bill_reimburse_audit`
  MODIFY `audit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_reimburse_bank`
--
ALTER TABLE `bill_reimburse_bank`
  MODIFY `bank_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_reimburse_item`
--
ALTER TABLE `bill_reimburse_item`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_revenue`
--
ALTER TABLE `bill_revenue`
  MODIFY `revenue_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_revenue_item`
--
ALTER TABLE `bill_revenue_item`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_setting_project`
--
ALTER TABLE `bill_setting_project`
  MODIFY `project_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bill_setting_type`
--
ALTER TABLE `bill_setting_type`
  MODIFY `type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bulletin_msg`
--
ALTER TABLE `bulletin_msg`
  MODIFY `msg_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bulletin_msg_audit`
--
ALTER TABLE `bulletin_msg_audit`
  MODIFY `audit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bulletin_msg_file`
--
ALTER TABLE `bulletin_msg_file`
  MODIFY `file_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bulletin_msg_visible`
--
ALTER TABLE `bulletin_msg_visible`
  MODIFY `visible_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bulletin_setting_type`
--
ALTER TABLE `bulletin_setting_type`
  MODIFY `type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cms_block`
--
ALTER TABLE `cms_block`
  MODIFY `block_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'Block ID';
--
-- AUTO_INCREMENT for table `cms_page`
--
ALTER TABLE `cms_page`
  MODIFY `page_id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'Page ID', AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `core_config_data`
--
ALTER TABLE `core_config_data`
  MODIFY `config_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Config Id', AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `core_email_template`
--
ALTER TABLE `core_email_template`
  MODIFY `template_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Template Id';
--
-- AUTO_INCREMENT for table `core_layout_link`
--
ALTER TABLE `core_layout_link`
  MODIFY `layout_link_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Link Id';
--
-- AUTO_INCREMENT for table `core_layout_update`
--
ALTER TABLE `core_layout_update`
  MODIFY `layout_update_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Layout Update Id';
--
-- AUTO_INCREMENT for table `core_url_rewrite`
--
ALTER TABLE `core_url_rewrite`
  MODIFY `url_rewrite_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Rewrite Id';
--
-- AUTO_INCREMENT for table `core_variable`
--
ALTER TABLE `core_variable`
  MODIFY `variable_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Variable Id';
--
-- AUTO_INCREMENT for table `core_variable_value`
--
ALTER TABLE `core_variable_value`
  MODIFY `value_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Variable Value Id';
--
-- AUTO_INCREMENT for table `crm_activity`
--
ALTER TABLE `crm_activity`
  MODIFY `activity_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crm_chance`
--
ALTER TABLE `crm_chance`
  MODIFY `chance_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crm_client`
--
ALTER TABLE `crm_client`
  MODIFY `client_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crm_clue`
--
ALTER TABLE `crm_clue`
  MODIFY `clue_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crm_competitor`
--
ALTER TABLE `crm_competitor`
  MODIFY `comp_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crm_contact`
--
ALTER TABLE `crm_contact`
  MODIFY `contact_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crm_order`
--
ALTER TABLE `crm_order`
  MODIFY `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_aff`
--
ALTER TABLE `edm_aff`
  MODIFY `aff_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `edm_article`
--
ALTER TABLE `edm_article`
  MODIFY `article_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31851;
--
-- AUTO_INCREMENT for table `edm_article_category`
--
ALTER TABLE `edm_article_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `edm_article_wx`
--
ALTER TABLE `edm_article_wx`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=587;
--
-- AUTO_INCREMENT for table `edm_cert`
--
ALTER TABLE `edm_cert`
  MODIFY `cert_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';
--
-- AUTO_INCREMENT for table `edm_client`
--
ALTER TABLE `edm_client`
  MODIFY `client_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `edm_client_attr`
--
ALTER TABLE `edm_client_attr`
  MODIFY `attr_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `edm_client_attr_option`
--
ALTER TABLE `edm_client_attr_option`
  MODIFY `option_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `edm_client_attr_value`
--
ALTER TABLE `edm_client_attr_value`
  MODIFY `value_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `edm_client_attr_value_copy`
--
ALTER TABLE `edm_client_attr_value_copy`
  MODIFY `value_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_client_category`
--
ALTER TABLE `edm_client_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_client_email`
--
ALTER TABLE `edm_client_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `edm_client_email_attr`
--
ALTER TABLE `edm_client_email_attr`
  MODIFY `attr_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `edm_client_email_attr_option`
--
ALTER TABLE `edm_client_email_attr_option`
  MODIFY `option_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_client_email_attr_value`
--
ALTER TABLE `edm_client_email_attr_value`
  MODIFY `value_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `edm_client_rule`
--
ALTER TABLE `edm_client_rule`
  MODIFY `rule_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `edm_client_rule_pagetype`
--
ALTER TABLE `edm_client_rule_pagetype`
  MODIFY `type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `edm_client_rule_variable`
--
ALTER TABLE `edm_client_rule_variable`
  MODIFY `variable_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Variable Id', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `edm_client_temp`
--
ALTER TABLE `edm_client_temp`
  MODIFY `client_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_client_text_rule`
--
ALTER TABLE `edm_client_text_rule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_client_text_tmp`
--
ALTER TABLE `edm_client_text_tmp`
  MODIFY `text_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_advantage`
--
ALTER TABLE `edm_company_advantage`
  MODIFY `advantage_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `edm_company_advantage_attrvalue`
--
ALTER TABLE `edm_company_advantage_attrvalue`
  MODIFY `value_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `edm_company_advantage_image`
--
ALTER TABLE `edm_company_advantage_image`
  MODIFY `image_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_advantage_option`
--
ALTER TABLE `edm_company_advantage_option`
  MODIFY `option_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `edm_company_advantage_value`
--
ALTER TABLE `edm_company_advantage_value`
  MODIFY `value_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=434;
--
-- AUTO_INCREMENT for table `edm_company_attr`
--
ALTER TABLE `edm_company_attr`
  MODIFY `attr_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `edm_company_attr_value`
--
ALTER TABLE `edm_company_attr_value`
  MODIFY `value_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `edm_company_category`
--
ALTER TABLE `edm_company_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;
--
-- AUTO_INCREMENT for table `edm_company_cert`
--
ALTER TABLE `edm_company_cert`
  MODIFY `cert_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_client`
--
ALTER TABLE `edm_company_client`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_client_category`
--
ALTER TABLE `edm_company_client_category`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_client_category_relate`
--
ALTER TABLE `edm_company_client_category_relate`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_client_email`
--
ALTER TABLE `edm_company_client_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_draft`
--
ALTER TABLE `edm_company_draft`
  MODIFY `draft_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `edm_company_email`
--
ALTER TABLE `edm_company_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_email_send`
--
ALTER TABLE `edm_company_email_send`
  MODIFY `send_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `edm_company_group`
--
ALTER TABLE `edm_company_group`
  MODIFY `group_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_keyword`
--
ALTER TABLE `edm_company_keyword`
  MODIFY `keyword_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;
--
-- AUTO_INCREMENT for table `edm_company_keyword_url`
--
ALTER TABLE `edm_company_keyword_url`
  MODIFY `url_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `edm_company_media`
--
ALTER TABLE `edm_company_media`
  MODIFY `media_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_media_category`
--
ALTER TABLE `edm_company_media_category`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_media_category_relate`
--
ALTER TABLE `edm_company_media_category_relate`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_template`
--
ALTER TABLE `edm_company_template`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `edm_company_template_draft`
--
ALTER TABLE `edm_company_template_draft`
  MODIFY `draft_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_template_module`
--
ALTER TABLE `edm_company_template_module`
  MODIFY `module_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `edm_company_template_module_item`
--
ALTER TABLE `edm_company_template_module_item`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=209;
--
-- AUTO_INCREMENT for table `edm_company_template_module_item_attrvalue`
--
ALTER TABLE `edm_company_template_module_item_attrvalue`
  MODIFY `value_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_company_template_module_item_relate`
--
ALTER TABLE `edm_company_template_module_item_relate`
  MODIFY `relate_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_email_validate`
--
ALTER TABLE `edm_email_validate`
  MODIFY `validate_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_email_white`
--
ALTER TABLE `edm_email_white`
  MODIFY `white_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_esp`
--
ALTER TABLE `edm_esp`
  MODIFY `esp_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `edm_feedback`
--
ALTER TABLE `edm_feedback`
  MODIFY `feedback_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `edm_product`
--
ALTER TABLE `edm_product`
  MODIFY `product_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `edm_product_category`
--
ALTER TABLE `edm_product_category`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1032;
--
-- AUTO_INCREMENT for table `edm_product_category_relate`
--
ALTER TABLE `edm_product_category_relate`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_product_link`
--
ALTER TABLE `edm_product_link`
  MODIFY `link_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Link ID';
--
-- AUTO_INCREMENT for table `edm_product_link_type`
--
ALTER TABLE `edm_product_link_type`
  MODIFY `link_type_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Link Type ID', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `edm_send_log`
--
ALTER TABLE `edm_send_log`
  MODIFY `log_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_server`
--
ALTER TABLE `edm_server`
  MODIFY `server_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `edm_server_log`
--
ALTER TABLE `edm_server_log`
  MODIFY `log_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `edm_task`
--
ALTER TABLE `edm_task`
  MODIFY `task_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `edm_template`
--
ALTER TABLE `edm_template`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `edm_templates`
--
ALTER TABLE `edm_templates`
  MODIFY `templateid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `edm_templates_category`
--
ALTER TABLE `edm_templates_category`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `edm_templates_category_relate`
--
ALTER TABLE `edm_templates_category_relate`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `edm_templates_layout`
--
ALTER TABLE `edm_templates_layout`
  MODIFY `layout_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `edm_templates_module`
--
ALTER TABLE `edm_templates_module`
  MODIFY `module_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `edm_templates_module_item`
--
ALTER TABLE `edm_templates_module_item`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Id', AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `edm_templates_module_item_attrvalue`
--
ALTER TABLE `edm_templates_module_item_attrvalue`
  MODIFY `value_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;
--
-- AUTO_INCREMENT for table `edm_templates_module_item_relate`
--
ALTER TABLE `edm_templates_module_item_relate`
  MODIFY `relate_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1028;
--
-- AUTO_INCREMENT for table `edm_templates_tag`
--
ALTER TABLE `edm_templates_tag`
  MODIFY `tag_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Tag Id', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `edm_templates_variable`
--
ALTER TABLE `edm_templates_variable`
  MODIFY `variable_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Variable Id', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `edm_template_category`
--
ALTER TABLE `edm_template_category`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_template_category_relate`
--
ALTER TABLE `edm_template_category_relate`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_template_tag`
--
ALTER TABLE `edm_template_tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_template_tag_relate`
--
ALTER TABLE `edm_template_tag_relate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `edm_urlprocess`
--
ALTER TABLE `edm_urlprocess`
  MODIFY `url_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `edm_url_some`
--
ALTER TABLE `edm_url_some`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `log_url_info`
--
ALTER TABLE `log_url_info`
  MODIFY `url_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'URL ID';
--
-- AUTO_INCREMENT for table `log_visitor`
--
ALTER TABLE `log_visitor`
  MODIFY `visitor_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Visitor ID';
--
-- AUTO_INCREMENT for table `material_apply`
--
ALTER TABLE `material_apply`
  MODIFY `apply_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `material_apply_audit`
--
ALTER TABLE `material_apply_audit`
  MODIFY `audit_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `material_apply_material`
--
ALTER TABLE `material_apply_material`
  MODIFY `material_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `material_category`
--
ALTER TABLE `material_category`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `material_material`
--
ALTER TABLE `material_material`
  MODIFY `material_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `material_purchase`
--
ALTER TABLE `material_purchase`
  MODIFY `purchase_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `material_purchase_file`
--
ALTER TABLE `material_purchase_file`
  MODIFY `file_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `material_purchase_material`
--
ALTER TABLE `material_purchase_material`
  MODIFY `material_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `material_store_item`
--
ALTER TABLE `material_store_item`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `material_store_purchase`
--
ALTER TABLE `material_store_purchase`
  MODIFY `link_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_contract`
--
ALTER TABLE `project_contract`
  MODIFY `contract_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_event`
--
ALTER TABLE `project_event`
  MODIFY `event_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_exp`
--
ALTER TABLE `project_exp`
  MODIFY `exp_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_expend`
--
ALTER TABLE `project_expend`
  MODIFY `expend_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_file`
--
ALTER TABLE `project_file`
  MODIFY `file_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_hour`
--
ALTER TABLE `project_hour`
  MODIFY `hour_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_link`
--
ALTER TABLE `project_link`
  MODIFY `link_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_material`
--
ALTER TABLE `project_material`
  MODIFY `material_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_meet`
--
ALTER TABLE `project_meet`
  MODIFY `meet_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_milestone`
--
ALTER TABLE `project_milestone`
  MODIFY `milestone_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_problem`
--
ALTER TABLE `project_problem`
  MODIFY `problem_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_project`
--
ALTER TABLE `project_project`
  MODIFY `project_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_quality_control`
--
ALTER TABLE `project_quality_control`
  MODIFY `control_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_quality_guarantee`
--
ALTER TABLE `project_quality_guarantee`
  MODIFY `gua_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_quality_standard`
--
ALTER TABLE `project_quality_standard`
  MODIFY `std_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_report`
--
ALTER TABLE `project_report`
  MODIFY `report_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_risk`
--
ALTER TABLE `project_risk`
  MODIFY `risk_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_stage`
--
ALTER TABLE `project_stage`
  MODIFY `stage_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_task`
--
ALTER TABLE `project_task`
  MODIFY `task_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report_file`
--
ALTER TABLE `report_file`
  MODIFY `file_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report_link`
--
ALTER TABLE `report_link`
  MODIFY `link_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report_link_reply`
--
ALTER TABLE `report_link_reply`
  MODIFY `reply_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report_report`
--
ALTER TABLE `report_report`
  MODIFY `report_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `saas_admin_assert`
--
ALTER TABLE `saas_admin_assert`
  MODIFY `assert_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Assert ID';
--
-- AUTO_INCREMENT for table `saas_admin_company`
--
ALTER TABLE `saas_admin_company`
  MODIFY `company_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `saas_admin_company.bak`
--
ALTER TABLE `saas_admin_company.bak`
  MODIFY `company_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `saas_admin_department`
--
ALTER TABLE `saas_admin_department`
  MODIFY `department_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `saas_admin_role`
--
ALTER TABLE `saas_admin_role`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Role ID', AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `saas_admin_rule`
--
ALTER TABLE `saas_admin_rule`
  MODIFY `rule_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Rule ID', AUTO_INCREMENT=331;
--
-- AUTO_INCREMENT for table `saas_admin_user`
--
ALTER TABLE `saas_admin_user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'User ID', AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `task_project`
--
ALTER TABLE `task_project`
  MODIFY `project_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `task_project_link`
--
ALTER TABLE `task_project_link`
  MODIFY `link_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `task_task`
--
ALTER TABLE `task_task`
  MODIFY `task_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `task_task_file`
--
ALTER TABLE `task_task_file`
  MODIFY `file_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `task_task_link`
--
ALTER TABLE `task_task_link`
  MODIFY `link_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- 限制导出的表
--

--
-- 限制表 `admin_rule`
--
ALTER TABLE `admin_rule`
  ADD CONSTRAINT `FK_ADMIN_RULE_ROLE_ID_ADMIN_ROLE_ROLE_ID` FOREIGN KEY (`role_id`) REFERENCES `admin_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `core_layout_link`
--
ALTER TABLE `core_layout_link`
  ADD CONSTRAINT `FK_CORE_LYT_LNK_LYT_UPDATE_ID_CORE_LYT_UPDATE_LYT_UPDATE_ID` FOREIGN KEY (`layout_update_id`) REFERENCES `core_layout_update` (`layout_update_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `core_variable_value`
--
ALTER TABLE `core_variable_value`
  ADD CONSTRAINT `FK_CORE_VARIABLE_VALUE_VARIABLE_ID_CORE_VARIABLE_VARIABLE_ID` FOREIGN KEY (`variable_id`) REFERENCES `core_variable` (`variable_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `edm_product_link`
--
ALTER TABLE `edm_product_link`
  ADD CONSTRAINT `FK_INS_PRD_LNK_CMP_ID_CMP_CMP_ID` FOREIGN KEY (`company_id`) REFERENCES `saas_admin_company.bak` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_INS_PRD_LNK_LNK_TYPE_ID_INA_PRD_LNK_TYPE_LNK_TYPE_ID` FOREIGN KEY (`link_type_id`) REFERENCES `edm_product_link_type` (`link_type_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_INS_PRD_LNK_PRD_ID_CAT_PRD_ENTT_ENTT_ID` FOREIGN KEY (`product_id`) REFERENCES `edm_product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `saas_admin_rule`
--
ALTER TABLE `saas_admin_rule`
  ADD CONSTRAINT `FK_INS_ADMIN_RULE_ROLE_ID_ADMIN_ROLE_ROLE_ID` FOREIGN KEY (`role_id`) REFERENCES `saas_admin_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
