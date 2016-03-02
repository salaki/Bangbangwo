<?php
include_once "include/config.php";
session_start();
ob_start();
if(!isset($_SESSION['adminUser']) || $_SESSION['adminUser'] == '')
{
	header('location:login.php');
}
//$allposts = mysql_result(mysql_query("SELECT count(id) FROM tasks"),0);
$finishedPosts = mysql_result(mysql_query("SELECT count(id) FROM tasks WHERE status='2' and tasktype='transportation'"),0);
//$pendingUser = mysql_result(mysql_query("SELECT count(id) FROM members  WHERE status='0'"),0);
//$suspendUser = mysql_result(mysql_query("SELECT count(id) FROM members  WHERE status='2'"),0);
$requestTasks = mysql_result(mysql_query("SELECT count(id) FROM tasks  WHERE status='1' and tasktype='transportation'"),0);

include_once "../include/classes/class.paging.php";
$Paging=new Paging();
$html = '';
$where = '';
$taskType = 'Transportation';
/*if(!isset($_GET['type']) || $_GET['type'] <=1)
{
	$taskType = 'Tasks Requests - Transportation';
}
else
{
	$taskType = 'Tasks Performed - Transportation';
}

if(!isset($_GET['type']) || $_GET['type'] <=1)
{
	$where = ' where a.tasktype="transportation" and a.status="1" ';
	
}
else
{
	$where = ' where a.tasktype="transportation" and a.status="2" and a.status="'.$_GET['type'].'"';
}
if(isset($_POST['search']))
{
	$where = ' where a.tasktype="transportation"  and b.email like "'.$_POST['search'].'%"';
}
if(isset($_POST['searchtxt']))
{
	$where = ' where a.tasktype="transportation" and a.taskname like "'.$_POST['searchtxt'].'%"';
}*/
//$getTopListQry = "SELECT * FROM members".$where;
//$getTopListQry = "SELECT a.id,a.taskname name,a.tasktype type,a.taskto tto ,a.taskfrom frm, a.people, a.taskduration duration,a.taskdescription description,a.tasklocation location,a.taskmulti multi,a.status as st,b.email FROM `tasks` as a left join members as b on a.userid=b.id".$where;



if($_GET['type'] == 0 || !isset($_GET['type']))
{
	$date = date('Y-m-d',strtotime('-6 days'));
}elseif($_GET['type']==2){
     //$date =mysql_result(mysql_query("SELECT added_date FROM tasks ORDER BY id LIMIT 1"),0);
     $date='2014-09-17';
 }
else if($_GET['type'] == 1)
{
	$date = date('Y-m-d',strtotime('-30 days'));
}

$endDate = date('Y-m-d');
if(isset($_REQUEST['startdate']))
{
	$date = $_REQUEST['startdate'];
	if(!isset($_REQUEST['enddate']) || $_REQUEST['enddate'] == ''){
		$endDate = date('Y-m-d');
	}
	else
	{
		$endDate = $_REQUEST['enddate'];
	}
	//$active = mysql_query("SELECT count(id) as cnt,activ_date FROM user_log WHERE  activ_date >= '".$date."' and activ_date<='".$endDate."' group by activ_date order by activ_date desc;");
	$getTopListQry = "SELECT DATE_FORMAT(added_date,'%Y-%m-%d') as dt FROM `tasks` where tasktype='transportation' and status!='0' and added_date>='".$date."' and added_date<='".$endDate."'";
}
else
{
	$getTopListQry = "SELECT DATE_FORMAT(added_date,'%Y-%m-%d') as dt FROM `tasks` where tasktype='transportation' and status!='0' and added_date>='".$date."'";
}
$PageNo = isset($_GET['page']) ? $_GET['page'] : 1;
$file=  rtrim($_SERVER[REQUEST_URI],"/".$PageNo);
$type=$_GET['type'];
$pagingStr='&tagName='.$_GET['tagName'];
		/*if(!isset($_SESSION['userid']) || $_SESSION['userid']==""){
			$objForum->objPaging->chkPageNo($PageNo, $getTopListQry, 5, 5,$file, "", "STATIC_PAGING");
		}else{*/
$Paging->chkPageNo($PageNo, $getTopListQry, 100, 5,"ajax/bids.php?page", "", "showTopId");

$getRecentQry = $Paging->showRecord($getTopListQry,'added_date desc') or die(mysql_error());
$html='<div class="container-fluid">
				<div style="margin:0 auto;width:300px;display:none;" id="loading"><img src="images/loading.gif"></div>
                <div class="row">
                    <div class="col-lg-12">
						<div class="col-lg-4">
                        <h1 class="">
                            '.$taskType.'
                        </h1>
						</div>
						
						<div class="col-lg-8">
							<div class="row">
								<form method="post" action="" id="search-frm" onsubmit="if($(\'#datepicker\').val()==\'\'){alert(\'Select Date First\');return false;}">
								<div class="col-md-5">From : <input type="text" id="datepicker"  name="startdate" placeholder="yyyy-mm-dd" class="form-control" value="'.$_POST['startdate'].'" style="float:right;width:82%"></div>
								
								<div class="col-md-5">To : <input type="text" id="datepicker1"  name="enddate" placeholder="yyyy-mm-dd" class="form-control" value="'.$_POST['enddate'].'"  style="float:right;width:86%"></div>
								<div class="col-md-2"><input type="submit" value="Search"></div>
								</form>
							</div>
						</div>
						<div style="clear:both;"></div>
                        <ol class="breadcrumb">
                            <li class="active">
                                 <a href="/admin/transport.php?type=2">All</a> | <a href="?type=0">Last 7 Days</a> | <a href="?type=1">1 Month</a>  
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
                                        <th>Date</th>                                        
                                        <th>Requests Posted</th>
                                        <th>Tasks Performed</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                        while($date<=$endDate){
                                          $finalArr[$date]=$date;
                                          $date= date("Y-m-d",strtotime($date.' +1 days'));
                                          
                                        }
                                        krsort($finalArr);
		 foreach($finalArr as $date=>$count)
		{
			
				
					$countAct = mysql_result(mysql_query("SELECT count(*) FROM `tasks` where tasktype='transportation'  and date(added_date) = '".$date."'"),0);
					$countPrfrm = mysql_result(mysql_query("SELECT count(*) as prfrm FROM `tasks` where tasktype='transportation' and status='2' and date(added_date) = '".$date."'"),0);
									
                                        $html.='<tr>
                                        <td>'.$date.'</td>
                                        <td>'.$countAct.'</td>
                                        <td>'.$countPrfrm.'</td>
										
                                    </tr>';
					$date= date("Y-m-d",strtotime($date.' +1 days'));
		
		
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

