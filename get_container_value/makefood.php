<?php
session_start();
require_once '../connections/Account.php';

$fid = $_POST['fid'];
$x  = $_POST['x'];
echo $fid . $x;

?>