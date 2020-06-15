-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2017 at 06:36 AM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.1.9

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `uthando-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `widget`
--

DROP TABLE IF EXISTS `widget`;
CREATE TABLE `widget` (
  `widgetId` int(10) UNSIGNED NOT NULL,
  `widgetGroupId` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `widget` varchar(255) NOT NULL,
  `sortOrder` int(2) UNSIGNED NOT NULL DEFAULT '0',
  `showTitle` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `params` text,
  `html` text,
  `enabled` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

--
-- RELATIONSHIPS FOR TABLE `widget`:
--   `widgetGroupId`
--       `widgetGroup` -> `widgetGroupId`
--

-- --------------------------------------------------------

--
-- Table structure for table `widgetGroup`
--

DROP TABLE IF EXISTS `widgetGroup`;
CREATE TABLE `widgetGroup` (
  `widgetGroupId` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `params` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONSHIPS FOR TABLE `widgetGroup`:
--

--
-- Indexes for table `widget`
--
ALTER TABLE `widget`
  ADD PRIMARY KEY (`widgetId`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE,
  ADD KEY `widgetGroupId` (`widgetGroupId`);

--
-- Indexes for table `widgetGroup`
--
ALTER TABLE `widgetGroup`
  ADD PRIMARY KEY (`widgetGroupId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `widget`
--
ALTER TABLE `widget`
  MODIFY `widgetId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `widgetGroup`
--
ALTER TABLE `widgetGroup`
  MODIFY `widgetGroupId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `widget`
--
ALTER TABLE `widget`
  ADD CONSTRAINT `widget_ibfk_1` FOREIGN KEY (`widgetGroupId`) REFERENCES `widgetGroup` (`widgetGroupId`) ON DELETE SET NULL ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
