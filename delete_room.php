<?php
session_start();
include "config/config.php";

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if (isset($_POST['delete_room'])) {
  $roomId = $_POST['delete_room'];

  $sql = "DELETE FROM room WHERE room_id = :roomId";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':roomId', $roomId);
  $statement->execute();

  // Send a response back to the client
  echo "Room deleted successfully";
}
?>