<?php
session_start();
include "db_conn.php";
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form values
    $name = $_POST['name'];
    $value = $_POST['value'];
    $date = $_POST['date'];

    // Get the room_id from the session
    $room_id = $_SESSION['room_id'];

    try {
        $pdo9 = new PDO("mysql:host=$sname;dbname=$db_name", $unmae, $password);
        $pdo9->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query3 = "INSERT INTO budget (name, value, date, room_id) VALUES (:name, :value, :date, :room_id)";
        $statement = $pdo9->prepare($query3);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':value', $value);
        $statement->bindParam(':date', $date);
        $statement->bindParam(':room_id', $room_id);
        $statement->execute();

        // Redirect to a success page or perform any other necessary actions
        header('Location: budget.php');
        exit();
    } catch (PDOException $e) {
        // Handle database error
        die("Error: " . $e->getMessage());
    }
}
?>