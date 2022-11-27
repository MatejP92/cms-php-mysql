-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2022 at 11:15 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `user_id`, `cat_title`) VALUES
(14, 0, 'Category 1'),
(15, 0, 'Category 2');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(3) NOT NULL,
  `comment_post_id` int(3) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(4) NOT NULL,
  `post_category_id` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_user` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` longtext NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(11) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_view_count` int(11) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `user_id`, `post_title`, `post_author`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_view_count`, `likes`) VALUES
(169, 14, 53, 'Test Post 1', '', 'admin', '2022-11-27', '362-600x200.jpg', '<div><font color=\"#000000\">In quis libero velit. Aliquam luctus enim dolor, viverra consequat magna accumsan tempor. Fusce vel turpis velit. Phasellus tellus urna, tincidunt in mollis ut, posuere venenatis turpis. Mauris consequat mauris vel tempor dignissim. Pellentesque malesuada convallis sapien non pellentesque. Sed et molestie lacus. Sed ultrices dapibus suscipit. Morbi vulputate elit sit amet augue finibus semper quis eu est. Suspendisse potenti. Pellentesque sed tellus in ipsum tempor tempus. Sed egestas orci eu lobortis sodales. Duis nibh felis, cursus nec placerat ultricies, commodo sed tortor. Vivamus molestie ex id egestas fringilla. Aenean libero nunc, ullamcorper id ex vel, condimentum accumsan ligula. Cras pellentesque vel mauris et eleifend.</font></div><div><font color=\"#000000\"><br></font></div><div><font color=\"#000000\">Morbi semper, sem nec malesuada auctor, ligula libero gravida turpis, id consectetur ligula dolor eu purus. Morbi volutpat viverra vulputate. Donec consequat iaculis turpis, vel sagittis tortor efficitur in. In aliquet dictum odio, vel feugiat eros mollis in. Maecenas feugiat, tortor ut tempor mattis, diam tortor tempus sem, eu iaculis eros nisl non dolor. Suspendisse vel velit at erat elementum sollicitudin. Morbi a nisl fringilla, ultricies elit sed, sagittis odio. Nam eleifend nisl id dui dignissim consectetur nec ut diam. Curabitur a rhoncus nisl, ac porttitor purus. Fusce consectetur pulvinar ullamcorper. Nulla porttitor aliquam quam, et mollis metus tincidunt a. Proin quis sapien non erat posuere pulvinar at et velit. Quisque sit amet velit tortor.</font></div><div><font color=\"#000000\"><br></font></div><div><font color=\"#000000\">Nunc sit amet justo ut erat fringilla pretium nec et lorem. Curabitur nec interdum est. Maecenas hendrerit porta justo, et finibus mauris condimentum sit amet. Maecenas ac vulputate ante, sed venenatis sapien. Proin lorem metus, mollis id sollicitudin eget, cursus et ligula. Duis semper ullamcorper mauris, ac interdum arcu. Maecenas gravida feugiat lectus, ac dapibus velit tempus at. Curabitur id nisl placerat magna pellentesque tempor eget id dolor. Quisque id tincidunt lectus, a dignissim arcu.</font></div>', 'test', 0, 'published', 22, 0),
(181, 14, 58, 'Test Post 2', '', 'subscriber', '2022-11-27', '400-600x200.jpg', '<p>In quis libero velit. Aliquam luctus enim dolor, viverra consequat magna accumsan tempor. Fusce vel turpis velit. Phasellus tellus urna, tincidunt in mollis ut, posuere venenatis turpis. Mauris consequat mauris vel tempor dignissim. Pellentesque malesuada convallis sapien non pellentesque. Sed et molestie lacus. Sed ultrices dapibus suscipit. Morbi vulputate elit sit amet augue finibus semper quis eu est. Suspendisse potenti. Pellentesque sed tellus in ipsum tempor tempus. Sed egestas orci eu lobortis sodales. Duis nibh felis, cursus nec placerat ultricies, commodo sed tortor. Vivamus molestie ex id egestas fringilla. Aenean libero nunc, ullamcorper id ex vel, condimentum accumsan ligula. Cras pellentesque vel mauris et eleifend.</p><p><br></p><p>Morbi semper, sem nec malesuada auctor, ligula libero gravida turpis, id consectetur ligula dolor eu purus. Morbi volutpat viverra vulputate. Donec consequat iaculis turpis, vel sagittis tortor efficitur in. In aliquet dictum odio, vel feugiat eros mollis in. Maecenas feugiat, tortor ut tempor mattis, diam tortor tempus sem, eu iaculis eros nisl non dolor. Suspendisse vel velit at erat elementum sollicitudin. Morbi a nisl fringilla, ultricies elit sed, sagittis odio. Nam eleifend nisl id dui dignissim consectetur nec ut diam. Curabitur a rhoncus nisl, ac porttitor purus. Fusce consectetur pulvinar ullamcorper. Nulla porttitor aliquam quam, et mollis metus tincidunt a. Proin quis sapien non erat posuere pulvinar at et velit. Quisque sit amet velit tortor.</p><p><br></p><p>Nunc sit amet justo ut erat fringilla pretium nec et lorem. Curabitur nec interdum est. Maecenas hendrerit porta justo, et finibus mauris condimentum sit amet. Maecenas ac vulputate ante, sed venenatis sapien. Proin lorem metus, mollis id sollicitudin eget, cursus et ligula. Duis semper ullamcorper mauris, ac interdum arcu. Maecenas gravida feugiat lectus, ac dapibus velit tempus at. Curabitur id nisl placerat magna pellentesque tempor eget id dolor. Quisque id tincidunt lectus, a dignissim arcu.</p>', 'test', 0, 'draft', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(50) NOT NULL,
  `randSalt` varchar(255) NOT NULL DEFAULT '$2a$10$iusesomecrazystrings22',
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_username`, `user_password`, `user_first_name`, `user_last_name`, `user_email`, `user_image`, `user_role`, `randSalt`, `token`) VALUES
(56, 'admin', '$2y$12$AiYWD229bSIVY8nAXFrjNOclMkdZ3bQ0PdxRkCoSP.5p5gZEJKeKi', '', '', 'admin@gmail.com', '', 'admin', '$2a$10$iusesomecrazystrings22', ''),
(58, 'subscriber', '$2y$12$xzonA73XsQQRtnu9pugVheXSoFgVblpeb.sIyBijoYoCYt9PV27IO', '', '', 'subscriber@gmail.com', '', 'subscriber', '$2a$10$iusesomecrazystrings22', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(24, 'nrorp4irncfgp82v70blksci3e', 1669587349),
(25, '9b37lmqbl45941qkvhvi1g0i57', 1669587349);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment id` (`comment_post_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id connection` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_username` (`user_username`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment id` FOREIGN KEY (`comment_post_id`) REFERENCES `posts` (`post_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
