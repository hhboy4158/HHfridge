<?php
  // session_start();
  include("./top.php");
  $family_username = $_SESSION['family_username'];
  require_once('./connections/Account.php');
   ?>

<div class="hero-wrap hero-bread" style="background-image: url('images/bg/member.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="./index.php">Home</a></span> <span>Account
                        manager</span></p>
                <h1 class="mb-0 bread">子帳戶管理</h1>
            </div>
        </div>
    </div>
</div>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section ftco-animate text-center">
                <span class="subheading">User Manage</span>
                <h2 class="mb-4">子帳戶管理</h2>
                <?php include("./family_Inquire.php"); ?>
            </div>
        </div>
    </div>
</section>


<!-- Modal add child 新增子帳戶表單-->
<div class="modal fade" id="addchild" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">新增子帳戶</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="./pages/user/personal_signup_work.php">
                <!-- onsubmit="return submitIng(); return false;" -->
                <div class="modal-body">
                    <!-- 新增 表單 -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">暱稱</span>
                        </div>
                        <input name="name" type="text" class="form-control" aria-label="Default"
                            aria-describedby="inputGroup-sizing-default" value="">
                    </div>
                    <br>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">帳號</span>
                        </div>
                        <input name="username" type="text" class="form-control" aria-label="Default"
                            aria-describedby="inputGroup-sizing-default" value="">
                    </div>
                    &nbsp;
                    <p><label for="Product_1"><input id="Product_1" type="checkbox" value="1" style="zoom:180%"
                                name="Product_1"> 心臟疾病<br></label></p>
                    <p><label for="Product_2"><input id="Product_2" type="checkbox" value="2" style="zoom:180%"
                                name="Product_2"> 肺炎<br></label></p>
                    <p><label for="Product_3"><input id="Product_3" type="checkbox" value="3" style="zoom:180%"
                                name="Product_3"> 糖尿病<br></label></p>
                    <p><label for="Product_4"><input id="Product_4" type="checkbox" value="4" style="zoom:180%"
                                name="Product_4"> 慢性下呼吸道疾病<br></label></p>
                    <p><label for="Product_5"><input id="Product_5" type="checkbox" value="5" style="zoom:180%"
                                name="Product_5"> 高血壓性疾病<br></label></p>
                    <p><label for="Product_6"><input id="Product_6" type="checkbox" value="6" style="zoom:180%"
                                name="Product_6"> 腎臟病<br></label></p>
                    <p><label for="Product_7"><input id="Product_7" type="checkbox" value="7" style="zoom:180%"
                                name="Product_7"> 變慢性肝病<br></label></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    <input type="submit" name="submit" class="btn btn-primary" value="確認">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Modal -->

<!-- Modal set child 修改子帳戶表單-->
<div class="modal fade" id="setchild" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">修改子帳戶</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="POST" onsubmit="return submitset(); return false;">
                <!-- onsubmit="return submitIng(); return false;" -->
                <div class="modal-body">
                    <!-- 修改 表單 -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <!-- <span class="input-group-text" id="inputGroup-sizing-default">暱稱</span> -->
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">選擇名稱</label>
                            </div>
                            <select class="custom-select" id="inputGroupSelect01" onchange="GetSelectValue();">
                                <?php
                      $sql = "SELECT * FROM `personal_account` WHERE Owner = (SELECT ID FROM `family_account` WHERE `Username` = '$family_username')";
                      $result = mysqli_query($conn, $sql);
                      $i = 0;
                      while($row = mysqli_fetch_row($result)){
                        if($i == 0){
                          echo '
                          <option id="selval" value='.$row[0].' selected>'.$row[2].'</option>
                          ';
                          $i++;
                        }else{
                          echo'<option id="selval" value='.$row[0].'>'.$row[2].'</option>';          
                        }//end else
                      }//end while
                    ?>
                            </select>
                        </div>
                        <!-- <input name="name" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value=""> -->
                    </div>
                    <br>
                    <!-- <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default">新名稱</span>
            </div>
            <input id="newname" name="username" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="">
          </div> -->
                    <!-- &nbsp; -->

                    <!-- <p><label for="Product_1"><input id="Product_1" type="checkbox" value="1" style="zoom:180%" name="Product_1"> 心臟疾病<br></label></p> -->
                    <div id="getmember" name="product">
                        <?php
            $sql = "SELECT * FROM `personal_account`WHERE Owner = (SELECT ID FROM family_account WHERE Username = 'root') LIMIT 1";
            $result = mysqli_query($conn, $sql);
            $sick = array("心臟疾病","肺炎","糖尿病","慢性下呼吸道疾病","高血壓性疾病","腎臟病","變慢性肝病",);
            while($row = mysqli_fetch_row($result)){
              for($i = 4; $i <= 10; $i++){
                $j = $i - 3;
                if($row[$i] == 1){
                  echo'<p><label for="setProduct_'.$j.'"><input id="setProduct_'.$j.'" type="checkbox" value="'.$sick[$i -4].'" style="zoom:180%" name="Product_x[]" checked> '.$sick[$i -4].'<br></label></p>';
                }else{
                  echo'<p><label for="setProduct_'.$j.'"><input id="setProduct_'.$j.'" type="checkbox" value="'.$sick[$i -4].'" style="zoom:180%" name="Product_x[]"> '.$sick[$i -4].'<br></label></p>';
                }
              }
              
            }
          ?>
                    </div><!-- getmember -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    <input type="submit" name="submit" class="btn btn-primary" value="確認">
                </div>
            </form>
        </div>
    </div>
