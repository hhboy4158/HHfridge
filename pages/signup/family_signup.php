<!DOCTYPE html>
<html lang="en">
<head>
    <title>登入介面</title>
</head>
<body>
<?php 
	header("Content-Type: text/html; charset=utf8");
	if(!isset($_POST['submit'])){
		exit("錯誤執行");
	}
	$username=$_POST['username'];
	$password=$_POST['password'];
	if ($username==''||$password=='') {
		header("refresh:1; url=family_signup_html.php");
		echo "<font color=red><h1><br><br>使用者帳號、密碼，不可為空白!<h1></font>";
	}else{
		require('connect_mysql.php');
		$re = "SELECT * FROM family_account where Username = '$username' LIMIT 1";
		$re_result = mysqli_query($db_link,$re);
		while($re_row=mysqli_fetch_array($re_result)){
			if ($re_row[1] == $username){
				echo '<meta http-equiv=REFRESH CONTENT=1;url=family_signup_html.php>';
				die('<font color=red><h1><br><br>帳號重複<h1></font>');
			}
		}
		$new="INSERT INTO family_account (Username,password) VALUES ('$username','$password')";
		$reslut=mysqli_query($db_link,$new);
		if (!$reslut){
			die('註冊失敗');
		}else{
			echo "<font color=blue><h1><br><br>註冊成功<h1></font>";
		}
		mysqli_close($db_link);
		header("refresh:1; url=family_login_into_html.php");
	}
?>
</body>
</html>
