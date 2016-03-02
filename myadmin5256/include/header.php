<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ubangbangwo</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	  
	<link rel="stylesheet" type="text/css" href="../css/jquery.timepicker.css" />

	<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script src="js/jquery-1.11.0.js"></script>
	<script src="js/admin.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
	<style type="text/css">
		input[type='submit'] {
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 6px 16px;
}
	</style>
  <?php
	if(isset($_POST['date']))
	{
			?>
			<script>
	$(document).ready(function(){
	var dt = "<?=$_POST['date'];?>";
	$(function(){
	$( "#datepicker" ).datepicker();
	$( "#datepicker" ).datepicker("option", "dateFormat", "yy-mm-dd");
	$( "#datepicker" ).datepicker("setDate", new Date(dt) );
	   
	//Pass the user selected date format 
  });
  
	});
	</script>
	<?php
	}
	else
	{
	?>
		<script>
	$(document).ready(function(){

	$(function(){
	$( "#datepicker,#datepicker1" ).datepicker();
	$( "#datepicker,#datepicker1" ).datepicker("option", "dateFormat", "yy-mm-dd");

	   
	//Pass the user selected date format 
  });
  
	});
	</script>
	<?php
	}
	?>
    <script>function pagingAjax(e, t, n) {
    //showTdiv();
    $.ajax({
        url: t,
        cache: false,
        success: function(e) {
          //  hideTdiv();
            $("#" + n).html(e);
            var body = $("html, body");
            var divTop = ($('#'+n).offset().top)-200;             
            body.animate({scrollTop:divTop}, '500', 'swing', function() { });
//            var t = document.createElement("div");
//            t.innerHTML = "_" + e + "_";
//            execJS(t)
        }
    });
}</script>
     <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56842292-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">UBANGBANGWO</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
               <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Admin <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                         <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="javascript:void(0)"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-desktop"></i> Management <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="allusers.php">User Account</a>
                            </li>
                            <li>
                                <a href="allposts.php">Posts</a>
                            </li>
                        </ul>
                    </li>
					<li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="fa fa-fw fa-bar-chart-o"></i> Analysis <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo1" class="collapse">
                            <li>
                                <a href="currentregister.php">Total Register Users</a>
                            </li>
                            <li>
                                <a href="currentactive.php">Total Active Users</a>
                            </li>
							<li>
                                <a href="pageview.php">Repeat users</a>
                            </li>
							<li>
                                <a href="transport.php">Transportation</a>
                            </li>
							<li>
                                <a href="moving.php">Moving Help</a>
                            </li>
							<li>
                                <a href="handyman.php">Handy Man</a>
                            </li>
							<li>
                                <a href="tutoring.php">Tutoring</a>
                            </li>		
							<li>
                                <a href="general.php">General</a>
                            </li>							
                        </ul>
                    </li>
                    
                    <!-- Stripe Management  --->
                    
                     <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#stripe">
                        <i class="fa fa-fw fa-desktop"></i> Stripe Management <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="stripe" class="collapse">
                            <li>
                                <a href="stripe.php">Configuration</a>
                            </li>
                            <li>
                                <a href="cancelpayment.php">Cancel Payment</a>
                            </li>
                            
                            <li>
                                <a href="servicefee.php">Service fee Transfer Details</a>
                            </li>
                            
                             <li>
                                <a href="transaction.php">Transaction Details</a>
                            </li>
                        </ul>
                    </li>
                    
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
