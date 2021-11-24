<?php
//   require_once './connections/Account.php';
//   @$user = $_SESSION['family_username'];
//   $sql = "SELECT * FROM `material` where account = '$user'";
//   $result = mysqli_query($conn, $sql) or die($sql);
//   while($row = mysqli_fetch_row($result)){
//       echo $row[0];
//     for($i = 0; $i < count($row[0]); $i++){
//       if ($row[3] == 0){

//         $sql = "DELETE FROM `material` WHERE `material`.`ID` = $row[0] and $row[3] = 0";
//         $result = mysqli_query($conn, $sql);
//       }
//     }
    
//   }
?>
<footer class="ftco-footer ftco-section">
    <div class="container">
        <div class="row">
            <div class="mouse">
                <a href="#body" class="mouse-icon">
                    <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">

                <p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

                    Copyright &copy;<script>
                    document.write(new Date().getFullYear());
                    </script> All rights reserved | This website is made with <b>LIVER</b> by <a
                        href="https://github.com/hhboy4158"
                        target="_blank">hhboy4158..</a>

                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0.-->
                </p>
            </div>
        </div>
    </div>
</footer>



<!-- loader -->
<div id="ftco-loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
            stroke="#F96D00" />
    </svg>
</div>


<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/scrollax.min.js"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script> -->
<!-- <script src="js/google-map.js"></script> -->
<script src="js/main.js"></script>

<script rel="stylesheet" href="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>


<script>
function totalFood(functionName, fid) {

    $.ajax({
        type: "post",
        url: "./get_container_value/get_food_data.php",
        data: {
            functionName: functionName,
            fid,
        },
        cache: false
    }).done(function(msg) {

        location.href = `f_popular.php?fid=${fid}`;
        // console.log(msg);
        // document.getElementById("recipe").innerHTML = msg;
    })
}

navlist("loadnav", <?php echo @$_GET["item"] ?>);

function navlist(tbody, mid) {

    $.ajax({
        type: "POST",
        url: "./get_container_value/get_memu.php",
        data: {
            mid: mid,
        },
        cache: false
    }).done(function(msg) {

        // console.log(msg);
        // alert(functionName);
        document.getElementsByName(tbody)[0].innerHTML = msg;
    });
}
check_ischef();

function check_ischef() {
    $.ajax({
        type: "POST",
        url: "./get_container_value/get_isChef.php",
        data: {
            user_id: 1, //無意義，lol
        },
        cache: false
    }).done(function(msg) {
        // console.log(msg);
        switch (msg) {
            case "0": //尚未認證使用者
                window.location.href = './pages/chef_portfolio/phase_02.php';
                break;
            case "1": //chef
                window.location.href = './pages/chef_portfolio/index.php';
                break;
            case "100": //一般使用者
                console.log("cust");
                break;
            default:
                alert("出事了阿伯:" + msg);
                console.log("出事了阿伯:" + msg);
                break;


        }
    });
}
</script>

</body>


</html>