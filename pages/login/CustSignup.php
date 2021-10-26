<?php
set_time_limit(864000);
// -----------------------------------------------
$account = $_POST['cust_account'];
$password = $_POST['cust_password'];
$cust_address = $_POST['cust_address'];
$cust_phonenum = $_POST['cust_phonenum'];
// -----------------------------------------------
require_once 'Anti_Injection.php';
session_start();
$_SESSION['account'] = $inputAccount;
$_SESSION['password'] = $inputPassword;
$session_account = $_SESSION['account'];
$session_password = $_SESSION['password'];
// -----------------------------------------------
$timezone = date_default_timezone_set('Asia/Taipei');
$today = date('Y-m-d');
// -----------------------------------------------
require_once './../../connections/Account.php';
if($_SESSION['account'] != "" or $_SESSION['password'] != "" or $cust_address != "" or $cust_phonenum != ""){
    $sql = "select Username from family_account where username = '$session_account'";
    $result = mysqli_query($conn, $sql) or die($sql);
    $row = mysqli_fetch_array($result);
    if(!isset($row[0])){//檢查帳號是否重複
        $sql    = "INSERT INTO `family_account`(`Username`, `password`, `address`, `phone`, `signup_date`)
               VALUES ('$session_account', '$session_password', '$cust_address', '$cust_phonenum', CURRENT_TIME())";//CURRENT_TIME() = 當前時間函數
        mysqli_query($conn, $sql) or die($sql);
        echo 1;
    }else{
        echo 2;
    }
}else{
    echo 0;
}
?>