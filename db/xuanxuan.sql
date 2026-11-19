-- DROP TABLE IF EXISTS `zt_im_chat`;
CREATE TABLE IF NOT EXISTS `zt_im_chat` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `gid` char(40) NOT NULL DEFAULT '' COMMENT '群组ID',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '群组名称',
  `type` varchar(20) NOT NULL DEFAULT 'group' COMMENT '群组类型',
  `admins` varchar(255) NOT NULL DEFAULT '' COMMENT '管理员列表',
  `committers` varchar(255) NOT NULL DEFAULT '' COMMENT '可编辑成员',
  `subject` mediumint(8) unsigned NOT NULL DEFAULT 0 COMMENT '关联对象ID',
  `public` enum('0', '1') NOT NULL DEFAULT '0' COMMENT '是否公开',
  `createdBy` varchar(30) NOT NULL DEFAULT '' COMMENT '创建者',
  `createdDate` datetime NULL COMMENT '创建时间',
  `ownedBy` varchar(30) NOT NULL DEFAULT '' COMMENT '所有者',
  `editedBy` varchar(30) NOT NULL DEFAULT '' COMMENT '编辑者',
  `editedDate` datetime NULL COMMENT '编辑时间',
  `mergedDate` datetime NULL COMMENT '合并时间',
  `lastActiveTime` datetime NULL COMMENT '最后活跃时间',
  `lastMessage` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '最后消息ID',
  `lastMessageIndex` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '最后消息索引',
  `dismissDate` datetime NULL COMMENT '解散时间',
  `pinnedMessages` text NULL COMMENT '置顶消息列表',
  `mergedChats` text NULL COMMENT '合并会话列表',
  `adminInvite` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否仅管理员可邀请',
  `avatar` text NULL COMMENT '头像',
  `archiveDate` datetime NULL COMMENT '归档时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='群组表';
CREATE INDEX `idx_gid` ON `zt_im_chat` (`gid`);
CREATE INDEX `idx_name` ON `zt_im_chat` (`name`);
CREATE INDEX `idx_type` ON `zt_im_chat` (`type`);
CREATE INDEX `idx_public` ON `zt_im_chat` (`public`);
CREATE INDEX `idx_createdBy` ON `zt_im_chat` (`createdBy`);
CREATE INDEX `idx_editedBy` ON `zt_im_chat` (`editedBy`);

