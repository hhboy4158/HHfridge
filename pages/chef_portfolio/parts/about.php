<?php
    $phone = str_split($row_user['phone']);
    $phone_split = '';
    for($i = 0; $i <= count($phone); $i++){
      if($i % 3 == 0){
        if($i == 9){
          break;
        }else if($i == 0){
          $phone_split .= $phone[$i];
        }else{
          $phone_split .= "-";
          $phone_split .= $phone[$i];
        }
      }else{
        $phone_split .= $phone[$i];
      }
    }
?>

<section id="about" class="about">
    <div class="container">

        <div class="section-title">
            <?php
            echo '<h2>'.$row_user['ChefFirstName']. $row_user['ChefName'] . '</h2>
                  <p>' . $row_user['about'] . '</p>';
            ?>
        </div>

        <div class="row">
            <div class="col-lg-4" data-aos="fade-right">
                <?php
                if($row_user['img'] == "0"){
                  echo '<img src="./../../images/users/user.png" class="img-fluid" alt="">';
                }else{
                  echo '<img src="./../../images/users/' . $row_user['img'] . '" class="img-fluid" alt="">';
                }
          ?>

            </div>
            <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
                <h3>關於<?php echo $row_user['ChefName']?></h3>
                <p class="font-italic">
                    <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore
                    magna aliqua. -->
                </p>
                <div class="row">
                    <div class="col-lg-6">
                        <ul>
                            <li><i class="icofont-rounded-right"></i> <strong>姓名
                                    :</strong><?php echo '  ' . $row_user['ChefFirstName'] . $row_user['ChefName'];?>
                            </li>
                            <li><i class="icofont-rounded-right"></i> <strong>註冊日期 :
                                </strong><?php echo $row_user['signup_date'];?></li>
                            <li><i class="icofont-rounded-right"></i> <strong>連絡電話 : </strong> +886
                                <?php echo $phone_split;?></li>
                            <li><i class="icofont-rounded-right"></i> <strong>住址 :
                                </strong><?php echo $row_user['address']?></li>
                            <li><i class="icofont-rounded-right"></i> <strong>專長 : </strong><?php echo $skill_string?>
                            </li>
                            <li><i class="icofont-rounded-right"></i><button type="button" class="btn btn-secondary"
                                    data-toggle="modal" data-target="#ModalCustom">新增自訂菜單</button></li>
                            <li><i class="icofont-rounded-right"></i><button type="button" class="btn btn-secondary"
                                    data-toggle="modal" data-target="#ModalExisting">新增平台現有菜單</button></li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <ul>
                            <!-- <li><i class="icofont-rounded-right"></i> <strong>Age:</strong> 30</li>
                            <li><i class="icofont-rounded-right"></i> <strong>Degree:</strong> Master</li>
                            <li><i class="icofont-rounded-right"></i> <strong>PhEmailone:</strong> email@example.com
                            </li>
                            <li><i class="icofont-rounded-right"></i> <strong>Freelance:</strong> Available</li> -->
                        </ul>
                    </div>
                </div>
                <!-- <p>
              Officiis eligendi itaque labore et dolorum mollitia officiis optio vero. Quisquam sunt adipisci omnis et ut. Nulla accusantium dolor incidunt officia tempore. Et eius omnis.
              Cupiditate ut dicta maxime officiis quidem quia. Sed et consectetur qui quia repellendus itaque neque. Aliquid amet quidem ut quaerat cupiditate. Ab et eum qui repellendus omnis culpa magni laudantium dolores.
            </p> -->
            </div>
        </div>

    </div>
    
