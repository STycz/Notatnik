<?php
session_start();
include "config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $adminId = $_GET['admin_id'];
    $name = $_POST['name'];
    $surname = $_POST['nazwisko'];
    $mail = $_POST['uname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update the admin's data in the database
    $sql = "UPDATE user SET name = '$name', surname = '$surname', mail = '$mail', username = '$username', password = '$password' WHERE user_id = $adminId";
    $result = mysqli_query($link, $sql);

    if ($result) {
        // Data updated successfully
        header("Location: admin_panel_admins.php");
        exit();
    } else {
        // Error updating data
        echo "Error updating admin data: " . mysqli_error($link);
    }
}
?>