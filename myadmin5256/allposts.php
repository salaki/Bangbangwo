<?php
include_once "include/config.php";
session_start();
ob_start();
if(!isset($_SESSION['adminUser']) || $_SESSION['adminUser'] == '')
{
	header('location:login.php');
}
$allposts = mysql_result(mysql_query("SELECT count(id) FROM tasks"),0);
$finishedPosts = mysql_result(mysql_query("SELECT count(id) FROM tasks WHERE status='2'"),0);
//$pendingUser = mysql_result(mysql_query("SELECT count(id) FROM members  WHERE status='0'"),0);
//$suspendUser = mysql_result(mysql_query("SELECT count(id) FROM members  WHERE status='2'"),0);
$deletedTasks = mysql_result(mysql_query("SELECT count(id) FROM tasks  WHERE status='3'"),0);

include_once "../include/classes/class.paging.php";
$Paging=new Paging();
$html = '';
$where = '';
if(!isset($_GET['type']) || $_GET['type'] <0 || $_GET['type'] >3)
{
	$userType = 'All Tasks';
}
else if($_GET['type'] == '2')
{
	$userType = 'Finished Tasks';
}
else if($_GET['type'] == '3')
{
	$userType = 'Deleted Tasks';
}
/*else if($_GET['type'] == '2')
{
	$userType = 'Suspended Users';
}
else if($_GET['type'] == '3')
{
	$userType = 'Banned Users';
}*/
if(!isset($_GET['type']) || $_GET['type'] <0 || $_GET['type'] >3)
{
	$where = '';
	
}
else
{
	$where = ' where a.status="'.$_GET['type'].'"';
}
if(isset($_POST['search']))
{
	$where = ' where b.email like "'.$_POST['search'].'%"';
}
if(isset($_POST['searchtxt']))
{
	$where = ' where a.taskname like "'.$_POST['searchtxt'].'%"';
}
//$getTopListQry = "SELECT * FROM members".$where;
$getTopListQry = "SELECT a.id,a.taskname name,a.tasktype type,a.taskto tto ,a.taskfrom frm, a.people, a.taskduration duration,a.taskdescription description,a.tasklocation location,a.taskmulti multi,a.status as st,b.email FROM `tasks` as a left join members as b on a.userid=b.id".$where;


$PageNo = isset($_GET['page']) ? $_GET['page'] : 1;
$file=  rtrim($_SERVER[REQUEST_URI],"/".$PageNo);
$type=$_GET['type'];
$pagingStr='&tagName='.$_GET['tagName'];
		/*if(!isset($_SESSION['userid']) || $_SESSION['userid']==""){
			$objForum->objPaging->chkPageNo($PageNo, $getTopListQry, 5, 5,$file, "", "STATIC_PAGING");
		}else{*/
$Paging->chkPageNo($PageNo, $getTopListQry, 100, 5,"ajax/bids.php?page", "", "showTopId");


$getRecentQry = $Paging->showRecord($getTopListQry,'a.id desc') or die(mysql_error());
$html='<div class="container-fluid">
				<div style="margin:0 auto;width:300px;display:none;" id="loading"><img src="images/loading.gif"></div>
                <div class="row">
                    <div class="col-lg-12">
						<div class="col-lg-6">
                        <h1 class="">
                            '.$userType.'
                        </h1>
						</div>
						<div class="col-lg-2"></div>
						<div class="col-lg-4">
							<div class="input-group">
								<form method="post" action="" id="search-frm">
								<input type="text" id="inputGroup"  style="width:300px;" name="search" placeholder="email" class="form-control" value="'.$_POST['search'].'">
								<span class="input-group-addon" style="padding:8.5px 15px;cursor:pointer"  onclick="document.getElementById(\'search-frm\').submit();">
									<i class="fa fa-search"></i>
								</span>
								</form>
								<form method="post" action="" id="date-frm" style="margin:5px 0px;">
								<input type="text" id="searchtxt"  name="searchtxt" placeholder="Task Name" class="form-control" value="'.$_POST['searchtxt'].'">
								<span class="input-group-addon" style="padding:8.5px 15px;cursor:pointer"  onclick="document.getElementById(\'date-frm\').submit();">
									<i class="fa fa-search"></i>
								</span>
								</form>
							</div>
						</div>
						<div style="clear:both;"></div>
                        <ol class="breadcrumb">
                            <li class="active">
                                 <a href="allposts.php">All Tasks</a> : <b id="allposts">'.$allposts.'</b> | <a href="?type=2">Finished Tasks</a> : <b id="finishedPosts">'.$finishedPosts.'</b> | <a href="?type=3">Deleted Tasks</a> : <b id="deletedTasks">'.$deletedTasks.'</b>
                            </li>
                        </ol>
                    </div>
                </div>
				<div class="row">
                     <div class="col-lg-12">
                        <div class="table-responsive">';
