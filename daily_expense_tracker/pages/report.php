<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}
include '../includes/header.php';
?>

<div class="card-custom shadow p-4">
    <h2 class="text-primary mb-4 text-center">🧾 Generate Financial Report</h2>

    <?php if (isset($_SESSION['report_error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['report_error']; unset($_SESSION['report_error']); ?>
        </div>
    <?php endif; ?>

    <form action="/daily_expense_tracker/scripts/generate_report.php" method="POST" class="row g-3">
        <div class="col-md-4">
            <label for="from_date" class="form-label">From Date</label>
            <input type="date" name="from_date" id="from_date" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label for="to_date" class="form-label">To Date</label>
            <input type="date" name="to_date" id="to_date" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label for="format" class="form-label">Export Format</label>
            <select name="format" id="format" class="form-select" required>
                <option value="">Select format</option>
                <option value="pdf">PDF</option>
                <option value="csv">CSV</option>
            </select>
        </div>
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary w-50">📥 Generate Report</button>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
