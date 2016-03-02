<?php

include_once '../include/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/classes/class.common.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/stripe/lib/Stripe.php');
//die($_GET['action']);  
$objCommon = new common();
session_start();
$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);
if (isset($_REQUEST['email'])) {
    $confirm = mysql_num_rows(mysql_query("SELECT id FROM members WHERE email='" . $_REQUEST['email'] . "'"));
    if ($confirm > 0) {
        echo 'true';
    } else {
        echo 'false';
    }
    die();
}
if ($_POST['action'] == 'bid_start') {
    $chkCreditCard = mysql_num_rows(mysql_query("SELECT * FROM taskerdetails WHERE userid='" . $_SESSION['userid'] . "' && secretkey='" . $sresult['secretkey'] . "' && bankid!=''"));
    if ($chkCreditCard > 0) {
        
    } else {
        echo "1";
    }
    die();
}


if ($_POST['action'] == 'bid_sts') {
    $type = $_POST['type'] > 0 ? $_POST['type'] : 0;
    $array = array('user_id' => $_SESSION['userid'], 'type' => $type);
    $getId = $objCommon->createQuery($array, 'sts_check');
    die();
}
if (isset($_REQUEST['frgtemail'])) {
    $result = mysql_fetch_assoc(mysql_query("SELECT fname,lname,pwd FROM members WHERE email='" . $_REQUEST['frgtemail'] . "'"));
    $to = $_REQUEST['frgtemail'];
    $from = 'info@ubangbangwo.com';
    $subject = 'Password Recovery';
    $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Dear " . $result['fname'] . " " . $result['lname'] . ",</h2><td></tr><tr><td>Your Password is " . $result['pwd'] . "</td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";


    $headers = "From: info@ubangbangwo.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to, $subject, $body, $headers);
    echo "Password has been changed...";
    die();
}
if (isset($_REQUEST['task'])) {
    extract($_REQUEST);
    $ttime = str_replace('am', '', $ttime);
    $ttime = str_replace('pm', '', $ttime);
    $tdate = str_replace('/', '-', $tdate);
    $query = "insert into tasks(userid,taskname,tasktype,taskfrom,taskto,taskdate,people,other,ip_address,status,taskduration,taskdescription,tasklocation,taskmulti,added_date) values('" . $_SESSION['userid'] . "','" . $tname . "','" . $ttype . "','" . $tfrom . "','" . $tto . "','" . $tdate . ' ' . $ttime . ":00','" . $tpeople . "','" . $tother . "','" . $ip . "','1','" . $tduration . "','" . $tdescription . "','" . $tlocation . "','" . $multi . "','" . date("Y-m-d H:i:s") . "')";
    $ip = $_SERVER['REMOTE_ADDR'];
    $dt = date('Y-m-d');
    $user_log = mysql_num_rows(mysql_query("SELECT * FROM user_log WHERE user_id='" . $_SESSION['userid'] . "' and activ_date='" . $dt . "'"));
    if ($user_log <= 0) {
        mysql_query("INSERT INTO user_log(user_id,activ_date,ip_address) values('" . $_SESSION['userid'] . "','" . $dt . "','" . $ip . "')");
    }
    mysql_query($query);
    echo 'Task has been added Successfully';
    die();
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'hideBid') {
    mysql_query("UPDATE bids SET hide_bid='1' WHERE id='" . $_REQUEST['val'] . "'");
    $ip = $_SERVER['REMOTE_ADDR'];
    $dt = date('Y-m-d');
    $user_log = mysql_num_rows(mysql_query("SELECT * FROM user_log WHERE user_id='" . $_SESSION['userid'] . "' and activ_date='" . $dt . "'"));
    if ($user_log <= 0) {
        mysql_query("INSERT INTO user_log(user_id,activ_date,ip_address) values('" . $_SESSION['userid'] . "','" . $dt . "','" . $ip . "')");
    }
    die();
}
if (isset($_REQUEST['update'])) {
    extract($_REQUEST);
    $ttime = str_replace('am', '', $ttime);
    $ttime = str_replace('pm', '', $ttime);
    $tdate = str_replace('/', '-', $tdate);
    $query = "UPdate tasks SET userid='" . $_SESSION['userid'] . "',taskname='" . $tname . "',tasktype='" . $ttype . "',taskfrom='" . $tfrom . "',taskto='" . $tto . "',taskdate='" . $tdate . ' ' . $ttime . ":00',people='" . $tpeople . "',other='" . $tother . "',ip_address='" . $ip . "',status='1',taskduration='" . $tduration . "',taskdescription='" . $tdescription . "',tasklocation='" . $tlocation . "' WHERE id='" . $id . "'";
    mysql_query($query);
    echo 'Task has been Update Successfully';
    die();
}
//task remove and cancel
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'removeTask') {
 	$isbided=false; 
     // if task is not satisfied 
     $query = mysql_query("SELECT * FROM  `satisfiedstatus` WHERE  `bid_id` ='" . $_REQUEST['taskid'] . "'");
     if (mysql_num_rows($query) == 0) {     
        $taskStatus = mysql_query("SELECT * FROM tasks WHERE id='" . $_REQUEST['taskid'] . "' and status!='3'");
        if (mysql_num_rows($taskStatus)>0) {
	    $tasker = mysql_fetch_assoc(mysql_query("SELECT  b.id,b.taskname FROM tasks as b WHERE b.id='" . $_REQUEST['taskid'] . "'"));
	    $bidquery = mysql_query("select * from bids where task_id='" . $_REQUEST['taskid'] . "' AND status!='3'");
                while ($otherTasker = mysql_fetch_array($bidquery)) {
			$memberdetails=mysql_fetch_array(mysql_query("SELECT * FROM members WHERE id='".$otherTasker['tasker_id']."'"));
			// mail to taskter
			$to = $memberdetails['email'];
                        //$to = 'raju.shinedezign@gmail.com';
                        $from = 'info@ubangbangwo.com';
                        $subject = 'Cancel bid on Task ' . strtoupper($tasker['taskname']);
                        $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Dear " . $otherTasker['fname'] . " " . $otherTasker['lname'] . ",</h2><td></tr><tr><td>Your Payment $" . $otherTasker['firstamnt'] . " for task  " . strtoupper($tasker['taskname']) . " is cancelled.</td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";
                        $headers = "From: info@ubangbangwo.com\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        echo mail($to, $subject, $body, $headers);
			$isbided=true;
                }
        }
    }
    if($isbided==true){
	    mysql_query("update tasks set status='4' WHERE id='" . $_REQUEST['taskid'] . "'");

    }else{
	    mysql_query("update tasks set status='3' WHERE id='" . $_REQUEST['taskid'] . "'");
    }
    mysql_query("update bids set status='3' WHERE task_id='" . $_REQUEST['taskid'] . "'");


    $taskrefundstatus = mysql_query("SELECT * FROM tasks WHERE id='" . $_REQUEST['taskid'] . "' AND refund!='1'"); // checking already refunded 
    if (mysql_num_rows($taskrefundstatus) > 0) {
        $bidmultipledata = mysql_query("select * from bids where task_id='" . $_REQUEST['taskid'] . "'");
        // task refund  
            while ($mtaskerid = mysql_fetch_array($bidmultipledata)) {
	
                $chksatisfied = mysql_query("select * from satisfiedstatus where bid_id='" . $_REQUEST['taskid'] . "' && tasker_id='" . $mtaskerid['tasker_id'] . "'");
                if (mysql_num_rows($chksatisfied) == 0) {

                    $cquery = mysql_query("select * from stripepayment where taskid = '" . $_REQUEST['taskid'] . "' && taskerid='" . $mtaskerid['tasker_id'] . "'");
                    $chargeid = mysql_fetch_array($cquery);
                    $secretkey = mysql_query("select * from stripecredentials where id ='1'");
                    $sresult = mysql_fetch_array($secretkey);

                    $amnt = mysql_query("select * from bids where task_id = '" . $_REQUEST['taskid'] . "' && tasker_id='" . $mtaskerid['tasker_id'] . "'");
                    $getamnt = mysql_fetch_array($amnt);

                    if (!empty($chargeid['chargeid'])) {
                        try {
                            Stripe::setApiKey($sresult['secretkey']);
                            $ch = Stripe_Charge::retrieve($chargeid['chargeid']);
                            $re = $ch->refunds->create();



                            mysql_query("update tasks set refund = '1' where id='" . $_REQUEST['taskid'] . "'");

                            $datacc = mysql_query("select * from tasks where id='" . $_REQUEST['taskid'] . "'");
                            $recdata = mysql_fetch_array($datacc);
                            $dataagain = mysql_query("select * from members where id='" . $recdata['userid'] . "'");
                            $recagain = mysql_fetch_array($dataagain);

                            /* ------- send mail to requester --- */

                            // echo 'Requester';

                            $to = $recagain['email'];  // send mail to tasker
                            // $to = 'sandeep.shinedezign@gmail.com';

                            $subject = ucfirst($recdata['taskname']) . $recagain['email'] . " is Refunded ";
                            $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h1>Dear " . $recagain['fname'] . " " . $recagain['lname'] . ",</h1><td></tr><tr><td>Your Payment of $" . $getamnt['amount'] . " is refunded to credit card for task " . ucfirst($recdata['taskname']) . "</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";

                            //$headers  = 'MIME-Version: 1.0' . "\r\n";
                            //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                            $headers = 'From: bangbangwo@box1042.bluehost.com.' . "\r\n";
                            $headers .= 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                            // send email
                            mail($to, $subject, $body, $headers);
                        } catch (Stripe_CardError $e) {
                            $error = $e->getMessage();
                            // echo '<br><span style="color:red">'.$error.'</span><br>';
                        } catch (stripe_InvalidRequestError $e) {
                            $error = $e->getMessage();
                            //  echo '<br><span style="color:red">'.$error.'</span><br>';
                        } catch (stripe_AuthenticationError $e) {
                            $error = $e->getMessage();
                            //  echo '<br><span style="color:red">'.$error.'</span><br>';
                        } catch (Exception $e) {
                            $error = $e->getMessage();
                            //   echo '<br><span style="color:red">'.$error.'</span><br>';
                        }
                    }

                    // echo $error;
                    //refund mail  
                }
            }
       
    }

    die();
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'addBid') {
    //"INSERT INTO bids(task_id,tasker_id,amount,message) values('".$_REQUEST['taskid']."','".$_SESSION['userid']."','".$_REQUEST['bid-amount']."','".$_REQUEST['bid-message']."')";
    $ip = $_SERVER['REMOTE_ADDR'];
    $dt = date('Y-m-d');
    $amnt = ($_REQUEST['bid-amount'] + ($_REQUEST['bid-amount'] * (15 / 100)));
    $user_log = mysql_num_rows(mysql_query("SELECT * FROM user_log WHERE user_id='" . $_SESSION['userid'] . "' and activ_date='" . $dt . "'"));
    if ($user_log <= 0) {
        mysql_query("INSERT INTO user_log(user_id,activ_date,ip_address) values('" . $_SESSION['userid'] . "','" . $dt . "','" . $ip . "')");
    }

    mysql_query("INSERT INTO bids(task_id,tasker_id,amount,message,firstamnt) values('" . $_REQUEST['taskid'] . "','" . $_SESSION['userid'] . "','" . $amnt . "','" . $_REQUEST['bid-message'] . "','" . $_REQUEST['bid-amount'] . "')");
    //mysql_query("UPDATE tasks SET status=4 WHERE id=".$_REQUEST['taskid']);
    $requester = mysql_fetch_assoc(mysql_query("SELECT a.email,a.fname,lname,b.taskname FROM `members` as a LEFT JOIN tasks as b ON a.id=b.userid WHERE b.id='" . $_REQUEST['taskid'] . "'"));
    $tasker = mysql_fetch_assoc(mysql_query("SELECT a.fname,a.lname FROM members as a WHERE a.id='" . $_SESSION['userid'] . "'"));
    $to = $requester['email'];
    $from = 'info@ubangbangwo.com';
    $subject = 'Recieving bid on ' . strtoupper($requester['taskname']);
    $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h1>Dear " . $requester['fname'] . " " . $requester['lname'] . ",</h1><td></tr><tr><td>Your request <a href='http://www.ubangbangwo.com/dashboard'>" . strtoupper($requester['taskname']) . "</a> received a bid from " . $tasker['fname'] . " " . $tasker['lname'] . "</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";



    $headers = "From: info@ubangbangwo.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to, $subject, $body, $headers);

    die();
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'hireBid') {

    //echo "SELECT * FROM tasks WHERE id='".$_REQUEST['taskid']."' AND status!='2'";
    //$taskStatus = mysql_num_rows(mysql_query("SELECT * FROM tasks WHERE id='".$_REQUEST['taskid']."' AND status='2'"));

    $ip = $_SERVER['REMOTE_ADDR'];
    $dt = date('Y-m-d');
    $user_log = mysql_num_rows(mysql_query("SELECT * FROM user_log WHERE user_id='" . $_SESSION['userid'] . "' and activ_date='" . $dt . "'"));
    if ($user_log <= 0) {
        mysql_query("INSERT INTO user_log(user_id,activ_date,ip_address) values('" . $_SESSION['userid'] . "','" . $dt . "','" . $ip . "')");
    }

    //die("UPDATE bids SET status=1 WHERE task_id='".$_REQUEST['taskid']."' AND tasker_id='".$_REQUEST['userid']."'");
    mysql_query("UPDATE bids SET status=1 WHERE task_id='" . $_REQUEST['taskid'] . "' AND tasker_id='" . $_REQUEST['userid'] . "'");
    mysql_query("UPDATE tasks SET status=2 WHERE id='" . $_REQUEST['taskid'] . "'");
    $tasker = mysql_fetch_assoc(mysql_query("SELECT a.email,a.fname,lname,b.taskname FROM `members` as a LEFT JOIN tasks as b ON a.id=b.userid WHERE b.id='" . $_REQUEST['taskid'] . "'"));
    $requester = mysql_fetch_assoc(mysql_query("SELECT a.fname,a.lname,a.email FROM members as a WHERE a.id='" . $_REQUEST['userid'] . "'"));
    $to = $requester['email'];
    $from = 'info@ubangbangwo.com';
    $subject = 'Accepting bid on ' . strtoupper($tasker['taskname']);
    $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Dear " . $requester['fname'] . " " . $requester['lname'] . ",</h2><td></tr><tr><td>Your recent bid on Task <a href='http://www.ubangbangwo.com/dashboard_tasker'>" . strtoupper($tasker['taskname']) . "</a> is accepted.</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard_tasker'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";


    $headers = "From: info@ubangbangwo.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to, $subject, $body, $headers);
    //$tasker = mysql_fetch_assoc(mysql_query("SELECT a.email,a.fname,lname,b.taskname FROM `members` as a LEFT JOIN tasks as b ON a.id=b.userid WHERE b.id='".$_REQUEST['taskid']."'"));
    //$requester = mysql_fetch_assoc(mysql_query("SELECT a.fname,a.lname,a.email FROM members as a LEFT JOIN bids as b ON a.id=b.userid WHERE a.id!='".$_REQUEST['userid']."' AND b.id='".$_REQUEST['taskid']."'"));
    /* $findOther = mysql_query("SELECT a.email,a.fname,a.lname FROM members as a left join bids as c on c.tasker_id=a.id left join tasks as b on a.id=b.userid  where c.task_id='".$_REQUEST['taskid']."' AND a.id!='".$_REQUEST['userid']."'");
      if(mysql_num_rows($findOther) > 0)
      {
      while($otherTasker = mysql_fetch_array($findOther))
      {
      $to = $otherTasker['email'];
      $from = 'info@ubangbangwo.com';
      $subject = 'BangBangWo';
      $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Dear ".$otherTasker['fname']." ".$otherTasker['lname'].",</h2><td></tr><tr><td>Your recent bid on Task <a href='http://www.ubangbangwo.com/dashboard_tasker'>".strtoupper($tasker['taskname'])."</a> is rejected.</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard_tasker'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";
      $headers = "From: info@ubangbangwo.com\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      mail($to, $subject, $body,$headers);
      }
      }
      //echo "DELETE FROM bids WHERE tasker_id!='".$_REQUEST['userid']."' AND task_id='".$_REQUEST['taskid']."'";
      mysql_query("DELETE FROM bids WHERE tasker_id!='".$_REQUEST['userid']."' AND task_id='".$_REQUEST['taskid']."'"); */

    /* else{
      echo 'false';
      } */
    die();
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'hireSingleBid') {
    //die("SELECT taskmulti FROM tasks WHERE id='".$_REQUEST['taskid']."'");
    $ip = $_SERVER['REMOTE_ADDR'];
    $hetstsmulti = mysql_result(mysql_query("SELECT taskmulti FROM tasks WHERE id='" . $_REQUEST['taskid'] . "'"), 0);
    //die($hetstsmulti."ashish");
    $dt = date('Y-m-d');
    $user_log = mysql_num_rows(mysql_query("SELECT * FROM user_log WHERE user_id='" . $_SESSION['userid'] . "' and activ_date='" . $dt . "'"));
    if ($user_log <= 0) {
        mysql_query("INSERT INTO user_log(user_id,activ_date,ip_address) values('" . $_SESSION['userid'] . "','" . $dt . "','" . $ip . "')");
    }
    //echo "SELECT * FROM tasks WHERE id='".$_REQUEST['taskid']."' AND status!='2'";
    //$taskStatus = mysql_num_rows(mysql_query("SELECT * FROM tasks WHERE id='".$_REQUEST['taskid']."' AND status='2'"));
    //if($taskStatus == 0)
    //  $chkCreditCard=mysql_num_rows(mysql_query("SELECT * FROM taskerdetails WHERE userid='".$_SESSION['userid']."' && secretkey='".$sresult['secretkey']."'"));
    //  echo "SELECT * FROM taskerdetails WHERE cardid!='' AND userid='".$_SESSION['userid']."'";
    $chkCreditCard = mysql_num_rows(mysql_query("SELECT * FROM taskerdetails WHERE cardid !='' AND userid='" . $_SESSION['userid'] . "'"));
    //print_r($chkCreditCard); exit();
    if ($chkCreditCard > 0) {
        //die("UPDATE bids SET status=1 WHERE task_id='".$_REQUEST['taskid']."' AND tasker_id='".$_REQUEST['userid']."'");
        // die("UPDATE bids SET status=1 WHERE task_id='".$_REQUEST['taskid']."' AND tasker_id='".$_REQUEST['userid']."'");
        mysql_query("UPDATE bids SET status=1 WHERE task_id='" . $_REQUEST['taskid'] . "' AND tasker_id='" . $_REQUEST['userid'] . "'");
        mysql_query("UPDATE tasks SET status=2 WHERE id='" . $_REQUEST['taskid'] . "'");

        $tasker = mysql_fetch_assoc(mysql_query("SELECT a.email,a.fname,lname,b.taskname FROM `members` as a LEFT JOIN tasks as b ON a.id=b.userid WHERE b.id='" . $_REQUEST['taskid'] . "'"));
        $requester = mysql_fetch_assoc(mysql_query("SELECT a.fname,a.lname,a.email FROM members as a WHERE a.id='" . $_REQUEST['userid'] . "'"));
        $to = $requester['email'];
        $from = 'info@ubangbangwo.com';

        $subject = 'Accepting bid on ' . strtoupper($tasker['taskname']);
        $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Dear " . $requester['fname'] . " " . $requester['lname'] . ",</h2><td></tr><tr><td>Your recent bid on Task <a href='http://www.ubangbangwo.com/dashboard_tasker'>" . strtoupper($tasker['taskname']) . "</a> is accepted.</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard_tasker'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";




        $headers = "From: info@ubangbangwo.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($to, $subject, $body, $headers);

        //$_POST['action']='payment';
        //$amount=mysql_result(mysql_query("SELECT amount FROM bids WHERE task_id='".$_REQUEST['taskid']."' AND tasker_id='".$_REQUEST['userid']."'"),0);
        //include_once $_SERVER['DOCUMENT_ROOT'].'/payouts/balanced_actions.php';

        $tasker = mysql_fetch_assoc(mysql_query("SELECT a.email,a.fname,lname,b.taskname FROM `members` as a LEFT JOIN tasks as b ON a.id=b.userid WHERE b.id='" . $_REQUEST['taskid'] . "'"));
        $requester = mysql_fetch_assoc(mysql_query("SELECT a.fname,a.lname,a.email FROM members as a LEFT JOIN bids as b ON a.id=b.userid WHERE a.id!='" . $_REQUEST['userid'] . "' AND b.id='" . $_REQUEST['taskid'] . "'"));
        $findOther = mysql_query("SELECT a.email,a.fname,a.lname FROM members as a left join bids as c on c.tasker_id=a.id left join tasks as b on a.id=b.userid  where c.task_id='" . $_REQUEST['taskid'] . "' AND a.id!='" . $_REQUEST['userid'] . "'");
        if (mysql_num_rows($findOther) > 0 && $hetstsmulti <= 0) {
            while ($otherTasker = mysql_fetch_array($findOther)) {
                $to = $otherTasker['email'];
                $from = 'info@ubangbangwo.com';
                $subject = 'Rejected bid on ' . strtoupper($tasker['taskname']);
                $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Dear " . $otherTasker['fname'] . " " . $otherTasker['lname'] . ",</h2><td></tr><tr><td>Your recent bid on Task <a href='http://www.ubangbangwo.com/dashboard_tasker'>" . strtoupper($tasker['taskname']) . "</a> is rejected.</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard_tasker'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";




                $headers = "From: info@ubangbangwo.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                mail($to, $subject, $body, $headers);
            }
        }
        //echo "DELETE FROM bids WHERE tasker_id!='".$_REQUEST['userid']."' AND task_id='".$_REQUEST['taskid']."'";
        if ($hetstsmulti <= 0) {
            mysql_query("update bids set status='3' WHERE tasker_id!='" . $_REQUEST['userid'] . "' AND task_id='" . $_REQUEST['taskid'] . "'");
        }
    } else {
        echo "1";
    }
    /* else{
      echo 'false';
      } */
    die();
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'removeSingle') {
    //echo "SELECT * FROM tasks WHERE id='".$_REQUEST['taskid']."' AND status!='2'";
    $taskStatus = mysql_num_rows(mysql_query("SELECT * FROM tasks WHERE id='" . $_REQUEST['taskid'] . "' AND status='2'"));
    if ($taskStatus == 0) {
        $tasker = mysql_fetch_assoc(mysql_query("SELECT a.email,a.fname,lname,b.taskname FROM `members` as a LEFT JOIN tasks as b ON a.id=b.userid WHERE b.id='" . $_REQUEST['taskid'] . "'"));
        $requester = mysql_fetch_assoc(mysql_query("SELECT a.fname,a.lname,a.email FROM members as a WHERE a.id='" . $_REQUEST['userid'] . "'"));
        $to = $requester['email'];
        $from = 'info@ubangbangwo.com';
        $subject = 'Reject bid on ' . strtoupper($tasker['taskname']);
        $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Dear " . $requester['fname'] . " " . $requester['lname'] . ",</h2><td></tr><tr><td>Your recent bid on Task <a href='http://www.ubangbangwo.com/dashboard_tasker'>" . strtoupper($tasker['taskname']) . "</a> is rejected.</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard_tasker'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";


        $headers = "From: info@ubangbangwo.com\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($to, $subject, $body, $headers);
        //echo "<br>".$body;
        mysql_query("update bids set status='3' WHERE tasker_id!='" . $_REQUEST['userid'] . "' AND task_id='" . $_REQUEST['taskid'] . "'");
    }
    die();
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rejectSingle') {
    //echo "SELECT * FROM tasks WHERE id='".$_REQUEST['taskid']."' AND status!='2'";
    $taskStatus = mysql_num_rows(mysql_query("SELECT * FROM tasks WHERE id='" . $_REQUEST['taskid'] . "' AND status='2'"));
    $tasker = mysql_fetch_assoc(mysql_query("SELECT a.email,a.fname,lname,b.taskname FROM `members` as a LEFT JOIN tasks as b ON a.id=b.userid WHERE b.id='" . $_REQUEST['taskid'] . "'"));
    $requester = mysql_fetch_assoc(mysql_query("SELECT a.fname,a.lname,a.email FROM members as a WHERE a.id='" . $_REQUEST['userid'] . "'"));
    $to = $requester['email'];
    $from = 'info@ubangbangwo.com';
    $subject = 'Reject bid on ' . strtoupper($tasker['taskname']);
    $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Dear " . $requester['fname'] . " " . $requester['lname'] . ",</h2><td></tr><tr><td>Your recent bid on Task <a href='http://www.ubangbangwo.com/dashboard_tasker'>" . strtoupper($tasker['taskname']) . "</a> is rejected.</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard_tasker'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";


    $headers = "From: info@ubangbangwo.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to, $subject, $body, $headers);
    mysql_query("update bids set status='3' WHERE tasker_id='" . $_REQUEST['userid'] . "' AND task_id='" . $_REQUEST['taskid'] . "'");
    //echo "DELETE FROM bids WHERE tasker_id='".$_REQUEST['userid']."' AND task_id='".$_REQUEST['taskid']."'";
    die();
}
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'satisfiedAction') {
    $ip = $_SERVER['REMOTE_ADDR'];
    $dt = date('Y-m-d H:i:s');
    $user_log = mysql_num_rows(mysql_query("SELECT * FROM user_log WHERE user_id='" . $_SESSION['userid'] . "' and activ_date='" . $dt . "'"));
    if ($user_log <= 0) {
        mysql_query("INSERT INTO user_log(user_id,activ_date,ip_address) values('" . $_SESSION['userid'] . "','" . $dt . "','" . $ip . "')");
    }
    $find = mysql_num_rows(mysql_query("SELECT * FROM satisfiedstatus WHERE bid_id='" . $_GET['bid'] . "' AND tasker_id='" . $_GET['tid'] . "'"));
    if ($_GET['status'] == '0' || $_GET['status'] == '1') {
        $status = $_GET['status'];
        mysql_query("INSERT INTO satisfiedstatus(bid_id,tasker_id,status,date) VALUES('" . $_GET['bid'] . "','" . $_GET['tid'] . "','" . $_GET['status'] . "','" . $dt . "')");
        switch ($status) {
            case 0:
                mysql_query("UPDATE members SET dislikes=dislikes+1 WHERE id='" . $_GET['tid'] . "'");
                $rated = 'Disatisfied';
                break;
            case 1:
                mysql_query("UPDATE members SET likes=likes+1 WHERE id='" . $_GET['tid'] . "'");
                $rated = 'Satisfied';
                break;
        }
// "SELECT a.email,a.fname,a.lname,c.taskname FROM `members` as a LEFT JOIN bids as b ON a.id=b.tasker_id LEFT JOIN tasks c ON b.task_id=c.id WHERE b.task_id='".$_GET['bid']."'";
        //$requester = mysql_fetch_assoc(mysql_query("SELECT a.fname,a.lname,a.email FROM members as a WHERE a.id='".$_GET['tid']."'"));
        /*    $requester=mysql_fetch_assoc(mysql_query("SELECT a.email,a.fname,a.lname,c.taskname FROM `members` as a LEFT JOIN bids as b ON a.id=b.tasker_id LEFT JOIN tasks c ON b.task_id=c.id WHERE b.task_id='".$_GET['bid']."'"));

          $to = $requester['email'];
          $from = 'info@ubangbangwo.com';
          $subject = 'Rating on bid to '.strtoupper($requester['taskname']);
          $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Dear ".$requester['fname']." ".$requester['lname'].",</h2><td></tr><tr><td>Your work on Job  <a href='http://www.ubangbangwo.com/dashboard_tasker'><b>".strtoupper($requester['taskname'])."<b></a> is rated.</td></tr><tr><td>&nbsp;</td></tr><tr><td>Rate - ".$rated."</td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";


          $headers = "From: info@ubangbangwo.com\r\n";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
          mail($to, $subject, $body,$headers); */
    }
    die();
}
?>
