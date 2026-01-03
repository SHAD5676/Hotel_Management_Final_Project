<?php
include_once('db_config.php');

session_start();


// Fetch all bookings for the current user/customer
$user_id = $_SESSION['full_name']; // adjust if you store customer_id
$sql = "SELECT 
            b.booking_id,
            b.customer_id,
            b.check_in,
            b.check_out,
            b.total_price,
            b.booking_status,
            r.room_number,
            c.category_name
        FROM bookings b
        JOIN rooms r ON b.room_id = r.room_id
        JOIN room_categories c ON r.category_id = c.category_id
        WHERE b.customer_id = ?
        ORDER BY b.booking_id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
?>

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
  <?php include_once 'Inc/top_nav.php'; ?>

  <!-- main-area -->
  <main>
    <!-- breadcrumb-area -->
    <section class="breadcrumb-area d-flex align-items-center" style="background-image:url(images/63.jpg)">
      <!-- breadcrumb-area -->
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-12 col-lg-12">
            <div class="breadcrumb-wrap text-center">
              <div class="breadcrumb-title">
                <h2>My Booking</h2>
                <div class="breadcrumb-wrap">

                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Bookings</li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <div class="content-wrapper p-4">
      <h2 class="mb-4">My Bookings</h2>

      <?php if (!empty($bookings)): ?>
        <?php foreach ($bookings as $b): ?>
          <div class="card booking-card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Room <?= htmlspecialchars($b['room_number']) ?> (<?= htmlspecialchars($b['category_name']) ?>)</h5>
              <p><strong>Check In:</strong> <?= htmlspecialchars($b['check_in']) ?></p>
              <p><strong>Check Out:</strong> <?= htmlspecialchars($b['check_out']) ?></p>
              <p><strong>Total:</strong> $<?= number_format($b['total_price'], 2) ?></p>
              <p>
                <span class="badge <?= $b['booking_status'] === 'Accepted' ? 'bg-success' : ($b['booking_status'] === 'Rejected' ? 'bg-danger' : 'bg-warning') ?>">
                  <?= htmlspecialchars($b['booking_status']) ?>
                </span>
              </p>
              <div class="booking-actions">
                <?php if ($b['booking_status'] !== 'Rejected' && $b['booking_status'] !== 'Checked Out'): ?>
                  <!-- Cancel Booking -->
                  <form method="POST" action="cancel_booking.php" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                    <input type="hidden" name="booking_id" value="<?= $b['booking_id'] ?>">
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="bi bi-x-circle"></i> Cancel
                    </button>
                  </form>
                <?php endif; ?>

                <?php if ($b['booking_status'] === 'Accepted'): ?>
                  <!-- Pay Booking -->
                  <form method="POST" action="make_payment.php">
                    <input type="hidden" name="booking_id" value="<?= $b['booking_id'] ?>">
                    <button type="submit" class="btn btn-sm btn-primary">
                      <i class="bi bi-credit-card"></i> Pay
                    </button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-muted">You have no bookings yet.</p>
      <?php endif; ?>
    </div>
    </div>



  </main>

  <!-- footer -->
  <?php include_once 'Inc/footer.php'; ?>



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