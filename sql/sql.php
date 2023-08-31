<?php 
$create[] = "CREATE TABLE `budget` (
    `budget_id` int(11) NOT NULL,
    `name` varchar(100) NOT NULL,
    `value` float NOT NULL,
    `date` varchar(50) DEFAULT NULL,
    `room_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
$create[] .= "CREATE TABLE `notes` (
    `notes_id` int(11) NOT NULL,
    `title` varchar(45) NOT NULL DEFAULT 'Title',
    `note` varchar(500) DEFAULT NULL,
    `room_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
$create[] .= "CREATE TABLE `room` (
    `room_id` int(11) NOT NULL,
    `room_name` varchar(45) DEFAULT 'Giga pokój',
    `user_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
$create[] .= "CREATE TABLE `task` (
    `task_id` int(11) NOT NULL,
    `name` varchar(45) NOT NULL,
    `isdone` tinyint(1) DEFAULT 0,
    `note` varchar(200) DEFAULT NULL,
    `priority` tinyint(5) DEFAULT NULL,
    `deadline` varchar(50) DEFAULT NULL,
    `user_id` int(11) NOT NULL,
    `room_id` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
$create[] .= "CREATE TABLE `user` (
    `user_id` int(11) NOT NULL,
    `isadmin` tinyint(1) NOT NULL DEFAULT 0,
    `username` varchar(45) NOT NULL,
    `mail` varchar(45) NOT NULL,
    `password` varchar(32) NOT NULL,
    `name` varchar(20) NOT NULL,
    `surname` varchar(25) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

$create[] .= "ALTER TABLE `budget`
ADD PRIMARY KEY (`budget_id`),
ADD KEY `room_id` (`room_id`);";
$create[] .= "ALTER TABLE `notes`
ADD PRIMARY KEY (`notes_id`),
ADD KEY `room_id` (`room_id`);";
$create[] .= "ALTER TABLE `room`
ADD PRIMARY KEY (`room_id`),
ADD KEY `user_id` (`user_id`);";
$create[] .= "ALTER TABLE `task`
ADD PRIMARY KEY (`task_id`),
ADD KEY `user_id` (`user_id`),
ADD KEY `room_id` (`room_id`);";
$create[] .= "ALTER TABLE `user`
ADD PRIMARY KEY (`user_id`);";
$create[] .= "ALTER TABLE `budget`
MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT;";
$create[] .= "ALTER TABLE `notes`
MODIFY `notes_id` int(11) NOT NULL AUTO_INCREMENT;";
$create[] .= "ALTER TABLE `room`
MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;";
$create[] .= "ALTER TABLE `task`
MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;";
$create[] .= "ALTER TABLE `user`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;";
$create[] .= "ALTER TABLE `budget`
ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);";
$create[] .= "ALTER TABLE `notes`
ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);";
$create[] .= "ALTER TABLE `room`
ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);";
$create[] .= "ALTER TABLE `task`
ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);";
$create[] .= "COMMIT;";
?> 