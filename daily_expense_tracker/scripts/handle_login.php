<?php
session_start();
require_once '../config/db_connect.php';

// Basic validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Email and password are required.';
        header('Location: /daily_expense_tracker/auth/index.php');
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'full_name' => $user['full_name'],
                'email' => $user['email']
            ];

            // Redirect to dashboard
            header("Location: /daily_expense_tracker/pages/dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = 'Invalid email or password.';
            header('Location: /daily_expense_tracker/auth/index.php');
            exit();
        }

    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage());
        $_SESSION['error'] = 'Something went wrong. Please try again.';
        header('Location: /daily_expense_tracker/auth/index.php');
        exit();
    }
} else {
    // If method is not POST
    header('Location: /daily_expense_tracker/auth/index.php');
    exit();
}
