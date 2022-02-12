# launchbox-to-json

Converts Launchbox database to JSON

1 - Download Launchbox Metadata zip: https://gamesdb.launchbox-app.com/Metadata.zip

2 - Open metadata.xml using Libreoffice

3 - Export games and media as CSV

4 - Create mySQL tables

    -- Create syntax for TABLE 'games'
    CREATE TABLE `games` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `Name` varchar(255) DEFAULT NULL,
    `ReleaseYear` longtext DEFAULT NULL,
    `Overview` longtext DEFAULT NULL,
    `MaxPlayers` varchar(255) DEFAULT NULL,
    `ReleaseType` varchar(255) DEFAULT NULL,
    `Cooperative` varchar(255) DEFAULT NULL,
    `VideoURL` varchar(255) DEFAULT NULL,
    `DatabaseID` varchar(255) DEFAULT NULL,
    `CommunityRating` varchar(255) DEFAULT NULL,
    `Platform` varchar(255) DEFAULT NULL,
    `ESRB` varchar(255) DEFAULT NULL,
    `CommunityRatingCount` varchar(255) DEFAULT NULL,
    `Genres` varchar(255) DEFAULT NULL,
    `Developer` varchar(255) DEFAULT NULL,
    `Publisher` varchar(255) DEFAULT NULL,
    `ReleaseDate` varchar(255) DEFAULT NULL,
    `WikipediaURL` varchar(255) DEFAULT NULL,
    `DOS` varchar(255) DEFAULT NULL,
    `StartupFile` varchar(255) DEFAULT NULL,
    `StartupMD5` varchar(255) DEFAULT NULL,
    `SetupFile` varchar(255) DEFAULT NULL,
    `SetupMD5` varchar(255) DEFAULT NULL,
    `StartupParameters` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=122777 DEFAULT CHARSET=utf8mb4;
    -- Create syntax for TABLE 'images_temp'
    CREATE TABLE `images_temp` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `DatabaseID` varchar(255) DEFAULT NULL,
    `filename` varchar(255) DEFAULT NULL,
    `type` varchar(255) DEFAULT NULL,
    `crc32` varchar(255) DEFAULT NULL,
    `region` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=785147 DEFAULT CHARSET=utf8mb4;
    -- Create syntax for TABLE 'images_temp2'
    CREATE TABLE `images_temp2` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `DatabaseID` varchar(255) DEFAULT NULL,
    `filename` varchar(255) DEFAULT NULL,
    `type` varchar(255) DEFAULT NULL,
    `region` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=262141 DEFAULT CHARSET=utf8mb4;
    -- Create syntax for TABLE 'images_temp3'
    CREATE TABLE `images_temp3` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `DatabaseID` varchar(255) DEFAULT NULL,
    `filename` varchar(255) DEFAULT NULL,
    `type` varchar(255) DEFAULT NULL,
    `region` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=131070 DEFAULT CHARSET=utf8mb4;

4 - Import CSV into those tables

5 - Execute clear_launchbox.sql ( It takes 20 minutes on an M1 Mac)

6 - Execute index.php and wait for the json files to generate.
