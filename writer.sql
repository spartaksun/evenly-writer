CREATE TABLE `writer` (
`file_name` bigint( 20 ) unsigned NOT NULL AUTO_INCREMENT ,
`size` bigint( 20 ) NOT NULL ,
`folder` varchar( 255 ) NOT NULL ,
PRIMARY KEY ( `file_name` ) ,
KEY `idx__size` ( `size` ) ,
KEY `idx__folder_size` ( `folder` , `size` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8;