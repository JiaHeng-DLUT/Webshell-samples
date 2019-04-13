<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\WebSiteRequest;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class WebSiteController extends Controller
{
    public function index(Website $website)
    {

        $website = $website->first();


        return view('admin.website.index',compact('website'));
    }


    public function update(WebSiteRequest $request,Website $website)
    {
        $data = $request->all();

        $first = $website->find(1);
//        dd($first);
        if($first){
            //修改
            if($first->base_loan != $data['base_loan']){
                Redis::del('all_count:');//累计
            }
            if ( $first->base_today_loan != $data['base_today_loan']) {
                Redis::del('today_count:'.date('Y-m-d').':');//今日
            }
            $first->company_name = $data['company_name'];
            $first->phone = $data['phone'];
            $first->record_num = $data['record_num'];
            $first->base_loan = $data['base_loan'];
            $first->base_today_loan = $data['base_today_loan'];
            if($data['qrcode_weixin']){
                $first->qrcode_weixin = $data['qrcode_weixin'];
            }
            if($data['qrcode_app']){
                $first->qrcode_app = $data['qrcode_app'];
            }
            if($data['qrcode_sina']){
                $first->qrcode_sina = $data['qrcode_sina'];
            }
            $first->update();


            return redirect()->route('admin.website')->with('success', '门户设置更新成功！');
        }else{
            //新增

            $website->create($data);
            Redis::del('all_count:');
            Redis::del('today_count:'.date('Y-m-d').':');
            return redirect()->route('admin.website')->with('success', '门户设置成功！');
        }
    }


}
