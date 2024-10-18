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

    // Use the session total for the order
    $total = $_SESSION['cart_total'];

    // Insert order details into customer_orders without invoice_id
    $stmt = $conn->prepare("
        INSERT INTO customer_orders (customer_id, order_total, order_date)
        VALUES (?, ?, NOW())
    ");
    $stmt->bind_param("id", $customerID, $total);
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id; // Get the last inserted order ID
    } else {
        echo "Error inserting order: " . $stmt->error;
        exit();
    }

    // Generate a unique invoice number
    $invoice_number = generateInvoiceNumber($conn);

    // Insert invoice into the invoices table
    $stmt = $conn->prepare("INSERT INTO invoices (invoice_number, customer_id, order_id, order_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sii", $invoice_number, $customerID, $order_id); // Bind the invoice number, customer ID, and order ID
    if ($stmt->execute()) {
        $invoice_id = $stmt->insert_id; // Get the last inserted invoice ID
    } else {
        echo "Error inserting invoice: " . $stmt->error;
        exit();
    }

    // Update the customer_orders table with the invoice_id
    $stmt = $conn->prepare("UPDATE customer_orders SET invoice_id = ? WHERE order_id = ?");
    $stmt->bind_param("ii", $invoice_id, $order_id);
    if (!$stmt->execute()) {
        echo "Error updating customer_orders with invoice_id: " . $stmt->error;
        exit();
    }
    $stmt->close();

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
    $stmt->bind_param("iids", $order_id, $customerID, $total, $payment_mode);
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" href="assets/img/favicon.png" sizes="32x32" />
    <link rel="icon" href="assets/img/favicon.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/assets/img/favicon.png" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        .btn-primary {
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #004085;
        }

        input,
        select {
            transition: border 0.3s ease;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
        }
    </style>
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <main class="wrapper">
        <section class="hero blog-hero">
            <div class="container-fluid">
                <h2>Checkout</h2>
                <p>Review your order and enter your billing information.</p>
            </div>
        </section>
        <section class="order-details">
            <div class="container">
                <br>
                <h3>Order Summary</h3>
                <table class="table table-bordered">
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
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total Amount</strong></td>
                            <td><strong>₹<?php echo htmlspecialchars($total); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <h4>Billing Information</h4>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="customer_address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="customer_address" id="customer_address" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_city" class="form-label">City</label>
                        <input type="text" class="form-control" name="customer_city" id="customer_city" required>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" name="state" id="state" required>
                    </div>
                    <div class="mb-3">
                        <label for="zip_code" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" name="zip_code" id="zip_code" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_contact" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" name="customer_contact" id="customer_contact" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" id="phone_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_mode" class="form-label">Payment Mode</label>
                        <select class="form-select" name="payment_mode" id="payment_mode" required>
                            <option value="" disabled selected>Select Payment Mode</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="Net Banking">Net Banking</option>
                            <option value="UPI">UPI</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Place Order</button>
                </form>
            </div>
        </section>
    </main>
    <br>
    <?php
    include 'include/news.php';
    include 'include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>