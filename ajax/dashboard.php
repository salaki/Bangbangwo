<?php
// top part of page
include_once "include/header.php";
// end top part
header("Content-Type: text/html; charset=Windows-1256\n");
include_once "include/classes/class.paging.php";
$Paging = new Paging();
$removebutton = '';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>  
<script src="https://checkout.stripe.com/checkout.js"></script>
<!-- /.row --> 
<?php
if (isset($_GET['done'])) {
    ?>
    <script>
        $(document).ready(function () {
            var location = 'http://' + window.location.hostname + '/dashboard';

            var taskerid = '<?php echo $_GET['tasker_id']; ?>';
            var taskid = '<?php echo $_GET['task_id']; ?>';
            var action = '<?php echo $_GET['action']; ?>';
            var pageno = '<?php echo $_GET['pageno']; ?>';

            hireTask(taskerid, taskid, action, pageno);
            setTimeout(function () {
                window.location.href = location;
            }, 2000);
        });

    </script>
    <?php
}
if (isset($_GET['satisfied'])) {
    ?>
    <script>
        $(document).ready(function () {
            var location = 'http://' + window.location.hostname + '/dashboard';
            var taskerid = $("#transfersattaskerid").val();

            var taskid = $("#transfersattaskid").val();

            var action = $("#transfersataction").val();

            var pageno = $("#transfersatpageno").val();

            satisfiedAction(taskid, taskerid, action, pageno);
            setTimeout(function () {
                window.location.href = location;
            }, 1000);
        });

    </script>
    <?php
}
if (isset($_GET['dissatisfied'])) {
    ?>
    <script>
        $(document).ready(function () {
            var location = 'http://' + window.location.hostname + '/dashboard';
            var taskerid = $("#transferdistaskerid").val();
            var taskid = $("#transferdistaskid").val();
            var action = $("#transferdisaction").val();
            var pageno = $("#transferdispageno").val();
            satisfiedAction(taskid, taskerid, action, pageno);
            setTimeout(function () {
                window.location.href = location;
            }, 1000);
        });

    </script>
<?php }
?>
<script>
    var handler = StripeCheckout.configure({
        key: 'pk_test_vzM5mOUXvklHG5AhnUEs63AE',
        // image: '/img/documentation/checkout/marketplace.png',
        token: function (token) {
            // alert(token);
        }
    });

    $('#customButton').on('click', function (e) {
        // Open Checkout with further options
        handler.open({
            name: 'Bangbangwo',
            description: '2 widgets',
            zipCode: true,
            amount: 2000
        });
        e.preventDefault();
    });

    // Close Checkout on page navigation
    $(window).on('popstate', function () {
        handler.close();
    });
</script>
<script>
    var formid = '';
    function status_set(value_get) {
        //alert(value_get);
        formid = value_get;
    }
    function satisfiedAction4()
    {
        $("#trans").click();

    }

    function satisfiedAction5()
    {
        $("#transdis").click();

    }
    // read more function when user click on read more after about me
    function read_more(read_id) {

        if ($('#click_' + read_id).html() == '(+)') {
            $('#click_' + read_id).html('(-)');
            $('#about_p_' + read_id).css('overflow', 'visible').css('height', 'auto');
        } else {
            $('#click_' + read_id).html('(+)');
            $('#about_p_' + read_id).css('overflow', 'hidden').css('height', '20px');
        }
    }
</script>
<!-- Project One -->
<div class="row" id="con1">
    <div class="col-md-12">
        <h4 class="hdg">My Requests:</h4>
    </div>
</div>
<div id="clickformid" style="display:none;"></div>
<div id="tasktypeid" style="display:none;"></div>
<!-- /.row -->
<?php
//request details with user details who has bid on the tasks..


$html = '';
$getTopListQry = "SELECT DATE_FORMAT(taskdate, '%d-%M-%Y') DATEONLY, DATE_FORMAT(taskdate,'%h:%i %p') TIMEONLY,id,taskname,taskfrom,taskto,tasktype,tasklocation,taskdescription,taskduration,people,other,status,taskmulti ,refund FROM tasks WHERE userid='" . $_SESSION['userid'] . "' and status !='3' order by id desc";
$PageNo = isset($_GET['page']) ? $_GET['page'] : 1;
$file = rtrim($_SERVER[REQUEST_URI], "/" . $PageNo);
$type = $_GET['type'];
$pagingStr = '&tagName=' . $_GET['tagName'];
/* if(!isset($_SESSION['userid']) || $_SESSION['userid']==""){
  $objForum->objPaging->chkPageNo($PageNo, $getTopListQry, 5, 5,$file, "", "STATIC_PAGING");
  }else{ */
$Paging->chkPageNo($PageNo, $getTopListQry, 3, 5, "ajax/requests.php?page", "", "showTopId");

