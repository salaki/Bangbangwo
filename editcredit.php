<?php
include_once "config.php"; 
include_once "include/header.php";  

if(isset($_POST['Submit']))
{
$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);

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
	
	
	
	        $rp = \Stripe\Customer::retrieve($_POST['id']);
	       	
               $token = \Stripe\Token::create(array(
                  "card" =>array('name'=>$_POST['cc-name'],'number'=>$_POST["cc-number"],'exp_month'=>$_POST["cc-ex-month"] ,'exp_year' =>$_POST["cc-ex-year"],'cvc'=>$_POST["ex-cvc"])
                ));
                
               //  print_r($token->card->id); exit();
               //	echo "select * taskerdetails  where userid ='".$_SESSION['userid']."'"; exit();
               		$updates = mysql_query("select * from taskerdetails  where userid ='".$_SESSION['userid']."'") or die(mysql_error());
           		if(mysql_num_rows($updates)>0){
           			 $update = mysql_query("update taskerdetails set `cardid` ='".$token->card->id."' where customerid ='".$_POST['id']."' && secretkey = '".$sresult['secretkey']."'");
           		}else{
           		$insert = mysql_query("insert into taskerdetails(`userid`,`recipientid`,`cardid`,`secretkey`,`customerid`) values('" . $_SESSION['userid'] . "','','".$token->card->id."','".$sresult['secretkey']."','".$_POST['id']."')");
           			
           		}
        		  
        
	         $rp->source =  $token->id;
	   
	        $rp->save();
                echo 'Edit successfully';
                header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/connect.php');
                
		
	
   }
	

catch(Stripe_CardError $e){
	$error = $e->getMessage();
	echo '<span style="color:red">'.$error.'</span>';
}

catch(stripe_InvalidRequestError $e){
   $error = $e->getMessage();
	echo '<span style="color:red">'.$error.'</span>';
}

catch(stripe_AuthenticationError $e){
	$error = $e->getMessage();
	echo '<span style="color:red">'.$error.'</span>';
}

catch(Exception $e){
	$error = $e->getMessage();
	echo '<span style="color:red">'.$error.'</span>';
}





}
?>

<?php

if($_GET['cid']!='')
{
?>

<hr>
  <div class="row" id="test" style="margin:0;">
    <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-primary">
                 <a style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 1px;padding: 8px 17px;text-decoration: none;" href="profile.php">Back</a>
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Card Details</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        $secretkey = mysql_query("select * from stripecredentials where id ='1'");
                        $sresult = mysql_fetch_array($secretkey);
                        
                        $rec = mysql_query("select * from taskerdetails  where customerid ='".$_GET['id']."' && cardid = '".$_GET['cid']."' && secretkey = '".$sresult['secretkey']."'");
                        $sresult1 = mysql_fetch_array($rec);
                        
                        $stripeClassesDir = __DIR__ . '/Stripe/lib/';
	                $stripeUtilDir    = $stripeClassesDir . 'Util/';
	                $stripeErrorDir   = $stripeClassesDir . 'Error/';

	                set_include_path($stripeClassesDir . PATH_SEPARATOR . $stripeUtilDir . PATH_SEPARATOR . $stripeErrorDir);
	                function __autoload($class)
	                {
		                $parts = explode('\\', $class);
		                require end($parts) . '.php';
	                }
	                ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
                                      
                       \Stripe\Stripe::setApiKey($sresult['secretkey']);
                       

                        $customer = \Stripe\Customer::retrieve($_GET['id']);
                        
                        //Add Code 
                          
                        mysql_query("update taskerdetails set `cardid`='".$customer->sources->data[0]->id."' WHERE userid='".$_SESSION['userid']."'");
                        
                        //Add Code
                       
                        $card = $customer->sources->retrieve($customer->sources->data[0]->id);
                       
                        ?>
                    
                       <form role="form" method="post"  action="" class="form-horizontal">
                       
                                                                    
                        <hr>                        
                         <h4> Card Details </h4>   
                        <hr>        
                        <div class="form-group">
                                <label class="col-lg-5 control-label">Card Number</label>
                                <div class="col-lg-5">
                                    <input type="text" id="cc-number" class="form-control" value="<?php echo '******'.$card->last4;?>" name="cc-number" autocomplete="off" placeholder="4111111111111111" />
                                </div>
                            </div>                                   
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Name on Card</label>
                                <div class="col-lg-5">
                                    <input type="text" id="cc-name" value="<?php echo $card->name;?>" class="form-control" name="cc-name" autocomplete="off" placeholder="John Doe" />
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Expiration</label>
                                <div class="col-lg-2">
                                    <input type="text" id="cc-ex-month" value="<?php echo $card->exp_month;?>" name="cc-ex-month" class="form-control" autocomplete="off" placeholder="09" maxlength="2" />
                                </div>
                                <div class="col-lg-2">
                                    <input type="text" id="cc-ex-year" value="<?php echo $card->exp_year;?>" name="cc-ex-year" class="form-control" autocomplete="off" placeholder="19" maxlength="2" />
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <label class="col-lg-5 control-label">Security Code (CVC)</label>
                                <div class="col-lg-2">
                                    <input type="text" id="ex-cvc" name="ex-cvc" class="form-control" autocomplete="off" placeholder="***"  maxlength="4" />
                                </div>
                            </div>
                            
                            <input type="hidden" value="<?php echo $_GET['id'];?>" name="id">
                            <input type="hidden" value="<?php echo $_GET['cid'];?>" name="cid">
                            <input name="Submit" type="submit" value="Encrypted and Save" class="btn btn-large btn-primary pull-right"/>
                           
                            </div> 
                            
                            
                            
                       
                            
                        </form>
                    </div>
                   
                </div>
            </div>
         
        </div>
  </div>
 <hr>







<?php
}
else
{
?>
<hr> 
  <div class="row" id="test" style="margin:0;">
    <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-primary">
                
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Credit Card Details</h3>
                    </div>
                    <div class="panel-body">
                       <form role="form" method="post"  action="" class="form-horizontal">
                       
                                                                    
                       <hr>                                           
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
                            <input type="hidden" value="<?php echo $_GET['id'];?>" name="id">
                            <input type="hidden" value="<?php echo $_GET['cid'];?>" name="cid">
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
