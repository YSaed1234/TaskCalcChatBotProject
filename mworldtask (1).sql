-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2021 at 07:37 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mworldtask`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `operators`
--

CREATE TABLE `operators` (
  `id` int(11) NOT NULL,
  `key` varchar(50) DEFAULT NULL,
  `value` varchar(5) DEFAULT NULL,
  `function` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `operators`
--

INSERT INTO `operators` (`id`, `key`, `value`, `function`) VALUES
(5, 'add', '+', 'array_sum'),
(7, 'and', '+', 'array_sum'),
(8, '+', '+', 'array_sum'),
(9, 'minus', '-', ''),
(10, '-', '-', ''),
(11, 'multiplying', '*', ''),
(12, '*', '*', ''),
(13, 'dividing', '/', ''),
(14, '/', '/', ''),
(15, 'square', NULL, 'sqrt');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remember_token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'yasmin', 'saedyasmin0@gmail.com', '$2y$10$fwDghNO1xFfNlkW3yxWOYuv4FD/nQuNBt556lVPDj89xMmEi5ApVS', '2021-03-18 14:24:42', '2021-03-18 14:24:42', 'VoHYlEG1pkFfv8j6wnzgteo4C1YGla7C952NdepObmNhFSmfrHm0IdsiL3Bg');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tag` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `user_id`, `action`, `message`, `created_at`, `updated_at`, `tag`) VALUES
(464, 1, 'send', 'add 1 to 9', '2021-03-19 18:35:44', '2021-03-19 18:35:44', NULL),
(465, 1, 'Recive', 'You Mean :1+9', '2021-03-19 18:35:44', '2021-03-19 18:35:44', NULL),
(466, 1, 'Recive', 'ABRACADABRA! it’s 10', '2021-03-19 18:35:44', '2021-03-19 18:35:44', NULL),
(467, 1, 'feedback', ' please send 1 if you think my answer is correct, 2 if it’s wrong, or 3 if you don’t know. ', '2021-03-19 18:35:44', '2021-03-19 18:35:44', NULL),
(468, 1, 'send', 'sadsad', '2021-03-19 18:35:57', '2021-03-19 18:35:57', 'feedback'),
(469, 1, 'Recive', 'Your Data Not Accurat please type at least two numbers to be calculated ..! ', '2021-03-19 18:35:57', '2021-03-19 18:35:57', NULL),
(470, 1, 'feedback', ' please send 1 if you think my answer is correct, 2 if it’s wrong, or 3 if you don’t know. ', '2021-03-19 18:35:57', '2021-03-19 18:35:57', NULL),
(471, 1, 'send', '2', '2021-03-19 18:36:02', '2021-03-19 18:36:02', 'feedback'),
(472, 1, 'Recive', 'Please Enter it With another Syntax to Try Again . ..... (Test ) ', '2021-03-19 18:36:02', '2021-03-19 18:36:02', NULL),
(473, 1, 'finish', ' If you need a new process send 1 or 2 to end this session.', '2021-03-19 18:36:02', '2021-03-19 18:36:02', NULL),
(474, 1, 'send', 'dasdsad', '2021-03-19 18:36:06', '2021-03-19 18:36:06', 'finish'),
(475, 1, 'Recive', 'Your Data Not Accurat please type at least two numbers to be calculated ..! ', '2021-03-19 18:36:07', '2021-03-19 18:36:07', NULL),
(476, 1, 'finish', ' If you need a new process send 1 or 2 to end this session.', '2021-03-19 18:36:07', '2021-03-19 18:36:07', NULL),
(477, 1, 'send', '2', '2021-03-19 18:36:12', '2021-03-19 18:36:12', 'finish'),
(478, 1, 'Recive', 'Good-Bye! Have a nice day.', '2021-03-19 18:36:12', '2021-03-19 18:36:12', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operators`
--
ALTER TABLE `operators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operators`
--
ALTER TABLE `operators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=479;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
