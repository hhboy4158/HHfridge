<?php
//=============================================================
    session_start();
    require_once('./../../connections/Account.php');
    $family = $_SESSION['family_username'];
//=============================================================
    $Trebuchet = $_POST['Trebuchet'];
    $p_name = $_POST['p_name'];
//=============================================================
    $all_sick = array("","","","","心臟疾病","肺炎","糖尿病","慢性下呼吸道疾病","高血壓性疾病","腎臟病","變慢性肝病");
    $con = array("","","","",0,0,0,0,0,0,0);
    //echo $family.'<\br>';
    //echo $p_name;
    // $heartattack = 0;
    // $pneumonia = 0;
    // $diabetes = 0;
    // $Lower_respiratory_tract = 0;
    // $hypertension = 0;
    // $Nephritis = 0;
    // $Liver = 0;
    if(isset($family)){

        /*$sql = "UPDATE `personal_account` 
            SET heartattack = '$p1', pneumonia = '$p2', diabetes = '$p3', Lower_respiratory_tract = '$p4', hypertension = '$p5', Nephritis = '$p6', Liver = $p7 
            WHERE ID = '$p_name' AND Owner = (SELECT ID FROM family_account WHERE Username = '$family')";
        mysqli_qurey($conn, $sql) or die("0");*/
        foreach($Trebuchet as $i){
            for($j = 4; $j <= count($all_sick); $j++){
                if($i == $all_sick[$j]){
                    $con[$j] = 1;
                }
            }            
        }

        $sql = "UPDATE `personal_account` 
            SET heartattack = '$con[4]', pneumonia = '$con[5]', diabetes = '$con[6]', Lower_respiratory_tract = '$con[7]', hypertension = '$con[8]', Nephritis = '$con[9]', Liver = '$con[10]' 
            WHERE ID = '$p_name' AND Owner = (SELECT ID FROM family_account WHERE Username = '$family')";
        
        mysqli_query($conn, $sql) or die($sql);
        //echo $sql;
        echo 1;
        // echo '<pre>';
        // print_r($Trebuchet);
        // print_r($con);
        // echo '</pre>';
        
    }else{
        echo 0;
    }
    

    

?>