<?php
session_start();
require_once '../config/db_connect.php';

// Check if user is authenticated
if (!isset($_SESSION['user'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user']['id'];

/**
 * Get monthly totals for a given table and date column.
 * 
 * @param PDO $pdo
 * @param string $table
 * @param string $dateColumn
 * @param string|null $typeFilter Optional 'lend' or 'borrow' for lending table.
 * @return array
 */
function getMonthlyTotals(PDO $pdo, string $table, string $dateColumn, ?string $typeFilter = null): array {
    // Restrict to known tables and columns
    $validTables = ['expenses', 'lending'];
    $validColumns = ['expense_date', 'lending_date'];

    if (!in_array($table, $validTables) || !in_array($dateColumn, $validColumns)) {
        return [];
    }

    $query = "
        SELECT DATE_FORMAT($dateColumn, '%b %Y') AS month_label, 
               SUM(amount) AS total 
        FROM $table 
        WHERE user_id = :user_id
    ";

    $params = ['user_id' => $GLOBALS['user_id']];

    // Add filter for lending type if needed
    if ($typeFilter !== null && $table === 'lending') {
        $query .= " AND type = :type";
        $params['type'] = $typeFilter;
    }

    $query .= "
        GROUP BY DATE_FORMAT($dateColumn, '%Y-%m') 
        ORDER BY DATE_FORMAT($dateColumn, '%Y-%m') ASC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert to [month => total] format
    $monthlyTotals = [];
    foreach ($results as $row) {
        $monthlyTotals[$row['month_label']] = (float)$row['total'];
    }

    return $monthlyTotals;
}

// Retrieve data
$expenses = getMonthlyTotals($pdo, 'expenses', 'expense_date');
$lent = getMonthlyTotals($pdo, 'lending', 'lending_date', 'lend');
$borrowed = getMonthlyTotals($pdo, 'lending', 'lending_date', 'borrow');

// Combine all months
$allMonths = array_unique(array_merge(array_keys($lent), array_keys($borrowed)));
sort($allMonths);

// Format lending data for chart
$lendingData = [
    'months' => $allMonths,
    'lent' => array_map(fn($m) => $lent[$m] ?? 0, $allMonths),
    'borrowed' => array_map(fn($m) => $borrowed[$m] ?? 0, $allMonths)
];

// Final JSON output
echo json_encode([
    'expenses' => [
        'months' => array_keys($expenses),
        'totals' => array_values($expenses)
    ],
    'lending' => $lendingData
]);
