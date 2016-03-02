<?php
include "../include/config.php";
include_once "../include/classes/class.paging.php";
session_start();
$Paging=new Paging();
$html = '';
		$getTopListQry = "SELECT DATE_FORMAT(a.taskdate, '%d-%M-%Y') DATEONLY, DATE_FORMAT(a.taskdate,'%h:%I %p') TIMEONLY,a.id,a.taskto,a.taskfrom,a.taskname,a.taskdate,a.taskduration,a.taskdescription,a.tasklocation,a.userid,a.tasktype,people,a.other FROM tasks as a LEFT JOIN bids as b ON a.id=b.task_id WHERE (b.task_id is NULL || b.status='0') AND a.status='1'".$search." group by a.id order by a.id desc";
		$PageNo = isset($_GET['page']) ? $_GET['page'] : 1;
		$file=  rtrim($_SERVER[REQUEST_URI],"/".$PageNo);
		$type=$_GET['type'];
		$pagingStr='&tagName='.$_GET['tagName'];
		/*if(!isset($_SESSION['userid']) || $_SESSION['userid']==""){
			$objForum->objPaging->chkPageNo($PageNo, $getTopListQry, 5, 5,$file, "", "STATIC_PAGING");
		}else{*/
		$Paging->chkPageNo($PageNo, $getTopListQry, 7, 5,"ajax/bids.php?page", "", "showTopId");

		$getRecentQry = $Paging->showRecord($getTopListQry);
		if(mysql_num_rows($getRecentQry)>0)
		{
			$tasktype = ucwords($row['tasktype']);
			$tasktype = $tasktype == 'Handyman' ? 'Handy Man':$tasktype;
			$html .= '<div id="showTopId">';
			while($row = mysql_fetch_array($getRecentQry))
			{
				$bidStatus = '<img src="images/ajax-loader.gif" id="bid-img'.$row['id'].'" style="display:none;">  &nbsp;<a class="btn btn-primary" id="a-bid'.$row['id'].'" href="javascript:void(0)" onclick="$(\'#bid-slide'.$row['id'].'\').slideDown(\'slow\');">Bid</a>';
				//$chkBid = mysql_num_rows(mysql_query("SELECT id FROM bids WHERE task_id='".$row['id']."' AND tasker_id='".$_SESSION['userid']."'"));
				//if($chkBid == 0)
				{
					$html .= '<div id="bid'.$row['id'].'"><hr>
						<div class="row" id="con1" style="margin:0;">
						<div class="col-md-12" id="v11">
						<div class="col-xs-7" style="overflow:hidden;">';
						$html .='<h4 class="hgr1">'.ucwords($row['taskname']).' - '.ucwords($row['tasktype']).'</h4>';
			if($row['taskfrom'] != '')
			{
				$html.='<p>From : '.$row['taskfrom'].'</p>';
			}
			if($row['taskto'] != '')
			{
				$html.='<p>To : '.$row['taskto'].'</p>';
			}
			if($row['DATEONLY'] != '')
			{
				$html .= '<p>Date : '.$row['DATEONLY'].'</p>';
			}
			if($row['TIMEONLY'] != '')
			{
				if($row['TIMEONLY'] >='12:00')
					$tm = 'PM';
				else
					$tm = 'AM';
				$html .= '<p>Time : '.$row['TIMEONLY'].'</p>';
			}
			if($row['people'] != '0')
			{
				$html .= '<p>People : '.$row['people'].'</p>';
			}
			if($row['tastkduration'] != '')
			{
				$html.='<p>Duration : '.$row['taskduration'].'</p>';
			}
			if($row['tasklocation'] != '')
			{
				$html .= '<p>Location : '.$row['tasklocation'].'</p>';
			}
			if($row['other'] != '')
			{
				$html .= '<p>Other : '.$row['other'].'</p>';
			}
			if($row['taskdescription'] != '')
			{
				$html .= '<p>Description : '.$row['taskdescription'].'</p>';
			}
				  $html .=' </div><div class="clearfix"></div>';
				if($row['userid'] != $_SESSION['userid'])
				{
					$html .= '<div class="col-xs-5">
					  <div class="con6">'.$bidStatus.'</div>
					</div>';
				}
			  $html .= '</div>
			</div>
			</div>';
			$html .= '<div id="bid-slide'.$row['id'].'" style="display:none;width: 100%; background: none repeat scroll 0% 0% rgb(255, 255, 255); border-right: 1px solid rgb(204, 204, 204); border-width: medium 1px 1px; border-style: none solid solid; border-color: -moz-use-text-color rgb(204, 204, 204) rgb(204, 204, 204); -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; border-image: none; min-height: 61px;">
  <form><textarea style="border:none;resize: none;float:left;width:74%;padding-left:2px;" rows="2" cols="80" placeholder="Enter your message" name="bid-message" id="bid-message'.$row['id'].'"></textarea>
	<div style="border-left:1px solid #ccc;float:left;min-height:60px">
	 &nbsp; &#36; <input type="text" name="bid-amount" placeholder="0" style="width:149px;" id="bid-amount'.$row['id'].'"  class="bid-amount"><br>
    <input type="button" value="confirm" onclick="taskAction(\'bid\','.$row['id'].',\'addBid\')" id="a-bid'.$row['id'].'"  style="width:170px;border:0;margin-top:-5px;border-radius:0" class="sechyi" value="Confirm">
	</form>
  </div>

</div>';
			}
			}
			
		}
		else
		{
			$html = '<div class="no-record">No Request found yet...</div>';
		}




$html .= '</div><div class="pagination" style="margin:10px 2.5% 20px;float:right;">';
$html .= $Paging->showNavigation();
$html .= '</div>';
echo $html;
?>