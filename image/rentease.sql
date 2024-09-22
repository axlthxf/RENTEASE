-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 05:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentease`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `user_type`) VALUES
('aaa@jajaj', 'aaaa', 0),
('abitha@gmail.com', 'abitha1234', 3),
('adil@gmail.com', '4567', 1),
('althaf@gmail.com', 'asw', 1),
('althafjamal035@gmail.com', '2255', 0),
('anandhu@gmail.com', 'asd', 0),
('anjali@gmail.com', '1234', 1),
('as@gmail.com', '3456', 0),
('famis@gmail.com', '121', 0),
('jamal@gmail.com', '0909', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phno` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `usertype` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `phno`, `email`, `password`, `status`, `usertype`) VALUES
(1, 'Abitha ck', '9744961489', 'abitha@gmail.com', 'abitha1234', 'active', 'admin'),
(6, 'Althaf Jamal', '0755882048', 'althafjamal035@gmail.com', '1111', 'active', 'User'),
(8, 'anandhu', '12456', 'anandhu@gmail.com', 'asd', 'active', 'User'),
(10, 'althaf', '1234578a', 'althaf@gmail.com', 'asw', 'active', 'Owner'),
(11, 'aaa', 'aaa', 'aaa@jajaj', 'aaaa', 'inactive', 'User'),
(13, 'famis', '234567890', 'famis@gmail.com', '121', 'inactive', 'User'),
(15, 'asd', '2345645', 'as@gmail.com', '3456', 'inactive', 'User'),
(16, 'anjali', '123456789', 'anjali@gmail.com', '1234', 'active', 'Owner'),
(18, 'adhil', '78945612', 'adil@gmail.com', '4567', 'active', 'Owner'),
(19, 'jamal', '0974496148', 'jamal@gmail.com', '0909', 'active', 'Owner');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
