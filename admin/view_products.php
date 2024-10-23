<?php
if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('../login.php','_self')</script>";
} else {
    // Pagination logic starts
    $limit = 9; // Number of products per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page from URL, default is 1
    $start = ($page - 1) * $limit; // Calculate the starting product index for the query

    // Get total number of products
    $get_total = "SELECT COUNT(*) FROM products WHERE status='product'";
    $run_total = mysqli_query($con, $get_total);
    $total_records = mysqli_fetch_array($run_total)[0];
    $total_pages = ceil($total_records / $limit); // Calculate total number of pages

    ?>
    <div class="row"><!--  1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / View Products
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!--  1 row Ends -->

    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title"><!-- panel-title Starts -->
                        <i class="fa fa-money fa-fw"></i> View Products
                    </h3><!-- panel-title Ends -->
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <div class="table-responsive"><!-- table-responsive Starts -->
                        <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Title</th>
                                    <th>Product Image</th>
                                    <th>Product Price</th>
                                    <th>Category</th>
                                    <th>Manufacturer</th>
                                    <th>Product Date</th>
                                    <th>Product Delete</th>
                                    <th>Product Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = $start;
                                // Modified query to include LIMIT for pagination
                                $get_pro = "SELECT p.product_id, p.product_title, p.product_img1, p.product_price, p.date, c.cat_title, m.manufacturer_title
                                            FROM products p
                                            JOIN categories c ON p.cat_id = c.cat_id
                                            JOIN manufacturers m ON p.manufacturer_id = m.manufacturer_id
                                            WHERE p.status='product'
                                            LIMIT $start, $limit";

                                $run_pro = mysqli_query($con, $get_pro);

                                while ($row_pro = mysqli_fetch_array($run_pro)) {
                                    $pro_id = $row_pro['product_id'];
                                    $pro_title = $row_pro['product_title'];
                                    $pro_image = $row_pro['product_img1'];
                                    $pro_price = $row_pro['product_price'];
                                    $pro_category = $row_pro['cat_title'];
                                    $pro_manufacturer = $row_pro['manufacturer_title'];
                                    $pro_date = $row_pro['date'];
                                    $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $pro_title; ?></td>
                                        <td><img src="product_images/<?php echo $pro_image; ?>" width="60" height="60"></td>
                                        <td>Rs. <?php echo $pro_price; ?></td>
                                        <td><?php echo $pro_category; ?></td>
                                        <td><?php echo $pro_manufacturer; ?></td>
                                        <td><?php echo $pro_date; ?></td>
                                        <td>
                                            <a href="index.php?delete_product=<?php echo $pro_id; ?>">
                                                <i class="fa fa-trash-o"></i> Delete
                                            </a>
                                        </td>
                                        <td>
                                            <a href="index.php?edit_product=<?php echo $pro_id; ?>">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table><!-- table table-bordered table-hover table-striped Ends -->
                    </div><!-- table-responsive Ends -->

                    <!-- Pagination Links Starts -->
                    <div class="text-center">
                        <ul class="pagination">
                            <?php
                            // Generate pagination links
                            for ($i = 1; $i <= $total_pages; $i++) {
                                echo "<li><a href='index.php?view_products&page=" . $i . "'>" . $i . "</a></li>";
                            }
                            ?>
                        </ul>
                    </div><!-- Pagination Links Ends -->

                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 2 row Ends -->
<?php } ?>
