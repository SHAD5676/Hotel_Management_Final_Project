<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
}

// Get booking_id
$booking_id = intval($_GET['booking_id'] ?? 0);
if ($booking_id <= 0) {
    $_SESSION['error'] = "Invalid Booking ID";
    header("Location: booking.php");
    exit;
}

// Fetch booking + customer + room + category
$stmt = $conn->prepare("
    SELECT b.booking_id, b.check_in, b.check_out, b.booking_status,
           c.name AS customer_name, c.phone, c.email, c.address,
           r.room_number,
           rc.category_name, rc.price AS rate
    FROM bookings b
    LEFT JOIN customers c ON b.customer_id = c.customer_id
    LEFT JOIN rooms r ON b.room_id = r.room_id
    LEFT JOIN room_categories rc ON r.category_id = rc.category_id
    WHERE b.booking_id = ?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$billing = $stmt->get_result()->fetch_assoc();

if (!$billing) {
    $_SESSION['error'] = "Booking not found";
    header("Location: booking.php");
    exit;
}

// Fetch bills (payments)
$bills_res = $conn->query("SELECT * FROM bills WHERE booking_id = $booking_id");
$paid = 0;
$bills = [];
while ($row = $bills_res->fetch_assoc()) {
    $paid += $row['amount'];
    $bills[] = $row;
}

// Extra services
$services_res = $conn->query("SELECT * FROM service_orders WHERE booking_id = $booking_id");
$service_total = 0;
$services = [];
while ($s = $services_res->fetch_assoc()) {
    $service_total += $s['price'] * $s['quantity'];
    $services[] = $s;
}

// Room calculation
$check_in = strtotime($billing['check_in']);
$check_out = strtotime($billing['check_out']);
$days = max(1, ($check_out - $check_in) / 86400);
$room_total = $days * $billing['rate'];

$grand_total = $room_total + $service_total;
$due = $grand_total - $paid;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bill #<?= $billing['booking_id'] ?></title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <style>
        .invoice-box {
            padding: 20px;
            border: 1px solid #ddd;
            margin: 20px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include("includes/navbar.php"); ?>
        <?php include("includes/leftbar.php"); ?>

        <div class="content-wrapper p-4">
            <div class="invoice-box">

                <h3>Bill / Invoice #<?= $billing['booking_id'] ?></h3>
                <hr>

                <h5>Customer Information</h5>
                <p>
                    <strong>Name:</strong> <?= htmlspecialchars($billing['customer_name']) ?><br>
                    <strong>Phone:</strong> <?= htmlspecialchars($billing['phone']) ?><br>
                    <strong>Email:</strong> <?= htmlspecialchars($billing['email']) ?><br>
                    <strong>Address:</strong> <?= htmlspecialchars($billing['address']) ?>
                </p>

                <h5>Booking Details</h5>
                <p>
                    <strong>Room:</strong> <?= $billing['room_number'] ?> (<?= $billing['category_name'] ?>)<br>
                    <strong>Check-in:</strong> <?= $billing['check_in'] ?><br>
                    <strong>Check-out:</strong> <?= $billing['check_out'] ?><br>
                    <strong>Days:</strong> <?= $days ?><br>
                    <strong>Rate/day:</strong> <?= number_format($billing['rate'], 2) ?><br>
                    <strong>Room Total:</strong> <?= number_format($room_total, 2) ?>
                </p>

                <?php if ($services): ?>
                    <h5>Extra Services</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Service</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                        <?php foreach ($services as $s): ?>
                            <tr>
                                <td><?= htmlspecialchars($s['service_name']) ?></td>
                                <td><?= number_format($s['price'], 2) ?></td>
                                <td><?= $s['quantity'] ?></td>
                                <td><?= number_format($s['price'] * $s['quantity'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th colspan="3">Service Total</th>
                            <th><?= number_format($service_total, 2) ?></th>
                        </tr>
                    </table>
                <?php endif; ?>

                <h5>Payment History</h5>
                <?php if ($bills): ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Payment ID</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Method</th>
                        </tr>
                        <?php foreach ($bills as $b): ?>
                            <tr>
                                <td><?= $b['payment_id'] ?></td>
                                <td><?= number_format($b['amount'], 2) ?></td>
                                <td><?= $b['payment_date'] ?></td>
                                <td><?= htmlspecialchars($b['method']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <th colspan="3">Total Paid</th>
                            <th><?= number_format($paid, 2) ?></th>
                        </tr>
                    </table>
                <?php else: ?>
                    <p>No payment found.</p>
                <?php endif; ?>

                <h5>Final Summary</h5>
                <p>
                    <strong>Grand Total:</strong> <?= number_format($grand_total, 2) ?><br>
                    <strong>Paid:</strong> <?= number_format($paid, 2) ?><br>
                    <strong>Due:</strong> <?= number_format($due, 2) ?><br>
                    <strong>Status:</strong> <?= $billing['booking_status'] ?>
                </p>

                <div class="no-print">
                    <button onclick="window.print()" class="btn btn-primary">Print</button>
                    <a href="bills.php" class="btn btn-secondary">Back</a>
                </div>

            </div>
        </div>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
</body>

</html>