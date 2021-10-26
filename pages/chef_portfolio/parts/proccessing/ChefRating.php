<?php
require_once './../../../../connections/Account.php';
session_start();


$FromData = $_POST['formData'];
$chef     = $_POST['chef'];
$account  = $_SESSION['family_username'];

$sql      = "SELECT `ID` FROM `family_account` WHERE `Username` = '" . $account . "'";
$result   = mysqli_query($conn, $sql) or die($sql);
$row      = mysqli_fetch_array($result);

$sql      = "SELECT * FROM `chef_score` WHERE `chef_ID` = '" . $chef . "' and `user_ID` = '" . $row['ID'] . "'" ;
$result   = mysqli_query($conn, $sql) or die($sql);
$RowCount = mysqli_num_rows($result);


if($RowCount > 0){
    $sql     = "UPDATE `chef_score` SET `score`='$FromData' WHERE `user_ID` = '" . $row['ID'] . "' and `chef_ID` = '" . $chef . "'";
    $result  = mysqli_query($conn, $sql) or die($sql);
    echo "0";
}else{
    $sql    = "INSERT INTO `chef_score`( `score`, `user_ID`, `chef_ID`) VALUES ('$FromData','" . $row['ID'] . "','$chef')";
    $result = mysqli_query($conn, $sql) or die($sql);
    echo "1";
}
?>