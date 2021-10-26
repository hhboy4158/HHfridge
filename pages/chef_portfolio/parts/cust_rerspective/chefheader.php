  <?php 
        $account = "'" . $_GET['name'] . "'";
        $chef = isset($_GET['chef']) ? "'" . $_GET['chef'] . "'" : $account ;
        $a = $account;
        //取得使用者資料
        $sql = "SELECT * FROM `chef_account`  WHERE ID = $chef";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row_user = mysqli_fetch_array($result);
        //取得使用者狀態
        if(isset($_SESSION['family_username'])){
            $sql = "SELECT * FROM `family_account` WHERE Username = '" . $_SESSION['family_username'] . "'";
            $result = mysqli_query($conn, $sql) or die($sql);
            $row = mysqli_fetch_array($result);
        }
        
        echo '
              <header id="header">
              <div class="d-flex flex-column">

                  <div class="profile">';

              echo  '<img src="./../../images/users/' . @$row_user['img'] . '" alt="" class="img-fluid rounded-circle">';
            echo          '<h1 class="text-light"><a href="./index.php">' . @$row_user['ChefFirstName'] . ' ' . @$row_user['ChefName'] . '</a></h1>
                      <div class="social-links mt-3 text-center">
                          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                      </div>
                  </div>';
        
        
        
        // switch($row_approve['approve']){
        //   case 0:
            
        //     break;
        //   case 1:
            echo      '<nav class="nav-menu">
                      <ul>
                          <li><a href="./chef_detail.php?name=' . $_GET['name'] .'"><i class="bx bx-home"></i> <span>回廚師主頁</span></a></li>
                          <li><a href="./../../allchef.php?item=8"><i class="bx bx-exit" ></i>回首頁</a></li>

                      </ul>
                  </nav>';
        //     break;
        // }
        
        
        echo      '<!-- .nav-menu -->
                  <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

              </div>
            </header>
  ';?>