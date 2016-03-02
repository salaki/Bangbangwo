<?php 
// top part of the page
include_once "include/header.php";
// ends top part


header("Content-Type: text/html; charset=Windows-1256\n");
include_once "include/classes/class.paging.php";
$Paging=new Paging();
?>
  <!-- /.row --> 
  
  <!-- Project One -->
  <div class="row" id="con1" style="padding:0px 15px;">
    <div class="col-md-12">
      <h4 class="hdg">My Bids:</h4>
    
  
  <!-- /.row -->
  <?php
  
  // mybids starts here...users all bids from the starting
  
  $html = '';
	$getTopListQry = "SELECT DATE_FORMAT(b.taskdate, '%d-%M-%Y') DATEONLY, DATE_FORMAT(b.taskdate,'%h:%I %p') TIMEONLY,a.id,a.task_id,b.taskname,b.refund,b.taskfrom,b.taskto,b.tasktype,b.tasklocation,b.taskdescription,b.taskduration,a.firstamnt,a.message,a.status,people,b.other,c.contact,c.fname,c.lname,c.email FROM bids as a LEFT JOIN tasks as b ON a.task_id = b.id LEFT JOIN members as c ON c.id=b.userid WHERE tasker_id='".$_SESSION['userid']."' and a.hide_bid='0' order by a.id desc";
        
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
		$i = 0;
	while($row = mysql_fetch_array($getRecentQry))
	  {
			$tasktype = ucwords($row['tasktype']);
			$tasktype = $tasktype == 'Handyman' ? 'Handy Man':$tasktype;
			$status = $row['status'] == 0 ? "Pending" : " Confirmed";
			
			if($row['status'] == '3' || $row['status'] == '4')
			{
				$status = 'Rejected';
				$hideBid = '<div style="float:right"><img src="images/ajax-loader.gif" id="hide-bid-img'.$row['id'].'" style="display:none;"> <a onclick="hideBid('.$row['id'].','.$PageNo.')" href="javascript:void(0)" id="a-bid25" class="btn btn-primary">Delete</a></div>';
			}
			
			if($row['refund'] == '1')
			{
				$status.= '  and Refunded';
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
			$margin = "";
			if($row['status'] == '0' || $row['status'] == '1')
			{
				$hideBid = '';
			}
			$requestrDetail = '';
			if($row['status'] == '1')
			{
				$requestrDetail = '<tr><td>Requester</td><td> : </td><td>'.ucfirst($row['fname']).' '.ucfirst($row['lname']).'</td></tr>
					<tr><td>Email </td><td> : </td><td>'.$row['email'].'</td></tr>';
				
			}
			if($i % 2 == 1)
				$margin = "margin-left:50px;";
			$html .= '<div class="col-lg-6" style="margin-bottom:15px"><div id="v11" ">
				<table border="0" width="100%">
						<tr>
						  <td width="19%">Task</td>
						  <td width="4%">:</td>
						  <td>'.ucwords($row['taskname']).' - '.$tasktype.'-'.$row['id'].'</td>
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
				$html .= '<tr>
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
			
			if($row['contact'] != '')
			{
				$html .= '
						<tr>
						  <td width="19%">Phonenumber</td>
						  <td width="4%">:</td>
						  <td>'.$row['contact'].'</td>
						</tr>';
			}
			
			if($row['firstamnt'] != '')
			{
				$html .= '
						<tr>
						  <td width="19%">Amount</td>
						  <td width="4%">:</td>
						  <td>$'.$row['firstamnt'].'</td>
						</tr>';
			}
			if($row['status'] != '')
			{
				$html .= '
						<tr>
						  <td width="19%">Status</td>
						  <td width="4%">:</td>
						  <td>'.$status.'</td>
						</tr>
						<tr>
						<td colspan="3">'.$hideBid.'</td></tr>
						';
			}
			$html.= $requestrDetail;
				 $html.=' </table>
			
			
			
			</div></div>';
			if($i % 2 == 1 && $i != 0)
			{
				$html .= '<div style="clear:both;"></div>';
			}
                    
			$i++;
		}
	 // my bids ends here
                
                
	 // pagination starts here 
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
<?php


// bottom starts here
include_once "include/footer.php";
// bottom ends here

?>
