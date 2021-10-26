<!DOCTYPE html>
<html lang="en">

<head>

    <?php 
        
        session_start();
        require_once './../../connections/Account.php';
        $sql = "SELECT * FROM chef_account where account = '" . $_SESSION['family_username'] . "'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $r = mysqli_num_rows($result);
        if($r == 0){
            echo '<script>
                    window.location.href="./../login/login.php";
                  </script>';   
        }

        if(!isset($_SESSION['family_username'])){
            echo '
            <script>
                console.log("' . $_SESSION['family_username'] . '");
                window.location.href="./../login/login.php";
            </script>';
        }
        include_once('./parts/head.php');
        
    ?>
</head>

<body>

    <!-- ======= Mobile nav toggle button ======= -->
    <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>
    <!-- ======= Header 左半邊 ======= -->
    <?php include_once('./parts/header.php');?>
    <!-- ======= End Header ======= -->


    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <?php
                require_once './parts/checkApprove.php';
                if($user_approve == "1"){
                    header("./index.php");
                    echo '<script>window.location.href="./index.php";</script>';
                }else{
                    header("./../login/login.php");
                }
                echo '<div class="d-flex justify-content-between align-items-center">
                        <h2> 您好，' . $row_user['ChefName'] . '! 請先完成資料</h2>
                        <ol>
                            <li><a href="index.html">Home</a></li>
                            <li>Inner Page</li>
                        </ol>
                    </div>';
            ?>


            </div>
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">
            <div class="container">
                <form id="chef_skill" onsubmit=" return update_skill() ;return false;">

                    <div class="form-group">
                        <div class="form-check">
                            <div class="row">
                                <h5>選擇專長</h5>
                                <div id="skill_id">
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="it" name="skill" value="1">
                                        <label class="form-check-label" for="it">義式料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="us" name="skill" value="2">
                                        <label class="form-check-label" for="us">美式料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="th" name="skill" value="3">
                                        <label class="form-check-label" for="th">泰式料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="jp" name="skill" value="4">
                                        <label class="form-check-label" for="jp">日式料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="tw" name="skill" value="5">
                                        <label class="form-check-label" for="tw">台式料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="ko" name="skill" value="6">
                                        <label class="form-check-label" for="ko">韓式料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="hk" name="skill" value="7">
                                        <label class="form-check-label" for="hk">港式料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="sc" name="skill" value="8">
                                        <label class="form-check-label" for="sc">四川料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="ch" name="skill" value="9">
                                        <label class="form-check-label" for="ch">中式料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="fr" name="skill" value="10">
                                        <label class="form-check-label" for="fr">法式料理</label>
                                    </div>
                                    <div class="form-check form-check-inline col-md-2">
                                        <input class="form-check-input" type="checkbox" id="en" name="skill" value="11">
                                        <label class="form-check-label" for="en">英式料理</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="row justify-content-md-center">
                            <div class="col-md-6 ">
                                <a href="./../logout/logout.php">
                                    <input type="butten" class="btn btn-outline-dark btn-lg btn-block form-control"
                                        value="登出">
                                </a>
                            </div>
                            <br><br><br>
                            <div class="col-md-6 ">
                                <button type="submit"
                                    class="btn btn-outline-success btn-lg btn-block form-control">送出</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>iPortfolio</span></strong>
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </footer><!-- End  Footer -->

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counterup/counterup.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/venobox/venobox.min.js"></script>
    <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="assets/vendor/typed.js/typed.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script language="Javascript">

    function update_skill() {
        var skill = $('#chef_skill').serializeArray();
        console.log(skill);
        $.ajax({
            type: "post",
            url: "./phase_02_submit.php",
            data: {
                skill: skill,
            },
            cache: false
        }).done(function(msg) {
            // document.getElementById("check_body").innerHTML = msg;
            if(msg == "1"){
                swal("新增成功");
            }
            window.location.href= './index.php';
            
        })
       
        return false;
        
    }

    
    </script>

</body>

</html>