<?php
	session_start();
	include 'database.php';

	if(loggedin()) {
		logout();
	}
    header('location:login.php');
?>