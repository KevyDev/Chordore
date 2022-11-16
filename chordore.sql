-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2020 at 03:38 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chordore`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps`
--

CREATE TABLE `apps` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_id` int(11) NOT NULL,
  `released_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `location` varchar(999) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(999) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(99) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` varchar(9999) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `upload_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `location`, `name`, `type`, `size`, `user_id`, `upload_date`) VALUES
(1, 'KHPFIBV', '8472eb2b95824fd358507f567cd4ad2f.jpeg', 'image/jpeg', '140931', 1, '2020-10-20 19:45:24'),
(2, 'KHPFIBV', '334eb7edeb3328dd717aa0307f18ed0c.jpeg', 'image/jpeg', '153458', 1, '2020-10-20 19:45:24'),
(3, 'KHPFIBV', '6dbc0da6ddbbec8b808b5cefca146970.jpeg', 'image/jpeg', '31181', 1, '2020-10-20 19:52:22'),
(4, 'KHPFIBV', 'cdb02b0fc6cce230965d225af3e5d81c.jpeg', 'image/jpeg', '31181', 1, '2020-10-20 21:01:21'),
(5, 'KHPFIBV', 'b072815ea2d734a696907c04f7cb85f4.jpeg', 'image/jpeg', '31181', 1, '2020-10-20 21:02:21'),
(6, 'KHPFIBV', '27552c4b5c9c6f482c5ac9955fe85c91.jpeg', 'image/jpeg', '41510', 1, '2020-10-21 02:52:18'),
(7, 'KHPFIBV', 'a2ccbe9bf2ece1418905c2000dfde3f0.jpeg', 'image/jpeg', '41510', 1, '2020-10-21 02:53:04'),
(8, 'KHPFIBV', '01264992f1d662163e35ca0762616968.jpeg', 'image/jpeg', '44388', 1, '2020-10-21 02:53:55'),
(9, 'KHPFIBV', '5e5d16366f5e9f8dd7043a7f54bf754d.jpeg', 'image/jpeg', '18920', 1, '2020-10-21 03:02:21'),
(10, 'KHPFIBV', '4946400f16ec6128fe39477a64c7bd3f.jpeg', 'image/jpeg', '35966', 1, '2020-10-21 03:04:20'),
(11, 'KHPFIBV', '7b997ab31cd4dd7dcc8cbb98c19e501c.jpeg', 'image/jpeg', '22234', 1, '2020-10-21 19:19:27'),
(12, 'KHPFIBV', '74fe599e780245d6e8b9cb74775cee8e.jpeg', 'image/jpeg', '10729', 1, '2020-10-21 19:37:58'),
(13, 'KHPFIBV', '0a311360c249478bb4b697691f726c1e.jpeg', 'image/jpeg', '18920', 1, '2020-10-21 19:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `object_id` int(11) NOT NULL,
  `comment` varchar(9999) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `object_id`, `comment`, `datetime`) VALUES
(1, 1, 'set_name', 0, 'Chordore', '2020-10-20 19:43:50'),
(2, 1, 'set_username', 0, 'chordore', '2020-10-20 19:43:50'),
(3, 1, 'set_email', 0, 'private@chordore.com', '2020-10-20 19:43:50'),
(4, 1, 'set_pass', 0, '', '2020-10-20 19:43:50'),
(5, 2, 'set_name', 0, 'kfw qw[j', '2020-10-20 20:29:12'),
(6, 2, 'set_username', 0, 'efv__c', '2020-10-20 20:29:12'),
(7, 2, 'set_email', 0, 'hfjjkevin@oFW.COM', '2020-10-20 20:29:12'),
(8, 2, 'set_pass', 0, '', '2020-10-20 20:29:12'),
(9, 1, 'set_photo', 4, '', '2020-10-20 21:01:21'),
(10, 1, 'set_photo', 5, '', '2020-10-20 21:02:21'),
(11, 1, 'set_photo', 6, '', '2020-10-21 02:52:18'),
(12, 1, 'set_photo', 7, '', '2020-10-21 02:53:04'),
(13, 1, 'set_photo', 8, '', '2020-10-21 02:53:55'),
(14, 1, 'set_photo', 9, '', '2020-10-21 03:02:21'),
(15, 1, 'set_photo', 10, '', '2020-10-21 03:04:20'),
(16, 1, 'set_photo', 11, '', '2020-10-21 19:19:28'),
(17, 1, 'set_photo', 12, '', '2020-10-21 19:37:58'),
(18, 1, 'set_photo', 13, '', '2020-10-21 19:38:19');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversation_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `readed` int(1) NOT NULL,
  `readed_date` datetime NOT NULL,
  `user_deleted` int(1) NOT NULL,
  `other_user_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_requests`
--

CREATE TABLE `password_reset_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publication_date` datetime NOT NULL,
  `images_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `privacy` int(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `token`, `text`, `publication_date`, `images_id`, `privacy`, `user_id`, `deleted`) VALUES
(1, '625c58a5bceb2912c032c5b46eb08945', 'El mejor álbum del 2020. :)', '2020-10-20 19:45:24', '[\"1\",\"2\"]', 1, 1, 0),
(2, 'bc9b49539062c45a9e61d841b3de4a58', 'Hola', '2020-10-20 19:52:22', '[\"3\"]', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts_comments`
--