-- DROP TABLE IF EXISTS `zt_im_chatuser`;
CREATE TABLE IF NOT EXISTS `zt_im_chatuser` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cgid` char(40) NOT NULL DEFAULT '' COMMENT '会话ID',
  `user` mediumint(8) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `order` smallint(5) NOT NULL DEFAULT 0 COMMENT '排序',
  `star` enum('0', '1') NOT NULL DEFAULT '0' COMMENT '是否星标',
  `hide` enum('0', '1') NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `mute` enum('0', '1') NOT NULL DEFAULT '0' COMMENT '是否免打扰',
  `freeze` enum('0', '1') NOT NULL DEFAULT '0' COMMENT '是否冻结',
  `join` datetime NULL COMMENT '加入时间',
  `quit` datetime NULL COMMENT '退出时间',
  `category` varchar(40) NOT NULL DEFAULT '' COMMENT '分类',
  `lastReadMessage` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '最后已读消息ID',
  `lastReadMessageIndex` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '最后已读消息索引',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='群成员表';
CREATE INDEX `idx_cgid` ON `zt_im_chatuser` (`cgid`);
CREATE INDEX `idx_user` ON `zt_im_chatuser` (`user`);
CREATE INDEX `idx_order` ON `zt_im_chatuser` (`order`);
CREATE INDEX `idx_star` ON `zt_im_chatuser` (`star`);
CREATE INDEX `idx_hide` ON `zt_im_chatuser` (`hide`);
CREATE UNIQUE INDEX `uk_chatuser` ON `zt_im_chatuser` (`cgid`, `user`);

-- DROP TABLE IF EXISTS `zt_im_client`;
CREATE TABLE IF NOT EXISTS `zt_im_client` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `version` char(30) NOT NULL DEFAULT '' COMMENT '版本',
  `desc` varchar(100) NOT NULL DEFAULT '' COMMENT '描述',
  `changeLog` text NULL COMMENT '更新日志',
  `strategy` varchar(10) NOT NULL DEFAULT '' COMMENT '升级策略',
  `downloads` text NULL COMMENT '下载地址',
  `createdDate` datetime NULL COMMENT '创建时间',
  `createdBy` varchar(30) NOT NULL DEFAULT '' COMMENT '创建者',
  `editedDate` datetime NULL COMMENT '编辑时间',
  `editedBy` varchar(30) NOT NULL DEFAULT '' COMMENT '编辑者',
  `status` enum('released','wait') NOT NULL DEFAULT 'wait' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='客户端版本表';

-- DROP TABLE IF EXISTS `zt_im_message`;
CREATE TABLE IF NOT EXISTS `zt_im_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `gid` char(40) NOT NULL DEFAULT '' COMMENT '消息ID',
  `cgid` char(40) NOT NULL DEFAULT '' COMMENT '会话ID',
  `user` varchar(30) NOT NULL DEFAULT '' COMMENT '发送者',
  `date` datetime NULL COMMENT '发送时间',
  `index` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '会话内索引',
  `type` enum('normal', 'broadcast', 'notify', 'bulletin', 'botcommand') NOT NULL DEFAULT 'normal' COMMENT '消息类型',
  `content` text NULL COMMENT '消息内容',
  `contentType` enum('text', 'plain', 'emotion', 'image', 'file', 'object', 'code', 'merge', 'voice') NOT NULL DEFAULT 'text' COMMENT '内容类型',
  `data` text NULL COMMENT '扩展数据',
  `read` text NULL COMMENT '已读信息',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='消息表';
CREATE INDEX `idx_mgid` ON `zt_im_message` (`gid`);
CREATE INDEX `idx_mcgid` ON `zt_im_message` (`cgid`);
CREATE INDEX `idx_muser` ON `zt_im_message` (`user`);
CREATE INDEX `idx_mtype` ON `zt_im_message` (`type`);

-- DROP TABLE IF EXISTS `zt_im_message_backup`;
CREATE TABLE IF NOT EXISTS `zt_im_message_backup` (
  `id` int(11) unsigned NOT NULL COMMENT 'ID',
  `gid` char(40) NOT NULL DEFAULT '' COMMENT '消息ID',
  `cgid` char(40) NOT NULL DEFAULT '' COMMENT '会话ID',
  `user` varchar(30) NOT NULL DEFAULT '' COMMENT '发送者',
  `date` datetime NULL COMMENT '发送时间',
  `index` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '会话内索引',
  `type` enum('normal', 'broadcast', 'notify', 'bulletin', 'botcommand') NOT NULL DEFAULT 'normal' COMMENT '消息类型',
  `content` text NULL COMMENT '消息内容',
  `contentType` enum('text', 'plain', 'emotion', 'image', 'file', 'object', 'code', 'merge', 'voice') NOT NULL DEFAULT 'text' COMMENT '内容类型',
  `data` text NULL COMMENT '扩展数据',
  `read` text NULL COMMENT '已读信息',
  `deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否删除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='消息备份表';

-- DROP TABLE IF EXISTS `zt_im_message_index`;
CREATE TABLE IF NOT EXISTS `zt_im_message_index` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tableName` char(64) NOT NULL COMMENT '表名',
  `start` int(11) unsigned NOT NULL COMMENT '起始ID',
  `end` int(11) unsigned NOT NULL COMMENT '结束ID',
  `startDate` datetime NULL COMMENT '起始时间',
  `endDate` datetime NULL COMMENT '结束时间',
  `chats` text NULL COMMENT '会话列表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='消息分表索引表';
CREATE INDEX `idx_tableName` ON `zt_im_message_index` (`tableName`);
CREATE INDEX `idx_start` ON `zt_im_message_index` (`start`);
CREATE INDEX `idx_end` ON `zt_im_message_index` (`end`);
CREATE INDEX `idx_startDate` ON `zt_im_message_index` (`startDate`);
CREATE INDEX `idx_endDate` ON `zt_im_message_index` (`endDate`);

-- DROP TABLE IF EXISTS `zt_im_chat_message_index`;
CREATE TABLE IF NOT EXISTS `zt_im_chat_message_index` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `gid` char(40) NOT NULL COMMENT '群组ID',
  `tableName` char(64) NOT NULL COMMENT '表名',
  `start` int(11) unsigned NOT NULL COMMENT '起始ID',
  `end` int(11) unsigned NOT NULL COMMENT '结束ID',
  `startIndex` int(11) unsigned NOT NULL COMMENT '起始索引',
  `endIndex` int(11) unsigned NOT NULL COMMENT '结束索引',
  `startDate` datetime NULL COMMENT '起始时间',
  `endDate` datetime NULL COMMENT '结束时间',
  `count` mediumint(8) unsigned NOT NULL COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='群组消息分表索引表';
CREATE UNIQUE INDEX `uk_chattable` ON `zt_im_chat_message_index` (`gid`, `tableName`);
CREATE INDEX `idx_start` ON `zt_im_chat_message_index` (`start`);
CREATE INDEX `idx_end` ON `zt_im_chat_message_index` (`end`);
CREATE INDEX `idx_startDate` ON `zt_im_chat_message_index` (`startDate`);
CREATE INDEX `idx_endDate` ON `zt_im_chat_message_index` (`endDate`);
CREATE INDEX `idx_chatstartindex` ON `zt_im_chat_message_index` (`gid`, `startIndex`);
CREATE INDEX `idx_chatendindex` ON `zt_im_chat_message_index` (`gid`, `endIndex`);

-- DROP TABLE IF EXISTS `zt_im_messagestatus`;
CREATE TABLE IF NOT EXISTS `zt_im_messagestatus` (
  `user` mediumint(8) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `message` int(11) unsigned NOT NULL COMMENT '消息ID',
  `status` enum('waiting','sent','readed','deleted') NOT NULL DEFAULT 'waiting' COMMENT '状态'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='消息状态表';
CREATE UNIQUE INDEX `uk_user` ON `zt_im_messagestatus` (`user`, `message`);

-- DROP TABLE IF EXISTS `zt_im_queue`;
CREATE TABLE IF NOT EXISTS `zt_im_queue` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `type` char(30) NOT NULL COMMENT '类型',
  `content` text NULL COMMENT '内容',
  `addDate` datetime NULL COMMENT '添加时间',
  `processDate` datetime NULL COMMENT '处理时间',
  `result` text NULL COMMENT '结果',
  `status` char(30) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='队列表';

-- DROP TABLE IF EXISTS `zt_im_conference`;
CREATE TABLE IF NOT EXISTS `zt_im_conference` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `rid` char(40) NOT NULL DEFAULT '' COMMENT '房间号',
  `cgid` char(40) NOT NULL DEFAULT '' COMMENT '会话ID',
  `status` enum ('closed', 'open', 'notStarted', 'canceled') NOT NULL DEFAULT 'closed' COMMENT '状态',
  `participants` text NULL COMMENT '参与者',
  `subscribers` text NULL COMMENT '订阅者',
  `invitee` text NULL COMMENT '受邀者',
  `openedBy` mediumint(8) NOT NULL DEFAULT 0 COMMENT '发起者',
  `openedDate` datetime NULL COMMENT '发起时间',
  `topic` text NULL COMMENT '主题',
  `startTime` datetime NULL COMMENT '开始时间',
  `endTime` datetime NULL COMMENT '结束时间',
  `password` char(20) NOT NULL DEFAULT '' COMMENT '密码',
  `type` enum('default','periodic','scheduled') NOT NULL DEFAULT 'default' COMMENT '类型',
  `number` char(20) NOT NULL DEFAULT '' COMMENT '会议号',
  `note` text NULL COMMENT '备注',
  `sentNotify` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已通知',
  `reminderTime` int NOT NULL DEFAULT 0 COMMENT '提醒时间',
  `moderators` text NULL COMMENT '主持人',
  `isPrivate` enum ('0', '1') NOT NULL DEFAULT '0' COMMENT '是否私密',
  `isInner` enum('0', '1') NOT NULL DEFAULT '1' COMMENT '是否内部',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='会议表';
CREATE INDEX `idx_status` ON `zt_im_conference` (`status`);

-- DROP TABLE IF EXISTS `zt_im_conferenceaction`;
CREATE TABLE IF NOT EXISTS `zt_im_conferenceaction` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `rid` char(40) NOT NULL DEFAULT '' COMMENT '房间号',
  `type` enum('create','invite','join','leave','close','publish') NOT NULL DEFAULT 'create' COMMENT '动作类型',
  `data` text NULL COMMENT '数据',
  `user` mediumint(8) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `date` datetime NULL COMMENT '时间',
  `device` char(40) NOT NULL DEFAULT 'default' COMMENT '设备',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='会议动作表';

-- DROP TABLE IF EXISTS `zt_im_conferenceuser`;
CREATE TABLE IF NOT EXISTS `zt_im_conferenceuser` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `conference` mediumint(8) NOT NULL DEFAULT 0 COMMENT '会议ID',
  `user` mediumint(8) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `hide` enum('0', '1') NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='会议成员表';
CREATE UNIQUE INDEX `uk_conferenceuser` ON `zt_im_conferenceuser` (`conference`, `user`);

-- DROP TABLE IF EXISTS `zt_im_conferenceinvite`;
CREATE TABLE IF NOT EXISTS `zt_im_conferenceinvite` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `conferenceID` mediumint(8) unsigned NOT NULL COMMENT '会议ID',
  `inviteeID` mediumint(8) unsigned NOT NULL COMMENT '受邀人ID',
  `status` enum('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending' COMMENT '状态',
  `createdDate` datetime NULL COMMENT '创建时间',
  `updatedDate` datetime NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='会议邀请表';
CREATE UNIQUE INDEX `uk_conference_user` ON `zt_im_conferenceinvite` (`conferenceID`, `inviteeID`);

-- DROP TABLE IF EXISTS `zt_im_userdevice`;
CREATE TABLE IF NOT EXISTS `zt_im_userdevice` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'ID',
  `user` mediumint(8) NOT NULL DEFAULT 0 COMMENT '用户ID',
  `device` char(40) NOT NULL DEFAULT 'default' COMMENT '设备',
  `deviceID` char(40) NOT NULL DEFAULT '' COMMENT '设备ID',
  `token` char(64) NOT NULL DEFAULT '' COMMENT '令牌',
  `validUntil` datetime NULL COMMENT '有效期',
  `lastLogin` datetime NULL COMMENT '最后登录时间',
  `lastLogout` datetime NULL COMMENT '最后登出时间',
  `online` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否在线',
  `version` char(10) NOT NULL DEFAULT '' COMMENT '版本',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT='用户设备表';
CREATE INDEX `idx_user` ON `zt_im_userdevice` (`user`);
CREATE INDEX `idx_lastLogin` ON `zt_im_userdevice` (`lastLogin`);
CREATE INDEX `idx_lastLogout` ON `zt_im_userdevice` (`lastLogout`);
CREATE UNIQUE INDEX `uk_userdevice` ON `zt_im_userdevice` (`user`, `device`);

