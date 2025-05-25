<?php
// config/db_connect.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'expense_tracker_db');
define('DB_USER', 'root'); // Change if using custom user
define('DB_PASS', '');     // Change if using password

try {
    $pdo = new PDO("mysql:host=". DB_HOST . ";dbname=". DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    die("Database connection failed. Please contact the administrator.");
}
?>
