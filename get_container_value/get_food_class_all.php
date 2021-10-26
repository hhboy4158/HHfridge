<?php


session_start();
require_once '../connections/Account.php';

$functionName = $_POST["functionName"];
$account =  isset($_SESSION['family_username']) ? $_SESSION['family_username'] : null;

switch ($functionName) {
	// 我的收藏
	case 'keep':

		$sql = 'SELECT family_account.Username,family_account.ID, keep.user, allrec.ID, name, img ,ing, num, link, diabetes, heartattack, hypertension, Liver, Lower_respiratory_tract, Nephritis, pneumonia, total, type 
				FROM `keep`
				INNER JOIN `allrec`,`family_account` 
				WHERE keep.`user` = `family_account`.`ID` AND keep.recipe = allrec.ID and keep.block = 0 and  unit like "%、%"';

		$result = mysqli_query($conn, $sql);

		while ($row = mysqli_fetch_row($result)) {
			if ($row[0] == $_SESSION['family_username']){
				echo '
				<div class="col-md-6 col-lg-3 ">
				<div class="product shadow ">
				<a href="f_popular.php?fid=' . $row[3] . '" class="img-prod"><center><img class="img-fluid" src="images/' . $row[5] . '" alt="Colorlib Template"></center>
					<div class="overlay"></div>
				</a>
				<div class="text py-3 pb-4 px-3 text-center">
					<h3><a href="f_popular.php?fid=' . $row[3] . '">' . $row[4] . '</a></h3>
					<div class="d-flex">
					<div class="pricing">
						<p class="price"><span class="mr-2 price-dc"></span><span class="price-sale"></span></p>
					</div>
					</div>
					<div class="bottom-area d-flex px-3">
					<div class="m-auto d-flex">
						</a>
						<a href="./pages/keep/keepprocess.php?fid=' . $row[3] . '" title="移除收藏" class="heart d-flex justify-content-center align-items-center " style="background:#c52424">
						<span><i class="ion-ios-close"></i></span>
						</a>
					</div>
					</div>
				</div>
				</div>
			</div>
		';
			}
		}
	break;

	// 顯示上方菜單列
	case 'menu':

		$Fclass = $_POST["Fclass"];
		$pagename = $_POST['pagename'];
		$sql = "SELECT * FROM `type` ORDER BY id DESC";
		$result = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_row($result)) {
			if($pagename == "allrec"){
				if ($row[2] == $Fclass) {
				
					echo
						'
						<li class="nav-item ftco-animate fadeInUp ftco-animated">
						  <a class="nav-link active" href="./' . $pagename . '.php?Fclass=' .$row[2] . '&item=2&Pages=1" style="color:#82ae46;">' . $row[2] . '</a>
						</li>
					';
				} else {
	
					echo
						'
					<li class="nav-item ftco-animate fadeInUp ftco-animated">
					  <a class="nav-link" href="./' . $pagename . '.php?Fclass=' . $row[2] . '&item=2&Pages=1">' . $row[2] . '</a>
					</li>
					';
				}
			}else{
				if ($row[2] == $Fclass) {
				
					echo
						'
						<li class="nav-item ftco-animate fadeInUp ftco-animated">
						  <a class="nav-link active" href="./' . $pagename . '.php?Fclass=' .$row[2] . '&item=2&Pages=1">' . $row[2] . '</a>
						</li>
					';
				} else {
	
					echo
						'
					<li class="nav-item ftco-animate fadeInUp ftco-animated">
					  <a class="nav-link" href="./' . $pagename . '.php?Fclass=' . $row[2] . '&item=2&Pages=1">' . $row[2] . '</a>
					</li>
					';
				}
			}
			
		}


		break;


	// 顯示下方使用者點選的料理
	case 'foodlist':

		$Fclass = $_POST["Fclass"];
		$show_row = 8;
		$Pages = (empty($_POST['Pages'])) ? 1 : $_POST['Pages'];
		// echo $Pages;
		if(strtolower($Fclass) == "all" || $Fclass == "")
		{
			$sql = 'SELECT * FROM `allrec` where unit like "%、%" LIMIT ' . ($Pages - 1) * $show_row . ',' . $show_row;
			// echo $sql ;
		}else{

			$sql = 'SELECT * 
					FROM `allrec` INNER JOIN `type`
					WHERE `type`.`fid` = `allrec`.`type` AND `type`.`name` = ' ."'". $Fclass . "'". ' and unit like "%、%" LIMIT ' . ($Pages - 1) * $show_row . "," . $show_row . '';
		}
		$item = isset($_COOKIE['item']) ? explode(",", $_COOKIE['item']): [] ;
		$result = mysqli_query($conn, $sql) or die($sql);
		while ($row = mysqli_fetch_row($result)) {
			echo '
					<div class="col-md-6 col-lg-3 ftco-animate fadeInUp ftco-animated">
						<div class="product shadow ">
							<a onclick="totalFood(\'add\',\'' . $row[0] . '\')" class="img-prod"><center><img class="img-fluid" src="images/recipe_image_squeeze/' . $row[4] . '" alt="ERROR 404: image not found"></center>
								<div class="overlay"></div>
							</a>
							<label for="checkrecipebox' . $row[0] . '">
								<div class="text py-3 pb-4 px-3 text-center">
									<h3>' . $row[1] .'</h3>';
									if(in_array($row[0],$item)){
										echo '<input type="checkbox" id="checkrecipebox' . $row[0] . '" name="check_ID" value="' . $row[0] . '" autocomplete="off" onchange="return addCookie(' . $row[0] . '); return false;" checked>';
									}else{
										echo '<input type="checkbox" id="checkrecipebox' . $row[0] . '" name="check_ID" value="' . $row[0] . '" autocomplete="off" onchange="return addCookie(' . $row[0] . '); return false;">';
									}
									
							  echo '<div class="d-flex">
										<div class="pricing">
											<p class="price"><span class="mr-2 price-dc"></span><span class="price-sale"></span></p>
										</div>
									</div>
									<div class="bottom-area d-flex px-3">
										<div class="m-auto d-flex">
											<a href="./pages/keep/keepprocess.php?fid=' . $row[0] . '" title="加入我的收藏"  alt="加入我的收藏" class="heart d-flex justify-content-center align-items-center mx-1">
												<span><i class="ion-ios-heart"></i></span>
											</a>
										</div>
									</div>
								</div>
							</label>
						</div>
					</div>';
		}
		break;

	case "cheflist":
		$Fclass = $_POST["Fclass"];
		// echo "!empty:" . !empty($_POST["Fclass"]);
		// echo "ALL" . $_POST['Fclass'] == "ALL";
		if(empty($_POST["Fclass"]) or $_POST['Fclass'] == "ALL"){
			$sqli = "SELECT * FROM `chef_account`";
		}else{
			$sqli = "SELECT * FROM `chef_account` inner join chef_skill where chef_account.ID = chef_skill.chef_ID and chef_skill.chef_type = (SELECT fid FROM `type` WHERE name = '" . $Fclass ."')";
		}
		$result = mysqli_query($conn, $sqli) or die($sqli);
		while($row = mysqli_fetch_array($result)){
			echo '<div class="col-md-6 col-lg-3 text-center">
					<div class="product">';
				if($row['img'] == 0){
					echo '<a href="./pages/chef_portfolio/chef_detail.php?name=' . $row['ID'] . '" class="img-prod"><img class="img-fluid" src="images/users/user.png" style="width:253px; height:254px;" alt="Colorlib Template">';
				}else if(isset($row['img'])){
					echo '<a href="./pages/chef_portfolio/chef_detail.php?name=' . $row['ID'] . '" class="img-prod"><img class="img-fluid" src="images/users/' . $row['img'] . '" style="width:253px; height:254px;" alt="Colorlib Template">';
				
				}else{
					echo '<a href="./pages/chef_portfolio/chef_detail.php?name=' . $row['ID'] . '" class="img-prod"><img class="img-fluid" src="images/users/user.png" style="width:253px; height:254px;" alt="Colorlib Template">';
				}
					
					echo '<div class="overlay"></div>
						</a>
						<div class="text py-3 pb-4 px-3 text-center">
							<h3><a href="./pages/chef_portfolio/chef_detail.php?name=' . $row['ID'] . '">' . $row['ChefFirstName'] . $row['ChefName'] . '</a></h3>
							<div class="d-flex">
								<div class="pricing">
									<p class="price">
										<span>';
											$c = 0;
											$sql_s ="SELECT chef_skill.*, type.name FROM `chef_skill` inner join type where chef_skill.`chef_type` = type.fid and chef_skill.chef_ID = '" . $row['ID'] ."'";
											$result_s = mysqli_query($conn, $sql_s) or die($sql_s);
											$length = mysqli_num_rows($result_s);
											while($row_s = mysqli_fetch_array($result_s)){
												if($c != $length - 1){
													echo $row_s['name'] . "、";
												}else{
													echo $row_s['name'];
												}
												$c++;
											}
									echo '</span>
									</p>
								</div>
							</div>
							<div class="bottom-area d-flex px-3">
								<div class="m-auto d-flex">
									<a href="#" class="add-to-cart d-flex justify-content-center align-items-center text-center">
										<span><i class="ion-ios-menu"></i></span>
									</a>
									<a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">
										<span><i class="ion-ios-cart"></i></span>
									</a>
									<a href="#" class="heart d-flex justify-content-center align-items-center ">
										<span><i class="ion-ios-heart"></i></span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>';
		}
		
		break;

	case "skill":
		$sql = "SELECT `name` FROM `type` INNER JOIN chef_skill WHERE chef_skill.chef_type = type.id and chef_skill.chef_ID = 
				(SELECT ID FROM chef_account WHERE `account` = '" . $account . "')";
		$result = mysqli_query($conn, $sql) or die($sql);
		$c_skill = array();
		while($row = mysqli_fetch_array($result)){
			array_push($c_skill, $row['name']);
		}
		$sql = "SELECT `id`,`name`,`tag` FROM `type`";
		$result = mysqli_query($conn, $sql) or die($sql);
		while($row = mysqli_fetch_array($result)){
			if($row['name'] == "ALL"){
				break;
			}else{
				if(in_array($row['name'], $c_skill, true)){
					echo '  <div class="form-check form-check-inline col-md-2">
						<input class="form-check-input" type="checkbox" id="' . $row['tag'] . '" name="skill" value="' . $row['id'] . '" checked>
						<label class="form-check-label" for="' . $row['tag'] . '"> ' . $row['name'] .  ' </label>
					</div>';
				}else{
					echo '  <div class="form-check form-check-inline col-md-2">
						<input class="form-check-input" type="checkbox" id="' . $row['tag'] . '" name="skill" value="' . $row['id'] . '">
						<label class="form-check-label" for="' . $row['tag'] . '"> ' . $row['name'] .  ' </label>
					</div>';
				}	
			}
		}
		break;

	
	default:
		# code...
		break;
}