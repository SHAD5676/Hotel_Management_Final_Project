<?php
require_once('stripe-php/init.php');
include_once('db_config.php');

\Stripe\Stripe::setApiKey('sk_test_51Sio7AFCqyrBH5H9dGD3PzfNzRyv9r5VdJ45e2mT2pLdGqdxgf58dijavpOBiGAiB5lwOSzy3Fs1c0gGLyJnMuMO0012wQWbdn');

$token = $_POST['stripeToken'];
$amount = $_POST['amount'];
$bill_id = $_POST['bill_id'];

$session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'mode' => 'payment',
  'line_items' => [[
    'price_data' => [
      'currency' => 'bdt',
      'product_data' => [
        'name' => 'Hotel Bill Payment',
      ],
      'unit_amount' => $amount * 100,
    ],
    'quantity' => 1,
  ]],
  'success_url' => 'http://localhost/pwad_68/Hotel_Management_System_Project_Final/admin/payment_success.php?bill_id=' . $bill_id,
  'cancel_url'  => 'http://localhost/pwad_68/Hotel_Management_System_Project_Final/admin/bills.php',
]);

header("Location: " . $session->url);
exit;
