<?php
include_once('../db_config.php');
session_start();
if (!isset($_SESSION['full_name'])) {
    header('location:index.php');
    exit;
}

// Stripe
require __DIR__ . '/../vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51Sio7AFCqyrBH5H9dGD3PzfNzRyv9r5VdJ45e2mT2pLdGqdxgf58dijavpOBiGAiB5lwOSzy3Fs1c0gGLyJnMuMO0012wQWbdn'); //

if (!isset($_GET['id'])) {
    die("Invalid Bill ID");
}

$bill_id = $_GET['id'];

// Fetch bill
$q = "SELECT * FROM bills WHERE bill_id='$bill_id'";
$res = mysqli_query($conn, $q);
$bill = mysqli_fetch_assoc($res);

if (!$bill) {
    die("Bill not found");
}

// Base URL (Admin folder)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

$base_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';


$amount = $bill['total_amount'] * 100; // Paisa/cents

// Create Stripe Session
$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [[
        'price_data' => [
            'currency' => 'bdt',
            'product_data' => [
                'name' => 'Hotel Bill #' . $bill['bill_id'],
            ],
            'unit_amount' => $amount,
        ],
        'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $base_url . 'payment_success.php?bill_id=' . $bill['bill_id'],
    'cancel_url'  => $base_url . 'bills.php',
]);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pay Bill</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <?php include("includes/navbar.php"); ?>
        <?php include("includes/leftbar.php"); ?>

        <div class="content-wrapper p-4">

            <section class="content">
                <div class="container-fluid">

                    <div class="row justify-content-center">
                        <div class="col-md-6">

                            <div class="card card-outline card-success shadow-lg">
                                <div class="card-header text-center">
                                    <h4 class="mb-0">
                                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                                        Pay Hotel Bill
                                    </h4>
                                </div>

                                <div class="card-body">

                                    <div class="text-center mb-4">
                                        <i class="fas fa-hotel fa-3x text-success mb-2"></i>
                                        <h5 class="mb-0">Invoice Summary</h5>
                                    </div>

                                    <table class="table table-borderless">
                                        <tr>
                                            <th class="text-muted">Bill ID</th>
                                            <td class="text-right font-weight-bold">
                                                #<?= htmlspecialchars($bill['bill_id']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Total Amount</th>
                                            <td class="text-right text-success font-weight-bold h5">
                                                <?= number_format($bill['total_amount'], 2) ?> ৳
                                            </td>
                                        </tr>
                                    </table>

                                    <hr>

                                    <button id="checkout-button" class="btn btn-success btn-lg btn-block">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Pay Securely with Card
                                    </button>

                                    <p class="text-center text-muted mt-3 mb-0" style="font-size: 13px;">
                                        <i class="fas fa-lock mr-1"></i>
                                        Secure payment powered by Stripe
                                    </p>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </section>

        </div>

        <?php include("includes/footer.php"); ?>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe("pk_test_51Sio7AFCqyrBH5H96UcwTaUldRPodvILiBJB26KJc9g0aGshjlIyn9G7lGgNSBBi1azzdwxxmwQ3P7E58NEwZI7G00JHg1LwSS"); // 👉 Publishable Key
        document.getElementById('checkout-button').addEventListener('click', function() {
            stripe.redirectToCheckout({
                sessionId: "<?= $session->id ?>"
            });
        });
    </script>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>


    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
</body>

</html>