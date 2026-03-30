<?php
require_once '../config/db.php';
require_once '../includes/auth.php';

 session_start();

 if(!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
        exit();
 }
 
 if (isset($_POST['add_prompt'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = intval($_POST['category_id']);
    $user_id = $_SESSION['user_id'];

    
    if (!empty($title) && !empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO prompts (title, content, category_id, user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $content, $category_id, $user_id]);
        
        header('Location: ../developer/dashboard.php');
        exit();
    }
}
if (isset($_POST['edit_prompt'])) {
    $id = intval($_POST['id']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category_id = intval($_POST['category_id']);

    // The only one who could modify it is the admin 
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

    // Redirection vers la page d'édition avec le message de succès (comme demandé)
    header("Location: ../developer/edit_prompt.php?id=$id&msg=success");
    exit();
}
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    
    // Sécurité : On vérifie que le prompt appartient à l'user (ou que l'user est admin)
    $stmt = $pdo->prepare("DELETE FROM prompts WHERE id = ? AND (user_id = ? OR ? = 'admin')");
    $stmt->execute([$id, $_SESSION['user_id'], $_SESSION['role']]);
    
    header('Location: ../developer/dashboard.php?msg=deleted');
    exit();
}

// Si quelqu'un accède au fichier sans action précise
header('Location: ../developer/dashboard.php');
exit();
?>