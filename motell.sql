CREATE DATABASE IF NOT EXISTS `motell`;

USE `motell`;

CREATE TABLE IF NOT EXISTS `bruker` (
  `bruker_id` int(11) NOT NULL AUTO_INCREMENT,
  `passord_hash` varchar(255) NOT NULL,
  `navn` varchar(50) DEFAULT NULL,
  `epost` varchar(50) NOT NULL,
  `telefon` varchar(8) DEFAULT NULL,
  `dato_registrert` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bruker_id`)
);

CREATE TABLE IF NOT EXISTS `administrator` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `bruker_id` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`),
  CONSTRAINT `fk_bruker_admin` FOREIGN KEY (`bruker_id`) REFERENCES `bruker` (`bruker_id`)
);

CREATE TABLE IF NOT EXISTS `rom` (
  `rom_id` int(11) NOT NULL AUTO_INCREMENT,
  `romnummer` int(11) NOT NULL,
  `romtype` varchar(50) NOT NULL,
  `sengeplasser_voksen` int(11) NOT NULL,
  `sengeplasser_barn` int(11) NOT NULL,
  `etasje` int(11) NOT NULL,
  `nær_heis` boolean NOT NULL,
  `pris_per_natt` int(11) NOT NULL,
  PRIMARY KEY (`rom_id`)
);

CREATE TABLE IF NOT EXISTS `booking` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `bruker_id` int(11) NOT NULL,
  `rom_id` int(11) NOT NULL,
  `dato_inn` datetime NOT NULL,
  `dato_ut` datetime NOT NULL,
  `dato_opprettet` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`booking_id`),
  CONSTRAINT `fk_booking_bruker` FOREIGN KEY (`bruker_id`) REFERENCES `bruker` (`bruker_id`),
  CONSTRAINT `fk_booking_rom` FOREIGN KEY (`rom_id`) REFERENCES `rom` (`rom_id`)
);

CREATE TABLE IF NOT EXISTS `betaling` (
  `betaling_id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `dato_betalt` datetime NOT NULL,
  `beløp` int(11) NOT NULL,
  PRIMARY KEY (`betaling_id`),
  CONSTRAINT `fk_betaling_booking` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`)
);

CREATE TABLE IF NOT EXISTS `favoritt_rom` (
  `bruker_id` int(11) NOT NULL,
  `rom_id` int(11) NOT NULL,
  PRIMARY KEY (`bruker_id`, `rom_id`),
  CONSTRAINT `fk_favoritt_bruker` FOREIGN KEY (`bruker_id`) REFERENCES `bruker` (`bruker_id`),
  CONSTRAINT `fk_favoritt_rom` FOREIGN KEY (`rom_id`) REFERENCES `rom` (`rom_id`)
);

INSERT INTO `rom` (`rom_id`, `romnummer`, `romtype`, `sengeplasser_voksen`, `sengeplasser_barn`, `etasje`, `nær_heis`, `pris_per_natt`) 
VALUES 
(1, 101, 'Dobbeltrom', 2, 0, 1, 1, 1000),
(2, 102, 'Familierom', 2, 2, 1, 1, 1600),
(3, 103, 'Enkeltrom', 1, 0, 1, 1, 700),
(4, 104, 'Juniorsuite', 2, 2, 1, 1, 2400),
(5, 105, 'Dobbeltrom', 2, 0, 1, 1, 1000),
(6, 201, 'Dobbeltrom', 2, 2, 2, 1, 1600),
(7, 202, 'Familierom', 2, 2, 2, 1, 1600),
(8, 203, 'Enkeltrom', 1, 0, 2, 1, 700),
(9, 204, 'Juniorsuite', 2, 2, 2, 1, 2400),
(10, 205, 'Dobbeltrom', 2, 0, 2, 1, 1000),
(11, 301, 'Dobbeltrom', 2, 2, 3, 1, 1600),
(12, 302, 'Familierom', 2, 2, 3, 1, 1600),
(13, 303, 'Enkeltrom', 1, 0, 3, 1, 700),
(14, 304, 'Juniorsuite', 2, 2, 3, 1, 2400),
(15, 305, 'Dobbeltrom', 2, 0, 3, 1, 1000),
(16, 401, 'Dobbeltrom', 2, 2, 4, 1, 1600),
(17, 402, 'Familierom', 2, 2, 4, 1, 1600),
(18, 403, 'Enkeltrom', 1, 0, 4, 1, 700),
(19, 404, 'Juniorsuite', 2, 2, 4, 1, 2400),
(20, 405, 'Dobbeltrom', 2, 0, 4, 1, 1000),
(21, 501, 'Dobbeltrom', 2, 2, 5, 1, 1600),
(22, 502, 'Familierom', 2, 2, 5, 1, 1600),
(23, 503, 'Enkeltrom', 1, 0, 5, 1, 700),
(24, 504, 'Juniorsuite', 2, 2, 5, 1, 2400),
(25, 505, 'Dobbeltrom', 2, 0, 5, 1, 1000);
