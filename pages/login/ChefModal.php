<div class="modal fade" id="ChefModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <form action="#" method=post
        oninput='chkchefpsd.setCustomValidity(chkchefpsd.value != chefpsd.value ? "Passwords do not match." : "")'
        onsubmit="chef_sign_up(); return false;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">廚師註冊</h5>
                    <small style="color:red;">* 廚師註冊必須先經過認證 *</small>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" maxlength="12" minlength="4" id="chefacc" name="chefacc"
                        autocomplete="off" required="" placeholder="帳號" pattern="(?=^[A-Za-z0-9]{4,12}$)^.*$"></p>
                    <small> <b style="color: red">*</b> 帳號輸入長度範圍 (4-12)</small>
                    <br><br>
                    <input type="password" maxlength="12" minlength="4" pattern="(?=^[A-Za-z0-9]{4,12}$)^.*$"
                        class="form-control" id="chefpsd" name="chefpsd" autocomplete="off" required=""
                        placeholder="密碼"></p>
                    <small> <b style="color: red">*</b> 密碼輸入長度範圍 (4-12)
                        ，密碼內容包含(A-Z,a-z,0~9)</small>
                    <br>
                    <input type="password" class="form-control" id="chkchefpsd" name="chkchefpsd" autocomplete="off"
                        required="" placeholder="再次輸入密碼"></p>
                    <hr>
                    <h3>基本資料</h3>
                    <br>
                    <h5>姓名</h5>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="chefFirstName" name="chefFirstName"
                            autocomplete="off" required="" placeholder="張">
                        <input type="text" class="form-control" id="chefName" name="chefName" autocomplete="off"
                            required="" placeholder="葦航">
                        </p>
                    </div>
                    <br>
                    <h5>住址</h5>
                    <input type="text" class="form-control" id="chefAddress" name="chefAddress" autocomplete="off"
                        required="" placeholder="桃園市中壢區龍川二街134號"></p>
                    <!-- <div class="row"> -->
                    <br>
                    <h5>手機</h5>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">TW +886</span>
                        </div>

                        <input type="text" class="form-control" id="chefPhoneNum" name="chefPhoneNum" autocomplete="off"
                            required="" placeholder="926890776" pattern="(?=^[0-9]{9}$)^.*$">
                        </p>
                    </div>

                    <hr>
                    <!-- <h5>選擇專長</h5>
                    <div id="skill" name="skill">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="it" value="1">
                            <label class="form-check-label" for="it">義式料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="us" value="2">
                            <label class="form-check-label" for="us">美式料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="th" value="3">
                            <label class="form-check-label" for="th">泰式料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="jp" value="4">
                            <label class="form-check-label" for="jp">日式料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="tw" value="5">
                            <label class="form-check-label" for="tw">台式料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="ko" value="6">
                            <label class="form-check-label" for="ko">韓式料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="hk" value="7">
                            <label class="form-check-label" for="hk">港式料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="sc" value="8">
                            <label class="form-check-label" for="sc">四川料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="ch" value="9">
                            <label class="form-check-label" for="ch">中式料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="fr" value="10">
                            <label class="form-check-label" for="fr">法式料理</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="en" value="11">
                            <label class="form-check-label" for="en">英式料理</label>
                        </div>
                    </div> -->
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