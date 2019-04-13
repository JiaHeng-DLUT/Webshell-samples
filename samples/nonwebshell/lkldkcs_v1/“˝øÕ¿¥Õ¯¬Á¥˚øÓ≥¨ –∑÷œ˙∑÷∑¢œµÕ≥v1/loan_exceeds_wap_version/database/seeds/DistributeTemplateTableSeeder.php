<?php

use Illuminate\Database\Seeder;

class DistributeTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\DistributeTemplate::truncate();
        $data=[
            ["name" => "列表页&专题页模板","support_custom" => 1,"custom_status" => 0,"custom_range"=>'"[\"banner\",\"product\"]"',"deleted_at"=>null,"html_name"=>"loanList.html"],
            ["name" => "主页模板","support_custom" => 0,"custom_status" => 0,"custom_range"=>'"[]"',"deleted_at"=>null,"html_name"=>"home.html"],
            ["name" => "注册页模板(跳转到下载页)","support_custom" => 1,"custom_status" => 0,"custom_range"=>'"[\"register\"]"',"deleted_at"=>null,"html_name"=>"registerDispense.html"],
            ["name" => "产品详情页模板","support_custom" => 1,"custom_status" => 0,"custom_range"=>'"[\"product\"]"',"deleted_at"=>null,"html_name"=>"loanDetail.html"],
            ["name" => "手机号激活模板","support_custom" => 0,"custom_status" => 0,"custom_range"=>'"[]"',"deleted_at"=>"2018-12-01 10:00:00","html_name"=>"activate.html"],
            ["name" => "下载模板-新用户秒过","support_custom" => 0,"custom_status" => 0,"custom_range"=>'"[]"',"deleted_at"=>null,"html_name"=>"appDown.html"],
            ["name" => "下载模板-无门槛急速借款","support_custom" => 0,"custom_status" => 0,"custom_range"=>'"[]"',"deleted_at"=>null,"html_name"=>"appDownB.html"],
            ["name" => "注册页模板(跳转到首页)","support_custom" => 1,"custom_status" => 0,"custom_range"=>'"[\"register\"]"',"deleted_at"=>null,"html_name"=>"registerDispenseB.html"],
            ["name" => "信息流注册模板(跳转到下载页)","support_custom" => 1,"custom_status" => 0,"custom_range"=>'"[\"register\"]"',"deleted_at"=>null,"html_name"=>"registerDispenseC.html"],
            ["name" => "信息流注册模板(跳转到首页)","support_custom" => 1,"custom_status" => 0,"custom_range"=>'"[\"register\"]"',"deleted_at"=>null,"html_name"=>"registerDispenseD.html"],
        ];
        \Illuminate\Support\Facades\DB::table('distribute_templates')->insert($data);
    }
}
