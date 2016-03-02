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
<div id="page-wrapper" style="padding:38px;">
<?php
if(isset($_GET['id']))
{
$secretkey = mysql_query("select * from stripecredentials where id ='1'");
$sresult = mysql_fetch_array($secretkey);
$cquery= mysql_query("select * from stripepayment where taskid = '".$_GET['id']."'");
$chargeid = mysql_fetch_array($cquery);
try{
	$stripeClassesDir = __DIR__ . '/Stripe/lib/';
	$stripeUtilDir    = $stripeClassesDir . 'Util/';
	$stripeErrorDir   = $stripeClassesDir . 'Error/';

	set_include_path($stripeClassesDir . PATH_SEPARATOR . $stripeUtilDir . PATH_SEPARATOR . $stripeErrorDir);
	function __autoload($class)
	{
		$parts = explode('\\', $class);
		require end($parts) . '.php';
	}
	   \Stripe\Stripe::setApiKey($sresult['secretkey']);
	
	             $ch = \Stripe\Charge::retrieve($chargeid['chargeid']);
                      $re = $ch->refunds->create();
                      $update = mysql_query("update tasks set `refund` ='1' where bid_id ='".$_GET['id']."'");
                        
	                echo"<h3>Refunded successfully to Requester</h3>";
	               
	                 header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/admin/cancelpayment.php');
	               
		
	
                   }
	

                catch(Stripe_CardError $e){
	                $error = $e->getMessage();
	                echo '<br><span style="color:red">'.$error.'</span><br>';
	               
	                
	               
                }

                catch(stripe_InvalidRequestError $e){
                   $error = $e->getMessage();
	                echo '<br><span style="color:red">'.$error.'</span><br>';
	               
	                
	               
                }

                catch(stripe_AuthenticationError $e){
	                $error = $e->getMessage();
	                echo '<br><span style="color:red">'.$error.'</span><br>';
	               
	                
	               
                }

                catch(Exception $e){
	                $error = $e->getMessage();
	                echo '<br><span style="color:red">'.$error.'</span><br>';
	                	                
	               
                }


}
if(isset($_GET['did']))
{
mysql_query("Delete from tasks  where id ='".$_GET['did']."'");
 echo"<h3>Delete successfully</h3>";
 header('Refresh: 2; URL=http://'.$_SERVER['HTTP_HOST'].'/admin/cancelpayment.php');
	               
}
?>

        <div id="showTopId">
                 <div class="container-fluid">
                  <table>
                  <tr> 
                  <td style="width:240px;"> Name </td>
                  <td> Added date </td>
                  </tr>
                
                 <?php
                 $query= mysql_query("SELECT * FROM tasks WHERE id NOT IN (SELECT bid_id FROM satisfiedstatus ) ORDER BY  `id` DESC");
                 while($rec = mysql_fetch_array($query))
                 {
                            
                 ?>
                <tr>
                <td> <?php echo $rec['taskname'];?></td>
                <td> <?php echo $rec['added_date'];?></td>
                <td>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                <?php
                if($rec['refund']=='1')
                {
                 echo 'Refunded'; 
                } else {
                ?>
                 <a href="?id=<?php echo $rec['id'];?>">Refund </a>
                 <?php } ?>
                 </td>
                 <td> &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<a href="?did=<?php echo $rec['id'];?>">Delete </a></td>
                </tr>
               
                
                 <?php
                 }
                 ?>
                  </table>
                
                 </div>
        </div>
</div>

<?php
include_once "include/footer.php";
?>
