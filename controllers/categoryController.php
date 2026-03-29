<?php
require_once '../config/db.php';
session_start();


if($_SESSION['role'] === 'admin'){
  header('Location: ../admin/dashboard.php');
  exit();
}

if($_POST['add_category']){
$name=htmlspecialchars($_POST['name']);
$stmt=$pdo->prepare("INSERT INTO categories (name) VALUES (?)");
$stmt->execute([$name]);
header('Location: ../admin/manage_category.php');
exit();
}

?>