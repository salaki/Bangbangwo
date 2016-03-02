<?php
include 'include/config.php';
class common
{
	function createQuery($array,$table)
	{
		$fields = "(";
		$values = "(";
		foreach($array as $k=>$v)
		{
			$k.=",";
			$fields .= $k;
			$values .= "'".$v."',";
		}
		$fields .= ")";
		$values .= ")";
		$fields = str_replace(',)',')',$fields);
		$values = str_replace(',)',')',$values);
		$query = mysql_query("INSERT INTO ".$table." ".$fields." values".$values) or die(mysql_error());
		return mysql_insert_id();
	}
	function verifyEmail($uid,$verifyCode)
	{
		$query = mysql_query("UPDATE members SET verify_email='1',status='1',verify_code='".$code."' WHERE id='".$uid."' AND verify_code='".$verifyCode."'") or die(mysql_error());
		if($query)
			return true;
		else 
			return false;
	}
	function login($email,$pass)
	{
		$validUser = mysql_num_rows(mysql_query("SELECT id FROM members WHERE email='".$email."' AND pwd='".$pass."' AND status='1'"));
		if($validUser > 0)
		{
			$userId = mysql_result(mysql_query("SELECT id FROM members WHERE email='".$email."' AND pwd='".$pass."' AND status='1'"),0);
			$_SESSION['userid'] = $userId;
			return true;
		}
		else
		{
			return false;
		}
	}
	function updateProfile($array)
	{
		$type = 0;
		if($array['linkedin'] != "")
		{
			$type = 1;
		}
		mysql_query("UPDATE members SET fname='".$array['fname']."',lname='".$array['lname']."',contact='".$array['contact']."',linkedin='".$array['linkedin']."',qual='".$array['qual']."',type='".$type."' WHERE id='".$_SESSION['userid']."'") or die(mysql_error());
	}
	function getUserDetail($uid)
	{
		$query = mysql_query("SELECT * FROM members WHERE id='".$_SESSION['userid']."'");
		$userDetail = mysql_fetch_assoc($query);
		return $userDetail;
	}
	
};




?>