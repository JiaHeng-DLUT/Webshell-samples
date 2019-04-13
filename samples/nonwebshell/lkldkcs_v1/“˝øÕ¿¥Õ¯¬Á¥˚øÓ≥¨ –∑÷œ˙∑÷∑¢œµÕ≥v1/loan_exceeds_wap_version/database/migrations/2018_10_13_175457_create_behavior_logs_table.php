<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBehaviorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('behavior_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone',11);
            $table->integer('register_channel_id');
            $table->string('register_channel_name',50);
            $table->integer('register_page_id')->default(0);
            $table->string('register_page_name',50)->nullable();
            $table->tinyInteger('operate_type');
            $table->integer('operate_channel_id')->default(0);
            $table->string('operate_channel_name',50);
            $table->enum('operate_platform',['android','ios','wap','pc']);
            $table->integer('operate_page_id')->default(0);
            $table->string('operate_page_name',50)->nullable();
            $table->json('operate_params')->nullable()->comment('请求参数');
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
        Schema::dropIfExists('behavior_logs');
    }
}
