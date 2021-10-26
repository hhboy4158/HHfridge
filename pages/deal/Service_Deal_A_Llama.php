<?php
// session_start();
require_once '../../connections/Account.php';
include("../../top.php");
?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" /> -->
<!-- dataTables -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="./scss/selection.css">

<body class="goto-here">
    <section class="ftco-section">


        <main>
            
            <section class="py-5 text-center container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <a href="Service_home.php">
                                <image src="./images/icon/delivery.jpg" class="selection" alt="">
                            </a>
                            <div class="card-body">
                                <h2>
                                    <p class="card-text">外送到府</p>
                                </h2>
                                <!-- <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                        </div>
                                        <small class="text-muted">9 mins</small>
                                    </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm ">
                            <a href="./rec.php">
                                <image src="./images/icon/homee.jpg" class="selection" alt="">
                            </a>
                            <div class="card-body">
                                <h2>
                                    <p class="card-text">到府服務</p>
                                </h2>
                                <!-- <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                        </div>
                                        <small class="text-muted">9 mins</small>
                                    </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>



        </main>


    </section>




    <?php include("../../footer.php"); ?>
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
    <?php //$_GET["chefid"]?>
    window.onload = function() {
        LoadPage("head", <?php echo $_GET["chefid"];?>, "data");
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

        var radios = document.getElementsByName('checkservice');
        var service;
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                // do whatever you want with the checked radio
                console.log(radios[i].value);
                service = radios[i].value;
                // only one radio can be logically checked, don't check the rest
                break;
            }
        }

        var inps = document.getElementsByName('recipe_name[]');
        var inps = $("input[name='recipe_name[]']").map(function() {
            return $(this).val();
        }).get();
        console.log(inps);
        $.ajax({
            type: "post",
            url: "./get_container_value/get_selectchef_data.php",
            data: {
                functionName: "checkprice",
                inps: inps,
                service: service,
                chefid: <?php echo $_GET["chefid"];?>
            },
            cache: false
        }).done(function(msg) {
            document.getElementById("modalbody").innerHTML = msg;
        })
        // for (var i = 0; i < inps.length; i++) {
        //     var inp = inps[i];
        //     console.log("pname[" + i + "].value=" + inp.value);
        // }

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
        // var hre = 
        //alert("127.0.0.1/vegefoods/Recommended_Score.php?Pages=" + num);
        window.location.href = "./Recommended_Score.php?Pages=" + num;
        return false;
        // location.replace("./index.php");
        // location.reload();


    }
    </script>