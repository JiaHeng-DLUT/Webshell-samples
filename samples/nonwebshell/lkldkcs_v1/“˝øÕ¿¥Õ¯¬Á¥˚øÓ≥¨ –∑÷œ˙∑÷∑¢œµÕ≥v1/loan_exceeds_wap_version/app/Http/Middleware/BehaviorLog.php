<?php

namespace App\Http\Middleware;

use App\Models\Channel;
use App\Models\Credit;
use App\Models\Member;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductColumn;
use Closure;
use Illuminate\Support\Facades\Log;

class BehaviorLog
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
        $behavior_log = new \App\Models\BehaviorLog();
        $member = Member::where('id',$request->uid)->first();
        if ($member){
            /*注册渠道*/
            $register_channel = Channel::where('channel_code',$member->channel_code)->first();
            if ($register_channel){
                $register_channel_id = $register_channel->id;
                $register_channel_name = $register_channel->channel_name;
            }else{
                $register_channel_id = 0;
                $register_channel_name = '';
            }


            /*操作参数*/
            $operate_param = null;
            /*访问来源*/
            $from = $request->input('from','other');
            $column_name = '';
            if ($from == 'banner'){
                $source = 'Banner';
            }elseif ($from == 'loanlist'){
                $source = 'Tab-贷款列表';
            }elseif ($from == 'push'){
                $source = 'Push';
            }elseif ($from == 'column'){
                $column_id = $request->input('t');
                $column = ProductColumn::where('id',$column_id)->first();
                if ($column){
                    $column_name = $column->name;
                }
                $source = $column_name.'栏目';
            }elseif ($from == 'like'){
                $source = '猜你喜欢';
            }elseif ($from == 'creditlist'){
                $source = 'Tab-信用卡列表';
            }else{
                $source = '其他';
            }
            /*操作类型*/
//            if ($request->path() == 'api/v1/register'){//注册
            if ($request->path() == 'api/v1/register/aes'){//注册
                $operate_type = 1;
            }
//            elseif($request->path() == 'api/v1/login' || $request->path() == 'api/v1/verify/login'){//登录|快捷登录
            elseif($request->path() == 'api/v1/login/aes' || $request->path() == 'api/v1/verify/login/aes'){//登录|快捷登录
                $operate_type = 2;
            }
            elseif($request->path() == 'api/v1/home'){//启动
                if ($request->platform == 'wap'){
                    return $next($request);
                }else{
                    $operate_type = 3;
                }
            }
            elseif(preg_match('/^api\/v1\/loan\/\d+$/',$request->path())){//产品详情
                $operate_type = 4;
                $product = Product::where('id',$request->id)->first();
                $name = '';
                if ($product){
                    $name = $product->name;
                }
                $operate_param  = [
                    'id'=>$request->id,
                    'name'=>$name?:'',
                    'from'=>$source,
                ];
            }
            elseif(preg_match('/^api\/v1\/credit\/\d+$/',$request->path())){//信用卡详情
                $operate_type = 7;
                $credit = Credit::where('id',$request->id)->first();
                $name = '';
                if ($credit){
                    $name = $credit->name;
                }
                $operate_param  = [
                    'id'=>$request->id,
                    'name'=>$name?:'',
                    'from'=>$source
                ];
            }
            elseif($request->path() == 'api/v1/apply'){
               $param = $request->all();
               if($param){
                   if (empty($param['type'])){
                       return ['code'=>4000,'info'=>'请传入操作类型','data'=>null];
                   }else{
                       if ($param['type'] == 'product'){//申请产品
                           $operate_type = 5;
                           $product = Product::where('id',$request->apply_id)->first();
                           $name = '';
                           if ($product){
                               $name = $product->name;
                           }
                           $operate_param  = [
                               'id'=>$request->apply_id,
                               'name'=>$name?:'',
                           ];
                       }
                       elseif($param['type'] == 'credit'){//申请信用卡
                           $operate_type = 8;
                           $credit = Credit::where('id',$request->apply_id)->first();
                           $name = '';
                           if ($credit){
                               $name = $credit->name;
                           }
                           $operate_param  = [
                               'id'=>$request->apply_id,
                               'name'=>$name?:'',
                           ];

                       }else{
                           $operate_type = 100;
                       }
                   }
               }else{
                   $operate_type = 101;
               }
            }
            elseif(preg_match('/^api\/v1\/home\/\d+$/',$request->path())){//查看产品分类
                $operate_type = 6;
                $product_category = ProductCategory::where('id',$request->id)->first();
                $name = '';
                if ($product_category){
                    $name = $product_category->name;
                }
                $operate_param  = [
                    'id'=>$request->id,
                    'name'=>$name,
                ];
            }
            else{//其他操作,不记录日志
                return $next($request);
            }
            $behavior_log->phone = $member->phone?:'';
            $behavior_log->register_channel_id = $register_channel_id;
            $behavior_log->register_channel_name = $register_channel_name;
            $behavior_log->register_page_id = $member->page_id;
            $behavior_log->register_page_name = $register_page_name;
            $behavior_log->operate_type = $operate_type;
            $behavior_log->operate_channel_id = $operate_channel_id;
            $behavior_log->operate_channel_name = $operate_channel_name;
            $behavior_log->operate_platform = $request->platform?:'';
            $behavior_log->operate_page_id = $request->page_id?:0;
            $behavior_log->operate_page_name = $operate_page_name;
            $behavior_log->operate_params = $operate_param?:null;
            $behavior_log->save();
        }
        return $next($request);
    }
}
