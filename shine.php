<?php
error_reporting(E_ALL);
require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey("sk_test_uM20qWzorVeB1Nz1Chat7aSF");

/*$response=\Stripe\Account::create(array(
  "managed" => false,
  "country" => "US",
  "email" => "amit@example.com"
)); */

/*
$response=\Stripe\Transfer::create(array(
  "amount" => 20,
  "currency" => "usd",
  "card"=>"card_15stKp2KAkwGg6MB042jmPGq",
  "description"=>"Transfer for test@example.com"
)); */


$response=\Stripe\Transfer::create(
  array(
    "amount" => 1000,
    "currency" => "usd",
    "recipient" => "self"
  ),
  array("stripe_account" => 'acct_15tZW7Kkdjh9EPrn')
);
print_r($response);
?>
