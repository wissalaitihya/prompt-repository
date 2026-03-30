<?php
require_once '../includes/auth.php'; 
confirm_admin();
require_once '../config/db.php';

// Get categories
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['confirm_delete'])){
        $C = $_POST['id'];
        try{
            $stmt= $pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$C]);
            header("Location: manage_category.php");
            exit();
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
    }
    
   
    if(isset($_POST['add_category'])){
        $name = $_POST["name"];
        try{
            $stmt= $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->execute([$name]);
            header("Location: manage_category.php");
            exit();
        }catch(PDOException $e){
            echo "Error: ". $e->getMessage();
        }
    }
}



include '../includes/header.php';
?>





<style>
:root {
    /* Couleurs */
    --color-primary: #4f46e5;
    --color-primary-dark: #4338ca;
    --color-primary-light: #6366f1;
    --color-secondary: #10b981;
    --color-danger: #ef4444;
    --color-background: #eef0f4;
    --color-dark: #0b1120;
    --color-gray-light: #f8fafc;
    --color-gray-border: #e2e8f0;
    --color-gray-text: #666666;
    
    /* Border Radius */
    --radius-sm: 6px;
    --radius-md: 10px;
    --radius-lg: 14px;
    --radius-xl: 18px;
    --radius-2xl: 24px;
    
    /* Shadows */
    --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.15);
}

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
}

.manage-header {
    display: flex;
    flex-direction: column;
    gap: 10px;
    animation: slideInUp 0.6s ease-out;
}

.manage-header h1 {
    font-size: 36px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    letter-spacing: -1px;
}

.manage-header > p {
    font-size: 16px;
    color: #666;
    font-weight: 500;
}

.add-category-card {
    background: white;
    border-radius: var(--radius-xl);
    padding: 30px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--color-gray-border);
    animation: slideInUp 0.7s ease-out 0.1s backwards;
}

.add-category-card h3 {
    font-size: 18px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.form-group input {
    flex: 1;
    min-width: 200px;
    padding: 12px 14px;
    border: 2px solid var(--color-gray-border);
    border-radius: var(--radius-lg);
    font-size: 14px;
    font-family: inherit;
    transition: all 0.3s ease;
}

.form-group input:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: var(--shadow-sm);
}

.form-group button {
    padding: 10px 20px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
    white-space: nowrap;
}

.form-group button:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.table-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--color-gray-border);
    overflow: hidden;
    animation: slideInUp 0.7s ease-out 0.2s backwards;
}

.table-card h3 {
    font-size: 18px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
    padding: 25px 30px 15px;
}

.table-card table {
    width: 100%;
    border-collapse: collapse;
}

.table-card thead {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white;
}

.table-card th {
    padding: 18px 20px;
    text-align: left;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-card td {
    padding: 18px 20px;
    border-bottom: 1px solid var(--color-gray-border);
    color: #333;
    font-size: 15px;
}

.table-card tbody tr {
    transition: all 0.3s ease;
}

.table-card tbody tr:hover {
    background: rgba(79, 70, 229, 0.05);
    transform: scale(1.01);
}

.table-card tbody tr:last-child td {
    border-bottom: none;
}

.btn-edit, .btn-delete {
    display: inline-block;
    padding: 6px 12px;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 11px;
    transition: all 0.3s ease;
    text-decoration: none;
    margin-right: 8px;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
    color: white;
    box-shadow: var(--shadow-sm);
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-delete {
    background: linear-gradient(135deg, var(--color-danger) 0%, #dc2626 100%);
    color: white;
    box-shadow: var(--shadow-sm);
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.empty-state {
    padding: 60px 30px;
    text-align: center;
}

.empty-state p {
    font-size: 16px;
    color: #999;
    font-weight: 500;
}

@media (max-width: 768px) {
    .manage-header h1 {
        font-size: 32px;
    }

    .form-group {
        flex-direction: column;
    }

    .form-group input {
        min-width: 100%;
    }

    .table-card th,
    .table-card td {
        padding: 12px 10px;
        font-size: 13px;
    }

    .table-card th {
        font-size: 12px;
    }

    .btn-edit, .btn-delete {
        padding: 6px 12px;
        font-size: 12px;
        margin-bottom: 4px;
    }
}
</style>

<main>
    <div class="manage-header">
        <h1>📁 Manage Categories</h1>
        <p>Create and manage content categories</p>
    </div>

    <!-- Add Category -->
    <div class="add-category-card">
        <h3>Add New Category</h3>
        <form  method="POST">
            <div class="form-group">
                <input type="text" name="name" placeholder="Enter category name" required>
                <button type="submit" name="add_category">+ Add Category</button>
            </div>
        </form>
    </div>

    <!-- Categories Table -->
    <div class="table-card">
        <h3>Categories List</h3>
        <?php if (count($categories) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $c) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($c['id']); ?></td>
                            <td><?php echo htmlspecialchars($c['name']); ?></td>
                            <td>
                                <a href="../admin/edit_category.php?id=<?php echo $c['id']; ?>" class="btn-edit">✏️ Edit</a>
                                <form  method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
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