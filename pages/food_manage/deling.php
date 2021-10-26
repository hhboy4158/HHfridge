<?php
// -----------------------------------------------
//connect to db
session_start();
require_once '../../connections/Account.php';

// -----------------------------------------------
//get post from 'fmanage.php'
$family_username = $_SESSION["family_username"];
$inputIng  = $_POST['food'];
// -----------------------------------------------

$sql = "DELETE  FROM `material` WHERE `foodname` = '$inputIng' AND `account` = '$family_username';";
$result = mysqli_query($conn, $sql);



?>