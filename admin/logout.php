<?php
session_start();
session_destroy();

// Remove admin cookie if it exists
if (isset($_COOKIE['admin_name'])) {
    setcookie("admin_name", "", time() - 3600, "/"); // Set expiration time to past
}


echo "<script>window.open('../login.php','_self')</script>";
?>
