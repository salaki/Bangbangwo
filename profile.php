<?php
        // top part of page
	include_once "include/header.php";        
        // end top part
        
        
	include_once "include/classes/class.paging.php";
        $Paging=new Paging();
        
        // getting user details dynamicaly who is logged in
	$name = $userDetail['fname']." ".$userDetail['lname'];
	$email = $userDetail['email'];
	$type = $userDetail['type'];
	$mobile = $userDetail['contact'];
	$linkedin = $userDetail['linkedin'];
	$image = $userDetail['image'];
	$image = $image == ''? 'upload/noprofile.jpg':'upload/'.$image;
	$likes = $userDetail['likes'];
	$dislikes = $userDetail['dislikes'];
	$oemail = $userDetail['otheremail'];
        $aboutme=$userDetail['about_me'];
        
        $getUniversity=mysql_result(mysql_query("SELECT university FROM university_email WHERE id=".$_SESSION['university']." LIMIT 1"),0);
        
        //End
?>
	<!-- /.row --> 
    <!-- Project One -->
   <!-- front part -->
  <div class="row" id="con1">
    <div class="col-md-12">
      
  
  <!-- /.row -->
  <hr>
  <div class="row" id="con1" style="margin:0;">
    <div class="col-md-12" id="v11">
    
    <div class="col-lg-4"><h3 style="color:#2980B9; margin:0 0 0 10px;">My Account</h3></div>
    <div class="col-lg-8">
     <a href="profile-edit"><img src="images/edit.png" class="edtu"/></a>
	 <!--<a href="javascript:void(0)" style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 17px;padding: 10px 17px;text-decoration: none;" onclick="warning();">Delete Account</a> -->
	
	
	<?php
	//if(isset($_GET['details']))
	//{
	?>
	<a href="connect.php" style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 17px;padding: 10px 17px;text-decoration: none;">My Credit Card</a>
         <a href="bankacc.php" style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 17px;padding: 10px 17px;text-decoration: none;">My Bank Account</a>
	<?php
	/*
	}
	else
	{
	?>
	<a href="profile.php?details" style="background: none repeat scroll 0 0 #2980b9;border-radius: 5px;color: #fff;float: right;margin: 17px;padding: 10px 17px;text-decoration: none;">Connect to Stripe</a>
	<?php
	} */
	?>
	 </div>
      
     <div class="col-md-12" id="v111" style="padding:15px;float:left;">
     <div class="profile-img col-lg-4"><img src="<?=$image;?>" width="230" height="230"></div>
	 <div class="col-lg-8">
     <ul class="proicns">
     <li style=" background:url(images/people.png) no-repeat left; height: 24px;line-height: 30px;  padding: 0 0 0 38px;text-align: left;"><h3><?=$name;?> &nbsp;<span class="dll"><?=$likes;?></span> &nbsp;<span class="dll_dark"><?=$dislikes;?></span></h3></li>
      <li style=" background:url(images/emli.png) no-repeat left; height: 24px;line-height: 30px;  padding: 0 0 0 38px;text-align: left;"><span><b><?=$email;?></b></span></li>
      <?php
	  if($oemail != '')
	  {
		echo '<li style=" background:url(images/emli.png) no-repeat left; height: 24px;line-height: 30px;  padding: 0 0 0 38px;text-align: left;"><span>'.$oemail.'</span></li>';
	  }
	  if($mobile != '')
	  {
	  echo '<li style=" background:url(images/phni.png) no-repeat left; height: 24px;line-height: 30px;  padding: 0 0 0 38px;text-align: left;"><span>'.$mobile.'</span></li>';
          }
          if($linkedin!=''){ ?>
                <li style=" background:url(images/link.png) no-repeat left; min-height: 24px;line-height: 30px;  padding: 0 0 0 38px;text-align: left;wordwrap:break-word;"><span><?=$linkedin;?></span></li>
          <?php } ?>
      <li style=" background:url(images/unmi.png) no-repeat left; height: 24px;line-height: 30px;  padding: 0 0 0 38px;text-align: left;"><span><b><?=$getUniversity?>
</b></span></li>

<?php 
if($aboutme!=''){ ?>
<li style=" height:auto;line-height: 30px;  padding: 0 0 0 38px;text-align: left;"><div><b>About Me</b></div><span>
            <?=$aboutme?></span></li>
     
<?php }  ?>
     </ul>
	 </div>
     <div class="clearfix"></div>
     </div>
     <div class="clearfix"></div>
     </div>
  </div>
   <h4 class="hdg">My Earnings:</h4>
   <div style="clear:both">&nbsp;</div>
  <?php
  // earning Details from the starting
	$html = '';
       
       
