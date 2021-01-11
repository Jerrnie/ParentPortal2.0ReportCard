-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2020 at 01:00 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dgsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `isBodySimple` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`isBodySimple`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cardkey`
--

CREATE TABLE `tbl_cardkey` (
  `Id` int(6) NOT NULL,
  `StudentNumber` varchar(20) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `CellphoneNumber` int(13) NOT NULL,
  `CardNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `schoolID` int(9) NOT NULL,
  `Code` varchar(20) NOT NULL,
  `Name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

CREATE TABLE `tbl_employee` (
  `employeeID` int(9) NOT NULL,
  `schoolID` int(9) NOT NULL,
  `Code` varchar(15) NOT NULL,
  `Prefix` varchar(10) NOT NULL,
  `Lastname` varchar(40) NOT NULL,
  `Firstname` varchar(40) NOT NULL,
  `Middlename` varchar(40) NOT NULL,
  `Suffix` varchar(10) NOT NULL,
  `Birthday` date NOT NULL,
  `Mobileno` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gradeyear`
--

CREATE TABLE `tbl_gradeyear` (
  `schoolID` int(9) NOT NULL,
  `Code` varchar(15) NOT NULL,
  `Name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parents`
--

CREATE TABLE `tbl_parents` (
  `studentID` int(9) NOT NULL,
  `schoolID` int(9) NOT NULL,
  `Guardian_name` varchar(150) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Employer_name` varchar(150) NOT NULL,
  `Employer_address` varchar(150) NOT NULL,
  `Employer_telno` varchar(15) NOT NULL,
  `Employer_cellphone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_room`
--

CREATE TABLE `tbl_room` (
  `schoolID` int(9) NOT NULL,
  `Code` varchar(25) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_school`
--

CREATE TABLE `tbl_school` (
  `schoolID` int(9) NOT NULL,
  `Schoolname` varchar(40) NOT NULL,
  `Schooladdress` varchar(50) NOT NULL,
  `Datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` tinyint(1) NOT NULL,
  `pictureFileName` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_school`
--

INSERT INTO `tbl_school` (`schoolID`, `Schoolname`, `Schooladdress`, `Datecreated`, `Status`, `pictureFileName`) VALUES
(1, 'STI Caloocan College', '129 Hindi Mahanap Street Maligaw City', '2019-10-03 13:12:37', 0, 'school1logo'),
(2, 'STI Munoz College', '129 Bahay ni Wilsom Malake Bawal Pumunta City', '2019-10-03 13:13:03', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `schoolID` int(9) NOT NULL,
  `Code` varchar(25) NOT NULL,
  `Name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sibling`
--

CREATE TABLE `tbl_sibling` (
  `studentID` int(9) NOT NULL,
  `schoolID` int(9) NOT NULL,
  `Sibling_name` varchar(150) NOT NULL,
  `Grade_Level` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `studentID` int(9) NOT NULL,
  `schoolID` int(9) NOT NULL,
  `Code` varchar(15) NOT NULL,
  `LRN` varchar(13) NOT NULL,
  `Prefix` varchar(10) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Middlename` varchar(50) NOT NULL,
  `Suffix` varchar(10) NOT NULL,
  `Birthday` date NOT NULL,
  `Parentname` varchar(150) NOT NULL,
  `Mobileno` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`studentID`, `schoolID`, `Code`, `LRN`, `Prefix`, `Lastname`, `Firstname`, `Middlename`, `Suffix`, `Birthday`, `Parentname`, `Mobileno`) VALUES
(1, 1, '911123123213', '911213213123', 'Mr.', 'Paniglinan', 'Jerrnie', 'Bello', '', '2020-05-15', 'Abdul Jabar', '09351621867');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_studentinfo`
--

CREATE TABLE `tbl_studentinfo` (
  `studentID` int(9) NOT NULL,
  `schoolID` int(9) NOT NULL,
  `Code` varchar(15) NOT NULL,
  `Birthday` date NOT NULL,
  `Siblings` tinyint(2) NOT NULL,
  `Family_Place` varchar(150) NOT NULL,
  `Gender` varchar(15) NOT NULL,
  `Address` varchar(150) NOT NULL,
  `Telno` varchar(12) NOT NULL,
  `Cellphone` varchar(12) NOT NULL,
  `School_last_attended` varchar(150) NOT NULL,
  `School_year` varchar(35) NOT NULL,
  `School_Address` varchar(150) NOT NULL,
  `Level_Completed` varchar(40) NOT NULL,
  `Average_grade` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_studentinfo`
--

INSERT INTO `tbl_studentinfo` (`studentID`, `schoolID`, `Code`, `Birthday`, `Siblings`, `Family_Place`, `Gender`, `Address`, `Telno`, `Cellphone`, `School_last_attended`, `School_year`, `School_Address`, `Level_Completed`, `Average_grade`) VALUES
(1, 1, '911123123213', '2020-05-15', 15, '12', 'Male', 'sdsadsadsadsadwsdasdwsd ', '2887576', '09351621867', 'sdsadasdsandui', '2012893', 'ajsndjasbdisubduisabdiub', 'Grade 10', '99');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_teacher`
--

CREATE TABLE `tbl_teacher` (
  `teacherID` int(9) NOT NULL,
  `schoolID` int(9) NOT NULL,
  `Code` varchar(15) NOT NULL,
  `Prefix` varchar(10) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Middlename` varchar(50) NOT NULL,
  `Suffix` varchar(10) NOT NULL,
  `Birthday` date NOT NULL,
  `Mobileno` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_token`
--

CREATE TABLE `tbl_token` (
  `tokenID` int(7) NOT NULL,
  `accountID` int(6) NOT NULL,
  `token` varchar(20) NOT NULL,
  `timeGen` datetime NOT NULL,
  `used` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_token`
--

INSERT INTO `tbl_token` (`tokenID`, `accountID`, `token`, `timeGen`, `used`) VALUES
(1, 1, '56ILYZ', '0000-00-00 00:00:00', 0),
(2, 1, 'JDZC8X', '2019-10-18 07:55:51', 0),
(3, 1, '8GAAKJ', '2019-10-18 10:40:18', 0),
(4, 1, '9P6GPB', '2019-10-18 10:41:31', 0),
(5, 1, 'WGKLME', '2019-10-18 10:42:50', 0),
(6, 1, 'WJWAI1', '2019-10-21 03:05:58', 0),
(7, 1, '4X8HOZ', '2019-10-21 11:02:08', 0),
(8, 1, 'PHM3OK', '2019-10-22 09:55:24', 0),
(9, 1, 'B3XKKD', '2019-10-22 11:01:15', 0),
(10, 1, 'YDGC2Z', '2019-10-22 13:13:00', 0),
(11, 1, 'K57XPB', '2019-10-22 13:15:46', 0),
(12, 1, 'FBC2HO', '2019-10-22 13:17:28', 0),
(13, 1, '62F091', '2019-10-22 13:19:59', 0),
(14, 1, 'OKCYOG', '2019-10-22 13:50:49', 0),
(15, 1, '1HAWCF', '2019-10-22 14:55:02', 0),
(16, 1, 'I7KM53', '2019-10-28 11:36:09', 0),
(17, 1, 'Z5WEWB', '2019-10-28 11:37:51', 0),
(18, 1, '5EF167', '2019-10-28 11:38:04', 0),
(19, 1, 'ZEZK4L', '2019-10-28 11:40:15', 0),
(20, 1, 'EIAXBI', '2019-10-28 11:40:41', 0),
(21, 1, '946PC0', '2019-10-28 11:44:03', 0),
(22, 1, 'EHJJ4I', '2019-10-28 11:44:56', 0),
(23, 1, '9ZHKIH', '2019-10-28 11:45:27', 0),
(24, 1, 'PX3JW9', '2019-10-28 12:00:02', 0),
(25, 1, 'FCLYMI', '2019-10-28 13:25:05', 0),
(26, 1, '88LDEB', '2019-10-28 13:25:15', 0),
(27, 1, 'A9HXEB', '2019-10-28 13:25:33', 0),
(28, 1, '691EGA', '2019-10-28 13:30:12', 0),
(29, 1, 'YO6JB8', '2019-10-28 13:38:06', 0),
(30, 1, 'PAGOJ8', '2019-10-28 13:52:40', 0),
(31, 1, 'MZAPAF', '2019-10-28 14:30:15', 0),
(32, 1, 'OO1YXF', '2019-10-28 14:39:01', 0),
(33, 1, 'DW489G', '2019-10-28 14:52:43', 0),
(34, 1, 'WH60M8', '2019-10-28 16:04:29', 0),
(35, 1, 'F92AB5', '2019-10-28 16:07:23', 1),
(36, 1, 'EJKGA1', '2019-10-28 16:15:10', 1),
(37, 1, '6E0PFZ', '2019-10-28 16:23:07', 1),
(38, 1, 'Z1WYP4', '2019-10-28 16:41:58', 0),
(39, 1, '29LFF5', '2019-10-30 08:45:22', 0),
(40, 1, '7K99G8', '2019-10-30 09:38:28', 0),
(41, 1, '230HHP', '2020-01-04 11:53:12', 0),
(42, 1, '0C988E', '2020-01-04 11:55:28', 0),
(43, 1, 'X5CXA9', '2020-01-04 11:57:44', 0),
(44, 1, 'J26AG2', '2020-01-04 11:58:49', 0),
(45, 1, 'OAFJYG', '2020-01-04 11:59:43', 0),
(46, 1, 'FXZIB2', '2020-01-04 12:28:07', 0),
(47, 1, 'XEOG1H', '2020-01-04 12:29:14', 0),
(48, 1, 'A2J3BX', '2020-01-04 12:30:02', 0),
(49, 1, 'M2Y1HM', '2020-01-04 12:30:13', 0),
(50, 1, '7GYYHD', '2020-01-04 12:30:54', 0),
(51, 1, 'X639WI', '2020-01-04 12:31:32', 0),
(52, 1, 'LD6LCC', '2020-01-04 12:32:40', 0),
(53, 1, 'JFYX4B', '2020-01-04 12:48:53', 0),
(54, 1, 'OIWWBG', '2020-01-04 12:49:21', 0),
(55, 1, 'MIXCA6', '2020-01-04 12:50:55', 0),
(56, 1, 'JP3FBO', '2020-01-04 12:52:18', 0),
(57, 1, '637HIG', '2020-01-04 12:53:22', 0),
(58, 1, 'DX2CCJ', '2020-01-04 12:54:22', 0),
(59, 1, 'P50M71', '2020-01-04 20:04:31', 0),
(60, 1, 'JPP0Z1', '2020-01-05 17:16:51', 0),
(61, 1, 'XOJF15', '2020-01-05 17:23:25', 0),
(62, 1, 'OOO1KA', '2020-01-05 17:26:03', 0),
(63, 1, '6LO4GA', '2020-01-05 17:27:26', 0),
(64, 1, '7GX1M7', '2020-01-05 17:29:17', 0),
(65, 1, 'Z7H3LF', '2020-01-05 17:29:24', 0),
(66, 1, 'IXHL92', '2020-01-05 17:36:11', 0),
(67, 1, 'MYG9HW', '2020-01-05 17:37:01', 0),
(68, 1, 'A2OYPP', '2020-01-05 17:37:37', 0),
(69, 1, 'WLAYKZ', '2020-01-06 22:28:30', 0),
(70, 1, 'F8MDYL', '2020-01-06 22:32:50', 0),
(71, 1, 'B99LLW', '2020-01-06 22:36:35', 0),
(72, 1, 'DIC04B', '2020-01-06 22:37:34', 0),
(73, 1, '7KYIF3', '2020-01-06 23:03:28', 0),
(74, 1, 'FE727B', '2020-01-06 23:03:32', 0),
(75, 1, '2G7KYI', '2020-01-06 23:03:35', 0),
(76, 1, '0XZJEJ', '2020-01-06 23:03:38', 0),
(77, 1, 'KW565D', '2020-01-06 23:03:41', 0),
(78, 1, 'YAYE6L', '2020-01-06 23:03:44', 0),
(79, 1, 'B8PKFC', '2020-01-06 23:03:47', 0),
(80, 1, '8AO23G', '2020-01-06 23:03:49', 0),
(81, 1, 'BD5P8I', '2020-01-06 23:03:52', 0),
(82, 1, '4IC9BG', '2020-01-06 23:03:56', 0),
(83, 1, '6IDFJO', '2020-01-06 23:04:01', 0),
(84, 1, 'W8Y388', '2020-01-06 23:04:02', 0),
(85, 1, '1XI6JD', '2020-01-06 23:04:02', 0),
(86, 1, 'AAEZE9', '2020-01-06 23:04:02', 0),
(87, 1, 'J2FB95', '2020-01-06 23:04:02', 0),
(88, 1, 'MGE4D2', '2020-01-06 23:04:03', 0),
(89, 1, '5PL651', '2020-01-06 23:04:03', 0),
(90, 1, 'IJAPFY', '2020-01-06 23:04:06', 0),
(91, 1, 'HA4GZ7', '2020-01-06 23:04:06', 0),
(92, 1, 'EH32YP', '2020-01-06 23:04:06', 0),
(93, 1, 'IFKW3A', '2020-01-06 23:04:07', 0),
(94, 1, 'EEJE4J', '2020-01-06 23:04:09', 0),
(95, 1, 'M2MOAK', '2020-01-06 23:04:13', 0),
(96, 1, 'H2A1AF', '2020-01-06 23:07:24', 0),
(97, 1, '6L1ZC9', '2020-01-06 23:12:34', 0),
(98, 1, 'I9O2P5', '2020-01-06 23:32:54', 0),
(99, 1, '7P0HKP', '2020-01-06 23:33:03', 0),
(100, 1, '406XC9', '2020-01-06 23:35:53', 0),
(101, 1, 'MIGIX2', '2020-01-06 23:39:39', 0),
(102, 1, 'WZADDK', '2020-01-06 23:42:38', 0),
(103, 1, 'WDH975', '2020-01-07 00:00:58', 0),
(104, 1, 'O0WXX1', '2020-01-07 01:14:42', 0),
(105, 1, 'GD7845', '2020-01-07 01:15:39', 0),
(106, 1, '0BE4I4', '2020-01-07 01:15:54', 0),
(107, 1, '7524I2', '2020-01-07 01:17:14', 0),
(108, 1, 'IA6KKW', '2020-01-07 01:17:16', 0),
(109, 1, 'G0GIEM', '2020-01-07 01:17:50', 0),
(110, 1, 'IFFDDX', '2020-01-07 01:20:28', 0),
(111, 1, 'OBH0W4', '2020-01-07 01:20:42', 0),
(112, 1, 'OJMGGP', '2020-01-07 01:21:05', 0),
(113, 1, 'FP96H2', '2020-01-07 01:21:50', 0),
(114, 1, '0HYBGW', '2020-01-07 01:22:18', 0),
(115, 1, '7PB6AF', '2020-01-07 01:29:29', 0),
(116, 1, '885J0A', '2020-01-07 01:30:10', 0),
(117, 1, '9M6AYY', '2020-01-07 01:30:39', 0),
(118, 1, 'A4ME5W', '2020-01-07 01:34:50', 0),
(119, 1, 'FPMZFE', '2020-01-07 01:35:02', 0),
(120, 1, 'IZ06XP', '2020-01-07 01:35:22', 0),
(121, 1, 'ABHC47', '2020-01-07 01:35:40', 0),
(122, 1, '54GCAJ', '2020-01-07 01:36:07', 0),
(123, 1, 'GF07XK', '2020-01-07 01:37:21', 0),
(124, 1, '3J5PZ5', '2020-01-07 01:37:56', 0),
(125, 1, 'Y0O49A', '2020-01-07 01:39:31', 0),
(126, 1, '7FF8A3', '2020-01-07 01:39:37', 0),
(127, 1, 'CAPYHC', '2020-01-07 01:40:05', 0),
(128, 1, 'C4XXCX', '2020-01-07 01:40:18', 0),
(129, 1, 'ZH72LE', '2020-01-07 01:40:40', 0),
(130, 1, 'KP8WBZ', '2020-01-07 01:41:20', 0),
(131, 1, 'X9H4EL', '2020-01-07 01:41:46', 0),
(132, 1, '4581CA', '2020-01-07 01:42:57', 0),
(133, 1, '3JD93O', '2020-01-07 02:11:19', 0),
(134, 1, 'Y8EWIM', '2020-01-07 02:11:28', 0),
(135, 1, '7L41E4', '2020-01-07 02:12:17', 0),
(136, 1, 'DDDL2D', '2020-01-07 02:13:12', 0),
(137, 1, 'M9JG5C', '2020-01-07 02:13:28', 0),
(138, 1, '051FME', '2020-01-07 02:13:41', 0),
(139, 1, '6BJ4HX', '2020-01-07 02:15:34', 0),
(140, 1, 'FC7CBM', '2020-01-07 02:15:53', 0),
(141, 1, '986BD8', '2020-01-07 02:16:46', 0),
(142, 1, 'BLJBX6', '2020-01-07 02:17:16', 0),
(143, 1, 'EDYAGC', '2020-01-07 02:17:46', 0),
(144, 1, 'MEJ6G5', '2020-01-07 02:19:41', 0),
(145, 1, '5MJ54G', '2020-01-07 02:19:51', 0),
(146, 1, '0O4ZO1', '2020-01-07 02:20:48', 0),
(147, 1, 'CYDFGB', '2020-01-07 02:24:02', 0),
(148, 1, '8D9JJE', '2020-01-07 02:24:08', 0),
(149, 1, 'PHHI90', '2020-01-07 02:25:34', 0),
(150, 1, '5YYZ74', '2020-01-07 02:25:37', 0),
(151, 1, '46DF6J', '2020-01-07 02:26:00', 0),
(152, 1, 'PI6EOF', '2020-01-07 02:26:02', 0),
(153, 1, 'KAKDCZ', '2020-01-07 02:26:33', 0),
(154, 1, '5PL3DH', '2020-01-07 02:27:17', 0),
(155, 1, '9KPEP5', '2020-01-07 02:27:19', 0),
(156, 1, '1IDD51', '2020-01-07 02:27:46', 0),
(157, 1, 'I4O92G', '2020-01-07 02:28:11', 0),
(158, 1, 'XPYF05', '2020-01-07 02:28:35', 0),
(159, 1, 'W8950K', '2020-01-07 02:29:00', 0),
(160, 1, 'A6EH32', '2020-01-07 03:08:44', 0),
(161, 1, 'YPI9O2', '2020-01-07 03:08:50', 0),
(162, 1, 'G9WMPC', '2020-01-07 03:16:37', 0),
(163, 1, '0642HP', '2020-01-07 03:18:19', 0),
(164, 1, 'P5406X', '2020-01-07 03:18:24', 0),
(165, 1, 'C9MIGI', '2020-01-07 03:19:03', 0),
(166, 1, '5F5LBP', '2020-01-07 03:19:25', 0),
(167, 1, 'E5K47I', '2020-01-07 13:03:25', 0),
(168, 1, '5JGEH5', '2020-01-07 13:14:07', 0),
(169, 1, 'YEKHW3', '2020-01-07 13:29:39', 0),
(170, 1, '5M7GWK', '2020-01-07 13:29:57', 0),
(171, 1, 'ZZYDMY', '2020-01-07 13:29:59', 0),
(172, 1, '44M3H4', '2020-01-07 13:29:59', 0),
(173, 1, 'E01HAW', '2020-01-07 13:30:00', 0),
(174, 1, 'CFOOO0', '2020-01-07 13:30:00', 0),
(175, 1, '8M5W6B', '2020-01-07 13:30:00', 0),
(176, 1, '5J7BWL', '2020-01-07 13:30:04', 0),
(177, 1, 'GFF342', '2020-01-07 13:30:07', 0),
(178, 1, '8BAA80', '2020-01-07 13:31:20', 0),
(179, 1, '6Z33FC', '2020-01-07 13:31:23', 0),
(180, 1, 'L783BF', '2020-01-07 13:31:25', 0),
(181, 1, 'BP0HAI', '2020-01-07 13:31:52', 0),
(182, 1, 'DWWC4L', '2020-01-07 13:31:54', 0),
(183, 1, 'W4Y136', '2020-01-07 13:31:56', 0),
(184, 1, 'AO0ME8', '2020-01-07 13:31:57', 0),
(185, 1, 'E71I5M', '2020-01-07 13:32:35', 0),
(186, 1, 'ZY4D4A', '2020-01-07 13:32:37', 0),
(187, 1, 'DKE85X', '2020-01-07 13:32:46', 0),
(188, 1, 'XG11FY', '2020-01-07 13:36:38', 0),
(189, 1, '3MC33F', '2020-01-07 13:36:39', 0),
(190, 1, 'J6HAC0', '2020-01-07 13:36:39', 0),
(191, 1, 'D5316K', '2020-01-07 13:36:39', 0),
(192, 1, 'GAM70G', '2020-01-07 13:36:39', 0),
(193, 1, '8J294K', '2020-01-07 13:37:36', 0),
(194, 1, 'PO5AKD', '2020-01-07 13:37:37', 0),
(195, 1, 'JH304G', '2020-01-07 13:38:38', 0),
(196, 1, 'FG26M0', '2020-01-07 13:39:09', 0),
(197, 1, '9IMG6Y', '2020-01-07 13:40:36', 0),
(198, 1, 'M0B3YG', '2020-01-07 13:41:07', 0),
(199, 1, 'FLBJ12', '2020-01-07 13:41:08', 0),
(200, 1, '3FC8YC', '2020-01-07 13:41:08', 0),
(201, 1, '3GYFBM', '2020-01-07 13:41:09', 0),
(202, 1, '13WH55', '2020-01-07 13:41:09', 0),
(203, 1, '1L3X5M', '2020-01-07 13:41:09', 0),
(204, 1, 'MBG79E', '2020-01-07 13:41:33', 0),
(205, 1, '8LX35E', '2020-01-07 13:41:34', 0),
(206, 1, 'Y40782', '2020-01-07 13:41:34', 0),
(207, 1, 'XKJFGH', '2020-01-07 13:42:03', 0),
(208, 1, 'PKM6OJ', '2020-01-07 13:42:17', 0),
(209, 1, '0Z58ZG', '2020-01-07 13:42:17', 0),
(210, 1, 'FMJJ42', '2020-01-07 13:42:17', 0),
(211, 1, 'H13X66', '2020-01-07 13:42:18', 0),
(212, 1, 'I499G9', '2020-01-07 13:42:32', 0),
(213, 1, 'YX59OF', '2020-01-07 13:42:32', 0),
(214, 1, '26O6DL', '2020-01-07 13:42:32', 0),
(215, 1, '1ZC8L8', '2020-01-07 13:42:33', 0),
(216, 1, 'M0PHGM', '2020-01-07 13:42:33', 0),
(217, 1, '0J1P1O', '2020-01-07 13:42:33', 0),
(218, 1, 'BEC577', '2020-01-07 13:42:33', 0),
(219, 1, '8X59Z9', '2020-01-07 13:45:28', 0),
(220, 1, 'EAHXYE', '2020-01-07 13:46:52', 0),
(221, 1, 'FZM460', '2020-01-07 13:47:00', 0),
(222, 1, 'JF9HP5', '2020-01-07 13:47:07', 0),
(223, 1, 'B43CX9', '2020-01-07 13:47:17', 0),
(224, 1, '5GGJM1', '2020-01-07 13:47:37', 0),
(225, 1, '2ZEMM3', '2020-01-07 13:47:44', 0),
(226, 1, 'GLWF3J', '2020-01-07 13:47:47', 0),
(227, 1, '2IY6A0', '2020-01-07 13:50:24', 0),
(228, 1, 'C178WC', '2020-01-07 13:51:30', 0),
(229, 1, 'Z8ZKW0', '2020-01-07 13:52:42', 0),
(230, 1, 'PLCH3B', '2020-01-07 13:54:01', 0),
(231, 1, '48998F', '2020-01-07 14:21:53', 0),
(232, 1, 'G4JFH5', '2020-01-07 14:23:33', 0),
(233, 1, '0EMOXB', '2020-01-07 14:23:43', 0),
(234, 1, '1O4YC2', '2020-01-07 14:24:57', 0),
(235, 1, '0CGMGY', '2020-01-07 14:25:53', 0),
(236, 1, 'L5CKCW', '2020-01-07 14:30:54', 0),
(237, 1, 'F61OIP', '2020-01-07 14:31:29', 0),
(238, 1, 'IY9P9O', '2020-01-07 14:31:41', 0),
(239, 1, '0KXF75', '2020-01-07 14:31:57', 0),
(240, 1, '83YBWF', '2020-01-07 14:32:20', 0),
(241, 1, 'B00YWA', '2020-01-07 14:33:49', 0),
(242, 1, 'O4AKX9', '2020-01-07 14:34:01', 0),
(243, 1, 'JYB9I2', '2020-01-07 14:35:21', 0),
(244, 1, '20ZC88', '2020-01-07 14:36:50', 0),
(245, 1, 'PIKE97', '2020-01-07 14:37:43', 0),
(246, 1, '98ZL0Z', '2020-01-07 14:39:41', 0),
(247, 1, 'J95GM0', '2020-01-07 14:40:56', 0),
(248, 1, '4D2JIK', '2020-01-07 14:41:51', 0),
(249, 1, '3HC3H3', '2020-01-07 14:42:40', 0),
(250, 1, 'Z9L0LI', '2020-01-07 14:42:47', 0),
(251, 1, 'E972J4', '2020-01-07 14:42:57', 0),
(252, 1, 'IHAIIE', '2020-01-07 14:43:15', 0),
(253, 1, 'ADIFKW', '2020-01-07 14:43:24', 0),
(254, 1, '3A474O', '2020-01-07 14:43:39', 0),
(255, 1, 'ZBODWW', '2020-01-07 14:43:44', 0),
(256, 1, 'O6PI68', '2020-01-07 14:43:55', 0),
(257, 1, '15PMA4', '2020-01-07 14:44:23', 0),
(258, 1, 'L0ALHB', '2020-01-07 14:44:28', 0),
(259, 1, '03EWA6', '2020-01-07 14:46:02', 0),
(260, 1, '27LXG4', '2020-01-07 14:46:08', 0),
(261, 1, 'OIBDY5', '2020-01-07 14:46:50', 0),
(262, 1, 'JYG78W', '2020-01-07 14:47:55', 0),
(263, 1, '064D24', '2020-01-07 14:48:17', 0),
(264, 1, 'A0AEO6', '2020-01-07 14:49:22', 0),
(265, 1, 'DO3PP4', '2020-01-07 14:51:04', 0),
(266, 1, 'XM0M0B', '2020-01-07 14:51:46', 0),
(267, 1, 'W89EAH', '2020-01-07 14:54:14', 0),
(268, 1, '2I8P38', '2020-01-07 14:55:02', 0),
(269, 1, 'L816X1', '2020-01-07 14:55:20', 0),
(270, 1, 'DZWCK2', '2020-01-08 17:27:46', 0),
(271, 1, '2JDX19', '2020-01-08 17:53:26', 0),
(272, 1, '1WWC57', '2020-01-08 17:54:50', 0),
(273, 1, 'K89L84', '2020-01-08 17:55:06', 0),
(274, 1, 'JMGLDJ', '2020-01-08 17:57:26', 0),
(275, 1, 'I80EG8', '2020-01-08 17:57:35', 0),
(276, 1, '69DOK5', '2020-01-08 17:59:29', 0),
(277, 1, '75DO74', '2020-01-08 18:32:50', 0),
(278, 1, 'J5I6CC', '2020-01-08 18:37:00', 0),
(279, 1, '5F6CZF', '2020-01-08 18:37:00', 0),
(280, 1, 'BYGL4C', '2020-01-08 18:46:15', 0),
(281, 1, 'YCP6FL', '2020-01-08 18:46:15', 0),
(282, 1, '1FGZ47', '2020-01-08 18:48:03', 0),
(283, 1, '8IM886', '2020-01-08 18:54:50', 0),
(284, 1, 'PY1HHP', '2020-01-08 18:57:53', 0),
(285, 1, 'ICZM55', '2020-01-08 19:01:08', 0),
(286, 1, 'Y8W151', '2020-01-08 19:04:09', 0),
(287, 1, '192BXI', '2020-01-08 19:07:59', 0),
(288, 1, 'ELF9ME', '2020-01-08 19:12:51', 0),
(289, 1, '693MIF', '2020-01-08 19:15:52', 0),
(290, 1, '1B4C61', '2020-01-08 19:53:34', 0),
(291, 1, 'L3EXWX', '2020-01-16 18:25:03', 0),
(292, 1, 'P2KLBC', '2020-01-16 18:28:52', 0),
(293, 1, '3I09OO', '2020-01-16 18:32:21', 1),
(294, 1, '78J5DJ', '2020-01-16 18:33:40', 0),
(295, 1, 'X23Y37', '2020-01-16 18:36:41', 0),
(296, 1, 'O6CCJA', '2020-01-16 18:39:43', 0),
(297, 1, 'BC21ZK', '2020-01-16 18:43:16', 0),
(298, 1, 'Y6GDED', '2020-01-16 18:48:29', 0),
(299, 1, 'B9J82B', '2020-01-16 18:51:30', 0),
(300, 1, 'M02EDH', '2020-01-16 18:52:27', 0),
(301, 1, '9YDZOD', '2020-01-16 18:58:03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `accountID` int(6) NOT NULL,
  `schoolID` int(9) NOT NULL,
  `Lastname` varchar(40) NOT NULL,
  `Firstname` varchar(40) NOT NULL,
  `userEmail` varchar(60) NOT NULL,
  `Mobileno` varchar(13) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Level` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`accountID`, `schoolID`, `Lastname`, `Firstname`, `userEmail`, `Mobileno`, `Password`, `Level`) VALUES
(1, 1, 'Pangilinan', 'Jerrnie', 'dota.jerrnie@gmail.com', '09351621867', 'jerrnie01', 2),
(2, 2, 'Pangilinan2', 'Jerrnie2', 'jerrnie15th@gmail.com', '09192000550', 'jerrnie01', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cardkey`
--
ALTER TABLE `tbl_cardkey`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD UNIQUE KEY `schoolID` (`schoolID`),
  ADD UNIQUE KEY `Code` (`Code`);

--
-- Indexes for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  ADD PRIMARY KEY (`employeeID`),
  ADD UNIQUE KEY `schoolID` (`schoolID`);

--
-- Indexes for table `tbl_gradeyear`
--
ALTER TABLE `tbl_gradeyear`
  ADD UNIQUE KEY `schoolID` (`schoolID`),
  ADD UNIQUE KEY `Code` (`Code`);

--
-- Indexes for table `tbl_school`
--
ALTER TABLE `tbl_school`
  ADD PRIMARY KEY (`schoolID`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`studentID`),
  ADD UNIQUE KEY `schoolID` (`schoolID`);

--
-- Indexes for table `tbl_studentinfo`
--
ALTER TABLE `tbl_studentinfo`
  ADD UNIQUE KEY `studentID` (`studentID`),
  ADD UNIQUE KEY `schoolID` (`schoolID`);

--
-- Indexes for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  ADD PRIMARY KEY (`teacherID`),
  ADD UNIQUE KEY `schoolID` (`schoolID`);

--
-- Indexes for table `tbl_token`
--
ALTER TABLE `tbl_token`
  ADD PRIMARY KEY (`tokenID`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`accountID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cardkey`
--
ALTER TABLE `tbl_cardkey`
  MODIFY `Id` int(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_employee`
--
ALTER TABLE `tbl_employee`
  MODIFY `employeeID` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_school`
--
ALTER TABLE `tbl_school`
  MODIFY `schoolID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  MODIFY `teacherID` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_token`
--
ALTER TABLE `tbl_token`
  MODIFY `tokenID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `accountID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
