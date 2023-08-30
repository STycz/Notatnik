<?php
session_start();
include "config/config.php";

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if (isset($_POST['delete_task'])) {
  $taskId = $_POST['delete_task'];

  $sql = "DELETE FROM task WHERE task_id = :taskId";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':taskId', $taskId);
  $statement->execute();

  // Send a response back to the client
  echo "Task deleted successfully";
}
?>