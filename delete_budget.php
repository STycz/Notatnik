<?php
session_start();
include "config/config.php";

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

if (isset($_POST['delete_budget'])) {
  $budgetId = $_POST['delete_budget'];

  $sql = "DELETE FROM budget WHERE budget_id = :budgetId";
  $statement = $pdo->prepare($sql);
  $statement->bindParam(':budgetId', $budgetId);
  $statement->execute();

  // Send a response back to the client
  echo "Budget deleted successfully";
}
?>