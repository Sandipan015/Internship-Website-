-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2022 at 05:34 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `int_global_group_of_institutions_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `db_user_account_reg`
--

CREATE TABLE `db_user_account_reg` (
  `sno` int(10) NOT NULL,
  `reg_user_id` int(10) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `pin` int(10) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `db_user_account_reg`
--

INSERT INTO `db_user_account_reg` (`sno`, `reg_user_id`, `firstname`, `lastname`, `dob`, `email`, `address`, `city`, `state`, `pin`, `phoneNumber`, `password`, `time`) VALUES
(3, 984159, 'Gopinath', 'Bhowmick', '2015-01-07', 'pujabhowmick@gmail.com', 'gangaprasad', 'paschim ', 'wb', 123456, '9932612277', '$2y$10$8Rce.AGwt2nCtkQCEbecEuNSdKLZp47zfT1.Lce542f6oy66uREMq', '2022-03-22 16:21:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `db_user_account_reg`
--
ALTER TABLE `db_user_account_reg`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `db_user_account_reg`
--
ALTER TABLE `db_user_account_reg`
  MODIFY `sno` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
