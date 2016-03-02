<?php
include_once "include/config.php"; 
$ip = $_SERVER['SERVER_ADDR']; // the IP address to query
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if($query && $query['status'] == 'success') {
 // echo 'Hello visitor from '.$query['country'].', '.$query['city'].'!';
        date_default_timezone_set($query['country']); // CDT
        $currentdate = date('Y-m-d H:i');
        $curtime= date('H:i:s A', time());
          //$dateInTwoWeeks = date("Y-m-d H:i",strtotime("-5 hours"));
        
       
        //$dateInTwoWeeks = date("Y-m-d H:i",strtotime("-2 weeks"));
        $dateInTwoWeeks = date("Y-m-d H:i",strtotime("-20160 minutes"));
        $secretkey = mysql_query("select * from stripecredentials where id ='1'");
        $sresult = mysql_fetch_array($secretkey);
        $query = mysql_query("SELECT * FROM tasks WHERE id NOT IN (SELECT task_id FROM bids) AND DATE_FORMAT(added_date,'%Y-%m-%d %H:%i')='$dateInTwoWeeks'  ORDER BY  `id` DESC");
        
       
        while($data = mysql_fetch_array($query)){
                 
                        $datacc  = mysql_query("select * from tasks where id='".$data['id']."'");
			$recdata = mysql_fetch_array($datacc);
			$dataagain  = mysql_query("select * from members where id='".$recdata['userid']."'");
			$recagain = mysql_fetch_array($dataagain);
                        $to =$recagain['email'];  // send mail to requester
                       
                       // $to ='sandeep.shinedezign@gmail.com';
                                            
                        $subject = "Your request ". $data['taskname']." is deleted";
                        $body="<table cellpadding='5px' width='600px' height='300px' style='border:1px solid #00aeec' align='center'><tr><td height='30px;' bgcolor='#fff' style='border-bottom:1px solid #00aeec'> &nbsp; <img src='http://ubangbangwo.com/images/logo.png' height='50'></td></tr><tr><td><h1>Dear ".$recagain['fname']." ".$recagain['lname'].",</h1><td></tr><tr><td>Sorry, Your request ". $data['taskname']." ".$curtime." is deleted by system. </td></tr><tr><td>&nbsp;</td></tr><tr><td>Reason- No bid on it for two weeks.</td></tr><tr><td>&nbsp;</td></tr><tr><td>Thanks</td></tr><tr><td>Your BangBangWo Team</td></tr></table>";
                        
                        
                        //$headers  = 'MIME-Version: 1.0' . "\r\n";
                        //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        
                        $headers  = 'From: bangbangwo@box1042.bluehost.com.' . "\r\n" ;
                        $headers .= 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        
                        mail($to,$subject,$body,$headers);
                          
                          
                           //changes : 20-08
                           
                         /*$bidmultipledata = mysql_query("select * from bids where task_id='".$data['id']."'");
			   if(mysql_num_rows($bidmultipledata)>0)
			   { 
                            mail($to,$subject,$body,$headers);
        		   }  */
        		               
                        mysql_query("Delete from tasks where id='".$data['id']."'");
                        mysql_query("Delete from bids where task_id='".$data['id']."'");
                        echo 'deleted';
                 
                 
                       
                 
        }
} else {
  echo 'Unable to get location';
}
?>
