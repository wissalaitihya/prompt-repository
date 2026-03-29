<?php
require_once '../includes/auth.php';
confirm_logged_in();
require_once '../config/db.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $user_id = $_SESSION['user_id'];
    
    try{
        $stmt = $pdo->prepare('INSERT INTO prompts(title, content, category_id, user_id) VALUES (?, ?, ?, ?)');
        $stmt->execute([$title, $content, $category_id, $user_id]);
        header('Location: dashboard.php');
        exit();
    }catch(PDOException $e){
        $error = "Error: " . $e->getMessage();
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

    main {
        animation: slideInUp 0.6s ease-out;
    }

    .form-container {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 8px 32px rgba(255, 107, 157, 0.1);
        border: 1px solid rgba(255, 107, 157, 0.2);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-title {
        font-size: 32px;
        font-weight: 800;
        background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 30px;
        text-align: center;
    }

    .main-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    label {
        font-size: 14px;
        font-weight: 700;
        color: #1a1a1a;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    input[type="text"],
    textarea,
    select {
        padding: 15px;
        border: 2px solid rgba(255, 107, 157, 0.2);
        border-radius: 10px;
        font-size: 15px;
        font-family: inherit;
        transition: all 0.3s ease;
        background: #f8f9fa;
        color: #1a1a1a;
    }

    input[type="text"]:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: #ff6b9d;
        background: white;
        box-shadow: 0 0 0 4px rgba(255, 107, 157, 0.1);
    }

    textarea {
        resize: vertical;
        min-height: 150px;
        line-height: 1.6;
    }

    input[type="text"]::placeholder,
    textarea::placeholder {
        color: #999;
    }

    button[type="submit"] {
        padding: 16px 32px;
        background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
        margin-top: 10px;
    }

    button[type="submit"]:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 107, 157, 0.4);
    }

    button[type="submit"]:active {
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 25px;
        }

        .form-title {
            font-size: 24px;
        }
    }
</style>

<main>
    <div class="form-container">
        <h1 class="form-title">Create New Prompt</h1>
        
        <form action="../controllers/promptController.php" method="POST" class="main-form">
            <div class="form-group">
                <label for="title">Prompt Title</label>
                <input type="text" id="title" name="title" placeholder="Enter an engaging prompt title" required>
            </div>

            <div class="form-group">
                <label for="content">Prompt Content</label>
                <textarea id="content" name="content" placeholder="Enter detailed prompt content. Be specific and clear for best results." required></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category_id" required>
                    <option value="">-- Select a category --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']) ?>">
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" name="add_prompt">✨ Create Prompt</button>
        </form>
    </div>
</main>

<?php include '../includes/footer.php'; ?>