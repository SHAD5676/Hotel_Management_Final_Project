<?php
include_once('db_config.php');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/* ---------- AUTH CHECK ---------- */
if (!isset($_SESSION['user_id']) && !isset($_SESSION['full_name'])) {
  header("Location: login.php");
  exit;
}

$customer_id = $_SESSION['user_id'] ?? null;

/* ---------- HANDLE CANCEL ---------- */
if (isset($_POST['cancel_booking_id'])) {
  $booking_id = (int) $_POST['cancel_booking_id'];

  $cancel = $conn->prepare("
        UPDATE bookings 
        SET booking_status = 'Cancelled'
        WHERE booking_id = ?
          AND customer_id = ?
          AND booking_status = 'Booked'
    ");
  $cancel->bind_param("is", $booking_id, $customer_id);
  $cancel->execute();

  $_SESSION['success'] = "Booking cancelled successfully.";
  header("Location: booking-status.php");
  exit;
}

/* ---------- FETCH USER BOOKINGS ---------- */
$stmt = $conn->prepare("
    SELECT 
        b.booking_id,
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
    ORDER BY b.booking_id DESC
");
$stmt->bind_param("s", $customer_id);
$stmt->execute();
$bookings = $stmt->get_result();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>My Booking Status</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <?php include_once 'Inc/top_nav.php'; ?>

  <div class="container py-5 min-vh-100">

    <h2 class="mb-4">My Bookings</h2>

    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if ($bookings->num_rows === 0): ?>
      <div class="alert alert-info">You have no bookings yet.</div>
    <?php else: ?>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-dark">
            <tr>
              <th>Room</th>
              <th>Category</th>
              <th>Check-in</th>
              <th>Check-out</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            <?php while ($row = $bookings->fetch_assoc()): ?>
              <tr>
                <td>Room <?= htmlspecialchars($row['room_number']) ?></td>
                <td><?= htmlspecialchars($row['category_name']) ?></td>
                <td><?= htmlspecialchars($row['check_in']) ?></td>
                <td><?= htmlspecialchars($row['check_out']) ?></td>
                <td>$<?= number_format($row['total_price'], 2) ?></td>

                <td>
                  <?php
                  $badge = match ($row['booking_status']) {
                    'Booked'    => 'bg-warning',
                    'Approved'  => 'bg-primary',
                    'Paid'      => 'bg-success',
                    'Cancelled' => 'bg-danger',
                    default     => 'bg-secondary'
                  };
                  ?>
                  <span class="badge <?= $badge ?>">
                    <?= htmlspecialchars($row['booking_status']) ?>
                  </span>
                </td>

                <td>
                  <!-- CANCEL -->
                  <?php if ($row['booking_status'] === 'Booked'): ?>
                    <form method="POST" class="d-inline">
                      <input type="hidden" name="cancel_booking_id" value="<?= $row['booking_id'] ?>">
                      <button class="btn btn-sm btn-danger"
                        onclick="return confirm('Cancel this booking?')">
                        Cancel
                      </button>
                    </form>
                  <?php endif; ?>

                  <!-- PAY -->
                  <?php if ($row['booking_status'] === 'Approved'): ?>
                    <a href="pay.php?booking_id=<?= $row['booking_id'] ?>"
                      class="btn btn-sm btn-success">
                      Pay Now
                    </a>
                  <?php endif; ?>

                  <?php if (in_array($row['booking_status'], ['Paid', 'Cancelled'])): ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>

          </tbody>
        </table>
      </div>

    <?php endif; ?>

  </div>

  <?php include_once 'Inc/footer.php'; ?>


  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>