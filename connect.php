z<?php
include_once "config.php";
include_once "include/header.php";

$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);


if (isset($_POST['Submit']) == 'Tokenize') {
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


         $token = \Stripe\Token::create(array(
                  "card" =>array('number'=>$_POST["cc-number"],'exp_month'=>$_POST["cc-ex-month"] ,'exp_year' =>$_POST["cc-ex-year"],'cvc'=>$_POST["ex-cvc"])
                ));
                 
                 
        if (isset($token->id)) {
            $secretkey = mysql_query("select * from taskerdetails where userid ='" . $_SESSION['userid'] . "'");
            if (mysql_num_rows($secretkey) > 0) {
            	$details=mysql_fetch_array($secretkey);
            	if(empty($details['customerid'])) {
                	$customer = \Stripe\Customer::create(array(
                     	"description" => $_POST["cc-name"],
                     	"source" => $token->id // obtained with Stripe.js
                   	));
                	$insert = mysql_query("insert into taskerdetails(`userid`,`recipientid`,`cardid`,`secretkey`,`customerid`) values('" . $_SESSION['userid'] . "','','".$customer->sources->data['0']->id."','".$sresult['secretkey']."','".$customer->id."')");
                }
                else {
            		$rp = \Stripe\Customer::retrieve($details['customerid']);
			$rp->source=$token->id;
			$rp->save();
                	$insert = mysql_query("update taskerdetails set `cardid`='" .$rp->sources->data['0']->id . "' WHERE userid='" . $_SESSION['userid'] . "'");
                }
            } else {
            	$customer = \Stripe\Customer::create(array(
                     "description" => $_POST["cc-name"],
                     "source" => $token->id // obtained with Stripe.js
                   ));
                $insert = mysql_query("insert into taskerdetails(`userid`,`recipientid`,`cardid`,`secretkey`,`customerid`) values('" . $_SESSION['userid'] . "','','".$customer->sources->data['0']->id."','".$sresult['secretkey']."','".$customer->id."')");
            }
        }
        

        echo"<h3>Details has been created in the Stripe Account</h3>";
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

\Stripe\Stripe::setApiKey($sresult['secretkey']);
$secretkey = mysql_query("select * from taskerdetails where cardid !='' and userid ='" . $_SESSION['userid'] . "'");

?>
<style type="text/css">
.credittd
{
 width: 197px;
}      
</style>
<br> <br> <br>
 <div style="background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;float:left;width:100%;">
<?php

if (mysql_num_rows($secretkey) > 0) {
    $rec = mysql_fetch_array($secretkey);
    ?>

    <div style="margin-bottom:111px;">
    
        <a href="editcredit.php?id=<?php echo $rec['customerid']; ?>&cid=<?php echo $rec['cardid']; ?>" style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 17px;padding: 10px 17px;text-decoration: none;"> Edit Credit Card Details</a>
      
         
        <a href="deletecard.php?id=<?php echo $rec['customerid']; ?>" style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 17px;padding: 10px 17px;text-decoration: none;">Do you want to Delete the card ?  </a>
      
    </div> 

    <?php
//    print_r($rec);
      $data = \Stripe\Customer::retrieve($rec['customerid']);
      

    //$data = \Stripe\Recipient::retrieve($rec['recipientid']);
    ?>
   
   
   <!-- <div  style="padding:0px 8px 6px 6px;width: 441px;">
        <table>
            <tr>
                <td class="credittd" style="width:240px;"> Name </td>
                <td class="credittd">
    <?php echo $data->description; ?>
                </td>
            </tr>
            <tr>
                <td class="credittd"> Email id </td>
                <td class="credittd">
    <?php  echo $data->email; ?>
                </td>
            </tr>

        </table>
    </div> -->


    <hr>
    <?php
  	

 
            ?>

            <div style="border: 1px solid #000000;float: left; margin-bottom: 21px; padding: 24px 8px 25px 118px;width:100%;">  
                <table align="center;">
                    <!--<th class="credittd"> Card Details</th> -->


                    <!--<tr>
                        <td class="credittd" style="width:240px;"> Full name on Card</td>
                        <td><?php //echo $cardetail->name; ?></td>
                        <td>&nbsp;</td> <td> </td>
                    </tr> -->
                    <tr>
                        <td class="credittd">Card Type</td>
                        <td class="credittd"><?php echo $data->sources->data['0']->brand; ?></td>
                    </tr>
                    <tr>
                        <td class="credittd">Card Number</td>
                        <td class="credittd">************<?php echo $data->sources->data['0']->last4; ?></td>
                    </tr>
                    <tr>
                        <td class="credittd">Expire Month/ Year</td>
                        <td class="credittd"><?php echo $data->sources->data['0']->exp_month; ?>/<?php echo $data->sources->data['0']->exp_year; ?></td>
                    </tr>
                    <tr>
                        <td class="credittd">Country</td>
                        <td class="credittd"><?php echo $data->sources->data['0']->country; ?></td>
                    </tr>

                </table>
            </div>
      

            <?php
  
    
} else {
    ?>

    <br>

    <hr>
    <div class="row" id="test" style="margin:0;">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
<a href="profile.php"  style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 1px;padding: 8px 17px;text-decoration: none;">Back</a>
                    <div class="panel-heading">
                        <h3 class="panel-title">Credit Card Info</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post"  action="" class="form-horizontal">
			    <!--	
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Name</label>
                                <div class="col-lg-5">
                                    <input type="text" id="name" class="form-control" name="name" autocomplete="off" placeholder="optional" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-5 control-label">Email Id</label>
                                <div class="col-lg-5">
                                    <input type="text" id="email" class="form-control" name="email" autocomplete="off" placeholder="optional" />
                                </div>
                            </div>




                            <div class="form-group">
                                <label class="col-lg-5 control-label">Mobile Number</label>
                                <div class="col-lg-5">
                                    <input type="text" id="mobile-id" class="form-control" name="mobile-id" autocomplete="off" placeholder="optional" />
                                </div>
                            </div>


                            <hr>                        
                            <h4> Add Card Details </h4>   
                            <hr>
                            -->                                           
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Name on Card</label>
                                <div class="col-lg-5">
                                    <input type="text" id="cc-name" class="form-control" name="cc-name" autocomplete="off" placeholder="John Doe" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Card Number</label>
                                <div class="col-lg-5">
                                    <input type="text" id="cc-number" name="cc-number" class="form-control" autocomplete="off" placeholder="4000056655665556" maxlength="16" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Expiration</label>
                                <div class="col-lg-2">
                                    <input type="text" id="cc-ex-month" name="cc-ex-month" class="form-control" autocomplete="off" placeholder="09" maxlength="2" />
                                </div>
                                <div class="col-lg-2">
                                    <input type="text" id="cc-ex-year" name="cc-ex-year" class="form-control" autocomplete="off" placeholder="19" maxlength="2" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Security Code (CVC)</label>
                                <div class="col-lg-2">
                                    <input type="text" id="ex-cvc" name="ex-cvc" class="form-control" autocomplete="off" placeholder="111" maxlength="4" />
                                </div>
                            </div> 

                            <input name="Submit" type="submit" value="Encrypted and Save" class="btn btn-large btn-primary pull-right"/>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <hr>
    <?php
}
?>


</div>








<?php
/*
  \Stripe\Stripe::setApiKey($sresult['secretkey']);
  $secretkey = mysql_query("select * from stripepayment where loggedinuser ='".$_SESSION['userid']."' && secretkey='".$sresult['secretkey']."'");
  $rec= mysql_fetch_array($secretkey);



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
  $data = \Stripe\Token::retrieve($rec['tokenid']);

  ?>
  <table>
  <tr>
  <td> Name </td>
  <td>
  <?php echo $data->name;?>
  </td>
  </tr>
  <tr>
  <td> Email id </td>
  <td>
  <?php echo $data->email;?>
  </td>
  </tr>

  </table>

  <hr>
  <?php
  $cards=  $data->card;

  ?>


  <table>
  <th> Card Details</th>

  <tr>
  <td>Full name on Card</td>
  <td><?php echo $cards->name;?></td>
  </tr>
  <tr>
  <td>Card Type</td>
  <td><?php echo $cards->brand;?></td>
  </tr>
  <tr>
  <td>Card Number</td>
  <td>************<?php echo $cards->last4;?></td>
  </tr>
  <tr>
  <td>Expire Month/ Year</td>
  <td><?php echo $cards->exp_month;?>/<?php echo $cards->exp_year;?></td>
  </tr>
  <tr>
  <td>Country</td>
  <td><?php echo $cards->country;?></td>
  </tr>

  </table>

  <?php

  }


  catch(Stripe_CardError $e){
  $error = $e->getMessage();
  echo '<span style="color:red">'.$error.'</span>';
  ?>
  <script type="text/javascript">
  document.getElementById("test").style.display = "block";
  </script>
  <?php
  }

  catch(stripe_InvalidRequestError $e){
  $error = $e->getMessage();
  echo '<span style="color:red">'.$error.'</span>';
  ?>
  <script type="text/javascript">
  document.getElementById("test").style.display = "block";
  </script>
  <?php
  }

  catch(stripe_AuthenticationError $e){
  $error = $e->getMessage();
  echo '<span style="color:red">'.$error.'</span>';
  ?>
  <script type="text/javascript">
  document.getElementById("test").style.display = "block";
  </script>
  <?php
  }

  catch(Exception $e){
  $error = $e->getMessage();
  echo '<span style="color:red">'.$error.'</span>';
  ?>
  <script type="text/javascript">
  document.getElementById("test").style.display = "block";
  </script>
  <?php
  }
 */



include_once "include/footer.php";
?>
