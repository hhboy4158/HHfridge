<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>食譜資訊 - cooker</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <!-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"> -->
    <!-- sweetlaert CSS File -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- sweetlaert CSS File -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>

    <!-- =======================================================
  * Template Name: iPortfolio - v1.5.0
  * Template URL: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Mobile nav toggle button ======= -->
    <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

    <!-- ======= Header ======= -->

    <!-- End Header -->


    <!-- ======= get recipe data ======= -->
    <?php 
    session_start();
    require_once './../../connections/Account.php';
    include_once('./parts/cust_rerspective/chefheader.php');
    $name = $_GET['name'];
    $family = "'" . $_GET['name'] . "'";
    $sql = "SELECT * FROM chef_recipe WHERE cr_ID = $name";
    $result = mysqli_query($conn, $sql) or die("無法開啟資料庫連結" + $sql);
    $row = mysqli_fetch_array($result);
    ?>
    <!-- !======= get recipe data ======= -->

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2><?php echo  @$row_user['ChefFirstName'] . @$row_user['ChefName']?></h2>
                    <ol>
                        <li><a href="index.php">Home</a></li>
                        <li><?php ?></li>
                    </ol>
                </div>

            </div>
        </section><!-- End Breadcrumbs -->

        <!-- ======= Portfolio Details Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <div class="portfolio-description">
                    <div class="row justify-content-center align-items-center" data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="700">
                        <div class="col-4"></div>
                        <div class="col-4 text-center">
                            <p style="letter-spacing:5px; font-size:48px; text-align:center"><i><?php echo $row['cr_name'];?></i></p>
                        </div>
                        <div class="col-4 text-right">
                        </div>
                    </div>

                    <?php echo '<h3 style="letter-spacing:5px;"></h3>';?>
                    <!-- <h3>Project information</h3> -->
                </div>
                <div class="portfolio-details-container row">
                    <div class="col-6 text-left"  data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="700">
                        <?php 
                            if($row['cr_img'] == ""){
                                echo '<img src="./../../images/chef_recipe/item.png" class="img-fluid img-thumbnail" alt=""style=" max-width: 538px;">';
                            }else{
                                echo '<img src="./../../images/chef_recipe/'.$row['cr_img'].'" class="img-fluid img-thumbnail text-center" alt=""style=" max-width: 538px;">';
                            }
                        ?>
                        <!-- <div class="portfolio-info" style="width:340px;">
                            <ul>
                                <li><p>價格: <?php //echo $row['price'];?></p></li>
                                <li><button type="button" class="btn btn-secondary" data-toggle="modal"
                                        data-target="#editing">編輯</button></li>
                            </ul>


                        </div> -->
                    </div>
                    <div class="col-6"  data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="700">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">食材</th>
                                    <th scope="col">數量</th>
                                    <th scope="col">單位</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- <th scope="row">#</th> -->
                                <?php
                                        $count = 1;
                                        $sql = 'SELECT * FROM `chef_recipe_ingredient` WHERE `cri_recipe` = '.$_GET['name'].'';
                                        $result = mysqli_query($conn, $sql) or die($sql);
                                        while($row_ing = mysqli_fetch_array($result)){
                                            //echo '<li><strong>'.$row_ing['cri_ingName']. '</strong> ' . $row_ing['cri_ingNum'] . $row_ing['cri_ingUnit'] .  '</li>';  
                                            echo '
                                            <tr>
                                                <th scope="row">' . $count . '</th>
                                                <td>' . $row_ing['cri_ingName'] . '</td>
                                                <td>' . $row_ing['cri_ingNum']  . '</td>
                                                <td>' . $row_ing['cri_ingUnit'] . '</td>
                                            </tr>
                                                ';
                                            $count++;
                                        }
                                        ?>

                            </tbody>
                        </table>
                    </div>

                </div>
                <hr>
                <div class="col-4 text-left"  data-aos-anchor-placement="top-bottom"  data-aos="fade-up" data-aos-duration="700">
                    <p><?php echo $row['cr_about'];?></p>
                </div>

            </div>
        </section><!-- End Portfolio Details Section -->

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
    <!-- <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script>
    AOS.init();

    </script>

</body>

</html>