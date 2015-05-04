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
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `u_id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `u_login` varchar(50) NOT NULL,
  `u_pas` varchar(32) NOT NULL,
  `u_salt` char(3) NOT NULL,
  `u_mail` varchar(20) NOT NULL,
  `u_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `login` (`u_login`),
  UNIQUE KEY `u_mail` (`u_mail`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_login`, `u_pas`, `u_salt`, `u_mail`, `u_active`) VALUES
(1, 'admin', '05a21de29f772ae5be8a0b5931586d9e', 'qw7', 'admin@mail.com', 1),
(2, 'jekaterina', '55048b96cba3f23045b203f9ff38eaac', 'j=3', 'katia@mail.com', 0);
