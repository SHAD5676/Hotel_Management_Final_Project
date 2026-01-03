<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// If you want, you can show the username here
$loggedIn = isset($_SESSION['full_name']);
$userName = $loggedIn ? $_SESSION['full_name'] : 'Guest';
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Hotel Admin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar d-flex flex-column justify-content-between" style="height: 100%;">
    <div>
      <!-- Sidebar user panel -->
      <?php if ($loggedIn): ?>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <!-- Simple avatar circle with first letter -->
            <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded-circle" style="width:35px; height:35px; font-weight:bold;">
              <?= strtoupper(substr($userName, 0, 1)) ?>
            </div>
          </div>
          <div class="info">
            <a href="#" class="d-block"><?= htmlspecialchars($userName) ?></a>
          </div>
        </div>
      <?php endif; ?>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
          <!-- Dashboard -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="room.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>Rooms</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="room_categories.php" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Room Categories</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="booking.php" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Bookings</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="customer.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Customers</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="check_in.php" class="nav-link">
              <i class="nav-icon fas fa-door-open"></i>
              <p>Check In</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="check_out.php" class="nav-link">
              <i class="nav-icon fas fa-door-open"></i>
              <p>Check Out</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="feedback.php" class="nav-link">
              <i class="nav-icon fas fa-comment-dots"></i>
              <p>Feedbacks/Reports</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user.php" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>Users/Staffs</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="bills.php" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Bills</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="service_new.php" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>Services</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>

    <!-- Logout Button at the bottom -->
    <?php if ($loggedIn): ?>
      <div class="p-3">
        <a href="logout.php" class="btn btn-danger btn-block">
          <i class="fas fa-sign-out-alt me-1"></i> Logout
        </a>
      </div>
    <?php endif; ?>
  </div>
  <!-- /.sidebar -->
</aside>