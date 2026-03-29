<?php
require_once '../config/db.php';
session_start();

if(isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
   header('Location:../developer/dashboard.php');
   exit();
}

$user=$_SESSION['user_id'];
$role=$_SESSION['role'];

if(isset($_POST['delete_user_id'])){
 $id = intval($_POST['delete_user_id']);
}









?>