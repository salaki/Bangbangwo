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
	
	$cu = \Stripe\Customer::retrieve($_GET['id']);
	$data = mysql_query("select * from taskerdetails  where customerid='".$_GET['id']."' && secretkey = '".$sresult['secretkey']."'");
	while($rec= mysql_fetch_array($data)){
            $customer_id = $rec['cardid'];
        }
    
        $cu->sources->retrieve($customer_id)->delete();
	
	
	
	 //$rp = \Stripe\Recipient::retrieve($_GET['id']);
        // $rp->cards->retrieve($_GET['cid'])->delete();
        
          $update = mysql_query("update taskerdetails set `cardid` ='' where customerid='".$_GET['id']."' && secretkey = '".$sresult['secretkey']."'");
         echo 'Delete Successfully';
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
