-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 21, 2012 at 06:06 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test_fb_app_gamekey`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `create_at` int(10) unsigned NOT NULL,
  `update_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`, `username`, `password`, `create_at`, `update_at`) VALUES
(1, 'admin', '7c222fb2927d828af22f592134e8932480637c0d', 1329295186, 1335863466);

-- --------------------------------------------------------

--
-- Table structure for table `key`
--

DROP TABLE IF EXISTS `key`;
CREATE TABLE IF NOT EXISTS `key` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `facebook_user_id` varchar(20) NOT NULL,
  `facebook_username` varchar(50) NOT NULL,
  `facebook_post_id` varchar(80) NOT NULL,
  `lock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_at` int(10) unsigned NOT NULL,
  `update_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `key`
--

INSERT INTO `key` (`id`, `code`, `facebook_user_id`, `facebook_username`, `facebook_post_id`, `lock`, `create_at`, `update_at`) VALUES
(1, '123-123-123-123', '1', '2', '3', 1, 0, 0),
(2, '456-456-456-456', '', '', '', 1, 1335786750, 1335786758),
(3, '789-789-789-789', '', '', '', 1, 1335787418, 1335787425);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`name`, `content`) VALUES
('app_id', '1234567891011121'),
('title', 'May be ..?'),
('link', 'http://google.com/ncr'),
('picture', 'http://www.danielmorlock.de/wp-content/uploads/2011/12/github-logo-300x300.png'),
('caption', 'What you see is what you get!'),
('description', 'This is content, This is content agian! Check it out!');
