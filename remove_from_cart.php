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

        // Set the quantity to 0
        if ($currentQty > 0) {
            $newQty = 0; // Set quantity to 0
            $updateStmt = $conn->prepare("UPDATE cart SET qty = ? WHERE cart_id = ?");
            $updateStmt->bind_param("ii", $newQty, $cartId);
            $updateStmt->execute();
            $updateStmt->close();

            // Optionally, you can also delete the row if you don't want to keep it in the cart
            // Uncomment the next lines if you want to delete the entry after setting quantity to 0
             $deleteStmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ?");
             $deleteStmt->bind_param("i", $cartId);
             $deleteStmt->execute();
            $deleteStmt->close();
        }
    }
    $stmt->close(); // Close the prepared statement
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
