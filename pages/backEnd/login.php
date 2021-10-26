<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>管理員登入</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- sweetalert2 -->
    <link rel="stylesheet" href="./vendor/sweetalert/dist/sweetalert2.min.css">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6" style="height:50%">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form id="LoginAdmin" class="user"
                                        onsubmit="return loginsubmit('Login'); return false;">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="InputAccount"
                                                aria-describedby="emailHelp" placeholder="帳號..." required
                                                autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="InputPassword" placeholder="密碼..." required>
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="登入">
                                        <!-- <a href="index.html" class="btn btn-primary btn-user btn-block">
                                            登入
                                        </a> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <!-- SweetAlert -->
    <script src="./vendor/sweetalert/dist/sweetalert2.min.js"></script>

    <script>
    // getIPAddress();
    swalip();

    function loginsubmit(functionName) {
        const account = document.getElementById("InputAccount").value;
        const pwd = document.getElementById("InputPassword").value;
        // console.log(account + "， " + pwd);

        $.ajax({
            type: "post",
            url: "./pages/login/loginFunc.php",
            data: {
                functionName: functionName,
                account: account,
                pwd: pwd,
            },
            cache: false
        }).done(function(msg) {
            if (msg == "0") {
                Swal.fire({
                    icon: 'success',
                    title: '登入成功!',
                    // text: '滾出我的沼澤!',
                }).then(function() {
                    window.location.href = "./index.php";
                })
            } else {
                console.log(msg);
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: '滾出我的沼澤!',
                }).then(function() {
                    window.location.href = "./../../index.php";
                })
            }
        })
        return false;
    }


    function getIPAddress() {
        $.ajax({
            type: "post",
            url: "./pages/login/loginFunc.php",
            data: {
                functionName: "ipck",
            },
            cache: false
        }).done(function(msg) {
            // console.log(msg);
            if (msg == "1") {
                console.log("歡迎");
                Swal.fire({
                    icon: 'success',
                    title: '身分確認完畢',
                    text: '歡迎，hhboy',
                    confirmButtonText: '讚喔',
                    // footer: '<a href="https://i.imgur.com/31RLV3l.jpg" target="_blank">幹三小，為甚麼?</a>'
                })
            } else {
                // alert("滾!  " + msg);
                Swal.fire({
                    icon: 'error',
                    title: '身分確認完畢，您不是hhboy，我操你媽的',
                    text: '滾出我的沼澤!',
                    footer: '<a href="https://i.imgur.com/31RLV3l.jpg" target="_blank">幹三小，為甚麼?</a>'
                }).then(function() {
                    window.location.href = "./../../index.php";
                })
                // location.href = "../../index.php";
            }
        })

    }

    function swalip() {
        const ipAPI = '//api.ipify.org?format=json';

        Swal.queue([{
            icon: 'warning',
            title: '等一下!',
            confirmButtonText: '查，都給你查',
            text: '即將執行系統身分檢查',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(ipAPI)
                    .then(response => response.json())
                    .then(data => {
                        if (data.ip == "120.118.166.218" || data.ip == "120.118.225.7") {
                            Swal.fire({
                                icon: 'success',
                                title: '身分確認',
                                text: '歡迎，hhboy',
                                confirmButtonText: '讚喔',
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: '404',
                                text: 'hhboy NOT FOUND. ERR_CODE:滾出我的沼澤，' + data.ip,
                                footer: '<a href="https://i.imgur.com/31RLV3l.jpg">幹三小，為甚麼?</a>'
                            }).then(function() {
                                window.location.href = "./../../index.php";
                            })
                        }
                    })
            }
        }])
    }
    </script>


</body>

</html>