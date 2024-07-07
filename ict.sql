-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 01:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ict`
--

-- --------------------------------------------------------

--
-- Table structure for table `desktop`
--

CREATE TABLE `desktop` (
  `desktopserial` int(50) NOT NULL,
  `desktopmodel` varchar(50) NOT NULL,
  `desktopspec` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `desktop`
--

INSERT INTO `desktop` (`desktopserial`, `desktopmodel`, `desktopspec`) VALUES
(123456789, 'HP', ''),
(6789, 'ASUS', '4GB RAM');

-- --------------------------------------------------------

--
-- Table structure for table `laptop`
--

CREATE TABLE `laptop` (
  `laptopserial` int(50) NOT NULL,
  `laptopmodel` varchar(50) NOT NULL,
  `laptopspec` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laptop`
--

INSERT INTO `laptop` (`laptopserial`, `laptopmodel`, `laptopspec`) VALUES
(123456789, '0', '0'),
(3456, '0', '8GB RAM'),
(98765, 'DELL', '64GB RAM');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `staffNumber` int(40) NOT NULL,
  `department` varchar(50) NOT NULL,
  `subDepartment` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` int(20) NOT NULL,
  `confirmPassword` int(20) NOT NULL,
  `gender` enum('male','female','preferNotToSay') NOT NULL,
  `signup_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`firstName`, `lastName`, `staffNumber`, `department`, `subDepartment`, `email`, `username`, `password`, `confirmPassword`, `gender`, `signup_timestamp`, `last_login_timestamp`) VALUES
('WANJOHI', 'MAINA', 123456789, 'BIT', 'BIT', 'robamaish29@gmail.com', 'Kang254', 1234, 1234, 'male', '2024-05-14 11:00:41', '2024-05-14 11:00:41'),
('Wilson', 'Wambua', 123456, 'ICT', 'ICT', 'robamaish29@gmail.co', 'Willy', 1234, 1234, 'male', '2024-05-22 11:56:51', '2024-05-22 11:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `tablet`
--

CREATE TABLE `tablet` (
  `tabletserial` int(50) NOT NULL,
  `tabletmodel` varchar(50) NOT NULL,
  `tabletspec` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablet`
--

INSERT INTO `tablet` (`tabletserial`, `tabletmodel`, `tabletspec`) VALUES
(1234, 'HP', ''),
(78909, 'HP', ''),
(4567, 'Huawei', '12GB RAM'),
(123456789, 'VIVO', '2GB RAM');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
