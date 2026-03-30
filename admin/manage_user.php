<?php 
require_once '../includes/auth.php';
confirm_admin();
require_once '../config/db.php';
include '../includes/header.php';

$users = $pdo->query("SELECT * FROM users ORDER BY role ASC")->fetchAll();
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

.table-card {
    background: white;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--color-gray-border);
    overflow: hidden;
    animation: slideInUp 0.7s ease-out 0.1s backwards;
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

.delete-btn {
    display: inline-block;
    padding: 6px 12px;
    background: linear-gradient(135deg, var(--color-danger) 0%, #dc2626 100%);
    color: white;
    text-decoration: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 12px;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.delete-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.role-badge {
    display: inline-block;
    padding: 6px 12px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: white;
    border-radius: var(--radius-2xl);
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.current-user {
    display: inline-block;
    padding: 6px 12px;
    background: rgba(79, 70, 229, 0.1);
    color: var(--color-primary);
    border-radius: var(--radius-2xl);
    font-weight: 600;
    font-size: 11px;
    border: 1px solid rgba(79, 70, 229, 0.3);
}

@media (max-width: 768px) {
    .manage-header h1 {
        font-size: 32px;
    }

    .table-card th,
    .table-card td {
        padding: 12px 10px;
        font-size: 13px;
    }

    .table-card th {
        font-size: 12px;
    }

    .delete-btn {
        padding: 6px 12px;
        font-size: 12px;
    }
}
</style>

<main>
    <div class="manage-header">
        <h1>👥 Users Management</h1>
        <p>Manage all platform users and their roles</p>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <span class="role-badge"><?= ($u['role']) ?></span>
                        </td>
                        <td>
                            <?php if($u['id'] != $_SESSION['user_id']): ?>
                                <a href="../controllers/developerController.php?delete_user_id=<?= $u['id'] ?>" class="delete-btn">Delete</a>
                            <?php else: ?>
                                <span class="current-user">You</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include '../includes/footer.php'; ?>