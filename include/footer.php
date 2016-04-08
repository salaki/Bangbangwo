  <!-- Footer// common file for the site, all the footer part's code in this file. This is included on every page -->
  
</div>
<div id="frgt" style="position: absolute;display:none; width: 50%; left: 25%; top: -50%; z-index: 10; min-height: 275px; border-radius: 10px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 2px solid rgb(41, 128, 185);">
  <div style="float:left;text-align:right;width:65%"><h3>Change Password</h3></div><div style="text-align:right;padding-right:10px;font-size:25px;cursor:pointer;"><span onclick="$('#frgt').animate({'top':'-50%'}).hide();">x</span></div>
	<div style="clear:both;"></div>
	<form id="" class="loginfrm" method="POST" action="" onsubmit="if($('#pass').val() =='' || $('#pass').val().length < 6){ $('#pass').css('border','1px solid red');$('#email-msg').show(); return false;}">
		 <label class="lbl" style="float:left;">New Password</label><div style="32px 10px 0px" id="email-msg" class="err-msg err-msg-new">Password must be 6 charcters</div>
		 <input type="password" style="" class="female" id="pass" name="passchange">
             
		 <input type="submit" class="btn1" value="Update" name="submit">
	 </form>
  
  </div>
  
 </div>
 </div>
<footer>
<div class="container">
    <div class="row">
      <div class="col-lg-12">
      <div class="ftinner">
      <div class="col-xs-9">
      <ul>
      <li><a href="aboutus"><font color="#fff">About Us</font></a></li>
      <li><a href="feedback"><font color="#fff">Feedback</font></a></li>
      <!--<li><a href="blog"><font color="#fff">Blog</font></a></li>-->
      <li><a href="terms"><font color="#fff">Terms & Privacy</font></a></li>
      </ul>
      </div>
     <!-- <div class="col-xs-3" id="roded11"><p>Follow Us! We're friendly<span class="scion"><img class="img-responsive" src="images/iconsft.png" alt=""></span></p></div>-->
      </div>
        
      </div>
    </div>
    <!-- /.row --> 
    </div>
  </footer>
<!-- /.container --> 
<!-- jQuery Version 1.11.0 --> 
<script src="js/jquery-1.11.0.js"></script> 
<script src="js/bootstrap.min.js"></script>
<script>function pagingAjax(e, t, n) {
    //showTdiv();
    $.ajax({
        url: t,
        cache: false,
        success: function(e) {
          //  hideTdiv();
            $("#" + n).html(e);
            var body = $("html, body");
            var divTop = ($('#'+n).offset().top)-200;             
            body.animate({scrollTop:divTop}, '500', 'swing', function() { });
//            var t = document.createElement("div");
//            t.innerHTML = "_" + e + "_";
//            execJS(t)
        }
    });
}</script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script type="text/javascript" src="js/jquery.timepicker.js"></script>
   <script type="text/javascript" src="js/jquery.mask.js"></script>
	<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />
  <script>
 $(document).ready(function(){
//Datepicker Popups calender to Choose date
$(function() {
                    $('#stepExample1,#stepExample2,#stepExample3,#stepExample,#stepExample4').timepicker({ 'step': 15,timeFormat: 'H:i'  });
                
                });
 
});
$(document).ready(function () {
  //called when key is pressed in textbox
  
  $(".bid-amount").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        //$("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
});
</script>
<div id="popUp" style="width:100%;height:100%;position:absolute;background:black;z-index:3;top:0;left:0;opacity:0.3;display:none;">
</div>
<div id="popUp-message" style="width: 50%; position: absolute; top: 25%; left: 25%; z-index: 4; background: none repeat scroll 0% 0% rgb(255, 255, 255);padding:20px;display:none;">
	<div style="font-size:20px;line-height:40px;margin-bottom:10px;">You need to complete your profile info in Account before you can be a tasker.</div>
  <ul class="nav navbar-nav" style="margin:0 !important"><li><a href="profile-edit">Complete your phone number</a></li></ul><ul class="nav navbar-nav" style="margin: 0px !important; margin-left:12px !important;"><li><a href="dashboard">Back</a></li></ul>
</div>
</body>
</html>
<?php
 $checkSts_tasker=mysql_fetch_assoc(mysql_query("SELECT contact FROM members where id=".$_SESSION['userid']));
 
    
if(strstr($_SERVER['REQUEST_URI'],'dashboard_tasker') && $checkSts_tasker['contact'] =='')
{
   
	echo '<script>var width = $(window).innerWidth();
		var height = $("html").height();
		$("#popUp").css({"width":width,"height":height}).show();
		$("#popUp-message").show();
               
	</script>';  
        
}
if(isset($date))
{ ?>
	<script>
	$(document).ready(function(){
	var dt = "'.$date.'";
	$(function(){
	$( "#datepicker, #datepicker1, #datepicker2, #datepicker3, #datepicker4" ).datepicker();
	$( "#datepicker, #datepicker1, #datepicker2, #datepicker3, #datepicker4" ).datepicker("option", "dateFormat", "yy-mm-dd");
	$( "#datepicker, #datepicker1, #datepicker2, #datepicker3, #datepicker4" ).datepicker("setDate", new Date(dt) );
	   
	//Pass the user selected date format 
  });
  
	});
	</script>
<?php }
else
{ ?>
	<script>
	$(document).ready(function(){
            $(function(){
            $( "#datepicker, #datepicker1, #datepicker2, #datepicker3, #datepicker4" ).datepicker();
            $( "#datepicker, #datepicker1, #datepicker2, #datepicker3, #datepicker4" ).datepicker("option", "dateFormat", "yy-mm-dd");
            //Pass the user selected date format 
            });
	});
	</script>;
<?php }
?>
