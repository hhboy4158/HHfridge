<?php
//===============================本檔案目前尚無用處===============================
session_start();
require_once '../connections/Account.php';
// ======================
$fid = $_POST["fid"];
// ======================
$sql = "SELECT * FROM `rec_step` WHERE rec_ID = $fid";
$result = mysqli_query($conn,$sql) or die($sql);
while($row = mysqli_fetch_row($result)){
    echo '<hr>
        <h1>'.$row[1].'</h1>
        <p>'.$row[2].'<p>
    ';
}