
SET FOREIGN_KEY_CHECKS=0;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cartId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `verifyId` varchar(255) NOT NULL,
  `expires` int(11) NOT NULL,
  `dateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cartId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cartItem`
--

DROP TABLE IF EXISTS `cartItem`;
CREATE TABLE IF NOT EXISTS `cartItem` (
  `cartItemId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cartId` int(10) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `price` float(6,2) NOT NULL,
  `tax` float(10,5) NOT NULL,
  `metadata` longtext NOT NULL,
  PRIMARY KEY (`cartItemId`),
  KEY `cartId` (`cartId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `countryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postZoneId` int(10) unsigned NOT NULL,
  `country` varchar(150) NOT NULL,
  PRIMARY KEY (`countryId`),
  KEY `postZoneId` (`postZoneId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customerId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL DEFAULT '0',
  `prefixId` int(10) unsigned NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `billingAddressId` int(10) unsigned NOT NULL,
  `deliveryAddressId` int(10) unsigned NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customerAddress`
--

DROP TABLE IF EXISTS `customerAddress`;
CREATE TABLE IF NOT EXISTS `customerAddress` (
  `customerAddressId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerId` int(5) unsigned NOT NULL,
  `countryId` int(2) unsigned DEFAULT '0',
  `address1` varchar(80) DEFAULT NULL,
  `address2` varchar(80) DEFAULT NULL,
  `address3` varchar(100) DEFAULT NULL,
  `city` varchar(40) DEFAULT NULL,
  `county` varchar(40) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`customerAddressId`),
  KEY `customerId` (`customerId`),
  KEY `countryId` (`countryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customerPrefix`
--

DROP TABLE IF EXISTS `customerPrefix`;
CREATE TABLE IF NOT EXISTS `customerPrefix` (
  `prefixId` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(5) NOT NULL DEFAULT '',
  PRIMARY KEY (`prefixId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `orderId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customerId` int(10) unsigned NOT NULL,
  `orderStatusId` int(10) unsigned NOT NULL,
  `orderNumber` int(10) unsigned NOT NULL,
  `total` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `orderDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shipping` decimal(4,2) NOT NULL DEFAULT '0.00',
  `vatTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `vatInvoice` int(1) unsigned NOT NULL DEFAULT '0',
  `txnId` varchar(19) DEFAULT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orderStatus`
--

DROP TABLE IF EXISTS `orderStatus`;
CREATE TABLE IF NOT EXISTS `orderStatus` (
  `orderStatusId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(200) NOT NULL,
  PRIMARY KEY (`orderStatusId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`postCostId`),
  KEY `cost` (`cost`),
  KEY `level` (`postLevelId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `postLevel`
--

DROP TABLE IF EXISTS `postLevel`;
CREATE TABLE IF NOT EXISTS `postLevel` (
  `postLevelId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postLevel` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`postLevelId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `postUnit`
--

DROP TABLE IF EXISTS `postUnit`;
CREATE TABLE IF NOT EXISTS `postUnit` (
  `postUnitId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postUnit` decimal(6,2) unsigned NOT NULL,
  PRIMARY KEY (`postUnitId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `postZone`
--

DROP TABLE IF EXISTS `postZone`;
CREATE TABLE IF NOT EXISTS `postZone` (
  `postZoneId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxCodeId` int(10) unsigned NOT NULL,
  `zone` varchar(45) NOT NULL,
  PRIMARY KEY (`postZoneId`),
  KEY `taxCodeId` (`taxCodeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
  `postUnitId` int(10) unsigned NOT NULL,
  `productGroupId` int(10) unsigned DEFAULT NULL,
  `ident` varchar(250) NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `description` text NOT NULL,
  `shortDescription` varchar(100) DEFAULT NULL,
  `quantity` int(5) NOT NULL DEFAULT '-1',
  `taxable` int(1) unsigned NOT NULL DEFAULT '0',
  `addPostage` int(1) unsigned NOT NULL DEFAULT '1',
  `discountPercent` decimal(5,4) unsigned NOT NULL DEFAULT '0.0000',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `discontinued` int(1) unsigned NOT NULL DEFAULT '0',
  `vatInc` int(1) unsigned NOT NULL,
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
-- Table structure for table `productGroupPrice`
--

DROP TABLE IF EXISTS `productGroup`;
CREATE TABLE IF NOT EXISTS `productGroup` (
  `productGroupId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(5) DEFAULT '0',
  `price` decimal(4,2) DEFAULT '0.00',
  PRIMARY KEY (`productGroupId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
-- Table structure for table `productSize`
--

DROP TABLE IF EXISTS `productSize`;
CREATE TABLE IF NOT EXISTS `productSize` (
  `productSizeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `size` varchar(60) NOT NULL,
  PRIMARY KEY (`productSizeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `voucherCodes`;
CREATE TABLE `voucherCodes` (
  `voucherId` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `quantity` int(5) NOT NULL DEFAULT '-1',
  `limitCustomer` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `noPerCustomer` int(11) DEFAULT NULL,
  `minCartCost` float(6,2) NOT NULL DEFAULT '0.00',
  `discountOperation` enum('-','%','s') NOT NULL DEFAULT '%',
  `startDate` date NOT NULL,
  `expiry` date DEFAULT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `redeemable` enum('web','fairs','both') NOT NULL,
  `productCategories` text NOT NULL,
  `zones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `voucherCodes`
--
ALTER TABLE `voucherCodes`
  ADD PRIMARY KEY (`voucherId`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `voucherCodes`
--
ALTER TABLE `voucherCodes`
  MODIFY `voucherId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartItem`
--
ALTER TABLE `cartItem`
  ADD CONSTRAINT `cartItem_ibfk_2` FOREIGN KEY (`cartId`) REFERENCES `cart` (`cartId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `country`
--
ALTER TABLE `country`
  ADD CONSTRAINT `country_ibfk_1` FOREIGN KEY (`postZoneId`) REFERENCES `postZone` (`postZoneId`);

--
-- Constraints for table `customerAddress`
--
ALTER TABLE `customerAddress`
  ADD CONSTRAINT `customerAddress_ibfk_1` FOREIGN KEY (`customerId`) REFERENCES `customer` (`customerId`),
  ADD CONSTRAINT `customerAddress_ibfk_2` FOREIGN KEY (`countryId`) REFERENCES `country` (`countryId`);

--
-- Constraints for table `postZone`
--
ALTER TABLE `postZone`
  ADD CONSTRAINT `postZone_ibfk_1` FOREIGN KEY (`taxCodeId`) REFERENCES `taxCode` (`taxCodeId`);

--
-- Constraints for table `productCategory`
--
ALTER TABLE `productCategory`
  ADD CONSTRAINT `productCategory_ibfk_4` FOREIGN KEY (`productImageId`) REFERENCES `productImage` (`productImageId`) ON DELETE SET NULL;

SET FOREIGN_KEY_CHECKS=1;
