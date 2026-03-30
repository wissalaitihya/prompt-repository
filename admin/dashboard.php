<?php
require_once '../includes/auth.php';
confirm_admin();
require_once '../config/db.php';
include '../includes/header.php';

$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$promptCount = $pdo->query("SELECT COUNT(*) FROM prompts")->fetchColumn();
$categoryCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
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

@keyframes cardHover {
    0% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(-8px);
    }
}

main {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.dashboard-header {
    display: flex;
    flex-direction: column;
    gap: 10px;
    animation: slideInUp 0.6s ease-out;
}

.dashboard-header h1 {
    font-size: 36px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    letter-spacing: -1px;
}

.dashboard-header > p {
    font-size: 16px;
    color: #666;
    font-weight: 500;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    animation: slideInUp 0.7s ease-out 0.1s backwards;
}

.stat-card {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    border-radius: var(--radius-xl);
    padding: 30px;
    color: white;
    box-shadow: var(--shadow-lg);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: slideInUp 0.6s ease-out backwards;
    position: relative;
    overflow: hidden;
}

.stat-card:nth-child(1) { animation-delay: 0.2s; }
.stat-card:nth-child(2) { animation-delay: 0.3s; }
.stat-card:nth-child(3) { animation-delay: 0.4s; }

.stat-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transition: all 0.6s ease;
    z-index: 0;
}

.stat-card:hover::before {
    top: -20px;
    right: -20px;
    width: 150px;
    height: 150px;
}

.stat-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--shadow-xl);
}

.stat-title {
    font-size: 14px;
    opacity: 0.9;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
    position: relative;
    z-index: 1;
}

.stat-value {
    font-size: 48px;
    font-weight: 900;
    margin-bottom: 16px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 1;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    z-index: 1;
}

.progress-fill {
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    transition: width 0.5s ease;
}

/* Admin Section */
.admin-section {
    animation: slideInUp 0.8s ease-out 0.2s backwards;
}

.admin-section h2 {
    font-size: 24px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 800;
    margin-bottom: 25px;
}

.admin-links {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 20px;
    border-radius: var(--radius-xl);
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
    color: white;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(255, 255, 255, 0.2);
    min-height: 60px;
    cursor: pointer;
}

.btn-category {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
}

.btn-category:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.btn-users {
    background: linear-gradient(135deg, var(--color-secondary) 0%, #059669 100%);
}

.btn-users:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(16, 185, 129, 0.35);
}
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(107, 114, 128, 0.35);
}

/* Responsive */
@media (max-width: 768px) {
    .dashboard-header h1 {
        font-size: 32px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .admin-links {
        grid-template-columns: 1fr;
    }

    .stat-value {
        font-size: 36px;
    }
}
</style>

<main>
    <div class="dashboard-header">
        <h1>🎛️ Admin Dashboard</h1>
        <p>Manage your platform and monitor key metrics</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">👥 Total Users</div>
            <div class="stat-value"><?= $userCount ?></div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 80%"></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-title">📝 Total Prompts</div>
            <div class="stat-value"><?= $promptCount ?></div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 60%"></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-title">📁 Categories</div>
            <div class="stat-value"><?= $categoryCount ?></div>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 75%"></div>
            </div>
        </div>
    </div>

    <div class="admin-section">
        <h2>🔧 Management</h2>
        <div class="admin-links">
            <a href="manage_category.php" class="btn btn-category">📁 Manage Categories</a>
            <a href="manage_user.php" class="btn btn-users">👥 Manage Users</a>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>









