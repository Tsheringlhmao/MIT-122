<?php
session_start();
require_once '../config/db_connect.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['signup_error'] = "All fields are required.";
        header("Location: /daily_expense_tracker/auth/signup.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = "Invalid email format.";
        header("Location: /daily_expense_tracker/auth/signup.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['signup_error'] = "Passwords do not match.";
        header("Location: /daily_expense_tracker/auth/signup.php");
        exit();
    }

    try {
        // Check for existing email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $_SESSION['signup_error'] = "Email already registered.";
            header("Location: /daily_expense_tracker/auth/signup.php");
            exit();
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $insert = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
        $insert->execute([$full_name, $email, $hashed_password]);

        // Auto-login after registration
        $_SESSION['user'] = [
            'id' => $pdo->lastInsertId(),
            'full_name' => $full_name,
            'email' => $email
        ];

        // Redirect to dashboard
        header("Location: /daily_expense_tracker/pages/dashboard.php");
        exit();

    } catch (PDOException $e) {
        error_log("Signup Error: " . $e->getMessage());
        $_SESSION['signup_error'] = "An error occurred. Please try again.";
        header("Location: /daily_expense_tracker/auth/signup.php");
        exit();
    }

} else {
    header("Location: /daily_expense_tracker/auth/signup.php");
    exit();
}
