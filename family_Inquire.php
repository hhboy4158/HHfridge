    <?php

	// session_start();
	require_once('./connections/Account.php');

	$family = $_SESSION['family_username'];

	// 查詢使用者
	$f = "SELECT * FROM family_account WHERE Username = '$family' LIMIT 1;";
	$f_result = mysqli_query($conn, $f);
	$f_row = mysqli_fetch_array($f_result);
	// 使用者ID
	$re_owner = $f_row[0];
	$re_class = $f_row[3];

	// ================================================
	$sql = "SELECT * FROM  `family_account` as f, `personal_account` as p
			WHERE f.ID = '$re_owner' AND p.Owner = '$re_owner'";
	$result = mysqli_query($conn, $sql);

	// 幾筆子帳號資料
	$row = mysqli_num_rows($result);

	
	
	// 第一次進入
	if ($re_class == 0) {
		echo '<input type="button" class="btn btn-outline-secondary" value="新增子帳戶" data-toggle="modal" data-target="#addchild">';
		echo '<span> </span>';
		echo '<input type="button" class="btn btn-outline-secondary" value="儲存設定" href="#personal_signup" onclick="UserCheckUpdata()">';
	} else if ($re_class == 1 && $row > 0) {
		// 確定儲存且也有新增子帳戶
		echo '<input type="button" class="btn btn-outline-secondary" value="新增子帳戶" data-toggle="modal" data-target="#addchild">';
		echo '<span> </span>';
		echo '<input type="button" class="btn btn-outline-secondary" value="修改子帳戶" data-toggle="modal" data-target="#setchild">';
		echo '<span> </span>';
	} else {
		// 如果沒有新增子帳戶
		echo '<input type="button" class="btn btn-outline-secondary" value="新增子帳戶" data-toggle="modal" data-target="#addchild">';
		echo '<span> </span>';
	}

	
	echo "<form id='delform' style='width:1024px' action='./pages/user/delchild.php'>";

	echo '<table class="table table-hover" >
			<thead>
				<tr  class="table text-center">
					<td scope="col">刪除</td>
					<td scope="col">名稱</td>
					<td scope="col">子帳戶帳號</td>
					<td scope="col">心臟疾病</td>
					<td scope="col">肺炎</td>
					<td scope="col">糖尿病</td>
					<td scope="col">慢性下呼吸道疾病</td>
					<td scope="col">高血壓性疾病</td>
					<td scope="col">腎炎腎病症候群</td>
					<td scope="col">變慢性肝病</td>
				</tr>
			</thead>';
	echo "</br>";

	// 依照使用者ID查詢所有人
	$re = "SELECT * FROM personal_account where Owner = '$re_owner'";

	$re_result = mysqli_query($conn, $re);

	while ($re_row = mysqli_fetch_array($re_result)) {

		for ($i = 4; $i <= 10; $i++) { //第4個到第11個column是疾病

			if ($re_row[$i] == 1) {//⭐️
				$re_row[$i] = '⭐️';
			} else {
				$re_row[$i] = "";
			}
			//用迴圈跑下列
		}
		$d = "'" . $re_row[0] . "'";
		echo '<tbody class="text-center"><tr>
			<td class="product-remove"><a href="#" onclick="removeuser(' . $d . ');"><span class="ion-ios-close"></span></a></td>
			<td>' . $re_row[2] . '</td>
			<td>' . $re_row[3] . '</td>
			<td>' . $re_row[4] . '</td>
			<td>' . $re_row[5] . '</td>
			<td>' . $re_row[6] . '</td>
			<td>' . $re_row[7] . '</td>
			<td>' . $re_row[8] . '</td>
			<td>' . $re_row[9] . '</td>
			<td>' . $re_row[10] . '</td>
			
			  </tr></tbody>';
	}
	echo "</table>
	</form>";

	?>