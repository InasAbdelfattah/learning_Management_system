-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 12, 2016 at 10:30 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `image`, `created_at`, `category_id`, `is_active`) VALUES
(1, 'Open Source DP.', 'course-1.jpg', '0000-00-00 00:00:00', 0, 1),
(2, 'E-Learning DP.', 'course-2.jpg', '0000-00-00 00:00:00', 0, 1),
(3, 'Java DP.', 'course-3.jpg', '0000-00-00 00:00:00', 0, 0),
(4, 'System Development DP.', 'course-single.jpg', '0000-00-00 00:00:00', 0, 0),
(7, 'Zend', 'zend.png', '0000-00-00 00:00:00', 4, 1),
(8, 'Laravel', 'notice.jpg', '2016-05-10 21:51:09', 1, 1),
(9, 'Ruby', 'course1.jpg', '2016-05-11 11:06:35', 3, 1);

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
  `image` varchar(255) NOT NULL DEFAULT 'defaultmaterial.png',
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `material_type_id` int(255) unsigned NOT NULL,
  `course_id` int(255) unsigned NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `material_type_id` (`material_type_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`id`, `material_name`, `descib`, `image`, `path`, `created_at`, `updated_at`, `material_type_id`, `course_id`, `is_active`) VALUES
(2, 'zend Fram Work', 'Book of Zend', 'PRINCE-tmagArticle.jpg', 'Zend_Framework_Day1.pdf', '2016-05-10 21:54:39', NULL, 1, 7, 1),
(6, 'my cv ', 'this is my cv', '12190989_1646099602295594_8371255997786664700_n.jpg', 'Ahmed salama CV 2011.2016 .pdf', '2016-05-12 06:19:18', NULL, 1, 9, 0),
(13, 'laravel material', 'this is book on laravel which have content', 'defaultmaterial.png', 'laravel-5-0-documentation.pdf', '2016-05-12 16:48:34', NULL, 1, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `material_types`
--

CREATE TABLE IF NOT EXISTS `material_types` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `material_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `material_types`
--

INSERT INTO `material_types` (`id`, `material_name`, `created_at`) VALUES
(1, 'PDF', '2016-05-09 04:10:00'),
(2, 'Video', '2016-05-08 08:20:00'),
(8, 'TXT', '2016-05-10 21:52:02');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(255) unsigned NOT NULL,
  `course_id` int(255) unsigned DEFAULT NULL,
  `material_id` int(255) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`course_id`,`material_id`),
  KEY `course_id` (`course_id`),
  KEY `material_id` (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `is_active` tinyint(2) NOT NULL DEFAULT '0',
  `is_admin` tinyint(2) NOT NULL DEFAULT '0',
  `is_loged` tinyint(2) NOT NULL DEFAULT '0',
  `last_login` timestamp NULL DEFAULT NULL,
  `joined_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `image`, `signature`, `is_active`, `is_admin`, `is_loged`, `last_login`, `joined_at`, `updated_at`) VALUES
(2, 'abanoub', 'abanoub@gmail.com', 'fff527fb1b92ef4e15d113c40fc0d8f6', '2.jpg', 'Abanoub Todary', 1, 0, 0, NULL, '2016-05-10 14:33:30', '0000-00-00 00:00:00'),
(3, 'Hani Shaker', 'hani@yahoo.com', 'fff527fb1b92ef4e15d113c40fc0d8f6', '3.jpg', 'Hani shaker Elzoghby', 0, 0, 0, NULL, '2016-05-12 09:29:11', '0000-00-00 00:00:00'),
(5, 'Mahmoud Wael', 'mahmoud@yahoo.com', 'fff527fb1b92ef4e15d113c40fc0d8f6', '4.jpg', 'Mahmoud Wael ', 0, 1, 0, NULL, '2016-05-12 09:32:47', '0000-00-00 00:00:00'),
(6, 'Shreif Wahdan', 'shreif@yahoo.com', 'fff527fb1b92ef4e15d113c40fc0d8f6', '5.jpg', 'Shrief Wahdan', 1, 1, 0, NULL, '2016-05-12 09:33:37', '0000-00-00 00:00:00'),
(7, 'ahmed salama2', 'ahmed.salama1679@gmail.com', 'fff527fb1b92ef4e15d113c40fc0d8f6', 'default.png', 'Ahmed Salama , PHP WebDeveloper', 1, 1, 0, NULL, '2016-05-12 17:38:16', '0000-00-00 00:00:00');

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
