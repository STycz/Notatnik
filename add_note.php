<?php
session_start();
include "config/config.php";
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form values
    $title = $_POST['title'];
    $note = $_POST['note'];

    // Get the room_id from the session
    $room_id = $_SESSION['room_id'];

    // Insert the data into the notes table

    try {
        $pdo8 = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo8->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query2 = "INSERT INTO notes (title, note, room_id) VALUES (:title, :note, :room_id)";
        $statement = $pdo8->prepare($query2);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':note', $note);
        $statement->bindParam(':room_id', $room_id);
        $statement->execute();

        // Redirect to a success page or perform any other necessary actions
        header('Location: notes_room.php');
        exit();
    } catch (PDOException $e) {
        // Handle database error
        die("Error: " . $e->getMessage());
    }
}
?>