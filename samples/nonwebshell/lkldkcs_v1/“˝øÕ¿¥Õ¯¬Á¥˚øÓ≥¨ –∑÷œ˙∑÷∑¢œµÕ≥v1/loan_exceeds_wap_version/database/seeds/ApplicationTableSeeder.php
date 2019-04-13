<?php

use Illuminate\Database\Seeder;

class ApplicationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Application::truncate();
        $data=[
            ['name'=>'ddh','display_name'=>'贷袋狐','package_name'=>'com.android.ddfox','jpush_config'=>'{"app_key": "192c43e134a1c744e916a070", "master_secret": "756f9a31d7eb73b5812e0d51"}'],
            ['name'=>'hry','display_name'=>'惠融易','package_name'=>'com.android.huirongyi','jpush_config'=>'{"app_key": "9b2db96068ac4b5d5fe9a04c", "master_secret": "46abefe0163d58d84aff1bf9"}'],
        ];
        \Illuminate\Support\Facades\DB::table('applications')->insert($data);
    }
}
