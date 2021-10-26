<?php
session_start();
require_once '../connections/Account.php';

// ==============================================
// $functionName = $_POST["functionName"];
// $fid = $_POST["fid"];
$BuyData = $_POST['BuyData'];
$total = $_POST['total'];
$family = $_SESSION['family_username'];
$sql = "SELECT ID FROM `family_account` WHERE `Username` = '$family'";
$result = mysqli_query($conn, $sql) or die($sql);
$row = mysqli_fetch_array($result);
$id = $row['ID'];
$buy = "";
$chef = array();
for($i = 0; $i < count($BuyData); $i++){
    $sql = "";
    if($i == count($BuyData) - 1){
        $buy .= $BuyData[$i]['value'];
    } else {
        $buy .= $BuyData[$i]['value'] . ",";
    }

    
}
$sql = "SELECT max(ID) FROM `user_order`";
$result = mysqli_query($conn, $sql) or die($sql);
$row = mysqli_fetch_array($result);
$uoid = $row[0] + 1;
$sql = "INSERT INTO `user_order` (`id`, `user_id`, `data`, `price`) VALUES ($uoid, $id, " .'"'. $buy  . '"' . ", $total)";
mysqli_query($conn, $sql) or die($sql);
$sql = "";

$sql = "INSERT INTO `user_order_status` (`uo_id`, `chef_id`, `food`, `status`) VALUES ($uoid, '', '', '0')";




// echo '<pre>';
// print_r($BuyData);
// echo '</pre>';

?>