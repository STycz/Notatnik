<?php
// Start the session
session_start();
include "config/config.php";
// Assuming you have established a connection to your MySQL database

// Create a new PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

// Prepare the SQL statement
$sql3 = "INSERT INTO room (room_name, user_id) VALUES (:roomName, :userId)";

// Bind the parameters
$statement = $pdo->prepare($sql3);
$statement->bindParam(':roomName', $_POST['nazwa_pokoju']);
$statement->bindParam(':userId', $_SESSION['user_id']);

// Execute the SQL statement
if ($statement->execute()) {
    $_SESSION['room_id'] = $pdo->lastInsertId();
    header('Location: create_room.php');
} else {
    echo "Error adding room: " . $statement->errorInfo()[2];
}

?>