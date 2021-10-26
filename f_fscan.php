<?php include("./top.php"); ?>

<div class="hero-wrap hero-bread" style="background-image: url('images/bg/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="./index.php">Home</a></span>
                    <h1 class="mb-0 bread">食材辨識</h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <!-- <span class="subheading">All recipes</span> -->
                <h2 class="mb-4">食材辨識</h2>
                <p>掃描食材並辨識</p>
            </div>
        </div>
        <div class="row">
            <!-- column -->
            <div class="col-12">
                <div class="card" style="border: 0px;">
                    <div class="card-body text-center">
                        <div class="d-flex">
                            <div class="ml-auto" id="slp">

                            <!-- <p style="color:red; font-size:30px;">辨識中，請稍後...</p> -->
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="col-md-12 text-center">
                            <button onclick="slptime();"  class="btn btn-primary">拍攝食材並辨識</button><!-- id="grabFrame" -->
                            <div class="select">
                                <br>
                                <label for="videoSource">Video source:<select id="videoSource"></select></label>
                            </div>
                        </div>
                        <button id="takePhoto" style="display:none">物件拍照</button>

                        <input style="display: none;" class="hidden" id="zoom" type="range" step="20">
                    </div>
                    <video autoplay playsinline class="hidden"></video>
                    <img class="hidden">
                    <canvas class="hidden"></canvas>
                </div>
            </div>
        </div>


        <!-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#InsertIng">
            <div class="col-sm-6 col-md-4 col-lg-3"><i class="fa fa-plus-square-o"></i> 新增食材</div>
        </button> -->

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
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">食材名稱</span>
                                </div>
                                <input name="adding" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="">
                            </div>
                            <br>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">數量</span>
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

    </div>
</section>


<?php include("./footer.php"); ?>

<!--拍照的fumction在"fscan/js/main.js"裡面-->
<script src="./js/fscan.js"></script>

<script type="text/javascript">
    function submitIng() {
        const ing = document.getElementsByName("adding")[0].value;
        const num = document.getElementsByName("addnum")[0].value;
        $.ajax({
            type: "POST",
            url: "pages/InsertIng.php",
            data: {
                ing: ing,
                num: num,
            },
            cache: false
        }).done(function(msg) {
            alert(msg);
            // document.getElementById("insertDone").innerHTML = msg;
        })

    }
    function slptime(){
        document.getElementById("slp").innerHTML='<p style="color:red; font-size:30px;">辨識中，請稍後...</p>';
        var t=setTimeout("alert(‘1 seconds!’)",1000);
        
        alert('123');
        // $.ajax({
        //     type: "POST",
        //     url: "pages/slp.php",
        //     data: {
        //         // ing: ing,
        //         // num: num,
        //     },
        //     cache: false
        // }).done(function(msg) {
        //     alert(msg);
        //     document.getElementById("slp").innerHTML = msg;
            
        // })

    }
</script>