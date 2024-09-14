<?php
session_start();

if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Check if the product exists in the cart
    if (isset($_SESSION['cart'][$productID])) {
        unset($_SESSION['cart'][$productID]);
    }
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
