<?php
ob_start(); // 1. Fixes the "Headers already sent" error!
require_once '../includes/auth.php'; 
confirm_admin();
require_once '../config/db.php';
include '../includes/header.php';

// Get categories
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<style>
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

main {
    display: flex;
    flex-direction: column;
    gap: 30px;
    animation: slideInUp 0.6s ease-out;
}

.manage-header {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.manage-header h2 {
    font-size: 36px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    letter-spacing: -1px;
    animation: slideInUp 0.6s ease-out 0.1s backwards;
}

/* Add Category Form */
.add-category-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(255, 107, 157, 0.1);
    border: 1px solid rgba(255, 107, 157, 0.2);
    animation: slideInUp 0.6s ease-out 0.1s backwards;
    transition: all 0.3s ease;
}

.add-category-card:hover {
    box-shadow: 0 12px 40px rgba(255, 107, 157, 0.15);
    border-color: rgba(255, 107, 157, 0.3);
}

.add-category-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    gap: 12px;
    align-items: flex-end;
}

.form-group input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid rgba(255, 107, 157, 0.2);
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    transition: all 0.3s ease;
    background: white;
}

.form-group input:focus {
    outline: none;
    border-color: #ff6b9d;
    box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.1);
    background: rgba(255, 107, 157, 0.02);
}

.form-group input::placeholder {
    color: #999;
}

.form-group button {
    padding: 12px 28px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
    white-space: nowrap;
    position: relative;
    overflow: hidden;
}

.form-group button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 157, 0.4);
}

/* Categories Table */
.table-card {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(255, 107, 157, 0.1);
    border: 1px solid rgba(255, 107, 157, 0.2);
    overflow: hidden;
    animation: slideInUp 0.6s ease-out 0.2s backwards;
    transition: all 0.3s ease;
}

.table-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

table thead {
    background: linear-gradient(135deg, rgba(255, 107, 157, 0.05) 0%, rgba(195, 74, 123, 0.05) 100%);
    border-bottom: 2px solid rgba(255, 107, 157, 0.2);
}

table th {
    padding: 16px 12px;
    text-align: left;
    font-weight: 700;
    color: #1a1a1a;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

table tbody tr {
    border-bottom: 1px solid rgba(255, 107, 157, 0.1);
    transition: all 0.3s ease;
}

table tbody tr:hover {
    background: rgba(255, 107, 157, 0.05);
}

table td {
    padding: 16px 12px;
    color: #333;
    font-size: 14px;
}

.btn-edit {
    display: inline-block;
    padding: 8px 16px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(255, 107, 157, 0.25);
}

.btn-delete {
    background: none;
    border: none;
    color: #c34a7b;
    cursor: pointer;
    font-weight: 600;
    font-size: 13px;
    margin-left: 10px;
}

.btn-delete:hover {
    text-decoration: underline;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #999;
}

/* Responsive */
@media (max-width: 768px) {
    .manage-header h2 { font-size: 28px; }
    .form-group { flex-direction: column; align-items: stretch; }
    .form-group button { width: 100%; }
    .add-category-card, .table-card { padding: 20px; }
    table th, table td { padding: 12px 8px; font-size: 12px; }
    .btn-edit { padding: 6px 12px; font-size: 12px; }
}
</style>

<main>
    <div class="manage-header">
        <h2>📁 Manage Categories</h2>
    </div>

    <div class="add-category-card">
        <h3>Add New Category</h3>
        <form action="../controllers/categoryController.php" method="POST">
            <div class="form-group">
                <input type="text" name="name" placeholder="Enter category name" required>
                <button type="submit" name="add_category">+ Add</button>
            </div>
        </form>
    </div>

    <div class="table-card">
        <h3>Categories List</h3>
        <?php if (count($categories) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th> <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1; // 2. Start a clean counter variable at 1
                    foreach ($categories as $c) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td> 
                            <td><?php echo htmlspecialchars($c['name']); ?></td>
                            <td>
                                <a href="../admin/edit_category.php?id=<?php echo $c['id']; ?>" class="btn-edit">✏️ Edit</a>
                                
                                <form action="../controllers/categoryController.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                                    <button type="submit" name="confirm_delete" class="btn-delete">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="empty-state">
                <p>No categories found. Create one to get started!</p>
            </div>
        <?php } ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>