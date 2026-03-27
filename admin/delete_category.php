<?php 
require_once '../includes/auth.php';
confirm_admin(); 
require_once '../config/db.php';
include '../includes/header.php';
?>

<div class="admin-container">
    <a href="manage_categories.php" class="btn-back">⬅ Back to list</a>
    <h2>Add a New Category</h2>
    <p>Create a theme to organize prompts (e.g., DevOps, UI/UX, Unit Testing).</p>
    <form action="../controllers/categoryController.php" method="POST" class="main-form">
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" id="name" name="name" placeholder="e.g., Mobile Development" required>
        </div>
        
        <button type="submit" name="add_category" class="btn-submit">Create Category</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>