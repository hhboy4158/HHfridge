<?php
    $phone = str_split($row_user['phone']);
    $phone_split = '';
    for($i = 0; $i <= count($phone); $i++){
      if($i % 3 == 0){
        if($i == 9){
          break;
        }else if($i == 0){
          $phone_split .= $phone[$i];
        }else{
          $phone_split .= "-";
          $phone_split .= $phone[$i];
        }
      }else{
        $phone_split .= $phone[$i];
      }
    } 
    $sql = "SELECT AVG(`score`) FROM `chef_score` WHERE chef_ID = '" . $row_user['ID'] . "'";
    $result = mysqli_query($conn, $sql) or die($sql);
    $row = mysqli_fetch_row($result);
    $rat =  round($row[0], 2);
    
?>

<section id="about" class="about">
    <div class="container">
        <div class="section-title">
            <div class="row">
                <div class="col-6">
                    <?php echo '<h2>'.$row_user['ChefFirstName']. $row_user['ChefName'] . '</h2>';?>
                </div>
                <div class="col-6">
                    <form name="RateForm">
                        <div class="col-6 rate" id="ChefRate">
                            <input type="radio" id="star5" name="rate" value="5" />
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="rate" value="4" />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="rate" value="2" />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="rate" value="1" />
                            <label for="star1" title="text">1 star</label>
                            <p>(<?php echo $rat;?>)</p>
                        </div>
                    </form>
                </div>

            </div>
            <?php
            //echo '<h2>'.$row_user['ChefFirstName']. $row_user['ChefName'] . '</h2>';
            echo '<p>' . $row_user['about'] . '</p>';
            ?>
        </div>

        <div class="row">
            <div class="col-lg-4" data-aos="fade-right">
                <?php
                if($row_user['img'] == "0"){
                  echo '<img src="./../../images/users/user.png" class="img-fluid" alt="">';
                }else{
                  echo '<img src="./../../images/users/' . $row_user['img'] . '" class="img-fluid" alt="">';
                }
          ?>

            </div>
            <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
                <h3>關於<?php echo $row_user['ChefName']?></h3>
                <p class="font-italic">
                    <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore
                    magna aliqua. -->
                </p>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                        </div>
                        <ul>
                            <li><i class="icofont-rounded-right"></i> <strong>姓名
                                    :</strong><?php echo '  ' . $row_user['ChefFirstName'] . $row_user['ChefName'];?>
                            </li>
                            <!-- <li><i class="icofont-rounded-right"></i> <strong>Birthday:</strong> 1 May 1995</li> -->
                            <li><i class="icofont-rounded-right"></i> <strong>註冊日期 :
                                </strong><?php echo $row_user['signup_date'];?></li>
                            <li><i class="icofont-rounded-right"></i> <strong>連絡電話 : </strong> +886
                                <?php echo $phone_split;?></li>
                            <li><i class="icofont-rounded-right"></i> <strong>住址 :
                                </strong><?php echo $row_user['address']?></li>
                            <li><i class="icofont-rounded-right"></i> <strong>專長 : </strong><?php echo $skill_string?>
                            </li>
                            <li><i class="icofont-rounded-right"></i> <strong>評論分數 : </strong>
                            <?php echo $rat;?>
                            </li>


                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <!-- <ul>
                            <li><i class="icofont-rounded-right"></i> <strong>Age:</strong> 30</li>
                            <li><i class="icofont-rounded-right"></i> <strong>Degree:</strong> Master</li>
                            <li><i class="icofont-rounded-right"></i> <strong>PhEmailone:</strong> email@example.com
                            </li>
                            <li><i class="icofont-rounded-right"></i> <strong>Freelance:</strong> Available</li>
                        </ul> -->
                    </div>
                </div>
                <!-- <p>
              Officiis eligendi itaque labore et dolorum mollitia officiis optio vero. Quisquam sunt adipisci omnis et ut. Nulla accusantium dolor incidunt officia tempore. Et eius omnis.
              Cupiditate ut dicta maxime officiis quidem quia. Sed et consectetur qui quia repellendus itaque neque. Aliquid amet quidem ut quaerat cupiditate. Ab et eum qui repellendus omnis culpa magni laudantium dolores.
            </p> -->
            </div>
        </div>

    </div>
</section>
<script>
var rad = document.RateForm.rate;
var prev = null;
for (var i = 0; i < rad.length; i++) {
    rad[i].addEventListener('change', function() {
        (prev) ? console.log(prev.value): null;
        if (this !== prev) {
            prev = this;
        }
        rate(this.value, <?php echo $_GET['name']?>);
        console.log(this.value);
    });
}

function rate(value, chef) {
    $.ajax({
        type: "post",
        url: "./parts/proccessing/ChefRating.php",
        data: {
            formData: value,
            chef: chef,
        },
        cache: false
    }).done(function(msg) {
      if(msg == "0"){
        console.log("更新成功");
      }else if(msg == "1"){
        console.log("新增成功");
      }else{
        console.log(msg);
      }
    })
    return false;
}
</script>