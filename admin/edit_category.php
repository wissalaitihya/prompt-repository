<?php
require_once '../includes/auth.php';
confirm_admin();
require_once '../config/db.php';


if(!isset($_GET['id'])) {
    header('Location: manage_category.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$_GET['id']]);
$cat = $stmt->fetch();

// Check if category exists
if(!$cat) {
    header('Location: manage_category.php');
    exit();
}

// Handle update
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_category'])) {
    $name = $_POST['name'];
    $id = $_POST['id'];
    
    try {
        $stmt = $pdo->prepare('UPDATE categories SET name = ? WHERE id = ?');
        $stmt->execute([$name, $id]);
        header('Location: manage_category.php');
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

include '../includes/header.php';
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

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

main {
    display: flex;
    flex-direction: column;
    gap: 30px;
    animation: slideInUp 0.6s ease-out;
}

.admin-container {
    max-width: 600px;
    width: 100%;
}

/* Back Button */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(255, 107, 157, 0.1);
    color: #ff6b9d;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    margin-bottom: 30px;
    animation: slideInLeft 0.6s ease-out;
    border: 1px solid rgba(255, 107, 157, 0.2);
}

.btn-back:hover {
    background: rgba(255, 107, 157, 0.15);
    transform: translateX(-5px);
}

.btn-back::before {
    content: '←';
    font-size: 16px;
}

/* Header Section */
.admin-container h2 {
    font-size: 36px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    letter-spacing: -1px;
    margin-bottom: 10px;
    animation: slideInUp 0.6s ease-out 0.1s backwards;
}

.admin-container > p {
    font-size: 15px;
    color: #666;
    font-weight: 500;
    margin-bottom: 30px;
    animation: slideInUp 0.6s ease-out 0.2s backwards;
}

/* Form Card */
.main-form {
    background: white;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 8px 32px rgba(255, 107, 157, 0.1);
    border: 1px solid rgba(255, 107, 157, 0.2);
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out 0.3s backwards;
}

.main-form:hover {
    box-shadow: 0 12px 40px rgba(255, 107, 157, 0.15);
    border-color: rgba(255, 107, 157, 0.3);
}

/* Form Group */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 30px;
}

.form-group label {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a1a;
    display: flex;
    align-items: center;
}

.form-group label::after {
    content: '*';
    color: #ff6b9d;
    margin-left: 4px;
    font-weight: 900;
}

.form-group input {
    padding: 14px 16px;
    border: 2px solid rgba(255, 107, 157, 0.2);
    border-radius: 12px;
    font-size: 14px;
    font-family: inherit;
    transition: all 0.3s ease;
    background: white;
}

.form-group input:focus {
    outline: none;
    border-color: #ff6b9d;
    box-shadow: 0 0 0 4px rgba(255, 107, 157, 0.1);
    background: rgba(255, 107, 157, 0.02);
}

.form-group input::placeholder {
    color: #999;
}

/* Hidden Input */
input[type="hidden"] {
    display: none;
}

/* Button Group */
.button-group {
    display: flex;
    gap: 12px;
}

/* Submit Button */
.btn-submit {
    flex: 1;
    padding: 14px 28px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 24px rgba(255, 107, 157, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-submit::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(255, 107, 157, 0.4);
}

.btn-submit:hover::before {
    width: 300px;
    height: 300px;
}

.btn-submit:active {
    transform: translateY(-1px);
}

/* Cancel Button */
.btn-cancel {
    flex: 1;
    padding: 14px 28px;
    background: rgba(255, 107, 157, 0.1);
    color: #ff6b9d;
    border: 2px solid rgba(255, 107, 157, 0.3);
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-cancel:hover {
    background: rgba(255, 107, 157, 0.15);
    border-color: rgba(255, 107, 157, 0.5);
    transform: translateY(-2px);
}

.btn-cancel:active {
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    .admin-container {
        max-width: 100%;
        padding: 0 16px;
    }

    .admin-container h2 {
        font-size: 28px;
    }

    .admin-container > p {
        font-size: 14px;
    }

    .main-form {
        padding: 28px 20px;
    }

    .btn-submit,
    .btn-cancel {
        padding: 12px 24px;
        font-size: 14px;
    }

    .button-group {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .admin-container h2 {
        font-size: 24px;
    }

    .main-form {
        padding: 20px 16px;
    }

    .form-group {
        margin-bottom: 24px;
    }
}
</style>

<main>
    <div class="admin-container">
        <a href="manage_category.php" class="btn-back">Back to Categories</a>
        
        <h2>✏️ Edit Category</h2>
        <p>Update the category name and save your changes</p>
        
        <form  method="POST" class="main-form">
            <input type="hidden" name="id" value="<?= $cat['id'] ?>">
            
            <div class="form-group">
                <label for="name">Category Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?= htmlspecialchars($cat['name']) ?>" 
                    placeholder="Enter category name"
                    required
                >
            </div>
            
            <div class="button-group">
                <button type="submit" name="edit_category" class="btn-submit">💾 Update Category</button>
                <a href="manage_category.php" class="btn-cancel">✕ Cancel</a>
            </div>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>