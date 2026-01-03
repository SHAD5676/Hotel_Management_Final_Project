<?php
include_once('../db_config.php');
session_start();
if(!isset($_SESSION['full_name'])){
    header('location:index.php');
    exit;
}

// Stripe
require __DIR__ . '/../vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51Sio7AFCqyrBH5H9dGD3PzfNzRyv9r5VdJ45e2mT2pLdGqdxgf58dijavpOBiGAiB5lwOSzy3Fs1c0gGLyJnMuMO0012wQWbdn'); //

if(!isset($_GET['id'])){
    die("Invalid Bill ID");
}

$bill_id = $_GET['id'];

// Fetch bill
$q = "SELECT * FROM bills WHERE bill_id='$bill_id'";
$res = mysqli_query($conn, $q);
$bill = mysqli_fetch_assoc($res);

if(!$bill){
    die("Bill not found");
}

// Base URL (Admin folder)
$base_url = "http://localhost/pwad_68/Hotel_Management_System_Project_Final/admin/";

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
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">
    <?php include("includes/navbar.php"); ?>
    <?php include("includes/leftbar.php"); ?>

    <div class="content-wrapper p-4">
        <h3>Pay Bill</h3>
        <p><strong>Bill ID:</strong> <?= $bill['bill_id'] ?></p>
        <p><strong>Total:</strong> <?= $bill['total_amount'] ?> ৳</p>

        <button id="checkout-button" class="btn btn-success">
            <i class="fas fa-credit-card"></i> Pay Now
        </button>
    </div>

    <?php include("includes/footer.php"); ?>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe("pk_test_51Sio7AFCqyrBH5H96UcwTaUldRPodvILiBJB26KJc9g0aGshjlIyn9G7lGgNSBBi1azzdwxxmwQ3P7E58NEwZI7G00JHg1LwSS"); // 👉 Publishable Key
document.getElementById('checkout-button').addEventListener('click', function() {
    stripe.redirectToCheckout({ sessionId: "<?= $session->id ?>" });
});
</script>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
