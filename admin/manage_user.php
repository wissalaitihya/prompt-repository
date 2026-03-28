<?php 
require_once '../includes/auth.php';
confirm_admin();
require_once '../config/db.php';
include '../includes/header.php';

$users = $pdo->query("SELECT * FROM users ORDER BY role ASC")->fetchAll();
?>

<h2> Users Management</h2>

<table border="1" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['username'] ?></td>            <td><?= $user['username'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['role'] ?></td>
            <td>
                <?php if($user['id'] !=$_SESSION['user_id'] ): ?>
                <a href="../controllers/userController.php?selete_user_id=<?=$u['id'] ?>" style="color:red;">Supprimer</a>
                <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-delete">Delete</a>
            
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<?php include '../includes/footer.php';?>
?>