<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-11-23
 * Time: 10:04
 */

namespace App\Traits;


use App\Models\BehaviorLog;
use App\Models\Channel;


trait LoginBehavior
{
    public function loginBehavior($request,$member)
    {
        $behavior_log = new BehaviorLog();

        /*操作类型*/
        if ($request->path() == 'api/v1/register/aes'){//注册
            $operate_type = 1;
        }
        elseif($request->path() == 'api/v1/login/aes' || $request->path() == 'api/v1/verify/login/aes'){//登录|快捷登录
            $operate_type = 2;
        }
        elseif ($request->path() == 'api/v1/register'){//注册,非加密
            $operate_type = 11;
        }
        elseif($request->path() == 'api/v1/login' || $request->path() == 'api/v1/verify/login'){//登录|快捷登录,非加密
            $operate_type = 22;
        }
        else{//操作失败
            $operate_type = 103;
        }

    }
}