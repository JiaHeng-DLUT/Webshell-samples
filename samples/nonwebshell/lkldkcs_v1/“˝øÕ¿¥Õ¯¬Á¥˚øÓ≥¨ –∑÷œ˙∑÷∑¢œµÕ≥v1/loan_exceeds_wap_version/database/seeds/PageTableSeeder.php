<?php

use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Page::truncate();
        $data=[
            ['user_id'=>0,'slug'=>'reg','title'=>'用户注册协议','content'=>'','sort'=>0],
            ['user_id'=>0,'slug'=>'privacy','title'=>'隐私条款','content'=>'','sort'=>0],
            ['user_id'=>0,'slug'=>'about','title'=>'关于我们','content'=>'','sort'=>0],
        ];
        \Illuminate\Support\Facades\DB::table('pages')->insert($data);
    }
}
