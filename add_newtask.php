<?php include_once "include/header.php";
$mh = 'display:none;';
$hm = 'display:none;';
$tr = 'display:none;';
$tt = 'display:block;';
$ttd = 'background-color: rgb(224, 224, 224);';
if(isset($_GET['movinghelp']))
{
	$mh = 'display:block;';
	$tt = 'display:none;';
	$mhd = 'background-color: rgb(224, 224, 224);';
	$ttd = 'background-color: none';
}
if(isset($_GET['handyman']))
{
	$hm = 'display:block;';
	$tt = 'display:none;';
	$hmd = 'background-color: rgb(224, 224, 224);';
	$ttd = 'background-color: none';
}
if(isset($_GET['tutoring']))
{
	$tr = 'display:block;';
	$tt = 'display:none;';
	$trd = 'background-color: rgb(224, 224, 224);';
	$ttd = 'background-color: none';
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
     <li style="<?=$ttd;?>"><span style="background:url(images/trc.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-1');" class="task">Transportation</a></span></li>
     <li style="<?=$mhd;?>"><span style="background:url(images/manui.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-2');" class="task">Moving Help</a></span></li>
     <li style="<?=$hmd;?>"><span style="background:url(images/waliy.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-3');" class="task">Handy Man</a></span></li>
     <li style="<?=$trd;?>"><span style="background:url(images/tutio.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-4');" class="task">Tutoring</a></span></li>
	 <li><span style="background:url(images/home_icon_.png) no-repeat left;background-size:33px 24px;background-position:4px 10px;" class="navicns"><a href="javascript:void(0)" onclick="showForm('tskfrm-5');" class="task">General</a></span></li>
     <!--<li><span style="background:url(images/info.png) no-repeat left;" class="navicns"><a href="javascript:void(0)" onclick="">Information</a></span></li>-->
 </ul>
      </div>
      
      
      <div class="col-xs-8" id="tskfrm-1" style="<?=$tt;?>">
			<form action="" method="get" id="frm89" onsubmit="return submitTask('frm89','89')">
            
            <div class="row">
            	<div class="col-lg-3"><strong>Task Name</strong></div>
                <div class="col-lg-9"><input name="tname" type="text" value="" placeholder="" maxlength="40"></div>
            </div>
            <div class="row">
            	<div class="col-lg-3"><strong>From</strong></div>
                <div class="col-lg-9"><input name="tfrom" type="text" value="" placeholder=""></div>
            </div>
            <div class="row">
            	<div class="col-lg-3"><strong>To</strong></div>
                <div class="col-lg-9"><input name="tto" type="text" value="" placeholder=""></div>
            </div>
            <div class="row">
            	<div class="col-lg-3"><strong>Time</strong></div>
                <div class="col-lg-9"><div class="col-lg-6 nopadding"><input name="tdate" type="text" value="" id="datepicker" placeholder="YYYY-MM-DD" class="tmn"></div><div class="col-lg-6 nopadding"><input name="ttime" type="text" value="" id="stepExample" placeholder="HH:MM" class="tmn2" data-mask="00:00"></div></div>
            </div>
            <div class="row">
            	<div class="col-lg-3"><strong>People</strong></div>
                <div class="col-lg-9"><input name="tpeople" type="text" value="" placeholder="0" class="bid-amount"></div>
            </div>
            
            <div class="row">
            	<div class="col-lg-3"><strong>Other</strong></div>
                <div class="col-lg-9"><input name="tother" type="text" value="" placeholder="(Optional)"></div>
            </div>
            
            <div class="row">
            	<div class="col-lg-3"><strong>Task Type</strong></div>
                <div class="col-lg-9"><div class="col-lg-6 nopadding"><input type="radio" value="0" name="multi" id="single1" style="width:10px;" checked="checked"><label for="single1">Single Tasker</label> </div><div class="col-lg-6 nopadding"><input type="radio" value="1" name="multi" id="multi1" style="width:10px;"><label for="multi1">Multiple Taskers</label></div></div>
            </div>
            
            <div class="row">
            	<div class="col-lg-3">&nbsp;</div>
                <div class="col-lg-9"><input name="submit" type="submit" value="Submit" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img89" style="display:none;"><input type="hidden" name="ttype" value="transportation"></div>
            </div>
            
            
            
            
            
            
			

			</form>
      </div>
      
      
	  <div class="col-xs-8" id="tskfrm-2" style="<?=$mh;?>">
			<form action="" method="get" class="frm89" id="frm90" onsubmit="return submitTask('frm90','90')">
            
            	<div class="row">
            		<div class="col-lg-3"><strong>Task Name</strong></div>
               		<div class="col-lg-9"><input name="tname" type="text" value="" placeholder="" maxlength="40"></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>From</strong></div>
               		<div class="col-lg-9"><input name="tfrom" type="text" value="" placeholder=""></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>To</strong></div>
               		<div class="col-lg-9"><input name="tto" type="text" value="" placeholder=""></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Time</strong></div>
               		<div class="col-lg-9"><div class="col-lg-6 nopadding"><input name="tdate" type="text" id="datepicker1" value="" placeholder="YYYY-MM-DD" class="tmn"></div><div class="col-lg-6 nopadding"><input name="ttime" id="stepExample1" type="text" value="" placeholder="HH:MM" class="tmn2"  data-mask="00:00"></div></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Duration</strong></div>
               		<div class="col-lg-9"><input name="tduration" type="text"  placeholder="(hrs)"></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Description</strong></div>
               		<div class="col-lg-9"><input name="tdescription" type="text"  placeholder="(Optional)" maxlength="300"></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Task Type</strong></div>
               		<div class="col-lg-9"><div class="col-lg-6 nopadding"><input type="radio" value="0" name="multi" id="single2" style="width:10px;" checked="checked"><label for="single2">Single Tasker</label></div><div class="col-lg-6 nopadding"><input type="radio" value="1" name="multi" id="multi2" style="width:10px;"><label for="multi2">Multiple Taskers</label></div></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>&nbsp;</strong></div>
               		<div class="col-lg-9"><input name="submit" type="submit" value="Submit" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img90" style="display:none;"><input type="hidden" name="ttype" value="movinghelp"></div>
            	</div>
            
            
            
            
			

			</form>
      </div>
      
      
      
	  <div class="col-xs-8" id="tskfrm-3" style="<?=$hm;?>">
			<form action="" method="get" class="frm89" id="frm91" onsubmit="return submitTask('frm91','91')">
            
            	<div class="row">
            		<div class="col-lg-3"><strong>Task Name</strong></div>
               		<div class="col-lg-9"><input name="tname" type="text" value="" placeholder="" maxlength="40"></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Location</strong></div>
               		<div class="col-lg-9"><input name="tlocation" type="text" value="" placeholder=""></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Time</strong></div>
               		<div class="col-lg-9"><div class="col-lg-6 nopadding"><input name="tdate" type="text" id="datepicker2" value="" placeholder="YYYY-MM-DD" class="tmn"></div><div class="col-lg-6 nopadding"><input name="ttime" id="stepExample2" type="text" value="" placeholder="HH:MM" class="tmn2"  data-mask="00:00"></div></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Description</strong></div>
               		<div class="col-lg-9"><textarea name="tdescription" cols="" rows="" placeholder="(Optional)" maxlength="300"></textarea></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Task Type</strong></div>
               		<div class="col-lg-9"><div class="col-lg-6 nopadding"><input type="radio" value="0" name="multi" id="single3" style="width:10px;" checked="checked"><label for="single3">Single Tasker</label></div><div class="col-lg-6 nopadding"><input type="radio" value="1" name="multi" id="multi3" style="width:10px;"><label for="multi3">Multiple Taskers</label></div></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>&nbsp;</strong></div>
               		<div class="col-lg-9"><input name="submit" type="submit" value="Submit" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img91" style="display:none;"><input type="hidden" name="ttype" value="handy man"></div>
            	</div>
            
            
            
			

			</form>
      </div>
      
      
      
	  <div class="col-xs-8" id="tskfrm-4" style="<?=$tr;?>">
			<form action="" method="get" id="frm92" class="frm89" onsubmit="return submitTask('frm92','92')">
            
            	<div class="row">
            		<div class="col-lg-3"><strong>Task Name</strong></div>
               		<div class="col-lg-9"><input name="tname" type="text" value="" placeholder="" maxlength="40"></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Location</strong></div>
               		<div class="col-lg-9"><input name="tlocation" type="text" value="" placeholder=""></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Time</strong></div>
               		<div class="col-lg-9"><div class="col-lg-6 nopadding"><input name="tdate" type="text" id="datepicker3" value="" placeholder="YYYY-MM-DD" class="tmn"></div><div class="col-lg-6 nopadding"><input name="ttime" id="stepExample3" type="text" value="" placeholder="HH:MM" class="tmn2"  data-mask="00:00"></div></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Description</strong></div>
               		<div class="col-lg-9"><textarea name="tdescription" cols="" rows="" placeholder="(Optional)" maxlength="300"></textarea></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Task Type</strong></div>
               		<div class="col-lg-9"><div class="col-lg-6 nopadding"><input type="radio" value="0" name="multi" id="single4" style="width:10px;" checked="checked"><label for="single4">Single Tasker</label> </div><div class="col-lg-6 nopadding"><input type="radio" value="1" name="multi" id="multi4" style="width:10px;"><label for="multi4">Multiple Taskers</label></div></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>&nbsp;</strong></div>
               		<div class="col-lg-9"><input name="submit" type="submit" value="Submit" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img92" style="display:none;"><input type="hidden" name="ttype" value="tutoring"></div>
            	</div>
            
            
            
            
			

			</form>
      </div>
      
      
      
	  <div class="col-xs-8" id="tskfrm-5" style="display:none;">
			<form action="" method="get" id="frm93" class="frm89" onsubmit="return submitTask('frm93','93')">
            
            	<div class="row">
            		<div class="col-lg-3"><strong>Task Name</strong></div>
               		<div class="col-lg-9"><input name="tname" type="text" value="" placeholder="" maxlength="40"></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Location</strong></div>
               		<div class="col-lg-9"><input name="tlocation" type="text" value="" placeholder=""></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Time</strong></div>
               		<div class="col-lg-9"><div class="col-lg-6 nopadding"><input name="tdate" type="text" id="datepicker4" value="" placeholder="YYYY-MM-DD" class="tmn"></div><div class="col-lg-6 nopadding"><input name="ttime" id="stepExample4" type="text" value="" placeholder="HH:MM" class="tmn2"  data-mask="00:00"></div></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Description</strong></div>
               		<div class="col-lg-9"><textarea name="tdescription" cols="" rows="" placeholder="(Optional)" maxlength="300"></textarea></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>Task Type</strong></div>
               		<div class="col-lg-9"><div class="col-lg-6 nopadding"><input type="radio" value="0" name="multi" id="single5" style="width:10px;" checked="checked"><label for="single5">Single Tasker</label></div><div class="col-lg-6 nopadding"><input type="radio" value="1" name="multi" id="multi5" style="width:10px;"><label for="multi5">Multiple Taskers</label></div></div>
            	</div>
                
                <div class="row">
            		<div class="col-lg-3"><strong>&nbsp;</strong></div>
               		<div class="col-lg-9"><input name="submit" type="submit" value="Submit" class="sbtbtns">&nbsp; <img src="images/ajax-loader.gif" id="hire-img93" style="display:none;"><input type="hidden" name="ttype" value="general"></div>
            	</div>
            
            
            
            
			

			</form>
      </div>
      
      <div class="clearfix"></div>
    </div>
  </div>
  <!-- /.row -->
  

  
</div>
<?php include_once "include/footer.php";?>
<script>
$('.task').click(function(){
$('.task').parent('span').parent('li').css('background-color','#f4f5f5');
$(this).parent('span').parent('li').css('background-color','#e0e0e0');
	


});
</script>