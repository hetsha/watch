<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORA - Watches </title>
    <meta name="description" conten="ORA - Watches &amp; Jewelry | Cart">
    <meta name="author" content="Author Name">
    <meta name="keywords" content="Or&euml; Dore, Syze, Bizhuteri, Aksesore, Outlet etc..." />
    <link rel="icon" href="assets/img/favicon.png" sizes="32x32" />
    <link rel="icon" href="assets/img/favicon.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/assets/img/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>


<<<<<<< Updated upstream:cart.php
<?php
        include 'navbar.php';
    ?>
=======
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
                        <img src="assets/img/light-logo.png" class="nav-logo" alt="Ora Watches &amp; Jewelery | Logo">
                    </a>
                </div>
                <nav class="menu js-menu">
                    <ul class="ul-menu">
                        <li class="menu-item">
                            <a href="index.html">Home</a>
                        </li>
                        <li class="menu-item menu-item-child">
                            <a href="#" class="js-sub_menu">Products <i class="fa-solid fa-angle-down"></i></a>
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a href="products.html">All Products</a></li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-child">
                            <a href="#" class="js-sub_menu">Pages <i class="fa-solid fa-angle-down"></i></a>
                            <ul class="sub-menu">
                                <li class="sub-menu-item"><a href="blog.html">blog</a></li>
                                <li class="sub-menu-item"><a href="about.html">about Us</a></li>
                                <li class="sub-menu-item"><a href="contact.html">contact Us</a></li>
                            </ul>
                        </li>
                        <li class="menu-item">
                            <a href="login.html">Log In</a>
                        </li>
                        </li>
                        <li class="menu-item">
                            <a href="sign.html">Sign Up</a>
                        </li>
                    </ul>
                </nav>
                <div class="darkLight-searchBox">
                    <div class="dark-light">
                        <!-- <i class="fa-solid fa-moon moon"></i> -->
                        <!-- <i class="fa-solid fa-sun"></i> -->
                        <i class="uil uil-moon moon"></i>
                        <i class="fa-regular fa-sun sun"></i>
                    </div>
                    <div class="searchBox">
                        <div class="searchToggle">
                            <!-- <i class="fa-solid fa-xmark cancel"></i> -->
                            <!-- <i class="fa-solid fa-magnifying-glass search"></i> -->
                            <i class="uil uil-times cancel"></i>
                            <i class="uil uil-search search"></i>
                        </div>

                        <div class="search-field">
                            <input type="text" placeholder="Search..." />
                            <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                            <i class="uil uil-search-alt"></i>
                        </div>
                    </div>
                    <div class="cart-checkout">
                        <i class="uil uil-shopping-bag shopping-cart active-n"></i>
                    </div>
                    <!-- <i class="fa-solid fa-bars open-nav"></i> -->
                    <div class="mcart">
                        <i>(<span id="cartCount" class="active-n active">0</span>)</i>
                    </div>
                </div>
            </section>
            <div class="progress"></div>
        </div>
    </header><!-- header-end  -->

>>>>>>> Stashed changes:cart.html

    <main class="wrapper">
        <section class="hero blog-hero">
            <div class="container-fluid">
                <div class="row">
                    <h2>#Shopping Cart</h2>
                    <p>Thank you for choosing ora-ks, for the checkout/payment see details below!</p>
                </div>
            </div>
        </section><!-- hero  -->

        <section class="cart">
            <div class="container">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Remove</td>
                                <td>Image</td>
                                <td>Product</td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td>Subtotal</td>
                            </tr>
                        </thead>
                        <tbody id="cart">
                            <!-- Cart items will be populated here -->
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
        </section>

        <section class="cart-add">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 cupon">
                        <h3>Apply Cupon</h3>
                        <div>
                            <input type="text" placeholder="Enter your Cupon..!" />
                            <button class="btn-normal">Apply</button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 subtotal">
                        <h3>Cart Total</h3>
                        <table class="table table-striped">
                            <tr>
                                <td class="text-right">total:</td>
                                <td id="subtotal" class="total-cost"></td> <!-- Display the subtotal amount here -->
                            </tr>
                            <tr>
                                <td>Shipping</td>
                                <td>Free</td>
                            </tr>
                        </table>
                        <button class="btn-normal" id="chekout">Proceed to Checkout</button>
                    </div>
                </div>
            </div>
            <div class="frm">

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
        </section>
    </main><!-- main-body-end  -->

    <footer class="footer">
        <div class="container-footer">
            <div class="row">
                <div class="col-lg-4 col-md-6 contact1">
                    <img src="assets/img/light-logo.png" class="footer-logo" alt="Ora - Logo">
                    <h4>Contact</h4>
                    <p><span class="fw-bold">Address:</span> Rr. Ferid Curri, 10000, Prishtina</p>
                    <p><span class="fw-bold">Tel:</span> +383 (0) 49 77 80 80</p>
                    <p><span class="fw-bold">Open:</span> 07:00 - 22:00, Monday - Friday</p>
                    <div class="social-fllw">
                        <h4>Follow us</h4>
                        <div class="icons d-flex justify-content-between align-items-center">
                            <a href="https://m.facebook.com/page">
                                <i class="uil uil-facebook"></i>
                            </a>
                            <a href="https://instagram.com/page">
                                <i class="uil uil-instagram"></i>
                            </a>
                            <a href="https://twitter.com/page">
                                <i class="uil uil-twitter-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-2 contact2">
                    <h4>About</h4>
                    <a href="about.php">About Us</a>
                    <a href="#">Delivery Information</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms&amp;Conditions</a>
                    <a href="contact.php">Contact Us</a>
                </div>

                <div class="col-md-6 col-lg-2 contact3">
                    <h4>My Account</h4>
                    <a href="sign-in.php">Sign In</a>
                    <a href="#">View Cart</a>
                    <a href="#">My Wishlist</a>
                    <a href="#">My Order</a>
                    <a href="help.php">Help?</a>
                </div>

                <div class="col-lg-4 col-md-6 install">
                    <h4>Install App</h4>
                    <p>From App Store or Google Play</p>
                    <div class="download-on">
                        <img src="assets/img/buttons/app-store.png" alt="">
                        <img src="assets/img/buttons/google-play.png" alt="">
                    </div>
                    <p>Secured Payment Getaway</p>
                    <div class="payment">
                        <i class="uil uil-master-card"></i>
                        <i class="uil uil-paypal"></i>
                        <i class="uil uil-transaction"></i>
                        <i class="uil uil-bill"></i>
                        <i class="uil uil-credit-card-search"></i>
                        <i class="uil uil-university"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="copyright">
                <p class="copy">&copy;<span id="year">. My Web Name.</span></p>
                <a href="#" class="go-to-link">
                    <p class="by">By:</p>
                    <span id="author">Web Studio</span>
                </a>
            </div>
        </div>

    </footer><!-- footer-end  -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <script src="cart.js"></script>
</body>

</html>