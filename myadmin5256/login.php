<?php
include_once "include/config.php";
session_start();
ob_start();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$record = mysql_num_rows(mysql_query("SELECT * FROM adminLogin WHERE user_nm='".$_POST['login']."' and user_pass=md5('".$_POST['password']."')"));
	if($record > 0)
	{
		$_SESSION['adminUser'] = 'true';
		header('location:dashboard.php');
	}
	else
	{
		$msg = 'Invalid Username or Password';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <link rel="stylesheet" href="css/login.css">
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Login</h1>
      <form method="post" action="">
        <p><input type="text" name="login" value="" placeholder="Username"></p>
        <p><input type="password" name="password" value="" placeholder="Password"></p>
        <p class="remember_me">
          <label style="color:red;">
            <?=$msg;?>
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Login" style="cursor:pointer;"></p>
      </form>
    </div>
  </section>
</body>
</html>
