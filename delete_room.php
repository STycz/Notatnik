<?php
session_start();
include "db_conn.php";

$pdo = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);

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