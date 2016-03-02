<?php
 require_once('config.php');

//\Stripe\Stripe::setApiKey("sk_test_YF3QdK0cxMpsytPzgDPywkBO");

$abc=
\Stripe\Charge::create(array(
  "amount" => 400,
  "currency" => "usd",
  "source" => "tok_15VQe7IVW8CGfYGhO3P7N8yz", // obtained with Stripe.js,
  "metadata" => array("order_id" => "6735")
));
die($abc);
  $token  = $_POST['stripeToken'];

  $customer = \Stripe\Customer::create(array(
      'email' => 'customer@example.com',
      'card'  => $token
  ));

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => 5000,
      'currency' => 'usd'
  ));

  echo '<h1>Successfully charged $50.00!</h1>';
?>