<?php
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

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customerID = (int)$_SESSION['customer_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = $_POST['cart_id'];
    $action = $_POST['action'];

    // Fetch the current quantity
    $stmt = $conn->prepare("SELECT qty FROM cart WHERE cart_id = ? AND customer_id = ?");
    $stmt->bind_param("ii", $cart_id, $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentQuantity = $row['qty'];

        // Update the quantity based on action
        if ($action == 'increase') {
            $newQuantity = $currentQuantity + 1;
        } elseif ($action == 'decrease' && $currentQuantity > 1) {
            $newQuantity = $currentQuantity - 1;
        } else {
            $newQuantity = $currentQuantity; // Do not decrease below 1
        }

        // Update the cart with the new quantity
        $updateStmt = $conn->prepare("UPDATE cart SET qty = ? WHERE cart_id = ?");
        $updateStmt->bind_param("ii", $newQuantity, $cart_id);
        $updateStmt->execute();

        // Optionally, you can add a session message
        $_SESSION['message'] = 'Cart updated successfully!';
    }
}

// Redirect back to the cart page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
