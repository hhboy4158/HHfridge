<?php
class OrderNumberGenerator{


    function __construct(){
        @session_start();
    }

    /**
    *取得當天id的最大值
    */
    public function GetOrderNumber(){
        require_once './connections/Account.php';

        date_default_timezone_set('Asia/Taipei');
        $today = date('Ymd');

        $sql = "SELECT `ID` FROM `user_order_group` WHERE `ID` LIKE '%$today%'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $numrows = mysqli_num_rows($result);

        //若當天沒有任何編號 -> 回傳00001
        if($numrows === 0){
            return 1;
        } else {
            //找出當天所有id, push進$AllOrderIdArray
            $count = 0;
            $AllOrderIdArray = array();
            while($row = mysqli_fetch_array($result)){
                $AllOrderIdArray[$count] = substr($row['ID'], 9, 5);
                $count++;
            }
            
            //找出最大值
            $max = 0;
            for($i = 0; $i < count($AllOrderIdArray); $i++){
                if($AllOrderIdArray[$i] > $max){
                    $max = $AllOrderIdArray[$i];
                }
            }
            $max += 1;
            
            return (String)$max;
        }
    }
}
?>