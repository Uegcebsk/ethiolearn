-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2024 at 06:18 PM
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
(1, 'desu@gmail.com', 'desu123', 'dustin', 'online');

-- --------------------------------------------------------

--
-- Table structure for table `answerlikes`
--

CREATE TABLE `answerlikes` (
  `Like_id` int(11) NOT NULL,
  `Student_id` int(11) DEFAULT NULL,
  `Answer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(25, 'order_660d5d6b1dbd4', 3, 4, '12', '2024-04-03', 'mylove', 'mylove@gmail.com', 'phyton', ''),
(53, '661abab4c4acb', 17, 4, '12', '2024-04-13', 'destinking', 'destinking06@gmail.com', 'phyton', ''),
(58, '66485c0e2d67f', 17, 5, '1200', '2024-05-18', 'destinking', 'destinking06@gmail.com', 'javaa', ''),
(70, '666c41b4159c4', 37, 4, '12', '2024-06-14', 'Destaw Aschalw', 'danielsemela83@gmail.com', 'phyton', '');

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
(232, 'exam 2', 'true_false', 'this is me ok yes me33333344khjgfkhljk the', 'True', '', '', '', '', '11'),
(233, '', 'multiple_choice', 'god always helps me in every moment i take the apple', 'abcd', 'win', 'database', 'question', 'abcd', '4'),
(234, '', 'multiple_choice', 'god always helps me in every moment i take the apple make', 'abcd', 'win', 'database', 'question', 'abcd', '5'),
(235, '', 'multiple_choice', 'god always helps me in every moment i take this', 'dda', 'database', 'dah', 'dda', 'ddaas', '6'),
(236, '', 'true_false', 'this is me ok yes', 'True', '', '', '', '', '7'),
(237, 'exam 2', 'multiple_choice', 'god always helps me in every moment i take that', 'eeeee', 'databasese', 'e', 'eeeeeeeeeeee', 'eeeee', '12'),
(238, '', 'true_false', 'what is data base is', 'True', '', '', '', '', '8'),
(239, 'exam 2', 'multiple_choice', 'god always helps me in every moment i take run', 'www', 'gegve', 'trtew', 'www', 'rrrrrrrrr', '13'),
(240, 'this', 'true_false', '', 'False', '', '', '', '', '5'),
(241, 'this', 'multiple_choice', 'god always helps me in every moment i takerr', 'www', 'gegve', 'trtew', 'www', 'rrrrrrrrr', '6'),
(242, 'this', 'multiple_choice', 'god always helps me in every moment i takerr hw ', 'www', 'gegve', 'trtew', 'www', 'rrrrrrrrr', '7'),
(243, 'this', 'multiple_choice', 'god always helps me in every moment i take that is', 'no', 'has', 'www', 'yes', 'no', '8'),
(244, '', 'true_false', 'this is me ok yes ok', 'True', '', '', '', '', '9'),
(245, 'exam 2', 'fill_in_the_blank', 'god always helps me in every moment i take that this', '', '', '', '', '', '14'),
(246, 'exam 2', 'fill_in_the_blank', 'god always helps me in every moment i take that this u no ', '', '', '', '', '', '15'),
(247, 'exam 2', 'fill_in_the_blank', 'what is chemistry', '', '', '', '', '', '16'),
(248, 'this', 'true_false', 'god always helps me in every moment i take3wv hgfhdfdhjuiop[opuiffdgsdfdo', 'False', '', '', '', '', '9'),
(249, 'exam 2', 'true_false', 'god always helps me in every moment i take3wv hgfhdfdhjuiop[opuiffdgsdfdo', 'True', '', '', '', '', '17'),
(250, 'exam 2', 'fill_in_the_blank', 'god always helps me in every moment i take a known', '', '', '', '', '', '18');

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
(42, 'first class', 'this is the first video from local file', 'Videos/LessonVideos/WIN_20240420_10_46_16_Pro.mp4', 4, NULL, NULL, '2024-05-24 11:10:10'),
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
(279, 17, 42, 'localvideo', 89.8572, 0, '2024-04-27 14:03:00', 4),
(280, 17, 42, 'localvideo', 89.8572, 0, '2024-04-27 14:03:00', 4),
(281, 17, 48, 'localvideo', 90.0013, 0, '2024-05-01 15:53:03', 4),
(283, 37, 42, 'localvideo', 74.9544, 0, '2024-06-14 13:12:41', 4);

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
(48, 'dustinnljhguf', 4, 'ou;turyeturtyu', 'Document', '../instructor/material/662d13d0736c7_dustinnljhguf.docx', '2024-04-27 18:03:44'),
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
(100, 2, 'lecturer', 17, 'student', 'this is for you', 'hi', '2024-06-10 11:14:22', 0, NULL),
(101, 2, 'lecturer', -1, 'admin', 'this is for you', 'hello', '2024-06-10 11:14:59', 1, NULL),
(102, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'pic', '2024-06-10 11:16:00', 0, 101),
(103, 1, 'admin', 2, 'lecturer', 'Re: this is for you', 'pic', '2024-06-10 11:16:11', 0, 101),
(104, 2, 'lecturer', 1, 'admin', 'Re: Re: this is for you', 'helo', '2024-06-10 11:16:36', 1, 103),
(105, 2, 'lecturer', 1, 'admin', 'Re: Re: this is for you', 'efrata', '2024-06-10 11:18:18', 1, 103);

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
(7, 2, 4, 'dustin', 'fkjy', '2024-05-10 03:34:00'),
(8, 2, 4, 'w', 'des', '2024-05-10 03:43:16'),
(9, 2, 4, 'w', 'des', '2024-05-10 03:43:55');

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
(11, 3, '<p>iofrrrrrrrrrrrrrrrrrrrrrrrr</p>', 5, '2024-03-31 21:35:42', 'no'),
(18, 3, '<p>how you look at me&nbsp;</p>\r\n<p>&nbsp;</p>', 5, '2024-03-31 21:57:06', 'no');

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
(37, 31, 'thanks', '2024-04-19 20:05:34', 0, NULL),
(38, 41, 'sjks', '2024-06-09 08:18:21', 0, NULL);

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
(17, 'destinking', 'destinking06@gmail.com', '$2y$10$AuPTGHiUG9AAz0ZykpbF9OfR/mRjwlDx0pMRMD86B5jR2trC2gEvy', '', '../Images/Student/photo_2024-01-03_23-36-02.jpg', 1, 'offline', NULL, NULL, NULL, NULL),
(18, 'desalgn', 'desalegngezmu@gmail.com', '$2y$10$1HjkwSS.FaHp22HDhms2s.UFd/.mVyEDDdpkm20OAxWHOOBF2G.Z.', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(19, 'nahome', 'nahomammanuel23@gmail.com', '$2y$10$qXPQNwDapJFBTx5MJPv81ec7.X89w6B01mzTTS.HRD2utQVdkowEK', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(21, 'aschalw', 'Desudes1@gmail.com', '$2y$10$m7Rqmpo2Rczsa/Kcjh3eQOiAut5kHDaqJerYQW2sebaXeEgwWBE7e', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(22, 'exampe', 'aschalw@gmail.com', '$2y$10$jrbZ0kQaVyTb8VYz4753XujyjYktF.cLViG/3Uf6DO8fFyLc7bhKW', NULL, NULL, 0, 'offline', NULL, NULL, 'bd3edebcb83e024b04136d27dca6fbeb', '2024-06-11 18:06:20'),
(23, 'exampe', 'desuz@email.com', '$2y$10$8wCa7kZwBAhnIAzODSC8VObuOx/9xGnWTKDOCO4sHr/rLYTU6UTlm', NULL, NULL, 0, 'offline', NULL, NULL, NULL, NULL),
(35, 'Destaw Aschalw', 'deshe@gmail.com', '$2y$10$.cfH1onnERBzOA37lGWTuOiFBjkZASj6KvhJNuqGHN8ecYonhfZ9i', NULL, NULL, 0, 'offline', '844408', '2024-06-14 16:01:59', NULL, NULL),
(36, 'Destaw a', 'des@gmail.com', '$2y$10$G/6HU8GrvFurTE5bwWPqO.cg2TYN92Udtcddg1AY3Nv1ca1WhmOrm', NULL, NULL, 0, 'offline', '464909', '2024-06-14 16:02:38', NULL, NULL),
(37, 'Destaw Aschalw', 'danielsemela83@gmail.com', '$2y$10$BxYdr/cByGHQKOqR.nSY6.1HVc045qF4wl7XjIbw7fdNEvUtBSXGW', NULL, NULL, 1, 'online', '280596', '2024-06-14 16:07:59', NULL, NULL);

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
  ADD KEY `answers_ibfk_1` (`Q_id`),
  ADD KEY `answers_ibfk_2` (`A_stu_id`);

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
  ADD KEY `courseorder_ibfk_1` (`stu_id`),
  ADD KEY `courseorder_ibfk_2` (`course_id`);

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
  ADD KEY `lesson_ibfk_1` (`course_id`);

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
  ADD KEY `notices_ibfk_2` (`course_id`);

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
  ADD KEY `questions_ibfk_2` (`course_id`),
  ADD KEY `questions_ibfk_1` (`Q_stu_id`);

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
  MODIFY `Like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `A_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=841;

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
  MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `exam_category`
--
ALTER TABLE `exam_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

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
  MODIFY `Q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `quiz_result`
--
ALTER TABLE `quiz_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answerlikes`
--
ALTER TABLE `answerlikes`
  ADD CONSTRAINT `fk_answer_id` FOREIGN KEY (`Answer_id`) REFERENCES `answers` (`A_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`Student_id`) REFERENCES `students` (`stu_id`);

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`Q_id`) REFERENCES `questions` (`Q_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`A_stu_id`) REFERENCES `students` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `courseorder_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courseorder_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `lesson_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `notices_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`stu_id`) REFERENCES `students` (`stu_id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`Q_stu_id`) REFERENCES `students` (`stu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
