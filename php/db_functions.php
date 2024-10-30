<?php
function connectDB()
{
    $host = 'db';
    $user = 'root';
    $pass = 'secret';
    $db = 'carlemany';

    $conn = new mysqli($host, $user, $pass);
    if ($conn->connect_error) {
        return false;
    }

    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS $db";
    if ($conn->query($sql) === FALSE) {
        return false;
    }

    $conn->select_db($db);

    // Create users table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === FALSE) {
        return false;
    }

    return $conn;
}

function registerUser($conn, $username, $email, $password)
{
    $username = $conn->real_escape_string($username);
    $email = $conn->real_escape_string($email);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    try {
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

function loginUser($conn, $username, $password)
{
    $username = $conn->real_escape_string($username);

    $sql = "SELECT id, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return $user['id'];
        }
    }
    return false;
}

function getAllUsers($conn)
{
    $sql = "SELECT id, username, email, created_at FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($user = $result->fetch_assoc()) {
        $users[] = $user;
    }
    return $users;
}

function getUserById($conn, $id)
{
    $sql = "SELECT id, username, email, password, created_at FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updatePassword($conn, $user_id, $new_password)
{
    try {
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);


        error_log("Updating password for user_id: " . $user_id);
        error_log("Hashed password length: " . strlen($hashedPassword));

        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return false;
        }

        $stmt->bind_param("si", $hashedPassword, $user_id);
        $result = $stmt->execute();

        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
        }

        // Debug: Ver si se afectó alguna fila
        error_log("Affected rows: " . $stmt->affected_rows);

        return $result;
    } catch (Exception $e) {
        error_log("Exception in updatePassword: " . $e->getMessage());
        return false;
    }
}
