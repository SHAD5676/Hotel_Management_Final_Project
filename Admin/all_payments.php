<?php
include_once('db_config.php');
session_start();

// Protect page
if (!isset($_SESSION['full_name'])) {
    header('location:index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>All Payments</title>

    <!-- AdminLTE & FontAwesome CSS -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include("includes/navbar.php"); ?>

        <!-- Left Sidebar -->
        <?php include("includes/leftbar.php"); ?>

        <div class="content-wrapper p-4">

            <h3>All Payments</h3>

            <?php
            // Fetch all payments with optional booking/customer info
            $sql = "
                SELECT p.payment_id, p.booking_id, p.amount, p.payment_date, p.method,
                       r.room_number, c.name AS customer_name
                FROM payments p
                LEFT JOIN bookings b ON p.booking_id = b.booking_id
                LEFT JOIN rooms r ON b.room_id = r.room_id
                LEFT JOIN customers c ON b.customer_id = c.customer_id
                ORDER BY p.payment_id DESC
            ";
            $result = mysqli_query($conn, $sql);
            ?>

            <table class="table table-bordered table-striped">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Payment ID</th>
                        <th>Booking ID</th>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>{$row['payment_id']}</td>
                                <td>{$row['booking_id']}</td>
                                <td>{$row['customer_name']}</td>
                                <td>{$row['room_number']}</td>
                                <td>{$row['amount']} ৳</td>
                                <td>{$row['method']}</td>
                                <td>{$row['payment_date']}</td>
                                <td>
                                    <a href='print_payment.php?payment_id={$row['payment_id']}' class='btn btn-sm btn-primary'>
                                        <i class='fas fa-print'></i> Print
                                    </a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No payments found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>

        <!-- Footer -->
        <?php include("includes/footer.php"); ?>

    </div>

    <!-- Scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>