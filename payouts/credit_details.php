<html>
    <head>
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    </head>
   <body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info">
                    <p>Do not provide real credit card or bank account details into these forms. Instead use <a href="https://docs.balancedpayments.com/current/overview.html#test-credit-card-numbers" class="alert-link" target="_blank">test cards</a> and <a href="https://docs.balancedpayments.com/current/overview.html#test-bank-account-numbers" class="alert-link" target="_blank">bank accounts</a>.</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tokenize Credit Card</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="example.php" class="form-horizontal">
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
                            <div class="form-group">
                                <label class="col-lg-5 control-label">Amount</label>
                                <div class="col-lg-2">
                                    <input type="text" id="amount" name="amount" class="form-control" autocomplete="off" placeholder="123" maxlength="4" />
                                </div>
                            </div> 
                            <input name="Submit" type="submit" value="Tokenize" class="btn btn-large btn-primary pull-right"/>

                        </form>
                    </div>
                </div>
            </div>
         
        </div>
         <h3 class="panel-title"><?php echo $_GET['response']==2?'Invalid details':''?></h3>
    </div>

   
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    
  </body>

</html>


