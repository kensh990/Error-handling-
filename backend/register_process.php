<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $errors = [];

    // Validation
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]{4,20}$/", $username)) {
        $errors[] = "Username must be 4-20 characters (letters, numbers, underscore only).";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (empty($errors)) {
        try {

            // Check duplicate
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $errors[] = "Username already exists.";
            } else {

                $hashed = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $hashed);
                $stmt->execute();

                $_SESSION['success'] = "Registration successful!";
                header("Location: ../frontend/register.php");
                exit();
            }

        } catch (Exception $e) {
            $errors[] = "System error. Please try again later.";
        }
    }

    $_SESSION['errors'] = $errors;
    header("Location: ../frontend/register.php");
    exit();
}
?>
