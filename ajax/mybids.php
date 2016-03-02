<?php
include "../include/config.php";
include_once "../include/classes/class.paging.php";
session_start();
$Paging=new Paging();
$html = '';
   $getTopListQry = "SELECT DATE_FORMAT(b.taskdate, '%d-%M-%Y') DATEONLY, DATE_FORMAT(b.taskdate,'%h:%I %p') TIMEONLY,a.id,a.task_id,b.taskname,b.taskfrom,b.taskto,b.tasktype,b.tasklocation,b.taskdescription,b.taskduration,a.firstamnt amount,a.message,a.status,people,b.other,c.fname,c.lname,c.email FROM bids as a LEFT JOIN tasks as b ON a.task_id = b.id LEFT JOIN members as c ON c.id=b.userid WHERE tasker_id='".$_SESSION['userid']."' and a.hide_bid='0' order by a.id desc";
	$PageNo = isset($_GET['page']) ? $_GET['page'] : 1;
	$file=  rtrim($_SERVER[REQUEST_URI],"/".$PageNo);
	$type=$_GET['type'];
	$pagingStr='&tagName='.$_GET['tagName'];
	/*if(!isset($_SESSION['userid']) || $_SESSION['userid']==""){
		$objForum->objPaging->chkPageNo($PageNo, $getTopListQry, 5, 5,$file, "", "STATIC_PAGING");
	}else{*/
	$Paging->chkPageNo($PageNo, $getTopListQry, 8, 5,"ajax/mybids.php?page", "", "showTopId");

	$getRecentQry = $Paging->showRecord($getTopListQry);
	 mysql_num_rows($getRecentQry);
	if(mysql_num_rows($getRecentQry)>0)
	{
		$html .= '<div id="showTopId"><div style="float:right"><a href="dashboard_tasker">Back</a></div><div style="clear:right"></div>';
		$i = 1;
	while($row = mysql_fetch_array($getRecentQry))
	  {		
			$tasktype = ucwords($row['tasktype']);
			$tasktype = $tasktype == 'Handyman' ? 'Handy Man':$tasktype;
			$status = $row['status'] == 0 ? "Pending" : " Confirmed";
			if($row['status'] == '3')
			{
				$status = 'Rejected';
				$hideBid = '<div style="float:right"><img src="images/ajax-loader.gif" id="hide-bid-img'.$row['id'].'" style="display:none;"> <a onclick="hideBid('.$row['id'].','.$PageNo.')" href="javascript:void(0)" id="a-bid25" class="btn btn-primary">Delete</a></div>';
			}
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
					$hideBid = '<div style="float:right"><img src="images/ajax-loader.gif" id="hide-bid-img'.$row['id'].'" style="display:none;"> <a onclick="hideBid('.$row['id'].','.$PageNo.')" href="javascript:void(0)" id="a-bid25" class="btn btn-primary">Delete</a></div>';
			
			}
			$requestrDetail = '';
			if($row['status'] == '1')
			{
				$requestrDetail = '<tr><td>Requester</td><td> : </td><td>'.ucfirst($row['fname']).' '.ucfirst($row['lname']).'</td></tr>
					<tr><td>Email </td><td> : </td><td>'.$row['email'].'</td></tr>';
				
			}
			$margin = "";
			$a = $i % 2;
			//echo 'a'.$i.' '.$a.'<br>';
			if($row['status'] == '0' || $row['status'] == '1')
			{
				$hideBid = '';
			}
			if($a == 0)
			{
				//echo $a;
				$margin = "margin-left:50px;";
			}
			$html .= '<div class="row" id="v11" style="float:left;width:500px;overflow:hidden;'.$margin.'">
				<table border="0" width="100%">
						<tr>
						  <td valign="top" width="19%">Task</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.ucwords($row['taskname']).' - '.$tasktype.'</td>
						</tr>';
						if($row['taskfrom'] != '')
			{
				$html.='<tr>
						  <td valign="top" width="19%">From</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$row['taskfrom'].'</td>
						</tr>';
			}
			if($row['taskto'] != '')
			{
				$html.='<tr>
						  <td valign="top" width="19%">To</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$row['taskto'].'</td>
						</tr>';
			}
			if($row['DATEONLY'] != '')
			{
				$html .='<tr>
						  <td valign="top" width="19%">Date</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$row['DATEONLY'].'</td>
						</tr>';
			}
			if($row['TIMEONLY'] != '')
			{
				$html .='<tr>
						  <td valign="top" width="19%">Time</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$row['TIMEONLY'].'</td>
						</tr>';
			}
			if($row['people'] != '0')
			{
				$html .= '<tr>
						  <td valign="top" width="19%">People</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$row['people'].'</td>
						</tr>';
			}
			if($row['tastkduration'] != '')
			{
				$html.='
						<tr>
						  <td valign="top" width="19%">Duration</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$row['taskduration'].'</td>
						</tr>';
			}
			if($row['tasklocation'] != '')
			{
				$html .= '
						<tr>
						  <td valign="top" width="19%">Location</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$row['tasklocation'].'</td>
						</tr>';
			}
			if($row['other'] != '')
			{
				$html .= '
						<tr>
						  <td valign="top" width="19%">Other</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$row['other'].'</td>
						</tr>';
			}
			if($row['taskdescription'] != '')
			{
				$html .= '
						<tr>
						  <td valign="top" width="19%">Description</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$row['taskdescription'].'</td>
						</tr>';
			}
			if($row['amount'] != '')
			{
				$html .= '
						<tr>
						  <td valign="top" width="19%">Amount</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">$'.$row['amount'].'</td>
						</tr>';
			}
			if($row['status'] != '')
			{
				$html .= '
						<tr>
						  <td valign="top" width="19%">Status</td>
						  <td valign="top" width="4%">:</td>
						  <td valign="top">'.$status.'</td>
						</tr>
						<tr>
						<td valign="top" colspan="3">'.$hideBid.'</td></tr>';
			}
			$html.=$requestrDetail;
				 $html.=' </table>
			
			
			
			</div>';
			if($i % 2 == 0 && $i != 1)
			{
				$html .= '<div style="clear:both;">&nbsp;</div>';
			}
			$i++;
		}
	 
	  
	  $html .= '<div style="clear:both;">&nbsp;</div>
		<div class="pagination" style="float:right;clear:both;">';
		$html .= $Paging->showNavigation();
		$html .= '</div></div>';
	}
	echo $html;
?>