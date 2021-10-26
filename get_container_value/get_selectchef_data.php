<?php
require_once '../connections/Account.php';
$FunctionName = $_POST['functionName'];
$used = array();
switch($FunctionName){
    case "head":
        $id       = $_POST['chefid'];
        $sql      = "SELECT * FROM `chef_account` WHERE ID = $id";
        $result   = mysqli_query($conn, $sql) or die($sql);
        $row_chef = mysqli_fetch_array($result);
        echo '  <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">' . $row_chef["ChefFirstName"] . $row_chef['ChefName'] . '</h1>
                    <p class="lead text-muted">'. $row_chef['about'] .'</p>
                    <!--<p>到府服務需加收'. $row_chef['OnSiteService'] .'元服務費。</p>
                    <p>外送則需加收60元外送費。</p>-->
                    <p>總計: <input class="form-control" type="text" id="totalprice" value="0" readonly>
                        <button  class="btn btn-primary my-2" data-toggle="modal" data-target="#exampleModal" onclick="return modalprice(); return false;">
                            確認訂單資料<!--<a href="#" class="btn btn-primary my-2" data-toggle="modal" data-target="#pricemodal" onclick="return LoadPage(' ."'". 'checkprice' . "'" . ', ' . "'" . "'" . ',' . "'" .  'pricemodal' ."'" . ')">確認價格</a>-->
                        </button>
                        <!--<a href="#" class="btn btn-secondary my-2">Secondary action</a>-->
                    </p>
                </div>';
    break;

    case "recomm":
        $family_username = isset($_SESSION['family_username']) ? $_SESSION['family_username'] : null ;
        if($family_username == null){ 
            echo '<script>';
            echo 'window.location.href="./pages/login/login.php"';
            echo '</script>';
        }
        $f = "'" . $family_username  . "'";
  
        
        // 目前所有食譜名稱
        $allfood= array();
  
        // 能吃的食譜輕單
        $k7Foodname = array();
  
        // 不能吃的食譜輕單
        $bk7Foodname = array();
  
        // 能吃的食譜輕單的材料
        $arc = array();
  
        //所有食譜芬數全仲
        $c=array();
  
        //評分排序
        $sortedscore = array();
  
  
        //目前所有食譜
        $sql = "SELECT * FROM `chef_recipe`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
          array_push($allfood, $row['DefaultRecipeID']);
        }
  
  
        // 疾病處理
        // 使用者疾病
        $user = [0,0,0,0,0,0,0];
        // 疾病
        $pb = ['heartattack','pneumonia','diabetes','Lower_respiratory_tract','hypertension','Nephritis','Liver'];
        for ($i=0; $i < count($user); $i++) { 
            $sql = 'SELECT '.$pb[$i].' FROM `personal_account` WHERE Owner = (SELECT ID FROM family_account WHERE `Username` = "' . $family_username . '")';
            $result = mysqli_query($conn, $sql) or die($sql);
            // echo $sql;
            while ($row = mysqli_fetch_array($result)) {
                if ($row[0] != 0) {
                    $user[$i] = 1;
                }
            }
            if($user[$i] == 0){
                $user[$i] = "0 or 1";
            }
        }
        
        for ($i = 0; $i < count($allfood); $i++) {
  
          $sql2 ='SELECT * FROM `chef_recipe` WHERE (`IsDefault` = 1) and (`DefaultRecipeID` = "'.$allfood[$i].'")'.' and (`heartattack` = ' . $user[0] . ') and (`pneumonia` = ' . $user[1] . ') and (`diabetes` = ' . $user[2].') and (`Lower_respiratory_tract` = ' . $user[3] . ') and (`hypertension` = ' .$user[4] . ') and (`Nephritis` = ' . $user[5]. ') and (`Liver` = ' . $user[6] .')';
          $result1 = mysqli_query($conn, $sql2) or die($sql2);
          $row = mysqli_fetch_array($result1); 
          // echo $sql2 . "<br>";
          // 第一步 篩選疾病
          if (isset($row[0])) {
            // 存入食譜名稱
            array_push($k7Foodname, $row['DefaultRecipeID']);
          } else {
            //array_push($bk7Foodname, $row['DefaultRecipeID']);
          }
        }
        // echo '<pre>';
        // print_r($k7Foodname);
        // echo '</pre>';
  
        $sql = 'SELECT `ID`,`account`,`fid`,`recipe`,AVG(`foodscore`) FROM `score` GROUP by `fid` ORDER BY `foodscore` DESC';
        $result = mysqli_query($conn, $sql) or die($sql);
        while($row = mysqli_fetch_array($result)){
          array_push($sortedscore, $row['fid']);
        }
  
        $sortedscoreV2 = array();
        $ssCount = count($sortedscore);
        for($k = 0; $k <  count($sortedscore); $k++){
          // echo $k .". 比對: " . $sortedscore[$k] . '<br>';
          if(in_array($sortedscore[$k], $k7Foodname)){
            // echo $k . "." . $sortedscore[$k] . 'pushed<br>';
            // echo "in array: " . $sortedscore[$k].', <br>';
            array_push($sortedscoreV2, $sortedscore[$k]);
            // array_splice($sortedscore, $k, 1);//不要用 會出事
          } else {
            // echo "not in array: " . $sortedscore[$k].', <br>';
          }
        }
        // echo "<pre>";
        // print_r($sortedscore); 
        // echo "</pre>";
        // echo "<pre>";
        // print_r($sortedscoreV2); 
        // echo "</pre>";
        $wher = "";
        for($i = 0; $i < count($sortedscoreV2); $i++){
          if($i == count($sortedscoreV2) - 1){
            $wher .= "`DefaultRecipeID` = " . $sortedscoreV2[$i];
          } else {
            $wher .= "`DefaultRecipeID` = " . $sortedscoreV2[$i] . " or ";
          }
        }
  
  
        
  
        //最終列出評分過並篩選掉疾病的菜單
        $chef_id="";
        $id = $_POST['chefid'];
        $sql = 'SELECT * FROM `chef_recipe` WHERE  `cr_chef` = "' . $id . '" and (' . $wher . ')';//LIMIT 8
        
        
        $result = mysqli_query($conn, $sql)or die($sql);
        while($row = mysqli_fetch_array($result)){
          // $sql2 = 'SELECT `chef_recipe`.*, ChefName,ChefFirstName, cr_chef FROM `chef_recipe` INNER JOIN chef_account WHERE cr_name = "' . $row[2] . '" and `cr_chef` = chef_account.ID and  `cr_chef` = "' .$id . '"';
          // $result2 = mysqli_query($conn, $sql2) or die($sql2);
          
          echo '<div class="col-md-4">
                  <div class="card shadow-sm">
                  <image class="card-img-top embed-responsive-4by3" src="./images/'. $row['cr_img'].'" alt="123">
                      <div class="card-body">
                          <p class="card-text">$'. $row['price'].'</p>
                          <p class="card-text">'. $row['cr_name'].'</p>
                          <input type="hidden" id="price_' . $row['cr_ID'] . '" value="'. $row['price'].'">
                          
                          <div class="d-flex justify-content-between align-items-center">
                          <div class="input-group mb-3">
                              <div class="container">
                                  <div class="row">
                                      <div class="col-md-4 text-center">
                                          <input type="button" class="btn btn-secondary btn-lg" value="-" onclick="Sub('.$row['cr_ID'].')">
                                      </div>
                                      <div class="col-md-4 text-center">
                                          <!--<div class="input-group-prepend">
                                              <span class="input-group-text" id="basic-addon1">數量</span>
                                          </div>-->
                                          <input type="text" name="rec_recipe_name[]" id="rec_inputnumber_'. $row['cr_ID'] .'" class="form-control" value="0" readonly>
                                      </div>
                                      <div class="col-md-4 text-center">
                                          <input type="button" class="btn btn-secondary btn-lg" value="+" onclick="Add('.$row['cr_ID'].')">
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
              array_push($used, $row['cr_ID']);
        }
        // echo "<pre>";
        // print_r($used);
        // echo "</pre>";
        used_recipe($used);

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
                                                <input type="button" class="btn btn-secondary btn-lg" value="-" onclick="Sub('.$row_recipe['cr_ID'].');Synchronize_InputData('.$row_recipe['cr_ID'].')">
                                            </div>

                                            <div class="col-md-4 text-center">
                                                <input type="text" name="recipe_name[]" id="inputnumber_'. $row_recipe['cr_ID'] .'" class="form-control" value="0"  readonly>
                                            </div>

                                            <div class="col-md-4 text-center">
                                                <input type="button" class="btn btn-secondary btn-lg" value="+" onclick="Add('.$row_recipe['cr_ID'].');Synchronize_InputData('.$row_recipe['cr_ID'].')">
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
        // echo "加價:" . $add;
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
                echo '<input type="hidden" name="rid' . $row['cr_ID'] . '" value="' . $inp[$i] . '">';
                echo '  <tr>
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

    case "order":
        session_start();
        require_once './OrderNumberGenerator.php';
        $order_data  = $_POST['order_data'];
        $chefid      = $_POST['chefid'];
        $type        = $_POST['type'];
        $custid      = $_SESSION['family_username'];
        // $ArrayId = array();

        
        $countOrder = count($order_data);
        for($i = 0; $i < $countOrder; $i++){
            $subject = $order_data[$i]['name'];
            $search = 'rid' ;
            $trimmed = str_replace($search, '', $subject) ;
            $order_data[$i]['name'] = $trimmed;
        }

        $sql     = "SELECT `ID` FROM `family_account` WHERE `Username` = '$custid'";
        $result  = mysqli_query($conn, $sql) or die($sql);
        $row     = mysqli_fetch_array($result);
        $cust    = $row['ID'];
        
        //隨機產生不重複id(倒閉發臭)
        // $flag = 0;
        // while($flag != 1){
        //     //產生隨機id
        //     $randid = rand_id_4("uog_");
            
        //     $sql = "SELECT `ID` FROM `user_order_group` WHERE `ID` = '$randid'";//尋找資料庫是否存在剛產生的id
        //     $result = mysqli_query($conn, $sql) or die($sql);
        //     $rowcount = mysqli_num_rows($result);
            
        //     if($rowcount > 0){//如果$rowcount > 0, 表示資料庫中已存在該id, 繼續隨機產生, continue
        //         continue;
        //     } else {
        //         $flag = 1;
        //     }
            
        // }
        date_default_timezone_set('Asia/Taipei');
        $today = date('Ymd');
        
        switch($type){
            case "0":
                $typecode = "o";
                break;

            case "1":
                $typecode = "d";
                break;
        }
        
        $OrderNum = new OrderNumberGenerator;
        $getOrderNum = $OrderNum -> GetOrderNumber();
        // echo (String)$getOrderNum;
        //字串補齊 ex:"1" -> "00001"
        $getOrderNum = sprintf('%05d', $getOrderNum);
        $NewID = (String)$typecode . (String)$today . (String)$getOrderNum;
        // echo $NewID;
        
        
        $today = date('Y-m-d');

        $sql = "INSERT INTO `user_order_group`(`ID`, `cust_id`, `chef_id`, `type`, `date`) VALUES ('$NewID', '$cust', '$chefid', $type, '$today')";
        $result = mysqli_query($conn, $sql) or die($sql);

        

        for($i = 0; $i < $countOrder; $i++){
            $sql = "INSERT INTO `user_order`(`user_id`, `chef_id`, `data`, `quantity`,`order_id`) 
                    VALUES ('" . $cust . "','" . $chefid . "', '" . $order_data[$i]['name'] . "', '" . $order_data[$i]['value'] . "', '$NewID')";
            mysqli_query($conn, $sql) or die($sql);
        }
        echo "1";
    break;
}

/**
 * 隨機產生5組數字 回傳$randID
 */
function rand_id_4($id){
    $randID = $id;
    for($i = 0; $i < 4; $i++){
        $rand = rand(0, 9);
        $randID .= (string)$rand;
    }
    // echo $randID;
    return $randID;
}

function used_recipe($used_array){

}
?>