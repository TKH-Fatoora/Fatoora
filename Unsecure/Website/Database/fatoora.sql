-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2022 at 10:54 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
(14, 9, '2022-11-07', 'debit', 'health', 'medicine', 200, '', 'none.jpg'),
(15, 9, '2022-11-07', 'credit', 'selfdevelopment', 'course', 1000, 'cd', 'name.jpg'),
(16, 9, '2022-11-06', 'cash', 'food', 'Tabali', 35, 'Fries', 'none.jpg'),
(17, 9, '2022-11-03', 'prepaid', 'food', 'Mcdonalds', 120, 'ice cream', 'none.jpg'),
(18, 9, '2022-11-03', 'prepaid', 'food', 'pick n pack', 246, 'pizza', 'none.jpg'),
(19, 9, '2022-11-08', 'credit', 'shopping', 'H&M', 350, 't-shirt', 'none.jpg'),
(20, 10, '2022-11-08', 'debit', 'coffee', 'starbucks', 78.85, 'latte', 'none.jpg'),
(21, 9, '2022-11-08', 'other', 'selfdevelopment', 'diwan', 250, 'all the bright places', 'none.jpg'),
(23, 10, '2022-11-07', 'cash', 'shopping', 'shoes', 2000, '', 'none.jpg'),
(24, 9, '2022-11-06', 'credit', 'coffee', 'coffee lab', 55, '', 'none.jpg'),
(26, 9, '2022-11-03', 'other', 'entertainment', 'game', 123, '', 'none.jpg'),
(29, 9, '2022-11-04', 'debit', 'other', 'gift', 34, '', 'none.jpg'),
(30, 9, '2022-12-02', 'credit', 'entertainment', 'bowling', 89, '', 'none.jpg'),
(31, 9, '2022-11-24', 'credit', 'transportation', 'uber', 89, '', 'none.jpg'),
(32, 9, '2022-11-27', 'cash', 'food', 'sushi', 350, '', 'none.jpg'),
(33, 11, '2022-11-10', 'cash', 'selfdevelopment', 'E-Learn Security', 400, '', 'E-Learn Security.png'),
(34, 11, '2022-11-10', 'debit', 'coffee', 'Starbucks', 55, '', 'none.jpg'),
(35, 9, '', 'credit', 'transportation', 'r', 123, 'ds', 'none.jpg'),
(36, 9, '2022-11-19', 'cash', 'coffee', 'Starbucks', 70, 'choco', 'none.jpg');

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
(2, 'test@test.com', 'quesion', 'Can i have multiple accounts?', 9),
(3, 'a@a.com', 'wow', 'this webapp is very useful ', 10),
(4, 'test@test.com', 'hi', 'bye', 9),
(6, 'test@test.com', 'Concern', 'Hello World!', 9);

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
  `type` varchar(100) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `name`, `email`, `password`, `birthdate`, `type`) VALUES
(9, 'nour', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', '2022-11-08', 'user'),
(10, 'ahmed', 'a@a.com', '0cc175b9c0f1b6a831c399e269772661', '2022-11-08', 'admin'),
(12, 'adminn', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '2022-11-16', 'admin'),
(13, 'Employee', 'e@e.com', '47e2e8c3fdb7739e740b95345a803cac', '2022-11-19', 'employee');

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
  MODIFY `exID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
