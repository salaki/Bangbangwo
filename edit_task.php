<?php 
// top part of the page
include_once "include/header.php";
// ends top part

include_once "include/config.php";
session_start();


// code for edit task, related to any type
if(isset($_GET['id']))
{
	$result = mysql_fetch_assoc(mysql_query("SELECT * FROM tasks WHERE id='".$_GET['id']."' AND userid='".$_SESSION['userid']."'"));
	$tdisplay = 'style="display:none;"';
	$mdisplay = 'style="display:none;"';
	$hdisplay = 'style="display:none;"';
	$tutoring = 'style="display:none;"';
	$general = 'style="display:none;"';
	$dt = explode(' ',$result['taskdate']);
	$date = $dt[0];
	$time = $dt[1];
	switch($result['tasktype'])
	{
		case 'transportation':
			$tdisplay = 'style="display:block;"';
		break;
		case 'movinghelp':
			$mdisplay = 'style="display:block;"';
		break;
		case 'handy man':
			$hdisplay = 'style="display:block;"';
		break;
		case 'tutoring':
			$tutoring = 'style="display:block;"';
		break;
		case 'general':
			$general = 'style="display:block;"';
		break;
	}
}

?>
  
  <!-- Project One -->
  <div class="row" id="con1">
    <div class="col-md-12">
    <h4 class="hdg" style="border-bottom:none;line-height: 16px;">Post A Request:</h4>
     <hr class="clr" style=" margin: 16px 0 13px;">
     </div>
     <div class="col-md-12">
     
     <div class="tccont5">
      <div class="col-xs-4">
      <ul class="icg">
     <li <?=$tdisplay;?>><span style="background:url(images/trc.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-1');" class="task">Transportation</a></span></li>
     <li <?=$mdisplay;?>><span style="background:url(images/manui.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-2');" class="task">Moving Help</a></span></li>
     <li <?=$hdisplay;?>><span style="background:url(images/waliy.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-3');" class="task">Handy Man</a></span></li>
     <li <?=$tutoring;?>><span style="background:url(images/tutio.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-4');" class="task">Tutoring</a></span></li>
     <li <?=$general;?>><span style="background:url(images/tutio.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-5');" class="task">General</a></span></li>
	 <!--<li><span style="background:url(images/info.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="">Information</a></span></li>-->
 </ul>
      </div>
      <div class="col-xs-8" id="tskfrm-1" <?=$tdisplay;?>>
			<form action="" method="get" id="frm89" onsubmit="return updateTask('frm89','89')">
			<table width="" border="0" class="col-xs-8">
			  <tr>
				<td width="92">Task Name</td>
				<td width="300"><input name="tname" type="text" value="<?=$result['taskname'];?>" placeholder=""></td>
			  </tr>
			  <tr>
				<td width="92">From</td>
				<td width="300"><input name="tfrom" type="text" value="<?=$result['taskfrom'];?>" placeholder=""></td>
			  </tr>
			  <tr>
				<td width="92">To</td>
				<td width="300"><input name="tto" type="text" value="<?=$result['taskto'];?>" placeholder=""></td>
			  </tr>
			  <tr>
				<td width="92">Time</td>
				<td width="300"><input name="tdate" editable id="datepicker3" type="text" value="<?=$date?>" id="datepicker" placeholder="" class="tmn"><input name="ttime" id="stepExample3" type="text" value="<?=$time;?>" placeholder="" class="tmn2"></td>
			  </tr>
			  <tr>
				<td width="92">People</td>
				<td width="300"><input name="tpeople" type="text" value="<?=$result['people'];?>" placeholder="" class="bid-amount"></td>
			  </tr>
			  <tr>
				<td width="92">Other</td>
				<td width="300"><input name="tother" type="text" value="<?=$result['other'];?>" placeholder=""></td>
			  </tr>
			 <tr style="display:None">
				<td width="92">Task Type</td>
				<td width="300"><input type="radio" value="0" name="multi" id="single1" style="width:10px;" <?php if($result['taskmulti'] == 0) echo 'checked="checked"'; ?>><label for="single1">Single Tasker</label> <input type="radio" value="1" name="multi" id="multi1" style="width:10px;" <?php if($result['taskmulti'] == 1) echo 'checked="checked"'; ?>><label for="multi1">Multiple Taskers</label></td>
			  </tr>
			   <tr>
				<td width="92"></td>
			   <td><input name="submit" type="submit" value="Update" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img89" style="display:none;"><input type="hidden" name="id" value="<?=$_GET['id'];?>"><input type="hidden" name="ttype" value="transportation"></td>
			  </tr>
			  
			</table>

			</form>
      </div>
	  <div class="col-xs-8" id="tskfrm-2" <?=$mdisplay;?>>
			<form action="" method="get" class="frm89" id="frm90" onsubmit="return updateTask('frm90','90')">
			<table width="" border="0" class="col-xs-8">
			  <tr>
				<td width="92">Task Name</td>
				<td width="300"><input name="tname" type="text" value="<?=$result['taskname'];?>" placeholder=""></td>
			  </tr>
			  <tr>
				<td width="92">From</td>
				<td width="300"><input name="tfrom" type="text" value="<?=$result['taskfrom'];?>" placeholder=""></td>
			  </tr>
			  <tr>
				<td width="92">To</td>
				<td width="300"><input name="tto" type="text" value="<?=$result['taskto'];?>" placeholder=""></td>
			  </tr>
			  <tr>
				<td width="92">Time</td>
				<td width="300"><input name="tdate" editable id="datepicker2" type="text" value="<?=$date;?>" placeholder="" class="tmn"><input type="hidden" name="id" value="<?=$_GET['id'];?>"><input name="ttime" id="stepExample2" type="text" value="<?=$time?>" placeholder="" class="tmn2"></td>
			  </tr>
			  <tr>
				<td width="92">Duration (hrs)</td>
				<td width="300"><input name="tduration" type="text" value="<?=$result['taskduration'];?>" placeholder=""></td>
			  </tr>
			  <tr>
				<td width="92">Description</td>
				<td width="300"><input name="tdescription" type="text" value="<?=$result['taskdescription'];?>" placeholder=""></td>
			  </tr>
			  <tr style="display:None">
				<td width="92">Task Type</td>
				<td width="300"><input type="radio" value="0" name="multi" id="single1" style="width:10px;" <?php if($result['taskmulti'] == 0) echo 'checked="checked"'; ?>><label for="single1">Single Tasker</label> <input type="radio" value="1" name="multi" id="multi1" style="width:10px;" <?php if($result['taskmulti'] == 1) echo 'checked="checked"'; ?>><label for="multi1">Multiple Taskers</label></td>
			  </tr>
			   <tr>
				<td width="92"></td>
			   <td><input name="submit" type="submit" value="Update" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img90" style="display:none;"><input type="hidden" name="ttype" value="movinghelp"></td>
			  </tr>
			  
			</table>

			</form>
      </div>
	        <div class="col-xs-8" id="tskfrm-3" <?=$hdisplay;?>>
			<form action="" method="get" class="frm89" id="frm91" onsubmit="return updateTask('frm91','91')">
			<table width="" border="0" class="col-xs-8">
			  <tr>
				<td width="92">Task Name</td>
				<td width="300"><input name="tname" type="text" value="<?=$result['taskname'];?>" placeholder=""></td>
			  </tr>
			  <tr>
				<td width="92">Location</td>
				<td width="300"><input name="tlocation" type="text" value="<?=$result['tasklocation'];?>" placeholder=""></td>
			  </tr>
			  
			  <tr>
				<td width="92">Time</td>
				<td width="300"><input name="tdate" editable id="datepicker1" type="text" value="<?=$date;?>" placeholder="" class="tmn"><input name="ttime" id="stepExample1" type="text" value="<?=$time?>" placeholder="" class="tmn2"></td>
			  </tr>
			  <tr>
				<td width="92">Description</td>
				<td width=""><textarea name="tdescription" cols="" rows="" placeholder=""><?=$result['taskdescription'];?></textarea></td>
			  </tr>
			  <tr style="display:None">
				<td width="92">Task Type</td>
				<td width="300"><input type="radio" value="0" name="multi" id="single1" style="width:10px;" <?php if($result['taskmulti'] == 0) echo 'checked="checked"'; ?>><label for="single1">Single Tasker</label> <input type="radio" value="1" name="multi" id="multi1" style="width:10px;" <?php if($result['taskmulti'] == 1) echo 'checked="checked"'; ?>><label for="multi1">Multiple Taskers</label></td>
			  </tr>
			   <tr>
				<td width="92"></td>
			   <td><input name="submit" type="submit" value="Update" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img91" style="display:none;"><input type="hidden" name="id" value="<?=$_GET['id'];?>"><input type="hidden" name="ttype" value="handy man"></td>
			  </tr>
			  
			</table>

			</form>
      </div>
		      <div class="col-xs-8" id="tskfrm-4" <?=$tutoring;?>>
			<form action="" method="get" id="frm92" class="frm89" onsubmit="return updateTask('frm92','92')">
			<table width="" border="0" class="col-xs-8">
			  <tr>
				<td width="92">Task Name</td>
				<td width="300"><input name="tname" type="text" value="<?=$result['taskname'];?>" placeholder=""></td>
			  </tr>
			  <tr>
				<td width="92">Location</td>
				<td width="300"><input name="tlocation" type="text" value="<?=$result['tasklocation'];?>" placeholder=""></td>
			  </tr>
			  
			  <tr>
				<td width="92">Time</td>
				<td width="300"><input name="tdate" editable id="datepicker" type="text" value="<?=$date;?>" placeholder="" class="tmn"><input name="ttime" id="stepExample" type="text" value="<?=$time?>" placeholder="" class="tmn2"></td>
			  </tr>
			  <tr>
				<td width="92">Description</td>
				<td width=""><textarea name="tdescription" cols="" rows="" placeholder=""><?=$result['taskdescription'];?></textarea></td>
			  </tr>
			  <tr style="display:None">
				<td width="92">Task Type</td>
				<td width="300"><input type="radio" value="0" name="multi" id="single1" style="width:10px;" <?php if($result['taskmulti'] == 0) echo 'checked="checked"'; ?>><label for="single1">Single Tasker</label> <input type="radio" value="1" name="multi" id="multi1" style="width:10px;" <?php if($result['taskmulti'] == 1) echo 'checked="checked"'; ?>><label for="multi1">Multiple Taskers</label></td>
			  </tr>
			   <tr>
				<td width="92"></td>
			   <td><input name="submit" type="submit" value="Update" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img92" style="display:none;"><input type="hidden" name="id" value="<?=$_GET['id'];?>"><input type="hidden" name="ttype" value="tutoring"></td>
			  </tr>
			  
			</table>

			</form>
      </div>
		<div class="col-xs-8" id="tskfrm-5" <?=$general;?>>
			<form action="" method="get" id="frm93" class="frm89" onsubmit="return updateTask('frm93','93')">
			<table width="" border="0" class="col-xs-8">
			  <tr>
				<td width="92">Task Name</td>
				<td width="300"><input name="tname" type="text"  value="<?=$result['taskname'];?>"></td>
			  </tr>
			  <tr>
				<td width="92">Location</td>
				<td width="300"><input name="tlocation" type="text"  value="<?=$result['tasklocation'];?>"></td>
			  </tr>
			  
			  <tr>
				<td width="92">Time</td>
				<td width="300"><input name="tdate" editable type="text" id="datepicker4" value="<?=$date;?>" class="tmn"><input name="ttime" id="stepExample4" type="text" value="<?=$time?>"  class="tmn2"></td>
			  </tr>
			  <tr>
				<td width="92">Description</td>
				<td width=""><textarea name="tdescription" cols="" rows=""><?=$result['taskdescription'];?></textarea></td>
			  </tr>
			  <tr style="display:None">
				<td width="92">Task Type</td>
				<td width="300"><input type="radio" value="0" name="multi" id="single1" style="width:10px;" <?php if($result['taskmulti'] == 0) echo 'checked="checked"'; ?>><label for="single1">Single Tasker</label> <input type="radio" value="1" name="multi" id="multi1" style="width:10px;" <?php if($result['taskmulti'] == 1) echo 'checked="checked"'; ?>><label for="multi1">Multiple Taskers</label></td>
			  </tr>
			   <tr>
				<td width="92"></td>
			   <td><input name="submit" type="submit" value="Update" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img93" style="display:none;"><input type="hidden" name="id" value="<?=$_GET['id'];?>"><input type="hidden" name="ttype" value="general"></td>
			  </tr>
			  
			</table>

			</form>
      </div>
    </div>
  </div>
  <!-- /.row -->
  

  
</div>
<?php // bottom starts here
include_once "include/footer.php";
// bottom ends here

;?>
<script>
$('.task').click(function(){
$('.task').parent('span').parent('li').css('background-color','#f4f5f5');
$(this).parent('span').parent('li').css('background-color','#e0e0e0');
	


});
</script>