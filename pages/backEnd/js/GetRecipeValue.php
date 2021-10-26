<?php
require_once './../connections/Account.php';
$functionName = $_POST['functionName'];
switch($functionName){
    case "Name":
        $dataName = array();
        $sql = "SELECT `name` FROM `type` WHERE `name` != 'ALL'";
        $result = mysqli_query($conn, $sql) or die($sql);
        while($row = mysqli_fetch_array($result)){
            array_push($dataName, $row['name']);
        }
        echo json_encode($dataName);
    break;

    case "Count":
        $dataCount = array();
        $sql = "SELECT type.name, `type`, count(*) FROM `allrec` INNER JOIN type WHERE type.fid = allrec.type GROUP BY `type`";
        $result = mysqli_query($conn, $sql) or die($sql);
        while($row = mysqli_fetch_row($result)){
            array_push($dataCount, $row[2]);     
        }
        echo json_encode($dataCount);
    break;
}
?>