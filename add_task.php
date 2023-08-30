<?php
session_start();
include "config/config.php";


// Prepare the SQL statement to insert a new task into the task table


// Get the form values from $_POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['nazwa'];
        $note = $_POST['notatka'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];
        $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
        $room_id = $_SESSION['room_id']; // Assuming the room_id is stored in the session
        try{
                // Create a new PDO instance
                $pdo6 = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
                $pdo6->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql9 = "INSERT INTO task (name, note, priority, deadline, user_id, room_id)
                VALUES (:name, :note, :priority, :deadline, :user_id, :room_id)";
                // Bind the parameters
                $statement = $pdo6->prepare($sql9);
                $statement->bindParam(':name', $name);
                $statement->bindParam(':note', $note);
                $statement->bindParam(':priority', $priority);
                $statement->bindParam(':deadline', $deadline);
                $statement->bindParam(':user_id', $user_id);
                $statement->bindParam(':room_id', $room_id);

                // Execute the SQL statement
                $statement->execute();

                // Redirect the user back to the original page after adding the task
                header('Location: tasks.php');
                exit();
        } catch (PDOException $e) {
                // Handle database error
                die("Error: " . $e->getMessage());
        }
}
?>