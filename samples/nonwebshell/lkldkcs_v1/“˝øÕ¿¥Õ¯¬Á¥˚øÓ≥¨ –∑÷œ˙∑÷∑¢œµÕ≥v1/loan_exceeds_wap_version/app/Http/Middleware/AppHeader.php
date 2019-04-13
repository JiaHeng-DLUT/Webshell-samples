<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

/**
 * 处理请求中的Header
 *
 * Class AuditUserAuth
 * @package App\Http\Middleware
 */
class AppHeader
{
    /**
     *
     * @param Request $req
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $req, Closure $next)
    {

            $reqUrl = $req->fullUrl();
//            Log::info("请求【" . $reqUrl . "】 原始Header：" . print_r($this->headerFormat($req->headers->all()), true));
//            Log::info("请求【" . $reqUrl . "】 提交内容：" . print_r($req->all(), true));
            $channel = $req->header("Channel", "");
            $platform = $req->header("Source", "");
            $identifier = $req->header("Device", "");
            $system_version = $req->header("System", "");
            $app_version = $req->header("Version", "");

            if (empty($channel) && empty($platform) && empty($identifier) && empty($system_version) && empty($app_version)) {
                $req = $this->userAgentParse($req);
            } else {
                $req = $this->headerParse($req);
            }

//            Log::info("请求【" . $reqUrl . "】 处理后Header：" . print_r($this->headerFormat($req->headers->all()), true));//
        return $next($req);

    }

    /**
     * 格式化Header
     *
     * @param $headers
     * @return array
     */
    public function headerFormat($headers) {
        $headers =array_map(function($item) {
            return $item[0];
        }, $headers);
        return $headers;
    }

    /**
     * 从User-Agent中解析出Header
     *
     * @param $req
     * @return Request
     */
    public function userAgentParse(Request $req) {
        $userAgent = $req->header("user-agent", "");

        if(null === ($headers = json_decode($userAgent, true))) {
            //浏览器访问
            $appUserAgent = $req->header('App-User-Agent', "");
            if(!empty($appUserAgent)) {
                $appUserAgent = Crypt::decrypt($appUserAgent);
                $headers = json_decode($appUserAgent, true) ?: [];
                $headers["IDENTIFIER"] = $req->header("App-IDENTIFIER", "");
            }

        }

        $headers = $headers ?: [];
        //$headers = json_decode($userAgent, true) ?: [];
        foreach($headers as $key => $val) {
            $req->headers->set($key, $val, true);
        }
        $req = $this->headerParse($req);
        return $req;
    }

    /**
     * 重新处理header项
     *
     * @param $req
     * @return Request
     */
    public function headerParse(Request $req) {
        $channel = $req->header("Channel", "");
        $chaCode = $req->header("CHA-CODE", "");
        $source = $req->header("Source", "");
        $source = strtolower($source);


        $realChannel = $channel ?: $chaCode;
        $template_id = '';
        if (empty($realChannel)) { //FIXME DEL
           $realChannel = 100001;
            if($req->url){
                $url = urldecode($req->url);
                $param = substr($url,strpos($url,'?')+1);
                if(strpos($param,'&') !== false){
                    $paramArr = explode('&',$param);
                    $param = $paramArr[0];
                    //
                    $template = $paramArr[1];
                    $templateArr = explode('=',$template);
                    $template_id = $templateArr[1];
                }
                $paramArrs = explode('=',$param);
//                dd($paramArrs);
                $realChannel = $paramArrs[1];

            }
            if($req->template_id){
                $template_id = $req->template_id;
            }
        }

        /*if(empty($source)) {
            if($realChannel > 200000 && $realChannel < 300000) {
                $source = 'iOS';
            }
        }*/

        $req->headers->set("Source", strtolower($source), true);

//        if($source == 'ios' && $realChannel == "100001") {
//            $realChannel = 200001;
//        }
        $req->headers->set("Channel", $realChannel, true);
        $req->headers->set("CHA-CODE", $realChannel, true);
        $req->headers->set("template_id",$template_id,true);
        return $req;
    }


}