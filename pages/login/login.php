<?php
    session_start();
    if(isset($_SESSION['family_username']) and isset($_SESSION['family_password'])){
        unset($_SESSION['family_username']);
        unset($_SESSION['family_password']);
    }
?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel=stylesheet type="text/css" href="./login2.css">
    <title>結合慢性病照護與食譜推薦之智慧冰箱</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/yt.png">
    <link href="./../../vendor/aos/aos.css" rel="stylesheet">
</head>

<body style="font-family: '微軟正黑體' ">
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-lg-6 col-12 d-none d-md-flex bg-image"></div>
            <!-- The content half -->
            <div class="col-lg-6 col-12 bg-light">
                <div class="login d-flex align-items-center py-5">
                    <!-- Demo content-->
                    <div class="container">
                        <div class="col-md-12 col-lg-10 col-xl-7 col-12 mx-auto">
                            <p class="text-center mb-4" style="font-size: 1.8rem;" data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="200">結合慢性病照護與食譜推薦之智慧冰箱</p>
                            <p class="text-center mb-4"  data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="300">Welcome back!</p>
                            <form method="POST" action="family_login_into.php" onsubmit="login(); return false;">
                                <div class="form-group mb-3" data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="400">
                                    <input id="inputEmail" type="text" name="username" placeholder="輸入帳號" required
                                        autocomplete="off" class="form-control rounded-pill border-0 shadow-sm px-4">
                                </div>
                                <div class="form-group mb-3" data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="500">
                                    <input id="inputPassword" type="password" name="password" placeholder="輸入密碼"
                                        required=""
                                        class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                </div>
                                <!-- <div class="custom-control custom-checkbox mb-3">
                                        <input id="customCheck1" type="checkbox" checked class="custom-control-input">
                                        <label for="customCheck1" class="custom-control-label">Remember password</label>
                                    </div> -->
                                <div class="form-group" data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="600">
                                    <div class="custom-control custom-checkbox small" id="alertMsg">
                                    </div>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary btn-block text-uppercase rounded-pill mb-2  shadow-sm" data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="700">登入</button>

                                <a href="./register.php">
                                    <button type="button"
                                        class="btn btn-primary btn-block col-md-12 text-uppercase rounded-pill mb-2  shadow-sm"
                                        data-dismiss="modal" data-toggle="modal"
                                        data-target="#exampleModalCenter" data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="800">使用者註冊</button>
                                </a>
                                <hr>
                                <button type="button"
                                    class="btn btn-info btn-block text-uppercase rounded-pill mb-2 shadow-sm"
                                    onclick="location.href='../../index.php'" data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="900">回到首頁</button>
                            </form>
                            <!-- Modal sign up ///////////////////////////////////////////////////////////////////////////////////////-->
                            <!-- <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <form action="#" method=post
                                    oninput='chkpsd.setCustomValidity(chkpsd.value != userpsd.value ? "Passwords do not match." : "")'
                                    onsubmit="signup(); return false;">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">註冊</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>使用者帳號<input type="text" class="form-control" maxlength="12"
                                                        minlength="4" id="useracc" name="useracc" autocomplete="off"
                                                        required=""></p>
                                                <small> <b style="color: red">*</b> 帳號輸入長度範圍 (4-12)</small>
                                                <br><br>
                                                <p>使用者密碼<input type="password" maxlength="12" minlength="4"
                                                        pattern="(?=^[A-Za-z0-9]{4,12}$)^.*$" class="form-control"
                                                        id="userpsd" name="userpsd" autocomplete="off" required=""></p>
                                                <small> <b style="color: red">*</b> 密碼輸入長度範圍 (4-12)
                                                    ，密碼內容包含(A-Z,a-z,1,9)</small>
                                                <br><br>
                                                <p>再輸入一次密碼<input type="password" class="form-control" id="chkpsd"
                                                        name="chkpsd" autocomplete="off" required=""></p>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small" id="alertMessage">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">關閉</button>
                                                <input type="submit" class="btn btn-primary" value="送出">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> -->
                            <!-- /Modal //////////////////////////////////////////////////////////////////////////////////////-->
                        </div>
                    </div><!-- container -->
                </div>
            </div><!-- End -->
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>
<script src="./../../vendor/aos/aos.js"></script>
<script type="text/javascript">
AOS.init();
function alertMsg(msg, color) {
    document.getElementById('alertMsg').innerHTML = "<span style='color:" + color + "'>*" + msg + "</span>";
}

function login() {
    var acc = document.getElementsByName('username')[0].value;
    var psd = document.getElementsByName('password')[0].value;
    $.ajax({
        type: "POST",
        url: "./loginsubmit.php",
        data: {
            acc: acc,
            psd: psd,
        },
        cache: false
    }).done(function(msg) {
        switch (msg) {

            case "0"://一般用戶
                window.location.href = "./../../index.php";
                break;

            case "1"://登入失敗
                alertMsg("登入失敗，帳號或密碼錯誤!", "red")
                // header("refresh:1; url=family_login_into_html.php");
                break;
            case "2"://廚師
                window.location.href = "./../chef_portfolio/index.php";
                break;
            default://出事了阿伯
                alertMsg("出事了阿伯" + msg, "red");
                break;

        }
    });
    return false;
}

function alertMessage(msg, color) {
    document.getElementById('alertMessage').innerHTML = "<span style='color:" + color + "'>" + msg + "</span>";
}

function signup() {

    var acc = document.getElementsByName('useracc')[0].value;
    var psd = document.getElementsByName('userpsd')[0].value;
    var chk = document.getElementsByName('chkpsd')[0].value;
    
    $.ajax({
        type: "POST",
        url: "./../signup/family_signup_check.php",
        data: {
            acc: acc,
            psd: psd,
            chk: chk
        },
        cache: false
    }).done(function(msg) {
        // console.log(msg);
        switch (msg) {

            case '0': //sign up fail
                alert("註冊失敗");
                alertMessage('');
                break;

            case '1': //sign up complete
                alert("註冊成功!", "red");
                alertMessage('');
                window.location.reload("./login.php");
                break;

            case '2': //account is exised
                alertMessage("該帳號已有人使用, 請使用其他帳號!", "red");
                break;

            default:
                alert("ERROR 404", "red");
                alertMessage('');
                alert(msg);
                break;
        }
    });
    return false;
}
</script>

</html>