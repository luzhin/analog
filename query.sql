CREATE TABLE `analogs_source` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`k` VARCHAR(100) NULL DEFAULT NULL,
	`trash` VARCHAR(100) NULL DEFAULT NULL,
	`brand` VARCHAR(200) NULL DEFAULT NULL,
	`detail` VARCHAR(200) NULL DEFAULT NULL,
	INDEX `Индекс 1` (`id`)
)
COMMENT='Исходная таблица аналогов'
COLLATE='cp1251_general_ci'
ENGINE=InnoDB;

LOAD DATA LOCAL INFILE 'Z:\\home\\user\\Projects\\analog\\Analogs.txt' 
INTO TABLE `temp`.`analogs` 
CHARACTER SET cp1251 FIELDS TERMINATED BY '	' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\r\n' (`k`, `trash`, `brand`, `detail`);


CREATE TABLE `analogs_res` (
	`brand` VARCHAR(100) NULL DEFAULT NULL COMMENT 'бренд',
	`detail` VARCHAR(200) NULL DEFAULT NULL COMMENT 'номер запчасти',
	`brand_analog` VARCHAR(100) NULL DEFAULT NULL COMMENT 'бренд аналога',
	`detail_analog` VARCHAR(200) NULL DEFAULT NULL COMMENT 'номер запчасти замены'
)
COMMENT='Результирующая таблица аналогов'
COLLATE='cp1251_general_ci'
ENGINE=InnoDB;