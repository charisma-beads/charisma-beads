
DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `menuId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu` varchar(255) NOT NULL,
  PRIMARY KEY (`menuId`),
  UNIQUE KEY `menu` (`menu`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `pageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menuId` int(10) unsigned NOT NULL,
  `label` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `resource` varchar(255) NOT NULL,
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  PRIMARY KEY (`pageId`),
  KEY `menuId` (`menuId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Constraints for table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`menuId`);