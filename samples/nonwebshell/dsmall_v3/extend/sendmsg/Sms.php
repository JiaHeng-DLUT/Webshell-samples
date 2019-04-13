<?php
/**
 * 手机短信类
 */

namespace sendmsg;
class Sms
{
    /*
     * 发送手机短信
     * @param unknown $mobile 手机号
     * @param unknown $content 短信内容
    */
    public function send($mobile, $content)
    {
        return $this->mysend_sms($mobile, $content);
    }

    /*
    您于{$send_time}绑定手机号，验证码是：{$verify_code}。【{$site_name}】
    -1	没有该用户账户
    -2	接口密钥不正确 [查看密钥]不是账户登陆密码
    -21	MD5接口密钥加密不正确
    -3	短信数量不足
    -11	该用户被禁用
    -14	短信内容出现非法字符
    -4	手机号格式不正确
    -41	手机号码为空
    -42	短信内容为空
    -51	短信签名格式不正确接口签名格式为：【签名内容】
    -6	IP限制
   大于0 短信发送数量
    http://utf8.api.smschinese.cn/?Uid=本站用户名&Key=接口安全秘钥&smsMob=手机号码&smsText=验证码:8888
    */
    private function mysend_sms($mobile, $content)
    {
        $user_id = urlencode(config('smscf_wj_username')); // 这里填写用户名
        $key = urlencode(config('smscf_wj_key')); // 这里填接口安全密钥
        if (!$mobile || !$content || !$user_id || !$key)
            return false;
        if (is_array($mobile)) {
            $mobile = implode(",", $mobile);
        }
        $mobile=urlencode($mobile);
        $content=urlencode($content);
        $url = "http://utf8.api.smschinese.cn/?Uid=" . $user_id . "&Key=" . $key . "&smsMob=" . $mobile . "&smsText=" . $content;
        if (function_exists('file_get_contents')) {
            $res = file_get_contents($url);
        }
        else {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $res = curl_exec($ch);
            curl_close($ch);
        }
        if ($res >0) {
            return true;
        }
        return false;

    }


}
