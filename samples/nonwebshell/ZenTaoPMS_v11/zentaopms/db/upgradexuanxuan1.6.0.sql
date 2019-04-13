ALTER TABLE `zt_im_message` CHANGE `contentType` `contentType` ENUM('text', 'plain', 'emotion', 'image', 'file', 'object')  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT 'text';
