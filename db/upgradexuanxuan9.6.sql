-- zt_im_chat
ALTER TABLE `zt_im_chat` MODIFY COLUMN `createdDate` DATETIME NOT NULL;
ALTER TABLE `zt_im_chat` MODIFY COLUMN `editedDate` DATETIME NULL;
ALTER TABLE `zt_im_chat` MODIFY COLUMN `mergedDate` DATETIME NULL;
ALTER TABLE `zt_im_chat` MODIFY COLUMN `lastActiveTime` DATETIME NULL;
ALTER TABLE `zt_im_chat` MODIFY COLUMN `dismissDate` DATETIME NULL;
ALTER Table `zt_im_chat` MODIFY COLUMN `archiveDate` DATETIME NULL;
ALTER TABLE `zt_im_chat` MODIFY COLUMN `pinnedMessages` TEXT NULL;
ALTER TABLE `zt_im_chat` MODIFY COLUMN `mergedChats` TEXT NULL;
ALTER TABLE `zt_im_chat` MODIFY COLUMN `avatar` TEXT NULL;

UPDATE `zt_im_chat`
SET
    `editedDate` = NULL
WHERE
    `editedDate` = '0000-00-00 00:00:00';

UPDATE `zt_im_chat`
SET
    `mergedDate` = NULL
WHERE
    `mergedDate` = '0000-00-00 00:00:00';

UPDATE `zt_im_chat`
SET
    `lastActiveTime` = NULL
WHERE
    `lastActiveTime` = '0000-00-00 00:00:00';

UPDATE `zt_im_chat`
SET
    `dismissDate` = NULL
WHERE
    `dismissDate` = '0000-00-00 00:00:00';

UPDATE `zt_im_chat`
SET
    `archiveDate` = NULL
WHERE
    `archiveDate` = '0000-00-00 00:00:00';

-- zt_im_chat_message_index
ALTER TABLE `zt_im_chat_message_index` MODIFY COLUMN `startDate` DATETIME NOT NULL;
ALTER TABLE `zt_im_chat_message_index` MODIFY COLUMN `endDate` DATETIME NOT NULL;

-- zt_im_chatuser
ALTER TABLE `zt_im_chatuser` MODIFY COLUMN `join` DATETIME NOT NULL;
ALTER TABLE `zt_im_chatuser` MODIFY COLUMN `quit` DATETIME NULL;

UPDATE `zt_im_chatuser`
SET
    `quit` = NULL
WHERE
    `quit` = '0000-00-00 00:00:00';

-- zt_im_client
ALTER TABLE `zt_im_client` MODIFY COLUMN `createdDate` DATETIME NOT NULL;
ALTER TABLE `zt_im_client` MODIFY COLUMN `editedDate` DATETIME NULL;

UPDATE `zt_im_client`
SET
    `editedDate` = NULL
WHERE
    `editedDate` = '0000-00-00 00:00:00';

-- zt_im_conference
ALTER TABLE `zt_im_conference` MODIFY COLUMN `openedDate` DATETIME NOT NULL;
ALTER TABLE `zt_im_conference` MODIFY COLUMN `startTime` DATETIME NULL;
ALTER TABLE `zt_im_conference` MODIFY COLUMN `endTime` DATETIME NULL;

UPDATE `zt_im_conference`
SET
    `startTime` = NULL
WHERE
    `startTime` = '0000-00-00 00:00:00';

UPDATE `zt_im_conference`
SET
    `endTime` = NULL
WHERE
    `endTime` = '0000-00-00 00:00:00';

-- zt_im_conferenceaction
ALTER TABLE `zt_im_conferenceaction` MODIFY COLUMN `date` DATETIME NOT NULL;
ALTER TABLE `zt_im_conferenceaction` MODIFY COLUMN `data` TEXT NULL;

-- zt_im_conferenceinvite
ALTER TABLE `zt_im_conferenceinvite` MODIFY COLUMN `createdDate` DATETIME NOT NULL;
ALTER TABLE `zt_im_conferenceinvite` MODIFY COLUMN `updatedDate` DATETIME NOT NULL;

-- zt_im_message
ALTER TABLE `zt_im_message` MODIFY COLUMN `date` DATETIME NOT NULL;
ALTER TABLE `zt_im_message` MODIFY COLUMN `content` TEXT NULL;
ALTER TABLE `zt_im_message` MODIFY COLUMN `data` TEXT NULL;
ALTER TABLE `zt_im_message` MODIFY COLUMN `read` TEXT DEFAULT NULL;

-- zt_im_message_backup
ALTER TABLE `zt_im_message_backup` MODIFY COLUMN `date` DATETIME NOT NULL;
ALTER TABLE `zt_im_message_backup` MODIFY COLUMN `content` TEXT NULL;
ALTER TABLE `zt_im_message_backup` MODIFY COLUMN `data` TEXT NULL;
ALTER TABLE `zt_im_message_backup`
  MODIFY COLUMN `type` enum('normal', 'broadcast', 'notify', 'bulletin', 'botcommand') NOT NULL DEFAULT 'normal';
ALTER TABLE `zt_im_message_backup`
  ADD COLUMN `read` JSON NULL AFTER `data`;
ALTER TABLE `zt_im_message_backup` MODIFY COLUMN `read` TEXT DEFAULT NULL;

-- zt_im_message_index
ALTER TABLE `zt_im_message_index` MODIFY COLUMN `startDate` DATETIME NOT NULL;
ALTER TABLE `zt_im_message_index` MODIFY COLUMN `endDate` DATETIME NOT NULL;

-- zt_im_userdevice
UPDATE `zt_im_userdevice`
SET
    `validUntil` = NOW()
WHERE
    `validUntil` = '0000-00-00 00:00:00';
ALTER TABLE `zt_im_userdevice` MODIFY COLUMN `validUntil` DATETIME NOT NULL;
ALTER TABLE `zt_im_userdevice` MODIFY COLUMN `lastLogin` DATETIME NULL;
ALTER TABLE `zt_im_userdevice` MODIFY COLUMN `lastLogout` DATETIME NULL;

UPDATE `zt_im_userdevice`
SET
    `lastLogin` = NULL
WHERE
    `lastLogin` = '0000-00-00 00:00:00';

UPDATE `zt_im_userdevice`
SET
    `lastLogout` = NULL
WHERE
    `lastLogout` = '0000-00-00 00:00:00';

ALTER TABLE `zt_im_chat` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_chat` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_chat_message_index` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_chat_message_index` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_chatuser` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_chatuser` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_client` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_client` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_conference` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_conference` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_conferenceaction` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_conferenceaction` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_conferenceinvite` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_conferenceinvite` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_conferenceuser` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_conferenceuser` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_message` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_message` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_message_backup` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_message_backup` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_message_index` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_message_index` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_messagestatus` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_messagestatus` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_queue` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_queue` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `zt_im_userdevice` ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `zt_im_userdevice` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
