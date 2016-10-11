-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2016 at 07:10 AM
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
-- Table structure for table `default_products_products`
--

CREATE TABLE `default_products_products` (
  `id` int(9) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `ordering_count` int(11) DEFAULT NULL,
  `p_id` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_image` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_price` int(11) DEFAULT NULL,
  `p_highlight` int(11) DEFAULT NULL,
  `p_discount` int(11) DEFAULT NULL,
  `p_unit` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p_short_description` longtext COLLATE utf8_unicode_ci,
  `p_long_description` longtext COLLATE utf8_unicode_ci,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `default_products_products`
--

INSERT INTO `default_products_products` (`id`, `created`, `updated`, `created_by`, `ordering_count`, `p_id`, `p_name`, `p_image`, `p_price`, `p_highlight`, `p_discount`, `p_unit`, `p_short_description`, `p_long_description`, `category_id`) VALUES
(1, '2016-10-07 06:46:53', '2016-10-11 06:16:57', 1, 1, 'CFE0001', 'Coffee Egg', 'd0d8923ca0f7198', 45000, NULL, 10, 'Cốc', 'Good coffee egg', NULL, 1),
(2, '2016-10-07 09:11:52', NULL, 1, 2, 'FJA0001', 'Avocado Smoothie', '4fd58c3aba9d466', 30000, 1, NULL, 'Cốc', 'Good avocado smoothie', NULL, 2),
(3, '2016-10-07 09:44:29', '2016-10-11 05:28:23', 1, 3, 'FJM0002', 'soursop fruit', '05765875e1c8c8c', 25000, NULL, 15, 'Cốc', 'Good soursop fruit', 'This is long description product has id = 3', 2),
(4, '2016-10-11 06:26:04', NULL, 1, 4, 'CFB0001', 'Black coffee', '59d73e4ed410ca8', 15000, NULL, 10, 'Cốc', 'Good black coffee', 'Good black coffee', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `default_products_products`
--
ALTER TABLE `default_products_products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `default_products_products`
--
ALTER TABLE `default_products_products`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
