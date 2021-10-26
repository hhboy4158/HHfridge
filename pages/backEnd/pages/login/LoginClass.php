<?php
// require_once "./../config/mysql.php";

/**
 * 登入
 */
class Login{
    // private $private_value = "private";


    /**
     * __init__
     */
    function __construct(){
        session_start();
    }


    /**
     * 呼叫私有function loginsubmit()
     */
    public function loginsubmit($account, $pwd){
        $log =  $this -> privatesubmit($account, $pwd);
        return $log;
    }


    /**
     * submit($a, $p)，$a = 帳號；$p = 密碼 執行完回傳0 or 1
     */
    private function privatesubmit($a, $p){
        require_once './../../connections/Account.php';
        $h_p = hash("sha256", $p);
        $sql = "SELECT * FROM `admin` WHERE `account` = '$a' and `password` = '$h_p'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            $row = mysqli_fetch_array($result);
            $_SESSION['admin'] = $row[1];
            return "0";
        }else{
            return "1";
        }
    }

    public function logout(){
        unset($_SESSION['admin']);
        return "0";
    }

    
    
}

?>