<?php
// Include this code where you handle the removal logic (for example, in remove_from_cart.php)
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecom_store";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the ID is set
if (isset($_GET['id'])) {
    $cartId = (int)$_GET['id'];
    // Fetch the quantity of the product in the cart
    $stmt = $conn->prepare("SELECT qty FROM cart WHERE cart_id = ?");
    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentQty = $row['qty'];
        // Check if the current quantity is greater than 1
        if ($currentQty > 1) {
            // Decrement the quantity
            $newQty = $currentQty - 1;
            $updateStmt = $conn->prepare("UPDATE cart SET qty = ? WHERE cart_id = ?");
            $updateStmt->bind_param("ii", $newQty, $cartId);
            $updateStmt->execute();
        } else {
            // Remove the product from the cart
            $deleteStmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ?");
            $deleteStmt->bind_param("i", $cartId);
            $deleteStmt->execute();
        }
    }
    // Redirect back to the cart page
    header("Location: cart.php");
    exit();
}
?>