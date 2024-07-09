-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 08:31 AM
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
-- Database: `imperia`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_ques`
--

CREATE TABLE `add_ques` (
  `id` int(11) NOT NULL,
  `ques_no` varchar(255) NOT NULL,
  `question` varchar(500) NOT NULL,
  `opt1` varchar(255) NOT NULL,
  `opt2` varchar(255) NOT NULL,
  `opt3` varchar(255) NOT NULL,
  `opt4` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `catergory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_ques`
--

INSERT INTO `add_ques` (`id`, `ques_no`, `question`, `opt1`, `opt2`, `opt3`, `opt4`, `answer`, `catergory`) VALUES
(76, '1', 'who helps you and me a lot yo who helps you anhg,hg', 'sjyit', 'tekeleye', 'tekeleye', 'eddy', 'eddy', 'des'),
(77, '2', 'who helps you and me a lot yo who helps you anhg,hgt', 'sjyit', 'tekeleye', 'tekeleye', 'eddy', 'eddy', 'des'),
(78, '1', 'who helps you and me a lot yo who helps you anhg,hgt', 'sjyit', 'tekeleye', 'tekeleye', 'eddy', 'eddy', 'exam '),
(79, '2', 'who helps you and me a lot yo who helps you anhg,hgthds', 'sjyit', 'tekeleye', 'tekeleye', 'eddy', 'eddy', 'exam '),
(80, '3', 'who helps you and me a lot yo who helps you anhg,hgthdst', 'sjyit', 'tekeleye', 'tekeleye', 'eddy', 'eddy', 'exam ');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `online_status` enum('online','offline') NOT NULL DEFAULT 'offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `username`, `online_status`) VALUES
(1, 'desu@gmail.com', 'desu123', 'dustin', 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `answerlikes`
--

CREATE TABLE `answerlikes` (
  `Like_id` int(11) NOT NULL,
  `Student_id` int(11) DEFAULT NULL,
  `Answer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answerlikes`
--

INSERT INTO `answerlikes` (`Like_id`, `Student_id`, `Answer_id`) VALUES
(3, 3, 1),
(2, 3, 2),
(1, 3, 3),
(12, 3, 4),
(11, 3, 10),
(17, 17, 1),
(14, 17, 2),
(15, 17, 4),
(18, 17, 26);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `A_id` int(11) NOT NULL,
  `Q_id` int(11) DEFAULT NULL,
  `A_stu_id` int(11) DEFAULT NULL,
  `A_body` longtext DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `a_timestamp` datetime DEFAULT current_timestamp(),
  `A_image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`A_id`, `Q_id`, `A_stu_id`, `A_body`, `likes`, `a_timestamp`, `A_image`) VALUES
