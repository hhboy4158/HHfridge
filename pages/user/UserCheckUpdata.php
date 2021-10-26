<?php
	session_start();
	require('../../connections/Account.php');
	if( isset( $_SESSION['family_username'] ))
	{
		$family = $_SESSION['family_username'];

		// 查詢使用者
		$sql = "SELECT * FROM family_account WHERE Username = '$family';";
		$result = mysqli_query($conn,$sql);
		$row = mysqli_num_rows($result);
		echo '$sql';
		if($row > 0)
		{
			$sql = "UPDATE `family_account` SET `class`= 1 WHERE `Username` = '$family';";
			mysqli_query($conn,$sql);
		}
	}
?>