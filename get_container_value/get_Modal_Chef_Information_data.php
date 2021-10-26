<?php
require_once '../connections/Account.php';
$FunctionName = $_POST['functionName'];

switch($FunctionName){
    case "Information_body":
        $id       = $_POST['chef_id'];
        $sql      = "SELECT * FROM `chef_account` WHERE ID = $id";
        $result   = mysqli_query($conn, $sql) or die($sql);
        $row_chef = mysqli_fetch_array($result);
        echo '
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">' . $row_chef["ChefFirstName"] . $row_chef['ChefName'] . '的簡介</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="Modal_Chef_Infomation_Body">
      ';
        echo '
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img class="img-thumbnail" src="./images/users/' . $row_chef['img'] . '" alt="Card image cap" style="width:200px;height:200px;">
                    </div>
                    <div class="col-md-8">
                        <div class="card" style="height:200px;">
                            <div class="card-body">
                                <h2>' . $row_chef["ChefFirstName"] . $row_chef['ChefName'] . '</h2>
                                <li>住址: ' . $row_chef['address'] . '</li>
                                <li>電話: ' . $row_chef['phone'] . '</li>
                                <li>註冊日期: ' . $row_chef['signup_date'] . '</li>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">' . $row_chef['about'] . '</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
        echo '
        </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    <a class="btn btn-primary" href="./chefselect.php?chefid=' .   $row_chef['ID'] . '">訂購</a>
                </div>
        ';
        // echo '  <div class="col-lg-6 col-md-8 mx-auto">
        //             <h1 class="fw-light">' . $row_chef["ChefFirstName"] . $row_chef['ChefName'] . '</h1>
        //             <p class="lead text-muted">'. $row_chef['about'] .'</p>
        //             <!--<p>到府服務需加收'. $row_chef['OnSiteService'] .'元服務費。</p>
        //             <p>外送則需加收60元外送費。</p>-->
        //             <p>總計: <input class="form-control" type="text" id="totalprice" value="0" readonly>
        //                 <button  class="btn btn-primary my-2" data-toggle="modal" data-target="#exampleModal" onclick="return modalprice(); return false;">
        //                     確認訂單資料<!--<a href="#" class="btn btn-primary my-2" data-toggle="modal" data-target="#pricemodal" onclick="return LoadPage(' ."'". 'checkprice' . "'" . ', ' . "'" . "'" . ',' . "'" .  'pricemodal' ."'" . ')">確認價格</a>-->
        //                 </button>
        //                 <!--<a href="#" class="btn btn-secondary my-2">Secondary action</a>-->
        //             </p>
        //         </div>';
    break;

    case "recipe":

        $id         = $_POST['chefid'];
        $sql        = "SELECT * FROM `chef_recipe` WHERE `cr_chef` = $id";
        $result     = mysqli_query($conn, $sql) or die($sql);
        while($row_recipe = mysqli_fetch_array($result)){
            echo '  <div class="col-md-4">
                        <div class="card shadow-sm">
                        <image class="card-img-top embed-responsive-4by3" src="./images/'. $row_recipe['cr_img'].'" alt="123">
                            <div class="card-body">
                                <p class="card-text">$'. $row_recipe['price'].'</p>
                                <p class="card-text">'. $row_recipe['cr_name'].'</p>
                                <input type="hidden" id="price_' . $row_recipe['cr_ID'] . '" value="'. $row_recipe['price'].'">
                                
                                <div class="d-flex justify-content-between align-items-center">
                                <div class="input-group mb-3">
                                    <div class="container">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <input type="button" class="btn btn-secondary btn-lg" value="-" onclick="Sub('.$row_recipe['cr_ID'].')">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <!--<div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">數量</span>
                                            </div>-->
                                            <input type="text" name="recipe_name[]" id="inputnumber_'. $row_recipe['cr_ID'] .'" class="form-control" value="0" readonly>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <input type="button" class="btn btn-secondary btn-lg" value="+" onclick="Add('.$row_recipe['cr_ID'].')">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                
                                    <!--
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                    </div>
                                    <small class="text-muted">9 mins</small>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        ;

    break;

    case "checkprice":
        $inp     = $_POST['inps'];
        // $service = $_POST['service'];
        $id      = $_POST['chefid'];
        $add = 0;
        // switch($service){
        //     case "uber":
        //         $add = 60;
        //         break;
        //     case "home":
        //         $sql = "SELECT `OnSiteService` FROM `chef_account` where ID = $id";
        //         $result = mysqli_query($conn, $sql) or die($sql);
        //         $row = mysqli_fetch_row($result);
        //         $add = $row[0];
        //         break;
        // }
        echo "加價:" . $add;
        echo '  <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">菜單名稱</th>
                        <th scope="col">單價</th>
                        <th scope="col">數量</th>
                        <th scope="col">合計</th>
                    </tr>
                    </thead>
                    <tbody>';
        $i = 0;
        $total = 0;
        $sql     = "SELECT * FROM `chef_recipe` WHERE `cr_chef` = $id";
        $result  = mysqli_query($conn, $sql) or die($sql);
        while($row = mysqli_fetch_array($result)){
            if($inp[$i] == 0){
                $i++;
                continue;
            } else {
                $sum = $row['price'] * $inp[$i];
            echo '       <tr>
                            <th scope="row">#</th>
                            <td>' . $row['cr_name'] . '</td>
                            <td>' . $row['price'] . '</td>
                            <td>' . $inp[$i] . '</td>
                            <td>' . $sum . '</td>
                        </tr>';
            $i++;
            $total += $sum;
            }
            
        }
            echo '  </tbody>
                </table>';
        echo "總計: " . $total + $add . " 元";
        // echo "<pre>";
        // print_r($inp);
        // echo "</pre>";

    break;
}
?>