<?php
require_once '../includes/auth.php';
confirm_admin(); // Only admin can access
require_once '../config/db.php';

// Get categories
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<h2>Manage Categories</h2>
<!-- Add Category -->
<form action="../controllers/categoryController.php" method="POST">
    <input type="text" name="name" placeholder="Category name" required>
    <button type="submit" name="add_category">Add</button>
</form>

<br>


<table border="1">  <!-- Categories Table -->
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Action</th>
    </tr>

    <?php foreach ($categories as $c) { ?>
        <tr>
            <td><?php echo htmlspecialchars($c['id']); ?></td>
            <td><?php echo htmlspecialchars($c['name']); ?></td>
            <td>
                <a href="edit_category.php?id=<?php echo $c['id']; ?>">Edit</a>
            </td>
        </tr>
    <?php } ?>

</table>