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
    <?php include 'include/fav.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php
    session_start(); // Ensure this is the very first line in your PHP script
    include 'include/base.php';
    // Check if the user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php"); // Redirect to login page if not logged in
        exit;
    }
    include 'include/navbar.php';
    include 'include/slide.php';
    include 'catagory.php';
    ?>
    <section class="products pm">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <article class="title text-center">
                        <h2 class="title-sec">Products</h2>
                        <p class="sub-title">Latest Products <i class="uil uil-list-ui-alt"></i><i
                                class="uil uil-watch-alt"></i></p>
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
                // SQL query to fetch 6 random products and their categories
                $sql = "SELECT p.product_id AS id, p.product_title AS name, c.cat_title AS category,
                p.product_psp_price AS price, p.product_price AS oldPrice,
                p.product_img1 AS image
                FROM products p
                JOIN categories c ON p.cat_id = c.cat_id
                 ORDER BY p.product_id DESC
            LIMIT 3";
                $result = $connection->query($sql);
                $displayed_products = []; // Array to store displayed product IDs
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $displayed_products[] = $row['id']; // Add product ID to the array
                        $old_price = $row['oldPrice'];
                        $new_price = $row['price'];
                ?>
                        <!-- HTML for product display -->
                        <div class="col-md-6 col-lg-4">
                            <div class="product-item">
                                <div class="product-item-inner">
                                    <figure class="img-box">
                                        <?php
                                        if (!empty($row['image'])) {
                                            $image_path = 'admin/product_images/' . $row['image'];
                                            echo "<img src='$image_path' alt='" . htmlspecialchars($row['name']) . "'>";
                                        } else {
                                            echo "<p>No image available</p>";
                                        }
                                        ?>
                                    </figure>
                                    <div class="details">
                                        <span class="cat"><i class="uil uil-tag-alt clr"></i>
                                            <?php echo htmlspecialchars($row['category']); ?></span>
                                        <a href="singleproduct.php?id=<?php echo $row['id']; ?>" class="link">
                                            <h5 class="title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                        </a>
                                        <div class="star">
                                            <i class="fa-solid fa-star clr"></i>
                                            <i class="fa-solid fa-star clr"></i>
                                            <i class="fa-solid fa-star clr"></i>
                                            <i class="fa-solid fa-star clr"></i>
                                            <i class="fa-solid fa-star-half-stroke clr"></i>
                                            <h4>
                                                <span class="old-prc"><?php echo number_format($old_price, 2); ?> &#8360;</span>
                                                <span class="new-prc"><?php echo number_format($new_price, 2); ?> &#8360;</span>
                                            </h4>
                                        </div>
                                        <form action="add_to_cart.php" method="POST" class="d-inline-block" id="cartForm">
                                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                                <a href="#" class="btn-link p-0 cart-button" onclick="document.getElementById('cartForm').submit();">
                                                    <i class="uil uil-shopping-bag cart-icon cart" title="Add to Cart"></i>
                                                </a>
                                            </form>
                                        <!-- View Details Button -->
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
                // Close the database connection
                $connection->close();
                ?>
            </div>
        </div>
    </section>
    <section class="product-support">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 col-lg-12">
                    <h4>Repair &amp; Support - Services</h4>
                    <h2>Up to <span>50% off</span> - All Watches &amp; Accessories</h2>
                    <button class="btn-normal"><a href="products.php">Explore More</a></button>
                </div>
            </div>
        </div>
    </section><!-- product support-end -->
    <section class="products pm">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <article class="title text-center">
                        <h2 class="title-sec">More Products</h2>
                        <p class="sub-title">Explore More Products <i class="uil uil-list-ui-alt"></i><i
                                class="uil uil-watch-alt"></i></p>
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
                // SQL query to fetch 6 more random products excluding the ones already displayed
                $placeholders = implode(',', array_fill(0, count($displayed_products), '?'));
                $sql = "SELECT p.product_id AS id, p.product_title AS name, c.cat_title AS category,
                p.product_psp_price AS price, p.product_price AS oldPrice,
                p.product_img1 AS image
                FROM products p
                JOIN categories c ON p.cat_id = c.cat_id
                WHERE p.product_id NOT IN ($placeholders)
                 ORDER BY p.product_id ASC
                LIMIT 6";
                $stmt = $connection->prepare($sql);
                if (!empty($displayed_products)) {
                    $types = str_repeat('i', count($displayed_products));
                    $stmt->bind_param($types, ...$displayed_products);
                }
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $old_price = $row['oldPrice'];
                        $new_price = $row['price'];
                ?>
                        <!-- HTML for more product display -->
                        <div class="col-md-6 col-lg-4">
                            <div class="product-item">
                                <div class="product-item-inner">
                                    <figure class="img-box">
                                        <?php
                                        if (!empty($row['image'])) {
                                            $image_path = 'admin/product_images/' . $row['image'];
                                            echo "<img src='$image_path' alt='" . htmlspecialchars($row['name']) . "'>";
                                        } else {
                                            echo "<p>No image available</p>";
                                        }
                                        ?>
                                    </figure>
                                    <div class="details">
                                        <span class="cat"><i class="uil uil-tag-alt clr"></i>
                                            <?php echo htmlspecialchars($row['category']); ?></span>
                                        <a href="singleproduct.php?id=<?php echo $row['id']; ?>" class="link">
                                            <h5 class="title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                        </a>
                                        <div class="star">
                                            <i class="fa-solid fa-star clr"></i>
                                            <i class="fa-solid fa-star clr"></i>
                                            <i class="fa-solid fa-star clr"></i>
                                            <i class="fa-solid fa-star clr"></i>
                                            <i class="fa-solid fa-star-half-stroke clr"></i>
                                            <h4>
                                                <span class="old-prc"><?php echo number_format($old_price, 2); ?> &#8360;</span>
                                                <span class="new-prc"><?php echo number_format($new_price, 2); ?> &#8360;</span>
                                            </h4>
                                        </div>
                                        <a class="go-to-cart" onclick="addToCart(<?php echo $row['id']; ?>)">
                                            <i class="uil uil-shopping-bag shopping-cart cart"></i>
                                        </a>
                                        <!-- View Details Button -->
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
                    echo "<p>No more products found.</p>";
                }
                // Close the database connection
                $stmt->close();
                $connection->close();
                ?>
            </div>
            <div class="row">
                <div class="col-12 text-center mt-5 mx-auto">
                    <a href="products.php" class="btn btn-theme">View All Products <i class="uil uil-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </section><!-- products end -->
    <?php
    include 'other.php';
    include 'include/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/61g4e8e+rbG8IhV7U+8OBZ4ycEGE2rKl4eovtQ4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-2mhtjks7TO7UjWVoqk0LY3ndztj1s4L0SCw3RguQ7EDsB3k3xHjF4gR98gB1g0yo" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>