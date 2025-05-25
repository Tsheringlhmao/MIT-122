<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Tracker</title>
    <link rel="stylesheet" href="/daily_expense_tracker/assets/css/style.css">
    <link rel="icon" type="image/png" href="/daily_expense_tracker/assets/images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="site-header bg-primary text-white py-3 shadow-sm">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="/daily_expense_tracker/assets/images/logo.png" alt="Logo" height="40" class="me-2">
                <h1 class="h4 mb-0">Daily Expense Tracker</h1>
            </div>

            <nav class="mt-3 mt-md-0">
                <ul class="nav">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/pages/dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/pages/add_expense.php">Add Expense</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/pages/manage_expense.php">Manage Expenses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/pages/lending.php">Lending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/pages/analytics.php">Analytics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/pages/report.php">Report</a>
                        </li>
                        
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/auth/index.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/auth/signup.php">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/faq.php">FAQs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/terms.php">Terms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/daily_expense_tracker/privacy.php">Privacy</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="py-4">
        <div class="container">
