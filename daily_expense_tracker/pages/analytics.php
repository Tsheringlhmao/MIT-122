<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}
include '../includes/header.php';
?>

<div class="card-custom shadow p-4">
    <h2 class="text-primary mb-4 text-center">📊 Financial Analytics</h2>

    <canvas id="expenseChart" height="100"></canvas>
    <hr class="my-5">
    <canvas id="lendingChart" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Fetch and render charts
    async function renderCharts() {
        const response = await fetch('/daily_expense_tracker/scripts/chart_data.php');
        const data = await response.json();

        // Expenses Line Chart
        new Chart(document.getElementById("expenseChart"), {
            type: 'line',
            data: {
                labels: data.expenses.months,
                datasets: [{
                    label: "Monthly Expenses (Nu.)",
                    data: data.expenses.totals,
                    fill: true,
                    borderColor: "#0d6efd",
                    backgroundColor: "rgba(13, 110, 253, 0.2)",
                    tension: 0.4
                }]
            }
        });

        // Lending Bar Chart
        new Chart(document.getElementById("lendingChart"), {
            type: 'bar',
            data: {
                labels: data.lending.months,
                datasets: [
                    {
                        label: "Lent (Nu.)",
                        data: data.lending.lent,
                        backgroundColor: "#198754"
                    },
                    {
                        label: "Borrowed (Nu.)",
                        data: data.lending.borrowed,
                        backgroundColor: "#ffc107"
                    }
                ]
            }
        });
    }

    renderCharts();
</script>

<?php include '../includes/footer.php'; ?>