$getRecentQry = $Paging->showRecord($getTopListQry);
mysql_num_rows($getRecentQry);
if (mysql_num_rows($getRecentQry) > 0) {
    $html .= '<div id="showTopId" style="padding: 0px 14px;">';
    while ($row = mysql_fetch_array($getRecentQry)) {
        $a++;
        $taskmulti = $row['taskmulti'] == '1' ? 'Multi' : 'Single';
        if ($row['taskmulti'] == '0') {
            $tasktype = ucwords($row['tasktype']);
            $tasktype = $tasktype == 'Handyman' ? 'Handy Man' : $tasktype;
            $html .= '<div id="task' . $row['id'] . '"> <hr>
		  <div class="row" id="con1" style="margin:0;">
			<div class="col-md-12" id="v11">
			  <div class="col-xs-7" style="overflow:hidden;">
				<h4 class="hgr1">' . ucwords($row['taskname']) . ' - ' . ucwords($row['tasktype']) . ' (' . $taskmulti . ')</h4>';
            if ($row['taskfrom'] != '') {
                $html.='<p>From : ' . $row['taskfrom'] . '</p>';
            }
            if ($row['taskto'] != '') {
                $html.='<p>To : ' . $row['taskto'] . '</p>';
            }
            if ($row['DATEONLY'] != '' || $row['TIMEONLY'] != '') {
                $html .='<p>Time : ' . $row['DATEONLY'] . ' ' . $row['TIMEONLY'] . '</p>';
            }
            if ($row['people'] != '0') {
                $html.='<p>People : ' . $row['people'] . '</p>';
            }
            if ($row['taskduration'] != '') {
                $html.='<p>Duration : ' . $row['taskduration'] . '</p>';
            }
            if ($row['tasklocation'] != '') {
                $html .= '<p>Location : ' . $row['tasklocation'] . '</p>';
            }
            if ($row['other'] != '') {
                $html .= '<p>Other : ' . $row['other'] . '</p>';
            }
            if ($row['taskdescription'] != '') {
                $html .= '<p>Description : ' . $row['taskdescription'] . '</p>';
            }
            $edit = '';
            //  if ($row['status'] != '2')

            $deleteRecord = mysql_query("SELECT * FROM bids where task_id='" . $row['id'] . "' AND status!=3 LIMIT 1");
            $chksatisfied = mysql_query("select * from satisfiedstatus where bid_id='" . $row['id'] . "' ");

            $removebutton = '';
		$actionbutton='';
            if (mysql_num_rows($deleteRecord) > 0) {

                $getData = mysql_fetch_assoc($deleteRecord);
                //if ($getData['status'] != '3') {

                if ($row['refund'] == '1' && $row['refund'] != '') {
                    $removebutton = 'show';
                    $delete = 'Refunded';
                } else if (mysql_num_rows($chksatisfied) > 0) {
                    $delete = "Delete ";
                } else {
                    $delete = "Cancel";
                }
   
            } else {
                $edit = '<a class="btn btn-primary" href="edit_task.php?id=' . $row['id'] . '">Edit</a>';
                if ($row['refund'] == '1' && $row['refund'] != '') {
                    $removebutton = 'show';
                    $delete = 'Refunded';
                } else {
                    $delete = "Delete";
                }
            }
	   if($row['status']==4){
		$delete = "Delete";
		$edit='';
	   }
	    if (!empty($removebutton)) {
                $rmbutton = '<a class="btn btn-primary" href="javascript:void(0);" onclick="taskAction(\'task\',' . $row['id'] . ',\'removeTask\')">Delete</a>';
                $actionbutton = '<div class="con6"><img src="images/ajax-loader.gif" id="remove-img' . $row['id'] . '" style="display:none;"> ' . $edit . '  <a class="btn btn-primary" href="javascript:void(0)">' . $delete . '</a> ' . $rmbutton . '</div>';
            } else if($delete=='Cancel'){
		$actionbutton = '<div class="con6"><img src="images/ajax-loader.gif" id="remove-img' . $row['id'] . '" style="display:none;"> ' . $edit . '  <a class="btn btn-primary" href="javascript:void(0)" onclick="taskAction(\'task\',' . $row['id'] . ',\'removeTask\')">' . $delete . '</a></div>';
	   }else {
                $actionbutton = '<div class="con6"><img src="images/ajax-loader.gif" id="remove-img' . $row['id'] . '" style="display:none;"> ' . $edit . '  <a class="btn btn-primary" href="javascript:void(0)" onclick="taskAction(\'task\',' . $row['id'] . ',\'removeTask\')">' . $delete . '</a></div>';
            }

            $html.='</div>
			  <div class="col-xs-5">
				' . $actionbutton . '
			  </div>
			</div>
		  </div>
		  <!-- /.row -->';
            // echo "SELECT a.task_id,a.tasker_id,a.amount,a.message,a.status,b.fname,b.lname,b.image,b.likes,b.dislikes,b.linkedin,b.contact FROM bids as a LEFT JOIN members as b ON a.tasker_id=b.id WHERE task_id='".$row['id']."' and a.status='2'";
            $getRecord = mysql_num_rows(mysql_query("SELECT a.task_id,a.tasker_id,a.amount,a.message,a.status,b.fname,b.lname,b.image,b.likes,b.dislikes,b.linkedin,b.contact,b.about_me FROM bids as a LEFT JOIN members as b ON a.tasker_id=b.id WHERE task_id='" . $row['id'] . "' and a.status='1'"));
            if ($getRecord > 0) {
                $bidQuery = "SELECT a.task_id,a.tasker_id,a.amount,a.message,a.status,b.fname,b.lname,b.image,b.likes,b.dislikes,b.linkedin,b.contact,b.email,b.about_me FROM bids as a LEFT JOIN members as b ON a.tasker_id=b.id WHERE task_id='" . $row['id'] . "' and a.status='1'";
            } else {
                $bidQuery = "SELECT a.task_id,a.tasker_id,a.amount,a.message,a.status,b.fname,b.lname,b.image,b.likes,b.dislikes,b.linkedin,b.contact,b.email,b.about_me FROM bids as a LEFT JOIN members as b ON a.tasker_id=b.id WHERE task_id='" . $row['id'] . "' and a.status='0'";
            }
            $bidQuery_1 = mysql_query($bidQuery);
            while ($bidResult = mysql_fetch_array($bidQuery_1)) {

                $abc++;

                $publishablekey1 = mysql_query("select * from stripecredentials where id ='1'");
                $presult1 = mysql_fetch_array($publishablekey1);
                $query = mysql_query("select * from taskerdetails where userid ='" . $_SESSION['userid'] . "' && cardid !='' && secretkey='" . $presult1['secretkey'] . "'");
                $cust = mysql_fetch_array($query);
                //print_r($cust);
                if (mysql_num_rows($query) > 0) {
                    $amnt = $bidResult['amount'] * 100;
                    $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;">  &nbsp;';
                    $hireStatus.='<form action="charge.php" method="POST" id="chargeform' . $abc . '" style="float:left; ">
			         <input type="hidden" name="taskerid" id="taskerid" value="' . $bidResult['tasker_id'] . '">
		                 <input type="hidden" name="taskid" id="taskid" value="' . $bidResult['task_id'] . '">
		                 <input type="hidden" name="action" id="action" value="hireSingleBid">
		                 <input type="hidden" name="pageno" id="pageno" value="' . $PageNo . '">
		                 <input type="hidden" name="amount" value="' . $amnt . '"> 
		                 <input type="hidden" name="customerid" value="' . $cust['customerid'] . '">
		                 <input type="submit" id="a-hire' . $bidResult['tasker_id'] . '" value="Hire" class="btn btn-primary">  
			               </form>		
			 <a class="btn btn-primary" id="a-remove' . $bidResult['tasker_id'] . '" href="javascript:void(0)" onclick="rejectSingleBid(' . $bidResult['tasker_id'] . ',' . $bidResult['task_id'] . ',' . $PageNo . ')">Reject</span></a>';
                } else {

                    /* $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img'.$bidResult['tasker_id'].'" style="display:none;">  &nbsp;<a class="btn btn-primary" id="a-hire'.$bidResult['tasker_id'].'" href="javascript:void(0)" onclick="hireTask('.$bidResult['tasker_id'].','.$bidResult['task_id'].',\'hireSingleBid\','.$PageNo.')">Hire </span></a> <a class="btn btn-primary" id="a-remove'.$bidResult['tasker_id'].'" href="javascript:void(0)" onclick="rejectSingleBid('.$bidResult['tasker_id'].','.$bidResult['task_id'].','.$PageNo.')">Reject</span></a>'; */
                    $amnt = $bidResult['amount'] * 100;

                    $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;">  &nbsp; <a style="float:right;margin-left:14px;" class="btn btn-primary" id="a-remove' . $bidResult['tasker_id'] . '" href="javascript:void(0)" onclick="rejectSingleBid(' . $bidResult['tasker_id'] . ',' . $bidResult['task_id'] . ',' . $PageNo . ')">Reject</span></a> &nbsp;
			 	<button  class="btn btn-primary customButton" > Hire  </button>
                              
                                <form action="charge.php" method="POST" id="chargeform' . $abc . '">
			         <input type="hidden" name="taskerid" id="taskerid" value="' . $bidResult['tasker_id'] . '">
		                 <input type="hidden" name="taskid" id="taskid" value="' . $bidResult['task_id'] . '">
		                 <input type="hidden" name="action" id="action" value="hireSingleBid">
		                 <input type="hidden" name="pageno" id="pageno" value="' . $PageNo . '">
		                 <input type="hidden" name="amount" value="' . $amnt . '"> 
		                 <input type="hidden" name="customerid" value="' . $cust['customerid'] . '">
		                 </form>	

<script>
 
  var handler = StripeCheckout.configure({
    key: "' . $presult1["publishablekey"] . '",
    token: function(token) {
     
       $.ajax({
	url:"connect1.php",
	type:"POST",
	data: {token:token.id,userid:' . $_SESSION['userid'] . '},
	success:function(msg){ 	
		alert($(this).html());
	        $("#"+$("#clickformid").html()).submit();
	}
	
	
	});
      
    }
  });

  $(".customButton").on("click", function(e) {
    // Open Checkout with further options
  	$("#clickformid").html($(this).next("form").attr("id"));
    handler.open({
        amount: ' . $amnt . '
    });
    e.preventDefault();
  });

  // Close Checkout on page navigation
  $(window).on("popstate", function() {
    handler.close();
  });
</script>
  
			              ';
                }
                $name = $bidResult['fname'] . ' ' . $bidResult['lname'];
                $image = $bidResult['image'];
                $image = $image == '' ? 'upload/noprofile.jpg' : 'upload/' . $image;
                if ($bidResult['status'] == 1) {
                    //echo "SELECT status FROM satisfiedstatus WHERE bid_id='".$bidResult['task_id']."' AND tasker_id='".$bidResult['tasker_id']."'";
                    $likeQuery = mysql_query("SELECT status FROM satisfiedstatus WHERE bid_id='" . $bidResult['task_id'] . "' AND tasker_id='" . $bidResult['tasker_id'] . "'");
                    $find = mysql_num_rows($likeQuery);
                    if ($find == 0) {
                        $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;">  &nbsp;<a  onclick="satisfiedAction4(' . $bidResult['task_id'] . ',' . $bidResult['tasker_id'] . ',1,' . $PageNo . ')" href="javascript:void(0)" id="like' . $bidResult['tasker_id'] . '" class="btn btn-primary">Satisfied</a> 
		
		        <input type="hidden" value="' . $bidResult['task_id'] . '" id="transfersattaskid">
		        <input type="hidden" value="' . $bidResult['tasker_id'] . '" id="transfersattaskerid">
		        <input type="hidden" value="1" id="transfersataction">
		        <input type="hidden" value="' . $PageNo . '" id="transfersatpageno">
		
	        <a onclick="satisfiedAction5(' . $bidResult['task_id'] . ',' . $bidResult['tasker_id'] . ',0,' . $PageNo . ')" href="javascript:void(0)" id="dislike' . $bidResult['tasker_id'] . '" class="btn btn-primary">Disatisfied</a>
	               
	                <input type="hidden" value="' . $bidResult['task_id'] . '" id="transferdistaskid">
		        <input type="hidden" value="' . $bidResult['tasker_id'] . '" id="transferdistaskerid">
		        <input type="hidden" value="0" id="transferdisaction">
		        <input type="hidden" value="' . $PageNo . '" id="transferdispageno">';
                        // $amnt = $bidResult['amount']*100;
                        // $result =$amnt - (15/100);
                        // $data = $result*100;
                        //$amnt = ($bidResult['amount']-($bidResult['amount']*(15/100)));
                        $data = mysql_query("SELECT * FROM bids WHERE task_id='" . $bidResult['task_id'] . "' AND tasker_id='" . $bidResult['tasker_id'] . "'");

                        $rec = mysql_fetch_array($data);
                        $amnt = $rec['firstamnt'] * 100;
                        //$amnt= $bidResult['firstamnt']*100;
                        $taskid = $bidResult['task_id'];
                        $taskerid = $bidResult['tasker_id'];
                        $hireStatus.= '
        <form action="satisfied.php" id="transferform" method="post" style="float:right; display:none;">
        <input type="hidden" name="amount" value="' . $amnt . '" >
        <input type="hidden" name="taskid" value="' . $taskid . '" >
        <input type="hidden" name="taskerid" value="' . $taskerid . '" >
        <input type="submit" id="trans" name="submit" class="btn btn-primary" value="Payment"> </form>

        <form action="dissatisfied.php" id="transferform" method="post" style="float:right; display:none;">
        <input type="hidden" name="amount" value="' . $amnt . '" >
        <input type="hidden" name="taskid" value="' . $taskid . '" >
        <input type="hidden" name="taskerid" value="' . $taskerid . '" >
        <input type="submit" id="transdis" name="submit" class="btn btn-primary" value="Payment"> </form>
        ';
                    } else {
                        //echo $find = mysql_num_rows($likeQuery);
                        $likeResult = mysql_result($likeQuery, 0);
                        //echo 'd'.$likeQuery['status'];
                        if ($likeResult == '0') {
                            $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;"> &nbsp;<a href="javascript:void(0)" class="btn btn-primary" style="background-color:#3071A9;color:#fff;">Disatisfied</a>';
                        } else {
                            $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;"> &nbsp;<a href="javascript:void(0)" class="btn btn-primary" style="background-color:#3071A9;color:#fff;">Satisfied</a>';
                        }
                    }
                }
                $html.='
		  <hr>
		  <!-- Project Two -->
		  <div class="row" style="overflow:hidden">
			<div id="" class="col-md-12">
			  <div class="col-xs-3" id="roded">  <img  class="img-responsive" src="' . $image . '" alt="">  </div>
			  <div class="col-xs-8" id="white1">
				<div class="innp">
				  <h4 class="hgr1">' . $name . '</h4>
				  <p style="word-wrap: break-word;"><a href="http://' . $bidResult['linkedin'] . '">' . $bidResult['linkedin'] . '</a></p>
				  <p><font size="5">$' . $bidResult['amount'] . '</font> &nbsp; <span class="dll" id="likeheart' . $bidResult['tasker_id'] . '"> ' . $bidResult['likes'] . ' </span> &nbsp; <span class="dll_dark" id="dislikeheart' . $bidResult['tasker_id'] . '"> ' . $bidResult['dislikes'] . ' </span></p>
				<p>Contact : ' . $bidResult['contact'] . '</p><p>Email : ' . $bidResult['email'] . '</p>';

                if ($bidResult['message'] != '')
                    $html.='<p>Message: ' . $bidResult['message'] . '</p>';

                $html.='</div>';


                if ($row['refund'] != '1') {
                    $html.='<div class="rhtyi"> ' . $hireStatus . ' </div>';
                }
                //<div class="rhtyi"> ' . $hireStatus . ' </div>';

                if ($bidResult['about_me'] != '') {
                    //$html.='<p style="height:40px;overflow:hidden" id="about_p_'.$a.'">About me:'.(strlen($bidResult['about_me'])>40?substr($bidResult['about_me'],0,37)."...":$bidResult['about_me']).'<a target="_blank" href="/about_me.php?id='.$bidResult['tasker_id'].'">Read More</a></p>';

                    $html.='<p>&nbsp;</p>
                                         <div style="float: left; width: 100%; padding-left: 47px;" >
                                        <p ><b>About me: </b>
                                         <p style="text-align: justify; height: 20px; overflow: hidden; float: left; width: 90%;" id="about_p_' . $a . '">' . $bidResult['about_me'] . '</p>
                                             <a style="float: left; margin-left: 2px; text-decoration: none; font-size: 20px; margin-top: -5px;" id="click_' . $a . '" onclick="read_more(' . $a . ');" href="javascript:void(0);">(+)</a></div>
                                             <!--<a target="_blank" href="/about_me.php?id=' . $bidResult['tasker_id'] . '">Read More</a>--></p>';
                }
                $html.='</div>
			</div>
		  </div>';
            }
        } else {
            //multi task 
            $tasktype = ucwords($row['tasktype']);
            $tasktype = $tasktype == 'Handyman' ? 'Handy Man' : $tasktype;
            $html .= '<div id="task' . $row['id'] . '">  <hr>
		  <div class="row" id="con1" style="margin:0;">
			<div class="col-md-12" id="v11">
			  <div class="col-xs-7" style="overflow:hidden;">
				<h4 class="hgr1">' . ucwords($row['taskname']) . ' - ' . ucwords($row['tasktype']) . ' (' . $taskmulti . ')</h4>';
            if ($row['taskfrom'] != '') {
                $html.='<p>From : ' . $row['taskfrom'] . '</p>';
            }
            if ($row['taskto'] != '') {
                $html.='<p>To : ' . $row['taskto'] . '</p>';
            }
            if ($row['DATEONLY'] != '' || $row['TIMEONLY'] != '') {
                $html .='<p>Time : ' . $row['DATEONLY'] . ' ' . $row['TIMEONLY'] . '</p>';
            }
            if ($row['people'] != '0') {
                $html.='<p>People : ' . $row['people'] . '</p>';
            }
            if ($row['taskduration'] != '') {
                $html.='<p>Duration : ' . $row['taskduration'] . '</p>';
            }
            if ($row['tasklocation'] != '') {
                $html .= '<p>Location : ' . $row['tasklocation'] . '</p>';
            }
            if ($row['other'] != '') {
                $html .= '<p>Other : ' . $row['other'] . '</p>';
            }
            if ($row['taskdescription'] != '') {
                $html .= '<p>Description : ' . $row['taskdescription'] . '</p>';
            }

            $edit = '';
            $deleteRecord1 = mysql_query("SELECT * FROM bids where task_id='" . $row['id'] . "' AND status!=3 LIMIT 1");
            $chksatisfied = mysql_query("select * from satisfiedstatus where bid_id='" . $row['id'] . "' AND status='0' ");
       
		if (mysql_num_rows($deleteRecord) > 0) {

                $getData = mysql_fetch_assoc($deleteRecord);
                //if ($getData['status'] != '3') {

                if ($row['refund'] == '1' && $row['refund'] != '') {
                    $removebutton = 'show';
                    $delete = 'Refunded';
                } else if (mysql_num_rows($chksatisfied) > 0) {
                    $delete = "Delete ";
                } else {
                    $delete = "Cancel";
                }
   
            } else {
                $edit = '<a class="btn btn-primary" href="edit_task.php?id=' . $row['id'] . '">Edit</a>';
                if ($row['refund'] == '1' && $row['refund'] != '') {
                    $removebutton = 'show';
                    $delete = 'Refunded';
                } else {
                    $delete = "Delete";
                }
            }
	   if($row['status']==4){
		$delete = "Delete";
		$edit='';
	   }

            if (!empty($removebutton)) {
                $rmbutton = '<a class="btn btn-primary" href="javascript:void(0);" onclick="taskAction(\'task\',' . $row['id'] . ',\'removeTask\')">Delete</a>';
                $actionbutton = '<div class="con6"><img src="images/ajax-loader.gif" id="remove-img' . $row['id'] . '" style="display:none;">   <a class="btn btn-primary" href="javascript:void(0)">' . $delete . '</a> ' . $rmbutton . '</div>';
            } else {
                $actionbutton = '<div class="con6"><img src="images/ajax-loader.gif" id="remove-img' . $row['id'] . '" style="display:none;"> ' . $edit . '  <a class="btn btn-primary" href="javascript:void(0)" onclick="taskAction(\'task\',' . $row['id'] . ',\'removeTask\')">' . $delete . '</a></div>';
            }
            $html.='</div>
			  <div class="col-xs-5">
				' . $actionbutton . '
			  </div>
			</div>
		  </div>
		  <!-- /.row -->';
            $bidQuery = mysql_query("SELECT a.task_id,a.tasker_id,a.amount,a.message,a.status,b.fname,b.lname,b.image,b.likes,b.dislikes,b.linkedin,b.contact,b.email,b.about_me FROM bids as a LEFT JOIN members as b ON a.tasker_id=b.id WHERE task_id='" . $row['id'] . "' and a.status!='3'");
            while ($bidResult = mysql_fetch_array($bidQuery)) {
                $a++;
                $abc++;
                $publishablekey1 = mysql_query("select * from stripecredentials where id ='1'");
                $presult1 = mysql_fetch_array($publishablekey1);
                //$query = mysql_query("select * from taskerdetails where userid ='" . $_SESSION['userid'] . "' && secretkey='" . $presult1['secretkey'] . "'");
                $query = mysql_query("select * from taskerdetails where userid ='" . $_SESSION['userid'] . "' && cardid !='' && secretkey='" . $presult1['secretkey'] . "'");
                $cust = mysql_fetch_array($query);

                if (mysql_num_rows($query) > 0) {

                    $amnt = $bidResult['amount'] * 100;
                    $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;">  &nbsp;';

                    $hireStatus.='<form action="charge.php" method="POST" style="float:left;">
			         <input type="hidden" name="taskerid" id="taskerid" value="' . $bidResult['tasker_id'] . '">
		                 <input type="hidden" name="taskid" id="taskid" value="' . $bidResult['task_id'] . '">
		                 <input type="hidden" name="action" id="action" value="hireBid">
		                 <input type="hidden" name="pageno" id="pageno" value="' . $PageNo . '">
		                 <input type="hidden" name="amount" value="' . $amnt . '"> 
		                 <input type="hidden" name="customerid" value="' . $cust['customerid'] . '">
		                 <input type="submit" id="a-hire' . $bidResult['tasker_id'] . '" value="Hire" class="btn btn-primary">  
			               </form>		
			 <a class="btn btn-primary" id="a-remove' . $bidResult['tasker_id'] . '" href="javascript:void(0)" onclick="rejectSingleBid(' . $bidResult['tasker_id'] . ',' . $bidResult['task_id'] . ',' . $PageNo . ')">Reject</span></a>';
                } else {



                    /* $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img'.$bidResult['tasker_id'].'" style="display:none;">  &nbsp;<a class="btn btn-primary" id="a-hire'.$bidResult['tasker_id'].'" href="javascript:void(0)" onclick="hireTask('.$bidResult['tasker_id'].','.$bidResult['task_id'].',\'hireBid\','.$PageNo.')">Hire </span></a> <a class="btn btn-primary" id="a-remove'.$bidResult['tasker_id'].'" href="javascript:void(0)" onclick="rejectSingleBid('.$bidResult['tasker_id'].','.$bidResult['task_id'].','.$PageNo.')">Reject</span></a>';
                     */

                    $amnt = $bidResult['amount'] * 100;

                    $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;">  &nbsp; <a style="float:right;margin-left:14px;" class="btn btn-primary" id="a-remove' . $bidResult['tasker_id'] . '" href="javascript:void(0)" onclick="rejectSingleBid(' . $bidResult['tasker_id'] . ',' . $bidResult['task_id'] . ',' . $PageNo . ')">Reject</span></a> &nbsp;
			 	<button onclick="status_set(' . $a . ')" class="btn btn-primary customButton" > Hire </button>
                              
                                <form action="charge.php" method="POST" id="chargeform' . $abc . '">
			         <input type="hidden" name="taskerid" id="taskerid" value="' . $bidResult['tasker_id'] . '">
		                 <input type="hidden" name="taskid" id="taskid" value="' . $bidResult['task_id'] . '">
		                 <input type="hidden" name="action" id="action" value="hireBid">
		                 <input type="hidden" name="pageno" id="pageno" value="' . $PageNo . '">
		                 <input type="hidden" name="amount" value="' . $amnt . '"> 
		                 <input type="hidden" name="customerid" value="' . $cust['customerid'] . '">
		                 </form>	

                <script>
                 
                  var handler = StripeCheckout.configure({
                    key:"' . $presult1["publishablekey"] . '",
                    token: function(token) {
                     
                       $.ajax({
	                url:"connect1.php",
	                type:"POST",
	                data: {token:token.id,userid:' . $_SESSION['userid'] . '},
	                success:function(msg){ 	
	                     //  alert("' . $a . '");
		               $("#"+$("#clickformid").html()).submit();
	                }
	
	
	                });                      
                    }
                  });

                  $(".customButton").on("click", function(e) {
                    // Open Checkout with further options
			$("#clickformid").html($(this).next("form").attr("id"));
                    handler.open({
                        amount: ' . $amnt . '
                    });
                    e.preventDefault();
                  });

                  // Close Checkout on page navigation
                  $(window).on("popstate", function() {
                    handler.close();
                  });
                </script> ';
                }
                $name = $bidResult['fname'] . ' ' . $bidResult['lname'];
                $image = $bidResult['image'];
                $image = $image == '' ? 'upload/noprofile.jpg' : 'upload/' . $image;
                if ($bidResult['status'] == 1) {
                    //echo "SELECT status FROM satisfiedstatus WHERE bid_id='".$bidResult['task_id']."' AND tasker_id='".$bidResult['tasker_id']."'";
                    $likeQuery = mysql_query("SELECT status FROM satisfiedstatus WHERE bid_id='" . $bidResult['task_id'] . "' AND tasker_id='" . $bidResult['tasker_id'] . "'");
                    $find = mysql_num_rows($likeQuery);
                    if ($find == 0) {
                        $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;">  &nbsp;<a  onclick="satisfiedAction4(' . $bidResult['task_id'] . ',' . $bidResult['tasker_id'] . ',1,' . $PageNo . ')" href="javascript:void(0)" id="like' . $bidResult['tasker_id'] . '" class="btn btn-primary">Satisfied</a> 
		<input type="hidden" value="' . $bidResult['task_id'] . '" id="transfersattaskid">
		<input type="hidden" value="' . $bidResult['tasker_id'] . '" id="transfersattaskerid">
		<input type="hidden" value="1" id="transfersataction">
		<input type="hidden" value="' . $PageNo . '" id="transfersatpageno">
					
					
	<a onclick="satisfiedAction5(' . $bidResult['task_id'] . ',' . $bidResult['tasker_id'] . ',0,' . $PageNo . ')" href="javascript:void(0)" id="dislike' . $bidResult['tasker_id'] . '" class="btn btn-primary">Disatisfied</a>
	
	        <input type="hidden" value="' . $bidResult['task_id'] . '" id="transferdistaskid">
		<input type="hidden" value="' . $bidResult['tasker_id'] . '" id="transferdistaskerid">
		<input type="hidden" value="0" id="transferdisaction">
		<input type="hidden" value="' . $PageNo . '" id="transferdispageno">';
                        //$amnt = $bidResult['amount']*100;
                        //$amnt = ($bidResult['amount']-($bidResult['amount']*(15/100)));
                        //$amnt = ($bidResult['amount']-($bidResult['amount']*(15/100)));
                        $data = mysql_query("SELECT * FROM bids WHERE task_id='" . $bidResult['task_id'] . "' AND tasker_id='" . $bidResult['tasker_id'] . "'");
                        //echo "SELECT * FROM bids WHERE task_id='" . $bidResult['task_id'] . "' AND tasker_id='" . $bidResult['tasker_id'] . "'";

                        $rec = mysql_fetch_array($data);
                        $amnt = $rec['firstamnt'] * 100;

                        $taskid = $bidResult['task_id'];
                        $taskerid = $bidResult['tasker_id'];
                        $hireStatus.= '
<form action="satisfied.php" id="transferform" method="post" style="float:right; display:none;">
<input type="hidden" name="amount" value="' . $amnt . '" >
<input type="hidden" name="taskid" value="' . $taskid . '" >
<input type="hidden" name="taskerid" value="' . $taskerid . '" > 
<input type="submit" id="trans" name="submit" class="btn btn-primary" value="Payment"> </form>

<form action="dissatisfied.php" id="transferform" method="post" style="float:right; display:none;">
<input type="hidden" name="amount" value="' . $amnt . '" >
<input type="hidden" name="taskid" value="' . $taskid . '" >
<input type="hidden" name="taskerid" value="' . $taskerid . '" >
<input type="submit" id="transdis" name="submit" class="btn btn-primary" value="Payment"> </form>
';
                    } else {
                        //echo $find = mysql_num_rows($likeQuery);
                        $likeResult = mysql_result($likeQuery, 0);
                        //echo 'd'.$likeQuery['status'];
                        if ($likeResult == '0') {
                            $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;"> &nbsp;<a href="javascript:void(0)" class="btn btn-primary" style="background-color:#3071A9;color:#fff;">Disatisfied</a>';
                        } else {
                            // <a class="btn btn-primary" id="a-remove'.$bidResult['tasker_id'].'" href="javascript:void(0)" onclick="rejectSingleBid('.$bidResult['tasker_id'].','.$bidResult['task_id'].','.$PageNo.')">Reject</span></a>
                            $hireStatus = '<img src="images/ajax-loader.gif" id="hire-img' . $bidResult['tasker_id'] . '" style="display:none;"> &nbsp;<a href="javascript:void(0)" class="btn btn-primary" style="background-color:#3071A9;color:#fff;">Satisfied</a>';
                        }
                    }
                }
                $html.='
		  <hr>
		  <!-- Project Two -->
		  <div class="row" style="overflow:hidden">
			<div id="" class="col-md-12">
			  <div class="col-xs-3" id="roded">  <img class="img-responsive" src="' . $image . '" alt="">  </div>
			  <div class="col-xs-8" id="white1">
				<div class="innp">
				  <h4 class="hgr1">' . $name . '</h4>
				  <p style="word-wrap: break-word;"><a href="http://' . $bidResult['linkedin'] . '">' . $bidResult['linkedin'] . '</a></p>
				  <p><font size="5">$' . $bidResult['amount'] . '</font> &nbsp; <span class="dll" id="likeheart' . $bidResult['tasker_id'] . '"> ' . $bidResult['likes'] . ' </span> &nbsp; <span class="dll_dark" id="dislikeheart' . $bidResult['tasker_id'] . '"> ' . $bidResult['dislikes'] . ' </span></p>
				<p>Contact : ' . $bidResult['contact'] . '</p><p>Email : ' . $bidResult['email'] . '</p>';

                if ($bidResult['message'] != '')
                    $html.='<p>Message: ' . $bidResult['message'] . '</p>';
                if ($bidResult['about_me'] != '')
                    $html.='<p>&nbsp;</p><p ><b>About me: </b>
                                         <div style="float:left;width:100%"><p style="text-align: justify; height: 20px; overflow: hidden; float: left; width: 313px;" id="about_p_' . $a . '">' . $bidResult['about_me'] . '</p>
                                             <a style="float: left; margin-left: 2px; text-decoration: none; font-size: 20px; margin-top: -5px;" id="click_' . $a . '" onclick="read_more(' . $a . ');" href="javascript:void(0);">(+)</a></div>
                                             <!--<a target="_blank" href="/about_me.php?id=' . $bidResult['tasker_id'] . '">Read More</a>--></p>';
                $html.='</div>';

                if ($row['refund'] != '1') {
                    $html.='<div class="rhtyi"> ' . $hireStatus . ' </div>';
                }

                //<div class="rhtyi"> ' . $hireStatus  . ' cb </div>
                $html.='</div>
                              


			</div>
		  </div>';
            }
            $html.='</div>';
        }
    }
    $html.='</div>';
    // end requets listing here
    //pagination for the page
    $html .= '<div class="pagination" style="margin:10px 2.5% 20px;float:right;">';
    $html .= $Paging->showNavigation();
    $html .= '</div></div>';

    //end pagination
} else {
    // if there is no record , will be diplayed this.
    $html = '<div class="no-record" style="width:98%;margin:0 auto;">No Request found yet...</div>';
    //end
}
echo $html;
?>

<hr>
<?php
// bottom part of the page
include_once "include/footer.php";
// end here
?>
