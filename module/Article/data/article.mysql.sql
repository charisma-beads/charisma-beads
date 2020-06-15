
SET FOREIGN_KEY_CHECKS=0;
-- --------------------------------------------------------

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `articleId` int(11) UNSIGNED NOT NULL,
  `userId` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text,
  `layout` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `lead` tinytext,
  `pageHits` int(10) UNSIGNED NOT NULL,
  `resource` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`articleId`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `userId` (`userId`);

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `articleId` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`);

SET FOREIGN_KEY_CHECKS=1;

