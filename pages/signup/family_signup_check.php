<?php 

	$inputAccount = $_POST['acc'];
	$inputPassword = $_POST['psd'];
	$inputConfirm = $_POST['chk'];

	// echo $inputAccount.$inputPassword.$inputConfirm;
	// // 過瀘 SQL Injection 
	$inputAccount = preg_replace("/[\'\"]+/" , '' ,$inputAccount);
	$inputPassword = preg_replace("/[\'\"]+/" , '' ,$inputPassword);
	$inputConfirm = preg_replace("/[\'\"]+/" , '' ,$inputConfirm);
	// // -----------------------------------------------
	session_start();
	$_SESSION['account']=$inputAccount;
	$_SESSION['Password']=$inputPassword;
	$_SESSION['Confirm']=$inputConfirm;

	// // -----------------------------------------------

	require_once './../../connections/Account.php';//包含Account.php，once為指包含一次，不會重複包含
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die('無法開啟Mysql資料庫連結');
	mysqli_query($conn, "SET CHARACTER SET UTF8");
	mysqli_select_db($conn, $dbname);

// 	echo "123";
// 	echo'<script type="text/javascript">
// alert('.$_SESSION['account'].');
// </script>';
$a = 0;
	
    if(!isset($_SESSION['account'])){
    	exit("ERROR 404");
    }else{
    	if ($_SESSION['Password'] == $_SESSION['Confirm']) {

    		$sql = 'SELECT `Username` FROM `family_account` where `Username`="'.$_SESSION['account'].'"';
    		$result = mysqli_query($conn, $sql) or die($sql);
    		$row = mysqli_fetch_array($result);
    		if ($row[0] == '') {
    				$sql2 = 'INSERT INTO `family_account` ( `Username`, `password`) VALUES ("'.$_SESSION['account'].'", "'.$_SESSION['Password'].'")';
    				mysqli_query($conn, $sql2) or die($sql2);
    				echo "1";//complete
    				// break;
    		 }else if($_SESSION['account'] == $row[0]){
	    			echo "2";//account is exist
	    			// break;
    			} else {
    				echo '0';
    				
    			}

    		

		} else {
	    	echo "0";
	    	// echo $_SESSION['password']. "," .$_SESSION['Confirm'];
	    	
	    }
    }

	// $password = $_POST['password'];
	// $family=$_SESSION["family_username"];
	// header("Content-Type: text/html; charset=utf8");
	// if(!isset($_POST['submit'])){
	// 	exit("錯誤執行");
	// }
	// $username=$_POST['username'];
	// $password=$_POST['password'];
	// if ($username==''||$password=='') {
	// 	header("refresh:1; url=family_signup_html.php");
	// 	echo "<font color=red><h1><br><br>使用者帳號、密碼，不可為空白!<h1></font>";
	// }else{
	// 	require('connect_mysql.php');
	// 	$re = "SELECT * FROM family_account where Username = '$username' LIMIT 1";
	// 	$re_result = mysqli_query($db_link,$re);
	// 	while($re_row=mysqli_fetch_array($re_result)){
	// 		if ($re_row[1] == $username){
	// 			echo '<meta http-equiv=REFRESH CONTENT=1;url=family_signup_html.php>';
	// 			die('<font color=red><h1><br><br>帳號重複<h1></font>');
	// 		}
	// 	}
	// 	$new="INSERT INTO family_account (Username,password) VALUES ('$username','$password')";
	// 	$reslut=mysqli_query($db_link,$new);
	// 	if (!$reslut){
	// 		die('註冊失敗');
	// 	}else{
	// 		echo "<font color=blue><h1><br><br>註冊成功<h1></font>";
	// 	}
	// 	mysqli_close($db_link);
	// 	header("refresh:1; url=family_login_into_html.php");
	// }
?>