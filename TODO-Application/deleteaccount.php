<?php 
	include('default.html');
	include('database.php');

	if(!loggedin()) {
		header("location:login.php");
	}
	deleteaccount($_SESSION['username']);
 ?>