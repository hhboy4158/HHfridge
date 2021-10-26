<?php

include("./top.php");
// 判斷是否登入
$family_username = isset($_SESSION['family_username']) ? $_SESSION['family_username'] : null;
if (!isset($family_username)) {
    echo'   <script>
                window.location.href="./pages/login/login.php";
            </script>';
}


require_once './connections/Account.php';

$user = isset($_SESSION['family_username']) ? $_SESSION['family_username'] : null;
?>

<body class="goto-here">

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg/bg_1.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="./index.php">Home</a></span> <span>Cart</span>
                    </p>
                    <h1 class="mb-0 bread">我的食材</h1>
                </div>
            </div>
        </div>
    </div>
    <form id="formsave" action="#" onsubmit="savefoods() ; return false;">
        <section class="ftco-section ftco-cart">
            <div class="container">
                <div class="row justify-content-around">

                    <div id="add_food" class="col-md-4  col-6  cart-wrap ftco-animate ">
                        <p><a href="javascript:void(0)" class="btn btn-primary py-3 px-4" data-toggle="modal" data-target="#InsertIng">新增食材</a></p>
                    </div>
                    <!-- <div id="add_food" class="col-md-4 mt-5 cart-wrap ftco-animate ">
          </div> -->
                    <div id="add_food" class="col-md-4 col-6 cart-wrap ftco-animate text-right">
                        <!-- <button class="btn btn-primary py-3 px-4 " style="float:right;">儲存</button> -->
                        <p><input type="submit" class="btn btn-primary py-3 px-4 " value="儲存食材"></p>
                    </div>

                    <div class="col-md-12 ftco-animate">
                        <div class="cart-list">
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr class="text-center">
                                        <th>刪除</th>
                                        <th>食材圖片</th>
                                        <th>食材名稱</th>
                                        <th></th>
                                        <th>數量</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <!----------------------------------------------------------------->
                                    <?php
                                    $sql = "SELECT * FROM `material`WHERE`account` = '$user'";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_row($result)) {
                                        $d = "'" . $row[2] . "'";
                                        echo '
                                              <tr class="text-center">
                                                <td class="product-remove"><a href="#" onclick="removefood(' . $d . ');"><span class="ion-ios-close"></span></a></td>
                                                
                                                <td class="image-prod"><div class="img" style="background-image:url(images/食材/' . $row[2] . '.png);"></div></td>
                                                
                                                <td class="product-name">
                                                  <!--<h3>' . $row[2] . '</h3>-->
                                                  <input type="text" style="font-size: 16px;"  id="foodname" class="quantity form-control input-number" value=' . $row[2] . ' readonly>
                                                  <input type="hidden" name="foodname" value=' . $row[0] . '>
                                                </td>
                                            
                                                <td class="price"></td>
                                            
                                                <td class="quantity">
                                                  <div class="input-group mb-3">
                                                    <input type="text"  id="foodqty" name="quantity" class="quantity form-control input-number" value=' . $row[3] . ' min="1" max="100">
                                                  </div>
                                                </td>
                                            
                                            <td class="total"></td>
                                          </tr>
                                              ';
                                    }
                                    ?>
                                    <!-- END TR-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                </div>
            </div>
        </section>
    </form>

    <!-- Modal add food 新增食材表單-->
    <div class="modal fade" id="InsertIng" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">新增食材</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="#" onsubmit="return submitIng(); return false;">
                    <div class="modal-body">
                        <!-- 新增 表單 -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">食材名稱</span>
                            </div>
                            <input name="adding" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="">
                        </div>
                        <br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">食材數量</span>
                            </div>
                            <input name="addnum" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                        <input type="submit" class="btn btn-primary" value="確認">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Modal -->


    <?php
         include("./footer.php"); 
    ?>

    <script type="text/javascript">
        //載入成功後再reload一次
        // $(document).ready(function () {

        //     if(location.href.indexOf("#reloaded")==-1){
        //     location.href=location.href+"#reloaded";
        //     location.reload();
        //     }
        // })

        //save changed foods

        function savefoods() {

            // 獲取所有欄位數值
            const formData = $('#formsave').serializeArray();
            $.ajax({
                type: "post",
                url: "./pages/food_manage/saveing.php",
                data: {
                    // functionName: functionName
                    formData: formData,
                },
                cache: false
            }).done(function(msg) {
                // console.log(msg);
                if (msg == "") {
                    alert("儲存成功");
                    location.reload();
                } else {
                    console.log(msg);
                }
            })

            return false;
        }
        //add foods
        function submitIng() {
            const ing = document.getElementsByName("adding")[0].value;
            const num = document.getElementsByName("addnum")[0].value;

            $.ajax({
                type: "POST",
                url: "./pages/food_manage/InsertIng.php",
                data: {
                    ing: ing,
                    num: num,
                },
                cache: false
            }).done(function(msg) {
                alert(msg);
                window.location.reload('./material.php')
                // document.getElementById("insertDone").innerHTML = msg;
            })
            return false;


        }

        function removefood(food) {
            yes = confirm('確定要刪除' + food + 'ㄇ');
            if (yes == 1) {
                $.ajax({
                    type: "post",
                    url: "./pages/food_manage/deling.php",
                    data: {
                        food: food
                    },
                    cache: false
                }).done(function(msg) {
                    console.log(msg);
                    window.location.reload('./material.php');
                    // document.getElementById("recipe").innerHTML = msg;
                })
            } else {}

        } //function
    </script>

    <script>
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