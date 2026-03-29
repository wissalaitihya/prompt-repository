<?php
require_once '../config/db.php';
session_start();

if(isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
   header('Location:../developer/dashboard.php');
   exit();
}

$user=$_SESSION['user_id'];
$role=$_SESSION['role'];




if($id ===$_SESSION ['user_id']){
header('Location: ../admin/manage_user.php?error=self_delete');
exit();

}


$stmt= $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$_GET['delete_user_id']]);
header('Location: ../admin/manage_user.php?msg=deleted');
exit();



if(isset($_POST['update_role'])){
  $id = intval($_POST['user_id']);
  $new_role = $_POST['role'];

if(in_array($new_role, ['admin', 'developer'])){
   $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
   $stmt->execute([$new_role, $id]);
}

header('Location: ../admin/manage_user.php?msg=role_updated');
exit();
}






?>