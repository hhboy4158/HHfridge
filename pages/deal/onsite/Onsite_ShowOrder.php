<?php
$formData = $_POST['formData'];
$IsChefRec = $_POST['IsChefRec'];
require_once('./../../../connections/Account.php');

// echo '
// <div class="container">
//     <div class="row">
//         <div class="col-md-4">
//             <img class="img-thumbnail"  src="./images/users/itc1.png" alt="Card image cap" style="width:150px;height:150px;display: block;
//             margin-left: auto;
//             margin-right: auto;">
//         </div>
//         <div class="col-md-8">
//             <div class="card" style="height:200px;">
//                 <div class="card-body">
//                     <h2><i>DeatElise</i></h2>
//                     <hr>
//                     <li>住址: 高雄市鳥松區澄清路840號</li>
//                     <li>電話: 123456789</li>
//                     <li>註冊日期: 2021-05-09</li>
//                 </div>
//             </div>
//         </div>
//     </div>
// </div>
// ';
echo '<form id="Onsite_OrderId">';
echo '
        <table class="table table-hover table-success table-striped">
            <thead>
                <tr>
                    <th scope="col">編號</th>
                    <th scope="col">菜單名稱</th>
                    <th scope="col">圖示</th>
                    <th scope="col">價格</th>
                    <th scope="col">訂購數量</th>
                    <th scope="col"><b>總計</b></th>
                </tr>
            </thead>
<tbody>';

switch($IsChefRec){
    case 1:
        $RowTotal = 0;
        $AllTotal = 0;
        for($i = 0; $i < count($formData); $i++){
            $cr_id = $formData[$i]['value'];
            $sql = "SELECT * FROM `chef_recipe` WHERE `cr_ID` = $cr_id";
            $result = mysqli_query($conn, $sql) or die($sql);
            $row = mysqli_fetch_array($result);
            $RowTotal = $formData[$i]['num'] * $row['price'];
            //echo'   <tr><th scope="row">' . $i + 1 . '</th><td>' . $row['cr_name'] . '</td><td>' . $row['price'] . '</td><td>' . $formData[$i]['num'] . '</td><td>' . $formData[$i]['num'] * $row['price'] . '</td></tr>';
            echo'   <tr>
                        <td scope="row">' . $i + 1 . '</td>
                        <td>' . $row['cr_name'] . '</td>
                        <td><img class="img rounded mx-auto d-block" src="./images/chef_recipe/' . $row['cr_img'] . '" style="width:75px;height:75px"></td>
                        <td>' . $row['price'] . '</td>
                        <input type="hidden" id="price'.$row['cr_ID'].'" value="'.$row['price'].'">
                        <td width="100px">
                            <input id="rid' . $row['cr_ID'] . '" name="rid' . $row['cr_ID'] . '" type="number" style="background-color:  #cae0cf!important;" class="form-control" value="' . $formData[$i]['num'] . '" min="1" onchange="ChangeRowTotal('.$row['cr_ID'].')">
                        </td>
                        <td id="Row_Total'.$row['cr_ID'].'">' . $RowTotal . '</td>
                        <input type="hidden" id="Row_Total_hdn'.$row['cr_ID'].'" name="Row_Total_hdn" value="' . $RowTotal . '">
                    </tr>';
            $AllTotal +=  $RowTotal;
        }
        echo '      <tr>
                        <td>總價</td>
                        
                        <td  colspan="5" class="text-center" id="All_Total">' . $AllTotal .'</td>
                    </tr>';
        
        break;
    case 0:
        $sql = "";
        $result = mysqli_query($conn, $sql) or die($sql);
        break;
    
}
        
echo '      </tbody>
        </table>';
?>