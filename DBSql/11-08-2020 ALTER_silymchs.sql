ALTER TABLE `silymchs`
	ADD COLUMN `status_teh` INT NULL DEFAULT '0' COMMENT 'статус техники на момент выезда (из строевой): 1-бр,2-резерв, 3-ремонт, 4-ТО-1, 5-ТО-2' AFTER `mark`;