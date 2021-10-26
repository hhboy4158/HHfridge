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

    <div class="hero-wrap hero-bread" style="background-image: url('images/icon/delivery.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="./index.php">Home</a></span>
                    <h1 class="mb-0 bread">外送到府</h1>


                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Delivery</span>
                    <h2 class="mb-4">熱門推薦</h2>
                    <div id="recipe_check_count"></div>
                    <!-- <p>請勾選您想吃的食譜</p> -->
                </div>
            </div>
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <!-- <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="我的訂單"
                        onclick="return check_order()" data-toggle="modal" data-target="#select_recipe_Modal"> -->
                </div>
                <!-- <div class="col-md-6 heading-section text-center ftco-animate">
                    <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="主廚推薦"
                        onclick="return chef_recommendation(); return false;">
                </div> -->
            </div>
            <div id="rec_head" class="row justify-content-center  mb-3 pb-3"></div>
        </div>
        <div class="container">
            <form action="#" ID="recipe_check" onsubmit="">


                <div id="rec_home" class="row ftco-animate">

                </div>
            </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="select_recipe_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">我的訂單</h5>
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
                                        <th scope="col">廚師id</th>
                                        <th scope="col">菜單名稱</th>
                                        <th scope="col">價格</th>
                                        <!-- <th scope="col">缺少食材</th> -->
                                    </tr>
                                </thead>
                                <tbody id="check_body">
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                            <!-- <input type="submit" class="btn btn-primary" value="訂購食材"> -->
                            <button type="button" class="btn btn-primary" onclick="check_buy()">訂購</button>
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

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="Modal_Chef_Infomation" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-lg" role="document">
            <div class="modal-content"  id="Modal_Chef_Infomation_Body">
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">廚師簡介</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="Modal_Chef_Infomation_Body">
                    
                </div> -->
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                </div> -->
            </div>
        </div>
    </div>


    <?php include("./footer.php"); ?>
    <script>
    function check_buy() {
        var BuyData = $('#recipe_check').serializeArray();
        var total = document.getElementById('total01').value;
        console.log(total);
        $.ajax({
            type: "post",
            url: "./get_container_value/get_order_data.php",
            data: {
                BuyData: BuyData,
                total: total,
            },
            cache: false
        }).done(function(msg) {
            console.log(msg);
        })
        return false;

    }

    // function check_ingredient(functionName) { //modal顯示勾選的食譜食材
    //     var formData = $('#recipe_check').serializeArray();
    //     console.log(formData);

    //     $.ajax({
    //         type: "post",
    //         url: "./get_container_value/get_food_data.php",
    //         data: {
    //             functionName: functionName,
    //             formData: formData,
    //         },
    //         cache: false
    //     }).done(function(msg) {
    //         document.getElementById("check_body").innerHTML = msg;
    //     })

    //     return false;
    // }
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
            document.getElementById('recipe_check_count').innerHTML = '<span class="subheading">目前尚未選擇任何料理</span>';
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
            // console.log(msg);
        })

        return false;
    }

    function check_order() {
        var formData = $('#recipe_check').serializeArray();
        console.log(formData);

        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: "ckorder",
                formData: formData,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById("check_body").innerHTML = msg;
        })

        return false;
    }

    // function getthischefrecipe(chefID) {
    //     getthischeftype(chefID);
    //     $.ajax({
    //         type: "post",
    //         url: "./get_container_value/get_food_data.php",
    //         data: {
    //             functionName: "ar_cr",
    //             chefID: chefID,
    //         },
    //         cache: false
    //     }).done(function(msg) {
    //         document.getElementById('ModalExistingBody').innerHTML = msg;
    //         console.log(msg);
    //     })

    //     return false;
    // }

    // function getthischeftype(chefID) {
    //     $.ajax({
    //         type: "post",
    //         url: "./get_container_value/get_food_data.php",
    //         data: {
    //             functionName: "ar_h",
    //             chefID: chefID,
    //         },
    //         cache: false
    //     }).done(function(msg) {
    //         document.getElementById('Modalhead').innerHTML = msg;
    //         console.log(msg);
    //     })
    // }

    function getrec(functionName, fid) {
        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: functionName,
                fid: fid,
            },
            cache: false
        }).done(function(msg) {
            if (functionName == 'ty') {
                document.getElementById('rec_home').innerHTML = msg;
            } else {
                document.getElementById(functionName).innerHTML = msg;
            }

            // console.log(msg);
        })
    }

    function get_Modal_Chef_Information(chef_id) {
        $.ajax({
            type: "post",
            url: "./get_container_value/get_Modal_Chef_Information_data.php",
            data: {
                functionName: "Information_body",
                chef_id: chef_id,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById('Modal_Chef_Infomation_Body').innerHTML = msg;
            // if (functionName == 'ty') {
            //     document.getElementById('rec_home').innerHTML = msg;
            // } else {
            //     document.getElementById(functionName).innerHTML = msg;
            // }

            // console.log(msg);
        })
    }

    

    $(document).ready(function() {
        // getrec("rec_head",);
        getrec("rec_home", );
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