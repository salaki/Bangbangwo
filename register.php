<?php
ob_start();
session_start();
include_once "include/config.php";
include 'include/classes/class.common.php';
$objCommon = new common();
$ip = $_SERVER['REMOTE_ADDR'];
$dt = date('Y-m-d');
$user_log = mysql_num_rows(mysql_query("SELECT * FROM pagerecord WHERE ip_address='".$ip."' and view_date='".$dt."'"));
if($user_log <=0)
{
	mysql_query("INSERT INTO pagerecord(ip_address,view_date) values('".$ip."','".$dt."')");
}
$style='style="top:54px;"';

$nameErr='';
if($_SERVER['REQUEST_METHOD'] == 'POST')
{

//    if(empty($_POST['registrationcode'])){
//      $nameErr="Please Enter Registration Code";
//       }
//     else if($_POST['registrationcode'] != 'LEBIU2015'){
//        $nameErr="Please Enter valid Registration Code";
//      }
//       else{ 
	extract($_POST);
	$verifyCode = rand(0,999999999);
	$ip = $_SERVER['REMOTE_ADDR'];
	$submit_dt = date('Y-m-d H:i:s');
	
	$record = mysql_num_rows(mysql_query("SELECT id FROM members WHERE email='".$email."'"));
	if($record == 0){
                $university=explode("@",$email);
                
                $getId=mysql_result(mysql_query("SELECT id FROM university_email WHERE email_university='".$university[1]."'"),0);
                if($getId<=0){
                    $array_university=array('email_university'=>$university[1]);
                    $getId=$objCommon->createQuery($array_university,'university_email');
                }
                $query = array('fname'=>$fname,'lname'=>$lname,'email'=>$email,'pwd'=>$password,'verify_code'=>$verifyCode,'submit_dt'=>$submit_dt,'ip_address'=>$ip,'university_id'=>$getId);
		$id = $objCommon->createQuery($query,'members');
                $_SESSION['confirm'] = 'A Confirmation E-Mail has been sent to your E-Mail Account';
                $to = $email;
                $from = 'info@bangbangwo.com';
                $body = "<table width='60%' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h2>Hi ".$fname." ".$lname."</h2><td></tr><tr><td></td></tr><tr><td>  Thanks for creating an account with Bangbangwo. Click below to confirm your email address:</td></tr><tr><td></td></tr><tr><td>http://".$_SERVER['SERVER_NAME']."/verify.php?uid=".base64_encode($id)."&verify=".base64_encode($verifyCode)."</td></tr><tr><td></td></tr><tr><td>If you have problems, please paste the above URL into your web browser.</td></tr></table>";
                $headers = "From: info@ubangbangwo.com\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

                mail($to, $subject, $body,$headers);
                $style='style="top:150px;"';
        }
        //}
	//header('location:register.php');




}
if(isset($_SESSION['confirm']))
{
	$msg = $_SESSION['confirm'];
	unset($_SESSION['confirm']);
}
function validation_new($data){
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
    <title>Register - Start Fill Details</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/1-col-portfolio.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    

    <!-- Page Content -->
    <div class="container">

        <!-- Project One -->
        <div class="row">
            <div class="col-md-12">
            <div class="col-md-10" id="part1" <?=$style?>>
			<div style="position:absolute;top:10px;right:10px;"><a href="index">Home</a> | <a href="signup">Back</a></div>
			<div class="frm1"><a href="http://index"><img src="images/logo.png"/></a></div>
			<?php 
				if(isset($msg)) echo '<div style="text-align:center;margin:20px 10px">'.$msg.'</div>';
				else
				{
				?>
				 <form action="" method="post" class="loginfrm" onsubmit="return validation_new('requester')">
				 <label class="lbl23">First Name</label><div class="err-msg" id="name-msg">Please Enter Your First Name</div><br/>
				 <input name="fname" type="text"  id="name" class="femalereg"><br/>
				 <label class="lbl23">Last Name</label><div class="err-msg" id="lname-msg">Please Enter Your Last Name</div><br/>
				 <input name="lname" type="text"  id="lname" class="femalereg"><br/>
				 <label class="lbl23">Email Address</label><div class="err-msg" id="email-msg">Please Enter Your Valid E-Mail Address</div><br/>
				 <input name="email" type="text"  id="email" class="femalereg" onblur="if($(this).val() != '') emailExists()"><br/>
			<!--<label class="lbl23">Your  Registration Code</label><div class="err-msg" id="registrationcode-msg">Please Enter a Valid  Registration Code</div><br/>
					 <input name="registrationcode" type="text"  id="registrationcode" class="femalereg"><br/>-->
                               <!--<label class="lbl23">Your  Registration Code</label><div class="err-msg" id="register-msg">Please Enter  Registration Code</div><br/>
                                         <input name="registrationcode" type="text"  id="register" class="femalereg"><br/>
                                           <span class="error" style="color:red;float:right;"> <?php echo $nameErr;?></span><br />-->

				  <label class="lbl23">Password</label><div class="err-msg" id="pass-msg">Please Enter Password</div><br/>
				 <input name="password" type="password"  id="pass" class="femalereg">
				 <label class="lbl23">Confirm Password</label><div class="err-msg" id="cpass-msg">Please Re-Enter Password</div><br/>
				 <input name="cpassword" type="password"  id="cpass" class="femalereg">
				 
				 <input name="submit" type="submit" value="Create An Account" class="btn1" >
				 </form>
				 <?php } ?>
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