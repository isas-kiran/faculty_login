-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2015 at 01:38 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `online_exams_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE IF NOT EXISTS `enrollment` (
  `student_id` int(11) NOT NULL,
  `invoice_no` varchar(30) NOT NULL,
  `inquiry_date` date NOT NULL,
  `id_card` int(30) NOT NULL,
  `source` varchar(50) NOT NULL,
  `admission_remark` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  `costomize_courses` varchar(40) NOT NULL,
  `fees` int(30) NOT NULL,
  `discount` int(30) NOT NULL,
  `final_fees` int(30) NOT NULL,
  `net_fees` int(30) NOT NULL,
  `service_tax` int(30) NOT NULL,
  `total_fees` int(30) NOT NULL,
  `down_payment` int(30) NOT NULL,
  `first_installment` int(30) NOT NULL,
  `second_installment` int(30) NOT NULL,
  `final_amt` int(30) NOT NULL,
  `added_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`student_id`, `invoice_no`, `inquiry_date`, `id_card`, `source`, `admission_remark`, `course`, `costomize_courses`, `fees`, `discount`, `final_fees`, `net_fees`, `service_tax`, `total_fees`, `down_payment`, `first_installment`, `second_installment`, `final_amt`, `added_date`) VALUES
(4, '', '2013-06-17', 45545, 'java', 'A+', 'DTP', 'Java spring', 20000, 2000, 18000, 15000, 1000, 14000, 5000, 5000, 5000, 10000, '2015-07-08'),
(2, 'STD02', '2013-04-13', 45545, 'java', 'B+', 'java programming', 'Java spring hibernate', 52000, 5000, 47000, 45000, 1000, 44000, 30000, 10000, 4000, 44000, '2015-07-08');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
