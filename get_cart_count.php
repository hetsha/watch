<?php
session_start();

// Initialize cart count
$cart_count = 0;

// Check if the cart session is set
if (isset($_SESSION['cart'])) {
    // Calculate the total items in the cart
    $cart_count = array_sum($_SESSION['cart']);
}

// Return the cart count as JSON
header('Content-Type: application/json');
echo json_encode(['count' => $cart_count]);
?>
