<?php
session_start();
include "config/config.php";

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if (isset($_POST['delete_user'])) {
  $userId = $_POST['delete_user'];

  $sql = "DELETE FROM user WHERE user_id = :userId";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':userId', $userId);
  $statement->execute();

  // Send a response back to the client
  echo "User deleted successfully";
}
?>