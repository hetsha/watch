<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecom_store";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if product ID is received from POST request
if (isset($_POST['product_id'])) {
    $productID = $_POST['product_id'];

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
        $sql = "SELECT product_id, product_title, product_price, product_img1 FROM products WHERE product_id = '$productID'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            // Add the product to the cart session
            $_SESSION['cart'][$productID] = [
                'id' => $product['product_id'],
                'title' => $product['product_title'],
                'price' => $product['product_price'],
                'image' => $product['product_img1'],
                'quantity' => 1
            ];
        }
    }

    // Redirect to the cart page
    header("Location: cart.php");
    exit();
} else {
    echo "Invalid product ID.";
}

$conn->close();
?>
