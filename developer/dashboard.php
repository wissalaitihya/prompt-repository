<?php
// ✅ Auth et BDD AVANT le header
require_once '../includes/auth.php';
confirm_logged_in();
require_once '../config/db.php';

$user_id = $_SESSION['user_id'];

// ✅ Vraies données depuis la BDD
$myPromptsCount = $pdo->prepare("SELECT COUNT(*) FROM prompts WHERE user_id = ?");
$myPromptsCount->execute([$user_id]);
$myPromptsCount = $myPromptsCount->fetchColumn();

$totalPromptsCount = $pdo->query("SELECT COUNT(*) FROM prompts")->fetchColumn();

// ✅ Récupérer les prompts de l'utilisateur connecté
$stmt = $pdo->prepare("
    SELECT p.*, c.name AS category_name 
    FROM prompts p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.user_id = ?
    ORDER BY p.created_at DESC
");
$stmt->execute([$user_id]);
$prompts = $stmt->fetchAll();

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

main { display: flex; flex-direction: column; gap: 30px; }

.dashboard-header { display: flex; flex-direction: column; gap: 10px; animation: slideInUp 0.6s ease-out; }

.dashboard-header h1 {
    font-size: 36px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    letter-spacing: -1px;
}

.dashboard-header > p { font-size: 16px; color: #666; font-weight: 500; }

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
    animation: slideInUp 0.7s ease-out 0.1s backwards;
}

.card {
    background: white; border-radius: var(--radius-xl); padding: 30px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--color-gray-border);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative; overflow: hidden;
    animation: slideInUp 0.6s ease-out backwards;
}

.card:nth-child(1) { animation-delay: 0.2s; }
.card:nth-child(2) { animation-delay: 0.3s; }

.card:hover { transform: translateY(-10px); box-shadow: var(--shadow-xl); }

.card-header { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }

.card-icon {
    width: 50px; height: 50px; border-radius: var(--radius-lg);
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; box-shadow: var(--shadow-md);
}

.card-title { font-size: 20px; font-weight: 700; color: #1a1a1a; }
.card-description { color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 15px; }
.card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }

.stat {
    font-size: 24px; font-weight: 800;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}

.badge {
    display: inline-block;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white; padding: 5px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 600;
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    animation: slideInUp 0.8s ease-out 0.2s backwards;
}

.stat-box {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    border-radius: var(--radius-xl); padding: 25px; color: white;
    text-align: center; box-shadow: var(--shadow-lg);
    transition: all 0.3s ease;
}

.stat-box:hover { transform: translateY(-5px); }
.stat-box-number { font-size: 48px; font-weight: 900; margin-bottom: 10px; }
.stat-box-label { font-size: 14px; opacity: 0.95; font-weight: 600; }

/* Table prompts */
.prompts-section { animation: slideInUp 0.9s ease-out 0.3s backwards; }

.prompts-section h2 {
    font-size: 22px; font-weight: 800; margin-bottom: 20px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}

.btn-new {
    display: inline-block;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white; padding: 10px 18px; border-radius: var(--radius-md);
    text-decoration: none; font-weight: 700; font-size: 13px;
    margin-bottom: 20px; transition: all 0.3s ease;
    box-shadow: var(--shadow-md);
}

.btn-new:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

.prompts-table {
    width: 100%; border-collapse: collapse; background: white;
    border-radius: var(--radius-xl); overflow: hidden;
    box-shadow: var(--shadow-lg);
}

.prompts-table th {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white; padding: 15px 20px; text-align: left;
    font-size: 13px; font-weight: 700; text-transform: uppercase;
}

.prompts-table td {
    padding: 15px 20px; border-bottom: 1px solid var(--color-gray-border);
    font-size: 14px; color: #444;
}

.prompts-table tr:last-child td { border-bottom: none; }
.prompts-table tr:hover td { background: rgba(79, 70, 229, 0.04); }

.badge-cat {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white; padding: 4px 10px; border-radius: var(--radius-2xl); font-size: 11px; font-weight: 600;
}

.btn-edit {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
    color: white; padding: 5px 10px; border-radius: var(--radius-md);
    font-size: 11px; font-weight: 700; text-decoration: none; margin-right: 5px;
    transition: all 0.2s ease;
}

.btn-delete {
    background: linear-gradient(135deg, var(--color-danger), #dc2626);
    color: white; border: none; padding: 5px 10px; border-radius: var(--radius-md);
    font-size: 11px; font-weight: 700; cursor: pointer; text-decoration: none;
    transition: all 0.2s ease;
}

.btn-edit:hover, .btn-delete:hover { transform: translateY(-2px); }

.empty-state {
    text-align: center; padding: 50px; color: #999;
    background: white; border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
}

@media (max-width: 768px) {
    .dashboard-header h1 { font-size: 32px; }
    .dashboard-grid { grid-template-columns: 1fr; }
    .stats-container { grid-template-columns: repeat(2, 1fr); }
}
</style>

<main>
    <div class="dashboard-header">
        <h1>Welcome to PromptHub 🚀</h1>
        <p>Hello <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Developer') ?></strong> — manage your prompts efficiently</p>
    </div>

    <!-- CARDS avec vraies données -->
    <div class="dashboard-grid">
        <div class="card">
            <div class="card-header">
                <div class="card-icon">📝</div>
                <div class="card-title">My Prompts</div>
            </div>
            <div class="card-content">
                <p class="card-description">Create, edit, and manage your custom prompts with ease.</p>
                <div class="card-footer">
                    <span class="stat"><?= $myPromptsCount ?></span>
                    <span class="badge">Active</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-icon">🌐</div>
                <div class="card-title">Platform Total</div>
            </div>
            <div class="card-content">
                <p class="card-description">Total prompts available on the platform.</p>
                <div class="card-footer">
                    <span class="stat"><?= $totalPromptsCount ?></span>
                    <span class="badge">Global</span>
                </div>
            </div>
        </div>
    </div>

    <!-- STATS BOXES avec vraies données -->
    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-box-number"><?= $myPromptsCount ?></div>
            <div class="stat-box-label">My Prompts</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-number"><?= $totalPromptsCount ?></div>
            <div class="stat-box-label">Platform Total</div>
        </div>
    </div>

    <!-- LISTE DES PROMPTS -->
    <div class="prompts-section">
        <h2>📋 My Prompts</h2>
        <a href="create_prompt.php" class="btn-new">✨ Create New Prompt</a>

        <?php if (empty($prompts)): ?>
            <div class="empty-state">
                <p>You don't have any prompts yet. <a href="create_prompt.php">Create your first prompt!</a></p>
            </div>
        <?php else: ?>
            <table class="prompts-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prompts as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><strong><?= htmlspecialchars($p['title']) ?></strong></td>
                        <td>
                            <?php if ($p['category_name']): ?>
                                <span class="badge-cat"><?= htmlspecialchars($p['category_name']) ?></span>
                            <?php else: ?>
                                <span style="color:#ccc">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                        <td>
                            <a href="update_prompt.php?id=<?= $p['id'] ?>" class="btn-edit">✏️ Edit</a>
                            <a href="../controllers/promptController.php?delete_id=<?= $p['id'] ?>"
                               class="btn-delete"
                               onclick="return confirm('Delete this prompt?')">🗑️ Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>