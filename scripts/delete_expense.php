<?php
session_start();
require_once '../config/db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $expense_id = intval($_POST['id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM expenses WHERE id = ? AND user_id = ?");
        $stmt->execute([$expense_id, $user_id]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['delete_success'] = "Expense deleted successfully.";
        } else {
            $_SESSION['delete_error'] = "Failed to delete expense or not found.";
        }

    } catch (PDOException $e) {
        error_log("Delete Expense Error: " . $e->getMessage());
        $_SESSION['delete_error'] = "An error occurred while deleting.";
    }

    header("Location: /daily_expense_tracker/pages/manage_expense.php");
    exit();
}

header("Location: /daily_expense_tracker/pages/manage_expense.php");
exit();
