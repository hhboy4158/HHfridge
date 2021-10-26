<?php
session_start();

require_once './../connections/Account.php';
$session_chef_Id = "'" . @$_SESSION['family_username'] . "'";
$session_chef_Pwd ="'" . @$_SESSION['family_password'] . "'";
//===================================================
$sql = 'SELECT * FROM `chef_account` where account = '. $session_chef_Id . 'AND password =' . $session_chef_Pwd;
$result = mysqli_query($conn, $sql) or die($sql);
$row = mysqli_fetch_array($result);
//===================================================
$sql_customer = 'SELECT * FROM `family_account` where Username = '. $session_chef_Id . 'AND password =' . $session_chef_Pwd;
$result_customer = mysqli_query($conn, $sql_customer) or die($sql_customer);
$row_customer = mysqli_fetch_array($result_customer);
//===================================================
if(isset($row[0]) and $row[1] == $_SESSION['family_username']){
    switch($row[7]){//檢查狀態
        case 0://尚未認證廚師
            echo "0";
            break;
    
        case 1://已認證廚師
            echo "1";
            break;

        default:
            exit;
            break;
    }
}else{
    echo "100";
}


?>