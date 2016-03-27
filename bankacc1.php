<?php
include_once "include/config.php";
//include_once "config.php";
//include_once "include/header.php"; 

        $secretkey = mysql_query("select * from stripecredentials where id ='1'");
        $sresult = mysql_fetch_array($secretkey);
       

    try {
        $stripeClassesDir = __DIR__ . '/Stripe/lib/';
        $stripeUtilDir = $stripeClassesDir . 'Util/';
        $stripeErrorDir = $stripeClassesDir . 'Error/';

        set_include_path($stripeClassesDir . PATH_SEPARATOR . $stripeUtilDir . PATH_SEPARATOR . $stripeErrorDir);

        function __autoload($class) {
            $parts = explode('\\', $class);
            require end($parts) . '.php';
        }

        \Stripe\Stripe::setApiKey($sresult['secretkey']);

    

	$updates = mysql_query("select * from taskerdetails  where userid ='".$_POST['userid']."' && secretkey='".$sresult['secretkey']."'") or die(mysql_error());
        $rows=mysql_fetch_array($updates);
	if(mysql_num_rows($updates)==0){
      			
		        $token = \Stripe\Token::create(array(
		                    "bank_account" => array('country' => 'US', 'routing_number' => $_POST["routing_number"], 'account_number' => $_POST["account_number"])
		        ));
		
		
		  $name = mysql_query("select * from members where id ='" . $_POST['userid'] . "'"); 
                  $getdata=mysql_fetch_array($name);
		
		      /*sachin changes
		        $customer = \Stripe\Customer::create(array(
		                    "description" => $getdata['email'],
		                    "source" => $token->id // obtained with Stripe.js
		        ));
		        */

		        $recipient = \Stripe\Recipient::create(array(
	                    "name" => $_POST['name'],
	                    "type" => "individual",
	                    "bank_account" => array('country' => 'US', 'routing_number' => $_POST["routing_number"], 'account_number' => $_POST["account_number"]),	                        
	       		));
	       		
	
	        $bank = $recipient->active_account;
	        $insert = mysql_query("insert into taskerdetails(`userid`,`recipientid`,`cardid`,`secretkey`,`customerid`,`bankid`) values('" . $_POST['userid'] . "','" . $recipient->id . "','" . $recipient->cards->data[0]['id'] . "','" . $sresult['secretkey'] . "','".$customer->id."','" . $bank->id . "')");
	}else if(empty($rows['bankid'])){
	
	          $name = mysql_query("select * from members where id ='" . $_POST['userid'] . "'"); 
                  $getdata=mysql_fetch_array($name);
		
		 $recipient = \Stripe\Recipient::create(array(
	                    "name" => $_POST['name'],
	                    "type" => "individual",
	                    "bank_account" => array('country' => 'US', 'routing_number' => $_POST["routing_number"], 'account_number' => $_POST["account_number"]),	                        
	       		));
		
	        $bank = $recipient ->active_account;
	        $insert = mysql_query("update taskerdetails set `recipientid`='".$recipient->id."' ,`bankid`='" . $bank->id . "' WHERE userid='".$_POST['userid']."'") or die(mysql_error());
	
	}
        echo 'success';
       
    } catch (Stripe_CardError $e) {
        $error = $e->getMessage();
        echo '<span style="color:red;margin-top:10px;">' . $error . '</span>';
    } catch (stripe_InvalidRequestError $e) {
        $error = $e->getMessage();
        echo '<span style="color:red;margin-top:10px;">' . $error . '</span>';
    } catch (stripe_AuthenticationError $e) {
        $error = $e->getMessage();
        echo '<span style="color:red;margin-top:10px;">' . $error . '</span>';
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo '<span style="color:red;margin-top:10px;">' . $error . '</span>';
    }

?>
