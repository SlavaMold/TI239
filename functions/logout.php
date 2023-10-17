
<?php 
require_once '../functions/connect.php'; 
session_start();

if(isset($_POST['trigger'])){
	$adminNick = $_COOKIE['login'];
	mysqli_query($connect, "UPDATE `admins` SET `online` = 'false' WHERE `login` = $adminNick");
	$_SESSION['token'] = false;
}


?>