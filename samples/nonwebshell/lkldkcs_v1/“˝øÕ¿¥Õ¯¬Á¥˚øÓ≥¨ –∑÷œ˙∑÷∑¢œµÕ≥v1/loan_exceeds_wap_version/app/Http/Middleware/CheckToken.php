<?php

namespace App\Http\Middleware;

use App\Models\Member;
use App\Models\TokenDevice;
use Closure;
use Illuminate\Support\Facades\Redis;

class CheckToken
{
    /**
     * @param $request
     * @param Closure $next
     * @return array|mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->authentication && $request->identifier && Redis::exists('token:'.$request->identifier)){
            //检查token
            $result = Redis::get('token:'.$request->identifier);
            if(json_decode($result,true)['token'] == $request->authentication){
                //TODO::用户登录信息关联
                $is_login = Member::where(['remember_token'=>$request->authentication])
                    ->first(['id']);
                if($is_login){
                    $request->merge([
                        'uid'=>$is_login->id
                    ]);
                    return $next($request);
                }
                return $next($request);
            }else{
                return ['code'=>4001,'info'=>'token认证失败','data'=>null];
            }
        }else{
            return ['code'=>4001,'info'=>'token认证失败','data'=>null];
        }
    }
}
