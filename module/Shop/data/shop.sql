
SET FOREIGN_KEY_CHECKS=0;

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
  `productGroupId` int(10) unsigned NOT NULL,
  `stockStatusId` int(10) unsigned NOT NULL,
  `indent` varchar(255) NOT NULL,
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
  KEY `ProductCategoryId` (`productCategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productCategory`
--

DROP TABLE IF EXISTS `productCategory`;
CREATE TABLE IF NOT EXISTS `productCategory` (
  `productCategoryId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productImageId` int(11) unsigned NOT NULL,
  `ident` varchar(255) NOT NULL,
  `category` varchar(60) DEFAULT NULL,
  `lft` int(10) unsigned NOT NULL DEFAULT '0',
  `rgt` int(10) unsigned NOT NULL DEFAULT '0',
  `enabled` int(1) unsigned NOT NULL DEFAULT '1',
  `discontinued` int(1) unsigned NOT NULL DEFAULT '0',
  `dateCreated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateModified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`productCategoryId`),
  KEY `productImageId` (`productImageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `price` decimal(6,2) unsigned NOT NULL DEFAULT '0.00',
  `sortOrder` int(2) unsigned NOT NULL,
  PRIMARY KEY (`productOptionId`),
  KEY `productId` (`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`productCategoryId`) REFERENCES `productCategory` (`productCategoryId`);

--
-- Constraints for table `productCategory`
--
ALTER TABLE `productCategory`
  ADD CONSTRAINT `productCategory_ibfk_1` FOREIGN KEY (`productImageId`) REFERENCES `productImage` (`productImageId`);

--
-- Constraints for table `productImage`
--
ALTER TABLE `productImage`
  ADD CONSTRAINT `productImage_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`);
  
--
-- Constraints for table `productOption`
--
ALTER TABLE `productOption`
  ADD CONSTRAINT `productOption_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`);
  
SET FOREIGN_KEY_CHECKS=1;
