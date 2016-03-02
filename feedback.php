<?php
session_start();
include_once 'include/config.php';

// feedback page upper part
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

// feedback upper part ends here


//feed back mails here to the admin
if($_SERVER['REQUEST_METHOD']=='POST' && $_POST['email']!=='' && $_POST["title"]!='' && $_POST['msg']!=''){
    $body='<strong>Email:</strong> '.$_POST['email']."<br/> <strong>Title:</strong> ".$_POST["title"]."<br/> <strong>Message:</strong> ".$_POST['msg'];
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    mail('salaki.zz@gmail.com','FEEDBACK',$body,$headers);
    $message="Thanks for your giving your feedback";
}

// mail ends here
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
  
   <!-- Latest compiled and minified CSS -->
   <link rel="icon" 
      type="image/png" 
      href="/images/favicon.png" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<style>
    input{
        width:500px;
        border:1px solid #ccc;
        padding-left:5px;
        height:40px;
    }
    textarea{
         width:500px;
        border:1px solid #ccc;
        padding-left:5px;
        height:80px;
    }
    </style>
    <script>
        function feedback(){
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            
            var title=document.getElementById('title').value;
            var email=document.getElementById('email').value;
            var msg=document.getElementById('msg').value;
            if(title=='' || email=='' || msg==''){
                alert('All the fields are mandatory');
                return false;
            }else if(re.test(email)!=true){
                alert('Email is not valid');
                return false;
            }
        }
        </script>
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

 <link href="style.css" rel="stylesheet" type="text/css"/>
 <title>Feedback</title>
 </head>
  <body>
      <div style="min-height:600px" class="wrapper">
  
      
  
  <header style="background:none; height:auto;">
		<div class="container">
        	<div class="col-xs-5" id="logo"><a href="/"><img class="col-sm-7" src="images/logo.png" style="width:90%; padding:0;"> </a> Beta</div>
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
     <div style="font-size:18px"><?php echo $message; ?></div>
     <div class="col-lg-12" >
                    <form  action="" method="post" class="loginfrm" onsubmit="return feedback()">
                    
                    <h1 class="text-left" style="color: #2980b9;font-family: arial;font-weight: bold; margin-bottom:35px">Feedback</h1>
                   
                   <div style="font-size: 17px;" class="col-lg-7"> 
                    <div class="col-lg-3 text-left">Title</div>
                    <div class="col-lg-8"><input type="text" name="title" id="title" class="femalereg"></div>
                    
                    <div class="col-lg-3 text-left">E-Mail</div>
                    <div class="col-lg-8 "><input type="text" name="email" id="email" class="femalereg"></div>
                    
                    <div class="col-lg-3 text-left">Message</div>
                    <div class="col-lg-8"><textarea name="msg" id="msg" class="femalereg"></textarea></div>
                    
                    <div class="col-lg-3"></div>
                    <div class="col-lg-8"><input style="padding: 5px 15px;background: none repeat scroll 0 0 #2980b9; border-radius: 5px;color: #fff;width:auto;" type="Submit" class="btn1" value="Submit"/></div>
                    
                 </div>   
                        <?php /*?><table style="width:100%;font-size: 15px;font-size:17px;" cellspacing="10" cellpadding="10" >
                            <tr>
                                <th align="left" colspan="2"><h1 style="color: #2980b9;font-family: arial;font-weight: bold;">Feedback</h1></th>
                            </tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td width="35%" align="left" >Title</td>
			<td align="left"><input type="text" name="title" id="title" class="femalereg"></td>
		  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left">E-Mail</td>
			<td align="left"><input type="text" name="email" id="email" class="femalereg"></td>
		  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td valign="top" align="left">Message</td>
			<td  align="left">
                            <textarea name="msg" id="msg" class="femalereg"></textarea>
                        </td>
		  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                   
                        <td colspan="2"><input style="padding: 5px 15px;background: none repeat scroll 0 0 #2980b9; border-radius: 5px;color: #fff;width:auto;" type="Submit" class="btn1" value="Submit"/></td>
                    </tr>
	  
	</table><?php */?>	 </form>
     </div>
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
        
    
    </div>


</div>
  </div>
</body>
	</html>