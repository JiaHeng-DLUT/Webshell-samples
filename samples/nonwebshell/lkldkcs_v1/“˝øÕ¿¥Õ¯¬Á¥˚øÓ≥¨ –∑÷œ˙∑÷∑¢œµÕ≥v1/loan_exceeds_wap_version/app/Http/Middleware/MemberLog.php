<?php

namespace App\Http\Middleware;

use App\Models\AccessApp;
use App\Models\AccessChannel;
use App\Models\AccessProduct;
use App\Models\Application;
use App\Models\Credit;
use App\Models\Device;
use App\Models\Product;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class MemberLog
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
        if(!preg_match('/^api\/v1\/home\/count$/',$request->path())) {
            $member_log = new \App\Models\MemberLog();
            $member_log->mid = $request->uid ?: 0;
            $member_log->identifier = $request->identifier ?: '';
//        $member_log->user_agent = $_SERVER['HTTP_USER_AGENT']?:'';
            $member_log->user_agent = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : $request->userAgent();
            $member_log->ip = $request->getClientIp() ?: '';
            $member_log->method = $request->method() ?: '';
            $member_log->route = $request->path() ?: '';//$request->route()->getAction()
            $member_log->params = json_encode($request->all()) ?: '';
            $member_log->channel_code = $request->channel ?: '';
            $member_log->platform = $request->platform ?: '';
            $member_log->page_id = $request->page_id ?: 0;
            $member_log->save();
        }
        /*Redis::flushall();
        dd('o');*/
        //判断路由
        //产品详情调用产品统计
        //api/v1/loan/1
        if(preg_match('/^api\/v1\/loan\/\d+$/',$request->path())){
//            dump($request->input());
            preg_match('/^api\/v1\/loan\/(\d+)/',$request->path(),$all);
            $loan_id = $all[1];
            $loan_exist = Product::where(['id'=>$loan_id])->first();
            if($loan_exist){
                $this->product($request,$loan_id,'loan');
            }
        }
        //信用卡
        if(preg_match('/^api\/v1\/credit\/\d+$/',$request->path())){
//            dump($request->input());
            preg_match('/^api\/v1\/credit\/(\d+)/',$request->path(),$all);
            $loan_id = $all[1];
            $loan_exist = Credit::where(['id'=>$loan_id])->first();
            if($loan_exist){
                $this->product($request,$loan_id,'credit');
            }
        }
        /*************************/
