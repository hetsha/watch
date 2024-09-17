<?php

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {

?>

<div class="row"><!-- 1 row Starts -->

    <div class="col-lg-12"><!-- col-lg-12 Starts -->

        <ol class="breadcrumb"><!-- breadcrumb Starts  --->

            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Orders
            </li>

        </ol><!-- breadcrumb Ends  --->

    </div><!-- col-lg-12 Ends -->

</div><!-- 1 row Ends -->


<div class="row"><!-- 2 row Starts -->

    <div class="col-lg-12"><!-- col-lg-12 Starts -->

        <div class="panel panel-default"><!-- panel panel-default Starts -->

            <div class="panel-heading"><!-- panel-heading Starts -->

                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> View Orders
                </h3>

            </div><!-- panel-heading Ends -->

            <div class="panel-body"><!-- panel-body Starts -->

                <div class="table-responsive"><!-- table-responsive Starts -->

                    <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->

                        <thead><!-- thead Starts -->

                        <tr>
                            <th>Order No:</th>
                            <th>Customer Email:</th>
                            <th>Invoice No:</th>
                            <th>Product Title:</th>
                            <th>Product Qty:</th>
                            <th>Product Size:</th>
                            <th>Order Date:</th>
                            <th>Total Amount:</th>
                            <th>Order Status:</th>
                            <th>Delete Order:</th>
                        </tr>

                        </thead><!-- thead Ends -->


                        <tbody><!-- tbody Starts -->

                        <?php

                        $i = 0;

                        // Debugging: print the query
                        $get_orders = "
                            SELECT
                                po.order_id, po.customer_id, po.product_id, po.qty, po.size, po.order_status,
                                co.invoice_no, co.order_date, co.due_amount,
                                c.customer_email, p.product_title
                            FROM pending_orders po
                            JOIN customer_orders co ON po.order_id = co.order_id
                            JOIN customers c ON po.customer_id = c.customer_id
                            JOIN products p ON po.product_id = p.product_id
                        ";

                        // Debugging: output the query for inspection
                        echo "<p>SQL Query: " . htmlspecialchars($get_orders) . "</p>";

                        $run_orders = mysqli_query($con, $get_orders);

                        if (!$run_orders) {
                            // Debugging: print MySQL error
                            echo "<p>Error: " . mysqli_error($con) . "</p>";
                        }

                        while ($row_orders = mysqli_fetch_array($run_orders)) {
                            $i++;
                            $order_id = $row_orders['order_id'];
                            $customer_email = $row_orders['customer_email'];
                            $invoice_no = $row_orders['invoice_no'];
                            $product_title = $row_orders['product_title'];
                            $qty = $row_orders['qty'];
                            $size = $row_orders['size'];
                            $order_date = $row_orders['order_date'];
                            $due_amount = $row_orders['due_amount'];
                            $order_status = $row_orders['order_status'];

                            // Debugging log to check if invoice_no is fetched correctly
                            echo "<script>console.log('Invoice No for Order $order_id: " . $invoice_no . "');</script>";
                        ?>

                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $customer_email; ?></td>
                            <td bgcolor="yellow"><?php echo ($invoice_no != '') ? $invoice_no : 'N/A'; ?></td>
                            <td><?php echo $product_title; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $size; ?></td>
                            <td><?php echo $order_date; ?></td>
                            <td>$<?php echo $due_amount; ?></td>
                            <td>
                                <?php echo ($order_status == 'pending') ? 'Pending' : 'Complete'; ?>
                            </td>
                            <td>
                                <a href="index.php?order_delete=<?php echo $order_id; ?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>
                        </tr>

                        <?php } ?>

                        </tbody><!-- tbody Ends -->

                    </table><!-- table table-bordered table-hover table-striped Ends -->

                </div><!-- table-responsive Ends -->

            </div><!-- panel-body Ends -->

        </div><!-- panel panel-default Ends -->

    </div><!-- col-lg-12 Ends -->

</div><!-- 2 row Ends -->


<?php } ?>
