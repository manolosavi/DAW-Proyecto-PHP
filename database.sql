CREATE SCHEMA IF NOT EXISTS `login`;
USE `login`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTOINCREMENT,
  `username` varchar(32) NOT NULL,
  `hash` varchar(128) NOT NULL,
   PRIMARY KEY (`id`)
)
