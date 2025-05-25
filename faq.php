<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-lg-10 col-md-12">
        <div class="card-custom shadow p-5">
            <h2 class="text-center text-primary mb-4">❓ Frequently Asked Questions</h2>

            <div class="faq-item mb-4">
                <h5 class="faq-question">💰 How do I add an expense?</h5>
                <p class="faq-answer">To add a new expense, go to your dashboard and click on the “Add Expense” button. You will be taken to a form where you can enter the amount, category, description, and date. Once submitted, the expense will be logged in your personal records.</p>
            </div>

            <div class="faq-item mb-4">
                <h5 class="faq-question">🔐 Is my financial data secure?</h5>
                <p class="faq-answer">Yes. We use secure PHP sessions and PDO for database interaction. Your data is never shared with any third party, and only authenticated users can access their own entries. All passwords are stored in a hashed format.</p>
            </div>

            <div class="faq-item mb-4">
                <h5 class="faq-question">📤 Can I export reports of my expenses and lending?</h5>
                <p class="faq-answer">Absolutely. You can visit the “Report” section to export your financial history for any date range. Both PDF and CSV formats are supported for download and printing.</p>
            </div>

            <div class="faq-item mb-4">
                <h5 class="faq-question">🔄 Can I update or delete my entries?</h5>
                <p class="faq-answer">Yes. Visit the “Manage Expenses” section to view all your logged expenses. You can delete any entry with a single click. Lending entries are viewable, and edit support may be added in future versions.</p>
            </div>

            <div class="faq-item mb-4">
                <h5 class="faq-question">😞 What if I forget my password?</h5>
                <p class="faq-answer">Currently, there is no self-service password recovery. Please contact the developer or system administrator to reset your account credentials manually.</p>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('mouseover', () => item.classList.add('hovered'));
    item.addEventListener('mouseout', () => item.classList.remove('hovered'));
});
</script>

<?php include 'includes/footer.php'; ?>
