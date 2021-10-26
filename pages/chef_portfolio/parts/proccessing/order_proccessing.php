<?php
session_start();
// require_once './../../../../connections/Account.php';
$FunctionName = $_POST['FunctionName'];
$username = $_SESSION['family_username'];
switch($FunctionName){
    case "cook":
        // $order_id = $_POST['order_id'];
        // $sql = "SELECT ID FROM `chef_account` WHERE `account` = '$username'";
        // $result = mysqli_query($conn, $sql) or die($sql);
        // $row = mysqli_fetch_array($result);
        // $chefid = $row['ID'];

        // $sql = "UPDATE `user_order` SET `status`='1' WHERE `id` = '$order_id' AND `chef_id` = '$chefid';";
        // $result = mysqli_query($conn, $sql) or die($sql);
        // if(!$result){
        //     echo "0";
        // } else {
        //     echo "1";
        // } 
        order_proccess($username,1);
    break;

    case "delivering":
        order_proccess($username,2);
    break;

    case "view":
        require_once './../../../../connections/Account.php';
        $order_id = $_POST['order_id'];
        $chef = $_SESSION['family_username'];

        $sql = "SELECT `ID` FROM `chef_account` WHERE`account` = '$chef'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row = mysqli_fetch_array($result);
        $chefid = $row["ID"];
        
        $sql = "SELECT `user_order`.*,chef_recipe.price ,chef_recipe.cr_name 
                    FROM `user_order` 
                    INNER JOIN `chef_recipe` 
                    WHERE chef_recipe.cr_ID = user_order.data 
                    AND user_order.order_id = '$order_id'";
        $result = mysqli_query($conn, $sql) or die($sql);
        while($row = mysqli_fetch_array($result)){
            echo '
            <tr>
                <th scope="row">' . $row['order_id'] . '</th>
                
                <td>' . $row['cr_name'] . '</td>
                <td>' . $row['quantity'] . '</td>
                <td>' . $row['price'] . '</td>
            </tr>
            ';
        }
        
    break;
}
/**
 * 更新訂單狀態(使用者id, 狀態)
 */
function order_proccess($username, $status){
    require_once './../../../../connections/Account.php';
    $order_id = $_POST['order_id'];
    $sql = "SELECT ID FROM `chef_account` WHERE `account` = '$username'";
    $result = mysqli_query($conn, $sql) or die($sql);
    $row = mysqli_fetch_array($result);
    $chefid = $row['ID'];

    $sql = "UPDATE `user_order_group` SET `status`='$status' WHERE `ID` = '$order_id' AND `chef_id` = '$chefid';";
    $result = mysqli_query($conn, $sql) or die($sql);
    if(!$result){
        echo "0";
    } else {
        echo "1";
    } 
}
?>