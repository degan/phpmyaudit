CREATE TABLE `dictionary` (
      `hash` varchar(41) binary NOT NULL default '',
      `old_hash` varchar(16) binary NOT NULL default '',
      `entry` varchar(32) NOT NULL default '',
      PRIMARY KEY  (`hash`),
      UNIQUE KEY `entry` (`entry`)
      );
