<?php

use Illuminate\Database\Seeder;

class DictionaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Dictionary::truncate();
        $data=[
              ["function_name" => "贷款产品","field_name" => "个人资质","slug" => "product_material","per_length"=>10,"max_num"=>20],
              ["function_name" => "贷款产品","field_name" => "贷款产品标签","slug" => "product_label","per_length"=>5,"max_num"=>10],
              ["function_name" => "贷款产品","field_name" => "贷款金额筛选区间","slug" => "product_quota","per_length"=>0,"max_num"=>0],
              ["function_name" => "贷款产品","field_name" => "还款周期筛选区间","slug" => "product_repay","per_length"=>0,"max_num"=>0],
              ["function_name" => "贷款产品","field_name" => "贷款角标","slug" => "product_corner","per_length"=>2,"max_num"=>6],
              ["function_name" => "信用卡产品","field_name" => "信用卡角标","slug" => "credit_corner","per_length"=>2,"max_num"=>6],
              ["function_name" => "信用卡产品","field_name" => "发卡行","slug" => "credit_bank","per_length"=>8,"max_num"=>15],
              ["function_name" => "信用卡产品","field_name" => "卡等级","slug" => "credit_level","per_length"=>4,"max_num"=>8],
              ["function_name" => "信用卡产品","field_name" => "卡组织","slug" => "credit_organization","per_length"=>15,"max_num"=>6],
              ["function_name" => "文章帮助及反馈","field_name" => "文章角标","slug" => "article_corner","per_length"=>2,"max_num"=>6],
              ["function_name" => "文章帮助及反馈","field_name" => "发现分类","slug" => "article_category","per_length"=>8,"max_num"=>8],
              ["function_name" => "文章帮助及反馈","field_name" => "反馈分类","slug" => "feedback_category","per_length"=>8,"max_num"=>8],
        ];
        \Illuminate\Support\Facades\DB::table('dictionaries')->insert($data);
    }
}
