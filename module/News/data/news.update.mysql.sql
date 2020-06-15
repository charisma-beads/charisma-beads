
ALTER TABLE news DROP FOREIGN KEY news_ibfk_1;
ALTER TABLE news DROP INDEX articleId;

ALTER TABLE `news` DROP `articleId`;

ALTER TABLE `news`
  ADD `userId` int(10) UNSIGNED NOT NULL AFTER `newsId`,
  ADD `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `userId`,
  ADD `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `title`,
  ADD `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `slug`,
  ADD `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `content`,
  ADD `keywords` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `content`,
  ADD `layout` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `keywords`,
  ADD `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `layout`,
  ADD `layout` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `image`,
  ADD `lead` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `layout`,
  ADD `pageHits` int(10) UNSIGNED NOT NULL AFTER 'lead',
  ADD `dateCreated` datetime NOT NULL AFTER 'pageHits';

ALTER TABLE `news` ADD INDEX(`userId`);

ALTER TABLE `news` ADD FOREIGN KEY (`userId`) REFERENCES `user`(`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT;
