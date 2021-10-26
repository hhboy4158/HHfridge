<?php

include("./top.php");


require_once './connections/Account.php';

$fid = $_GET["fid"];

$sql = "SELECT * FROM `allrec` WHERE id = '$fid'";
$result = mysqli_query($conn, $sql);



?>


<div class="hero-wrap hero-bread" style="background-image: url('images/bg/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread">
                    <?php
            while($row = mysqli_fetch_row($result)){
              echo $row[1];
            }
          ?>
                </h1>
            </div>
        </div>
    </div>
</div>


<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row" id="tbody">
            <input type="hidden" name="test" value="i " />
            <input type="hidden" name="test" value="see " />
            <input type="hidden" name="test" value="you" />
            <script>
            var object = document.getElementsByName("test");
            for (let i = 0; i < object.length; i++) {
                console.log(object[i].value);
            }
            </script>
        </div>
    </div>
</section>




<!-- END comment-list -->




<?php include("./footer.php"); ?>

<script type="text/javascript">
loadFood("personal", <?php echo $_GET["fid"]; ?>);

// 載入食譜資料
function loadFood(functionName, fid) {

    $.ajax({
        type: "post",
        url: "./get_container_value/get_food_data.php",
        data: {
            functionName: functionName,
            fid: fid
        },
        cache: false
    }).done(function(msg) {
        document.getElementById("tbody").innerHTML = msg;
    })
}


function sleep(time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}

// 延遲時間，因為資料載入順序問題，如果優先載一下的資訊，會抓不到分數，所以讓
// 這邊先延遲等待，資料載入完畢後再執行以下方法
sleep(500).then(() => {
    $(document).ready(function() {
        $(`input[type=radio][name=score]`).change(function() {
            // 取得食物

            const food = document.getElementsByName(`food_`)[0].value;
            const score = this.value;
            const foodname = document.getElementsByName(`food_`)[1].value;

            // alert(foodname);
            // 取得 radio 質
            $.ajax({
                type: "post",
                url: "./get_container_value/get_food_data.php",
                data: {
                    food: food,
                    score: score,
                    foodname: foodname,
                    functionName: "comment"
                },
                cache: false
            }).done(function(msg) {

                if (msg == "1") {
                    alert("完成評分!");
                    location.reload();
                } else if (msg == "0") {
                    alert("請先登入再評分!");
                    location.href = "./pages/login/login.php";
                } else {
                    console.log(msg);
                }
            })
        });
    });
})
/*foodstep(<?php //echo $_GET["fid"]; ?>);*/
function foodstep(fid) {
    $.ajax({
        type: "post",
        url: "./get_container_value/get_step.php",
        data: {
            fid: fid
        },
        //  timeout: 1500,
        cache: false
    }).done(function(msg) {
        document.getElementById('step').innerHTML = msg;
    })
}

function makefood(fid) {

    var foodUpdata = $("#make_food").serializeArray();
    console.log(foodUpdata);
    $.ajax({
        type: "post",
        url: "./get_container_value/get_food_data.php",
        data: {
            fid: fid,
            foodUpdata: foodUpdata,
            functionName: "make",
        },
        cache: false,
    }).done(function(msg) {
        if(msg == ""){
            alert("扣除成功");
            location.reload;
        }else{
            console.log(msg);
        }
        
        location.reload();

    })

    return false;
}
</script>