<?php
	session_start();
	unset($_SESSION['family_username']);
	unset($_SESSION['family_password']);
	header("Location: ./../login/login.php");
?>