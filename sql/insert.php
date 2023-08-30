<?php
$pwd1 = md5("mamatata");
$pwd2 = md5("f5f3668df1211279c897");
$pwd3 = md5("86984bed8763ff454ed1");
$insert[] = "INSERT INTO `user` (`user_id`, `isadmin`, `username`, `mail`, `password`, `name`, `surname`) VALUES
(1, 1, 'tomczi', 'tomaszpyszczek@gmail.com', '$pwd1', 'Tomasz', 'Pyszczek'),
(2, 0, 'jkowal', 'jankowalski@gmail.com', '$pwd1', 'Jan', 'Kowalski'),
(3, 0, 'tomczi2', 'tomaszpyszczek@wp.pl', '$pwd2', 'Tomasz', 'Pyszczek'),
(4, 0, 'mklec', 'mklec@wp.pl', '$pwd3', 'Maciej', 'Kleczewski'),
(5, 0, 'kjon', 'kjon@wp.pl', '$pwd1', 'Kami', 'Jończyk');";
$insert[] .= "INSERT INTO `room` (`room_id`, `room_name`, `user_id`) VALUES
(4, 'Giga pokój', 1);";
$insert[] .= "INSERT INTO `budget` (`budget_id`, `name`, `value`, `date`, `room_id`) VALUES
(1, 'Mandat', -100, '2023-07-02', 4),
(2, 'Prezent od babci', 200, '2023-07-01', 4);";
$insert[] .= "INSERT INTO `notes` (`notes_id`, `title`, `note`, `room_id`) VALUES
(1, 'Super nota', 'Mega giga super nota.', 4),
(2, 'Super nota 2', 'Ala miała kota.', 4);";
$insert[] .= "INSERT INTO `task` (`task_id`, `name`, `isdone`, `note`, `priority`, `deadline`, `user_id`, `room_id`) VALUES
(1, 'Wyrzucić śmieci', 0, 'Wyrzuć śmieci gościu', 4, '2023-07-03 23:55:00', 1, 4),
(2, 'Pozmywać naczynia', 1, 'Pozmywaj gościu', 2, '2023-07-05 16:15:49', 1, 4);";
$insert[] .= "COMMIT;";
?>