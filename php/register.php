<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';


if (empty($username) || empty($email) || empty($password)) {
    header("Location: index.php?error=empty_fields");
    exit();
}


if (strlen($username) < 3 || strlen($username) > 50) {
    header("Location: index.php?error=invalid_username");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php?error=invalid_email");
    exit();
}


if (strlen($password) < 6) {
    header("Location: index.php?error=password_short");
    exit();
}

if (registerUser($conn, $username, $email, $password)) {
    header("Location: index.php?success=registered");
    exit();
}

header("Location: index.php?error=exists");
exit();
