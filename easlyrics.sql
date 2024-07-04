-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 04, 2024 at 12:38 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easlyrics`
--

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tags` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collections`
--

-- --------------------------------------------------------

--
-- Table structure for table `lyrics`
--

CREATE TABLE `lyrics` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `collection_id` int DEFAULT NULL,
  `title` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `youtube_url` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lyrics`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(256) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `created_at`) VALUES
(2, 'dani', 'e@e.com', 'e1671797c52e15f763380b45e841ec32', 'e65ed7171fc81e2ace8bc4d2aa52b374', '2024-07-04 11:27:46'),

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lyrics`
--
ALTER TABLE `lyrics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lyrics`
--
ALTER TABLE `lyrics`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
