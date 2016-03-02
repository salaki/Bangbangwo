<?php
// home page of the website

session_start();
include_once 'include/config.php';
$ip = $_SERVER['REMOTE_ADDR'];
$dt = date('Y-m-d');
$user_log = mysql_num_rows(mysql_query("SELECT * FROM pagerecord WHERE ip_address='".$ip."' and view_date='".$dt."'"));
if($user_log <=0)
{
	mysql_query("INSERT INTO pagerecord(ip_address,view_date) values('".$ip."','".$dt."')");
}

// top part of the page
if(isset($_SESSION['userid']) && $_SESSION['userid'] != '')
{
	 /*$type = mysql_result(mysql_query("SELECT type FROM members WHERE id='".$_SESSION['userid']."'"),0);
	if($type == 0)
	{
		$link = '<li><a href="dashboard">Dashboard</a></li><li  style="border-right:none;"><a href="logout.php">Log Out</a></li>';
	}
	else
	{
		$link = '<li><a href="dashboard_tasker">Dashboard</a></li><li  style="border-right:none;"><a href="logout.php">Log Out</a></li>';
	}*/
	$link = '<li><a href="dashboard">Dashboard</a></li><li  style="border-right:none;"><a href="logout.php">Log Out</a></li>';
}
else
{
	$link = ' <li><a href="signup">Sign up</a></li><li style="border-right:none;"><a href="login.php">Login</a></li>';
}
// ends top part
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

          <style>
.button {
	padding: 5px 15px !important;
	background: none repeat scroll 0 0 #fff;
	border-radius: 5px;
	color: #2980b9;
	position: unset !important;
	margin: 0 !important;
	font-family: "Open Sans", sans-serif;
}
.button:hover {
	text-decoration: none !important;
}
</style>
          <!-- Latest compiled and minified CSS -->
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

          <!-- Optional theme -->
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
          <link href="style.css" rel="stylesheet" type="text/css"/>
          <link rel="icon" 
      type="image/png" 
      href="/images/favicon.png" />
</head>
<body>

<div class="wrapper">
	<header>
		<div class="container">
        	<div class="col-xs-5" id="logo"> <img class="col-sm-7" src="images/logo.png" style="width:90%"> Beta </div>
            <div class="col-xl-7" id="navigation">
                <ul style="font-family: Adelle_Regular,sans-serif;" class="menu1">
                  <li><a href="#hw_works">How it Works</a></li>
                  <?=$link;?>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
	</header>


	<section>

        <div class="container">
          <div class="main text-center"> <span class="txt_darkgrey"></span><span class="txt">One Community</span>
            <p class="txt_slogan">You are a college student who needs help? Others in your university are ready to offer. </p>
          </div>
          
          
          <!--  <div style="text-align:center">
        <iframe width="650" height="400" src="//www.youtube.com/embed/5svDggd8B4I" frameborder="0" allowfullscreen></iframe>
        
        </div>--> 
        </div>
        
    </section>
    
    <section class="blue-bar">
    	
        <div class="container">
    <div class="main">
    
    	<div class="col-lg-3">
    
          <div class="box">
            <div class="circle1"></div>
            <div class="texto11">
              <h4>Transportation</h4>
              <p style="height:85px">Need a ride to home, or a pickup from airport, or a food delivery from your favorite restaurant? Never be this easy and safe.</p>
              <p ><a class="button" href="add_newtask">Start</a></p>
            </div>
            <!--<div class="button1"><a href="#">Read More</a></div>--> 
          </div>
      </div>
      <div class="col-lg-3">
          <div class="box">
            <div class="circle1" style="background:url(images/ic1234.png) no-repeat;"></div>
            <div class="texto11">
              <h4>Moving</h4>
              <p style="height:85px">Need an Uhaul driver and labor for moving? You get them all with one simple step. </p>
              <p ><a class="button"  href="add_newtask?movinghelp">Start</a> </p>
            </div>
            <!--<div class="button1"><a href="#">Read More</a></div>--> 
          </div>
      </div>
      
      <div class="col-lg-3">
          <div class="box">
            <div class="circle1" style="background:url(images/ic22.png) no-repeat;"></div>
            <div class="texto11">
              <h4>Tutoring</h4>
              <p style="height:85px">Having difficulties with your homework or want to learn something cool? An experienced peer tutor would like to help.</p>
              <p><a class="button"  href="add_newtask?tutoring">Start</a> </p>
            </div>
            <!--<div class="button1"><a href="#">Read More</a></div>--> 
          </div>
      </div>
      
      <div class="col-lg-3">
          <div class="box">
            <div class="circle1" style="background:url(images/ic33.png) no-repeat;"></div>
            <div class="texto11">
              <h4>Handy man</h4>
              <p style="height:85px">Need hands for assembling your Ikea furniture or repairing your laptop? Your help is not far!</p>
              <p ><a class="button" href="add_newtask?handyman">Start</a></p>
            </div>
            <!--<div class="button1"><a href="#">Read More</a></div>--> 
          </div>
      </div>
    </div>
  </div>
    
    
    </section>

	<section>
    	<div class="container">
          <div id="hw_works" class="txt_darkgrey"> How Bangbangwo Works</div>
          <div class="img-box">
            <div class="col-lg-4 lft1">
              <h1>Post a Task</h1>
            </div>
            <div class="col-lg-8 rgt1">Our designated task templates will help you create your task request quickly.</div>
          </div>
          <div class="img-box" style=" background:url(images/2.jpg) repeat-y;">
            <div class="col-lg-4 lft1">
              <h1>Bid</h1>
            </div>
            <div class="col-lg-8 rgt1">Only students in your university can view your post and bid on your task. </div>
          </div>
          <div class="img-box" style=" background:url(images/bluesh.png) repeat-y;">
            <div class="col-lg-4 lft1">
              <h1>Make decision</h1>
            </div>
            <div class="col-lg-8 rgt1">Check out the self intro, previous rating, and messages of your peers who bid and pick up the one who is the best fit.</div>
          </div>
          <div class="img-box" style="background:url(images/yellow.png) repeat-y;">
            <div class="col-lg-4 lft1">
              <h1>Pay and Rate</h1>
            </div>
            <div class="col-lg-8 rgt1">When task is done, get your tasker paid and rate the work to let others know.</div>
          </div>
        </div>
    
    </section>


<div class="footer">
  <div class="container">
    <div class="col-lg-6 ftlft">
      <ul>
        <li><a href="/aboutus">About Us</a></li>
        <li><a href="/feedback">Feedback</a></li>
        <!--<li><a href="#">Blog</a></li>-->
        <li><a href="/terms">Terms & Privacy</a></li>
      </ul>
    </div>
    <div class="col-lg-6 ftrgt45">
      <ul>
        <!--<li>Follow us! We're Friendly</li>
     <li><a href="#"><img src="images/scinvs45.png" style="margin:-13px 0 0 0;"/></a></li>-->
        
      </ul>
    </div>
  </div>
</div>
</body>
</html>