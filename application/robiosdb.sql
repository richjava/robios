-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2015 at 07:09 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `robiosdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE IF NOT EXISTS `auth_tokens` (
`id` int(11) NOT NULL,
  `token` varchar(500) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `business_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE IF NOT EXISTS `businesses` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`id`, `name`) VALUES
(1, 'My Business');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
`id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` varchar(500) NOT NULL,
  `conditions` varchar(500) DEFAULT NULL,
  `expiry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE IF NOT EXISTS `deals` (
`id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` varchar(500) NOT NULL,
  `conditions` varchar(500) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expiry_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`id`, `title`, `content`, `conditions`, `date_created`, `expiry_date`, `user_id`) VALUES
(1, 'wert', 'wert', '0', '2015-03-23 01:32:40', '2017-05-05 12:00:00', 1),
(2, 'rtuy', 'rty', '0', '2015-03-23 01:33:12', '1970-08-12 12:00:00', 1),
(3, 'sdfhdg', 'ddfghdfgh', '0', '2015-03-24 02:13:21', '2015-03-30 11:00:00', 1),
(4, '4455', '44565', '0', '2015-03-24 02:13:51', '2015-03-30 11:00:00', 1),
(5, 'sdfg', 'werwert', '0', '2015-03-24 22:24:15', '2015-04-07 12:00:00', 1),
(6, '77777', '7777', '0', '2015-03-24 22:26:19', '2015-03-31 11:00:00', 1),
(7, '88', '88', '0', '2015-03-24 22:28:28', '2015-03-31 11:00:00', 1),
(8, '88', '88', '0', '2015-03-24 22:29:11', '2015-03-31 11:00:00', 1),
(9, '99', '99', '0', '2015-03-24 22:31:24', '2015-03-31 11:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news_items`
--

CREATE TABLE IF NOT EXISTS `news_items` (
`id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `news_items`
--

INSERT INTO `news_items` (`id`, `title`, `content`, `user_id`, `date_created`) VALUES
(2, 'sdfgsdfg', 'sdfgsdfg gfhdfgh', 1, '2015-03-23 02:20:22'),
(3, 'sdfgsdfg', 'sdfgsdfg gfhdfgh!', 1, '2015-03-23 02:21:49'),
(4, 'dfghdf dfgh dfgh dfgh dfgh dfghdf dfgh dfgh fdghdfgh fdgh.', 'dfghdf dfgh dfgh dfgh dfgh dfghdf dfgh dfgh fdghdfgh fdgh. dfghdf dfgh dfgh dfgh dfgh dfghdf dfgh dfgh fdghdfgh fdgh. dfghdf dfgh dfgh dfgh dfgh dfghdf dfgh dfgh fdghdfgh fdgh. dfghdf dfgh dfgh dfgh dfgh dfghdf dfgh dfgh fdghdfgh fdgh.', 1, '2015-03-23 22:24:03'),
(5, 'ert', 'erttrre', 1, '2015-03-25 02:07:46'),
(6, 'sdf tyityi', 'tyityuityui', 1, '2015-03-25 02:08:01'),
(7, 'iouiuui', 'uioupio', 1, '2015-03-25 02:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `business_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `business_id`) VALUES
(4, 'a', 'a', 'rjlovell@hotmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'pending', 0),
(5, 'aaa', 'aaa', 'Richard.Lovell@ecgedu.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'pending', 0),
(6, 'aaaaaa', 'aaaaa', 'aaaaa@aaaaaa.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'pending', 0),
(7, 'bbbbb', 'bbbbb', 'bbbb@vvv.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'pending', 0),
(8, 'asdfasdf', 'asdfsadf', 'sdagadsfg@asf.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'pending', 0),
(9, 'Richard', 'Lovell', 'Richard.Lovell@ecgedu.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'pending', 0),
(10, 'Richard', 'Lovell', 'asdasd@sdfsdf.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 1),
(11, 'Richard', 'Lovell', 'asd2sd@sdfsdf.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 2),
(12, 'Richard', 'Lovell', 'asd24sd@sdfsdf.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 3),
(13, 'derfg', 'wert', 'wregtwer@qwert.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 4),
(14, 'qwer', 'tyu', 'sdrfg@sdthst.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 5),
(15, 'hyrt', 'rtrt', 'sdfgsdf@sag.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 6),
(16, 'tyerty', 'ertyerty', 'ertytr@dsfg.com', '81dc9bdb52d04dc20036dbd8313ed055', 'editor', 1),
(17, 'yui', 'tyui', 'uky@dsfg.com', '81dc9bdb52d04dc20036dbd8313ed055', 'editor', 1),
(18, 'ewrtwert', 'wertwert', 'uyrtrtu@sgfrg.com', '81dc9bdb52d04dc20036dbd8313ed055', 'editor', 1),
(19, 'ewrtwert', 'wertwert', 'uyrtrtu@sgffrg.com', '81dc9bdb52d04dc20036dbd8313ed055', 'editor', 1),
(20, 'ewrtwert', 'wertwert', 'uyrtrtu@sgffurg.com', '81dc9bdb52d04dc20036dbd8313ed055', 'editor', 1),
(21, 'ewrtwert', 'wertwert', 'uyrtrtru@sgffurg.com', '81dc9bdb52d04dc20036dbd8313ed055', 'editor', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
 ADD PRIMARY KEY (`id`), ADD KEY `business_name` (`business_name`,`email`), ADD KEY `business_id` (`business_id`);

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
 ADD PRIMARY KEY (`id`), ADD KEY `name` (`name`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
 ADD PRIMARY KEY (`id`), ADD KEY `expiry_date` (`expiry_date`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `deals`
--
ALTER TABLE `deals`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `date_created` (`date_created`), ADD KEY `expiry_date` (`expiry_date`);

--
-- Indexes for table `news_items`
--
ALTER TABLE `news_items`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `date_created` (`date_created`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD KEY `email` (`email`), ADD KEY `status` (`role`), ADD KEY `business_id` (`business_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `deals`
--
ALTER TABLE `deals`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `news_items`
--
ALTER TABLE `news_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
