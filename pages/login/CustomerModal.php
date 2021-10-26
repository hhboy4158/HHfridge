<div class="modal fade" id="CustomerModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <form action="#" method=post
        oninput='chkpsd.setCustomValidity(chkcustpsd.value != custpsd.value ? "Passwords do not match." : "")'
        onsubmit="cust_sign_up(); return false;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">使用者註冊</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="text" class="form-control" maxlength="12" minlength="4" id="custacc" name="custacc"
                        autocomplete="off" required="" placeholder="帳號"></p>
                    <small> <b style="color: red">*</b> 帳號輸入長度範圍 (4-12)</small>
                    <br><br>
                    <input type="password" maxlength="12" minlength="4" pattern="(?=^[A-Za-z0-9]{4,12}$)^.*$"
                        class="form-control" id="custpsd" name="custpsd" autocomplete="off" required=""
                        placeholder="密碼"></p>
                    <small> <b style="color: red">*</b> 密碼輸入長度範圍 (4-12)
                        ，密碼內容包含(A-Z,a-z,0~9)</small>
                    <br>
                    <input type="password" class="form-control" id="chkcustpsd" name="chkcustpsd" autocomplete="off" required=""
                        placeholder="再次輸入密碼"></p>
                    <hr>
                    <h3>基本資料</h3>
                    <br>
                    <h5>地址</h5>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="custAddress" name="custAddress" autocomplete="off"
                            required="" placeholder="桃園市中壢區龍川二街134號">
                        <!-- <span class="input-group-text validity"></span> -->
                        </p>
                        <!-- <div class="row"> -->
                    </div>
                    <br>
                    <h5>手機</h5>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">TW +886</span>
                        </div>

                        <input type="text" class="form-control" id="CustPhoneNum" name="CustPhoneNum" autocomplete="off"
                            required="" placeholder="926890776" pattern="(?=^[0-9]{9}$)^.*$">
                        <!-- <span class="input-group-text validity"></span> -->
                        <!-- <span class="validity"></span> -->
                        </p>
                    </div>

                    <!-- </div> -->
                    <!-- <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="uploadImage" accept="image/*">
                            <label class="custom-file-label" for="inputGroupFile04">選擇照片</label>
                        </div>
                    </div>

                    <hr>

                    <div class="card border-secondary mb-3" style="max-width: 60%;">
                        <div class="card-body text-secondary">
                            <h5 class="card-title">照片預覽</h5>
                            <hr>
                            <img id="img" src="../../images/register/image_mada.png" style="max-width: 100%; max-height:1000%">

                        </div>
                    </div> -->





                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox small" id="alertMessage">
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    <input type="submit" class="btn btn-primary" value="註冊">

                </div>
            </div>
        </div>
    </form>
</div>