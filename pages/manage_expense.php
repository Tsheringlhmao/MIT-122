<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}

require_once '../config/db_connect.php';
include '../includes/header.php';

$user_id = $_SESSION['user']['id'];

// Fetch user's expenses
try {
    $query = "SELECT e.id, e.amount, e.description, e.expense_date, c.name AS category 
              FROM expenses e 
              LEFT JOIN categories c ON e.category_id = c.id 
              WHERE e.user_id = ? 
              ORDER BY e.expense_date DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $expenses = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Manage Expense Error: " . $e->getMessage());
    $expenses = [];
}
?>

<div class="card-custom shadow p-4">
    <h2 class="text-primary mb-4 text-center">📋 Manage Your Expenses</h2>

    <?php if (isset($_SESSION['delete_success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['delete_success']; unset($_SESSION['delete_success']); ?>
        </div>
    <?php elseif (isset($_SESSION['delete_error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['delete_error']; unset($_SESSION['delete_error']); ?>
        </div>
    <?php endif; ?>

    <?php if (count($expenses) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Amount (Nu.)</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th style="width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($expenses as $exp): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($exp['expense_date']); ?></td>
                            <td>Nu. <?php echo number_format($exp['amount'], 2); ?></td>
                            <td><?php echo $exp['category'] ? htmlspecialchars($exp['category']) : '<em>Uncategorized</em>'; ?></td>
                            <td><?php echo htmlspecialchars($exp['description']); ?></td>
                            <td>
                                <form action="/daily_expense_tracker/scripts/delete_expense.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                    <input type="hidden" name="id" value="<?php echo $exp['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No expenses recorded yet.</div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
