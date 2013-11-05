
SET FOREIGN_KEY_CHECKS=0;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `countryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postZoneId` int(10) unsigned NOT NULL,
  `country` varchar(150) NOT NULL,
  PRIMARY KEY (`countryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `customerAddress`
--

DROP TABLE IF EXISTS `customerAddress`;
CREATE TABLE IF NOT EXISTS `customerAddress` (
  `customerAddressId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(5) unsigned NOT NULL,
  `countryId` int(2) unsigned DEFAULT '0',
  `address1` varchar(80) DEFAULT NULL,
  `address2` varchar(80) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `county` varchar(40) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`addressId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customerBillingAddress`
--

DROP TABLE IF EXISTS `customerBillingAddress`;
CREATE TABLE IF NOT EXISTS `customerBillingAddress` (
  `customerBillingAddressId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerAddressId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`customerBillingAddressId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `customerDeliveryAddress`
--

DROP TABLE IF EXISTS `customerDeliveryAddress`;
CREATE TABLE IF NOT EXISTS `customerDeliveryAddress` (
  `customerDeliveryAddressId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerAddressId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`customerDeliveryAddressId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `orderId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `orderStatusId` int(10) unsigned NOT NULL,
  `total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `orderDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shipping` decimal(4,2) NOT NULL DEFAULT '0.00',
  `vatTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `txnId` varchar(19) DEFAULT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `orderLines`
--

DROP TABLE IF EXISTS `orderLines`;
CREATE TABLE IF NOT EXISTS `orderLines` (
  `orderLineId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `orderId` int(10) unsigned NOT NULL,
  `productId` int(10) unsigned NOT NULL,
  `qty` int(5) unsigned NOT NULL DEFAULT '0',
  `price` decimal(4,2) NOT NULL DEFAULT '0.00',
  `vatPercent` decimal(4,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`orderLineId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `orderStatus`
--

DROP TABLE IF EXISTS `orderStatus`;
CREATE TABLE IF NOT EXISTS `orderStatus` (
  `orderStatusId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(200) NOT NULL,
  PRIMARY KEY (`orderStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `postCost`
--

DROP TABLE IF EXISTS `postCost`;
CREATE TABLE IF NOT EXISTS `postCost` (
  `postCostId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postLevelId` int(10) unsigned NOT NULL,
  `postZoneId` int(10) unsigned NOT NULL,
  `cost` decimal(6,2) NOT NULL DEFAULT '0.00',
  `vatInc` int(1) unsigned NOT NULL,
  PRIMARY KEY (`postCostId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `postLevel`
--

DROP TABLE IF EXISTS `postLevel`;
CREATE TABLE IF NOT EXISTS `postLevel` (
  `postLevelId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postLevel` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`postLevelId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `postZone`
--

DROP TABLE IF EXISTS `postZone`;
CREATE TABLE IF NOT EXISTS `postZone` (
  `postZoneId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxCodeId` int(10) unsigned NOT NULL,
  `zone` varchar(45) NOT NULL,
  PRIMARY KEY (`postZoneId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

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
  `ident` varchar(250) NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `description` text NOT NULL,
  `shortDescription` varchar(100) DEFAULT NULL,
  `quantity` int(5) NOT NULL DEFAULT '-1',
  `taxable` int(1) unsigned NOT NULL DEFAULT '0',
  `addPostage` int(1) unsigned NOT NULL DEFAULT '1',
  `discountPercent` int(3) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `discontinued` int(1) unsigned NOT NULL DEFAULT '0',
  `vatInc` int(1) unsigned NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`productId`),
  UNIQUE KEY `ident` (`ident`),
  KEY `ProductCategoryId` (`productCategoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

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
  `isDefault` int(1) unsigned NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`productImageId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `productPostUnit`
--

DROP TABLE IF EXISTS `productPostUnit`;
CREATE TABLE IF NOT EXISTS `productPostUnit` (
  `productPostUnitId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postUnit` decimal(6,2) unsigned NOT NULL,
  PRIMARY KEY (`productPostUnitId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `productSize`
--

DROP TABLE IF EXISTS `productSize`;
CREATE TABLE IF NOT EXISTS `productSize` (
  `productSizeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `size` varchar(60) NOT NULL,
  PRIMARY KEY (`productSizeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `productStockStatus`
--

DROP TABLE IF EXISTS `productStockStatus`;
CREATE TABLE IF NOT EXISTS `productStockStatus` (
  `productStockStautsId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stockStatus` varchar(50) NOT NULL,
  PRIMARY KEY (`productStockStautsId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Table structure for table `taxRate`
--

DROP TABLE IF EXISTS `taxRate`;
CREATE TABLE IF NOT EXISTS `taxRate` (
  `taxRateId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxRate` decimal(4,3) unsigned NOT NULL,
  PRIMARY KEY (`taxRateId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `productCategory`
--
ALTER TABLE `productCategory`
  ADD CONSTRAINT `productCategory_ibfk_4` FOREIGN KEY (`productImageId`) REFERENCES `productImage` (`productImageId`) ON DELETE SET NULL;

SET FOREIGN_KEY_CHECKS=1;

