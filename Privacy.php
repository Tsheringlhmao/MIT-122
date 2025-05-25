<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-10 col-md-12">
        <div class="card-custom shadow p-5">
            <h2 class="text-center text-primary mb-4">🔒 Privacy Policy</h2>

            <p>We understand how important privacy is, especially when it comes to personal financial information. This privacy policy explains how your data is handled in the Daily Expense Tracker System:</p>

            <ul>
                <li><strong>Data Ownership:</strong> All data you enter into the system belongs solely to you. We do not claim ownership over your financial entries.</li>
                <li><strong>Access Control:</strong> Only you can access your data once logged in. Other users, including administrators, cannot view your data unless granted permission.</li>
                <li><strong>Session Security:</strong> We use PHP sessions to keep your account secure while logged in. Logging out will invalidate your session.</li>
                <li><strong>Password Encryption:</strong> Your password is stored using strong hashing algorithms. We never store plaintext passwords.</li>
                <li><strong>No Third-Party Sharing:</strong> We do not share your data with any third parties. It is stored locally within the system database.</li>
                <li><strong>Data Retention:</strong> You may request your data be deleted permanently at any time by contacting the administrator.</li>
            </ul>

            <p>By using this system, you consent to this privacy policy. If you have concerns, feel free to reach out to the development team for clarification.</p>
        </div>
    </div>
</div>

<script>
document.querySelector('.card-custom').addEventListener('mouseover', function() {
    this.style.backgroundColor = "#fefefe";
});
document.querySelector('.card-custom').addEventListener('mouseout', function() {
    this.style.backgroundColor = "#ffffff";
});
</script>

<?php include 'includes/footer.php'; ?>
