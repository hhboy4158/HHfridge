<?php
// -----------------------------------------------
//connect to db
session_start();
require_once '../../connections/Account.php';

// -----------------------------------------------

$formData = $_POST["formData"];

for($i = 0 ; $i < count($formData) ; $i+=2)
{
	// echo $i;
	// 取得陣列內部的 食物ID及更改數量
	$q = $formData[($i+1)]["value"]; //食物的數量
	$d = $formData[$i]['value']; //食物的ID
	$sql = "UPDATE `material` SET `quantity`= '$q' WHERE `ID`=  '$d';";
	mysqli_query($conn,$sql);
	
}

?>