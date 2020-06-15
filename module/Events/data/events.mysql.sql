
CREATE TABLE IF NOT EXISTS `events` (
  `eventId` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `html` text CHARACTER SET utf8 NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `events`
ADD PRIMARY KEY (`eventId`);


ALTER TABLE `events`
MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT;