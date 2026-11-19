ALTER TABLE `zt_reqintakeHistory`
    MODIFY COLUMN `action` enum('start','close','reopen','accept') NOT NULL;
