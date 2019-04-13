<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('warns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0)->comment('刷量id');
            $table->string('phone',20)->default()->comment('刷量的手机号');
            $table->string('deviceid_register')->default('')->comment('注册设备码');
            $table->string('deviceid_login')->default('')->comment('登录设备码');
            $table->string('ip')->default('')->comment('登录ip');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->enum('platform',['android','ios','wap','pc'])->nullable()->comment('登录来源平台');
            $table->string('department_name')->default('')->comment('所属部门');
            $table->string('manager')->default('')->comment('负责人');
            $table->tinyInteger('status')->default(0)->comment('是否显示:0=>否,1=>是 |同一设备被大于等于3个不同号码登录时,标记为1,否则标记为0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warns');
    }
}
