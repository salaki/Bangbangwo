<?php
// top part of page
	include_once "include/header.php";        
        // end top part
        
        
 // Updation for profile 
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['contact']))
	{
		extract($_POST);
		if ((($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/jpg") || ($_FILES["image"]["type"] == "image/png"))) {
			if ($_FILES["image"]["error"] == 0) 
			{
				$arr = explode('.',$_FILES["image"]["name"]);
					move_uploaded_file($_FILES["image"]["tmp_name"],
				  "upload/" . $_SESSION['userid'].'.'.$arr[1]);
				  $image = $_SESSION['userid'].'.'.$arr[1];
				  $array = array("email"=>$email,"otheremail"=>$oemail,"contact"=>$contact,"linkedin"=>$linkedin,'image'=>$image,'type'=>'1',"about_me"=>nl2br($about_me),'major'=>$major,'matriculation'=>$Matriculation,'degree'=>$Degree,'gender'=>$gender);
			}
		}
		else
		{
			$array = array("email"=>$email,"otheremail"=>$oemail,"contact"=>$contact,"linkedin"=>$linkedin,'type'=>'1',"about_me"=>nl2br($about_me),'major'=>$major,'matriculation'=>$Matriculation,'degree'=>$Degree,'gender'=>$gender);
		}
                
                
		$objCommon->updateProfile($array);
		header("location:profile");
	}
	else if(isset($_POST['passchange']) && $_POST['passchange'] != '')
	{
		mysql_query("UPDATE members SET pwd='".$_POST['passchange']."' WHERE id='".$_SESSION['userid']."'");
		echo '<script>alert("Your password has been changed");</script>';
	}
}

$email = $userDetail['email'];
 $oemail = $userDetail['otheremail'];
$contact = $userDetail['contact'];
$linkedin = $userDetail['linkedin'];
$aboutme=$userDetail['about_me'];
$major=$userDetail['major'];
$matriculation=$userDetail['matriculation'];
$degree=$userDetail['degree'];
$gender=$userDetail['gender'];

// End Updation here
?>
  <!-- /.row --> 
  
  <!-- Project One -->
  <div class="row" id="con1">
    <div class="col-md-12">
      
    </div>
  </div>
  <!-- /.row -->
  
  <hr>
  <div class="row" id="con1" style="margin:0;">
    <div class="col-md-12" id="v11">
     <a href="javascript:void(0)" onclick="$('#frgt').show().animate({'top':'25%'});" class="edtu"/>Change Password</a>
      <h3 style="color:#2980B9; margin:0 0 0 10px;">My Account</h3>
	  <?php if(isset($msg)) echo $msg;?>
     <div class="col-md-12" id="v111">
		<form action="" method="post" class="loginfrm" style="text-align:left;" onsubmit="return editProfile()" enctype="multipart/form-data">
             <label class="lbl23">E-Mail</label><br/>
             <input name="email" type="text"  id="email" class="femalereg" value="<?=$email;?>" disabled><br/>
             <label class="lbl23">Other E-Mail</label><br/>
             <input name="oemail" type="text"  id="oemail" class="femalereg" value="<?=$oemail;?>"><br/>
             <label class="lbl23">Contact Number</label><div class="err-msg" id="contact-msg">Please Enter a Valid Phone Number</div><br/>
             <input name="contact" type="text"  id="contact" class="femalereg" value="<?=$contact;?>"  data-mask="000-000-9999"><br/>
              <label class="lbl23">Linkedin</label><br/>
             <input name="linkedin" type="text"  id="linkedin" class="femalereg" value="<?=$linkedin;?>"><br/>
             <label class="lbl23"> About Me </label>
             <textarea style="height: 180px;" class="femalereg" id="about_me" name="about_me"><?=$aboutme;?></textarea>
             
             <label class="lbl23">Image</label><br/>
             <input name="image" type="file"  id="image" class="femalereg"><br/>
             <label class="lbl23">Major</label><div class="err-msg" id="pmajor-msg">Please Enter Major</div><br/>

				 <input name="major" type="text" value="<?php echo $major; ?>"  id="major" class="femalereg">
                                 
                                  <label class="lbl23">Matriculation Year</label><div class="err-msg" id="pass-msg">Please Enter Matriculation Year</div><br/>

				 <select name="Matriculation"  id="Matriculation" class="femalereg">
                                     <?php
                                      $a=2010;
                                     for($i=0;$i<7;$i++){
                                         $selected='';
                                         if($a==$matriculation){
                                             $selected="selected='selected'";
                                         }
                                        echo '<option '.$selected.' value="'.$a.'">'.$a.'</option>';
                                        $a++;
                                     }
                                     ?>
                                     
                                     
                                 </select>
                                  
                                  
                                  <label class="lbl23">Degree</label><div class="err-msg" id="Degree-msg">Please Enter Degree</div><br/>

				 <select name="Degree"  id="Degree" class="femalereg">
                                     <option <?php echo $degree=='Bachelor'?'selected':''; ?> value="Bachelor">Bachelor</option>
                                     <option <?php echo $degree=='Master'?'selected':''; ?> value="Master">Master</option>
                                     <option <?php echo $degree=='PhD'?'selected':''; ?> value="PhD">PhD</option>
                                     
                                 </select><br/>
                                 <label class="lbl23">Male</label>

                                   <input name="gender" type="radio" <?php echo $gender=='Male'?'checked="checked"':''; ?>  value="Male" > <label class="lbl23">Female</label><input name="gender" type="radio" <?php echo $gender=='Female'?'checked="checked"':''; ?> value="Female" >   <br/>
             
             
             <input name="submit" type="submit" value="Update Account" class="btn1" >
             </form>
     </div>
     
    </div>
  </div>
  <!-- /.row -->
 <hr>
<?php 
// bottom part of the page
include_once "include/footer.php";
// end here;
?>