//	$getTopListQry = mysql_query("SELECT DATE_FORMAT(b.taskdate, '%d-%M-%Y') DATEONLY, DATE_FORMAT(b.taskdate,'%h:%I %p') TIMEONLY,a.task_id,b.refund,b.taskname,b.taskfrom,b.taskto,b.tasktype,b.tasklocation,b.taskdescription,b.taskduration,a.firstamnt,a.message,a.status,people,b.other FROM bids as a LEFT JOIN tasks as b ON a.task_id = b.id WHERE tasker_id='".$_SESSION['userid']."' order by a.id desc");
//        
//        echo "SELECT DATE_FORMAT(b.taskdate, '%d-%M-%Y') DATEONLY, DATE_FORMAT(b.taskdate,'%h:%I %p') TIMEONLY,a.task_id,b.refund,b.taskname,b.taskfrom,b.taskto,b.tasktype,b.tasklocation,b.taskdescription,b.taskduration,a.firstamnt,a.message,a.status,people,b.other FROM bids as a LEFT JOIN tasks as b ON a.task_id = b.id WHERE tasker_id='".$_SESSION['userid']."' order by a.id desc";
	/*$PageNo = isset($_GET['page']) ? $_GET['page'] : 1;
	$file=  rtrim($_SERVER[REQUEST_URI],"/".$PageNo);
	$type=$_GET['type'];
	$pagingStr='&tagName='.$_GET['tagName'];
	/*if(!isset($_SESSION['userid']) || $_SESSION['userid']==""){
		$objForum->objPaging->chkPageNo($PageNo, $getTopListQry, 5, 5,$file, "", "STATIC_PAGING");
	}else{
	$Paging->chkPageNo($PageNo, $getTopListQry, 8, 5,"ajax/earnings.php?page", "", "showTopId");

	$getRecentQry = $Paging->showRecord($getTopListQry);*/
        
    
        
        $getTopListQry=mysql_query("SELECT sum( b.firstamnt ) amount, count( DISTINCT a.id ) AS total
                        FROM `satisfiedstatus` a
                        LEFT JOIN bids b ON b.task_id = a.bid_id
                        WHERE a.tasker_id = ".$_SESSION['userid']."
                        AND b.tasker_id =".$_SESSION['userid']);
	if(mysql_num_rows($getTopListQry)>0)
	{
                $dataArr=mysql_fetch_array($getTopListQry);
		$html .= '<div id="showTopId">';
		$i = 0;
		$html .= '<table border="2" width="100%" cellpadding="10"><tr style="background-color:#2980B9;color:#fff;"><th align="center" style="text-align:center;height:32px;">No of Tasks</th><th align="center" style="text-align:center;height:32px;">Total Earning</th></tr>';
//	while($row = mysql_fetch_array($getTopListQry))
//	  {		
//			$tasktype = ucwords($row['tasktype']);
//			$tasktype = $tasktype == 'Handyman' ? 'Handy Man':$tasktype;
//			$status = $row['status'] == 0 ? "Pending" : " Confirmed";
//                        if( $row['status']!=0 && $row['status']!=3 && $row['refund']!='1'){
//                            $count++;
//                            
//                        }  else {
//                            $row['firstamnt']=0;
//                        }
//                        $amount+=$row['firstamnt'];
//			//$highlighted = $row['status'] == 0 ? "style='background-color:#00d8ff;color:#000'" : "";
//			
//			$margin = "";
//			
//			
//		}
                $html .= '<tr '.$highlighted.'><td style="text-align: center;margin: 10px 0 0 0;height: 44px;" >'.$dataArr['total'].'</td>
                <td style="text-align:center">$'.round($dataArr['amount'],2).'</td></tr>';
	 $html .='</table>';
	  
	  $html .= '<div style="clear:both;">&nbsp;</div>
		</div>';
	}
	else
	{
		$html = '<div class="no-record" style="width:98%;margin:0 auto;">No Request found yet...</div>';
	}
  echo $html;
  ?>
  <!-- /.row -->
   <hr>
  </div>
  </div>
 
<?php 
// bottom part of the page
include_once "include/footer.php";
// end here
?>
<script>
    //client side confirmation if the user want to delete his/her account
function warning()
{
	if(confirm('If you delete your account you lost all your recent activities. Do you want to delete your account?'))
	{
		window.location = 'deleteaccount.php';
	}
}
//end function
</script>
