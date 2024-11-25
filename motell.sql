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
  `roomType` INT NOT NULL,
  `adults` INT NOT NULL,
  `children` INT NOT NULL
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


CREATE VIEW IF NOT EXISTS `RoomAvailability` AS SELECT