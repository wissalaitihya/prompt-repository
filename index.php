<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // ✅ Correction : $_SESSION (1 seul S), pas d'espace, comparaison directe
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: developer/dashboard.php");
    }
} else {
    // ✅ Correction : index.php est à la racine, donc pas de ../
    header("Location: auth/login.php");
}
exit();
?>