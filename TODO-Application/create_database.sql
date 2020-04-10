CREATE DATABASE todo;

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY (`username`)
);

CREATE TABLE `tasks` (
  `taskid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `task` varchar(100) NOT NULL,
  `done` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`taskid`),
  -- KEY `username_idx` (`username`),
  CONSTRAINT `username` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
);