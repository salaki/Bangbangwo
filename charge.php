<?php
include_once "config.php"; 
include_once "include/headernew.php"; 
 
if(isset($_POST['taskid'])!='')
{
    //print_r($_POST); exit();

$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult1 = mysql_fetch_array($secretkey);
$secretkey = mysql_query("select * from members where id ='".$_SESSION['userid']."'");
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
	\Stripe\Stripe::setApiKey($sresult1['secretkey']);
	
	$data = mysql_query("select * from taskerdetails where userid ='".$_SESSION['userid']."' && secretkey='".$sresult1['secretkey']."'");
	$data1 = mysql_fetch_array($data);
	
	$charge = \Stripe\Charge::create(array(
	"amount" => $_POST['amount'],
	"currency"=>"usd",
	"customer" => $data1['customerid'],
	"description" => $sresult['email']
	));
	
	/*\Stripe\Account::create(array(
          "managed" => false,
          "country" => "US",
          "email" => "bob111@example.com"
        )); */
        
        
       
	
	echo"<h3> Your Payment has been Completed. Please Don't refresh page. </h3>";
		
	$insert = mysql_query("insert into stripepayment(`taskid`,`taskerid`,`status`,`chargeid`,`customerid`,`secretkey`,`loggedinuser`) values('".$_POST['taskid']."','".$_POST['taskerid']."','1','".$charge->id."','".$data1['customerid']."','".$sresult1['secretkey']."','".$_SESSION['userid']."')"); 
	
	         if($insert=='1' && $_POST['page']=='')
	         {
	         mysql_query("UPDATE tasks SET  hiredate='".date('Y-m-d H:i:s')."' WHERE id='".$_POST['taskid']."'") or die(mysql_error());
	         header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/dashboard?done=1&task_id='.$_POST['taskid'].'&tasker_id='.$_POST['taskerid'].'&action='.$_POST['action'].'&pageno='.$_POST['pageno']);
	         }
	         if($_POST['page']!='' && $insert=='1')
	         {
	            header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/dashboard?page='.$_POST['page'].'&done=1&task_id='.$_POST['taskid'].'&tasker_id='.$_POST['taskerid'].'&action='.$_POST['action'].'&pageno='.$_POST['pageno']);
	         }
	        
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
}
else
{
echo"<h3>Your Payment has been Completed.</h3>";
}


?>
