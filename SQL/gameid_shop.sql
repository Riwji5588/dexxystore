-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3ss307
-- Generation Time: 25 ก.พ. 2021 เมื่อ 07:58 AM
-- เวอร์ชันของเซิร์ฟเวอร์: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gameid_shop`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `accounts`
--

CREATE TABLE `accounts` (
  `ac_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(512) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `points` float NOT NULL DEFAULT 0,
  `sid` varchar(256) NOT NULL,
  `role` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- dump ตาราง `accounts`
--

INSERT INTO `accounts` (`ac_id`, `username`, `password`, `salt`, `email`, `points`, `sid`, `role`) VALUES
(33, 'hyperstudio', '5ad01ccb4a05e40ce62da75e407b23d9', 'f36038f0566c67c9', 'hyperstudio@hyper.page', 0, 'NjkxMzViNzg1YTRlMTEzMjE4aHlwZXJzdHVkaW8=', 779);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `card_image`
--

CREATE TABLE `card_image` (
  `image_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `image_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `data_selled`
--

CREATE TABLE `data_selled` (
  `selled_id` int(11) NOT NULL,
  `data_id` int(11) NOT NULL,
  `ac_id` int(11) NOT NULL,
  `selled_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `game_card`
--

CREATE TABLE `game_card` (
  `card_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `card_title` text NOT NULL,
  `card_price` double NOT NULL,
  `card_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `game_data`
--

CREATE TABLE `game_data` (
  `data_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `detail` text NOT NULL,
  `selled` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `game_type`
--

CREATE TABLE `game_type` (
  `game_id` int(11) NOT NULL,
  `game_name` text NOT NULL,
  `game_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `history_pay`
--

CREATE TABLE `history_pay` (
  `pay_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `link` text NOT NULL,
  `amount` float NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- dump ตาราง `history_pay`
--

INSERT INTO `history_pay` (`pay_id`, `username`, `link`, `amount`, `date`) VALUES
(3, 'hyperstudio', 'y7gMecjIKprVJemngf', 10, '2021-02-25 11:55:01');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `image_slide`
--

CREATE TABLE `image_slide` (
  `slide_id` int(11) NOT NULL,
  `image_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- dump ตาราง `image_slide`
--

INSERT INTO `image_slide` (`slide_id`, `image_name`) VALUES
(1, 'bannerani.png');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `web_config`
--

CREATE TABLE `web_config` (
  `con_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `facebook` text NOT NULL,
  `detail` text NOT NULL,
  `image` text NOT NULL,
  `opened` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- dump ตาราง `web_config`
--

INSERT INTO `web_config` (`con_id`, `name`, `facebook`, `detail`, `image`, `opened`) VALUES
(1, 'hyperstudio', 'pagehyperstudio', 'Hello hyperstudio!', '682f025c739fef2c81303b618f811df7_logo.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`ac_id`);

--
-- Indexes for table `card_image`
--
ALTER TABLE `card_image`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `data_selled`
--
ALTER TABLE `data_selled`
  ADD PRIMARY KEY (`selled_id`);

--
-- Indexes for table `game_card`
--
ALTER TABLE `game_card`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `game_data`
--
ALTER TABLE `game_data`
  ADD PRIMARY KEY (`data_id`);

--
-- Indexes for table `game_type`
--
ALTER TABLE `game_type`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `history_pay`
--
ALTER TABLE `history_pay`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `image_slide`
--
ALTER TABLE `image_slide`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `web_config`
--
ALTER TABLE `web_config`
  ADD PRIMARY KEY (`con_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `card_image`
--
ALTER TABLE `card_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `data_selled`
--
ALTER TABLE `data_selled`
  MODIFY `selled_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `game_card`
--
ALTER TABLE `game_card`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `game_data`
--
ALTER TABLE `game_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `game_type`
--
ALTER TABLE `game_type`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `history_pay`
--
ALTER TABLE `history_pay`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `image_slide`
--
ALTER TABLE `image_slide`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `web_config`
--
ALTER TABLE `web_config`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
