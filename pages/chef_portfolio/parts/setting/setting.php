<section id="setting" class="inner-page">
    <div class="container">
        <div class="section-title" data-aos-anchor-placement="top-bottom" data-aos="fade-up" data-aos-duration="500">
            <h2>修改基本資料</h2>
            <p></p>
        </div>
        <form id="ChefSetting" autocomplete="off" onsubmit="return ChefUpdateSetting(); return false">
            <div class="form-group" data-aos-anchor-placement="top-bottom" data-aos="fade-up" data-aos-duration="600">
                <label for="inputAddress">住址</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St"
                    value=<?php echo '"' . $row_user['address'] . '"'?>>
            </div>
            <div class="form-group" data-aos-anchor-placement="top-bottom" data-aos="fade-up" data-aos-duration="700">
                <label for="inputphone">電話</label>
                <input type="text" class="form-control" id="inputphone" placeholder="Apartment, studio, or floor"
                    value=<?php echo '"' . $row_user['phone'] . '"'?>>
            </div>
            <div class="input-group" data-aos-anchor-placement="top-bottom" data-aos="fade-up" data-aos-duration="800">
                <div class="input-group-prepend">
                    <span class="input-group-text">個人簡介 (500字以內)</span>
                </div>
                <textarea id="ChefIntroduction" class="form-control" aria-label="With textarea" rows="10"><?php 
                    $text_intro = str_replace( " " , "" , $row_user['about']);
                    $text_intro = str_replace( "<br>" , "" , $text_intro);
                    $text_intro = str_replace( "</br>" , "" , $text_intro);
                    $text_intro = str_replace( "<hr>" , "" ,$text_intro);
                    $text_intro = str_replace( "<script>" , "" , $text_intro);
                    $text_intro = str_replace( "</script>" , "" , $text_intro);
                    echo $text_intro;
                    ?></textarea>
            </div>
            <br>
            <div class="form-group" data-aos-anchor-placement="top-bottom" data-aos="fade-up" data-aos-duration="900">
                <div class="form-check">
                    <div class="row">
                        <h5>選擇專長</h5>
                        <div id="skill_id">

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="input-group mb-3 col-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text">到府服務額外費用</span>
                    </div>
                    <input type="number" id="os_cost" class="form-control" aria-label="Amount (to the nearest dollar)"
                    value="<?php echo $row_user['OnSiteService']?>">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>

                <div class="input-group mb-3 col-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text">外送服務額外費用</span>
                    </div>
                    <input type="number" id="d_cost" class="form-control" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
            </div>


            <hr>
            <div class="form-group" data-aos-anchor-placement="top-bottom" data-aos="fade-up" data-aos-duration="1000">
                <div class="row justify-content-md-center">
                    <!-- <div class="col-md-6 ">
                        <a href="./../logout/logout.php">
                            <input type="butten" class="btn btn-outline-dark btn-lg btn-block form-control" value="登出">
                        </a>
                    </div> -->
                    <br><br><br>
                    <div class="col-md-12 ">
                        <button type="submit" class="btn btn-outline-success btn-lg btn-block form-control">送出</button>

                    </div>
                </div>
            </div>

        </form>
    </div>
    <div style="height:100px;"></div>
</section>

<script>
function loadskill(divID) {
    $.ajax({
        type: "post",
        url: "./../../get_container_value/get_food_class_all.php",
        data: {
            functionName: "skill",
        },
        cache: false
    }).done(function(msg) {
        document.getElementById(divID).innerHTML = msg;
    })
}
</script>