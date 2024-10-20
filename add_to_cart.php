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

// Initialize variables
$productID = 0;
$qty = 1; // Default quantity
$customerID = isset($_SESSION['customer_id']) ? (int)$_SESSION['customer_id'] : 0;
$redirectToCart = false; // Flag to check if we should redirect to cart

// Check if request is POST (from Buy Now or Add to Cart button)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    // Get product ID and quantity from form
    $productID = (int)$_POST['product_id'];
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Determine if the request is from "Buy Now" or "Add to Cart"
    if (isset($_POST['action']) && $_POST['action'] === 'buy_now') {
        $redirectToCart = true; // Set flag for Buy Now action
    }
}
// Check if request is GET (e.g., Add to Cart from a link)
elseif (isset($_GET['product_id'])) {
    // Get product ID and quantity from link
    $productID = (int)$_GET['product_id'];
    $qty = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;
}

// Proceed if product ID is valid
if ($productID > 0) {
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
            $newQty = $cartItem['qty'] + $qty;
            $updateStmt = $conn->prepare("UPDATE cart SET qty = ? WHERE cart_id = ?");
            $updateStmt->bind_param("ii", $newQty, $cartItem['cart_id']);
            $updateStmt->execute();
            $updateStmt->close();
            $_SESSION['message'] = 'Product quantity updated in cart!';
        } else {
            // Insert new product into cart
            $insertStmt = $conn->prepare("INSERT INTO cart (customer_id, product_id, qty, p_price) VALUES (?, ?, ?, ?)");
            $insertStmt->bind_param("iiid", $customerID, $product['product_id'], $qty, $product['product_psp_price']);
            $insertStmt->execute();
            $insertStmt->close();
            $_SESSION['message'] = 'Product added to cart!';
        }
    } else {
        $_SESSION['message'] = 'Product not found.';
    }
    $stmt->close(); // Close the prepared statement
} else {
    $_SESSION['message'] = 'Invalid product ID.';
}

// Conditional redirect based on the request method
if ($redirectToCart) {
    // If "Buy Now" (POST), redirect to cart after a delay
    echo "<script type='text/javascript'>
        setTimeout(function(){
            window.location.href = 'cart.php';
        }, 2000); // 2 second delay before redirecting to cart
    </script>";
    echo "<h1>{$_SESSION['message']}</h1>";
    echo "<p>Redirecting you to the cart...</p>";
} else {
    // If "Add to Cart" (POST or GET), redirect back to the same page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
