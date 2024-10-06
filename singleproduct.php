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
    <?php include 'include/fav.php' ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php
    session_start();
    include 'include/navbar.php';
    include 'include/base.php';
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecom_store";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Get product ID from URL
    $productID = $_GET['id'];
    // SQL query to fetch product details
    $sql = "
    SELECT products.*, product_categories.p_cat_title
    FROM products
    JOIN product_categories
    ON products.p_cat_id = product_categories.p_cat_id
    WHERE product_id = '$productID'
    ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
        <main class="wrapper">
            <section class="product-details">
                <div class="container-fluid">
                    <div class="row gap-5">
                        <div class="col-md-12 col-lg-6 mx-auto single-product-img">
                            <div class="big-product">
                                <img src="admin/product_images/<?php echo $row['product_img1']; ?>"
                                    class="pro-img img-fluid" alt="<?php echo $row['product_title']; ?>" />
                            </div>
                            <div class="img-gr d-flex justify-content-between">
                                <?php
                                for ($i = 2; $i <= 5; $i++) {
                                    $imageField = 'product_img' . $i;
                                    if (!empty($row[$imageField])) {
                                ?>
                                        <div class="col-lg-3 img-col">
                                            <img src="admin/product_images/<?php echo $row[$imageField]; ?>" class="img-sm"
                                                alt="<?php echo $row['product_title']; ?>" />
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-5 mx-auto single-details">
                            <h6>Home / <?php echo $row['p_cat_title']; ?></h6>
                            <h4><?php echo $row['product_title']; ?></h4>
                            <h2><?php echo number_format($row['product_psp_price'], 2); ?> &#8360;</h2> <!-- Changed to product_psp_price -->
                            <form action="add_to_cart.php" method="POST">
                                <input type="number" name="quantity" min="1" max="10" value="1" required>
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                <button type="submit" class="btn-normal">Add to Cart</button>
                            </form>
                            <button class="btn-normal" onclick="buyNow(<?php echo $row['product_id']; ?>)">Buy Now</button>
                            <h4>Product Details</h4>
                            <span>
                                <?php echo $row['product_desc']; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </section>
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
                        $connection = new mysqli("localhost", "root", "", "ecom_store");
                        if ($connection->connect_error) {
                            die("Connection failed: " . $connection->connect_error);
                        }
                        // Updated SQL query to use product_psp_price
                        $sql = "SELECT p.product_id AS id, p.product_title AS name, c.cat_title AS category,
        p.product_psp_price AS price, p.product_price AS oldPrice,
        p.product_img1 AS image, p.product_img1 AS product_image
        FROM products p
        JOIN categories c ON p.cat_id = c.cat_id
        ORDER BY RAND()
        LIMIT 3";
                        $result = $connection->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $old_price = $row['price'];
                                $new_price = $row['oldPrice'];
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
                                                <span class="cat"><i class="uil uil-tag-alt clr"></i>
                                                    <?php echo $row['category']; ?></span>
                                                <a href="singleproduct.php?id=<?php echo $row['id']; ?>" class="link">
                                                    <h5 class="title"><?php echo $row['name']; ?></h5>
                                                </a>
                                                <div class="star">
                                                    <i class="fa-solid fa-star clr"></i>
                                                    <i class="fa-solid fa-star clr"></i>
                                                    <i class="fa-solid fa-star clr"></i>
                                                    <i class="fa-solid fa-star clr"></i>
                                                    <i class="fa-solid fa-star-half-stroke clr"></i>
                                                    <h4><span class="old-prc"><?php echo number_format($row['oldPrice'], 2); ?>
                                                            &#8360;</span><?php echo number_format($row['price'], 2); ?>&#8360;
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
                        $connection->close();
                        ?>
                    </div>
                </div>
            </section>
            <?php
                include 'include/news.php';
            ?>
        </main>
        <?php include 'include/footer.php'; ?>
    <?php
    } else {
        echo "<p>Product not found.</p>";
    }
    $conn->close();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
        crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>