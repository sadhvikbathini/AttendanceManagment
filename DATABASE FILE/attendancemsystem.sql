
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `tbltemp` (
  `regStat` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `tbltemp` (`regStat`) VALUES('0');

CREATE TABLE password_reset_tokens (
id INT AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(255) NOT NULL,
token VARCHAR(255) NOT NULL,
created_at DATETIME NOT NULL,
expires_at DATETIME NOT NULL,
INDEX idx_email (email),
INDEX idx_token (token)
);


CREATE TABLE `tbladmin` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `emailAddress` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `tbladmin` (`Id`, `firstName`, `lastName`, `emailAddress`, `password`) VALUES
(1, 'Admin', '', 'admin@mail.com', 'D00F5D5217896FB7FD601412CB890830');


CREATE TABLE `tblattendance` (
  `Id` int(10) NOT NULL,
  `admissionNo` varchar(255) NOT NULL,
  `branchId` varchar(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL,
  `batchId` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `dateTimeTaken` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `tblbranch` (
  `Id` int(10) NOT NULL,
  `branchName` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `tblclass` (
  `Id` int(10) NOT NULL,
  `className` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `tblbatch` (
  `Id` int(10) NOT NULL,
  `batchName` varchar(20) NOT NULL,
  `classId` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `tblclassarms` (
  `Id` int(10) NOT NULL,
  `branchId` varchar(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmName` varchar(255) NOT NULL,
  `isAssigned` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `tblclassteacher` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `branchId` varchar(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `classArmId` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `tblstudents` (
  `Id` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `admissionNumber` varchar(255) NOT NULL,
  `branchId` varchar(10) NOT NULL,
  `classId` varchar(10) NOT NULL,
  `batchId` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `tblattendance`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `tblbranch`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `tblclass`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `tblbatch`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `tblclassarms`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `tblclassteacher`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`Id`);


ALTER TABLE `tbladmin`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `tblattendance`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;


ALTER TABLE `tblbranch`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tblclass`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tblbatch`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tblclassarms`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tblclassteacher`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tblstudents`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;




