<?php
require_once '../config/db.php';
require_once '../includes/auth.php'; // ✅ auth.php fait déjà session_start(), pas besoin de le rappeler

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Note : add_prompt est maintenant géré directement dans create_prompt.php
// Ce controller gère uniquement : edit et delete

/**
 * --- MODIFIER UN PROMPT ---
 */
if (isset($_POST['edit_prompt'])) {
    $id          = intval($_POST['id']);
    $title       = trim($_POST['title']);
    $content     = trim($_POST['content']);
    $category_id = intval($_POST['category_id']);

    $stmt = $pdo->prepare("UPDATE prompts SET title = ?, content = ?, category_id = ?
                           WHERE id = ? AND (user_id = ? OR ? = 'admin')");
    $stmt->execute([
        $title,
        $content,
        $category_id,
        $id,
        $_SESSION['user_id'],
        $_SESSION['role']
    ]);

    header("Location: ../developer/dashboard.php?msg=updated");
    exit();
}

/**
 * --- SUPPRIMER UN PROMPT ---
 */
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);

    $stmt = $pdo->prepare("DELETE FROM prompts WHERE id = ? AND (user_id = ? OR ? = 'admin')");
    $stmt->execute([$id, $_SESSION['user_id'], $_SESSION['role']]);

    header('Location: ../developer/dashboard.php?msg=deleted');
    exit();
}

header('Location: ../developer/dashboard.php');
exit();
?>