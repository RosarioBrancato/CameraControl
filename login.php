<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('constants.php');
	include_once('controller/Login.php');
	
	$login = new Login();
	
	if(isset($_POST['login'])) {
		$username = '';
		$password = '';
		
		if(isset($_POST['username'])) {
			$username = $_POST['username'];
		}
		
		if(isset($_POST['password'])) {
			$password = $_POST['password'];
		}
		
		echo '{ "success" : "' . $login->isLoginValid($username, $password) . '" }';
	}
?>