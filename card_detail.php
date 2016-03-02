<?php
// top part of page
	include_once "include/header.php";
        // end top part
        
        
 // Updation for profile 


// End Updation here
?>
  <!-- /.row --> 
  
  <!-- Project One -->
  <div class="row" id="con1">
    <div class="col-md-12">
        <script>
            function add_credit(){
                var name=$('#cc-name');
                var cc_number=$('#cc-number');
                var month_var=$('#cc-ex-month');
                var year_var=$('#cc-ex-year');
                var amount=$('#amount');
                var csv=$('#ex-csc');
                if(name.val()==''){
                    alert('Please enter your name');
                    return false;
                }else if(cc_number.val()==''){
                    alert('Please enter your card number');
                    return false;
                }else if(month_var.val()=='' || year_var.val()==''){
                    alert('Please enter your card expiry');
                    return false;
                }else if(csv.val()==''){
                    alert('Please enter your security code');
                    return false;
                }
            }
         </script>
    </div>
  </div>
  <!-- /.row -->
  
  <hr>
  <div class="row" id="con1" style="margin:0;">
    <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tokenize Credit Card</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" onsubmit="return add_credit()" action="payouts/balanced_actions.php" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Name on Card</label>
                                <div class="col-lg-5">
                                    <input type="text" id="cc-name" class="form-control" name="cc-name" autocomplete="off" placeholder="John Doe" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Card Number</label>
                                <div class="col-lg-5">
                                    <input type="text" id="cc-number" name="cc-number" class="form-control" autocomplete="off" placeholder="4111111111111111" maxlength="16" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Expiration</label>
                                <div class="col-lg-2">
                                    <input type="text" id="cc-ex-month" name="cc-ex-month" class="form-control" autocomplete="off" placeholder="01" maxlength="2" />
                                </div>
                                <div class="col-lg-2">
                                    <input type="text" id="cc-ex-year" name="cc-ex-year" class="form-control" autocomplete="off" placeholder="2015" maxlength="4" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Security Code (CSC)</label>
                                <div class="col-lg-2">
                                    <input type="text" id="ex-csc" name="ex-csc" class="form-control" autocomplete="off" placeholder="123" maxlength="4" />
                                </div>
                            </div> 
                            
                            <input name="Submit" type="submit" value="Tokenize" class="btn btn-large btn-primary pull-right"/>
                            <input type="hidden" name="action" value="add_credit" />
                            <input type="hidden" name="type" value="<?php echo $_GET['action']; ?>" />
                        </form>
                    </div>
                    <h3 style="padding: 10px" class="panel-title"><?php echo $_GET['response']==2?'Invalid details':$_GET['response']==1?'Your details have been submitted':''?></h3>
                </div>
            </div>
         
        </div>
  </div>
  <!-- /.row -->
 <hr>
<?php 
// bottom part of the page
include_once "include/footer.php";
// end here;
?>