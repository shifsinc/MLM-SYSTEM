<?php
if(!isset($_SESSION))
{	session_start();
}
if(isset($_SESSION['id']))
{	
    $uid = $_SESSION['id'];
}
else
{
	echo "<script>window.location.replace('login.php')</script>";
	exit();
}

?>