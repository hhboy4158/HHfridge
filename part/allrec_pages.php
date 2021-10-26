<?php
    require_once './connections/Account.php';
    @$Fclass = "'" . $_GET['Fclass'] . "'";
    $Pages = empty($_GET['Pages']) ? 1 : $_GET['Pages'];
    $show_row = 8;
    // if(empty($_GET['Pages'])){
    //     $Pages = 1;
    // }else{
    //     $Pages = $_GET['Pages'];
    // }
    // echo $Pages;
    if(@$_GET['Fclass'] == "ALL" or empty($_GET['Fclass'])){
        $sql = "SELECT count(*) FROM `allrec` WHERE unit like '%、%' ";
    }else{
        $sql = "SELECT count(*) FROM `allrec` as a inner JOIN `type` as t WHERE a.unit like '%、%' and a.type = t.fid and t.name = $Fclass";
    }
    $Fclass = empty($_GET['Fclass']) ? "" : $_GET['Fclass'];
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    $pages_count = ceil($row[0] / $show_row);
    // $pages_count = 679;
    $Previous_page = $Pages - 1;
?>

<div class="row mt-5">
    <div class="col text-center">
        <div class="block-27">
            <ul>
                <?php
                if($Pages != 1){
                    echo '<li><a href="./allrec.php?Fclass=' . $Fclass . '&item=2&Pages=' . ($Pages - 1) . '">&lt;</a></li>';
                }
                $con = 0;
                for($i = 1; $i <= $pages_count; $i++ ){
                    
                    if($Pages == $i){
                        echo '<li class="active"><a href="./allrec.php?Fclass=' . $Fclass . '&item=2&Pages=' . $i. '">' . $i . '</a></li>';
                    }else if($i > $Pages){
                        echo '<li><a href="./allrec.php?Fclass=' . $Fclass . '&item=2&Pages=' . $i. '">' . $i . '</a></li>';
                        $con ++;
                        // echo $con;
                    }else if($Pages-1 == $i or $Pages-2 == $i){
                        echo '<li><a href="./allrec.php?Fclass=' . $Fclass . '&item=2&Pages=' . $i. '">' . $i . '</a></li>';
                        $con ++;
                        // echo $con;
                    }

                    if($con >= 4)
                    {
                        // echo $pages_count;
                        break;
                    }
                }
            ?>

                <?php 
            if($Pages != $pages_count){
                echo '<li><a href="./allrec.php?Fclass=' . $Fclass . '&item=2&Pages=' . ($Pages + 1) . '">&gt;</a></li>';
            }
            ?>
            </ul>
        </div>
    </div>
</div>