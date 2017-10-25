<?php require_once('../init.php');
	$user=new User();
	$user->logout();
	header('location: ../index.php');
 ?>