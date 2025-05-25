<?php
session_start();
require_once '../config/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}

// Check form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user']['id'];
    $amount = trim($_POST['amount']);
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $description = trim($_POST['description']);
    $expense_date = $_POST['expense_date'];

    // Basic validations
    if (empty($amount) || empty($expense_date)) {
        $_SESSION['expense_error'] = "Amount and date are required.";
        header("Location: /daily_expense_tracker/pages/add_expense.php");
        exit();
    }

    if (!is_numeric($amount) || $amount <= 0) {
        $_SESSION['expense_error'] = "Invalid amount entered.";
        header("Location: /daily_expense_tracker/pages/add_expense.php");
        exit();
    }

    try {
        // Insert expense
        $query = "INSERT INTO expenses (user_id, amount, category_id, description, expense_date) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id, $amount, $category_id, $description, $expense_date]);

        $_SESSION['expense_success'] = "Expense added successfully.";
        header("Location: /daily_expense_tracker/pages/add_expense.php");
        exit();

    } catch (PDOException $e) {
        error_log("Insert Expense Error: " . $e->getMessage());
        $_SESSION['expense_error'] = "Failed to save expense. Please try again.";
        header("Location: /daily_expense_tracker/pages/add_expense.php");
        exit();
    }
} else {
    header("Location: /daily_expense_tracker/pages/add_expense.php");
    exit();
}
