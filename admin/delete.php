<?php 
	$token = 1;

	function exitToAdmin(){
	header('Location: admin_auth.php');
	}

	if(isset($_POST['delcomm'])){
		exitToAdmin();
	}
?>