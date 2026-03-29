<?php

require_once '../includes/auth.php';
require_once '../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

confirm_admin();


$categoryId = isset($_GET['id']) ? intval($_GET['id']) : null;

// No ID provided
if (!$categoryId) {
    header('Location: manage_category.php');
    exit();
}


$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$categoryId]);
$category = $stmt->fetch();


if (!$category) {
    header('Location: manage_category.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {

    // Check if category is used by any prompts
    $check = $pdo->prepare("SELECT COUNT(*) FROM prompts WHERE category_id = ?");
    $check->execute([$categoryId]);

    if ($check->fetchColumn() > 0) {
        header('Location: manage_category.php?msg=in_use');
        exit();
    }

    
    $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$categoryId]);
    header('Location: manage_category.php?msg=deleted');
    exit();
}

include '../includes/header.php';
?>

<style>

</style>

<main>
    <div class="admin-container">
        <a href="manage_category.php" class="btn-back">Back to Categories</a>
        
        <h2>⚠️ Delete Category</h2>
        <p>This action cannot be undone. Please confirm carefully.</p>
        
        <div class="alert-card">
            <div class="alert-icon">🗑️</div>
            
            <div class="alert-message">
                <h3>Confirm Deletion</h3>
                <p>Are you sure you want to delete this category?</p>
                <div class="category-name">
                    📁 <?= htmlspecialchars($category['name']) ?>
                </div>
                <p style="margin-top: 12px; font-size: 12px; color: #999;">
                    This will permanently remove the category from the system.
                </p>
            </div>

            
            <form method="POST">
                <input type="hidden" name="confirm_delete" value="1">
                <div class="button-group">
                    <button type="submit" class="btn-delete">
                        🗑️ Delete Category
                    </button>
                    <a href="manage_category.php" class="btn-cancel">✕ Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>