-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 20, 2026 at 02:58 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `chats`
--

CREATE TABLE `chats` (
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `created_by`, `created_at`) VALUES
(1, 1, '2026-01-19 20:27:05'),
(2, 1, '2026-01-19 20:27:07'),
(3, 1, '2026-01-19 23:14:34'),
(4, 1, '2026-01-19 23:40:45'),
(5, 1, '2026-01-19 23:40:46'),
(6, 10, '2026-01-19 23:54:37');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `chat_members`
--

CREATE TABLE `chat_members` (
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_members`
--

INSERT INTO `chat_members` (`chat_id`, `user_id`, `joined_at`) VALUES
(1, 1, '2026-01-19 20:27:05'),
(1, 3, '2026-01-19 20:27:05'),
(2, 1, '2026-01-19 20:27:07'),
(2, 7, '2026-01-19 20:27:07'),
(4, 1, '2026-01-19 23:40:45'),
(4, 7, '2026-01-19 23:40:45'),
(5, 1, '2026-01-19 23:40:46'),
(5, 7, '2026-01-19 23:40:46'),
(6, 1, '2026-01-19 23:54:37'),
(6, 10, '2026-01-19 23:54:37');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `chat_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `chat_id`, `user_id`, `content`, `is_deleted`, `created_at`) VALUES
(1, 2, 1, 'coś', 0, '2026-01-19 20:27:10'),
(2, 2, 1, 'hhju', 0, '2026-01-19 21:34:21'),
(4, 2, 1, 'NAPISZE', 0, '2026-01-19 21:35:26'),
(5, 2, 1, 'DUZO', 0, '2026-01-19 21:35:29'),
(6, 2, 1, 'FGDG', 0, '2026-01-19 21:35:33'),
(8, 2, 1, 'DGDFG', 0, '2026-01-19 21:35:35'),
(9, 2, 1, 'DFGFDGDFGDFG', 0, '2026-01-19 21:35:37'),
(10, 2, 1, 'FGDFG', 0, '2026-01-19 21:35:38'),
(11, 2, 1, 'FGDFG', 0, '2026-01-19 21:35:38'),
(12, 2, 1, 'FGDG', 0, '2026-01-19 21:35:39'),
(13, 2, 1, 'DGDFG', 0, '2026-01-19 21:35:40'),
(14, 2, 1, 'DGDFG', 0, '2026-01-19 21:35:41'),
(15, 2, 1, 'DGDFG', 0, '2026-01-19 21:35:42'),
(16, 2, 1, 'DFGDFG', 0, '2026-01-19 21:35:42'),
(17, 2, 1, 'FDGDFG', 0, '2026-01-19 21:35:43'),
(18, 2, 1, 'FGDG', 0, '2026-01-19 21:35:45'),
(19, 2, 1, 'DGDFG', 0, '2026-01-19 21:35:46'),
(20, 2, 1, 'DGDFGFD', 0, '2026-01-19 21:35:47'),
(24, 4, 1, 'f', 0, '2026-01-19 23:40:45'),
(25, 5, 1, 'f', 0, '2026-01-19 23:40:46'),
(29, 6, 10, 'dffdfsdfdf', 0, '2026-01-19 23:54:39'),
(30, 6, 1, 'tbtht', 0, '2026-01-19 23:55:06'),
(31, 2, 1, 'dwdw', 0, '2026-01-20 00:01:19'),
(32, 6, 1, 'wdwd', 0, '2026-01-20 00:18:59'),
(33, 6, 1, 'fefe', 0, '2026-01-20 00:20:58'),
(34, 2, 1, 'fewfwe', 0, '2026-01-20 00:36:29'),
(38, 2, 1, 'd', 0, '2026-01-20 01:12:53'),
(39, 2, 1, 'd', 0, '2026-01-20 01:20:37');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password_hash` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `created_at`) VALUES
(1, 'M4nf123d', 'biniak.szymon@o2.pl', '$2y$10$qShnQkA3KbblmoKwsymC1uZ9IQeMUR7IyhFUOxMLsEas19uzEw0.u', '2026-01-19 00:36:36'),
(3, 'M4nf', 'szymon.biniek1@o2.pl', '$2y$10$GceQHCBo4u8ExxgvAbLHQ.SBPNnyja6iJ4nywxzMvjxH0MNYY67fW', '2026-01-19 00:46:19'),
(7, 'Ala', 'ada@o2.pl', '$2y$10$SZCybjlhcyFba8jwrMtey.UJO.GKB.1RRRqIKb2Waf9XmbShZMyPy', '2026-01-19 00:52:01'),
(10, 'ale', 'ale@o2.pl', '$2y$10$xqoHLBB5Za7dwbNqVE4vteNDatJN.q48V7dSyv3ENv75Xpzg7Csda', '2026-01-19 23:54:25');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`),
  ADD KEY `fk_chats_created_by` (`created_by`);

--
-- Indeksy dla tabeli `chat_members`
--
ALTER TABLE `chat_members`
  ADD PRIMARY KEY (`chat_id`,`user_id`),
  ADD KEY `fk_chat_members_user` (`user_id`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `fk_messages_chat` (`chat_id`),
  ADD KEY `fk_messages_user` (`user_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `fk_chats_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `chat_members`
--
ALTER TABLE `chat_members`
  ADD CONSTRAINT `fk_chat_members_chat` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`chat_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_chat_members_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_chat` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`chat_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_messages_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
