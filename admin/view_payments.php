<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
?>
    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / View Payments
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 1 row Ends -->
    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"></i> View Payments
                    </h3><!-- panel-title Ends -->
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <div class="table-responsive"><!-- table-responsive Starts -->
                        <table class="table table-hover table-bordered table-striped table-sm"><!-- table Starts -->
                            <thead class="thead-dark"><!-- thead Starts -->
                                <tr>
                                    <th>Payment No:</th>
                                    <th>Invoice ID:</th>
                                    <th>Order ID:</th> <!-- Added Order ID column -->
                                    <th>Amount Paid:</th>
                                    <th>Payment Method:</th>
                                    <th>Coupon:</th>
                                    <th>Payment Date:</th>
                                    <th>Delete Payment:</th>
                                </tr>
                            </thead><!-- thead Ends -->
                            <tbody><!-- tbody Starts -->
                                <?php
                                $i = 0;
                                $get_payments = "
                                    SELECT payments.*, customer_orders.order_id
                                    FROM payments
                                    JOIN customer_orders ON payments.invoice_id = customer_orders.invoice_id"; // Corrected query

                                $run_payments = mysqli_query($con, $get_payments);

                                if ($run_payments) { // Check if the query executed successfully
                                    while ($row_payments = mysqli_fetch_array($run_payments)) {
                                        $payment_id = $row_payments['payment_id'];
                                        $invoice_id = isset($row_payments['invoice_id']) ? $row_payments['invoice_id'] : 'N/A';
                                        $order_id = isset($row_payments['order_id']) ? $row_payments['order_id'] : 'N/A'; // Get order_id
                                        $amount = $row_payments['amount'];
                                        $payment_mode = $row_payments['payment_mode'];
                                        $coupon = isset($row_payments['coupon']) ? $row_payments['coupon'] : 'N/A';
                                        $payment_date = $row_payments['payment_date'];
                                        $i++;
                                ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $invoice_id; ?></td> <!-- Removed link from Invoice ID -->
                                            <td>
                                                <a href="../order_confirmation.php?order_id=<?php echo $order_id; ?>" class="text-primary">
                                                    <?php echo $order_id; ?>
                                                </a> <!-- Added link to Order ID -->
                                            </td>
                                            <td>$<?php echo number_format($amount, 2); ?></td>
                                            <td><?php echo ucfirst($payment_mode); ?></td>
                                            <td><?php echo $coupon; ?></td>
                                            <td><?php echo date('Y-m-d H:i:s', strtotime($payment_date)); ?></td>
                                            <td>
                                                <a href="index.php?payment_delete=<?php echo $payment_id; ?>" class="text-danger">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>Error fetching payments: " . mysqli_error($con) . "</td></tr>";
                                }
                                ?>
                            </tbody><!-- tbody Ends -->
                        </table><!-- table Ends -->
                    </div><!-- table-responsive Ends -->
                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 2 row Ends -->
<?php } ?>
