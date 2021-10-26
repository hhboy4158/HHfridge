<?php
    session_start();
    require_once './connections/Account.php';
    // ======================
    $fid = $_POST["fid"];
    $txt = "";
    // ======================
    $sql = "SELECT step, content FROM `rec_step` WHERE rec_ID = $fid";
    $result = mysqli_query($conn, $sql) or die($sql);
    while($row = mysqli_fetch_row($result)){
        $txt = $txt . '<hr>
                <h1>'.$row[0].'</h1>
                <p>'.$row[1].'<p>  
';
    }
    echo $txt;
    $sqq = "UPDATE `allrec` SET `step`= $txt WHERE id = $fid";
    mysqli_query($conn, $sqq) or die($sqq);
?>