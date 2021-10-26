<?php 
	session_start();
	require_once('./../../connections/Account.php');
	
	error_reporting(E_ALL^E_NOTICE^E_WARNING);
	header("Content-Type: text/html; charset=utf8");
	if(!isset($_POST['submit'])){
		exit("錯誤執行");
	}
	$name=$_POST['name'];
	$username=$_POST['username'];
	$Product_1=$_POST['Product_1'];
	$Product_2=$_POST['Product_2'];
	$Product_3=$_POST['Product_3'];
	$Product_4=$_POST['Product_4'];
	$Product_5=$_POST['Product_5'];
	$Product_6=$_POST['Product_6'];
	$Product_7=$_POST['Product_7'];


	if ($name==''||$username=='') {

		echo "<script>";
		echo 'alert("使用者名稱、帳號，不可為空白!")';
		echo "</script>";
	}else{
		
		$family = $_SESSION["family_username"];
		$re_f="SELECT * FROM family_account WHERE Username = '$family' LIMIT 1";
		$re_f_result=mysqli_query($conn, $re_f) or die($re_f);
		while($re_f_row=mysqli_fetch_array($re_f_result)){
			$re_owner = $re_f_row[0];
		}
		$re = "SELECT * FROM personal_account where Username = '$username' AND Owner = '$re_owner' LIMIT 1";
		$re_result = mysqli_query($conn,$re);
		while($re_row = mysqli_fetch_array($re_result)){
			if ($re_row[3] == $username){

				echo "<script>";
				echo 'alert("子帳號重複")';
				echo "</script>";
				header("refresh:0.5; url=../index.php#family_Inquire");
				
				exit();
			}else{
				die('Unknown ERROR!');
			}
		}
		$new="INSERT INTO personal_account (`Owner`,`Name`,`Username`) VALUES ('$re_owner','$name','$username')";
		$reslut=mysqli_query($conn,$new) or die($new);
		if (!$reslut){

			echo "<script>";
			echo 'alert("新增失敗")';
			echo "</script>";

		}else{
			$f="SELECT * FROM family_account WHERE Username = '$family' LIMIT 1";
			$f_result=mysqli_query($conn,$f);
			while($f_row=mysqli_fetch_array($f_result)){
				$owner="UPDATE personal_account SET Owner='$f_row[0]' WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$owner);
			}
			if ($Product_1==1){
				// updt('heartattack', 1, $name, $username);
				$sick="UPDATE personal_account SET 	heartattack=1 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}else{
				// updt('heartattack', 0, $name, $username);
				$sick="UPDATE personal_account SET 	heartattack=0 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}
			if ($Product_2==2){
				// updt('pneumonia', 1, $name, $username);
				$sick="UPDATE personal_account SET pneumonia=1 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}else{
				// updt('pneumonia', 0, $name, $username);
				$sick="UPDATE personal_account SET pneumonia=0 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}
			if ($Product_3==3){
				// updt('diabetes', 1, $name, $username);
				$sick="UPDATE personal_account SET diabetes=1 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}else{
				// updt('diabetes', 0, $name, $username);
				$sick="UPDATE personal_account SET diabetesr=0 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}
			if ($Product_4==4){
				// updt('Lower_respiratory_tract', 1, $name, $username);
				$sick="UPDATE personal_account SET Lower_respiratory_tract=1 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}else{
				// updt('Lower_respiratory_tract', 0, $name, $username);
				$sick="UPDATE personal_account SET Lower_respiratory_tract=0 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}
			if ($Product_5==5){
				// updt('hypertension', 1, $name, $username);
				$sick="UPDATE personal_account SET hypertension=1 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}else{
				// updt('hypertension', 0, $name, $username);
				$sick="UPDATE personal_account SET hypertension=0 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}
			if ($Product_6==6){
				// updt('Nephritis', 1, $name, $username);
				$sick="UPDATE personal_account SET Nephritis=1 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}else{
				// updt('Nephritis', 0, $name, $username);
				$sick="UPDATE personal_account SET Nephritis=0 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}
			if ($Product_7==7){
				// updt('Liver', 1, $name, $username);
				$sick="UPDATE personal_account SET Liver=1 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}else{
				// updt('Liver', 0, $name, $username);
				$sick="UPDATE personal_account SET Liver=0 WHERE Name='$name' AND Username='$username'";
				mysqli_query($conn,$sick);
			}
			// echo "<font color=blue><h1>註冊成功<h1></font>";

			echo "<script>";
			echo 'alert("新增成功")';
			echo "</script>";
		}
	}
	function updt($s, $value, $n, $user){
		require_once('./../../connections/Account.php');
		$sick="UPDATE personal_account SET 	" . $s .  "=" . $value . " WHERE Name='$n' AND Username='$user'";
		mysqli_query($conn, $sick) or die($sick);
	}
	mysqli_close($conn);
	header("refresh:0.5; url=../../user_manage.php");
?>