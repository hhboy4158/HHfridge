<?php
    require_once './../../../../connections/Account.php';
    session_start();
    $chef = $_SESSION['family_username'];
    $info = $_POST['recipe_info_edit'];
    $price = $_POST['recipe_price_edit'];
    $ing = $_POST['rec_ing_data'];
    $name = $_POST['name'];

    $sql = "SELECT `ID`FROM `chef_account` where account = '$chef'";
    $result = mysqli_query($conn, $sql) or die("查詢廚師時出了問題: " . $sql);
    $row = mysqli_fetch_array($result);
    $sql = "SELECT `cri_ID`,`cri_ingName`,`cri_ingNum`,`cri_ingUnit` FROM `chef_recipe_ingredient`inner join `chef_recipe`";
    $sql .="WHERE cri_recipe = chef_recipe.cr_ID  and  cri_recipe = " . $name . "  and  chef_recipe.cr_chef = " . $row['ID'] . "";
    $result = mysqli_query($conn, $sql) or die("查詢食材時時出了問題: " . $sql);
    $count_upd = 0;
    $count_NothingChange = 0;
    $count_Err = 0;
    while($row = mysqli_fetch_array($result)){
        for($i = 0; $i < count($ing); $i += 4){
            if($row['cri_ID'] == $ing[$i]['value'] and $row['cri_ingName'] == $ing[$i + 1]['value'] and $row['cri_ingNum'] == $ing[$i + 2]['value'] and $row['cri_ingUnit'] == $ing[$i + 3]['value']){
                $count_NothingChange++;
            }else if($row['cri_ID'] == $ing[$i]['value']){
               $sql_upd = "UPDATE `chef_recipe_ingredient` SET `cri_ingName`= " . "'" . $ing[$i + 1]['value'] . "'" . ",`cri_ingNum`= " . "'" . $ing[$i + 2]['value'] . "'" . ",`cri_ingUnit`= " . "'" . $ing[$i + 3]['value'] . "'" . " WHERE `cri_ID` = " . $ing[$i]['value'];
               mysqli_query($conn, $sql_upd) or die("修改食材出了問題: " . $sql_upd);
               $count_upd++;
            }else{
                $count_Err++;
            }   
            // echo $ing[$i+1]['value'];
        }
        
    }
    $count_info = 0;
    $sql = "SELECT * FROM `chef_recipe` INNER JOIN `chef_account` WHERE `cr_ID` = " . $name . " and `cr_chef` =  chef_account.ID and chef_account.account = " . "'" . $chef . "'";
    $result = mysqli_query($conn, $sql) or die("查詢原有簡介出了問題:" . $sql);
    $row = mysqli_fetch_array($result);
    if($row['cr_about'] != $info or $row['price'] != $price){
        $sql = "UPDATE `chef_recipe` SET `cr_about`=" . "'" . $info . "'" . " , `price`=" . "'" . $price . "'" . " WHERE `cr_chef` = (SELECT ID FROM `chef_account` WHERE `account` = " . "'" . $chef . "'" . ") and `cr_ID` = " . $name;
        mysqli_query($conn, $sql) or die("更新簡介時出了問題: " . $sql);
        $count_info++;
    }
    if($count_upd != 0 or $count_info != 0){
        echo "1";
    }else if($count_NothingChange == count($ing) / 4 and $row['cr_about'] == $info and $row['price'] == $price){
        echo "2";
    }else{
        echo $count_Err;
    }

    
    // echo $sql;

?>