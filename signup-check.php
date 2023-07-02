<?php
session_start();
include "db_conn.php";
if (isset($_POST['name']) && isset($_POST['nazwisko']) 
    && isset($_POST['uname']) && isset($_POST['username']) && isset($_POST['password'])){
    
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $name = validate($_POST['name']);
    $pass = validate($_POST['password']);
    $nazwisko = validate($_POST['nazwisko']);
    $uname = validate($_POST['uname']);
    $username = validate($_POST['username']);

    $user_data = 'uname='. $uname. '&name='. $name;

    if(empty($name)){
        header("Location: signup.php?error=Imię jest wymagane&$user_data");
        exit();
    }elseif(empty($pass)){
        header("Location: signup.php?error=Hasło jest wymagane&$user_data");
        exit();
    }elseif(empty($nazwisko)){
        header("Location: signup.php?error=Nazwisko jest wymagane&$user_data");
        exit();
    }elseif(empty($uname)){
        header("Location: signup.php?error=E-mail jest wymagany&$user_data");
        exit();
    }elseif(empty($username)){
        header("Location: signup.php?error=Nazwa użytkownika jest wymagana&$user_data");
        exit();
    }else{
        //hashowanie hasła
        
        
        $sql = "SELECT * FROM user WHERE mail='$uname' ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0){
            header("Location: signup.php?error=Nazwa użytkownika jest już zajęta$user_data");
            exit();
        }else{
            $sql2 = "INSERT INTO user(username, mail, password, name, surname) VALUES('$username', '$uname', '$pass', '$name', '$nazwisko')";
            $result2 = mysqli_query($conn, $sql2);
            if($result2){
                header("Location: signup.php?success=Twoje konto zostało pomyślnie utworzone");
                exit();
            }else{
                header("Location: signup.php?error=Wystąpił nieznany błąd&$user_data");
                exit();
            }
        }
    }

}else{
    header("Location: signup.php");
    exit();
}