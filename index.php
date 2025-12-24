<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dahotel - Luxury Hotel HTML Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="fontawesome-pro/css/all.min.css">
    <link rel="stylesheet" href="css/dripicons.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/meanmenu.css">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>

<body>
    <!-- header -->
    <?php include("inc/top_nav.php"); ?>
    <!-- header-end -->

    <!-- main-area -->
    <main>
        <!-- slider-area -->
        <section id="home" class="slider-area fix p-relative">
            <!-- slider-info-area -->
            <div class="slider-info">
                <div class="social">
                    <span>
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" title="Twitter"><i class="fab fa-youtube"></i></a>
                    </span>
                    <!--  /social media icon redux -->
                </div>
                <div class="email">
                    <span class="mr-15">info@dahotel.com</span> +(123) 456 789
                </div>
            </div>
            <!-- slider-info-area-end -->
            <div class="slider-active" style="background: #101010;">
                <div class="single-slider slider-bg d-flex align-items-center" style="background-image: url(images/43.jpg); background-size: cover;">
                    <div class="container">
                        <div class="row justify-content-center align-items-center">

                            <div class="col-lg-7 col-md-7">
                                <div class="slider-content s-slider-content mt-80 text-center">
                                    <h5 data-animation="fadeInUp" data-delay=".4s">LUXURY HOTEL & BEST RESORT</h5>
                                    <h2 data-animation="fadeInUp" data-delay=".4s">Enjoy A Luxury <span>Experience</span> </h2>
                                    <div class="slider-btn mt-30 mb-105">
                                        <a href="contact.php" class="btn ss-btn active mr-15" data-animation="fadeInLeft" data-delay=".4s">book a seat </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- slider-area-end -->
        <!-- booking-area -->
        <div id="booking" class="booking-area p-relative">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-9">
                        <form action="#" class="contact-form">
                            <ul>
                                <li>
                                    <div class="contact-field p-relative c-name">
                                        <label>CHECK-IN</label>
                                        <input type="date" id="chackin" name="date">
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-field p-relative c-name">
                                        <label>CHECK-OUT</label>
                                        <input type="date" id="chackout" name="date">
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-field p-relative c-name">
                                        <label>GUESTS</label>
                                        <select name="adults" id="adu">
                                            <option value="sports-massage">Guests</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="contact-field p-relative c-name mt-10 mb-10">
                                        <input type="text" id="firstn" name="firstn" placeholder="First Name" required="">
                                    </div>
                                    <div class="contact-field p-relative c-name mb-10">
                                        <input type="text" id="email" name="email" placeholder="Eamil" required="">
                                    </div>
                                </li>

                                <li>
                                    <div class="slider-btn">
                                        <button class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s">Check <br> Availability</button>
                                    </div>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- booking-area-end -->
        <!-- service-details2-area -->
        <section id="service-details2" class="pt-120 pb-90 p-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="section-title center-align mb-50">
                            <h5>why choose us</h5>
                            <h2>
                                Why <span>choose us</span>
                            </h2>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="services-08-item mb-70">
                                    <div class="services-08-thumb">
                                        <img src="images/3.jpg" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.php"> Restaurants</a></h3>
                                        <p>Visitors to your city need to eat. In fact, some people visit new towns specifically for the food. Use your insider</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="services-08-item mb-70">
                                    <div class="services-08-thumb">
                                        <img src="images/1.jpg" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.php">Luxury Room</a></h3>
                                        <p>Visitors to your city need to eat. In fact, some people visit new towns specifically for the food. Use your insider</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="services-08-item mb-70">
                                    <div class="services-08-thumb">
                                        <img src="images/2.jpg" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.php">Entertainment</a></h3>
                                        <p>Visitors to your city need to eat. In fact, some people visit new towns specifically for the food. Use your insider</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="services-08-item mb-70">
                                    <div class="services-08-thumb">
                                        <img src="images/pool.jpg" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.php">Pool Area</a></h3>
                                        <p>Visitors to your city need to eat. In fact, some people visit new towns specifically for the food. Use your insider</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="services-08-item mb-70">
                                    <div class="services-08-thumb">
                                        <img src="images/bar7.jpg" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.phpl">Cocktail Bar</a></h3>
                                        <p>Visitors to your city need to eat. In fact, some people visit new towns specifically for the food. Use your insider</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="services-08-item mb-70">
                                    <div class="services-08-thumb">
                                        <img src="images/hotel1.jpeg" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.php">Tour Guide</a></h3>
                                        <p>Visitors to your city need to eat. In fact, some people visit new towns specifically for the food. Use your insider</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- service-details2-area-end -->
        <!-- counter-area -->
        <div class="counter-area p-relative wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
            <div class="container">

                <div class="row p-relative align-items-center">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-counter text-center">
                            <div class="counter p-relative">
                                <div class="text">
                                    <span class="count">90</span><span>K</span>
                                    <p>Guest Have Stayed at Our Hotel</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-counter text-center">
                            <div class="counter p-relative">
                                <div class="text">
                                    <span class="count">152</span><span>+</span>
                                    <p>Guest Have Stayed at Our Hotel</p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-counter text-center">
                            <div class="counter p-relative">
                                <div class="text">
                                    <span class="count">221</span><span>+</span>
                                    <p>Our Luxurious Services Rooms</p>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- counter-area-end -->
        <!--instagram-area -->

        <!-- room-area-->
        <section id="services" class="services-area pb-120">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-9">
                        <div class="section-title center-align mb-80 text-center">
                            <div class="icon mb-50"> <img src="img/icon/hotel-icon-sub.png" alt="img"> </div>
                            <h5>serve quality service</h5>
                            <h2>Our <span>hotel features</span></h2>
                            <p>Visitors to your city need to eat. In fact, some people visit new towns specifically for the food. Use your insider knowledge of the area to get them started with the must-visit eateries.</p>
                            <div class="mt-30">
                                <a href="contact.php" class="btn ss-btn mr-15">Rooms </a>
                                <a href="contact.php" class="btn active mr-15">suites </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row services-active">
                    <div class="col-xl-4 col-md-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-thumb">
                                <a class="gallery-link popup-image" href="img/gallery/room-img01.png">
                                    <img src="images/images (4).jpeg" alt="img">
                                </a>
                            </div>
                            <div class="services-content">
                                <h4><a href="single-rooms.php">Minimal Duplex Room</a></h4>
                                <p>Visitors to your city need to eat. In fact, some people visit new towns specifically.</p>
                                <div class="icon">
                                    <ul>
                                        <li><img src="img/icon/sve-icon1.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon2.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon3.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon4.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon5.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon6.png" alt="img"></li>
                                    </ul>
                                </div>
                                <div class="day-book">
                                    <ul>
                                        <li>$600/Night</li>
                                        <li><a href="contact.php">Book Now</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-thumb">
                                <a class="gallery-link popup-image" href="img/gallery/room-img02.png">
                                    <img src="images/bed.jpg" alt="img">
                                </a>
                            </div>
                            <div class="services-content">
                                <h4><a href="single-rooms.php">Superior Double Room</a></h4>
                                <p>Visitors to your city need to eat. In fact, some people visit new towns specifically.</p>
                                <div class="icon">
                                    <ul>
                                        <li><img src="img/icon/sve-icon1.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon2.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon3.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon4.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon5.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon6.png" alt="img"></li>
                                    </ul>
                                </div>
                                <div class="day-book">
                                    <ul>
                                        <li>$400/Night</li>
                                        <li><a href="contact.php">Book Now</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-thumb">
                                <a class="gallery-link popup-image" href="img/gallery/room-img03.png">
                                    <img src="images/images (2).jpeg" alt="img">
                                </a>
                            </div>
                            <div class="services-content">
                                <h4><a href="single-rooms.php">Super Balcony Double Room</a></h4>
                                <p>Visitors to your city need to eat. In fact, some people visit new.</p>
                                <div class="icon">
                                    <ul>
                                        <li><img src="img/icon/sve-icon1.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon2.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon3.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon4.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon5.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon6.png" alt="img"></li>
                                    </ul>
                                </div>
                                <div class="day-book">
                                    <ul>
                                        <li>$100/Night</li>
                                        <li><a href="contact.php">Book Now</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-thumb">
                                <a class="gallery-link popup-image" href="img/gallery/room-img04.png">
                                    <img src="img/gallery/room-img04.png" alt="img">
                                </a>
                            </div>
                            <div class="services-content">
                                <h4><a href="single-rooms.php">Delux Double Room</a></h4>
                                <p>Visitors to your city need to eat. In fact, some people visit new towns specifically.</p>
                                <div class="icon">
                                    <ul>
                                        <li><img src="img/icon/sve-icon1.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon2.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon3.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon4.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon5.png" alt="img"></li>
                                        <li><img src="img/icon/sve-icon6.png" alt="img"></li>
                                    </ul>
                                </div>
                                <div class="day-book">
                                    <ul>
                                        <li>$300/Night</li>
                                        <li><a href="contact.php">Book Now</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- room-area-end -->

        <!--instagram-area -->

        <section class="instagram-area p-relative fix pt-120 pb-120">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2 col-sm-6">
                        <div class="instagram-box">
                            <img src="images/images (5).jpeg" alt="img">
                            <div class="hover"><a href="#"><img src="img/icon/instagram-icon.png" alt="img"></a></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <div class="instagram-box">
                            <img src="images/29.jpeg" alt="img">
                            <div class="hover"><a href="#"><img src="img/icon/instagram-icon.png" alt="img"></a></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <div class="instagram-box">
                            <img src="images/food.jpeg" alt="img">
                            <div class="hover"><a href="#"><img src="img/icon/instagram-icon.png" alt="img"></a></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <div class="instagram-box">
                            <img src="images/images (9).jpeg" alt="img">
                            <div class="hover"><a href="#"><img src="img/icon/instagram-icon.png" alt="img"></a></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <div class="instagram-box">
                            <img src="images/bb1.jpg" alt="img">
                            <div class="hover"><a href="#"><img src="img/icon/instagram-icon.png" alt="img"></a></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6">
                        <div class="instagram-box">
                            <img src="images/images (12).jpeg" alt="img">
                            <div class="hover"><a href="#"><img src="img/icon/instagram-icon.png" alt="img"></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- pricing-area -->
        <section id="pricing" class="pricing-area pt-120 pb-60 fix p-relative">
            <div class="container">

                <div class="row justify-content-center align-items-center">

                    <div class="col-lg-6 col-md-12">
                        <div class="section-title mb-80 text-center">
                            <h5>our plans</h5>
                            <h2>Our pricing <span>& plans</span></h2>
                        </div>

                    </div>
                </div>
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-box pricing-box2 mb-60">
                            <div class="pricng-img">
                                <img src="images/9.jpg" alt="contact-bg-an-01">
                            </div>
                            <div class="pricing-head">
                                <h3>luxury plan</h3>
                                <div class="price-count">
                                    <h2>$70</h2>
                                    <span>/ Per Night</span>
                                </div>
                                <hr>
                            </div>

                            <div class="pricing-body mt-20 mb-30">
                                <ul>
                                    <li>Safe & Secure Services</li>
                                    <li>Room Fast Cleaning</li>
                                    <li>Drinks is Included</li>
                                    <li>Room Breakfast</li>
                                </ul>
                            </div>
                            <div class="pricing-btn">
                                <a href="contact.php" class="btn active">purchase now</a>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-box pricing-box2 mb-60">
                            <div class="pricng-img">
                                <img src="images/images (6).jpeg" alt="contact-bg-an-01">
                            </div>
                            <div class="pricing-head">
                                <h3>couple plan</h3>
                                <div class="price-count">
                                    <h2>$99</h2>
                                    <span>/ Per Night</span>
                                </div>
                                <hr>
                            </div>

                            <div class="pricing-body mt-20 mb-30">
                                <ul>
                                    <li>Safe & Secure Services</li>
                                    <li>Room Fast Cleaning</li>
                                    <li>Drinks is Included</li>
                                    <li>Room Breakfast</li>
                                </ul>
                            </div>
                            <div class="pricing-btn">
                                <a href="contact.php" class="btn active">purchase now</a>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-box pricing-box2 mb-60">
                            <div class="pricng-img">
                                <img src="images/images (15).jpeg" alt="contact-bg-an-01">
                            </div>
                            <div class="pricing-head">
                                <h3>intro price</h3>
                                <div class="price-count">
                                    <h2>$299</h2>
                                    <span>/ Per Night</span>
                                </div>
                                <hr>
                            </div>

                            <div class="pricing-body mt-20 mb-30">
                                <ul>
                                    <li>Safe & Secure Services</li>
                                    <li>Room Fast Cleaning</li>
                                    <li>Drinks is Included</li>
                                    <li>Room Breakfast</li>
                                </ul>
                            </div>
                            <div class="pricing-btn">
                                <a href="contact.php" class="btn active">purchase now</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- pricing-area-end -->


        <!-- newslater-area -->
        <section class="newslater-area">
            <div class="container p-relative">
                <div class="newslater-text">Newsletter</div>
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-7 col-md-12">
                        <div class="section-title">
                            <h2>Subscribe here <span>for update</span></h2>
                            <p>Subscribe us to receive market updates.</p>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-12">
                        <form name="ajax-form" id="contact-form4" action="#" method="post" class="contact-form newslater">
                            <div class="form-group">
                                <input class="form-control" id="email2" name="email" type="email" placeholder="Email Address..." value="" required="">
                                <button type="submit" class="btn btn-custom" id="send2">Subscribe</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </section>
        <!-- newslater-aread-end -->
    </main>
    <!-- main-area-end -->
    <!-- footer -->
    <?php include("inc/footer.php"); ?>

    <!-- footer-end -->
    <!-- JS here -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/paroller.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/js_isotope.pkgd.min.js"></script>
    <script src="js/imagesloaded.min.js"></script>
    <script src="js/parallax.min.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/jquery.meanmenu.min.js"></script>
    <script src="js/parallax-scroll.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/element-in-view.js"></script>
    <script src="js/main.js"></script>
</body>

</html>