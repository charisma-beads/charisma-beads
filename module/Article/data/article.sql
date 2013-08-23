
DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `articleId` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `keywords` text CHARACTER SET utf32 NOT NULL,
  `pageHits` int(10) unsigned NOT NULL,
  `dateCreated` datetime NOT NULL,
  `dateModified` datetime NOT NULL,
  PRIMARY KEY (`articleId`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;