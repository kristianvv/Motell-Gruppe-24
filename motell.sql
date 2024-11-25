CREATE DATABASE IF NOT EXISTS `motell`;

USE `motell`;

CREATE TABLE IF NOT EXISTS `User` (
  `userID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) DEFAULT NULL
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
  FOREIGN KEY (`roomID`) REFERENCES `Rooms`(`roomID`)
  FOREIGN KEY (`userID`) REFERENCES `User`(`userID`)
);