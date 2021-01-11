-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2020 at 11:22 AM
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
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_school`
--

INSERT INTO `tbl_school` (`schoolID`, `Schoolname`, `Schooladdress`, `Datecreated`, `Status`) VALUES
(1, 'STI Caloocan College', '129 Hindi Mahanap Street Maligaw City', '2019-10-03 13:12:37', 0),
(2, 'STI Munoz College', '129 Bahay ni Wilsom Malake Bawal Pumunta City', '2019-10-03 13:13:03', 0);

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
(40, 1, '7K99G8', '2019-10-30 09:38:28', 0);

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
  MODIFY `tokenID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `accountID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
