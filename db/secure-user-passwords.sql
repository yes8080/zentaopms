ALTER TABLE `zt_user` MODIFY `password` varchar(255) NOT NULL DEFAULT '';
CREATE TABLE IF NOT EXISTS `zt_userremember` (
  `digest` char(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `account` varchar(30) NOT NULL,
  `expires` int unsigned NOT NULL,
  PRIMARY KEY (`digest`),
  KEY `expires` (`expires`)
);
