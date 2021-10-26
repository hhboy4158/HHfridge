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

    <div class="hero-wrap hero-bread" style="background-image: url('images/icon/home.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="./index.php">Home</a></span>
                    <h1 class="mb-0 bread">到府服務</h1>

                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">On-site Chef</span>
                    <?php
                    $tag = isset($_GET['type']) ? $_GET['type'] : "al";
                    $sql = "SELECT name FROM `type` WHERE tag =  " . "'" . $tag . "'";
                    $result = mysqli_query($conn, $sql) or die($sql);
                    $row = mysqli_fetch_array($result);
                    echo '<h2 class="mb-4">' . $row['name'] . '</h2>';
                    ?>

                    <!-- <p>請勾選您想吃的食譜</p> -->
                    <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="主廚推薦"
                        onclick="return chef_recommendation(); return false;" data-toggle="modal"
                        data-target=".bd-recommandchef-modal-xl">
                </div>
            </div>
            <div id="rec_head" class="row justify-content-center  mb-3 pb-3"></div>
            <!-- <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-13 heading-section text-center ftco-animate">
                    <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="瀏覽所需食材"
                        onclick="return check_ingredient('check_recipe_ing')" data-toggle="modal"
                        data-target="#select_recipe_Modal">
                </div>
                <div class="col-md-6 heading-section text-center ftco-animate">
                    <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="主廚推薦"
                        onclick="return chef_recommendation(); return false;">
                </div>
            </div> -->

        </div>
        <div class="container">
            <form action="#" ID="recipe_check" onsubmit="">


                <div id="" class="row">
                    <div class="container">
                        <div class="row" id="rec_home">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- 主廚推薦 modal -->
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
                                    <!-- <table class="table table-hover">
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
                                    </table> -->
                                    <!-- <div class="container" style="height: 300px">
                                        <script>//倒閉發臭</script>
                                        <canvas id="line_chart" width="200" height="200"></canvas> 
                                    </div> -->


                                    <div id="rec_body" class="card mb-3">

                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <canvas id="chef_score_chart_01" width="200" height="100"></canvas>
                                            </div>
                                            <div class="col-md-4">
                                                <canvas id="chef_score_chart_02" width="200" height="100"></canvas>
                                            </div>
                                            <div class="col-md-4">
                                                <canvas id="chef_score_chart_03" width="200" height="100"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--  Modal -->
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
                                <!-- <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">所需食材</th>
                                        <th scope="col">所需數量</th>
                                        <th scope="col">缺少食材</th>
                                    </tr>
                                </thead> -->
                                <!-- <tbody id="check_body">
                                </tbody> -->
                            </table>
                            <div id="check_body"></div>

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
            document.getElementById("check_body").innerHTML = msg;
        })
        return false;

    }

    function check_ingredient(functionName) { //modal顯示勾選的食譜食材
        var formData = $('#recipe_check [type=checkbox]').serializeArray();
        // console.log(formData);

        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: functionName,
                formData: formData,
            },
            cache: false
        }).done(function(msg) {
            // console.log(msg);
            document.getElementById("check_body").innerHTML = msg;
        })

        return false;
    }
    var ArrayRecipe = [];

    // function recipe_CheckCount(RecipeName) { //檢查目前選擇了那些食譜並顯示
    //     var recipe_str = "";
    //     if (ArrayRecipe.includes(RecipeName)) {
    //         for (let j = 0; j < ArrayRecipe.length; j++) {
    //             if (RecipeName == ArrayRecipe[j]) {
    //                 ArrayRecipe.splice(j, 1);
    //             }
    //         }
    //     } else {
    //         ArrayRecipe.push(RecipeName);
    //     }
    //     for (let i = 0; i < ArrayRecipe.length; i++) {
    //         if (i == ArrayRecipe.length - 1) {
    //             recipe_str += ArrayRecipe[i];
    //         } else {
    //             recipe_str += ArrayRecipe[i] + "、";
    //         }
    //     }
    //     // console.log(ArrayRecipe);
    //     if (recipe_str != "") {
    //         document.getElementById('recipe_check_count').innerHTML = '<span class="subheading">目前選擇了: ' + recipe_str +
    //             '</span>';
    //     } else {
    //         document.getElementById('recipe_check_count').innerHTML = '<span class="subheading">目前尚未選擇任何食材</span>';
    //     }

    // }

    // function chef_recommendation() {
    //     var formData = $('#recipe_check [type=checkbox]').serializeArray();
    //     // console.log(formData);
    //     const functionName = "chef_recommendation";
    //     $.ajax({
    //         type: "post",
    //         url: "./get_container_value/get_food_data.php",
    //         data: {
    //             functionName: functionName,
    //             formData: formData,
    //         },
    //         cache: false
    //     }).done(function(msg) {
    //         document.getElementById('rec_body').innerHTML = msg;
    //         console.log(msg);
    //     })

    //     return false;
    // }

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
            if (functionName == 'rec_home_v2') {
                document.getElementById('rec_home').innerHTML = msg;
            } else {
                document.getElementById(functionName).innerHTML = msg;
            }

            // console.log(msg);
        })
    }


    function chef_recommendation() {
        // var formData = $('#recipe_check').serializeArray();
        // check_ingredient('check_recipe_ing');
        var formData = $('#recipe_check [type=checkbox]').serializeArray();

        console.log(formData);
        for (let i = 0; i < formData.length; i++) {
            const element = formData[i]['value'];
            formData[i]['num'] = get_checked_recipe_num(element);//取得拿到的食譜的數量
        }
        console.log(formData);

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
            print_chart("chef_score_chart_01", 1);
            print_chart("chef_score_chart_02", 2);
            print_chart("chef_score_chart_03", 3);
            // line_chart();
            // console.log(msg);
        })

        return false;
    }

    function get_checked_recipe_num(recipe_id) {
        const GetNumValue = document.getElementById("inputnumber_" + recipe_id).value;
        return GetNumValue;
    }

    function Add(id) {
        let inp = document.getElementById("inputnumber_" + id).value;
        let total = parseInt(inp) + 1;
        document.getElementById("inputnumber_" + id).value = total;
        // totalAdd(id);
        // console.log(inp);
    }

    function Sub(id) {
        let total;
        let inp = document.getElementById("inputnumber_" + id).value;

        //值一旦小於0就減不了 直接給0
        if (parseInt(inp) > 0) {
            total = parseInt(inp) - 1;
        } else {
            total = 0;
        }
        document.getElementById("inputnumber_" + id).value = total;
        // totalSub(id);
    }

    // function totalAdd(id) {
    //     let total = document.getElementById("totalprice").value;
    //     let value = document.getElementById("price_" + id).value;
    //     total = parseInt(total) + parseInt(value);
    //     document.getElementById("totalprice").value = total;
    // }

    // function totalSub(id) {
    //     let total = document.getElementById("totalprice").value;
    //     let value = document.getElementById("price_" + id).value;
    //     if (parseInt(total) <= 0) {
    //         total = 0;
    //     } else {
    //         total = parseInt(total) - parseInt(value);
    //     }
    //     document.getElementById("totalprice").value = total;
    // }

    function order_post(id, name) {

        var formData = $('#recipe_check [type=checkbox]').serializeArray();

        console.log(formData);
        for (let i = 0; i < formData.length; i++) {
            const element = formData[i]['value'];
            formData[i]['num'] = get_checked_recipe_num(element);
        }
        console.log(formData);

        // const swalWithBootstrapButtons = Swal.mixin({ // set swal button css
        //     customClass: {
        //         confirmButton: 'btn btn-info',
        //         cancelButton: 'btn btn-secondary'
        //     },
        //     buttonsStyling: false
        // })

        var OrderTable;
        $.ajax({//ajax start
            type: "post",
            url: "./pages/deal/onsite/Onsite_ShowOrder.php",
            data: {
                formData: formData,
                IsChefRec: 1,
            },
            cache: false
        }).done(function(msg) {
            OrderTable = msg.replace(/(^|>)\s+|\s+(?=<|$)/g, "$1");
            console.log(typeof(OrderTable));
            //swal start
            swal.fire({
                title: '<span style="color:#000000">訂購確認<span>',
                html: OrderTable,
                // html: '<table class="table table-hover"><thead><tr><th scope="col">編號</th><th scope="col">菜單名稱</th><th scope="col">價格</th><th scope="col">訂購數量</th><th scope="col"><b>總計</b></th></tr></thead><tbody><tr><th scope="row">1</th><td>義式香料紙包雞</td><td>350</td><td>1</td><td>350</td></tr><tr><th scope="row">2</th><td>義大利雞肉丸子麵</td><td>130</td><td>3</td><td>390</td></tr></tbody></table>',
                // icon: 'warning',
                background: '#ffffff',
                width: '800px',
                showCancelButton: true,
                confirmButtonText: '訂購',
                cancelButtonText: '取消',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Confirmed");
                    let orderdata = $("#Onsite_OrderId").serializeArray();
                    console.log(orderdata);
                    $.ajax({
                        type: "post",
                        url: "./get_container_value/get_service_home_data.php",
                        data: {
                            functionName: "order",
                            chefid: id,
                            order_data: orderdata,
                            type: 0,
                        },
                        cache: false
                    }).done(function(msg) {
                        let ShowMsg = "";
                        let ShowIcon = "";
                        if(msg == "1"){
                            ShowMsg = "訂購成功!";
                            ShowIcon = "success";
                            
                        } else {
                            ShowMsg = "錯誤!\n";
                            ShowMsg += msg;
                            ShowIcon = "danger";
                        }
                        swal.fire({
                            title: '<span style="color:#000000">' + ShowMsg + '<span>"',
                            text: "廚師: " + name,
                            icon: ShowIcon,
                            background: '#ffffff',
                        }).then((result) => {
                            window.location.href = "./order.php";
                        })
                    })

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swal.fire({
                        title: '<span style="color:#000000">取消<span>"',
                        text: "您取消了訂單",
                        icon: 'error',
                        background: '#ffffff',
                    })
                } else{
                    swal.fire({
                        title: '<span style="color:#000000">取消<span>"',
                        text: "您取消了訂單",
                        icon: 'error',
                        background: '#ffffff',
                    })
                }
            })//end swal
        })//end ajax

    }

    function GetLineChartValue(ElementNum) {
        const similar = document.getElementById("similar_0" + ElementNum).value;
        const rate = document.getElementById("rate_0" + ElementNum).value;
        const total = document.getElementById("total_0" + ElementNum).value;
        const ratelist = [similar, rate, total];
        return ratelist;
    }

    function GetChefName(ElementNum) {
        return document.getElementById("chef_0" + ElementNum).value;
    }

    function line_chart() { //倒閉發臭

        var ctx = document.getElementById("line_chart"),
            example = new Chart(ctx, {
                // 參數設定
                type: "line", // 圖表類型
                data: {
                    labels: ['相似度分數', '評分分數', '總分'],
                    datasets: [{
                        label: GetChefName(1),
                        backgroundColor: "#5D8CAE",
                        borderColor: "#5D8CAE",
                        data: GetLineChartValue(1),
                        fill: false,
                    }, {
                        label: GetChefName(2),
                        fill: false,
                        backgroundColor: "#A4345D",
                        borderColor: "#A4345D",
                        data: GetLineChartValue(2),
                    }, {
                        label: GetChefName(3),
                        fill: false,
                        backgroundColor: "#3A6960",
                        borderColor: "#3A6960",
                        data: GetLineChartValue(3),
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: true,
                        text: '主廚推薦結果前三名'
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                color: ['pink', 'red', 'orange', 'yellow', 'green', 'blue', 'indigo',
                                    'purple'
                                ]
                            },
                            ticks: {
                                min: 0,
                                max: 20,
                                stepSize: 4
                            }
                        }]
                    }
                }

            });
        ctx.update();

    }

    function print_chart(Element_ID, ElementNum) {


        const similar = document.getElementById("similar_0" + ElementNum).value;
        const rate = document.getElementById("rate_0" + ElementNum).value;
        const total = document.getElementById("total_0" + ElementNum).value;

        const ratelist = [similar, rate, total];
        // console.log("similar_0" + ElementNum +  ": " + similar);
        // console.log("rate_0" + ElementNum +  ": " + rate);
        // console.log("total_0" + ElementNum +  ": " + total);
        // console.log(ratelist);
        document.getElementById(Element_ID).innerHTML = null;
        var ctx = document.getElementById(Element_ID),
            example = new Chart(ctx, {
                // 參數設定
                type: "horizontalBar", // 圖表類型
                data: {
                    labels: ["相似度分數", "評分分數", "總分"], // 標題
                    datasets: [{
                        label: "主廚評分表", // 標籤
                        data: ratelist, // 資料
                        backgroundColor: [ // 背景色
                            "#A4345D", //牡丹
                            "#5D8CAE", //群青
                            "#3A6960", //青碧
                        ],
                        borderWidth: 1 // 外框寬度
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                                steps: 10,
                                stepValue: 5,
                                max: 20
                            }
                        }]
                    },
                    animation: {
                        onComplete: function() {
                            var chartInstance = this.chart,
                                ctx = chartInstance.ctx;

                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart
                                .defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = "black";
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function(dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function(bar, index) {
                                    var data = dataset.data[index];
                                    ctx.fillText(data, bar._model.x + 20, bar._model.y + 9);
                                });
                            });
                        }
                    }

                }

            });

    }

    function ChangeRowTotal(crid){
        let price = document.getElementById("price" + crid).value;
        let qty   = document.getElementById("rid" + crid).value;
        document.getElementById("Row_Total" + crid).innerHTML = price * qty;
        document.getElementById("Row_Total_hdn" + crid).value = price * qty;
        ChangeAllTotal();
    }

    function ChangeAllTotal(){
        let TotalElement = document.getElementsByName("Row_Total_hdn");
        let AllTotal = 0;
        for (let i = 0; i < TotalElement.length; i++) {
            AllTotal += parseInt(TotalElement[i].value);
        }
        document.getElementById("All_Total").innerHTML = AllTotal;
    }






    $(document).ready(function() {
        // getrec("rec_head", );
        // getrec("rec_home", );
        getrec("rec_home_v2", <?php echo "'" . $_GET['type'] . "'"?>);
        



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