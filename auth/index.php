<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/pages/dashboard.php");
    exit();
}
?>

<?php include '../includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card-custom shadow p-4">
            <div class="text-center mb-4">
                <img src="/daily_expense_tracker/assets/images/user-icon.png" alt="Login Icon" width="80">
                <h2 class="mt-3 text-primary">User Login</h2>
                <p class="text-muted">Track your daily expenses and manage your money easily</p>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="/daily_expense_tracker/scripts/handle_login.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <div class="text-center mt-3">
                <small>Don't have an account? <a href="/daily_expense_tracker/auth/signup.php">Sign up here</a></small>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
