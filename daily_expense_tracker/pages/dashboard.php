<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}
require_once '../config/db_connect.php';
include '../includes/header.php';

// Fetch summary stats
$user_id = $_SESSION['user']['id'];

try {
    // Total Expenses
    $stmt = $pdo->prepare("SELECT IFNULL(SUM(amount), 0) AS total_expenses FROM expenses WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $total_expenses = $stmt->fetchColumn();

    // Total Lending
    $stmt = $pdo->prepare("SELECT IFNULL(SUM(amount), 0) AS total_lending FROM lending WHERE user_id = ? AND type = 'lend'");
    $stmt->execute([$user_id]);
    $total_lending = $stmt->fetchColumn();

    // Total Borrowed
    $stmt = $pdo->prepare("SELECT IFNULL(SUM(amount), 0) AS total_borrowed FROM lending WHERE user_id = ? AND type = 'borrow'");
    $stmt->execute([$user_id]);
    $total_borrowed = $stmt->fetchColumn();

} catch (PDOException $e) {
    error_log("Dashboard Error: " . $e->getMessage());
    $total_expenses = $total_lending = $total_borrowed = 0;
}
?>

<div class="text-center mb-5">
    <h2 class="text-success">Welcome back, <?php echo htmlspecialchars($_SESSION['user']['full_name']); ?>!</h2>
    <p class="text-muted">Here's your financial snapshot</p>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom bg-light border-success">
            <h5>Total Expenses</h5>
            <p class="fs-3 text-danger">Nu. <?php echo number_format($total_expenses, 2); ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-custom bg-light border-primary">
            <h5>Total Lent</h5>
            <p class="fs-3 text-primary">Nu. <?php echo number_format($total_lending, 2); ?></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card-custom bg-light border-warning">
            <h5>Total Borrowed</h5>
            <p class="fs-3 text-warning">Nu. <?php echo number_format($total_borrowed, 2); ?></p>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-3">
        <a href="add_expense.php" class="btn btn-outline-primary w-100">➕ Add Expense</a>
    </div>
    <div class="col-md-3">
        <a href="manage_expense.php" class="btn btn-outline-secondary w-100">📋 Manage Expenses</a>
    </div>
    <div class="col-md-3">
        <a href="lending.php" class="btn btn-outline-success w-100">💸 Lending/Borrowing</a>
    </div>
    <div class="col-md-3">
        <a href="analytics.php" class="btn btn-outline-dark w-100">📊 View Analytics</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
