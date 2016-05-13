-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2016 at 03:59 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(500) NOT NULL,
  `user_id` int(255) unsigned NOT NULL,
  `material_id` int(255) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`material_id`),
  KEY `material_id` (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` int(255) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `image`, `created_at`, `category_id`, `is_active`) VALUES
(1, 'Open Source DP.', '/img/course-1.jpg', '0000-00-00 00:00:00', 0, 1),
(2, 'E-Learning DP.', 'img/course-2.jpg', '0000-00-00 00:00:00', 0, 1),
(3, 'Java DP', 'img/course-3.jpg', '0000-00-00 00:00:00', 0, 0),
(4, 'System Development DP', 'img/course-single.jpg', '0000-00-00 00:00:00', 0, 0),
(5, 'Java SE', 'img/course-3.jpg', '0000-00-00 00:00:00', 3, 1),
(6, 'C#', 'img/course-single.jpg', '0000-00-00 00:00:00', 4, 1),
(7, 'Zend', '/img/zend.png', '0000-00-00 00:00:00', 1, 1),
(8, 'javaScript', '', '2016-05-12 13:32:09', 1, 1),
(9, 'php', '', '2016-05-12 18:41:44', 1, 1),
(10, 'action script', '', '2016-05-12 18:41:44', 2, 1),
(11, 'photoshop', '', '2016-05-12 18:41:44', 2, 1),
(12, 'java EE', '', '2016-05-12 18:41:44', 3, 1),
(13, 'python', '', '2016-05-12 18:41:44', 1, 1),
(14, 'asp .net', '', '2016-05-12 18:41:44', 4, 1),
(15, 'perl', '', '2016-05-12 18:41:44', 1, 1),
(16, 'flash', '', '2016-05-12 18:41:44', 2, 1),
(17, 'sharepoint', '', '2016-05-12 18:41:44', 4, 1),
(18, 'java ME', '', '2016-05-12 18:41:45', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(255) unsigned NOT NULL,
  `material_id` int(255) unsigned NOT NULL,
  `downloaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`material_id`),
  KEY `material_id` (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE IF NOT EXISTS `materials` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `material_name` varchar(100) NOT NULL,
  `descib` varchar(500) NOT NULL,
  `image` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `material_type_id` int(255) unsigned NOT NULL,
  `course_id` int(255) unsigned NOT NULL,
  `is dowelodable` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `material_type_id` (`material_type_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `material_name`, `descib`, `image`, `path`, `created_at`, `material_type_id`, `course_id`, `is dowelodable`) VALUES
(1, 'zend_book.pdf', 'this is pdf that contail main lessons of zend', '/matrials/1.jpg', '', '0000-00-00 00:00:00', 1, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `material_types`
--

CREATE TABLE IF NOT EXISTS `material_types` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `material_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `material_types`
--

INSERT INTO `material_types` (`id`, `material_name`) VALUES
(1, 'PDF'),
(2, 'Video'),
(3, 'e-books');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(255) unsigned NOT NULL,
  `category_id` int(255) NOT NULL,
  `course_id` int(255) unsigned DEFAULT NULL,
  `material_id` int(255) unsigned DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`course_id`,`material_id`),
  KEY `course_id` (`course_id`),
  KEY `material_id` (`material_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `category_id`, `course_id`, `material_id`, `description`, `created_at`, `status`) VALUES
(4, 1, 1, 7, NULL, '', '2016-05-12 21:02:51', 0),
(6, 2, 4, 6, NULL, '', '2016-05-13 00:35:02', 0),
(7, 2, 1, 8, NULL, '', '2016-05-13 00:35:43', 0),
(8, 2, 1, 8, NULL, 'ddddddd', '2016-05-13 00:58:12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  `image` varchar(300) NOT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `is_active` tinyint(2) NOT NULL,
  `is_admin` tinyint(2) NOT NULL,
  `is_loged` tinyint(2) NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `image`, `signature`, `is_active`, `is_admin`, `is_loged`, `joined_at`, `updated_at`) VALUES
(1, 'ahmed salama', 'ahmed.salama1679@gmail.com', 'salama2010', '/userimages/me.jpg', 'Ahmed Salama', 1, 1, 1, '2016-05-09 22:00:00', '2016-05-09 22:00:00'),
(2, 'abeer', 'abeer@gmail.com', 'a2043f16d4c6128dc470bd276f1223fc', '/img/user/944318_10154293752232638_7802700495927173923_n.jpg', 'abeer elhoot', 1, 1, 1, '2016-05-10 22:36:42', '0000-00-00 00:00:00'),
(3, 'abanob', 'abanob@gmail.com', 'a2043f16d4c6128dc470bd276f1223fc', '/img/user/11694159_1529425404028027_1345197886989078743_n.jpg', 'abanob raaft todary', 0, 0, 0, '2016-05-10 22:36:42', '0000-00-00 00:00:00'),
(4, 'ghada', 'ghada@gmail.com', '', '/img/user/13082497_833779043421457_6018319399430910745_n.jpg', 'ghada gamal Dallam', 0, 0, 0, '2016-05-12 23:32:40', '2016-05-12 23:32:40');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE IF NOT EXISTS `views` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(255) unsigned NOT NULL,
  `material_id` int(255) unsigned NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`material_id`),
  KEY `material_id` (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`);

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`);

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `materials_ibfk_1` FOREIGN KEY (`material_type_id`) REFERENCES `material_types` (`id`),
  ADD CONSTRAINT `materials_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `requests_ibfk_3` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`);

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `views_ibfk_2` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
