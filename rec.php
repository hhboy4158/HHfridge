<?php
    include("./top.php");  
    $family_username = isset($_SESSION['family_username']) ? $_SESSION['family_username'] : null ;
    if($family_username == null){ 
        echo '<script>';
        echo 'window.location.href="./pages/login/login.php"';
        echo '</script>';
    }
    require_once './connections/Account.php';
?>
<link href="assets/vendor/bootstrap-image-checkbox-master/dist/css/bootstrap-image-checkbox.min.css" rel="stylesheet">
<body class="goto-here">

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg/bg-recipe.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="./index.php">Home</a></span>
                    <h1 class="mb-0 bread">食譜推薦</h1>

                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Recipes recommend</span>
                    <h2 class="mb-4">食譜推薦</h2>
                    <p>請勾選您想吃的食譜</p>
                </div>
            </div>
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-13 heading-section text-center ftco-animate">
                    <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="瀏覽所需食材"
                        onclick="return check_ingredient('check_recipe_ing')" data-toggle="modal"
                        data-target="#select_recipe_Modal">
                </div>
                <!-- <div class="col-md-6 heading-section text-center ftco-animate">
                    <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="主廚推薦"
                        onclick="return chef_recommendation(); return false;">
                </div> -->
            </div>
        </div>
        <div class="container">
            <form action="#" ID="recipe_check" onsubmit="">
                <div class="row">
                    <!------------------------------------------------------------>
                    <?php


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
    //          echo '<pre>';
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

    for ($i = 0; $i < 8; $i++) {
        $sql2 ='SELECT * FROM `allrec`WHERE (`name` = "'.$t[0][$i].'")'.' and (`heartattack` = ' . $user[0] . ') and (`pneumonia` = ' . $user[1] . ') and (`diabetes` = ' . $user[2].') and (`Lower_respiratory_tract` = ' . $user[3] . ') and (`hypertension` = ' .$user[4] . ') and (`Nephritis` = ' . $user[5]. ') and (`Liver` = ' . $user[6] .')';
        $result1 = mysqli_query($conn, $sql2) or die($sql2);
        $row = mysqli_fetch_array($result1);
        $na = '"' . $row[1] . '"';
        if (isset($row[0])) {
                echo'

                <div class="col-md-6 col-lg-3 ftco-animate">

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
          ?>
                </div>
            </form>
        </div>
        <section class="ftco-section testimony-section">
            <div class="container">
                <div class="row justify-content-center mb-5 pb-3">
                    <div class="col-md-7 heading-section ftco-animate text-center">
                        <span class="subheading">Chef Recommendation</span>
                        <h2 class="mb-4">主廚推薦</h2>
                        <p>第二步: 勾選完畢後，點選主廚推薦，推薦專屬廚師</p>
                        <!-- <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="主廚推薦"
                            onclick="return check_ingredient('check_recipe_ing')"> -->
                        <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="主廚推薦"
                            onclick="return chef_recommendation(); return false;" data-toggle="modal"
                            data-target=".bd-recommandchef-modal-xl">
                    </div>
                    <div id="recipe_check_count" class="col-md-12 heading-section ftco-animate text-center">
                    </div>
                </div>
                <div id="chef_container" class="row ftco-animate">

                </div>
            </div>
            <div class="modal fade bd-recommandchef-modal-xl" tabindex="-1" role="dialog"
                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title h4" id="myExtraLargeModalLabel">主廚推薦</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">x</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="rec_body" class="card mb-3">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="select_recipe_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">所需食材</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="POST" id="buy_ing">
                        <!--onsubmit="check_buy(); return false;"-->
                        <div class="modal-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">所需食材</th>
                                        <th scope="col">所需數量</th>
                                        <th scope="col">缺少食材</th>
                                    </tr>
                                </thead>
                                <tbody id="check_body">
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                            <!-- <input type="submit" class="btn btn-primary" value="訂購食材"> -->
                            <button type="button" class="btn btn-primary" onclick="check_buy()">訂購食材</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- /Large modal -->
    </section>
            <!-- Large modal -->

            <div id="ModalChefRecipeCheck" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="ModalExisting" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="CheckList" onsubmit="return SystemRecipeSubmit(); return false;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalCustomLabel">新增</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="container">
                                <div id="Modalhead" class="row justify-content-md-center">
                                    <figure class="text-center">
                                        <blockquote class="blockquote" style="font-size:30px;">
                                            <p>選擇菜單</p>
                                        </blockquote>
                                        <figcaption class="blockquote-footer">
                                            <!-- <cite title="Source Title">您可以新增本平台的預設菜單。</cite>
                                            <cite id="checknum" title="Source Title">目前選擇了 0 道。</cite> -->
                                        </figcaption>
                                    </figure>
                                </div>
                                <div class="row justify-content-md-center">
                                    <!-- <div class="col-6 text-center">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input id="FormControlSelectMember" type="number" class="form-control"
                                                aria-label="Amount (to the nearest dollar)"
                                                oninput='FormControlSelectPrice.setCustomValidity(FormControlSelectPrice.value > 9999 ? "請輸入 10,000元以下的金額" : "")'
                                                required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-12 text-center">
                                        <!-- <div id="checknum"><p>目前選擇了 0 道</p></div> -->
                                        <div id="ModalCheck" class="btn-group btn-group-toggle" role="group"
                                            aria-label="Basic radio toggle button group" data-toggle="buttons">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div id="ModalExistingBody" class="row justify-content-md-center">
                                    <!--justify-content-md-center-->

                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">送出</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    <?php include("./footer.php"); ?>
    <script>
    function check_buy() {
        var BuyData = $('#buy_ing').serializeArray();
        console.log(BuyData);
        $.ajax({
            type: "post",
            url: "./get_container_value/get_order_data.php",
            data: {
                BuyData: BuyData,
            },
            cache: false
        }).done(function(msg) {
            console.log(msg);
        })
        return false;

    }

    function check_ingredient(functionName) { //modal顯示勾選的食譜食材
        var formData = $('#recipe_check').serializeArray();
        console.log(formData);

        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: functionName,
                formData: formData,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById("check_body").innerHTML = msg;
        })

        return false;
    }
    var ArrayRecipe = [];

    function recipe_CheckCount(RecipeName) { //檢查目前選擇了那些食譜並顯示
        var recipe_str = "";
        if (ArrayRecipe.includes(RecipeName)) {
            for (let j = 0; j < ArrayRecipe.length; j++) {
                if (RecipeName == ArrayRecipe[j]) {
                    ArrayRecipe.splice(j, 1);
                }
            }
        } else {
            ArrayRecipe.push(RecipeName);
        }
        for (let i = 0; i < ArrayRecipe.length; i++) {
            if (i == ArrayRecipe.length - 1) {
                recipe_str += ArrayRecipe[i];
            } else {
                recipe_str += ArrayRecipe[i] + "、";
            }
        }
        console.log(ArrayRecipe);
        if (recipe_str != "") {
            document.getElementById('recipe_check_count').innerHTML = '<span class="subheading">目前選擇了: ' + recipe_str +
                '</span>';
        } else {
            document.getElementById('recipe_check_count').innerHTML = '<span class="subheading">目前尚未選擇任何食材</span>';
        }

    }

    function chef_recommendation() {
        var formData = $('#recipe_check').serializeArray();
        // console.log(formData);
        const functionName = "chef_recommendation";
        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: functionName,
                formData: formData,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById('rec_body').innerHTML = msg;
            console.log(msg);
        })

        return false;
    }

    function getthischefrecipe(chefID){
        getthischeftype(chefID);
        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: "ar_cr",
                chefID: chefID,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById('ModalExistingBody').innerHTML = msg;
            console.log(msg);
        })

        return false;
    }

    function getthischeftype(chefID){
        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: "ar_h",
                chefID: chefID,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById('Modalhead').innerHTML = msg;
            console.log(msg);
        })
    }

    $(document).ready(function() {

        var quantitiy = 0;
        $('.quantity-right-plus').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            $('#quantity').val(quantity + 1);


            // Increment

        });

        $('.quantity-left-minus').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            // Increment
            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });

    });
    </script>

</body>

</html>