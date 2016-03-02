<?php
ob_start();
session_start();

// common file for the site, all the upper part's code in this file. This is included on every page
include_once 'include/config.php';
include_once 'include/classes/class.common.php';
$objCommon = new common();
$ip = $_SERVER['REMOTE_ADDR'];
$dt = date('Y-m-d');
$user_log = mysql_num_rows(mysql_query("SELECT * FROM pagerecord WHERE ip_address='".$ip."' and view_date='".$dt."'"));
if($user_log <=0)
{
	mysql_query("INSERT INTO pagerecord(ip_address,view_date) values('".$ip."','".$dt."')");
}
if(!$_SESSION['userid'])
{
	if(strstr($_SERVER['REQUEST_URI'],'add_newtask'))
	{
		header('location:http://'.$_SERVER['SERVER_NAME'].'/signup');
	}
	else
	{

	header('location:http://'.$_SERVER['SERVER_NAME'].'/login');
	}
}

if(strstr($_SERVER['REQUEST_URI'],'dashboard_tasker') || strstr($_SERVER['REQUEST_URI'],'mybids'))
{
	$dashboard_tasker = 'class="active"';
}
else if(strstr($_SERVER['REQUEST_URI'],'/dashboard') || strstr($_SERVER['REQUEST_URI'],'add_newtask') || strstr($_SERVER['REQUEST_URI'],'edit_task'))
{
	$dashboard = 'class="active"';
	if(!strstr($_SERVER['REQUEST_URI'],'add_newtask'))
	$addTask = '<div id="pst" class="col-xs-6 text-right"><a href="add_newtask">Post A Request</a></div>';
}elseif(strstr($_SERVER['REQUEST_URI'],'card_detail.php'))
{
	$credit_card = 'class="active"';
}

if(strstr($_SERVER['REQUEST_URI'],'profile'))
{
	$profile = 'class="active"';
	$addTask = '<div class="col-xs-6 text-right" id="pst"><a href="add_newtask">Post A Request</a></div>';
}
if(strstr($_SERVER['REQUEST_URI'],'profile-edit'))
{
	$addTask = '<div class="col-xs-6 text-right" id="pst"><a href="add_newtask">Find new Task</a></div>';
}

$userDetail = $objCommon->getUserDetail($_SESSION['userid']);
$userName = $userDetail['fname'];
$image = $userDetail['image'];
	$image = $image == ''? 'upload/noprofile.jpg':'upload/'.$image;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Welcome to - Dashboard</title>

<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="css/1-col-portfolio.css" rel="stylesheet">
<script src="js/common.js?_<?php echo time(); ?>"></script>
<link rel="icon" 
      type="image/png" 
      href="/images/favicon.png" />
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="cback">
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <a href="/"><img src="images/logo1.png"/> </a> Beta </div>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="wel">
      <ul>
        <li style="padding:none;"><img src="<?=$image;?>" align="middle" class="img"> Hello <?=$userName;?> <img src="images/arrow.png"></li>
        <li style="background:none;padding:10px;"><a href="logout">Logout</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container --> 
</nav>
<!-- Page Content -->
<div class="container container-height"> 
  
  <!-- Page Heading -->
  <div class="row">
    <div class="col-xs-6">
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li> <a href="dashboard" <?=$dashboard;?>>Requester</a> </li>
          <li> <a href="dashboard_tasker" <?=$dashboard_tasker;?>>Tasker</a> </li>
          <li> <a href="profile" <?=$profile;?>>Account</a> </li>
          <!--<li> <a href="card_detail.php" <?=$credit_card;?>>Add your Card </a> </li> -->
          
        </ul>
      </div>
    </div>
    <?=$addTask;?>
  </div>
