<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>User Login | Hotel Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- header -->
<header class="header-area header-three">
    <div class="menu-area">
        <div class="container-fluid pl-85 pr-85">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <a href="index.php">
                        <img src="img/logo/logo.png" alt="logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- login area -->
<section class="contact-area pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-6">
                <div class="contact-bg02 p-5 shadow">

                    <div class="section-title text-center mb-40">
                        <h2>User Login</h2>
                        <p>Please login to continue</p>
                    </div>

                    <form action="login_action.php" method="POST">

                        <div class="contact-field mb-20">
                            <input type="text" name="username" placeholder="Username" required>
                        </div>

                        <div class="contact-field mb-20">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>

                        <div class="slider-btn text-center">
                            <button class="btn ss-btn" type="submit">
                                <span>Login</span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- JS -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
