<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $response = $next($request);
        $response->headers->add([
            'Access-Control-Allow-Origin'=>'*',
            'Access-Control-Allow-Headers'=>'Origin, Content-Type, Cookie, Accept, Authentication, Source, Channel, Device, System, Version, Push, PageId',//请求头: Origin, Content-Type, Cookie, Accept|token|平台|渠道码|设备码|操作版本|app版本|极光设备id
            'Access-Control-Allow-Methods'=>'GET, POST, PATCH, PUT, OPTIONS',
            'Access-Control-Allow-Credentials'=>'false',
            'Access-Control-Max-Age'=>3600,
//            'X-Frame-OPTIONS'=>'deny',
//            'Content-Type' => 'multipart/form-data, application/json'
        ]);
        return $response;
    }
}
