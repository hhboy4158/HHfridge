<!DOCTYPE html>
<html lang="en">
<script>

</script>
<head>
    <?php session_start();
        include_once('./parts/head.php');
        require_once './../../connections/Account.php';
        require_once './parts/CheckApprove.php';
        if(!isset($user_approve)){
            echo "<script>";
            echo "window.location.href='./../logout/logout.php';";
            echo "</script>";
        }
    ?>
</head>

<body>

    <!-- ======= Mobile nav toggle button ======= -->
    <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

    <!-- ======= Header ======= -->
    <?php include_once('./parts/header.php');?>
    <!-- .nav-menu -->
    <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

    </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <?php include_once('./parts/hero.php');?>
    <!-- End Hero -->

    <main id="main">

        <!-- ======= About Section ======= -->
        <?php include_once('./parts/about.php');?>
        <!-- End About Section -->

        <!-- ======= Facts Section ======= -->
        <?php //include_once('./parts/facts.php');?>
        <!-- End Facts Section -->

        <!-- ======= order Section ======= -->
        <?php include_once('./parts/order.php');?>
        <!-- End order Section -->

        <!-- ======= Skills Section ======= -->
        <?php //include_once('./parts/skills.php');?>
        <!-- End Skills Section -->

        <!-- ======= Resume Section ======= -->
        <?php //include_once('./parts/resume.php');?>
        <!-- End Resume Section -->

        <!-- ======= Portfolio Section ======= -->
        <?php include_once('./parts/portfolio.php');?>
        <!-- End Portfolio Section -->

        <!-- ======= Services Section ======= -->
        <?php //include_once('./parts/services.php');?>
        <!-- End Services Section -->

        <!-- ======= Testimonials Section ======= -->
        <?php //include_once('./parts/testimonials.php');?>
        <!-- End Testimonials Section -->

        <!-- ======= Contact Section ======= -->
        <?php //include_once('./parts/contact.php');?>
        <!-- End Contact Section -->
        <hr>
        <!-- ======= About Section ======= -->
        <?php include_once('./parts/setting/setting.php');?>
        <!-- End About Section -->


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
    <!-- CSS only -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counterup/counterup.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/venobox/venobox.min.js"></script>
    <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="assets/vendor/typed.js/typed.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <?php 
    if(isset($_SESSION['family_username'])){
        if(isset($user_approve) and $user_approve == 0){
            echo '<script>
                    alert(' . isset($_SESSION['family_username']) . ');
                    window.onload = function() {
                      swal({
                              title: "等一下!",
                              text: "請先田寫專長!",
                              icon: "info"
                          }).then(function() {
                              window.location.href = "./phase_02.php";
                          });
                      }
                          </script>';
          }else{
            echo   '<script>
                        console.log("' . $row_user['ChefFirstName'] . $row_user['ChefName'] . '，welcome back.");
                    </script>';
          }
    }else{
        echo    '<script>
                    window.location.href="./../login/login.php";
                </script>';
    }
        
    ?>

    <script>


    function ChefUpdateSetting() {
        const address = document.getElementById('inputAddress').value;
        const phone = document.getElementById('inputphone').value;
        let intro = document.getElementById('ChefIntroduction').value;
        var c_skill = $('#ChefSetting input[name=skill]').serializeArray();
        console.log(c_skill);


        //處理換行
        intro = intro.replace(/ /g, " ");
        intro = intro.replace(/<br>/g, "");
        //textarea換行轉成<br>
        intro = intro.replace(/\n/g, "<br>\n")



        $.ajax({
            type: "post",
            url: "./parts/setting/f_UpdateSetting.php",
            data: {
                address: address,
                phone: phone,
                intro: intro,
                c_skill: c_skill,
            },
            cache: false
        }).done(function(msg) {
            console.log(msg);
            swal({
                title: "更新成功!",
                text: "update success",
                type: "success"
            }).then(function() {
                window.location.reload();
            });
            // console.log(msg);
        })
        return false;
    }
    </script>

</body>

</html>