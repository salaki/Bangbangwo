<?php
include_once "include/config.php";
include 'include/classes/class.common.php';
session_start();
$objCommon = new common();
$ip = $_SERVER['REMOTE_ADDR'];
$dt = date('Y-m-d');
//user is being login here

$user_log = mysql_num_rows(mysql_query("SELECT * FROM pagerecord WHERE ip_address='".$ip."' and view_date='".$dt."'"));
if($user_log <=0)
{
	mysql_query("INSERT INTO pagerecord(ip_address,view_date) values('".$ip."','".$dt."')");
}
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	extract($_POST);
	if($objCommon->login($email,$password))
	{
		$user_detail = mysql_fetch_array(mysql_query("SELECT type,university_id FROM members WHERE id='".$_SESSION['userid']."'"));
                $_SESSION['university']=$user_detail['university_id'];
		//if($type == 0)
		{
			header('location:dashboard');
		}
		/*else
		{
			header('location:dashboard_tasker');
		}*/
		
	}
	else
	{
		$msg = "Invalid User Name or Password";
		$style = "border-color:red;";
	}
}

// end here
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<link rel="icon" type="image/png"  href="/images/favicon.png" />
    <title>bangbangwo - Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/1-col-portfolio.css" rel="stylesheet">
<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .lbl{
            margin: 0px;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    

    <!-- Page Content -->
    <div class="container">

        <!-- Project One -->
        <div class="row">
            <div class="col-md-12">
            <div class="col-md-10" id="part1">
			<div style="position:absolute;top:10px;right:10px;"><a href="index" id="login-link">Home</a><a href="javascript:void(0)" style="display:none;" id="back-link" onclick="$('#loginfrm, #login-link').show();$('#frgtPass, #back-link').hide();">Back</a></div>
            <div class="frm1"><a href="index"><img src="images/logo.png"/></a></div>
             <form action="" method="POST" class="loginfrm" id="loginfrm">
             <label class="lbl">Your Email</label><div class="err-msg err-msg-new" id="email-msg" style="32px 10px 0px">Please Enter E-Mail Address</div><br/>
             <input name="email" type="text"  id="email" class="female" style="<?=$style?>"><br/>
              <?php if(isset($msg)) echo '<div class="login-error" style="text-align:center;color:red;">Invalid user Name or password</div><br/>';?>
              <label class="lbl">Password</label><div class="err-msg err-msg-new" id="pass-msg" style="32px 10px 0px">Please Enter Password</div><br/>
             <input name="password" type="password"  id="pass" class="female" style="<?=$style?>">
             <div class="col-md-12" style="  margin-left: 0;padding-left: 0;">
             <div class="col-md-4" id="rem"><input name="Remember" type="checkbox" value="Remember"> Remember Me</div>
              <div class="col-md-8" id="frgt"><a href="javascript:void(0)"  onclick="$('#loginfrm, #login-link').hide();$('#frgtPass, #back-link').show();">Forget Your Password ?</a></div>
             </div>
             <input name="submit" type="submit" value="Sign In" class="btn1" >
             </form>
			 <div action="" method="POST" class="loginfrm" id="frgtPass" style="display:none">
				<label class="lbl">Your Email</label><div class="err-msg err-msg-new" id="email-msg1" style="32px 10px 0px">Please Enter E-Mail Address</div><br/>
				<input name="email" type="text"  id="email1" class="female" style="<?=$style?>"><br/>
				<input name="submit" type="button" value="Send E-Mail" class="btn1" onclick="return frgtpass()">
             </div>
			 <div action="" method="POST" class="loginfrm" id="confrmMsg" style="display:none">
				<div style="text-align:center;margin:20px 10px;font-size:16px;line-height:35px;">Your login credential sent to your e-mail...<br>
				<a href="login.php">click here to login</a></div>
             </div>
			
               </div>
            </div>
            
        </div>
        <!-- /.row -->

      
        <!-- Footer -->
        

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
