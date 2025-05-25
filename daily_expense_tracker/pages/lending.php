<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}

require_once '../config/db_connect.php';
include '../includes/header.php';

$user_id = $_SESSION['user']['id'];

// Fetch lending and borrowing entries
try {
    $stmt = $pdo->prepare("SELECT * FROM lending WHERE user_id = ? ORDER BY lending_date DESC");
    $stmt->execute([$user_id]);
    $transactions = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Lending Load Error: " . $e->getMessage());
    $transactions = [];
}
?>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card-custom shadow p-4 mb-5">
            <h2 class="text-success text-center mb-4">💸 Lending / Borrowing</h2>

            <?php if (isset($_SESSION['lending_success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['lending_success']; unset($_SESSION['lending_success']); ?></div>
            <?php elseif (isset($_SESSION['lending_error'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['lending_error']; unset($_SESSION['lending_error']); ?></div>
            <?php endif; ?>

            <form action="/daily_expense_tracker/scripts/insert_lending.php" method="POST">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Person Name</label>
                        <input type="text" class="form-control" name="person_name" required placeholder="Name">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Amount (Nu.)</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="amount" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select" required>
                            <option value="">-- Select --</option>
                            <option value="lend">Lent</option>
                            <option value="borrow">Borrowed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="lending_date" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Purpose</label>
                    <textarea name="purpose" class="form-control" placeholder="E.g. Helped friend, Paid school fee..." rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Record Transaction</button>
            </form>
        </div>

        <div class="card-custom shadow p-4">
            <h4 class="mb-3 text-secondary">📜 Your Lending History</h4>
            <?php if (count($transactions) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Purpose</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $t): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($t['lending_date']); ?></td>
                                    <td><?php echo htmlspecialchars($t['person_name']); ?></td>
                                    <td>Nu. <?php echo number_format($t['amount'], 2); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $t['type'] === 'lend' ? 'success' : 'warning'; ?>">
                                            <?php echo ucfirst($t['type']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo $t['status'] === 'returned' ? 'primary' : 'secondary'; ?>">
                                            <?php echo ucfirst($t['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($t['purpose']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">No lending or borrowing recorded yet.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
