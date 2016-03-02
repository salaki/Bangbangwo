<?php
include "../include/config.php";
include_once "../include/classes/class.paging.php";
session_start();
echo '<h4 class="sidehd">My Bids</h4>';
			$html = '';
			$query = mysql_query("SELECT DATE_FORMAT(b.taskdate, '%d-%M-%Y') DATEONLY, DATE_FORMAT(b.taskdate,'%h:%I %p') TIMEONLY,a.task_id,b.taskname,b.taskfrom,b.taskto,b.taskdate,b.tasktype,b.tasklocation,b.taskdescription,b.taskduration,a.amount,a.message,a.status,people,b.other FROM bids as a LEFT JOIN tasks as b ON a.task_id = b.id WHERE tasker_id='".$_SESSION['userid']."' order by a.id desc LIMIT 3");
			if(mysql_num_rows($query) > 0)
			{
				while($row = mysql_fetch_array($query))
				{
					$tasktype = ucwords($row['tasktype']);
			$tasktype = $tasktype == 'Handyman' ? 'Handy Man':$tasktype;
			$status = $row['status'] == 0 ? "Pending" : " Confirmed";
			if($row['status'] == '3')
			{
				$status = 'Rejected';
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
			}
			$html .= '<div class="contxtinner1" style="overflow:hidden">
				<table border="0" width="100%">
						<tr>
						  <td width="19%">Task</td>
						  <td width="4%">:</td>
						  <td>'.ucwords($row['taskname']).' - '.$tasktype.'</td>
						</tr>';
						if($row['taskfrom'] != '')
			{
				$html.='<tr>
						  <td width="19%">From</td>
						  <td width="4%">:</td>
						  <td>'.$row['taskfrom'].'</td>
						</tr>';
			}
			if($row['taskto'] != '')
			{
				$html.='<tr>
						  <td width="19%">To</td>
						  <td width="4%">:</td>
						  <td>'.$row['taskto'].'</td>
						</tr>';
			}
			if($row['DATEONLY'] != '')
			{
				$html .='<tr>
						  <td width="19%">Date</td>
						  <td width="4%">:</td>
						  <td>'.$row['DATEONLY'].'</td>
						</tr>';
			}
			if($row['TIMEONLY'] != '')
			{
				$html .='<tr>
						  <td width="19%">Time</td>
						  <td width="4%">:</td>
						  <td>'.$row['TIMEONLY'].'</td>
						</tr>';
			}
			if($row['people'] != '0')
			{
				$html .='<tr>
						  <td width="19%">People</td>
						  <td width="4%">:</td>
						  <td>'.$row['people'].'</td>
						</tr>';
			}
			if($row['tastkduration'] != '')
			{
				$html.='
						<tr>
						  <td width="19%">Duration</td>
						  <td width="4%">:</td>
						  <td>'.$row['taskduration'].'</td>
						</tr>';
			}
			if($row['tasklocation'] != '')
			{
				$html .= '
						<tr>
						  <td width="19%">Location</td>
						  <td width="4%">:</td>
						  <td>'.$row['tasklocation'].'</td>
						</tr>';
			}
			if($row['other'] != '')
			{
				$html .= '
						<tr>
						  <td width="19%">Other</td>
						  <td width="4%">:</td>
						  <td>'.$row['other'].'</td>
						</tr>';
			}
			if($row['taskdescription'] != '')
			{
				$html .= '
						<tr>
						  <td width="19%">Description</td>
						  <td width="4%">:</td>
						  <td>'.$row['taskdescription'].'</td>
						</tr>';
			}
			if($row['taskdescription'] != '')
			{
				$html .= '
						<tr>
						  <td width="19%">Amount</td>
						  <td width="4%">:</td>
						  <td>$'.$row['amount'].'</td>
						</tr>';
			}
			if($row['status'] != '')
			{
				$html .= '
						<tr>
						  <td width="19%">Status</td>
						  <td width="4%">:</td>
						  <td>'.$status.'</td>
						</tr>';
			}
				 $html.='</table>
			</div>';
				}
				
				$html .= '<div class="contxtinner1" style="text-align:right">
  <a href="mybids">View All</a>
</div>';
			}
			else
			{
				$html = '<div class="no-record">No Bid accept yet...</div>';
			}
	echo $html;		
?>			