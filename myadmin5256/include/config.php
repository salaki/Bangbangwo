<?php
$host = 'localhost';
$user = 'ubangban';
$pass = 'Sauzheng@97817';
$db = 'ubangban_tasks';
$conn = mysql_connect($host,$user,$pass) or die(mysql_error());
mysql_select_db($db,$conn) or die(mysql_error());
?>