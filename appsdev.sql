-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 02:09 PM
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
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `bannerTitle` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `description`, `price`, `imagePath`, `bannerTitle`) VALUES
(30, 'Banner', 'Welcome to Pang-Kape Apartment, a luxury haven that combines sophistication with comfort in a scenic setting. Each unit within Pang-Kape has been meticulously designed to meet the standards of modern living, creating a home that offers both style and convenience. Surrounded by lush greenery and panoramic views, this apartment complex is an oasis of calm in the heart of urban living. From exquisite interiors to top-tier amenities, Pang-Kape Apartment redefines apartment living with elegance and functionality. Discover the luxury of space, where every detail is crafted to elevate your lifestyle and enhance your daily experience.', 0, 'uploads/apartment.jpg', 'Pang-Kape Apartment'),
(31, 'Studio Unit', 'The Studio Unit is a compact yet beautifully designed space, ideal for those who value simplicity without compromising style. With an open layout that seamlessly integrates the living area, kitchen, and bathroom, this unit offers everything you need within a cozy space. Priced affordably, the Studio Unit combines functionality and charm, making it a perfect choice for minimalist living.', 200000, 'uploads/2bedcr.jpg', 'Pang-Kape Apartment'),
(32, 'One Bed', 'The One-Bed Unit provides a more spacious option with separate living and bedroom areas, ideal for professionals or couples. Featuring large windows that fill the space with natural light, this unit offers a bright, welcoming environment. With premium finishes and a well-thought-out layout, the One-Bed Unit is a stylish choice for those seeking a balance of space and comfort.', 400000, 'uploads/1bedlb.jpg', 'Pang-Kape Apartment'),
(33, 'Two Bed', 'Designed for families or those needing extra space, the Two-Bed Unit offers ample room and privacy. The expansive living area, coupled with a modern kitchen and well-appointed bathrooms, makes it a perfect choice for comfortable living. With sweeping views from every angle, this unit combines luxury and practicality, setting a new standard in apartment living.', 600000, 'uploads/1bedkitchen.jpg', 'Pang-Kape Apartment');

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
  `unittype` varchar(255) NOT NULL,
  `acquired_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unitname`, `unitno`, `status`, `unitposition`, `unitprice`, `unittype`, `acquired_by`) VALUES
(1, 'mharck', 1, 1, 'Bay Side', 100000, 'One Bed Room', NULL),
(2, 'one bed', 10, 1, 'Bay Side', 10000, 'Studio Unit', NULL),
(3, 'asdasd', 11, 0, 'Lobby Side', 10000, 'Studio Unit', 1),
(4, 'craby', 13, 0, 'Bay Side', 20000, 'One Bed Room', 1),
(5, 'craby', 19, 0, 'High-Way Side', 20000, 'One Bed Room', 1),
(6, 'Kent', 1234, 1, 'Bay Side', 20000, 'One Bed Room', NULL);

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
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

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
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
