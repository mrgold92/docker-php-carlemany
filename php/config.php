<?php
require_once 'db_functions.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$conn = connectDB();
if (!$conn) {
    die("Database connection failed");
}
?>