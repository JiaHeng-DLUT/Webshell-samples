<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //扣量综合表
        Schema::create('deductions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->enum('platform',['android','ios','wap','pc'])->comment('平台');
            $table->integer('page_id')->default(0)->comment('分发页id');
            $table->string('phone',11)->default('')->comment('手机号');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->enum('reduce_type',['register','apply_register'])->comment('扣量模式');
            $table->integer('deduction_register_id')->default(0)->comment('deduction_registers表id');
            $table->integer('deduction_apply_id')->default(0)->comment('deduction_applies表id');
            $table->integer('reduce_rate')->default(100)->comment('扣量值');
            $table->tinyInteger('status')->default(0)->comment('状态:0=>隐藏,1=>显示');
            $table->tinyInteger('is_deal')->default(0)->comment('是否结算:0=>否,1=>是');
            $table->timestamps();
        });

        //注册扣量表
        Schema::create('deduction_registers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->string('phone',11)->default('')->comment('手机号');
            $table->integer('reduce_rate')->default(100)->comment('扣量值');
            $table->integer('rate_sum')->default(0)->comment('扣量累计求和');
            $table->integer('natural')->default(0)->comment('扣量自然数');
            $table->tinyInteger('status')->default(0)->comment('状态:0=>隐藏,1=>显示');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->enum('platform',['android','ios','wap','pc'])->comment('平台');
            $table->integer('page_id')->default(0)->comment('分发页id');
            $table->timestamps();
        });


        //申请注册扣量表
        Schema::create('deduction_applies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->string('phone',11)->default('')->comment('手机号');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->enum('platform',['android','ios','wap','pc'])->comment('平台');
            $table->integer('page_id')->default(0)->comment('分发页id');
            $table->integer('reduce_rate')->default(100)->comment('扣量值');
            $table->tinyInteger('status')->default(0)->comment('状态:0=>隐藏,1=>显示');
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
        Schema::dropIfExists('deductions');
        Schema::dropIfExists('deduction_registers');
        Schema::dropIfExists('deduction_applies');
    }
}
