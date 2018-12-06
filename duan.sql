-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 15, 2018 lúc 05:23 PM
-- Phiên bản máy phục vụ: 10.1.25-MariaDB
-- Phiên bản PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `duan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_user`
--

CREATE TABLE `admin_user` (
  `adm_id` int(11) NOT NULL,
  `adm_loginname` varchar(100) DEFAULT NULL,
  `adm_password` varchar(100) DEFAULT NULL,
  `adm_name` varchar(255) DEFAULT NULL,
  `adm_email` varchar(255) DEFAULT NULL,
  `adm_address` varchar(255) DEFAULT NULL,
  `adm_phone` varchar(255) DEFAULT NULL,
  `adm_mobile` varchar(255) DEFAULT NULL,
  `adm_access_module` varchar(255) DEFAULT NULL,
  `adm_access_category` text,
  `adm_date` int(11) DEFAULT '0',
  `adm_isadmin` tinyint(1) DEFAULT '0',
  `adm_active` tinyint(1) DEFAULT '1',
  `lang_id` tinyint(1) DEFAULT '1',
  `adm_delete` int(11) DEFAULT '0',
  `adm_all_category` int(1) DEFAULT NULL,
  `adm_edit_all` int(1) DEFAULT '0',
  `admin_id` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Đang đổ dữ liệu cho bảng `admin_user`
--

INSERT INTO `admin_user` (`adm_id`, `adm_loginname`, `adm_password`, `adm_name`, `adm_email`, `adm_address`, `adm_phone`, `adm_mobile`, `adm_access_module`, `adm_access_category`, `adm_date`, `adm_isadmin`, `adm_active`, `lang_id`, `adm_delete`, `adm_all_category`, `adm_edit_all`, `admin_id`) VALUES
(1, 'admin', 'c4ca4238a0b923820dcc509a6f75849b', 'Bùi văn chiến', 'lienhe.1viec@gmail.com', '210A Lê Trọng Tấn - HN', '0989197453', '', NULL, NULL, 0, 1, 1, 1, 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_user_right`
--

CREATE TABLE `admin_user_right` (
  `adu_admin_id` int(11) NOT NULL,
  `adu_admin_module_id` int(11) NOT NULL DEFAULT '0',
  `adu_add` int(1) DEFAULT '0',
  `adu_edit` int(1) DEFAULT '0',
  `adu_delete` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `admin_user_right`
--

INSERT INTO `admin_user_right` (`adu_admin_id`, `adu_admin_module_id`, `adu_add`, `adu_edit`, `adu_delete`) VALUES
(14, 4, 1, 1, 1),
(5, 12, 1, 1, 0),
(6, 1, 1, 1, 1),
(6, 4, 0, 0, 0),
(7, 5, 1, 1, 0),
(7, 4, 1, 0, 0),
(8, 6, 1, 1, 1),
(8, 11, 1, 1, 1),
(8, 13, 1, 1, 1),
(8, 1, 1, 1, 0),
(9, 14, 1, 1, 1),
(9, 13, 1, 1, 1),
(9, 12, 1, 1, 1),
(9, 7, 1, 1, 1),
(10, 14, 1, 1, 1),
(11, 14, 1, 1, 1),
(11, 13, 1, 1, 1),
(12, 14, 1, 1, 1),
(12, 6, 1, 1, 1),
(11, 11, 1, 1, 1),
(11, 6, 1, 1, 1),
(13, 14, 1, 1, 1),
(13, 6, 1, 1, 1),
(13, 4, 1, 1, 1),
(13, 1, 1, 1, 1),
(10, 6, 1, 1, 1),
(10, 5, 1, 1, 1),
(10, 4, 1, 1, 1),
(10, 1, 1, 1, 1),
(9, 11, 1, 1, 1),
(11, 5, 1, 1, 1),
(9, 6, 1, 1, 1),
(14, 14, 1, 1, 1),
(14, 6, 1, 1, 1),
(14, 5, 1, 1, 1),
(15, 14, 1, 1, 1),
(15, 6, 1, 1, 1),
(15, 5, 1, 1, 1),
(15, 1, 1, 1, 0),
(11, 1, 1, 1, 1),
(16, 14, 1, 1, 1),
(16, 6, 1, 1, 1),
(16, 5, 1, 1, 1),
(16, 4, 1, 1, 1),
(16, 1, 1, 1, 1),
(9, 5, 1, 1, 1),
(17, 4, 1, 1, 1),
(17, 1, 1, 1, 1),
(17, 24, 1, 1, 1),
(17, 25, 1, 1, 1),
(17, 26, 1, 1, 1),
(17, 27, 1, 1, 1),
(17, 6, 1, 1, 1),
(17, 5, 1, 1, 1),
(17, 11, 1, 1, 1),
(17, 13, 1, 1, 1),
(17, 14, 1, 1, 1),
(18, 14, 1, 1, 1),
(18, 6, 1, 1, 1),
(18, 4, 1, 1, 1),
(18, 27, 1, 1, 1),
(9, 4, 1, 1, 1),
(9, 1, 1, 1, 1),
(9, 24, 1, 1, 1),
(9, 25, 1, 1, 1),
(9, 26, 1, 1, 1),
(9, 27, 1, 1, 1),
(14, 1, 1, 0, 1),
(19, 26, 1, 1, 1),
(19, 25, 1, 1, 1),
(19, 24, 1, 1, 1),
(19, 4, 1, 1, 1),
(19, 5, 1, 1, 1),
(19, 1, 1, 1, 1),
(19, 6, 1, 1, 1),
(19, 11, 1, 1, 1),
(20, 6, 1, 1, 1),
(20, 27, 1, 1, 1),
(19, 27, 1, 1, 1),
(19, 7, 1, 1, 1),
(19, 12, 1, 1, 1),
(19, 13, 1, 1, 1),
(19, 14, 1, 1, 1),
(20, 14, 1, 1, 1),
(21, 6, 1, 1, 0),
(21, 4, 1, 1, 0),
(17, 28, 1, 1, 1),
(21, 27, 1, 1, 1),
(19, 28, 1, 1, 1),
(20, 28, 1, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) DEFAULT NULL,
  `cat_no_accent` varchar(255) DEFAULT NULL,
  `cat_parent_id` int(11) DEFAULT '0',
  `cat_child_id` varchar(255) DEFAULT NULL,
  `cat_type` varchar(20) DEFAULT NULL,
  `cat_hot` int(11) DEFAULT '0',
  `cat_order` int(11) DEFAULT '0',
  `cat_active` int(11) DEFAULT '1',
  `cat_title` varchar(255) DEFAULT NULL,
  `cat_keyword` varchar(255) DEFAULT NULL,
  `cat_description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_no_accent`, `cat_parent_id`, `cat_child_id`, `cat_type`, `cat_hot`, `cat_order`, `cat_active`, `cat_title`, `cat_keyword`, `cat_description`) VALUES
(2, 'Dự án', 'du an', 0, '3,4,5,6\r\n', 'products', 0, 0, 1, 'Tổng hợp các dự án chung cư, Biệt thự, Đất nền, Nhà ở xã hội', NULL, NULL),
(3, 'Nhà chung cư', 'nha chung cu', 2, '3', 'products', 0, 0, 1, 'Danh sách hơn 300 dự án căn hộ chung cư cao cấp, thấp cấp', NULL, NULL),
(4, 'Nhà ở xã hội', 'nha o xa hoi', 2, '4', 'products', 0, 0, 1, 'Nhà ở xã hội kênh thông tin về các dự án nhà ở xã hội', NULL, NULL),
(5, 'Biệt thự liền kề', 'biet thu lien ke', 2, '5', 'products', 0, 0, 1, 'Săn biệt thự liền kề mới nhất', NULL, NULL),
(6, 'Đất nền', 'dat nen', 2, '6', 'products', 0, 0, 1, NULL, NULL, NULL),
(7, 'Kinh nghiệm mua nhà', 'kinh nghiem mua nha', 0, '7', 'news', 0, 0, 1, 'Những kinh nhiệm sương máu khi đi mua nhà', NULL, 'Trao đổi kinh nghiệm mua nhà'),
(8, 'Phong thủy', 'phong thuy', 0, '8', 'news', 0, 0, 1, 'Phong thủy nhà ở, xem hướng, mệnh', NULL, 'new_pro_id');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `city`
--

CREATE TABLE `city` (
  `cit_id` int(11) NOT NULL,
  `cit_name` varchar(255) DEFAULT NULL,
  `cit_alias` varchar(50) DEFAULT NULL,
  `cit_no_accent` varchar(255) DEFAULT NULL,
  `cit_parent_id` int(11) DEFAULT '0',
  `cit_child` varchar(255) DEFAULT NULL,
  `cit_title` varchar(255) DEFAULT NULL,
  `cit_keyword` varchar(255) DEFAULT NULL,
  `cit_description` varchar(255) DEFAULT NULL,
  `cit_hot` int(11) DEFAULT '0',
  `cit_order` int(11) DEFAULT '0',
  `cit_active` int(11) DEFAULT '1',
  `cit_important` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `city`
--

INSERT INTO `city` (`cit_id`, `cit_name`, `cit_alias`, `cit_no_accent`, `cit_parent_id`, `cit_child`, `cit_title`, `cit_keyword`, `cit_description`, `cit_hot`, `cit_order`, `cit_active`, `cit_important`) VALUES
(1, 'Hồ Chí Minh', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(2, 'Hà Nội', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(3, 'Đà Nẵng', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(4, 'Bình Dương', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(5, 'Đồng Nai', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(6, 'Khánh Hòa', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(7, 'Hải Phòng', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(8, 'Long An', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(9, 'Quảng Nam', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(10, 'Bà Rịa Vũng Tàu', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(11, 'Đắk Lắk', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(12, 'Cần Thơ', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(13, 'Bình Thuận  ', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(14, 'Lâm Đồng', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(15, 'Thừa Thiên Huế', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(16, 'Kiên Giang', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(17, 'Bắc Ninh', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(18, 'Quảng Ninh', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(19, 'Thanh Hóa', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(20, 'Nghệ An', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(21, 'Hải Dương', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(22, 'Gia Lai', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(23, 'Bình Phước', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(24, 'Hưng Yên', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(25, 'Bình Định', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(26, 'Tiền Giang', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(27, 'Thái Bình', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(28, 'Bắc Giang', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(29, 'Hòa Bình', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(30, 'An Giang', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(31, 'Vĩnh Phúc', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(32, 'Tây Ninh', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(33, 'Thái Nguyên', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(34, 'Lào Cai', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(35, 'Nam Định', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(36, 'Quảng Ngãi', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(37, 'Bến Tre', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(38, 'Đắk Nông', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(39, 'Cà Mau', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(40, 'Vĩnh Long', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(41, 'Ninh Bình', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(42, 'Phú Thọ', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(43, 'Ninh Thuận', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(44, 'Phú Yên', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(45, 'Hà Nam', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(46, 'Hà Tĩnh', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(47, 'Đồng Tháp', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(48, 'Sóc Trăng', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(49, 'Kon Tum', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(50, 'Quảng Bình', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(51, 'Quảng Trị', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(52, 'Trà Vinh', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(53, 'Hậu Giang', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(54, 'Sơn La', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(55, 'Bạc Liêu', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(56, 'Yên Bái', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(57, 'Tuyên Quang', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(58, 'Điện Biên', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(59, 'Lai Châu', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(60, 'Lạng Sơn', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(61, 'Hà Giang', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(62, 'Bắc Kạn', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(63, 'Cao Bằng', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(64, 'Hoàn Kiếm', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(65, 'Ba Đình', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(66, 'Đống Đa', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(67, 'Hai Bà Trưng', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(68, 'Thanh Xuân', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(69, 'Tây Hồ', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(70, 'Cầu Giấy', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(71, 'Hoàng Mai', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(72, 'Long Biên', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(73, 'Đông Anh', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(74, 'Gia Lâm', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(75, 'Sóc Sơn', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(76, 'Thanh Trì', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(77, 'Nam Từ Liêm', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(78, 'Bắc Từ Liêm', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(79, 'Hà Đông', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(80, 'Sơn Tây', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(81, 'Mê Linh', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(82, 'Ba Vì', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(83, 'Phúc Thọ', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(84, 'Đan Phượng', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(85, 'Hoài Đức', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(86, 'Quốc Oai', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(87, 'Thạch Thất', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(88, 'Chương Mỹ', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(89, 'Thanh Oai', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(90, 'Thường Tín', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(91, 'Phú Xuyên', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(92, 'Ứng Hòa', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(93, 'Mỹ Đức', NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(94, 'Quận 1', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(95, 'Quận 2', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(96, 'Quận 3', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(97, 'Quận 4', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(98, 'Quận 5', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(99, 'Quận 6', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(100, 'Quận 7', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(101, 'Quận 8', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(102, 'Quận 9', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(103, 'Quận 10', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(104, 'Quận 11', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(105, 'Quận 12', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(106, 'Bình Tân', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(107, 'Bình Thạnh', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(108, 'Gò Vấp', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(109, 'Phú Nhuận', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(110, 'Tân Bình', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(111, 'Tân Phú', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(112, 'Thủ Đức', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(113, 'Bình Chánh', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(114, 'Cần Giờ', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(115, 'Củ Chi', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(116, 'Hóc Môn', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0),
(117, 'Nhà Bè', NULL, NULL, 1, NULL, NULL, NULL, NULL, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `configuration`
--

CREATE TABLE `configuration` (
  `con_id` int(11) NOT NULL,
  `con_admin_email` varchar(255) DEFAULT NULL,
  `con_site_title` varchar(255) DEFAULT NULL,
  `con_meta_description` text,
  `con_meta_keywords` text,
  `con_currency` varchar(20) DEFAULT NULL,
  `con_exchange` double DEFAULT '0',
  `con_lang_id` int(11) DEFAULT '1',
  `con_extenstion` varchar(20) DEFAULT 'html',
  `con_support_online` text,
  `lang_id` int(11) DEFAULT '1',
  `con_min_product` int(11) DEFAULT '0',
  `con_time_edit_stocks` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `constructions`
--

CREATE TABLE `constructions` (
  `con_id` int(11) NOT NULL,
  `con_name` varchar(255) DEFAULT NULL,
  `con_no_accent` varchar(255) DEFAULT NULL,
  `con_full_address` varchar(255) DEFAULT NULL,
  `con_home_phone` varchar(255) DEFAULT NULL,
  `con_hot_line` varchar(255) DEFAULT NULL,
  `con_email` varchar(255) DEFAULT NULL,
  `con_website` varchar(255) DEFAULT NULL,
  `con_introduction` text,
  `con_active` int(11) DEFAULT '1',
  `con_title` varchar(255) DEFAULT NULL,
  `con_keyword` varchar(255) DEFAULT NULL,
  `con_description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact`
--

CREATE TABLE `contact` (
  `con_id` int(11) NOT NULL,
  `con_name` varchar(255) DEFAULT NULL,
  `con_phone` varchar(50) DEFAULT NULL,
  `con_email` varchar(200) DEFAULT NULL,
  `con_pro_id` int(11) DEFAULT '0',
  `con_date` int(11) DEFAULT '0',
  `con_status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `designs`
--

CREATE TABLE `designs` (
  `des_id` int(11) NOT NULL,
  `des_name` varchar(255) DEFAULT NULL,
  `des_no_accent` varchar(255) DEFAULT NULL,
  `des_full_address` varchar(255) DEFAULT NULL,
  `des_home_phone` varchar(255) DEFAULT NULL,
  `des_hot_line` varchar(255) DEFAULT NULL,
  `des_email` varchar(255) DEFAULT NULL,
  `des_website` varchar(255) DEFAULT NULL,
  `des_introduction` text,
  `des_active` int(11) DEFAULT '1',
  `des_title` varchar(255) DEFAULT NULL,
  `des_keyword` varchar(255) DEFAULT NULL,
  `des_description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `investors`
--

CREATE TABLE `investors` (
  `inv_id` int(11) NOT NULL,
  `inv_name` varchar(255) DEFAULT NULL,
  `inv_no_accent` varchar(255) DEFAULT NULL,
  `inv_full_address` varchar(255) DEFAULT NULL,
  `inv_home_phone` varchar(255) DEFAULT NULL,
  `inv_hot_line` varchar(255) DEFAULT NULL,
  `inv_email` varchar(255) DEFAULT NULL,
  `inv_website` varchar(255) DEFAULT NULL,
  `inv_introduction` text,
  `inv_active` int(11) DEFAULT '1',
  `inv_title` varchar(255) DEFAULT NULL,
  `inv_keyword` varchar(255) DEFAULT NULL,
  `inv_description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `modules`
--

CREATE TABLE `modules` (
  `mod_id` int(11) NOT NULL,
  `mod_name` varchar(255) DEFAULT NULL,
  `mod_path` varchar(255) DEFAULT NULL,
  `mod_listname` varchar(255) DEFAULT NULL,
  `mod_listfile` varchar(255) DEFAULT NULL,
  `mod_order` int(11) DEFAULT '0',
  `mod_help` mediumtext,
  `lang_id` int(11) DEFAULT '1',
  `mod_checkloca` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `modules`
--

INSERT INTO `modules` (`mod_id`, `mod_name`, `mod_path`, `mod_listname`, `mod_listfile`, `mod_order`, `mod_help`, `lang_id`, `mod_checkloca`) VALUES
(104, 'Investor', 'investor', 'Add|Listing', 'add.php|listing.php', 0, NULL, 1, 0),
(105, 'Designer', 'design', 'Add|Listing', 'add.php|listing.php', 0, NULL, 1, 0),
(106, 'Constructions', 'construction', 'Add|Listing', 'add.php|listing.php', 0, NULL, 1, 0),
(107, 'Projects step', 'products_step', 'Add|Listing', 'add.php|listing.php', 0, NULL, 1, 0),
(7, 'Permission', 'admin_user', 'Add permission', 'add.php', 6, NULL, 1, 0),
(36, 'News', 'news', 'Add|Listing', 'add.php|listing.php', 0, NULL, 1, 0),
(103, 'Projects', 'products', 'Add products|Listing products', 'add.php|listing.php', 0, NULL, 1, 0),
(57, 'Category', 'category', 'Add category|Listing category', 'add.php|listing.php', 0, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `new_id` int(11) NOT NULL,
  `new_name` varchar(255) DEFAULT NULL,
  `new_title` varchar(255) DEFAULT NULL,
  `new_description` varchar(255) DEFAULT NULL,
  `new_cat_id` int(11) DEFAULT '0',
  `new_pro_id` int(11) DEFAULT '0',
  `new_image` varchar(255) DEFAULT NULL,
  `new_date` int(11) DEFAULT '0',
  `new_active` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news_content`
--

CREATE TABLE `news_content` (
  `nec_id` int(11) NOT NULL,
  `nec_content` text,
  `nec_source` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(255) DEFAULT NULL,
  `pro_name_accent` varchar(255) DEFAULT NULL,
  `pro_image` varchar(255) DEFAULT NULL,
  `pro_address` varchar(255) DEFAULT NULL,
  `pro_title` varchar(255) DEFAULT NULL,
  `pro_description` varchar(255) DEFAULT NULL,
  `pro_start_time` varchar(50) DEFAULT NULL,
  `pro_end_time` varchar(50) DEFAULT NULL,
  `pro_price_from` float DEFAULT NULL,
  `pro_price_to` float DEFAULT '0',
  `pro_cat_id` int(11) DEFAULT '0',
  `pro_cit_id` int(11) DEFAULT '0',
  `pro_district_id` int(11) DEFAULT '0',
  `pro_invertor_id` int(11) DEFAULT '0',
  `pro_design_id` int(11) DEFAULT '0',
  `pro_construction_id` int(11) DEFAULT '0',
  `pro_hot` int(11) DEFAULT '0',
  `pro_active` int(11) DEFAULT '0',
  `pro_floor` int(11) DEFAULT '0',
  `pro_room` int(11) DEFAULT '0',
  `pro_teaser` varchar(255) DEFAULT NULL,
  `pro_contact` varchar(255) DEFAULT NULL,
  `pro_status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `pro_name_accent`, `pro_image`, `pro_address`, `pro_title`, `pro_description`, `pro_start_time`, `pro_end_time`, `pro_price_from`, `pro_price_to`, `pro_cat_id`, `pro_cit_id`, `pro_district_id`, `pro_invertor_id`, `pro_design_id`, `pro_construction_id`, `pro_hot`, `pro_active`, `pro_floor`, `pro_room`, `pro_teaser`, `pro_contact`, `pro_status`) VALUES
(1, 'Sunshine City', 'Sunshine City', 'nop1538498559.jpg', 'Khu Đô Thị Ciputra – Nam Thăng Long, Tây Hồ, Hà Nội', 'Sunshine City khu đô thị Ciputra, Bảng giá, Thiết kế, Tiến độ xây dựng', 'Sunshine City là dự án của tập đoàn Sunshine Group, nằm trên vị trí vàng khu đô thị Ciputra tây hồ hà nội. Dự án có tổng vốn đầu tư 5000 tỷ và được bảo lãnh bởi ngân hàng Sacombank', '12/2017', '12/2019', 28, 32, 3, 2, 0, 0, 0, 0, 0, 1, 40, 1791, '- 6 tòa tháp 40 tầng\r\n- 03 tầng hầm, 03 tầng TTTM\r\n- 69 lô biệt thự liền kề\r\n', 'Hotline: 0984 721 911 - 0888 506 693', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products_detail`
--

CREATE TABLE `products_detail` (
  `prd_id` int(11) NOT NULL,
  `prd_total` text,
  `prd_total_img` varchar(255) DEFAULT NULL,
  `prd_position` text,
  `prd_position_img` varchar(255) DEFAULT NULL,
  `prd_utilities_in` text,
  `prd_utilities_in_img` varchar(255) DEFAULT NULL,
  `prd_utilities_out` text,
  `prd_utilities_out_img` varchar(255) DEFAULT NULL,
  `prd_design` text,
  `prd_price` text,
  `prd_policy` text,
  `prd_furniture_living_room` text,
  `prd_furniture_bed_room` text,
  `prd_furniture_wc_room` text,
  `prd_furniture_logia_room` text,
  `prd_more` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `products_detail`
--

INSERT INTO `products_detail` (`prd_id`, `prd_total`, `prd_total_img`, `prd_position`, `prd_position_img`, `prd_utilities_in`, `prd_utilities_in_img`, `prd_utilities_out`, `prd_utilities_out_img`, `prd_design`, `prd_price`, `prd_policy`, `prd_furniture_living_room`, `prd_furniture_bed_room`, `prd_furniture_wc_room`, `prd_furniture_logia_room`, `prd_more`) VALUES
(1, '<p>Dự &aacute;n: <strong>Sunshine City</strong><br />\r\nChủ đầu tư: Tập Đo&agrave;n <strong>Sunshine Group</strong><br />\r\nVị tr&iacute; dự &aacute;n: Khu Đ&ocirc; thị Ciputra &ndash; Nam Thăng Long,T&acirc;y Hồ, H&agrave; Nội<br />\r\nDiện t&iacute;ch: 05 hecta<br />\r\nLoại h&igrave;nh ph&aacute;t triển: Dự &aacute;n nh&agrave; ở chung cư kết hợp dịch vụ thương mại Sunshine Riverside<br />\r\nPhong c&aacute;ch kiến tr&uacute;c: Hiện đại (Chung cư), Cổ điển (Biệt thự)<br />\r\nQuy m&ocirc; dự &aacute;n: 6 t&ograve;a th&aacute;p 40 tầng tổng 1.791 căn hộ, diện t&iacute;ch từ 76m2 - 122m2, 03 tầng hầm, 03 tầng TTTM. 69 l&ocirc; liền kề biệt thự.<br />\r\nTiện &iacute;ch: Chuẩn 5* Đẳng cấp C&ocirc;ng nghệ 4.0<br />\r\nTổng mức đầu tư: 5000 tỷ<br />\r\nNg&acirc;n h&agrave;ng bảo l&atilde;nh: <strong>Sacombank</strong><br />\r\nH&igrave;nh thức sở hữu: <span style=\"color:#FF0000;\"><strong>Sổ đỏ vĩnh viễn</strong></span><br />\r\nHo&agrave;n th&agrave;nh v&agrave; đi v&agrave;o sử dụng: <span style=\"color:#FF0000;\"><strong>Q&uacute;y IV/2019</strong></span></p>\r\n\r\n<p style=\"margin: 0px 0px 9.1875px; padding: 0px; outline: none; max-width: 100%; font-family: &quot;Times New Roman&quot;; font-size: 16px; color: rgb(0, 0, 0); text-align: justify; line-height: 20px !important;\">&nbsp;</p>\r\n\r\n<p><iframe allow=\"autoplay; encrypted-media\" allowfullscreen=\"\" frameborder=\"0\" height=\"538\" src=\"https://www.youtube.com/embed/NRB4EqZGvi4\" width=\"100%\"></iframe></p>\r\n\r\n<p style=\"text-align: center;\">(Video giới thiệu về chung cư Sunshine City - Đăng cấp cuộc sốn thượng lưu)</p>\r\n', NULL, '<div><img alt=\"Vị trí chung cư Sunshine City khu đô thị Ciputra\" src=\"/uploads/products/sunshinecity/vitri.jpg\" /></div>\r\n\r\n<div style=\"text-align: center;\">(Vị tr&iacute; chung cư Sunshine City, khu đ&ocirc; thị Ciputra T&acirc;y Hồ - H&agrave; Nội)</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>- Sunshine City được x&acirc;y dựng tại bờ Nam s&ocirc;ng Hồng, nằm trong khu đ&ocirc; thị Ciputra l&agrave; một v&ugrave;ng đất đai tr&ugrave; ph&uacute;, nơi vượng kh&iacute; hưng thịnh, đại diện cho một cuộc sống đẳng cấp v&agrave; tiện nghi</div>\r\n\r\n<div>- Đ&acirc;y cũng l&agrave; nơi quy tụ một cộng đồng d&acirc;n cư gi&agrave;u c&oacute; v&agrave; văn minh &ndash; những gi&aacute; trị hữu h&igrave;nh tạo n&ecirc;n đẳng cấp của một khu an cư thượng lưu.</div>\r\n\r\n<div>- Tọa lạc ở vị tr&iacute; v&agrave;ng c&oacute; thể dễ d&agrave;ng nh&igrave;n ra Hồ T&acirc;y với kh&ocirc;ng gian tho&aacute;ng đ&atilde;ng, cầu Nhật T&acirc;n, s&ocirc;ng Hồng&hellip;Sunshine City thừa hưởng v&agrave; hội tụ tất cả những vẻ đẹp m&agrave; thi&ecirc;n nhi&ecirc;n ban tặng với m&ocirc;i trường sống trong l&agrave;nh, tho&aacute;ng m&aacute;t</div>\r\n\r\n<div>- Dự &aacute;n chung cư Sunshine City ch&iacute;nh l&agrave; dự &aacute;n hội tụ đầy đủ những yếu tố đẳng cấp v&agrave; kh&aacute;c biệt, v&agrave; tự tin khẳng định m&igrave;nh để trở th&agrave;nh một khu đ&aacute;ng sống bậc nhất của Thủ đ&ocirc;</div>\r\n\r\n<div>- Dễ d&agrave;ng kết nối tới c&aacute;c trục giao th&ocirc;ng ch&iacute;nh như cầu Thăng Long, cầu Nhật T&acirc;n, đường v&agrave;nh đai 2, v&agrave;nh đai 3,&hellip;<br />\r\n- Ngay s&aacute;t tuyến metro số 02 Nam Thăng Long &ndash; Trần Hưng Đạo</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>- Với b&aacute;n kinh 3km th&igrave; Sunshine City được kết nối với c&aacute;c địa điểm sau:</div>\r\n\r\n<div>+ Ciputra club<span style=\"white-space:pre\"> </span>500m</div>\r\n\r\n<div>+ Cầu Thăng Long<span style=\"white-space:pre\"> </span>500m</div>\r\n\r\n<div>+ Cầu Nhật T&acirc;n<span style=\"white-space:pre\"> </span>2km</div>\r\n\r\n<div>+ C&ocirc;ng vi&ecirc;n nước Hồ T&acirc;y<span style=\"white-space:pre\"> </span>3km</div>\r\n\r\n<div>+ Dự &aacute;n Sunshine Riverside<span style=\"white-space:pre\"> </span>2km</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div>- Với b&aacute;n kinh 7km th&igrave; Sunshine City được kết nối với c&aacute;c địa điểm sau:</div>\r\n\r\n<div>+ Bến xe Mỹ Đ&igrave;nh <span style=\"white-space:pre\"> </span>7km</div>\r\n\r\n<div>+ Hồ Tr&uacute;c Bạch <span style=\"white-space:pre\"> </span>7km</div>\r\n\r\n<div>+ Bệnh viện E <span style=\"white-space:pre\"> </span>5km</div>\r\n\r\n<div>+ Cung thể thao Quần Ngựa <span style=\"white-space:pre\"> </span>6km</div>\r\n\r\n<div>+ Vườn hoa B&aacute;ch Hợp<span style=\"white-space:pre\"> </span>5km</div>\r\n\r\n<p>- Đ&acirc;y l&agrave; nơi trung t&acirc;m kinh tế, ch&iacute;nh trị, văn h&oacute;a, h&agrave;nh ch&iacute;nh sự nghiệp của cả nước. Điển h&igrave;nh như: Trường đại học danh tiếng,Đ&agrave;i truyền h&igrave;nh Việt Nam, Kh&aacute;ch sạn Grand Plaza, Kangnam, Lakeside..v v<br />\r\n- Với lợi thế hạ tầng tốt, đồng bộ với quy hoạch chiến lược đ&atilde; gi&uacute;p Q.V&Otilde; CH&Iacute; C&Ocirc;NG lu&ocirc;n nằm trong Top c&aacute;c quận đẹp nhất H&agrave; Nội<br />\r\n- Sống tại đ&acirc;y bạn ho&agrave;n to&agrave;n y&ecirc;n t&acirc;m về cơ sở học tập của c&aacute;c con v&igrave; với một loạt c&aacute;c trường điểm h&agrave;ng đầu H&agrave; Nội như: Đại học khoa học x&atilde; hội v&agrave; nh&acirc;n văn, Trường đại học khoa học tự nhi&ecirc;n, Trường THCS Nguyễn Tr&atilde;i, Trường THPT Thực Nghiệm, Trường THCS Phan Chu Trinh, Trường Tiểu Học Kim Đồng..v v</p>\r\n', NULL, '<p>- Ngo&agrave;i những tiện &iacute;ch dịch vụ cơ bản như Trung t&acirc;m thương mại, Bể bơi, Nh&agrave; trẻ, Kh&ocirc;ng gian xanh, Đ&agrave;i phun nước .. th&igrave; Sunshine City c&ograve;n được v&iacute; như một th&agrave;nh phố trong một th&agrave;nh phố với c&aacute;c tiện &iacute;ch đăng cấp 5 sao.</p>\r\n\r\n<p>- L&agrave; một trong số &iacute;t c&aacute;c t&ograve;a nh&agrave; được trang bị hệ thống b&atilde;i đậu trực thăng tr&ecirc;n n&oacute;c t&ograve;a nh&agrave; kết hợp với thi&ecirc;n đường giải tr&iacute; tr&ecirc;n cao, những điều n&agrave;y đ&atilde; đủ đưa dự &aacute;n vượt xa những tiền &iacute;ch th&ocirc;ng thường của một dự &aacute;n chung cư</p>\r\n\r\n<p>- Đối với bất kỳ c&ocirc;ng tr&igrave;nh kiến tr&uacute;c phục vụ đời sống n&agrave;o th&igrave; hồ bơi lu&ocirc;n mang tới một gi&aacute; trị cho sự hưởng thụ cuộc sống. Với Sunshine City, hồ bơi tr&ecirc;n m&aacute;i được thiết kế đặc biệt như một điểm nhấn của t&ograve;a th&aacute;p. Từ hồ bơi v&ocirc; cực giữa kh&ocirc;ng trung c&oacute; thể ph&oacute;ng tầm nh&igrave;n xuống khu cảnh quan tuyệt đẹp, nhạc nước, hoa cỏ c&ugrave;ng tiểu cảnh mang đậm phong c&aacute;ch ch&acirc;u &Acirc;u sẽ cho bạn một cảm gi&aacute;c thư gi&atilde;n tuyệt vời.</p>\r\n\r\n<p>- Theo đuổi thị hiếu thời thượng một kh&ocirc;ng gian rộng r&atilde;i của Sunshine City l&agrave; nơi hiện diện của hầm rượu vang sang trọng. Đắm ch&igrave;m trong sự quyến rũ của &acirc;m nhạc v&agrave; nh&acirc;m nhi những ly rượu tuyệt hảo, những gi&acirc;y ph&uacute;t thư gi&atilde;n của bạn sẽ được thăng hoa tuyệt đối trong kh&ocirc;ng gian giải tr&iacute; đ&iacute;ch thực n&agrave;y</p>\r\n\r\n<p>- Lấy cảm hứng từ th&agrave;nh phố 6 lần li&ecirc;n tiếp được vinh danh l&agrave; th&agrave;nh phố đ&aacute;ng sống nhất thế giới &ndash; Melbourne b&igrave;nh y&ecirc;n, trong l&agrave;nh lu&ocirc;n l&agrave; niềm tự h&agrave;o nước &Uacute;c xinh đẹp, sở hữu hệ thống tiện &iacute;ch xanh ti&ecirc;u chuẩn của c&aacute;c khu đ&ocirc; thị cao cấp (l&otilde;i Landscape, hồ tiểu cảnh, đường dạo ven hồ, đ&agrave;i phun nước, c&acirc;y xanh nội khu), Sunshine City l&agrave; 1 miền thi&ecirc;n nhi&ecirc;n thuần khiết &ocirc;m trọn những tiện &iacute;ch đỉnh cao nơi l&yacute; tưởng để tận hưởng cuộc sống xanh c&ugrave;ng những cơn gi&oacute; trong l&agrave;nh</p>\r\n\r\n<p>- Điểm nhấn kh&ocirc;ng gian của Sunshine City l&agrave; l&otilde;i cảnh quan độc đ&aacute;o với c&aacute;c tuyến phố dạo bộ, nơi diễn ra c&aacute;c hoạt động mua sắm sầm uất c&ugrave;ng những đ&ecirc;m nhạc h&ograve;a &acirc;m hợp sắc. Đ&acirc;y sẽ l&agrave; nơi sớm trở th&agrave;nh điểm đến đầy mới mẻ v&agrave; hấp dẫn, một biểu tượng của nhịp sống thời thượng</p>\r\n\r\n<p>-&nbsp; Chung cư Sunshine City sẽ được tận hưởng trọn vẹn những dịch vụ tiện &iacute;ch ho&agrave;n hảo theo ti&ecirc;u chuẩn quốc tế như trung t&acirc;m dịch vụ Gym-Fitness cấp 5 sao, nh&agrave; h&agrave;ng 5 ch&acirc;u, khu giải tr&iacute; m&ocirc; h&igrave;nh quốc tế, khu spa sauna hiện đại</p>\r\n\r\n<p>- Trung t&acirc;m thương mại được bố tr&iacute; tại 2 tầng khối đế lớn nhất trong khu vực với chiều cao mỗi tầng gần 10m tạo n&ecirc;n một kh&ocirc;ng gian tho&aacute;ng đ&atilde;ng, sang trọng, đẳng cấp. Nhưng khu phố thời trang xa xỉ c&ugrave;ng c&aacute;c thương hiệu nổi tiếng sẽ l&agrave;m thỏa m&atilde;n tức th&igrave; mọi nhu cầu mua sắm, thư gi&atilde;n của cư d&acirc;n s&agrave;nh điệu</p>\r\n\r\n<p>- Sống tại tổ hợp chung cư cao cấp Sunshine City, c&aacute;c bậc phụ huynh c&oacute; thể ho&agrave;n to&agrave;n y&ecirc;n t&acirc;m v&agrave; h&atilde;nh diện về thế hệ tương lai khi được tiếp cận v&agrave; định hướng ph&aacute;t triển tốt nhất bởi hệ thống gi&aacute;o dục li&ecirc;n cấp chuẩn quốc tế như&nbsp; Trường mầm non Sunshine House, trường H&agrave; Nội Academy, Trường quốc tế Li&ecirc;n hợp quốc Unis, Trường quốc tế Singapore&hellip;Với mong muốn hướng tới kh&ocirc;ng gian văn h&oacute;a, Chủ đầu tư đ&atilde; hi sinh một phần lợi nhuận để d&agrave;nh diện t&iacute;ch x&acirc;y dựng ph&ograve;ng thư viện, cung thiếu nhi ph&aacute;t triển kỹ năng, năng khiếu&hellip; với trang thiết bị đẳng cấp quốc tế. Hệ thống cơ sở gi&aacute;o dục ti&ecirc;n tiến ngay trong nội khu dự &aacute;n ch&iacute;nh l&agrave; điểm &quot;V&agrave;ng&quot; trong quyết định lựa chọn Sunshine City l&agrave;m nơi an cư của kh&aacute;ch h&agrave;ng</p>\r\n\r\n<p>- Sở hữu tầm nh&igrave;n Panorama đắt gi&aacute; với những g&oacute;c rộng, to&agrave;n cảnh hướng ra Hồ T&acirc;y, s&ocirc;ng Hồng, cầu Nhật T&acirc;n, Sunshine City mang tới trải nghiệm cuộc sống nghỉ dưỡng mỗi ng&agrave;y, nơi t&aacute;ch biệt với ồn &agrave;o huy&ecirc;n n&aacute;o thường nhật, nơi thư gi&atilde;n, thả hồn v&agrave;o cảnh quan tuyệt đẹp của thi&ecirc;n nhi&ecirc;n, th&agrave;nh phố</p>\r\n\r\n<p>- Tại Sunshine City, c&oacute; đến 40 tiện &iacute;ch cao cấp ti&ecirc;u chuẩn 5 sao d&agrave;nh ri&ecirc;ng cho cư d&acirc;n. Một trong số đ&oacute; c&oacute; thể kể đến như s&acirc;n golf Ciputra 18 lỗ, b&atilde;i đỗ trực thăng, bể bơi panorama, khu tập gym v&agrave; yoga, trường mầm non ti&ecirc;u chuẩn quốc tế, khối sinh hoạt cộng đồng, trung t&acirc;m mua sắm, ẩm thực cao cấp, bar, cafe, lối đi dạo bộ đẹp mắt</p>\r\n\r\n<p>- Với những ứng dụng c&ocirc;ng nghệ th&ocirc;ng minh, đi đầu trong xu hướng vạn vật kết nối internet (IoT), Sunshine City đ&atilde; v&agrave; đang mang tới một l&agrave;n gi&oacute; mới cho thị trường.<br />\r\nTheo đ&oacute;, chủ đầu tư cung cấp miễn ph&iacute; ứng dụng Sunshine Home cho cư d&acirc;n. Phần mềm sẽ gi&uacute;p mỗi cư d&acirc;n c&oacute; thể thực hiện h&agrave;ng loạt c&aacute;c thao t&aacute;c nhanh gọn tr&ecirc;n chiếc điện thoại như: gọi xe, mua sắm, gọi c&aacute;c dịch vụ sửa chữa, thanh to&aacute;n ho&aacute; đơn... rất tiện lợi.</p>\r\n\r\n<p>- Ngo&agrave;i ra, tại Sunshine City c&ograve;n c&oacute; v&iacute; điện tử Sunshine Pay, ứng dụng gọi xe sang Sunshine Cab, Sunshine Service... mọi tiện &iacute;ch đều c&oacute; thể &ldquo;order&rdquo; từ xa qua một n&uacute;t chạm tr&ecirc;n smart phone</p>\r\n\r\n<p>- Nằm giữa khối biệt thự n&agrave;y l&agrave; l&otilde;i Landscape với diện t&iacute;ch gần 3.200 m2 bao gồm: Đường dạo, hồ nước, đ&agrave;i phun, c&acirc;y &aacute;nh s&aacute;ng, c&acirc;y xanh. L&otilde;i Landscape n&agrave;y c&oacute; gi&aacute; trị đầu tư lớn với vật liệu cao cấp c&ugrave;ng hệ thống c&acirc;y xanh được lựa chọn kỹ lưỡng về mặt thẩm mỹ v&agrave; ph&ugrave; hợp với điều kiện kh&iacute; hậu miền Bắc.</p>\r\n\r\n<p>- V&agrave;o ban đ&ecirc;m, l&otilde;i Landscapse sẽ chuyển m&igrave;nh trở th&agrave;nh khu vườn &aacute;nh s&aacute;ng nhờ hệ thống chiếu s&aacute;ng hiện đại v&agrave; c&aacute;c kịch bản &aacute;nh s&aacute;ng độc đ&aacute;o. Kết hợp c&ugrave;ng với hệ thống chiếu s&aacute;ng nội khu v&agrave; những dải đ&egrave;n tr&ecirc;n 6 t&ograve;a nh&agrave;, chắc chắn Sunshine City sẽ l&agrave; t&acirc;m điểm ch&uacute; &yacute; bởi sự lộng lấy của m&igrave;nh v&agrave; l&agrave; nơi mang lại cuộc sống trọn vẹn m&agrave;u sắc</p>\r\n', NULL, '<p>- Sunshine City thừa hưởng c&aacute;c tiện &iacute;ch sẵn c&oacute; của Ciputra (s&acirc;n gofl, s&acirc;n tennis, trường học&hellip;.)</p>\r\n\r\n<p>- Hưởng to&agrave;n bộ tiện &iacute;ch của Sunshine Riverside, đặc biệt l&agrave; hệ thống trường học đẳng cấp Quốc tế</p>\r\n\r\n<p>- Với hạ tầng ng&agrave;y c&agrave;ng ho&agrave;n thiện như: Cầu Nhật T&acirc;n v&agrave; đường cao tốc V&otilde; Ch&iacute; C&ocirc;ng, đường Nguyễn Văn Huy&ecirc;n k&eacute;o d&agrave;i sắp tới ng&agrave;y về đ&iacute;ch, Sunshine City l&agrave; dự &aacute;n v&ocirc; c&ugrave;ng thuận lợi cho người nước ngo&agrave;i khi di chuyển về c&aacute;c khu vực trung t&acirc;m th&agrave;nh phố cũng như đến s&acirc;n bay quốc tế Nội B&agrave;i.</p>\r\n\r\n<p>- Sau khi đường Nguyễn Văn Huy&ecirc;n k&eacute;o d&agrave;i đi v&agrave;o hoạt động, to&agrave;n bộ c&aacute;c khu đ&ocirc; thị như Sunshine City, Ngoại giao đo&agrave;n, T&acirc;y Hồ T&acirc;y, Ciputra Nam Thăng Long sẽ kết nối trực tiếp với nhau th&agrave;nh một thể thống nhất, tạo n&ecirc;n sự đồng bộ hạ tầng giao th&ocirc;ng. Từ Sunshine City, cư d&acirc;n ngoại quốc c&oacute; thể di chuyển dễ d&agrave;ng đến đại sứ qu&aacute;n, trụ sở c&aacute;c cơ quan nước ngo&agrave;i.</p>\r\n\r\n<p>- Khu biệt thự liền kề được thiết kế với khối kiến tr&uacute;c Ph&aacute;p sang trọng v&agrave; lộng lẫy, c&ugrave;ng những tiện nghi cao cấp. Được bố tr&iacute; hợp l&yacute;, đồng đều tạo n&ecirc;n tổng thể như một th&agrave;nh phố Paris tr&aacute;ng lệ thu nhỏ.</p>\r\n', NULL, '', '<p>Gi&aacute; b&aacute;n Sunshine City chỉ từ 30 triệu/m2</p>\r\n\r\n<p>Mở b&aacute;n đợt 1 với nhiều c&aacute;c căn tầng đẹp nhất dự &aacute;n</p>\r\n\r\n<p>- Căn 2PN: Diện t&iacute;ch 73,6 - 89,4 m2. Gi&aacute; từ 2,6 - 3.7 tỷ.<br />\r\n- Căn 3PN: Diện t&iacute;ch 96 - 119,9 m2. Gi&aacute; từ 2,9 - 5 tỷ.<br />\r\n- Gi&aacute; đ&atilde; gồm VAT + Full nội thất cao cấp Kohler v&agrave; Hafele.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>GI&Aacute; B&Aacute;N V&Agrave; TIẾN ĐỘ THANH TO&Aacute;N<br />\r\nĐặt cọc mua căn hộ 100 triệu.<br />\r\nĐợt 1 30% K&yacute; hợp đồng mua b&aacute;n&nbsp;<br />\r\nĐợt 2 10% 15/10/2018<br />\r\nĐợt 3 10% 25/11/2018<br />\r\nĐợt 4 10% 30/12/2018<br />\r\nĐợt 5 10% 15/01/2019<br />\r\nĐợt 6 25% Khi b&agrave;n giao nh&agrave; &ndash; Qu&yacute; IV/2019<br />\r\nĐợt 7 5% Khi nhận sổ hồng</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"\" src=\"/uploads/products/sunshinecity/chinh-sach-ban-hang-sunshine-city.jpg\" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt=\"\" src=\"/uploads/products/sunshinecity/chinh-sach-ban-hang-chung-cu-sunshine-city.jpg\" /></p>\r\n\r\n<p><img alt=\"\" src=\"/uploads/products/sunshinecity/chinh-sach-ban-hang-can-ho-sunshine-city.jpg\" /></p>\r\n', '<p>- Với T&acirc;m l&yacute; mong muốn sở hữu c&aacute;c bất động sản với thủ tục ph&aacute;p l&yacute; r&otilde; r&agrave;ng minh bạch l&agrave; yếu tố thu h&uacute;t được Việt kiều v&agrave; người nước ngo&agrave;i lựa chọn Sunshine City.</p>\r\n\r\n<p>- Ngo&agrave;i ra, từ 10/5/2018, kh&aacute;ch h&agrave;ng mua căn hộ tại Sunshine City được hưởng ch&iacute;nh s&aacute;ch ưu đ&atilde;i lớn chưa từng c&oacute; như: tặng g&oacute;i nh&agrave; th&ocirc;ng minh Smart Home trị gi&aacute; 200 triệu đồng, chiết khấu d&agrave;nh cho kh&aacute;ch h&agrave;ng thanh to&aacute;n sớm, miễn ph&iacute; dịch vụ l&ecirc;n đến 3 năm&hellip;.Sunshine City trở th&agrave;nh &ldquo;m&oacute;n hời&rdquo; cho cả người mua nh&agrave; v&agrave; những nh&agrave; đầu tư s&agrave;nh sỏi.</p>\r\n', '<p>- Đối với người nước ngo&agrave;i mua căn hộ tại Việt Nam, một dự &aacute;n b&agrave;n giao ho&agrave;n thiện với nội thất cao cấp l&agrave; y&ecirc;u ti&ecirc;n h&agrave;ng đầu. Tại Sunshine City, mỗi căn hộ đều được lắp đặt thiết bị vệ sinh Kohler, cửa chống ch&aacute;y, chống ồn Porta Doors, điều h&ograve;a Multi Misubishi Heavy, cửa k&iacute;nh Eurowindow&hellip;</p>\r\n\r\n<p>- Sự sang trọng, xa hoa của kiến tr&uacute;c Ph&aacute;p được thể hiện tinh tế trong từng căn hộ Sunshine City qua hệ thống trang thiết bị nội thất cao cấp mạ v&agrave;ng. Đặc biệt, nội thất ph&ograve;ng tắm mạ v&agrave;ng được cung cấp bởi Kohler mang h&igrave;nh thức kh&aacute;ch sạn 5 sao với to&agrave;n bộ tường, s&agrave;n ốp l&aacute;t đ&aacute; Mable t&ocirc;ng m&agrave;u trầm sang trọng.</p>\r\n', '<p>reen Pearl 378 Minh Khai<br />\r\nĐịa chỉ Số 378 Minh Khai, Vĩnh Tuy, Hai B&agrave; Trưng, H&agrave; Nội<br />\r\nChủ đầu tư C&ocirc;ng ty Cổ phần Ph&aacute;t triển nh&agrave; Phong Ph&uacute; &ndash; Daewon &ndash; Thủ Đức<br />\r\nĐơn vị thiết kế KYTA Architects (Singapore)<br />\r\nTổng diện t&iacute;ch đất lập dự &aacute;n 28.736,2m2<br />\r\nQuy m&ocirc; d&acirc;n số dự kiến 1.600 người<br />\r\nC&aacute;c sản phẩm dự &aacute;n Biệt thự, liền kề, nh&agrave; phố thương mại, văn ph&ograve;ng v&agrave; căn hộ chung cư cao cấp<br />\r\nDiện t&iacute;ch sử dụng đất &ndash; khu nh&agrave; cao tầng 11.404m2</p>\r\n\r\n<p><img alt=\"\" src=\"/uploads/products/ecolakeview32daitu/03A%20eco%20lake%20view.jpg\" style=\"width: 640px; height: 452px;\" /></p>\r\n', '', '', '<p><strong>TIỀM NĂNG CHO THU&Ecirc;</strong></p>\r\n\r\n<p>Tập trung nhiều doanh nghiệp nước ngo&agrave;i v&agrave; doanh nghiệp FDI, những người gi&agrave;u v&agrave; nh&acirc;n sự cấp cao, người nước ngo&agrave;i định cư n&ecirc;n khu vực n&agrave;y c&oacute; nhu cầu thu&ecirc; căn hộ hạng sang lu&ocirc;n ở mức cao. Sunshine City xuất hiện như cơn mưa đầu m&ugrave;a giải cơn kh&aacute;t nhu cầu thu&ecirc; căn hộ cao cấp tại khu vực T&acirc;y Hồ, Nam Thăng Long, Ho&agrave;n Kiếm&hellip;Với hạ tầng hiện đại, chuỗi tiện &iacute;ch, thiết kế tối ưu v&agrave; vị tr&iacute; đắc địa, Sunshine City l&agrave; lựa chọn tối ưu của kh&aacute;ch thu&ecirc; hoặc mong muốn sở hữu nh&agrave; ở tại khu vực ven Hồ T&acirc;y</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>GIA TĂNG GI&Aacute; TRỊ BĐS</strong></p>\r\n\r\n<p>Khu vực xung quanh đường V&otilde; Ch&iacute; C&ocirc;ng đang trở th&agrave;nh trung t&acirc;m h&agrave;nh ch&iacute;nh &ndash; kinh tế mới của H&agrave; Nội, tầm nh&igrave;n đến năm 2020 gi&aacute; đất nơi đ&acirc;y chỉ c&oacute; tăng chứ kh&ocirc;ng c&oacute; giảm. Li&ecirc;n kết v&ugrave;ng linh hoạt nối thẳng s&acirc;n bay quốc tế, nối liền với ngoại th&agrave;nh, chạy thẳng v&agrave;o nội th&agrave;nh cũng l&agrave; một sự đảm bảo cho sự gia tăng gi&aacute; trị nh&agrave; đất sau những lần đổi chủ. Kh&ocirc;ng chỉ l&agrave; một tổ ấm l&yacute; tưởng với phong c&aacute;ch sống sang trọng ho&agrave;ng gia, sở hữu một căn hộ cao cấp khu vực n&agrave;y l&agrave; c&aacute;c nh&agrave; đầu tư sở hữu tiềm năng tăng gi&aacute; bậc nhất.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>CH&Iacute;NH S&Aacute;CH CAM KẾT TỪ CĐT</strong></p>\r\n\r\n<p>Chủ đầu tư cam kết cho thu&ecirc; lại với lợi nhuận 24% gi&aacute; trị căn hộ trong v&ograve;ng 3 năm khiến dự &aacute;n n&agrave;y c&oacute; cam kết ưu việt nhất từ trước đến nay tại khu vực quanh Hồ T&acirc;y. Shunshine City l&agrave; một trong số cực hiếm những dự &aacute;n được chủ đầu tư đảm bảo lợi nhuận cho thu&ecirc; tại H&agrave; Nội, m&agrave; lại c&ograve;n l&agrave; một con số v&ocirc; c&ugrave;ng hấp dẫn. Với chương tr&igrave;nh b&aacute;n h&agrave;ng hấp dẫn, hỗ trợ cho vay thiết thực, việc sở hữu một sản phẩm sinh lời tốt trở n&ecirc;n dễ d&agrave;ng hơn v&agrave; c&aacute;c nh&agrave; đầu tư nhanh nhạy nhất định kh&oacute; bỏ qua cơ hội hiếm c&oacute; kh&oacute; t&igrave;m n&agrave;y</p>\r\n');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products_step`
--

CREATE TABLE `products_step` (
  `prs_id` int(11) NOT NULL,
  `prs_pro_id` int(11) DEFAULT '0',
  `prs_title` varchar(255) DEFAULT NULL,
  `prs_description` text,
  `prs_date` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `use_id` int(11) NOT NULL,
  `use_name` varchar(255) DEFAULT NULL,
  `use_loginname` varchar(100) DEFAULT NULL,
  `use_email` varchar(100) DEFAULT NULL,
  `use_date_create` int(11) DEFAULT '0',
  `use_avatar` varchar(100) DEFAULT NULL,
  `use_password` varchar(100) DEFAULT NULL,
  `use_security` int(11) DEFAULT '0',
  `use_basic_birthday` int(11) DEFAULT '0',
  `use_basic_phone` varchar(255) DEFAULT NULL,
  `use_basic_email` varchar(255) DEFAULT NULL,
  `use_basic_gender` varchar(255) DEFAULT NULL,
  `use_basic_address` varchar(255) DEFAULT NULL,
  `use_basic_marriage` varchar(255) DEFAULT NULL,
  `use_basic_website` varchar(255) DEFAULT NULL,
  `use_basic_facebook` varchar(255) DEFAULT NULL,
  `use_basic_twitter` varchar(255) DEFAULT NULL,
  `use_basic_linked` varchar(255) DEFAULT NULL,
  `use_basic_avatar` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Chỉ mục cho bảng `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`cit_id`);

--
-- Chỉ mục cho bảng `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`con_id`);

--
-- Chỉ mục cho bảng `constructions`
--
ALTER TABLE `constructions`
  ADD PRIMARY KEY (`con_id`);

--
-- Chỉ mục cho bảng `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`con_id`);

--
-- Chỉ mục cho bảng `designs`
--
ALTER TABLE `designs`
  ADD PRIMARY KEY (`des_id`);

--
-- Chỉ mục cho bảng `investors`
--
ALTER TABLE `investors`
  ADD PRIMARY KEY (`inv_id`);

--
-- Chỉ mục cho bảng `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`mod_id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`new_id`);

--
-- Chỉ mục cho bảng `news_content`
--
ALTER TABLE `news_content`
  ADD PRIMARY KEY (`nec_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`);

--
-- Chỉ mục cho bảng `products_detail`
--
ALTER TABLE `products_detail`
  ADD PRIMARY KEY (`prd_id`);

--
-- Chỉ mục cho bảng `products_step`
--
ALTER TABLE `products_step`
  ADD PRIMARY KEY (`prs_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`use_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT cho bảng `city`
--
ALTER TABLE `city`
  MODIFY `cit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT cho bảng `configuration`
--
ALTER TABLE `configuration`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT cho bảng `constructions`
--
ALTER TABLE `constructions`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `contact`
--
ALTER TABLE `contact`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `designs`
--
ALTER TABLE `designs`
  MODIFY `des_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `investors`
--
ALTER TABLE `investors`
  MODIFY `inv_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `modules`
--
ALTER TABLE `modules`
  MODIFY `mod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `new_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT cho bảng `products_step`
--
ALTER TABLE `products_step`
  MODIFY `prs_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `use_id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
