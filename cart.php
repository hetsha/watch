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

$customerID = (int)$_SESSION['customer_id']; // Ensure customer_id is available in session
$total = 0;

// Fetch cart items for the logged-in customer
$stmt = $conn->prepare("SELECT c.cart_id, c.qty AS quantity, c.p_price AS p_price, p.product_id, p.product_title AS title, p.product_img1 AS image FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.customer_id = ?");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();

// Initialize cart_id as null
$cart_id = null;

if ($result && $result->num_rows > 0) {
    // Get the first product to set the cart_id
    $firstProduct = $result->fetch_assoc();
    $cart_id = $firstProduct['cart_id']; // Set cart_id from the first product

    // Rewind the result set to use it in the table
    $result->data_seek(0); // Go back to the beginning of the result set

    while ($product = $result->fetch_assoc()) {
        // Check if required data is present
        if (isset($product['p_price'], $product['quantity'], $product['title'], $product['image'], $product['cart_id'])) {
            $subtotal = $product['p_price'] * $product['quantity'];
            $total += $subtotal;
        }
    }
} else {
   // echo "<script>alert('cart is empty!');</script>";
    //header("Location: products.php");
    //echo "<tr><td colspan='6'>Your cart is empty.</td></tr>";
}

$stmt->close(); // Close the prepared statement
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - ORA</title>
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
                    <h2>#Shopping Cart</h2>
                    <p>Thank you for choosing ORA, for the checkout/payment see details below!</p>
                </div>
            </div>
        </section>
        <section class="cart">
            <div class="container">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Remove</td>
                                <td>Image</td>
                                <td>Product</td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td>Subtotal</td>
                            </tr>
                        </thead>
                        <tbody id="cart">
                        <?php
                        // Re-execute the query to populate the cart table after calculating total
                        $stmt = $conn->prepare("SELECT c.cart_id, c.qty AS quantity, c.p_price AS p_price, p.product_id, p.product_title AS title, p.product_img1 AS image FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.customer_id = ?");
                        $stmt->bind_param("i", $customerID);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($product = $result->fetch_assoc()) {
                            // Check if required data is present
                            if (isset($product['p_price'], $product['quantity'], $product['title'], $product['image'], $product['cart_id'])) {
                                $subtotal = $product['p_price'] * $product['quantity'];
                        ?>
                                <tr>
                                    <td>
                                        <a href="remove_from_cart.php?id=<?php echo $product['cart_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                                    </td>
                                    <td>
                                        <img src="admin/product_images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" width="50" class="img-thumbnail">
                                    </td>
                                    <td><?php echo htmlspecialchars($product['title']); ?></td>
                                    <td><?php echo number_format($product['p_price'], 2); ?>&#8360;</td>
                                    <td>
                                        <form action="update_cart.php" method="POST" class="d-flex align-items-center">
                                            <input type="hidden" name="cart_id" value="<?php echo $product['cart_id']; ?>">
                                            <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm">-</button>
                                            <input type="number" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" min="1" class="form-control mx-1" style="width: 60px; text-align: center;" readonly>
                                            <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm">+</button>
                                        </form>
                                    </td>
                                    <td><?php echo number_format($subtotal, 2); ?>&#8360;</td>
                                </tr>
                        <?php
                            } else {
                                echo "<tr><td colspan='6'>Error: Incomplete product data.</td></tr>";
                            }
                        }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right">Total:</td>
                                <td><?php echo number_format($total, 2); ?>&#8360;</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
        <section class="cart-add">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 cupon">
                        <h3>Apply Coupon</h3>
                        <div>
                            <form action="apply_coupon.php" method="POST">
                                <input type="text" name="coupon_code" placeholder="Enter your coupon code" />
                                <button type="submit" class="btn-normal">Apply</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 subtotal">
                        <h3>Cart Total</h3>
                        <table class="table table-striped">
                            <tr>
                                <td class="text-right">Total:</td>
                                <td><?php echo number_format($total, 2); ?>&#8360;</td>
                            </tr>
                            <tr>
                                <td>Shipping:</td>
                                <td>Free</td>
                            </tr>
                        </table>
                        <a href="checkout.php?customer_id=<?php echo $_SESSION['customer_id']; ?>" class="btn-normal">Proceed to Checkout</a>
                        <a href="view_orders.php?customer_id=<?php echo $customerID; ?>" class="btn-normal">view orders </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="newsletter">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-8">
                        <div class="newstext">
                            <h4>Sign Up For Newsletters!</h4>
                            <p>Get E-Mail updates about our Latest Products and <span>special offers</span>.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="n-form">
                            <form>
                                <input type="text" placeholder="Your E-Mail Address...">
                                <button class="btn-normal">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
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

