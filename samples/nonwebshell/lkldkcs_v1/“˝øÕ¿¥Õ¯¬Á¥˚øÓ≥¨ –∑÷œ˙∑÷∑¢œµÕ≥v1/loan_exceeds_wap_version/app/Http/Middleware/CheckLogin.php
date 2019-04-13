<?php

namespace App\Http\Middleware;

use App\Models\Member;
use Closure;
use Illuminate\Support\Facades\Redis;

class CheckLogin
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
        if($request->identifier && $request->authentication && Redis::get('token:'.$request->identifier)){
            //判断登录
            $user = Member::where(['remember_token'=>$request->authentication])->first();
            if ($user){
                $token = Redis::get('token:'.$request->identifier);
                $uid = json_decode($token,true)['uid'];
                if($user->id == $uid){//已登录
                    $request->merge([
                        'uid'=>$uid
                    ]);
                    return $next($request);
                }else{
                    return ['code'=>4002,'info'=>'请登录','data'=>null];
                }
            }else{
                return ['code'=>4002,'info'=>'请登录','data'=>null];
            }
        }else{
            return ['code'=>4001,'info'=>'token失效','data'=>null];
        }
    }
}
