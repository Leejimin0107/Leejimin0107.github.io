CREATE DATABASE amusement DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE amusement;

DROP TABLE IF EXISTS amusement;

CREATE TABLE amusement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(32) CHARACTER SET utf8mb4 NOT NULL,
    enter_child INT,
    enter_adult INT,
    big3_child INT,
    big3_adult INT,
    free_child INT,
    free_adult INT,
    year_child INT,
    year_adult INT,
    regdate DATETIME DEFAULT CURRENT_TIMESTAMP
);
