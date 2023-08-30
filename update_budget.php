<?php
// Start the session
session_start();
include "config/config.php";

// Create a new PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated values from the form
    $name = $_POST['name'];
    $date = $_POST['date'];
    $value = $_POST['value'];

    // Perform the database update
    $sql = "UPDATE budget SET name = :name, date = :date, value = :value WHERE budget_id = :id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':date', $date);
    $statement->bindValue(':value', $value);
    $statement->bindValue(':id', $_POST['id']);
    $statement->execute();

    // Redirect back to the budget page
    header("Location: budget.php");
    exit();
}
?>