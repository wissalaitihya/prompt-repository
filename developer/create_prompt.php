<?php
// ✅ Auth AVANT tout
require_once '../includes/auth.php';
confirm_logged_in();
require_once '../config/db.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

// ✅ Le formulaire envoie ici directement (action="create_prompt.php")
// L'insertion se fait ICI seulement — plus de double INSERT avec promptController
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title       = trim($_POST['title']);
    $content     = trim($_POST['content']);
    $category_id = intval($_POST['category_id']);
    $user_id     = $_SESSION['user_id'];

    if (!empty($title) && !empty($content)) {
        try {
            $stmt = $pdo->prepare('INSERT INTO prompts(title, content, category_id, user_id) VALUES (?, ?, ?, ?)');
            $stmt->execute([$title, $content, $category_id, $user_id]);
            header('Location: dashboard.php?msg=added');
            exit();
        } catch (PDOException $e) {
            $error = "Erreur : " . $e->getMessage();
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
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
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}

main { animation: slideInUp 0.6s ease-out; }

.form-container {
    background: white; border-radius: var(--radius-xl); padding: 40px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--color-gray-border);
    max-width: 600px; margin: 0 auto;
}

.form-title {
    font-size: 28px; font-weight: 800;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    margin-bottom: 30px; text-align: center;
}

.main-form { display: flex; flex-direction: column; gap: 20px; }
.form-group { display: flex; flex-direction: column; gap: 8px; }

label { font-size: 14px; font-weight: 700; color: #1a1a1a; text-transform: uppercase; letter-spacing: 0.5px; }

input[type="text"], textarea, select {
    padding: 14px 12px; border: 2px solid var(--color-gray-border);
    border-radius: var(--radius-lg); font-size: 14px; font-family: inherit;
    transition: all 0.3s ease; background: var(--color-gray-light); color: #1a1a1a;
}

input[type="text"]:focus, textarea:focus, select:focus {
    outline: none; border-color: var(--color-primary); background: white;
    box-shadow: var(--shadow-sm);
}

textarea { resize: vertical; min-height: 150px; line-height: 1.6; }

.error-msg {
    background: #ffe0e0; color: #c0392b; padding: 12px 16px;
    border-radius: 8px; font-size: 14px; font-weight: 600;
    border: 1px solid #ffb3b3;
}

button[type="submit"] {
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white; border: none; border-radius: var(--radius-md);
    font-size: 14px; font-weight: 700; text-transform: uppercase;
    cursor: pointer; transition: all 0.3s ease;
    box-shadow: var(--shadow-md); margin-top: 10px;
}

button[type="submit"]:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
</style>

<main>
    <div class="form-container">
        <h1 class="form-title">✨ Create New Prompt</h1>

        <?php if (!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- ✅ action="create_prompt.php" — plus de double INSERT -->
        <form action="create_prompt.php" method="POST" class="main-form">
            <div class="form-group">
                <label for="title">Prompt Title</label>
                <input type="text" id="title" name="title" placeholder="Enter an engaging prompt title" required>
            </div>

            <div class="form-group">
                <label for="content">Prompt Content</label>
                <textarea id="content" name="content" placeholder="Enter detailed prompt content." required></textarea>
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