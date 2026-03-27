<?php
require_once '../config/db.php';
session_start();

if(isset($_POST['register'])){ //make sure the user clicked on the register buttom
$username=$_POST['username'];
$email=$_POST['email'];        //read what the user typed in the form 
$password=$_POST['password'];

    if(!empty($username) && !empty($email) && !empty($password)){
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); //hash the password for security

    $stmt=$pdo->prepare("INSERT INTO users(username,email,password,role) VALUES (?, ?, ?,'developer' )");
    $stmt->execute([$username, $email, $hashed_password]);
    header("Location: ../includes/login.php"); //redirect to login page after successful registration
    exit();
    }

}

if(isset($_POST['login'])){
$email = $_POST['email'];
$password = $_POST['password'];  //it pulls the text the user typed into the email and password boxes


$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(); //fetch the user data from the database

    if ($user && password_verify($password, $user['password'])) { //verify the password
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['username'] = $user['username']; 
        $_SESSION['role'] = $user['role']; 

            if($_SESSION['role'] === 'admin'){
            header("Location:../admin/dashboard.php");
            exit();
            } else{
            header("Location:../developer/dashboard.php");
            exit();
        }
    }
}
?>