</section>
<!-- Modal Custom -->
<div class="modal fade" id="ModalCustom" tabindex="-1" role="dialog" aria-labelledby="ModalCustom" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="#" id="addrec" onsubmit="return recipe_submit(); return false;">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCustomLabel">新增菜單</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">菜單名稱</span>
                        </div>
                        <input type="text" id="recipe_name" class="form-control" aria-label="Default"
                            aria-describedby="inputGroup-sizing-default" autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-file">
                                <input id="recimg" type="file" class="custom-file-input">
                                <label class="custom-file-label" for="customFile">選擇照片</label>
                            </div>
                            <hr>
                            <div id="img_preview">
                                <img src="./../../images/chef_recipe/item.png" height="200" width="200" alt="未選擇檔案"
                                    class="rounded mx-auto d-block" style="max-width:200px;max-height:200px">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="FormControlSelectPrice_c">選擇價位</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="FormControlSelectPrice_c" type="text" class="form-control"
                                        aria-label="Amount (to the nearest dollar)"
                                        oninput='FormControlSelectPrice_c.setCustomValidity(FormControlSelectPrice_c.value > 9999 ? "請輸入 10,000元以下的金額" : "")' required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="recipe_type">菜單類型</label>
                                <select class="form-control" id="recipe_type">
                                    <?php 
                                        session_start();
                                        $account = "'" . $_SESSION['family_username'] . "'";
                                        require_once './../../connections/Account.php';
                                        $sql = 'SELECT t.* FROM `type` as t INNER JOIN chef_skill as cs INNER JOIN chef_account as ca WHERE t.fid = cs.chef_type and ca.ID = cs.chef_ID and ca.account = '. $account;
                                        $result = mysqli_query($conn, $sql) or die($sql);
                                        while($row = mysqli_fetch_array($result)){
                                            echo '<option value="' . $row['fid'] . '">' . $row['name'] . '</option>';
                                        }
                                        // SELECT t.* FROM `type` as t INNER JOIN chef_skill as cs INNER JOIN chef_account as ca WHERE t.fid = cs.chef_type and ca.ID = cs.chef_ID and ca.account = 'test'
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipe_info">菜單資訊</label>
                        <textarea class="form-control" id="recipe_info" rows="3"></textarea>
                    </div>
                    <hr>
                    <button type="button" class="btn btn-secondary" onclick="return add()">新增食材</button>
                    <br><br>
                    <div id="add_ing" class="row"></div>
                    <div class="row">
                        <div id="alert_text" class="col-6">
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
<!-- /Modal Custom -->
<!-- Large modal -->

<div id="ModalExisting" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
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
                        <div class="row justify-content-md-center">
                            <figure class="text-center">
                                <blockquote class="blockquote" style="font-size:30px;">
                                    <p>新增菜單</p>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                    <cite title="Source Title">您可以新增本平台的預設菜單。</cite>
                                    <cite id="checknum" title="Source Title">目前選擇了 0 道。</cite>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-6 text-center">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input id="FormControlSelectPrice" type="text" class="form-control"
                                        aria-label="Amount (to the nearest dollar)"
                                        oninput='FormControlSelectPrice.setCustomValidity(FormControlSelectPrice.value > 9999 ? "請輸入 10,000元以下的金額" : "")' required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-center">
                                <!-- <div id="checknum"><p>目前選擇了 0 道</p></div> -->
                                <div id="ModalExistingCheck" class="btn-group btn-group-toggle" role="group"
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
<!-- /Large modal -->
<script>

function add() {
    var a;
    var b =
        '<div class="input-group mb-3 col-12"><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-default">食材名稱</span></div><input type="text" name="ing_name" class="form-control" aria-label="Default"aria-describedby="inputGroup-sizing-default" autocomplete="off"></div>';
    var c =
        '<div class="input-group mb-3 col-6"><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-default">數量</span></div><input type="text" value="1" name="ing_num" class="form-control" aria-label="Default"aria-describedby="inputGroup-sizing-default" autocomplete="off"></div>';
    var d =
        '<div class="input-group mb-3 col-6"><div class="input-group-prepend"><span class="input-group-text" id="inputGroup-sizing-default">單位</span></div><input type="text" value="個" name="ing_unit" class="form-control" aria-label="Default"aria-describedby="inputGroup-sizing-default" autocomplete="off"></div>';
    document.getElementById("add_ing").innerHTML += b + c + d;
}

