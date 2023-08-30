<?php
// update_task.php
session_start();
include "config/config.php";

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $taskId = $_POST['task_id'];
    $nazwa = $_POST['nazwa'];
    $note = $_POST['notatka'];
    $deadline = $_POST['deadline'];
    $priority = $_POST['priority'];

    // Prepare and execute the UPDATE query
    $sql = "UPDATE task SET name=?, note=?, deadline=?, priority=? WHERE task_id=?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('ssssi', $nazwa, $note, $deadline, $priority, $taskId);

    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            // Update successful
            $_SESSION['success_message'] = 'Task updated successfully.';
            header('Location: tasks.php');
            exit();
            
        } else {
            // No rows were affected
            $_SESSION['error_message'] = 'No rows were affected by the update.';
        }
    } else {
        // Update failed
        $_SESSION['error_message'] = 'Failed to execute the update query. Error: ' . $stmt->error;
    }
    
    // Close the statement
    $stmt->close();
    // Redirect to tasks.php 
    header('Location: tasks.php');
    exit();
    
}
?>