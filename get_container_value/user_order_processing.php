<?php
session_start();
require_once './../connections/Account.php';
$FunctionName = $_POST['FunctionName'];
$username = $_SESSION['family_username'];
switch($FunctionName){
    case "view":
        $order_id = $_POST['order_id'];
        $cust = $_SESSION['family_username'];

        $sql = "SELECT `ID` FROM `family_account` WHERE`Username` = '$cust'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row = mysqli_fetch_array($result);
        $custid = $row["ID"];
        // echo $order_id;
        // $sql = "SELECT `user_order_group` .*,SUM(`chef_recipe`.`price`) as price , CONCAT(`chef_account`.`ChefFirstName`, ' ', `chef_account`.`ChefName`) as `chefname`
        //         FROM `user_order_group` 
        //         inner join `user_order` ,`chef_recipe`, `chef_account`
        //         WHERE `user_order_group`.`ID` = `user_order`.`order_id`
        //         AND user_order.data = chef_recipe.cr_ID
        //         AND cust_id = '$custid'
        //         AND chef_account.ID = chef_recipe.cr_chef
        //         ORDER BY `user_order_group`.`date` DESC";
        // $result = mysqli_query($conn, $sql)or die($sql);
        $sql = "SELECT `status` FROM `user_order_group` WHERE `ID` = '$order_id'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $status = mysqli_fetch_array($result);

        $sql = "SELECT `user_order`.*, chef_recipe.price , chef_recipe.cr_name ,chef_recipe.cr_img
                    FROM `user_order` 
                    INNER JOIN `chef_recipe` 
                    WHERE chef_recipe.cr_ID = user_order.data 
                    AND user_order.order_id = '$order_id'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $count = 1;
        while($row = mysqli_fetch_array($result)){
                    echo '
                    <tr>
                        <td>' . $count . '</td>
                        <td><img src="./images/chef_recipe/' . $row['cr_img'] . '" width="100px" height="100px"></td>
                        <td>' . $row['cr_name'] . '</td>
                        <td>' . $row['quantity'] . '</td>
                        <td>' . $row['price'] . '</td>';
            if($status['status'] == 2){
                echo '  <td>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">⭐</label>
                                </div>'.
                                '<select class="custom-select" id="inputGroupSelect01" onchange="return chef_recipe_score(' . $row['data'] . ', this.options[this.options.selectedIndex].value); return false;">';
                                $sql_score = "SELECT `score` FROM `chef_recipe_score` WHERE `recipe_id` = " . $row['data'] . " AND `user_id` = " . $custid . "";
                                $result_score = mysqli_query($conn, $sql_score) or die($sql_score);
                                $row_score = mysqli_fetch_array($result_score);
                                switch($row_score['score']){
                                    case 1:
                                        echo'<option value="1"  selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>';
                                        break;

                                    case 2:
                                        echo'<option value="1">1</option>
                                            <option value="2" selected>2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>';
                                        break;

                                    case 3:
                                        echo'<option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3" selected>3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>';
                                        break;

                                    case 4:
                                        echo'<option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4" selected>4</option>
                                            <option value="5">5</option>';
                                        break;

                                    case 5:
                                        echo'<option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected>5</option>';
                                        break;

                                    default:
                                        echo'<option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>';
                                        break;

                                }
                                // echo'<option value="1">1</option>
                                //      <option value="2">2</option>
                                //      <option value="3" selected>3</option>
                                //      <option value="4">4</option>
                                //      <option value="4">5</option>';
                            echo '</select>'.
                           '</div>
                        </td>';                
            } else {
                echo   '<td>還不能進行評分!</td>';
            }
    
            echo    '</tr>';
            $count++;
        }
        
    break;

    case "score":
        $chef_recipe_id = $_POST['chef_recipe_id'];
        $score = $_POST['score'];
        $cust = $_SESSION['family_username'];

        $sql = "SELECT `ID` FROM `family_account` WHERE`Username` = '$cust'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row = mysqli_fetch_array($result);
        $custid = $row["ID"];

        $sql = "SELECT * FROM `chef_recipe_score` WHERE `recipe_id` = $chef_recipe_id and `user_id` = $custid";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row_num = mysqli_num_rows($result);
        if($row_num < 1){
            $sql = "INSERT INTO `chef_recipe_score`(`recipe_id`, `user_id`, `score`) VALUES (" . $chef_recipe_id . ", " . $custid . ", " . $score . ")";
            $result = mysqli_query($conn, $sql) or die($sql);
            echo '1';
        } else {
            $sql = "UPDATE `chef_recipe_score` SET `score`='$score' WHERE `recipe_id` = $chef_recipe_id AND `user_id` = $custid";
            $result = mysqli_query($conn, $sql) or die($sql);
            echo '0';
        }
        break;

    case "chefimage":
        $order_id = $_POST['order_id'];
        $sql = "SELECT * FROM user_order_group
                inner join	chef_account
                where user_order_group.`ID` = '$order_id'
                AND user_order_group.chef_id = chef_account.ID";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row = mysqli_fetch_array($result);
        echo '<img src="./images/users/' . $row['img'] . '" witch="300px" height="300px">';
        break;

    case "orderinfo":
        $order_id = $_POST['order_id'];
        $sql = "SELECT user_order_group.`ID`, user_order_group.status, concat(chef_account.ChefFirstName,chef_account.ChefName) as chefname, family_account.Username ,sum(chef_recipe.price * user_order.quantity) as totalprice  ,user_order_group.score
                FROM user_order_group 
                inner join chef_account, family_account, chef_recipe, user_order 
                where user_order_group.`ID` = '$order_id' 
                AND user_order_group.chef_id = chef_account.ID 
                AND user_order_group.cust_id = family_account.ID 
                AND user_order.order_id = user_order_group.ID 
                AND chef_recipe.cr_ID = user_order.data";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row = mysqli_fetch_array($result);
        echo '<h2>'.$row['chefname'].'</h2>';
        echo '<hr>';
        echo '<ul class="list-group text-left">';
        echo '<li class="list-group-item list-group-item-action">訂單編號 : ' . $row['ID'] . '</li>';
        switch($row['status']){
            case "0":
                echo '<li class="list-group-item list-group-item-action">狀態 : 訂單已送出</li>';
                break;
            case "1":
                echo '<li class="list-group-item list-group-item-action">狀態 : 餐點外送中</li>';
                break;
            case "2":
                echo '<li class="list-group-item list-group-item-action">狀態 : 餐點已送達</li>';
                break;
        }
        echo '<li class="list-group-item list-group-item-action">總價 : ' . $row['totalprice'] . '</li>';
        switch($row['status']){
            case "2":
                
                echo '<li class="list-group-item list-group-item-action">為訂單打分數 : ';

                $checked1 = "";
                $checked2 = "";
                $checked3 = "";
                $checked4 = "";
                $checked5 = "";
                switch($row['score']){
                    case "1":
                        $checked1 = " checked";
                        break;
                    case "2":
                        $checked2 = " checked";
                        break;
                    case "3":
                        $checked3 = " checked";
                        break;
                    case "4":
                        $checked4 = " checked";
                        break;
                    case "5":
                        $checked5 = " checked";
                        break;
                }
        echo   '<div class="form-check form-check-inline">
                    <input' . $checked1 .' class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" onchange="return order_score(' . "'" . $order_id . "'" . ',this); return false;">
                    <label class="form-check-label" for="inlineRadio1">1</label>
                </div>
                <div class="form-check form-check-inline">
                    <input' . $checked2 . ' class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2" onchange="return order_score(' . "'" . $order_id . "'" . ',this); return false;">
                    <label class="form-check-label" for="inlineRadio2">2</label>
                </div>
                <div class="form-check form-check-inline">
                    <input' . $checked3 . ' class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="3" onchange="return order_score(' . "'" . $order_id . "'" . ',this); return false;">
                    <label class="form-check-label" for="inlineRadio3">3</label>
                </div>
                <div class="form-check form-check-inline">
                    <input' . $checked4 . ' class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="4" onchange="return order_score(' . "'" . $order_id . "'" . ',this); return false;">
                    <label class="form-check-label" for="inlineRadio4">4</label>
                </div>
                <div class="form-check form-check-inline">
                    <input' . $checked5 . ' class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio5" value="5" onchange="return order_score(' . "'" . $order_id . "'" . ',this); return false;">
                    <label class="form-check-label" for="inlineRadio5">5</label>
                </div>
                
                </li>';
                break;
            default:
            echo '<li class="list-group-item list-group-item-action">還不能給訂單打分數😡</li>';
                break;
        }
        
        echo '<ul>';
        
        
        break;
    case "order_score":
        $orderid = $_POST['orderid'];
        $radiovalue = $_POST['radiovalue'];
        $sql = "SELECT family_account.Username ,family_account.ID
                FROM `user_order_group` 
                INNER join family_account 
                WHERE user_order_group.ID = '$orderid' 
                and user_order_group.cust_id = family_account.ID";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row = mysqli_fetch_array($result);
        if($row['Username'] != $username){
            echo '給我滾出去';
        } else {
            $sql = "UPDATE `user_order_group` 
                    SET `score`= $radiovalue 
                    WHERE `ID` = '$orderid' 
                    and `cust_id` = " . $row['ID'];
            mysqli_query($conn, $sql) or die($sql);
            // printf("Affected rows (UPDATE): %d\n", mysqli_affected_rows($conn));
            echo mysqli_affected_rows($conn);


        }

        break;
}
?>