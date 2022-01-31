-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2022 at 02:29 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_homeseek`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `acc_id` int(11) NOT NULL,
  `acc_email` varchar(50) NOT NULL,
  `acc_password` mediumtext NOT NULL,
  `acc_fname` varchar(50) NOT NULL,
  `acc_lname` varchar(50) NOT NULL,
  `acc_phone` varchar(11) NOT NULL,
  `acc_role` int(1) NOT NULL,
  `acc_verified` int(1) NOT NULL DEFAULT 0,
  `acc_otp` varchar(6) NOT NULL,
  `acc_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`acc_id`, `acc_email`, `acc_password`, `acc_fname`, `acc_lname`, `acc_phone`, `acc_role`, `acc_verified`, `acc_otp`, `acc_createdAt`) VALUES
(1, 'mallarim003@gmail.com', '$2y$10$MzhjNDUyNzEyNWZiOWQzNuqSSUOroDX074BQ9L9PBu31oP4IU.Ibu', 'Marv', 'Iramms', '09165227437', 1, 1, '906096', '2021-07-26 14:03:38'),
(4, 'whatss21@gmail.com', '$2y$10$NGQyNDk2NTAwZWRhYzA2YeM4XyjCUUN9wAxWZvfnOiRfnGh96Dw46', 'DJ', 'Tadeo', '09079488197', 0, 1, '715099', '2021-07-27 17:34:36'),
(7, 'hezzy@gmail.com', '$2y$10$NDkxOTEyYzczMmY1MWFjNuyM/cQRgMn5aS2tyw/U1SCY8YeV5cdFi', 'Sample', 'Admin', '09152558565', 2, 0, '530934', '2021-07-29 21:32:39'),
(12, 'wew7@gmail.com', '$2y$10$YTRiOTAzMWFlM2NiZTQ4NOr9hEhvwtANq0HvGsHodEvV5e8QuDkEW', 'rams', 'Sample', '09165227437', 1, 0, '933615', '2021-08-01 14:19:36'),
(13, 'test@gmail.cocm', '$2y$10$NzdlMGJhNjJlMjU5ZjRhZ.QCXHaywb6juvOIw6qBTwlx7DXOq1Z1u', '', '', '', 1, 0, '128503', '2021-08-01 14:24:27'),
(14, 'test@gmail.com', '$2y$10$MTcwYThiNjM3MzY5YmZiZOxliD.EA0rAFRa1fpyVwV7F8WkUVF.22', '', '', '', 1, 0, '625092', '2021-08-01 14:25:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(14) NOT NULL,
  `userid` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `full_name` varchar(500) NOT NULL,
  `user_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `userid`, `password`, `full_name`, `user_type`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin Name []', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment`
--

CREATE TABLE `tbl_appointment` (
  `app_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `prop_id` int(11) NOT NULL,
  `app_date` date NOT NULL,
  `app_time` varchar(80) NOT NULL,
  `app_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_appointment`
--

INSERT INTO `tbl_appointment` (`app_id`, `acc_id`, `prop_id`, `app_date`, `app_time`, `app_status`) VALUES
(2, 4, 2, '2021-08-15', '2021-07-28T07:45:02.164+08:00', 0),
(3, 4, 3, '2021-08-25', '2021-07-28T19:30:20.442+08:00', 2),
(4, 4, 1, '2021-07-31', '2021-07-28T10:00:41.836+08:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property`
--

CREATE TABLE `tbl_property` (
  `prop_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `prop_isForRent` int(1) NOT NULL,
  `prop_name` varchar(50) NOT NULL,
  `prop_description` text NOT NULL,
  `prop_price` int(11) NOT NULL,
  `prop_address` varchar(150) NOT NULL,
  `prop_image` longtext NOT NULL,
  `prop_status` int(1) NOT NULL DEFAULT 0,
  `prop_createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_property`
--

INSERT INTO `tbl_property` (`prop_id`, `acc_id`, `type_id`, `prop_isForRent`, `prop_name`, `prop_description`, `prop_price`, `prop_address`, `prop_image`, `prop_status`, `prop_createdAt`) VALUES
(1, 1, 3, 0, 'Apartment Apart', 'Fully Furnish, \n2 Bedrooms,\n1 CR,\nSpacious Lounge', 7000, 'Sta Rita Soriano Street 187', '', 2, '2021-07-26 16:40:06'),
(2, 1, 1, 0, 'Bed Spacer', 'Live with an bedspace female only!', 1000, 'Barreto Olongapo City', '', 4, '2021-07-26 17:02:37'),
(3, 1, 4, 1, 'New Build House', '1 Bedroom\nSpacious Lounge\n1 Kitchen Sink\n1 Bathroom\nSmall Garage Outside', 800000, 'Mabayuan Otero ', '', 1, '2021-07-27 16:02:37'),
(4, 1, 2, 0, 'asd', 'asd', 1500, 'asd', '', 3, '2021-07-27 16:25:38'),
(5, 1, 2, 0, 'teasd', 'qweqwe', 500, 'qewqwe', '', 3, '2021-07-27 16:33:06'),
(6, 1, 4, 0, 'test', 'qweas', 5000, 'qweqweasd', '', 3, '2021-07-28 11:22:47'),
(8, 1, 4, 1, 'trest', 'test', 500, 'tesasd', 'data:image/png;base64,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', 1, '2021-07-31 16:14:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saves`
--

CREATE TABLE `tbl_saves` (
  `save_id` int(11) NOT NULL,
  `prop_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `save_status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_saves`
--

INSERT INTO `tbl_saves` (`save_id`, `prop_id`, `acc_id`, `save_status`) VALUES
(3, 1, 4, 1),
(4, 2, 4, 0),
(5, 3, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_type`
--

CREATE TABLE `tbl_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_type`
--

INSERT INTO `tbl_type` (`type_id`, `type_name`) VALUES
(1, 'Bed Space'),
(2, 'Room'),
(3, 'Apartment'),
(4, 'House'),
(5, 'Two Storey House');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `tbl_property`
--
ALTER TABLE `tbl_property`
  ADD PRIMARY KEY (`prop_id`);

--
-- Indexes for table `tbl_saves`
--
ALTER TABLE `tbl_saves`
  ADD PRIMARY KEY (`save_id`);

--
-- Indexes for table `tbl_type`
--
ALTER TABLE `tbl_type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_property`
--
ALTER TABLE `tbl_property`
  MODIFY `prop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_saves`
--
ALTER TABLE `tbl_saves`
  MODIFY `save_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_type`
--
ALTER TABLE `tbl_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
