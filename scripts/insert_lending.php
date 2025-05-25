<?php
session_start();
require_once '../config/db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $person_name = trim($_POST['person_name']);
    $amount = trim($_POST['amount']);
    $type = $_POST['type'];
    $purpose = trim($_POST['purpose']);
    $lending_date = $_POST['lending_date'];

    // Validate inputs
    if (empty($person_name) || empty($amount) || empty($type) || empty($lending_date)) {
        $_SESSION['lending_error'] = "All fields except purpose are required.";
        header("Location: /daily_expense_tracker/pages/lending.php");
        exit();
    }

    if (!is_numeric($amount) || $amount <= 0) {
        $_SESSION['lending_error'] = "Invalid amount entered.";
        header("Location: /daily_expense_tracker/pages/lending.php");
        exit();
    }

    if (!in_array($type, ['lend', 'borrow'])) {
        $_SESSION['lending_error'] = "Invalid transaction type.";
        header("Location: /daily_expense_tracker/pages/lending.php");
        exit();
    }

    try {
        // Insert into lending table
        $query = "INSERT INTO lending (user_id, person_name, amount, type, purpose, lending_date) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id, $person_name, $amount, $type, $purpose, $lending_date]);

        $_SESSION['lending_success'] = ucfirst($type) . " recorded successfully.";
        header("Location: /daily_expense_tracker/pages/lending.php");
        exit();

    } catch (PDOException $e) {
        error_log("Insert Lending Error: " . $e->getMessage());
        $_SESSION['lending_error'] = "Something went wrong while saving the transaction.";
        header("Location: /daily_expense_tracker/pages/lending.php");
        exit();
    }
} else {
    header("Location: /daily_expense_tracker/pages/lending.php");
    exit();
}
