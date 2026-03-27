<?php
session_start();
 if(isset($_SESSION['user_id'])){
   if(isset($_SESSSION ['role']) == 'admin'){
     header("Location:admin/dashboard.php");
    }else{
      header("Location: developer/dashboard.php");
   }
 } else{
    header("Location: login.php");
 }
 exit();


?>