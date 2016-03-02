<?php
include_once "include/config.php";


$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);

        $stripeClassesDir = __DIR__ . '/Stripe/lib/';
        $stripeUtilDir = $stripeClassesDir . 'Util/';
        $stripeErrorDir = $stripeClassesDir . 'Error/';

        set_include_path($stripeClassesDir . PATH_SEPARATOR . $stripeUtilDir . PATH_SEPARATOR . $stripeErrorDir);

        function __autoload($class) {
            $parts = explode('\\', $class);
            require end($parts) . '.php';
        }

        \Stripe\Stripe::setApiKey($sresult['secretkey']);


         $token = $_POST['token'];
        
         $secretkey = mysql_query("select * from taskerdetails where userid ='" . $_POST['userid'] . "' && secretkey ='" . $sresult['secretkey'] . "'");
            if (mysql_num_rows($secretkey) > 0) {
            	$details=mysql_fetch_array($secretkey);
            	
            	$rp = \Stripe\Customer::retrieve($details['customerid']);
		$rp->source=$token;
		$rp->save();
		//echo "update taskerdetails set `cardid`='" .$rp->sources->data['0']->id . "' WHERE userid='" . $_POST['userid'] . "'";
                $update = mysql_query("update taskerdetails set `cardid`='" .$rp->sources->data['0']->id . "' WHERE userid='" . $_POST['userid'] . "'");
            } else {
            
                  $name = mysql_query("select * from members where id ='" . $_POST['userid'] . "'"); 
                  $getdata=mysql_fetch_array($name);
            
            	$customer = \Stripe\Customer::create(array(
                     "description" => $getdata['email'],
                     "source" => $token // obtained with Stripe.js
                   ));
                  
                   
                  
                  
                  $recipient= \Stripe\Recipient::create(array(
                          "name" => $getdata['fname'].' '. $getdata['lname'],
                          "type" => "individual"
                   ));
                  
                   
                 
                $insert = mysql_query("insert into taskerdetails(`userid`,`recipientid`,`cardid`,`secretkey`,`customerid`) values('" . $_POST['userid'] . "','".$recipient->id."','".$customer->sources->data['0']->id."','".$sresult['secretkey']."','".$customer->id."')");
            }
                 
        

?>

