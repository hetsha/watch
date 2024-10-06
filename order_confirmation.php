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

// Get order ID from the URL
$order_id = (int)$_GET['order_id'];

// Fetch order details along with the invoice number
$stmt = $conn->prepare("
    SELECT o.order_id, o.order_total, o.order_date, i.invoice_number,
           c.customer_name, c.customer_email, c.customer_address,
           c.customer_city, c.state, c.zip_code,
           c.customer_contact, c.phone_number
    FROM customer_orders o
    JOIN customers c ON o.customer_id = c.customer_id
    JOIN invoices i ON o.invoice_id = i.invoice_id  -- Join to get invoice number
    WHERE o.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Order not found.");
}

$orderDetails = $result->fetch_assoc();
$stmt->close();

// Fetch order items
$stmt = $conn->prepare("
    SELECT oi.product_id, p.product_title, oi.qty, oi.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$orderItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - ORA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <?php include 'include/fav.php'; ?>
</head>
<body>
    <?php include 'include/navbar.php'; ?>
    <main class="wrapper">
        <section class="hero blog-hero">
            <div class="container-fluid">
                <h2>Order Confirmation</h2>
                <p>Your order has been placed successfully!</p>
            </div>
        </section>
        <section class="order-details">
            <div class="container">
                <h3>Order Summary</h3>
                <p><strong>Order ID:</strong> <?php echo htmlspecialchars($orderDetails['order_id']); ?></p>
                <p><strong>Invoice Number:</strong> <?php echo htmlspecialchars($orderDetails['invoice_number']); ?></p> <!-- Added invoice number -->
                <p><strong>Name:</strong> <?php echo htmlspecialchars($orderDetails['customer_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($orderDetails['customer_email']); ?></p>
                <p><strong>Total Amount:</strong> ₹<?php echo htmlspecialchars($orderDetails['order_total']); ?></p>
                <p><strong>Order Date:</strong> <?php echo htmlspecialchars($orderDetails['order_date']); ?></p>

                <h4>Shipping Address</h4>
                <p><?php echo htmlspecialchars($orderDetails['customer_address']); ?></p>
                <p><?php echo htmlspecialchars($orderDetails['customer_city']); ?>, <?php echo htmlspecialchars($orderDetails['state']); ?>, <?php echo htmlspecialchars($orderDetails['zip_code']); ?></p>
                <p><strong>Contact:</strong> <?php echo htmlspecialchars($orderDetails['customer_contact']); ?> | <strong>Phone:</strong> <?php echo htmlspecialchars($orderDetails['phone_number']); ?></p>

                <h4>Order Items</h4>
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
                                <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['qty'] * $item['price']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="mb-3">
                    <a href="download_invoice.php?order_id=<?php echo $order_id; ?>" class="btn btn-primary">Download Invoice</a>
                </div>

            </div>
        </section>

        <?php
                include 'include/news.php';
            ?>
    </main>
    <?php include 'include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
