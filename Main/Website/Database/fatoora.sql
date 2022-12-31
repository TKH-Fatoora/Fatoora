-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2022 at 02:55 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fatoora`
--
CREATE DATABASE IF NOT EXISTS `fatoora` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fatoora`;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `exID` int(100) NOT NULL,
  `UserID` int(100) NOT NULL,
  `date` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `note` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`exID`, `UserID`, `date`, `method`, `category`, `name`, `amount`, `note`, `image`) VALUES
(14, 0, '2022-11-07', 'debit', 'health', 'Sharaky', 0, 'd', 'none.jpg'),
(15, 0, '2022-11-07', 'credit', 'selfdevelopment', 'name', 0, 'cd', 'name.jpg'),
(16, 9, '2022-11-06', 'cash', 'food', 'Tabali', 0, 'Fries', 'none.jpg'),
(17, 9, '2022-11-03', 'prepaid', 'food', 'Mcdonalds', 0, 'ice cream', 'none.jpg'),
(18, 9, '2022-11-03', 'prepaid', 'food', 'pick n pack', 0, 'pizza', 'none.jpg'),
(19, 9, '2022-11-08', 'credit', 'shopping', 'H&M', 0, 't-shirt', 'none.jpg'),
(20, 10, '2022-11-08', 'debit', 'coffee', 'starbucks', 23242.11, 'latte', 'none.jpg'),
(21, 9, '2022-11-08', 'other', 'selfdevelopment', 'diwan', 0, 'all the bright places', 'none.jpg'),
(22, 9, '2022-11-08', 'debit', 'shopping', 'idk', 0, 'oh no', 'none.jpg'),
(23, 10, '2022-11-07', 'cash', 'shopping', 'waw', 0, 'a', 'none.jpg'),
(24, 9, '2022-11-06', 'credit', 'coffee', 'vdf', 0, 'dgag', 'none.jpg'),
(26, 9, '2022-11-03', 'other', 'entertainment', 'test', 123, '', 'none.jpg'),
(27, 9, '2022-11-01', 'prepaid', 'selfdevelopment', 'book', 56, 'abc', 'none.jpg'),
(29, 9, '2022-11-04', 'debit', 'other', 'nour', 34, '', 'none.jpg'),
(30, 9, '2022-12-02', 'credit', 'entertainment', 'name', 89, '', 'none.jpg'),
(31, 9, '2022-11-24', 'credit', 'transportation', 'hcg', 89, '', 'none.jpg'),
(32, 9, '2022-11-27', 'cash', 'food', 'n', 1234, '', 'none.jpg'),
(33, 11, '2022-03-02', 'credit', 'transportation', 'Uber', 150, 'From Home To Uni', 'Uber.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `MessageID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`MessageID`, `email`, `subject`, `content`, `UserID`) VALUES
(1, 'v', 'v', '', 1),
(2, 'v', 'v', 'v', 1),
(3, 'nour', 'f', 's', 1);

-- --------------------------------------------------------

--
-- Table structure for table `secalerts`
--

CREATE TABLE `secalerts` (
  `AlertID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Content` varchar(255) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Severity` int(11) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `secalerts`
--

INSERT INTO `secalerts` (`AlertID`, `UserID`, `Content`, `Category`, `Severity`, `TimeStamp`) VALUES
(1, 19, '4 Failed Login Attempts Were Captured On The Account a23basem@gmail.com', 'Login', 1, '2022-12-31 13:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `type` varchar(100) NOT NULL DEFAULT 'user',
  `2fa` varchar(255) NOT NULL,
  `QR` int(11) NOT NULL DEFAULT 0,
  `VOTP` int(11) NOT NULL,
  `Verified` int(11) NOT NULL DEFAULT 0,
  `FailedLogin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `name`, `email`, `password`, `birthdate`, `type`, `2fa`, `QR`, `VOTP`, `Verified`, `FailedLogin`) VALUES
(7, 'nour', 'n.sharaky@outlook.com', 'ccbc1770bb10486495d127a7d65c252b', '2022-11-07', 'user', '', 0, 0, 0, 0),
(8, 'nour', 'user@gmail.com', 'ee11cbb19052e40b07aac0ca060c23ee', '2022-11-07', 'user', '', 0, 0, 0, 0),
(9, 'nour', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', '2022-11-08', 'user', 'GM2FBZOWUTQ6MRD3', 0, 0, 0, 0),
(10, 'ahmed', 'a@a.com', '0cc175b9c0f1b6a831c399e269772661', '2022-11-08', 'admin', 'BTJHDRG73DQDIUFL', 0, 0, 0, 0),
(19, 'Ahmed Basem', 'a23basem@gmail.com', '187ef4436122d1cc2f40dc2b92f0eba0', '2003-02-23', 'user', 'I4U66HX37ISQ4YE5', 1, 0, 1, 4),
(21, 'Ahmed Basem', 'ahmedbasemegy@gmail.com', '0cc175b9c0f1b6a831c399e269772661', '2003-03-23', 'user', '', 0, 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`exID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`MessageID`);

--
-- Indexes for table `secalerts`
--
ALTER TABLE `secalerts`
  ADD PRIMARY KEY (`AlertID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `exID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `secalerts`
--
ALTER TABLE `secalerts`
  MODIFY `AlertID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
