<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/14
 * Time: 16:51
 */

namespace App\Handler;


use App\Models\Application;
use App\Models\Message;
use App\Models\MessageCrontabFirst;
use App\Models\MessageCrontabSendRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use JPush\Client as JPush;

class JPushMessage
{
    public $push;

    public function setPushKey($config)
    {
        if(!is_array($config)) {
            $jpush_config = json_decode($config, true);
        }else{
            $jpush_config = $config;
        }
        $key = $jpush_config['app_key'];
        $secret = $jpush_config['master_secret'];

        $client = new JPush($key, $secret);
        $this->push = $client->push();
    }
    /** 发送全部
     * @param $platform
     * @param $msgid
     * @return array
     * TODO::修改代码后需要重新执行php artisan queue:work 命令
     */

    public function allPlatformSend($platform,$msgid,$push_config){

        //实例化极光SDK
        $this->setPushKey($push_config['config']);
        Log::info($push_config['config']);
        //redis消息
        /**
         *  $data['title'] = $message['title'];
         *  $data['content'] = strip_tags($message['content']);
         *  $data['redirect_model'] = $message['redirect_model'];
         *  $data['redirect_model_detail'] = $message['redirect_model_detail'];
         */
        $key = 'push:message:now:message_id_'.$msgid;
        if(Redis::exists($key))
        {
            $con = Redis::get($key);
            $con = json_decode($con,true);
        }else{
            $con = Message::where(['id'=>$msgid])
                ->first(['id','title','content','redirect_model','redirect_model_detail']);
        }

        Log::info('极光测试：'.$msgid.'---');
        //*查询最后一次更新的push_platform*//
        $pusher = $this->push;
        $pusher->setPlatform($platform);
        $pusher->addAllAudience();
        $pusher->iosNotification(['title' => $con['title'],'body' => $con['content']], array(
            'badge' => '1',
            'extras' => array(
                'redirect_type'=>$con['redirect_model'],
                'redirect_url' => $con['redirect_model_detail']??'',
                'id'=>$msgid
            ),
        ));
        $pusher->androidNotification($con['content'], array(
            'title' => $con['title'],
            'extras' => array(
                'redirect_type'=>$con['redirect_model'],
                'redirect_url' => $con['redirect_model_detail']??'',
                'id'=>$msgid
            ),
        ));
//        try {
            $response = $pusher->send();
        Log::info(json_encode($response));
        if($response['http_code'] == 200){
            return '1';
        }else{
            return '0';
        }
      /*  } catch (\JPush\Exceptions\APIConnectionException $e) {
            // try something here
            print $e;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            // try something here
            print $e;
        }*/
    }

    /**
     * 自定义推送用户
     */
    public function setCustomPush($platform,$msgid,$push_config,$push_id){
        //实例化极光SDK

        $this->setPushKey($push_config['config']);
        Log::info('--自定义推送--'.$msgid);
        Log::info('--自定义设备id--'.$push_id);
        Log::info($push_config['config']);
        /****/

        $key = 'push:message:now:message_id_'.$msgid;
        if(Redis::exists($key))
        {
            $con = Redis::get($key);
            $con = json_decode($con,true);
        }else{
            $con = Message::find($msgid,['id','title','content','redirect_model','redirect_model_detail']);
        }
        Log::info('message--'.json_encode($con));
//        try {
        $response = $this->push
            ->setPlatform($platform)
            // 一般情况下，关于 audience 的设置只需要调用 addAlias、addTag、addTagAnd  或 addRegistrationId
            // 这四个方法中的某一个即可，这里仅作为示例，当然全部调用也可以，多项 audience 调用表示其结果的交集
            // 即是说一般情况下，下面三个方法和没有列出的 addTagAnd 一共四个，只适用一个便可满足大多数的场景需求

            // ->addAlias('alias')
//            ->addAllAudience()
//            ->addTag(array('tag1', 'tag2'))
            ->addRegistrationId($push_id)
//            ->setNotificationAlert('eeeee')
            ->iosNotification(['title' => $con['title'],'body' => $con['content']], array(
                'category' => 'jiguang',
                'badge' => '1',
                'extras' => array(
                    'redirect_type'=>$con['redirect_model'],
                    'redirect_url' => $con['redirect_model_detail']??'',
                    'id'=>$msgid
                ),
            ))
            ->androidNotification($con['content'], array(
                'title' => $con['title'],
                'extras' => array(
                    'redirect_type'=>$con['redirect_model'],
                    'redirect_url' => $con['redirect_model_detail']??'',
                    'id'=>$msgid
                ),
            ))->send();
        Log::info(json_encode($response));
        if($response['http_code'] == 200){
            Message::where(['id'=>$msgid])->increment('send_counts');
        }else{
            return '0';
        }
//        return $response;
        /*} catch (\JPush\Exceptions\APIConnectionException $e) {
            // try something here
            return $e;
        } catch (\JPush\Exceptions\APIRequestException $e) {
            // try something here
            return $e;
        }*/
    }

    /**
     * @param $platform
     * @param $record_id
     * @param $push_config
     * @param $push_id
     * @return string
     */
    public  function  cronMessage($platform,$record_id,$push_config,$push_id)
    {
        //实例化极光SDK

        $this->setPushKey($push_config['config']);
       /* Log::info('--定时推送--'.$record_id);
        Log::info('--定时推送id--'.$push_id);
        Log::info($push_config['config']);*/
        /****/

        $key = 'push:message:now:record_id'.$record_id;
        if(Redis::exists($key))
        {
            $con = Redis::get($key);
            $con = json_decode($con,true);
        }else{
            $con = MessageCrontabSendRecord::where('id',$record_id)->with(['cornMessage'])->first()->toArray();
        }

        //获取标题名称
        $app_id = MessageCrontabFirst::where('identifier',$con['identifier'])->first(['app_id'])->app_id;
        $title = Application::where('id',$app_id)->first(['display_name'])->display_name;
        //Log::info('message--'.json_encode($con));
//        try {
        $response = $this->push
          ->setPlatform($platform)
          // 一般情况下，关于 audience 的设置只需要调用 addAlias、addTag、addTagAnd  或 addRegistrationId
          // 这四个方法中的某一个即可，这里仅作为示例，当然全部调用也可以，多项 audience 调用表示其结果的交集
          // 即是说一般情况下，下面三个方法和没有列出的 addTagAnd 一共四个，只适用一个便可满足大多数的场景需求

          // ->addAlias('alias')
//            ->addAllAudience()
//            ->addTag(array('tag1', 'tag2'))
          ->addRegistrationId($push_id)
//            ->setNotificationAlert('eeeee')
          ->iosNotification(['title' => $title,'body' => $con['corn_message']['content']], array(
            'category' => 'jiguang',
            'badge' => '1',
            'extras' => array(
              'redirect_type'=>'productDetail',
              'redirect_url' =>'',
              'id'=>$con['corn_message']['id'],
              'no_login_product_id'=>$con['no_login_product_id'],
              'login_product_id'=>$con['login_product_id'],
            ),
          ))
          ->androidNotification($con['corn_message']['content'], array(
            'title' => $title,
            'extras' => array(
              'redirect_type'=>'productDetail',
              'redirect_url' => '',
              'id'=>$con['corn_message']['id'],
              'no_login_product_id'=>$con['no_login_product_id'],
              'login_product_id'=>$con['login_product_id'],
            ),
          ))->send();
        Log::info(json_encode($response));
       /* if($response['http_code'] == 200){
            Message::where(['id'=>$msgid])->increment('send_counts');
        }else{
            return '0';
        }*/
    }






}