<?php
require_once './connections/Account.php';
include("./top.php");
?>

<body class="goto-here">

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg/bg-recipe.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="./index.php">Home</a></span>
                    <h1 class="mb-0 bread">食譜總覽</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-3 pb-3">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">All recipes</span>
                    <h2 class="mb-4">食譜總覽</h2>
                    <div id="qq"></div>
                    <p>以下為本平台收錄之所有食譜</p>
                    <?php
                    if(isset($_COOKIE['item'])){
                       echo '<button type="button" class="btn btn-danger" onclick="return delCookie('."'carItem'".'); return false;">全部清除</button>'; 
                    }
                    ?>
                    <input class="btn btn-outline-info btn-lg align-center" type="button" value="瀏覽所需食材"
                        onclick="return check_ingredient('check_recipe_ing')" data-toggle="modal"
                        data-target="#select_recipe_Modal">
                    <input class="btn btn-outline-secondary btn-lg align-center" type="button" value="主廚推薦"
                        onclick="return chef_recommendation(); return false;" data-toggle="modal"
                        data-target=".bd-recommandchef-modal-xl">
                </div>
            </div>
        </div>
        <div class="container">
            <ul class="nav justify-content-center" id="menu">

            </ul>
            <hr>
            </br>
            </br>
            <form action="" id="recipe_check">
                <div class="row" id="foodlist">

                    <!------------------------------------------------------------>
                    <?php
				

				    ?>
                    <!------------------------------------------------------------>

                </div>
            </form>
        </div>
        <?php include("./part/allrec_pages.php"); ?>
    </section>

    <div class="modal fade" id="select_recipe_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">所需食材</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" id="buy_ing">
                    <!--onsubmit="check_buy(); return false;"-->
                    <div class="modal-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">所需食材</th>
                                    <th scope="col">所需數量</th>
                                    <th scope="col">缺少食材</th>
                                </tr>
                            </thead>
                            <tbody id="check_body">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                        <!-- <input type="submit" class="btn btn-primary" value="訂購食材"> -->
                        <button type="button" class="btn btn-primary" onclick="check_buy()">訂購食材</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bd-recommandchef-modal-xl" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title h4" id="myExtraLargeModalLabel">主廚推薦</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div id="rec_body" class="card mb-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>
    <?php include("./footer.php"); ?>

    <script>
    $(document).ready(function() {
        checkcookie();
        var quantitiy = 0;
        $('.quantity-right-plus').click(function(e) {

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            $('#quantity').val(quantity + 1);


            // Increment

        });

        $('.quantity-left-minus').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

            // Increment
            if (quantity > 0) {
                $('#quantity').val(quantity - 1);
            }
        });

    });

    <?php $Fclass = empty($_GET['Fclass']) ? "" : $_GET['Fclass'];?>
    LoadFood("menu", '<?php echo  $Fclass; ?>', <?php echo $_GET["Pages"]; ?>);
    LoadFood("foodlist", '<?php echo $Fclass; ?>', <?php echo $_GET["Pages"]; ?>);


    function LoadFood(functionName, Fclass, Pages) {

        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_class_all.php",
            data: {
                functionName: functionName,
                Fclass: Fclass,
                Pages: Pages,
                pagename: "allrec",
            },
            cache: false
        }).done(function(msg) {

            //console.log(msg);
            document.getElementById(functionName).innerHTML = msg;
        })
    }



    function removeA(arr) {
        var what,
            a = arguments,
            L = a.length,
            ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax = arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    }



    function addCookie(item) {
        let flag = false;
        currentItem = Cookies.get("item");
        if (Cookies.get("item") == undefined) {
            Cookies.set("item", item, {
                path: './allrec.php'
            })
        } else {
            let currentArray = currentItem.split(",");
            for (let i of currentArray) {
                if (i == item) {
                    currentArray = removeA(currentArray, i);
                    let removed = currentArray.join();
                    Cookies.set("item", removed, {
                        path: './allrec.php'
                    })
                    flag = true;
                }
            }
            if (flag == false) {
                currentItem = Cookies.get("item");
                currentItem = currentItem + "," + item;
                Cookies.set("item", currentItem, {
                    path: './allrec.php'
                })
            }
        }
        // checkcookie();
        window.location.reload();
        return false;
        //0922592316 王同學 13:00 805 5/26
    }



    //清空cookie
    function delCookie(item) {
        if (Cookies.get("item") != undefined) {
            Cookies.remove('item', {
                path: './allrec.php'
            });
            checkcookie();
        }
        window.location.reload();
    }




    function checkcookie() {
        console.log(Cookies.get("item"));
        //若 Cookies 尚未建立 或 Cookie內是空值 清空cookie
        if (Cookies.get("item") == undefined || Cookies.get("item") == "") {
            let element = document.createElement("p");
            element.setAttribute("id", "item");
            element.setAttribute("value", "t");
            element.innerHTML = "尚未選擇食譜!";
            document.getElementById("qq").appendChild(element);
            console.log(element);
            Cookies.remove('item', {
                path: './allrec.php'
            });
        } else {
            //藉由split把食譜個列出來
            let items = Cookies.get("item");
            items = items.split(",");
            for (let item of items) {
                let element = document.createElement("li");
                element.setAttribute("name", "item");
                element.innerHTML = item;
                document.querySelector("#qq").appendChild(element);
                console.log(element);
            }
        }
        return false;
    }



    function check_ingredient(functionName) { //modal顯示勾選的食譜食材
        var formData = $('#recipe_check').serializeArray();
        console.log(formData);

        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: functionName,
                formData: formData,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById("check_body").innerHTML = msg;
        })

        return false;
    }



    function chef_recommendation() {
        var formData = $('#recipe_check').serializeArray();
        // console.log(formData);
        const functionName = "chef_recommendation";
        $.ajax({
            type: "post",
            url: "./get_container_value/get_food_data.php",
            data: {
                functionName: functionName,
                formData: formData,
            },
            cache: false
        }).done(function(msg) {
            document.getElementById('rec_body').innerHTML = msg;
            console.log(msg);
        })

        return false;
    }
    </script>

</body>

</html>