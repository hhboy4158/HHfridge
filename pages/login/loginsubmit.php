<?php
	$inputAccount = $_POST['acc'];
	$inputPassword = $_POST['psd'];
	// 過瀘 SQL Injection
	$inputAccount = preg_replace("/[\'\"]+/" , '' ,$inputAccount);
	$inputPassword = preg_replace("/[\'\"]+/" , '' ,$inputPassword);
	// -----------------------------------------------
	session_start();
	$_SESSION['family_username']=$inputAccount;
	$_SESSION['family_password']=$inputPassword;
	// -----------------------------------------------
	require_once('./../../connections/Account.php');
	// $conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die('無法開啟Mysql資料庫連結');
	// mysqli_query("SET NAMES 'utf8'",$conn);
	// mysqli_select_db($dbname, $conn);
	// -----------------------------------------------
	$sql = "select * from family_account where Username = '".$_SESSION['family_username']."' and password ='".$_SESSION['family_password']."';"; 
	$result = mysqli_query($conn,$sql) or die($sql);
	$rowCust = mysqli_num_rows($result);

	$sqlChef = "select * from chef_account where account = '".$_SESSION['family_username']."' and password ='".$_SESSION['family_password']."';"; 
	$resultChef = mysqli_query($conn,$sqlChef) or die($sqlChef);
	$rowChef = mysqli_num_rows($resultChef);
	if($rowCust > 0){//一般用戶
		echo "0";
	}else if($rowChef > 0){//廚師狀態0
		echo "2";
	}else{
		echo "1";//登入失敗
		unset($_SESSION['family_username']);
		unset($_SESSION['family_password']);
	}
	
?>
