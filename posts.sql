-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 23, 2010 at 05:59 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `p_id` smallint(8) NOT NULL AUTO_INCREMENT,
  `p_header` varchar(30) NOT NULL,
  `p_date` date NOT NULL,
  `p_text` varchar(30000) CHARACTER SET ucs2 COLLATE ucs2_lithuanian_ci NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`p_id`, `p_header`, `p_date`, `p_text`) VALUES
(19, 'Absolutely New Post', '2010-03-22', 'In volutpat feugiat purus, a hendrerit risus placerat ac. Sed dapibus leo at mi rutrum tempus ac eget mi. Phasellus laoreet blandit urna molestie convallis. Sed laoreet posuere varius. Quisque semper accumsan tellus, et sagittis nibh commodo id. Suspendisse aliquet vehicula viverra. Nam facilisis velit in libero pharetra ut ullamcorper turpis aliquam. '),
(3, 'Second Post', '2010-03-07', 'Nullam mauris nisi, tristique quis fermentum rhoncus, laoreet a eros. Nullam sit amet orci dui. Mauris id dui dolor, ac congue sem. Nunc id lacinia turpis. Pellentesque vulputate iaculis justo, eget venenatis mi fermentum vitae. Phasellus et arcu vel leo adipiscing elementum iaculis at dui. ');
