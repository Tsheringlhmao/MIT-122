<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login
header("Location: /daily_expense_tracker/auth/index.php");
exit();
