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

// Get customer ID from session
$customerID = (int)$_SESSION['customer_id'];
$total = 0; // Initialize total price

// Fetch the cart items for the logged-in customer
$stmt = $conn->prepare("
    SELECT cart.product_id, cart.qty, cart.p_price, products.product_title
    FROM cart
    JOIN products ON cart.product_id = products.product_id
    WHERE cart.customer_id = ?
");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: cart.php"); // Redirect to cart page if the cart is empty
    exit();
}

// Store order items and calculate total
$orderItems = [];
while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row; // Collect order items
    $total += $row['p_price'] * $row['qty']; // Calculate total
}

$stmt->close(); // Close the prepared statement

// Function to generate a unique 6-digit invoice number
function generateInvoiceNumber($conn) {
    $invoiceNumber = rand(100000, 999999); // Generate a random 6-digit number
    $stmt = $conn->prepare("SELECT COUNT(*) FROM customer_orders WHERE invoice_number = ?");
    $stmt->bind_param("i", $invoiceNumber);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // If the invoice number already exists, generate a new one
    return $count > 0 ? generateInvoiceNumber($conn) : $invoiceNumber;
}

// Handle form submission for placing an order
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and prepare inputs
    $customer_name = htmlspecialchars(trim($_POST['customer_name']));
    $email = htmlspecialchars(trim($_POST['customer_email']));
    $address = htmlspecialchars(trim($_POST['customer_address']));
    $city = htmlspecialchars(trim($_POST['customer_city']));
    $state = htmlspecialchars(trim($_POST['state']));
    $zip = htmlspecialchars(trim($_POST['zip_code']));
    $contact = htmlspecialchars(trim($_POST['customer_contact']));
    $phone = htmlspecialchars(trim($_POST['phone_number']));
    $payment_mode = htmlspecialchars(trim($_POST['payment_mode'])); // Updated variable name

    // Update customer details in customers table
    $stmt = $conn->prepare("
        UPDATE customers SET
            customer_name = ?,
            customer_email = ?,
            customer_address = ?,
            customer_city = ?,
            state = ?,
            zip_code = ?,
            customer_contact = ?,
            phone_number = ?
        WHERE customer_id = ?
    ");
    $stmt->bind_param("ssssssssi", $customer_name, $email, $address, $city, $state, $zip, $contact, $phone, $customerID);
    $stmt->execute();

    // Generate a unique invoice number
    $invoice_number = generateInvoiceNumber($conn);

    // Insert order details into customer_orders
    $stmt = $conn->prepare("
        INSERT INTO customer_orders (customer_id, order_total, invoice_number, order_date)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->bind_param("ids", $customerID, $total, $invoice_number);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Get the last inserted order ID

    // Insert the order into the pending_orders table
    $stmt = $conn->prepare("
        INSERT INTO pending_orders (order_id, customer_id, order_total, order_date, payment_method)
        VALUES (?, ?, ?, NOW(), ?)
    ");
    $stmt->bind_param("iids", $order_id, $customerID, $total, $payment_mode);
    $stmt->execute();

    // Insert payment details into the payments table
    $stmt = $conn->prepare("
        INSERT INTO payments (amount, payment_mode, ref_no, payment_date)
        VALUES (?, ?, ?, NOW())
    ");
    $ref_no = 'REF' . $order_id; // Generate a reference number based on the order ID
    $stmt->bind_param("dss", $total, $payment_mode, $ref_no);
    $stmt->execute();

    // Insert each item from the cart into order_items
    foreach ($orderItems as $item) {
        $stmt = $conn->prepare("
            INSERT INTO order_items (order_id, product_id, qty, price)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['qty'], $item['p_price']);
        $stmt->execute();
    }

    // Clear the cart for the customer after placing the order
    $stmt = $conn->prepare("DELETE FROM cart WHERE customer_id = ?");
    $stmt->bind_param("i", $customerID);
    $stmt->execute();

    // Redirect to order confirmation page
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
                                <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                                <td><?php echo htmlspecialchars($item['qty']); ?></td>
                                <td><?php echo htmlspecialchars(number_format($item['p_price'], 2)); ?></td>
                                <td><?php echo htmlspecialchars(number_format($item['p_price'] * $item['qty'], 2)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td class="fw-bold"><?php echo htmlspecialchars(number_format($total, 2)); ?></td>
                        </tr>
                    </tbody>
                </table>

                <form action="" method="POST">
                    <h3>Billing Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="customer_address" name="customer_address" required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_city" class="form-label">City</label>
                                <input type="text" class="form-control" id="customer_city" name="customer_city" required>
                            </div>
                            <div class="mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control" id="state" name="state" required>
                            </div>
                            <div class="mb-3">
                                <label for="zip_code" class="form-label">Zip Code</label>
                                <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                            </div>
                            <div class="mb-3">
                                <label for="customer_contact" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="customer_contact" name="customer_contact" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                            </div>
                            <div class="mb-3">
                                <label for="payment_mode" class="form-label">Payment Method</label>
                                <select id="payment_mode" name="payment_mode" class="form-select" required>
                                    <option value="cod">Cash on Delivery</option>
                                    <option value="online">Online Payment</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Place Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <?php include 'include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
