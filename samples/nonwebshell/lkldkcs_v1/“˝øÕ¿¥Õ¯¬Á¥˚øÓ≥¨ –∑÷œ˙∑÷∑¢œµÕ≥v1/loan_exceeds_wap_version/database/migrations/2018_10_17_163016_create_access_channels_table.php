<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //渠道综合统计
        Schema::create('access_channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->enum('platform',['android','ios','wap','pc'])->comment('访问平台');
            $table->integer('template_id')->default(0)->comment('分发页模板id,仅platform=wap时有值');
            $table->integer('page_id')->default(0)->comment('分发页id,仅platform=wap时有值');
            $table->integer('pv')->default(0)->comment('pv');
            $table->integer('uv')->default(0)->comment('uv');
            $table->integer('ip')->default(0)->comment('ip');
            $table->date('today')->comment('日期');
            $table->timestamps();
        });

        //产品详细统计
        Schema::create('access_products', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('platform',['android','ios','wap','pc'])->comment('访问平台');
            $table->integer('page_id')->default(0)->comment('分发页id');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->integer('product_id')->default(0)->comment('产品id');
            $table->integer('pv')->default(0)->comment('pv');
            $table->integer('uv')->default(0)->comment('uv');
            $table->integer('ip')->default(0)->comment('ip');
            $table->date('today')->comment('日期');
            $table->timestamps();
        });

        //App活跃统计
        Schema::create('access_apps', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('platform',['android','ios'])->comment('访问平台');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->string('slug',50)->default('')->comment('页面标识');
            $table->integer('pv')->default(0)->comment('pv');
            $table->integer('uv')->default(0)->comment('uv');
            $table->integer('ip')->default(0)->comment('ip');
            $table->date('today')->comment('日期');
            $table->timestamps();
        });


        //访问记录
        Schema::create('access_records', function (Blueprint $table) {
            $table->increments('id');
            $table->date('today')->comment('日期');
            $table->enum('platform',['android','ios','wap','pc'])->comment('访问平台');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->string('refer',1000)->default('')->comment('来源页');
            $table->string('url',1000)->default('')->comment('访问页');
            $table->string('ip',20)->default('')->comment('ip地址');
            $table->string('identifier',255)->default('')->comment('设备唯一标识');
            $table->text('user_agent')->nullable()->comment('浏览器UA');
            $table->string('device_name',100)->default('')->comment('设备名称');
            $table->string('system_version',100)->default('')->comment('设备系统版本');
            $table->string('app_name',100)->default('')->comment('app名称');
            $table->string('app_version',100)->default('')->comment('app版本');
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
        Schema::dropIfExists('access_channels');
        Schema::dropIfExists('access_products');
        Schema::dropIfExists('access_apps');
        Schema::dropIfExists('access_records');
    }
}
