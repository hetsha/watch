<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORA - Watches </title>
    <meta name="description" conten="ORA - Watches &amp; Jewelry | Products">
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
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php"); // Redirect to login page
        exit;
    }
    include 'include/navbar.php';
    include 'include/slide.php';
    ?>

    <section class="products-categories">
        <div class="container">
            <article class="product-box">
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/swatch.png" alt="Swatch" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/jacques-lemans.png" alt="Jacques Lemans" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/citizen.png" alt="Citizen" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/zeppelin.png" alt="Zeppelin" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/roamer.png" alt="Roamer" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/LC.png" alt="Lee Cooper" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/pcd.png" alt="Pierre Cardin" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/gant.png" alt="Gant" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/quantum.png" alt="Quantum" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/danish.png" alt="Danish Design" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/Originals.png" alt="Lee Cooper | Originals" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/adorat.png" alt="Adora" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/esprit.png" alt="Esprit" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/armani.png" alt="Emporio Armani" />
                    </a>
                </div>
                <div class="cat-box">
                    <a href="#">
                        <img src="assets/img/categories/guess.png" alt="Guess" />
                    </a>
                </div>
            </article>
        </div>
    </section><!-- cats-end  -->

    <section class="products pm">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <article class="title text-center">
                        <h2 class="title-sec">Products</h2>
                        <p class="sub-title">Prefered <i class="uil uil-list-ui-alt"></i></p>
                    </article>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-25%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/quantum.png" alt="Ore Quantum PWG927.650">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Quantum</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Ore Quantum PWG927.650</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">169.00 &#8360;</span>135.20&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-15%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/quantum2.png" alt="Ore Quantum HNG949.652">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Quantum</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Ore Quantum HNG949.652</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">179.00&#8360;</span>143.00&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-50%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/armani.png" alt="Ore Armani AR5886">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Emporio Armani</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Ore Armani AR5886</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">279.00&#8360;</span>139.50&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-10%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/Ore_Gant_G121004.jpg" alt="Gant G121004">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Gant</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Ore Gant G121004</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">229.00&#8360;</span>183.20&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-25%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/Ore_Lee_Cooper_LC06713.740.jpg"
                                        alt="Lee Cooper LC06713.740">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Lee Cooper</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Ore Lee Cooper LC06713.740</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">229.00&#8360;</span>183.20&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-15%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/Lee_Cooper_LC07200.651.jpg"
                                        alt="Lee Cooper LC07200.651">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Lee Cooper</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Lee Cooper LC07200.651</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">229.00&#8360;</span>183.20&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- products-end  -->
        </div>
        <div class="row">
            <div class="col-12 text-center mt-5 mx-auto">
                <a href="products.php" class="btn btn-theme">View All Products <i
                        class="uil uil-arrow-circle-right"></i></a>
            </div>
        </div>
        </div>
    </section><!-- products-end  -->

    <section class="product-support">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 col-lg-12">
                    <h4>Repair &amp; Support - Services</h4>
                    <h2>Up to <span>50% off</span> - All Watches &amp; Accessories</h2>
                    <button class="btn-normal">Explore More</button>
                </div>
            </div>
        </div>
    </section><!-- product support-end -->

    <section class="products pm">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <article class="title text-center">
                        <h2 class="title-sec">Products</h2>
                        <p class="sub-title">Latest <i class="uil uil-list-ui-alt"></i><i class="uil uil-watch-alt"></i>
                        </p>
                    </article>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-50%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/Ore_Lee_Cooper_LC06713.741.jpg"
                                        alt="Lee Cooper LC06713.740">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Lee Cooper</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Ore Lee Cooper LC06713.741</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">150.00&#8360;</span>80.00&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-50%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/Lee_Cooper_LC07200.652.jpg"
                                        alt="Lee Cooper LC07200.651">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Lee Cooper</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Lee Cooper LC07200.652</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">189.00&#8360;</span>89.00&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-50%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/LC06673.362 = 69 EURO-600x660.jpg"
                                        alt="Lee Cooper LC06846.040">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Lee Cooper</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Lee Cooper LC06846.040</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">199.00&#8360;</span>100.00&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-25%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/Ore_Quantum_ADG950.090.jpg" alt="Quantum ADG950.090">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Quantum</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Ore Quantum ADG950.090</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <i class="uil uil-favorite"></i>
                                    <h4><span class="old-prc">149.00&#8360;</span>119.20&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-25%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/Ore_Quantum_ADG679.990.jpg" alt="Quantum ADG679.990">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Quantum</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Ore Quantum ADG679.990</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <i class="uil uil-favorite"></i>
                                    <h4><span class="old-prc">149.00&#8360;</span>119.20&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
                <div class="col-lg-4 col-md-6">
                    <div class="product-item discount">
                        <div class="product-item-inner">
                            <span class="discount">-25%</span>
                            <a href="products.php" class="link">
                                <figure class="img-box">
                                    <img src="assets/img/products/Ore_Quantum_ADG679.090.jpg"
                                        alt="Ore Quantum ADG679.090">
                                </figure>
                            </a>
                            <div class="details">
                                <span class="cat"><i class="uil uil-tag-alt"></i> Quantum</span>
                                <a href="products.php" class="link">
                                    <h5 class="title">Ore Quantum ADG679.090</h5>
                                </a>
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star-half-stroke"></i>
                                    <h4><span class="old-prc">149.00&#8360;</span>119.20&#8360;</h4>
                                </div>

                                <a href="products.php" class="go-to-cart"><i
                                        class="uil uil-shopping-bag shopping-cart cart"></i></a>
                            </div>
                        </div>
                    </div>
                </div><!-- products-end  -->
            </div>
            <div class="row">
                <div class="col-12 text-center mt-5 mx-auto">
                    <a href="products.php" class="btn btn-theme">View All Products <i
                            class="uil uil-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </section><!-- products-end  -->

    <section class="banner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <article class="banner-img">
                        <div class="circle-img">
                            <div class="circle-img-inner">
                                <div class="img-circle"></div>
                                <div class="c-gift">
                                    <article class="banner-text">
                                        <h2 class="mb-3">An investment in good products saves your work, time &amp;
                                            money.</h2>
                                        <h1 class="mb-3">Best online shopping web for Watches!</h1>
                                        <p>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                            Alias commodi, architecto labore minima distinctio aliquam
                                            voluptates dolor delectus temporibus, iusto corporis perferendis?
                                            Dignissimos unde blanditiis dolorum, omnis alias voluptatibus
                                            doloremque.
                                        </p>
                                        <span>You Can:</span>
                                        <a href="#" class="btn btn-theme mx-2">Log In!</a>
                                        <span>or:</span>
                                        <a href="#" class="btn btn-theme mx-2">Register for Free!</a>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section><!-- banner-end  -->

    <section class="feature">
        <div class="container">
            <div class="fe-box">
                <figure class="feature-box">
                    <img src="assets/img/features/free_shipping.png" alt="" />
                    <figcaption>Free Shipping</figcaption>
                </figure>
            </div>
            <div class="fe-box">
                <figure class="feature-box">
                    <img src="assets/img/features/shopping.gif" alt="" />
                    <figcaption>Online Order</figcaption>
                </figure>
            </div>
            <div class="fe-box">
                <figure class="feature-box">
                    <img src="assets/img/features/safe-box.gif" alt="" />
                    <figcaption>Save Money</figcaption>
                </figure>
            </div>
            <div class="fe-box">
                <figure class="feature-box">
                    <img src="assets/img/features/shopping-online.png" alt="" />
                    <figcaption>Promotions</figcaption>
                </figure>
            </div>
            <div class="fe-box">
                <figure class="feature-box">
                    <img src="assets/img/features/computer.png" alt="" />
                    <figcaption>Happy Sell</figcaption>
                </figure>
            </div>
            <div class="fe-box">
                <figure class="feature-box">
                    <img src="assets/img/features/social-care.gif" alt="" />
                    <figcaption>24/7 Support</figcaption>
                </figure>
            </div>
        </div>
    </section><!-- features-end  -->

    <section class="sales">
        <div class="container">
            <article class="box py-2">
                <div class="row text-center">
                    <div class="col-md-6 col-lg-3">
                        <div class="sales-count">
                            <h2 class="c-1">196k+</h2>
                            <p>Followers / Visitors</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="sales-count">
                            <h2 class="c-2">10k +</h2>
                            <p>Products</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="sales-count">
                            <h2 class="c-3">3</h2>
                            <p>Countries</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="sales-count">
                            <h2 class="c-4">3</h2>
                            <p>Shops</p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section><!-- sales - end  -->

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
                        <h2>Upcomming Season</h2>
                        <span>The best class watch is on sale at Ora Watches &amp; Jewelery.</span>
                        <button class="btn-coll">Collection</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container xs-c-oll">
            <div class="row">
                <div class="col-lg-4 col-md-6 c-box-img">
                    <div class="c-box">
                        <h4>SEASONAL SALE</h4>
                        <h2>Men Watches, Jewelery & Accessories</h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 c-box-img">
                    <div class="c-box">
                        <h4>SEASONAL SALE</h4>
                        <h2>Women Watches, Jewelery & Accessories</h2>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 c-box-img">
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
                <div class="col-lg-4 col-md-6">
                    <div class="n-form">
                        <input type="text" placeholder="Your E-Mail Address...">
                        <button class="btn-normal">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main><!-- main-body-end  -->

    <?php include 'include/footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <!-- <script src="cart.js"></script> -->
    <script src="count.js"></script>
    <script src="cart.js"></script>
</body>

</html>