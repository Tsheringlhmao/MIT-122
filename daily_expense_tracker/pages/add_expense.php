<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}
require_once '../config/db_connect.php';
include '../includes/header.php';

// Fetch categories (optional)
try {
    $categories = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
} catch (PDOException $e) {
    $categories = [];
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-custom shadow p-4">
            <h2 class="text-primary mb-4 text-center">➕ Add New Expense</h2>

            <?php if (isset($_SESSION['expense_success'])): ?>
                <div class="alert alert-success">
                    <?php 
                        echo $_SESSION['expense_success']; 
                        unset($_SESSION['expense_success']);
                    ?>
                </div>
            <?php elseif (isset($_SESSION['expense_error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        echo $_SESSION['expense_error']; 
                        unset($_SESSION['expense_error']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="/daily_expense_tracker/scripts/insert_expense.php" method="POST">
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount (Nu.)</label>
                    <input type="number" step="0.01" min="0" class="form-control" id="amount" name="amount" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">-- Optional --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="E.g. Lunch at hotel, Taxi fare..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="expense_date" class="form-label">Expense Date</label>
                    <input type="date" class="form-control" id="expense_date" name="expense_date" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Save Expense</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
