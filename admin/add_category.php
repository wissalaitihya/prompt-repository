<?php
require_once '../includes/auth.php';
confirm_admin();
require_once '../config/db.php';
require_once '../includes/header.php';
?>


<div class="admin_container">
   <a href="manage_categories.php"  class="btn-back">Return to Category</a>
<h2>Add a new category </h2>
<p>Create  a theme to organize the prompts (Ex: Web Development, CyberSecurity, Data Science)</p>
<form action="../controllers/categoryController.php" method="POST" class="main-form">
    <div class="form-group">
    <label for="category_name">Category Name:</label>
    <input type="text" id="category_name" name="category_name" required>
    </div>
    <button type="submit" name="add_category" class="btn-submit">Add Category</button>
</form>
</div>

<?php include '../includes/footer.php'; ?>





?>