<?php
include_once('db_config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['status'])) {

  $booking_id = (int) $_POST['booking_id'];
  $status     = $_POST['status'];

  // Update booking status
  $stmt = $conn->prepare("UPDATE bookings SET booking_status = ? WHERE booking_id = ?");
  $stmt->bind_param("si", $status, $booking_id);
  $stmt->execute();

  // If Accepted → mark room as Occupied
  if ($status === 'Accepted') {
    $roomQuery = $conn->prepare("SELECT room_id FROM bookings WHERE booking_id = ?");
    $roomQuery->bind_param("i", $booking_id);
    $roomQuery->execute();
    $room = $roomQuery->get_result()->fetch_assoc();

    if ($room) {
      $updateRoom = $conn->prepare("UPDATE rooms SET status = 'Occupied' WHERE room_id = ?");
      $updateRoom->bind_param("i", $room['room_id']);
      $updateRoom->execute();
    }
  }

  $_SESSION['success'] = "Booking status updated successfully!";
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Check In</title>
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include("includes/navbar.php"); ?>
    <?php include("includes/leftbar.php"); ?>

    <div class="content-wrapper p-4">
      <h3 class="mb-4">Check In</h3>

      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($_SESSION['success']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Room</th>
              <th>Customer ID</th>
              <th>Check In</th>
              <th>Check Out</th>
              <th>Total Price</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT 
                                    b.booking_id,
                                    b.customer_id,
                                    b.check_in,
                                    b.check_out,
                                    b.total_price,
                                    b.booking_status,
                                    r.room_number
                                FROM bookings b
                                JOIN rooms r ON b.room_id = r.room_id
                                ORDER BY b.booking_id DESC";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0):
              while ($row = $result->fetch_assoc()):
            ?>
                <tr>
                  <td><?= htmlspecialchars($row['booking_id']) ?></td>
                  <td><?= htmlspecialchars($row['room_number']) ?></td>
                  <td><?= htmlspecialchars($row['customer_id']) ?></td>
                  <td><?= htmlspecialchars($row['check_in']) ?></td>
                  <td><?= htmlspecialchars($row['check_out']) ?></td>
                  <td>$<?= number_format($row['total_price'], 2) ?></td>
                  <td>
                    <span class="badge <?= $row['booking_status'] === 'Accepted' ? 'bg-success' : ($row['booking_status'] === 'Rejected' ? 'bg-danger' : 'bg-warning') ?>">
                      <?= htmlspecialchars($row['booking_status']) ?>
                    </span>
                  </td>
                  <td>
                    <?php if ($row['booking_status'] === 'Booked'): ?>
                      <form method="POST" style="display:inline;">
                        <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                        <input type="hidden" name="status" value="Accepted">
                        <button type="submit" class="btn btn-sm btn-success mb-1">
                          <i class="bi bi-check-lg"></i> Accept
                        </button>
                      </form>
                      <form method="POST" style="display:inline;">
                        <input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
                        <input type="hidden" name="status" value="Rejected">
                        <button type="submit" class="btn btn-sm btn-danger mb-1">
                          <i class="bi bi-x-lg"></i> Reject
                        </button>
                      </form>
                    <?php else: ?>
                      <span class="badge <?= $row['booking_status'] === 'Accepted' ? 'bg-success' : 'bg-danger' ?>">
                        <?= htmlspecialchars($row['booking_status']) ?>
                      </span>
                    <?php endif; ?>
                  </td>
                </tr>
            <?php
              endwhile;
            else:
              echo "<tr><td colspan='8' class='text-center text-muted'>No bookings found</td></tr>";
            endif;
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>