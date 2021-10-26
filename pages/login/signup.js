//使用者註冊
function cust_sign_up() {
    const cust_account = document.getElementById('custacc').value;
    const cust_password = document.getElementById('custpsd').value;
    const cust_address = document.getElementById('custAddress').value;
    const cust_phonenum = document.getElementById('CustPhoneNum').value;
    $.ajax({
        type: "POST",
        url: "./CustSignup.php",
        data: {
            cust_account: cust_account,
            cust_password: cust_password,
            cust_address: cust_address,
            cust_phonenum: cust_phonenum,
        },
        cache: false
    }).done(function (msg) {
        console.log(msg);
        if (msg == 1) {
            Swal.fire({
                icon: 'success',
                title: '註冊成功',
                text: msg,
                footer: 'Copyright ©2021 All rights reserved by <a href="https://www.facebook.com/photo?fbid=338212634253491&set=pob.100041942715066">林科地</a>'
            })
            window.location.href = "./login.php";
        } else if (msg == 2) {
            Swal.fire({
                icon: 'error',
                title: '註冊失敗，該帳號已有人使用 !',
                text: msg,
                footer: 'Copyright ©2021 All rights reserved by <a href="https://www.facebook.com/photo?fbid=338212634253491&set=pob.100041942715066">林科地</a>'
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: '出事了，阿伯',
                text: msg,
                footer: 'Copyright ©2021 All rights reserved by <a href="https://www.facebook.com/photo?fbid=338212634253491&set=pob.100041942715066">林科地</a>'
            })
        }
        return false;
    });


}

//主廚註冊
function chef_sign_up() {
    const chef_account = document.getElementById('chefacc').value;
    const chef_password = document.getElementById('chefpsd').value;
    const chef_address = document.getElementById('chefAddress').value;
    const chef_phonenum = document.getElementById('chefPhoneNum').value;
    const chef_FirstName = document.getElementById('chefFirstName').value;
    const chef_Name = document.getElementById('chefName').value;
    
    console.log(chef_account + ", " + chef_password + ", " + chef_address + ", " + chef_phonenum + ", " + chef_FirstName + ", " + chef_Name);
    $.ajax({
        type: "POST",
        url: "./ChefSignup.php",
        data: {
            chef_account: chef_account,
            chef_password: chef_password,
            chef_address: chef_address,
            chef_phonenum: chef_phonenum,
            chef_FirstName: chef_FirstName,
            chef_Name: chef_Name,
        },
        cache: false
    }).done(function (msg) {
        console.log(msg);
        if (msg == 1) {
            Swal.fire({
                icon: 'success',
                title: '註冊成功',
                text: "請接著填寫基本資料，聽話，讓我看看",
                footer: 'Copyright ©2021 All rights reserved by <a href="https://www.facebook.com/photo?fbid=338212634253491&set=pob.100041942715066">林科地</a>',
            }).then(() => {
                window.location.href = './../chef_portfolio/phase_02.php';

            })
        } else if (msg == 2) {
            Swal.fire({
                icon: 'error',
                title: '註冊失敗，該帳號已有人使用 !',
                text: msg,
                footer: 'Copyright ©2021 All rights reserved by <a href="https://www.facebook.com/photo?fbid=338212634253491&set=pob.100041942715066">林科地</a>'
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: '出事了，阿伯',
                text: msg,
                footer: 'Copyright ©2021 All rights reserved by <a href="https://www.facebook.com/photo?fbid=338212634253491&set=pob.100041942715066">林科地</a>'
            })
        }
        return false;
    })
}
