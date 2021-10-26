<?php
//-------------------------------------------------

	session_start();
	require('./../../connections/Account.php');

//-------------------------------------------------

    $family_username = $_SESSION['family_username'];
    $selectObj = $_POST['selectObj'];
    $sick = array("心臟疾病","肺炎","糖尿病","慢性下呼吸道疾病","高血壓性疾病","腎臟病","變慢性肝病",);
    $sql = "SELECT * FROM `personal_account` WHERE`ID` ='$selectObj'";
    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_row($result)){
        for($i = 4; $i <= 10; $i++){
            $j = $i - 3;
            if($row[$i] == 1){
                echo '<p><label for="setProduct_'.$j.'"><input id="setProduct_'.$j.'" type="checkbox" checked value="'.$sick[$i - 4].'" style="zoom:180%" name="Product_x[]"> '.$sick[$i - 4].'<br></label></p>';
                $j = 0;
            }else if($row[$i] == 0){
                echo'<p><label for="setProduct_'.$j.'"><input id="setProduct_'.$j.'" type="checkbox" value="'.$sick[$i - 4].'" style="zoom:180%" name="Product_x[]">'.$sick[$i - 4].'<br></label></p>';
                $j = 0;
            }

        }
    }
    
?>