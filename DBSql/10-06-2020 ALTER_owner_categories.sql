ALTER TABLE `owner_categories`
	ADD COLUMN `gender` TINYINT NOT NULL DEFAULT '0' COMMENT 'род: 0 - м.р., 1 - жен.р.' AFTER `name`;