-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2019 at 08:49 PM
-- Server version: 5.7.11-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tourini`
--
CREATE DATABASE IF NOT EXISTS `tourini` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tourini`;

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE IF NOT EXISTS `attractions` (
  `aid` int(10) NOT NULL AUTO_INCREMENT,
  `aname` varchar(20) NOT NULL,
  `longitude` decimal(5,2) DEFAULT NULL,
  `latitude` decimal(5,2) DEFAULT NULL,
  `country` varchar(20) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`aid`, `aname`, `longitude`, `latitude`, `country`) VALUES
(1, 'Eiffel Tower', '48.86', '2.29', 'France');

-- --------------------------------------------------------

--
-- Table structure for table `circles`
--

CREATE TABLE IF NOT EXISTS `circles` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `cname` varchar(15) NOT NULL,
  `in_circle` blob,
  PRIMARY KEY (`cid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `circles`
--

INSERT INTO `circles` (`cid`, `uid`, `cname`, `in_circle`) VALUES
(1, 'DoraNYC', 'strangers', 0x4a6f7368313938392c206e657775736572),
(2, 'thn248', 'classmates', 0x6d69636861656c31393937),
(3, 'thn248', 'random', NULL),
(4, 'thn248', 'new circle', NULL),
(5, 'thn248', '', NULL),
(6, 'thn248', 'new', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `fid` int(10) NOT NULL AUTO_INCREMENT,
  `uid1` varchar(20) NOT NULL,
  `uid2` varchar(20) NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`fid`, `uid1`, `uid2`) VALUES
(1, 'DoraNYC', 'Josh1989'),
(2, 'Josh1989', 'DoraNYC'),
(3, 'michael1997', 'thn248'),
(4, 'thn248', 'michael1997');

-- --------------------------------------------------------

--
-- Table structure for table `friend_req`
--

CREATE TABLE IF NOT EXISTS `friend_req` (
  `rid` int(10) NOT NULL AUTO_INCREMENT,
  `uid1` varchar(20) NOT NULL,
  `uid2` varchar(20) NOT NULL,
  `req_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `req_resp` varchar(3) DEFAULT 'na',
  PRIMARY KEY (`rid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `friend_req`
--

INSERT INTO `friend_req` (`rid`, `uid1`, `uid2`, `req_date`, `req_resp`) VALUES
(1, 'newuser', 'michael1997', '2016-03-01 11:48:00', 'yes'),
(2, 'michael1997', 'newuser', '2016-03-01 11:48:00', 'na');

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE IF NOT EXISTS `photo` (
  `pid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `file_path` varchar(100) NOT NULL,
  `ptime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `longitude` decimal(5,2) DEFAULT NULL,
  `latitude` decimal(5,2) DEFAULT NULL,
  `view_opt` varchar(20) NOT NULL DEFAULT 'public',
  PRIMARY KEY (`pid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `photo`
--

INSERT INTO `photo` (`pid`, `uid`, `file_path`, `ptime`, `longitude`, `latitude`, `view_opt`) VALUES
(1, 'DoraNYC', 'image1.png', '2016-04-25 14:30:00', NULL, NULL, 'public'),
(2, 'thn248', 'myimg.png', '2016-04-25 15:00:00', '40.71', '74.01', 'friends'),
(3, 'thn248', 'user_photos/thn248/12899763_1011180458927609_1665210422_n.jpg', '2016-05-16 11:09:00', '20.00', '20.00', 'public');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `postid` int(10) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) NOT NULL,
  `message` varchar(140) NOT NULL,
  `timestp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `add_loc` varchar(3) DEFAULT 'no',
  PRIMARY KEY (`postid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postid`, `uid`, `message`, `timestp`, `add_loc`) VALUES
(1, 'newuser', 'Just made an account.', '2016-03-01 11:40:00', 'no'),
(2, 'DoraNYC', 'Good morning!', '2016-04-25 09:00:00', 'no'),
(3, 'michael1997', 'Planning to travel to France this summer.', '2016-04-25 15:10:35', 'yes'),
(4, 'Josh1989', 'The train is late today.', '2016-04-25 15:20:30', 'yes'),
(5, 'DoraNYC', 'No R train again.', '2016-04-25 15:20:30', 'yes'),
(6, 'thn248', 'Hello World', '2016-05-16 09:48:52', 'yes'),
(7, 'thn248', 'Who is in New York today?', '2016-05-16 09:50:48', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `profile` varchar(140) DEFAULT NULL,
  `curr_long` decimal(5,2) DEFAULT NULL,
  `curr_lat` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `profile`, `curr_long`, `curr_lat`) VALUES
('', '', '', NULL, NULL, NULL),
('admin', 'administrator', 'admin01', NULL, NULL, NULL),
('DoraNYC', 'DoraNYC', 'Dora888', 'Hello', NULL, NULL),
('Josh1989', 'Josh1989', 'joshatnyu', 'Hi, my name is Josh', '48.00', '2.00'),
('michael1997', 'Michael', 'random', 'Hello. My name is Michael.', '41.00', '74.01'),
('newuser', 'francis', 'xyzcordinate', 'Random friend requests are welcome.', '46.00', '1.00'),
('sandy', 'tes', '12superuser', NULL, NULL, NULL),
('tester', 'site-tester', '12345', NULL, NULL, NULL),
('thn248', 'LilyNg', 'cs3083', 'hello', '41.00', '74.00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `circles`
--
ALTER TABLE `circles`
  ADD CONSTRAINT `circles_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
