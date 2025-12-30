<?php
include_once('db_config.php');
session_start();

// Require login
if (!isset($_SESSION['username'])) {
	header('location:index.php');
	exit;
}

/* ---------- PROCESS CHECKOUT ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'], $_POST['booking_id'])) {

	$booking_id = (int) $_POST['booking_id'];

	// Get booking info
	$stmt = $conn->prepare("SELECT room_id, total_price FROM bookings WHERE booking_id = ?");
	$stmt->bind_param("i", $booking_id);
	$stmt->execute();
	$booking = $stmt->get_result()->fetch_assoc();

	if ($booking) {
		$room_id = $booking['room_id'];
		$total_price = $booking['total_price'];

		// Update booking status
		$updateBooking = $conn->prepare("UPDATE bookings SET booking_status = 'Checked Out' WHERE booking_id = ?");
		$updateBooking->bind_param("i", $booking_id);
		$updateBooking->execute();

		// Create bill
		$stmtBill = $conn->prepare(
			"INSERT INTO bills (booking_id, total_amount, bill_status, bill_date)
             VALUES (?, ?, 'Unpaid', CURDATE())"
		);
		$stmtBill->bind_param("id", $booking_id, $total_price);
		$stmtBill->execute();

		// Update room status
		$updateRoom = $conn->prepare("UPDATE rooms SET status = 'Available' WHERE room_id = ?");
		$updateRoom->bind_param("i", $room_id);
		$updateRoom->execute();

		$_SESSION['success'] = "Guest checked out successfully!";
	}

	header("Location: check_out.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Check Out</title>
	<link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">

		<?php include("includes/navbar.php"); ?>
		<?php include("includes/leftbar.php"); ?>

		<div class="content-wrapper p-4">
			<h3 class="mb-4">Check Out</h3>

			<!-- Success message -->
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
                                WHERE b.booking_status = 'Accepted'
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
										<span class="badge bg-success">Accepted</span>
									</td>
									<td>
										<form method="POST" onsubmit="return confirm('Confirm check out?');">
											<input type="hidden" name="booking_id" value="<?= $row['booking_id'] ?>">
											<button type="submit" name="checkout" class="btn btn-sm btn-primary">
												Check Out
											</button>
										</form>
									</td>
								</tr>
						<?php
							endwhile;
						else:
							echo "<tr><td colspan='8' class='text-center text-muted'>No guests to check out</td></tr>";
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