-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 14, 2021 at 10:23 PM
-- Server version: 5.6.49-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isasbeautyschool_org`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses_price`
--

CREATE TABLE `courses_price` (
  `course_price_id` int(10) UNSIGNED NOT NULL,
  `course_id` varchar(100) DEFAULT NULL,
  `course_price` varchar(100) DEFAULT NULL,
  `discount_otp` varchar(100) DEFAULT NULL,
  `discount_inst` varchar(100) DEFAULT NULL,
  `discount_now_otp` varchar(100) DEFAULT NULL,
  `discount_now_inst` varchar(100) DEFAULT NULL,
  `discount_otp_inst` varchar(100) DEFAULT NULL,
  `discount_now_otp_inst` varchar(100) DEFAULT NULL,
  `cm_id` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses_price`
--

INSERT INTO `courses_price` (`course_price_id`, `course_id`, `course_price`, `discount_otp`, `discount_inst`, `discount_now_otp`, `discount_now_inst`, `discount_otp_inst`, `discount_now_otp_inst`, `cm_id`) VALUES
(1, '299', '847', '0', '0', '0', '0', '0', '0', '2'),
(2, '299', '847', '0', '0', '0', '0', '0', '0', '60'),
(3, '299', '847', '0', '0', '0', '0', '0', '0', '174'),
(4, '298', '847', '0', '0', '0', '0', '0', '0', '2'),
(5, '298', '847', '0', '0', '0', '0', '0', '0', '60'),
(6, '298', '847', '0', '0', '0', '0', '0', '0', '174'),
(7, '297', '7627', '0', '0', '0', '0', '0', '0', '2'),
(8, '297', '7627', '0', '0', '0', '0', '0', '0', '60'),
(9, '297', '7627', '0', '0', '0', '0', '0', '0', '174'),
(10, '296', '1271', '0', '0', '0', '0', '0', '0', '2'),
(11, '296', '1271', '0', '0', '0', '0', '0', '0', '60'),
(12, '296', '1271', '0', '0', '0', '0', '0', '0', '174'),
(13, '295', '1271', '0', '0', '0', '0', '0', '0', '2'),
(14, '295', '1271', '0', '0', '0', '0', '0', '0', '60'),
(15, '295', '1271', '0', '0', '0', '0', '0', '0', '174'),
(16, '294', '424', '0', '0', '0', '0', '0', '0', '2'),
(17, '294', '424', '0', '0', '0', '0', '0', '0', '60'),
(18, '294', '424', '0', '0', '0', '0', '0', '0', '174'),
(19, '293', '1271', '0', '0', '0', '0', '0', '0', '2'),
(20, '293', '1271', '0', '0', '0', '0', '0', '0', '60'),
(21, '293', '1271', '0', '0', '0', '0', '0', '0', '174'),
(22, '292', '847', '0', '0', '0', '0', '0', '0', '2'),
(23, '292', '847', '0', '0', '0', '0', '0', '0', '60'),
(24, '292', '847', '0', '0', '0', '0', '0', '0', '174'),
(25, '291', '847', '0', '0', '0', '0', '0', '0', '2'),
(26, '291', '847', '0', '0', '0', '0', '0', '0', '60'),
(27, '291', '847', '0', '0', '0', '0', '0', '0', '174'),
(28, '290', '59322', '0', '0', '0', '0', '0', '0', '2'),
(29, '290', '59322', '0', '0', '0', '0', '0', '0', '60'),
(30, '290', '59322', '0', '0', '0', '0', '0', '0', '174'),
(31, '289', '12000', '0', '0', '0', '0', '0', '0', '2'),
(32, '289', '12000', '0', '0', '0', '0', '0', '0', '60'),
(33, '289', '12000', '0', '0', '0', '0', '0', '0', '174'),
(34, '288', '0', '0', '0', '0', '0', '0', '0', '2'),
(35, '288', '0', '0', '0', '0', '0', '0', '0', '60'),
(36, '288', '0', '0', '0', '0', '0', '0', '0', '174'),
(37, '287', '0', '0', '0', '0', '0', '0', '0', '2'),
(38, '287', '0', '0', '0', '0', '0', '0', '0', '60'),
(39, '287', '0', '0', '0', '0', '0', '0', '0', '174'),
(40, '286', '0', '0', '0', '0', '0', '0', '0', '2'),
(41, '286', '0', '0', '0', '0', '0', '0', '0', '60'),
(42, '286', '0', '0', '0', '0', '0', '0', '0', '174'),
(43, '285', '1271', '0', '0', '0', '0', '0', '0', '2'),
(44, '285', '1271', '0', '0', '0', '0', '0', '0', '60'),
(45, '285', '1271', '0', '0', '0', '0', '0', '0', '174'),
(46, '284', '5085', '0', '0', '0', '0', '0', '0', '2'),
(47, '284', '5085', '0', '0', '0', '0', '0', '0', '60'),
(48, '284', '5085', '0', '0', '0', '0', '0', '0', '174'),
(49, '282', '8475', '0', '0', '0', '0', '0', '0', '2'),
(50, '282', '8475', '0', '0', '0', '0', '0', '0', '60'),
(51, '282', '8475', '0', '0', '0', '0', '0', '0', '174'),
(52, '281', '0', '0', '0', '0', '0', '0', '0', '2'),
(53, '281', '0', '0', '0', '0', '0', '0', '0', '60'),
(54, '281', '0', '0', '0', '0', '0', '0', '0', '174'),
(55, '280', '1695', '0', '0', '0', '0', '0', '0', '2'),
(56, '280', '1695', '0', '0', '0', '0', '0', '0', '60'),
(57, '280', '1695', '0', '0', '0', '0', '0', '0', '174'),
(58, '270', '6900', '0', '0', '0', '0', '0', '0', '2'),
(59, '270', '6900', '0', '0', '0', '0', '0', '0', '60'),
(60, '270', '6900', '0', '0', '0', '0', '0', '0', '174'),
(61, '269', '130508', '20', '15', '30', '25', '25', '30', '2'),
(62, '269', '130508', '20', '15', '30', '25', '25', '30', '60'),
(63, '269', '130508', '30', '20', '33', '25', '25', '33', '174'),
(64, '268', '11844', '0', '0', '0', '0', '0', '0', '2'),
(65, '268', '11844', '0', '0', '0', '0', '0', '0', '60'),
(66, '268', '11844', '0', '0', '0', '0', '0', '0', '174'),
(67, '267', '50847', '20', '9', '30', '19', '19', '30', '2'),
(68, '267', '50847', '20', '9', '30', '19', '19', '30', '60'),
(69, '267', '50847', '25', '15', '33', '23', '23', '33', '174'),
(70, '266', '847', '0', '0', '0', '0', '0', '0', '2'),
(71, '266', '847', '0', '0', '0', '0', '0', '0', '60'),
(72, '266', '847', '0', '0', '0', '0', '0', '0', '174'),
(73, '265', '1525', '0', '0', '0', '0', '0', '0', '2'),
(74, '265', '1525', '0', '0', '0', '0', '0', '0', '60'),
(75, '265', '1525', '0', '0', '0', '0', '0', '0', '174'),
(76, '264', '0', '0', '0', '0', '0', '0', '0', '2'),
(77, '264', '0', '0', '0', '0', '0', '0', '0', '60'),
(78, '264', '0', '0', '0', '0', '0', '0', '0', '174'),
(79, '263', '1271', '0', '0', '0', '0', '0', '0', '2'),
(80, '263', '1271', '0', '0', '0', '0', '0', '0', '60'),
(81, '263', '1271', '0', '0', '0', '0', '0', '0', '174'),
(82, '262', '0', '0', '0', '0', '0', '0', '0', '2'),
(83, '262', '0', '0', '0', '0', '0', '0', '0', '60'),
(84, '262', '0', '0', '0', '0', '0', '0', '0', '174'),
(85, '261', '0', '0', '0', '0', '0', '0', '0', '2'),
(86, '261', '0', '0', '0', '0', '0', '0', '0', '60'),
(87, '261', '0', '0', '0', '0', '0', '0', '0', '174'),
(88, '260', '4237', '0', '0', '0', '0', '0', '0', '2'),
(89, '260', '4237', '0', '0', '0', '0', '0', '0', '60'),
(90, '260', '4237', '0', '0', '0', '0', '0', '0', '174'),
(91, '259', '4237', '0', '0', '0', '0', '0', '0', '2'),
(92, '259', '4237', '0', '0', '0', '0', '0', '0', '60'),
(93, '259', '4237', '0', '0', '0', '0', '0', '0', '174'),
(94, '258', '4237', '0', '0', '0', '0', '0', '0', '2'),
(95, '258', '4237', '0', '0', '0', '0', '0', '0', '60'),
(96, '258', '4237', '0', '0', '0', '0', '0', '0', '174'),
(97, '257', '4237', '0', '0', '0', '0', '0', '0', '2'),
(98, '257', '4237', '0', '0', '0', '0', '0', '0', '60'),
(99, '257', '4237', '0', '0', '0', '0', '0', '0', '174'),
(100, '256', '4237', '0', '0', '0', '0', '0', '0', '2'),
(101, '256', '4237', '0', '0', '0', '0', '0', '0', '60'),
(102, '256', '4237', '0', '0', '0', '0', '0', '0', '174'),
(103, '255', '0', '0', '0', '0', '0', '0', '0', '2'),
(104, '255', '0', '0', '0', '0', '0', '0', '0', '60'),
(105, '255', '0', '0', '0', '0', '0', '0', '0', '174'),
(106, '254', '12712', '0', '0', '0', '0', '0', '0', '2'),
(107, '254', '12712', '0', '0', '0', '0', '0', '0', '60'),
(108, '254', '12712', '0', '0', '0', '0', '0', '0', '174'),
(109, '253', '30508', '20', '9', '30', '19', '19', '30', '2'),
(110, '253', '30508', '20', '9', '30', '19', '19', '30', '60'),
(111, '253', '30508', '25', '15', '33', '23', '23', '33', '174'),
(112, '252', '97085', '15', '9', '25', '19', '19', '25', '2'),
(113, '252', '97085', '15', '9', '25', '19', '19', '25', '60'),
(114, '252', '97085', '15', '9', '25', '19', '19', '25', '174'),
(115, '251', '97085', '15', '9', '25', '19', '19', '25', '2'),
(116, '251', '97085', '15', '9', '25', '19', '19', '25', '60'),
(117, '251', '97085', '15', '9', '25', '19', '19', '25', '174'),
(118, '250', '97085', '15', '9', '25', '19', '19', '25', '2'),
(119, '250', '97085', '15', '9', '25', '19', '19', '25', '60'),
(120, '250', '97085', '15', '9', '25', '19', '19', '25', '174'),
(121, '249', '157119', '15', '9', '25', '19', '19', '25', '2'),
(122, '249', '157119', '15', '9', '25', '19', '19', '25', '60'),
(123, '249', '157119', '15', '9', '25', '19', '19', '25', '174'),
(124, '248', '8475', '20', '0', '30', '0', '0', '30', '2'),
(125, '248', '8475', '20', '0', '30', '0', '0', '30', '60'),
(126, '248', '8475', '20', '0', '30', '0', '0', '30', '174'),
(127, '247', '1695', '0', '0', '0', '', '', '0', '2'),
(128, '247', '1695', '0', '0', '0', '', '', '0', '60'),
(129, '247', '1695', '0', '0', '0', '', '', '0', '174'),
(130, '246', '24576', '20', '9', '30', '19', '19', '30', '2'),
(131, '246', '24576', '20', '9', '30', '19', '19', '30', '60'),
(132, '246', '24576', '20', '9', '30', '19', '19', '30', '174'),
(133, '245', '12288', '20', '9', '30', '19', '19', '30', '2'),
(134, '245', '12288', '20', '9', '30', '19', '19', '30', '60'),
(135, '245', '12288', '20', '9', '30', '19', '19', '30', '174'),
(136, '244', '12288', '20', '9', '30', '19', '19', '30', '2'),
(137, '244', '12288', '20', '9', '30', '19', '19', '30', '60'),
(138, '244', '12288', '20', '9', '30', '19', '19', '30', '174'),
(139, '243', '0', '0', '0', '0', '0', '0', '0', '2'),
(140, '243', '0', '0', '0', '0', '0', '0', '0', '60'),
(141, '243', '0', '0', '0', '0', '0', '0', '0', '174'),
(142, '242', '0', '0', '0', '0', '0', '0', '0', '2'),
(143, '242', '0', '0', '0', '0', '0', '0', '0', '60'),
(144, '242', '0', '0', '0', '0', '0', '0', '0', '174'),
(145, '241', '547', '0', '0', '0', '0', '0', '0', '2'),
(146, '241', '547', '0', '0', '0', '0', '0', '0', '60'),
(147, '241', '547', '0', '0', '0', '0', '0', '0', '174'),
(148, '240', '0', '0', '0', '0', '0', '0', '0', '2'),
(149, '240', '0', '0', '0', '0', '0', '0', '0', '60'),
(150, '240', '0', '0', '0', '0', '0', '0', '0', '174'),
(151, '239', '2966', '0', '0', '0', '0', '0', '0', '2'),
(152, '239', '2966', '0', '0', '0', '0', '0', '0', '60'),
(153, '239', '2966', '0', '0', '0', '0', '0', '0', '174'),
(154, '238', '1780', '0', '0', '0', '0', '0', '0', '2'),
(155, '238', '1780', '0', '0', '0', '0', '0', '0', '60'),
(156, '238', '1780', '0', '0', '0', '0', '0', '0', '174'),
(157, '237', '0', '0', '0', '0', '0', '0', '0', '2'),
(158, '237', '0', '0', '0', '0', '0', '0', '0', '60'),
(159, '237', '0', '0', '0', '0', '0', '0', '0', '174'),
(160, '236', '0', '0', '0', '0', '0', '0', '0', '2'),
(161, '236', '0', '0', '0', '0', '0', '0', '0', '60'),
(162, '236', '0', '0', '0', '0', '0', '0', '0', '174'),
(163, '235', '0', '0', '0', '0', '0', '0', '0', '2'),
(164, '235', '0', '0', '0', '0', '0', '0', '0', '60'),
(165, '235', '0', '0', '0', '0', '0', '0', '0', '174'),
(166, '234', '0', '0', '0', '0', '0', '0', '0', '2'),
(167, '234', '0', '0', '0', '0', '0', '0', '0', '60'),
(168, '234', '0', '0', '0', '0', '0', '0', '0', '174'),
(169, '233', '5000', '0', '0', '0', '0', '0', '0', '2'),
(170, '233', '5000', '0', '0', '0', '0', '0', '0', '60'),
(171, '233', '5000', '0', '0', '0', '0', '0', '0', '174'),
(172, '230', '8475', '0', '0', '0', '0', '0', '0', '2'),
(173, '230', '8475', '0', '0', '0', '0', '0', '0', '60'),
(174, '230', '8475', '0', '0', '0', '0', '0', '0', '174'),
(175, '229', '0', '0', '0', '0', '0', '0', '0', '2'),
(176, '229', '0', '0', '0', '0', '0', '0', '0', '60'),
(177, '229', '0', '0', '0', '0', '0', '0', '0', '174'),
(178, '228', '12712', '0', '0', '0', '0', '0', '0', '2'),
(179, '228', '12712', '0', '0', '0', '0', '0', '0', '60'),
(180, '228', '12712', '0', '0', '0', '0', '0', '0', '174'),
(181, '227', '0', '0', '0', '0', '0', '0', '0', '2'),
(182, '227', '0', '0', '0', '0', '0', '0', '0', '60'),
(183, '227', '0', '0', '0', '0', '0', '0', '0', '174'),
(184, '226', '24424', '15', '9', '25', '19', '19', '25', '2'),
(185, '226', '24424', '15', '9', '25', '19', '19', '25', '60'),
(186, '226', '24424', '15', '9', '25', '19', '19', '25', '174'),
(187, '225', '38136', '15', '9', '25', '19', '19', '25', '2'),
(188, '225', '38136', '15', '9', '25', '19', '19', '25', '60'),
(189, '225', '38136', '15', '9', '25', '19', '19', '25', '174'),
(190, '224', '0', '0', '0', '0', '0', '0', '0', '2'),
(191, '224', '0', '0', '0', '0', '0', '0', '0', '60'),
(192, '224', '0', '0', '0', '0', '0', '0', '0', '174'),
(193, '223', '0', '0', '0', '0', '0', '0', '0', '2'),
(194, '223', '0', '0', '0', '0', '0', '0', '0', '60'),
(195, '223', '0', '0', '0', '0', '0', '0', '0', '174'),
(196, '222', '50847', '0', '0', '0', '0', '0', '0', '2'),
(197, '222', '50847', '0', '0', '0', '0', '0', '0', '60'),
(198, '222', '50847', '0', '0', '0', '0', '0', '0', '174'),
(199, '221', '0', '0', '0', '0', '0', '0', '0', '2'),
(200, '221', '0', '0', '0', '0', '0', '0', '0', '60'),
(201, '221', '0', '0', '0', '0', '0', '0', '0', '174'),
(202, '220', '0', '0', '0', '0', '0', '0', '0', '2'),
(203, '220', '0', '0', '0', '0', '0', '0', '0', '60'),
(204, '220', '0', '0', '0', '0', '0', '0', '0', '174'),
(205, '219', '50847', '15', '9', '25', '19', '19', '25', '2'),
(206, '219', '50847', '15', '9', '25', '19', '19', '25', '60'),
(207, '219', '50847', '15', '9', '25', '19', '19', '25', '174'),
(208, '218', '21186', '15', '9', '25', '19', '19', '25', '2'),
(209, '218', '21186', '15', '9', '25', '19', '19', '25', '60'),
(210, '218', '21186', '15', '9', '25', '19', '19', '25', '174'),
(211, '217', '50847', '15', '9', '25', '19', '19', '25', '2'),
(212, '217', '50847', '15', '9', '25', '19', '19', '25', '60'),
(213, '217', '50847', '15', '9', '25', '19', '19', '25', '174'),
(214, '216', '50847', '15', '9', '25', '19', '19', '25', '2'),
(215, '216', '50847', '15', '9', '25', '19', '19', '25', '60'),
(216, '216', '50847', '15', '9', '25', '19', '19', '25', '174'),
(217, '215', '38136', '15', '9', '25', '19', '19', '25', '2'),
(218, '215', '38136', '15', '9', '25', '19', '19', '25', '60'),
(219, '215', '38136', '15', '9', '25', '19', '19', '25', '174'),
(220, '214', '50847', '15', '9', '25', '19', '19', '25', '2'),
(221, '214', '50847', '15', '9', '25', '19', '19', '25', '60'),
(222, '214', '50847', '15', '9', '25', '19', '19', '25', '174'),
(223, '213', '50847', '15', '9', '25', '19', '19', '25', '2'),
(224, '213', '50847', '15', '9', '25', '19', '19', '25', '60'),
(225, '213', '50847', '15', '9', '25', '19', '19', '25', '174'),
(226, '212', '38136', '15', '9', '25', '19', '19', '25', '2'),
(227, '212', '38136', '15', '9', '25', '19', '19', '25', '60'),
(228, '212', '38136', '15', '9', '25', '19', '19', '25', '174'),
(229, '211', '50847', '15', '9', '25', '19', '19', '25', '2'),
(230, '211', '50847', '15', '9', '25', '19', '19', '25', '60'),
(231, '211', '50847', '15', '9', '25', '19', '19', '25', '174'),
(232, '210', '50847', '15', '9', '25', '19', '19', '25', '2'),
(233, '210', '50847', '15', '9', '25', '19', '19', '25', '60'),
(234, '210', '50847', '15', '9', '25', '19', '19', '25', '174'),
(235, '209', '50847', '15', '9', '25', '19', '19', '25', '2'),
(236, '209', '50847', '15', '9', '25', '19', '19', '25', '60'),
(237, '209', '50847', '15', '9', '25', '19', '19', '25', '174'),
(238, '208', '36846', '0', '0', '0', '0', '0', '0', '2'),
(239, '208', '36846', '0', '0', '0', '0', '0', '0', '60'),
(240, '208', '36846', '0', '0', '0', '0', '0', '0', '174'),
(241, '207', '42373', '15', '9', '25', '19', '19', '25', '2'),
(242, '207', '42373', '15', '9', '25', '19', '19', '25', '60'),
(243, '207', '42373', '15', '9', '25', '19', '19', '25', '174'),
(244, '206', '50847', '15', '9', '25', '19', '19', '25', '2'),
(245, '206', '50847', '15', '9', '25', '19', '19', '25', '60'),
(246, '206', '50847', '15', '9', '25', '19', '19', '25', '174'),
(247, '205', '175424', '15', '9', '25', '19', '19', '25', '2'),
(248, '205', '175424', '15', '9', '25', '19', '19', '25', '60'),
(249, '205', '175424', '15', '9', '25', '19', '19', '25', '174'),
(250, '204', '50847', '15', '9', '25', '19', '19', '25', '2'),
(251, '204', '50847', '15', '9', '25', '19', '19', '25', '60'),
(252, '204', '50847', '15', '9', '25', '19', '19', '25', '174'),
(253, '203', '38136', '15', '9', '25', '19', '19', '25', '2'),
(254, '203', '38136', '15', '9', '25', '19', '19', '25', '60'),
(255, '203', '38136', '15', '9', '25', '19', '19', '25', '174'),
(256, '202', '25424', '15', '9', '25', '19', '19', '25', '2'),
(257, '202', '25424', '15', '9', '25', '19', '19', '25', '60'),
(258, '202', '25424', '15', '9', '25', '19', '19', '25', '174'),
(259, '201', '10169', '15', '9', '25', '19', '19', '25', '2'),
(260, '201', '10169', '15', '9', '25', '19', '19', '25', '60'),
(261, '201', '10169', '15', '9', '25', '19', '19', '25', '174'),
(262, '200', '7627', '20', '0', '30', '0', '0', '30', '2'),
(263, '200', '7627', '20', '0', '30', '0', '0', '30', '60'),
(264, '200', '7627', '20', '0', '30', '0', '0', '30', '174'),
(265, '199', '12422', '15', '9', '25', '19', '19', '25', '2'),
(266, '199', '12422', '15', '9', '25', '19', '19', '25', '60'),
(267, '199', '12422', '15', '9', '25', '19', '19', '25', '174'),
(268, '198', '7627', '15', '9', '25', '19', '19', '25', '2'),
(269, '198', '7627', '15', '9', '25', '19', '19', '25', '60'),
(270, '198', '7627', '15', '9', '25', '19', '19', '25', '174'),
(271, '197', '10169', '15', '9', '25', '19', '19', '25', '2'),
(272, '197', '10169', '15', '9', '25', '19', '19', '25', '60'),
(273, '197', '10169', '15', '9', '25', '19', '19', '25', '174'),
(274, '196', '7627', '20', '9', '30', '19', '19', '30', '2'),
(275, '196', '7627', '20', '9', '30', '19', '19', '30', '60'),
(276, '196', '7627', '20', '9', '30', '19', '19', '30', '174'),
(277, '195', '10169', '15', '9', '25', '19', '19', '25', '2'),
(278, '195', '10169', '15', '9', '25', '19', '19', '25', '60'),
(279, '195', '10169', '15', '9', '25', '19', '19', '25', '174'),
(280, '194', '10169', '15', '9', '25', '19', '19', '25', '2'),
(281, '194', '10169', '15', '9', '25', '19', '19', '25', '60'),
(282, '194', '10169', '15', '9', '25', '19', '19', '25', '174'),
(283, '193', '80544', '20', '15', '30', '19', '19', '30', '2'),
(284, '193', '80544', '20', '15', '30', '19', '19', '30', '60'),
(285, '193', '80544', '20', '15', '30', '19', '19', '30', '174'),
(286, '192', '12288', '15', '9', '25', '19', '19', '25', '2'),
(287, '192', '12288', '15', '9', '25', '19', '19', '25', '60'),
(288, '192', '12288', '15', '9', '25', '19', '19', '25', '174'),
(289, '191', '12288', '15', '9', '25', '19', '19', '25', '2'),
(290, '191', '12288', '15', '9', '25', '19', '19', '25', '60'),
(291, '191', '12288', '15', '9', '25', '19', '19', '25', '174'),
(292, '190', '0', '0', '0', '0', '0', '0', '0', '2'),
(293, '190', '0', '0', '0', '0', '0', '0', '0', '60'),
(294, '190', '0', '0', '0', '0', '0', '0', '0', '174'),
(295, '189', '39831', '15', '9', '25', '19', '19', '25', '2'),
(296, '189', '39831', '15', '9', '25', '19', '19', '25', '60'),
(297, '189', '39831', '15', '9', '25', '19', '19', '25', '174'),
(298, '188', '7529', '15', '9', '25', '19', '19', '25', '2'),
(299, '188', '7529', '15', '9', '25', '19', '19', '25', '60'),
(300, '188', '7529', '15', '9', '25', '19', '19', '25', '174'),
(301, '187', '10038', '15', '9', '25', '19', '19', '25', '2'),
(302, '187', '10038', '15', '9', '25', '19', '19', '25', '60'),
(303, '187', '10038', '15', '9', '25', '19', '19', '25', '174'),
(304, '186', '9000', '20', '0', '30', '0', '0', '30', '2'),
(305, '186', '9000', '20', '0', '30', '0', '0', '30', '60'),
(306, '186', '9000', '20', '0', '30', '0', '0', '30', '174'),
(307, '185', '7027', '20', '0', '30', '0', '0', '30', '2'),
(308, '185', '7027', '20', '0', '30', '0', '0', '30', '60'),
(309, '185', '7027', '20', '0', '30', '0', '0', '30', '174'),
(310, '184', '19831', '20', '9', '30', '19', '19', '30', '2'),
(311, '184', '19831', '20', '9', '30', '19', '19', '30', '60'),
(312, '184', '19831', '20', '9', '30', '19', '19', '30', '174'),
(313, '183', '26529', '15', '9', '25', '19', '19', '25', '2'),
(314, '183', '26529', '15', '9', '25', '19', '19', '25', '60'),
(315, '183', '26529', '15', '9', '25', '19', '19', '25', '174'),
(316, '182', '29476', '15', '9', '25', '19', '19', '25', '2'),
(317, '182', '29476', '15', '9', '25', '19', '19', '25', '60'),
(318, '182', '29476', '15', '9', '25', '19', '19', '25', '174'),
(319, '181', '0', '0', '0', '0', '0', '0', '0', '2'),
(320, '181', '0', '0', '0', '0', '0', '0', '0', '60'),
(321, '181', '0', '0', '0', '0', '0', '0', '0', '174'),
(322, '180', '0', '0', '0', '0', '0', '0', '0', '2'),
(323, '180', '0', '0', '0', '0', '0', '0', '0', '60'),
(324, '180', '0', '0', '0', '0', '0', '0', '0', '174'),
(325, '179', '0', '0', '0', '0', '0', '0', '0', '2'),
(326, '179', '0', '0', '0', '0', '0', '0', '0', '60'),
(327, '179', '0', '0', '0', '0', '0', '0', '0', '174'),
(328, '178', '0', '0', '0', '0', '0', '0', '0', '2'),
(329, '178', '0', '0', '0', '0', '0', '0', '0', '60'),
(330, '178', '0', '0', '0', '0', '0', '0', '0', '174'),
(331, '177', '0', '0', '0', '0', '0', '0', '0', '2'),
(332, '177', '0', '0', '0', '0', '0', '0', '0', '60'),
(333, '177', '0', '0', '0', '0', '0', '0', '0', '174'),
(334, '176', '0', '0', '0', '0', '0', '0', '0', '2'),
(335, '176', '0', '0', '0', '0', '0', '0', '0', '60'),
(336, '176', '0', '0', '0', '0', '0', '0', '0', '174'),
(337, '175', '7797', '20', '0', '30', '0', '0', '30', '2'),
(338, '175', '7797', '20', '0', '30', '0', '0', '30', '60'),
(339, '175', '7797', '25', '0', '33', '0', '0', '33', '174'),
(340, '174', '0', '0', '0', '0', '0', '0', '0', '2'),
(341, '174', '0', '0', '0', '0', '0', '0', '0', '60'),
(342, '174', '0', '0', '0', '0', '0', '0', '0', '174'),
(343, '173', '22881', '15', '9', '25', '19', '19', '25', '2'),
(344, '173', '22881', '15', '9', '25', '19', '19', '25', '60'),
(345, '173', '22881', '15', '9', '25', '19', '19', '25', '174'),
(346, '172', '11864', '15', '9', '25', '19', '19', '25', '2'),
(347, '172', '11864', '15', '9', '25', '19', '19', '25', '60'),
(348, '172', '11864', '15', '9', '25', '19', '19', '25', '174'),
(349, '171', '7203', '15', '9', '25', '19', '19', '25', '2'),
(350, '171', '7203', '15', '9', '25', '19', '19', '25', '60'),
(351, '171', '7203', '15', '9', '25', '19', '19', '25', '174'),
(352, '170', '0', '0', '0', '0', '0', '0', '0', '2'),
(353, '170', '0', '0', '0', '0', '0', '0', '0', '60'),
(354, '170', '0', '0', '0', '0', '0', '0', '0', '174'),
(355, '169', '27103', '0', '0', '0', '0', '0', '0', '2'),
(356, '169', '27103', '0', '0', '0', '0', '0', '0', '60'),
(357, '169', '27103', '0', '0', '0', '0', '0', '0', '174'),
(358, '168', '42004', '20', '9', '30', '19', '19', '30', '2'),
(359, '168', '42004', '20', '9', '30', '19', '19', '30', '60'),
(360, '168', '42004', '20', '9', '30', '19', '19', '30', '174'),
(361, '167', '50191', '25', '9', '30', '19', '19', '30', '2'),
(362, '167', '50191', '25', '9', '30', '19', '19', '30', '60'),
(363, '167', '50191', '25', '9', '30', '19', '19', '30', '174'),
(364, '162', '91525', '20', '9', '30', '19', '19', '30', '2'),
(365, '162', '91525', '20', '9', '30', '19', '19', '30', '60'),
(366, '162', '91525', '25', '15', '33', '23', '23', '33', '174'),
(367, '105', '37832', '27', '15', '33', '21', '21', '33', '2'),
(368, '105', '37832', '27', '15', '33', '21', '21', '33', '60'),
(369, '105', '37832', '27', '15', '33', '21', '21', '33', '174'),
(370, '103', '200763', '15', '9', '25', '19', '19', '25', '2'),
(371, '103', '200763', '15', '9', '25', '19', '19', '25', '60'),
(372, '103', '200763', '15', '9', '25', '19', '19', '25', '174'),
(373, '98', '87288', '27', '15', '33', '21', '21', '33', '2'),
(374, '98', '87288', '27', '15', '33', '21', '21', '33', '60'),
(375, '98', '87288', '30', '20', '35', '25', '25', '35', '174'),
(376, '92', '72275', '20', '9', '30', '19', '19', '30', '2'),
(377, '92', '72275', '20', '9', '30', '19', '19', '30', '60'),
(378, '92', '72275', '25', '15', '33', '23', '23', '33', '174'),
(379, '82', '37832', '27', '15', '33', '21', '21', '33', '2'),
(380, '82', '37832', '27', '15', '33', '21', '21', '33', '60'),
(381, '82', '37832', '30', '20', '35', '25', '25', '35', '174'),
(382, '52', '442373', '15', '8', '21', '11', '11', '21', '2'),
(383, '52', '442373', '15', '8', '21', '11', '11', '21', '60'),
(384, '52', '442373', '16', '10', '22', '18', '18', '22', '174'),
(385, '51', '42004', '20', '9', '30', '19', '19', '30', '2'),
(386, '51', '42004', '20', '9', '30', '19', '19', '30', '60'),
(387, '51', '42004', '20', '9', '30', '19', '19', '30', '174'),
(388, '36', '10169', '0', '0', '0', '0', '0', '0', '2'),
(389, '36', '10169', '0', '0', '0', '0', '0', '0', '60'),
(390, '36', '10169', '0', '0', '0', '0', '0', '0', '174'),
(391, '23', '0', '0', '0', '0', '0', '0', '0', '2'),
(392, '23', '0', '0', '0', '0', '0', '0', '0', '60'),
(393, '23', '0', '0', '0', '0', '0', '0', '0', '174'),
(394, '22', '45390', '20', '9', '30', '19', '19', '30', '2'),
(395, '22', '45390', '20', '9', '30', '19', '19', '30', '60'),
(396, '22', '45390', '25', '15', '33', '19', '19', '33', '174'),
(397, '21', '7627', '15', '9', '30', '19', '19', '30', '2'),
(398, '21', '7627', '15', '9', '30', '19', '19', '30', '60'),
(399, '21', '7627', '15', '9', '30', '19', '19', '30', '174'),
(400, '20', '0', '0', '0', '0', '0', '0', '0', '2'),
(401, '20', '0', '0', '0', '0', '0', '0', '0', '60'),
(402, '20', '0', '0', '0', '0', '0', '0', '0', '174'),
(403, '19', '15254', '20', '9', '30', '19', '19', '30', '2'),
(404, '19', '15254', '20', '9', '30', '19', '19', '30', '60'),
(405, '19', '15254', '25', '15', '33', '19', '19', '33', '174'),
(406, '18', '9960', '20', '9', '30', '19', '19', '30', '2'),
(407, '18', '9960', '20', '9', '30', '19', '19', '30', '60'),
(408, '18', '9960', '25', '15', '33', '19', '19', '33', '174'),
(409, '17', '143475', '15', '9', '25', '19', '19', '25', '2'),
(410, '17', '143475', '15', '9', '25', '19', '19', '25', '60'),
(411, '17', '143475', '15', '9', '25', '19', '19', '25', '174'),
(412, '16', '0', '0', '0', '0', '0', '0', '0', '2'),
(413, '16', '0', '0', '0', '0', '0', '0', '0', '60'),
(414, '16', '0', '0', '0', '0', '0', '0', '0', '174'),
(415, '15', '91525', '27', '15', '33', '21', '21', '33', '2'),
(416, '15', '91525', '27', '15', '33', '21', '21', '33', '60'),
(417, '15', '91525', '27', '15', '33', '21', '21', '33', '174'),
(418, '13', '0', '0', '0', '0', '0', '0', '0', '2'),
(419, '13', '0', '0', '0', '0', '0', '0', '0', '60'),
(420, '13', '0', '0', '0', '0', '0', '0', '0', '174'),
(421, '12', '72034', '20', '9', '30', '19', '19', '30', '2'),
(422, '12', '72034', '20', '9', '30', '19', '19', '30', '60'),
(423, '12', '72034', '25', '15', '33', '23', '23', '33', '174'),
(424, '11', '219966', '20', '9', '25', '14', '14', '25', '2'),
(425, '11', '219966', '20', '9', '25', '14', '14', '25', '60'),
(426, '11', '219966', '22', '15', '27', '20', '20', '27', '174'),
(427, '8', '53644', '27', '15', '33', '25', '25', '33', '2'),
(428, '8', '53644', '27', '15', '33', '25', '25', '33', '60'),
(429, '8', '53644', '30', '20', '35', '25', '25', '35', '174'),
(430, '6', '27103', '20', '9', '30', '19', '19', '30', '2'),
(431, '6', '27103', '20', '9', '30', '19', '19', '30', '60'),
(432, '6', '27103', '25', '15', '33', '23', '23', '33', '174'),
(433, '5', '40153', '25', '9', '30', '19', '25', '30', '2'),
(434, '5', '40153', '25', '9', '30', '19', '19', '30', '60'),
(435, '5', '40153', '25', '9', '30', '19', '19', '30', '174'),
(436, '2', '27103', '20', '9', '30', '19', '19', '30', '2'),
(437, '2', '27103', '20', '9', '30', '19', '19', '30', '60'),
(438, '2', '27103', '25', '15', '33', '23', '23', '33', '174'),
(439, '1', '53644', '27', '15', '33', '21', '21', '33', '2'),
(440, '1', '53644', '27', '15', '33', '21', '21', '33', '60'),
(441, '1', '53644', '27', '15', '33', '21', '21', '33', '174'),
(442, '', '67797', '20', '9', '30', '19', '19', '30', '2'),
(443, '', '67797', '20', '9', '30', '19', '19', '30', '60'),
(444, '', '67797', '25', '15', '33', '23', '23', '33', '174'),
(445, '299', '847', '0', '0', '0', '0', '0', '0', '115'),
(446, '298', '847', '0', '0', '0', '0', '0', '0', '115'),
(447, '297', '7627', '0', '0', '0', '0', '0', '0', '115'),
(448, '296', '1271', '0', '0', '0', '0', '0', '0', '115'),
(449, '295', '1271', '0', '0', '0', '0', '0', '0', '115'),
(450, '294', '424', '0', '0', '0', '0', '0', '0', '115'),
(451, '293', '1271', '0', '0', '0', '0', '0', '0', '115'),
(452, '292', '847', '0', '0', '0', '0', '0', '0', '115'),
(453, '291', '847', '0', '0', '0', '0', '0', '0', '115'),
(454, '290', '59322', '0', '0', '0', '0', '0', '0', '115'),
(455, '289', '12000', '0', '0', '0', '0', '0', '0', '115'),
(456, '288', '0', '0', '0', '0', '0', '0', '0', '115'),
(457, '287', '0', '0', '0', '0', '0', '0', '0', '115'),
(458, '286', '0', '0', '0', '0', '0', '0', '0', '115'),
(459, '285', '1271', '0', '0', '0', '0', '0', '0', '115'),
(460, '284', '5085', '0', '0', '0', '0', '0', '0', '115'),
(461, '282', '8475', '0', '0', '0', '0', '0', '0', '115'),
(462, '281', '0', '0', '0', '0', '0', '0', '0', '115'),
(463, '280', '1695', '0', '0', '0', '0', '0', '0', '115'),
(464, '270', '6900', '0', '0', '0', '0', '0', '0', '115'),
(465, '269', '130508', '20', '15', '30', '25', '25', '30', '115'),
(466, '268', '11844', '0', '0', '0', '0', '0', '0', '115'),
(467, '267', '50847', '20', '9', '30', '19', '19', '30', '115'),
(468, '266', '847', '0', '0', '0', '0', '0', '0', '115'),
(469, '265', '1525', '0', '0', '0', '0', '0', '0', '115'),
(470, '264', '0', '0', '0', '0', '0', '0', '0', '115'),
(471, '263', '1271', '0', '0', '0', '0', '0', '0', '115'),
(472, '262', '0', '0', '0', '0', '0', '0', '0', '115'),
(473, '261', '0', '0', '0', '0', '0', '0', '0', '115'),
(474, '260', '4237', '0', '0', '0', '0', '0', '0', '115'),
(475, '259', '4237', '0', '0', '0', '0', '0', '0', '115'),
(476, '258', '4237', '0', '0', '0', '0', '0', '0', '115'),
(477, '257', '4237', '0', '0', '0', '0', '0', '0', '115'),
(478, '256', '4237', '0', '0', '0', '0', '0', '0', '115'),
(479, '255', '0', '0', '0', '0', '0', '0', '0', '115'),
(480, '254', '12712', '0', '0', '0', '0', '0', '0', '115'),
(481, '253', '30508', '20', '9', '30', '19', '19', '30', '115'),
(482, '252', '97085', '15', '9', '25', '19', '19', '25', '115'),
(483, '251', '97085', '15', '9', '25', '19', '19', '25', '115'),
(484, '250', '97085', '15', '9', '25', '19', '19', '25', '115'),
(485, '249', '157119', '15', '9', '25', '19', '19', '25', '115'),
(486, '248', '8475', '20', '0', '30', '0', '0', '30', '115'),
(487, '247', '1695', '0', '0', '0', '', '', '0', '115'),
(488, '246', '24576', '20', '9', '30', '19', '19', '30', '115'),
(489, '245', '12288', '20', '9', '30', '19', '19', '30', '115'),
(490, '244', '12288', '20', '9', '30', '19', '19', '30', '115'),
(491, '243', '0', '0', '0', '0', '0', '0', '0', '115'),
(492, '242', '0', '0', '0', '0', '0', '0', '0', '115'),
(493, '241', '547', '0', '0', '0', '0', '0', '0', '115'),
(494, '240', '0', '0', '0', '0', '0', '0', '0', '115'),
(495, '239', '2966', '0', '0', '0', '0', '0', '0', '115'),
(496, '238', '1780', '0', '0', '0', '0', '0', '0', '115'),
(497, '237', '0', '0', '0', '0', '0', '0', '0', '115'),
(498, '236', '0', '0', '0', '0', '0', '0', '0', '115'),
(499, '235', '0', '0', '0', '0', '0', '0', '0', '115'),
(500, '234', '0', '0', '0', '0', '0', '0', '0', '115'),
(501, '233', '5000', '0', '0', '0', '0', '0', '0', '115'),
(502, '230', '8475', '0', '0', '0', '0', '0', '0', '115'),
(503, '229', '0', '0', '0', '0', '0', '0', '0', '115'),
(504, '228', '12712', '0', '0', '0', '0', '0', '0', '115'),
(505, '227', '0', '0', '0', '0', '0', '0', '0', '115'),
(506, '226', '24424', '15', '9', '25', '19', '19', '25', '115'),
(507, '225', '38136', '15', '9', '25', '19', '19', '25', '115'),
(508, '224', '0', '0', '0', '0', '0', '0', '0', '115'),
(509, '223', '0', '0', '0', '0', '0', '0', '0', '115'),
(510, '222', '50847', '0', '0', '0', '0', '0', '0', '115'),
(511, '221', '0', '0', '0', '0', '0', '0', '0', '115'),
(512, '220', '0', '0', '0', '0', '0', '0', '0', '115'),
(513, '219', '50847', '15', '9', '25', '19', '19', '25', '115'),
(514, '218', '21186', '15', '9', '25', '19', '19', '25', '115'),
(515, '217', '50847', '15', '9', '25', '19', '19', '25', '115'),
(516, '216', '50847', '15', '9', '25', '19', '19', '25', '115'),
(517, '215', '38136', '15', '9', '25', '19', '19', '25', '115'),
(518, '214', '50847', '15', '9', '25', '19', '19', '25', '115'),
(519, '213', '50847', '15', '9', '25', '19', '19', '25', '115'),
(520, '212', '38136', '15', '9', '25', '19', '19', '25', '115'),
(521, '211', '50847', '15', '9', '25', '19', '19', '25', '115'),
(522, '210', '50847', '15', '9', '25', '19', '19', '25', '115'),
(523, '209', '50847', '15', '9', '25', '19', '19', '25', '115'),
(524, '208', '36846', '0', '0', '0', '0', '0', '0', '115'),
(525, '207', '42373', '15', '9', '25', '19', '19', '25', '115'),
(526, '206', '50847', '15', '9', '25', '19', '19', '25', '115'),
(527, '205', '175424', '15', '9', '25', '19', '19', '25', '115'),
(528, '204', '50847', '15', '9', '25', '19', '19', '25', '115'),
(529, '203', '38136', '15', '9', '25', '19', '19', '25', '115'),
(530, '202', '25424', '15', '9', '25', '19', '19', '25', '115'),
(531, '201', '10169', '15', '9', '25', '19', '19', '25', '115'),
(532, '200', '7627', '20', '0', '30', '0', '0', '30', '115'),
(533, '199', '12422', '15', '9', '25', '19', '19', '25', '115'),
(534, '198', '7627', '15', '9', '25', '19', '19', '25', '115'),
(535, '197', '10169', '15', '9', '25', '19', '19', '25', '115'),
(536, '196', '7627', '20', '9', '30', '19', '19', '30', '115'),
(537, '195', '10169', '15', '9', '25', '19', '19', '25', '115'),
(538, '194', '10169', '15', '9', '25', '19', '19', '25', '115'),
(539, '193', '80544', '20', '15', '30', '19', '19', '30', '115'),
(540, '192', '12288', '15', '9', '25', '19', '19', '25', '115'),
(541, '191', '12288', '15', '9', '25', '19', '19', '25', '115'),
(542, '190', '0', '0', '0', '0', '0', '0', '0', '115'),
(543, '189', '39831', '15', '9', '25', '19', '19', '25', '115'),
(544, '188', '7529', '15', '9', '25', '19', '19', '25', '115'),
(545, '187', '10038', '15', '9', '25', '19', '19', '25', '115'),
(546, '186', '9000', '20', '0', '30', '0', '0', '30', '115'),
(547, '185', '7027', '20', '0', '30', '0', '0', '30', '115'),
(548, '184', '19831', '20', '9', '30', '19', '19', '30', '115'),
(549, '183', '26529', '15', '9', '25', '19', '19', '25', '115'),
(550, '182', '29476', '15', '9', '25', '19', '19', '25', '115'),
(551, '181', '0', '0', '0', '0', '0', '0', '0', '115'),
(552, '180', '0', '0', '0', '0', '0', '0', '0', '115'),
(553, '179', '0', '0', '0', '0', '0', '0', '0', '115'),
(554, '178', '0', '0', '0', '0', '0', '0', '0', '115'),
(555, '177', '0', '0', '0', '0', '0', '0', '0', '115'),
(556, '176', '0', '0', '0', '0', '0', '0', '0', '115'),
(557, '175', '7797', '20', '0', '30', '0', '0', '30', '115'),
(558, '174', '0', '0', '0', '0', '0', '0', '0', '115'),
(559, '173', '22881', '15', '9', '25', '19', '19', '25', '115'),
(560, '172', '11864', '15', '9', '25', '19', '19', '25', '115'),
(561, '171', '7203', '15', '9', '25', '19', '19', '25', '115'),
(562, '170', '0', '0', '0', '0', '0', '0', '0', '115'),
(563, '169', '27103', '0', '0', '0', '0', '0', '0', '115'),
(564, '168', '42004', '20', '9', '30', '19', '19', '30', '115'),
(565, '167', '50191', '25', '9', '30', '19', '19', '30', '115'),
(566, '162', '91525', '20', '9', '30', '19', '19', '30', '115'),
(567, '105', '37832', '27', '15', '33', '21', '21', '33', '115'),
(568, '103', '200763', '15', '9', '25', '19', '19', '25', '115'),
(569, '98', '87288', '27', '15', '33', '21', '21', '33', '115'),
(570, '92', '72275', '20', '9', '30', '19', '19', '30', '115'),
(571, '82', '37832', '27', '15', '33', '21', '21', '33', '115'),
(572, '52', '442373', '15', '8', '21', '11', '11', '21', '115'),
(573, '51', '42004', '20', '9', '30', '19', '19', '30', '115'),
(574, '36', '10169', '0', '0', '0', '0', '0', '0', '115'),
(575, '23', '0', '0', '0', '0', '0', '0', '0', '115'),
(576, '22', '45390', '20', '9', '30', '19', '19', '30', '115'),
(577, '21', '7627', '15', '9', '30', '19', '19', '30', '115'),
(578, '20', '0', '0', '0', '0', '0', '0', '0', '115'),
(579, '19', '15254', '20', '9', '30', '19', '19', '30', '115'),
(580, '18', '9960', '20', '9', '30', '19', '19', '30', '115'),
(581, '17', '143475', '15', '9', '25', '19', '19', '25', '115'),
(582, '16', '0', '0', '0', '0', '0', '0', '0', '115'),
(583, '15', '91525', '27', '15', '33', '21', '21', '33', '115'),
(584, '13', '0', '0', '0', '0', '0', '0', '0', '115'),
(585, '12', '72034', '20', '9', '30', '19', '19', '30', '115'),
(586, '11', '219966', '20', '9', '25', '14', '14', '25', '115'),
(587, '8', '53644', '27', '15', '33', '25', '25', '33', '115'),
(588, '6', '27103', '20', '9', '30', '19', '19', '30', '115'),
(589, '5', '40153', '25', '9', '30', '19', '19', '30', '115'),
(590, '2', '27103', '20', '9', '30', '19', '19', '30', '115'),
(591, '1', '53644', '27', '15', '33', '21', '21', '33', '115'),
(592, '', '67797', '20', '9', '30', '19', '19', '30', '115'),
(593, '303', '38100', '15', '10', '20', '15', '15', '20', '60'),
(594, '303', '38100', '15', '10', '20', '15', '15', '20', '2'),
(595, '304', '38136', '20', '9', '30', '19', '19', '30', '2'),
(596, '304', '38136', '20', '9', '30', '19', '19', '30', '60'),
(597, '304', '38136', '25', '15', '33', '23', '23', '33', '174'),
(598, '304', '38136', '20', '9', '30', '19', '19', '30', '115'),
(599, '305', '38136', '20', '9', '30', '19', '19', '30', '2'),
(600, '305', '38136', '20', '9', '30', '19', '19', '30', '60'),
(601, '305', '38136', '20', '9', '30', '19', '19', '30', '115'),
(602, '305', '38136', '25', '15', '33', '23', '23', '33', '174'),
(603, '306', '63559', '20', '9', '30', '19', '19', '30', '2'),
(604, '306', '63559', '20', '9', '30', '19', '19', '30', '60'),
(605, '306', '63559', '20', '9', '30', '19', '19', '30', '115'),
(606, '306', '63559', '25', '15', '33', '23', '23', '33', '174'),
(607, '307', '33898', '20', '9', '30', '19', '19', '30', '2'),
(608, '307', '33898', '20', '9', '30', '19', '19', '30', '60'),
(609, '307', '33898', '20', '9', '30', '19', '19', '30', '115'),
(610, '307', '33898', '25', '15', '33', '23', '23', '33', '174'),
(611, '308', '38136', '20', '9', '30', '19', '19', '30', '2'),
(612, '308', '38136', '20', '9', '30', '19', '19', '30', '60'),
(613, '308', '38136', '20', '9', '30', '19', '19', '30', '115'),
(614, '308', '38136', '25', '15', '33', '23', '23', '33', '174'),
(615, '309', '67797', '20', '9', '30', '19', '19', '30', '2'),
(616, '309', '67797', '20', '9', '30', '19', '19', '30', '60'),
(617, '309', '67797', '20', '9', '30', '19', '19', '30', '115'),
(618, '309', '67797', '25', '15', '33', '23', '23', '33', '174');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses_price`
--
ALTER TABLE `courses_price`
  ADD PRIMARY KEY (`course_price_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses_price`
--
ALTER TABLE `courses_price`
  MODIFY `course_price_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=619;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
