<?php

include_once "config.php";
include_once "include/config.php";
$ip = $_SERVER['SERVER_ADDR']; // the IP address to query
$query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));
date_default_timezone_set($query['country']); // CDT


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



$bal = \Stripe\Balance::retrieve();

$balance_array = $bal->__toArray(true);


$amnt = $balance_array['available'][0]['amount'];

if ($amnt != 0) {

    $task = mysql_query("SELECT * FROM tasks WHERE id IN (SELECT bid_id FROM satisfiedstatus) ORDER BY `id` DESC");
    while ($taskrec = mysql_fetch_array($task)) {

        $id[] = $taskrec['id'];
    }
    $idrec = implode(",", $id);


    $satisfy = mysql_query("SELECT * FROM  satisfiedstatus where bid_id IN ($idrec)");
    while ($satisfyrec = mysql_fetch_array($satisfy)) {

        $chkdate = date('Y-m-d', strtotime($satisfyrec['date']));
        $enddate = date('Y-m-d', strtotime($chkdate . "-2 weeks"));
        //$enddate = date('Y-m-d', strtotime($satisfyrec['date']));

        if (strtotime($chkdate) == strtotime($enddate)) {
            $tid[] = $satisfyrec['bid_id'];
        }
    }

    if (!empty($tid)) {
        $tidrec = implode(",", $tid);
        $bid = mysql_query("SELECT * FROM bids WHERE task_id IN ($tidrec) ORDER BY `id` DESC");
        while ($bidrec = mysql_fetch_array($bid)) {
            $amount[] = $bidrec['amount'] - $bidrec['firstamnt'];
        }
        $admin = mysql_query("SELECT * FROM admin_bank_details WHERE id='1'");
        $adminrec = mysql_fetch_array($admin);
        $actualprice = array_sum($amount) * 100;
        $currentdate = date("Y-m-d H:i:s");
//die("insert into transaction_details (`price`,`date`,`status`) values('" . $actualprice . "','" . $currentdate . "','Transfer complete')");
        try {
            $data = \Stripe\Transfer::create(array(
                        "amount" => $actualprice,
                        "currency" => "usd",
                        "recipient" => $adminrec['recipientid'],
                        //"card" =>$data['cardid'],
                        "destination" => $adminrec['bankid'],
                        // "source_transaction" =>$rec['chargeid'],
                        "description" => "Transfer Successfully"));




            echo"<h3>Transfer has been done Successfully</h3>";
            $actualprice = $actualprice / 100;

            $query = mysql_query("insert into transaction_details (`price`,`date`,`status`) values('" . $actualprice . "','" . $currentdate . "','Transfer complete')");
        } catch (Stripe_CardError $e) {
            $error = $e->getMessage();
            echo '<br><span style="color:red">' . $error . '</span><br>';
            $query = mysql_query("insert into transaction_details (`price`,`date`,`status`) values('" . $actualprice . "','" . $currentdate . "','" . $error . "')");
        } catch (stripe_InvalidRequestError $e) {
            $error = $e->getMessage();
            echo '<br><span style="color:red">' . $error . '</span><br>';
            $query = mysql_query("insert into transaction_details (`price`,`date`,`status`) values('" . $actualprice . "','" . $currentdate . "','" . $error . "')");
        } catch (stripe_AuthenticationError $e) {
            $error = $e->getMessage();
            echo '<br><span style="color:red">' . $error . '</span><br>';
            $query = mysql_query("insert into transaction_details (`price`,`date`,`status`) values('" . $actualprice . "','" . $currentdate . "','" . $error . "')");
        } catch (Exception $e) {
            $error = $e->getMessage();
            echo '<br><span style="color:red">' . $error . '</span><br>';
            $query = mysql_query("insert into transaction_details (`price`,`date`,`status`) values('" . $actualprice . "','" . $currentdate . "','" . $error . "')");
        }
    }
} else {
    $to = 'sachin.shinedezign@gmail.com';
    $subject = "Notification";


    $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h1>Dear Zheng Zhou,</h1><td></tr><tr><td>Available balance in stripe is Null.</td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";


    //$msg = wordwrap($msg,70);
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    mail($to, $subject, $body, $headers);
}
?>