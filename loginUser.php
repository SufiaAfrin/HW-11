<?php
session_start();
include "../database/env.php";


$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$errors = [];

if(empty($email)){
    $errors['email_error'] = "Email is required";
}
if(empty($password)){
    $errors['password_error'] = "Password is required";
}

if(count($errors) > 0){
    $_SESSION['form_errors'] = $errors;
    header("Location: ../backend/login.php");
}else{
   $query = "SELECT * FROM users WHERE email ='$email'";
   $result = mysqli_query($conn, $query);
   $user = mysqli_fetch_assoc($result);
   
   if(mysqli_num_rows($result) > 0){
    $isPasswordCorrect = password_verify($password, $user['password']);
    if($isPasswordCorrect){
        $_SESSION['auth'] = $user;
        header("Location: ../backend/index.php");
    }else{
        $errors['password_error'] = "Wrong password!";
        $_SESSION['form_errors'] = $errors;
        header("Location: ../backend/login.php");
    }

}else{
    $errors['email_error'] = "Wrong email!";
    $_SESSION['form_errors'] = $errors;
    header("Location: ../backend/login.php");
}
}

   
    
