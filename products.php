<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php
    session_start();
    include 'include/base.php';
    include 'include/db.php';
    include 'include/navbar.php';
    ?>
    <main class="wrapper">
        <section class="hero">
            <div class="container-fluid">
                <div class="row">
                    <h2>#tb__stayhome</h2>
                    <p>Save more with coupons &amp; up to 70% off!</p>
                </div>
            </div>
        </section><!-- hero -->

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
                    <div class="col-md-12 mb-3">
                        <!-- Manufacturer Filter -->
                        <form method="GET" class="d-flex justify-content-between">
                            <select name="manufacturer" class="form-select" onchange="this.form.submit()">
                                <option value="">Select Manufacturer</option>
                                <?php
                                // Fetch manufacturers for dropdown
                                $manufacturers_query = "SELECT manufacturer_id, manufacturer_title FROM manufacturers";
                                $manufacturers_result = $con->query($manufacturers_query);
                                while ($manufacturer = $manufacturers_result->fetch_assoc()) {
                                    $selected = (isset($_GET['manufacturer']) && $_GET['manufacturer'] == $manufacturer['manufacturer_id']) ? 'selected' : '';
                                    echo "<option value='{$manufacturer['manufacturer_id']}' $selected>{$manufacturer['manufacturer_title']}</option>";
                                }
                                ?>
                            </select>
                            <select name="sort" class="form-select" onchange="this.form.submit()">
                                <option value="">Sort By</option>
                                <option value="newest" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>Newest</option>
                                <option value="price_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Price: Low to High</option>
                                <option value="price_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Price: High to Low</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <?php
                    // Check con
                    if ($con->connect_error) {
                        die("con failed: " . $con->connect_error);
                    }

                    // Category ID from GET request
                    $category_id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;

                    // Pagination setup
                    $products_per_page = 9;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $products_per_page;

                    // Base SQL query with category filtering if applicable
                    $sql = "SELECT p.product_id AS id,
            p.product_title AS name,
            c.cat_title AS category,
            m.manufacturer_title AS manufacturer,
            p.product_psp_price AS newPrice,
            p.product_price AS oldPrice,
            p.product_img1 AS image
        FROM products p
        JOIN categories c ON p.cat_id = c.cat_id
        JOIN manufacturers m ON p.manufacturer_id = m.manufacturer_id";

                    // Initialize a flag for the WHERE clause
                    $where_clauses = [];

                    // If category ID is set, add the category filter
                    if ($category_id) {
                        $where_clauses[] = "p.cat_id = $category_id";
                    }

                    // Filter by manufacturer if selected
                    if (isset($_GET['manufacturer']) && is_numeric($_GET['manufacturer'])) {
                        $manufacturer_id = (int)$_GET['manufacturer'];
                        $where_clauses[] = "p.manufacturer_id = $manufacturer_id";
                    }

                    // Add WHERE clause if there are any conditions
                    if (!empty($where_clauses)) {
                        $sql .= " WHERE " . implode(" AND ", $where_clauses);
                    }

                    // Sorting logic
                    if (isset($_GET['sort'])) {
                        switch ($_GET['sort']) {
                            case 'newest':
                                $sql .= " ORDER BY p.product_id DESC";
                                break;
                            case 'price_asc':
                                $sql .= " ORDER BY p.product_psp_price ASC";
                                break;
                            case 'price_desc':
                                $sql .= " ORDER BY p.product_psp_price DESC";
                                break;
                            default:
                                $sql .= " ORDER BY RAND()"; // Default to random if no sort is specified
                        }
                    } else {
                        $sql .= " ORDER BY RAND()"; // Default to random if no sort is specified
                    }

                    // Add LIMIT clause for pagination
                    $sql .= " LIMIT $offset, $products_per_page";
                    $result = $con->query($sql);

                    // Display products
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $old_price = isset($row['oldPrice']) ? $row['oldPrice'] : 0;
                            $new_price = $row['newPrice'];
                            $discount_percentage = ($old_price > 0) ? (($old_price - $new_price) / $old_price) * 100 : 0; ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="product-item <?php echo $discount_percentage > 0 ? 'discount' : ''; ?>" onclick="location.href='singleproduct.php?id=<?php echo $row['id']; ?>';" style="cursor: pointer;">
                                    <div class="product-item-inner">
                                        <?php if ($discount_percentage > 0) : ?>
                                            <span class="discount"><?php echo number_format($discount_percentage, 2); ?>%</span>
                                        <?php endif; ?>
                                        <figure class="img-box">
                                            <?php
                                            // Display product image
                                            if (!empty($row['image'])) {
                                                $image_path = 'admin/product_images/' . $row['image'];
                                                echo "<img src='$image_path' alt='" . htmlspecialchars($row['name']) . "'>";
                                            } else {
                                                echo "<p>No image available</p>";
                                            }
                                            ?>
                                        </figure>
                                        <div class="details">
                                            <span class="cat"><i class="uil uil-tag-alt clr"></i> <?php echo htmlspecialchars($row['category']); ?>/<?php echo htmlspecialchars($row['manufacturer']); ?></span>
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
                                                    <?php if ($old_price > 0) : ?>
                                                        <span class="old-prc">&#8360;<?php echo number_format($old_price, 2); ?></span>
                                                    <?php endif; ?>
                                                    <br>
                                                    <span class="new-prc">&#8360;<?php echo number_format($new_price, 2); ?></span>
                                                </h4>
                                            </div>
                                            <a href="add_to_cart.php?product_id=<?php echo $row['id']; ?>&quantity=1" class="btn-link p-0 cart-link">
                                                <i class="uil uil-shopping-bag cart-icon cart" title="Add to Cart"></i>
                                            </a>
                                            <a href="singleproduct.php?id=<?php echo $row['id']; ?>" class="view-details">
                                                <i class="uil uil-eye" title="View Details"></i>
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

                <div class="row">
                    <?php
                    // Check connection
                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }

                    // Pagination setup
                    $products_per_page = 9;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $products_per_page;

                    // SQL query to count total products for pagination
                    $total_query = "SELECT COUNT(*) AS total FROM products p";
                    if (!empty($where_clauses)) {
                        $total_query .= " WHERE " . implode(" AND ", $where_clauses);
                    }
                    $total_result = $con->query($total_query);
                    $total_row = $total_result->fetch_assoc();
                    $total_products = $total_row['total'];
                    $total_pages = ceil($total_products / $products_per_page);

                    // Base SQL query to fetch products
                    $sql = "SELECT p.product_id AS id,
            p.product_title AS name,
            c.cat_title AS category,
            m.manufacturer_title AS manufacturer,
            p.product_psp_price AS newPrice,
            p.product_price AS oldPrice,
            p.product_img1 AS image
            FROM products p
            JOIN categories c ON p.cat_id = c.cat_id
            JOIN manufacturers m ON p.manufacturer_id = m.manufacturer_id";

                    // Add WHERE clauses based on filters
                    if (!empty($where_clauses)) {
                        $sql .= " WHERE " . implode(" AND ", $where_clauses);
                    }

                    // Sorting logic
                    if (isset($_GET['sort'])) {
                        switch ($_GET['sort']) {
                            case 'newest':
                                $sql .= " ORDER BY p.product_id DESC";
                                break;
                            case 'price_asc':
                                $sql .= " ORDER BY p.product_psp_price ASC";
                                break;
                            case 'price_desc':
                                $sql .= " ORDER BY p.product_psp_price DESC";
                                break;
                            default:
                                $sql .= " ORDER BY RAND()"; // Default to random
                        }
                    } else {
                        $sql .= " ORDER BY RAND()"; // Default to random
                    }

                    // Limit for pagination
                    $sql .= " LIMIT $offset, $products_per_page";
                    $result = $con->query($sql);

                    // Display products
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Display product details...
                            // (Your existing product display code here)
                        }
                    } else {
                        echo "<p>No products found.</p>";
                    }
                    ?>
                </div>

                <!-- Pagination Section -->
                <section class="pagination">
                    <div class="container">
                        <div class="row">
                            <div class="pagination justify-content-center">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page - 1; ?>" class="page-link"><i class="uil uil-arrow-left"></i></a>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <a href="?page=<?php echo $i; ?>" class="page-link <?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>
                                <?php endfor; ?>
                                <?php if ($page < $total_pages): ?>
                                    <a href="?page=<?php echo $page + 1; ?>" class="page-link"><i class="uil uil-arrow-right"></i></a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                    </section>
            </div>

        </section>
    </main>

    <?php
    include 'include/news.php';
    include 'include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnSIAt7gx2V2jQGz5NvmXt38f1YFovVSIb8zD4B+JCBiwlE/NKX3fBguHeTf" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>