<?php
    session_start();
    $a = $_SESSION['family_username'];
    require_once './../../connections/Account.php';
    $sql = "SELECT ID FROM `chef_account` WHERE account =" . "'" . $a . "'";
    $result = mysqli_query($conn, $sql) or die($sql);
    $row = mysqli_fetch_array($result);

    $skill = $_POST['skill'];
    
    for($i = 0; $i < count($skill); $i++){
        echo $skill[$i]['value'];
        $sql = 'INSERT INTO `chef_skill`(`chef_ID`, `chef_type`) VALUES (' . $row[0] . ', ' . $skill[$i]['value'] . ')';
        mysqli_query($conn, $sql) or die($sql);
    }
    $sql = "UPDATE `chef_account` SET `approve`= 1, `img` = 0 where account = " . "'" . $a . "'" ;
    mysqli_query($conn, $sql) or die($sql);
    echo "1";
?>