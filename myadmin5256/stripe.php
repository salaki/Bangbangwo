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

<div id="page-wrapper" style="padding:38px;height:186px;">

<?php
if(isset($_POST['submit']) =='Submit')
{
 $data = mysql_query("select * from stripecredentials where id =1");
 if(mysql_num_rows($data) >0)
 {
  $updatedata = mysql_query("update stripecredentials set `publishablekey` ='".$_POST['publishablekey']."' ,`secretkey`='".$_POST['secretkey']."' where id=1 ");
  echo 'Update Successfully'; 
 }
 else
 {
 $insertdata  =  mysql_query("insert into stripecredentials (`id`,`secretkey`,`publishablekey`) values ('1','".$_POST['secretkey']."','".$_POST['publishablekey']."')");
 echo 'Insert Successfully';
 }
}
?>
        <div id="showTopId">
                 <div class="container-fluid">
                 <form action="" method="post">
                 <?php
                 $data = mysql_query("select * from stripecredentials where id =1");
                 $rec = mysql_fetch_array($data);
                 ?>
                 <table>
                 <tr>
                         <td> Enter Publishable Key </td>
                         <td> <input type="text" name="publishablekey" size="50" value="<?php echo $rec['publishablekey'];?>"> </td>
                 </tr>
                 <tr>
                         <td> Enter Secret Key </td>
                         <td> <input type="text" name="secretkey" size="50" value="<?php echo $rec['secretkey'];?>"> </td>
                 </tr>
                 <tr>
                         <td><input type="submit" name="submit" value="Submit"> </td>
                 </tr>
                 </table>
                 </form>
                 </div>
        </div>
</div>

<?php
include_once "include/footer.php";
?>
