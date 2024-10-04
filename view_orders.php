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

$customerID = (int)$_SESSION['customer_id'];

// Fetch past orders for the logged-in customer
$stmt = $conn->prepare("SELECT order_id, invoice_id, order_date, order_total, order_status FROM customer_orders WHERE customer_id = ?");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Past Orders - ORA</title>
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
                    <h2>#Your Past Orders</h2>
                    <p>Here are the details of your past orders.</p>
                </div>
            </div>
        </section>
        <section class="orders">
            <div class="container">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Invoice ID</th> <!-- Changed from Invoice Number to Invoice ID -->
                                <th>Order Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($order = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td><a href='order_confirmation.php?order_id={$order['order_id']}' class='text-decoration-none'>{$order['order_id']}</a></td> <!-- Link to Order Confirmation -->
                                    <td>{$order['invoice_id']}</td> <!-- Display Invoice ID -->
                                    <td>" . date("Y-m-d H:i:s", strtotime($order['order_date'])) . "</td>
                                    <td>&#8360;" . number_format($order['order_total'], 2) . "</td>
                                    <td>" . htmlspecialchars($order['order_status']) . "</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No past orders found.</td></tr>"; // Adjusted colspan to 5
                        }
                        ?>
                        </tbody>
                    </table>
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
$stmt->close(); // Close the prepared statement
$conn->close(); // Close the database connection
?>
