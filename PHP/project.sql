-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2020 at 11:02 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--
CREATE DATABASE IF NOT EXISTS `project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `project`;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--
DROP TABLE IF EXISTS `blogstags`;
DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `follows`;
DROP TABLE IF EXISTS `blogs`;
DROP TABLE IF EXISTS `hobbies`;
DROP TABLE IF EXISTS `users`;
CREATE TABLE `blogs` (
  `blogid` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `postuser` varchar(20) NOT NULL,
  `pdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`blogid`, `subject`, `description`, `postuser`, `pdate`) VALUES
(71, 'The Thing', 'A human being made of rock like material. the affliction has no cure.', 'reed', '2020-04-27'),
(72, 'rubberbands', 'rubber bands are similar to my powers of stretching and elasticity', 'reed', '2020-04-27'),
(73, 'Testing dummy', 'i am a testing dummy who\'s only purpose is to see if i can fill the fields and see if the information goes to the right location in an appropriate time limit.', 'john', '2020-04-27'),
(74, 'buttercream cake', 'I like buttercream cake i think i do not know all i know is i am to write the generic placeholder template to try and fill the database as quickly as possible', 'john', '2020-04-27');

-- --------------------------------------------------------

--
-- Table structure for table `blogstags`
--


CREATE TABLE `blogstags` (
  `blogid` int(11) NOT NULL,
  `tag` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogstags`
--

INSERT INTO `blogstags` (`blogid`, `tag`) VALUES
(71, 'cure'),
(71, 'geology'),
(71, 'rocks'),
(71, 'Thing'),
(72, 'elastic'),
(72, 'mr.fantasic'),
(72, 'rubbery'),
(73, 'dummy'),
(73, 'life'),
(73, 'testing'),
(74, 'cake'),
(74, 'dummy'),
(74, 'testing');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--


CREATE TABLE `comments` (
  `commentid` int(11) NOT NULL,
  `sentiment` varchar(20) NOT NULL,
  `description` varchar(250) NOT NULL,
  `cdate` date NOT NULL,
  `blogid` int(11) NOT NULL,
  `author` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--


CREATE TABLE `follows` (
  `leader` varchar(20) NOT NULL,
  `follower` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hobbies`
--


CREATE TABLE `hobbies` (
  `username` varchar(20) NOT NULL,
  `hobby` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--


CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `firstname`, `lastname`, `email`) VALUES
('john', 'pass1234', 'john', 'doe', 'johndoe@gmail.com'),
('reed', 'reed1234', 'reed', 'richards', 'fantastic@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`blogid`),
  ADD KEY `postuser` (`postuser`);

--
-- Indexes for table `blogstags`
--
ALTER TABLE `blogstags`
  ADD PRIMARY KEY (`blogid`,`tag`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentid`),
  ADD KEY `blogid` (`blogid`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`leader`,`follower`),
  ADD KEY `follower` (`follower`);

--
-- Indexes for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD PRIMARY KEY (`username`,`hobby`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `blogid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`postuser`) REFERENCES `users` (`username`);

--
-- Constraints for table `blogstags`
--
ALTER TABLE `blogstags`
  ADD CONSTRAINT `blogstags_ibfk_1` FOREIGN KEY (`blogid`) REFERENCES `blogs` (`blogid`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`blogid`) REFERENCES `blogs` (`blogid`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`author`) REFERENCES `users` (`username`);

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`leader`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`follower`) REFERENCES `users` (`username`);

--
-- Constraints for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD CONSTRAINT `hobbies_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
