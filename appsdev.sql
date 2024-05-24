-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 04:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appsdev`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL,
  `givenname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `role`, `status`, `givenname`, `middlename`, `surname`, `email`, `username`, `password`, `gender`, `birthdate`, `token`) VALUES
(1, 'admin', 1, 'Mharck Justin Gil', 'Narciso', 'Carumba', 'carumba878@gmail.com', 'admin', '$2y$10$7mPIdfhZjJ8HnrmTTDEPzeGqu68D5ZXbTBOtuJ2M.buqDOdBH2aB2', 'Male', '2002-10-09', '');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `unitname` varchar(255) NOT NULL,
  `unitno` int(255) NOT NULL,
  `status` int(11) NOT NULL,
  `unitposition` varchar(255) NOT NULL,
  `unitprice` int(255) NOT NULL,
  `unittype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unitname`, `unitno`, `status`, `unitposition`, `unitprice`, `unittype`) VALUES
(1, 'mharck', 1, 1, 'Bay Side', 100000, 'One Bed Room');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL,
  `givenname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contactnumber` bigint(21) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `status`, `givenname`, `middlename`, `surname`, `email`, `username`, `password`, `contactnumber`, `birthdate`, `gender`, `token`) VALUES
(1, 'user', 1, 'Hannah', 'Vino', 'Sameon', 'hannah@gmail.com', 'hannah', '$2y$10$IMXCM1oQGjpHZMBxEBgeveD8CxXz.H3BPiKojZyjhWGFm6cGEX/WS', 9955650956, '2003-03-29', 'Female', ''),
(2, 'user', 1, 'Mharck Justin Gil', 'Narciso', 'Carumba', 'carumba878@gmail.com', 'Craby', '$2y$10$cjaq/1UwtbFqaIeE1U.0xuqY.NfJ6oe54pA9M852CK5ICiCPHzqAG', 9959332743, '2002-10-09', 'Male', ''),
(3, 'user', 1, 'Nihemai', 'Nihemai', 'Nihemai', 'nihemai@gmail.com', 'nihemai', '$2y$10$JDmzwfzXSnab8WN2f/n1CekK3YM8SAulbhbrKVn3SdFDZNHPBsGsa', 12312312312, '2002-10-09', 'Male', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
