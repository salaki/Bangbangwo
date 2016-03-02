<?php
include_once "config.php";
include_once "include/header.php";
//taskerid  ==userid
//print_r($_POST); exit();
$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);
$details = mysql_query("select * from members where id ='" . $_POST['taskerid'] . "'");
$rec = mysql_fetch_array($details);
//transfer = servicefee - stripefee
$servicefee = floor($_POST['amount'] * 0.15 - ($_POST['amount'] * 1.15 * 0.029 + 30));

//echo "select * from taskerdetails where userid = '".$_POST['taskerid']."' && secretkey='".$sresult['secretkey']."'";
$checkcreditdetails = mysql_query("select * from taskerdetails where userid = '" . $_POST['taskerid'] . "' && secretkey='" . $sresult['secretkey'] . "'");
if (mysql_num_rows($checkcreditdetails) > 0) {
    $data = mysql_fetch_array($checkcreditdetails);

    $source = mysql_query("select * from stripepayment where taskid = '" . $_POST['taskid'] . "' && taskerid = '" . $_POST['taskerid'] . "'");
    $rec = mysql_fetch_array($source);

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
        $data = \Stripe\Transfer::create(array(
                    "amount" => $_POST['amount'],
                    "currency" => "usd",
                    "recipient" => $data['recipientid'],
                    //"card" =>$data['cardid'],
                    "destination" => $data['bankid'],
                    "source_transaction" => $rec['chargeid'],
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

//echo "update satisfiedstatus set `paymentstatus` ='1' where bid_id ='" . $_POST['taskid'] . "' && tasker_id = '" . $_POST['taskerid'] . "'"; exit();
            $update = mysql_query("update satisfiedstatus set `paymentstatus` ='1' where bid_id ='" . $_POST['taskid'] . "' && tasker_id = '" . $_POST['taskerid'] . "'");


            echo"<h3>Transfer has been done Successfully</h3>";
            $_SESSION['bid'] = $_POST['taskid'];
            $_SESSION['tid'] = $_POST['taskerid'];
            $_SESSION['amount'] = $_POST['amount'];

            $gettaskdetail = mysql_query("select * from tasks where id='" . $_POST['taskid'] . "'");
            $taskdetail = mysql_fetch_array($gettaskdetail);
            $taskname = $taskdetail['taskname'];

            $data = mysql_query("select * from members where id='" . $_POST['taskerid'] . "'");
            $rec = mysql_fetch_array($data);
            $to = $rec['email'];
            $subject = "Payment Transfer Notification";
            //$to = 'sandeep.shinedezign@gmail.com';


            /* $msg =    "<div style='border:1px solid red;height:200px;width:357px;margin-top:30px;'>
              <span style='height:30px;float:left;width:100%;border-bottom:1px solid #000;margin-bottom:10px;padding-left:12px;'>
              <h2>BangBangWo</h2>
              <p>Getting help from your schoolmate</p>
              </span>
              <span style='margin-left:10px;font-weight:bold;'>Dear Zheng Zhou, </span>
              <p style='font-size: 14px;height: 42px; margin-top: 32px;text-align: center;'>
              Your Payment $ ".$_POST['amount']." is refunded to your credit card for task ".$taskname.".
              </p>
              <p style='font-size: 14px;height: 42px; margin-top: 32px;text-align: center;'></p>
              <p style='font-size: 14px;height: 42px; margin-top: 32px;text-align: center;'> <a href='http://www.ubangbangwo.com/dashboard'>Click here to view </a> </p>
              <span style='margin-left: 10px;font-size:14px;'>Thanks </span>
              <br>
              <span style='margin-left: 10px;font-size:14px;'>Your BangBangWo Team </span>
              </div>"; */

            // use wordwrap() if lines are longer than 70 characters

            $amnt = $_POST['amount'] / 100;
            $body = "<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h1>Dear " . $rec['fname'] . " " . $rec['lname'] . ",</h1><td></tr><tr><td>Your Work on Job <b>" . $taskname . "</b> is rated.</td></tr><tr><td>&nbsp;</td></tr><tr><td>Rate - Satisfied</td></tr><tr><td>&nbsp;</td></tr><tr><td>$" . $amnt . " is Transferring to your account </td></tr><tr><td><a href='http://www.ubangbangwo.com/dashboard'>Click here to view</a></td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";


            //$msg = wordwrap($msg,70);
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            mail($to, $subject, $body, $headers);
       


        if ($_POST['pageno'] != '') {
            header('Refresh: 2; URL=http://' . $_SERVER['HTTP_HOST'] . '/dashboard?page_no=' . $_POST['pageno'] . '&satisfied');
        } else {
            header('Refresh: 2; URL=http://' . $_SERVER['HTTP_HOST'] . '/dashboard?page_no=1&satisfied');
        }
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
} else {
    echo '<br><span style="color:red">Credit card details didnot enter by Tasker .. Ask him to Connect with stripe</span><br>';
}
?>
