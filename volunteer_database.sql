-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2024 at 02:30 PM
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
-- Database: `volunteer_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `deleted_schools`
--

CREATE TABLE `deleted_schools` (
  `deleted_school_id` int(11) NOT NULL,
  `schoolID` int(11) NOT NULL,
  `delete_fact` tinyint(1) NOT NULL DEFAULT 0,
  `delete_history` timestamp NULL DEFAULT NULL,
  `user_stamp` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_schools`
--

INSERT INTO `deleted_schools` (`deleted_school_id`, `schoolID`, `delete_fact`, `delete_history`, `user_stamp`) VALUES
(1, 1, 0, NULL, NULL),
(2, 2, 0, NULL, NULL),
(3, 5, 1, '2024-06-13 03:46:34', 'tchoat@cis-hot.org'),
(4, 6, 1, '2024-06-15 01:06:08', 'tchoat@cis-hot.org');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_servicecode`
--

CREATE TABLE `deleted_servicecode` (
  `deleted_service_codeID` int(11) NOT NULL,
  `service_codeID` int(11) NOT NULL,
  `delete_fact` tinyint(1) NOT NULL DEFAULT 0,
  `delete_history` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `user_stamp` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_servicecode`
--

INSERT INTO `deleted_servicecode` (`deleted_service_codeID`, `service_codeID`, `delete_fact`, `delete_history`, `user_stamp`) VALUES
(1, 1, 0, '2024-06-13 19:34:32', ''),
(2, 2, 0, '2024-06-13 21:10:45', NULL),
(3, 3, 1, '2024-06-15 01:25:55', 'tchoat@cis-hot.org');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_services`
--

CREATE TABLE `deleted_services` (
  `deleted_service_id` int(30) NOT NULL,
  `serviceID` int(30) NOT NULL,
  `delete_fact` tinyint(1) NOT NULL,
  `delete_reasonID` varchar(30) DEFAULT NULL,
  `delete_comment` text DEFAULT NULL,
  `delete_date` timestamp(6) NULL DEFAULT NULL,
  `user_stamp` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_services`
--

