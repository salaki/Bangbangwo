<?php
session_start();
include_once 'include/config.php';
if(isset($_SESSION['userid']) && $_SESSION['userid'] != '')
{
	 $type = mysql_result(mysql_query("SELECT type FROM members WHERE id='".$_SESSION['userid']."'"),0);
	if($type == 0)
	{
		$link = '<li><a href="dashboard.php">Dashboard</a></li><li  style="border-right:none;"><a href="logout.php">Log Out</a></li>';
	}
	else
	{
		$link = '<li><a href="dashboard_tasker.php">Dashboard</a></li><li  style="border-right:none;"><a href="logout.php">Log Out</a></li>';
	}
	
}
else
{
	$link = ' <li><a href="signup.php">Sign up</a></li><li style="border-right:none;"><a href="login.php">Login</a></li>';
}
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
      <link rel="icon" type="image/png"  href="/images/favicon.png" />
   <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

 <link href="style.css" rel="stylesheet" type="text/css"/>
 </head>
  <body>
  <div class="wrapper">
  <header>
		<div class="container">
        	<div class="col-xs-5" id="logo"><img class="col-sm-7" src="images/logo.png" style="width:90%"></div>
            <div class="col-xl-7" id="navigation">
                <ul style="font-family: Adelle_Regular,sans-serif;" class="menu1">
                  <li><a href="/">How it Works</a></li>
                  <?=$link;?>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
	</header>
    
    
    
   
  
    
	
	
  <section>
  
  <div class="container">
  
 <div class="main text-center">
                    <span class="txt_darkgrey"></span><span class="txt">About Us</span>
                    <ul  style="list-style:none;font-size:21px; margin:0px; padding:0px;">
                        <li>Better Learning: Teaching and Being Taught. </li>
						<li>Better Living: Help and Being Helped.</li>
						<li>Better Connecting: Making friends by doing.</li>
						<li>Bangbangwo makes your university time better.</li>
                    </ul>
                </div>

  
  
     </div>
     
     </section>
     
     
	<div class="footer">
    <div class="container">
    <div class="ftlft">
    <ul>
     <li><a href="aboutus">About Us</a></li>
     <li><a href="feedback">Feedback</a></li>
      <!--<li><a href="blog">Blog</a></li>-->
       <li><a href="terms">Terms & Privacy</a></li>
    </ul>
    </div>
        <div class="ftrgt45">
    <ul>
    
      
    </ul>
    </div>
    
    </div>


</div>

</body>
	</html>