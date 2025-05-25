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
                <img src="/daily_expense_tracker/assets/images/user-icon.png" alt="Signup Icon" width="80">
                <h2 class="mt-3 text-primary">Create an Account</h2>
                <p class="text-muted">Join and take control of your daily finances</p>
            </div>

            <?php if (isset($_SESSION['signup_error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                        echo $_SESSION['signup_error']; 
                        unset($_SESSION['signup_error']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="/daily_expense_tracker/scripts/handle_signup.php" method="POST">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required placeholder="Enter your full name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="Choose a password">
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Re-enter password">
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>

            <div class="text-center mt-3">
                <small>Already have an account? <a href="/daily_expense_tracker/auth/index.php">Login here</a></small>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
