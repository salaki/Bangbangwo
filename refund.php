<?php

require_once "include/config.php";
require_once('stripe/lib/Stripe.php');

$cquery = mysql_query("select * from stripepayment where taskid = '" . $_POST['tid'] . "'");
$chargeid = mysql_fetch_array($cquery);

$query = mysql_query("SELECT * FROM tasks WHERE id='" . $_POST['tid'] . "' and  id NOT IN (SELECT bid_id FROM satisfiedstatus ) ORDER BY  `id` DESC");
if (mysql_num_rows($query) > 0) {

    $secretkey = mysql_query("select * from stripecredentials where id ='1'");
    $sresult = mysql_fetch_array($secretkey);


    try {
        $amnt = mysql_query("select * from bids where task_id = '" . $_POST['tid'] . "'");
        $getamnt = mysql_fetch_array($amnt);
        Stripe::setApiKey($sresult['secretkey']);
        $ch = Stripe_Charge::retrieve($chargeid['chargeid']);
        $re = $ch->refunds->create();
        echo"<h3>Refunded successfully</h3>";

        $recdata = mysql_fetch_array($query);
        $dataagain = mysql_query("select * from members where id='" . $recdata['userid'] . "'");
        $recagain = mysql_fetch_array($dataagain);

        $to = $recagain['email'];  // send mail to tasker
        //$to = 'sandeep.shinedezign@gmail.com';

        $subject = ucfirst($recdata['taskname']) . $recagain['email'] . " is Refunded ";
        $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h1>Dear " . $recagain['fname'] . " " . $recagain['lname'] . ",</h1><td></tr><tr><td>Your Payment of $" . $getamnt['amount'] . " is refunded to credit card for task " . ucfirst($recdata['taskname']) . "</td></tr><tr><td>&nbsp;</td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";

        $headers = 'From: bangbangwo@box1042.bluehost.com.' . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    } catch (Stripe_CardError $e) {
        $error = $e->getMessage();
        echo '<br><span style="color:red">' . $error . '</span><br>';
    } catch (stripe_InvalidRequestError $e) {
        $error = $e->getMessage();
        echo '<br><span style="color:red">' . $error . '</span><br>';
    } catch (stripe_AuthenticationError $e) {
        $error = $e->getMessage();
        echo '<br><span style="color:red">' . $error . '</span><br>';
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo '<br><span style="color:red">' . $error . '</span><br>';
    }
}
?>
