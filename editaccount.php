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
	
	        $rp = \Stripe\Recipient::retrieve($_POST['id']);
	         $rp->name = $_POST['name'];
	         $rp->email=$_POST['email'];
	         $rp->type=$_POST['type'];
	         $rp->tax_id=$_POST['tax-id'];
                $rp->bank_account = array('country'=>'US','routing_number'=>$_POST['routing_number'],'account_number'=>$_POST['account_number']);
                 $rp->save();
                
                $data =$rp->active_account;
                
                 $update = mysql_query("update taskerdetails set `bankid` ='".$data->id."' where recipientid ='".$_POST['id']."' && secretkey = '".$sresult['secretkey']."'");
                echo 'Done successfully';
                header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/bankacc.php');
		
	
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
if(!empty($_GET['id']))
{
?>
<hr>
  <div class="row" id="test" style="margin:0;">
    <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                 <a style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 1px;padding: 8px 17px;text-decoration: none;" href="profile.php">Back</a>
                    <div class="panel-heading">
                        <h3 class="panel-title">Connect to Stripe</h3>
                       
                    </div>
                    <div class="panel-body">
                    <?php
                    $secretkey = mysql_query("select * from stripecredentials where id ='1'");
                    $sresult = mysql_fetch_array($secretkey);
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
	
	           $rp = \Stripe\Recipient::retrieve($_GET['id']);
	           if(!empty($rp))
	           {	           
	           $data =$rp->active_account;
	                     
                    ?>
                         <p>(Please double check you bank account information to avoid payment delay.)</p>
                       <form role="form" method="post"  action="" class="form-horizontal">
                       
                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Name</label>
                                    <div class="col-lg-5">
                                        <input type="text" id="name" class="form-control" value="<?php echo $rp->name;?>" name="name" autocomplete="off" placeholder="John Doe" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Email Id</label>
                                    <div class="col-lg-5">
                                        <input type="text" id="email" class="form-control" value="<?php echo $rp->email;?>" name="email" autocomplete="off" placeholder="John @gmail.com" />
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Type</label>
                                    <div class="col-lg-5">
                                        <select name="type" class="form-control">
                                            <option value="individual" <?php if($rp->type=='individual'){ ?> selected="selected" <?php } ?>> Individual </option>
                                            <option value="corporation" <?php if($rp->type=='corporation'){ ?> selected="selected" <?php } ?>> Corporation </option>
                                        </select>                         
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-5 control-label">Tax-Id</label>
                                    <div class="col-lg-5">
                                        <input type="text" id="tax-id" class="form-control" name="tax-id" autocomplete="off" placeholder="*********" />
                                    </div>
                                </div>
                                                                    
                        <hr>
                        <h4>  Bank Account Details </h4>
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
                                    <input type="text" id="routing_number" value="<?php echo $data->routing_number;?> "  class="form-control" name="routing_number" autocomplete="off" placeholder="110000000" maxlength="9" />
                                </div>
                        </div>
                        
                        <div class="form-group">
                                <label class="col-lg-5 control-label">Account Number</label>
                                <div class="col-lg-5">
                                    <input type="text" id="account_number" value="<?php echo '**********'.$data->last4;?> " name="account_number" class="form-control" autocomplete="off" placeholder="000123456789" maxlength="34" size="34" />
                                </div>
                        </div> 
                        
                       
                            <input type="hidden" value="<?php echo $_GET['id'];?>" name="id">
                            <input name="Submit" type="submit" value="Encrypted and Save" class="btn btn-large btn-primary pull-right"/>
                           
                        </form>
                        <?php
                        }
                        else
                        {
                        
                        ?>
                        
                        
                        
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
                                        <input type="text" id="email" class="form-control"  name="email" autocomplete="off" placeholder="John @gmail.com" />
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
                        <h4>  Bank Account Details </h4>
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
                                    <input type="text" id="routing_number"  class="form-control" name="routing_number" autocomplete="off" placeholder="110000000" maxlength="9" />
                                </div>
                        </div>
                        
                        <div class="form-group">
                                <label class="col-lg-5 control-label">Account Number</label>
                                <div class="col-lg-5">
                                    <input type="text" id="account_number" name="account_number" class="form-control" autocomplete="off" placeholder="000123456789" maxlength="34" size="34" />
                                </div>
                        </div> 
                        
                       
                            <input type="hidden" value="<?php echo $_GET['id'];?>" name="id">
                            <input name="Submit" type="submit" value="Encrypted and Save" class="btn btn-large btn-primary pull-right"/>
                           
                        </form>
                        
                        
                        
                        
                        
                        
                        
                        
                        <?php
                        }
                        ?>
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
                 <a style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 1px;padding: 8px 17px;text-decoration: none;" href="profile.php">Back</a>
                    <div class="panel-heading">
                        <h3 class="panel-title">Connect to Stripe</h3>
                       
                    </div>
                    <div class="panel-body">
    
    
    <?php
    echo '<span style="color:red;margin-top:10px;"> No Bank Details </span>';
    ?>
    </div>
    </div>
     </div>
      </div>
       </div>
    <?php
 }
 ?>
