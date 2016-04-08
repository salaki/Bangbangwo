<?php
// this is most important class , contains maximum numbers of common functions

class common
{
    
        // common function for data insertion
        /* Parameter: 2  data Array and table name
         
         * 
         * 
         */
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
        // email verification update in database
        // parameter 2,   user id and verification code
	function verifyEmail($uid,$verifyCode)
	{
		$code = rand(0,9999999999);
                
                $get_id=mysql_num_rows(mysql_query("SELECT * FROM members WHERE id='".$uid."' AND verify_code='".$verifyCode."'"));
                if($get_id>0){
		$query = mysql_query("UPDATE members SET verify_email='1',status='1',verify_code='".$code."' WHERE id='".$uid."' AND verify_code='".$verifyCode."'") or die(mysql_error());
		
			return true;
                }
		else 
			return false;
	}
        
        // login function , return details are true or false        
        // parameter 2   email and password
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
        
       
        
        // profile update after edit
        // parameter 1   data array
	function updateProfile($array)
	{
		$type = 0;
		if($array['linkedin'] != "")
		{
			$type = 1;
		}
		if(array_key_exists('image',$array))
		{
			mysql_query("UPDATE members SET otheremail='".$array['otheremail']."',contact='".$array['contact']."',linkedin='".$array['linkedin']."',qual='".$array['qual']."',type='".$type."',image='".$array['image']."',about_me='".$array['about_me']."',gender='".$array['gender']."',major='".$array['major']."',degree='".$array['degree']."',matriculation='".$array['matriculation']."' WHERE id='".$_SESSION['userid']."'") or die(mysql_error());
		}
		else
		{
			mysql_query("UPDATE members SET otheremail='".$array['otheremail']."',contact='".$array['contact']."',linkedin='".$array['linkedin']."',qual='".$array['qual']."',type='".$type."',about_me='".$array['about_me']."' ,gender='".$array['gender']."',major='".$array['major']."',degree='".$array['degree']."',matriculation='".$array['matriculation']."' WHERE id='".$_SESSION['userid']."'") or die(mysql_error());
		}
	}
        
        // user details
        // parameter: 1   user id
	function getUserDetail($uid)
	{
		$query = mysql_query("SELECT * FROM members WHERE id='".$_SESSION['userid']."'");
		$userDetail = mysql_fetch_assoc($query);
		return $userDetail;
	}
	
};




?>