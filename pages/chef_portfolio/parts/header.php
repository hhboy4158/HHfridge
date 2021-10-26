  <?php 
        $session_account = "'" . $_SESSION['family_username'] . "'";

        //取得使用者資料
        $sql = "SELECT * FROM `chef_account`  WHERE account = $session_account";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row_user = mysqli_fetch_array($result);

        //取得使用者狀態
        $sql = "SELECT approve FROM `chef_account` WHERE account = " . "'" . $_SESSION['family_username'] . "'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $row_approve = mysqli_fetch_array($result);
        echo '
              <header id="header">
              <div class="d-flex flex-column">

                  <div class="profile">';
        switch($row_approve['approve']){
          case 0:
            echo  '<img src="./assets/img/user.png" alt="" class="img-fluid rounded-circle">';
            echo          '<h1 class="text-light"><a href="./index.php">' . $row_user['ChefFirstName'] . ' ' . $row_user['ChefName'] . '</a></h1>
                      <div class="social-links mt-3 text-center">
                          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                      </div>
                  </div>';
            break;

          case 1:
            if($row_user['img'] == "0"){
              echo  '<img src="./../../images/users/user.png" alt="" class="img-fluid rounded-circle">';
            }else{
              echo  '<img src="./../../images/users/'.$row_user['img'].'" alt="" class="img-fluid rounded-circle">';
            }
            
            echo          '<h1 class="text-light"><a href="./index.php">' . $row_user['ChefFirstName'] . ' ' . $row_user['ChefName'] . '</a></h1>
                      <div class="social-links mt-3 text-center">
                          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                      </div>
                  </div>';
            break;
        }
        
        
        switch($row_approve['approve']){
          case 0:
            
            break;
          case 1:
            echo      '<nav class="nav-menu">
                      <ul>
                          <li><a href="./index.php#hero"><i class="bx bx-home"></i> <span>主頁</span></a></li>
                          <li><a href="./index.php#about"><i class="bx bx-user"></i> <span>關於</span></a></li>
                          <li><a href="./index.php#portfolio"><i class="bx bx-food-menu"></i></i> 菜單</a></li>
                          <!-- <li><a href="#resume"><i class="bx bx-file-blank"></i> <span>Resume</span></a></li>
                          <li><a href="#portfolio"><i class="bx bx-book-content"></i> Portfolio</a></li>
                          <li><a href="#services"><i class="bx bx-server"></i> Services</a></li>
                          <li><a href="#contact"><i class="bx bx-envelope"></i> Contact</a></li> -->
                          <li><a href="./index.php#setting"><i class="bx bx-cog"></i></i>設定</a></li>
                          <li><a href="./../logout/logout.php"><i class="bx bx-exit" ></i>登出</a></li>

                      </ul>
                  </nav>';
            break;
        }
        
        
        echo      '<!-- .nav-menu -->
                  <button type="button" class="mobile-nav-toggle d-xl-none"><i class="icofont-navigation-menu"></i></button>

              </div>
            </header>
  ';?>