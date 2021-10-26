<?php

session_start();
require_once '../connections/Account.php';
// ======================
@$mid = $_POST["mid"];
@$session_chef_Id = $_SESSION['family_username'] ;
// ======================
if($mid == ""){
    $mid = 1;
}

// ======================

//include_once('./part/check_isChef.php');
$sql = "SELECT * FROM `chef_account` where account =  '$session_chef_Id'";
$result = mysqli_query($conn, $sql) or die($sql);
$row = mysqli_fetch_array($result);
if(isset($row[7]) and $row[7] == 0){
echo "<script>";
echo "window.href.location = './pages/chef_portfolio/phase_02.php'";
echo "</script>";
}

// ======================

$sql = "SELECT * FROM `t_menu`";
$result = mysqli_query($conn, $sql) or die($sql);
// $row = mysqli_fetch_assoc($result);
while($row = mysqli_fetch_array($result)){


    if(0)//$mid == $row[1]
    {
        echo '<li class="nav-item active"><a href="'.$row[3].'?item='.$row[1].'" class="nav-link">'.$row[2].'</a></li>';

    }else if($row[1] == 3){
        echo 
        '
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle drop" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$row[2].'</a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">
        ';
                  $sql2 = "SELECT `Name`,`ID` FROM `sick`;";
                  $result2 = mysqli_query($conn, $sql2);
                  while($row2 = mysqli_fetch_row($result2)){
                    echo '<a class="dropdown-item" href="'.$row[3].'?item='.$row[1].'&sick='.$row2[1].'">' . $row2[0] . '</a>';
                  }
        echo'
              </div>
          </li>
        ';
    }else if($row[1] == 2){
        echo '<li class="nav-item drop"><a href="'.$row[3].'?item='.$row[1].'&Pages=1" class="nav-link">'.$row[2].'</a></li>';
    }else{
        echo '<li class="nav-item drop"><a href="'.$row[3].'?item='.$row[1].'" class="nav-link">'.$row[2].'</a></li>';
    }
}


    echo '<li class="nav-item dropdown drop">';


        if (isset($_SESSION['family_username'])) {
            echo '
                <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $_SESSION['family_username'] . '</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                    <a class="dropdown-item " href="mykeep.php">
                        <i class="fas fa-heart"></i>
                        &nbsp;我的收藏
                    </a>
                    <a class="dropdown-item" href="user_manage.php">
                        <i class="fas fa-user-friends"></i>
                        &nbsp;子帳戶管理
                    </a>
                    <a class="dropdown-item" href="./order.php">
                        <i class="fas fa-file-alt"></i>
                        &nbsp;訂單紀錄</p>
                    </a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModalCenter">
                        <i class="fas fa-unlock-alt"></i>
                        &nbsp;修改密碼
                    </a>
                    <a class="dropdown-item" href="./pages/logout/logout.php">
                        <i class="fas fa-sign-out-alt"></i>
                        &nbsp;登出
                    </a>
                </div>';
            // unset($_SESSION['family_username']);
        } else {
            echo '
                <li class="nav-item"><a href="./pages/login/login.php" class="nav-link">登入</a></li>';
        }

    echo '</li>';