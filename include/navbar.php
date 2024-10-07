<?php
include 'db.php'; // Ensure this includes your database connection

// Check if the customer is logged in
if (isset($_SESSION['customer_id'])) {
    $customerID = (int)$_SESSION['customer_id']; // Get the customer ID from session

    // Query to count the number of items in the cart for this customer
    $cartCountQuery = $con->prepare("SELECT COALESCE(SUM(qty), 0) as total_items FROM cart WHERE customer_id = ?");
    $cartCountQuery->bind_param("i", $customerID);
    $cartCountQuery->execute();
    $cartCountResult = $cartCountQuery->get_result();

    $cartCount = 0; // Default to 0 if no items found
    if (isset($_SESSION['cart'])) {
        $cart_count = count($_SESSION['cart']);
    }
    if ($cartCountResult->num_rows > 0) {
        $row = $cartCountResult->fetch_assoc();
        $cartCount = $row['total_items'] ?: 0; // Safeguard against NULL
    }
    $cartCountQuery->close(); // Close the prepared statement
} else {
    $cartCount = 0; // No customer logged in, default count to 0
}

// Fetch categories for the Products menu
$categoryQuery = $con->prepare("SELECT cat_id, cat_title FROM categories");
$categoryQuery->execute();
$categoryResult = $categoryQuery->get_result();
$categories = $categoryResult->fetch_all(MYSQLI_ASSOC); // Fetch all categories
$categoryQuery->close(); // Close the prepared statement

// Get the current page
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="assets/img/favicon.png" sizes="32x32" />
    <link rel="icon" href="assets/img/favicon.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/assets/img/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css"> -->
</head>
<body>
    <header class="header">
        <div class="container">
            <section class="header--main">
                <div class="mobile-menu">
                    <input id="menu__toggle" class="open-nav" type="checkbox" />
                    <label class="menu__btn" class="open" for="menu__toggle">
                        <span></span>
                    </label>
                </div>
                <div class="header--logo">
                    <a href="">
                        <img src="assets/img/light-logo.png" class="nav-logo" alt="Ora Watches &amp; Jewelry | Logo">
                    </a>
                </div>
                <nav class="menu js-menu">
                    <ul class="ul-menu">
                        <li class="menu-item <?php if ($currentPage == 'index.php') echo 'active-n active'; ?>">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="menu-item menu-item-child <?php if ($currentPage == 'products.php') echo 'active'; ?>">
                            <a href="#" class="js-sub_menu">Products <i class="fa-solid fa-angle-down"></i></a>
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a href="products.php">All Products</a></li>
                                <?php foreach ($categories as $category): ?>
                                    <li class="sub-menu-item">
                                        <a href="products.php?id=<?php echo $category['cat_id']; ?>">
                                            <?php echo htmlspecialchars($category['cat_title']); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-child <?php if ($currentPage == 'blog.php' || $currentPage == 'about.php' || $currentPage == 'contact.php') echo 'active'; ?>">
                            <a href="#" class="js-sub_menu">Pages <i class="fa-solid fa-angle-down"></i></a>
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a href="blog.php">Blog</a></li>
                                <li class="sub-menu-item"><a href="about.php">About Us</a></li>
                                <li class="sub-menu-item"><a href="contact.php">Contact Us</a></li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-child <?php if ($currentPage == 'login.php' || $currentPage == 'sign.php' || $currentPage == 'logout.php') echo 'active'; ?>">
                            <a href="#" class="js-sub_menu">Login/Signup <i class="fa-solid fa-angle-down"></i></a>
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a href="login.php">Login</a></li>
                                <li class="sub-menu-item"><a href="login.php?action=register">Sign Up</a></li>
                                <li class="sub-menu-item"><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <div class="darkLight-searchBox">
                    <div class="dark-light">
                        <i class="uil uil-moon moon"></i>
                        <i class="fa-regular fa-sun sun"></i>
                    </div>
                    <div class="searchBox">
                        <div class="searchToggle">
                            <i class="uil uil-times cancel"></i>
                            <i class="uil uil-search search"></i>
                        </div>
                        <div class="search-field">
                            <input type="text" placeholder="Search..." />
                            <i class="uil uil-search-alt"></i>
                        </div>
                    </div>
                    <div class="cart-checkout">
                        <a href="cart.php">
                            <i class="uil uil-shopping-bag shopping-cart"></i>
                        </a>
                    </div>
                    <div class="mcart">
                        <i>(<span id="cartCount"><?php echo $cartCount; ?></span>)</i> <!-- Display cart count -->
                    </div>
                </div>
            </section>
            <div class="progress"></div>
        </div>
    </header><!-- header-end  -->
</body>
<script src="assets/js/script.js"></script>
</html>
