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
        // Insert payment method into the payments table first
        $stmt = $con->prepare("INSERT INTO payments (amount, payment_mode) VALUES (?, ?)");
        $stmt->bind_param("ds", $total, $payment_method);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit();
        }
        $invoice_no = $stmt->insert_id; // Get the last inserted ID

        // Insert customer order into the customer_orders table
        $stmt = $con->prepare("INSERT INTO customer_orders (customer_id, order_date, due_amount, invoice_no, order_status) VALUES (?, ?, ?, ?, ?)");
        $order_date = date('Y-m-d H:i:s');
        $order_status = 'Pending';
        $stmt->bind_param("issis", $_SESSION['customer_id'], $order_date, $total, $invoice_no, $order_status);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit();
        }
        $order_id = $stmt->insert_id;

        // Insert order items into the pending_orders table
        foreach ($_SESSION['cart'] as $productID => $product) {
            if (isset($product['id']) && isset($product['quantity'])) {
                $stmt = $con->prepare("INSERT INTO pending_orders (order_id, customer_id, product_id, qty) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiii", $order_id, $_SESSION['customer_id'], $productID, $product['quantity']);
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

        // Clear the cart
        unset($_SESSION['cart']);

        // Redirect to a confirmation page or display order details
        header("Location: confirmation.php?order_id=$order_id");
        exit();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <?php include 'include/fav.php'; ?>
</head>

<body>

    <?php include 'include/navbar.php'; ?>

    <main class="wrapper">
        <section class="hero blog-hero">
            <div class="container-fluid">
                <div class="row">
                    <h2>#Checkout</h2>
                    <p>Please fill in your details to complete your order.</p>
                </div>
            </div>
        </section>

        <section class="checkout">
            <div class="container">
                <form method="POST" action="">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="payment_method" class="col-sm-2 col-form-label">Payment Method</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Debit Card">Debit Card</option>
                                <option value="Net Banking">Net Banking</option>
                                <option value="UPI">UPI</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Complete Order</button>
                        </div>
                    </div>
                </form>

                <h3>Order Summary</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Product</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Subtotal</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['cart'] as $productID => $product) {
                            $subtotal = $product['price'] * $product['quantity'];
                            ?>
                            <tr>
                                <td><?php echo $product['title']; ?></td>
                                <td><?php echo number_format($product['price'], 2); ?>&#8360;</td>
                                <td><?php echo $product['quantity']; ?></td>
                                <td><?php echo number_format($subtotal, 2); ?>&#8360;</td>
                            </tr>
                            <?php
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
        </section>
    </main>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>

