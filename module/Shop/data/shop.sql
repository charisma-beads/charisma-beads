
SET FOREIGN_KEY_CHECKS=0;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `productId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productCategoryId` int(10) unsigned NOT NULL,
  `productSizeId` int(10) unsigned NOT NULL,
  `taxCodeId` int(10) unsigned NOT NULL,
  `productPostUnitId` int(10) unsigned NOT NULL,
  `productGroupId` int(10) unsigned DEFAULT NULL,
  `productStockStatusId` int(10) unsigned DEFAULT NULL,
  `ident` varchar(255) NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `description` text NOT NULL,
  `shortDescription` varchar(200) DEFAULT NULL,
  `quantity` int(5) NOT NULL DEFAULT '-1',
  `taxable` int(1) unsigned NOT NULL DEFAULT '0',
  `addPostage` int(1) unsigned NOT NULL DEFAULT '1',
  `discountPercent` int(3) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `discontinued` int(1) unsigned NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`productId`),
  UNIQUE KEY `ident` (`ident`),
  KEY `ProductCategoryId` (`productCategoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productCategory`
--

DROP TABLE IF EXISTS `productCategory`;
CREATE TABLE IF NOT EXISTS `productCategory` (
  `productCategoryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productImageId` int(11) unsigned DEFAULT NULL,
  `ident` varchar(255) NOT NULL,
  `category` varchar(60) DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL DEFAULT '0',
  `rgt` int(10) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `discontinued` int(1) unsigned NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`productCategoryId`),
  UNIQUE KEY `ident` (`ident`),
  KEY `productImageId` (`productImageId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productImage`
--

DROP TABLE IF EXISTS `productImage`;
CREATE TABLE IF NOT EXISTS `productImage` (
  `productImageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(10) unsigned NOT NULL,
  `thumbnail` varchar(200) NOT NULL,
  `full` varchar(200) NOT NULL,
  `default` int(1) unsigned NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`productImageId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productOption`
--

DROP TABLE IF EXISTS `productOption`;
CREATE TABLE IF NOT EXISTS `productOption` (
  `productOptionId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productId` int(10) unsigned NOT NULL,
  `option` varchar(100) NOT NULL,
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`productOptionId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productPostUnit`
--

DROP TABLE IF EXISTS `productPostUnit`;
CREATE TABLE IF NOT EXISTS `productPostUnit` (
  `productPostUnitId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postUnit` decimal(6,2) unsigned NOT NULL,
  PRIMARY KEY (`productPostUnitId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productSize`
--

DROP TABLE IF EXISTS `productSize`;
CREATE TABLE IF NOT EXISTS `productSize` (
  `productSizeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `size` varchar(60) NOT NULL,
  PRIMARY KEY (`productSizeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productStockStatus`
--

DROP TABLE IF EXISTS `productStockStatus`;
CREATE TABLE IF NOT EXISTS `productStockStatus` (
  `productStockStautsId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stockStatus` varchar(50) NOT NULL,
  PRIMARY KEY (`productStockStautsId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `taxCode`
--

DROP TABLE IF EXISTS `taxCode`;
CREATE TABLE IF NOT EXISTS `taxCode` (
  `taxCodeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxRateId` int(10) unsigned NOT NULL,
  `taxCode` varchar(2) NOT NULL,
  `description` varchar(60) NOT NULL,
  PRIMARY KEY (`taxCodeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `taxRate`
--

DROP TABLE IF EXISTS `taxRate`;
CREATE TABLE IF NOT EXISTS `taxRate` (
  `taxRateId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxRate` decimal(4,3) unsigned NOT NULL,
  PRIMARY KEY (`taxRateId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `productCategory`
--
ALTER TABLE `productCategory`
  ADD CONSTRAINT `productCategory_ibfk_4` FOREIGN KEY (`productImageId`) REFERENCES `productImage` (`productImageId`) ON DELETE SET NULL;
SET FOREIGN_KEY_CHECKS=1;
