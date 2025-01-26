DROP DATABASE IF EXISTS shuffle_lunch_service;
CREATE DATABASE IF NOT EXISTS shuffle_lunch_service;

USE shuffle_lunch_service;

DROP TABLE IF EXISTS
  id,
  name;

CREATE TABLE list_employees (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(100) NOT NULL
);

LOAD DATA
  INFILE '/var/lib/mysql-files/listEmployees.txt'

INTO TABLE
  list_employees
  FIELDS TERMINATED BY ' '
  LINES TERMINATED BY '\n'
  (@col1, @col2)

SET
  id = @col1,
  name = @col2;

UPDATE
  list_employees SET name = REPLACE(name, "'", "");
