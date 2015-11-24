CREATE SCHEMA IF NOT EXISTS `login`;
USE `login`;

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hash` varchar(100) NOT NULL,
   PRIMARY KEY (`username`)
)
