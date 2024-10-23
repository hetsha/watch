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
                                <th>Invoice ID:</th>
                                <th>Products:</th>
                                <th>Quantities:</th>
                                <th>Order Date:</th>
                                <th>Total Amount:</th>
                                <th>Order Status:</th>
                                <th>Delete Order:</th>
                            </tr>
                        </thead><!-- thead Ends -->

                        <tbody><!-- tbody Starts -->
                            <?php
                            // Pagination Logic
                            $limit = 10; // Orders per page
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }
                            $offset = ($page - 1) * $limit;

                            // Get total number of orders for pagination
                            $total_orders_query = "SELECT COUNT(*) FROM pending_orders";
                            $result_total = mysqli_query($con, $total_orders_query);
                            $total_orders = mysqli_fetch_array($result_total)[0];
                            $total_pages = ceil($total_orders / $limit);

                            // Updated query with pagination
                            $get_orders = "
                            SELECT
                                po.order_id, po.customer_id, po.order_status,
                                co.invoice_id, co.order_date,
                                c.customer_email,
                                GROUP_CONCAT(p.product_title SEPARATOR ', ') AS product_titles,
                                GROUP_CONCAT(oi.qty SEPARATOR ', ') AS quantities,
                                SUM(oi.qty * oi.price) AS total_amount
                            FROM pending_orders po
                            JOIN customer_orders co ON po.order_id = co.order_id
                            JOIN customers c ON po.customer_id = c.customer_id
                            JOIN order_items oi ON po.order_id = oi.order_id
                            JOIN products p ON oi.product_id = p.product_id
                            GROUP BY po.order_id
                            LIMIT $offset, $limit
                            ";

                            $run_orders = mysqli_query($con, $get_orders);
                            $i = $offset; // Start order number from the current page
                            while ($row_orders = mysqli_fetch_array($run_orders)) {
                                $i++;
                                $order_id = $row_orders['order_id'];
                                $customer_email = $row_orders['customer_email'];
                                $invoice_id = $row_orders['invoice_id'];
                                $product_titles = $row_orders['product_titles'];
                                $quantities = $row_orders['quantities'];
                                $order_date = $row_orders['order_date'];
                                $total_amount = $row_orders['total_amount'];
                                $order_status = $row_orders['order_status'];
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $customer_email; ?></td>
                                    <td bgcolor="yellow">
                                        <a href="../order_confirmation.php?order_id=<?php echo $order_id; ?>">
                                            <?php echo ($invoice_id != '') ? $invoice_id : 'N/A'; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $product_titles; ?></td>
                                    <td><?php echo $quantities; ?></td>
                                    <td><?php echo $order_date; ?></td>
                                    <td>$<?php echo number_format($total_amount, 2); ?></td>
                                    <td><?php echo ($order_status == 'pending') ? 'Pending' : 'Complete'; ?></td>
                                    <td>
                                        <a href="index.php?order_delete=<?php echo $order_id; ?>">
                                            <i class="fa fa-trash-o"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody><!-- tbody Ends -->
                    </table><!-- table table-bordered table-hover table-striped Ends -->

                    <!-- Pagination Links -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php
                            if ($total_pages > 1) {
                                if ($page > 1) {
                                    echo "<li><a href='index.php?view_orders&page=" . ($page - 1) . "'>Previous</a></li>";
                                }
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    if ($i == $page) {
                                        echo "<li class='active'><a href='index.php?view_orders&page=$i'>$i</a></li>";
                                    } else {
                                        echo "<li><a href='index.php?view_orders&page=$i'>$i</a></li>";
                                    }
                                }
                                if ($page < $total_pages) {
                                    echo "<li><a href='index.php?view_orders&page=" . ($page + 1) . "'>Next</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </nav>
                </div><!-- table-responsive Ends -->
            </div><!-- panel-body Ends -->
        </div><!-- panel panel-default Ends -->
    </div><!-- col-lg-12 Ends -->
</div><!-- 2 row Ends -->
<?php } ?>
