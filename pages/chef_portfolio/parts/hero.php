<?php
 if($row_user['img'] == "0"){
  echo '<section id="hero" class="d-flex flex-column justify-content-center align-items-center" style="background-image:url(./../../images/users/user.png)">';
 }else{
  echo '<section id="hero" class="d-flex flex-column justify-content-center align-items-center" style="background-image:url(./../../images/users/' . $row_user['img'] . ')">';
 }
?>
  <div class="hero-container" data-aos="fade-in">
    <h1><?php echo $row_user['ChefFirstName'] . ' ' . $row_user['ChefName'];?></h1>
    <p>
      <?php 
        require_once './../../connections/Account.php';
        $a = "'" . @$_SESSION['family_username'] . "'";
        $skill_array = array();
        $sql = "SELECT chef_type FROM chef_skill WHERE chef_ID = (SELECT ID FROM chef_account WHERE account = $a)";
        $result = mysqli_query($conn, $sql) or die($sql);
        while($row = mysqli_fetch_array($result)){
          $sql2 = "SELECT name FROM `type` WHERE fid = $row[0]";
          $result2 = mysqli_query($conn,$sql2) or die($sql2);
          $row2 = mysqli_fetch_array($result2);
          array_push($skill_array, $row2[0]);
        }

        $skill_string = "";
        for($i = 0; $i < count($skill_array); $i++){
          $skill_string .= $skill_array[$i];
          if($i != count($skill_array) - 1){
            $skill_string .= ", ";
          }
          
        }
        
        echo '<span class="typed" data-typed-items="' . $skill_string . '"></span>';
      ?>
    </p>
  </div>
</section>

