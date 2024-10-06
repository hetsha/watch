<?php
session_start();
// Database connection
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
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Handle coupon application
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $couponCode = $conn->real_escape_string(trim($_POST['coupon_code']));

    // Validate the coupon code
    $stmt = $conn->prepare("SELECT coupon_id, coupon_price, coupon_used, coupon_limit FROM coupons WHERE coupon_code = ?");
    $stmt->bind_param("s", $couponCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        // Check if the coupon limit has been reached
        if ($row['coupon_used'] < $row['coupon_limit']) {
            $discountValue = (float)$row['coupon_price']; // Assuming this is a fixed discount
            $_SESSION['coupon_discount'] = $discountValue; // Store the discount in the session

            // Update the coupon usage count
            $newCouponUsed = $row['coupon_used'] + 1;
            $updateStmt = $conn->prepare("UPDATE coupons SET coupon_used = ? WHERE coupon_id = ?");
            $updateStmt->bind_param("ii", $newCouponUsed, $row['coupon_id']);
            $updateStmt->execute();
            $updateStmt->close();

            header("Location: cart.php"); // Redirect back to the cart page
        } else {
            $_SESSION['error_message'] = "Coupon limit has been reached.";
            header("Location: cart.php"); // Redirect back to the cart page
        }
    } else {
        $_SESSION['error_message'] = "Invalid coupon code.";
        header("Location: cart.php"); // Redirect back to the cart page
    }

    $stmt->close(); // Close the prepared statement
}

$conn->close(); // Close the database connection
?>
