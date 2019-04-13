<?php

use Illuminate\Database\Seeder;

class DefaultChannelCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Department::truncate();
        $data=[
            ["name" => "运营"],
            ["name" => "流量"],
        ];
        \Illuminate\Support\Facades\DB::table('departments')->insert($data);

        \App\Models\Channel::truncate();
        $data=[
            ["user_id" => "1","role_id" => "1","channel_name" => "官方","channel_code" => "100001","department_id" => "1","manager" => "官方负责人","reduce_type" => "register"],
        ];
        \Illuminate\Support\Facades\DB::table('channels')->insert($data);

        \App\Models\ChannelReduce::truncate();
        $data=[
            ['channel_id'=> "1",'channel_code'=> "100001",'channel_name'=> "官方",'platform'=> "android",'reduce_type'=> "register","distribute_page_id"=>"","distribute_page_name" => "","distribute_template_id"=>"","distribute_template_name"=>""],
            ['channel_id'=> "1",'channel_code'=> "100001",'channel_name'=> "官方",'platform'=> "ios",'reduce_type'=> "register","distribute_page_id"=>"","distribute_page_name" => "","distribute_template_id"=>"","distribute_template_name"=>""],
            ['channel_id'=> "1",'channel_code'=> "100001",'channel_name'=> "官方",'platform'=> "wap",'reduce_type'=> "register","distribute_page_id"=>"1","distribute_page_name" => "官方渠道","distribute_template_id"=>"2","distribute_template_name"=>"主页模板&专题页模板"],
        ];
        \Illuminate\Support\Facades\DB::table('channel_reduces')->insert($data);

        \App\Models\DealRecord::truncate();
        $data=[
            ['channel_code'=> "100001",'user_id'=> "1",'deal_at'=> date('Y-m-d H:i:s',time())],
        ];
        \Illuminate\Support\Facades\DB::table('deal_records')->insert($data);

        \App\Models\App::truncate();
        $data=[
            [
                'name'=> '',
                'package_name'=> '',
                'logo'=> '',
                'download_url'=> '',
                'qrcode_url'=> '',
                'platform'=> 'android',
                'version'=> '',
                'update_log'=> '',
                'channel_id'=> 1,
                'channel_code'=> '100001',
                'created_at'=>time(),
            ]
        ];
        \Illuminate\Support\Facades\DB::table('apps')->insert($data);

        $path = create_templat_html(1,'100001','home.html');
        $url = env('APP_H5_DISTRIBUTE') .'/html/'. $path;

        \App\Models\DistributePage::truncate();
        $data=[
            ["channel_code" => "100001","name" => "官方渠道","template_id" => "2","reduce_type" => "register","status" => "1","support_custom" => "0","custom_status" => "1","custom_range" => "\"\"","url" => $url, "qrcode_url" => $url],
        ];
        \Illuminate\Support\Facades\DB::table('distribute_pages')->insert($data);


    }
}
