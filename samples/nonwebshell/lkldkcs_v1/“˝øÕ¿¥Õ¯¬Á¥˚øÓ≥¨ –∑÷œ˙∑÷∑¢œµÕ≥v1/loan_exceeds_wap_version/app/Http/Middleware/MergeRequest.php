<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Log;

class MergeRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ip = $request->getClientIp();//用户操作IP地址
        $identifier = $request->header('Device')?:'';//用户注册设备码
        $system_version = $request->header('System')?:'';//用户操作系统版本
        $channel_code = $request->header('Channel')?:0;//用户操作渠道码
        $platform = $request->header('Source')?:$this->browser();//用户操作渠道码
        $app_version = $request->header('Version')?:'';//用户操作渠道码
        $authentication = $request->header('Authentication');//token
        $push = $request->header('Push')?:'';//极光设备id
        $package = $request->header('package')?:'';//极光设备id
        $page_id = $request->header('PageId')?:0;
        $norm = $request->header('Norm')?:0;

        //请求参数添加
        $request->merge([
            'identifier'=>$identifier,
            'system'=>$system_version,
            'ip'=>$ip,
            'channel'=>$channel_code,
            'platform'=>$platform,
            'version'=>$app_version,
            'authentication'=>$authentication,
            'push'=>$push,
            'package'=>$package,
            'page_id'=>$page_id,
            'norm'=>$norm
        ]);
        return $next($request);
    }

    public function browser(){
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            return 'ios';
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            return 'android';
        }else{
            return  'pc';
        }
    }
}
