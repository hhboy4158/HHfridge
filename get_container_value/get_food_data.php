<?php

session_start();
require_once '../connections/Account.php';

// ==============================================
@$functionName = $_POST["functionName"];
@$fid = $_POST["fid"];
@$family = $_SESSION['family_username'];


switch ($functionName) {
  //首頁熱門資料
  case 'data':

    $sql = "SELECT * FROM `allrec` ORDER BY `total` DESC LIMIT 0,8;";
    $result = mysqli_query($conn, $sql);
    // 列印熱門資料
    while ($row = mysqli_fetch_array($result)) {
      echo
        '
            <div class="col-md-6 col-lg-3">
                <div class="product shadow ">
                    <a class="img-prod" onclick="totalFood(\'add\',\'' . $row[0] . '\')">
                    <img class="img-fluid rounded" src="./images/' . $row[4] . '" style="height:253px;"  alt="Colorlib Template">
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <h3>' . $row[1] . '</h3>
                    </div>
                    <div class="card-footer text-muted text-right">
                    <p style="font-size:8px;">點擊量:' . $row[13] . '</p>
                    </div>
                </div>
            </div>
            ';
    }
    break;

  //點擊量
  case "add":

    $fid = $_POST["fid"];
    $sql = "UPDATE `allrec` SET `total`= (`total`+1) WHERE `ID`='$fid';";
    mysqli_query($conn, $sql);


  break;

  
  case 'personal'://  0      1      2       3      4      5       6      7       8
    $sql = "SELECT a.name, a.ing, a.num, a.img, t.name, a.link, a.ID, a.step, a.unit FROM `allrec` as a INNER JOIN `type` as t WHERE a.`type` = t.fid AND a.`id` = '$fid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $rcpname = $row[0];
    echo '

          <div class="col-lg-8">
            <div class="row">
              <div class="col-md-8 mb-3 ftco-animate fadeInUp ftco-animated"><h2 class="mb-3">' . $row[0] . '</h2></div>
              <div class="col-md-4 mb-3 ftco-animate fadeInUp ftco-animated">
                <h2 class="mb-3 ">評分
                
                <h2>
                <input type="hidden" name="food_" value="' . $row[6] . '">
                <input type="hidden" name="food_" value="' . $row[0] . '">

                <div id="starBg" class="star_bg">
                    <input type="radio" id="starScore1' . $row[0] . '" class="score score_1" value="1" name="score">
                    <a class="star star_1" title="差"><label for="starScore1' . $row[0] . '">差</label></a>
                    <input type="radio" id="starScore2' . $row[0] . '" class="score score_2" value="2" name="score">
                    <a class="star star_2" title="較差"><label for="starScore2' . $row[0] . '">較差</label></a>
                    <input type="radio" id="starScore3' . $row[0] . '" class="score score_3" value="3" name="score">
                    <a class="star star_3" title="普通"><label for="starScore3' . $row[0] . '">普通</label></a>
                    <input type="radio" id="starScore4' . $row[0] . '" class="score score_4" value="4" name="score">
                    <a class="star star_4" title="較好"><label for="starScore4' . $row[0] . '">較好</label></a>
                    <input type="radio" id="starScore5' . $row[0] . '" class="score score_5" value="5" name="score">
                    <a class="star star_5" title="好"><label for="starScore5' . $row[0] . '">好</label></a>
                </div>

              </div>
            </div>
            <hr>
          <p>
            <img src="images/' . $row[3] . '" alt="" class="img-fluid rounded ftco-animate fadeInUp ftco-animated">
          </p>
          <hr>
          <p>更多料理方法: <a href="' . $row[5] . '" target="_blank"> 點我連結</a></p>
          <div class="tag-widget post-tag-container mb-5 mt-5">
            <div class="tagcloud">
              <a href="./allrec.php?Fclass=' . $row[4] . '" class="tag-cloud-link">' . $row[4] . '</a>
            </div>
          </div>
          <div class="tag-widget post-tag-container mb-5 mt-5">
          <div id="step">
          '.$row[7].'
          </div>
          </div>
        </div>
        <div class="col-lg-4 sidebar">
          <div class="sidebar-box ">
            <div class="container">
              <div class="row justify-content-center">
                <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="進行製作" data-toggle="modal" data-target="#makefoodModal">
              </div>
            </div>
        <hr>
          <p style="color:red; font-size:9px;">*若顏色為紅字，即代表您尚未擁有該食材*<p>
            <h3 class="heading">所需食材</h3>
              <ul class="categories">
              ';
    $ing_name = explode("、", $row[1]);
    //echo count($ing_name); 食材名稱 $ing_name[]陣列

    $ing_stock = explode("、", $row[2]);
    //echo count($ing_stock);  食材數量 $ing_stock[]陣列

    $ing_unit = explode("、", $row[8]);

    $sql = "";
    for ($i = 0; $i < count($ing_name); $i++) {
      $redtxt = "SELECT * FROM `material` WHERE account = '$family' AND foodname = '$ing_name[$i]'";
      $result = mysqli_query($conn, $redtxt);
      $row = mysqli_fetch_row($result);
      // echo $row[0];
      if(!isset($row[0]) or $row[2] == $ing_name[$i] and $row[3] < $ing_stock[$i]){
        echo '<li style="color:red;">' . $ing_name[$i] . ' <span>' . (isset($ing_stock[$i]) ? $ing_stock[$i] : null) .  '' . (isset($ing_unit[$i]) ? $ing_unit[$i] : null) .'</span></li>';
      }else if(isset($row[0]) and $row[2] == $ing_name[$i] and $row[3] >= $ing_stock[$i]){
        echo '<li>' . $ing_name[$i] . ' <span>' . (isset($ing_stock[$i]) ? $ing_stock[$i] : null) .  '' . (isset($ing_unit[$i]) ? $ing_unit[$i] : null) .'</span></li>';
      }
      // echo '<li>' . $ing_name[$i] . ' <span>(' . $ing_stock[$i] . ')</span></li>';
    };


    // 隨機三筆料理
    $sqltype = "SELECT type FROM `allrec` where id = $fid";
    $typeresult = mysqli_query($conn, $sqltype);
    $row_type = mysqli_fetch_row($typeresult);
    $sqlother = "SELECT * FROM `allrec`where type = $row_type[0] ORDER BY RAND() LIMIT 3";
    $result = mysqli_query($conn, $sqlother);
    echo '
                </ul>
              <hr>
                </div>
                  <div class="sidebar-box ">
                    <h3 class="heading">其他料理</h3>';
    while ($row = mysqli_fetch_row($result)) {
      echo '
                          <div class="block-21 mb-4 d-flex">
                            <a href="f_popular.php?fid=' . $row[0] . '" class="blog-img mr-4 rounded" style="background-image: url(images/' . $row[4] . ');"></a>
                            <div class="text">
                              <h3 class="heading-1"><br><a href="./f_popular.php?fid=' . $row[0] . '">' . $row[1] . '</a></h3>
                            </div>
                          </div>
                          
                          <hr>
                          ';
    }
    echo '
            </div>
          </div>

          <!-- makefood Modal -->
          <div class="modal fade bd-example-modal-lg" id="makefoodModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">製作 - ' . $rcpname . '</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form id="make_food" action="#" onsubmit="makefood('.$fid.'); return false">
                  <div class="modal-body">
                    <p style="color:red;">* 此功能僅只扣除您所擁有並且也足夠數量之食材。 *</p>
                    <table id="makerec" class="table table-bordered" >
                        <thead>
                          <tr>
                            <td scope="col">食材名稱</th>
                            <td scope="col">目前數量</th>
                            <td scope="col">扣除後數量</th>
                          </tr>
                        </thead>
                        <tbody>
                          ';
                          //使用者現有食材
                          $material = "SELECT * FROM `material` WHERE account = '$family'"; 
                          $result_m = mysqli_query($conn, $material);
                          
                          //迴圈數 = 食譜食材數量
                          for ($i = 0; $i < count($ing_name); $i++) {
                            
                              // echo "所需食材：" . $ing_name[$i];
                              // echo "所需數量：" . $ing_stock[$i];
                              // echo "現有食材：" . $row[2];
                              // echo "現有數量：" . $row[3];
                            $redtxt = "SELECT * FROM `material` WHERE account = '$family' AND foodname = '$ing_name[$i]'";
                            $result = mysqli_query($conn, $redtxt);
                            $row = mysqli_fetch_array($result);

                            if(isset($row[0])){//如果我有所需食材
                              echo "<tr>";
                              if($ing_name[$i] == $row['foodname'] and $ing_stock[$i] <= $row['quantity']){
                                // echo "所需食材：" . $ing_name[$i] . "(". $ing_stock[$i] . ")". "<br>";
                                // echo "現有食材：" . $row[0] . "," . $row[2] . "(". $row[3] . ")". "<br>";

                                //扣除後數量 = 現有數量 - 所需數量
                                $make = $row[3] - $ing_stock[$i];

                                //食材名稱
                                echo "<td >" . $row[2] . "</td>";
                                //現有數量
                                echo "<td  name='food_before' value=".$row[0].">". $row[3] . "</td>";

                                //扣除後數量
                                echo "<td name='123' value=".$row[0]." style='color:red;'>". $make . "</td>";

                                echo "<input type='hidden' name='ID_food' value='$row[0]'/>";
                                echo "<input type='hidden' name='food_after' value='$make'/>";
                              }
                              echo "</tr>";
                            }
                          }
                          echo '
                        </tbody>
                      </table>
                  </div><!-- modal-body -->
            
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    <button type="submit" class="btn btn-primary">製作</button>
                  </div><!-- footer -->
                </form>
              </div>
            </div>
          </div>
          <!-- makefood Modal -->

        ';
    break;
    //評分新增功能
    case "comment":


      // $family = $_SESSION['family_username'];

      if(isset($family)){
        
        $foodid = $_POST["food"];
        
        $foodname = $_POST["foodname"];
        
        $score = $_POST["score"];
        
        $sql = "INSERT INTO `score`( `account` ,`fid`,`recipe`, `foodscore`) VALUES ('$family','$foodid','$foodname','$score');";
        
        mysqli_query($conn,$sql);
        echo "1";

      }else{
        // header("Location:../pages/login/login.php");
        echo "0";
      }
      

    break;
    //食譜製作(暫時不用)
    case "make":

      $fid = $_POST["fid"];
      $foodUpdata = $_POST["foodUpdata"];
      // echo $fid.'<br>';
      $step = count($foodUpdata);

      if(isset($foodUpdata)){
        // echo $step;
        for($i = 0; $i < $step; $i += 2){
          // echo "ID:" . $foodUpdata[$i]['value'] ."\n";
          // echo "qty : " . $foodUpdata[$i + 1]['value'] . "\n";
          // echo "";
          $food_id = $foodUpdata[$i]['value'];
          $food_qty = $foodUpdata[$i + 1]['value'];
          $sql = "UPDATE `material` SET `quantity` = '$food_qty' WHERE `material`.`ID` = '$food_id';";    
          $result  = mysqli_query($conn, $sql) or die($sql);
        }
      }


      // echo '<pre>';
      // print_r($foodUpdata);
      // echo '</pre>';

      $a = $foodUpdata[$i]['value'];
      
      $sql= "$a";


      break;
    //modal 顯示食材
    case "check_recipe_ing":

      $recipeID_array = isset($_POST['formData']) ? $_POST['formData'] : [] ;
      
      // 使用者勾選喜好計算食材
      $name = array();
      $ing = array();
      $num = array();
      $unit = array();

      $total_ing = array();//所有所需食材
      $total_num = array();//所有所需食材之數量

      // 使用者食材
      // ====================
      $user_food = array();
      // ====================

      for($i = 0; $i < count($recipeID_array); $i++){
        $sql = 'select `name`, `ing`, `num`, `unit` from  `allrec` where id = ' . $recipeID_array[$i]['value'] ;
        
        $result = mysqli_query($conn, $sql) or die($sql);
        $row = mysqli_fetch_array($result);
        array_push($name, $row['name']);


        $ing = explode("、", $row['ing']);
        $num = explode("、", $row['num']);
        
        for($j = 0; $j < count($ing); $j++){  
          if(!in_array($ing[$j], $total_ing)){//若食材不重複 則 push食材至陣列

            array_push($total_ing, $ing[$j]);

            @$total_num[$ing[$j]] = (float)$num[$j];

          }else if(in_array($ing[$j], $total_ing)){//反之 若食材重複 則 該食材數量進行累加
            
            @$total_num[$ing[$j]] = $total_num[$ing[$j]] + (float)$num[$j];

          }
        }
      }

      $sql = "SELECT foodname, quantity FROM `material` where (account = '$family') and (";
      // 使用者食材與 食譜食材的比對
      $a = 0;
      for ($i = 0 ; $i < count($total_ing) ; $i++)
      {

        if($a == count($total_ing) - 1)
        {
          $sql .=" foodname = '$total_ing[$i]' );";
        }else{
          $sql .=" foodname = '$total_ing[$i]' or ";
        }
        
        $a ++;
      }

      // 計算使用者食材總數
      $result = mysqli_query($conn,$sql) or die(" ");
      while($row = mysqli_fetch_row($result)){
        
        // 比對食材是否再陣列裡面
        if(array_key_exists($row[0],$user_food)){
          // 食材累加
          $user_food[$row[0]] = $user_food[$row[0]] + $row[1];
        }else{
          // 創新的食材
          $user_food[$row[0]] = $row[1];
        }
      }

      $number = 1;
      //印出全部所需食材
      foreach($total_num as $key => $value){
        $ch = 0;
        // $a_little = array("少許", "一點點", "適量", "依個人喜好", "都可以", "剛好就好"); //6
        $a_little = array("少許", "適量"); //2
        if($value == 0){
          $rnd = rand(0,1);
          $value = $a_little[$rnd];
        }
        
        $red_output = 0;//檢查變數 若為 0(未擁有食材 or 食材數量足夠) 則 echo 黑字，  反之(擁有食材 且 數量不夠) 則 echo 紅字
        
        foreach($user_food as $user_key => $user_value){
          // echo $key . "、" . $user_key . "、" . $value . "、" . $user_value;

          //$key        => 所需食材名稱
          //$value      => 所需食材數量
          //$user_key   => 擁有食材名稱
          //$user_value => 擁有食材數量

          $require_ing = 3;
          if($key == $user_key and $value <= $user_value){ //擁有且足夠 黑字
            $red_output = 0;
            break;
          }else if(!array_key_exists($key, $user_food)){   //未擁有 紅字
            $require_ing = $value; // 缺少食材 直接等於 所需數量
            $red_output = 1;
            break;
          }else if(array_key_exists($key, $user_food) and $key == $user_key){ //數量不夠 橘字
            if(is_string($value)){
              $require_ing = $value;
              $red_output = 0;
            }else{
              $require_ing = $value - $user_value; // 缺少食材 = 所需食材 - 擁有食材
              $red_output = 2;
            }
            break;
          }
        }

        if($red_output == 0){ //黑字
          echo '<tr>
                  <th scope="row">' . $number  . '</th>
                  <td>' . $key . '</td>
                  <td>' . $value . '</td>
                  <td>-</td>
                </tr>';
        }else if($red_output == 1){ //紅字
          echo '<tr>
                  <th scope="row">' .$number  . '</th>
                  <td>' . $key . '</td>
                  <td>' . $value . '</td>
                  <td style="color:red;">' . $require_ing . '</td>
                  <input type="hidden" id="buy_' . $key . '" name="buy_name" value="' . $key . '">
                  <input type="hidden"  id="buy_'.$key. '_value" name="buy_value" value="' . $require_ing . '">
                </tr>';
        }else if($red_output == 2){ //橘字
          echo '<tr>
                  <th scope="row">' .$number  . '</th>
                  <td>' . $key . '</td>
                  <td>' . $value . '</td>
                  <td style="color:orange;">' . $require_ing . '</td>
                  <input type="hidden" id="buy_' . $key . '" name="buy_name" value="' . $key . '">
                  <input type="hidden" id="buy_'.$key. '_value" name="buy_value" value="' . $require_ing . '">        
                </tr>';
        }
        // <input type="hidden" name="buy_name" value="' . $key . '">
        // <input type="hidden" name="buy_value" value="' . $require_ing . '">
        
        $number ++;

      }


      
      // echo '<pre>';
      // print_r($name);
      // echo '</pre>';

      // echo '<pre>';
      // print_r($total_ing);
      // echo '</pre>';

      // 食材名稱 => key 數量 => value 
      // echo '<pre>';
      // print_r($total_num);
      // echo '</pre>';

      // echo '<pre>';
      // print_r($user_food);
      // echo '</pre>';

      // echo '<pre>';
      // print_r($unit);
      // echo '</pre>';
      break;
    
    //推薦分數表格
    case "Score_recom":
      $pages = empty($_POST['pages']) ? 1 :$_POST['pages'];
      //$show_row = 100;
      $sick = array();


      
      //$sql = "SELECT * FROM `allrec`  WHERE unit like '%、%' limit  ". ($pages - 1) * $show_row . ", " . $show_row . " ";
      $sql = "SELECT * FROM `allrec`";
      $result = mysqli_query($conn, $sql)or die($sql);
      $count  = 0;
      echo '<tbody>';
      while($row = mysqli_fetch_array($result)){//每道食譜

        echo '<tr>
                <td>' . $row['ID']   . '</td>
                <td>' . $row['name'] . '</td>';


        ////////////////////////////食材///////////////////////////
        echo '<td>';
        $array_ing = explode("、", $row['ing']);//食譜所需食材切割'
        for($i = 0; $i < count($array_ing); $i++){//食材
          if($i == count($array_ing) - 1){
            echo $array_ing[$i];
          }else{
            echo $array_ing[$i]  . "、 ";
          }
        }
        echo '</td>';
        ///////////////////////////////////////////////////////


        $sql_sick = "SELECT `ID`, `Name`, `Noteat` FROM `sick`";
        $result_sick = mysqli_query($conn, $sql_sick) or die($sql_sick);
        $arr = array();//sickarr
        while($row_sick = mysqli_fetch_array($result_sick)){//7個疾病
          // echo "<script>
          //         console.log(" . $row_sick['Name'] . " + " . $row_sick['Noteat'] . ");
          //       </script>
          // ";                                                 [索引、疾病名稱]['疾病不能吃的食材']
          $sick[$row_sick['Name']] = $row_sick['Noteat'];//ex: $sick['心臟疾病']['雞蛋、腦、內臟、、......、白米']
          $count = 0;//擊中計數器
          $tt_ing = array(); //$tt_ing = 陣列['食譜中被擊中的食材']
          //
          for($j = 0; $j < count($array_ing); $j++){//食譜食材數量迴圈，每道食材
            $sick_ing_cut = explode("、", $sick[$row_sick['Name']]); //$sick['心臟疾病']['雞蛋、腦、內臟、、......、白米']食材切割，頓點隔開

            for($k = 0; $k < count($sick_ing_cut); $k++){//疾病不能吃食材迴圈
              if($array_ing[$j] == $sick_ing_cut[$k]){// 食譜食材 = 疾病不能吃食材
                $count++;//有擊中 count++
                array_push($tt_ing, $array_ing[$j]); //被擊中的食材丟進陣列$tt_ing
              }
            }
          //陣列相互比對後，最後擇一處理
          (float)$tt = (1 - ($count / count($array_ing)));//1 - (被擊中數量 / 總食譜數量) 小數點顯示
          $tt_str = $count . " / " . count($array_ing); //被擊中數量 / 總食譜數量 字串顯示
          $Percent = (string)round($tt,2) * 100;  //被擊中數量 / 總食譜數量 字串顯示
          $imp_tt_ing = implode("、", $tt_ing);         //輸出陣列，頓點隔開
            // round($tt,2)
          }
          //門檻
          if((integer)$Percent >= 90){
            array_push($arr,1);
            $k = 1;
          }else{
            array_push($arr,0);
            $k = 0;
          }
          
          // echo $ing_cut;
          //echo "<td> " . $imp_tt_ing . "</td>"; //輸出
          echo "<td> " .$Percent . "</td>"; //百分比
          // echo "<td> " . $tt_str . "</td>"; // 
        }
        $sq = "UPDATE `allrec` SET `heartattack`='" . $arr[0] . "',`pneumonia`='" . $arr[1] . "',`diabetes`='" . $arr[2] . "',`Lower_respiratory_tract`='" . $arr[3] . "',`hypertension`='" . $arr[4] . "',`Nephritis`='" . $arr[5] . "',`Liver`='" . $arr[6] . "' WHERE `ID` = '" .  $row['ID'] . "'";
        mysqli_query($conn,$sq)or die($sq);
        echo "</tr>";
      }




      //計算主廚自訂料理.推薦分數
      $sql = "SELECT * FROM `chef_recipe` where `IsDefault` = '" . 0 .  "'";
      $result = mysqli_query($conn, $sql)or die($sql);
      $count  = 0;
      while($row = mysqli_fetch_array($result)){//每道食譜

        echo '<tr>
                <td>' . $row['cr_ID']   . '</td>
                <td>' . $row['cr_name'] . '</td>';
        ////////////////////////////食材///////////////////////////

        echo '<td>';
        $sql_ing = "SELECT * FROM `chef_recipe_ingredient` WHERE  `cri_recipe` = '" . $row['cr_ID'] . "'";
        $result_ing = mysqli_query($conn, $sql_ing) or die($sql_ing);
        $array_ing = array();
        while($row_ing = mysqli_fetch_array($result_ing)){
          array_push($array_ing, $row_ing['cri_ingName']);
        }
        //$array_ing = explode("、", $row['cr_ing']);//食譜所需食材切割'
        for($i = 0; $i < count($array_ing); $i++){//食材
          if($i == count($array_ing) - 1){
            echo $array_ing[$i];
          }else{
            echo $array_ing[$i]  . "、 ";
          }
        }
        echo '</td>';

        ///////////////////////////////////////////////////////
        $sql_sick = "SELECT `ID`, `Name`, `Noteat` FROM `sick`";
        $result_sick = mysqli_query($conn, $sql_sick) or die($sql_sick);
        $arr = array();//sickarr
        while($row_sick = mysqli_fetch_array($result_sick)){//7個疾病
          // echo "<script>
          //         console.log(" . $row_sick['Name'] . " + " . $row_sick['Noteat'] . ");
          //       </script>
          // ";                                                 [索引、疾病名稱]['疾病不能吃的食材']
          $sick[$row_sick['Name']] = $row_sick['Noteat'];//ex: $sick['心臟疾病']['雞蛋、腦、內臟、、......、白米']
          $count = 0;//擊中計數器
          $tt_ing = array(); //$tt_ing = 陣列['食譜中被擊中的食材']
          //
          for($j = 0; $j < count($array_ing); $j++){//食譜食材數量迴圈，每道食材
            $sick_ing_cut = explode("、", $sick[$row_sick['Name']]); //$sick['心臟疾病']['雞蛋、腦、內臟、、......、白米']食材切割，頓點隔開

            for($k = 0; $k < count($sick_ing_cut); $k++){//疾病不能吃食材迴圈
              if($array_ing[$j] == $sick_ing_cut[$k]){// 食譜食材 = 疾病不能吃食材
                $count++;//有擊中 count++
                array_push($tt_ing, $array_ing[$j]); //被擊中的食材丟進陣列$tt_ing
              }
            }
          //陣列相互比對後，最後擇一處理
          (float)$tt = (1 - ($count / count($array_ing)));//1 - (被擊中數量 / 總食譜數量) 小數點顯示
          $tt_str = $count . " / " . count($array_ing); //被擊中數量 / 總食譜數量 字串顯示
          $Percent = (string)round($tt,2) * 100;  //被擊中數量 / 總食譜數量 字串顯示
          $imp_tt_ing = implode("、", $tt_ing);         //輸出陣列，頓點隔開
            // round($tt,2)
          }
          if((integer)$Percent >= 90){
            array_push($arr,1);
            $k = 1;
          }else{
            array_push($arr,0);
            $k = 0;
          }
          // array_push($arr,$Percent);
          // echo $ing_cut;
          //echo "<td> " . $imp_tt_ing . "</td>"; //輸出
          echo "<td> " . $Percent . "</td>"; //百分比
          // echo "<td> " . $tt_str . "</td>"; // 
        }
        $sq_s = "UPDATE `chef_recipe` SET `heartattack`='" . $arr[0] . "',`pneumonia`='" . $arr[1] . "',`diabetes`='" . $arr[2] . "',`Lower_respiratory_tract`='" . $arr[3] . "',`hypertension`='" . $arr[4] . "',`Nephritis`='" . $arr[5] . "',`Liver`='" . $arr[6] . "' WHERE `cr_ID` = '" . $row['cr_ID'] . "'";
        mysqli_query($conn,$sq_s)or die($sq_s);
        echo "</tr>";
      }

      echo '</tbody>';
      break;

    //外 - 主廚推薦
    case "chef_recommendation":
      $name = array();
      $type = array();
      $EveryChefRecipeIng = array();
      $chef_score = array();
      $recipe = isset($_POST['formData']) ? $_POST['formData'] : [] ;
      
      //每道食譜
      
      for($i = 0; $i < count($recipe); $i++){
        $sql_cr1 = "select a.`name`as Aname, a.`ing`, a.`num`, a.`img`, a.`unit`,a.`type`,t.name as Tname from `allrec`as a INNER join type as t where a.id = " . $recipe[$i]['value'] . " and a.type = t.fid";
        // $sql_cr1 = "";
        $result_cr1 = mysqli_query($conn, $sql_cr1) or die($sql_cr1);
        $row_cr1 = mysqli_fetch_array($result_cr1);
        $c = 0;
        
        //取得食材
        $recipe_ing[$row_cr1['Aname']] = explode("、", $row_cr1['ing']);
        // echo "原食譜: " . $row_cr1['Aname'] . "<br>";
        
        //尋找相同專長廚師
        $sql_cr2 = "SELECT `ID`, ChefFirstName, `ChefName`,`img` FROM `chef_account` as ca INNER join chef_skill as cs where cs.chef_type = " . "'" . $row_cr1['type'] . "'" . " and ca.ID = cs.chef_ID";
        $result_cr2 = mysqli_query($conn, $sql_cr2) or die($sql_cr2);
        $price = 0;


        while($row_cr2 = mysqli_fetch_array($result_cr2)){
          $top_similar = 0;
          $chef_similar = 0;

          $sql_AVG = "SELECT AVG(`score`) FROM `chef_score` WHERE chef_ID = '" . $row_cr2['ID'] . "'";
          $sql_AVG = "SELECT avg(`score`) FROM `user_order_group` WHERE `chef_id` = " . $row_cr2['ID'] . " GROUP BY chef_id";
          $result_AVG = mysqli_query($conn, $sql_AVG) or die($sql_AVG);
          $row_AVG = mysqli_fetch_row($result_AVG);
          $rat =  is_null($row_AVG) ? 0 : round($row_AVG[0], 2);
          

          // $ChefPriceAVG = 'SELECT AVG(price) FROM `chef_recipe` WHERE cr_chef = ' . $row_cr2['ID'];
          // $result_CPA = mysqli_query($conn, $ChefPriceAVG) or die($ChefPriceAVG);
          // $row_CPA = mysqli_fetch_row($result_CPA);
          // $PRICEAVG = round($row_CPA[0], 2);

          //每個廚師的食譜
          $sql_cr3 = "SELECT `cr_ID`, `cr_name`, `price` FROM `chef_recipe` WHERE `cr_chef` = '" . $row_cr2['ID'] . "' and type = " . "'" . $row_cr1['type'] . "'";
          $result_cr3 = mysqli_query($conn, $sql_cr3) or die($sql_cr3);
          
          while($row_cr3 = mysqli_fetch_array($result_cr3)){
            $count = 0;//分子 
            //每個食譜的食材
            $sql_cr4 = "SELECT cri.`cri_ingName`,cr.cr_name FROM `chef_recipe_ingredient` as cri INNER join chef_recipe as cr WHERE cri_recipe = cr.cr_ID and cr.cr_ID =" . $row_cr3['cr_ID'];
            $result_cr4 = mysqli_query($conn, $sql_cr4) or die($sql_cr4);
            $j = 0;
            while($row_cr4 = mysqli_fetch_array($result_cr4)){
              $EveryChefRecipeIng[$row_cr3['cr_name']][$j] = $row_cr4['cri_ingName'];
              $j++;
            }//end每個食譜的食材
            
            //比對
            // echo count($EveryChefRecipeIng[$row_cr3['cr_name']]) . ":" . count($recipe_ing[$row_cr1['Aname']]) . "<br>";
            // for($k = 0; $k < count($EveryChefRecipeIng[$row_cr3['cr_name']]); $k++){
            //   for ($h = 0; $h < count($recipe_ing[$row_cr1['Aname']]); $h++) { 
            //     // if($EveryChefRecipeIng[$row_cr3['cr_name']][$k] == $recipe_ing[$row_cr1['Aname']][$h]){
            //     if(in_array($recipe_ing[$row_cr1['Aname']][$h], $EveryChefRecipeIng[$row_cr3['cr_name']])){
            //       $count++;
            //     }
            //   }
            // }
            //$count = 0;
            // (count($EveryChefRecipeIng[$row_cr3['cr_name']]) < count($recipe_ing[$row_cr1['Aname']])) ? count($EveryChefRecipeIng[$row_cr3['cr_name']]) : count($recipe_ing[$row_cr1['Aname']]) ;
            $loopcount = count($recipe_ing[$row_cr1['Aname']]);
            // echo $loopcount;
            for ($h = 0; $h < $loopcount; $h++) { 
              if(in_array($recipe_ing[$row_cr1['Aname']][$h], $EveryChefRecipeIng[$row_cr3['cr_name']])){
                $count++;
              }
            }

            $chef_similar = $count / count($recipe_ing[$row_cr1['Aname']]);

            
            // echo "被比對的廚師食譜: " . $row_cr3['cr_name'] . "、";
            // echo "被比對的廚師: " . $row_cr2['ChefName'] . "\n  ";
            // echo $count . "/" . count($recipe_ing[$row_cr1['Aname']]) . "\n ";
            // echo "相似度: " . $count / count($recipe_ing[$row_cr1['Aname']]) . "<br>";
            if($chef_similar > $top_similar){
              $top_similar = $chef_similar;
              $price = $row_cr3['price'];
              $chefs_Most_similar_recipe = $row_cr3['cr_name'];//chefs_Most_similar_recipe
            }
          }//end每個廚師的食譜
          // echo $top_similar ."</br>";
          if($top_similar != 0 and $c < 3){
            $c++;
            $chef_score[$row_cr1['Aname']][$row_cr2['ID']]['ID']   = ($top_similar == null) ? 0 : round($top_similar,1) ;
            $chef_score[$row_cr1['Aname']][$row_cr2['ID']]['Rate'] = ($rat == null) ? 0 : $rat;
            $chef_score[$row_cr1['Aname']][$row_cr2['ID']]['name'] = ($row_cr2['ChefFirstName'] == null) ? "" : $row_cr2['ChefFirstName']  .  $row_cr2['ChefName'];
            $chef_score[$row_cr1['Aname']][$row_cr2['ID']]['img']  = ($row_cr2['img'] == null) ? "" : $row_cr2['img'];
            $chef_score[$row_cr1['Aname']][$row_cr2['ID']]['price'] = ($price == null) ? 0 : $price;
            $chef_score[$row_cr1['Aname']][$row_cr2['ID']]['chefs_Most_similar_recipe'] = ($chefs_Most_similar_recipe == null) ? 0 : $chefs_Most_similar_recipe;
            $chef_score[$row_cr1['Aname']][$row_cr2['ID']]['chefID'] = ($row_cr2['ID'] == null) ? "" : $row_cr2['ID'];
            $chef_score[$row_cr1['Aname']][$row_cr2['ID']]['total_score'] =(($rat == null) ? 0 : $rat) * 2 + (($top_similar == null) ? 0 : round($top_similar,1) * 10);
          }      
          // echo "chefid: " . $row_cr2['ID'];
          // echo "rat: ".(($rat == null) ? 0 : $rat);
          // echo ", sim:" . (($top_similar == null) ? 0 : round($top_similar,1) * 5);
          // echo ", tt: ".(($rat == null) ? 0 : $rat) + (($top_similar == null) ? 0 : round($top_similar,1) * 5);
          // echo '</br></br>';
        }//end尋找相同專長廚師
        

      
        try{
          (empty($chef_score)) ?  : arsort($chef_score[$row_cr1['Aname']]) ;
        }catch(TypeError $e){
          // do nothing
        }

      }//end每道食譜

      (empty($chef_score)) ?  : arsort($chef_score) ;
      // echo "<pre>";
      // print_r($chef_score);
      // echo "</pre>";
      $total_chef_score = array();
      $total_chef_img = array();
      $total_chef_id = array();
        if(!empty($chef_score)){
          $forcount = 0;
          foreach($chef_score as $key => $value){
            $forcount++;
            $sql = "SELECT `img`FROM `allrec` where `name` = '" . $key . "'";
            $result = mysqli_query($conn, $sql);
            $rowimg = mysqli_fetch_array($result);
            // echo '
            // <div class="card-body text-center">
            //   <h5 class="card-title">' . $key . '</h5>
            // </div>
            // <div id="recipe_img"style="height:180px; width:auto;background-image: url(' . './images/' . $rowimg['img'] .  ');background-size: cover;">
            //   <div class="card-img-overlay"style="position:static;">
            //     <!--<h5 class="card-title">' . $key . '</h5>-->
            //   </div>
            // </div>
            // <div class="card-body">
            //     <h5 class="card-title">適合做「' . $key . '」的廚師有:</h5>
            //     <div class="row">';
            if(is_array($value)){
              if(!empty($value)){
                
                foreach($value as $k => $v){
                  @$total_chef_score[$v['name']]['similar_score'] += ($v['ID'] * 10);
                  @$total_chef_score[$v['name']]['user_rate'] = ($v['Rate'] * 2);
                  @$total_chef_score[$v['name']]['total'] += $v['total_score'];
                  @$total_chef_score[$v['name']]['chefID'] = $v['chefID'];
                  $total_chef_img[$v['name']] = $v['img'];
                  $total_chef_id[$v['name']]  = $k;
                  // echo '<div class="col-12 col-lg-4">
                  //         <div class="product text-center">
                  //             <a href="./pages/chef_portfolio/chef_detail.php?name=' . $k . '"
                  //                 class="img-prod">
                  //                 <img class="img-fluid" src="images/users/' . $v['img'] . '"
                  //                     style="width:253px; height:254px;"
                  //                     alt="Colorlib Template">
                  //                 <span class="status">' . $v['ID'] . '%</span>
                  //                 <!--<div class="overlay"></div>-->
                  //             </a>
                  //             <div class="text py-3 pb-4 px-3 text-center">
                  //                 <h3>
                  //                     <a href="./pages/chef_portfolio/chef_detail.php?name=' . $k . '">' . $v['name'] .'</a>
                  //                 </h3>
                                  
                  //                 <div class="d-flex">
                  //                     <div class="pricing">
                  //                         <p class="price">
                  //                             <span>推薦分數: ' . $v['ID'] . '</span>  
                  //                         </p>
                  //                         <p class="price">
                  //                           <span>評分分數: ' . $v['Rate'] . '</span>
                  //                         </p>
                  //                         <p class="price">
                  //                           <span>預期價格:  ' . $v['price'] . '</span>
                  //                         </p>
                  //                         <p class="price">
                  //                           <span>相似食譜:  ' . $v['pr15'] . '</span>
                  //                         </p>
                  //                     </div>
                  //                 </div>
                  //                 <div class="bottom-area d-flex px-3">
                  //                   <div class="m-auto d-flex">
                  //                   <a href="./chefselect.php?chefid=' .  $v['chefID'] . '">
                  //                     <button type="button" class="btn btn-secondary">選擇' .  $v["name"] . '</button>
                  //                   </a>
                  //                     <!--<button type="button" class="btn btn-secondary" 
                  //                     data-toggle="modal" data-target="#ModalChefRecipeCheck"
                  //                     onclick="return getthischefrecipe(' . $k . '); return false;">選擇' . $v["name"] . '</button>-->
                  //                   </div>
                  //                 </div>
                  //             </div>
                  //         </div>
                  //     </div>';
                }
                
              }else{//if(!empty($value))
                echo 'negative.';
              }
              
            }else{//if(is_array($value))
              echo "沒有與該食譜匹配的廚師!";
            }
            echo
            '   </div>
            </div>
            <hr>
                  ';
          }
          
        }else{
          echo '
          <div class="card text-center">
            <div class="card-header">
              ERROR
            </div>
            <div class="card-body">
              <h5 class="card-title">Division by zero.</h5>
              <p class="card-text">請先勾選菜品</p>
              <button type="button" data-dismiss="modal" class="btn btn-secondary">好吧</button>
            </div>
          </div>
          ';
        }
        // echo "<pre>";
        // print_r($total_chef_score);
        // echo "</pre>";

        # get a list of sort columns and their data to pass to array_multisort
        // $sort = array();
        // foreach($total_chef_score as $k=>$v) {
        //     $sort['total'][$k] = $v['total'];
        //     $sort['chefID'][$k] = $v['chefID'];
        // }
        // echo "<pre>";
        // print_r($sort);
        // echo "</pre>";
        # sort by event_type desc and then title asc
        // array_multisort($sort['total'], SORT_DESC, $sort['chefID'], SORT_ASC,$total_chef_score);
        (empty($total_chef_score)) ?  : arsort($total_chef_score);
        // (empty($total_chef_score)) ?  : array_multisort($total_chef_score['total'], SORT_DESC);
        // echo "<pre>";
        // print_r($total_chef_score);
        // echo "</pre>";
        echo '<div class="row">';
        $score_count = 1;
        foreach($total_chef_score as $total_k => $total_v){
          echo '<div class="col-12 col-lg-4">
                  <div class="product text-center">
                      <a href="#" onclick="order_post(' .  $total_v['chefID'] . ', ' . "'" . $total_k . "'" . ')"
                          class="img-prod">
                          <img class="img-fluid" src="images/users/' . $total_chef_img[$total_k] . '"
                              style="width:253px; height:254px;"
                              alt="Colorlib Template">
                          <span class="status">No.' . $score_count . '</span>
                          <!--<div class="overlay"></div>-->
                      </a>
                      <div class="text py-3 pb-4 px-3 text-center">
                          <h3>
                          <input type="hidden" id="chef_0' . $score_count . '" value="' . "'" . $total_k . "'" . '">
                              <a href="#" onclick="order_post(' . $total_v['chefID'] . ', ' . "'" . $total_k . "'" . ')">' . $total_k .'</a>
                          </h3>
                          
                          <div class="d-flex">
                              <div class="pricing">
                                  <p class="price">
                                      <div>
                                        <span>相似度分數: ' . number_format( $total_v['similar_score'] / $forcount, 2) . '</span> </br> 
                                        <input type="hidden" id="similar_0' . $score_count . '" value="' . number_format( $total_v['similar_score'] / $forcount, 2) . '">
                                      </div>
                                      <div >
                                        <span>評分分數: ' . number_format( $total_v['user_rate'], 2) . '</span>  </br>
                                        <input type="hidden" id="rate_0' . $score_count . '" value="' . number_format( $total_v['user_rate'], 2) . '">
                                      </div>
                                      <div >
                                        <span>推薦分數: ' . number_format( $total_v['total'] / $forcount, 2) . '</span>  
                                        <input type="hidden" id="total_0' . $score_count . '" value="' . number_format( $total_v['total'] / $forcount, 2) . '">
                                      </div>
                                  </p>
                              </div>
                          </div>
                          <div class="bottom-area d-flex px-3">
                            <div class="m-auto d-flex">
                            <!--<a href="./chefselect.php?chefid=' .  $v['chefID'] . '">
                              <button type="button" class="btn btn-secondary">選擇' .  $v["name"] . '</button>
                            </a>-->
                              <!--<button type="button" class="btn btn-secondary" 
                              data-toggle="modal" data-target="#ModalChefRecipeCheck"
                              onclick="return getthischefrecipe(' . $k . '); return false;">選擇' . $v["name"] . '</button>-->
                            </div>
                          </div>
                      </div>
                  </div>
                </div>';
                $score_count++;
        }
        echo '<div>';


        
    break;

    case "ar_cr":
        $chefID  = $_POST["chefID"];
        $sql     = "SELECT * FROM `chef_recipe` WHERE `cr_chef` = " . $chefID;
        $result  = mysqli_query($conn ,$sql) or die($sql);
        while($row = mysqli_fetch_array($result)){
          echo '
          <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-ms-12 text-center"><!-- data-aos-anchor-placement="top-center" data-aos="fade-down" data-aos-duration="100" -->
              <div class="custom-control custom-checkbox image-checkbox">
                  <figure class="figure">
                      <input type="checkbox" class="custom-control-input" id="ck1a' . $row['cr_ID'] . '" name="RecipeCheckbox" value="' . $row['cr_ID'] . '">
                      <label class="custom-control-label" for="ck1a' . $row['cr_ID'] . '">
                          <img src="./images/chef_recipe/' . $row['cr_img'] . '" class="figure-img img-fluid rounded" 
                              alt="找不到圖片= =" style= "width: 200px; height: 200px ">
                      </label>
                      <figcaption class="figure-caption text-center">' . $row['cr_name'] . '</figcaption>
                  </figure>
              </div>
              <!--
              <div class="input-group mb-3">
                  <input id="FormControlSelectMember" type="number" class="form-control"
                      aria-label="Amount (to the nearest dollar)" required>
                  <div class="input-group-append">
                      <span class="input-group-text">份</span>
                  </div>
              </div>-->
          </div>
                ';
        }
        

    break;
    
    case "ar_h":
      $chefID  = $_POST["chefID"];
      $sql     = "SELECT `ChefName`,`ChefFirstName` FROM `chef_account` where `ID` = " . $chefID ;
      $result  = mysqli_query($conn, $sql) or die($sql);
      $row     = mysqli_fetch_row($result);
      $chefN   = $row[1] . $row[0];
    break;

    case "rec_head":
      $ty = "'ty'";
      echo '<div class="btn-group mr-2 col-md-12">';
      //echo'   <button class="btn btn-sm btn-outline-secondary" onclick="getrec('.$rec_home.',);">建議菜單</button>';
      $sql = "SELECT fid,name FROM `type` WHERE name != 'ALL'";
      $result = mysqli_query($conn, $sql) or die($sql);
      while($row = mysqli_fetch_array($result)){
        echo '<button class="btn btn-sm btn-outline-secondary" onclick="getrec(' . $ty . ', '.$row['fid'].')">' . $row['name'] . '</button>';
      }

      echo '</div>';
              
      break;
    case "ty":
    $fid = $_POST['fid'];
    $family_username = isset($_SESSION['family_username']) ? $_SESSION['family_username'] : null ;
      if($family_username == null){ 
          echo '<script>';
          echo 'window.location.href="./pages/login/login.php"';
          echo '</script>';
      }
       // 目前所有食譜名稱
       $allfood= array();
       // 能吃的食譜輕單
       $arcFoodname = array();
       // 能吃的食譜輕單的材料
       $arc = array();
       //所有食譜芬數全仲
       $c=array();

       $arr_rec= "";
     // ==============================================

       //目前所有食譜
       $sql = "SELECT * FROM `allrec`";
       $result = mysqli_query($conn, $sql);

       while ($row = mysqli_fetch_array($result)) {
         array_push($allfood, $row[1]);
       }
     // 疾病處理
     // 使用者毛病
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

     for ($i=0; $i < count($allfood); $i++) {

         $sql2 ='SELECT * FROM `allrec` WHERE (`name` = "'.$allfood[$i].'")'.' and (`heartattack` = ' . $user[0] . ') and (`pneumonia` = ' . $user[1] . ') and (`diabetes` = ' . $user[2].') and (`Lower_respiratory_tract` = ' . $user[3] . ') and (`hypertension` = ' .$user[4] . ') and (`Nephritis` = ' . $user[5]. ') and (`Liver` = ' . $user[6] .') and (`type` = '.$fid .')';

         // echo $sql2."<br>";
         $result1 = mysqli_query($conn, $sql2) or die($sql2);
         $row = mysqli_fetch_array($result1); 

         // 地一不 篩選疾病
         if (isset($row[0])) {

           // 存入食譜名稱
           array_push($arcFoodname, $row[1]);

           $arr_rec = explode("、",$row[2]);
           //$arr_rec存所有食譜食材
           array_push($arc,$arr_rec);
         }
     }
     $t = array($arcFoodname,$c);
    //  @array_multisort($t[1],SORT_DESC,$t[0]);

     // echo "<pre>";
     // print_r($t);
     // echo "</pre>";

    //title評價
    $titlescore=['','差','較差','普通','較好','好'];

    echo '<div id="recipe" class = "row">';

    for ($i=0; $i < 8; $i++) {
        $sql2 ='SELECT * FROM `allrec`WHERE (`name` = "'.$t[0][$i].'")'.' and (`heartattack` = ' . $user[0] . ') and (`pneumonia` = ' . $user[1] . ') and (`diabetes` = ' . $user[2].') and (`Lower_respiratory_tract` = ' . $user[3] . ') and (`hypertension` = ' .$user[4] . ') and (`Nephritis` = ' . $user[5]. ') and (`Liver` = ' . $user[6] .')';
        // echo $sql2;
        $result1 = mysqli_query($conn, $sql2) or die($sql2);
        $row = mysqli_fetch_array($result1);
        $na = '"' . $row[1] . '"';
        if (isset($row[0])) {
                echo'

                <div class="col-md-6 col-lg-3"><!-- ftco-animate-->

                    <div class="product text-center">
                    <a href="f_popular.php?fid='.$row[0].'" class="img-prod"><img class="img-fluid" src="images/recipe_image_squeeze/'.$row[4].'" alt="Colorlib Template">
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <label for="checkrecipebox' . $row[0] . '">
                        <h3>'.$row[1].'</h3>';
                            echo "<input type='checkbox' ID='checkrecipebox" . $row[0] . "' name='check_ID' value='".$row[0]."' autocomplete='off' onchange='return recipe_CheckCount(" . $na . "); return false;'>";
                            //echo '<input type="hidden" name="chec" value="' . $row[1] . '">
                        echo '<div class="d-flex">
                            <div class="pricing">
                            <p class="price"><span class="mr-2 price-dc"></span><span class="price-sale"></span></p>
                            </div>
                        </div>
                        </label>  
                        <div class="bottom-area d-flex px-3">          
                            <div class="m-auto d-flex">
                                <a href="./pages/keep/keepprocess.php?fid=' . $row[0] . '" class="heart d-flex justify-content-center align-items-center ">
                                <span><i class="ion-ios-heart"></i></span>
                                </a>
                            </div>
                        </div>
                    </div><!--product-->
                    </div>
                </div>
                ';
        }
    }
      break;
    

    case "rec_home":
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
      $sql = 'SELECT * FROM `chef_recipe` WHERE ' . $wher . ' ';//LIMIT 8
      $result = mysqli_query($conn, $sql)or die($sql);
      while($row = mysqli_fetch_array($result)){
        $sql2 = 'SELECT `chef_recipe`.*, ChefName,ChefFirstName, cr_chef FROM `chef_recipe` INNER JOIN chef_account WHERE cr_name = "' . $row[2] . '" and `cr_chef` = chef_account.ID';
        $result2 = mysqli_query($conn, $sql2) or die($sql2);
        
        echo'

                    <div class="col-md-6 col-lg-3"><!-- ftco-animate-->
    
                        <div class="product text-center">
                        <a href="f_popular.php?fid='.$row['DefaultRecipeID'].'" class="img-prod"><img class="img-fluid" src="images/recipe_image_squeeze/'.$row['DefaultRecipeID'].'.png" alt="Colorlib Template">
                            <div class="overlay"></div>
                        </a>
                        <div class="text py-3 pb-4 px-3 text-center">
                            <label for="checkrecipebox' . $row['DefaultRecipeID'] . '">
                            <h3>'.$row[2].'</h3>
                            <div class="card">
                              <ul class="list-group list-group-flush">';
                            //echo '<div class="card-header">'.$row[2].'</div>';
                            while($row2 = mysqli_fetch_array($result2)){
                              //echo '<p>廚師: ' . $row2['ChefName'] . $row2['ChefFirstName']  . " $". $row2['price'] . '</p>';
                              //echo '<div class="card-header">'. $row2['ChefName'] . $row2['ChefFirstName']  . '</div>';
                              $chef_id = $row2['cr_chef'];
                              //echo '<li class="list-group-item">' . $row2['ChefName'] . $row2['ChefFirstName']  . '</li>';
                            }
                            // $sql_similar_chef = " SELECT * FROM `chef_recipe`
                            //                       inner join chef_account 
                            //                       WHERE chef_recipe.cr_chef = chef_account.ID 
                            //                       and `cr_name` like '%$row[2]%' 
                            //                       GROUP BY `cr_chef`";
                            $sql_similar_chef = " SELECT chef_recipe.*, CONCAT(chef_account.ChefFirstName, ' ', chef_account.ChefName) as `chefname` 
                                                  FROM `chef_recipe` inner join chef_account 
                                                  WHERE chef_recipe.cr_chef = chef_account.ID 
                                                  and `cr_name` like '%$row[2]%' 
                                                  GROUP BY `cr_chef`
                                                  LIMIT 4";
                            $result_similar_chef = mysqli_query($conn, $sql_similar_chef) or die($sql_similar_chef);
                            $rowcount = 0;
                            while($row_similar_chef = mysqli_fetch_array($result_similar_chef)){
                              //echo '<li class="list-group-item">' . $row_similar_chef['cr_name']  . '</li>';
                              $sql_score = "SELECT avg(score) as score,chef_ID FROM `chef_score` WHERE `chef_ID` = " . $row_similar_chef['cr_chef'] . " GROUP BY `chef_ID`";
                              $result_score = mysqli_query($conn, $sql_score) or die($sql_score);
                              $row_score = mysqli_fetch_array($result_score);
                              echo '<li class="list-group-item  list-group-item-action list-group-item-secondary"">';
                              echo '<div class="row">
                                        <div class="col-md-8">
                                        ★ ' . number_format(@$row_score['score'], 1) . '
                                        </div>
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                              ';
                              echo '  <div class="row">
                                        
                                        <div class="col-md-8">
                                        ' . $row_similar_chef['chefname'] . '
                                        </div>
                                        <div class="col-md-4">
                                        <button type="button" class="btn btn-secondary" onclick="return get_Modal_Chef_Information(' . $row_similar_chef['cr_chef'] . ');return false;" data-toggle="modal" data-target="#Modal_Chef_Infomation">
                                        ℹ️
                                        </button>
                                        </div>
                                      </div>';
                              echo '</li>';
                            }
                            
                          echo '</ul>
                            </div>';
                          echo '<div class="d-flex">
                                  <div class="pricing">
                                    <p class="price"><span class="mr-2 price-dc"></span><span class="price-sale"></span></p>
                                  </div>
                                </div>
                          </label>
                            
                              
                              
                            

                            <div class="bottom-area d-flex px-3">          
                                <div class="m-auto d-flex">
                                  <!--<div class="row">
                                    <div class="col-md-6">
                                      <input type="button" class="btn btn-secondary" value="廚師簡介" onclick="return get_Modal_Chef_Information(' . $chef_id . ');return false;" data-toggle="modal" data-target="#Modal_Chef_Infomation">
                                    </div>
                                    <div class="col-md-6">
                                      <input type="button" class="btn btn-secondary" value="我要訂餐" onclick="location.href=' . "'" .'./chefselect.php?chefid=' . $chef_id . "'" . ';">
                                    </div>
                                  </div>-->
                                </div>
                            </div>

                        </div><!--product-->
                        </div>
                    </div>
                    ';
                    
                    
                    
                  }
    break;
                
    case "rec_home_v2"://外送到府 菜單
      $family_username = isset($_SESSION['family_username']) ? $_SESSION['family_username'] : null ;
      if($family_username == null){ 
          echo '<script>';
          echo 'window.location.href="./pages/login/login.php"';
          echo '</script>';
      }
      $tag = isset($_POST['fid']) ? "'" . $_POST['fid'] . "'" : null; 
      // echo "tag".$tag;
      $f = "'" . $family_username . "'";
      $material = array();
      $sql = "SELECT * FROM `material` WHERE `account` = $f";
      $result = mysqli_query($conn, $sql) or die($sql);
      while($row = mysqli_fetch_array($result)){
        array_push($material, $row['foodname']);
      }

       // 目前所有食譜名稱
       $allfood= array();
       // 能吃的食譜輕單
       $arcFoodname = array();
       // 能吃的食譜輕單的材料
       $arc = array();
       //所有食譜芬數全仲
       $c=array();

       $arr_rec= [];
     // ==============================================

     $sql = "SELECT * FROM `type` WHERE `tag` = $tag";
     $result = mysqli_query($conn, $sql) or die($sql);
     $rowtag = mysqli_fetch_array($result);
       //目前所有食譜
       $sql = "SELECT * FROM `allrec` where `type` = " . "'" . $rowtag['fid'] . "'";
      //  echo $sql;
       $result = mysqli_query($conn, $sql);

       while ($row = mysqli_fetch_array($result)) {
         array_push($allfood, $row[1]);
       }
     // 疾病處理
     // 使用者毛病
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

     for ($i=0; $i < count($allfood); $i++) {

         $sql2 ='SELECT * FROM `chef_recipe` WHERE (`cr_name` = "'.$allfood[$i].'")'.' and (`heartattack` = ' . $user[0] . ') and (`pneumonia` = ' . $user[1] . ') and (`diabetes` = ' . $user[2].') and (`Lower_respiratory_tract` = ' . $user[3] . ') and (`hypertension` = ' .$user[4] . ') and (`Nephritis` = ' . $user[5]. ') and (`Liver` = ' . $user[6] .');';
         // echo $sql2."<br>";
         $result1 = mysqli_query($conn, $sql2) or die($sql2);
         $row = mysqli_fetch_array($result1); 

         // 地一不 篩選疾病
         if (isset($row[0])) {

           // 存入食譜
           array_push($arcFoodname, $row[2]);
          $sql = "SELECT * FROM `chef_recipe_ingredient` WHERE `cri_recipe` = $row[0]";
          $result = mysqli_query($conn, $sql) or die($sql);
          while($row = mysqli_fetch_array($result)){
            
            array_push($arr_rec, $row[2]);
          }
          array_push($arc, $arr_rec);
          //  $arr_rec = explode("、",$row[2]);
          //  //$arr_rec存所有食譜食材
          //  array_push($arc,$arr_rec);
         }
     }
    //  echo '<pre>';
    //  print_r($arc);
    //  echo '</pre>';

     //user owned ing 使用者現有食材
     $sql1 = "SELECT * FROM `material` WHERE `account` = '$family_username'";
     
     $result1 = mysqli_query($conn, $sql1) or die($sql1);

     // ==============================================
     // ing count 使用者現有食材個數
     $sql1_count = "SELECT count(*) FROM `material` WHERE `account` = '$family_username'";
     
     $result1_count = mysqli_query($conn, $sql1_count) or die($sql1_count);

     
     // ==============================================
     //現有食材
     $arr = array();
     while ($row_result1 = mysqli_fetch_array($result1)) {
         array_push($arr, $row_result1[2]);//$arr = 使用者現有食材總個數
     }

    

     // 第二步-1 使用者冰箱有食材
     // 食譜 權重
    //  echo '<pre>';
    //  print_r($arc);
    //  echo '</pre>';
    //  echo '<pre>';
    //  print_r($arr);
    //  echo '</pre>';
     
    if(count($arr) != 0){
      for ($i = 0; $i < count($arc); $i++) { 
          $foodcount = 0;
          // 冰箱
          for($j = 0 ; $j < count($arr) ; $j++){   
              // 冰箱比對食譜
              if (in_array($arr[$j], $arc[$i])) {
                  // 相對應＋＋
                  $foodcount ++;
              }
          }
          $c[$i] = $foodcount / count($arc[$i]);
      }
    } else {
         // 弟二不-2 使用者冰箱沒有食材
         // ==============================================
         //芬數 佳總
         $sql_score  = "SELECT * FROM `score` WHERE `account` = '$family_username'";
         // echo  $sql_score;
         $result_score = mysqli_query($conn, $sql_score)or die($sql_score);
         // score = 使用者有評分的食譜名稱 2 食譜編號 3為食譜名稱
         while ($score = mysqli_fetch_array($result_score)) {
             // echo $score[2].'<br>';
             // $score_arr[$p] = $score[3].$score[2];
             // $p++;
             for($i = 0 ; $i < count($arcFoodname); $i++)
             {     

                 // echo $arcFoodname[$i].'<br>';
                 if($score[3] == $arcFoodname[$i])
                 { 
                     $c[$i] =  $c[$i] + $score[4];
                 } else {
                     $c[$i] =  0;
                 }
             }
         }
     }
      $t = array($arcFoodname,$c);
      // echo '<pre>';
      // print_r($t);
      // echo '</pre>';
      array_multisort($t[1], SORT_DESC,$t[0]);

    //  echo "<pre>";
    //  print_r($t[0]);
    //  echo "</pre>";

//title評價
$titlescore=['','差','較差','普通','較好','好'];

$top = array();

 for ($i = 0; $i < 8; $i++) {
    array_push($top, $t[0][$i]);   
 }
  //  echo '<pre>';
  // print_r($top);
  // echo '<pre>';
 for ($i = 0; $i < 8; $i++) {
  $sql = "SELECT * FROM `chef_recipe` WHERE `cr_name` = " . "'" . $top[$i] . "'";
  // echo $sql . "<br>";
  $result =mysqli_query($conn, $sql) or die($sql);
  $row = mysqli_fetch_array($result);
  if (isset($row[0])){
  echo '

      <div class="col-lg-3 col-md-4 col-sm-6">

          <div class="product text-center">
          <a href="f_popular.php?fid='.$row['cr_ID'].'" class="img-prod"><img class="img-fluid" src="images/recipe_image_squeeze/'.$row['DefaultRecipeID'].'.png" alt="Colorlib Template">
              <div class="overlay"></div>
          </a>
          <div class="text py-3 pb-4 px-3 text-center">
              <label for="checkrecipebox' . $row['cr_ID'] . '">
              <h3>'.$row[2].'</h3>
              <h3>'.$row['price'].'$</h3>';
                  echo "<input type='checkbox' ID='checkrecipebox" . $row['cr_ID'] . "' name='check_ID' value='".$row['cr_ID']."' autocomplete='off' >";
                  //echo '<input type="hidden" name="chec" value="' . $row[1] . '">
              echo '<div class="d-flex">
                  <div class="pricing">
                  <p class="price"><span class="mr-2 price-dc"></span><span class="price-sale"></span></p>
                  </div>
              </div>
              </label>  
              <div class="container">
                      <div class="row">
                          <div class="col-md-4 text-center">
                            <span class="input-group-btn mr-2">
                              <input type="button" class="quantity-left-minus btn btn-lg" value="-" onclick="Sub('.$row['cr_ID'].')">
                            </span>
                          </div>
                          <div class="col-md-4 text-center">
                            <span class="input-group-btn mr-2">
                              <input class="form-control input-number" type="text" name="recipe_name[]" id="inputnumber_'. $row['cr_ID'] .'" class="form-control" value="0" readonly>
                            </span>
                          </div>
                          <div class="col-md-4 text-center">
                            <span class="input-group-btn mr-2">
                              <input type="button" class="quantity-right-plus btn" value="+" onclick="Add('.$row['cr_ID'].')">
                            </span>
                          </div>
                      </div>
                  </div>
              <div class="bottom-area d-flex px-3">          
                  <!--<div class="m-auto d-flex">
                      <a href="./pages/keep/keepprocess.php?fid=' . $row['DefaultRecipeID'] . '" class="heart d-flex justify-content-center align-items-center ">
                      <span><i class="ion-ios-heart"></i></span>
                      </a>
                  </div>-->
                  <!-- hover -->
              </div>
          </div><!--product-->
          </div>
      </div>
      ';
  }else{
    echo 0;
  }
}
 

 
  
  // echo '<pre>';
  // print_r($top);
  // echo '<pre>';
      





      break;

    case "rec_body":

      $family_username = isset($_SESSION['family_username']) ? $_SESSION['family_username'] : null ;
      if($family_username == null){ 
          echo '<script>';
          echo 'window.location.href="./pages/login/login.php"';
          echo '</script>';
      }
       // 目前所有食譜名稱
       $allfood = array();
       // 能吃的食譜輕單
       $arcFoodname = array();
       // 能吃的食譜輕單的材料
       $arc = array();
       //所有食譜芬數全仲
       $c = array();

       $arr_rec= "";
     // ==============================================

       //目前所有食譜
       $sql = "SELECT * FROM `allrec`";
       $result = mysqli_query($conn, $sql);

       while ($row = mysqli_fetch_array($result)) {
         array_push($allfood, $row[1]);
       }
     // 疾病處理
     // 使用者毛病
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

     for ($i=0; $i < count($allfood); $i++) {

         $sql2 ='SELECT * FROM `allrec` WHERE (`name` = "'.$allfood[$i].'")'.' and (`heartattack` = ' . $user[0] . ') and (`pneumonia` = ' . $user[1] . ') and (`diabetes` = ' . $user[2].') and (`Lower_respiratory_tract` = ' . $user[3] . ') and (`hypertension` = ' .$user[4] . ') and (`Nephritis` = ' . $user[5]. ') and (`Liver` = ' . $user[6] .')';

         // echo $sql2."<br>";
         $result1 = mysqli_query($conn, $sql2) or die($sql2);
         $row = mysqli_fetch_array($result1); 

         // 地一不 篩選疾病
         if (isset($row[0])) {

           // 存入食譜名稱
           array_push($arcFoodname, $row[1]);

           $arr_rec = explode("、",$row[2]);
           //$arr_rec存所有食譜食材
           array_push($arc,$arr_rec);
         }
     }

     //user owned ing 使用者現有食材
     $sql1 = "SELECT * FROM `material` WHERE `account` = '$family_username'";
     
     $result1 = mysqli_query($conn, $sql1) or die($sql1);

     // ==============================================
     // ing count 使用者現有食材個數
     $sql1_count = "SELECT count(*) FROM `material` WHERE `account` = '$family_username'";
     
     $result1_count = mysqli_query($conn, $sql1_count) or die($sql1_count);

     
     // ==============================================
     //現有食材
     $arr = array();
     while ($row_result1 = mysqli_fetch_array($result1)) {
         array_push($arr, $row_result1[2]);//$arr = 使用者現有食材總個數
     }


     // 第二步-1 使用者冰箱有食材
     // 食譜 權重
     
     if(count($arr) != 0){
       for ($i = 0; $i < count($arc); $i++) { 
           $foodcount = 0;
           // 冰箱
           for($j = 0 ; $j < count($arr) ; $j++){   
               // 冰箱比對食譜
               if (in_array($arr[$j], $arc[$i])) {
                   // 相對應＋＋
                   $foodcount ++;
               }
           }
           $c[$i] = $foodcount / count($arc[$i]);
       }
     } else {
         // 弟二不-2 使用者冰箱沒有食材
         // ==============================================
         //芬數 佳總
         $sql_score  = "SELECT * FROM `score` WHERE `account` = '$family_username'";
         // echo  $sql_score;
         $result_score = mysqli_query($conn, $sql_score)or die($sql_score);
         // score = 使用者有評分的食譜名稱 2 食譜編號 3為食譜名稱
         while ($score = mysqli_fetch_array($result_score)) {
             // echo $score[2].'<br>';
             // $score_arr[$p] = $score[3].$score[2];
             // $p++;
             for($i = 0 ; $i < count($arcFoodname); $i++)
             {     

                 // echo $arcFoodname[$i].'<br>';
                 if($score[3] == $arcFoodname[$i])
                 { 
                     $c[$i] =  $c[$i] + $score[4];
                 } else {
                     $c[$i] =  0;
                 }
             }
         }
     }
     $t = array($arcFoodname,$c);
     @array_multisort($t[1],SORT_DESC,$t[0]);

     // echo "<pre>";
     // print_r($t);
     // echo "</pre>";

    //title評價
    $titlescore=['','差','較差','普通','較好','好'];

    echo '<div id="recipe" class = "row">';

    for ($i=0; $i < 8; $i++) {
        $sql2 ='SELECT * FROM `allrec`WHERE (`name` = "'.$t[0][$i].'")'.' and (`heartattack` = ' . $user[0] . ') and (`pneumonia` = ' . $user[1] . ') and (`diabetes` = ' . $user[2].') and (`Lower_respiratory_tract` = ' . $user[3] . ') and (`hypertension` = ' .$user[4] . ') and (`Nephritis` = ' . $user[5]. ') and (`Liver` = ' . $user[6] .')';
        $result1 = mysqli_query($conn, $sql2) or die($sql2);
        $row = mysqli_fetch_array($result1);
        $na = '"' . $row[1] . '"';
        if (isset($row[0])) {
                echo'

                <div class="col-md-6 col-lg-3"><!-- ftco-animate-->

                    <div class="product text-center">
                    <a href="f_popular.php?fid='.$row[0].'" class="img-prod"><img class="img-fluid" src="images/recipe_image_squeeze/'.$row[4].'" alt="Colorlib Template">
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <label for="checkrecipebox' . $row[0] . '">
                        <h3>'.$row[1].'</h3>';
                            echo "<input type='checkbox' ID='checkrecipebox" . $row[0] . "' name='check_ID' value='".$row[0]."' autocomplete='off' onchange='return recipe_CheckCount(" . $na . "); return false;'>";
                            //echo '<input type="hidden" name="chec" value="' . $row[1] . '">
                        echo '<div class="d-flex">
                            <div class="pricing">
                            <p class="price"><span class="mr-2 price-dc"></span><span class="price-sale"></span></p>
                            </div>
                        </div>
                        </label>  
                        <div class="bottom-area d-flex px-3">          
                            <div class="m-auto d-flex">
                                <a href="./pages/keep/keepprocess.php?fid=' . $row[0] . '" class="heart d-flex justify-content-center align-items-center ">
                                <span><i class="ion-ios-heart"></i></span>
                                </a>
                            </div>
                        </div>
                    </div><!--product-->
                    </div>
                </div>
                ';
        }
    }
      break;

    case "ckorder":
      $data = $_POST['formData'];
      $total = 0;
      for($i = 0; $i < count($data); $i++){
        $sql = "SELECT * FROM `chef_recipe` WHERE (`IsDefault` = 1) and `DefaultRecipeID` = " . $data[$i]['value'] ;
        $result = mysqli_query($conn, $sql) or die($sql);
        echo '<tbody>';
        while($row = mysqli_fetch_array($result)){
          echo '<tr>';
          echo '<td>' . $row['cr_chef'] . '</td>';
          echo '<td>' . $row['cr_name'] . '</td>';
          echo '<td>' . $row['price'] . '</td>';
          echo '</tr>';
          $total += $row['price'];
        }
        echo '</tbody>';
      }
      echo '<tfoot>';
      echo '<td></td>';
      echo '<td>總計: ' . $total .'</td>';
      echo '<input type="hidden" id="total01" name="toto" value="' . $total . '">';
      echo '<td></td>';
      echo '</tfoot>';
      
      // $sql = "SELECT * FROM `chef_recipe` WHERE `cr_ID` = ";
      // $result = mysqli_query($conn, $sql) or die($sql);
      // $row = mysqli_fetch_array($result);
      break;

    default:

    echo "error?";
    break;
}

?>