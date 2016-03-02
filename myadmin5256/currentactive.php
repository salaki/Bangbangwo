<?php
include_once "include/config.php";
session_start();
ob_start();
if(!isset($_SESSION['adminUser']) || $_SESSION['adminUser'] == '')
{
	header('location:login.php');
}

include_once "include/header.php";
?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
				<?php
				$userType = 'Active Users';
                echo '<div class="row">
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
								<a href="/admin/currentactive.php?type=2">All</a> | <a href="?type=0">Last 7 Days</a> | <a href="?type=1">1 Month</a>  
                          
                            </li>
                        </ol>
                    </div>
				</div>';
				?>
			
                <div class="row">
				<?php
                                $endDate = date('Y-m-d');
					if($_GET['type'] == 0 || !isset($_GET['type']))
					{
						$date = date('Y-m-d',strtotime('-6 days'));
					}elseif($_GET['type']==2){
                                             
                                           // $date =mysql_result(mysql_query("SELECT activ_date FROM user_log ORDER BY activ_date LIMIT 1"),0);
                                            $date='2014-09-17';
                                        }
					else if($_GET['type'] == 1)
					{
						$date = date('Y-m-d',strtotime('-30 days'));
					}
					if(isset($_REQUEST['startdate']))
					{
						$date = $_REQUEST['startdate'];
						if(!isset($_REQUEST['enddate']) || $_REQUEST['enddate'] == '')
						{
							$endDate = date('Y-m-d');
						}
						else
						{
							$endDate = $_REQUEST['enddate'];
						}
						$active = mysql_query("SELECT count(id) as cnt,activ_date FROM user_log WHERE  activ_date >= '".$date."' and activ_date<='".$endDate."' group by activ_date order by activ_date desc;");
					}
					else
					{
						$active = mysql_query("SELECT count(id) as cnt,activ_date FROM user_log WHERE  activ_date >= '".$date."%' group by activ_date order by activ_date desc;");
					
					}
                                        
                                        while($row = mysql_fetch_array($active))
					{
                                       
                                        $array_table[$row['activ_date']]= $row['cnt'];
                                        
                                        }
                                 
                                       
                                        while($date<=$endDate){
                                          $finalArr[$date]=$array_table[$date];
                                          $date= date("Y-m-d",strtotime($date.' +1 days'));
                                          
                                        }
                                        krsort($finalArr);
                                        
                                        
					
						
				?>
                    
                      <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive"><table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>                                        
                                        <th>Total Active Users</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach($finalArr as $date=>$count){
                                        
					 ?>
                                    <tr>
                                        <td><?=$date?></td>
                                        <td><?=($count)?$count:0?></td>
										
										
                                    </tr>
                                    <?php } ?>
                                
                                </tbody></table>
										
                                   
                        </div>
                                </div>
					
				 </div>
          
          
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php
include_once "include/footer.php";
?>
