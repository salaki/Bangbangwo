<?php
include_once "include/config.php";
session_start();
ob_start();
if(!isset($_SESSION['adminUser']) || $_SESSION['adminUser'] == '')
{
	header('location:login.php');
}

//$todayRegister = mysql_result(mysql_query('SELECT count(id) FROM members where submit_dt like "'.date('Y-m-d').'%"'),0);

include_once "include/header.php";
?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
				<?php
                $userType = 'Registered Users';
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
								<a href="/admin/currentregister.php?type=2">All</a> | <a href="?type=0">Last 7 Days</a> | <a href="?type=1">1 Month</a>  
                          
                            </li>
                        </ol>
                    </div>
				</div>';
				
				?>
                <!-- /.row -->

                
                <!-- /.row -->

                <div class="row">
				<?php
                                        
                                        $endDate=date("Y-m-d");
					if($_GET['type'] == 0 || !isset($_GET['type']))
					{
						$date = date('Y-m-d',strtotime('-6 days'));
					}elseif($_GET['type']==2){
                                             
                                            //$date =mysql_result(mysql_query("SELECT submit_dt FROM members ORDER BY id LIMIT 1"),0);
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
                                                
                                                        
						$active = mysql_query("SELECT count(id) as cnt,DATE_FORMAT(submit_dt,'%Y-%m-%d') as dt FROM members where submit_dt >= '".$date."' and submit_dt<='".$endDate."' group by submit_dt order by submit_dt desc;");
					}
					else
					{
                                          
                                                //$totalUsers=mysql_result(mysql_query("SELECT count(id) as cnt,DATE_FORMAT(submit_dt,'%Y-%m-%d') as dt FROM members where submit_dt >= '".$date."' "),0);
						$active = mysql_query("SELECT count(id) as cnt,DATE_FORMAT(submit_dt,'%Y-%m-%d') as dt FROM members where submit_dt >= '".$date."' group by submit_dt order by submit_dt desc;");
                                                
                                                //echo "SELECT count(id) as cnt,DATE_FORMAT(submit_dt,'%Y-%m-%d') as dt FROM members where submit_dt >= '".$date."' group by submit_dt order by submit_dt desc;";
					
					}
                                        $totalUsers=mysql_result(mysql_query("SELECT count(id) as cnt FROM members"),0);
                                        
                                       /*while($row = mysql_fetch_array($active))
					{
                                        $i++;
                                        $array_table[$row['dt']]= $i==1?$totalUsers:$abc;
                                        
                                        $count+=$row['cnt'];
                                        $abc=$totalUsers-$count;
                                        
                                        } */
                                        while($row = mysql_fetch_array($active))
					{
                                       
                                        $array_table[$row['dt']]= $row['cnt'];
                                        
                                        }
                                     
                                       
                                        while($date<=$endDate){
                                          $finalArr[$date]=$array_table[$date];
                                          $date= date("Y-m-d",strtotime($date.' +1 days'));
                                          
                                        }
                                        krsort($finalArr);
                                        
                                        
                                         /*while($row = mysql_fetch_array($active)){
                                             $arrayDateWise[]=array($row['dt']=>$row['cnt']);
                                         }
					echo "<pre>";
                                        print_r($arrayDateWise);
                                        echo "</pre>";*/
						
				?>
				
				
                    
                                <div class="row">
                                    <div class="col-lg-12">
                        <div class="table-responsive"><table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>                                        
                                        <th>Total Users</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php 
                                   
                                    foreach($finalArr as $date=>$count){
                                      $i++;
                                      
                                   ?>
                                    <tr>
                                        <td><?=$date?></td>
                                        <td><?php echo $i==1?$totalUsers:$abc; ?></td>
										
                                        </tr>
                                        <?php
                                        $count_rows+=$count;
                                        $abc=$totalUsers-$count_rows;
                                        
                                        } ?>
                                     
                                
                                </tbody></table>
										
                                   
                        </div>
                                </div>
                            </div>
                            <!--<a href="javascript:void(0)">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>-->
                        
					
                </div>
                <!-- /.row 
				
				<div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">189</div>
                                        <div>All Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">45</div>
                                        <div>Active Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">124</div>
                                        <div>Blocked Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">131</div>
                                        <div>Today Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
               
                 /.row -->

                
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<?php
include_once "include/footer.php";
?>
