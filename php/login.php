<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validación de campos vacíos
if (empty($username) || empty($password)) {
    header("Location: index.php?error=empty_fields");
    exit();
}

$user_id = loginUser($conn, $username, $password);
if ($user_id) {
    $_SESSION['user_id'] = $user_id;
    header("Location: dashboard.php");
    exit();
}

header("Location: index.php?error=invalid");
exit();
