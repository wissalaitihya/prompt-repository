<?php
require_once '../includes/auth.php';
confirm_admin();
require_once '../config/db.php';
include '../includes/header.php';

$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$promptCount = $pdo->query("SELECT COUNT(*) FROM prompts")->fetchColumn();
?>


<div class="dashboard-container">

    <div class="dashboard-title"> Admin Dashboard </div>
    <div class="stats-container">
         <div class="stat-title">Users</div>
         <div class="stat-value"><?= $userCount?> </div>
         <div class="progress-bar">
            <div class="progress-fill" style="width: 80%"></div>
         </div>
    </div>
    <div class="stat-card">
            <div class="stat-title">Total Prompts</div>
            <div class="stat-value"><?= $promptCount ?></div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 60%; background:#10b981;"></div>
            </div>
        </div>
    </div>
    <div class="admin-section">
        <h3>Gestion</h3>

        <div class="admin-links">
            <a href="manage_categories.php" class="btn btn-category">Categories</a>
            <a href="manage_users.php" class="btn btn-users">Users</a>
        </div>
    </div>

</div>

<?php include '../includes/footer.php'; ?>









