<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    $error = null;
    
    // Validaciones
    if ($new_password !== $confirm_password) {
        $error = 'password_mismatch';
    } elseif (strlen($new_password) < 6) {
        $error = 'password_short';
    } else {
        $user = getUserById($conn, $_SESSION['user_id']);
        if (!$user || !isset($user['password'])) {
            $error = 'user_not_found';
        } elseif (!password_verify($current_password, $user['password'])) {
            $error = 'wrong_password';
        } elseif (!updatePassword($conn, $_SESSION['user_id'], $new_password)) {
            $error = 'update_failed';
        }
    }
    
    // Redirección según resultado
    if ($error) {
        header("Location: dashboard.php?error=" . $error);
    } else {
        header("Location: dashboard.php?success=password_updated");
    }
    exit();
}

// Si no es POST, redirigir al dashboard
header("Location: dashboard.php");
exit();
?>