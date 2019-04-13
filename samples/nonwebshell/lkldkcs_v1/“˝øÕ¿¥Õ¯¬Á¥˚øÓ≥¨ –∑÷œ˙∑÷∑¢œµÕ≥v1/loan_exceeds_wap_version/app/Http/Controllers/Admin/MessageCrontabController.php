<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\PushMessage;
use App\Models\Apply;
use App\Models\MessageCrontab;
use App\Models\MessageCrontabFirst;
use App\Models\MessageCrontabRule;
use App\Models\MessageCrontabSendRecord;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class MessageCrontabController extends Controller
{

    public  function  checkError()
    {
        $time = date("Y-m-d H:i:00", strtotime("-1 hour"));
        $list  = MessageCrontab::where('created_at','>=',$time)->get();
        foreach ( $list as $key =>$item){
            $rule =  MessageCrontabRule::find($item->send_type);
            $info = $this->judgeTime($rule);
            $info['times'] = date('Y-m-d H:i:00',strtotime($info['times'])+3600);
            if($info['type'] == 1) { return 'over';}
            if($item->send_type < 5)
            {
                $record_list = MessageCrontabFirst::where('created_at','<',$info['times'])->with(['user','apps'])->get();
            }else{
                $record_list = MessageCrontabFirst::where('updated_at','<',$info['times'])->with(['user','apps'])->get();
            }
            if(count($record_list) > 0)
            {
                $this->listDeal($record_list,$item->id,$item->send_type);
            }else{
                continue;
            }
        }
    }

        public function  listDeal($list,$msg_id,$type)
        {
            $product = $this->getProductId($type);
            foreach ($list as $k=>$v)
            {
                if(MessageCrontabSendRecord::where(['identifier'=>$v->identifier,'type'=>$type])->first())
                {
                    unset($list[$k]);
                    continue;
                }
                if($type ==1  || $type == 2)
                {
                    if($v->user)
                    {
                        unset($list[$k]);
                        continue;
                    }
                    $list[$k]->login_product_id = 0;
                    $list[$k]->no_login_product_id = $product;
                }else{
                    if(!$v->user)
                    {
                        unset($list[$k]);
                        continue;
                    }else{
                        $v->mid ? $mid=$v->mid : $mid=$v->user->id;
                        $apply_num= Apply::where('mid',$mid)->count();
                        if(($apply_num > 0 && $type == 3) || ($apply_num > 3 && $type == 4))
                        {
                            unset($list[$k]);
                            continue;
                        }
                        if($apply_num)
                        {
                            $apply_ids =  Apply::where('mid',$mid)->get(['product_id'])->toArray();
                            $ids = array_column($apply_ids, 'product_id');
                            $login_product = Product::where('status',1)->whereNotIn('id',$ids)->orderByRaw("RAND()")->first(['id'])->id;
                        }else{
                            $login_product =$product;
                        }
                        $list[$k]->login_product_id = $login_product;
                        $list[$k]->no_login_product_id = $product;
                    }
                }
                if(count($list)>0){
                    $this->toPushCronMsg($list,$msg_id,$type);
                    //更改发送状态
                    MessageCrontab::where('id',$msg_id)->update(['status'=>1]);
                }
            }
        }
    /**
     * 描述：激活未注册
     * @param $type      int         1=>10分钟,2=>24小时
     */
    public  function  notRegister($type)
    {

        $rule =  MessageCrontabRule::find($type);
        $info = $this->judgeTime($rule);
        if($info['type'] == 1) { return 'over';}
        Log::info('--定时推送激活未注册执行时间'.date('Y-m-d H:i:s',time()).'类型：'.$type);
        $times = $info['times'];
        $product = $this->getProductId($type);
        //查询满足条件的记录(看需不需要进行优化通过mid来判断(会出现不进首页漏记录情况))
        $list = MessageCrontabFirst::where('created_at','<',$times)->with(['user','apps'])->get();
        if(count($list) > 0)
        {
            //按条件筛选记录
            foreach ($list as $key =>$val)
            {
                if($val->user)
                {
                    unset($list[$key]);
                    continue;
                }
                if(MessageCrontabSendRecord::where(['identifier'=>$val->identifier,'type'=>$type])->first())
                {
                    unset($list[$key]);
                    continue;
                }
                $list[$key]->login_product_id = 0;
                $list[$key]->no_login_product_id = $product;
            }
            //有数据的时候调用极光
            if(count($list) > 0){
                $msg_add_result = $this->insertMsgCrontab($rule,$type);
                if($msg_add_result)
                {
                    //执行极光推送
                    $this->toPushCronMsg($list,$msg_add_result->id,$type);
                    //更改发送状态
                    MessageCrontab::where('id',$msg_add_result->id)->update(['status'=>1]);
                }
            }
        }
        return 'over';
    }
    /**
     * 描述：申请转化 和 用户流失
     * @param $type  int   3=>10分钟未申请,4=>60分钟内申请小于等于3次,5=>流失1天,6=>流失2天,7=>流失7天
     */
    public  function  noApplyOrLoss($type)
    {
        if($type < 3 ){ return 'over';}
        $rule =  MessageCrontabRule::find($type);
        $info = $this->judgeTime($rule);
        if($info['type'] == 1) { return 'over';}
        Log::info('--定时推送申请转化和用户流失执行时间'.date('Y-m-d H:i:s',time()).'类型：'.$type);
        $times = $info['times'];
        //查询满足条件的记录(看需不需要进行优化通过mid来判断(会出现不进首页漏记录情况))
        if($type == 3 || $type == 4)
        {
            $list = MessageCrontabFirst::where('created_at','<',$times)->with(['user','apps'])->get();
        }else{
            $list = MessageCrontabFirst::where('updated_at','<',$times)->with(['user','apps'])->get();//->whereHas('user',function ($query){ $query->orderBy('id','desc');})
        }
        if(count($list) > 0)
        {
            //筛选满足条件数据
            $product = $this->getProductId($type);
            foreach ($list as $key =>$val){
                if(!$val->user)
                {
                    unset($list[$key]);
                    continue;
                }
                if(MessageCrontabSendRecord::where(['identifier'=>$val->identifier,'type'=>$type])->first())
                {
                    unset($list[$key]);
                    continue;
                }
                $val->mid ? $mid=$val->mid : $mid=$val->user->id;
                $apply_num= Apply::where('mid',$mid)->count();
                if(($apply_num > 0 && $type == 3) || ($apply_num > 3 && $type == 4))
                {
                    unset($list[$key]);
                    continue;
                }
                if($apply_num)
                {
                    $apply_ids =  Apply::where('mid',$mid)->get(['product_id'])->toArray();
                    $ids = array_column($apply_ids, 'product_id');
                    $login_product = Product::where('status',1)->whereNotIn('id',$ids)->orderByRaw("RAND()")->first(['id'])->id;
                }else{
                    $login_product =$product;
                }
                $list[$key]->login_product_id = $login_product;
                $list[$key]->no_login_product_id = $product;
            }
            //有数据的时候调用极光
            if(count($list) > 0){
                $msg_add_result = $this->insertMsgCrontab($rule,$type);
                if($msg_add_result)
                {
                    //极光推送
                    $this->toPushCronMsg($list,$msg_add_result->id,$type);
                    //更改发送状态
                    MessageCrontab::where('id',$msg_add_result->id)->update(['status'=>1]);
                }
            }
        }
        return 'over';
    }
    /**
     * 根据当前时间和类型生成时间查询条件
     * @param $rule
     * @return array
     */
    public  function judgeTime($rule)
    {
        $type  = 0;
        //根据单位算出时间
        if($rule->unti == 2)
        {
            $times = time() - (3600 * $rule->length_time);
        }else{
            $times = time() - (60 * $rule->length_time);
        }
        //存在22-9点期间的则第二天九点的时候需要延长时间
        $times = date("Y-m-d H:i:00",$times);
        $hour = date("H",time());
        if($rule->stop_send_start && $rule->stop_send_end)
        {
            if($hour == $rule->stop_send_end)
            {
                //当时间是开始发送的时间需要把之前没有推送的记录也要处理
                $hour_time =3600 * (24 - $rule->stop_send_start + $rule->stop_send_end);
                $times = date('Y-m-d H:i:00',strtotime($times)-$hour_time);
            }elseif(($hour >= $rule->stop_send_start) || ($hour < $rule->stop_send_end)){
                $type  = 1;
            }
        }
        return ['times'=>$times,'type'=>$type];
    }
    /**
     * 描述：生成任务记录
     * @param $rule
     * @param $product_id
     * @param $send_type
     * @param $login_product
     * @return mixed
     */
    public  function  insertMsgCrontab($rule,$send_type)
    {
        $data = [
          'title'=>$rule->title,
          'content'=>$rule->content,
          'send_type'=>$send_type,
          'redirect_type'=>'productDetail',
        ];
        return MessageCrontab::create($data);
    }
    /**
     * 描述：执行推送处理
     * @param $list     要执行推送的记录
     * @param $id  推送任务信息
     * @param $type  推送任务信息
     */
    public  function toPushCronMsg($list,$id,$type)
    {
        foreach ($list as $k =>$v)
        {
            //首先判断是否已经发送过了
             $recodes =  MessageCrontabSendRecord::where(['identifier'=>$v->identifier,'type'=>$type])->first();
             if(!$recodes)
             {
                 //生成一条极光送达记录和点击记录
                 $cron_record =[
                   'message_id'=>$id,
                   'identifier'=>$v->identifier,
                   'type'=>$type,
                   'mid'=> isset($v->user->id) ? $v->user->id:'',
                   'login_product_id'=>$v->login_product_id,
                   'no_login_product_id'=>$v->no_login_product_id
                 ];
                  $record = MessageCrontabSendRecord::create($cron_record);
                 //发起调用极光推送
                 /*Log::info('---push_id---'. $v->push_id);*/
                 $config = $v->apps->jpush_config;
                 if ($config &&  $v->push_id) {
                    /* Log::info('---config---' . $config);
                     Log::info('---push_id---' .  $v->push_id);*/
                      $job = new PushMessage(['config' => $config], $id, $v->identifier, 'cron_tab', $v->push_id,$record->id);
                      $this->dispatchNow($job);
                 }
             }
        }
    }
    /**
     * 描述：获取商品的id
     * @param $type
     * @return mixed
     */
    public function  getProductId($type)
    {
        if($type == 2)
        {
            $products = Product::where('status',1)->orderBy('sort','desc')->limit(2)->get(['id']);
            $product = $products[1]->id;
            unset($products);
        }else{
            $product = Product::where('status',1)->orderBy('sort','desc')->first(['id'])->id;
        }
       return $product;
    }

    //后台定时任务列表
    public function  index()
    {
        return view('admin.messageCrontab.index');
    }
    public  function  data(Request $request,MessageCrontab $message)
    {
        $message = $message->query();
        if($request->create_start){
            $message = $message->where('created_at','>=',$request->create_start);
        }
        if($request->create_end){
            $message = $message->where('created_at','<',$request->create_end);
        }
        if($request->body){
            $message = $message->where('content','like',"%$request->body%");
        }
        $data = $message->with(['send_record'])
          ->orderBy('id','desc')
          ->paginate($request->get('limit',$this->pageSize))
          ->toArray();

        foreach ($data['data'] as $key =>$val)
        {
            $send_num = 0;
            $click_num= 0;
            if(isset($val['send_record'])){
                $send_num = count($val['send_record']);
                foreach ($val['send_record'] as $k=>$v)
                {
                    if($v['is_clicked'] == 1)
                    {
                        $click_num +=1;
                    }
                }
            }
            $data['data'][$key]['send_num'] = $send_num;
            $data['data'][$key]['click_num'] =$click_num;

        }
//        $log = DB::getQueryLog();
//        dd($log);
//        dd(count($data));
        $data = [
          'code' => 0,
          'msg'   => '正在请求中...',
          'count' => $data['total'],
          'data'  => $data['data']
        ];
        return response()->json($data);
    }

   /* public  function  edit($id)
    {
        $msg_info = MessageCrontab::with(['']);
    }*/
}
