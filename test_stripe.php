<?php

include_once "config.php";
include_once "include/headernew.php";

    try {
        $stripeClassesDir = __DIR__ . '/Stripe/lib/';
        $stripeUtilDir = $stripeClassesDir . 'Util/';
        $stripeErrorDir = $stripeClassesDir . 'Error/';

        set_include_path($stripeClassesDir . PATH_SEPARATOR . $stripeUtilDir . PATH_SEPARATOR . $stripeErrorDir);

        function __autoload($class) {
            $parts = explode('\\', $class);
            require end($parts) . '.php';
        }

        \Stripe\Stripe::setApiKey('sk_test_0grA60KbtsaU2qHyycnz9P5F');

     
         $charge = \Stripe\Transfer::create(array(
                    "amount" => '1950',
                    "currency" => "usd",
                    "recipient" => 'rp_16yJ9dKxyzah3hYNTDCmrCWc',
                    "card" =>'card_16yJBbKxyzah3hYNJi0qOnWO',
                    //"destination" => '',
                    "source_transaction" => 'ch_16z19MKxyzah3hYNpeBPTOYW',
                    "description" => "Transfer Successfully"
        ));
        $data = $charge->__toArray(true);
        echo "<pre>"; print_r($data);
    } catch (Stripe_CardError $e) {
        $error = $e->getMessage();
        echo $error;
    } catch (stripe_InvalidRequestError $e) {
        $error = $e->getMessage();
        echo $error;
    } catch (stripe_AuthenticationError $e) {
        $error = $e->getMessage();
        echo $error;
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo $error;
    }

?>