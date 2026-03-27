<?php
require_once '../config/db.php';
session_start();

// Sécurité : Seul l'admin peut gérer les catégories
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../developer/dashboard.php');
    exit();
}

if (isset($_POST['add_category'])) {
    $name = htmlspecialchars($_POST['name']);
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
    header('Location: ../admin/manage_category.php');
    exit();
}