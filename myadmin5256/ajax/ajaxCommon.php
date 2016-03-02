<?php
include_once "../include/config.php";

// if user suspended by admin
if(isset($_GET['action']) && $_GET['action'] == 'suspend')
{
	$dt = date('Y-m-d',strtotime("+3 days"));
	mysql_query("UPDATE members SET status='2',suspend_date='".$dt."' WHERE id='".$_GET['id']."'");
	die();
}
//if users is activated by admin
if(isset($_GET['action']) && $_GET['action'] == 'active')
{
	$dt = '0000-00-00';
	mysql_query("UPDATE members SET status='1',suspend_date='".$dt."' WHERE id='".$_GET['id']."'");
	die();
}

// if user is banned by admin
if(isset($_GET['action']) && $_GET['action'] == 'ban')
{
	mysql_query("UPDATE members SET status='3' WHERE id='".$_GET['id']."'");
	die();
}

// if any task is deleted by admin
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{
	mysql_query("UPDATE tasks SET status='3' WHERE id='".$_GET['id']."'");
	die();
}

// account deleted by admin, all the history will be deleted related to the account
if(isset($_GET['action']) && $_GET['action'] == 'deleteAccount')
{
	mysql_query("DELETE FROM members WHERE id='".$_GET['id']."'");
	mysql_query("DELETE FROM satisfiedstatus WHERE tasker_id='".$_GET['id']."'");
	mysql_query("DELETE FROM tasks WHERE userid='".$_GET['id']."'");
	mysql_query("DELETE FROM bids WHERE tasker_id='".$_GET['id']."'");
	die();
}

?>