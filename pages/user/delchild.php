<?php 
	session_start();
	require('./../../connections/Account.php');
	error_reporting(E_ALL^E_NOTICE^E_WARNING);
	header("Content-Type: text/html; charset=utf8");
	// if(!isset($_POST['submit'])){
	// 	exit("錯誤執行");
	// }
	$family = $_SESSION['family_username'];
	$username = $_POST['child'];
	$add = "'" . $family . "'";
	$sql = 'DELETE FROM `personal_account` WHERE `personal_account`.`ID` = '.$username.' AND `Owner` = (SELECT ID FROM family_account WHERE Username ='.$add.');';
	mysqli_query($conn, $sql);
	echo $sql;
	


	
	mysqli_close($conn);
	header("refresh:0.5; url=../../user_manage.php");
?>