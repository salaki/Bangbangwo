<?php include_once "include/header.php";
header("Content-Type: text/html; charset=Windows-1256\n");
include_once "include/classes/class.paging.php";
$Paging=new Paging();
?>
  <!-- /.row --> 
  
  <!-- Project One -->
  <div class="row" id="con1" style="padding:0px 15px;">
    <div class="col-md-12">
      <h4 class="hdg">My Earnings:</h4>
    
  
  <!-- /.row -->
  <?php
  
  // task wise earning
  $html = '';
   $getTopListQry = "SELECT DATE_FORMAT(b.taskdate, '%d-%M-%Y') DATEONLY, DATE_FORMAT(b.taskdate,'%h:%I %p') TIMEONLY,a.task_id,b.taskname,b.taskfrom,b.taskto,b.tasktype,b.tasklocation,b.taskdescription,b.taskduration,a.amount,a.message,a.status,people,b.other FROM bids as a LEFT JOIN tasks as b ON a.task_id = b.id WHERE tasker_id='".$_SESSION['userid']."' and a.status!='3'order by a.id desc";
	$PageNo = isset($_GET['page']) ? $_GET['page'] : 1;
	$file=  rtrim($_SERVER[REQUEST_URI],"/".$PageNo);
	$type=$_GET['type'];
	$pagingStr='&tagName='.$_GET['tagName'];
	/*if(!isset($_SESSION['userid']) || $_SESSION['userid']==""){
		$objForum->objPaging->chkPageNo($PageNo, $getTopListQry, 5, 5,$file, "", "STATIC_PAGING");
	}else{*/
	$Paging->chkPageNo($PageNo, $getTopListQry, 8, 5,"ajax/mybids.php?page", "", "showTopId");

	$getRecentQry = $Paging->showRecord($getTopListQry);
	 echo mysql_num_rows($getRecentQry);
	if(mysql_num_rows($getRecentQry)>0)
	{
		$html .= '<div id="showTopId"><div style="float:right"><a href="dashboard_tasker">Back</a></div><div style="clear:right"></div>';
		$i = 0;
		$html .= '<table border="2" width="100%" cellpadding="10"><tr style="background-color:#2980B9;color:#fff;"><th align="center">Task</th><th align="center">Rate</th><th align="center">Earn</th></tr>';
	while($row = mysql_fetch_array($getRecentQry))
	  {		
			$tasktype = ucwords($row['tasktype']);
			$tasktype = $tasktype == 'Handyman' ? 'Handy Man':$tasktype;
			$status = $row['status'] == 0 ? "Pending" : " Confirmed";
			if($row['status'] == '3')
			{
				$status = 'Rejected';
			}
			$highlighted = $row['status'] == 0 ? "style='background-color:#00d8ff;color:#000'" : "";
			$st = mysql_result(mysql_query("SELECT status from satisfiedstatus where bid_id='".$row['task_id']."' AND tasker_id='".$_SESSION['userid']."'"),0);
			if($st != '')
			{
				if($st == '1')
				{
					$status = 'Satisfied';
				}
				else if($st == '0')
				{
					$status = 'Disatisfied';
				}
			}
			$margin = "";
			$html .= '<tr '.$highlighted.'><td valign="top">'.$row['taskname'].'</td><td valign="top">'.$status.'</td><td valign="top">'.$row['amount'].'</td></tr>';
			
		}
	 $html .='</table>';
	  
	  $html .= '<div style="clear:both;">&nbsp;</div>
		<div class="pagination" style="float:right;clear:both;">';
		$html .= $Paging->showNavigation();
		$html .= '</div></div>';
	}
	else
	{
		$html = '<div class="no-record" style="width:98%;margin:0 auto;">No Request found yet...</div>';
	}
  echo $html;
  ?>
	</div>
	</div>
  <hr>
