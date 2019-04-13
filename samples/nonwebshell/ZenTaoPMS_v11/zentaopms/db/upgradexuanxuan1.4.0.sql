-- DROP TABLE IF EXISTS `zt_im_messagestatus`;
CREATE TABLE `zt_im_messagestatus` (
  `user` mediumint(8) NOT NULL DEFAULT 0,
  `gid` char(40) NOT NULL DEFAULT '',
  `status` enum('waiting','sent','readed','deleted') NOT NULL DEFAULT 'waiting',
  UNIQUE KEY `user` (`user`,`gid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `zt_im_message` CHANGE `type` `type` ENUM('normal','broadcast','notify') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'normal';
ALTER TABLE `zt_im_message` CHANGE `contentType` `contentType` ENUM('text','emotion','image','file','object')  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT 'text';
