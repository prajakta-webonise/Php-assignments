-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 20, 2014 at 02:53 PM
-- Server version: 5.5.37
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
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `to_name` varchar(50) NOT NULL,
  `address_line1` tinytext NOT NULL,
  `address_line2` tinytext NOT NULL,
  `city` varchar(25) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `pincode` int(6) NOT NULL,
  `message` tinytext NOT NULL,
  `contact` varchar(13) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `product_id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `weight_id` int(3) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ProductID` (`product_id`,`user_id`,`weight_id`),
  KEY `UserID` (`user_id`),
  KEY `WeightID` (`weight_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`) VALUES
(1, 'Television'),
(2, 'Printer'),
(3, 'Laptop'),
(4, 'Documnets');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `status` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`) VALUES
(1, 'Order is placed.'),
(2, 'Shipment Dispatched'),
(3, 'Shipment Arrived'),
(4, 'Shipment Further Coonected'),
(5, 'Shipment Out For Delivery'),
(6, 'Shipment Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE IF NOT EXISTS `track` (
  `id` varchar(32) NOT NULL,
  `order_id` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `StatusID` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `track_details`
--

CREATE TABLE IF NOT EXISTS `track_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `location` varchar(25) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `track_id` varchar(32) NOT NULL,
  `status_id` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `TackID` (`track_id`,`status_id`),
  KEY `StatusID` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(15) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `address_line1` tinytext NOT NULL,
  `address_line2` tinytext NOT NULL,
  `city` varchar(25) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `pincode` int(6) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact` varchar(13) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_role_id` int(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserRoleID` (`user_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `address_line1`, `address_line2`, `city`, `state`, `country`, `pincode`, `email`, `contact`, `password`, `user_role_id`) VALUES
(3, 'Admin', 'Admin', '', '', '', '', '', 0, 'admin@admin.com', '99999999', '123456', 1),
(4, 'Courier', 'Courier', '', '', '', '', '', 0, 'courier@courier.com', '8888888888', '123456', 2),
(5, 'User', 'User', '', '', '', '', '', 0, 'user@user.com', '99999999', '123456', 3),
(77, 'deepak', 'kabbur', 'subhashnagar', 'belgaum', 'belgaum', 'maharashtra', 'India', 411052, 'deepak.kabbur@weboniselab.com', '9090909090', 'deepak123', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `roles` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `roles`) VALUES
(1, 'Administrator'),
(2, 'Courier'),
(3, 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `weight`
--

CREATE TABLE IF NOT EXISTS `weight` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `from_range` float NOT NULL,
  `to_range` float NOT NULL,
  `price` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `weight`
--

INSERT INTO `weight` (`id`, `from_range`, `to_range`, `price`) VALUES
(1, 0.1, 3, 50),
(2, 3.1, 6, 100),
(3, 6.1, 9, 150),
(4, 9.1, 12, 200),
(5, 10, 10, 20),
(6, 15, 18, 500);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`weight_id`) REFERENCES `weight` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `track`
--
ALTER TABLE `track`
  ADD CONSTRAINT `track_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `track_details`
--
ALTER TABLE `track_details`
  ADD CONSTRAINT `track_details_ibfk_1` FOREIGN KEY (`track_id`) REFERENCES `track` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `track_details_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
