<?php
require_once "include/config.php"; 
require_once('stripe/lib/Stripe.php');

$ip = $_SERVER['SERVER_ADDR']; // the IP address to query
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if($query && $query['status'] == 'success') {
 // echo 'Hello visitor from '.$query['country'].', '.$query['city'].'!';
 
date_default_timezone_set($query['country']); // CDT
 
$current_date = date('Y-m-d H:i:s');
$curtime= date('H:i:s A', time());

$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);

//$date= date("Y-m-d H:i",strtotime("-2 weeks")); 

$date= date("Y-m-d H:i",strtotime("-20160 minutes")); 

//echo "SELECT * FROM tasks WHERE DATE_FORMAT(hiredate,'%Y-%m-%d %H:%i')='".$date."' && id NOT IN (SELECT bid_id FROM satisfiedstatus ) ORDER BY  `id` DESC";

$query= mysql_query("SELECT * FROM tasks WHERE DATE_FORMAT(hiredate,'%Y-%m-%d %H:%i')='".$date."' && id NOT IN (SELECT bid_id FROM satisfiedstatus ) ORDER BY  `id` DESC");



while($data=mysql_fetch_array($query)){
        
        $bidmultipledata = mysql_query("select * from bids where task_id='".$data['id']."'");
        while($row= mysql_fetch_array($bidmultipledata))
        {        
        $cquery= mysql_query("select * from stripepayment where taskid = '".$data['id']."' && taskerid='".$row['tasker_id']."'");
        $chargeid = mysql_fetch_array($cquery);
        if(mysql_num_rows($cquery)>0)
        {
          try{
                 $amnt= mysql_query("select * from bids where task_id = '".$data['id']."' && tasker_id='".$row['tasker_id']."'");
                 $getamnt = mysql_fetch_array($amnt);
	              Stripe::setApiKey($sresult['secretkey']);
	              $ch = Stripe_Charge::retrieve($chargeid['chargeid']);
                      $re = $ch->refunds->create();
	                echo"<h3>Refunded successfully</h3>";
	                mysql_query("update tasks set status = '4' where id='".$data['id']."'");
//	                mysql_query("Delete from bids where task_id='".$data['id']."'");
//			mysql_query("UPDATE bids SET status='4' where task_id='".$data['id']."'");

                        mysql_query("update bids set refund = '1' where task_id = '" . $data['id'] . "' && tasker_id='". $row['tasker_id']. "'");
			mysql_query("update tasks set refund = '1' where id='".$data['id']."'");
			$taskerdata  = mysql_query("select * from members where id='".$chargeid['taskerid']."'");
			$taskerrec = mysql_fetch_array($taskerdata);
			$datacc  = mysql_query("select * from tasks where id='".$chargeid['taskid']."'");
			$recdata = mysql_fetch_array($datacc);
			$reqdataagain  = mysql_query("select * from members where id='".$chargeid['taskid']."'");
			$requesterrecagain = mysql_fetch_array($reqdataagain);
			//echo 'tasker';
			 $to =$taskerrec['email'];  // send mail to tasker
			 
			// $to ='sandeep.shinedezign@gmail.com';
			$subject = ucfirst($recdata['taskname'])." is Canceled Now ";
                        $body="<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h1>Dear ".$taskerrec['fname']." ".$taskerrec['lname'].",</h1><td></tr><tr><td>Your Payment $".$getamnt['firstamnt']." for ".ucfirst($recdata['taskname'])." is Canceled.</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";
                       // $headers  = 'MIME-Version: 1.0' . "\r\n";
                        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        
                        $headers  = 'From: bangbangwo@box1042.bluehost.com.' . "\r\n" ;
                        $headers .= 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        // send email
                        mail($to,$subject,$body,$headers);
                         /* ------- send mail to requester ---*/
                         
                        // echo 'Requester';
                        $reqdataagain  = mysql_query("select * from members where id='".$data['userid']."'");
			$requesterrecagain = mysql_fetch_array($reqdataagain);
                        $to =$requesterrecagain['email'];  // send mail to requester
                       
                        // $to ='sandeep.shinedezign@gmail.com';
                        
                        $subject = ucfirst($recdata['taskname'])." is Refunded ";
                        $body="<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h1>Dear ".$requesterrecagain['fname']." ".$requesterrecagain['lname'].",</h1><td></tr><tr><td>Your Payment of $".$getamnt['amount']." is refunded to credit card for task ".ucfirst($recdata['taskname']). "</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";
                        
                        //$headers  = 'MIME-Version: 1.0' . "\r\n";
                        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        
                        $headers  = 'From: bangbangwo@box1042.bluehost.com.' . "\r\n" ;
                        $headers .= 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                               
                        // send email
                        mail($to,$subject,$body,$headers);
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
        
    } }
} else {
  echo 'Unable to get location';
}




?>
