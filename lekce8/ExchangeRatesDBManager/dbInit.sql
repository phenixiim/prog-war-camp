CREATE DATABASE 'exchangeRates';

CREATE TABLE `exchangeRates` (
     `country` varchar(255) DEFAULT 'DEFAULT',
     `currency` varchar(255) DEFAULT NULL,
     `amount` int(11) DEFAULT NULL,
     `code` varchar(255) NOT NULL,
     `exchangeRateValue` varchar(255) DEFAULT NULL,
     PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


