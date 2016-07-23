-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Comment` text NOT NULL,
  `UserId` int(11) NOT NULL,
  `TicketId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `UserId` (`UserId`),
  KEY `TicketId` (`TicketId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ErrorLogs`;
CREATE TABLE `ErrorLogs` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Error` text NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `TicketId` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `ReporterId` int(11) DEFAULT NULL,
  UNIQUE KEY `TicketId` (`TicketId`),
  KEY `ReporterId` (`ReporterId`),
  KEY `UserId` (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Priority` enum('low','medium','high') DEFAULT NULL,
  `Status` enum('notStarted','Inprogress','Finished','Tested','Closed') DEFAULT NULL,
  `Resolution` varchar(50) DEFAULT NULL,
  `StartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `EndDate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `TicketLog`;
CREATE TABLE `TicketLog` (
  `TicketId` int(11) NOT NULL,
  `LogMessage` text NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `TicketId` (`TicketId`),
  CONSTRAINT `ticketlog_ibfk_1` FOREIGN KEY (`TicketId`) REFERENCES `task` (`TicketId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `PasswordHash` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


