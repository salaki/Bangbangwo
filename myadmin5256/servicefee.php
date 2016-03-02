<?php
include_once "include/config.php";
session_start();
ob_start();
if(!isset($_SESSION['adminUser']) || $_SESSION['adminUser'] == '')
{
	header('location:login.php');
}
include_once "include/header.php";
$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);
        $stripeClassesDir = 'Stripe/lib/';
        $stripeUtilDir = $stripeClassesDir . 'Util/';
        $stripeErrorDir = $stripeClassesDir . 'Error/';

        set_include_path($stripeClassesDir . PATH_SEPARATOR . $stripeUtilDir . PATH_SEPARATOR . $stripeErrorDir);

        function __autoload($class) {
            $parts = explode('\\', $class);
            require end($parts) . '.php';
        }



if (isset($_POST['Submit']) == 'Tokenize' && isset($_POST['name']) != '')
 {
 try {
        

        \Stripe\Stripe::setApiKey($sresult['secretkey']);

    

	$updates = mysql_query("select * from admin_bank_details  where id ='1'") or die(mysql_error());
        $rows=mysql_fetch_array($updates);
	if(mysql_num_rows($updates)==0){
      			
		        $token = \Stripe\Token::create(array(
		                    "bank_account" => array('country' => 'US', 'routing_number' => $_POST["routing_number"], 'account_number' => $_POST["account_number"])
		        ));
		
		
		/* sachin changes here
		        $customer = \Stripe\Customer::create(array(
		                    "description" => $_POST['email'],
		                    "source" => $token->id // obtained with Stripe.js
		        ));
		        */

		        $recipient = \Stripe\Recipient::create(array(
	                    "name" => $_POST['name'],
	                    "email" => $_POST['email'],
	                    "description" => $_POST['description'],
	                    "type" => $_POST['type'],
	                    "tax_id" => $_POST['tax-id'],
	                    "bank_account" => array('country' => 'US', 'routing_number' => $_POST["routing_number"], 'account_number' => $_POST["account_number"]),	                        
	       		));
	
	        $bank = $recipient->active_account;
	        $insert = mysql_query("insert into admin_bank_details(`id`,`userid`,`recipientid`,`secretkey`,`customerid`,`bankid`) values('1','1','" . $recipient->id . "','" . $sresult['secretkey'] . "','".$customer->id."','" . $bank->id . "')");
	}else if(empty($rows['bankid'])){
		
		 $recipient = \Stripe\Recipient::create(array(
	                    "name" => $_POST['name'],
	                    "email" => $_POST['email'],
	                    "description" => $_POST['description'],
	                    "type" => $_POST['type'],
	                    "tax_id" => $_POST['tax-id'],
	                    "bank_account" => array('country' => 'US', 'routing_number' => $_POST["routing_number"], 'account_number' => $_POST["account_number"]),	                        
	       		));
		//print_r($recipient ); exit();
	        $bank = $recipient ->active_account;
	        $insert = mysql_query("update admin_bank_details set `recipientid`='".$recipient->id."' ,`bankid`='" . $bank->id . "' WHERE id='1'") or die(mysql_error());
	
	}
        echo"<span style='color:red'>Details has been created in the Stripe Account</span>";
    } catch (Stripe_CardError $e) {
        $error = $e->getMessage();
        echo '<span style="color:red">' . $error . '</span>';
    } catch (stripe_InvalidRequestError $e) {
        $error = $e->getMessage();
        echo '<span style="color:red">' . $error . '</span>';
    } catch (stripe_AuthenticationError $e) {
        $error = $e->getMessage();
        echo '<span style="color:red">' . $error . '</span>';
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo '<span style="color:red">' . $error . '</span>';
    }
 }
?>



<div style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;float:left;">
<?php
\Stripe\Stripe::setApiKey($sresult['secretkey']);
$secretkey = mysql_query("select * from admin_bank_details where userid ='1' && secretkey='" . $sresult['secretkey'] . "'");
$rec = mysql_fetch_array($secretkey);

?>


   <a href="editbank.php?id=<?php echo $rec['recipientid']; ?>" style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 17px;padding: 10px 17px;text-decoration: none;">Edit Bank Account Details</a>
   <div style="float: left; margin-bottom: 21px;  padding: 24px 179px 25px 118px; ">
       <?php
        if(mysql_num_rows($secretkey)==0)
          {
           $trun= mysql_query("Truncate table admin_bank_details ");
          ?>
         <div class="row" id="test" style="margin: 0 0 0 30px;">
            <div class="row">
                <div>
                    <div class="panel panel-primary">
			<a href="profile.php"  style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 1px;padding: 8px 17px;text-decoration: none;">Back</a>
                        <div class="panel-heading">
                            <h3 class="panel-title">Bank Details</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post"  action="" class="form-horizontal">

                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Name</label>
                                    <div class="col-lg-5">
                                        <input type="text" id="name" class="form-control" name="name" autocomplete="off" placeholder="John Doe" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Email Id</label>
                                    <div class="col-lg-5">
                                        <input type="text" id="email" class="form-control" name="email" autocomplete="off" placeholder="John @gmail.com" />
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Type</label>
                                    <div class="col-lg-5">
                                        <select name="type" class="form-control">
                                            <option value="individual"> Individual </option>
                                            <option value="corporation"> Corporation </option>
                                        </select>                         
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Tax-Id</label>
                                    <div class="col-lg-5">
                                        <input type="text" id="tax-id" class="form-control" name="tax-id" autocomplete="off" placeholder="000000000" />
                                    </div>
                                </div>

                                <hr>
                                <h4> Add Bank Account Details </h4>
                                <hr>

                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Bank Country</label>
                                    <div class="col-lg-5">
                                        <select class="field" name="bank_country" disabled="disabled">
                                            <option value="US">United States</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Routing Number</label>
                                    <div class="col-lg-5">
                                        <input type="text" id="tax-id" class="form-control" name="routing_number" autocomplete="off" placeholder="110000000" maxlength="9" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Account Number</label>
                                    <div class="col-lg-5">
                                        <input type="text" id="account_number" name="account_number" class="form-control" autocomplete="off" placeholder="000123456789" maxlength="34" size="34" />
                                    </div>
                                </div> 



                                <input name="Submit" type="submit" value="Tokenize" class="btn btn-large btn-primary pull-right"/>

                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <hr>
    

</div>
<?php
}
else
{
       $data = \Stripe\Recipient::retrieve($rec['recipientid']);
    
       $bankdetail = $data->active_account;
       ?> 

        <div class="row" id="test" style="margin: 0 0 0 30px;">
       
            <div class="row">
             <table>
                <tr>
                    <td class="credittd" style="width:239px;"> Bank Name </td>
                    <td class="credittd"> <?php echo $bankdetail->bank_name; ?></td>
                </tr>
                <tr>
                    <td class="credittd"> Account Number </td>
                    <td class="credittd"> <?php echo '*******' . $bankdetail->last4; ?></td>
                </tr>

                <tr>
                    <td class="credittd"> Routing Number </td>
                    <td class="credittd"> <?php echo $bankdetail->routing_number; ?></td>
                </tr>


            </table>
            </div>
            </div>
    <?php
   

        }
        ?>



</div>

</div>

<?php
include_once "include/footer.php";
?>
