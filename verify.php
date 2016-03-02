<?php
// email verification code after registration. redirection according to the conditions.

ob_start();
session_start();
include 'include/config.php';
include 'include/classes/class.common.php';
$objCommon = new common();
$code = base64_decode($_GET['verify']);
$uid = base64_decode($_GET['uid']);
if($objCommon->verifyEmail($uid,$code))
{
	$_SESSION['userid'] = $uid;
       
	$user_detail = mysql_fetch_array(mysql_query("SELECT type,university_id FROM members WHERE id='".$_SESSION['userid']."'"));
        $_SESSION['university']=$user_detail['university_id'];
	if($user_detail['type'] == 0)
	{
		header('location:dashboard');
	}
	else
	{
		header('location:dashboard_tasker');
	}
}
else
	header('location:http://www.ubangbangwo.com');
?>