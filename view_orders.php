<?php
session_start();
include 'include/db.php'; // Use the connection from this file

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$customerID = (int)$_SESSION['customer_id'];

// Fetch past orders for the logged-in customer
$stmt = $con->prepare("
    SELECT o.order_id, i.invoice_number, o.order_date, o.order_total, o.order_status
    FROM customer_orders o
    JOIN invoices i ON o.invoice_id = i.invoice_id
    WHERE o.customer_id = ?
");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
        <br>
        <section class="orders">
            <div class="container">
                <div class="row">

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Invoice ID</th>
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
            <td>
                <a href='order_confirmation.php?order_id={$order['order_id']}'>
                    {$order['order_id']}
                </a>
            </td> <!-- Link to Order Confirmation -->
            <td>click to get info<a href='order_confirmation.php?order_id={$order['order_id']}' style='color: blue; text-decoration: underline;'>{$order['invoice_number']}</a></td> <!-- Link to Invoice ID -->
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
                <form action="">
                <button type="button" class="btn btn-primary" onclick="window.location.href='cart.php';" style="color:blue;">Go To Cart</button>
            </form>
            <br>
            </div>
        </section>

        <?php
        include 'include/news.php';
        ?>
    </main>
    <?php include 'include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>

<?php
  // Close the prepared statement
  // Close the database connection
?>
