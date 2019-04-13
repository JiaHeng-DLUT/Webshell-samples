<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //消息表
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['push','system'])->comment('消息类型');
            $table->string('title',20)->default('')->comment('标题');
            $table->text('content')->comment('推送内容');
            $table->tinyInteger('send_type')->default(1)->comment('发送类型:1=>即时发送,2=>定时发送');
            $table->dateTime('fixed_at')->nullable()->comment('定时时间,仅send_type=2时有值');
            $table->tinyInteger('send_object')->default(0)->comment('发送对象:1=>全部用户,2=>注册用户,3=>指定注册用户');
            $table->tinyInteger('status')->default(0)->comment('发送状态:0=>未发送,1=>已发送');
            $table->string('redirect_model',50)->comment('跳转页面类型');
            $table->string('redirect_model_detail',255)->nullable()->comment('跳转页面详情:product/credit/artic/system 时为其详情id,link时为填写的url地址');
            $table->integer('counts')->nullable()->comment('预计人数：为创建时间的用户模型人数');
            $table->dateTime('send_at')->nullable()->comment('执行时间');
            $table->timestamps();
            $table->softDeletes();
        });

        //消息&&用户模型关联表
        Schema::create('message_user_models', function (Blueprint $table) {

            $table->integer('message_id');
            $table->integer('user_model_id');
        });

        //消息&&追加号码表
        Schema::create('message_appends', function (Blueprint $table) {

            $table->integer('message_id');
            $table->text('phone')->default('')->comment('追加的手机号');
            $table->tinyInteger('type')->default(0)->comment('类型:1=>textarea,2=>excel');

        });

        //消息&&注册用户表
        Schema::create('message_members', function (Blueprint $table) {

            $table->integer('message_id');
            $table->tinyInteger('mid')->default(0)->comment('用户id');
            $table->text('numbers')->default('')->comment('自定义号码');

        });

        //消息&&游客表
        Schema::create('message_guests', function (Blueprint $table) {

            $table->integer('message_id');
            $table->tinyInteger('guest_id')->default(0)->comment('游客id,即排除有注册用户的设备的id');

        });

        //消息&&所有设备表(member+guest)
        Schema::create('message_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('message_id')->default(0)->comment('消息id');
            $table->integer('device_id')->default(0)->comment('设备主键id');
            $table->tinyInteger('is_reached')->default(0)->comment('是否到达:0=>否,1=>是');
            $table->tinyInteger('is_clicked')->default(0)->comment('是否点击:0=>否,1=>是');
            $table->timestamps();
        });

        //消息&&applications应用表
        Schema::create('message_applications', function (Blueprint $table) {

            $table->integer('message_id')->default(0)->comment('消息id');
            $table->integer('application_id')->default(0)->comment('应用id');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('message_appends');
        Schema::dropIfExists('message_members');
        Schema::dropIfExists('message_guests');
        Schema::dropIfExists('message_devices');
        Schema::dropIfExists('message_user_models');
        Schema::dropIfExists('message_applications');
    }
}
