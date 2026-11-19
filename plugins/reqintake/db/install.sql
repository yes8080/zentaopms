CREATE TABLE IF NOT EXISTS `zt_reqintakeOwner` (
  `product` mediumint unsigned NOT NULL,
  `account` varchar(30) NOT NULL,
  PRIMARY KEY (`product`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeFeedback` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `operation` char(32) NOT NULL,
  `product` mediumint unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `customer` varchar(255) NOT NULL DEFAULT '',
  `channel` varchar(64) NOT NULL DEFAULT '',
  `openedBy` varchar(30) NOT NULL,
  `assignedTo` varchar(30) NOT NULL,
  `assignmentPending` tinyint unsigned NOT NULL DEFAULT 0,
  `status` enum('pending','tracking','closed') NOT NULL DEFAULT 'pending',
  `version` int unsigned NOT NULL DEFAULT 1,
  `openedDate` datetime NOT NULL,
  `updatedDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `submission` (`openedBy`, `operation`),
  KEY `productStatus` (`product`, `status`, `updatedDate`),
  KEY `assigneeStatus` (`assignedTo`, `status`, `updatedDate`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeHistory` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `actor` varchar(30) NOT NULL,
  `action` enum('start','close','reopen') NOT NULL,
  `reason` varchar(500) NOT NULL DEFAULT '',
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeLink` (
  `feedback` int unsigned NOT NULL,
  `targetType` varchar(20) NOT NULL,
  `target` int unsigned NOT NULL,
  `scope` varchar(500) NOT NULL DEFAULT '',
  `createdBy` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`feedback`, `targetType`, `target`),
  KEY `targetLookup` (`targetType`, `target`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeProgress` (
  `feedback` int unsigned NOT NULL,
  `targetType` varchar(20) NOT NULL,
  `target` int unsigned NOT NULL,
  `available` tinyint unsigned NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `stage` varchar(50) NOT NULL DEFAULT '',
  `reason` varchar(50) NOT NULL DEFAULT '',
  `checkedDate` datetime NOT NULL,
  PRIMARY KEY (`feedback`, `targetType`, `target`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeRevision` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `customer` varchar(255) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `actor` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeFollowup` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `actor` varchar(30) NOT NULL,
  `previousAssignee` varchar(30) NOT NULL DEFAULT '',
  `nextAssignee` varchar(30) NOT NULL DEFAULT '',
  `message` varchar(500) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;
