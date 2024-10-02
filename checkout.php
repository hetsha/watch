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

// Validate cart_id is set
$cart_id = isset($_GET['cart_id']) ? (int)$_GET['cart_id'] : null;
$customerID = (int)$_SESSION['customer_id']; // Ensure customer_id is available in session
$total = 0;

// Check if the cart is empty
$stmt = $conn->prepare("SELECT * FROM cart WHERE cart_id = ? AND customer_id = ?");
$stmt->bind_param("ii", $cart_id, $customerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: cart.php"); // Redirect to cart if it's empty
    exit();
}

// Fetch order items for the logged-in customer
$orderItems = [];
while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row; // Collect order items
    $total += $row['p_price'] * $row['qty']; // Calculate total
}

$stmt->close(); // Close the prepared statement

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and prepare inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $city = htmlspecialchars($_POST['city']);
    $state = htmlspecialchars($_POST['state']);
    $zip = htmlspecialchars($_POST['zip']);
    $payment_method = htmlspecialchars($_POST['payment_method']);

    // Insert order details
    $stmt = $conn->prepare("INSERT INTO customer_orders (customer_id, order_total, order_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("id", $customerID, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Get the last inserted order id

    // Insert order items
    foreach ($orderItems as $item) {
        $stmt = $conn->prepare("INSERT INTO pending_orders (order_id, product_id, qty, p_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['qty'], $item['p_price']);
        $stmt->execute();
    }

    // Clear cart after successful order
    $stmt = $conn->prepare("DELETE FROM cart WHERE customer_id = ?");
    $stmt->bind_param("i", $customerID);
    $stmt->execute();

    // Redirect to order confirmation page or display a success message
    header("Location: order_confirmation.php?order_id=$order_id");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ORA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <?php include 'include/fav.php'; ?>
</head>
<body>
    <?php include 'include/navbar.php'; ?>
    <main class="wrapper">
        <section class="hero blog-hero">
            <div class="container-fluid">
                <div class="row">
                    <h2>Checkout</h2>
                    <p>Please fill in your details to complete your order.</p>
                </div>
            </div>
        </section>
        <section class="checkout">
            <div class="container">
                <h3>Order Details</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($item['qty']); ?></td>
                                <td><?php echo htmlspecialchars($item['p_price']); ?></td>
                                <td><?php echo htmlspecialchars($item['p_price'] * $item['qty']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end">Total:</td>
                            <td><?php echo htmlspecialchars($total); ?></td>
                        </tr>
                    </tbody>
                </table>

                <form action="" method="POST">
                    <h3>Billing Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                            <div class="mb-3">
                                <label for="zip" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="zip" name="zip" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3>Payment Method</h3>
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Select Payment Method</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="">Select a method</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="debit_card">Debit Card</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-normal">Place Order</button>
                </form>
            </div>
        </section>
    </main>
    <?php include 'include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
