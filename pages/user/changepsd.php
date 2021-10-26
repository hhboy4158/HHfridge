<?php
//-------------------------------------------------

	session_start();
	require('./../../connections/Account.php');

//-------------------------------------------------

	$family_username = $_SESSION['family_username'];
	$psd = $_SESSION['family_password'];

	$ogpsd = $_POST['ogpsd'];
	$newpsd = $_POST['newpsd'];
	$cfmpsd = $_POST['cfmpsd'];

//-------------------------------------------------

	// $sql = "SELECT `password` FROM `family_account` WHERE`Username` = '$family_username'";
	// $result = mysqli_query($conn, $sql);
	// $row = mysqli_fetch_row($result);
	if ($newpsd == $cfmpsd) {//新密碼 == 確認密碼
		if ($ogpsd != $psd) {//原密碼 不為 輸入的原密碼
			echo "0";
		}elseif ($ogpsd == $psd) {//原密碼 == 輸入的原密碼
			$sql = "UPDATE `family_account` SET `password` = '$newpsd' WHERE `family_account`.`Username` = '$family_username';";
			mysqli_query($conn, $sql) or die($sql);
			echo '1';
		}	# code...
	}else{//$newpsd == $cfmpsd
		echo "Passwords do not match.";
	}


?>