-- 创建 zt_cluster 表（适用于从 9.6 等无集群功能的版本升级）
CREATE TABLE IF NOT EXISTS `zt_cluster` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(16) NOT NULL DEFAULT '',
  `desc` text NULL,
  `address` varchar(20) NOT NULL,
  `commonPort` varchar(20) NOT NULL,
  `chatPort` varchar(20) NOT NULL DEFAULT '',
  `role` enum('master', 'follower') NOT NULL DEFAULT 'follower',
  `priority` int(11) NOT NULL DEFAULT 0,
  `term` bigint(20) NOT NULL DEFAULT 0,
  `leaseExpireAt` datetime NULL,
  `lastSeenAt` datetime NULL,
  `wsAddr` varchar(255) NOT NULL DEFAULT '',
  `httpAddr` varchar(255) NOT NULL DEFAULT '',
  `switchCount` int(11) NOT NULL DEFAULT 0,
  `version` varchar(50) NOT NULL DEFAULT '',
  `status` enum('online', 'offline') NOT NULL,
  `onlineCount` mediumint(8) unsigned NOT NULL,
  `start` datetime NULL,
  `lastPoll` datetime NULL,
  `polling` varchar(20) NOT NULL DEFAULT '',
  `enable` enum('0', '1') NOT NULL DEFAULT '0',
  `deleted` enum('0', '1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 将旧版 port 字段重命名为 commonPort（仅当 port 字段存在时生效）
ALTER TABLE `zt_cluster` CHANGE COLUMN `port` `commonPort` varchar(20) NOT NULL;
ALTER TABLE `zt_cluster` ADD COLUMN `name` char(16) NOT NULL DEFAULT '' AFTER `id`;
ALTER TABLE `zt_cluster` ADD COLUMN `desc` text NULL AFTER `name`;
ALTER TABLE `zt_cluster` ADD COLUMN `chatPort` varchar(20) NOT NULL DEFAULT '' AFTER `commonPort`;
ALTER TABLE `zt_cluster` ADD COLUMN `onlineCount` mediumint(8) unsigned NOT NULL DEFAULT 0 AFTER `status`;
ALTER TABLE `zt_cluster` ADD COLUMN `start` datetime NULL AFTER `onlineCount`;
ALTER TABLE `zt_cluster` ADD COLUMN `lastPoll` datetime NULL AFTER `start`;
ALTER TABLE `zt_cluster` ADD COLUMN `polling` varchar(20) NOT NULL DEFAULT '' AFTER `lastPoll`;
ALTER TABLE `zt_cluster` ADD COLUMN `enable` enum('0', '1') NOT NULL DEFAULT '0' AFTER `polling`;
ALTER TABLE `zt_cluster` ADD COLUMN `deleted` enum('0', '1') NOT NULL DEFAULT '0' AFTER `enable`;
ALTER TABLE `zt_cluster` ADD COLUMN `role` enum('master','follower') NOT NULL DEFAULT 'follower' AFTER `chatPort`;
ALTER TABLE `zt_cluster` ADD COLUMN `priority` int NOT NULL DEFAULT 0 AFTER `role`;
ALTER TABLE `zt_cluster` ADD COLUMN `term` bigint NOT NULL DEFAULT 0 AFTER `priority`;
ALTER TABLE `zt_cluster` ADD COLUMN `leaseExpireAt` datetime NULL AFTER `term`;
ALTER TABLE `zt_cluster` ADD COLUMN `lastSeenAt` datetime NULL AFTER `leaseExpireAt`;
ALTER TABLE `zt_cluster` ADD COLUMN `wsAddr` varchar(255) NOT NULL DEFAULT '' AFTER `lastSeenAt`;
ALTER TABLE `zt_cluster` ADD COLUMN `httpAddr` varchar(255) NOT NULL DEFAULT '' AFTER `wsAddr`;
ALTER TABLE `zt_cluster` ADD COLUMN `switchCount` int NOT NULL DEFAULT 0 AFTER `httpAddr`;
ALTER TABLE `zt_cluster` ADD COLUMN `version` varchar(50) NOT NULL DEFAULT '' AFTER `switchCount`;

UPDATE `zt_cluster`
SET `role` = 'master'
WHERE CAST(`master` AS CHAR) NOT IN ('', '0', 'follower');

ALTER TABLE `zt_cluster` DROP COLUMN `master`;

UPDATE `zt_cluster`
SET
  `chatPort` = `commonPort`,
  `onlineCount` = 0,
  `enable` = '1',
  `deleted` = '0'
WHERE `id` > 0;

CREATE TABLE IF NOT EXISTS `zt_cluster_session` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `userID` bigint unsigned NOT NULL DEFAULT '0',
  `serverName` varchar(255) NOT NULL DEFAULT '',
  `nodeID` bigint unsigned NOT NULL DEFAULT '0',
  `nodeAddr` varchar(255) NOT NULL DEFAULT '',
  `sessionID` varchar(255) NOT NULL DEFAULT '',
  `device` varchar(50) NOT NULL DEFAULT '',
  `status` enum('online','reconnecting','offline') NOT NULL DEFAULT 'online',
  `connectedAt` datetime NULL,
  `lastActiveAt` datetime NULL,
  `term` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_user_session` (`userID`, `device`, `sessionID`),
  KEY `idx_user_status_server` (`userID`, `status`, `serverName`),
  KEY `idx_nodeID` (`nodeID`),
  KEY `idx_nodeAddr` (`nodeAddr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_user`
  ADD COLUMN `activeNode` mediumint(8) unsigned NOT NULL DEFAULT '0' AFTER `clientLang`,
  ADD COLUMN `activeSessionID` varchar(255) NOT NULL DEFAULT '' AFTER `activeNode`;
