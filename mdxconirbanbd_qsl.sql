-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 09, 2024 at 06:45 PM
-- Server version: 10.6.15-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mdxconirbanbd_qsl`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `callsign` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `comments` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `callsign`, `name`, `address`, `country`, `phone`, `status`, `comments`) VALUES
(1, 'admin', 'admin', 'fahadmieaji@gmail.com', 's21af', 'Abdullah Al Fahad', 'Dhaka', 'Bangladesh', '01675665086', 'active', 'test comments'),
(2, 'admin2', '12345', 'fahadmieaji@gmail.com', 's21af', 'genaral_marketing', 'Kakrail, Dhaka', 'Bangladesh', '01675665086', 'active', 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notices`
--

CREATE TABLE `admin_notices` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(500) NOT NULL,
  `create_date` varchar(100) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_notices`
--

INSERT INTO `admin_notices` (`id`, `title`, `content`, `create_date`) VALUES
(1, 'Test Notice new', 'Welcome to MDXC. this is a new portal', ''),
(2, 'test Notice from web', 'test', '2024-02-17 02:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(200) NOT NULL,
  `event_deteails` varchar(500) NOT NULL,
  `status` varchar(10) NOT NULL,
  `create_date` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_name`, `event_deteails`, `status`, `create_date`, `created_by`) VALUES
(1, 'MDXC reunion', '9 March 2024 - Montichiari (BS)  ITALY @15:30 \r\n', 'active', '2024-02-18 00:23:04', '1'),
(2, 'Test DX in S2 Land', 'jhvu kjbkj', 'active', '2024-02-18 00:23:04', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `call_sign` varchar(10) NOT NULL,
  `email` varchar(220) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(250) NOT NULL,
  `country` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `status` varchar(100) NOT NULL,
  `create_date` varchar(100) NOT NULL DEFAULT current_timestamp(),
  `create_by` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `call_sign`, `email`, `phone`, `address`, `country`, `password`, `status`, `create_date`, `create_by`) VALUES
(1, 'Abdullah Al Fahad', 's21af', 'fahadmieaji@gmail.com', '01675665086', '64/A, Purana Paltan Lane, Kakrail, Dhaka-1000', 'Bangladesh', 'not4all~', 'Active', '', 'admin'),
(2, 'Abdullah Al Fahad two', 's21pl', 'admin@admin.com', '01675665086', '64/A, Purana Paltan', 'Bangladesh', '123456', 'active', '2024-02-07 04:56:42', '1'),
(3, 'Sabbir Ahmed', 'S21ACP', 's21acp@gmail.com', '01675665086', 'Kakrail, Dhaka', 'Bangladesh', '123456', 'active', '2024-02-13 16:41:06', '1'),
(4, 'hemal_rotary', 'S21ACl', 'admin@admin.com', '01675665086', 'Dag-282, East Box Nagar, Sarulia', 'Bangladesh', 'pass1234', 'active', '2024-02-13 17:12:49', '1'),
(5, 'Abdullah Al Fahad 3', 's21pl1', 'admin@onirbanbd.con', '+8801675665086', '64/A, Purana Paltan', 'Bangladesh', '12345', 'active', '2024-02-13 17:14:04', '1'),
(8, 'Abdullah Al Fahad', 'S21ACp/1', 'admin@gmail.com', '01675665086', '64/A, Purana Paltan', 'Bangladesh', '1234', 'active', '2024-03-06 18:03:33', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_adfi_files`
--

CREATE TABLE `user_adfi_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `event_id` varchar(11) NOT NULL,
  `upload_date` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `comments` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_adfi_files`
--

INSERT INTO `user_adfi_files` (`id`, `user_id`, `file_name`, `event_id`, `upload_date`, `status`, `comments`) VALUES
(1, 1, 'it9ssi.adi', '1', '2024-02-05 23:38:59', '1', ''),
(2, 1, 'Test Event DX in BD_it9ssi.adi.bak', '2', '2024-02-06 19:04:24', '1', ''),
(3, 1, 'Test Event DX in BD_it9ssi.adi.bak', '2', '2024-02-06 19:09:57', '1', ''),
(4, 1, 'Test Event DX in BD_it9ssi.adi', '2', '2024-02-06 19:10:14', '1', ''),
(5, 1, 'Test_Event_DX_in_BD_it9ssi.adi', '2', '2024-02-06 19:11:43', '1', ''),
(6, 1, 'Test_Event_DX_in_BD_it9ssi.adi', '2', '2024-02-06 19:11:55', '1', ''),
(7, 1, 'Test_Event_DX_in_BD_1fahad.adi', '2', '2024-02-07 08:15:37', '1', ''),
(8, 1, 'Test_Event_DX_in_BD_iz8aju.adi', '1', '2024-02-11 02:01:18', '1', ''),
(9, 1, 'Test_Event_DX_in_BD_lotwreport.adi', '2', '2024-02-11 02:02:17', '1', ''),
(10, 1, 'Test_Event_DX_in_BD_DXCC_QSLs_20240115_184117.adi', '1', '2024-02-11 02:02:47', '1', ''),
(11, 2, 'Test_Event_DX_in_BD_IT9AAI.adi', '2', '2024-02-17 19:09:31', '1', ''),
(12, 2, 'Test_Event_DX_in_BD_iz8ffa.adi', '1', '2024-02-17 19:11:16', '1', ''),
(13, 2, 'Test_Event_DX_in_BD_IK0FUX_TX5S.adi', '1', '2024-02-17 19:12:11', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_qsl`
--

CREATE TABLE `user_qsl` (
  `id` int(11) NOT NULL,
  `event_id` varchar(11) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `call` varchar(20) NOT NULL,
  `band` varchar(20) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `qso_date` varchar(50) NOT NULL,
  `time_on` varchar(50) NOT NULL,
  `freq` varchar(50) NOT NULL,
  `operator` varchar(50) NOT NULL,
  `rst_sent` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `creat_date` varchar(50) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_qsl`
--

INSERT INTO `user_qsl` (`id`, `event_id`, `user_id`, `call`, `band`, `mode`, `qso_date`, `time_on`, `freq`, `operator`, `rst_sent`, `status`, `creat_date`) VALUES
(1, '1', '1', 's21pl/m', '160m', 'SSB', '2023-02-03', '02:40', '11.123', 's21af', '55', '1', '2024-03-04 03:43:09'),
(3, '1', '1', 'i8khc', '160m', 'SSB', '2024-01-11', '12:32', '1820', 's21af', '59', '1', '2024-03-06 17:50:35'),
(4, '1', '1', 'Tx5s', '160m', 'SSB', '2024-01-11', '17:00', '0000', 's21af', '59', '1', '2024-03-07 00:00:58'),
(5, '1', '2', 'Accusantium sint arc', '12m', 'FM', '1975-11-20', '04:58', '0000', 's21pl', '599', '1', '2024-03-09 00:18:08'),
(6, '1', '2', 'Sit qui vitae venia', '4m', 'SSB', '2017-03-05', '21:02', '0000', 'Ea est in iure mini', '566', '1', '2024-03-09 00:23:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notices`
--
ALTER TABLE `admin_notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `call_sign` (`call_sign`);

--
-- Indexes for table `user_adfi_files`
--
ALTER TABLE `user_adfi_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_qsl`
--
ALTER TABLE `user_qsl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notices`
--
ALTER TABLE `admin_notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_adfi_files`
--
ALTER TABLE `user_adfi_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_qsl`
--
ALTER TABLE `user_qsl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
