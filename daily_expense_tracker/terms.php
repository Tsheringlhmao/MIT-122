<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-10 col-md-12">
        <div class="card-custom shadow p-5">
            <h2 class="text-center text-primary mb-4">📜 Terms & Conditions</h2>
            <p>By accessing or using the Daily Expense Tracker System (DETS), you agree to comply with and be bound by the following terms and conditions:</p>
            <ol>
                <li><strong>Personal Use Only:</strong> This system is intended for personal or academic purposes only. It must not be used for commercial financial tracking without written consent.</li>
                <li><strong>Data Accuracy:</strong> You are solely responsible for ensuring the accuracy of the financial information you enter into the system.</li>
                <li><strong>Account Responsibility:</strong> Keep your login credentials safe. We are not responsible for any unauthorised access due to compromised credentials.</li>
                <li><strong>No Warranty:</strong> This system is provided “as is” without warranties of any kind. While we strive for accuracy, we do not guarantee the system will be error-free.</li>
                <li><strong>Changes to Terms:</strong> We may revise these terms from time to time. Continued use of the system implies acceptance of those changes.</li>
            </ol>
            <p>If you do not agree with any of these terms, please discontinue use of the platform immediately.</p>
        </div>
    </div>
</div>

<script>
document.querySelector('.card-custom').addEventListener('mouseover', function() {
    this.classList.add('shadow-lg');
    this.style.transition = "all 0.3s ease-in-out";
});
document.querySelector('.card-custom').addEventListener('mouseout', function() {
    this.classList.remove('shadow-lg');
});
</script>

<?php include 'includes/footer.php'; ?>
