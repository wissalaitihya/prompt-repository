<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // ✅ Fix: $_SESSION (single S), no spaces, direct comparison
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: developer/dashboard.php");
    }
} else {
    // ✅ Fix: index.php is at root, so no ../
    header("Location: auth/login.php");
}
exit();
?>