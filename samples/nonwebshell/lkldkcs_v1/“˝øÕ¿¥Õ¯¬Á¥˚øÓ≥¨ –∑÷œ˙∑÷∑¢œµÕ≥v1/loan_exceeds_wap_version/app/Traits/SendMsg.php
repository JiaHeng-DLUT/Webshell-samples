<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-8-22
 * Time: 15:40
 */

namespace App\Traits;


use App\Models\SmsRecord;
use App\Models\SmsSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

trait SendMsg
{

    protected  $messageCount = 10;//同一号码当日接收短信上限
    protected  $encode='UTF-8';  //页面编码和短信内容编码为GBK。
    protected  $accesskey='c1648da1dd32ac0056d5df73e445b727';  //平台分配给用户的AccessKey
    protected  $secret='cc07b4ddcc1aa95de6ee20c982b6c4a6';  //平台分配给用户的AccessSecret
    protected  $msg_url = "http://sms.kouhaobang.com/api/send/do";  //post提交的地址

    /**
     * 将短信验证码存入session
     * @param $phone
     * @param $code
     * @param $verifyType
     */
    public function setCodeRedis($phone,$code,$verifyType){
        Session::forget($verifyType.':'.$phone);
        Session([$verifyType.':'.$phone=>$code]);
    }
    /**
     * 将销毁短信验证码session
     * @param $phone
     * @param $code
     * @param $verifyType
     */
    public function destroyCodeRedis($phone,$verifyType){
        Session::forget($verifyType.':'.$phone);
    }
    /**
     * 检查当前号码接收的短信条数
     * @param $phone
     * @return int
     */
    public function checkCodeHistory($phone){
        $number = SmsRecord::where('phone',$phone)->where('created_at','>=',date('Y-m-d'))->count();
        if($number < $this->messageCount)
        {
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 取出验证码
     * @param $phone
     * @param $verifyType
     * @return int
     */
    public function checkPhoneCode($phone,$verifyType){
        if(Session::get($verifyType.':'.$phone)){
            return Session::get($verifyType.':'.$phone);
        }else{
            return 0;
        }
    }

    /**
     * 检测 手机/渠道 是否为白名单
     * @param string $phone
     * @param string $channel
     * @return int
     */
    public function checkWhite($phone='',$channel='')
    {
        if (!empty($phone)){
            $redis_key = 'phone_white_list';
            $redis_value = $phone;
        }else{
            $redis_key = 'channel_white_list';
            $redis_value = $channel;
        };
        if (Redis::exists($redis_key)){
            $exists = json_decode(Redis::get($redis_key),true);
            if (in_array($redis_value,$exists)){
                return 1;//存在于白名单
            }else{
                return 0;//不存在
            }
        }else{
            return 0;//redis不存在
        }
    }
    /**
     * 发送短信验证码
     * @param int $verifyType
     * @param $phone
     * @param $code
     * @param $type
     * @return mixed
     */
    public function  newSendSMS($phone,$code,$type)
    {
        $setting = SmsSetting::first();
        $this->accesskey = $setting->appkey;
        $this->secret = $setting->appsecret;

        $param=array
        (
            'sms_key'=>$this->accesskey,
            'sms_secret'=>$this->secret,
            'phone'=>$phone,
            'code'=>$code,
            'category'=>$type,
        );
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->msg_url);//用PHP取回的URL地址（值将被作为字符串）
        curl_setopt($ch,CURLOPT_HEADER,1);//将文件头输出直接可见。
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//使用curl_setopt获取页面内容或提交数据，有时候希望返回的内容作为变量存储，而不是直接输出，这时候希望返回的内容作为变量
        curl_setopt($ch,CURLOPT_POST,1);//设置这个选项为一个零非值，这个post是普通的application/x-www-from-urlencoded类型，多数被HTTP表调用。
        curl_setopt($ch,CURLOPT_POSTFIELDS,$param);//post操作的所有数据的字符串。

        $data = curl_exec($ch);//抓取URL并把他传递给浏览器
        curl_close($ch);//释放资源
        $res = @explode("\r\n\r\n",$data);//分隔成数组,获取发送短信json数据
 //       return json_decode($res);//本地
       return $res[1];//线上
    }

}