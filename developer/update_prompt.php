<?php
require_once('../includes/auth.php');
confirm_logged_in();
require_once '../config/db.php';
include '../includes/header.php';

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM prompts WHERE id = ?");
$stmt->execute([$id]);
$prompt = $stmt->fetch();

if($prompt['user_id'] !== $_SESSION['user_id'] && $_SESSION['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
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
    animation: slideInUp 0.6s ease-out;
}

.prompt-container {
    max-width: 700px;
    margin: 0 auto;
    width: 100%;
}

.prompt-container h2 {
    font-size: 32px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    letter-spacing: -1px;
    margin-bottom: 30px;
    animation: slideInUp 0.6s ease-out 0.1s backwards;
}

.form-card {
    background: white;
    border-radius: var(--radius-xl);
    padding: 40px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--color-gray-border);
    transition: all 0.3s ease;
    animation: slideInUp 0.6s ease-out 0.2s backwards;
}

.form-card:hover {
    box-shadow: var(--shadow-xl);
    border-color: rgba(79, 70, 229, 0.2);
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 25px;
}

.form-group label {
    font-size: 14px;
    font-weight: 700;
    color: #1a1a1a;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-group label::after {
    content: '*';
    color: var(--color-primary);
    margin-left: 4px;
}

.form-group input,
.form-group textarea,
.form-group select {
    padding: 12px 14px;
    border: 2px solid var(--color-gray-border);
    border-radius: var(--radius-lg);
    font-size: 14px;
    font-family: inherit;
    transition: all 0.3s ease;
    background: var(--color-gray-light);
    color: #1a1a1a;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--color-primary);
    background: white;
    box-shadow: var(--shadow-sm);
}

.form-group textarea {
    resize: vertical;
    min-height: 180px;
    line-height: 1.6;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #999;
}

.button-group {
    display: flex;
    gap: 12px;
    margin-top: 30px;
}

.btn-submit {
    flex: 1;
    padding: 12px 24px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--shadow-md);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-submit:active {
    transform: translateY(-1px);
}

.btn-cancel {
    flex: 1;
    padding: 12px 24px;
    background: rgba(79, 70, 229, 0.1);
    color: var(--color-primary);
    border: 2px solid rgba(79, 70, 229, 0.3);
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-cancel:hover {
    background: rgba(79, 70, 229, 0.15);
    border-color: rgba(79, 70, 229, 0.5);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .prompt-container {
        padding: 0 16px;
    }

    .prompt-container h2 {
        font-size: 28px;
    }

    .form-card {
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

    .form-group textarea {
        min-height: 140px;
    }
}
</style>

<main>
    <div class="prompt-container">
        <h2>✏️ Update Prompt</h2>

        <div class="form-card">
            <form action="../controllers/promptController.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $prompt['id']; ?>">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($prompt['title']); ?>" placeholder="Enter prompt title" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category_id" required>
                        <option value="">-- Select a category --</option>
                        <?php foreach ($categories as $c): ?>
                            <option value="<?php echo $c['id']; ?>" <?php echo $c['id'] == $prompt['category_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($c['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content" name="content" placeholder="Enter detailed prompt content" required><?php echo htmlspecialchars($prompt['content']); ?></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" name="edit_prompt" class="btn-submit">💾 Update</button>
                    <a href="dashboard.php" class="btn-cancel">✕ Cancel</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>


