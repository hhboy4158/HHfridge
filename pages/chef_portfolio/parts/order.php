<style>
    .modal{
        z-index: 10000 !important;
    }
    .modal-backdrop{
        z-index: 9999 !important;
    }
</style>
<section id="facts" class="facts">
    <div class="container">

        <div class="section-title">
            <h2>訂單</h2>
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th scope="col">訂單編號</th>
                        <th scope="col">客戶</th>
                        <!-- <th scope="col">菜品</th> -->
                        <!-- <th scope="col">數量</th> -->
                        <th scope="col">總價</th>
                        <th scope="col">訂單狀態</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        $chef = $_SESSION['family_username'];
                        $sql     = "SELECT `ID` FROM `chef_account` WHERE`account` = '$chef'";
                        $result  = mysqli_query($conn, $sql) or die($sql);
                        $row     = mysqli_fetch_array($result);
                        $chef    = $row['ID'];

                        require_once './../../connections/Account.php';
                        $sql     = "SELECT * FROM `user_order` 
                                        INNER JOIN chef_account, family_account ,`chef_recipe` 
                                            WHERE `user_order`.`chef_id` = '$chef' 
                                                AND `user_order`.`chef_id` = chef_account.ID 
                                                and `user_order`.`user_id` = family_account.ID 
                                                and  `chef_recipe`.`cr_ID` = user_order.data
                                                ";//AND `user_order`.`status` = '0'
                        $sql = "SELECT `user_order_group` .*,
                                    sum( (user_order.quantity * `chef_recipe`.`price`))as price,
                                    CONCAT(`chef_account`.`ChefFirstName`, ' ', `chef_account`.`ChefName`) as `chefname`,
                                    family_account.Username
                                    FROM `user_order_group` 
                                    inner join `user_order` ,`chef_recipe`, `chef_account`, family_account
                                    WHERE `user_order_group`.`ID` = `user_order`.`order_id`
                                    AND `user_order`.`data` = `chef_recipe`.`cr_ID`
                                    AND user_order_group.chef_id = '$chef'
                                    and user_order_group.cust_id = family_account.ID
                                    AND `chef_account`.`ID` = `chef_recipe`.`cr_chef`
                                    GROUP BY `user_order_group`.`ID`
                                    ORDER BY `user_order_group`.`date` DESC";
                        $result  = mysqli_query($conn, $sql) or die($sql);
                        while($row = mysqli_fetch_array($result)){
                            switch($row['status']){
                                case "0":
                                    echo '<tr  class="text-center table-danger">';
                                break;

                                case "1":
                                    echo '<tr  class="text-center table-warning">';
                                break;

                                case "2":
                                    echo '<tr  class="text-center table-success">';
                                break;
                            }


                            
                            echo '
                            
                                <th scope="row">' . $row['ID'] . '</th>
                                <td>' . $row['Username'] . '</td>
                                <td>' . $row['price']. '</td>';
                            switch($row['status']){
                                case "0":
                                    echo '  <td>待確認訂單</td>';
                                    echo '  <td><button type="button" class="btn btn-secondary" onclick="return order_done(' . "'" .  $row['ID'] . "'" . '); return false;" title="如果您料理完畢，並且外送員領取餐點後 即可點擊「完成」鍵。">完成</button></td>';
                                    echo '  <td>
                                                <button type="button" class="btn btn-danger" 
                                                    data-toggle="modal" data-target="#largemodal"
                                                    style="padding: inherit; color:#f8c3cd !important;"
                                                    onclick="return detail_view('. "'" . $row['ID'] . "'" . '); return false;">
                                                    <i class="fas fa-info" style="color: #f8c3cd;"></i>&nbsp;view
                                                </button>
                                            </td>';
                                break;

                                case "1":
                                    echo '  <td>外送中</td>';
                                    echo '  <td><button type="button" class="btn btn-secondary" onclick="return order_delivering(' . "'" . $row['ID'] . "'" . '); return false;" title="如果外送員已送達您的餐點，即可點擊「外送完成」鍵。">外送完成</button></td>';
                                    echo '  <td>
                                                <button type="button" class="btn btn-warning" 
                                                    data-toggle="modal" data-target="#largemodal"
                                                    style="padding: inherit; color:#d9cd90 !important;"
                                                    onclick="return detail_view('. "'" . $row['ID'] . "'" . '); return false;">
                                                    <i class="fas fa-info" style="color: #d9cd90;"></i>&nbsp;view
                                                </button>
                                            </td>';
                                break;

                                case "2":
                                    echo '  <td>餐點已送達</td>';
                                    echo '  <td></td>';
                                    echo '  <td>
                                                <button type="button" class="btn btn-success" 
                                                    data-toggle="modal" data-target="#largemodal"
                                                    style="padding: inherit; color:#a8d8b9 !important;"
                                                    onclick="return detail_view('. "'" . $row['ID'] . "'" . '); return false;">
                                                    <i class="fas fa-info" style="color: #a8d8b9;"></i>&nbsp;view
                                                </button>
                                            </td>';
                                break;

                            }
                           
                            echo '
                            </tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- <div class="row no-gutters">

            <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up">
                <div class="count-box">
                    <i class="icofont-simple-smile"></i>
                    <span data-toggle="counter-up">232</span>
                    <p><strong>Happy Clients</strong> consequuntur quae</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="100">
                <div class="count-box">
                    <i class="icofont-document-folder"></i>
                    <span data-toggle="counter-up">521</span>
                    <p><strong>Projects</strong> adipisci atque cum quia aut</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="200">
                <div class="count-box">
                    <i class="icofont-live-support"></i>
                    <span data-toggle="counter-up">1,463</span>
                    <p><strong>Hours Of Support</strong> aut commodi quaerat</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="300">
                <div class="count-box">
                    <i class="icofont-users-alt-5"></i>
                    <span data-toggle="counter-up">15</span>
                    <p><strong>Hard Workers</strong> rerum asperiores dolor</p>
                </div>
            </div>

        </div> -->

     </div><!-- container -->
    <!-- Modal -->
    <div id="largemodal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="ModalExisting" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="CheckList" onsubmit="return SystemRecipeSubmit(); return false;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalCustomLabel">詳細資訊</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">訂單編號</th>
                                    <th scope="col">菜品名稱</th>
                                    <th scope="col">價格</th>
                                    <th scope="col">數量</th>
                                </tr>
                            </thead>
                            <tbody id="view_body">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
<script>
function order_done(order_id) {
    var FunctionName = "cook";
    $.ajax({
        type: "post",
        url: "./parts/proccessing/order_proccessing.php",
        data: {
            FunctionName: FunctionName,
            order_id: order_id,
        },
        cache: false
    }).done(function(msg) {
        if (msg == "1") {
            alert("更新完成");
            window.location.reload();
        } else {
            alert("更新失敗: " + msg);
        }
        console.log(msg);
    })

    return false;
}

function order_delivering(order_id) {
    var FunctionName = "delivering";
    $.ajax({
        type: "post",
        url: "./parts/proccessing/order_proccessing.php",
        data: {
            FunctionName: FunctionName,
            order_id: order_id,
        },
        cache: false
    }).done(function(msg) {
        if (msg == "1") {
            alert("更新完成");
            window.location.reload();
        } else {
            alert("更新失敗: " + msg);
        }
        console.log(msg);
    })

    return false;
}
function detail_view(order_id) {
        $.ajax({
            type: "post",
            url: "./parts/proccessing/order_proccessing.php",
            data: {
                FunctionName: "view",
                order_id: order_id
            },
            cache: false
        }).done(function(msg) {
            document.getElementById("view_body").innerHTML = msg;
        })
        return false;
    }
</script>