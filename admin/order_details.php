<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('../login.php','_self')</script>";
} else {
    if (isset($_GET['order_id'])) {
        $order_id = $_GET['order_id'];

        // Fetch order details
        $get_orders = "
        SELECT
            po.order_id, po.customer_id, po.order_status,
            co.invoice_id, co.order_date,
            c.customer_email,
            c.customer_name, c.customer_address, c.customer_contact, c.phone_number,
            GROUP_CONCAT(p.product_title SEPARATOR ', ') AS product_titles,
            GROUP_CONCAT(oi.qty SEPARATOR ', ') AS quantities,
            SUM(oi.qty * oi.price) AS total_amount
        FROM pending_orders po
        JOIN customer_orders co ON po.order_id = co.order_id
        JOIN customers c ON po.customer_id = c.customer_id
        JOIN order_items oi ON po.order_id = oi.order_id
        JOIN products p ON oi.product_id = p.product_id
        WHERE po.order_id = '$order_id'  -- Ensure you're filtering by order_id
        GROUP BY po.order_id
        ";

        $run_order_details = mysqli_query($con, $get_orders);

        if (mysqli_num_rows($run_order_details) > 0) {
            $row_order_details = mysqli_fetch_array($run_order_details);

            // Use the correct column names from your query
            $invoice_number = $row_order_details['invoice_id'] ?? 'N/A';  // Update this line if invoice_id is not the right column
            $order_date = $row_order_details['order_date'] ?? 'N/A';
            $customer_email = $row_order_details['customer_email'] ?? 'N/A';
            $customer_name = $row_order_details['customer_name'] ?? 'N/A';
            $customer_address = $row_order_details['customer_address'] ?? 'N/A';
            $customer_contact = $row_order_details['customer_contact'] ?? 'N/A';
            $phone_number = $row_order_details['phone_number'] ?? 'N/A';
            $product_titles = $row_order_details['product_titles'] ?? 'N/A';
            $quantities = $row_order_details['quantities'] ?? 'N/A';
            $total_amount = $row_order_details['total_amount'] ?? 0;
            $order_status = $row_order_details['order_status'] ?? 'N/A';
            $payment_mode = $row_order_details['payment_mode'] ?? 'N/A';  // Ensure this is included in your SELECT statement
            $payment_date = $row_order_details['payment_date'] ?? 'N/A';  // Ensure this is included in your SELECT statement
        } else {
            // No order details found
            echo "<script>alert('No order details found for this order ID.');</script>";
            exit; // Exit if no details found
        }
    }
?>
<div class="container"><!-- Container Starts -->
    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <h2>Order Details</h2>
            <div class="table-responsive"><!-- table-responsive Starts -->
                <table class="table table-striped table-bordered"><!-- table Starts -->
                    <thead class="thead-dark"><!-- thead Starts -->
                        <tr>
                            <th>Field</th>
                            <th>Details</th>
                        </tr>
                    </thead><!-- thead Ends -->
                    <tbody><!-- tbody Starts -->
                        <tr>
                            <td>Invoice Number:</td>
                            <td><?php echo $invoice_number; ?></td>
                        </tr>
                        <tr>
                            <td>Order Date:</td>
                            <td><?php echo $order_date; ?></td>
                        </tr>
                        <tr>
                            <td>Customer Email:</td>
                            <td><?php echo $customer_email; ?></td>
                        </tr>
                        <tr>
                            <td>Customer Name:</td>
                            <td><?php echo $customer_name; ?></td>
                        </tr>
                        <tr>
                            <td>Customer Address:</td>
                            <td><?php echo $customer_address; ?></td>
                        </tr>
                        <tr>
                            <td>Customer Contact:</td>
                            <td><?php echo $customer_contact; ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number:</td>
                            <td><?php echo $phone_number; ?></td>
                        </tr>
                        <tr>
                            <td>Products:</td>
                            <td><?php echo $product_titles; ?></td>
                        </tr>
                        <tr>
                            <td>Quantities:</td>
                            <td><?php echo $quantities; ?></td>
                        </tr>
                        <tr>
                            <td>Total Amount:</td>
                            <td>$<?php echo number_format($total_amount, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Order Status:</td>
                            <td><?php echo ($order_status == 'pending') ? 'Pending' : 'Complete'; ?></td>
                        </tr>
                        <tr>
                            <td>Payment Mode:</td>
                            <td><?php echo $payment_mode; ?></td>
                        </tr>
                        <tr>
                            <td>Payment Date:</td>
                            <td><?php echo $payment_date; ?></td>
                        </tr>
                    </tbody><!-- tbody Ends -->
                </table><!-- table Ends -->
            </div><!-- table-responsive Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 1 row Ends -->
</div><!-- Container Ends -->
<?php } ?>
