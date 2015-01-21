--
-- MySQL 5.5.34
-- Wed, 21 Jan 2015 22:54:30 +0000
--

CREATE TABLE `games` (
   `id` int(10) not null auto_increment,
   `ownerid` int(10),
   `createdat` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `name` varchar(255) default ' ',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=373;


CREATE TABLE `gamescores` (
   `id` int(10) not null auto_increment,
   `gameid` int(10),
   `ownerid` int(10),
   `score` int(10),
   PRIMARY KEY (`id`),
   UNIQUE KEY (`gameid`,`ownerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;


CREATE TABLE `minigames` (
   `id` int(10) not null auto_increment,
   `gameid` int(10),
   `createdat` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `type` varchar(255),
   PRIMARY KEY (`id`),
   KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=619;


CREATE TABLE `minigamescores` (
   `id` int(10) not null auto_increment,
   `minigameid` int(10),
   `ownerid` int(10),
   `createdat` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `score` int(10),
   PRIMARY KEY (`id`),
   UNIQUE KEY (`minigameid`,`ownerid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=297;


CREATE TABLE `sessions` (
   `userid` int(10),
   `sessionid` varchar(255),
   `settings` longtext,
   `updated_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   UNIQUE KEY (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `users` (
   `id` int(10) not null auto_increment,
   `displayname` varchar(255),
   `username` varchar(255),
   `config` longtext,
   `stats` longtext,
   `created_at` timestamp not null default '0000-00-00 00:00:00',
   `updated_at` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   `password` varchar(255),
   `salt` varchar(255),
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=25;