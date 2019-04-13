<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/10 0010
 * Time: 上午 11:49
 */

namespace App\Traits;


trait Sms
{

    public $postUrl = "http://sms.kouhaobang.com/";
    /**
     * @param $url
     * @param $post_data
     * @return mixed
     * curl 类
     */
    function requestPost($url,$post_data=null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
    }

    /**
     * @param $url
     * @param null $post_data
     * @return mixed
     */
    function requestGet($url){
        $content = file_get_contents($url);
        return json_decode($content,true);
    }
    /**
     * 拉取充值记录
     */
    public function getRechargeList($data){
        $url = $this->postUrl.'/api/get/charge/list';
        $res = $this->requestPost($url,$data);
        return $res;
    }

    /**
     * 拉取余额记录
     */
    public function getRestList($data){
        $url = $this->postUrl.'/api/get/number/rest';
        $res = $this->requestPost($url,$data);
        return $res;
    }


    /**
     * @param $data
     * @return mixed
     * 注册账号
     */
    public function register($data){
        $url = $this->postUrl.'api/register';
        $res = $this->requestPost($url,$data);
        return $res;
    }

}