if(mysql_num_rows($getRecentQry)>0)
{
	$html.='<table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>E-Mail</th>
                                        <th>Task Name</th>
                                        <th>Task Type</th>
										<th>Multi Task</th>
                                        <!-- <th>To</th>
                                        <th>From</th>
                                        <th>Location</th>
                                        <th>People</th>
                                        -->
                                        <th>Status</th>
                                        <th>Action</th>
                                       <!-- <th align="center" colspan="2">Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>';
		while($row = mysql_fetch_array($getRecentQry))
		{
			$status = '-';
			$multi = 'No';
			if($row['st'] == 2)
			{
				$status = 'Finished';
			}
			else if($row['st'] == 3)
			{
				$status = 'Deleted';
			}
			if($row['multi'] == 1)
			{
				$multi = 'Yes';
			}
			if($row['st'] != 3)
			{
				$delete = '<a  style="cursor: pointer; float: right; padding: 3px; background: none repeat scroll 0% 0% rgb(238, 238, 238); border: 1px solid;" id="img'.$row['id'].'" onclick="deletePost('.$row['id'].')">Delete</a>';
			}
			/*$action1 = '-';
										$action2 = '-';
										if($row['status'] == '0')
										{
											$status = 'Pending';
											
										}
										else if($row['status'] == '1')
										{
											$status = '<span id="st'.$row['id'].'">Active</span>';
											$action1 = '<a href="javascript:void(0)" id="action1'.$row['id'].'" onclick="userAction('.$row['id'].',\'suspend\')">Suspend</a>';
											$action2 = '<a href="javascript:void(0)" id="action2'.$row['id'].'" onclick="userAction('.$row['id'].',\'ban\')">Ban</a>';
											
										}
										else if($row['status'] == '2')
										{
											$status = 'Suspended';
											//$action1 = '<a href="#">Suspend</a>';
											//$action2 = '<a href="#">Ban</a>';
										}
										else if($row['status'] == '3')
										{
											$status = 'Banned';
											$action1 = '<a href="javascript:void(0)" id="action1'.$row['id'].'" onclick="userAction('.$row['id'].',\'active\')">Active</a>';
											//$action2 = '<a href="#">Ban</a>';
										}*/
										$html.='<tr>
										<td>'.$row['email'].'</td>
										<td>'.$row['name'].'</td>
										<td>'.$row['type'].'</td><!--<td>'.$row['tto'].'</td><td>'.$row['frm'].'</td><td>'.$row['location'].'</td><td>'.$row['people'].'</td>--><td>'.$multi.'</td><td><span id="st'.$row['id'].'">'.$status.'</span></td>
                                                                                <td>'.$delete.'</td>
                                    </tr>';
		
		
		
		}
		$html.='</tbody>
                            </table>';
}
else
{
	$html.='<div class="breadcrumb">No Record Found...</div>';
}
		$html.='</div>
                   </div>
                 </div></div>';
            
$html .=  '<div class="pagination" style="margin:10px 2.5% 20px;float:right;">';
$html .= $Paging->showNavigation();
$html .= '</div><div style="clear:both;>&nbsp;</div>';
include_once "include/header.php";

?>
	
        <div id="page-wrapper">
			<div id="showTopId">
				<?=$html;?>
			
			<!-- /.container-fluid -->

			</div>
		</div>
        <!-- /#page-wrapper -->

<?php
include_once "include/footer.php";
?>

