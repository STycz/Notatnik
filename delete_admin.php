<?php
session_start();
include "db_conn.php";

$pdo = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);

if (isset($_POST['delete_admin'])) {
  $userId = $_POST['delete_admin'];

  $sql = "DELETE FROM user WHERE user_id = :userId";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':userId', $userId);
  $statement->execute();

  // Send a response back to the client
  echo "Admin deleted successfully";
}
?>