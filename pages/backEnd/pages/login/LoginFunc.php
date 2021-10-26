<?php
// session_start();
// require_once "./../../connections/Account.php";
require_once "./LoginClass.php";
switch ($_POST['functionName']) {
    case 'Login':
        if ($_POST['account'] != "" and $_POST['pwd'] != "") {
            $inputAccount  = $_POST['account'];
            $inputPassword = $_POST['pwd'];
            // 過瀘 SQL Injection
            $inputAccount  = preg_replace("/[\'\"]+/", '', $inputAccount);
            $inputPassword = preg_replace("/[\'\"]+/", '', $inputPassword);

            $login = new Login;
            $func = $login->loginsubmit($inputAccount, $inputPassword);
            echo $func;
            $login = NULL;
        }
        break;

        
    case "Logout":
        $logout = new Login;
        $log = $logout->logout();
        echo $log;
        $logout = NULL;
        break;

    case "ipck":

        $rootIp = "120.118.166.218";
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        // echo $ip;
        if($ip == $rootIp or $ip == "127.0.0.1" or $ip == "120.118.225.7")
        {  
            echo "1";
        }else{
            echo $ip;
        }



    break;
}
