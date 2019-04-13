<?php

namespace App\Console;

use App\Http\Controllers\Admin\CreditController;
use App\Http\Controllers\Admin\DistributeController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\MessageCrontabController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserModelController;
use App\Models\MessageCrontab;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        //03:00执行刷新用户模型快照操作
        $schedule->call(function (UserModelController $userModel){
            $userModel->cronRefreshSnapshot();
        })->dailyAt('03:00');
            //everyMinute()
        //每分钟执行一次贷款产品和信用卡
        //贷款
        $schedule->call(function (ProductController $productController){
            $productController->autoUpLoan();
        })->everyMinute();
        //信用卡
        $schedule->call(function (CreditController $creditController){
            $creditController->autoUpCredit();
        })->everyMinute();

        //渠道分发页模板定时任务
       /* $schedule->call(function (DistributeController $controller){
            $controller->timingUpdateAll();
        })->dailyAt('00:00');*/

        //定时消息检查
        $schedule->call(function(MessageController $message){
            Log::info("定时任务 >>> RUN");
//            expireCall();
            $message->checkPushMessage();
            $message->checkSystemMessage();

        })->everyMinute();
        $schedule->call(function(MessageCrontabController $crontabController){
           // Log::info("每分钟执行");
            $crontabController->checkError();
        })->everyMinute();

        //极光推送定时发送：10minutes,1hour
        $schedule->call(function (MessageCrontabController $crontabController){
            $crontabController->notRegister(1);
            $crontabController->noApplyOrLoss(3);
        })->everyTenMinutes();
        $schedule->call(function (MessageCrontabController $crontabController){
            $crontabController->notRegister(2);
            $crontabController->noApplyOrLoss(4);
            $crontabController->noApplyOrLoss(5);
            $crontabController->noApplyOrLoss(6);
            $crontabController->noApplyOrLoss(7);
        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
