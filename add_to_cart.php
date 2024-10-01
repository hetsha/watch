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
// Check if product ID is received from POST request
if (isset($_POST['product_id'])) {
    $productID = (int)$_POST['product_id']; // Cast to integer to avoid SQL injection
    $customerID = isset($_SESSION['customer_id']) ? (int)$_SESSION['customer_id'] : 0; // Ensure customer_id is available in session
    // Determine the quantity to use
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Default to 1 if quantity is not set
    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT product_id, product_title, product_psp_price FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // Check if the product is already in the cart
        $cartCheck = $conn->prepare("SELECT * FROM cart WHERE customer_id = ? AND product_id = ?");
        $cartCheck->bind_param("ii", $customerID, $productID);
        $cartCheck->execute();
        $cartResult = $cartCheck->get_result();
        if ($cartResult->num_rows > 0) {
            // Update quantity if the product already exists in the cart
            $cartItem = $cartResult->fetch_assoc();
            $newQty = $cartItem['qty'] + $qty; // Increment quantity by the received quantity
            $updateStmt = $conn->prepare("UPDATE cart SET qty = ? WHERE cart_id = ?");
            $updateStmt->bind_param("ii", $newQty, $cartItem['cart_id']);
            $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Insert new product into cart
            $insertStmt = $conn->prepare("INSERT INTO cart (customer_id, product_id, qty, p_price) VALUES (?, ?, ?, ?)");
            $insertStmt->bind_param("iiid", $customerID, $product['product_id'], $qty, $product['product_psp_price']);
            $insertStmt->execute();
            $insertStmt->close();
        }
        // Optional: Set a session message for confirmation
        $_SESSION['message'] = 'Product added to cart!';
    } else {
        $_SESSION['message'] = 'Product not found.';
    }
    $stmt->close(); // Close the prepared statement
} else {
    $_SESSION['message'] = 'Invalid product ID.';
}
// Redirect back to the previous page (not cart.php) after adding to cart
header("Location: " . $_SERVER['HTTP_REFERER']);
exit(); // Close the database connection
?>