//        dump(Redis::scard('set1'));//返回个数
//        dump(Redis::sismember('set1','ff'));//查询是否存在于集合中
//        dump(Redis::smembers('set1'));//返回全部成员
//        //hash:存当前记录数据
//        dump(Redis::hincrby('hash1', 'key5', 3));//哈希：不存在直接创建一个
//        dump(Redis::hincrby('hash1', 'key3', 3));//哈希：不存在直接创建一个
//        dump(Redis::hgetall('hash1'));
        /*************************/
        //首页，产品，发现，调用app统计
        ///api/v1/home
        ///api/v1/loan
        ///api/v1/article
        ///api/v1/credit
        ///api/v1/login
        ///api/v1/verify/login//快捷登录
        ///api/v1/register
        ///api/v1/feedback/cate//反馈页面
        ///api/v1/about
        ///api/v1/about
        //api/v1/circle//贷贷狐圈子
        //api/v1/help//新手帮助
        //api/v1/collection/product//收藏产品
        //api/v1/collection/credit//收藏信用卡
        //api/v1/comment/product/id/?
        //api/v1/comment/credit/id/?
        //api/v1/product/apply//产品申请
        //api/v1/apply/credit//信用卡申请
        //api/v1/logout//退出登录
        //api/v1/message//系统消息
        //api/v1/message/4//系统消息详情
        //api/v1/apply//申请产品
        if(in_array($request->path(),['api/v1/loan','api/v1/article','api/v1/credit','api/v1/login/aes','api/v1/verify/login/aes','api/v1/register/aes','api/v1/feedback/cate','api/v1/about','api/v1/circle','api/v1/help','api/v1/collection/product','api/v1/collection/credit','api/v1/product/apply','api/v1/apply/credit','api/v1/logout','api/v1/collection/article','api/v1/apply','api/v1/message','/api/v1/agreement'])||preg_match('/^api\/v1\/loan\/\d+/',$request->path())||preg_match('/^api\/v1\/credit\/\d/',$request->path())||preg_match('/^api\/v1\/article\/\d/',$request->path())||preg_match('/^api\/v1\/message\/\d+/',$request->path())||preg_match('/^api\/v1\/comment\/product\/\d+/',$request->path())||preg_match('/^api\/v1\/comment\/credit\/\d+/',$request->path())||preg_match('/^api\/v1\/page\/\d+/',$request->path())||preg_match('/^api\/v1\/home$/',$request->path())){
            if(preg_match('/^api\/v1\/home$/',$request->path())){
                $path = 'home';//首页列表
            }elseif($request->path() == 'api/v1/loan'){
                $path = 'product';//贷款产品列表
            }elseif($request->path() == 'api/v1/credit'){
                $path = 'credit';//信用卡列表
            }elseif($request->path() == 'api/v1/article'){
                $path = 'article';//文章列表
            }elseif($request->path() == 'api/v1/login/aes'){
                $path = 'login';//密码登录
            }elseif($request->path() == 'api/v1/verify/login/aes'){
                $path = 'verifyLogin';//快捷登录
            }elseif($request->path() == 'api/v1/register/aes'){
                $path = 'register';//注册
            }elseif($request->path() == 'api/v1/feedback/cate'){
                $path = 'feedback';//反馈页面
            }elseif($request->path() == 'api/v1/about'){
                $path = 'about';//关于我们
            }elseif($request->path() == 'api/v1/circle'){
                $path = 'circle';//圈子
            }elseif($request->path() == 'api/v1/help'){
                $path = 'help';//帮助
            }elseif($request->path() == 'api/v1/collection/product'){
                $path = 'collectionProduct';//收藏产品
            }elseif($request->path() == 'api/v1/collection/credit'){
                $path = 'collectionCredit';//收藏信用卡
            }elseif($request->path() == 'api/v1/collection/article'){
                $path = 'collectionArticle';//收藏文章
            }elseif($request->path() == 'api/v1/message'){
                $path = 'message';//消息列表
            }elseif($request->path() == '/api/v1/agreement'){
                $path = 'agreement';//注册协议
            }elseif(preg_match('/^api\/v1\/article\/\d+$/',$request->path())){
                $path = 'articleDetail';//文章详情
            }elseif(preg_match('/^api\/v1\/loan\/\d+$/',$request->path())){
                $path = 'loanDetail';//贷款产品详情
            }elseif(preg_match('/^api\/v1\/credit\/\d+$/',$request->path())){
                $path = 'creditDetail';//信用卡详情
            }elseif(preg_match('/^api\/v1\/message\/\d+$/',$request->path())){
                $path = 'messageDetail';//系统消息详情
            }elseif(preg_match('/^api\/v1\/comment\/product\/\d+$/',$request->path())){
                $path = 'productComment';//产品评论列表
            }elseif(preg_match('/^api\/v1\/comment\/product\/\d+\/good/',$request->path())){
                $path = 'productCommentGood';//产品评论列表：好评
            }elseif(preg_match('/^api\/v1\/comment\/product\/\d+\/bad/',$request->path())){
                $path = 'productCommentBad';//产品评论列表:差评
            }elseif(preg_match('/^api\/v1\/comment\/credit\/\d+$/',$request->path())){
                $path = 'creditComment';//信用卡评论列表
            }elseif(preg_match('/^api\/v1\/comment\/credit\/\d+\/good/',$request->path())){
                $path = 'creditCommentGood';//信用卡评论列表:好评
            }elseif(preg_match('/^api\/v1\/comment\/credit\/\d+\/bad/',$request->path())){
                $path = 'creditCommentBad';//信用卡评论列表:差评
            }else{
                $path = 'apply';//申请产品
            }

        }
        return $next($request);
    }

    /**
     * @param $request
     * 产品统计
     */
    public function product($request,$loan_id,$type)
    {
       $ip = $request->getClientIp();
        //设备去重：
        $platform = $request->platform?:'';
        $channel_code = $request->channel ?:0;
        $page_id = $request->page_id ?:0;
        $product_basic_key = 'statics:device:' . date('Y-m-d') . ":product:platform_" . $platform . ":";
        $device = $request->identifier;//设备码
        //TODO::产品统计
        //产品统计key
        $product_id = $loan_id;
        if ($product_id) {
            $device_product_key = $product_basic_key . '_product_'. $type . $product_id . '_channel_code_' . $channel_code . '_page_id_:' . $page_id;//产品，渠道，分发页：
            $device_product_key_device = $product_basic_key . '_product_' . $type . $product_id . '_channel_code_' . $channel_code . '_device';//产品，渠道，分发页：
            if (Redis::sismember($device_product_key_device, $device) ) {//如果设备id存在于集合中，今天不记录uv,pv+1,
                if(Redis::sismember($device_product_key_device, 'page_id_'.$page_id)) {//如果该分发页非第一次访问，只加pv
                    Redis::hincrby($device_product_key, 'pv', 1);//hash储存
                }else{//如果该分发页非第一次访问，只加pv
                    Redis::hincrby($device_product_key, 'pv', 1);
                    Redis::hincrby($device_product_key, 'uv', 0);
                    Redis::hincrby($device_product_key, 'ip', 0);
                    Redis::sadd($device_product_key_device, 'page_id_'.$page_id);
                }
            } else {//如果设备id不存在于集合中，今天不在记录uv+1,pv+1,
                Redis::hincrby($device_product_key, 'pv', 1);
                Redis::hincrby($device_product_key, 'uv', 1);
                Redis::hincrby($device_product_key, 'ip', 1);
                Redis::sadd($device_product_key_device, $device);
                Redis::sadd($device_product_key_device, $ip);
                Redis::sadd($device_product_key_device, 'page_id_'.$page_id);
            }
            if (!Redis::sismember($device_product_key_device, $ip)) {//如果ip存在于集合中，今天不+ip
                Redis::hincrby($device_product_key, 'ip', 1);
                Redis::sadd($device_product_key_device, $ip);
            }
            $data = Redis::hgetall($device_product_key);
            $today = date('Y-m-d',time());//今日时间
            $query = AccessProduct::where(['platform' => $platform, 'channel_code' => $channel_code, 'product_id' => $product_id, 'today' => $today,'page_id'=>$page_id]);
            if($type == 'loan'){
                $query = $query->where(['product_id'=>$product_id]);
            }else{
                $query = $query->where(['credit_id'=>$product_id]);
            }
            $product_statistics = $query ->first();
            if (!$product_statistics) {
                $product_statistics = new AccessProduct();
            }
            $product_statistics->platform = $platform;
            $product_statistics->channel_code = $channel_code;
            if($type == 'loan') {
                $product_statistics->product_id = $product_id;
            }else{
                $product_statistics->credit_id = $product_id;
            }
            $product_statistics->today = $today;
            $product_statistics->pv = $data['pv'];
            $product_statistics->uv = $data['uv'];
            $product_statistics->ip = $data['ip'];
            $product_statistics->page_id = $page_id;
            $product_statistics->save();
        }
        return '1';
    }

    /**
     * @param Request $request
     * 渠道统计
     */
    public function channel($request,$page_id=0,$channel_code){
        $ip = $request->getClientIp();
        $today = date('Y-m-d',time());//今日时间
        //设备去重：
        $platform = $request->platform;
        $template_id = 0;


        $channel_basic_key = 'statics:device:' . date('Y-m-d',time()) . ":channel:platform_" . $platform . ":";//渠道统计
        $device = $request->identifier;//设备码
        if($channel_code){
            $device_channel_key = $channel_basic_key .  '_channel_code_' . $channel_code . '_page_id_:' . $page_id;//产品，渠道，分发页：
            $device_channel_key_device = $channel_basic_key  . '_channel_code_' . $channel_code . '_device';//产品，渠道，分发页：
            if (Redis::sismember($device_channel_key_device, $device) ) {//如果设备id存在于集合中，今天不记录uv,pv+1,
                if(Redis::sismember($device_channel_key_device, 'page_id_'.$page_id)) {//如果该分发页非第一次访问，只加pv
                    Redis::hincrby($device_channel_key, 'pv', 1);//hash储存
                }else{//如果该分发页非第一次访问，只加pv
                    Redis::hincrby($device_channel_key, 'pv', 1);
                    Redis::hincrby($device_channel_key, 'uv', 0);
                    Redis::hincrby($device_channel_key, 'ip', 0);
                    Redis::sadd($device_channel_key_device, 'page_id_'.$page_id);
                }
            } else {//如果设备id不存在于集合中，今天不在记录uv+1,pv+1,
                Redis::hincrby($device_channel_key, 'pv', 1);
                Redis::hincrby($device_channel_key, 'uv', 1);
                Redis::hincrby($device_channel_key, 'ip', 1);
                Redis::sadd($device_channel_key_device, $device);
                Redis::sadd($device_channel_key_device, $ip);
                Redis::sadd($device_channel_key_device, 'page_id_'.$page_id);
            }
            if (!Redis::sismember($device_channel_key_device, $ip)) {//如果ip存在于集合中，今天不+ip
                Redis::hincrby($device_channel_key, 'ip', 1);
                Redis::sadd($device_channel_key_device, $ip);
            }
            $data = Redis::hgetall($device_channel_key);
//            dump($data);
            //储存数据库
            $channel_statistics = AccessChannel::where(['channel_code'=>$channel_code,'platform'=>$platform,'template_id'=>$template_id,'page_id'=>$page_id,'today'=>$today])->first();
            if (!$channel_statistics) {
                $channel_statistics = new AccessChannel();
            }
            $channel_statistics -> platform = $platform;
            $channel_statistics -> channel_code = $channel_code;
            $channel_statistics -> template_id = $template_id;
            $channel_statistics -> page_id = $page_id;
            $channel_statistics -> pv = $data['pv'];
            $channel_statistics -> uv = $data['uv'];
            $channel_statistics -> ip = $data['ip'];
            $channel_statistics -> today = $today;
            $channel_statistics->save();
        }
        return '1';
    }

    /**
     * app 统计
     */
    public function apps($request,$path){//TODO::首页|产品|发现|信用卡
        $ip = $request->getClientIp();
        $platform = $request->platform;
        $channel_code = $request->channel ?: 0;
       /* if(in_array($platform,['ios','android']) && in_array($path,['home','product','article','credit','login','verifyLogin','register','feedback','about'])){//过滤掉wap*/
        if(in_array($platform,['ios','android'])){//过滤掉wap
            $app_basic_key = 'statics:device:' . date('Y-m-d') . ":app:platform_" . $platform . ":";//app统计
            $app_basic_statics = 'device:statics:app:platform_' . $platform . ":identifier";//app：激活记录：集合
            $device = $request->identifier;//设备码

            $device_app_key_path = $app_basic_key .  '_channel_code_' . $channel_code .'_slug_'.$path ;//产品，渠道，页面：

            $device_app_key_device_path = $app_basic_key .  '_channel_code_' . $channel_code.'_slug_'.$path.'_device';//产品，渠道，分发页：过滤到渠道
            //TODO::总汇统计-all：
            $device_app_key = $app_basic_key .  '_channel_code_' . $channel_code ;//产品，渠道：
            $device_app_key_device = $app_basic_key .  '_channel_code_' . $channel_code   .'_device';//产品，渠道，分发页：过滤到渠道
            $device_app_all = $app_basic_key .  '_channel_code_' . $channel_code .'_slug_all';
            //TODO::app总览统计
            if (Redis::sismember($device_app_key_device, $device)) {//如果设备id存在于集合中，今天不记录uv,pv+1,
                //all
                Redis::hincrby($device_app_all, 'pv', 1);
                Redis::hincrby($device_app_all, 'uv', 0);
                Redis::hincrby($device_app_all, 'ip', 0);
            } else {//如果设备id不存在于集合中，今天不在记录uv+1,pv+1,
                //all
                Redis::hincrby($device_app_all, 'pv', 1);
                Redis::hincrby($device_app_all, 'uv', 1);
                Redis::hincrby($device_app_all, 'ip', 1);
                Redis::sadd($device_app_key_device, $device);
                Redis::sadd($device_app_key_device, $ip);
            }
            if (!Redis::sismember($device_app_key_device, $ip)) {//如果ip存在于集合中，今天不+ip
                Redis::hincrby($device_app_key, 'ip', 1);
                Redis::sadd($device_app_key_device, $ip);
            }
            //TODO::页面pv,uv
            if (Redis::sismember($device_app_key_device_path, $device)) {//如果设备id存在于集合中，今天不记录uv,pv+1,
                Redis::hincrby($device_app_key_path, 'pv', 1);
                Redis::hincrby($device_app_key_path, 'uv', 0);
                Redis::hincrby($device_app_key_path, 'ip', 0);
            } else {//如果设备id不存在于集合中，今天不在记录uv+1,pv+1,
                Redis::hincrby($device_app_key_path, 'pv', 1);
                Redis::hincrby($device_app_key_path, 'uv', 1);
                Redis::hincrby($device_app_key_path, 'ip', 1);
                Redis::sadd($device_app_key_device_path, $device);
                Redis::sadd($device_app_key_device_path, $ip);
            }
            if (!Redis::sismember($device_app_key_device_path, $ip)) {//如果ip存在于集合中，今天不+ip
                Redis::hincrby($device_app_key_path, 'ip', 1);
                Redis::sadd($device_app_key_device_path, $ip);
            }
            $data = Redis::hgetall($device_app_key_path);
            $data_all = Redis::hgetall($device_app_all);//all
            //保存设备激活：
            //推送id：默认为空
            $push_id = $request->push;
            $app_id = 0;
            if($request->package){
                $app = Application::where(['name'=>$request->package])->first();
                $app_id = $app->id;
            }
            $device_name = '';
            $app_name = $request->package?:'';
            $user_agent = $_SERVER['HTTP_USER_AGENT']?:'';
            if(!Redis::sismember($app_basic_statics, $device)){//设备激活集合：记录不存在
                Redis::sadd($app_basic_statics,$device);//添加
                $exist = Device::where(['identifier'=>$device])->first();
                if(!$exist){//设备激活记录
                    Device::create(['channel_code'=>$channel_code,'platform'=>$platform,'identifier'=>$device,'app_version'=>$request->version,'system_version'=>$request->system,'app_id'=>$app_id,'push_id'=>$push_id,'device_name'=>$device_name,'app_name'=>$app_name,'user_agent'=>$user_agent]);
                }
            }else{
                $exist = Device::where(['identifier'=>$device])->first();
                if(!$exist){//设备激活记录
                    Device::create(['channel_code'=>$channel_code,'platform'=>$platform,'identifier'=>$device,'app_version'=>$request->version,'system_version'=>$request->system,'app_id'=>$app_id,'push_id'=>$push_id,'device_name'=>$device_name,'app_name'=>$app_name,'user_agent'=>$user_agent]);
                }
            }
            //TODO::判断接口路由
            $today = date('Y-m-d',time());//今日时间

            //app pv|uv|ip
            $access_statistics = AccessApp::where(['platform'=>$platform,'channel_code'=>$channel_code,'slug'=>$path,'today'=>$today])->first();
            if(!$access_statistics){
                $access_statistics = new AccessApp();
            }
            $access_statistics->platform = $platform;
            $access_statistics->channel_code = $channel_code;
            $access_statistics->slug = $path;
            $access_statistics->today = $today;
            $access_statistics->pv = $data['pv'];
            $access_statistics->uv = $data['uv'];
            $access_statistics->ip = $data['ip'];
            $access_statistics->save();
            //all
            $access_statistics_all = AccessApp::where(['platform'=>$platform,'channel_code'=>$channel_code,'slug'=>'all','today'=>$today])->first();
            if(!$access_statistics_all){
                $access_statistics_all = new AccessApp();
            }
            $access_statistics_all->platform = $platform;
            $access_statistics_all->channel_code = $channel_code;
            $access_statistics_all->slug = 'all';
            $access_statistics_all->today = $today;
            $access_statistics_all->pv = $data_all['pv'];
            $access_statistics_all->uv = $data_all['uv'];
            $access_statistics_all->ip = $data_all['ip'];
            $access_statistics_all->save();
        }
        return '1';
    }
}
