<?php
session_start();

function confirm_logged_in(){
    if(!isset($_SESSION['user_id'])){
        header("Location: ../auth/login.php");
        exit();
    }
}


function confirm_admin(){
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../developer/dashboard.php");
        exit();
    }



}




?>