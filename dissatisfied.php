<?php
include_once "config.php"; 
include_once "include/header.php";    
//taskerid  ==userid

$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);
$details = mysql_query("select * from members where id ='".$_POST['taskerid']."'");
$rec = mysql_fetch_array($details);
//transfer = servicefee - stripefee
$servicefee = floor($_POST['amount'] * 0.15 - ($_POST['amount'] * 1.15 * 0.029 + 30));


        $checkcreditdetails= mysql_query("select * from taskerdetails where userid = '".$_POST['taskerid']."' && secretkey='".$sresult['secretkey']."'");
        if(mysql_num_rows($checkcreditdetails)>0)
        {
          $data =mysql_fetch_array($checkcreditdetails);
         
          $source= mysql_query("select * from stripepayment where taskid = '".$_POST['taskid']."' && taskerid = '".$_POST['taskerid']."'");
          $rec = mysql_fetch_array($source);
         
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
	
	              $data  = \Stripe\Transfer::create(array(
                          "amount" => $_POST['amount'],
                          "currency" => "usd",
                          "recipient" => $data['recipientid'],
                          //"card" =>$data['cardid'],
                          "destination" =>$data['bankid'],
                          "source_transaction" =>$rec['chargeid'],
                          "description" => "Tasker Payment."
                        )); 
						
				  //Service Fee Transfer
	              $data  = \Stripe\Transfer::create(array(
                          "amount" => $servicefee,
                          "currency" => "usd",
                          "recipient" => "self",
                          "source_transaction" =>$rec['chargeid'],
                          "description" => "Service Fee."
                        ));
                        
                         $update = mysql_query("update satisfiedstatus set `paymentstatus` ='1' where bid_id ='".$_POST['taskid']."' && tasker_id = '".$_POST['taskerid']."'");
                       
	                echo"<h3>Transfer has been done Successfully</h3>";
	                
	                $gettaskdetail =  mysql_query("select * from tasks where id='".$_POST['taskid']."'");
	                $taskdetail = mysql_fetch_array($gettaskdetail);
	                $taskname = $taskdetail['taskname'];
	                
	                $data  = mysql_query("select * from members where id='".$_POST['taskerid']."'");
			$rec = mysql_fetch_array($data);
			$to = $rec['email'];
			$subject = "Payment Transfer Notification";
			//$to = 'sandeep.shinedezign@gmail.com';
	                
	                
	                $amnt = $_POST['amount']/100;
                        $body="<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h1>Dear ".$rec['fname']." ".$rec['lname'].",</h1><td></tr><tr><td>Your Work on Job <b>".$taskname."</b> is rated.</td></tr><tr><td>&nbsp;</td></tr><tr><td>Rate - dissatisfied</td></tr><tr><td>&nbsp;</td></tr><tr><td>$".$amnt." is Transferring to your account </td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";
                        
                        $headers  = 'From: bangbangwo@box1042.bluehost.com.' . "\r\n" ;
                        $headers .= 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                       
                        mail($to,$subject,$body,$headers);
	                
	                
	                 if($_POST['page']!='')
	                 {
	                    header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/dashboard?page='.$_POST['page'].'&dissatisfied');
	                 }
	                 else
	                 { 	                
	                  header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/dashboard?dissatisfied');
	                  }
	               
		
	
                   }
	

                catch(Stripe_CardError $e){
	                $error = $e->getMessage();
	                echo '<br><span style="color:red">'.$error.'</span><br>';
	               
	                
	               
                }

                catch(stripe_InvalidRequestError $e){
                   $error = $e->getMessage();
	                echo '<br><span style="color:red">'.$error.'</span><br>';
	               
	                
	               
                }

                catch(stripe_AuthenticationError $e){
	                $error = $e->getMessage();
	                echo '<br><span style="color:red">'.$error.'</span><br>';
	               
	                
	               
                }

                catch(Exception $e){
	                $error = $e->getMessage();
	                echo '<br><span style="color:red">'.$error.'</span><br>';
	                
	                
	               
                }
          
           
        }
        else
        {
         echo '<br><span style="color:red">Credit card details are not entered by Tasker .. Ask him to Connect with stripe</span><br>';
        }
        

?>