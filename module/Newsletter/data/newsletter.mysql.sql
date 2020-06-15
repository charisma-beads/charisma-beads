-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2017 at 03:27 PM
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
-- Table structure for table `newsletter`
--

DROP TABLE IF EXISTS `newsletter`;
CREATE TABLE `newsletter` (
  `newsletterId` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `visible` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`newsletterId`, `name`, `description`, `visible`) VALUES
  (1, 'test', 'Test Newsletter', 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletterMessage`
--

DROP TABLE IF EXISTS `newsletterMessage`;
CREATE TABLE `newsletterMessage` (
  `messageId` int(10) UNSIGNED NOT NULL,
  `templateId` int(10) UNSIGNED NOT NULL,
  `newsletterId` int(10) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` mediumtext NOT NULL,
  `params` text NOT NULL,
  `sent` int(1) UNSIGNED NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateSent` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterSubscriber`
--

DROP TABLE IF EXISTS `newsletterSubscriber`;
CREATE TABLE `newsletterSubscriber` (
  `subscriberId` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterSubscription`
--

DROP TABLE IF EXISTS `newsletterSubscription`;
CREATE TABLE `newsletterSubscription` (
  `subscriptionId` int(10) UNSIGNED NOT NULL,
  `subscriberId` int(10) UNSIGNED NOT NULL,
  `newsletterId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `newsletterTemplate`
--

DROP TABLE IF EXISTS `newsletterTemplate`;
CREATE TABLE `newsletterTemplate` (
  `templateId` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`newsletterId`);

--
-- Indexes for table `newsletterMessage`
--
ALTER TABLE `newsletterMessage`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `newsletterId` (`newsletterId`),
  ADD KEY `templateId` (`templateId`);

--
-- Indexes for table `newsletterSubscriber`
--
ALTER TABLE `newsletterSubscriber`
  ADD PRIMARY KEY (`subscriberId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `newsletterSubscription`
--
ALTER TABLE `newsletterSubscription`
  ADD PRIMARY KEY (`subscriptionId`),
  ADD KEY `subscriberId` (`subscriberId`),
  ADD KEY `newsletterId` (`newsletterId`);

--
-- Indexes for table `newsletterTemplate`
--
ALTER TABLE `newsletterTemplate`
  ADD PRIMARY KEY (`templateId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `newsletterId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `newsletterMessage`
--
ALTER TABLE `newsletterMessage`
  MODIFY `messageId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `newsletterSubscriber`
--
ALTER TABLE `newsletterSubscriber`
  MODIFY `subscriberId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `newsletterSubscription`
--
ALTER TABLE `newsletterSubscription`
  MODIFY `subscriptionId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `newsletterTemplate`
--
ALTER TABLE `newsletterTemplate`
  MODIFY `templateId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `newsletterMessage`
--
ALTER TABLE `newsletterMessage`
  ADD CONSTRAINT `newsletterMessage_ibfk_1` FOREIGN KEY (`newsletterId`) REFERENCES `newsletter` (`newsletterId`),
  ADD CONSTRAINT `newsletterMessage_ibfk_2` FOREIGN KEY (`templateId`) REFERENCES `newsletterTemplate` (`templateId`);

--
-- Constraints for table `newsletterSubscription`
--
ALTER TABLE `newsletterSubscription`
  ADD CONSTRAINT `newsletterSubscription_ibfk_1` FOREIGN KEY (`subscriberId`) REFERENCES `newsletterSubscriber` (`subscriberId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `newsletterSubscription_ibfk_2` FOREIGN KEY (`newsletterId`) REFERENCES `newsletter` (`newsletterId`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;
