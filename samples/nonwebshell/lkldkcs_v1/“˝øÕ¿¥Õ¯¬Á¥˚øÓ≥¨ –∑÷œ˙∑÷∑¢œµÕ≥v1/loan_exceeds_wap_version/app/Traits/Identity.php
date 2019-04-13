<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-1-9
 * Time: 10:26
 */

namespace App\Traits;


trait Identity
{
    private $appcode_ID = "******";
    private $appcode_phone = "************";

    /**
     * 识别身份证信息
     * @param $card_face
     * @return array
     */
    protected function distinguishID($card_face)
    {
        $url = "https://dm-51.data.aliyun.com/rest/160601/ocr/ocr_idcard.json";
        $file = $card_face;
        //如果输入带有inputs, 设置为True，否则设为False
        $is_old_format = false;
        //如果没有configure字段，config设为空
        $config = array(
            "side" => "face"
        );
//        $config = array();

        if($fp = fopen($file, "rb", 0)) {
            $binary = fread($fp, filesize($file)); // 文件读取
            fclose($fp);
            $base64 = base64_encode($binary); // 转码
        }
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $this->appcode_ID);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type".":"."application/json; charset=UTF-8");
        $querys = "";
        if($is_old_format == TRUE){
            $request = array();
            $request["image"] = array(
                "dataType" => 50,
                "dataValue" => "$base64"
            );

            if(count($config) > 0){
                $request["configure"] = array(
                    "dataType" => 50,
                    "dataValue" => json_encode($config)
                );
            }
            $body = json_encode(array("inputs" => array($request)));
        }else{
            $request = array(
                "image" => "$base64"
            );
            if(count($config) > 0){
                $request["configure"] = json_encode($config);
            }
            $body = json_encode($request);
        }
        $method = "POST";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$url, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $rheader = substr($result, 0, $header_size);
        $rbody = substr($result, $header_size);

        $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
        if($httpCode == 200){
            if($is_old_format){
                $output = json_decode($rbody, true);
                $result_str = $output["outputs"][0]["outputValue"]["dataValue"];
            }else{
                $result_str = $rbody;
            }
            return ['code'=>$httpCode,'data'=>$result_str];
//            printf("result is :\n %s\n", $result_str);
        }else{
            return ['code'=>$httpCode,'info'=>$rbody,'data'=>$rheader];
        }
    }


    /**
     * 验证手机号与身份证是否匹配
     * @param $id_number
     * @param $phone
     * @param $real_name
     * @return mixed
     */
    protected function phoneMatchID($id_number,$phone,$real_name)
    {
        $host = "https://fephone.market.alicloudapi.com";
        $path = "/phoneCheck";
        $method = "GET";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $this->appcode_phone);
        $querys = "idCard={$id_number}&mobile={$phone}&name={$real_name}";
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HEADER, true); //如不输出json, 请打开这行代码，打印调试头部状态码。
        //状态码: 01 实名认证通过；02 实名认证不通过 ；200 正常；400 URL无效；401 appCode错误； 403 次数用完； 500 API网管错误
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        $out_put = curl_exec($curl);
        $data = explode("\r\n\r\n",$out_put);
        return json_decode($data[1],true);
    }
}