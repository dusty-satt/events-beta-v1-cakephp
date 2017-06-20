-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 20, 2017 at 10:40 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `events_app`
--
CREATE DATABASE IF NOT EXISTS `events_app` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `events_app`;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_group_id` int(11) DEFAULT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL,
  `date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `preferred_start_time` time DEFAULT NULL,
  `guest_quota` smallint(3) NOT NULL DEFAULT '0'COMMENT
) ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `event_group_id`, `name`, `date`, `start_time`, `preferred_start_time`, `guest_quota`, `guest_limit`, `created`, `modified`) VALUES
(1, 1, 'BoardGames @ Dusty\'s', '2017-05-29', NULL, '18:30:00', 4, 6, '2017-05-29 06:01:38', '2017-05-29 06:01:38'),
(2, 1, 'BoardGames @ Dusty\'s', '2017-05-30', NULL, '18:30:00', 4, 6, '2017-05-29 06:01:38', '2017-05-29 06:01:38'),
(3, 1, 'BoardGames @ Dusty\'s', '2017-05-31', NULL, '18:30:00', 4, 6, '2017-05-29 06:01:38', '2017-05-29 06:01:38'),
(4, 1, 'BoardGames @ Dusty\'s', '2017-06-01', NULL, '18:30:00', 4, 6, '2017-05-29 06:01:38', '2017-05-29 06:01:38'),
(5, 1, 'BoardGames @ Dusty\'s', '2017-06-02', NULL, '18:30:00', 4, 6, '2017-05-29 06:01:38', '2017-05-29 06:01:38'),
(6, 1, 'BoardGames @ Dusty\'s', '2017-06-03', NULL, '18:30:00', 4, 6, '2017-05-29 06:01:38', '2017-05-29 06:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `event_groups`
--

DROP TABLE IF EXISTS `event_groups`;
CREATE TABLE `event_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `event_groups`
--

INSERT INTO `event_groups` (`id`, `name`) VALUES
(1, 'BoardGames @ Dusty\'s');

-- --------------------------------------------------------

--
-- Table structure for table `event_guests`
--

DROP TABLE IF EXISTS `event_guests`;
CREATE TABLE `event_guests` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `preferred_start_time` time DEFAULT NULL,
  `preferred_day` smallint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `event_invitees`
--

DROP TABLE IF EXISTS `event_invitees`;
CREATE TABLE `event_invitees` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email_address` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `facebook_id` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `first_name` varchar(85) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(85) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `role` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `facebook_id`, `username`, `first_name`, `last_name`, `password`, `role`, `created`, `modified`) VALUES
(1, '1200303670078778', 'dusty.satt@gmail.com', NULL, NULL, '$2y$10$5n1ib6POPZY/7AdIdF/Yaua2gEUIdMh8JrEjvck4b0gydFVFIGTRu', 'admin', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_groups`
--
ALTER TABLE `event_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_guests`
--
ALTER TABLE `event_guests`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_invitees`
--
ALTER TABLE `event_invitees`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facebook_id` (`facebook_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_groups`
--
ALTER TABLE `event_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
