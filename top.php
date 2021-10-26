<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>結合慢性病照護與食譜推薦之智慧冰箱</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.css">

  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/ionicons.min.css">

  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">


  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/style.css">

  <link rel="stylesheet" href="css/media.css">

  <link rel="stylesheet" href="vendor/bootstrap-select/css/bootstrap-select.min.css">

  <!-- icon lick -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

  <!-- sweetalert2 theme -->
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

  <!-- Chart.js v2.4.0 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

  <!-- table detail view -->
  <!-- <script src="https://www.itxst.com/package/bootstrap-table-1.14.1/jquery-3.3.1/jquery.js"></script>
  <link href="https://www.itxst.com/package/bootstrap-table-1.14.1/bootstrap-4.3.1/css/bootstrap.css" rel="stylesheet" />
  <link href="https://www.itxst.com/package/bootstrap-table-1.14.1/bootstrap-table-1.14.1/bootstrap-table.css" rel="stylesheet" />
  <script src="https://www.itxst.com/package/bootstrap-table-1.14.1/bootstrap-table-1.14.1/bootstrap-table.js"></script>  -->
  <link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">

<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
  <!-- /table detail view -->

  <link href="./css/IndexChoose.css"  rel="stylesheet">

</head>

<style>
  body {
    font-family: arial, "Microsoft JhengHei", "微軟正黑體", sans-serif !important;
  }
</style>

<!-- change psd modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="#" oninput='cfmpsd.setCustomValidity(cfmpsd.value != newpsd.value ? "Passwords do not match." : "")' onsubmit="return changepsd();return false;" method="post">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">變更密碼</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <label for="ogpsd" class="col-form-label">原有密碼:</label>
          <input id="ogpsd" type="password"  value="" maxlength="12" minlength="4" autocomplete="off" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required="">
          </p>

          <label for="newpsd" class="col-form-label">新密碼:</label>
          <input id="newpsd" type="password"  value="" maxlength="12" minlength="4" pattern="(?=^[A-Za-z0-9]{4,12}$)^.*$" autocomplete="off" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required="">
          </p>

          <label for="cfmpsd" class="col-form-label">新密碼確認:</label>
          <input id="cfmpsd" type="password"  value="" maxlength="12" minlength="4" autocomplete="off" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required="">
          </p>
          <!-- <p>新密碼:
            <input type="Password" name="password" autocomplete="off" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
          </p> -->
        </div>

        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" name="submit" value="變更">
          <!-- <input class="btn btn-outline-secondary" type="button" value="取消" href="#" onclick="pageLoad('family_Inquire')"> -->
          <button type="button" data-dismiss="modal" class="btn btn-secondary" href="#" value="取消">取消</button>
        </div>

      </form>
    </div>

  </div>
</div>
<!-- /change psd modal -->

<body class="goto-here" style="color:black;font-family: 微軟正黑體;">
  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="index.php">vegefoods</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> Menu
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto" name="loadnav">

        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->
  <script>
    function changepsd() {
      yes = confirm('確定要變更密碼嗎?');
      if (yes == 1) {
        var ogpsd = document.getElementById("ogpsd").value;
        var newpsd = document.getElementById("newpsd").value;
        var cfmpsd = document.getElementById("cfmpsd").value;
        // alert (ogpsd + "," + newpsd + "," + cfmpsd);
        $.ajax({
          type: "post",
          url: "./pages/user/changepsd.php",
          data: {
            ogpsd: ogpsd,
            newpsd: newpsd,
            cfmpsd: cfmpsd,
          },
          cache: false
        }).done(function(msg) {
          // 如果沒有儲存設定
          switch (msg) {
            case "0":
              alert("輸入的原密碼不正確!")
              break;

            case "1":
              alert("變更成功!");
              break;

            default:
              alert("ERROR 404:" + msg);

          }
          location.reload("./user_manage.php#family_Inquire");
        }) //done
      }
      return false;
    }
  </script>