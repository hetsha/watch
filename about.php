<?php
session_start();
include 'include/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORA - Watches </title>
    <meta name="description" conten="ORA - Watches &amp; Jewelry | About">
    <meta name="author" content="Author Name">
    <meta name="keywords" content="Or&euml; Dore, Syze, Bizhuteri, Aksesore, Outlet etc..." />
    <?php include 'include/fav.php' ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<?php
include 'include/navbar.php';
?>

<body>

    <main class="wrapper">
        <section class="hero about-hero">
            <div class="container-fluid">
                <div class="row">
                    <h2>#about__us</h2>
                    <p>
                        ora watches
                    </p>
                </div>
            </div>
        </section><!-- hero  -->
        <section class="about">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-12 about-us">
                        <div class="about-video">
                            <video controls autoplay muted poster="assets/img/about/about-us.jpg">
                                <source src="assets/img/video/Corporate About Us Video Template.mp4" type="video/mp4" />
                                Your browser does not support the video tag!
                            </video>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12 my-5 who-we-are">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseOne">
                                        Who are we?
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        We are ORA n.t.p – Specialized Enterprise for sale and servicing of
                                        watches.<br><br>
                                        We offer fine watches and jewelry from a various worldwide famous brands
                                        like:<br>
                                        CITIZEN, JACQUES LEMANS, PIERRE CARDIN, GANT, ROAMER, LEE COOPER, QUANTUM,
                                        ADORA, DANISH DESIGN, POLICE, ESPRIT, ARMANI, GUESS, FOSSIL, DIESEL, MICHAEL
                                        KORS etc. <br><br>
                                        Our products can be bought on Our Stores or online in our website:
                                        https://orawatch.netlify.app/ .<br><br>
                                        For our products we offer 2 years warranty, continuous service and ongoing after
                                        sale support.<br><br>
                                        We are dedicated to offer choices for everyone.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseTwo">
                                        Vision
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">
                                        To be a market leader for products and services we offer and a permanent point
                                        of support toward offering solutions to our clients.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseThree">
                                        Mission
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="accordion-body">
                                        By offering wide choice of products for everyone with most affordable prices in
                                        the market, high quality and ongoing support after the sale toward realization
                                        of the main goal which is maximum client satisfaction and transformation of our
                                        clients in to life time repeated clients.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false"
                                        aria-controls="panelsStayOpen-collapseFour">
                                        Our core values
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="panelsStayOpen-headingFour">
                                    <div class="accordion-body">
                                        Commitment to work and achieving company objectives,<br>
                                        Special respect to customers, partners and colleagues,<br>
                                        Providing quality products with quality services,<br>
                                        Continuous improvement in order to provide a wide spectrum of satisfactory
                                        solutions to all customers,<br>
                                        Open to any critic toward improvement and fulfillment of all customer
                                        requirements.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6-col-md-12 mt-4 mb-3">
                        <abbr title="">
                            ORA n.t.p – Specialized Enterprise for sale and servicing of watches.<br><br>
                            We offer fine watches and jewelry from a various worldwide famous brands like:<br>
                            <marquee loop="-1" scrollamount="5">
                                CITIZEN, JACQUES LEMANS, PIERRE CARDIN, GANT, ROAMER, LEE COOPER, QUANTUM, ADORA, DANISH
                                DESIGN, POLICE, ESPRIT, ARMANI, GUESS, FOSSIL, DIESEL, MICHAEL KORS etc.
                            </marquee>
                        </abbr>
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
                            <h2>Upcomming Season</h2>
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
                            <h2>Men Watches, Jewelery & Accessories</h2>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 c-box-img">
                        <div class="c-box">
                            <h4>SEASONAL SALE</h4>
                            <h2>Women Watches, Jewelery & Accessories</h2>
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
        
        <?php
        include 'include/news.php';
        include 'include/footer.php'
        ?>
    </main><!-- main-body-end  -->
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>
    <script src="count.js"></script>
</body>

</html>