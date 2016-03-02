<?php
include_once "config.php"; 
include_once "include/header.php"; 


$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);		 
try{
	$stripeClassesDir = __DIR__ . '/Stripe/lib/';
	$stripeUtilDir    = $stripeClassesDir . 'Util/';
	$stripeErrorDir   = $stripeClassesDir . 'Error/';

	set_include_path($stripeClassesDir . PATH_SEPARATOR . $stripeUtilDir . PATH_SEPARATOR . $stripeErrorDir);
	function __autoload($class)
	{
		$parts = explode('\\', $class);
		require end($parts) . '.php';
	}
	\Stripe\Stripe::setApiKey($sresult['secretkey']);
	
	$data = mysql_query("select * from stripepayment where loggedinuser ='".$_SESSION['userid']."' && secretkey = '".$sresult['secretkey']."'");
	$token = mysql_fetch_array($data);
	
	
       
	
	   $charge = \Stripe\Charge::create(array(
                  "amount" => $_POST['amount'],
                  "currency" => "usd",
                  "customer" => $token['customerid'], // obtained with Stripe.js
                  "description" => "Charge"
                ));
                       
	
	echo"<h3>Your Payment has been Completed.</h3>";
		
	
	 header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/dashboard?success');
	}

	

        catch(Stripe_CardError $e){
	        $error = $e->getMessage();
	        echo $error;
        }

        catch(stripe_InvalidRequestError $e){
           $error = $e->getMessage();
	        echo $error;
        }

        catch(stripe_AuthenticationError $e){
	        $error = $e->getMessage();
	        echo $error;
        }

        catch(Exception $e){
	        $error = $e->getMessage();
	        echo $error;
        }




?>