CREATE TABLE `posts_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `replying_comment_id` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commented_date` datetime NOT NULL,
  `deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts_hashtags`
--

CREATE TABLE `posts_hashtags` (
  `id` int(11) NOT NULL,
  `hashtag` varchar(999) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts_likes`
--

CREATE TABLE `posts_likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `liked_date` datetime NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts_usertags`
--

CREATE TABLE `posts_usertags` (
  `id` int(11) NOT NULL,
  `usertag` varchar(999) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verified` int(1) NOT NULL,
  `joined_date` datetime NOT NULL,
  `last_activity` datetime NOT NULL,
  `ban` int(1) NOT NULL,
  `deleted` int(1) NOT NULL,
  `admin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `password`, `photo_id`, `banner_id`, `token`, `bio`, `location`, `link`, `verified`, `joined_date`, `last_activity`, `ban`, `deleted`, `admin`) VALUES
(1, 'Chordore', 'chordore', 'private@chordore.com', '', '$2y$10$3oCLwhA/pAtMXlEgEYvvnOkIj/Vr4y4/ygxfFnlyfzql1xov/08VG', 13, 0, '7a57a13ecbcfbf247664b7055bec975c', '', '', '', 0, '2020-10-20 19:43:50', '2020-10-21 20:02:33', 0, 0, 0),
(2, 'kfw qw[j', 'efv__c', 'hfjjkevin@oFW.COM', '', '$2y$10$Br8ojjw0LRWy6VXx2GicQuKHYB5.XdLrC7sxlS5pgjlJaA//9XBJ.', 0, 0, '18df7aa237bedce892f8a2096daee4d1', '', '', '', 0, '2020-10-20 20:29:12', '2020-10-20 22:11:25', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_bans`
--

CREATE TABLE `users_bans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `reason` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_conversations`
--

CREATE TABLE `users_conversations` (
  `id` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_1_id` int(11) NOT NULL,
  `user_2_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `user_1_deleted` int(1) NOT NULL,
  `user_2_deleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_follows`
--

CREATE TABLE `users_follows` (
  `id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `follow_date` datetime NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_friends`
--

CREATE TABLE `users_friends` (
  `id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `accepted` int(1) NOT NULL,
  `declined` int(1) NOT NULL,
  `request_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_sessions`
--

CREATE TABLE `users_sessions` (
  `id` int(11) NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_info` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `last_activity` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `active` int(1) NOT NULL,
  `user_ended` int(1) NOT NULL,
  `timeout_ended` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_sessions`
--

INSERT INTO `users_sessions` (`id`, `token`, `user_id`, `device_ip`, `device_info`, `start_date`, `last_activity`, `end_date`, `active`, `user_ended`, `timeout_ended`) VALUES
(1, '0d91358c9c72ee80de37bc7f204b0b4f', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.87 Safari/537.36', '2020-10-20 19:43:50', '2020-10-20 20:27:48', '0000-00-00 00:00:00', 1, 0, 0),
(2, 'e8f5adce789b0d1b85321e32d61676d5', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:65.0) Gecko/20100101 Firefox/65.0', '2020-10-20 19:48:28', '2020-10-21 03:04:26', '0000-00-00 00:00:00', 1, 0, 0),
(3, 'e67e2c0a5169863d0cbce63e01145e10', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.87 Safari/537.36', '2020-10-20 20:29:12', '2020-10-20 22:11:25', '0000-00-00 00:00:00', 1, 0, 0),
(4, 'b4c4675615a928848bec72b4a97dec67', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.87 Mobile Safari/537.36', '2020-10-20 22:12:28', '2020-10-21 04:45:07', '0000-00-00 00:00:00', 1, 0, 0),
(5, '8e3c64a1c6959f32d87bd1908c4bba79', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:65.0) Gecko/20100101 Firefox/65.0', '2020-10-21 19:16:32', '2020-10-21 20:02:33', '0000-00-00 00:00:00', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apps`
--
ALTER TABLE `apps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_comments`
--
ALTER TABLE `posts_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_hashtags`
--
ALTER TABLE `posts_hashtags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_likes`
--
ALTER TABLE `posts_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_usertags`
--
ALTER TABLE `posts_usertags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_bans`
--
ALTER TABLE `users_bans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_conversations`
--
ALTER TABLE `users_conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_follows`
--
ALTER TABLE `users_follows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_friends`
--
ALTER TABLE `users_friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_sessions`
--
ALTER TABLE `users_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apps`
--
ALTER TABLE `apps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts_comments`
--
ALTER TABLE `posts_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_hashtags`
--
ALTER TABLE `posts_hashtags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_likes`
--
ALTER TABLE `posts_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts_usertags`
--
ALTER TABLE `posts_usertags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_bans`
--
ALTER TABLE `users_bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_conversations`
--
ALTER TABLE `users_conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_follows`
--
ALTER TABLE `users_follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_friends`
--
ALTER TABLE `users_friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_sessions`
--
ALTER TABLE `users_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
