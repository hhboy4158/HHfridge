<?php
// session_start();
require_once './connections/Account.php';
include("./top.php");
?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" /> -->
<!-- dataTables -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<body class="goto-here">
    <section class="ftco-section">


        <main>

            <section class="py-5 text-center container">
                <div id="data" class="row py-lg-5">
                <!-- head here -->
                </div>
                <form action="#" id="form_order">
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">小計</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                                <div id="modalbody" class="modal-body">
                                <!-- modal body here -->
                                </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">不好</button>
                                <button type="button" class="btn btn-primary" onclick="return order_post(); return false;">好</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </section>

            <div class="py-5 bg-light">
                <div class="container">
                    <h2>為您推薦</h2>
                    <br>
                    <div id="recomm" class="row">
                        
                    </div>

                    <hr>

                    <h2>菜品總覽</h2>
                    <br>
                    <div id="recipe" class="row">
                        
                    </div>

                </div>
            </div>

        </main>

    </section>

    <?php include("./footer.php"); ?>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <!-- dataTables -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
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
    window.onload = function() {
        var count = 0;
        LoadPage("head", <?php echo $_GET["chefid"];?>, "data");
        LoadPage("recomm", <?php echo $_GET["chefid"];?>, "recomm");
        LoadPage("recipe", <?php echo $_GET["chefid"];?>, "recipe");
        
    }


    function LoadPage(functionName, chefid, ElementId) {
        $.ajax({
            type: "post",
            url: "./get_container_value/get_selectchef_data.php",
            data: {
                functionName: functionName,
                chefid: chefid,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById(ElementId).innerHTML = msg;
        })
    }

    function modalprice(functionName) {

        // var radios = document.getElementsByName('checkservice');
        // var service;
        // for (var i = 0, length = radios.length; i < length; i++) {
        //     if (radios[i].checked) {
        //         // do whatever you want with the checked radio
        //         console.log(radios[i].value);
        //         service = radios[i].value;
        //         // only one radio can be logically checked, don't check the rest
        //         break;
        //     }
        // }

        // var inps = document.getElementsByName('recipe_name[]')[0].value;
        var inps = $("input[name='recipe_name[]']").map(function() {
            // return  ($(this).val() != 0) ? $(this).val() : null;
            return  $(this).val();
        }).get();
        console.log(inps);
        $.ajax({
            type: "post",
            url: "./get_container_value/get_selectchef_data.php",
            data: {
                functionName: "checkprice",
                inps: inps,
                // service: service,
                chefid: <?php echo $_GET["chefid"];?>
            },
            cache: false
        }).done(function(msg) {
            document.getElementById("modalbody").innerHTML = msg;
            var d = $('#form_order input[type=hidden]').serializeArray();
            // var dd = document.getElementsByName("rid").value;
            console.log(d);
        })
        // for (var i = 0; i < inps.length; i++) {
        //     var inp = inps[i];
        //     console.log("pname[" + i + "].value=" + inp.value);
        // }

    }

    function order_post(){
        var order_data = $('#form_order input[type=hidden]').serializeArray();
        console.log(order_data);
        $.ajax({
            type: "post",
            url: "./get_container_value/get_selectchef_data.php",
            data: {
                functionName: "order",
                order_data: order_data,
                type: 1,
                chefid: <?php echo $_GET["chefid"];?>
            },
            cache: false
        }).done(function(msg) {
            console.log(msg);
            if(msg == "1"){
                alert("訂單已送出");
                window.location.href="./order.php";
            } else {
                alert(msg);
            }
        })
    }

    // function setDataTable(ID) {
    //     $(ID).DataTable({
    //         searching: false,
    //         autoWidth: true,
    //         processing: true,
    //         scrollCollapse: true,
    //         //scrollX:"50px",
    //         scrollY: "1500px",
    //         "language": {
    //             "processing": "處理中...",
    //             "loadingRecords": "載入中...",
    //             "lengthMenu": "顯示 _MENU_ 項結果",
    //             "zeroRecords": "沒有符合的結果",
    //             "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
    //             "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
    //             "infoFiltered": "(從 _MAX_ 項結果中過濾)",
    //             "infoPostFix": "",
    //             //"search": "搜尋:",
    //             "paginate": {
    //                 "first": "第一頁",
    //                 "previous": "上一頁",
    //                 "next": "下一頁",
    //                 "last": "最後一頁"
    //             },
    //             "aria": {
    //                 "sortAscending": ": 升冪排列",
    //                 "sortDescending": ": 降冪排列"
    //             }
    //         }
    //     });
    // }

    function PageSubmit() {
        const num = document.getElementById("PageNumber").value;
        window.location.href = "./Recommended_Score.php?Pages=" + num;
        return false;


    }

    function Add(id){
        let inp = document.getElementById("inputnumber_" + id).value;
        let total = parseInt(inp) + 1;
        document.getElementById("inputnumber_" + id).value = total;
        totalAdd(id);
        // console.log(inp);
    }

    function Sub(id){
        let total;
        let inp = document.getElementById("inputnumber_" + id).value;

        //值一旦小於0就減不了 直接給0
        if(parseInt(inp) > 0){
            total = parseInt(inp) - 1;
        } else {
            total = 0;
        }
        document.getElementById("inputnumber_" + id).value = total;
        totalSub(id);
    }

    function totalAdd(id){
        let total = document.getElementById("totalprice").value;
        let value = document.getElementById("price_" + id).value;
        total = parseInt(total) + parseInt(value);
        document.getElementById("totalprice").value = total;
    }

    function totalSub(id){
        let total = document.getElementById("totalprice").value;
        let value = document.getElementById("price_" + id).value;
        if(parseInt(total) <= 0){
            total = 0;
        } else {
            total = parseInt(total) - parseInt(value);
        }
        document.getElementById("totalprice").value = total;
    }

    /**
     * 同步相同菜品的資料
     */
    function Synchronize_InputData(recipe_id) {
        let inputvalue = document.getElementById("inputnumber_" + recipe_id).value;
        // let num1 = document.getElementById("rec_inputnumber_" + recipe_id).value;
        if (isNaN(inputvalue)){
            document.getElementById("rec_inputnumber_" + recipe_id).value = inputvalue;
        } else {

        }
    }
    </script>