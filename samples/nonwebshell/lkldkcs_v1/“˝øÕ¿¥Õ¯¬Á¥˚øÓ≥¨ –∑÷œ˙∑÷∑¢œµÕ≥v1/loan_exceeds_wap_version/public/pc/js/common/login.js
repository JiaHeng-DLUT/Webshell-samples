document.write("<script language=javascript src='/pc/js/common/aes.js'></script>");

/**
 * 加密（需要先加载lib/aes/aes.min.js文件）
 */
function encrypt(word){
    var key = CryptoJS.enc.Utf8.parse("ySjR!@#$%^&*2018");
    var ivs   = CryptoJS.enc.Utf8.parse('2018^@YSJR_%ysjr');
    var srcs = CryptoJS.enc.Utf8.parse(word);
    var encrypted = CryptoJS.AES.encrypt(srcs, key, {
        iv: ivs,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7
    });
    return encrypted.toString();
}
/**
 * 解密
 */
function decrypt(word){
    var key = CryptoJS.enc.Utf8.parse("ySjR!@#$%^&*2018");
    var ivs   = CryptoJS.enc.Utf8.parse('2018^@YSJR_%ysjr');
    var decrypt = CryptoJS.AES.decrypt(word, key, {
        iv: ivs,
        mode: CryptoJS.mode.CBC,
        padding: CryptoJS.pad.Pkcs7
    });
    return CryptoJS.enc.Utf8.stringify(decrypt).toString();
}

/**
 * 获取短信验证码
 * @param phone
 * @param captcha
 * @param scene
 */
function getVerifyCode(phone,captcha,scene){
    $.ajax({
        url: '/getVerifyCode',
        type: 'POST',
        dataType: 'JSON',
        headers: {
            'X-CSRF-TOKEN': window._token,
            crypto: 1
        },
        data: {
            mobile: encrypt(phone),
            captcha: captcha,
            scene: scene
        },
        success: function (data) {
            console.log(data);
            if (data.status === 200) {
                flag = false
                var time = 60
                $(type).siblings('input').attr('readonly',false)
                $(type).addClass('on').text('('+ time +'s)重新获取')
                timer = setInterval(function(){
                    time --
                    $(type).text('('+ time +'s)重新获取')
                    if(time <= 0){
                        flag = true
                        $(type).removeClass('on').text('获取验证码')
                        clearInterval(timer)
                    }
                }, 1000)
            } else {
                alert(data.info);
                // flag = true
                // $(type).removeClass('on').text('获取验证码')
                // clearInterval(timer)
                return false;
            }
        }
    })
}

$(function(){

    //获取短信验证码
    $('#getVerifyCode').on('click',function () {
        var phone=$('input[name="phone"]').val();
        var captcha=$('input[name="captcha"]').val();
        if(phone===''){
            alert('请输入手机号码');return false;
        }
        if(!(/^1[3456789]\d{9}$/.test(phone))){
            alert("手机号码有误，请重填");
            return false;
        }
        if(captcha===''){
            alert('请输入图形验证码');return false;
        }
        getVerifyCode(phone,captcha,'login');

    });

});