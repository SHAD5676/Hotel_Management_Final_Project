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

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">


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

  <!-- Custom CSS -->
  <style>
    /* Full background */
    .login-bg {
      min-height: 100vh;
      background:
        linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
        url("images/Login_Back.jpg") center / cover no-repeat;
      display: flex;
      align-items: center;
    }

    /* Login card */
    .contact-bg02 {
      background-color: rgba(255, 255, 255, 0.97);
      /* white with slight opacity */
      border-radius: 12px;
      box-shadow: 0 20px 45px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.6);
    }

    /* Inputs */
    .contact-bg02 .form-control {
      height: 48px;
      font-size: 15px;
    }

    .contact-bg02 .input-group-text {
      background: #f1f3f5;
      border-right: 0;
    }

    /* Button */
    .ss-btn {
      background: #0d6efd;
      color: #fff;
      border: none;
      transition: all 0.2s ease-in-out;
    }

    .ss-btn:hover {
      background: #0b5ed7;
      color: #fff;
    }
  </style>


</head>

<body>

  <!-- header -->
  <?php include("inc/top_nav.php"); ?>
  <!-- header-end -->


  <!-- login area -->
  <!-- Login Area -->
  <section class="contact-area login-bg">
    <div class="container">
      <div class="row justify-content-center w-100">
        <div class="col-lg-5 col-md-7">

          <div class="contact-bg02 p-5">

            <!-- Title -->
            <div class="section-title text-center mb-4">
              <h2 class="fw-bold mb-1">User Login</h2>
              <p class="text-muted mb-0">Sign in to access your account</p>
            </div>

            <!-- Error message -->
            <?php if (!empty($_GET['error'])): ?>
              <div class="alert alert-danger text-center">
                <?= htmlspecialchars($_GET['error']) ?>
              </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="login_action.php" method="POST" autocomplete="off">

              <!-- Username / Email -->
              <div class="mb-3">
                <label class="form-label fw-semibold">Email or Full Name</label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class="bi bi-person"></i>
                  </span>
                  <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="Enter email or full name"
                    required>
                </div>
              </div>

              <!-- Password -->
              <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                  <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                  </span>
                  <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter your password"
                    required>
                </div>
              </div>

              <!-- Submit -->
              <button type="submit" class="btn ss-btn w-100 py-2">
                <i class="bi bi-box-arrow-in-right me-1"></i>
                Login
              </button>

            </form>

            <p class="mt-3 text-center text-muted">
              Don’t have an account?
              <a href="register.php" class="fw-semibold text-primary text-decoration-none">
                Create one
              </a>
            </p>

          </div>

        </div>
      </div>
    </div>
  </section>



  <!-- footer -->
  <?php include("inc/footer.php"); ?>

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