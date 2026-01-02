<?php
require_once('stripe-php/init.php');
include_once('db_config.php');

\Stripe\Stripe::setApiKey('sk_test_51Sio7AFCqyrBH5H9dGD3PzfNzRyv9r5VdJ45e2mT2pLdGqdxgf58dijavpOBiGAiB5lwOSzy3Fs1c0gGLyJnMuMO0012wQWbdn');

$token = $_POST['stripeToken'];
$amount = $_POST['amount'];
$bill_id = $_POST['bill_id'];

\Stripe\Charge::create([
  "amount" => $amount * 100,
  "currency" => "bdt",
  "source" => $token,
  "description" => "Hotel Bill Payment"
]);

// Save payment
mysqli_query($conn, "
  INSERT INTO payments (bill_id, amount, method, status)
  VALUES ('$bill_id','$amount','Stripe','Paid')
");

// Update bill
mysqli_query($conn, "
  UPDATE bills SET payment_method='Stripe'
  WHERE bill_id='$bill_id'
");

header("Location: invoice.php?id=$bill_id");
