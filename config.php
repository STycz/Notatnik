<?php
$host = "localhost";
$user = "root";
$password = "mamatata";
$dbname = "Notatnik";

// Create connection
$link = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
// echo "Connected successfully";

?>