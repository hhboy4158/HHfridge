<?php
    session_start();
    // 判斷是否登入
    $family = $_SESSION['family_username'];
    if(!isset($family)){
    header("Location:../login/login.php");
    }
    
    require('./../../connections/Account.php');

    // $family = $_SESSION['family_username'];
    $fid = $_GET['fid'];
    // $vansama = "'" . $family . "'";
    $sql = "SELECT * FROM `keep` WHERE `user` = (SELECT ID FROM `family_account` WHERE Username ='$family') AND `recipe` = '$fid';";
    $result = mysqli_query($conn, $sql) or die($sql);
    $row = mysqli_fetch_row($result);

    if(empty($row[0])){
        $sql = "INSERT INTO `keep` (`id`, `user`, `recipe`) VALUES (NULL, (SELECT ID FROM `family_account` WHERE Username ='$family'), '$fid')";
        $msg = "已新增至我的收藏";
    }else{
        $sql = "DELETE FROM `keep` WHERE `keep`.`id` = '$row[0]';";
        $msg = "已從我的收藏中移除";
    }
    $result = mysqli_query($conn, $sql) or die($sql);
    echo '<script language="JavaScript">';
    // echo "alert('$msg');";
    echo "javascript:history.go(-1)";
    echo '</script>';


?>
