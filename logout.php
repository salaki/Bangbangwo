<?php
// all the sessions destroys here and user log out

session_start();
session_destroy();
header('location:http://'.$_SERVER['SERVER_NAME']);
?>