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

    <div class="hero-wrap hero-bread" style="background-image: url('./images/bg/order.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="./index.php">Home</a></span>
                    </p>
                    <h1 class="mb-0 bread">訂單紀錄</h1>
                </div>
            </div>
        </div>
    </div>

    <form id="formsave" action="#">
        <section class="ftco-section ftco-cart">
            <div class="container">
                <div class="row justify-content-around">



                    <div class="col-md-12 ftco-animate">
                        <div class="cart-list">
                            <table class="table  table-hover">
                                <thead class="thead-secondary">
                                    <tr class="text-center">
                                        <th>訂單編號</th>
                                        <th>訂單類型</th>
                                        <th colspan="2">廚師</th>
                                        <th>總價</th>
                                        <th>狀態</th>
                                        <th>詳細資訊</th>
                                        
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    // $sql = 'SELECT chef_recipe.cr_ID, chef_recipe.cr_name, CONCAT(`ca`.`ChefFirstName`, " ", `ca`.`ChefName`) as `chefname`, 
                                    //         `family_account`.Username, chef_recipe.cr_img,chef_recipe.price , `uo`.quantity ,(chef_recipe.price * `uo`.quantity) as total, 
                                    //         `uo`.status FROM `user_order`as `uo` 
                                    //             inner JOIN `chef_account` as `ca`, `chef_recipe`, `family_account` 
                                    //                 WHERE `user_id` = "3" 
                                    //                     AND `uo`.chef_id = `ca`.ID 
                                    //                     AND `uo`.data = chef_recipe.cr_ID
                                    //                     AND family_account.ID = `uo`.`user_id`
                                    //                     ORDER BY `uo`.`id` DESC';
                                    $cust = $_SESSION['family_username'];
                                    $sql = "SELECT `ID` FROM `family_account` WHERE`Username` = '$cust'";
                                    $result = mysqli_query($conn, $sql) or die($sql);
                                    $row = mysqli_fetch_array($result);
                                    $custid = $row["ID"];
                                    // $sql = "SELECT `user_order_group` .*,
                                    //         sum((user_order.quantity * `chef_recipe`.`price`))as price,
                                    //         CONCAT(`chef_account`.`ChefFirstName`, ' ', `chef_account`.`ChefName`) as `chefname`,
                                    //         `chef_account`.`img`
                                    //         FROM `user_order_group` 
                                    //         inner join `user_order` ,`chef_recipe`, `chef_account`
                                    //         WHERE `user_order_group`.`ID` = `user_order`.`order_id`
                                    //         AND `user_order`.`data` = `chef_recipe`.`cr_ID`
                                    //         AND `cust_id` = '$custid'
                                    //         AND `chef_account`.`ID` = `chef_recipe`.`cr_chef`
                                    //         GROUP BY `user_order_group`.`ID`
                                    //         ORDER BY `user_order_group`.`ID` DESC";
                                    $sql = "SELECT `user_order_group` .*,
                                            sum((user_order.quantity * `chef_recipe`.`price`))as price,
                                            CONCAT(`chef_account`.`ChefFirstName`, ' ', `chef_account`.`ChefName`) as `chefname`,
                                            `chef_account`.`img`
                                            FROM `user_order_group` 
                                            inner join `user_order` ,`chef_recipe`, `chef_account`
                                            WHERE `user_order_group`.`ID` = `user_order`.`order_id`
                                            AND `user_order`.`data` = `chef_recipe`.`cr_ID`
                                            AND `cust_id` = '$custid'
                                            AND `chef_account`.`ID` = user_order_group.chef_id
                                            GROUP BY `user_order_group`.`ID`
                                            ORDER BY `user_order_group`.`ID` DESC";
                                    
                                    // $sql = "SELECT * FROM `material`WHERE`account` = '$user'";
                                    $result = mysqli_query($conn, $sql) or die($sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $d = "'" . $row[2] . "'";
                                        switch ($row['status']){
                                            case "0":
                                                echo '<tr class="text-center table-info">';
                                            break;

                                            case "1":
                                                echo '<tr class="text-center table-warning">';
                                            break;

                                            case "2":
                                                echo '<tr class="text-center table-success">';
                                            break;
                                        }

                                        // echo '  <tr data-index="0" data-has-detail-view="true">
                                        //             <td><a class="detail-icon" href="#"><i class="fa fa-minus"></i></a></td>
                                        //             <td>0</td>
                                        //             <td>Item 0</td><td>$0</td>
                                        //         </tr>
                                        //         <tr class="detail-view">
                                        //             <td colspan="4">
                                        //                 <p><b>id:</b> 0</p>
                                        //                 <p><b>name:</b> Item 0</p>
                                        //                 <p><b>price:</7b> $0</p>
                                        //                 <p><b>amount:</b> 3</p>
                                        //             </td>
                                        //         </tr>';

                                        echo '
                                                <td class="product-remove"><span>' . $row['ID'] . '</span></td>';
                                        switch($row['type']){
                                            case "0":
                                        echo    '<td class="price">到府服務</td>';
                                                break;
                                            case "1":
                                        echo    '<td class="price">外送到府</td>';
                                                break;
                                        }
                                        echo '  <td class="image-prod"><div class="img" style="background-image:url(./images/users/'.$row['img'] .');"></div></td>
                                                <td class="price">' . $row['chefname'] . '</td>
                                                <td class="price">' . $row['price'] . '</td>
                                                ';
                                            switch ($row['status']){
                                                case "0":
                                                    echo '<td class="total" style="color:#1F4788;">訂單已送出</td>';
                                                    echo '  <td>
                                                                <button type="button" class="btn btn-info" 
                                                                    data-toggle="modal" data-target="#largemodal"
                                                                    style="padding: inherit; color:#f8c3cd !important;"
                                                                    onclick="return detail_view('. "'" . $row['ID'] . "'" . ', ' . "'" . "view" . "'" .'); return false;">
                                                                    <i class="fas fa-info" style="color: #f8c3cd;"></i>&nbsp;view
                                                                </button>
                                                            </td>';
                                                    //echo '<td></td>';
                                                break;

                                                case "1":
                                                    echo '<td class="total" style="color:#896C39;">餐點外送中</td>';
                                                    echo '  <td>
                                                                <button type="button" class="btn btn-warning" 
                                                                    data-toggle="modal" data-target="#largemodal"
                                                                    style="padding: inherit; color:#896C39 !important;"
                                                                    onclick="return detail_view('. "'" . $row['ID'] . "'" . ', ' . "'" . "view" . "'" .'); return false;">
                                                                    <i class="fas fa-info" style="color: #896C39;"></i>&nbsp;view
                                                                </button>
                                                            </td>';
                                                    //echo '<td></td>';
                                                break;

                                                case "2":
                                                    echo '<td class="total" style="color:#00896c;">餐點已送達</td>';
                                                    echo '  <td>
                                                                <button type="button" class="btn btn-success" 
                                                                    data-toggle="modal" data-target="#largemodal"
                                                                    style="padding: inherit; color:#a8d8b9 !important;"
                                                                    onclick="return detail_view('. "'" . $row['ID'] . "'" . ', ' . "'" . "view" . "'" .'); return false;">
                                                                    <i class="fas fa-info" style="color: #a8d8b9;"></i>&nbsp;view
                                                                </button>
                                                            </td>';
                                                    //echo '<td> <button type="button" class="btn btn-success" style="padding: inherit; color:#a8d8b9 !important;">撰寫評價</button></td>';
                                                break;
                                            }
                                            
                                          echo '
                                            </tr>
                                              ';
                                              
                                    }
                                    ?>
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

    <!-- Modal -->
    <div id="largemodal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="ModalExisting" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="CheckList" onsubmit="return SystemRecipeSubmit(); return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalCustomLabel">詳細資訊</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" >
                        <div class="container">
                            <div class="row">
                                <div id="chefimage" class="col-md-6 text-center">
                                </div>
                                <div id="orderinfo" class="col-md-6">
                                    
                                </div>
                            </div>
                                
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">圖示</th>
                                    <th scope="col">菜品名稱</th>
                                    <th scope="col">價格</th>
                                    <th scope="col">數量</th>
                                    <th scope="col">評分</th>
                                </tr>
                            </thead>
                            <tbody id="view_body">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



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

    function detail_view(order_id, FunctionName) {
        detail_info(order_id, "chefimage");
        detail_info(order_id, "orderinfo");
        $.ajax({
            type: "post",
            url: "./get_container_value/user_order_processing.php",
            data: {
                FunctionName: FunctionName,
                order_id: order_id,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById("view_body").innerHTML = msg;
        })
        return false;
    }

    function detail_info(order_id, FunctionName){
        $.ajax({
            type: "post",
            url: "./get_container_value/user_order_processing.php",
            data: {
                FunctionName: FunctionName,
                order_id: order_id,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById(FunctionName).innerHTML = msg;
        })
        return false;
    }

    function  chef_recipe_score(chef_recipe_id, score){
        $.ajax({
            type: "post",
            url: "./get_container_value/user_order_processing.php",
            data: {
                FunctionName: "score",
                score: score,
                chef_recipe_id: chef_recipe_id,
            },
            cache: false
        }).done(function(msg) {
            console.log(msg);
        })
        return false;
    }

    function order_score(orderid, radiovalue){
        // console.log(radiovalue.value);
        $.ajax({
            type: "post",
            url: "./get_container_value/user_order_processing.php",
            data: {
                FunctionName: "order_score",
                orderid: orderid,
                radiovalue: radiovalue.value,
            },
            cache: false
        }).done(function(msg) {
            console.log(msg);
        })
        return false;
    }
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