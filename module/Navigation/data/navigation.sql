
SET FOREIGN_KEY_CHECKS=0;

--
-- Database: `charisma-beads`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `menuId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu` varchar(255) NOT NULL,
  PRIMARY KEY (`menuId`),
  UNIQUE KEY `menu` (`menu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `pageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menuId` int(10) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `resource` varchar(255) NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pageId`),
  KEY `menuId` (`menuId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_3` FOREIGN KEY (`menuId`) REFERENCES `menu` (`menuId`);
  
SET FOREIGN_KEY_CHECKS=1;
