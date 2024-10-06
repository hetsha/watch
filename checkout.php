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

// Fetch the cart items for the logged-in customer
$stmt = $conn->prepare("
    SELECT cart.product_id, cart.qty AS quantity, cart.p_price AS price, products.product_title
    FROM cart
    JOIN products ON cart.product_id = products.product_id
    WHERE cart.customer_id = ?
");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();

$total = 0; // Initialize total amount
$orderItems = []; // Initialize order items

if ($result->num_rows === 0) {
    header("Location: cart.php"); // Redirect to cart page if the cart is empty
    exit();
}

// Store order items and calculate total
while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row; // Collect order items
    $total += $row['price'] * $row['quantity']; // Calculate total
}

$stmt->close(); // Close the prepared statement

// Store total in session to access in checkout
$_SESSION['cart_total'] = $total; // Store total for later use in checkout

// Function to generate a unique 6-digit invoice number
function generateInvoiceNumber($conn) {
    while (true) {
        $invoiceNumber = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // Generate a random 6-digit number
        $stmt = $conn->prepare("SELECT COUNT(*) FROM invoices WHERE invoice_number = ?");
        $stmt->bind_param("s", $invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        // If the invoice number does not exist, return it
        if ($count == 0) {
            return $invoiceNumber;
        }
    }
}

// Handle form submission for placing an order
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and prepare inputs
    $address = htmlspecialchars(trim($_POST['customer_address']));
    $city = htmlspecialchars(trim($_POST['customer_city']));
    $state = htmlspecialchars(trim($_POST['state']));
    $zip = htmlspecialchars(trim($_POST['zip_code']));
    $contact = htmlspecialchars(trim($_POST['customer_contact']));
    $phone = htmlspecialchars(trim($_POST['phone_number']));
    $payment_mode = htmlspecialchars(trim($_POST['payment_mode']));

    // Update customer details in customers table
    $stmt = $conn->prepare("
        UPDATE customers SET
            customer_address = ?, customer_city = ?, state = ?, zip_code = ?, customer_contact = ?, phone_number = ?
        WHERE customer_id = ?
    ");
    $stmt->bind_param("ssssssi", $address, $city, $state, $zip, $contact, $phone, $customerID);

    // Execute the update query
    if (!$stmt->execute()) {
        echo "Error updating customer details: " . $stmt->error;
        exit();
    }
    $stmt->close();

    // Generate a unique invoice number
    $invoice_number = generateInvoiceNumber($conn);

    // Insert invoice into the invoices table
    $stmt = $conn->prepare("INSERT INTO invoices (invoice_number, customer_id, order_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("si", $invoice_number, $customerID);
    if ($stmt->execute()) {
        $invoice_id = $stmt->insert_id; // Get the last inserted invoice ID
    } else {
        echo "Error inserting invoice: " . $stmt->error;
        exit();
    }

    // Use the session total for the order
    $total = $_SESSION['cart_total'];

    // Insert order details into customer_orders
    $stmt = $conn->prepare("
        INSERT INTO customer_orders (customer_id, order_total, invoice_id, order_date)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->bind_param("idi", $customerID, $total, $invoice_id); // Use total from session here
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id; // Get the last inserted order ID
    } else {
        echo "Error inserting order: " . $stmt->error;
        exit();
    }

    // Loop through each order item and insert into the order_items table
    foreach ($orderItems as $item) {
        $stmt = $conn->prepare("
            INSERT INTO order_items (order_id, product_id, qty, price)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $stmt->execute();
    }

    // Insert into the pending_orders table
    $stmt = $conn->prepare("
        INSERT INTO pending_orders (order_id, customer_id, order_total, order_date, payment_method)
        VALUES (?, ?, ?, NOW(), ?)
    ");
    $stmt->bind_param("iids", $order_id, $customerID, $total, $payment_mode); // Use total from session here
    $stmt->execute();

    // Insert payment details into the payments table
    $stmt = $conn->prepare("
        INSERT INTO payments (invoice_id, amount, payment_mode, ref_no, payment_date)
        VALUES (?, ?, ?, ?, NOW())
    ");
    $ref_no = 'REF' . $order_id; // Generate a reference number
    $stmt->bind_param("idss", $invoice_id, $total, $payment_mode, $ref_no);
    if ($stmt->execute()) {
        // Payment successful, clear the cart
        $stmt = $conn->prepare("DELETE FROM cart WHERE customer_id = ?");
        $stmt->bind_param("i", $customerID);
        $stmt->execute();

        // Redirect to success page or order confirmation page
        header("Location: order_confirmation.php?order_id=" . $order_id);
        exit();
    } else {
        echo "Error inserting payment details: " . $stmt->error;
        exit();
    }

    $stmt->close(); // Close the prepared statement
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ORA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <main class="container">
        <h2>Checkout</h2>
        <form method="POST" action="">
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
                <select class="form-select" id="payment_mode" name="payment_mode" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="net_banking">Net Banking</option>
                    <option value="cash_on_delivery">Cash on Delivery</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>

        <h3>Order Summary</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $item) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($item['price']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total Amount: ₹<?php echo htmlspecialchars($total); ?></h4>
    </main>
    <?php include 'include/footer.php'; ?>
</body>

</html>
