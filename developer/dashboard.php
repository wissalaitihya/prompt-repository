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
@keyframes slideInUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}

main { display: flex; flex-direction: column; gap: 30px; }

.dashboard-header { display: flex; flex-direction: column; gap: 10px; animation: slideInUp 0.6s ease-out; }

.dashboard-header h1 {
    font-size: 42px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
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
    background: white; border-radius: 15px; padding: 30px;
    box-shadow: 0 8px 32px rgba(255, 107, 157, 0.1);
    border: 1px solid rgba(255, 107, 157, 0.2);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative; overflow: hidden;
    animation: slideInUp 0.6s ease-out backwards;
}

.card:nth-child(1) { animation-delay: 0.2s; }
.card:nth-child(2) { animation-delay: 0.3s; }

.card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(255, 107, 157, 0.2); }

.card-header { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }

.card-icon {
    width: 50px; height: 50px; border-radius: 12px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
}

.card-title { font-size: 20px; font-weight: 700; color: #1a1a1a; }
.card-description { color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 15px; }
.card-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }

.stat {
    font-size: 24px; font-weight: 800;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}

.badge {
    display: inline-block;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
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
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    border-radius: 15px; padding: 25px; color: white;
    text-align: center; box-shadow: 0 8px 32px rgba(255, 107, 157, 0.25);
    transition: all 0.3s ease;
}

.stat-box:hover { transform: translateY(-5px); }
.stat-box-number { font-size: 48px; font-weight: 900; margin-bottom: 10px; }
.stat-box-label { font-size: 14px; opacity: 0.95; font-weight: 600; }

/* Table prompts */
.prompts-section { animation: slideInUp 0.9s ease-out 0.3s backwards; }

.prompts-section h2 {
    font-size: 26px; font-weight: 800; margin-bottom: 20px;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
}

.btn-new {
    display: inline-block;
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    color: white; padding: 12px 24px; border-radius: 10px;
    text-decoration: none; font-weight: 700; font-size: 14px;
    margin-bottom: 20px; transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 157, 0.3);
}

.btn-new:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(255, 107, 157, 0.4); }

.prompts-table {
    width: 100%; border-collapse: collapse; background: white;
    border-radius: 15px; overflow: hidden;
    box-shadow: 0 8px 32px rgba(255, 107, 157, 0.1);
}

.prompts-table th {
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    color: white; padding: 15px 20px; text-align: left;
    font-size: 13px; font-weight: 700; text-transform: uppercase;
}

.prompts-table td {
    padding: 15px 20px; border-bottom: 1px solid rgba(255, 107, 157, 0.1);
    font-size: 14px; color: #444;
}

.prompts-table tr:last-child td { border-bottom: none; }
.prompts-table tr:hover td { background: rgba(255, 107, 157, 0.04); }

.badge-cat {
    background: linear-gradient(135deg, #ff6b9d 0%, #c34a7b 100%);
    color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;
}

.btn-edit {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white; padding: 6px 12px; border-radius: 8px;
    font-size: 12px; font-weight: 700; text-decoration: none; margin-right: 5px;
    transition: all 0.2s ease;
}

.btn-delete {
    background: linear-gradient(135deg, #ff4d4d, #c0392b);
    color: white; border: none; padding: 6px 12px; border-radius: 8px;
    font-size: 12px; font-weight: 700; cursor: pointer; text-decoration: none;
    transition: all 0.2s ease;
}

.btn-edit:hover, .btn-delete:hover { transform: translateY(-2px); }

.empty-state {
    text-align: center; padding: 50px; color: #999;
    background: white; border-radius: 15px;
    box-shadow: 0 8px 32px rgba(255, 107, 157, 0.1);
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
        <p>Bonjour <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Developer') ?></strong> — gérez vos prompts efficacement</p>
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
                <div class="card-title">Total Plateforme</div>
            </div>
            <div class="card-content">
                <p class="card-description">Total prompts disponibles sur la plateforme.</p>
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
            <div class="stat-box-label">Mes Prompts</div>
        </div>
        <div class="stat-box">
            <div class="stat-box-number"><?= $totalPromptsCount ?></div>
            <div class="stat-box-label">Total Plateforme</div>
        </div>
    </div>

    <!-- LISTE DES PROMPTS -->
    <div class="prompts-section">
        <h2>📋 Mes Prompts</h2>
        <a href="create_prompt.php" class="btn-new">✨ Créer un nouveau prompt</a>

        <?php if (empty($prompts)): ?>
            <div class="empty-state">
                <p>Vous n'avez encore aucun prompt. <a href="create_prompt.php">Créez votre premier prompt !</a></p>
            </div>
        <?php else: ?>
            <table class="prompts-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Catégorie</th>
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
                            <a href="update_prompt.php?id=<?= $p['id'] ?>" class="btn-edit">✏️ Modifier</a>
                            <a href="../controllers/promptController.php?delete_id=<?= $p['id'] ?>"
                               class="btn-delete"
                               onclick="return confirm('Supprimer ce prompt ?')">🗑️ Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<?php include '../includes/footer.php'; ?>