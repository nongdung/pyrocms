-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2016 at 07:11 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pyrocms`
--

-- --------------------------------------------------------

--
-- Table structure for table `default_products_categories`
--

CREATE TABLE `default_products_categories` (
  `id` int(9) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `ordering_count` int(11) DEFAULT NULL,
  `c_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `c_description` longtext COLLATE utf8_unicode_ci,
  `c_image` char(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `default_products_categories`
--

INSERT INTO `default_products_categories` (`id`, `created`, `updated`, `created_by`, `ordering_count`, `c_name`, `c_description`, `c_image`) VALUES
(1, '2016-10-07 06:44:18', NULL, 1, 1, 'Coffee', 'Good coffee', 'ee0b192fa48f6c0'),
(2, '2016-10-07 06:46:07', NULL, 1, 2, 'Fruit juice', 'Good fruit juice', '08c6c92e2aae4ed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `default_products_categories`
--
ALTER TABLE `default_products_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `default_products_categories`
--
ALTER TABLE `default_products_categories`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
