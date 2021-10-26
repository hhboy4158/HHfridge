<?php

    session_start();
    require_once './../../../../connections/Account.php';
    $session_username = "'" . $_SESSION['family_username'] . "'";
    $address = "'" . $_POST['address'] . "'";
    $phone = "'" . $_POST['phone'] . "'";
    $intro = "'" . $_POST['intro']. "'";
    echo $address . ", " . $phone . ", " . $intro;

    $sql = "UPDATE `chef_account` SET `address`  = $address, `phone` = $phone, `about` = $intro where account = $session_username";
    mysqli_query($conn, $sql) or die($sql);


    $type = $_POST['c_skill'];

    
    $sql = "SELECT `id`,`name`,`tag` FROM `type` INNER JOIN chef_skill WHERE chef_skill.chef_type = type.id and chef_skill.chef_ID = 
    (SELECT ID FROM chef_account WHERE `account` = " . $session_username .")";
    $result = mysqli_query($conn, $sql) or die($sql);
    $c_skill = array();
    while($row = mysqli_fetch_array($result)){
        array_push($c_skill, $row['id']);
    }
    $t = array();
    for($i = 0; $i < count($type); $i++){
        array_push($t, $type[$i]['value']);
        // echo $type[$i]['value'];
        if(!in_array($type[$i]['value'], $c_skill)){
            $sql_i = "INSERT INTO `chef_skill`(`chef_ID`, `chef_type`) VALUES ((select ID from chef_account where account = " . $session_username . "),'" . $type[$i]['value'] . "')";
            mysqli_query($conn, $sql_i) or die($sql_i);
            echo "INS: " . $type[$i]['value'] . ", ";
        }
    }
    for($j = 0; $j < count($c_skill); $j++){
        if(!in_array($c_skill[$j], $t)){
            $sql_d = "DELETE FROM `chef_skill` WHERE chef_id = (select ID from chef_account where account = " . $session_username . ")
             and  chef_type = '" . $c_skill[$j] . "'";
            mysqli_query($conn, $sql_d) or die($sql_d);
            echo "del: " . $c_skill[$j] . ", ";
        }
    }


// post = a b c 
// c_s = [a, b ]
// insert c 

// post = [a, b]
// c_s = [a, b, c]
// remove c 

// post = [a, b]
// c_s = [a, b]
// do nothing 


?>
