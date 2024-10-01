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
    // Use prepared statements to prevent SQL injection
    $productID = (int)$_POST['product_id']; // Cast to integer to avoid SQL injection
    // Check if the cart session exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$productID])) {
        // Increase the quantity if the product already exists
        $_SESSION['cart'][$productID]['quantity'] += 1;
    } else {
        // Fetch product details from the database
        $stmt = $conn->prepare("SELECT product_id, product_title, product_psp, product_img1 FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            // Add the product to the cart session
            $_SESSION['cart'][$productID] = [
                'id' => $product['product_id'],
                'title' => $product['product_title'],
                'price' => $product['product_psp'], // Use product_psp instead of product_price
                'image' => $product['product_img1'],
                'quantity' => 1
            ];
        } else {
            // Handle the case where the product does not exist
            echo "Product not found.";
            exit();
        }
        $stmt->close(); // Close the prepared statement
    }
    // Optional: Return a response or confirmation
    echo json_encode(['status' => 'success', 'message' => 'Product added to cart!']);
    // Redirect to the cart page
    // header("Location: cart.php"); // Uncomment this if you want to redirect after adding
    // exit();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product ID.']);
}
$conn->close(); // Close the database connection
