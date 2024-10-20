<?php
session_start();

// Unset all session variables
session_unset();
session_destroy();


// Remove customer cookie if it exists
if (isset($_COOKIE['customer_name'])) {
    setcookie('customer_name', '', time() - 3600, '/'); // Set the cookie to expire in the past
}

// Redirect to the login page
header("Location: login.php");
exit;
?>
