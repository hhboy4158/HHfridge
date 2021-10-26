<?php
// session_start();
require_once './connections/Account.php';
include("./top.php");
?>
<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" /> -->
<!-- dataTables -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<body class="goto-here">

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="./index.php">Home</a></span>
                    <h1 class="mb-0 bread">食譜總覽</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">All recipes</span>
                    <h2 class="mb-4">食譜總覽</h2>
                    <p>以下為本平台收錄之所有食譜</p>
                </div>
            </div>
        </div>
        <div class="container">
            <ul class="nav justify-content-center" id="menu">

            </ul>
            <div class="row" id="foodlist">

                <!------------------------------------------------------------>

                <!------------------------------------------------------------>
                <table id="ScoreDataTable" class="table table-hover cell-border">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" width="150px">食譜名稱</th>
                            <th scope="col" width="250px">所需食材</th>
                            <th scope="col" width="100px">心臟病</th>
                            <th scope="col" width="90px">肺炎</th>
                            <th scope="col" width="90px">糖尿病</th>
                            <th scope="col" width="160px" style="min-width:120px">下呼吸道疾病</th>
                            <th scope="col" width="90px">高血壓</th>
                            <th scope="col" width="90px">腎病</th>
                            <th scope="col" width="90px">肝病</th>
                        </tr>
                    </thead>
                    <tbody id="tabby">
                        <!-- <tr>
                                <th scope="row">' . $row['ID'] . '</th>
                                <td>' . $row['name'] . '</td>
                                <td>' . $row['ing'] . '</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                                <td>8</td>
                                <td>9</td>
                                <td>10</td>
                            </tr> -->
                    </tbody>

                </table>
            </div>
        </div>
        <?php //include("./part/Rec_Score_pages.php"); ?>
        <!-- <form id="input_pages" action="" onsubmit="PageSubmit(); return false;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="input-group input-group-lg col-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-lg">輸入頁數</span>
                        </div>
                        <input id="PageNumber" type="text" class="form-control" aria-label="Large"
                            aria-describedby="inputGroup-sizing-sm" autocomplete="off">
                    </div>
                </div>
            </div>
        </form> -->
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
        LoadRecipe("Score_recom", <?php echo $_GET['Pages']?>, 0, '#ScoreDataTable');
    }


    function LoadRecipe(functionName, pages, orderby, tableID) {
        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: functionName,
                pages: pages,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById("tabby").innerHTML = msg;
            //console.log(msg);
            setDataTable(tableID);
        })
    }

    function setDataTable(ID) {
        $(ID).DataTable({
            searching: false,
            autoWidth:true,
            processing: true,
            scrollCollapse:true,
            //scrollX:"50px",
            scrollY:"1500px",
            "language": {
                "processing": "處理中...",
                "loadingRecords": "載入中...",
                "lengthMenu": "顯示 _MENU_ 項結果",
                "zeroRecords": "沒有符合的結果",
                "info": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "infoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                "infoFiltered": "(從 _MAX_ 項結果中過濾)",
                "infoPostFix": "",
                //"search": "搜尋:",
                "paginate": {
                    "first": "第一頁",
                    "previous": "上一頁",
                    "next": "下一頁",
                    "last": "最後一頁"
                },
                "aria": {
                    "sortAscending": ": 升冪排列",
                    "sortDescending": ": 降冪排列"
                }
            }
        });
    };

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