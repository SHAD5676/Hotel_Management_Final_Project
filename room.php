<?php
include_once('db_config.php');

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
    <section class="breadcrumb-area d-flex align-items-center"
      style="
    background-image:
      linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
      url(images/63.jpg);
  ">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-xl-12 col-lg-12">
            <div class="breadcrumb-wrap text-center">
              <div class="breadcrumb-title">
                <h2>Our Room's</h2>
                <div class="breadcrumb-wrap">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="index.php">Home</a>
                      </li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Our Room
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <?php if (isset($_SESSION['success'])): ?>
      <div class="container mt-4">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($_SESSION['success']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <h1 style="text-align: center; margin-top: 50px;">Our Rooms</h1>


    <section class="room-cards py-5">
      <div class="container">
        <div class="row">
          <?php
          $sql = "SELECT r.room_id, r.room_number, r.status,
                           c.category_name, c.price,
                           ri.image_url
                    FROM rooms r
                    JOIN room_categories c ON r.category_id = c.category_id
                    LEFT JOIN room_images ri ON r.room_id = ri.room_id
                    GROUP BY r.room_id
                    ORDER BY r.room_id DESC";

          $result = $conn->query($sql);

          if ($result && $result->num_rows > 0):
            while ($room = $result->fetch_assoc()):
          ?>
              <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 rounded-lg overflow-hidden h-100">
                  <!-- Room Image -->
                  <?php if (!empty($room['image_url']) && file_exists($room['image_url'])): ?>
                    <img src="./Admin/<?= $room['image_url'] ?>" class="card-img-top" alt="Room Image" style="height:220px; object-fit:cover;">
                  <?php else: ?>
                    <img src="./Admin/<?= $room['image_url'] ?>" class="card-img-top" alt="Room Image" style="height:220px; object-fit:cover;">
                  <?php endif; ?>

                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-2">Room <?= htmlspecialchars($room['room_number']) ?></h5>
                    <p class="card-text mb-1"><strong>Category:</strong> <?= htmlspecialchars($room['category_name']) ?></p>
                    <p class="card-text mb-1"><strong>Price:</strong> $<?= number_format($room['price'], 2) ?> / night</p>
                    <p class="card-text mb-3">
                      <span class="badge <?= $room['status'] == 'Available' ? 'badge-success' : ($room['status'] == 'Occupied' ? 'badge-danger' : 'badge-warning') ?>">
                        <?= $room['status'] ?>
                      </span>
                    </p>
                    <a href="room-details.php?room_id=<?= $room['room_id'] ?>" class="btn btn-primary mt-auto">View Details</a>
                  </div>
                </div>
              </div>
            <?php
            endwhile;
          else:
            ?>
            <div class="col-12">
              <p class="text-center text-muted">No rooms available at the moment.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>

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