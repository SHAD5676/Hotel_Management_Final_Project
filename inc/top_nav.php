<?php
// Get the current page filename
$currentPage = basename($_SERVER['PHP_SELF']);
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
                  <li class="has-sub <?= ($currentPage == 'index.php') ? 'active' : '' ?>">
                    <a href="index.php">Home</a>
                  </li>
                  <li class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>"><a href="about.php">About</a></li>
                  <li class="has-sub <?= ($currentPage == 'room.php') ? 'active' : '' ?>">
                    <a href="room.php">Our Rooms</a>
                  </li>
                  <li class="has-sub <?= ($currentPage == 'services.php' || $currentPage == 'single-service.php') ? 'active' : '' ?>">
                    <a href="services.php">Facilities</a>
                    
                  </li>
                 
                  <li class="<?= ($currentPage == 'contact.php') ? 'active' : '' ?>"><a href="contact.php">Contact</a></li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="col-xl-2 col-lg-2 d-none d-lg-block">
            <a href="contact.php" class="top-btn mt-10 mb-10 <?= ($currentPage == 'contact.php') ? 'active' : '' ?>">Reservation</a>
          </div>

          <div class="col-12">
            <div class="mobile-menu"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>