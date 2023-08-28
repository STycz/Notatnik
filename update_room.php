<?php
session_start();
include "db_conn.php";

$pdo = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form data
  $roomId = $_POST['room_id'];
  $roomName = $_POST['room_name'];

  // Update the room's data in the database
  $sql = "UPDATE room SET room_name = :roomName WHERE room_id = :roomId";
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':roomName', $roomName);
  $statement->bindValue(':roomId', $roomId);

  // Execute the query
  $statement->execute();

  if ($statement->rowCount() > 0) {
    // Data updated successfully
    echo "Room updated successfully.";
  } else {
    // Error updating data
    echo "Error updating room.";
  }
}
?>