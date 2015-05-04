-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2010 at 05:58 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `p_id` smallint(8) NOT NULL,
  `c_id` smallint(8) NOT NULL AUTO_INCREMENT,
  `u_id` smallint(8) NOT NULL,
  `c_text` varchar(1000) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`p_id`, `c_id`, `u_id`, `c_text`) VALUES
(3, 10, 2, 'Cras pretium metus neque. Nam auctor est ut elit commodo facilisis. Sed vitae dui vitae augue dignissim convallis. Integer vehicula gravida felis, et vehicula libero convallis eget. Mauris neque mauris, lacinia non molestie venenatis, dignissim at dolor.'),
(19, 38, 1, 'Donec vitae ligula at purus mattis tincidunt. Nulla semper nunc quis nisi varius mattis. Morbi non placerat elit. Nullam luctus venenatis ligula in rutrum. In ipsum nisl, eleifend non varius sed, porta non justo. Sed nulla magna, pellentesque sit amet viverra scelerisque, vestibulum sit amet dui. Ut vitae sem vitae ligula bibendum faucibus nec sed nisi. Sed ac quam eget neque fringilla ullamcorper. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean vitae consectetur justo. Cras egestas ornare arcu vel tristique. Nunc viverra blandit erat, vel vehicula eros rhoncus in. '),
(19, 41, 1, 'one more comment'),
(19, 35, 1, 'In volutpat feugiat purus, a hendrerit risus placerat ac. Sed dapibus leo at mi rutrum tempus ac eget mi. Phasellus laoreet blandit urna molestie convallis. Sed laoreet posuere varius. Quisque semper accumsan tellus, et sagittis nibh commodo id. Suspendisse aliquet vehicula viverra. Nam facilisis velit in libero pharetra ut ullamcorper turpis aliquam. Aenean diam mi, laoreet nec auctor et, elementum eu mi. Duis eget sollicitudin velit. Nullam nibh lacus, ullamcorper vel interdum id, auctor non est. Curabitur viverra sem id massa aliquam aliquet. ');
