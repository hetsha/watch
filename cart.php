<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - ORA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <?php include'include/fav.php'?>
</head>

<body>

    <?php include 'include/navbar.php'; ?>

    <main class="wrapper">
        <section class="hero blog-hero">
            <div class="container-fluid">
                <div class="row">
                    <h2>#Shopping Cart</h2>
                    <p>Thank you for choosing ORA, for the checkout/payment see details below!</p>
                </div>
            </div>
        </section>

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
                            <?php
                            $total = 0;

                            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $productID => $product) {
                                    $subtotal = $product['price'] * $product['quantity'];
                                    $total += $subtotal;
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="remove_from_cart.php?id=<?php echo $productID; ?>">Remove</a>
                                        </td>
                                        <td>
                                            <img src="admin/product_images/<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" width="50">
                                        </td>
                                        <td><?php echo $product['title']; ?></td>
                                        <td><?php echo number_format($product['price'], 2); ?>&#8360;</td>
                                        <td><?php echo $product['quantity']; ?></td>
                                        <td><?php echo number_format($subtotal, 2); ?>&#8360;</td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='6'>Your cart is empty.</td></tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right">Total:</td>
                                <td><?php echo number_format($total, 2); ?>&#8360;</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>

        <section class="cart-add">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 cupon">
                        <h3>Apply Coupon</h3>
                        <div>
                            <form action="apply_coupon.php" method="POST">
                                <input type="text" name="coupon_code" placeholder="Enter your coupon code" />
                                <button type="submit" class="btn-normal">Apply</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 subtotal">
                        <h3>Cart Total</h3>
                        <table class="table table-striped">
                            <tr>
                                <td class="text-right">Total:</td>
                                <td><?php echo number_format($total, 2); ?>&#8360;</td>
                            </tr>
                            <tr>
                                <td>Shipping:</td>
                                <td>Free</td>
                            </tr>
                        </table>
                        <a href="checkout.php" class="btn-normal">Proceed to Checkout</a>
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
                            <form>
                                <input type="text" placeholder="Your E-Mail Address...">
                                <button class="btn-normal">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
