<?php
$dbhost = "120.118.166.218";
$dbname = "testdb";
$dbuser = "user";
$dbpass = "12345678";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die('無法開啟Mysql資料庫連結');
mysqli_query($conn, "SET CHARACTER SET UTF8") or die("完了");
mysqli_select_db($conn, $dbname);
?>