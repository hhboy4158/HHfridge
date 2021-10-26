<?php
set_time_limit(864000);
// -----------------------------------------------
$account = $_POST['chef_account'];
$password = $_POST['chef_password'];
$chef_address = $_POST['chef_address'];
$chef_phonenum = $_POST['chef_phonenum'];
$chef_FirstName = $_POST['chef_FirstName'];
$chef_Name = $_POST['chef_Name'];
// echo $chef_FirstName . ', ' . $chef_Name;
// -----------------------------------------------
// $account  => $inputAccount
// $password => $inputPassword
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
if($_SESSION['account'] != "" and $_SESSION['password'] != "" and $chef_address != "" and $chef_phonenum != "" and $chef_Name != "" and $chef_FirstName != ""){
    //檢查廚師 table
    $sql = "select account from chef_account where account = '$session_account'";
    $result = mysqli_query($conn, $sql) or die($sql);
    if(!$result){
        echo("Error: ". mysqli_error($conn));
        exit();
     }else{
        $row = mysqli_fetch_array($result);
     }
     //檢查使用者table
    $c_sql = "SELECT * FROM `family_account` where `Username` = '$session_account'";
    $c_result = mysqli_query($conn, $c_sql) or die($c_sql);
    if(!$c_result){
        echo("Error: ". mysqli_error($conn));
        exit();
     }else{
        $c_row = mysqli_fetch_array($c_result);
     }
     
    
    if(!isset($row[0]) and !isset($c_row[0])){//檢查帳號是否重複 
        //新增
        $sql    = "INSERT INTO `chef_account`(`account`, `password`, `address`, `phone`, `signup_date`, `ChefName`, `ChefFirstName`)
               VALUES ('$session_account', '$session_password', '$chef_address', '$chef_phonenum', CURRENT_TIME(), '$chef_Name','$chef_FirstName')";//CURRENT_TIME() = mysql 當前時間函數    
        mysqli_query($conn, $sql) or die($sql);

        //檢查資料是否新增成功
        $sql = "select account from chef_account where account = '$session_account'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row_count = mysqli_num_rows($result);
        if($row_count > 0){
            //新增成功 則 將值傳給session
            $_SESSION['family_username'] = $session_account;
            $_SESSION['family_password'] = $session_password;
            echo 1;
        }else{
            echo "ERROR 404: NOT FOUND result in Database.";
            exit;
        }
    }else{
        echo 2;
    }
}else{
    echo 0;
}
?>