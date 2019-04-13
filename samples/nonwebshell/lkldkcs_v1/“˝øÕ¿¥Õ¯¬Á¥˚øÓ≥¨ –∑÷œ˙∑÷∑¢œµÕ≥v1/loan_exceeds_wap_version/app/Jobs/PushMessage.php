<?php

namespace App\Jobs;

use App\Handler\JPushMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class PushMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    //($key,'all',$app,'custom_user',$item->device['push_id']);//config|id|all|hry|allusers|13300000000
    protected $jpush_config;
    protected $msgId;
    protected $send_platform;
    protected $app;
    protected $user_type;
    protected $push_id;
    protected $record_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($jpush_config,$msgId,$send_platform,$user_type,$push_id,$record_id = null)
    {
        $this->jpush_config = $jpush_config;
        $this->msgId = $msgId;
//        $this->send_platform = $jpush_config;
//        $this->app  = $app;
        $this->user_type  = $user_type;
        $this->push_id  = $push_id;
        $this->record_id  = $record_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $push = new JPushMessage();
        if($this->user_type == 'allUsers'){
            $push->allPlatformSend('all',$this->msgId,$this->jpush_config);
        }elseif($this->user_type == 'cron_tab'){//定时推送
            if($this->push_id) {
                $push->cronMessage('all', $this->record_id, $this->jpush_config, $this->push_id);
            }
        }else{
            if($this->push_id) {
                $push->setCustomPush('all', $this->msgId, $this->jpush_config, $this->push_id);
            }
        }
    }
}
