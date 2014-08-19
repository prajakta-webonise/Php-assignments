-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 18, 2014 at 02:18 PM
-- Server version: 5.5.38
-- PHP Version: 5.3.10-1ubuntu3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `courier_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE IF NOT EXISTS `Orders` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `To` varchar(50) NOT NULL,
  `AddressLine1` tinytext NOT NULL,
  `AddressLine2` tinytext NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(20) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `Pincode` int(6) NOT NULL,
  `Message` tinytext NOT NULL,
  `Contact` varchar(13) NOT NULL,
  `Date` date NOT NULL,
  `ProductID` int(3) NOT NULL,
  `UserID` int(3) NOT NULL,
  `WeightID` int(3) NOT NULL,
  `Status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ProductID` (`ProductID`,`UserID`,`WeightID`),
  KEY `UserID` (`UserID`),
  KEY `WeightID` (`WeightID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`ID`, `To`, `AddressLine1`, `AddressLine2`, `City`, `State`, `Country`, `Pincode`, `Message`, `Contact`, `Date`, `ProductID`, `UserID`, `WeightID`, `Status`) VALUES
(1, 'Prajakta Rajapure', 'Sushila Sadan ', 'Gajanan Nagar,Pimple Gurav', 'Pune', 'Maharastra', 'India', 411061, 'Happy Birthday.', '99999999', '2014-08-07', 1, 5, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE IF NOT EXISTS `Products` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`ID`, `Name`) VALUES
(1, 'Television'),
(2, 'Printer'),
(3, 'Laptop'),
(4, 'Documnets');

-- --------------------------------------------------------

--
-- Table structure for table `Status`
--

CREATE TABLE IF NOT EXISTS `Status` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `Status` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Status`
--

INSERT INTO `Status` (`ID`, `Status`) VALUES
(1, 'Waiting For Approval'),
(2, 'Shipment Dispatched'),
(3, 'Shipment Arrived'),
(4, 'Shipment Further Coonected'),
(5, 'Shipment Out For Delivery'),
(6, 'Shipment Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `Track`
--

CREATE TABLE IF NOT EXISTS `Track` (
  `ID` varchar(16) NOT NULL,
  `OrderID` int(5) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `StatusID` (`OrderID`),
  KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Track`
--

INSERT INTO `Track` (`ID`, `OrderID`) VALUES
('abc123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `TrackDetails`
--

CREATE TABLE IF NOT EXISTS `TrackDetails` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Location` varchar(25) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `TackID` varchar(16) NOT NULL,
  `StatusID` int(3) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `TackID` (`TackID`,`StatusID`),
  KEY `StatusID` (`StatusID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `TrackDetails`
--

INSERT INTO `TrackDetails` (`ID`, `Location`, `Date`, `Time`, `TackID`, `StatusID`) VALUES
(1, 'Delhi', '2014-08-18', '10:00:00', 'abc123', 1),
(2, 'Pune', '2014-08-19', '10:00:00', 'abc123', 3),
(3, 'Delhi', '2014-08-18', '10:30:00', 'abc123', 2);

-- --------------------------------------------------------

--
-- Table structure for table `UserRoles`
--

CREATE TABLE IF NOT EXISTS `UserRoles` (
  `ID` int(2) NOT NULL AUTO_INCREMENT,
  `Roles` varchar(15) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `UserRoles`
--

INSERT INTO `UserRoles` (`ID`, `Roles`) VALUES
(1, 'Administrator'),
(2, 'Courier'),
(3, 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(15) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `AddressLine1` tinytext NOT NULL,
  `AddressLine2` tinytext NOT NULL,
  `City` varchar(25) NOT NULL,
  `State` varchar(20) NOT NULL,
  `Country` varchar(20) NOT NULL,
  `Pincode` int(6) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Contact` varchar(13) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `UserRoleID` int(2) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UserRoleID` (`UserRoleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`ID`, `FirstName`, `LastName`, `AddressLine1`, `AddressLine2`, `City`, `State`, `Country`, `Pincode`, `Email`, `Contact`, `Password`, `UserRoleID`) VALUES
(3, 'Admin', 'Admin', '', '', '', '', '', 0, 'admin@admin.com', '99999999', '123456', 1),
(4, 'Courier', 'Courier', '', '', '', '', '', 0, 'courier@courier.com', '8888888888', '123456', 2),
(5, 'User', 'User', '', '', '', '', '', 0, 'user@user.com', '99999999', '123456', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Weight`
--

CREATE TABLE IF NOT EXISTS `Weight` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `From` float NOT NULL,
  `To` float NOT NULL,
  `Price` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Weight`
--

INSERT INTO `Weight` (`ID`, `From`, `To`, `Price`) VALUES
(1, 0, 3, 50),
(2, 3.1, 6, 100),
(3, 6.1, 9, 150),
(4, 9.1, 12, 200);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Products` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Orders_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Orders_ibfk_3` FOREIGN KEY (`WeightID`) REFERENCES `Weight` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Track`
--
ALTER TABLE `Track`
  ADD CONSTRAINT `Track_ibfk_2` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TrackDetails`
--
ALTER TABLE `TrackDetails`
  ADD CONSTRAINT `TrackDetails_ibfk_2` FOREIGN KEY (`StatusID`) REFERENCES `Status` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TrackDetails_ibfk_1` FOREIGN KEY (`TackID`) REFERENCES `Track` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `Users_ibfk_1` FOREIGN KEY (`UserRoleID`) REFERENCES `UserRoles` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
