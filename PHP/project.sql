-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2020 at 07:06 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5


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
(71, 'The Thing', 'A human being made of rock like material. the affliction has no cure.', 'reed', '2020-02-10'),
(72, 'rubberbands', 'rubber bands are similar to my powers of stretching and elasticity', 'reed', '2020-02-10'),
(73, 'Testing dummy', 'i am a testing dummy who\'s only purpose is to see if i can fill the fields and see if the information goes to the right location in an appropriate time limit.', 'john', '2020-02-10'),
(74, 'buttercream cake', 'I like buttercream cake i think i do not know all i know is i am to write the generic placeholder template to try and fill the database as quickly as possible', 'john', '2020-02-10'),
(75, 'Cant wait for cake boss season 15', 'cant wait for what buddy is going to make in cake boss season 15 hope its make out of fondunt', 'john', '2020-05-05'),
(76, 'What is a bird', 'No seriously what is a bird i get mixed signals form the internet', 'john', '2020-05-05'),
(77, 'replying test', 'reply to see if your a cool dude', 'Wes', '2020-05-06'),
(78, 'friendship', 'follow me to become my friend', 'Wes', '2020-02-10'),
(79, 'I am X', 'I am user X i will always be X', 'UserX', '2020-05-06'),
(80, 'I am not user Y', 'I am X not Y get it right', 'UserX', '2020-05-06'),
(81, 'I an user Y', 'I am user Y i am Y', 'UserY', '2020-05-06'),
(82, 'I am not User X', 'I am not User X i am Y', 'UserY', '2020-05-06');

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
(74, 'testing'),
(75, 'cake'),
(75, 'cake boss'),
(76, ' internet'),
(76, ' what'),
(76, 'bird'),
(77, ' life'),
(77, 'testing'),
(78, ' positive'),
(78, 'friend'),
(79, 'x'),
(80, 'x'),
(81, 'y'),
(82, 'x');

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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentid`, `sentiment`, `description`, `cdate`, `blogid`, `author`) VALUES
(1, 'negative', 'Why would you even post this it makes no sense', '2020-05-05', 72, 'john'),
(2, 'positive', 'I like the rock man', '2020-05-05', 71, 'john'),
(3, 'negative', 'Then how do you know your a testing dummy or a human who is testing you.', '2020-05-05', 73, 'reed'),
(4, 'negative', 'I\'\'m a fondunt person myself to be honest', '2020-05-05', 74, 'reed'),
(6, 'positive', 'cool post john', '2020-05-06', 73, 'Wes'),
(7, 'positive', 'i also like buttercream cake', '2020-05-06', 74, 'Wes'),
(8, 'positive', 'hey im a cool dude', '2020-05-06', 77, 'john'),
(9, 'positive', 'i want to be your friend', '2020-05-06', 78, 'john'),
(10, 'positive', 'Hello their mr.fantastic', '2020-05-06', 72, 'Wes');

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `leader` varchar(20) NOT NULL,
  `follower` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`leader`, `follower`) VALUES
('astghik', 'aram'),
('halo', 'shadow'),
('halo', 'UserX'),
('light', 'shadow'),
('reed', 'halo'),
('reed', 'john'),
('reed', 'shadow'),
('UserX', 'light'),
('Wes', 'halo'),
('Wes', 'john'),
('Wes', 'reed');

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
('aram', 'aram1234', 'Aram', 'Balayan', 'AramBalayan@gmail.com'),
('astghik', 'astghik1234', 'Astghik', 'Hovhannisyan', 'astghikhovhannisyan@gmail.com'),
('halo', 'stars123', 'reed', 'grabd', 'fasdfasdfasd'),
('john', 'pass1234', 'john', 'doe', 'johndoe@gmail.com'),
('light', 'light1234', 'ligh', 'note', 'light@gmail.com'),
('reed', 'reed1234', 'reed', 'richards', 'fantastic@gmail.com'),
('shadow', 'shadow123', 'sha', 'dow', 'shadow@gmail.com'),
('UserX', 'X12345678', 'x', 'x', 'x@gmail.com'),
('UserY', 'Y12345678', 'Y', 'Y', 'Y@gmail.com'),
('Wes', 'scooby123', 'wes', 'flamenco', 'flamencowes@yahoo.com');

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
  MODIFY `blogid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
