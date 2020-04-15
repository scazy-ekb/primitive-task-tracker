CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL auto_increment,
    `login` varchar(250) NOT NULL UNIQUE,
    `email` varchar(250)  NOT NULL,
    `password` varchar(32)  NOT NULL,
    PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `tasks` (
    `id` int(11) NOT NULL auto_increment,
    `username` varchar(250) NOT NULL,
    `email` varchar(250) NOT NULL,
    `description` TEXT NOT NULL,
    `status` int(1) NOT NULL default false,
    PRIMARY KEY  (`id`)
);
