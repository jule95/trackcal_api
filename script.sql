-- server config
SET default_storage_engine = innodb;
SET sql_safe_updates = 0;

-- table config

ALTER TABLE meal AUTO_INCREMENT = 1;

-- creating database
DROP DATABASE IF EXISTS trackcal;

CREATE DATABASE trackcal
    CHARACTER SET LATIN1
    COLLATE LATIN1_GERMAN2_CI;

-- select database
USE trackcal;

-- create tables
DROP TABLE IF EXISTS meal;

CREATE TABLE meal (
                      id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                      name VARCHAR(32) NOT NULL,
                      calories INT UNSIGNED NOT NULL
);

-- test data
INSERT INTO meal (name, calories)
VALUES("Burger", 800);

INSERT INTO meal (name, calories)
VALUES("Pizza", 700);

INSERT INTO meal (name, calories)
VALUES("Steak", 1000);

INSERT INTO meal (name, calories)
VALUES("Ham & Eggs", 400);

INSERT INTO meal (name, calories)
VALUES("Chicken", 900);

-- validate

SELECT * FROM meal;