(1, 2, 4, 'hf ', 36, '2024-03-29 22:58:00', NULL),
(2, 2, 4, 'ihfbsd', 22, '2024-03-29 23:15:47', NULL),
(3, 2, NULL, 'yuewgbdas', 42, '2024-03-30 01:36:51', NULL),
(4, 2, NULL, 'rything from stylized drawings to technical designs. Key Benefits: Efficiency: Tools like Kaledo Style streamline processes, reducing the time from concept to final design. Integration: Lectra’s solutions seamlessly integrate various aspects of the design process, ensuring consistency and accuracy (https://thefashionstarter.com/best-pattern-making-software/)1 (https://thefashionstarter.com/best-pattern-making-software/). Tuka CAD: Tuka CAD stands out for its comprehensive functionality in 2D CAD pattern making, grading, and marker making. Features: Enables accurate pattern building, bespoke grading standards, and marker nesting for any style. Provides audio/video', 29, '2024-03-30 01:38:36', NULL),
(10, 3, NULL, 'i don\'t know what is the meaning of this all', NULL, '2024-03-30 21:15:21', NULL),
(24, 3, 3, 'i love you more than you ever think.', 0, '2024-03-31 20:39:42', NULL),
(26, 8, 3, 'i love you too', 2, '2024-03-31 20:44:37', NULL),
(27, 3, 3, 'o\'yipfoywegupi', 0, '2024-03-31 21:31:39', NULL),
(28, 2, 17, 'true that is the answer for this questions', 0, '2024-05-23 19:17:20', NULL),
(29, 2, 17, 'true that is the answer for this questions', 0, '2024-05-23 19:17:22', NULL),
(30, 19, 17, 'data is the collection of rows and facts', 0, '2024-05-23 19:38:47', NULL),
(31, 19, 17, 'tshhhhhhhhdgvksjas hjae', 0, '2024-05-23 21:06:40', NULL),
(32, 19, 17, 'tshhhhhhhhdgvksjas hjae', 0, '2024-05-23 21:06:40', NULL),
(33, 19, 17, 'tshhhhhhhhdgvksjas hjae', 0, '2024-05-23 21:06:40', NULL),
(34, 19, 17, 'tshhhhhhhhdgvksjas hjae', 0, '2024-05-23 21:06:40', NULL),
(35, 19, 17, 'tshhhhhhhhdgvksjas hjae', 0, '2024-05-23 21:06:40', NULL),
(36, 19, 17, '3333333333333333333333333333333333333', 0, '2024-05-23 21:07:31', NULL),
(37, 19, 17, '3333333333333333333333333333333333333', 0, '2024-05-23 21:07:31', NULL),
(38, 19, 17, '111111111111111111111111111111111', 0, '2024-05-23 21:08:43', NULL),
(39, 19, 17, '11111111111111', 0, '2024-05-23 21:09:03', NULL),
(40, 19, 17, 'that is good bro continue', 0, '2024-05-23 21:14:38', NULL),
(41, 19, 17, 'that is good bro continue', 0, '2024-05-23 21:14:41', NULL),
(42, 19, 17, 'that is good bro continue', 0, '2024-05-23 21:14:42', NULL),
(43, 12, 17, 'iusd   ysj sj sjdjjhao dhae', 0, '2024-05-23 21:16:40', NULL),
(44, 12, 17, 'yes brother that is what i want', 0, '2024-05-23 21:17:00', NULL),
(45, 12, 17, 'yes brother that is what i want', 0, '2024-05-23 21:17:00', NULL),
(46, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(47, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(48, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(49, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(50, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(51, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(52, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(53, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(54, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(55, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(56, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(57, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(58, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(59, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(60, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(61, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(62, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(63, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(64, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(65, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(66, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(67, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(68, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(69, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(70, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(71, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(72, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(73, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(74, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(75, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(76, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(77, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(78, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(79, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(80, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(81, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(82, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(83, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(84, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(85, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(86, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(87, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(88, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(89, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(90, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(91, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(92, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(93, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(94, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(95, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(96, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(97, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(98, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(99, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(100, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(101, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(102, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(103, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(104, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(105, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(106, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(107, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(108, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(109, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(110, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(111, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(112, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(113, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(114, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(115, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(116, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(117, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(118, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(119, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(120, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(121, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(122, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(123, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(124, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(125, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(126, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(127, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(128, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(129, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(130, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(131, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(132, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(133, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(134, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(135, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(136, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(137, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(138, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(139, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(140, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(141, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(142, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(143, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(144, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(145, 11, 17, 'what is the answer', 0, '2024-05-23 21:17:57', NULL),
(146, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(147, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(148, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(149, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(150, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(151, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(152, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(153, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(154, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(155, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(156, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(157, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(158, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(159, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(160, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(161, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(162, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(163, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(164, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(165, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(166, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(167, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(168, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(169, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(170, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(171, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(172, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(173, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(174, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(175, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(176, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(177, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(178, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(179, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(180, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(181, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(182, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(183, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(184, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(185, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(186, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(187, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(188, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(189, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(190, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(191, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(192, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(193, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(194, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(195, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(196, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(197, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(198, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(199, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(200, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(201, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(202, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(203, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(204, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(205, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(206, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(207, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(208, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(209, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:18', NULL),
(210, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(211, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(212, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(213, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(214, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(215, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(216, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(217, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(218, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(219, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(220, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(221, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(222, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(223, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(224, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(225, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(226, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(227, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(228, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(229, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(230, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(231, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(232, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(233, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(234, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(235, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(236, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(237, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(238, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(239, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(240, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(241, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(242, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(243, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(244, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(245, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(246, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(247, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(248, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(249, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(250, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(251, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(252, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(253, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(254, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(255, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(256, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(257, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(258, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(259, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(260, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(261, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(262, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(263, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(264, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(265, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(266, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(267, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(268, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(269, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(270, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(271, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(272, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(273, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(274, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(275, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(276, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(277, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(278, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(279, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(280, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(281, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(282, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(283, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(284, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(285, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(286, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(287, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(288, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(289, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(290, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(291, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(292, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(293, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(294, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(295, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(296, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(297, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(298, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(299, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(300, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(301, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(302, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(303, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(304, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(305, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(306, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(307, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(308, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(309, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(310, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(311, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(312, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(313, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(314, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(315, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(316, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(317, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(318, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(319, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(320, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(321, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(322, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(323, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(324, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(325, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(326, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(327, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(328, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(329, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(330, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(331, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(332, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(333, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(334, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(335, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(336, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(337, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(338, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(339, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(340, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(341, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(342, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(343, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(344, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(345, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(346, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(347, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(348, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(349, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(350, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(351, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(352, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(353, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(354, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(355, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(356, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(357, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(358, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(359, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(360, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(361, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(362, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(363, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(364, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(365, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(366, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(367, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(368, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(369, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(370, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(371, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:19', NULL),
(372, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(373, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(374, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(375, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(376, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(377, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(378, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(379, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(380, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(381, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(382, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(383, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(384, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(385, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(386, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(387, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(388, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(389, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(390, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(391, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(392, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(393, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(394, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(395, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(396, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(397, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(398, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(399, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(400, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(401, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(402, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(403, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(404, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(405, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(406, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(407, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(408, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(409, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(410, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(411, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(412, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(413, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(414, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(415, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(416, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(417, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(418, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(419, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(420, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(421, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(422, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(423, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(424, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(425, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(426, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(427, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(428, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(429, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(430, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(431, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(432, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(433, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(434, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(435, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(436, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(437, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(438, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(439, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(440, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(441, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(442, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(443, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(444, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(445, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(446, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(447, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(448, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(449, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(450, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(451, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(452, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(453, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(454, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(455, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(456, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(457, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(458, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(459, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(460, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(461, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(462, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(463, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(464, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(465, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(466, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(467, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(468, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(469, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(470, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(471, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(472, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(473, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(474, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(475, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(476, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(477, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(478, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(479, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(480, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(481, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(482, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(483, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(484, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(485, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(486, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(487, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(488, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(489, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(490, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(491, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(492, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(493, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(494, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(495, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(496, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(497, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(498, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(499, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(500, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(501, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(502, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(503, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(504, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(505, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(506, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(507, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(508, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(509, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(510, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(511, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(512, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(513, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(514, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(515, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(516, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(517, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(518, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(519, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(520, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(521, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:20', NULL),
(522, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(523, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(524, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(525, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(526, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(527, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(528, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(529, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(530, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(531, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(532, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(533, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(534, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(535, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(536, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(537, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(538, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(539, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(540, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(541, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(542, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(543, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(544, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(545, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(546, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(547, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(548, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(549, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(550, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(551, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(552, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(553, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(554, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(555, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(556, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(557, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(558, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(559, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(560, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(561, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(562, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(563, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(564, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(565, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(566, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(567, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(568, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(569, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(570, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(571, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(572, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(573, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(574, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(575, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(576, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(577, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(578, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(579, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(580, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(581, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(582, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(583, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(584, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(585, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(586, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(587, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(588, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(589, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(590, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(591, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(592, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(593, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(594, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(595, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(596, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(597, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(598, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(599, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(600, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(601, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(602, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(603, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(604, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(605, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(606, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(607, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(608, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(609, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(610, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(611, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(612, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(613, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(614, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(615, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(616, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(617, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(618, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(619, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(620, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(621, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(622, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(623, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(624, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(625, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(626, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(627, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(628, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(629, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(630, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(631, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(632, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(633, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(634, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(635, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(636, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(637, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(638, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(639, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(640, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(641, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(642, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(643, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(644, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(645, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(646, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(647, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(648, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(649, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(650, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(651, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(652, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(653, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(654, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(655, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(656, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(657, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(658, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(659, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(660, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(661, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(662, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(663, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(664, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(665, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(666, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(667, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(668, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(669, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(670, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(671, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(672, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(673, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(674, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(675, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(676, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(677, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(678, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(679, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(680, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(681, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(682, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(683, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(684, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(685, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(686, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(687, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(688, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:21', NULL),
(689, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(690, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(691, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(692, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(693, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(694, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(695, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(696, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(697, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(698, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(699, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(700, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(701, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(702, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(703, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(704, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(705, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(706, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(707, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(708, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(709, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(710, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(711, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(712, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(713, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(714, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(715, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(716, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(717, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(718, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(719, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(720, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(721, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(722, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(723, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(724, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(725, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(726, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(727, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(728, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(729, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(730, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(731, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(732, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(733, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(734, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL);
INSERT INTO `answers` (`A_id`, `Q_id`, `A_stu_id`, `A_body`, `likes`, `a_timestamp`, `A_image`) VALUES
(735, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(736, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(737, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(738, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(739, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(740, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(741, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(742, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(743, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(744, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(745, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(746, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(747, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(748, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(749, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(750, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(751, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(752, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(753, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(754, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(755, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(756, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(757, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(758, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(759, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(760, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(761, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(762, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(763, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(764, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(765, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(766, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(767, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(768, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(769, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(770, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(771, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(772, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(773, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(774, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(775, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(776, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(777, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(778, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(779, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(780, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(781, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(782, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(783, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(784, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(785, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(786, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(787, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(788, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(789, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(790, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(791, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(792, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(793, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(794, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(795, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(796, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(797, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(798, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(799, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(800, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(801, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(802, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(803, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(804, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(805, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(806, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(807, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(808, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(809, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(810, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(811, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(812, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(813, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(814, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(815, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(816, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(817, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(818, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(819, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(820, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(821, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(822, 9, 17, 'yes hany ou are write', 0, '2024-05-23 21:21:22', NULL),
(823, 19, 17, 'eeeeeeeeeeeeeeeeeeeeeeee', 0, '2024-05-23 21:26:47', NULL),
(824, 19, 17, 'eeeeeeeeeeeeeeeeeeeeeeee', 0, '2024-05-23 21:26:50', NULL),
(825, 19, 17, 'eeeeeeeeeeeeeeeeeeeeeeee', 0, '2024-05-23 21:26:52', NULL),
(826, 19, 17, 'eeeeeeeeeeeeeeeeeeeeeeee', 0, '2024-05-23 21:26:52', NULL),
(827, 19, 17, 'eeeeeeeeeeeeeeeeeeeeeeee', 0, '2024-05-23 21:26:52', NULL),
(828, 19, 17, 'eeeeeeeeeeeeeeeeeeeeeeee', 0, '2024-05-23 21:26:52', NULL),
(829, 19, 17, 'eeeeeeeeeeeeeeeeeeeeeeee', 0, '2024-05-23 21:26:53', NULL),
(830, 2, 17, 'yes you are Absolutly right', 0, '2024-05-23 21:27:50', NULL),
(831, 10, 17, 'ok good thanks', 0, '2024-05-23 21:28:23', NULL),
(832, 10, 17, 'ok good thanks', 0, '2024-05-23 21:28:23', NULL),
(833, 10, 17, 'ok good thanks', 0, '2024-05-23 21:28:23', NULL),
(834, 10, 17, 'ok good thanks', 0, '2024-05-23 21:28:23', NULL),
(835, 10, 17, 'ok good thanks', 0, '2024-05-23 21:28:23', NULL),
(836, 8, 17, 'ok and this is the  answer for your question', 0, '2024-05-23 21:35:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `b_id` int(11) NOT NULL,
  `b_title` text DEFAULT NULL,
  `b_dec` text DEFAULT NULL,
  `b_dec1` text DEFAULT NULL,
  `b_dec2` text DEFAULT NULL,
  `b_dec3` text DEFAULT NULL,
  `b_img` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`b_id`, `b_title`, `b_dec`, `b_dec1`, `b_dec2`, `b_dec3`, `b_img`) VALUES
(1, 'we did it', 'Well organized and easy to understand Web building tutorials with lots of examples of how to use HTML, CSS, JavaScript, SQL, Python, PHP, …', 'PHP is an open-source server-side scripting language that many devs use for web development. It is also a general-purpose language that you can …', 'none class constant dynamically syntax Readonly Amendments Override Attribute New Randomizer method RandomRandomizer::getBytesFromString New function json_validate And much much more... For source downloads of PHP 8.3.0 please visit our downloads page, Windows source and binaries can be found on windows.php.net/download/. The list of changes is recorded in the ChangeLog.  The migration guide is available in the PHP Manual. Please consult it for the detailed list of new features and backward incompatible changes.  Kudos to all the contributors and support', 'P 8.2 users are encouraged to upgrade to this version.  For source downloads of PHP 8.2.13 please visit our downloads page, Windows source and binaries can be found on windows.php.net/download/. The list of changes is recorded in the ChangeLog.  09 Nov 2023 PHP 8.3.0 RC 6 available for testing', '../Images/Blog/photo_2023-12-09_08-03-55.jpg'),
(2, 'thsjid\'s oko', 'In this version, the toggle button (#menu-toggle-btn) only appears when the sidebar is hidden on small screens. Clicking the toggle button toggles the class show-sidebar on the body element, which in turn displays or hides the sidebar. Adjustments to sidebar width and other styles can be made as needed.', 'In this version, the toggle button (#menu-toggle-btn) only appears when the sidebar is hidden on small screens. Clicking the toggle button toggles the class show-sidebar on the body element, which in turn displays or hides the sidebar. Adjustments to sidebar width and other styles can be made as needed.', 'In this version, the toggle button (#menu-toggle-btn) only appears when the sidebar is hidden on small screens. Clicking the toggle button toggles the class show-sidebar on the body element, which in turn displays or hides the sidebar. Adjustments to sidebar width and other styles can be made as needed.', 'In this version, the toggle button (#menu-toggle-btn) only appears when the sidebar is hidden on small screens. Clicking the toggle button toggles the class show-sidebar on the body element, which in turn displays or hides the sidebar. Adjustments to sidebar width and other styles can be made as needed.', '../Images/Blog/OIP.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `catagorie_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `icon`, `catagorie_name`, `description`) VALUES
(3, 'uil uil-android', 'App Developmentt', 'web programing web programing web programing..'),
(4, 'uil uil-palette', 'Back-End Developing', 'the best catagoris'),
(6, 'uil uil-palette', 'pyschlogy', 'this one');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `certificate` text DEFAULT NULL,
  `course_name` varchar(255) NOT NULL,
  `issue_date` date NOT NULL,
  `completion_status` tinyint(1) NOT NULL,
  `stu_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `certificate`, `course_name`, `issue_date`, `completion_status`, `stu_id`, `course_id`) VALUES
(8, 'Certificate of Completion', 'phyton', '2024-05-07', 0, 17, 4);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `f_name` text DEFAULT NULL,
  `l_name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `msg` text DEFAULT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `f_name`, `l_name`, `email`, `msg`, `approved`, `answer`) VALUES
(1, 'Destaw', 'Aschalw', 'Desudes0621@gmail.com', 'hi can i get your name', 1, 'As noted above, there are no deadlines to begin or complete the course. Even after you complete the course you will continue to have access to it, provided that your account is in good standing, and Imperial continues to have a license to the course.'),
(3, 'alex', 'aschalw', 'Desudes0621@gmail.com', 'What do ethio learn courses include?', 1, 'Each Imperial course is created, owned and managed by the instructor(s). The foundation of each Imperial course are its lectures, which can include videos. In addition, instructors can add resources and various types of practice activities, as a way to enhance the learning experience of students.');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `course_desc` text DEFAULT NULL,
  `lec_id` int(11) DEFAULT NULL,
  `course_img` text DEFAULT NULL,
  `course_duration` int(11) DEFAULT NULL,
  `course_price` float DEFAULT NULL,
  `course_lessons` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_desc`, `lec_id`, `course_img`, `course_duration`, `course_price`, `course_lessons`, `category_id`, `status`) VALUES
(2, 'php', 'PHP(short for Hypertext PreProcessor) is the most widely used open source and general purpose server side scripting language used mainly in web development to create dynamic websites and applications. It was developed in 1994 by Rasmus Lerdorf. A survey by W3Tech shows that almost 79% of the websites in their data are developed using PHP. It is not only used to build the web apps of many tech giants like Facebook but is also used to build many CMS (Content Management System) like WordPress, Drupal, Shopify, WooCommerce etc.', 3, '../Images/CourseImages/th (1).jpg', 49, 0, 50, NULL, 1),
(3, 'java', 'java(short for Hypertext PreProcessor) is the most widely used open source and general purpose server side scripting language used mainly in web development to create dynamic websites and applications. It was developed in 1994 by Rasmus Lerdorf. A survey by W3Tech shows that almost 79% of the websites in their data are developed using PHP. It is not only used to build the web apps of many tech giants like Facebook but is also used to build many CMS (Content Management System) like WordPress, Drupal, Shopify, WooCommerce etc.', 2, '../Images/CourseImages/OIP.jpg', 49, 0, 100, NULL, 1),
(4, 'phyton', 'pythone', 2, '../Images/CourseImages/page user interface.png', 49, 12, 40, 3, 1),
(5, 'javaa', 'PHP(short for Hypertext PreProcessor) is the most widely used open source and general purpose server side scripting language used mainly in web development to create dynamic websites and applications. It was developed in 1994 by Rasmus Lerdorf. A survey by W3Tech shows that almost 79% of the websites in their data are developed using PHP. It is not only used to build the web apps of many tech giants like Facebook but is also used to build many CMS (Content Management System) like WordPress, Drupal, Shopify, WooCommerce etc.', 3, '../Images/CourseImages/', 1, 1200, 50, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `courseorder`
--

CREATE TABLE `courseorder` (
  `co_id` int(11) NOT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `amount` varchar(11) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `stu_name` varchar(255) NOT NULL,
  `stu_email` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `tx_ref` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courseorder`
--

INSERT INTO `courseorder` (`co_id`, `order_id`, `stu_id`, `course_id`, `amount`, `date`, `stu_name`, `stu_email`, `course_name`, `tx_ref`) VALUES
(23, 'fa362f8c-f0ae-11ee-ab31-e8674d4a8ee9', 1, 2, '0', '2024-04-02', '', 'Desudes0621@gmail.com', 'php', ''),
(24, '523868b3-f0d0-11ee-a7aa-de3b8d13b450', 3, 3, '0', '2024-04-02', 'mylove', 'mylove@gmail.com', 'java', ''),
(25, 'order_660d5d6b1dbd4', 3, 4, '12', '2024-04-03', 'mylove', 'mylove@gmail.com', 'phyton', ''),
(53, '661abab4c4acb', 17, 4, '12', '2024-04-13', 'destinking', 'destinking06@gmail.com', 'phyton', ''),
(56, '663888a3b786e', 20, 4, '12', '2024-05-06', 'nahome', 'Desudes0621@gmail.com', 'phyton', ''),
(58, '66485c0e2d67f', 17, 5, '1200', '2024-05-18', 'destinking', 'destinking06@gmail.com', 'javaa', '');

-- --------------------------------------------------------

--
-- Table structure for table `exam_category`
--

CREATE TABLE `exam_category` (
  `id` int(11) NOT NULL,
  `assessment_type` varchar(255) NOT NULL,
  `exam_name` varchar(255) DEFAULT NULL,
  `exam_time` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `exam_description` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT 0,
  `catagory_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_category`
--

INSERT INTO `exam_category` (`id`, `assessment_type`, `exam_name`, `exam_time`, `course_id`, `exam_description`, `active`, `catagory_timestamp`) VALUES
(8, 'exam', 'first exam', '23', 3, 'this is the first exam', 1, '2024-05-24 11:11:23'),
(9, 'exam', 'exam for me', '2', 2, 'ljfcgrxf', 0, '2024-05-24 11:11:23'),
(10, 'quiz', 'exam ', '3', 4, 'this exam is for all', 1, '2024-05-24 11:11:23'),
(11, 'quiz', 'des', '3', 4, 'this exam is provided to you', 1, '2024-05-24 11:11:23'),
(12, 'exam', 'this', '1', 4, 'od[saj fsa', 1, '2024-05-24 11:11:23'),
(13, 'exam', 'exam 2', '2', 4, '', 1, '2024-05-24 11:11:23'),
(14, '', 'java', '1', NULL, NULL, 0, '2024-05-24 11:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` int(11) NOT NULL,
  `catergory` varchar(255) DEFAULT NULL,
  `question_type` enum('multiple_choice','true_false','fill_in_the_blank') DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  `correct_answer` text DEFAULT NULL,
  `opt1` text DEFAULT NULL,
  `opt2` varchar(255) NOT NULL,
  `opt3` varchar(255) NOT NULL,
  `opt4` varchar(255) NOT NULL,
  `ques_no` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `catergory`, `question_type`, `question_text`, `correct_answer`, `opt1`, `opt2`, `opt3`, `opt4`, `ques_no`) VALUES
(198, 'this', 'multiple_choice', 'god always helps me in every moment i take3w', 'database', 'database', 'dde', 'database', 'database', '1'),
(210, 'exam 2', 'multiple_choice', 'what is AI', 'artificial intelligent', 'artificial intelligent', 'computer', 'system', 'data', '1'),
(211, 'exam 2', 'true_false', 'i love you', 'True', '', '', '', '', '2'),
(212, 'exam 2', 'true_false', 'what is data', 'True', '', '', '', '', '3'),
(213, 'exam 2', 'true_false', NULL, 'False', '', '', '', '', '4'),
(214, 'exam 2', 'multiple_choice', 'god always helps me in every moment i take', 'data base', 'database', 'database', 'database', 'databases', '5'),
(215, 'exam 2', 'multiple_choice', 'god always helps me in every moment i take', 'data base', 'database', 'database', 'database', 'databases', '6'),
(216, 'exam 2', 'multiple_choice', 'god always helps me in every moment i take', 'data base', 'database', 'database', 'database', 'databases', '7'),
(217, 'exam 2', 'multiple_choice', 'this is me ok yes', 'data base jgwjhkeg', 'databases', 'ytwekhlb', 'datab', 'databasesssssss', '8'),
(218, 'first exam', NULL, 'this is me ok yes', '', '', '', '', '', '1'),
(219, '', NULL, 'this is me ok yes me', '', '', '', '', '', '1'),
(220, 'first exam', NULL, 'this is me ok yes me for that case', '', '', '', '', '', '2'),
(221, 'first exam', NULL, 'god always helps me in every moment i take', '', '', '', '', '', '3'),
(222, 'this', NULL, 'god always helps me in every moment i take', '', '', '', '', '', '2'),
(223, 'this', NULL, 'this is me ok yes me3333', '', '', '', '', '', '3'),
(224, 'exam 2', NULL, 'this is me ok yes me3333', '', '', '', '', '', '9'),
(225, 'this', 'multiple_choice', 'this is me ok yes me3333', 'datab', 'databases', 'datab', 'databrr', 'databasesssssss', '4'),
(226, 'first exam', 'multiple_choice', 'this is me ok yes me3333', 'datab', 'databases', 'datab', 'databrr', 'databasesssssss', '4'),
(227, 'first exam', 'multiple_choice', 'this is me ok yes me33333344', 'datab', 'databases', 'databases', 'databrr', 'databasesssssss', '5'),
(228, 'first exam', 'multiple_choice', 'this is me ok yes me33333344', 'datab', 'databases', 'databases', 'databrr', 'databasesssssss', '6'),
(229, '', 'multiple_choice', 'this is me ok yes me33333344khjgfkhljk', 'datab', 'databases', 'databases', 'databrr', 'databasesssssss', '2'),
(230, '', 'multiple_choice', 'this is me ok yes me33333344khjgfkhljk', 'datab', 'databases', 'databas', 'databrr', 'databasesssssss', '3'),
(231, 'exam 2', 'multiple_choice', 'god always helps me in every moment i take the apple', 'abcd', 'win', 'database', 'question', 'abcd', '10'),
(232, 'exam 2', 'true_false', 'this is me ok yes me33333344khjgfkhljk the', 'True', '', '', '', '', '11');

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `result_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `exam_category` varchar(255) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `correct_answers` int(11) DEFAULT NULL,
  `wrong_answers` int(11) DEFAULT NULL,
  `exam_time` datetime DEFAULT NULL,
  `mark` decimal(5,2) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`result_id`, `student_id`, `exam_category`, `total_questions`, `correct_answers`, `wrong_answers`, `exam_time`, `mark`, `course_id`) VALUES
(17, 17, 'this', 5, 4, 1, '2024-05-07 10:09:06', 80.00, NULL),
(28, 17, 'exam 2', 2, 2, 3, '2024-05-07 10:17:22', 100.00, NULL),
(32, 17, 'this', 1, 1, 4, '2024-05-22 15:26:27', 100.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `f_id` int(11) NOT NULL,
  `f_content` text DEFAULT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `reply_content` varchar(255) DEFAULT NULL,
  `feedback_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`f_id`, `f_content`, `stu_id`, `course_id`, `reply_content`, `feedback_time`, `approved`) VALUES
(7, 'the des', 1, 2, NULL, '2024-03-26 16:50:43', 1),
(8, 'kew', 1, 2, NULL, '2024-03-26 16:58:11', 1),
(9, 'edsc', 1, 2, NULL, '2024-03-26 17:03:30', 0),
(10, 'edk;s', 1, 2, NULL, '2024-03-26 17:03:56', 0),
(11, 'i;dagcs', 1, 2, NULL, '2024-03-26 17:04:33', 0),
(12, 'ihd', 1, 2, NULL, '2024-03-26 17:05:35', 0),
(19, 'gdsh', 1, 2, NULL, '2024-03-26 21:07:38', 0),
(20, 'i love', 1, 2, NULL, '2024-03-26 21:07:50', 0),
(21, 'i love', 1, 2, NULL, '2024-03-26 21:09:55', 0),
(22, 'i love', 1, 2, NULL, '2024-03-26 21:14:47', 0),
(23, 'i love', 1, 2, NULL, '2024-03-26 21:32:51', 0),
(24, 'i love', 1, 2, NULL, '2024-03-26 21:42:56', 0),
(25, 'i love', 1, 2, NULL, '2024-03-26 21:43:09', 0),
(26, 'i love', 1, 2, NULL, '2024-03-26 21:43:21', 0),
(27, 'i love', 1, 2, NULL, '2024-03-26 21:43:32', 1),
(28, 'i love', 1, 2, NULL, '2024-03-26 21:48:18', 1),
(29, 'i love', 1, 2, NULL, '2024-03-26 21:51:49', 0),
(30, 'udhsj', 1, 3, NULL, '2024-04-08 16:01:13', 0),
(31, 'this is amazing', 17, 4, NULL, '2024-04-19 20:04:10', 1),
(32, 'this is amazing', 17, 4, NULL, '2024-04-19 20:05:40', 1),
(33, 'thtytu', 17, 4, NULL, '2024-05-09 03:48:16', 0),
(34, '8dssgdghj', 17, 4, NULL, '2024-05-09 03:48:20', 1),
(35, 'uyjhtdgrdhjhjk', 17, 4, NULL, '2024-05-09 03:48:22', 1),
(36, 'uytrgtjhghjjk', 17, 4, NULL, '2024-05-09 03:48:26', 1),
(37, 'hgh', 17, 4, NULL, '2024-05-09 03:48:31', 1),
(38, 'kjhjghgfghjklkjhg', 17, 4, NULL, '2024-05-09 03:48:35', 1),
(39, 'lkjkjhghjkl;kjhj', 17, 4, NULL, '2024-05-09 03:48:38', 1),
(40, ';llkljkhjghgdfdsfghjkl;kjkghgffghjkl', 17, 4, NULL, '2024-05-09 03:48:45', 1),
(41, 'kkjhhgggghjkl;kljhjh', 17, 4, NULL, '2024-05-09 03:48:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `l_id` int(11) NOT NULL,
  `l_name` text DEFAULT NULL,
  `l_design` text DEFAULT NULL,
  `l_img` text DEFAULT NULL,
  `l_email` text NOT NULL,
  `l_password` text NOT NULL,
  `password_changed` tinyint(1) DEFAULT 0,
  `online_status` enum('online','offline') NOT NULL DEFAULT 'offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`l_id`, `l_name`, `l_design`, `l_img`, `l_email`, `l_password`, `password_changed`, `online_status`) VALUES
(1, 'aschalw', 'php', '../Images/Lectures/photo_2023-12-09_08-03-55.jpg', 'aschalw@gmail.com', '$2y$10$Y6LZVpqGwJOb6QDslGC4zerzGPdt/M6Apk7tOAt5Z4NAbxr.AzzTS', 0, 'offline'),
(2, 'dustin', 'web devlopment', '../Images/Lectures/photo_2024-01-03_23-36-02.jpg', 'Desudes0621@gmail.com', '$2y$10$uDTUyhcCVNg5VJZf8LYeC./g6WMwGbTmhx9sTQT7KIpjI5xaJJE2S', 1, 'online'),
(3, 'dad', 'php', '../Images/Lectures/Screenshot 2024-03-15 180143.png', 'desu@gmail.com', '$2y$10$Uer5KVng7Q3CA2HaDo0/p.oU1I9n5G8MfihW/kFJpiovAVEJroa2u', 1, 'offline'),
(4, 'dustin', 'web devlopment', '../Images/Lectures/', 'mylove@gmail.com', '$2y$10$XD53OdodEGz2Ug8zEFPcBu/vNaEFQRvuXLJ3FZU5FfQh4GoCYPQLi', 0, 'offline'),
(8, 'nahome', 'php', '../Images/Lectures/', 'nahomammanuel23@gmail.com', '$2y$10$HeUJukKTTR77hBfZ4DDXMejhKkCD/Aroxen9KUcQuhLbsw.gMuJNC', 0, 'offline'),
(10, 'destaw', 'math', '../Images/Lectures/', 'destinking06@gmail.com', '$2y$10$EafD.SQvtaDJzV84O.vcUuhI4RQ5iB5NzKzMx9Jw5BCJxTzQdV6DC', 1, 'offline');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE `lesson` (
  `lesson_id` int(11) NOT NULL,
  `lesson_name` text DEFAULT NULL,
  `lesson_description` text NOT NULL,
  `lesson_link` text DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `completion_status` int(11) DEFAULT NULL,
  `video_progress` int(11) DEFAULT NULL,
  `lesson_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`lesson_id`, `lesson_name`, `lesson_description`, `lesson_link`, `course_id`, `completion_status`, `video_progress`, `lesson_timestamp`) VALUES
(41, 'local video', 'this is the second lesson video from local file', 'Videos/LessonVideos/WIN_20240420_10_46_16_Pro.mp4', 3, NULL, NULL, '2024-05-24 11:10:10'),
(42, 'first class', 'this is the first video from local file', 'Videos/LessonVideos/WIN_20240420_10_46_16_Pro.mp4', 4, NULL, NULL, '2024-05-24 11:10:10'),
(43, 'class two', 'lb\'', 'Videos/LessonVideos/WIN_20240321_19_09_43_Pro.mp4', 3, NULL, NULL, '2024-05-24 11:10:10'),
(44, 'n', 'h', 'Videos/LessonVideos/WIN_20240321_19_09_43_Pro.mp4', 4, NULL, NULL, '2024-05-24 11:10:10'),
(47, 'dustin', 'this isme', 'Videos/LessonVideos/WIN_20240420_10_46_16_Pro.mp4', 4, NULL, NULL, '2024-05-24 11:10:10'),
(48, 'last', 'f oas 9', 'Videos/LessonVideos/WIN_20240420_10_46_16_Pro.mp4', 4, NULL, NULL, '2024-05-24 11:10:10'),
(51, 'qw', 'djb', 'Videos/LessonVideos/WIN_20240321_19_09_43_Pro.mp4', 4, NULL, NULL, '2024-05-24 11:10:10');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `type` enum('youtube','localvideo') NOT NULL DEFAULT 'localvideo',
  `progress` float DEFAULT NULL,
  `completed` tinyint(1) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `student_id`, `lesson_id`, `type`, `progress`, `completed`, `timestamp`, `course_id`) VALUES
(276, 17, 47, 'localvideo', 100, 1, '2024-04-27 13:24:53', 4),
(277, 17, 44, 'localvideo', 96.8165, 0, '2024-04-27 13:26:49', 4),
(278, 17, 41, 'localvideo', 100, 1, '2024-04-27 13:27:24', 3),
(279, 17, 42, 'localvideo', 89.8572, 0, '2024-04-27 14:03:00', 4),
(280, 17, 42, 'localvideo', 89.8572, 0, '2024-04-27 14:03:00', 4),
(281, 17, 48, 'localvideo', 90.0013, 0, '2024-05-01 15:53:03', 4);

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `material_id` int(11) NOT NULL,
  `material_name` varchar(255) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `material_desc` text DEFAULT NULL,
  `material_type` varchar(50) DEFAULT NULL,
  `material_url` text DEFAULT NULL,
  `upload_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `materials`
--

INSERT INTO `materials` (`material_id`, `material_name`, `course_id`, `material_desc`, `material_type`, `material_url`, `upload_date`) VALUES
(46, 'test', 3, 'ouyutretyuoo[p]', 'Document', '../instructor/material/662d135bccff3_test.docx', '2024-04-27 18:01:47'),
(47, 'testhlugkfydjtkhjl', 3, 'lkfdtsrfxgfhghpio[upytfgdxfbvhjojhv', 'Document', '../instructor/material/662d139e9e034_testhlugkfydjtkhjl.docx', '2024-04-27 18:02:54'),
(48, 'dustinnljhguf', 4, 'ou;turyeturtyu', 'Document', '../instructor/material/662d13d0736c7_dustinnljhguf.docx', '2024-04-27 18:03:44'),
(49, 'jhgffh', 3, 'm j/hgfjtdhsrjfgj', 'Presentation', '../instructor/material/664df49930cd5_jhgffh.pptx', '2024-05-22 16:35:21'),
(50, 're', 4, 'rrrrrrrrrrrrrr', 'Document', '../instructor/material/664df5817ec38_re.docx', '2024-05-22 16:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` enum('admin','student','lecturer') NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `receiver_type` enum('admin','student','lecturer') NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `sender_id`, `sender_type`, `receiver_id`, `receiver_type`, `subject`, `content`, `sent_at`, `is_read`, `parent_id`) VALUES
(7, 2, 'lecturer', 3, 'student', 'this is for you', 't hduasf of dsojf adfjdssnfffj dsa dhdss a', '2024-05-03 07:59:35', 0, NULL),
(8, 2, 'lecturer', 0, 'admin', 'this is for you', 'iuuew hfs dfh dsuhf dshfs sdaoei', '2024-05-03 08:20:45', 1, NULL),
(9, 2, 'lecturer', -1, 'admin', 'this is for you', 'kjad dsfuas ha sa', '2024-05-03 08:38:38', 1, NULL),
(10, 17, 'student', 2, 'lecturer', 'this is for you', 'do fsudhsudff sd-s', '2024-05-03 11:37:04', 1, NULL),
(11, 17, 'student', 3, 'student', 'this is for you', 'diyd diusjhaf asiuf ufa sdnoa', '2024-05-03 11:38:48', 0, NULL),
(12, 1, 'admin', 1, 'student', 'iugsdakn;kl', 'sdoayfsiyuioscpkdjbahjs', '2024-05-03 17:04:49', 0, NULL),
(13, 1, 'admin', 3, 'student', 'this is for you', 'how are you how is bale', '2024-05-03 17:07:07', 0, NULL),
(14, 1, 'admin', 2, 'lecturer', 'this is for you', 'hi bro', '2024-05-03 17:07:44', 1, NULL),
(15, 2, 'lecturer', -1, 'admin', 'this is for you', 'dsyig ;ag daui dasgedv ads', '2024-05-03 18:11:24', 0, NULL),
(16, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'ok thanks', '2024-05-03 20:07:29', 1, NULL),
(17, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'thsi', '2024-05-03 20:07:48', 1, NULL),
(18, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'ddddddddddddddd', '2024-05-03 20:07:58', 1, NULL),
(19, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'djwlsab', '2024-05-03 20:09:04', 1, NULL),
(20, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'hi evry', '2024-05-04 04:12:22', 1, 10),
(21, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'good', '2024-05-04 04:12:51', 1, 10),
(22, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'this', '2024-05-04 04:13:07', 1, 10),
(23, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'jiahdhd ', '2024-05-04 05:02:04', 1, 10),
(24, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'upw9e ph', '2024-05-04 05:02:10', 1, 10),
(25, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'ksdbn', '2024-05-04 05:02:16', 1, 10),
(26, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'jdkv', '2024-05-04 05:02:32', 1, 10),
(27, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'fhwk', '2024-05-04 05:02:43', 1, 10),
(28, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'iuytdfgh', '2024-05-04 05:06:13', 1, 10),
(29, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'yes\r\n', '2024-05-04 05:09:16', 1, 10),
(30, 17, 'student', 2, 'lecturer', 'this is for you', 'ok thanks', '2024-05-04 05:20:25', 1, NULL),
(31, 17, 'student', 2, 'lecturer', 'yes mister ', 'you are doing well continue to doing that', '2024-05-04 05:40:31', 1, NULL),
(32, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'ya you are write\r\n', '2024-05-04 06:16:45', 1, 30),
(33, 17, 'student', 2, 'lecturer', 'iugsdakn;kl', ' des you did it with the help of God everything is possible', '2024-05-04 06:20:12', 1, NULL),
(34, 17, 'student', 2, 'lecturer', 'this is for you', 'is it work', '2024-05-04 07:37:44', 1, NULL),
(35, 2, 'lecturer', 1, 'admin', 'Re: this is for you', 'hi admin', '2024-05-04 10:53:15', 1, 14),
(36, 2, 'lecturer', 17, 'student', 'Re: this is for you', '512163247\r\n', '2024-05-04 11:25:44', 1, 34),
(37, 1, 'admin', 2, 'lecturer', 'Re: Re: this is for you', 'thr', '2024-05-04 11:54:57', 1, 35),
(38, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: this is for you', 'ok thanks', '2024-05-04 11:55:33', 1, 37),
(39, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'ok', '2024-05-04 11:56:22', 1, 34),
(40, 1, 'admin', 2, 'lecturer', 'Re: Re: this is for you', 'thr', '2024-05-04 12:06:31', 1, 35),
(41, 1, 'admin', 2, 'lecturer', 'Re: Re: this is for you', 'ok', '2024-05-04 12:06:41', 1, 35),
(42, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'hi', '2024-05-04 12:07:33', 1, 34),
(43, 1, 'admin', 2, 'lecturer', 'fffffffffffffd', 'ssssssssssssssss', '2024-05-04 12:09:15', 1, NULL),
(44, 1, 'admin', 1, 'student', 'fgfdd', '55555555555555', '2024-05-04 12:09:56', 0, NULL),
(45, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'thr', '2024-05-04 12:32:17', 1, 34),
(46, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'thr', '2024-05-04 12:34:50', 1, 34),
(47, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: this is for you', 'uyffghsj', '2024-05-04 12:35:15', 1, 38),
(48, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'what', '2024-05-04 12:36:46', 1, 34),
(49, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: this is for you', 'eeeeeee', '2024-05-04 12:39:27', 1, 47),
(50, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: Re: Re: this is for you', 'yes bra', '2024-05-04 12:47:53', 1, 49),
(51, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'ok bra\r\n', '2024-05-04 13:58:18', 1, 8),
(52, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'kflsd', '2024-05-04 13:58:29', 1, 8),
(53, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'whatttttttttt', '2024-05-04 13:58:38', 1, 8),
(54, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'tt', '2024-05-04 14:02:45', 1, 8),
(55, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'kj', '2024-05-04 14:05:10', 1, 8),
(56, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: Re: this is for you', 'jky', '2024-05-04 14:05:40', 1, 50),
(57, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'ioui', '2024-05-04 14:06:45', 1, 8),
(58, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'k;luiyd', '2024-05-04 14:11:19', 1, 8),
(59, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'uiyutf', '2024-05-04 14:19:44', 1, 8),
(60, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'uiyutf', '2024-05-04 14:24:42', 1, 8),
(61, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: Re: this is for you', 'uydf udfua9', '2024-05-04 14:26:06', 1, 50),
(62, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'u', '2024-05-04 14:33:44', 1, 8),
(63, 2, 'lecturer', 1, 'admin', 'Re: Re: this is for you', 'ok', '2024-05-04 14:45:06', 1, 62),
(64, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: this is for you', 'what', '2024-05-04 14:45:32', 1, 63),
(65, 2, 'lecturer', 1, 'admin', 'Re: Re: this is for you', 'good', '2024-05-04 14:45:54', 1, 62),
(66, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: this is for you', 'what', '2024-05-04 14:59:24', 1, 63),
(67, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: this is for you', 'ufjs', '2024-05-04 15:12:04', 1, 66),
(68, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: this is for you', 'ee', '2024-05-04 15:12:41', 1, 66),
(69, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: Re: this is for you', 'what', '2024-05-04 15:17:04', 1, 68),
(70, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: Re: this is for you', 'hjghfg', '2024-05-04 15:17:33', 1, 68),
(71, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: this is for you', 'ok bos', '2024-05-04 15:20:23', 1, 70),
(72, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: this is for you', 'what', '2024-05-04 15:23:19', 1, 70),
(73, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: Re: Re: Re: this is for you', 'dddddd', '2024-05-04 15:30:07', 1, 72),
(74, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: this is for you', 'ok', '2024-05-04 15:30:46', 1, 70),
(75, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: this is for you', 'dd', '2024-05-04 15:32:07', 1, 70),
(76, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: Re: Re: Re: this is for you', 'dd', '2024-05-04 15:32:26', 1, 72),
(77, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: Re: Re: Re: this is for you', 'hi ', '2024-05-04 15:37:28', 1, 75),
(78, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: Re: Re: Re: this is for you', 'sss', '2024-05-04 15:40:25', 1, 75),
(79, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: Re: Re: this is for you', 'what', '2024-05-04 15:41:11', 1, 78),
(80, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: Re: Re: this is for you', 'what', '2024-05-04 16:16:43', 1, 78),
(81, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: Re: Re: Re: Re: Re: this is for you', 'pic', '2024-05-05 06:48:05', 0, 80),
(82, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: Re: Re: this is for you', 'what', '2024-05-05 06:48:23', 0, 78),
(83, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: Re: Re: this is for you', 'good', '2024-05-05 11:05:07', 1, 78),
(84, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: Re: Re: Re: Re: this is for you', 'yes', '2024-05-05 11:21:43', 1, 81),
(85, 2, 'lecturer', 1, 'admin', 'Re: Re: Re: Re: Re: Re: Re: Re: Re: Re: this is for you', 'ok', '2024-05-05 11:22:13', 1, 81),
(86, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'thanks', '2024-05-05 11:53:46', 0, 34),
(87, 17, 'student', 2, 'lecturer', 'Re: Re: this is for you', 'ok mr', '2024-05-06 03:55:30', 0, 86),
(88, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'ok student', '2024-05-06 03:56:07', 1, 34),
(89, 2, 'lecturer', 17, 'student', 'Re: this is for you', 'hi nahome', '2024-05-06 06:36:24', 1, 34),
(90, 20, 'student', 17, 'student', 'hi bro', 'hi my friend', '2024-05-06 07:37:53', 1, NULL),
(91, 17, 'student', 20, 'student', 'Re: hi bro', 'hi bra', '2024-05-06 07:38:59', 1, 90),
(92, 20, 'student', 17, 'student', 'Re: Re: hi bro', 'ok bra', '2024-05-06 07:39:56', 1, 91),
(93, 1, 'admin', 2, 'lecturer', 'Re: Re: Re: Re: Re: Re: Re: Re: Re: Re: Re: this is for you', 'gg', '2024-05-06 07:58:23', 0, 85),
(94, 17, 'student', 2, 'lecturer', 'Re: Re: this is for you', 'hg', '2024-05-06 07:59:07', 0, 89),
(95, 17, 'student', 20, 'student', 'Re: Re: Re: hi bro', 'ok', '2024-05-06 07:59:32', 0, 92),
(96, 2, 'lecturer', 17, 'student', 'Re: Re: Re: this is for you', 'ok', '2024-05-06 08:02:45', 1, 87),
(97, 17, 'student', 2, 'lecturer', 'Re: Re: Re: Re: this is for you', 'this', '2024-05-06 12:23:08', 0, 96),
(98, 17, 'student', 2, 'lecturer', 'Re: Re: Re: Re: this is for you', 'yie', '2024-05-06 12:23:14', 0, 96),
(99, 17, 'student', 2, 'lecturer', 'Re: Re: Re: Re: this is for you', 'fiker', '2024-05-18 07:36:46', 0, 96);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `notice_id` int(11) NOT NULL,
  `lecturer_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`notice_id`, `lecturer_id`, `course_id`, `title`, `content`, `timestamp`) VALUES
(2, 2, 3, 'exam', 'exam will be next fjfweekg', '2024-05-10 01:55:05'),
(3, 2, 3, 'exam', 'exam will be next week', '2024-05-10 01:55:37'),
(7, 2, 4, 'dustin', 'fkjy', '2024-05-10 03:34:00'),
(8, 2, 4, 'w', 'des', '2024-05-10 03:43:16'),
(9, 2, 4, 'w', 'des', '2024-05-10 03:43:55'),
(10, 2, 3, 'hd', 'eeeeeeeeeeeeeeeeeeeeeeeeeeeeeaaaaaasdwbghdtrg', '2024-05-10 03:45:16');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `notification_date` datetime DEFAULT current_timestamp(),
  `notification_type` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `notification_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `stu_id`, `material_id`, `is_read`, `notification_date`, `notification_type`, `item_id`, `notification_message`) VALUES
(1, 1, 32, 1, '0000-00-00 00:00:00', '0', 32, 'New lesson added: last notification'),
(2, 1, NULL, 1, '0000-00-00 00:00:00', '0', NULL, 'New material added: dustin'),
(3, 1, 29, 1, '2024-03-27 22:22:00', 'material', NULL, 'New material added: dustin'),
(4, 1, 30, 1, '2024-03-27 22:23:06', 'material', NULL, 'New material added: swa'),
(5, 1, 35, 1, '2024-03-27 23:26:48', 'lesson', 35, 'New lesson added: first class'),
(6, 1, 36, 1, '2024-03-27 23:26:59', 'lesson', 36, 'New lesson added: first class'),
(7, 1, 37, 1, '2024-03-27 23:35:47', 'lesson', 37, 'New lesson added: first class'),
(8, NULL, NULL, 0, '2024-03-28 00:03:37', 'quiz', NULL, 'New quiz question added: who helps you'),
(9, 1, 38, 1, '2024-03-28 01:08:50', 'lesson', 38, 'New lesson added: caa'),
(10, 1, 39, 1, '2024-03-28 01:09:06', 'lesson', 39, 'New lesson added: ghfd'),
(11, 1, 31, 1, '2024-03-28 01:09:37', 'material', NULL, 'New material added: jkhjgh'),
(12, 1, 32, 1, '2024-03-28 01:24:27', 'material', NULL, 'New material added: dustinn'),
(13, 1, 33, 1, '2024-03-28 01:43:56', 'material', NULL, 'New material added: jhg'),
(14, 1, 34, 1, '2024-03-28 09:32:37', 'material', NULL, 'New material added: dustinn'),
(15, 1, 35, 1, '2024-03-28 10:22:26', 'material', NULL, 'New material added: dustinn'),
(16, 1, 36, 1, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(17, 3, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(18, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(19, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(20, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(21, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(22, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(23, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(24, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(25, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(26, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(27, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(28, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(29, NULL, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(30, 4, 36, 0, '2024-04-01 21:13:19', 'material', NULL, 'New material added: love'),
(31, 1, 37, 1, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(32, 3, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(33, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(34, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(35, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(36, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(37, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(38, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(39, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(40, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(41, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(42, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(43, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(44, NULL, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(45, 4, 37, 0, '2024-04-01 21:13:38', 'material', NULL, 'New material added: love'),
(46, NULL, NULL, 0, '2024-04-07 15:05:49', 'quiz', NULL, 'New quiz question added: who helps you'),
(47, NULL, NULL, 0, '2024-04-07 15:59:40', 'quiz', NULL, 'New quiz question added: who helps me'),
(48, NULL, NULL, 0, '2024-04-07 16:23:57', 'quiz', NULL, 'New quiz question added: who helps o'),
(49, NULL, NULL, 0, '2024-04-07 16:56:20', 'quiz', NULL, 'New quiz question added: who helps you'),
(50, NULL, NULL, 0, '2024-04-07 16:57:13', 'quiz', NULL, 'New quiz question added: who'),
(51, NULL, NULL, 0, '2024-04-07 17:14:15', 'quiz', NULL, 'New quiz question added: who helps me'),
(52, NULL, NULL, 0, '2024-04-07 17:14:52', 'quiz', NULL, 'New quiz question added: w'),
(53, NULL, NULL, 0, '2024-04-07 17:25:08', 'quiz', NULL, 'New quiz question added: w'),
(54, NULL, NULL, 0, '2024-04-07 17:27:52', 'quiz', NULL, 'New quiz question added: w'),
(55, NULL, NULL, 0, '2024-04-07 18:39:01', 'quiz', NULL, 'New quiz question added: who helps you'),
(56, NULL, NULL, 0, '2024-04-07 19:06:27', 'quiz', NULL, 'New quiz question added: who helps you'),
(57, NULL, NULL, 0, '2024-04-07 19:06:35', 'quiz', NULL, 'New quiz question added: who helps you'),
(58, NULL, NULL, 0, '2024-04-07 19:06:47', 'quiz', NULL, 'New quiz question added: who helps you'),
(59, NULL, NULL, 0, '2024-04-07 19:14:35', 'quiz', NULL, 'New quiz question added: who helps you and me alot'),
(60, NULL, NULL, 0, '2024-04-07 19:16:06', 'quiz', NULL, 'New quiz question added: who helps you and me a lot you say '),
(61, NULL, NULL, 0, '2024-04-07 19:55:00', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo'),
(62, NULL, NULL, 0, '2024-04-08 08:43:50', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yo'),
(63, NULL, NULL, 0, '2024-04-08 10:01:17', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yotttttttt'),
(64, NULL, NULL, 0, '2024-04-08 10:19:53', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh'),
(65, NULL, NULL, 0, '2024-04-08 11:07:37', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD'),
(66, NULL, NULL, 0, '2024-04-08 11:49:36', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh'),
(67, NULL, NULL, 0, '2024-04-08 12:04:09', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(68, NULL, NULL, 0, '2024-04-08 12:09:48', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(69, NULL, NULL, 0, '2024-04-08 12:10:11', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(70, NULL, NULL, 0, '2024-04-08 12:10:25', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(71, NULL, NULL, 0, '2024-04-08 12:14:20', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(72, NULL, NULL, 0, '2024-04-08 12:20:54', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(73, NULL, NULL, 0, '2024-04-08 12:24:25', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(74, NULL, NULL, 0, '2024-04-08 16:49:42', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(75, NULL, NULL, 0, '2024-04-08 17:27:57', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(76, NULL, NULL, 0, '2024-04-08 17:33:03', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(77, NULL, NULL, 0, '2024-04-08 17:35:11', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(78, NULL, NULL, 0, '2024-04-08 17:36:18', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(79, NULL, NULL, 0, '2024-04-08 17:37:53', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(80, NULL, NULL, 0, '2024-04-08 17:41:15', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(81, NULL, NULL, 0, '2024-04-08 17:43:17', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(82, NULL, NULL, 0, '2024-04-08 17:49:47', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(83, NULL, NULL, 0, '2024-04-08 17:50:49', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(84, NULL, NULL, 0, '2024-04-08 17:51:20', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(85, NULL, NULL, 0, '2024-04-08 17:53:34', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(86, NULL, NULL, 0, '2024-04-08 17:54:14', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(87, NULL, NULL, 0, '2024-04-08 18:03:29', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(88, NULL, NULL, 0, '2024-04-08 18:03:40', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(89, NULL, NULL, 0, '2024-04-08 18:11:29', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(90, NULL, NULL, 0, '2024-04-08 18:12:50', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(91, NULL, NULL, 0, '2024-04-08 18:13:54', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(92, NULL, NULL, 0, '2024-04-08 18:29:12', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot yottttttttjyiltukrysetjdkfgh  dsaD hgf,dhmg jg,fh gjv;id\\whiadcsvj'),
(93, NULL, NULL, 0, '2024-04-08 20:26:14', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot'),
(94, NULL, NULL, 0, '2024-04-08 20:31:16', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot'),
(95, NULL, NULL, 0, '2024-04-08 20:32:28', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot more'),
(96, NULL, NULL, 0, '2024-04-08 20:45:08', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot more'),
(97, NULL, NULL, 0, '2024-04-19 17:04:51', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot'),
(98, NULL, NULL, 0, '2024-04-19 17:05:42', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and '),
(99, NULL, NULL, 0, '2024-04-19 17:06:14', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps y'),
(100, NULL, NULL, 0, '2024-04-19 17:52:56', 'quiz', NULL, 'New quiz question added: who helps you and me '),
(101, NULL, NULL, 0, '2024-04-19 17:54:07', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo '),
(102, NULL, NULL, 0, '2024-04-19 18:48:09', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you and me a lot y'),
(103, 1, 40, 0, '2024-04-20 08:59:41', 'lesson', 40, 'New lesson added: java'),
(104, 3, 40, 0, '2024-04-20 08:59:41', 'lesson', 40, 'New lesson added: java'),
(105, 17, 40, 1, '2024-04-20 08:59:41', 'lesson', 40, 'New lesson added: java'),
(106, 1, 41, 0, '2024-04-20 09:47:34', 'lesson', 41, 'New lesson added: local video'),
(107, 3, 41, 0, '2024-04-20 09:47:34', 'lesson', 41, 'New lesson added: local video'),
(108, NULL, 41, 0, '2024-04-20 09:47:34', 'lesson', 41, 'New lesson added: local video'),
(109, 1, 42, 0, '2024-04-20 09:48:50', 'lesson', 42, 'New lesson added: first class'),
(110, 3, 42, 0, '2024-04-20 09:48:50', 'lesson', 42, 'New lesson added: first class'),
(111, 17, 42, 0, '2024-04-20 09:48:50', 'lesson', 42, 'New lesson added: first class'),
(112, 1, 43, 0, '2024-04-20 10:37:34', 'lesson', 43, 'New lesson added: class two'),
(113, 3, 43, 0, '2024-04-20 10:37:34', 'lesson', 43, 'New lesson added: class two'),
(114, NULL, 43, 0, '2024-04-20 10:37:34', 'lesson', 43, 'New lesson added: class two'),
(115, 1, 44, 0, '2024-04-20 10:38:25', 'lesson', 44, 'New lesson added: n'),
(116, 3, 44, 0, '2024-04-20 10:38:25', 'lesson', 44, 'New lesson added: n'),
(117, 17, 44, 0, '2024-04-20 10:38:25', 'lesson', 44, 'New lesson added: n'),
(118, 1, 45, 0, '2024-04-20 11:53:55', 'lesson', 45, 'New lesson added: ddd'),
(119, 3, 45, 0, '2024-04-20 11:53:55', 'lesson', 45, 'New lesson added: ddd'),
(120, 17, 45, 0, '2024-04-20 11:53:55', 'lesson', 45, 'New lesson added: ddd'),
(121, 1, 46, 0, '2024-04-20 12:03:35', 'lesson', 46, 'New lesson added: one'),
(122, 3, 46, 0, '2024-04-20 12:03:35', 'lesson', 46, 'New lesson added: one'),
(123, 17, 46, 0, '2024-04-20 12:03:35', 'lesson', 46, 'New lesson added: one'),
(124, 1, 47, 0, '2024-04-20 14:17:13', 'lesson', 47, 'New lesson added: dustin'),
(125, 3, 47, 0, '2024-04-20 14:17:13', 'lesson', 47, 'New lesson added: dustin'),
(126, 17, 47, 0, '2024-04-20 14:17:13', 'lesson', 47, 'New lesson added: dustin'),
(127, 1, 48, 0, '2024-04-20 19:15:07', 'lesson', 48, 'New lesson added: last'),
(128, 3, 48, 0, '2024-04-20 19:15:07', 'lesson', 48, 'New lesson added: last'),
(129, 17, 48, 0, '2024-04-20 19:15:07', 'lesson', 48, 'New lesson added: last'),
(130, 1, 49, 0, '2024-04-27 08:47:29', 'lesson', 49, 'New lesson added: yes'),
(131, 3, 49, 0, '2024-04-27 08:47:29', 'lesson', 49, 'New lesson added: yes'),
(132, 17, 49, 0, '2024-04-27 08:47:29', 'lesson', 49, 'New lesson added: yes'),
(133, 1, 50, 0, '2024-04-27 08:48:42', 'lesson', 50, 'New lesson added: yes'),
(134, 3, 50, 0, '2024-04-27 08:48:42', 'lesson', 50, 'New lesson added: yes'),
(135, 1, 51, 0, '2024-04-27 11:34:16', 'lesson', 51, 'New lesson added: qw'),
(136, 3, 51, 0, '2024-04-27 11:34:16', 'lesson', 51, 'New lesson added: qw'),
(137, 17, 51, 0, '2024-04-27 11:34:16', 'lesson', 51, 'New lesson added: qw'),
(138, 1, 38, 0, '2024-04-27 16:05:07', 'material', NULL, 'New material added: abrsh'),
(139, 3, 38, 0, '2024-04-27 16:05:07', 'material', NULL, 'New material added: abrsh'),
(140, 17, 38, 1, '2024-04-27 16:05:07', 'material', NULL, 'New material added: abrsh'),
(141, 1, 39, 0, '2024-04-27 16:09:22', 'material', NULL, 'New material added: abrsh'),
(142, 3, 39, 0, '2024-04-27 16:09:22', 'material', NULL, 'New material added: abrsh'),
(143, 17, 39, 0, '2024-04-27 16:09:22', 'material', NULL, 'New material added: abrsh'),
(144, 1, 40, 0, '2024-04-27 16:10:39', 'material', NULL, 'New material added: abrsh'),
(145, 3, 40, 0, '2024-04-27 16:10:39', 'material', NULL, 'New material added: abrsh'),
(146, 17, 40, 0, '2024-04-27 16:10:39', 'material', NULL, 'New material added: abrsh'),
(147, 1, 41, 0, '2024-04-27 16:11:16', 'material', NULL, 'New material added: abrsh'),
(148, 3, 41, 0, '2024-04-27 16:11:16', 'material', NULL, 'New material added: abrsh'),
(149, 17, 41, 0, '2024-04-27 16:11:16', 'material', NULL, 'New material added: abrsh'),
(150, 1, 42, 0, '2024-04-27 16:16:26', 'material', NULL, 'New material added: abrsh'),
(151, 3, 42, 0, '2024-04-27 16:16:26', 'material', NULL, 'New material added: abrsh'),
(152, 17, 42, 0, '2024-04-27 16:16:26', 'material', NULL, 'New material added: abrsh'),
(153, 1, 43, 0, '2024-04-27 16:18:37', 'material', NULL, 'New material added: abrsh'),
(154, 3, 43, 0, '2024-04-27 16:18:37', 'material', NULL, 'New material added: abrsh'),
(155, 17, 43, 0, '2024-04-27 16:18:37', 'material', NULL, 'New material added: abrsh'),
(156, 1, 44, 0, '2024-04-27 16:19:33', 'material', NULL, 'New material added: pic'),
(157, 3, 44, 0, '2024-04-27 16:19:33', 'material', NULL, 'New material added: pic'),
(158, 17, 44, 1, '2024-04-27 16:19:33', 'material', NULL, 'New material added: pic'),
(159, 1, 45, 0, '2024-04-27 16:31:51', 'material', NULL, 'New material added: yesi'),
(160, 3, 45, 0, '2024-04-27 16:31:51', 'material', NULL, 'New material added: yesi'),
(161, 17, 45, 1, '2024-04-27 16:31:51', 'material', NULL, 'New material added: yesi'),
(162, 1, 46, 0, '2024-04-27 17:01:47', 'material', NULL, 'New material added: test'),
(163, 3, 46, 0, '2024-04-27 17:01:47', 'material', NULL, 'New material added: test'),
(164, NULL, 46, 0, '2024-04-27 17:01:47', 'material', NULL, 'New material added: test'),
(165, 1, 47, 0, '2024-04-27 17:02:54', 'material', NULL, 'New material added: testhlugkfydjtkhjl'),
(166, 3, 47, 0, '2024-04-27 17:02:54', 'material', NULL, 'New material added: testhlugkfydjtkhjl'),
(167, NULL, 47, 0, '2024-04-27 17:02:54', 'material', NULL, 'New material added: testhlugkfydjtkhjl'),
(168, 1, 48, 0, '2024-04-27 17:03:44', 'material', NULL, 'New material added: dustinnljhguf'),
(169, 3, 48, 0, '2024-04-27 17:03:44', 'material', NULL, 'New material added: dustinnljhguf'),
(170, 17, 48, 1, '2024-04-27 17:03:44', 'material', NULL, 'New material added: dustinnljhguf'),
(171, NULL, NULL, 0, '2024-04-27 20:06:30', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you an'),
(172, NULL, NULL, 0, '2024-04-27 20:06:48', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you anhg,'),
(173, NULL, NULL, 0, '2024-04-27 20:07:18', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you anhg,hg'),
(174, NULL, NULL, 0, '2024-04-27 20:17:45', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you anhg,hg'),
(175, NULL, NULL, 0, '2024-04-27 22:15:26', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you anhg,hg'),
(176, NULL, NULL, 0, '2024-04-27 22:15:36', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you anhg,hgt'),
(177, NULL, NULL, 0, '2024-04-27 22:17:32', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you anhg,hgt'),
(178, NULL, NULL, 0, '2024-04-27 22:17:39', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you anhg,hgthds'),
(179, NULL, NULL, 0, '2024-04-28 00:05:25', 'quiz', NULL, 'New quiz question added: who helps you and me a lot yo who helps you anhg,hgthdst'),
(180, 3, 9, 0, '2024-05-10 06:43:55', 'Notice', 9, 'A new notice has been posted in one of your courses.'),
(181, 17, 9, 0, '2024-05-10 06:43:55', 'Notice', 9, 'A new notice has been posted in one of your courses.'),
(182, 20, 9, 0, '2024-05-10 06:43:55', 'Notice', 9, 'A new notice has been posted in one of your courses.'),
(183, 3, 10, 0, '2024-05-10 06:45:16', 'Notice', 10, 'A new notice has been posted in one of your courses.'),
(184, 3, 49, 0, '2024-05-22 15:35:21', 'material', NULL, 'New material added: jhgffh'),
(185, 3, 50, 0, '2024-05-22 15:39:13', 'material', NULL, 'New material added: re'),
(186, 17, 50, 0, '2024-05-22 15:39:13', 'material', NULL, 'New material added: re'),
(187, 20, 50, 0, '2024-05-22 15:39:13', 'material', NULL, 'New material added: re');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `Q_id` int(11) NOT NULL,
  `Q_stu_id` int(11) DEFAULT NULL,
  `q_body` text DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `q_timestamp` datetime DEFAULT current_timestamp(),
  `resolved` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`Q_id`, `Q_stu_id`, `q_body`, `course_id`, `q_timestamp`, `resolved`) VALUES
(1, NULL, '<p>what is php</p>', 2, '2024-03-29 22:06:58', 'no'),
(2, 4, '<h1 style=\"text-align: justify;\"><strong>what is php</strong></h1>', 2, '2024-03-29 22:56:50', 'no'),
(3, 1, '<p>This code combines both functionalities seamlessly, displaying questions along with a part of one answer and allowing users to show more answers by clicking a button. It also implements real-time search functionality without the need for a search button.</p>', 3, '2024-03-30 02:16:43', 'no'),
(7, 1, 'juo;yitlurkyt', 2, '2024-03-30 14:58:57', 'no'),
(8, 3, '<p>this is my question</p>', 3, '2024-03-31 19:56:33', 'no'),
(9, 3, '<p>iofrrrrrrrrrrrrrrrrrrrrrrrr</p>', 2, '2024-03-31 21:32:34', 'no'),
(10, 3, '<p>iofrrrrrrrrrrrrrrrrrrrrrrrr</p>', 3, '2024-03-31 21:34:30', 'no'),
(11, 3, '<p>iofrrrrrrrrrrrrrrrrrrrrrrrr</p>', 5, '2024-03-31 21:35:42', 'no'),
(12, 3, '<p>iofrrrrrrrrrrrrrrrrrrrrrrrr</p>', 3, '2024-03-31 21:40:10', 'no'),
(13, 3, '<p>iofrrrrrrrrrrrrrrrrrrrrrrrr</p>', 3, '2024-03-31 21:42:08', 'no'),
(14, 3, '<p>iofrrrrrrrrrrrrrrrrrrrrrrrr</p>', 3, '2024-03-31 21:45:48', 'no'),
(18, 3, '<p>how you look at me&nbsp;</p>\r\n<p>&nbsp;</p>', 5, '2024-03-31 21:57:06', 'no'),
(19, 17, 'what is data mean for you give me your answer', 2, '2024-05-23 19:19:44', 'no'),
(20, 17, 'my question is what is your aim', 3, '2024-05-23 22:19:06', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_result`
--

CREATE TABLE `quiz_result` (
  `id` int(11) NOT NULL,
  `stu_id` int(11) DEFAULT NULL,
  `exam_type` varchar(255) DEFAULT NULL,
  `total_question` int(11) DEFAULT NULL,
  `correct_answer` int(11) DEFAULT NULL,
  `wrong_answer` int(11) DEFAULT NULL,
  `exam_time` varchar(255) DEFAULT NULL,
  `mark` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_result`
--

INSERT INTO `quiz_result` (`id`, `stu_id`, `exam_type`, `total_question`, `correct_answer`, `wrong_answer`, `exam_time`, `mark`, `course_id`) VALUES
(8, 17, 'des', 2, 2, 0, '2024-05-07 07:31:14', 100, NULL),
(13, 17, 'des', 2, 2, 0, '2024-05-07 13:38:56', 100, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `reply_id` int(11) NOT NULL,
  `feedback_id` int(11) DEFAULT NULL,
  `reply_content` text DEFAULT NULL,
  `reply_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `edited` tinyint(1) DEFAULT 0,
  `edit_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`reply_id`, `feedback_id`, `reply_content`, `reply_time`, `edited`, `edit_time`) VALUES
(33, 7, 'uhd', '2024-03-26 17:07:59', 1, '2024-03-26 20:08:16'),
(34, 12, '/hdskc', '2024-03-26 19:37:24', 1, '2024-03-27 00:09:22'),
(35, 20, 'jlZV?CIK/DYCSaxhvjgctfjadgksyfio;pfiodgfdsdgsfjk;jldsjghmshvjkl;knjdbvbkjlewouiytfusdvjcnbknlkho;gidsv;nzxlc\'naobdvsian kzkcbhi', '2024-03-26 21:08:51', 1, '2024-03-27 00:09:33'),
(36, 8, 'hi desu pic new', '2024-03-28 17:32:13', 0, NULL),
(37, 31, 'thanks', '2024-04-19 20:05:34', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `stu_id` int(11) NOT NULL,
  `stu_name` varchar(255) DEFAULT NULL,
  `stu_email` varchar(255) DEFAULT NULL,
  `stu_pass` varchar(255) DEFAULT NULL,
  `stu_occ` varchar(255) DEFAULT NULL,
  `stu_img` text DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `online_status` enum('online','offline') NOT NULL DEFAULT 'offline',
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stu_id`, `stu_name`, `stu_email`, `stu_pass`, `stu_occ`, `stu_img`, `email_verified`, `online_status`, `otp`, `otp_expiry`, `reset_token`, `reset_expiry`) VALUES
(3, 'mylove', 'mylove@gmail.com', 'd42905badaded5dff36e7a7645f924d3', '', '../Images/Student/photo_2024-02-27_15-55-37.jpg', 0, 'offline', NULL, NULL, NULL, NULL),
(4, 'example', 'example@gmail.com', '8342da4a7ef469194556ea2561b1f116', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(5, 'kidist', 'kidist@gmail.com', '8342da4a7ef469194556ea2561b1f116', '', '../Images/Student/th.jpg', 0, 'offline', NULL, NULL, NULL, NULL),
(17, 'destinking', 'destinking06@gmail.com', '$2y$10$AuPTGHiUG9AAz0ZykpbF9OfR/mRjwlDx0pMRMD86B5jR2trC2gEvy', '', '../Images/Student/photo_2024-01-03_23-36-02.jpg', 1, 'online', NULL, NULL, NULL, NULL),
(18, 'desalgn', 'desalegngezmu@gmail.com', '$2y$10$1HjkwSS.FaHp22HDhms2s.UFd/.mVyEDDdpkm20OAxWHOOBF2G.Z.', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(19, 'nahome', 'nahomammanuel23@gmail.com', '$2y$10$qXPQNwDapJFBTx5MJPv81ec7.X89w6B01mzTTS.HRD2utQVdkowEK', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(20, 'nahome', 'Desudes0621@gmail.com', '$2y$10$VYwdm2oEY8KeoKCeLRaKkeoTGTUb7weYJDmWfntp1E1liU05UOWAO', '', '../Images/Student/photo_2023-12-09_08-03-55.jpg', 1, 'offline', NULL, NULL, NULL, NULL),
(21, 'aschalw', 'Desudes1@gmail.com', '$2y$10$m7Rqmpo2Rczsa/Kcjh3eQOiAut5kHDaqJerYQW2sebaXeEgwWBE7e', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(22, 'exampe', 'aschalw@gmail.com', '$2y$10$jrbZ0kQaVyTb8VYz4753XujyjYktF.cLViG/3Uf6DO8fFyLc7bhKW', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(23, 'exampe', 'desuz@email.com', '$2y$10$8wCa7kZwBAhnIAzODSC8VObuOx/9xGnWTKDOCO4sHr/rLYTU6UTlm', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(24, 'aschalw aschalw', 'aschalww@gmail.com', '$2y$10$nZzqMXacnzc4zrpahE94buf6X2A4ASok3obmkOk.Pu.dyCteL4rHe', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(28, 'Destaw Aschalw', 'ethiolearningacadmy@gmail.com', '$2y$10$idCXWM4DkoCXeaBdYki8AekrvQENwzcXw6Ip0IJTHJnhYQiHaqzQ.', NULL, NULL, 1, 'offline', '306031', '2024-05-26 00:04:00', '7612dac5b50cd8bc08afdef81c4deb90', '2024-05-26 00:35:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_ques`
--
ALTER TABLE `add_ques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `answerlikes`
--
ALTER TABLE `answerlikes`
  ADD PRIMARY KEY (`Like_id`),
  ADD UNIQUE KEY `unique_like` (`Student_id`,`Answer_id`),
  ADD KEY `fk_answer_id` (`Answer_id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`A_id`),
  ADD KEY `Q_id` (`Q_id`),
  ADD KEY `A_stu_id` (`A_stu_id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stu_id` (`stu_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- Indexes for table `courseorder`
--
ALTER TABLE `courseorder`
  ADD PRIMARY KEY (`co_id`),
  ADD KEY `stu_id` (`stu_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `exam_category`
--
ALTER TABLE `exam_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`catergory`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `fk_exam_result_course` (`course_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `stu_id` (`stu_id`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`l_id`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `fk_lesson_progress_lesson_id` (`lesson_id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `fk_course_id` (`course_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`notice_id`),
  ADD KEY `lecturer_id` (`lecturer_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `stu_id` (`stu_id`),
  ADD KEY `material_id` (`material_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`Q_id`),
  ADD KEY `Q_stu_id` (`Q_stu_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stu_id` (`stu_id`),
  ADD KEY `fk_quiz_result_course` (`course_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `feedback_id` (`feedback_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`stu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_ques`
--
ALTER TABLE `add_ques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `answerlikes`
--
ALTER TABLE `answerlikes`
  MODIFY `Like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `A_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=837;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courseorder`
--
ALTER TABLE `courseorder`
  MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `exam_category`
--
ALTER TABLE `exam_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `l_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lesson`
--
ALTER TABLE `lesson`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `Q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `quiz_result`
--
ALTER TABLE `quiz_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answerlikes`
--
ALTER TABLE `answerlikes`
  ADD CONSTRAINT `fk_answer_id` FOREIGN KEY (`Answer_id`) REFERENCES `answers` (`A_id`),
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`Student_id`) REFERENCES `students` (`stu_id`);

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`Q_id`) REFERENCES `questions` (`Q_id`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`A_stu_id`) REFERENCES `students` (`stu_id`);

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`);

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `courseorder`
--
ALTER TABLE `courseorder`
  ADD CONSTRAINT `courseorder_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`),
  ADD CONSTRAINT `courseorder_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`stu_id`),
  ADD CONSTRAINT `fk_exam_result_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`);

--
-- Constraints for table `lesson`
--
ALTER TABLE `lesson`
  ADD CONSTRAINT `lesson_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `fk_lesson_progress_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lesson` (`lesson_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `lectures` (`l_id`),
  ADD CONSTRAINT `notices_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`Q_stu_id`) REFERENCES `students` (`stu_id`),
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);

--
-- Constraints for table `quiz_result`
--
ALTER TABLE `quiz_result`
  ADD CONSTRAINT `fk_quiz_result_course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_result_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`f_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
