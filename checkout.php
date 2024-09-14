<?php
session_start();
include 'include/db.php'; // Ensure you include your DB connection here

// Initialize cart if not set
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$total = 0;

// Calculate total
foreach ($_SESSION['cart'] as $product) {
    if (isset($product['price']) && isset($product['quantity'])) {
        $total += $product['price'] * $product['quantity'];
    } else {
        // Handle missing product data
        echo "Error: Product data is incomplete.";
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    // Check if customer_id is set
    if (isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id'])) {
        // Insert customer order into the customer_orders table
        $stmt = $con->prepare("INSERT INTO customer_orders (customer_id, order_date, due_amount, order_status) VALUES (?, ?, ?, ?)");
        $order_date = date('Y-m-d H:i:s');
        $order_status = 'Pending';
        $stmt->bind_param("isss", $_SESSION['customer_id'], $order_date, $total, $order_status);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit();
        }
        $order_id = $stmt->insert_id;

        // Insert payment method into the payments table
        $stmt = $con->prepare("INSERT INTO payments (invoice_no, amount, payment_mode) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $order_id, $total, $payment_method);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit();
        }

        // Insert order items into the pending_orders table
        foreach ($_SESSION['cart'] as $product) {
            if (isset($product['id']) && isset($product['quantity'])) {
                $stmt = $con->prepare("INSERT INTO pending_orders (order_id, customer_id, product_id, qty) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiii", $order_id, $_SESSION['customer_id'], $product['id'], $product['quantity']);
                if (!$stmt->execute()) {
                    echo "Error: " . $stmt->error;
                    exit();
                }
            } else {
                // Handle missing product data
                echo "Error: Product data is incomplete.";
                exit();
            }
        }

        // Retrieve order details
        $stmt = $con->prepare("SELECT p.product_title, po.qty, p.product_price FROM pending_orders po JOIN products p ON po.product_id = p.product_id WHERE po.order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order_details = $result->fetch_all(MYSQLI_ASSOC);

        // Clear the cart
        unset($_SESSION['cart']);

        // Redirect to a confirmation page or display order details
        // For example:
        // header("Location: confirmation.php?order_id=$order_id");
        // exit();
    } else {
        echo "Error: Customer ID is missing.";
        exit();
    }
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
</head>
<body>

    <?php include 'include/navbar.php'; ?>

    <main class="wrapper">
        <section class="checkout">
            <div class="container">
                <h2>Checkout</h2>
                <form method="POST" action="checkout.php">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Billing Information</h4>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4>Your Order</h4>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                        foreach ($_SESSION['cart'] as $product) {
                                            $subtotal = $product['price'] * $product['quantity'];
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($product['title']); ?></td>
                                            <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                                            <td><?php echo number_format($product['price'], 2); ?>&#8360;</td>
                                            <td><?php echo number_format($subtotal, 2); ?>&#8360;</td>
                                        </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>Cart is empty or not set.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right">Total:</td>
                                        <td><?php echo number_format($total, 2); ?>&#8360;</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <button type="submit" class="btn-normal">Place Order</button>
                </form>
            </div>
        </section>
    </main>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
