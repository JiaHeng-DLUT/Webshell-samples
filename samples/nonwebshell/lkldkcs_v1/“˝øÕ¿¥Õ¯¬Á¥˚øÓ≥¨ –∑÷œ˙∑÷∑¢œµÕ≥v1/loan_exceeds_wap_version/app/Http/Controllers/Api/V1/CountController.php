<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\Apply;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class CountController extends BaseController
{
    public function count()
    {
        $website = Website::orderBy('created_at','desc')->first();
        if ($website){
            $base_loan = $website->base_loan;
            $base_today_loan = $website->base_today_loan;
        }else{
            $base_loan = 120000;
            $base_today_loan = 1000;
        }
//        $rand_apply = 0;
        $rand_apply = mt_rand(1,10);
        //累计借款
        $all_count = Apply::where('type','product')->count();
        if (!Redis::exists('all_count:')){//首次存
            Redis::set('all_count:',$base_loan + $all_count);
        }else{//更新
            Redis::set('all_count:',Redis::get('all_count:')+$rand_apply);
        }
        //当天借款
        $today_count = Apply::where('type','product')
            ->whereBetween('created_at',[date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])
            ->count();
        if (!Redis::exists('today_count:'.date('Y-m-d').':')){//首次存
            Redis::set('today_count:'.date('Y-m-d').':',$base_today_loan + $today_count);
        }else{//更新
            Redis::set('today_count:'.date('Y-m-d').':',Redis::get('today_count:'.date('Y-m-d').':')+$rand_apply);
        }
        $data = [
            'all'=>(int)Redis::get('all_count:'),
            'today'=>(int)Redis::get('today_count:'.date('Y-m-d').':')
        ];
        $this->set('data',$data);
        return $this->jsonResponse();
    }
}