function recipe_submit() {

    //取得種類
    var rec_type = document.getElementById('recipe_type').value;
    console.log("種類: " + rec_type);

    //取得價位
    var rec_price = document.getElementById('FormControlSelectPrice').value;
    console.log("價位: " + rec_price);

    //取得菜單名稱
    var rec_name = document.getElementById('recipe_name').value;
    console.log("菜單名稱: " + rec_name);

    //取得菜單資訊
    var rec_info = document.getElementById('recipe_info').value;
    console.log("菜單資訊: " + rec_info);

    //取得所有食材
    var rec_data = $('#addrec').serializeArray();
    console.log(rec_data);

    $.ajax({
        type: "post",
        url: "./parts/proccessing/recipe_submit.php",
        data: {
            rec_type: rec_type,
            rec_price: rec_price,
            rec_name: rec_name,
            rec_info: rec_info,
            rec_data: rec_data,
        },
        cache: false
    }).done(function(msg) {
        switch (msg) {
            case "0":
                document.getElementById("alert_text").innerHTML = "<p style='color:red;'>尚未填寫完畢!</p>";
                break;
            case "1":
                swal({
                    title: "新增成功!",
                    text: "",
                    icon: "success",
                    buttons: true,
                    // dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        window.location.reload();
                    } else {
                        swal("Your imaginary file is safe!");
                        window.location.reload();
                    }
                });

                break;
            case "2":
                document.getElementById("alert_text").innerHTML = "<p style='color:red;'>別亂改選項好ㄇ</p>";
                break;
        }
        if (msg == "0") {
            document.getElementById("alert_text").innerHTML = "<p style='color:red;'>尚未填寫完畢!</p>";
        }
        // document.getElementById("check_body").innerHTML = msg;
        console.log(msg);
    })
    return false;
}


function loadSystemRecipeCheck(divID) {
    console.log("loadSystemRecipeCheck start");
    $.ajax({
        type: "post",
        url: "./parts/proccessing/loadSystemRecipe.php",
        data: {
            divID: divID,
            //PageValue: PageValue,
        },
        cache: false
    }).done(function(msg) {
        console.log("loadSystemRecipeCheck done");
        document.getElementById(divID).innerHTML = msg;
        loadSystemRecipeBody('ModalExistingBody');

    });
}

function loadSystemRecipeBody(divID) {
    var num = document.getElementsByName('btnradio');
    var num_length = num.length;
    // console.log(num[0].type);
    for (let i = 0; i < num_length; i++) {
        let typ = num[i].type;
        let val = num[i].value;
        if (typ === 'radio' && num[i].checked == true) {
            $.ajax({
                type: "post",
                url: "./parts/proccessing/loadSystemRecipe.php",
                data: {
                    divID: divID,
                    val: val,
                },
                cache: false
            }).done(function(msg) {
                document.getElementById(divID).innerHTML = msg;

            });
        }

    }

}

function GetCheckNum() {
    var num = document.getElementsByName('RecipeCheckbox');
    var num_length = num.length;
    var count = 0;
    for (let i = 0; i < num_length; i++) {
        let typ = num[i].type;
        if (typ === 'checkbox' && num[i].checked == true) {
            count++;
        }
    }
    document.getElementById("checknum").innerHTML = "目前選擇了 " + count + " 道";

}



function SystemRecipeSubmit() {
    var rec_price = document.getElementById('FormControlSelectPrice').value;
    var skill = $('#CheckList [type=checkbox]').serializeArray();
    console.log(skill);
    $.ajax({
        type: "post",
        url: "./parts/proccessing/SystemRecipeSubmit.php",
        data: {
            skill: skill,
            rec_price: rec_price,

        },
        cache: false
    }).done(function(msg) {
        console.log(msg);
        swal({
            title: "新增成功!",
            text: "",
            icon: "success",
            buttons: true,
            // dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.location.reload();
            } else {
                swal("Your imaginary file is safe!");
                window.location.reload();
            }
        });
    });
    return false;
}



window.onload = function() {
    console.log("window.onload");
    loadSystemRecipeCheck('ModalExistingCheck');
    loadskill("skill_id"); //this function located in setting.php

    $(function() {
        $('#recimg').on('change', function(event) {
            var files = event.target.files;
            var image = files[0]
            var reader = new FileReader();
            reader.onload = function(file) {
                var img = new Image();
                img.style = "max-width:200px;max-height:200px;";
                img.className = "rounded mx-auto d-block";
                console.log(file);
                img.src = file.target.result;
                console.log(img);
                $('#img_preview').html(img);
            }
            reader.readAsDataURL(image);
            console.log(files);
        });
    });

}
</script>