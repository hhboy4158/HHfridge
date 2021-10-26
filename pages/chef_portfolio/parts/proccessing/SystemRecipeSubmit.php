<?php
    require_once './../../../../connections/Account.php';
    session_start();
    $recipeID = $_POST['skill'];
    $recprice = $_POST['rec_price'];
    $family = $_SESSION['family_username'];
    echo count($recipeID);
    for($i = 0; $i < count($recipeID); $i++){
        $sql = 'SELECT * FROM `allrec` WHERE `ID` =  "'  . $recipeID[$i]['value'] .  '"';
        $result = mysqli_query($conn, $sql) or die($sql);
        $row = mysqli_fetch_array($result);

        $sql_acc = "SELECT ID FROM `chef_account` WHERE account = '" . $family . "'";
        $result_acc = mysqli_query($conn, $sql_acc) or die($sql_acc);
        $roe_acc = mysqli_fetch_array($result_acc);

        $sql_rec = "INSERT INTO `chef_recipe`(`cr_chef`, `cr_name`, `cr_img`, `price` , `type`, `heartattack`, `pneumonia`, `diabetes`, `Lower_respiratory_tract`, `hypertension`, `Nephritis`, `Liver`, `IsDefault`, `DefaultRecipeID`)";
        $sql_rec .= " VALUES ('" . $roe_acc['ID'] . "' , '" . $row['name'] . "' , '" . $row['img'] . "' , '" . $recprice . "' , '" . $row['type'] . "' , '" . $row['heartattack'] . "' , '" . $row['pneumonia'] . "' , '" . $row['diabetes'] . "' , '" . $row['Lower_respiratory_tract'] . "' , '" . $row['hypertension'] . "' , '" . $row['Nephritis'] . "' , '" . $row['Liver'] . "' , '1' , '" . $row['ID'] . "' )";
        mysqli_query($conn, $sql_rec) or die($sql_rec);

        $sql_r = "SELECT * FROM `chef_recipe` where `cr_chef` = '" . $roe_acc['ID'] . "' and cr_name = '" . $row['name'] . "'";
        $result_r = mysqli_query($conn, $sql_r) or die($sql_r);
        $row_r = mysqli_fetch_array($result_r);

        //食材新增
        $IngArr  = explode("、",$row['ing']);
        $NumArr  = explode("、",$row['num']);
        $unitArr = explode("、",$row['unit']);
        for($j = 0; $j < count($IngArr); $j++){
            $sql_ing = 'INSERT INTO `chef_recipe_ingredient`(`cri_recipe`, `cri_ingName`, `cri_ingNum`, `cri_ingUnit`) VALUES ("'  . $row_r['cr_ID'] .  '", "'  . $IngArr[$j] .  '","'. $NumArr[$j] .'","' . $unitArr[$j] . '")';
            mysqli_query($conn, $sql_ing) or die($sql);
        }
    }
    

?>
