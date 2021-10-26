<?php
session_start();
require_once './../../../../connections/Account.php';
// $s_PageValue  =  $_POST['PageValue'];
$divID        =  $_POST['divID'];
$s_account    =  $_SESSION['family_username'];
switch($divID){
    case 'ModalExistingCheck':
        $sql     =   "SELECT `id`, `name` FROM `type` INNER JOIN chef_skill WHERE type.id = chef_skill.chef_type and chef_skill.chef_ID = ";
        $sql    .=   "(SELECT ID FROM chef_account WHERE account = '" . $s_account . "')"; 
        $result  =   mysqli_query($conn, $sql) or die($sql);
        $i = 0;
        while($row = mysqli_fetch_array($result)){
            if($i == 0){
                echo '
                    <label class="btn btn-outline-secondary active" for="btnradio' . $row['id'] . '">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio' . $row['id'] . '" autocomplete="off" value="' . $row['id'] . '" onchange=" return loadSystemRecipeBody(' . "'ModalExistingBody'" . ');"  checked>
                        ' . $row['name'] . '
                    </label>
                ';
                $i++;
            }else{
                echo '
                    <label class="btn btn-outline-secondary" for="btnradio' . $row['id'] . '">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio' . $row['id'] . '" autocomplete="off" value="' . $row['id'] . '" onchange=" return loadSystemRecipeBody(' . "'ModalExistingBody'" . ');" >
                        ' . $row['name'] . '
                    </label>
                ';
            }
        }
        break;
    case 'ModalExistingBody':
        $val = $_POST['val'];
        $sql = "SELECT * FROM `allrec` WHERE type =  '" . $val . "' and `unit` like '" . "%、%" . "'";
        $result = mysqli_query($conn, $sql) or die($sql);
        $halo = 5;
        while($row = mysqli_fetch_array($result)){
            echo '
                <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-ms-12 text-center"><!-- data-aos-anchor-placement="top-center" data-aos="fade-down" data-aos-duration="' . $halo .'00" -->
                    <div class="custom-control custom-checkbox image-checkbox">
                        <figure class="figure">
                            <input type="checkbox" class="custom-control-input" id="ck1a' . $row['ID'] . '" name="RecipeCheckbox" onchange="return GetCheckNum(); return false;" value="' . $row['ID'] . '">
                            <label class="custom-control-label" for="ck1a' . $row['ID'] . '">
                                <img src="./../../images/' . $row['img'] . '" class="figure-img img-fluid rounded" 
                                    alt="A generic square placeholder image with rounded corners in a figure." style= "width: 200px; height: 200px ">
                            </label>
                            <figcaption class="figure-caption text-center">' . $row['name'] . '</figcaption>
                        </figure>
                    </div>
                </div>
            ';
            $halo++;
        }
        
        break;
}

?>