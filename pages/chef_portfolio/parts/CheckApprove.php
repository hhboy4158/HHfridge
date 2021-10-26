<?php
    $session_username = "'" . $_SESSION['family_username'] .  "'";
    $user_approve = 0;
    $sql = "SELECT account, approve FROM `chef_account`WHERE account = $session_username";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $user_approve = $row['approve'];

?>