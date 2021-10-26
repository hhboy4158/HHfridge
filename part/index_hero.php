<section id="home-section" class="hero">
    <div id="" class="home-slider owl-carousel" >
        <div class="slider-item" style="background-image:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(images/bg/bg_1.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                    <div class="col-md-12 ftco-animate text-center">
                        <h1 class="mb0-2">基於人工智慧技術之</h1>
                        <h1 class="mb0-2">食譜推薦平台</h1>
                        <h2 class="subheading mb-4">Build a platform for healthy recipes and chef recommendation based on artificial intelligence technology.</h2>
                        <!-- <p><a href="#" class="btn btn-primary">更多資訊</a></p> -->
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once './connections/Account.php';
        $sql = "SELECT * FROM `type` WHERE`name` like '%料理' ORDER BY RAND() LIMIT 3";
        $result = mysqli_query($conn, $sql) or die($sql);
        while($row = mysqli_fetch_array($result)){
            echo '
            <div class="slider-item" style="background-image:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(images/foodtype/' . $row['tag'] . '.png);">
                <div class="overlay"></div>
                <div class="container">
                    <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                        <div class="col-sm-12 ftco-animate text-center">
                            <h1 class="mb-2">' . $row['name'] . '</h1>
                            <h2 class="subheading mb-4">Vegetables</h2>
                            <p><a href="allrec.php?Fclass=' . $row['name'] . '&item=2" class="btn btn-primary">點我看更多</a></p>
                        </div>

                </div>
                </div>
            </div>
            ';
        }

        ?>
<!-- 
        <div class="slider-item" style="background-image:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(images/product-1.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                    <div class="col-sm-12 ftco-animate text-center">
                        <h1 class="mb-2">蔬食</h1>
                        <h2 class="subheading mb-4">Vegetables</h2>
                        <p><a href="allrec.php?Fclass=蔬食&item=2" class="btn btn-primary">點我看更多</a></p>
                    </div>

                </div>
            </div>
        </div>

        <div class="slider-item" style="background-image:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(images/soup.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                    <div class="col-sm-12 ftco-animate text-center">
                        <h1 class="mb-2">湯品</h1>
                        <h2 class="subheading mb-4">Soups</h2>
                        <p><a href="allrec.php?Fclass=湯品&item=2" class="btn btn-primary">點我看更多</a></p>
                    </div>

                </div>
            </div>
        </div>

        <div class="slider-item" style="background-image:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(images/dessert.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                    <div class="col-sm-12 ftco-animate text-center">
                        <h1 class="mb-2">點心</h1>
                        <h2 class="subheading mb-4">dessert</h2>
                        <p><a href="allrec.php?Fclass=點心&item=2" class="btn btn-primary">點我看更多</a></p>
                    </div>

                </div>
            </div>
        </div> -->
    </div>
</section>