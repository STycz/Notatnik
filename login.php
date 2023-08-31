<?php
session_start();
include "config/config.php";
$pdo7 = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
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
        
        $pass=md5($pass);
        echo $uname;
        echo $pass;
        $sql = "SELECT * FROM user WHERE mail='$uname' AND password='$pass'";

        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            echo $row;
            if($row['mail'] === $uname && $row['password'] === $pass){
                $_SESSION['mail'] = $row['mail'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['user_id'];
                $user_id = $row['user_id']; // Assuming you have a variable to store the user's ID after login
                if ($row['isadmin'] == 1) {
                    $_SESSION['isadmin'] = 1;
                    header("Location: admin_panel_users.php");
                    exit();
                } else {
                    $query = "SELECT room_id FROM room WHERE user_id = :user_id";
                    $statement = $pdo7->prepare($query);
                    $statement->bindParam(':user_id', $user_id);
                    $statement->execute();

                    $result = $statement->fetch(PDO::FETCH_ASSOC);

                    if ($result) {
                        $_SESSION['room_id'] = $result['room_id'];
                    }

                    header("Location: create_room.php");
                    exit();
                }
            } else {
                header("Location: index.php?error=Zła nazwa użytkownika lub hasło.");
                exit();
            }
        } else {
            header("Location: index.php?error=Zła nazwa użytkownika lub hasło.");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}