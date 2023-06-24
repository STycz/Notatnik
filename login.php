<?php
session_start();
include "db_conn.php";
if (isset($_POST['uname']) && isset($_POST['password'])){
    
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if(empty($uname)){
        header("Location: index.php?error=User Name is required");
        exit();
    }elseif(empty($pass)){
        header("Location: index.php?error=Password is required");
        exit();
    }else{
        $sql = "SELECT * FROM user WHERE mail='$uname' AND password='$pass'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if($row['mail'] === $uname && $row['password'] === $pass){
                $_SESSION['mail'] = $row['mail'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: create_room.php");
                exit();
            }else{
                header("Location: index.php?error=Zła nazwa użytkownika lub hasło.");
                exit();
            }
        }else{
            header("Location: index.php?error=Zła nazwa użytkownika lub hasło.");
            exit();
        }
    }
}
else{
    header("Location: index.php");
    exit();
}