-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 31, 2025 at 10:27 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eduportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `adminID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  PRIMARY KEY (`adminID`),
  KEY `admin_login_fk` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `userID`) VALUES
(1, 2),
(2, 318);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `attendanceID` int NOT NULL AUTO_INCREMENT,
  `studentID` int NOT NULL,
  `date` date NOT NULL,
  `periodNumber` int NOT NULL,
  `status` enum('absent','present','dl') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`attendanceID`),
  KEY `attendance_stud_fk` (`studentID`)
) ENGINE=InnoDB AUTO_INCREMENT=601 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendanceID`, `studentID`, `date`, `periodNumber`, `status`) VALUES
(1, 1, '2025-03-13', 2, 'dl'),
(2, 2, '2025-03-13', 2, 'present'),
(3, 3, '2025-03-13', 2, 'present'),
(4, 4, '2025-03-13', 2, 'present'),
(5, 5, '2025-03-13', 2, 'present'),
(6, 6, '2025-03-13', 2, 'present'),
(7, 7, '2025-03-13', 2, 'present'),
(8, 8, '2025-03-13', 2, 'present'),
(9, 9, '2025-03-13', 2, 'present'),
(10, 10, '2025-03-13', 2, 'present'),
(11, 11, '2025-03-13', 2, 'present'),
(12, 12, '2025-03-13', 2, 'present'),
(13, 13, '2025-03-13', 2, 'present'),
(14, 14, '2025-03-13', 2, 'present'),
(15, 15, '2025-03-13', 2, 'present'),
(16, 16, '2025-03-13', 2, 'present'),
(17, 17, '2025-03-13', 2, 'present'),
(18, 18, '2025-03-13', 2, 'present'),
(19, 19, '2025-03-13', 2, 'present'),
(20, 20, '2025-03-13', 2, 'present'),
(21, 21, '2025-03-13', 2, 'present'),
(22, 22, '2025-03-13', 2, 'present'),
(23, 23, '2025-03-13', 2, 'present'),
(24, 24, '2025-03-13', 2, 'present'),
(25, 25, '2025-03-13', 2, 'present'),
(26, 26, '2025-03-13', 2, 'present'),
(27, 27, '2025-03-13', 2, 'present'),
(28, 28, '2025-03-13', 2, 'present'),
(29, 29, '2025-03-13', 2, 'present'),
(30, 30, '2025-03-13', 2, 'present'),
(31, 116, '2025-03-13', 2, 'present'),
(32, 117, '2025-03-13', 2, 'absent'),
(33, 118, '2025-03-13', 2, 'present'),
(34, 119, '2025-03-13', 2, 'present'),
(35, 120, '2025-03-13', 2, 'present'),
(36, 121, '2025-03-13', 2, 'present'),
(37, 122, '2025-03-13', 2, 'present'),
(38, 123, '2025-03-13', 2, 'present'),
(39, 124, '2025-03-13', 2, 'present'),
(40, 125, '2025-03-13', 2, 'present'),
(41, 126, '2025-03-13', 2, 'present'),
(42, 127, '2025-03-13', 2, 'present'),
(43, 128, '2025-03-13', 2, 'present'),
(44, 129, '2025-03-13', 2, 'present'),
(45, 130, '2025-03-13', 2, 'present'),
(46, 131, '2025-03-13', 2, 'present'),
(47, 132, '2025-03-13', 2, 'present'),
(48, 133, '2025-03-13', 2, 'present'),
(49, 134, '2025-03-13', 2, 'present'),
(50, 135, '2025-03-13', 2, 'present'),
(51, 136, '2025-03-13', 2, 'present'),
(52, 137, '2025-03-13', 2, 'present'),
(53, 138, '2025-03-13', 2, 'present'),
(54, 139, '2025-03-13', 2, 'present'),
(55, 140, '2025-03-13', 2, 'present'),
(56, 141, '2025-03-13', 2, 'present'),
(57, 142, '2025-03-13', 2, 'present'),
(58, 143, '2025-03-13', 2, 'present'),
(59, 144, '2025-03-13', 2, 'present'),
(60, 145, '2025-03-13', 2, 'present'),
(61, 1, '2025-03-13', 5, 'dl'),
(62, 2, '2025-03-13', 5, 'present'),
(63, 3, '2025-03-13', 5, 'present'),
(64, 4, '2025-03-13', 5, 'present'),
(65, 5, '2025-03-13', 5, 'present'),
(66, 6, '2025-03-13', 5, 'present'),
(67, 7, '2025-03-13', 5, 'present'),
(68, 8, '2025-03-13', 5, 'present'),
(69, 9, '2025-03-13', 5, 'present'),
(70, 10, '2025-03-13', 5, 'present'),
(71, 11, '2025-03-13', 5, 'present'),
(72, 12, '2025-03-13', 5, 'present'),
(73, 13, '2025-03-13', 5, 'present'),
(74, 14, '2025-03-13', 5, 'present'),
(75, 15, '2025-03-13', 5, 'present'),
(76, 16, '2025-03-13', 5, 'present'),
(77, 17, '2025-03-13', 5, 'present'),
(78, 18, '2025-03-13', 5, 'present'),
(79, 19, '2025-03-13', 5, 'present'),
(80, 20, '2025-03-13', 5, 'present'),
(81, 21, '2025-03-13', 5, 'present'),
(82, 22, '2025-03-13', 5, 'present'),
(83, 23, '2025-03-13', 5, 'present'),
(84, 24, '2025-03-13', 5, 'present'),
(85, 25, '2025-03-13', 5, 'present'),
(86, 26, '2025-03-13', 5, 'present'),
(87, 27, '2025-03-13', 5, 'present'),
(88, 28, '2025-03-13', 5, 'present'),
(89, 29, '2025-03-13', 5, 'present'),
(90, 30, '2025-03-13', 5, 'present'),
(91, 1, '2025-03-13', 1, 'dl'),
(92, 2, '2025-03-13', 1, 'present'),
(93, 3, '2025-03-13', 1, 'present'),
(94, 4, '2025-03-13', 1, 'present'),
(95, 5, '2025-03-13', 1, 'present'),
(96, 6, '2025-03-13', 1, 'present'),
(97, 7, '2025-03-13', 1, 'present'),
(98, 8, '2025-03-13', 1, 'present'),
(99, 9, '2025-03-13', 1, 'present'),
(100, 10, '2025-03-13', 1, 'present'),
(101, 11, '2025-03-13', 1, 'present'),
(102, 12, '2025-03-13', 1, 'present'),
(103, 13, '2025-03-13', 1, 'present'),
(104, 14, '2025-03-13', 1, 'present'),
(105, 15, '2025-03-13', 1, 'present'),
(106, 16, '2025-03-13', 1, 'present'),
(107, 17, '2025-03-13', 1, 'present'),
(108, 18, '2025-03-13', 1, 'present'),
(109, 19, '2025-03-13', 1, 'present'),
(110, 20, '2025-03-13', 1, 'present'),
(111, 21, '2025-03-13', 1, 'present'),
(112, 22, '2025-03-13', 1, 'present'),
(113, 23, '2025-03-13', 1, 'present'),
(114, 24, '2025-03-13', 1, 'present'),
(115, 25, '2025-03-13', 1, 'present'),
(116, 26, '2025-03-13', 1, 'present'),
(117, 27, '2025-03-13', 1, 'present'),
(118, 28, '2025-03-13', 1, 'present'),
(119, 29, '2025-03-13', 1, 'present'),
(120, 30, '2025-03-13', 1, 'present'),
(121, 1, '2025-03-14', 3, 'present'),
(122, 2, '2025-03-14', 3, 'dl'),
(123, 3, '2025-03-14', 3, 'present'),
(124, 4, '2025-03-14', 3, 'present'),
(125, 5, '2025-03-14', 3, 'present'),
(126, 6, '2025-03-14', 3, 'present'),
(127, 7, '2025-03-14', 3, 'present'),
(128, 8, '2025-03-14', 3, 'present'),
(129, 9, '2025-03-14', 3, 'present'),
(130, 10, '2025-03-14', 3, 'present'),
(131, 11, '2025-03-14', 3, 'present'),
(132, 12, '2025-03-14', 3, 'present'),
(133, 13, '2025-03-14', 3, 'present'),
(134, 14, '2025-03-14', 3, 'present'),
(135, 15, '2025-03-14', 3, 'present'),
(136, 16, '2025-03-14', 3, 'present'),
(137, 17, '2025-03-14', 3, 'present'),
(138, 18, '2025-03-14', 3, 'present'),
(139, 19, '2025-03-14', 3, 'present'),
(140, 20, '2025-03-14', 3, 'present'),
(141, 21, '2025-03-14', 3, 'present'),
(142, 22, '2025-03-14', 3, 'present'),
(143, 23, '2025-03-14', 3, 'present'),
(144, 24, '2025-03-14', 3, 'present'),
(145, 25, '2025-03-14', 3, 'present'),
(146, 26, '2025-03-14', 3, 'present'),
(147, 27, '2025-03-14', 3, 'present'),
(148, 28, '2025-03-14', 3, 'present'),
(149, 29, '2025-03-14', 3, 'present'),
(150, 30, '2025-03-14', 3, 'present'),
(151, 1, '2025-03-17', 3, 'absent'),
(152, 2, '2025-03-17', 3, 'present'),
(153, 3, '2025-03-17', 3, 'present'),
(154, 4, '2025-03-17', 3, 'present'),
(155, 5, '2025-03-17', 3, 'present'),
(156, 6, '2025-03-17', 3, 'present'),
(157, 7, '2025-03-17', 3, 'present'),
(158, 8, '2025-03-17', 3, 'present'),
(159, 9, '2025-03-17', 3, 'present'),
(160, 10, '2025-03-17', 3, 'present'),
(161, 11, '2025-03-17', 3, 'present'),
(162, 12, '2025-03-17', 3, 'present'),
(163, 13, '2025-03-17', 3, 'present'),
(164, 14, '2025-03-17', 3, 'present'),
(165, 15, '2025-03-17', 3, 'present'),
(166, 16, '2025-03-17', 3, 'present'),
(167, 17, '2025-03-17', 3, 'present'),
(168, 18, '2025-03-17', 3, 'present'),
(169, 19, '2025-03-17', 3, 'present'),
(170, 20, '2025-03-17', 3, 'present'),
(171, 21, '2025-03-17', 3, 'present'),
(172, 22, '2025-03-17', 3, 'present'),
(173, 23, '2025-03-17', 3, 'present'),
(174, 24, '2025-03-17', 3, 'present'),
(175, 25, '2025-03-17', 3, 'present'),
(176, 26, '2025-03-17', 3, 'present'),
(177, 27, '2025-03-17', 3, 'present'),
(178, 28, '2025-03-17', 3, 'present'),
(179, 29, '2025-03-17', 3, 'present'),
(180, 30, '2025-03-17', 3, 'present'),
(181, 1, '2025-03-18', 5, 'present'),
(182, 2, '2025-03-18', 5, 'absent'),
(183, 3, '2025-03-18', 5, 'present'),
(184, 4, '2025-03-18', 5, 'present'),
(185, 5, '2025-03-18', 5, 'present'),
(186, 6, '2025-03-18', 5, 'present'),
(187, 7, '2025-03-18', 5, 'present'),
(188, 8, '2025-03-18', 5, 'present'),
(189, 9, '2025-03-18', 5, 'present'),
(190, 10, '2025-03-18', 5, 'present'),
(191, 11, '2025-03-18', 5, 'present'),
(192, 12, '2025-03-18', 5, 'present'),
(193, 13, '2025-03-18', 5, 'present'),
(194, 14, '2025-03-18', 5, 'present'),
(195, 15, '2025-03-18', 5, 'present'),
(196, 16, '2025-03-18', 5, 'present'),
(197, 17, '2025-03-18', 5, 'present'),
(198, 18, '2025-03-18', 5, 'present'),
(199, 19, '2025-03-18', 5, 'present'),
(200, 20, '2025-03-18', 5, 'present'),
(201, 21, '2025-03-18', 5, 'present'),
(202, 22, '2025-03-18', 5, 'present'),
(203, 23, '2025-03-18', 5, 'present'),
(204, 24, '2025-03-18', 5, 'present'),
(205, 25, '2025-03-18', 5, 'present'),
(206, 26, '2025-03-18', 5, 'present'),
(207, 27, '2025-03-18', 5, 'present'),
(208, 28, '2025-03-18', 5, 'present'),
(209, 29, '2025-03-18', 5, 'present'),
(210, 30, '2025-03-18', 5, 'present'),
(211, 1, '2025-03-31', 3, 'present'),
(212, 2, '2025-03-31', 3, 'present'),
(213, 3, '2025-03-31', 3, 'present'),
(214, 4, '2025-03-31', 3, 'present'),
(215, 5, '2025-03-31', 3, 'present'),
(216, 6, '2025-03-31', 3, 'present'),
(217, 7, '2025-03-31', 3, 'present'),
(218, 8, '2025-03-31', 3, 'present'),
(219, 9, '2025-03-31', 3, 'present'),
(220, 10, '2025-03-31', 3, 'present'),
(221, 11, '2025-03-31', 3, 'present'),
(222, 12, '2025-03-31', 3, 'present'),
(223, 13, '2025-03-31', 3, 'present'),
(224, 14, '2025-03-31', 3, 'present'),
(225, 15, '2025-03-31', 3, 'present'),
(226, 16, '2025-03-31', 3, 'present'),
(227, 17, '2025-03-31', 3, 'present'),
(228, 18, '2025-03-31', 3, 'present'),
(229, 19, '2025-03-31', 3, 'present'),
(230, 20, '2025-03-31', 3, 'present'),
(231, 21, '2025-03-31', 3, 'present'),
(232, 22, '2025-03-31', 3, 'present'),
(233, 23, '2025-03-31', 3, 'present'),
(234, 24, '2025-03-31', 3, 'present'),
(235, 25, '2025-03-31', 3, 'present'),
(236, 26, '2025-03-31', 3, 'present'),
(237, 27, '2025-03-31', 3, 'present'),
(238, 28, '2025-03-31', 3, 'present'),
(239, 29, '2025-03-31', 3, 'present'),
(240, 30, '2025-03-31', 3, 'present'),
(241, 1, '2025-04-25', 3, 'present'),
(242, 2, '2025-04-25', 3, 'present'),
(243, 3, '2025-04-25', 3, 'present'),
(244, 4, '2025-04-25', 3, 'present'),
(245, 5, '2025-04-25', 3, 'present'),
(246, 6, '2025-04-25', 3, 'present'),
(247, 7, '2025-04-25', 3, 'present'),
(248, 8, '2025-04-25', 3, 'present'),
(249, 9, '2025-04-25', 3, 'present'),
(250, 10, '2025-04-25', 3, 'present'),
(251, 11, '2025-04-25', 3, 'present'),
(252, 12, '2025-04-25', 3, 'present'),
(253, 13, '2025-04-25', 3, 'present'),
(254, 14, '2025-04-25', 3, 'present'),
(255, 15, '2025-04-25', 3, 'present'),
(256, 16, '2025-04-25', 3, 'present'),
(257, 17, '2025-04-25', 3, 'present'),
(258, 18, '2025-04-25', 3, 'present'),
(259, 19, '2025-04-25', 3, 'present'),
(260, 20, '2025-04-25', 3, 'present'),
(261, 21, '2025-04-25', 3, 'present'),
(262, 22, '2025-04-25', 3, 'present'),
(263, 23, '2025-04-25', 3, 'present'),
(264, 24, '2025-04-25', 3, 'present'),
(265, 25, '2025-04-25', 3, 'present'),
(266, 26, '2025-04-25', 3, 'present'),
(267, 27, '2025-04-25', 3, 'present'),
(268, 28, '2025-04-25', 3, 'present'),
(269, 29, '2025-04-25', 3, 'present'),
(270, 30, '2025-04-25', 3, 'present'),
(271, 1, '2025-03-28', 3, 'dl'),
(272, 2, '2025-03-28', 3, 'present'),
(273, 3, '2025-03-28', 3, 'present'),
(274, 4, '2025-03-28', 3, 'present'),
(275, 5, '2025-03-28', 3, 'present'),
(276, 6, '2025-03-28', 3, 'present'),
(277, 7, '2025-03-28', 3, 'present'),
(278, 8, '2025-03-28', 3, 'present'),
(279, 9, '2025-03-28', 3, 'present'),
(280, 10, '2025-03-28', 3, 'present'),
(281, 11, '2025-03-28', 3, 'present'),
(282, 12, '2025-03-28', 3, 'present'),
(283, 13, '2025-03-28', 3, 'present'),
(284, 14, '2025-03-28', 3, 'present'),
(285, 15, '2025-03-28', 3, 'present'),
(286, 16, '2025-03-28', 3, 'present'),
(287, 17, '2025-03-28', 3, 'present'),
(288, 18, '2025-03-28', 3, 'present'),
(289, 19, '2025-03-28', 3, 'present'),
(290, 20, '2025-03-28', 3, 'present'),
(291, 21, '2025-03-28', 3, 'present'),
(292, 22, '2025-03-28', 3, 'present'),
(293, 23, '2025-03-28', 3, 'present'),
(294, 24, '2025-03-28', 3, 'present'),
(295, 25, '2025-03-28', 3, 'present'),
(296, 26, '2025-03-28', 3, 'present'),
(297, 27, '2025-03-28', 3, 'present'),
(298, 28, '2025-03-28', 3, 'present'),
(299, 29, '2025-03-28', 3, 'present'),
(300, 30, '2025-03-28', 3, 'present'),
(301, 1, '2025-04-08', 5, 'absent'),
(302, 2, '2025-04-08', 5, 'present'),
(303, 3, '2025-04-08', 5, 'present'),
(304, 4, '2025-04-08', 5, 'present'),
(305, 5, '2025-04-08', 5, 'present'),
(306, 6, '2025-04-08', 5, 'present'),
(307, 7, '2025-04-08', 5, 'present'),
(308, 8, '2025-04-08', 5, 'present'),
(309, 9, '2025-04-08', 5, 'present'),
(310, 10, '2025-04-08', 5, 'present'),
(311, 11, '2025-04-08', 5, 'present'),
(312, 12, '2025-04-08', 5, 'present'),
(313, 13, '2025-04-08', 5, 'present'),
(314, 14, '2025-04-08', 5, 'present'),
(315, 15, '2025-04-08', 5, 'present'),
(316, 16, '2025-04-08', 5, 'present'),
(317, 17, '2025-04-08', 5, 'present'),
(318, 18, '2025-04-08', 5, 'present'),
(319, 19, '2025-04-08', 5, 'present'),
(320, 20, '2025-04-08', 5, 'present'),
(321, 21, '2025-04-08', 5, 'present'),
(322, 22, '2025-04-08', 5, 'present'),
(323, 23, '2025-04-08', 5, 'present'),
(324, 24, '2025-04-08', 5, 'present'),
(325, 25, '2025-04-08', 5, 'present'),
(326, 26, '2025-04-08', 5, 'present'),
(327, 27, '2025-04-08', 5, 'present'),
(328, 28, '2025-04-08', 5, 'present'),
(329, 29, '2025-04-08', 5, 'present'),
(330, 30, '2025-04-08', 5, 'present'),
(331, 1, '2025-03-27', 2, 'absent'),
(332, 2, '2025-03-27', 2, 'present'),
(333, 3, '2025-03-27', 2, 'present'),
(334, 4, '2025-03-27', 2, 'present'),
(335, 5, '2025-03-27', 2, 'present'),
(336, 6, '2025-03-27', 2, 'present'),
(337, 7, '2025-03-27', 2, 'present'),
(338, 8, '2025-03-27', 2, 'present'),
(339, 9, '2025-03-27', 2, 'present'),
(340, 10, '2025-03-27', 2, 'present'),
(341, 11, '2025-03-27', 2, 'present'),
(342, 12, '2025-03-27', 2, 'present'),
(343, 13, '2025-03-27', 2, 'present'),
(344, 14, '2025-03-27', 2, 'present'),
(345, 15, '2025-03-27', 2, 'present'),
(346, 16, '2025-03-27', 2, 'present'),
(347, 17, '2025-03-27', 2, 'present'),
(348, 18, '2025-03-27', 2, 'present'),
(349, 19, '2025-03-27', 2, 'present'),
(350, 20, '2025-03-27', 2, 'present'),
(351, 21, '2025-03-27', 2, 'present'),
(352, 22, '2025-03-27', 2, 'present'),
(353, 23, '2025-03-27', 2, 'present'),
(354, 24, '2025-03-27', 2, 'present'),
(355, 25, '2025-03-27', 2, 'present'),
(356, 26, '2025-03-27', 2, 'present'),
(357, 27, '2025-03-27', 2, 'present'),
(358, 28, '2025-03-27', 2, 'present'),
(359, 29, '2025-03-27', 2, 'present'),
(360, 30, '2025-03-27', 2, 'present'),
(361, 1, '2025-03-26', 1, 'absent'),
(362, 2, '2025-03-26', 1, 'absent'),
(363, 3, '2025-03-26', 1, 'present'),
(364, 4, '2025-03-26', 1, 'present'),
(365, 5, '2025-03-26', 1, 'present'),
(366, 6, '2025-03-26', 1, 'present'),
(367, 7, '2025-03-26', 1, 'present'),
(368, 8, '2025-03-26', 1, 'present'),
(369, 9, '2025-03-26', 1, 'present'),
(370, 10, '2025-03-26', 1, 'present'),
(371, 11, '2025-03-26', 1, 'present'),
(372, 12, '2025-03-26', 1, 'present'),
(373, 13, '2025-03-26', 1, 'present'),
(374, 14, '2025-03-26', 1, 'present'),
(375, 15, '2025-03-26', 1, 'present'),
(376, 16, '2025-03-26', 1, 'present'),
(377, 17, '2025-03-26', 1, 'present'),
(378, 18, '2025-03-26', 1, 'present'),
(379, 19, '2025-03-26', 1, 'present'),
(380, 20, '2025-03-26', 1, 'present'),
(381, 21, '2025-03-26', 1, 'present'),
(382, 22, '2025-03-26', 1, 'present'),
(383, 23, '2025-03-26', 1, 'present'),
(384, 24, '2025-03-26', 1, 'present'),
(385, 25, '2025-03-26', 1, 'present'),
(386, 26, '2025-03-26', 1, 'present'),
(387, 27, '2025-03-26', 1, 'present'),
(388, 28, '2025-03-26', 1, 'present'),
(389, 29, '2025-03-26', 1, 'present'),
(390, 30, '2025-03-26', 1, 'present'),
(391, 1, '2025-03-24', 3, 'absent'),
(392, 2, '2025-03-24', 3, 'absent'),
(393, 3, '2025-03-24', 3, 'present'),
(394, 4, '2025-03-24', 3, 'present'),
(395, 5, '2025-03-24', 3, 'present'),
(396, 6, '2025-03-24', 3, 'present'),
(397, 7, '2025-03-24', 3, 'present'),
(398, 8, '2025-03-24', 3, 'present'),
(399, 9, '2025-03-24', 3, 'present'),
(400, 10, '2025-03-24', 3, 'present'),
(401, 11, '2025-03-24', 3, 'present'),
(402, 12, '2025-03-24', 3, 'present'),
(403, 13, '2025-03-24', 3, 'present'),
(404, 14, '2025-03-24', 3, 'present'),
(405, 15, '2025-03-24', 3, 'present'),
(406, 16, '2025-03-24', 3, 'present'),
(407, 17, '2025-03-24', 3, 'present'),
(408, 18, '2025-03-24', 3, 'present'),
(409, 19, '2025-03-24', 3, 'present'),
(410, 20, '2025-03-24', 3, 'present'),
(411, 21, '2025-03-24', 3, 'present'),
(412, 22, '2025-03-24', 3, 'present'),
(413, 23, '2025-03-24', 3, 'present'),
(414, 24, '2025-03-24', 3, 'present'),
(415, 25, '2025-03-24', 3, 'present'),
(416, 26, '2025-03-24', 3, 'present'),
(417, 27, '2025-03-24', 3, 'present'),
(418, 28, '2025-03-24', 3, 'present'),
(419, 29, '2025-03-24', 3, 'present'),
(420, 30, '2025-03-24', 3, 'present'),
(541, 1, '2025-03-19', 1, 'absent'),
(542, 2, '2025-03-19', 1, 'absent'),
(543, 3, '2025-03-19', 1, 'present'),
(544, 4, '2025-03-19', 1, 'present'),
(545, 5, '2025-03-19', 1, 'present'),
(546, 6, '2025-03-19', 1, 'present'),
(547, 7, '2025-03-19', 1, 'present'),
(548, 8, '2025-03-19', 1, 'present'),
(549, 9, '2025-03-19', 1, 'present'),
(550, 10, '2025-03-19', 1, 'present'),
(551, 11, '2025-03-19', 1, 'present'),
(552, 12, '2025-03-19', 1, 'present'),
(553, 13, '2025-03-19', 1, 'present'),
(554, 14, '2025-03-19', 1, 'present'),
(555, 15, '2025-03-19', 1, 'present'),
(556, 16, '2025-03-19', 1, 'present'),
(557, 17, '2025-03-19', 1, 'present'),
(558, 18, '2025-03-19', 1, 'present'),
(559, 19, '2025-03-19', 1, 'present'),
(560, 20, '2025-03-19', 1, 'present'),
(561, 21, '2025-03-19', 1, 'present'),
(562, 22, '2025-03-19', 1, 'present'),
(563, 23, '2025-03-19', 1, 'present'),
(564, 24, '2025-03-19', 1, 'present'),
(565, 25, '2025-03-19', 1, 'present'),
(566, 26, '2025-03-19', 1, 'present'),
(567, 27, '2025-03-19', 1, 'present'),
(568, 28, '2025-03-19', 1, 'present'),
(569, 29, '2025-03-19', 1, 'present'),
(570, 30, '2025-03-19', 1, 'present'),
(571, 1, '2025-03-19', 6, 'absent'),
(572, 2, '2025-03-19', 6, 'present'),
(573, 3, '2025-03-19', 6, 'present'),
(574, 4, '2025-03-19', 6, 'present'),
(575, 5, '2025-03-19', 6, 'present'),
(576, 6, '2025-03-19', 6, 'present'),
(577, 7, '2025-03-19', 6, 'present'),
(578, 8, '2025-03-19', 6, 'present'),
(579, 9, '2025-03-19', 6, 'present'),
(580, 10, '2025-03-19', 6, 'present'),
(581, 11, '2025-03-19', 6, 'present'),
(582, 12, '2025-03-19', 6, 'present'),
(583, 13, '2025-03-19', 6, 'present'),
(584, 14, '2025-03-19', 6, 'present'),
(585, 15, '2025-03-19', 6, 'present'),
(586, 16, '2025-03-19', 6, 'present'),
(587, 17, '2025-03-19', 6, 'present'),
(588, 18, '2025-03-19', 6, 'present'),
(589, 19, '2025-03-19', 6, 'present'),
(590, 20, '2025-03-19', 6, 'present'),
(591, 21, '2025-03-19', 6, 'present'),
(592, 22, '2025-03-19', 6, 'present'),
(593, 23, '2025-03-19', 6, 'present'),
(594, 24, '2025-03-19', 6, 'present'),
(595, 25, '2025-03-19', 6, 'present'),
(596, 26, '2025-03-19', 6, 'present'),
(597, 27, '2025-03-19', 6, 'present'),
(598, 28, '2025-03-19', 6, 'present'),
(599, 29, '2025-03-19', 6, 'present'),
(600, 30, '2025-03-19', 6, 'present');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `classID` int NOT NULL AUTO_INCREMENT,
  `className` varchar(100) NOT NULL,
  `facultyID` int DEFAULT NULL,
  `workingDay` int NOT NULL DEFAULT '0',
  `instituteID` int NOT NULL,
  `numPeriods` int DEFAULT NULL,
  PRIMARY KEY (`classID`),
  UNIQUE KEY `className` (`className`),
  UNIQUE KEY `facultyID` (`facultyID`),
  KEY `class_faculty_fk` (`facultyID`),
  KEY `class_institute_fk` (`instituteID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`classID`, `className`, `facultyID`, `workingDay`, `instituteID`, `numPeriods`) VALUES
(1, 'Computer Science', 14, 16, 1, 6),
(27, 'Electrical Engineering', 7, 4, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `class_faculty`
--

DROP TABLE IF EXISTS `class_faculty`;
CREATE TABLE IF NOT EXISTS `class_faculty` (
  `classID` int DEFAULT NULL,
  `facultyID` int DEFAULT NULL,
  KEY `classID` (`classID`),
  KEY `facultyID` (`facultyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `class_faculty`
--

INSERT INTO `class_faculty` (`classID`, `facultyID`) VALUES
(1, 15),
(1, 18),
(1, 11),
(1, 13),
(27, 18),
(27, 16),
(27, 11),
(27, 12);

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

DROP TABLE IF EXISTS `exam`;
CREATE TABLE IF NOT EXISTS `exam` (
  `examID` int NOT NULL AUTO_INCREMENT,
  `examName` varchar(100) NOT NULL,
  `classID` int NOT NULL,
  `instituteID` int NOT NULL,
  PRIMARY KEY (`examID`),
  UNIQUE KEY `examName` (`examName`,`classID`),
  KEY `classID` (`classID`),
  KEY `instituteID` (`instituteID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `exam`
--

INSERT INTO `exam` (`examID`, `examName`, `classID`, `instituteID`) VALUES
(7, 'Internal Exam 1', 1, 1),
(8, 'Internal Exam 2', 1, 1),
(9, 'Internal Exam 1', 27, 1),
(13, 'Internal Exam 2', 27, 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_subject`
--

DROP TABLE IF EXISTS `exam_subject`;
CREATE TABLE IF NOT EXISTS `exam_subject` (
  `examID` int NOT NULL,
  `subjectID` int NOT NULL,
  `totalMarks` int NOT NULL,
  PRIMARY KEY (`examID`,`subjectID`),
  KEY `subjectID` (`subjectID`)
) ;

--
-- Dumping data for table `exam_subject`
--

INSERT INTO `exam_subject` (`examID`, `subjectID`, `totalMarks`) VALUES
(7, 11, 50),
(7, 13, 50),
(7, 14, 50),
(7, 15, 50),
(7, 18, 50),
(8, 11, 50),
(8, 13, 50),
(8, 14, 50),
(8, 15, 50),
(8, 18, 50),
(9, 7, 50),
(9, 11, 50),
(9, 12, 50),
(9, 16, 50),
(9, 18, 50),
(13, 7, 50),
(13, 11, 50),
(13, 12, 50),
(13, 16, 50),
(13, 18, 50);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
CREATE TABLE IF NOT EXISTS `faculty` (
  `facultyID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `instituteID` int NOT NULL,
  PRIMARY KEY (`facultyID`),
  KEY `faculty_user_fk` (`userID`),
  KEY `faculty_institute_fk` (`instituteID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`facultyID`, `userID`, `instituteID`) VALUES
(5, 3, 1),
(6, 4, 1),
(7, 5, 1),
(8, 6, 1),
(9, 7, 1),
(10, 8, 1),
(11, 9, 1),
(12, 10, 1),
(13, 11, 1),
(14, 12, 1),
(15, 13, 1),
(16, 14, 1),
(17, 15, 1),
(18, 16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `institute`
--

DROP TABLE IF EXISTS `institute`;
CREATE TABLE IF NOT EXISTS `institute` (
  `instituteID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `adminID` int NOT NULL,
  PRIMARY KEY (`instituteID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`instituteID`, `name`, `location`, `adminID`) VALUES
(1, 'Kottayam Institute of Technology', 'Kottayam,Kerala', 1),
(2, 'test1', 'dsada', 2);

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplication`
--

DROP TABLE IF EXISTS `leaveapplication`;
CREATE TABLE IF NOT EXISTS `leaveapplication` (
  `leaveID` int NOT NULL AUTO_INCREMENT,
  `studID` int NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `periods` varchar(50) NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `filePath` varchar(255) DEFAULT NULL,
  `status` enum('approved','rejected','pending') NOT NULL DEFAULT 'pending',
  `appliedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`leaveID`),
  KEY `leaveApply_student_fk` (`studID`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leaveapplication`
--

INSERT INTO `leaveapplication` (`leaveID`, `studID`, `startDate`, `endDate`, `periods`, `reason`, `filePath`, `status`, `appliedDate`) VALUES
(27, 2, '2025-03-21', '2025-03-21', '1,2,3,4,5,6', 'Jejejejjeh', 'uploads/duty_leave_2_1741867208.pdf', 'rejected', '2025-03-13 12:00:08'),
(28, 2, '2025-03-13', '2025-03-13', '1,2,3', 'Eheheh', 'uploads/duty_leave_2_1741867679.pdf', 'rejected', '2025-03-13 12:07:59'),
(39, 1, '2025-03-03', '2025-03-03', '1,2,5,6', 'Gehehhe', 'uploads/duty_leave_1_1743407793.png', 'rejected', '2025-03-31 07:56:33'),
(41, 1, '2025-03-28', '2025-03-28', '3', 'Fever', 'uploads/duty_leave_1_1743408069.php', 'approved', '2025-03-31 08:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `logincredentials`
--

DROP TABLE IF EXISTS `logincredentials`;
CREATE TABLE IF NOT EXISTS `logincredentials` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` enum('male','female') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('student','parent','faculty','admin') NOT NULL,
  `instituteID` int DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `un` (`email`),
  KEY `login_institute_fk` (`instituteID`)
) ENGINE=InnoDB AUTO_INCREMENT=329 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `logincredentials`
--

INSERT INTO `logincredentials` (`userID`, `email`, `password`, `name`, `gender`, `role`, `instituteID`) VALUES
(2, 'mathewpunnen8281@gmail.com', '$2y$10$dIatYkOQPw3zk6mYgd1wIO4RKK8HZ7UtYnPbEh8YY7VoW0Dibbwtu', 'Mathew Punnen Chandy', 'male', 'admin', 1),
(3, 'alex.johnson@college.edu', '$2y$10$uaqbr4c/AKSSikIF/nx5ZuKylew9Qcqf8KCaElddFOz6T1u2Nteb2', 'Alex Johnson', 'male', 'faculty', 1),
(4, 'emily.roberts@college.edu', '$2y$10$0Ku7PLgNu90j6j8TZqiby.71ewDLRY84FimUvKp8ippAtiENJfThi', 'Emily Roberts', 'female', 'faculty', 1),
(5, 'michael.smith@college.edu', '$2y$10$ZTK1YFsEKU/N1IsVKAxetORhkKmGIARntQHQECEkb29Nbpvuj8gvW', 'Michael Smith', 'male', 'faculty', 1),
(6, 'sarah.brown@college.edu', '$2y$10$mlDXHsfPeIqWHqKAZF2De.n5QBpcLymAw6vKwaRbUAQJlqgfMU7jm', 'Sarah Brown', 'female', 'faculty', 1),
(7, 'daniel.white@college.edu', '$2y$10$mQ4F6IBQVqXyK3AU9wEyPe6UZ2UDONslSpGj8Lp4BcStOufVG4g2u', 'Daniel White', 'male', 'faculty', 1),
(8, 'jessica.green@college.edu', '$2y$10$umpPOrYrHQLyx8pVqzfcyeMk6l63o4pftDs4SyZQIWPsvb0SYsXee', 'Jessica Green', 'female', 'faculty', 1),
(9, 'robert.adams@college.edu', '$2y$10$1sy5r/axAiAAbRihnE.ccOST4DpoVIXoNpMA.x5QkksaUyLY0iumG', 'Robert Adams', 'male', 'faculty', 1),
(10, 'olivia.taylor@college.edu', '$2y$10$0FU.Isq0gRTaEUpN66Eu1e7g70VsF7GI2vKF3QOWdw5mwDeKynkhS', 'Olivia Taylor', 'female', 'faculty', 1),
(11, 'alice.brown@college.com', '$2y$10$Wlc9alV7QtgSmEIyzUAdHORXp0IkWJV7zf8qhFMNiwLYNRhVFmdK6', 'Dr. Alice Brown', 'female', 'faculty', 1),
(12, 'john.smith@college.com', '$2y$10$sqA91eSuxEpZqdj600QrSOKnBkP80WxPHR2i8P.e0YO.l68CKcgwa', 'Mr. John Smith', 'male', 'faculty', 1),
(13, 'emily.davis@college.com', '$2y$10$VsuZATBndy2kKDVJVcAyle2KLeSB/gvfVZCljLeXEqnHTrHc9r8eC', 'Dr. Emily Davis', 'female', 'faculty', 1),
(14, 'mark.wilson@college.com', '$2y$10$BTtf1c2SukjTuA.toZX1HuyoHbKLQ7jIlJnYZjoeqcWbTqHlxuWUW', 'Prof. Mark Wilson', 'male', 'faculty', 1),
(15, 'sarah.lee@college.com', '$2y$10$2POabuyh3NwH44dBXexNuOp1uSJGPKVC8ukn8HvHTAq8ZCziXW8O6', 'Ms. Sarah Lee', 'female', 'faculty', 1),
(16, 'zach.ryder@college.com', '$2y$10$fIhZ3L1leFGbfEcHbBqLYO7KwMRAbeGkPdP.3/bfr5c93RkQXHiaS', 'Zach Ryder', 'male', 'faculty', 1),
(17, 'aarav.sharma@email.com', '$2y$10$8HQD.9I0mcehBWulWt8SwuIutWfZaqOgdNXSg9vwQBoWttsdu4n/W', 'Aarav Sharma', 'male', 'student', 1),
(18, 'rajesh.sharma@email.com', '$2y$10$eGBzwzMum2leGGZJMvZW..GACyGgMKzG91oyaldO7lqXyhzYGwaTq', 'Rajesh Sharma', 'male', 'parent', 1),
(19, 'aarohi.saxena@email.com', '$2y$10$ST5s/Si8RhgrNDd/rJXC1OsstQzBt03F46fC0HwMYTFPYoxH1A/E.', 'Aarohi Saxena', 'female', 'student', 1),
(20, 'kavita.saxena@email.com', '$2y$10$iy0JUOqyE./TsOQIJ34jrehxq7IotJH4oUjo67ZCDHsuXoTvk/nga', 'Kavita Saxena', 'female', 'parent', 1),
(21, 'aditi.roy@email.com', '$2y$10$mKSBgau3oGzr1pW4oMZuXOTd0.gi22rV/hdDtK0l21d3kczhtZnOq', 'Aditi Roy', 'female', 'student', 1),
(22, 'sourav.roy@email.com', '$2y$10$RCKBa7ix1z19Ya4WsH8m4uIlQqOjPNUa4Wd71M1oE3uuNIJ7aMVNe', 'Sourav Roy', 'female', 'parent', 1),
(23, 'aditi.saxena@email.com', '$2y$10$qXkvhb64kld3/HfkaC/.wOFIs47/8v.lKOPUZfZ8YpTOBaBl0JAhu', 'Aditi Saxena', 'female', 'student', 1),
(24, 'ramesh.saxena@email.com', '$2y$10$4XadTS55NF07Na9srclCo.Ibwo8laDWHB0YX1nvLsjywVidtpcpxe', 'Ramesh Saxena', 'female', 'parent', 1),
(25, 'aditya.malhotra@email.com', '$2y$10$9b0W1J55te0PzOFCNWJjJ.8ltLDwI4lZD66vDcTbBvlvrR/uAnLjy', 'Aditya Malhotra', 'male', 'student', 1),
(26, 'ramesh.malhotra@email.com', '$2y$10$uOU5fqq.96cdC3BXLFSMYOy1Oq5jobBe13K9gevFj0lUOKPn4KxtO', 'Ramesh Malhotra', 'male', 'parent', 1),
(27, 'advik.patel@email.com', '$2y$10$EjLHdRODu6hUyCchAVRdyuj0eKO74.StbVkVn5lGQK4/2IDG7qy8K', 'Advik Patel', 'male', 'student', 1),
(28, 'kiran.patel@email.com', '$2y$10$kWQIkJM.lITmsQgs1.SCYugYXWsox7wJ3g06rVpaj/bkPQ48QJUmm', 'Kiran Patel', 'male', 'parent', 1),
(29, 'aisha.sheikh@email.com', '$2y$10$8UoL/Cf3opojRx78h0LpHeSyMpaCluOl0Hddxf1BQj2X2EQrFVSxm', 'Aisha Sheikh', 'female', 'student', 1),
(30, 'farah.sheikh@email.com', '$2y$10$eF3cCCuP66eBazUBmnOHdOpAbaFmBnJxjeWlo79qDcB8LBg3RlMeO', 'Farah Sheikh', 'female', 'parent', 1),
(31, 'aman.singh@email.com', '$2y$10$FdY5PqXpBdJlbRBvn.ePOOxOga8rQLY9OyxorEqwJ3B3UeggWLlQy', 'Aman Singh', 'male', 'student', 1),
(32, 'sunil.singh@email.com', '$2y$10$3VkCZWWqUyLNvez9VPW6U.lEzmQOf7nZWV7/IlKbQtlw6g3GQaBfu', 'Sunil Singh', 'male', 'parent', 1),
(33, 'amitabh.nair@email.com', '$2y$10$/HKX11uoI4ospAdE2fMFmeOGLI7cPkoq3qBkPmjewF0JHB.zzSEby', 'Amitabh Nair', 'male', 'student', 1),
(34, 'madhav.nair@email.com', '$2y$10$4OwE1oXSMKEFWD2P7fnrteP6jSrwh8xcKOyHsUhqaAZgrOHV765B.', 'Madhav Nair', 'male', 'parent', 1),
(35, 'ananya.iyer@email.com', '$2y$10$qCi7QKGRpItoVIUHBdFhB.5sUN4Lh4TrTc0lA4w9nyxodFfRRlHka', 'Ananya Iyer', 'female', 'student', 1),
(36, 'meera.iyer@email.com', '$2y$10$RMXeqYTp6cH6AjdXLpvh1uhzuyLuUPt8JhNIjl9qbIbgDn5tGH.c2', 'Meera Iyer', 'female', 'parent', 1),
(37, 'arjun.mehta@email.com', '$2y$10$cAd/Q2VRzVYLEzJjcgEjqOof1Xcj3FOvWTHey2ZmXZouPPRpShRYu', 'Arjun Mehta', 'male', 'student', 1),
(38, 'sanjay.mehta@email.com', '$2y$10$kvTJZYiMkuUNejybayxOfuJVapYhS0TXNeBInus9EOuiCiklkUIjG', 'Sanjay Mehta', 'male', 'parent', 1),
(39, 'aryan.verma@email.com', '$2y$10$WeBlEMhKd0qY1TNnyvjnzu/i37eWAW6kt6YccnALgV86Ijwa.W17u', 'Aryan Verma', 'male', 'student', 1),
(40, 'prakash.verma@email.com', '$2y$10$HsdNuhIgk43.6kF9vT7S.OJ4aYVXKTC34g/YbYx.9d9USs3Skwy7W', 'Prakash Verma', 'male', 'parent', 1),
(41, 'devendra.kulkarni@email.com', '$2y$10$EVDCrktWC8RJ6imr4VN4R.R.tVv/HbjwdT8wd8Cwp64DfoT/xib5K', 'Devendra Kulkarni', 'male', 'student', 1),
(42, 'dilip.kulkarni@email.com', '$2y$10$tE.sQJTw9Rqzj9z.scKY3eBPPYFxC7Han.apV8DnOdvEuvOrtcluC', 'Dilip Kulkarni', 'male', 'parent', 1),
(43, 'divya.kapoor@email.com', '$2y$10$79YiXFit8K4haxtTAzhcCuvnl1HABetQxB1FMzr3ubJd7tHVpj1bi', 'Divya Kapoor', 'female', 'student', 1),
(44, 'mona.kapoor@email.com', '$2y$10$FTwHSOt7/rw5BOw5/DQp8eHcKkWWGO.I0RBjSX69n10cLtDMaNvcy', 'Mona Kapoor', 'female', 'parent', 1),
(45, 'diya.nair@email.com', '$2y$10$QZGqhJs8lM10a.UuCHQ09OhoQrxUWgRUGbhPs6sDP5HIRrkxbn7B.', 'Diya Nair', 'female', 'student', 1),
(46, 'suresh.nair@email.com', '$2y$10$hEj02LYCvNiQZ5.QWYVNMOwc33kxH/AFiPv4yz.qxEwNvt/ZIaK6u', 'Suresh Nair', 'female', 'parent', 1),
(47, 'gautam.nanda@email.com', '$2y$10$nQfVR/SJJrFwnFtmA20U6uZx.jiUEIOVOLeclcPHhW5ZPBcLK71em', 'Gautam Nanda', 'male', 'student', 1),
(48, 'sandeep.nanda@email.com', '$2y$10$vKVXo.0vm0Gi/sZqWRz.V.GmslJ9KWnIDKHc3LWrJVTIDB1nMA/Em', 'Sandeep Nanda', 'male', 'parent', 1),
(49, 'harsh.tiwari@email.com', '$2y$10$aPEeV/bCa8GnnJldRBdv4ezszCixF2IfXYVkIhDgJllntyYShci3O', 'Harsh Tiwari', 'male', 'student', 1),
(50, 'rajeev.tiwari@email.com', '$2y$10$n7dogCcHp.LEr5oAeSqute8.ALGSs4eVHXGhMa0qm7R.lmui.emS2', 'Rajeev Tiwari', 'male', 'parent', 1),
(51, 'ishaan.reddy@email.com', '$2y$10$9H62jM/yKx5N6UeG3I6FQuCxvdEEkqHd5ciMe0zyuwChEX/U3v3xS', 'Ishaan Reddy', 'male', 'student', 1),
(52, 'kavitha.reddy@email.com', '$2y$10$iMYgD24MUPTNZIEqAC2DyewUh6H3S3E6vB.GTTqc27x5gLNqw6HZy', 'Kavitha Reddy', 'male', 'parent', 1),
(53, 'ishant.chopra@email.com', '$2y$10$mb.VtbIjpZl.ADI8Dhf6B.plAbnmEdpn63HjJzJ71iwlnyw5PwCCi', 'Ishant Chopra', 'male', 'student', 1),
(54, 'shiv.chopra@email.com', '$2y$10$YrmqdMwENbxQHwNz3rK/iuV66Q4L8FhcdyN3FUzRMN1YgGU95dYv6', 'Shiv Chopra', 'male', 'parent', 1),
(55, 'ishika.sharma@email.com', '$2y$10$HtWU/wIyajg.7BWGyMiLE.S8jBu7Hewb8xjkl42GISVu1S4ppM.gK', 'Ishika Sharma', 'female', 'student', 1),
(56, 'manju.sharma@email.com', '$2y$10$HwzzJtrxG.Zq8oew9gS5JuqsEV2.HQJpE1YPb.vPkcC/rIAaN3vdy', 'Manju Sharma', 'female', 'parent', 1),
(57, 'kabir.singh@email.com', '$2y$10$n1doOfj5kegKbTPzKiqLfuX2p8hKCQ3YsPlTcpkyH5e/vhZHXaJHS', 'Kabir Singh', 'male', 'student', 1),
(58, 'ajay.singh@email.com', '$2y$10$EwXp5UZ/H75uv5P7VHQJ8.1YM3AIQMH98HN95TBwo2ItYqJ1cKmdG', 'Ajay Singh', 'male', 'parent', 1),
(59, 'karthik.iyer@email.com', '$2y$10$9xjOudkavCPM6zkDdRoo0Oasa/JJnpFbA6LL8v5lFbLtJif6Uq26y', 'Karthik Iyer', 'male', 'student', 1),
(60, 'vikram.iyer@email.com', '$2y$10$Vkvx4hTfiQ03mtKBDPHeFOcAU6941e8AlMSgLK6w5/39GCnjw0e62', 'Vikram Iyer', 'male', 'parent', 1),
(61, 'kavya.menon@email.com', '$2y$10$.dOgjyliwZIuG39eBzAXK.3aQ6oMDC.I62I3QK0CXtSiCKa9Mco7e', 'Kavya Menon', 'female', 'student', 1),
(62, 'sunita.menon@email.com', '$2y$10$HV9kGxH56ZILUOqbQLXQCuSSQ41g4NkIlRVnVJxusL8L5wyPSBMH6', 'Sunita Menon', 'female', 'parent', 1),
(63, 'kunal.sen@email.com', '$2y$10$YsW.ayCryTfKrqV95iK4w..ZbUWOqFW26UY1pJ3eVcBQnW5YCtASa', 'Kunal Sen', 'male', 'student', 1),
(64, 'anil.sen@email.com', '$2y$10$PZJZBsVhfGfD7EQspLVkJO.XIDCcxNNFARHqROalG1uSIqrXFFYWS', 'Anil Sen', 'male', 'parent', 1),
(65, 'meera.joshi@email.com', '$2y$10$hgaw4l54nZx/UmR1IbgeAuWliOvGqxH4I/TlNGezzb6ofzkJ3b9wK', 'Meera Joshi', 'female', 'student', 1),
(66, 'amit.joshi@email.com', '$2y$10$.M769gF.m6dwSi8ERV1LsuQhAqSMGf3jh9ououx1h.sEth8VmfwxO', 'Amit Joshi', 'female', 'parent', 1),
(67, 'mira.ahuja@email.com', '$2y$10$ELVrOd9kxRjsAoaYkbQn3uC1zdmbE/Gs7KPpR8.t9d0WR7XzaNOQW', 'Mira Ahuja', 'female', 'student', 1),
(68, 'meenal.ahuja@email.com', '$2y$10$No2AdJumdtxPPhggw9ICJ.bjaLYxR4SFXVrhyAeKw4z8ylYWLKsaS', 'Meenal Ahuja', 'female', 'parent', 1),
(69, 'neha.bansal@email.com', '$2y$10$6DGFu7yP6CQTGt5oMK241u8cB/39TPQK1A/HghHXVitUZSk/M/zYu', 'Neha Bansal', 'female', 'student', 1),
(70, 'poonam.bansal@email.com', '$2y$10$oXIQkWegYgJlaiWuUJpMBeEhjL3Rq140wfaOaoFqTyf/oavvXB/gW', 'Poonam Bansal', 'female', 'parent', 1),
(71, 'nisha.jain@email.com', '$2y$10$4KKMKQ/jfBdiG2170lPG9.r/bhWjrU8sb/2GQMO8Mlud/u5zgH1DC', 'Nisha Jain', 'female', 'student', 1),
(72, 'ritu.jain@email.com', '$2y$10$PRzSWMwsp1YftqJJm.MvluBwnc5MhYxu6fN4/e3MZTHgMUOM1mdZK', 'Ritu Jain', 'female', 'parent', 1),
(73, 'nitin.rajput@email.com', '$2y$10$ILc7y5U8HszEw8BZmXQcR.aSY8linFFe1ycRYOCcg7Axy9wZODBKS', 'Nitin Rajput', 'male', 'student', 1),
(74, 'vikas.rajput@email.com', '$2y$10$YcCYIneaNzAEZwk3gXMiBeu4gEqX2arZXLecJwpT1oSRbvrKOGfGW', 'Vikas Rajput', 'male', 'parent', 1),
(75, 'omkar.pillai@email.com', '$2y$10$ub2FYUznivalQN8hloqbI.A.jggL3.96rE3fZmG4NKMX6OEl//jKi', 'Omkar Pillai', 'male', 'student', 1),
(76, 'vishal.pillai@email.com', '$2y$10$UL1AfOM.aioas.EwolQksOEDql3Oj4K5NVCskpES9OKtoLnwL6xMC', 'Vishal Pillai', 'male', 'parent', 1),
(257, 'aarush.kapoor@email.com', '$2y$10$soLIzJcFkgTuPUvIFt.MwuMQTWug9xi9YE.IWG1Vh/x5zego912vS', 'Aarush Kapoor', 'male', 'student', 1),
(258, 'rohit.kapoor@email.com', '$2y$10$XFWnHEdT0GYh.tsmZHTdceOimhBCPG8RK67kAu8Z/4i/CNBXbNdP.', 'Rohit Kapoor', 'male', 'parent', 1),
(259, 'aayesha.khan@email.com', '$2y$10$MmUHBpG2lAz3xoCc2eeNWeix11GP.BycO0fyk3oVtNR/rkka0qc2G', 'Aayesha Khan', 'female', 'student', 1),
(260, 'sameena.khan@email.com', '$2y$10$hWCOXLz.8bnfNeMquiBd2uQ3tT/HTIJJzCWXQ812Rd2XH0z4z/7kO', 'Sameena Khan', 'female', 'parent', 1),
(261, 'abhinav.sharma@email.com', '$2y$10$ooAtFe6NvCE79f8BRQ3LPePdEsY4w35b7bossMPxiAK7gzOFsxTu2', 'Abhinav Sharma', 'male', 'student', 1),
(262, 'vinod.sharma@email.com', '$2y$10$/ZdmoYyN5iFhpy1NjEQZw.XtY6C2nU8dXXrqfEo6ziY65trgkz88m', 'Vinod Sharma', 'male', 'parent', 1),
(263, 'alok.mehta@email.com', '$2y$10$yTDwe88/kzeR8NCAueDAxe.UruLEf5/PEyvR/DzuOL9Jno6I96EVW', 'Alok Mehta', 'male', 'student', 1),
(264, 'ramesh.mehta@email.com', '$2y$10$.1WYU.PqtY.8Js/5yxiQxOQcmN/K25HrTKHcqSQLllrD2p6KBruTW', 'Ramesh Mehta', 'male', 'parent', 1),
(265, 'anjali.verma@email.com', '$2y$10$luyCGn9t6UOkG9U0Tzk38.3v8UREy5oPaMy/pxY2Gx9wiR.X1lRs2', 'Anjali Verma', 'female', 'student', 1),
(266, 'pratibha.verma@email.com', '$2y$10$oAQkAI/WzVvo.e31MVG.d.AqKxuqPc/MsJXqRIoaF.m3vNHOVhxbm', 'Pratibha Verma', 'female', 'parent', 1),
(267, 'arya.bhatt@email.com', '$2y$10$5vp7YW/RtP.QwA1.xHNQpOr4U23UoEAOODnLxc2A5i2TRIq9sGDya', 'Arya Bhatt', 'female', 'student', 1),
(268, 'neeta.bhatt@email.com', '$2y$10$rj7VR/fTQS0GLCBVHgw11OFRMJjEDepu77yl3u/LYXzPv2Ogw0fvm', 'Neeta Bhatt', 'female', 'parent', 1),
(269, 'chetan.nair@email.com', '$2y$10$tQgR8WqGYPmqiVaHb4luA.lxoT5a0lYtf68NSZdt4LOWC88eeIfdm', 'Chetan Nair', 'male', 'student', 1),
(270, 'subhash.nair@email.com', '$2y$10$v/PSz2lGiJxBwbozr58B2.S5ADk6bfrZFYtMCVbiYpFuaYrQ2fcO6', 'Subhash Nair', 'male', 'parent', 1),
(271, 'charu.malhotra@email.com', '$2y$10$dnPOpHrxfgv.gqul4I3Zc.G19Jzz0qW3cdGPsyUAhceDaWLdpSq9S', 'Charu Malhotra', 'female', 'student', 1),
(272, 'radhika.malhotra@email.com', '$2y$10$FUoC1oJj.kZj6T1Rd3eURuPCvYvvVJC2LlRKOFYedbbkN/oqoPmZe', 'Radhika Malhotra', 'female', 'parent', 1),
(273, 'deepak.reddy@email.com', '$2y$10$zxZIl6elTX7qYWzMDhDdIeaJOdTc2Pt/x2P8uu5BtDI98Pm4Zg1zu', 'Deepak Reddy', 'male', 'student', 1),
(274, 'suresh.reddy@email.com', '$2y$10$do8jZW8m4hjJOFg64AAd5.uMJLBE7QQEdT7QZ.4OWKfuZQmVG79Ka', 'Suresh Reddy', 'male', 'parent', 1),
(275, 'esha.iyer@email.com', '$2y$10$cV22uJATuTrDxpOCvI2uL.1SlnM0FYNZTFJAUqMlrrr7DK4dEyKUK', 'Esha Iyer', 'female', 'student', 1),
(276, 'meenal.iyer@email.com', '$2y$10$r8gb4Tww4hpSJROIziQgw.W8M8vbif9uLvceTppVr6M6OZlpweA6e', 'Meenal Iyer', 'female', 'parent', 1),
(277, 'farhan.shaikh@email.com', '$2y$10$.2Po1aPjGRsl4rT2hzixD.u.SMvPqoyaccvbzi3aZE0805C6EiTTC', 'Farhan Shaikh', 'male', 'student', 1),
(278, 'javed.shaikh@email.com', '$2y$10$mKNcjFrB4OZCfaUSAUByAudpT5fR4rmaW.pt37KU7NZCIUVCd/oNS', 'Javed Shaikh', 'male', 'parent', 1),
(279, 'gauri.joshi@email.com', '$2y$10$vhDR/2Zpdp8XU94qdyqFiO0wx0aTIIRIt4eRe2gb9eOdpiGPEdc36', 'Gauri Joshi', 'female', 'student', 1),
(280, 'sanjay.joshi@email.com', '$2y$10$X8WlDc/7ng4O/ZOgV3N4Pemf3a9y7ekL665NQSGgdlX3he5JN31Fm', 'Sanjay Joshi', 'male', 'parent', 1),
(281, 'harsh.tandon@email.com', '$2y$10$Mwh.wgXN39jcTezFR0ud2.DtWYYOmtp/KdUQoDTuHhl0cZatHx6za', 'Harsh Tandon', 'male', 'student', 1),
(282, 'rajiv.tandon@email.com', '$2y$10$xhyewQxvIbqWr/ZMfQBFDunqDUlZrpENdYZAkWtFr2FyCiMMCDSxq', 'Rajiv Tandon', 'male', 'parent', 1),
(283, 'ishita.das@email.com', '$2y$10$lMiRqIjerCazJaCHTeqT3Ol92/oiqwXIIk/25ClQygoACJaJ5TufC', 'Ishita Das', 'female', 'student', 1),
(284, 'kavita.das@email.com', '$2y$10$OR9R0wQsMmzGEQTDJkmnfO5yz5DmRV92iDCZJ12sre6iZV1sTO5qy', 'Kavita Das', 'female', 'parent', 1),
(285, 'jatin.kulkarni@email.com', '$2y$10$ZUCGKGzyPylIxE7ABips4.CQJUEahNmz7MH1YBgqBw8zYaYox3Iii', 'Jatin Kulkarni', 'male', 'student', 1),
(286, 'uday.kulkarni@email.com', '$2y$10$UELrUUrdRW097jZgfRPT3e/d.ViTP6uplEEhF17E9KlxOXzFWGkg.', 'Uday Kulkarni', 'male', 'parent', 1),
(287, 'kavish.chopra@email.com', '$2y$10$pS4d1cw33Q2gKJEVS12r7e1HQ7GMuoKmv3PKAMclAc.uFsrxv1NBy', 'Kavish Chopra', 'male', 'student', 1),
(288, 'anil.chopra@email.com', '$2y$10$25c57vq9QFDlTNFvdmlqeuVEI7UtjXFs8xGyRNejxfbIh3v/X/lvW', 'Anil Chopra', 'male', 'parent', 1),
(289, 'kritika.sen@email.com', '$2y$10$xSlfL.D217m3WS.Cm.V1QumaPvedbeL7lugd79Ugojrn9T7iAiL.a', 'Kritika Sen', 'female', 'student', 1),
(290, 'seema.sen@email.com', '$2y$10$qfOvecVI8zVaAvjZ7azgRu3M1oCK2DYrfAvvCoe.7X6IN7aLHwfcq', 'Seema Sen', 'female', 'parent', 1),
(291, 'lakshay.singh@email.com', '$2y$10$Blx1wV5rF/bXIuw3i9SzXegfCLFY/7Xl7/0bRYUjTp34gGxjHIO0u', 'Lakshay Singh', 'male', 'student', 1),
(292, 'arjun.singh@email.com', '$2y$10$1FhdK0nFKaDQU/iYFQhq7uNNWfQjCsQA0/kMqXjoX1drZR847llaK', 'Arjun Singh', 'male', 'parent', 1),
(293, 'manvi.mishra@email.com', '$2y$10$zqg7a/8i22wMmlI/Z9o8cecP/yRJ5Ddhbw7J.JXhbv1nRvi4IPJPC', 'Manvi Mishra', 'female', 'student', 1),
(294, 'sunita.mishra@email.com', '$2y$10$lH5MltUpocDqwYoFOCpOdeQBGaxt.OgdmW38yb4tlOh0tAN1Bjoq6', 'Sunita Mishra', 'female', 'parent', 1),
(295, 'mohan.raj@email.com', '$2y$10$rm6D6wA5sidIBgjbyOtyuem73eQYicstJY0FzYICdoi0WQ/e9VMUy', 'Mohan Raj', 'male', 'student', 1),
(296, 'ramesh.raj@email.com', '$2y$10$svCUubhnt3V6I0.CL.sCx.kGFtVap5Rc3CI/CUKYEXFL969SKANqe', 'Ramesh Raj', 'male', 'parent', 1),
(297, 'nandini.jain@email.com', '$2y$10$UnJJLVZSGTx28W/Oo43sZu6zdB.vDqa2d24heWzWh.46noX5gnGyW', 'Nandini Jain', 'female', 'student', 1),
(298, 'reena.jain@email.com', '$2y$10$XoLyZEjQSXTurUkwdrHTZ.9b9DLi1yUUQ3KqzJJFH/b5iC4PDbVlO', 'Reena Jain', 'female', 'parent', 1),
(299, 'neeraj.bhardwaj@email.com', '$2y$10$aHmbcW2tRr9pqBj2EAPcUu0EiVB1lG0oYKeVtKuSm2274O1csQ3D.', 'Neeraj Bhardwaj', 'male', 'student', 1),
(300, 'vikas.bhardwaj@email.com', '$2y$10$ZdlVPLwlQFX/wBJpcQQGxO8gz3LmmZL4xHVMP0DwxBZuQgLIoYYcW', 'Vikas Bhardwaj', 'male', 'parent', 1),
(301, 'om.prakash@email.com', '$2y$10$gL5zxL3UU6jEQI/Kd2pscOjwWSKirxF8SqLMCLbvn/EK9hqTwAAxe', 'Om Prakash', 'male', 'student', 1),
(302, 'shyamlal.prakash@email.com', '$2y$10$6FV67YDzc3x3c8/ANAEDSOZwiwnW6GdL1UwINFwiRHzGx/KQdtL5W', 'Shyamlal Prakash', 'male', 'parent', 1),
(303, 'pallavi.kaur@email.com', '$2y$10$JKmEWcu3Xyph9ICOnC4nIOOL79GQKsBH7IW59Lk2UcUdANfTQymLy', 'Pallavi Kaur', 'female', 'student', 1),
(304, 'simran.kaur@email.com', '$2y$10$GwZn0ZGF9nreEYX99aGJJuUdA7cvpYp4.hlrmnTTOi8AK2F6e7mMq', 'Simran Kaur', 'female', 'parent', 1),
(305, 'piyush.saxena@email.com', '$2y$10$TWaBrKH5R2Qb1Q5VpqafeuDMCUf93Mk1FUWnQ4Vv.SLLgzxKzxPlW', 'Piyush Saxena', 'male', 'student', 1),
(306, 'rakesh.saxena@email.com', '$2y$10$0WZsVXAjlHZazbTS6GqowuOoUCRM20Kbbo16kbqUQ1N59oKcC3z.i', 'Rakesh Saxena', 'male', 'parent', 1),
(307, 'rahul.sethi@email.com', '$2y$10$LtLjGMAfiy4NFUc6MztJ9ebv43knUW/nGOx2YVVN497f/9uBhG75G', 'Rahul Sethi', 'male', 'student', 1),
(308, 'vinay.sethi@email.com', '$2y$10$J8TH9/60rMXMYZYT.VWbZOFZMa/XBLbgqr.56p83hWvmCGB4hZqqq', 'Vinay Sethi', 'male', 'parent', 1),
(309, 'rhea.desai@email.com', '$2y$10$6PM6qrj7K5NwUMu6F2Lve.aUAoQk4kSOlLYuAdbtQehiGUc6sFP6S', 'Rhea Desai', 'female', 'student', 1),
(310, 'namrata.desai@email.com', '$2y$10$ByKcwkQWXq7PUctxkl3DdOQnizJeUItabsheKJt15JeIyPLWoG8yu', 'Namrata Desai', 'female', 'parent', 1),
(311, 'sahil.arora@email.com', '$2y$10$hoZQZcggyVna75Xlbbdo3uVW9LrdbWPynNd.1JqlCyYCu6KBR7xkm', 'Sahil Arora', 'male', 'student', 1),
(312, 'vijay.arora@email.com', '$2y$10$VU8708/GPcwrTZSdQts6Gu/iLajzoYEd/t9LmRRDn1voJlFnBOwLe', 'Vijay Arora', 'male', 'parent', 1),
(313, 'tanya.kapoor@email.com', '$2y$10$QaGiCFI2ZqJKPJhT7SS7OeZC7RXAJhm90EHMkM3.6O62BUMMH0FtO', 'Tanya Kapoor', 'female', 'student', 1),
(314, 'meenal.kapoor@email.com', '$2y$10$A8piOfNv59BeAWBZfbSymuZCtIr81qMMChVK5TvBnfE/hBvbGeWeK', 'Meenal Kapoor', 'female', 'parent', 1),
(315, 'uday.patel@email.com', '$2y$10$/S6iqX8RPUGwPV6U2.3bFO6DcTzOR4rPzicAWHbpVr0FW6Itpqb8O', 'Uday Patel', 'male', 'student', 1),
(316, 'harish.patel@email.com', '$2y$10$ETS3jIz/M2GuHUljiGBcB.AS0u4vn8Fhsi06RLnV9ZGAwi6SdPw7K', 'Harish Patel', 'male', 'parent', 1),
(318, 'test@gmail.com', '$2y$10$ex.gtejzujWM6QVmbcGbGOdhanlxRZSd8oVNMgfM7ERSyF1/ichNe', 'test', 'male', 'admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `notificationID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','warning','success','error') DEFAULT 'info',
  `isRead` tinyint(1) DEFAULT '0',
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notificationID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notificationID`, `userID`, `message`, `type`, `isRead`, `createdAt`) VALUES
(1, 17, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(2, 18, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(3, 19, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(4, 20, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(5, 21, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(6, 22, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(7, 23, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(8, 24, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(9, 25, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(10, 26, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(11, 27, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(12, 28, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(13, 29, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(14, 30, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(15, 31, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(16, 32, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(17, 33, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(18, 34, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(19, 35, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(20, 36, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(21, 37, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(22, 38, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(23, 39, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(24, 40, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(25, 41, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(26, 42, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(27, 43, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(28, 44, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(29, 45, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(30, 46, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(31, 47, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(32, 48, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(33, 49, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(34, 50, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(35, 51, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(36, 52, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(37, 53, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(38, 54, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(39, 55, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(40, 56, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(41, 57, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(42, 58, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(43, 59, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(44, 60, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(45, 61, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(46, 62, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(47, 63, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(48, 64, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(49, 65, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(50, 66, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(51, 67, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(52, 68, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(53, 69, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(54, 70, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(55, 71, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(56, 72, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(57, 73, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(58, 74, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(59, 75, 'Your result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(60, 76, 'Your child\'s result for Internal Exam 1 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:16:00'),
(65, 17, 'You were marked as absent for the class on 2025-03-19 during period 1', 'warning', 0, '2025-03-31 15:56:55'),
(66, 18, 'Your child was marked as absent on 2025-03-19 during period 1', 'warning', 0, '2025-03-31 15:56:55'),
(67, 19, 'You were marked as absent for the class on 2025-03-19 during period 1', 'warning', 0, '2025-03-31 15:56:55'),
(68, 20, 'Your child was marked as absent on 2025-03-19 during period 1', 'warning', 0, '2025-03-31 15:56:55'),
(69, 17, 'You were marked as absent for the class on 2025-03-19 during period 6', 'warning', 0, '2025-03-31 15:58:01'),
(70, 18, 'Your child was marked as absent on 2025-03-19 during period 6', 'warning', 0, '2025-03-31 15:58:01'),
(71, 17, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 1, '2025-03-31 21:33:43'),
(72, 18, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(73, 19, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(74, 20, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(75, 21, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(76, 22, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(77, 23, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(78, 24, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(79, 25, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(80, 26, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(81, 27, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(82, 28, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(83, 29, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(84, 30, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(85, 31, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(86, 32, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(87, 33, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(88, 34, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(89, 35, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(90, 36, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(91, 37, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(92, 38, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(93, 39, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(94, 40, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(95, 41, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(96, 42, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(97, 43, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(98, 44, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(99, 45, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(100, 46, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(101, 47, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(102, 48, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(103, 49, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(104, 50, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(105, 51, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(106, 52, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(107, 53, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(108, 54, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(109, 55, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(110, 56, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(111, 57, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(112, 58, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(113, 59, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(114, 60, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(115, 61, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(116, 62, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(117, 63, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(118, 64, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(119, 65, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(120, 66, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(121, 67, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(122, 68, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(123, 69, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(124, 70, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(125, 71, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(126, 72, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(127, 73, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(128, 74, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(129, 75, 'Your result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43'),
(130, 76, 'Your child\'s result for Internal Exam 2 - Artificial Intelligence has been uploaded.', 'success', 0, '2025-03-31 21:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

DROP TABLE IF EXISTS `parent`;
CREATE TABLE IF NOT EXISTS `parent` (
  `parentID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `instituteID` int NOT NULL,
  PRIMARY KEY (`parentID`),
  KEY `parent_login_fk` (`userID`),
  KEY `parent_institute_fk` (`instituteID`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`parentID`, `userID`, `instituteID`) VALUES
(1, 18, 1),
(2, 20, 1),
(3, 22, 1),
(4, 24, 1),
(5, 26, 1),
(6, 28, 1),
(7, 30, 1),
(8, 32, 1),
(9, 34, 1),
(10, 36, 1),
(11, 38, 1),
(12, 40, 1),
(13, 42, 1),
(14, 44, 1),
(15, 46, 1),
(16, 48, 1),
(17, 50, 1),
(18, 52, 1),
(19, 54, 1),
(20, 56, 1),
(21, 58, 1),
(22, 60, 1),
(23, 62, 1),
(24, 64, 1),
(25, 66, 1),
(26, 68, 1),
(27, 70, 1),
(28, 72, 1),
(29, 74, 1),
(30, 76, 1),
(116, 258, 1),
(117, 260, 1),
(118, 262, 1),
(119, 264, 1),
(120, 266, 1),
(121, 268, 1),
(122, 270, 1),
(123, 272, 1),
(124, 274, 1),
(125, 276, 1),
(126, 278, 1),
(127, 280, 1),
(128, 282, 1),
(129, 284, 1),
(130, 286, 1),
(131, 288, 1),
(132, 290, 1),
(133, 292, 1),
(134, 294, 1),
(135, 296, 1),
(136, 298, 1),
(137, 300, 1),
(138, 302, 1),
(139, 304, 1),
(140, 306, 1),
(141, 308, 1),
(142, 310, 1),
(143, 312, 1),
(144, 314, 1),
(145, 316, 1);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

DROP TABLE IF EXISTS `result`;
CREATE TABLE IF NOT EXISTS `result` (
  `resultID` int NOT NULL AUTO_INCREMENT,
  `studentID` int NOT NULL,
  `instituteID` int NOT NULL,
  `subjectID` int NOT NULL,
  `examID` int NOT NULL,
  `classID` int NOT NULL,
  `markObtained` decimal(5,2) DEFAULT NULL,
  `totalMark` decimal(5,2) NOT NULL,
  PRIMARY KEY (`resultID`),
  UNIQUE KEY `unique_result` (`studentID`,`examID`,`subjectID`),
  KEY `subjectID` (`subjectID`),
  KEY `examID` (`examID`),
  KEY `instituteID` (`instituteID`),
  KEY `classID` (`classID`)
) ENGINE=InnoDB AUTO_INCREMENT=603 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`resultID`, `studentID`, `instituteID`, `subjectID`, `examID`, `classID`, `markObtained`, `totalMark`) VALUES
(1, 1, 1, 14, 7, 1, 41.00, 50.00),
(2, 2, 1, 14, 7, 1, 44.00, 50.00),
(3, 3, 1, 14, 7, 1, 35.00, 50.00),
(4, 4, 1, 14, 7, 1, 25.00, 50.00),
(5, 5, 1, 14, 7, 1, 50.00, 50.00),
(6, 6, 1, 14, 7, 1, 45.00, 50.00),
(7, 7, 1, 14, 7, 1, 43.00, 50.00),
(8, 8, 1, 14, 7, 1, 24.00, 50.00),
(9, 9, 1, 14, 7, 1, 43.00, 50.00),
(10, 10, 1, 14, 7, 1, 42.00, 50.00),
(11, 11, 1, 14, 7, 1, 24.00, 50.00),
(12, 12, 1, 14, 7, 1, 50.00, 50.00),
(13, 13, 1, 14, 7, 1, 33.00, 50.00),
(14, 14, 1, 14, 7, 1, 33.00, 50.00),
(15, 15, 1, 14, 7, 1, 33.00, 50.00),
(16, 16, 1, 14, 7, 1, 33.00, 50.00),
(17, 17, 1, 14, 7, 1, 44.00, 50.00),
(18, 18, 1, 14, 7, 1, 22.00, 50.00),
(19, 19, 1, 14, 7, 1, 22.00, 50.00),
(20, 20, 1, 14, 7, 1, 15.00, 50.00),
(21, 21, 1, 14, 7, 1, 44.00, 50.00),
(22, 22, 1, 14, 7, 1, 33.00, 50.00),
(23, 23, 1, 14, 7, 1, 22.00, 50.00),
(24, 24, 1, 14, 7, 1, 32.00, 50.00),
(25, 25, 1, 14, 7, 1, 42.00, 50.00),
(26, 26, 1, 14, 7, 1, 24.00, 50.00),
(27, 27, 1, 14, 7, 1, 32.00, 50.00),
(28, 28, 1, 14, 7, 1, 23.00, 50.00),
(29, 29, 1, 14, 7, 1, 44.00, 50.00),
(30, 30, 1, 14, 7, 1, 11.00, 50.00),
(91, 1, 1, 11, 7, 1, 49.00, 50.00),
(92, 2, 1, 11, 7, 1, 50.00, 50.00),
(93, 3, 1, 11, 7, 1, 23.00, 50.00),
(94, 4, 1, 11, 7, 1, 33.00, 50.00),
(95, 5, 1, 11, 7, 1, 44.00, 50.00),
(96, 6, 1, 11, 7, 1, 25.00, 50.00),
(97, 7, 1, 11, 7, 1, 11.00, 50.00),
(98, 8, 1, 11, 7, 1, 13.00, 50.00),
(99, 9, 1, 11, 7, 1, 50.00, 50.00),
(100, 10, 1, 11, 7, 1, 46.00, 50.00),
(101, 11, 1, 11, 7, 1, 45.00, 50.00),
(102, 12, 1, 11, 7, 1, 47.00, 50.00),
(103, 13, 1, 11, 7, 1, 48.00, 50.00),
(104, 14, 1, 11, 7, 1, 23.00, 50.00),
(105, 15, 1, 11, 7, 1, 24.00, 50.00),
(106, 16, 1, 11, 7, 1, 14.00, 50.00),
(107, 17, 1, 11, 7, 1, 50.00, 50.00),
(108, 18, 1, 11, 7, 1, 13.00, 50.00),
(109, 19, 1, 11, 7, 1, 39.00, 50.00),
(110, 20, 1, 11, 7, 1, 36.00, 50.00),
(111, 21, 1, 11, 7, 1, 36.50, 50.00),
(112, 22, 1, 11, 7, 1, 49.00, 50.00),
(113, 23, 1, 11, 7, 1, 45.50, 50.00),
(114, 24, 1, 11, 7, 1, 29.00, 50.00),
(115, 25, 1, 11, 7, 1, 50.00, 50.00),
(116, 26, 1, 11, 7, 1, 46.00, 50.00),
(117, 27, 1, 11, 7, 1, 41.00, 50.00),
(118, 28, 1, 11, 7, 1, 40.00, 50.00),
(119, 29, 1, 11, 7, 1, 34.00, 50.00),
(120, 30, 1, 11, 7, 1, 31.00, 50.00),
(151, 1, 1, 15, 7, 1, 50.00, 50.00),
(152, 2, 1, 15, 7, 1, 36.00, 50.00),
(153, 3, 1, 15, 7, 1, 36.00, 50.00),
(154, 4, 1, 15, 7, 1, 23.00, 50.00),
(155, 5, 1, 15, 7, 1, 50.00, 50.00),
(156, 6, 1, 15, 7, 1, 49.00, 50.00),
(157, 7, 1, 15, 7, 1, 41.00, 50.00),
(158, 8, 1, 15, 7, 1, 29.00, 50.00),
(159, 9, 1, 15, 7, 1, 27.00, 50.00),
(160, 10, 1, 15, 7, 1, 28.00, 50.00),
(161, 11, 1, 15, 7, 1, 25.00, 50.00),
(162, 12, 1, 15, 7, 1, 19.00, 50.00),
(163, 13, 1, 15, 7, 1, 36.00, 50.00),
(164, 14, 1, 15, 7, 1, 34.00, 50.00),
(165, 15, 1, 15, 7, 1, 39.00, 50.00),
(166, 16, 1, 15, 7, 1, 19.00, 50.00),
(167, 17, 1, 15, 7, 1, 24.00, 50.00),
(168, 18, 1, 15, 7, 1, 22.00, 50.00),
(169, 19, 1, 15, 7, 1, 41.00, 50.00),
(170, 20, 1, 15, 7, 1, 34.00, 50.00),
(171, 21, 1, 15, 7, 1, 29.00, 50.00),
(172, 22, 1, 15, 7, 1, 24.00, 50.00),
(173, 23, 1, 15, 7, 1, 27.00, 50.00),
(174, 24, 1, 15, 7, 1, 50.00, 50.00),
(175, 25, 1, 15, 7, 1, 46.00, 50.00),
(176, 26, 1, 15, 7, 1, 32.00, 50.00),
(177, 27, 1, 15, 7, 1, 33.00, 50.00),
(178, 28, 1, 15, 7, 1, 33.00, 50.00),
(179, 29, 1, 15, 7, 1, 39.00, 50.00),
(180, 30, 1, 15, 7, 1, 44.00, 50.00),
(211, 1, 1, 11, 8, 1, 50.00, 50.00),
(212, 2, 1, 11, 8, 1, 33.00, 50.00),
(213, 3, 1, 11, 8, 1, 38.00, 50.00),
(214, 4, 1, 11, 8, 1, 50.00, 50.00),
(215, 5, 1, 11, 8, 1, 19.00, 50.00),
(216, 6, 1, 11, 8, 1, 28.00, 50.00),
(217, 7, 1, 11, 8, 1, 41.00, 50.00),
(218, 8, 1, 11, 8, 1, 39.00, 50.00),
(219, 9, 1, 11, 8, 1, 29.00, 50.00),
(220, 10, 1, 11, 8, 1, 35.00, 50.00),
(221, 11, 1, 11, 8, 1, 44.00, 50.00),
(222, 12, 1, 11, 8, 1, 46.00, 50.00),
(223, 13, 1, 11, 8, 1, 18.00, 50.00),
(224, 14, 1, 11, 8, 1, 35.00, 50.00),
(225, 15, 1, 11, 8, 1, 39.00, 50.00),
(226, 16, 1, 11, 8, 1, 37.00, 50.00),
(227, 17, 1, 11, 8, 1, 46.00, 50.00),
(228, 18, 1, 11, 8, 1, 28.00, 50.00),
(229, 19, 1, 11, 8, 1, 39.00, 50.00),
(230, 20, 1, 11, 8, 1, 43.00, 50.00),
(231, 21, 1, 11, 8, 1, 46.00, 50.00),
(232, 22, 1, 11, 8, 1, 48.00, 50.00),
(233, 23, 1, 11, 8, 1, 26.00, 50.00),
(234, 24, 1, 11, 8, 1, 21.00, 50.00),
(235, 25, 1, 11, 8, 1, 22.00, 50.00),
(236, 26, 1, 11, 8, 1, 36.00, 50.00),
(237, 27, 1, 11, 8, 1, 34.00, 50.00),
(238, 28, 1, 11, 8, 1, 37.00, 50.00),
(239, 29, 1, 11, 8, 1, 43.00, 50.00),
(240, 30, 1, 11, 8, 1, 44.00, 50.00),
(361, 1, 1, 14, 8, 1, 40.00, 50.00),
(362, 2, 1, 14, 8, 1, 34.00, 50.00),
(363, 3, 1, 14, 8, 1, 26.00, 50.00),
(364, 4, 1, 14, 8, 1, 50.00, 50.00),
(365, 5, 1, 14, 8, 1, 45.00, 50.00),
(366, 6, 1, 14, 8, 1, 47.00, 50.00),
(367, 7, 1, 14, 8, 1, 42.00, 50.00),
(368, 8, 1, 14, 8, 1, 42.00, 50.00),
(369, 9, 1, 14, 8, 1, 42.00, 50.00),
(370, 10, 1, 14, 8, 1, 42.00, 50.00),
(371, 11, 1, 14, 8, 1, 42.00, 50.00),
(372, 12, 1, 14, 8, 1, 42.00, 50.00),
(373, 13, 1, 14, 8, 1, 42.00, 50.00),
(374, 14, 1, 14, 8, 1, 42.00, 50.00),
(375, 15, 1, 14, 8, 1, 42.00, 50.00),
(376, 16, 1, 14, 8, 1, 42.00, 50.00),
(377, 17, 1, 14, 8, 1, 42.00, 50.00),
(378, 18, 1, 14, 8, 1, 42.00, 50.00),
(379, 19, 1, 14, 8, 1, 42.00, 50.00),
(380, 20, 1, 14, 8, 1, 42.00, 50.00),
(381, 21, 1, 14, 8, 1, 42.00, 50.00),
(382, 22, 1, 14, 8, 1, 42.00, 50.00),
(383, 23, 1, 14, 8, 1, 42.00, 50.00),
(384, 24, 1, 14, 8, 1, 42.00, 50.00),
(385, 25, 1, 14, 8, 1, 42.00, 50.00),
(386, 26, 1, 14, 8, 1, 42.00, 50.00),
(387, 27, 1, 14, 8, 1, 42.00, 50.00),
(388, 28, 1, 14, 8, 1, 42.00, 50.00),
(389, 29, 1, 14, 8, 1, 42.00, 50.00),
(390, 30, 1, 14, 8, 1, 33.00, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `studID` int NOT NULL AUTO_INCREMENT,
  `userID` int NOT NULL,
  `instituteID` int NOT NULL,
  `parentID` int NOT NULL,
  `classID` int NOT NULL,
  `RollNo` int NOT NULL,
  `attendedClass` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`studID`),
  KEY `stud_class_fk` (`classID`),
  KEY `stud_parent_fk` (`parentID`),
  KEY `stud_login_fk` (`userID`),
  KEY `stud_institute_fk` (`instituteID`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studID`, `userID`, `instituteID`, `parentID`, `classID`, `RollNo`, `attendedClass`) VALUES
(1, 17, 1, 1, 1, 1, 10),
(2, 19, 1, 2, 1, 2, 14),
(3, 21, 1, 3, 1, 3, 17),
(4, 23, 1, 4, 1, 4, 17),
(5, 25, 1, 5, 1, 5, 17),
(6, 27, 1, 6, 1, 6, 17),
(7, 29, 1, 7, 1, 7, 17),
(8, 31, 1, 8, 1, 8, 17),
(9, 33, 1, 9, 1, 9, 17),
(10, 35, 1, 10, 1, 10, 17),
(11, 37, 1, 11, 1, 11, 17),
(12, 39, 1, 12, 1, 12, 17),
(13, 41, 1, 13, 1, 13, 17),
(14, 43, 1, 14, 1, 14, 17),
(15, 45, 1, 15, 1, 15, 17),
(16, 47, 1, 16, 1, 16, 17),
(17, 49, 1, 17, 1, 17, 17),
(18, 51, 1, 18, 1, 18, 17),
(19, 53, 1, 19, 1, 19, 17),
(20, 55, 1, 20, 1, 20, 17),
(21, 57, 1, 21, 1, 21, 17),
(22, 59, 1, 22, 1, 22, 17),
(23, 61, 1, 23, 1, 23, 17),
(24, 63, 1, 24, 1, 24, 17),
(25, 65, 1, 25, 1, 25, 17),
(26, 67, 1, 26, 1, 26, 17),
(27, 69, 1, 27, 1, 27, 17),
(28, 71, 1, 28, 1, 28, 17),
(29, 73, 1, 29, 1, 29, 17),
(30, 75, 1, 30, 1, 30, 17),
(116, 257, 1, 116, 27, 1, 2),
(117, 259, 1, 117, 27, 2, 2),
(118, 261, 1, 118, 27, 3, 4),
(119, 263, 1, 119, 27, 4, 4),
(120, 265, 1, 120, 27, 5, 4),
(121, 267, 1, 121, 27, 6, 4),
(122, 269, 1, 122, 27, 7, 4),
(123, 271, 1, 123, 27, 8, 4),
(124, 273, 1, 124, 27, 9, 4),
(125, 275, 1, 125, 27, 10, 4),
(126, 277, 1, 126, 27, 11, 4),
(127, 279, 1, 127, 27, 12, 4),
(128, 281, 1, 128, 27, 13, 4),
(129, 283, 1, 129, 27, 14, 4),
(130, 285, 1, 130, 27, 15, 4),
(131, 287, 1, 131, 27, 16, 4),
(132, 289, 1, 132, 27, 17, 4),
(133, 291, 1, 133, 27, 18, 4),
(134, 293, 1, 134, 27, 19, 4),
(135, 295, 1, 135, 27, 20, 4),
(136, 297, 1, 136, 27, 21, 4),
(137, 299, 1, 137, 27, 22, 4),
(138, 301, 1, 138, 27, 23, 4),
(139, 303, 1, 139, 27, 24, 4),
(140, 305, 1, 140, 27, 25, 4),
(141, 307, 1, 141, 27, 26, 4),
(142, 309, 1, 142, 27, 27, 4),
(143, 311, 1, 143, 27, 28, 4),
(144, 313, 1, 144, 27, 29, 4),
(145, 315, 1, 145, 27, 30, 4);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `subjectID` int NOT NULL AUTO_INCREMENT,
  `subjectName` varchar(100) NOT NULL,
  `facultyID` int NOT NULL,
  `instituteID` int NOT NULL,
  `classID` int DEFAULT NULL,
  PRIMARY KEY (`subjectID`),
  UNIQUE KEY `subjectName` (`subjectName`),
  KEY `subj_faculty_fk` (`facultyID`),
  KEY `subj_institute_fk` (`instituteID`),
  KEY `subject_class_fk` (`classID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subjectID`, `subjectName`, `facultyID`, `instituteID`, `classID`) VALUES
(5, 'Computer Science', 5, 1, NULL),
(6, 'Business Management', 6, 1, NULL),
(7, 'Electrical Engineering', 7, 1, NULL),
(8, 'Psychology', 8, 1, NULL),
(9, 'Mechanical Engineering', 9, 1, NULL),
(10, 'Economics', 10, 1, NULL),
(11, 'Mathematics', 11, 1, NULL),
(12, 'Literature', 12, 1, NULL),
(13, 'Data Science', 13, 1, NULL),
(14, 'Artificial Intelligence', 14, 1, NULL),
(15, 'Cybersecurity', 15, 1, NULL),
(16, 'Robotics', 16, 1, NULL),
(17, 'Cloud Computing', 17, 1, NULL),
(18, 'Networks', 18, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

DROP TABLE IF EXISTS `timetable`;
CREATE TABLE IF NOT EXISTS `timetable` (
  `timetableID` int NOT NULL AUTO_INCREMENT,
  `classID` int NOT NULL,
  `dayOfWeek` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
  `periodNumber` int NOT NULL,
  `facultyID` int NOT NULL,
  `instituteID` int NOT NULL,
  PRIMARY KEY (`timetableID`),
  UNIQUE KEY `unique_timetable` (`classID`,`dayOfWeek`,`periodNumber`),
  KEY `timetable_class_fk` (`classID`),
  KEY `timetable_faculty_fk` (`facultyID`),
  KEY `timetable_institute_fk` (`instituteID`)
) ENGINE=InnoDB AUTO_INCREMENT=2190 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `timetable`
--

INSERT INTO `timetable` (`timetableID`, `classID`, `dayOfWeek`, `periodNumber`, `facultyID`, `instituteID`) VALUES
(1920, 27, 'Monday', 1, 11, 1),
(1921, 27, 'Monday', 2, 7, 1),
(1922, 27, 'Monday', 3, 16, 1),
(1923, 27, 'Monday', 4, 11, 1),
(1924, 27, 'Monday', 5, 18, 1),
(1925, 27, 'Monday', 6, 12, 1),
(1926, 27, 'Tuesday', 1, 16, 1),
(1927, 27, 'Tuesday', 2, 18, 1),
(1928, 27, 'Tuesday', 3, 16, 1),
(1929, 27, 'Tuesday', 4, 7, 1),
(1930, 27, 'Tuesday', 5, 11, 1),
(1931, 27, 'Tuesday', 6, 12, 1),
(1932, 27, 'Wednesday', 1, 18, 1),
(1933, 27, 'Wednesday', 2, 16, 1),
(1934, 27, 'Wednesday', 3, 12, 1),
(1935, 27, 'Wednesday', 4, 11, 1),
(1936, 27, 'Wednesday', 5, 7, 1),
(1937, 27, 'Wednesday', 6, 7, 1),
(1938, 27, 'Thursday', 1, 18, 1),
(1939, 27, 'Thursday', 2, 16, 1),
(1940, 27, 'Thursday', 3, 12, 1),
(1941, 27, 'Thursday', 4, 16, 1),
(1942, 27, 'Thursday', 5, 11, 1),
(1943, 27, 'Thursday', 6, 7, 1),
(1944, 27, 'Friday', 1, 16, 1),
(1945, 27, 'Friday', 2, 18, 1),
(1946, 27, 'Friday', 3, 12, 1),
(1947, 27, 'Friday', 4, 11, 1),
(1948, 27, 'Friday', 5, 16, 1),
(1949, 27, 'Friday', 6, 11, 1),
(2160, 1, 'Monday', 1, 13, 1),
(2161, 1, 'Monday', 2, 13, 1),
(2162, 1, 'Monday', 3, 14, 1),
(2163, 1, 'Monday', 4, 15, 1),
(2164, 1, 'Monday', 5, 18, 1),
(2165, 1, 'Monday', 6, 18, 1),
(2166, 1, 'Tuesday', 1, 18, 1),
(2167, 1, 'Tuesday', 2, 11, 1),
(2168, 1, 'Tuesday', 3, 11, 1),
(2169, 1, 'Tuesday', 4, 13, 1),
(2170, 1, 'Tuesday', 5, 14, 1),
(2171, 1, 'Tuesday', 6, 15, 1),
(2172, 1, 'Wednesday', 1, 14, 1),
(2173, 1, 'Wednesday', 2, 11, 1),
(2174, 1, 'Wednesday', 3, 13, 1),
(2175, 1, 'Wednesday', 4, 15, 1),
(2176, 1, 'Wednesday', 5, 18, 1),
(2177, 1, 'Wednesday', 6, 14, 1),
(2178, 1, 'Thursday', 1, 11, 1),
(2179, 1, 'Thursday', 2, 14, 1),
(2180, 1, 'Thursday', 3, 11, 1),
(2181, 1, 'Thursday', 4, 18, 1),
(2182, 1, 'Thursday', 5, 15, 1),
(2183, 1, 'Thursday', 6, 15, 1),
(2184, 1, 'Friday', 1, 18, 1),
(2185, 1, 'Friday', 2, 15, 1),
(2186, 1, 'Friday', 3, 14, 1),
(2187, 1, 'Friday', 4, 13, 1),
(2188, 1, 'Friday', 5, 11, 1),
(2189, 1, 'Friday', 6, 18, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_login_fk` FOREIGN KEY (`userID`) REFERENCES `logincredentials` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_stud_fk` FOREIGN KEY (`studentID`) REFERENCES `student` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_faculty_fk` FOREIGN KEY (`facultyID`) REFERENCES `faculty` (`facultyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_institute_fk` FOREIGN KEY (`instituteID`) REFERENCES `institute` (`instituteID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class_faculty`
--
ALTER TABLE `class_faculty`
  ADD CONSTRAINT `class_faculty_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`),
  ADD CONSTRAINT `class_faculty_ibfk_2` FOREIGN KEY (`facultyID`) REFERENCES `faculty` (`facultyID`);

--
-- Constraints for table `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `exam_ibfk_1` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`),
  ADD CONSTRAINT `exam_ibfk_2` FOREIGN KEY (`instituteID`) REFERENCES `institute` (`instituteID`);

--
-- Constraints for table `exam_subject`
--
ALTER TABLE `exam_subject`
  ADD CONSTRAINT `exam_subject_ibfk_1` FOREIGN KEY (`examID`) REFERENCES `exam` (`examID`),
  ADD CONSTRAINT `exam_subject_ibfk_2` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_institute_fk` FOREIGN KEY (`instituteID`) REFERENCES `institute` (`instituteID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `faculty_user_fk` FOREIGN KEY (`userID`) REFERENCES `logincredentials` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD CONSTRAINT `leaveApply_student_fk` FOREIGN KEY (`studID`) REFERENCES `student` (`studID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logincredentials`
--
ALTER TABLE `logincredentials`
  ADD CONSTRAINT `login_institute_fk` FOREIGN KEY (`instituteID`) REFERENCES `institute` (`instituteID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `logincredentials` (`userID`);

--
-- Constraints for table `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `parent_institute_fk` FOREIGN KEY (`instituteID`) REFERENCES `institute` (`instituteID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `parent_login_fk` FOREIGN KEY (`userID`) REFERENCES `logincredentials` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student` (`studID`),
  ADD CONSTRAINT `result_ibfk_2` FOREIGN KEY (`subjectID`) REFERENCES `subject` (`subjectID`),
  ADD CONSTRAINT `result_ibfk_3` FOREIGN KEY (`examID`) REFERENCES `exam` (`examID`),
  ADD CONSTRAINT `result_ibfk_4` FOREIGN KEY (`instituteID`) REFERENCES `institute` (`instituteID`),
  ADD CONSTRAINT `result_ibfk_5` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `stud_class_fk` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stud_institute_fk` FOREIGN KEY (`instituteID`) REFERENCES `institute` (`instituteID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stud_login_fk` FOREIGN KEY (`userID`) REFERENCES `logincredentials` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stud_parent_fk` FOREIGN KEY (`parentID`) REFERENCES `parent` (`parentID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subj_faculty_fk` FOREIGN KEY (`facultyID`) REFERENCES `faculty` (`facultyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subj_institute_fk` FOREIGN KEY (`instituteID`) REFERENCES `institute` (`instituteID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_class_fk` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timetable`
--
ALTER TABLE `timetable`
  ADD CONSTRAINT `timetable_class_fk` FOREIGN KEY (`classID`) REFERENCES `class` (`classID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `timetable_faculty_fk` FOREIGN KEY (`facultyID`) REFERENCES `faculty` (`facultyID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `timetable_institute_fk` FOREIGN KEY (`instituteID`) REFERENCES `institute` (`instituteID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
