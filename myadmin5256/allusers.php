<?php
include_once "include/config.php";
session_start();
ob_start();
if(!isset($_SESSION['adminUser']) || $_SESSION['adminUser'] == '')
{
	header('location:login.php');
}
$totalUser = mysql_result(mysql_query("SELECT count(id) FROM members"),0);
$activeUser = mysql_result(mysql_query("SELECT count(id) FROM members WHERE status='1'"),0);
$pendingUser = mysql_result(mysql_query("SELECT count(id) FROM members  WHERE status='0'"),0);
$suspendUser = mysql_result(mysql_query("SELECT count(id) FROM members  WHERE status='2'"),0);
$bannedUser = mysql_result(mysql_query("SELECT count(id) FROM members  WHERE status='3'"),0);


include_once "../include/classes/class.paging.php";
$Paging=new Paging();
$html = '';
$where = '';
if(!isset($_GET['type']) || $_GET['type'] <0 || $_GET['type'] >3)
{
	$userType = 'Total Registered Users';
}
else if($_GET['type'] == '1')
{
	$userType = 'Active Users';
}
else if($_GET['type'] == '0')
{
	$userType = 'Pending Users';
}
else if($_GET['type'] == '2')
{
	$userType = 'Suspended Users';
}
else if($_GET['type'] == '3')
{
	$userType = 'Banned Users';
}
if(!isset($_GET['type']) || $_GET['type'] <0 || $_GET['type'] >3)
{
	$where = '';
	if(isset($_POST['search']))
	{
		$where = ' where email like "'.$_POST['search'].'%"';
	}
	if(isset($_POST['date']))
	{
		$where = ' where submit_dt like "'.$_POST['date'].'%"';
	}
}
else
{
	$where = ' where status="'.$_GET['type'].'"';
	if(isset($_POST['search']))
	{
		$where = ' and email like "'.$_POST['search'].'%"';
	}
}
$getTopListQry = "SELECT * FROM members".$where;
$PageNo = isset($_GET['page']) ? $_GET['page'] : 1;
$file=  rtrim($_SERVER[REQUEST_URI],"/".$PageNo);
$type=$_GET['type'];
$pagingStr='&tagName='.$_GET['tagName'];
		/*if(!isset($_SESSION['userid']) || $_SESSION['userid']==""){
			$objForum->objPaging->chkPageNo($PageNo, $getTopListQry, 5, 5,$file, "", "STATIC_PAGING");
		}else{*/
$Paging->chkPageNo($PageNo, $getTopListQry, 100, 5,"ajax/bids.php?page", "", "showTopId");


$getRecentQry = $Paging->showRecord($getTopListQry);
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
								<input type="text" id="datepicker"  name="date" placeholder="yyyy-mm-dd" class="form-control" value="'.$_POST['date'].'">
								<span class="input-group-addon" style="padding:8.5px 15px;cursor:pointer"  onclick="document.getElementById(\'date-frm\').submit();">
									<i class="fa fa-search"></i>
								</span>
								</form>
							</div>
						</div>
						<div style="clear:both;"></div>
                        <ol class="breadcrumb">
                            <li class="active">
								<a href="allusers.php">Registered</a> : <b id="allposts">'.$totalUser.'</b> | <a href="?type=0">Pending User</a> : <b id="finishedPosts">'.$pendingUser.'</b> | <a href="?type=1">Active Users</a> : <b id="deletedTasks">'.$activeUser.'</b> | <a href="?type=1">Banned Users</a> : <b id="bannedUser">'.$bannedUser.'</b> | <a href="?type=1">Suspended Users</a> : <b id="suspendUser">'.$suspendUser.'</b> 
                          
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
                                        <th>User Name</th>
                                        <th>E-Mail</th>
                                        <th>Status</th>
                                        <th align="center" colspan="3">Action</th>
                                    </tr>
                                </thead>
                                <tbody>';
		while($row = mysql_fetch_array($getRecentQry))
		{
			$status = '-';
										$action1 = '-';
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
											$status = '<span id="st'.$row['id'].'">Suspended</span>';
											$action1 = '<a href="javascript:void(0)" id="action1'.$row['id'].'" onclick="userAction('.$row['id'].',\'active\')">Active</a>';
										    $action2 = '<a href="javascript:void(0)" id="action2'.$row['id'].'">-</a>';
										}
										else if($row['status'] == '3')
										{
											$status = '<span id="st'.$row['id'].'">Banned</span>';
											$action1 = '<a href="javascript:void(0)" id="action1'.$row['id'].'" onclick="userAction('.$row['id'].',\'active\')">Active</a>';
											//$action2 = '<a href="#">Ban</a>';
										}
										$html.='<tr id="row'.$row['id'].'">
                                        <td>'.ucfirst($row['fname']).' '.$row['lname'].'</td>
                                        <td>'.$row['email'].'</td>
                                        <td class="centerNew">'.$status.'</td>
                                        <td class="centerNew">'.$action1.'</td>
										<td class="centerNew"><a href="javascript:void(0)">'.$action2.'</a></td>
										<td class="centerNew"><a href="javascript:void(0)" onclick="deleteAccount('.$row['id'].')">Delete A/C</a></td>
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

