CREATE TABLE `owner_categories` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	PRIMARY KEY (`id`)
)
COMMENT='собственник. категория'
ENGINE=InnoDB
;



INSERT INTO `journal`.`owner_categories` (`name`) VALUES ('собственник');
INSERT INTO `journal`.`owner_categories` (`name`) VALUES ('владелец');
INSERT INTO `journal`.`owner_categories` (`name`) VALUES ('хозяин');
INSERT INTO `journal`.`owner_categories` (`name`) VALUES ('хозяйка');