INSERT INTO `deleted_services` (`deleted_service_id`, `serviceID`, `delete_fact`, `delete_reasonID`, `delete_comment`, `delete_date`, `user_stamp`) VALUES
(10, 28, 0, NULL, NULL, NULL, NULL),
(11, 29, 0, NULL, NULL, NULL, NULL),
(12, 30, 0, NULL, NULL, NULL, NULL),
(13, 31, 0, NULL, NULL, NULL, NULL),
(14, 32, 0, NULL, NULL, NULL, NULL),
(15, 33, 0, NULL, NULL, NULL, NULL),
(16, 34, 0, NULL, NULL, NULL, NULL),
(19, 37, 0, NULL, NULL, NULL, NULL),
(20, 38, 0, NULL, NULL, NULL, NULL),
(21, 39, 0, NULL, NULL, NULL, NULL),
(22, 40, 0, NULL, NULL, NULL, NULL),
(23, 41, 1, '', 'wrong kid ', '2024-04-09 22:37:06.000000', 'testadmin'),
(24, 42, 0, NULL, NULL, NULL, NULL),
(25, 43, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deleted_staff`
--

CREATE TABLE `deleted_staff` (
  `deleted_staff_id` int(11) NOT NULL,
  `staff_ID` int(11) NOT NULL,
  `delete_fact` tinyint(1) NOT NULL DEFAULT 0,
  `delete_reason` varchar(255) DEFAULT NULL,
  `staff_comment` text DEFAULT NULL,
  `delete_history` timestamp NULL DEFAULT current_timestamp(),
  `user_stamp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_staff`
--

INSERT INTO `deleted_staff` (`deleted_staff_id`, `staff_ID`, `delete_fact`, `delete_reason`, `staff_comment`, `delete_history`, `user_stamp`) VALUES
(14, 44, 1, '1', '', '2024-05-23 03:20:30', 'tchoat@cis-hot.org'),
(15, 1, 0, NULL, NULL, '2024-05-22 20:16:10', 'tchoat@cis-hot.org'),
(16, 2, 0, NULL, NULL, '2024-05-22 20:16:10', 'tchoat@cis-hot.org'),
(17, 3, 0, NULL, NULL, '2024-05-22 20:16:10', 'tchoat@cis-hot.org'),
(18, 4, 0, NULL, NULL, '2024-05-22 20:16:10', 'tchoat@cis-hot.org'),
(19, 22, 0, NULL, NULL, '2024-05-22 20:16:10', 'tchoat@cis-hot.org');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_tiers`
--

CREATE TABLE `deleted_tiers` (
  `deleted_tierID` int(255) NOT NULL,
  `tierID` int(255) NOT NULL,
  `delete_fact` int(11) NOT NULL DEFAULT 0,
  `delete_history` timestamp NULL DEFAULT NULL,
  `user_stamp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_tiers`
--

INSERT INTO `deleted_tiers` (`deleted_tierID`, `tierID`, `delete_fact`, `delete_history`, `user_stamp`) VALUES
(1, 1, 0, NULL, NULL),
(2, 2, 0, NULL, NULL),
(3, 3, 0, NULL, NULL),
(4, 4, 1, '2024-06-22 03:14:57', 'tchoat@cis-hot.org');

-- --------------------------------------------------------

--
-- Table structure for table `delete_reason_table`
--

CREATE TABLE `delete_reason_table` (
  `delete_reasonID` int(30) NOT NULL,
  `delete_reason` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delete_reason_table`
--

INSERT INTO `delete_reason_table` (`delete_reasonID`, `delete_reason`) VALUES
(1, 'Duplicate'),
(2, 'False Entry');

-- --------------------------------------------------------

--
-- Table structure for table `delete_staff_reason`
--

CREATE TABLE `delete_staff_reason` (
  `delete_staff_reasonID` int(11) NOT NULL,
  `delete_staff_reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delete_staff_reason`
--

INSERT INTO `delete_staff_reason` (`delete_staff_reasonID`, `delete_staff_reason`) VALUES
(1, 'Inactive'),
(2, 'Layed off/Fired'),
(3, 'Internal Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `exit_list`
--

CREATE TABLE `exit_list` (
  `exit_id` int(10) NOT NULL,
  `volunteerID` int(10) NOT NULL,
  `exit_fact` tinyint(1) NOT NULL,
  `exit_reason` int(10) DEFAULT NULL,
  `comment` varchar(600) DEFAULT NULL,
  `exit_date` datetime DEFAULT NULL,
  `user_stamp` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exit_list`
--

INSERT INTO `exit_list` (`exit_id`, `volunteerID`, `exit_fact`, `exit_reason`, `comment`, `exit_date`, `user_stamp`) VALUES
(87, 203, 0, NULL, NULL, NULL, NULL),
(92, 216, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reason_table`
--

CREATE TABLE `reason_table` (
  `reasonID` int(11) NOT NULL,
  `reason_Text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reason_table`
--

INSERT INTO `reason_table` (`reasonID`, `reason_Text`) VALUES
(1, 'Graduated'),
(2, 'Cannot Contact');

-- --------------------------------------------------------

--
-- Table structure for table `role_list`
--

CREATE TABLE `role_list` (
  `user_role` int(11) NOT NULL,
  `role_name` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_list`
--

INSERT INTO `role_list` (`user_role`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Moderator'),
(3, 'Guest'),
(4, 'Baylor');

-- --------------------------------------------------------

--
-- Table structure for table `school_list`
--

CREATE TABLE `school_list` (
  `schoolID` int(11) NOT NULL,
  `school_name` varchar(320) NOT NULL,
  `on_off` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_list`
--

INSERT INTO `school_list` (`schoolID`, `school_name`, `on_off`) VALUES
(1, 'Test High School', 1),
(2, 'Waco High School', 1),
(5, 'Midway High School', 0),
(6, 'McGregor High School', 0);

-- --------------------------------------------------------

--
-- Table structure for table `school_queue`
--

CREATE TABLE `school_queue` (
  `school_selectID` int(11) NOT NULL,
  `volunteerID` int(11) NOT NULL,
  `schoolID` int(11) NOT NULL,
  `location_date` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_queue`
--

INSERT INTO `school_queue` (`school_selectID`, `volunteerID`, `schoolID`, `location_date`) VALUES
(317, 203, 2, '2024'),
(331, 216, 2, '2024');

-- --------------------------------------------------------

--
-- Table structure for table `school_status_mode`
--

CREATE TABLE `school_status_mode` (
  `modeID` int(11) NOT NULL,
  `statusID` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_status_mode`
--

INSERT INTO `school_status_mode` (`modeID`, `statusID`) VALUES
(1, 'CYD'),
(2, 'CIS');

-- --------------------------------------------------------

--
-- Table structure for table `school_status_queue`
--

CREATE TABLE `school_status_queue` (
  `historyID` int(11) NOT NULL,
  `schoolID` int(11) NOT NULL,
  `modeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_status_queue`
--

INSERT INTO `school_status_queue` (`historyID`, `schoolID`, `modeID`) VALUES
(1, 1, 2),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_code`
--

CREATE TABLE `service_code` (
  `service_codeID` int(11) NOT NULL,
  `service_code` varchar(10) NOT NULL,
  `on_off` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_code`
--

INSERT INTO `service_code` (`service_codeID`, `service_code`, `on_off`) VALUES
(1, '1001TT', 1),
(2, '1002TT', 1),
(3, '1003TT', 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_entry`
--

CREATE TABLE `service_entry` (
  `serviceID` int(11) NOT NULL,
  `volunteerID` int(10) NOT NULL,
  `service_date` date NOT NULL,
  `service_minutes` int(5) NOT NULL,
  `student_names` varchar(320) NOT NULL,
  `service_comment` varchar(1200) NOT NULL,
  `tierID` int(11) NOT NULL,
  `service_codeID` int(11) NOT NULL,
  `schoolID` int(10) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_stamp` varchar(600) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_entry`
--

INSERT INTO `service_entry` (`serviceID`, `volunteerID`, `service_date`, `service_minutes`, `student_names`, `service_comment`, `tierID`, `service_codeID`, `schoolID`, `entry_date`, `user_stamp`) VALUES
(28, 203, '2024-04-02', 60, 'Test', '', 2, 2, 2, '2024-04-04 15:21:11', ''),
(29, 203, '2024-03-13', 30, 'Test', '', 3, 1, 1, '2024-04-04 15:21:11', ''),
(30, 203, '2024-02-07', 15, 'Mr Mark', '', 1, 1, 1, '2024-04-04 15:21:11', ''),
(31, 203, '2024-03-11', 30, '', '', 1, 1, 2, '2024-04-04 15:21:11', ''),
(32, 203, '2024-03-06', 45, 'Mario', '', 1, 1, 1, '2024-04-04 15:21:11', ''),
(33, 203, '2024-04-03', 15, '', '', 1, 1, 2, '2024-04-04 15:21:11', ''),
(34, 203, '2024-04-03', 15, '', '', 1, 1, 1, '2024-04-04 15:21:11', ''),
(37, 203, '2024-04-04', 15, '', '', 1, 1, 1, '2024-04-04 15:25:02', ''),
(38, 203, '2024-04-04', 15, '', '', 1, 1, 1, '2024-04-04 15:30:34', 'tchoat@cis-hot.org');

-- --------------------------------------------------------

--
-- Table structure for table `staff_login`
--

CREATE TABLE `staff_login` (
  `staff_Login_ID` int(255) NOT NULL,
  `staff_email` varchar(255) NOT NULL,
  `staff_password` varchar(255) NOT NULL,
  `user_role` int(5) DEFAULT NULL,
  `staff_ID` int(255) DEFAULT NULL,
  `on_off` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_login`
--

INSERT INTO `staff_login` (`staff_Login_ID`, `staff_email`, `staff_password`, `user_role`, `staff_ID`, `on_off`) VALUES
(1, 'tchoat@cis-hot.org', '$2y$10$lTAlg8.QTsYze462XER2KOKIeSD69R8pUj8.D68fHAomTHM/k8DAy', 1, 1, 1),
(2, 'manager@cis-hot.org', '$2y$10$GF04RW3LegPWMajeM2FXZuHBvM690kTX5.g5JlFi3O/ruiZdqEVwW', 2, 2, 1),
(3, 'maaron@cis-hot.org', '$2y$10$08n2776Yx15aFmulsOpH/uWcrUrQIqwF3C/r.Nv372CE4ZthxD6QG', 1, 3, 1),
(4, 'aholt@cis-hot.org', '$2y$10$GF04RW3LegPWMajeM2FXZuHBvM690kTX5.g5JlFi3O/ruiZdqEVwW', 1, 4, 1),
(6, 'kaley.eggers@cis-hot.org', '$2y$10$PhHtlzmU1T6uvyIAfz5eHu6PFzLlIK1ZCytFAd4S.rflGRdtVZUqu', 1, 22, 1),
(28, 'test123@gmail.com', '$2y$10$QryJaeXt8YNIvhT6aqXak.yhUc8H2oMeqw...AtqeAEQJshLlbkFm', 2, 44, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff_name`
--

CREATE TABLE `staff_name` (
  `staff_ID` int(11) NOT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `email_address` text DEFAULT NULL,
  `phone_number` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `street` text DEFAULT NULL,
  `state_address` text DEFAULT NULL,
  `zip` int(6) DEFAULT NULL,
  `county` text DEFAULT NULL,
  `city` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_name`
--

INSERT INTO `staff_name` (`staff_ID`, `first_name`, `last_name`, `email_address`, `phone_number`, `date_of_birth`, `street`, `state_address`, `zip`, `county`, `city`) VALUES
(1, 'Tristian', 'Choat', 'tchoat@cis-hot.org', '2365198478', '2000-01-05', '1001 Washington Ave', 'Texas', 76707, 'McLennan', 'Waco'),
(2, 'Manager', 'CIS', 'manager@cis-hot.org', '2547536002', '0000-00-00', '1001 Washington Avenue', 'Texas', 76701, 'McLennan', 'Waco'),
(3, 'Maggie', 'Aaron', 'maaron@cis-hot.org', '1234567899', '2024-05-01', '', '', 0, '', ''),
(4, 'Toni', 'Holt', 'aholt@cis-hot.org', '1234567898', '2024-05-01', '', '', 0, '', ''),
(22, 'Kaley', 'Eggers', 'kaley.eggers@cis-hot.org', '1234567899', '2024-05-01', '', '', 0, '', ''),
(44, 'Caden', 'Choat', 'test123@gmail.com', '1234567899', '2024-05-22', '324 Mac Street', 'McGregor', 0, '76704', 'McLennan');

-- --------------------------------------------------------

--
-- Table structure for table `tier_level_type`
--

CREATE TABLE `tier_level_type` (
  `tierID` int(11) NOT NULL,
  `tier_level` varchar(256) NOT NULL,
  `on_off` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tier_level_type`
--

INSERT INTO `tier_level_type` (`tierID`, `tier_level`, `on_off`) VALUES
(1, 'Tier 3', 1),
(2, 'Tier 2', 1),
(3, 'Tier 1', 1),
(4, 'Indirect Test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_login`
--

CREATE TABLE `volunteer_login` (
  `loginID` int(11) NOT NULL,
  `volunteer_email` varchar(320) NOT NULL,
  `volunteer_password` varchar(125) NOT NULL,
  `user_role` int(11) NOT NULL,
  `volunteerID` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_login`
--

INSERT INTO `volunteer_login` (`loginID`, `volunteer_email`, `volunteer_password`, `user_role`, `volunteerID`) VALUES
(10, 'Baylor@Buddies', '$2y$10$AQ/gUj10RIR8yteKJdxzcuGw4VyA/g0T5FGQIaCVrdW8BlGMTt0Nu', 4, 219),
(11, 'dsitman@gmail.com', '$2y$10$w/snt52yiy0tn29d64IZiuh9tomhVOF883XIq3mCCO5dj2n1FlTqK', 3, 203),
(22, 'antoniamholt@gmail.com', '$2y$10$GF04RW3LegPWMajeM2FXZuHBvM690kTX5.g5JlFi3O/ruiZdqEVwW', 3, 206);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_name`
--

CREATE TABLE `volunteer_name` (
  `volunteerID` int(11) NOT NULL,
  `volunteer_first_name` varchar(30) NOT NULL,
  `volunteer_last_name` varchar(30) NOT NULL,
  `volunteer_email` varchar(320) NOT NULL,
  `volunteer_phone` varchar(14) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state_address` varchar(100) DEFAULT NULL,
  `zip` varchar(100) DEFAULT NULL,
  `county` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_name`
--

INSERT INTO `volunteer_name` (`volunteerID`, `volunteer_first_name`, `volunteer_last_name`, `volunteer_email`, `volunteer_phone`, `birth_date`, `street`, `city`, `state_address`, `zip`, `county`) VALUES
(203, 'Tristian', 'Choat', 'dsitman@gmail.com', '2544054692', '2000-01-05', '324 Mac Street', 'Waco', 'Texas', '76700', 'McLennan'),
(216, 'Toni', 'sanchez', 'antoniamholt@gmail.com', '2544984086', '2024-04-05', '', '', '', '', ''),
(219, 'Baylor', 'Buddies', 'BaylorBuddies@Baylor.edu', '2540000000', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_type`
--

CREATE TABLE `volunteer_type` (
  `volunteer_typeID` int(11) NOT NULL,
  `volunteer_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_type`
--

INSERT INTO `volunteer_type` (`volunteer_typeID`, `volunteer_type`) VALUES
(1, 'Mentor'),
(2, 'Tutor'),
(3, 'Work Study'),
(4, 'Baylor Buddies');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_type_history`
--

CREATE TABLE `volunteer_type_history` (
  `volunteer_type_historyID` int(11) NOT NULL,
  `volunteerID` int(11) NOT NULL,
  `volunteer_typeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_type_history`
--

INSERT INTO `volunteer_type_history` (`volunteer_type_historyID`, `volunteerID`, `volunteer_typeID`) VALUES
(164, 203, 4),
(177, 216, 1);

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_year`
--

CREATE TABLE `volunteer_year` (
  `yearID` int(11) NOT NULL,
  `volunteerYear` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_year`
--

INSERT INTO `volunteer_year` (`yearID`, `volunteerYear`) VALUES
(5, '2023'),
(6, '2024');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_year_queue`
--

CREATE TABLE `volunteer_year_queue` (
  `volunteer_yearID` int(11) NOT NULL,
  `yearID` int(11) NOT NULL,
  `volunteerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_year_queue`
--

INSERT INTO `volunteer_year_queue` (`volunteer_yearID`, `yearID`, `volunteerID`) VALUES
(145, 6, 203),
(150, 6, 216);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deleted_schools`
--
ALTER TABLE `deleted_schools`
  ADD PRIMARY KEY (`deleted_school_id`);

--
-- Indexes for table `deleted_servicecode`
--
ALTER TABLE `deleted_servicecode`
  ADD PRIMARY KEY (`deleted_service_codeID`);

--
-- Indexes for table `deleted_services`
--
ALTER TABLE `deleted_services`
  ADD PRIMARY KEY (`deleted_service_id`);

--
-- Indexes for table `deleted_staff`
--
ALTER TABLE `deleted_staff`
  ADD PRIMARY KEY (`deleted_staff_id`);

--
-- Indexes for table `deleted_tiers`
--
ALTER TABLE `deleted_tiers`
  ADD PRIMARY KEY (`deleted_tierID`);

--
-- Indexes for table `delete_reason_table`
--
ALTER TABLE `delete_reason_table`
  ADD PRIMARY KEY (`delete_reasonID`);

--
-- Indexes for table `delete_staff_reason`
--
ALTER TABLE `delete_staff_reason`
  ADD PRIMARY KEY (`delete_staff_reasonID`);

--
-- Indexes for table `exit_list`
--
ALTER TABLE `exit_list`
  ADD PRIMARY KEY (`exit_id`),
  ADD KEY `volunteerID` (`volunteerID`),
  ADD KEY `exit_reason` (`exit_reason`);

--
-- Indexes for table `reason_table`
--
ALTER TABLE `reason_table`
  ADD PRIMARY KEY (`reasonID`);

--
-- Indexes for table `role_list`
--
ALTER TABLE `role_list`
  ADD PRIMARY KEY (`user_role`);

--
-- Indexes for table `school_list`
--
ALTER TABLE `school_list`
  ADD PRIMARY KEY (`schoolID`);

--
-- Indexes for table `school_queue`
--
ALTER TABLE `school_queue`
  ADD PRIMARY KEY (`school_selectID`),
  ADD KEY `volunteerID` (`volunteerID`),
  ADD KEY `schoolID` (`schoolID`);

--
-- Indexes for table `school_status_mode`
--
ALTER TABLE `school_status_mode`
  ADD PRIMARY KEY (`modeID`);

--
-- Indexes for table `school_status_queue`
--
ALTER TABLE `school_status_queue`
  ADD PRIMARY KEY (`historyID`),
  ADD KEY `schoolID` (`schoolID`),
  ADD KEY `modeID` (`modeID`);

--
-- Indexes for table `service_code`
--
ALTER TABLE `service_code`
  ADD PRIMARY KEY (`service_codeID`);

--
-- Indexes for table `service_entry`
--
ALTER TABLE `service_entry`
  ADD PRIMARY KEY (`serviceID`),
  ADD KEY `tierID` (`tierID`),
  ADD KEY `service_codeID` (`service_codeID`);

--
-- Indexes for table `staff_login`
--
ALTER TABLE `staff_login`
  ADD PRIMARY KEY (`staff_Login_ID`),
  ADD UNIQUE KEY `staff_email` (`staff_email`) USING BTREE;

--
-- Indexes for table `staff_name`
--
ALTER TABLE `staff_name`
  ADD PRIMARY KEY (`staff_ID`);

--
-- Indexes for table `tier_level_type`
--
ALTER TABLE `tier_level_type`
  ADD PRIMARY KEY (`tierID`);

--
-- Indexes for table `volunteer_login`
--
ALTER TABLE `volunteer_login`
  ADD PRIMARY KEY (`loginID`),
  ADD UNIQUE KEY `volunteer_email` (`volunteer_email`),
  ADD KEY `user_role` (`user_role`);

--
-- Indexes for table `volunteer_name`
--
ALTER TABLE `volunteer_name`
  ADD PRIMARY KEY (`volunteerID`);

--
-- Indexes for table `volunteer_type`
--
ALTER TABLE `volunteer_type`
  ADD PRIMARY KEY (`volunteer_typeID`);

--
-- Indexes for table `volunteer_type_history`
--
ALTER TABLE `volunteer_type_history`
  ADD PRIMARY KEY (`volunteer_type_historyID`),
  ADD KEY `volunteerID` (`volunteerID`),
  ADD KEY `volunteer_typeID` (`volunteer_typeID`);

--
-- Indexes for table `volunteer_year`
--
ALTER TABLE `volunteer_year`
  ADD PRIMARY KEY (`yearID`);

--
-- Indexes for table `volunteer_year_queue`
--
ALTER TABLE `volunteer_year_queue`
  ADD PRIMARY KEY (`volunteer_yearID`),
  ADD KEY `yearID` (`yearID`),
  ADD KEY `volunteerID` (`volunteerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deleted_schools`
--
ALTER TABLE `deleted_schools`
  MODIFY `deleted_school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `deleted_servicecode`
--
ALTER TABLE `deleted_servicecode`
  MODIFY `deleted_service_codeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deleted_services`
--
ALTER TABLE `deleted_services`
  MODIFY `deleted_service_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `deleted_staff`
--
ALTER TABLE `deleted_staff`
  MODIFY `deleted_staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `deleted_tiers`
--
ALTER TABLE `deleted_tiers`
  MODIFY `deleted_tierID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delete_reason_table`
--
ALTER TABLE `delete_reason_table`
  MODIFY `delete_reasonID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delete_staff_reason`
--
ALTER TABLE `delete_staff_reason`
  MODIFY `delete_staff_reasonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exit_list`
--
ALTER TABLE `exit_list`
  MODIFY `exit_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `reason_table`
--
ALTER TABLE `reason_table`
  MODIFY `reasonID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_list`
--
ALTER TABLE `school_list`
  MODIFY `schoolID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `school_queue`
--
ALTER TABLE `school_queue`
  MODIFY `school_selectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;

--
-- AUTO_INCREMENT for table `school_status_mode`
--
ALTER TABLE `school_status_mode`
  MODIFY `modeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `school_status_queue`
--
ALTER TABLE `school_status_queue`
  MODIFY `historyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_code`
--
ALTER TABLE `service_code`
  MODIFY `service_codeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `service_entry`
--
ALTER TABLE `service_entry`
  MODIFY `serviceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `staff_login`
--
ALTER TABLE `staff_login`
  MODIFY `staff_Login_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `staff_name`
--
ALTER TABLE `staff_name`
  MODIFY `staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tier_level_type`
--
ALTER TABLE `tier_level_type`
  MODIFY `tierID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `volunteer_login`
--
ALTER TABLE `volunteer_login`
  MODIFY `loginID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `volunteer_name`
--
ALTER TABLE `volunteer_name`
  MODIFY `volunteerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `volunteer_type`
--
ALTER TABLE `volunteer_type`
  MODIFY `volunteer_typeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `volunteer_type_history`
--
ALTER TABLE `volunteer_type_history`
  MODIFY `volunteer_type_historyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `volunteer_year`
--
ALTER TABLE `volunteer_year`
  MODIFY `yearID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `volunteer_year_queue`
--
ALTER TABLE `volunteer_year_queue`
  MODIFY `volunteer_yearID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
