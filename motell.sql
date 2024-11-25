CREATE DATABASE IF NOT EXISTS `motell`;

USE `motell`;

CREATE TABLE IF NOT EXISTS `User` (
  `userID` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) DEFAULT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(10) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS `Rooms` (
  `roomID` INT AUTO_INCREMENT PRIMARY KEY,
  `roomType` VARCHAR(50) NOT NULL,
  `adults` INT NOT NULL,
  `children` INT NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS `Booking` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `checkInDate` DATE NOT NULL,
  `checkOutDate` DATE NOT NULL,
  `createdAt` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `roomID` INT NOT NULL,
  `userID` INT NOT NULL,
  FOREIGN KEY (`roomID`) REFERENCES `Rooms`(`roomID`),
  FOREIGN KEY (`userID`) REFERENCES `User`(`userID`)
);

INSERT INTO `Rooms` (`roomType`, `adults`, `children`)
  VALUES
  ('Enkeltrom', 1, 0),
  ('Enkeltrom', 1, 0),
  ('Enkeltrom', 1, 0),
  ('Enkeltrom', 1, 0),
  ('Enkeltrom', 1, 0),
  ('Enkeltrom', 1, 0),
  ('Enkeltrom', 1, 0),
  ('Enkeltrom', 1, 0),
  ('Enkeltrom', 1, 0),
  ('Enkeltrom', 1, 0),
  ('Dobbeltrom', 2, 2),
  ('Dobbeltrom', 2, 2),
  ('Dobbeltrom', 2, 2),
  ('Dobbeltrom', 2, 2),
  ('Dobbeltrom', 2, 2),
  ('Dobbeltrom', 2, 2),
  ('Dobbeltrom', 2, 2),
  ('Dobbeltrom', 2, 2),
  ('Dobbeltrom', 2, 2),
  ('Dobbeltrom', 2, 2),
  ('Juniorsuite', 4, 4),
  ('Juniorsuite', 4, 4),
  ('Juniorsuite', 4, 4),
  ('Juniorsuite', 4, 4),
  ('Juniorsuite', 4, 4);

ALTER TABLE 'Rooms' ADD COLUMN 'price' INT NOT NULL DEFAULT 0;
ALTER TABLE 'Rooms' WHERE 'roomType' = 'Enkeltrom' SET 'price' = 500;
ALTER TABLE 'Rooms' WHERE 'roomType' = 'Dobbeltrom' SET 'price' = 1000;
ALTER TABLE 'Rooms' WHERE 'roomType' = 'Juniorsuite' SET 'price' = 2000;
