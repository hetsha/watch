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
    <?php include 'include/fav.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmEoJj0SHxp6XOPjo1rmqUY9G8NfITfXq2HktId7S1Irt7NuDvu8gozEmI4VhR" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">

    <style>
        /* CSS for smooth transition */
        #mainImage {
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
            /* Adjust duration for quicker transitions */
            visibility: visible;
            /* Ensure visibility is set */
        }

        .hidden {
            opacity: 0;
            visibility: hidden;
            /* Hide the image from the layout */
        }
    </style>
</head>

<body>
    <?php
    session_start();
    include 'include/navbar.php';
    include 'include/base.php';
    include 'include/db.php'; // Assuming 'include/db.php' contains the $con variable for connection

    // Get product ID from URL
    $productID = $_GET['id'];

    // SQL query to fetch product details
    $sql = "
SELECT products.*, categories.cat_title
FROM products
JOIN categories ON products.cat_id = categories.cat_id
WHERE product_id = '$productID'
";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
        <main class="wrapper">
            <section class="hero blog-hero">
                <div class="container-fluid">
                    <div class="row">
                        <h2>#product details</h2>
                        <p>Thank you for choosing ORA, for the product see details below!</p>
                    </div>
                </div>
            </section>
            <section class="product-details">
                <div class="container-fluid">
                    <div class="row gap-5">
                        <div class="col-md-12 col-lg-6 mx-auto single-product-img">
                            <div class="big-product">
                                <img id="mainImage" src="admin/product_images/<?php echo $row['product_img1']; ?>" class="pro-img img-fluid" alt="<?php echo $row['product_title']; ?>" />
                            </div>
                            <div class="img-gr d-flex justify-content-between">
                                <?php
                                for ($i = 2; $i <= 5; $i++) {
                                    $imageField = 'product_img' . $i;
                                    if (!empty($row[$imageField])) {
                                ?>
                                        <div class="col-lg-3 img-col">
                                            <img src="admin/product_images/<?php echo $row[$imageField]; ?>" class="img-sm" alt="<?php echo $row['product_title']; ?>" onmouseover="changeImage('admin/product_images/<?php echo $row[$imageField]; ?>')" onmouseout="resetImage()" />
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-5 mx-auto single-details">
                            <h6>Home / <?php echo $row['cat_title']; ?></h6>
                            <h4><?php echo $row['product_title']; ?></h4>
                            <h2><?php echo number_format($row['product_psp_price'], 2); ?> &#8360;</h2>

                            <!-- Add to Cart Form -->
                            <form id="addToCartForm" method="POST" action="add_to_cart.php">
                                <input type="number" id="quantityInput" name="quantity" min="1" max="10" value="1" required>
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                <input type="hidden" name="action" value="add_to_cart"> <!-- For Add to Cart -->
                                <button type="submit" class="btn-normal">Add to Cart</button>
                            </form>

                            <!-- Buy Now Form -->
                            <form id="buyNowForm" method="POST" action="add_to_cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                <input type="hidden" id="buyNowQuantity" name="quantity" value="1">
                                <input type="hidden" name="action" value="buy_now"> <!-- For Buy Now -->
                                <button type="submit" class="btn-normal">Buy Now</button>
                            </form>

                            <h4>Product Details</h4>
                            <span>
                                <?php echo $row['product_desc']; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </section>
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
                        // Fetch latest products
                            if ($con->connect_error) {
                            die("Connection failed: " . $connection->connect_error);
                        }
                        // Updated SQL query to use product_psp_price
                        $sql = "SELECT p.product_id AS id, p.product_title AS name, c.cat_title AS category,
p.product_psp_price AS price, p.product_price AS oldPrice,
p.product_img1 AS image
FROM products p
JOIN categories c ON p.cat_id = c.cat_id
ORDER BY RAND()
LIMIT 3";
                        $result = $con->query($sql);
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
                                                if (!empty($row['image'])) {
                                                    $image_path = 'admin/product_images/' . $row['image'];
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
                                                            &#8360;
                                                            <br>
                                                        </span><?php echo number_format($row['price'], 2); ?>&#8360;
                                                    </h4>
                                                </div>
                                                <a href="add_to_cart.php?product_id=<?php echo $row['id']; ?>&quantity=1" class="btn-link p-0 cart-link">
                                                    <i class="uil uil-shopping-bag cart-icon cart" title="Add to Cart"></i>
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

                        ?>
                    </div>
                </div>
            </section>
        <?php
    } else {
        echo "<h3>Product not found.</h3>";
    }
    include 'include/news.php';
    include 'include/footer.php';
        ?>
        <script>
            var originalImage = document.getElementById("mainImage").src;

            function changeImage(imageSrc) {
                var mainImage = document.getElementById("mainImage");

                // Add hidden class to fade out
                mainImage.classList.add('hidden');

                // Wait for the fade-out transition to complete
                setTimeout(function() {
                    mainImage.src = imageSrc; // Change the image source
                    mainImage.classList.remove('hidden'); // Remove hidden class to fade in

                    // Wait for a brief moment to allow for a full fade-in effect
                    setTimeout(function() {
                        mainImage.style.opacity = 1; // Reset opacity to 1
                    }, 50); // Small delay to allow for transition
                }, 500); // Match this duration to your CSS transition time
            }

            function resetImage() {
                var mainImage = document.getElementById("mainImage");

                // Add hidden class to fade out
                mainImage.classList.add('hidden');

                // Wait for the fade-out transition to complete
                setTimeout(function() {
                    mainImage.src = originalImage; // Change back to the original image
                    mainImage.classList.remove('hidden'); // Remove hidden class to fade in

                    // Wait for a brief moment to allow for a full fade-in effect
                    setTimeout(function() {
                        mainImage.style.opacity = 1; // Reset opacity to 1
                    }, 50); // Small delay to allow for transition
                }, 500); // Match this duration to your CSS transition time
            }
        </script>
        <script>
            // Get references to the quantity input and Buy Now hidden input
            var quantityInput = document.getElementById('quantityInput');
            var buyNowQuantity = document.getElementById('buyNowQuantity');
            var buyNowForm = document.getElementById('buyNowForm');

            // Update Buy Now form's hidden quantity field when quantity changes
            quantityInput.addEventListener('input', function() {
                buyNowQuantity.value = quantityInput.value;
            });

            // Optionally, ensure the Buy Now form submits the correct quantity
            buyNowForm.addEventListener('submit', function() {
                buyNowQuantity.value = quantityInput.value;
            });
        </script>

</body>

</html>