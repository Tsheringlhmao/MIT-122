<?php
$current_year = date("Y");
?>
</div> <!-- closing container from header -->

<footer class="site-footer bg-dark text-white py-4 mt-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">

        <div class="mb-3 mb-md-0 text-center text-md-start">
            <p class="mb-1">&copy; <?php echo $current_year; ?> Daily Expense Tracker | Built with ❤️ in Bhutan 🇧🇹</p>
            <p class="mb-0">A Student Project – Wentworth Institute of Higher Education</p>
        </div>

        <div class="footer-links text-center text-md-end">
            <ul class="list-unstyled d-flex gap-3 mb-0">
                <li><a class="footer-link" href="/daily_expense_tracker/faq.php">FAQs</a></li>
                <li><a class="footer-link" href="/daily_expense_tracker/terms.php">Terms</a></li>
                <li><a class="footer-link" href="/daily_expense_tracker/privacy.php">Privacy</a></li>

                <?php if (!isset($_SESSION['user'])): ?>
                    <li><a class="footer-link" href="/daily_expense_tracker/auth/index.php">Login</a></li>
                    <li><a class="footer-link" href="/daily_expense_tracker/auth/signup.php">Sign Up</a></li>
                <?php else: ?>
                    <li><a class="footer-link" href="/daily_expense_tracker/pages/dashboard.php">Dashboard</a></li>
                    <li><a class="footer-link" href="/daily_expense_tracker/auth/logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Footer Link Hover Script -->
<script>
    document.querySelectorAll('.footer-link').forEach(link => {
        link.addEventListener('mouseover', () => {
            link.style.color = '#ffc107';
        });
        link.addEventListener('mouseout', () => {
            link.style.color = '#ffffff';
        });
    });
</script>

</body>
</html>
