-- --------------------------------------------------------
-- Host:                         52.74.3.44
-- Server version:               5.7.30-0ubuntu0.16.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for dgsdb2
CREATE DATABASE IF NOT EXISTS `dgsdb2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dgsdb2`;

-- Dumping structure for table dgsdb2.tbl_contact
CREATE TABLE IF NOT EXISTS `tbl_contact` (
  `userID` int(7) DEFAULT NULL,
  `studentID` int(7) DEFAULT NULL,
  `contactID` int(7) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(180) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `mobile` varchar(13) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`contactID`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table dgsdb2.tbl_guardian
CREATE TABLE IF NOT EXISTS `tbl_guardian` (
  `userID` int(7) DEFAULT NULL,
  `studentID` int(7) DEFAULT NULL,
  `guardianID` int(7) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(180) DEFAULT NULL,
  `relationship` varchar(30) DEFAULT NULL,
  `guardianPhone` varchar(25) DEFAULT NULL,
  `guardianMobile` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`guardianID`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=latin1 COMMENT='Table For guardian information';

-- Data exporting was unselected.

-- Dumping structure for table dgsdb2.tbl_parents
CREATE TABLE IF NOT EXISTS `tbl_parents` (
  `userID` int(7) DEFAULT NULL,
  `studentID` int(7) DEFAULT NULL,
  `parentID` int(7) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(180) NOT NULL DEFAULT '0',
  `employerName` varchar(180) NOT NULL DEFAULT '0',
  `isFather` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=true',
  `mobileNumber` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`parentID`)
) ENGINE=InnoDB AUTO_INCREMENT=309 DEFAULT CHARSET=latin1 COMMENT='Table for parents information. ';

-- Data exporting was unselected.

-- Dumping structure for table dgsdb2.tbl_parentuser
CREATE TABLE IF NOT EXISTS `tbl_parentuser` (
  `userID` int(7) NOT NULL AUTO_INCREMENT,
  `fname` varchar(60) DEFAULT NULL,
  `mname` varchar(60) DEFAULT NULL,
  `lname` varchar(60) DEFAULT NULL,
  `mobile` varchar(13) DEFAULT NULL,
  `sex` varchar(8) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `isEnabled` tinyint(1) DEFAULT NULL,
  `usertype` tinytext,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=latin1 COMMENT='User list for parent only';

-- Data exporting was unselected.

-- Dumping structure for table dgsdb2.tbl_schoolinfo
CREATE TABLE IF NOT EXISTS `tbl_schoolinfo` (
  `userID` int(7) DEFAULT NULL,
  `studentID` int(7) DEFAULT NULL,
  `schoolInfoID` int(7) NOT NULL AUTO_INCREMENT,
  `schoolLastAttended` varchar(180) DEFAULT NULL,
  `schoolYear` varchar(25) DEFAULT NULL,
  `schoolAddress` varchar(180) DEFAULT NULL,
  `inComingLevel` varchar(50) DEFAULT NULL,
  `averageGrade` int(3) DEFAULT NULL,
  PRIMARY KEY (`schoolInfoID`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table dgsdb2.tbl_schoolyear
CREATE TABLE IF NOT EXISTS `tbl_schoolyear` (
  `schoolYearID` int(4) DEFAULT NULL,
  `schoolYear` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table dgsdb2.tbl_settings
CREATE TABLE IF NOT EXISTS `tbl_settings` (
  `isBodySimple` int(4) DEFAULT '1',
  `currentSchoolYear` int(7) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table dgsdb2.tbl_siblings
CREATE TABLE IF NOT EXISTS `tbl_siblings` (
  `userID` int(7) DEFAULT NULL,
  `studentID` int(7) DEFAULT NULL,
  `siblingID` int(7) NOT NULL AUTO_INCREMENT,
  `fullName` varchar(180) DEFAULT NULL,
  `level` varchar(45) DEFAULT NULL,
  `siblingNo` int(2) DEFAULT NULL COMMENT 'to number the sibling',
  PRIMARY KEY (`siblingID`)
) ENGINE=InnoDB AUTO_INCREMENT=337 DEFAULT CHARSET=latin1 COMMENT='Tables for sibling information';

-- Data exporting was unselected.

-- Dumping structure for table dgsdb2.tbl_student
CREATE TABLE IF NOT EXISTS `tbl_student` (
  `userID` int(7) DEFAULT NULL,
  `studentID` int(7) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `schoolYearID` int(7) DEFAULT '0',
  `studentCode` varchar(30) DEFAULT NULL,
  `lrn` varchar(20) DEFAULT NULL,
  `prefix` varchar(10) DEFAULT NULL,
  `lastName` varchar(60) DEFAULT NULL,
  `firstName` varchar(60) DEFAULT NULL,
  `middleName` varchar(60) DEFAULT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` varchar(50) DEFAULT NULL,
  `Address` varchar(180) DEFAULT NULL,
  `Telno` varchar(25) DEFAULT NULL,
  `Cellphone` varchar(13) DEFAULT NULL,
  `isEldest` varchar(3) DEFAULT NULL COMMENT 'yes or no',
  `familyPlace` varchar(3) DEFAULT NULL,
  `dateTimeSubmitted` datetime DEFAULT NULL,
  `isSubmitted` tinyint(1) DEFAULT '0',
  `isExported` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`studentID`)
) ENGINE=InnoDB AUTO_INCREMENT=7122 DEFAULT CHARSET=latin1 COMMENT='Student main information.';

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