</div>


<?php include("./footer.php"); ?>



</body>
<script type="text/javascript">
function GetSelectValue() {
    var selectObj = document.getElementById('inputGroupSelect01').value;
    //alert(selectObj);
    // console.log(selectObj);
    $.ajax({
        type: "post",
        url: "./pages/user/ShowMemberSick.php",
        data: {
            selectObj: selectObj,
        },
        cache: false
    }).done(function(msg) {
        // console.log(msg);
        document.getElementById('getmember').innerHTML = msg;
    })
}

function submitset() {

    var p_name = document.getElementById('inputGroupSelect01').value;
    var chkmember = document.getElementById('getmember'); //circle the range from the whole document
    var menber_inside = chkmember.getElementsByTagName('input'); //get tegname from the range
    var all_sick = ["心臟疾病", "肺炎", "糖尿病", "慢性下呼吸道疾病", "高血壓性疾病", "腎臟病", "變慢性肝病"];
    var Trebuchet = [];
    for (var i = 0; i <= menber_inside.length; i++) {
        if (menber_inside[i].checked == true) {
            var orb = document.getElementsByName('Product_x[]')[i].value;
            //alert("orb: " + orb);
            if (orb == all_sick[i]) {
                Trebuchet.push(all_sick[i]);
                //alert("持有疾病: " + Trebuchet);
            } //inside if end
        } //outside if end
        if (i == menber_inside.length - 1) {
            yes = confirm("選擇的疾病: " + Trebuchet + '， 確定要更新嗎?' + p_name);
            if (yes == 1) {
                $.ajax({
                    type: "post",
                    url: "./pages/user/setchild.php",
                    data: {
                        p_name: p_name,
                        Trebuchet: Trebuchet,
                    },
                    cache: false
                }).done(function(msg) {
                    if (msg == 1) {
                        alert("修改成功");
                    } else {
                        alert("出事了阿伯" + msg);
                    }

                    // console.log(msg);
                    //document.getElementById('getmember').innerHTML = msg;
                }) //end ajax
            } //end confirm
        } //end if i == menber_inside.length-1

    } // for end

    //return false;

} //end function

function UserCheckUpdata() {
    $.ajax({
        type: "post",
        url: "./pages/user/UserCheckUpdata.php",
        cache: false
    }).done(function(msg) {
        alert("成功儲存" + msg);
        location.reload("./user_manage.php#family_Inquire");
    })
}

function removeuser(user) {
    yes = confirm('確定要刪除嗎?');
    if (yes == 1) {
        $.ajax({
            type: "post",
            url: "./pages/user/delchild.php",
            data: {
                child: user,
            },
            cache: false
        }).done(function(msg) {
            // 如果沒有儲存設定
            alert("刪除成功");
            location.reload("./user_manage.php#family_Inquire");
        }) //done
    } //if
} //func

// function changepsd() {
//   yes = confirm('確定要變更密碼嗎?');
//   if (yes == 1) {
//     var ogpsd = document.getElementById("ogpsd").value;
//     var newpsd = document.getElementById("newpsd").value;
//     var cfmpsd = document.getElementById("cfmpsd").value;
//     // alert (ogpsd + "," + newpsd + "," + cfmpsd);
//     $.ajax({
//       type: "post",
//       url: "./pages/user/changepsd.php",
//       data: {
//         ogpsd: ogpsd,
//         newpsd: newpsd,
//         cfmpsd: cfmpsd,
//       },
//       cache: false
//     }).done(function(msg) {
//       // 如果沒有儲存設定
//       switch (msg) {
//         case "0":
//           alert("輸入的原密碼不正確!")
//           break;

//         case "1":
//           alert("變更成功!");
//           break;

//         default:
//           alert("ERROR 404:" + msg);

//       }
//       location.reload("./user_manage.php#family_Inquire");
//     }) //done
//   }
//   return false;
// }
</script>

</html>