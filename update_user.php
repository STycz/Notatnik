<?php
session_start();
include "config/config.php";
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the user ID from the form
  $userId = $_POST['user_id'];

  // Get the updated values from the form
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $mail = $_POST['mail'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Update the user record in the database
  $sql = "UPDATE user SET name=:name, surname=:surname, mail=:mail, username=:username, password=:password WHERE user_id=:userId";
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':name', $name);
  $statement->bindValue(':surname', $surname);
  $statement->bindValue(':mail', $mail);
  $statement->bindValue(':username', $username);
  $statement->bindValue(':password', $password);
  $statement->bindValue(':userId', $userId);
  
  if ($statement->execute()) {
    // Update successful
    header("Location: admin_panel_users.php");
    exit();
  } else {
    // Update failed
    echo "Failed to update user.";
  }
}
?>