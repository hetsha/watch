<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORA - Watches</title>
    <meta name="description" content="ORA - Watches &amp; Jewelry | Products">
    <meta name="author" content="Author Name">
    <meta name="keywords" content="Or&euml; Dore, Syze, Bizhuteri, Aksesore, Outlet etc..." />
    <link rel="icon" href="assets/img/favicon.png" sizes="32x32" />
    <link rel="icon" href="assets/img/favicon.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="assets/img/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
</head>

<body>

    <?php include 'include/navbar.php';

    include 'include/base.php';
    ?>

    <main class="wrapper">
        <section class="hero">
            <div class="container-fluid">
                <div class="row">
                    <h2>#tb__stayhome</h2>
                    <p>Save more with coupons &amp; up to 70% off!</p>
                </div>
            </div>
        </section><!-- hero  -->

        <section class="products pm">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <article class="title text-center">
                            <h2 class="title-sec">Products</h2>
                            <p class="sub-title">Latest Products <i class="uil uil-list-ui-alt"></i><i class="uil uil-watch-alt"></i></p>
                        </article>
                    </div>
                </div>
                <div class="row">
                    <?php
                    // Database connection
                    $connection = new mysqli("localhost", "root", "", "ecom_store");

                    // Check for connection errors
                    if ($connection->connect_error) {
                        die("Connection failed: " . $connection->connect_error);
                    }

                    // Pagination setup
                    $products_per_page = 9;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $products_per_page;

                    // SQL query to fetch products with limit and offset
                    $sql = "SELECT p.product_id AS id, p.product_title AS name, c.cat_title AS category,
                       p.product_price AS price, p.product_psp_price AS oldPrice, p.product_label AS discount,
                       p.product_img1 AS image, p.product_img1 AS product_image
                    FROM products p
                    JOIN categories c ON p.cat_id = c.cat_id
                    LIMIT $products_per_page OFFSET $offset";

                    $result = $connection->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $old_price = $row['oldPrice'];
                            $new_price = $row['price'];
                            $discount_percentage = (($new_price - $old_price) / $new_price) * 100;
                    ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="product-item discount">
                                    <div class="product-item-inner">
                                        <span class="discount">-<?php echo number_format($discount_percentage, 2); ?>%</span>
                                        <figure class="img-box">
                                            <?php
                                            if (!empty($row['product_image'])) {
                                                $image_path = 'admin/product_images/' . $row['product_image'];
                                                echo "<img src='$image_path' alt='" . $row['name'] . "'>";
                                            } else {
                                                echo "<p>No image available</p>";
                                            }
                                            ?>
                                        </figure>
                                        <div class="details">
                                            <span class="cat"><i class="uil uil-tag-alt clr"></i> <?php echo $row['category']; ?></span>
                                            <a href="singleproduct.php?id=<?php echo $row['id']; ?>" class="link">
                                                <h5 class="title"><?php echo $row['name']; ?></h5>
                                            </a>
                                            <div class="star">
                                                <i class="fa-solid fa-star clr"></i>
                                                <i class="fa-solid fa-star clr"></i>
                                                <i class="fa-solid fa-star clr"></i>
                                                <i class="fa-solid fa-star clr"></i>
                                                <i class="fa-solid fa-star-half-stroke clr"></i>
                                                <h4><span class="old-prc"><?php echo number_format($row['price'], 2); ?> &#8360;</span>
                                                    <?php echo number_format($row['oldPrice'], 2); ?> &#8360;
                                                </h4>
                                            </div>
                                            <a class="go-to-cart" onclick="addToCart(<?php echo $row['id']; ?>)">
                                                <i class="uil uil-shopping-bag shopping-cart cart"></i>
                                            </a>
                                            <a href="singleproduct.php?id=<?php echo $row['id']; ?>" class="view-details">
                                                <i class="uil uil-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>No products found.</p>";
                    }

                    // Calculate the total number of pages
                    $total_products_sql = "SELECT COUNT(*) AS total FROM products";
                    $total_result = $connection->query($total_products_sql);
                    $total_row = $total_result->fetch_assoc();
                    $total_pages = ceil($total_row['total'] / $products_per_page);

                    // Close the database connection
                    $connection->close();
                    ?>
                </div>
            </div>
        </section>

        <!-- Pagination Section -->
        <section class="pagination">
            <div class="container">
                <div class="row">
                    <div class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>"><i class="uil uil-arrow-left"></i></a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>"><i class="uil uil-arrow-right"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>


        <section class="product-support">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-12">
                        <h4>Repair &amp; Support - Services</h4>
                        <h2>Up to <span>50% off</span> - All Watches &amp; Accessories</h2>
                        <button class="btn-normal">Explore More</button>
                    </div>
                </div>
            </div>
        </section><!-- product support-end -->

        <section class="collection my-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 c-box-img">
                        <div class="c-box">
                            <h4>Crazy Deals</h4>
                            <h2>Buy 1 get 1 Free</h2>
                            <span>The best class watch is on sale at Ora Watches &amp; Jewelery.</span>
                            <button class="btn-coll">Learn More</button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 c-box-img">
                        <div class="c-box">
                            <h4>Spring / Summer</h4>
                            <h2>Upcoming Season</h2>
                            <span>The best class watch is on sale at Ora Watches &amp; Jewelery.</span>
                            <button class="btn-coll">Collection</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container xs-c-oll">
                <div class="row">
                    <div class="col-md-6 col-lg-4 c-box-img">
                        <div class="c-box">
                            <h4>SEASONAL SALE</h4>
                            <h2>Men Watches, Jewelry & Accessories</h2>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 c-box-img">
                        <div class="c-box">
                            <h4>SEASONAL SALE</h4>
                            <h2>Women Watches, Jewelry & Accessories</h2>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 c-box-img">
                        <div class="c-box">
                            <h4>SEASONAL SALE</h4>
                            <h2>Child Watches & Accessories</h2>
                        </div>
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
                            <input type="text" placeholder="Your E-Mail Address...">
                            <button class="btn-normal">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- newsletter-end -->

    </main><!-- main-body-end  -->
    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <script src="count.js"></script>
    <script src="cart.js"></script>
</body>

</html>