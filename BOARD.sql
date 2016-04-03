-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2016 at 03:29 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `LARM`
--

-- --------------------------------------------------------

--
-- Table structure for table `BOARD`
--

CREATE TABLE IF NOT EXISTS `BOARD` (
  `BOARD_NUM` int(5) NOT NULL COMMENT 'Primary Key',
  `PLAYERX` varchar(20) NOT NULL COMMENT 'USERID FK',
  `PLAYERO` varchar(20) NOT NULL COMMENT 'USERID FK',
  `CELLA1` char(1) DEFAULT NULL COMMENT 'X, O, or Null',
  `CELLB1` char(1) DEFAULT NULL COMMENT 'X, O, or Null',
  `CELLC1` char(1) DEFAULT NULL COMMENT 'X, O, or Null',
  `CELLA2` char(1) DEFAULT NULL COMMENT 'X, O, or Null',
  `CELLB2` char(1) DEFAULT NULL COMMENT 'X, O, or Null',
  `CELLC2` char(1) DEFAULT NULL COMMENT 'X, O, or Null',
  `CELLA3` char(1) DEFAULT NULL COMMENT 'X, O, or Null',
  `CELLB3` char(1) DEFAULT NULL COMMENT 'X, O, or Null',
  `CELLC3` char(1) DEFAULT NULL COMMENT 'X, O, or Null',
  `TURN` varchar(20) NOT NULL COMMENT 'USERID'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BOARD`
--
ALTER TABLE `BOARD`
  ADD PRIMARY KEY (`BOARD_NUM`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `BOARD`
--
ALTER TABLE `BOARD`
  MODIFY `BOARD_NUM` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
