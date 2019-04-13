<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WhiteListController extends BaseController
{
    /**
     * 添加 电话/渠道 白名单
     * @param Request $request
     * @return array
     */
    public function setWhite(Request $request)
    {
        $phone = $request->phones;
        $channel = $request->channels;
        $type = $request->type;
        if (empty($phone) && empty($channel) && empty($type)){
            $this->set('type',$this->badRequest);
            $this->set('info','请传入请求参数:phones/channels/type');
        }else{
            if (!empty($phone)){
                $redis_key = 'phone_white_list';
                $redis_value = $phone;
                $info = '电话';
            }else{
                $redis_key = 'channel_white_list';
                $redis_value = $channel;
                $info = '渠道';
            };
            //接收到的手机号去重
            $redis_value_arr = array_unique(explode(',',$redis_value));
            $exists = json_decode(Redis::get($redis_key),true);
            if ( Redis::exists($redis_key)){
                if ($type == 'set'){
                    foreach ($redis_value_arr as $k=>$item){
                        if (in_array($item,$exists)){
                            unset($redis_value_arr[$k]);//去重
                        }
                    }
                    foreach($redis_value_arr as $item){
                        array_push($exists,$item);
                        Redis::set($redis_key,json_encode($exists));
                    }
                    $this->set('info',"插入{$info}白名单成功");
                    $this->set('data',json_decode(Redis::get($redis_key)));
                }elseif ($type == 'reduce'){//减少
                    foreach($redis_value_arr as $value){
                        if (in_array($value,$exists)){
                            foreach($exists as $k=>$exist){
                                if ($exists[$k] == $value){
                                    unset($exists[$k]);
                                    Redis::set($redis_key,json_encode(explode(',',implode(',',$exists))));
                                }
                            }
                        }else{
                            throw new BadRequestHttpException("{$info}不存在于白名单中");
                        }
                    }
                    $this->set('info',"减少{$info}白名单成功");
                    $this->set('data',json_decode(Redis::get($redis_key)));
                }elseif ($type == 'del'){//清空
                    Redis::del($redis_key);
                    $this->set('info',"清空{$info}白名单成功");
                    $this->set('data',json_decode(Redis::get($redis_key)));
                }else{//获取
                    $redis_values = json_decode(Redis::get($redis_key));
                    foreach($redis_value_arr as $v){
                        if (!in_array($v,$redis_values)){
                            $this->set('info',$v."不存在{$info}白名单中");
                            $this->set('data',json_decode(Redis::get($redis_key)));
                        }else{
                            $this->set('info',$v."存在{$info}白名单中");
                            $this->set('data',json_decode(Redis::get($redis_key)));
                        }
                    }
                }
            }else{//添加第一条
                if ($type != 'set'){
                    $this->set('info',"redis键不存在,请先添加");
                }else{
                    Redis::set($redis_key,json_encode($redis_value_arr));
                    $this->set('info',"添加成功");
                    $this->set('data',json_decode(Redis::get($redis_key)));
                }
            }
        }
        return $this->jsonResponse();
    }

}
