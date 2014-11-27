CREATE TABLE `analogs_source` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`k` VARCHAR(100) NULL DEFAULT NULL,
	`trash` VARCHAR(100) NULL DEFAULT NULL,
	`brand` VARCHAR(200) NULL DEFAULT NULL,
	`detail` VARCHAR(200) NULL DEFAULT NULL,
	INDEX `Индекс 1` (`id`)
)
COMMENT='Исходная таблица аналогов'
COLLATE='utf8_general_ci';

ALTER TABLE `analogs_source` ADD INDEX `Индекс 2` (`k`);

CREATE TABLE `analogue_orig` (
 `ArticalNum` VARCHAR(25) NOT NULL DEFAULT '',
 `ArticalBrand` VARCHAR(50) NOT NULL DEFAULT '',
 `Analogue` VARCHAR(25) NOT NULL DEFAULT '',
 `Brand` VARCHAR(50) NOT NULL DEFAULT '',
 UNIQUE INDEX `ArticalNum` (`ArticalNum`, `ArticalBrand`, `Analogue`, `Brand`),
 INDEX `ArticalBrand` (`ArticalBrand`),
 INDEX `Analogue` (`Analogue`),
 INDEX `Brand` (`Brand`)
)
COMMENT='Результирующая таблица аналогов'
COLLATE='utf8_general_ci'
ENGINE=MyISAM;


LOAD DATA LOCAL INFILE 'Z:\\home\\user\\Projects\\analog\\Analogs_utf8.txt' 
INTO TABLE `temp_utf8`.`analogs_source` 
CHARACTER SET utf8 FIELDS TERMINATED BY '	' OPTIONALLY ENCLOSED BY '"' ESCAPED BY '"' LINES TERMINATED BY '\r\n' (`k`, `trash`, `brand`, `detail`);

CREATE USER 'vlad'@'%' IDENTIFIED BY 'Ygh23%cDnF2&kU';
GRANT EXECUTE, PROCESS, SELECT, SHOW DATABASES, SHOW VIEW, ALTER, ALTER ROUTINE, CREATE, CREATE ROUTINE, CREATE TABLESPACE, CREATE TEMPORARY TABLES, 
  CREATE VIEW, DELETE, DROP, EVENT, INDEX, INSERT, REFERENCES, TRIGGER, UPDATE, CREATE USER, FILE, LOCK TABLES, RELOAD, REPLICATION CLIENT, REPLICATION SLAVE, 
  SHUTDOWN, SUPER  ON *.* TO 'vlad'@'%' WITH GRANT OPTION;