-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2023 at 11:07 PM
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
(34, 33, '2023-01-03', 'credit', 'transportation', 'Uber', 230, 'Rehab > TKH', 'none.jpg');

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
(1089, 32, 'No CSRF Token in Use to Access page: Admin Users ', 'Insufficent Access', 3, '2023-01-02 21:31:48'),
(1090, 32, 'No CSRF Token in Use to Access page: Admin Users ', 'Insufficent Access', 3, '2023-01-02 21:32:06'),
(1091, 33, 'Unauthorized Access to Admin Users pasge Was Attempted', 'Insufficent Access', 2, '2023-01-02 21:37:14'),
(1092, 33, 'No CSRF Token in Use to Access page: Admin Users ', 'Insufficent Access', 3, '2023-01-02 21:37:14'),
(1093, 33, 'Unauthorized Access to Admin Users pasge Was Attempted', 'Insufficent Access', 2, '2023-01-02 21:37:55'),
(1094, 32, 'No CSRF Token in Use to Access page: Admin Users ', 'Insufficent Access', 3, '2023-01-02 21:38:30'),
(1095, 32, 'Unauthorized Access to Admin Users pasge Was Attempted', 'Insufficent Access', 2, '2023-01-02 21:46:54'),
(1096, 32, 'No CSRF Token in Use to Access page: Admin Users ', 'Insufficent Access', 3, '2023-01-02 21:46:54'),
(1097, 32, 'Unauthorized Access to Admin Users pasge Was Attempted', 'Insufficent Access', 2, '2023-01-02 21:47:00'),
(1098, 0, 'Unauthorized Access Attempt to Authentication page', 'Insufficent Access', 2, '2023-01-02 21:47:01');

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
  `FailedLogin` int(11) NOT NULL DEFAULT 0,
  `blocked` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `name`, `email`, `password`, `birthdate`, `type`, `2fa`, `QR`, `VOTP`, `Verified`, `FailedLogin`, `blocked`) VALUES
(32, 'Nour Sharaky', 'Ns00149@tkh.edu.eg', '3438663f0c7474dd81ac867f87a07e5b', '2003-06-27', 'admin', 'ZRWYSHKBX3V34FYA', 1, 0, 1, 0, 0),
(33, 'Ahmed Basem', 'AA00188@tkh.edu.eg', '882538dd22ee34b24e8b677f4d37032a', '2003-03-23', 'security', 'ZYHIUJNSNXAJKSCI', 1, 0, 1, 0, 0),
(34, 'Ahmed Nader', 'AH00355@tkh.edu.eg', 'b499986e2dd1642db8828243938d179c', '2003-06-11', 'employee', 'TZBQ5UYKJ7NPOZCM', 1, 0, 1, 0, 0),
(35, 'Ziad Amin', 'ZA00056@tkh.edu.eg', '3404681cf0d61715d7914300bc8bb1cc', '2003-01-26', 'user', 'PS6CIZWTKATDWXWD', 1, 0, 1, 1, 0);

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
  MODIFY `exID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `secalerts`
--
ALTER TABLE `secalerts`
  MODIFY `AlertID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1099;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
