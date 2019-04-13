<?php

namespace App\Listeners;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserEventSubscriber
{
    /**
     * 处理用户登录事件。
     */
    public function onUserLogin($event) {
//        $user = $event->user;
//        $user->last_login_at=Carbon::now();
//
//        $user->save();
    }

    /**
     * 处理用户注销事件。
     */
    public function onUserLogout($event) {}

    /**
     * 为订阅者注册监听器。
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

       /* $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );*/
    }

}