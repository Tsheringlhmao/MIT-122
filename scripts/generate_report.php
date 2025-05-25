<?php
session_start();
require_once '../config/db_connect.php';

if (!isset($_SESSION['user'])) {
    header("Location: /daily_expense_tracker/auth/index.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

// Validate form input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $_POST['from_date'];
    $to = $_POST['to_date'];
    $format = $_POST['format'];

    if (!$from || !$to || !$format) {
        $_SESSION['report_error'] = "All fields are required.";
        header("Location: /daily_expense_tracker/pages/report.php");
        exit();
    }

    // Fetch data
    try {
        // Expenses
        $stmt = $pdo->prepare("SELECT expense_date AS date, 'Expense' AS type, amount, description 
                               FROM expenses WHERE user_id = ? AND expense_date BETWEEN ? AND ?");
        $stmt->execute([$user_id, $from, $to]);
        $expenses = $stmt->fetchAll();

        // Lending
        $stmt = $pdo->prepare("SELECT lending_date AS date, type, amount, purpose AS description 
                               FROM lending WHERE user_id = ? AND lending_date BETWEEN ? AND ?");
        $stmt->execute([$user_id, $from, $to]);
        $lending = $stmt->fetchAll();

        // Merge and sort all
        $records = array_merge($expenses, $lending);
        usort($records, fn($a, $b) => strtotime($a['date']) <=> strtotime($b['date']));

        // Handle output
        if ($format === 'pdf') {
            require_once 'libs/fpdf.php';
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Financial Report', 0, 1, 'C');
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, "From $from to $to", 0, 1, 'C');
            $pdf->Ln(5);

            $pdf->SetFillColor(220, 220, 220);
            $pdf->Cell(40, 10, 'Date', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'Type', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Amount (Nu.)', 1, 0, 'C', true);
            $pdf->Cell(80, 10, 'Description', 1, 1, 'C', true);

            foreach ($records as $r) {
                $pdf->Cell(40, 10, $r['date'], 1);
                $pdf->Cell(30, 10, ucfirst($r['type']), 1);
                $pdf->Cell(40, 10, number_format($r['amount'], 2), 1);
                $pdf->Cell(80, 10, substr($r['description'], 0, 45), 1);
                $pdf->Ln();
            }

            $pdf->Output("D", "financial_report_$from-$to.pdf");
            exit();

        } elseif ($format === 'csv') {
            header('Content-Type: text/csv');
            header("Content-Disposition: attachment; filename=financial_report_$from-$to.csv");
            $output = fopen("php://output", "w");
            fputcsv($output, ['Date', 'Type', 'Amount', 'Description']);
            foreach ($records as $r) {
                fputcsv($output, [$r['date'], ucfirst($r['type']), $r['amount'], $r['description']]);
            }
            fclose($output);
            exit();
        } else {
            $_SESSION['report_error'] = "Invalid format selected.";
            header("Location: /daily_expense_tracker/pages/report.php");
            exit();
        }

    } catch (PDOException $e) {
        error_log("Report Generation Error: " . $e->getMessage());
        $_SESSION['report_error'] = "Failed to generate report. Please try again.";
        header("Location: /daily_expense_tracker/pages/report.php");
        exit();
    }

} else {
    header("Location: /daily_expense_tracker/pages/report.php");
    exit();
}
