<?php
    session_start();
    require_once './../../../../connections/Account.php';
    if($_POST['rec_name'] != "" and $_POST['rec_price'] != "" and $_POST['rec_type'] != "" and $_POST['rec_info'] != "" and $_POST['rec_data'] != ""){
        if($_POST['rec_price'] != "1" and $_POST['rec_price'] != "2" and $_POST['rec_price'] != "3" and $_POST['rec_price'] != "4" and $_POST['rec_price'] != "5"){
            echo "2";
        }else{
            $account = "'" .  $_SESSION['family_username'] . "'";
            $name = "'" . $_POST['rec_name'] . "'";
            $price = "'" . $_POST['rec_price'] . "'";
            $type = "'" . $_POST['rec_type'] . "'";
            $info = "'" . $_POST['rec_info'] . "'";
            $ing = $_POST['rec_data'];


            $account_sql = 'SELECT ID FROM `chef_account` where`account` = ' . $account;
            $account_result = mysqli_query($conn, $account_sql) or die($account_sql);
            $account_row = mysqli_fetch_array($account_result);

            //新增食譜
            $sql = 'INSERT INTO `chef_recipe`( `cr_chef`, `cr_name`, `cr_about`, `price`, `type`) ';
            $sql .= 'VALUES (' . $account_row['ID'] . ',' . $name . ',' . $info . ',' . $price . ", " . $type . ' )';
            mysqli_query($conn, $sql) or die($sql);

            //取得該食譜的ID
            $recID_sql = 'SELECT `cr_ID` FROM `chef_recipe` where `cr_chef` = ' . $account_row['ID'] . ' and `cr_name` = ' . $name . 'and `cr_about` = ' . $info;
            $recID_result = mysqli_query($conn, $recID_sql) or die($recID_sql);
            $recID_row = mysqli_fetch_array($recID_result);
            
            //所有疾病 & 疾病不能吃的食材
            $sick_sql = "SELECT `Name`, `Noteat` FROM `sick`";
            $sick_result = mysqli_query($conn, $sick_sql) or die($sick_sql);

            $a_sick_hit = array(); //$a_sick_hit['心臟疾病'] = 0.3

            $b_InsertCount = 0;//值是F = 新增所有食材
            while($a_sick_row = mysqli_fetch_array($sick_result)){//7種疾病 固定7圈
                $i_ScoreCount = 0;
                $a_sick = explode("、", $a_sick_row['Noteat']);//所有該疾病不能吃的食材
                for($li_i = 0; $li_i < count($a_sick); $li_i++){//圈數 = 不能吃的食材數量
                    

                    for($i = 0; $i < count($ing); $i+=3){//圈數 = 食材數量
                        $ingname = "'" . $ing[$i]['value'] . "'";
                        $ingnum = "'" . $ing[$i + 1]['value'] . "'";
                        $ingunit = "'" . $ing[$i + 2]['value'] . "'";
                        if($ing[$i]['value'] == $a_sick[$li_i]){////比對食材 
                            $i_ScoreCount++;
                        }
                        if($b_InsertCount == 0){//設定成只新增一次，新增玩值變成True
                            //新增食材
                            $recING_sql = 'INSERT INTO `chef_recipe_ingredient`( `cri_recipe`, `cri_ingName`, `cri_ingNum`, `cri_ingUnit`)';
                            $recING_sql .= 'VALUES (' . $recID_row['cr_ID'] . ', ' . $ingname . ', ' . $ingnum . ', ' . $ingunit . ')';
                            $recING_result = mysqli_query($conn, $recING_sql) or die($recING_sql);
                        }
                    }
                    $b_InsertCount++;//新增所有食材一次就不再新增
                }
                // array_push($a_sick_hit[$sick_row['Name']], $i_ScoreCount );
                $a_sick_hit[$a_sick_row['Name']] = (1 - ($i_ScoreCount /  (count($ing) / 3))) * 100;
            }
            $s_upd_sick_sql  = "UPDATE `chef_recipe` SET `heartattack`= " . (int)$a_sick_hit['心臟疾病'] . ",`pneumonia`= " . (int)$a_sick_hit['肺炎'];
            $s_upd_sick_sql .= ",`diabetes`= " . (int)$a_sick_hit['糖尿病'] . " ,`Lower_respiratory_tract`= " . (int)$a_sick_hit['慢性呼吸道疾病'];
            $s_upd_sick_sql .= ",`hypertension`= " . (int)$a_sick_hit['高血壓性疾病'] . ",`Nephritis`= " . (int)$a_sick_hit['腎臟病'] . ",`Liver`=  " . (int)$a_sick_hit['肝病'] . " WHERE `cr_ID` = " . $recID_row['cr_ID'] . "";
            mysqli_query($conn, $s_upd_sick_sql) or die($s_upd_sick_sql);
            // echo "<pre>";
            // print_r($a_sick_hit);
            // echo "</pre>";

            echo "1";
        }

    }else{
        echo "0";
    }










    // for ($i=0; $i < $1個料理的總數; $i++) { 
    //     豆腐、雞蛋、柑橘、美生菜、奇異果、小黃瓜、玉米、檸檬、糖(料理)
    //     for ($j=0; $j < $1個疾病的總數; $j++) { 
            
    //         雞蛋、腦、內臟、魚子、糖、熱狗、香腸、肉乾、肉鬆、奶油、牛肉、豬肉、羊肉、培根、白麵粉、飯、米飯、白米飯 (疾病)

    //         if(豆腐 == 雞蛋)
    //         {
    //             $conn ++;
    //         }
    //     }
    // }
    // $conn
    // =============================================================
    // 1個料理的總數

    // >= 0.2 慢性病不能吃
    // 否則 可以吃



















    
?>