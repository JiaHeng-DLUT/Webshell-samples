ALTER TABLE `zt_file` CHANGE `pathname` `pathname` char(100) NOT NULL;

TRUNCATE `zt_im_usermessage`;

ALTER TABLE `zt_im_usermessage` DROP `module`;
ALTER TABLE `zt_im_usermessage` DROP `method`;
ALTER TABLE `zt_im_usermessage` CHANGE `data` `message` text not null;

DROP TABLE IF EXISTS `zt_im_chatfile`;
