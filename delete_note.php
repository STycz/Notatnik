<?php
session_start();
include "db_conn.php";

$pdo = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);

if (isset($_POST['delete_note'])) {
  $noteId = $_POST['delete_note'];

  $sql = "DELETE FROM notes WHERE notes_id = :noteId";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':noteId', $noteId);
  $statement->execute();

  // Send a response back to the client
  echo "Note deleted successfully";
}
?>