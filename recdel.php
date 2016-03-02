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
	
	        $rp = \Stripe\Recipient::retrieve($_GET['id']);
                
                
                $customer_array = $rp->__toArray(true);
                //echo "<pre>";                print_r($customer_array); die("sachin");
                $rp->delete();
                $del = mysql_query("Update  taskerdetails set bankid ='' where recipientid ='".$_GET['id']."' && secretkey = '".$sresult['secretkey']."'");
               
                echo 'Delete successfully';
                header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/connect.php');
		
	
   }
	

catch(Stripe_CardError $e){
	$error = $e->getMessage();
	echo '<span style="color:red">'.$error.'</span>';
}

catch(stripe_InvalidRequestError $e){
   $error = $e->getMessage();
	echo '<span style="color:red">'.$error.'</span>';
}

catch(stripe_AuthenticationError $e){
	$error = $e->getMessage();
	echo '<span style="color:red">'.$error.'</span>';
}

catch(Exception $e){
	$error = $e->getMessage();
	echo '<span style="color:red">'.$error.'</span>';
}


?>

