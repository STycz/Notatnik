<?php

$sname = "localhost";
$unmae = "2023_szymont";
$password = "392782";

$db_name = "2023_szymont";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if(!$conn){
    echo "Connection failed!";
}