<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(IconTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        $this->call(DictionaryTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(DistributeTemplateTableSeeder::class);
        $this->call(ApplicationTableSeeder::class);
        $this->call(DefaultChannelCodeTableSeeder::class);

    }
}
