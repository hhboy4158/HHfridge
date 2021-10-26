<?php
// -----------------------------------------------
//connect to db
session_start();
require_once '../../connections/Account.php';

// -----------------------------------------------
//get post from 'fmanage.php'
$family_username = $_SESSION["family_username"];
$inputIng  = $_POST['ing'];
$inputNum = $_POST['num'];

// -----------------------------------------------
//取得原有食材數量
$sqlQty = "SELECT `quantity` FROM `material` WHERE `account` = '$family_username' AND `foodname` = '$inputIng'";
$resultqty = mysqli_query($conn, $sqlQty) or die($sqlQty);
$foodqty = mysqli_fetch_array($resultqty);
$add = isset($foodqty[0]) ? $foodqty[0] : 0 ;

// -----------------------------------------------
//尋找資料庫內是否有資料，有就INSERT，否則就UPDATE
$checksql = "SELECT count(*) FROM `material` WHERE `account` = '$family_username' AND `foodname` = '$inputIng'";
$checkresult = mysqli_query($conn, $checksql) or die($checksql);
$checkarr = mysqli_fetch_array($checkresult);

// -----------------------------------------------
//判斷
if ((int)$checkarr[0] == 0){
	$sql = "INSERT INTO `material` (`ID`, `account`, `foodname`, `quantity`) VALUES (NULL, '$family_username', '$inputIng', '$inputNum');";
	echo '新增了' . $inputIng . '，' . $inputNum . '個';
}else{
	$sql = "UPDATE `material` SET `quantity` = '$add' + '$inputNum' WHERE `material`.`foodname` = '$inputIng' AND `account` = '$family_username';";
	echo '修改了' . $inputIng . '，' . $inputNum . '個';
}
mysqli_query($conn, $sql) or die($sql);



// -----------------------------------------------


?>