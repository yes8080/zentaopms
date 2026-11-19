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
  `action` enum('start','close','reopen','accept') NOT NULL,
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

CREATE TABLE IF NOT EXISTS `zt_reqintakeConversion` (
  `operation` char(64) NOT NULL,
  `target` int unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`operation`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeAttributes` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `category` varchar(30) NOT NULL,
  `priority` tinyint unsigned NOT NULL,
  `acceptance` mediumtext NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeRichText` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeAttachment` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `feedback` int unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` mediumblob NOT NULL,
  `removed` tinyint unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `feedback` (`feedback`, `removed`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeDemandFields` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `source` varchar(30) NOT NULL,
  `sourceNote` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `estimate` varchar(11) NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeProductScope` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `branch` mediumint unsigned NOT NULL,
  `module` mediumint unsigned NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeHandling` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `kind` enum('plan','reply') NOT NULL,
  `actor` varchar(30) NOT NULL,
  `summary` varchar(500) NOT NULL,
  `details` varchar(2000) NOT NULL,
  `channel` varchar(64) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeDuplicate` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `original` int unsigned NOT NULL,
  PRIMARY KEY (`feedback`, `version`),
  KEY `original` (`original`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeBranchScope` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `branchModules` json NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakePlan` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `plan` int unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeMailto` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `mailto` text NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeCustomerVersion` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `customerVersion` varchar(100) NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeLinkMethod` (
  `feedback` int unsigned NOT NULL,
  `targetType` varchar(20) NOT NULL,
  `target` int unsigned NOT NULL,
  `method` varchar(10) NOT NULL,
  PRIMARY KEY (`feedback`, `targetType`, `target`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeClosure` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `outcome` varchar(10) NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeInitialAttachment` (
  `feedback` int unsigned NOT NULL,
  `fingerprint` char(64) NOT NULL,
  PRIMARY KEY (`feedback`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeGrade` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `suggestedGrade` varchar(40) NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeParent` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `suggestedParent` varchar(10) NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeReviewers` (
  `feedback` int unsigned NOT NULL,
  `version` int unsigned NOT NULL,
  `suggestedReviewers` text NOT NULL,
  PRIMARY KEY (`feedback`, `version`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `zt_reqintakeConversionDetails` (
  `operation` char(64) NOT NULL,
  `targetType` varchar(20) NOT NULL,
  `product` int unsigned NOT NULL,
  `execution` int unsigned NOT NULL DEFAULT 0,
  `sources` text NOT NULL,
  `actor` varchar(30) NOT NULL,
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`operation`)
) ENGINE=InnoDB;
