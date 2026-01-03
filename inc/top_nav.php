<?php
session_start();

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);
$userName = $loggedIn ? $_SESSION['full_name'] : '';
$firstLetter = $userName ? strtoupper(substr($userName, 0, 1)) : '';
?>

<header class="header-area header-three">
  <div id="header-sticky" class="menu-area">
    <div class="container-fluid pl-85 pr-85">
      <div class="second-menu">
        <div class="row align-items-center">
          <div class="col-xl-2 col-lg-2">
            <div class="logo">
              <a href="index.php"><img src="img/logo/logo.png" alt="logo"></a>
            </div>
          </div>
          <div class="col-xl-8 col-lg-8">
            <div class="main-menu text-center">
              <nav id="mobile-menu">
                <ul>
                  <li class="has-sub <?= ($currentPage == 'index.php') ? 'active' : '' ?>"><a href="index.php">Home</a></li>
                  <li class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>"><a href="about.php">About</a></li>
                  <li class="has-sub <?= ($currentPage == 'room.php') ? 'active' : '' ?>"><a href="room.php">Our Rooms</a></li>
                  <li class="has-sub <?= ($currentPage == 'services.php' || $currentPage == 'single-service.php') ? 'active' : '' ?>"><a href="services.php">Facilities</a></li>
                  <li class="<?= ($currentPage == 'contact.php') ? 'active' : '' ?>"><a href="contact.php">Contact</a></li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="col-xl-2 col-lg-2 d-none d-lg-block text-end">
            <?php if (!$loggedIn): ?>
              <a href="login.php" class="top-btn mt-10 mb-10 <?= ($currentPage == 'login.php') ? 'active' : '' ?>">Login</a>
            <?php else: ?>
              <div class="user-options d-flex align-items-center justify-content-end gap-3 mt-10 mb-10">

                <span class="fw-semibold text-white"><?= $userName ?></span>
                <a href="booking-status.php" class="top-btn">Bookings</a>
                <a href="logout.php" class="top-btn">Logout</a>
              </div>
            <?php endif; ?>
          </div>

          <div class="col-12">
            <div class="mobile-menu"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>