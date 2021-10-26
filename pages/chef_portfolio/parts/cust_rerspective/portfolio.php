<section id="portfolio" class="portfolio section-bg">
    <div class="container">

        <div class="section-title">
            <h2>菜單</h2>
        </div>

        <!-- <div class="row" data-aos="fade-up">
            <div class="col-lg-12 d-flex justify-content-center">
                <ul id="portfolio-flters">
                    <li data-filter="*" class="filter-active">All</li>
                    <li data-filter=".filter-app">App</li>
                    <li data-filter=".filter-card">Card</li>
                    <li data-filter=".filter-web">Web</li>
                </ul>
            </div>
        </div> -->
        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="100">
            <?php
            
            require_once './../../connections/Account.php';
            // session_start();
            $account ="'" . $_GET['name'] . "'";
            $sql="SELECT * FROM chef_recipe where cr_chef = $account";
            $result = mysqli_query($conn, $sql) or die($sql);
            $nums=mysqli_num_rows($result);

                while($row = mysqli_fetch_array($result)){
                    echo '
                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <p style="font-size:24px;">' . $row['cr_name'] . '</p>
                        <div class="portfolio-wrap">';
                    if($row['cr_img'] == ""){//if(圖片 = "")
                        echo     '<img src="./../../images/chef_recipe/item.png" style="height:350px; width:350px" class="img-fluid" alt="recipe">';
                        
                        echo    '<div class="portfolio-links row">
                                    <a href="./../../images/icon/item.png" data-gall="portfolioGallery" class="venobox col-6"
                                        title="'.$row['cr_name'] .'"><i class="bx bx-plus"></i></a>
                                    <a href="chef_recipe_portfolio.php?name=' . $row['cr_ID'] . '&chef=' . $_GET['name'] . '" class="col-6" title="More Details"><i class="bx bx-link"></i></a>
                                    
                        
                                </div>';
                                
                    }else{
                        echo     '<img src="./../../images/chef_recipe/' . $row['cr_img'] . '" style="height:350px; width:350px;" class="img-fluid" alt="recipe">';
                        echo    '<div class="portfolio-links row">
                                    <a href="./../../images/chef_recipe/' . $row['cr_img'] . '" data-gall="portfolioGallery" class="venobox col-6"
                                        title="'.$row['cr_name'] .'><i class="bx bx-plus"></i></a>
                                    <a href="chef_recipe_portfolio.php?name=' . $row['cr_ID'] . '&chef=' . $_GET['name'] . '" class="col-6" title="More Details"><i class="bx bx-link"></i></a>
                                </div>';
                    }

                    echo     
                        '</div>
                    </div>';
            }
            ?>

        </div>

    </div>
</section>