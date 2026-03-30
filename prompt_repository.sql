

CREATE DATABASE  IF NOT EXISTS prompt_repository

USE prompt_repository ;
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generated: Wed. 25 March 2026 at 15:59
-- Server version: 10.4.32-MariaDB
-- PHP version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prompt`
--

-- --------------------------------------------------------

--
-- Table structure for `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL UNIQUE,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Code', '2026-03-24 12:33:42'),
(2, 'Marketing', '2026-03-24 12:33:42'),
(4, 'DevOps', '2026-03-24 12:33:42'),
(5, 'PYTHON', '2026-03-24 16:11:36'),
(6, 'java', '2026-03-25 11:55:07');

-- --------------------------------------------------------

--
-- Table structure for `prompts`
--

CREATE TABLE `prompts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prompts`
--

INSERT INTO `prompts` (`id`, `title`, `content`, `user_id`, `category_id`, `created_at`) VALUES
(10, 'fhjklkjhhj', 'dOIasuAHSUHUISDWQUDGUIWQDGQWUDGU', 3, 4, '2026-03-25 13:47:50');

-- --------------------------------------------------------

--
-- Table structure for `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','developer') DEFAULT 'developer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(3, 'RootAdmin', 'admin@devgenius.com', '$2y$10$UnuwGzISXCac2pnWyA4DluKHgK.h8sEZHM5UM1zdChmySON/.V5Um', 'admin', '2026-03-24 15:34:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for dumped tables
--

--
-- AUTO_INCREMENT for dumped tables
--
ALTER TABLE `categories` AUTO_INCREMENT=8;
ALTER TABLE `prompts` AUTO_INCREMENT=12;
ALTER TABLE `users` AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prompts`
--
ALTER TABLE `prompts`
  ADD CONSTRAINT `prompts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prompts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
