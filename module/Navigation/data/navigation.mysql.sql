
SET FOREIGN_KEY_CHECKS=0;

--
-- Table structure for table `menuItem`
--

CREATE TABLE `menuItem` (
  `menuItemId` int(10) UNSIGNED NOT NULL,
  `menuId` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `params` text,
  `route` varchar(255) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `resource` varchar(255) NOT NULL,
  `visible` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `lft` int(10) UNSIGNED DEFAULT NULL,
  `rgt` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menuItem`
--
ALTER TABLE `menuItem`
  ADD PRIMARY KEY (`menuItemId`),
  ADD KEY `menuId` (`menuId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menuItem`
--
ALTER TABLE `menuItem`
  MODIFY `menuItemId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `menuItem`
--
ALTER TABLE `menuItem`
  ADD CONSTRAINT `menuItem_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`menuId`) ON DELETE CASCADE;

SET FOREIGN_KEY_CHECKS=1;
