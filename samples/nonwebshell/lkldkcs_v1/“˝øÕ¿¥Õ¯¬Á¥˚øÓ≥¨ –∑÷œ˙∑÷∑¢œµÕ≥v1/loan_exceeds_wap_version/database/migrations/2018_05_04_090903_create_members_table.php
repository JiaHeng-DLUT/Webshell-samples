<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户表
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id')->default(0)->comment('应用id');
            $table->integer('app_id')->default(0)->comment('app id');
            $table->string('phone',11)->default('')->comment('手机');
            $table->string('password',255)->default('')->comment('密码');
            $table->string('uuid',255)->nullable()->comment('uuid');
            $table->string('avatar',255)->comment('头像')->nullable();
            $table->enum('platform_register',['android','ios','wap','pc']);
            $table->enum('platform_login',['android','ios','wap','pc']);
            $table->string('identifier_register')->default('')->comment('注册时的设备码');
            $table->string('identifier_login')->default('')->comment('最后登陆的设备码');
            $table->string('identifier_push')->default('')->comment('推送所用的设备码');
            $table->integer('login_count')->default(0)->comment('登陆次数');
            $table->string('channel_code',20);
            $table->integer('product_id')->default(0)->comment('通过产品详情引导完成注册的产品id');
            $table->integer('credit_id')->nullable()->comment('信用卡id,预留');
            $table->integer('page_id')->default(0)->comment('通过分发页完成注册时的分发页id');
            $table->enum('reduce_type',['register','apply_register']);
            $table->integer('reduce_rate')->default(100)->comment('注册扣量或申请注册扣量值');
            $table->dateTime('last_apply_at')->nullable()->comment('最后申请时间');
            $table->string('nick',50)->comment('昵称')->nullable();
            $table->string('remember_token',150)->comment('记住我')->nullable();
            $table->string('register_ip',20)->default('')->comment('注册ip');
            $table->string('last_login_ip',20)->default('')->comment('最后登陆ip');
            $table->dateTime('last_login_at')->comment('最后登陆时间');
            $table->string('package')->default('')->comment('包名');
            $table->string('system_version',50)->nullable()->comment('系统版本');
            $table->integer('old_page_id')->nullable()->comment('原page_id');

            $table->timestamps();
        });

        //用户登录退出记录表
        Schema::create('member_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->string('identifier',255)->default('')->comment('设备码');
            $table->text('user_agent')->nullable()->comment('浏览器UA');
            $table->string('ip',20)->default('')->comment('ip地址');
            $table->enum('method',['GET','POST','PUT','PATCH'])->comment('ip地址');
            $table->string('route',255)->default('')->comment('请求路由');
            $table->text('params')->comment('请求参数');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->enum('platform',['android','ios','wap','pc'])->comment('平台');
            $table->integer('page_id')->default(0)->comment('分发页id');
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
        Schema::dropIfExists('members');
        Schema::dropIfExists('member_logs');
    }
}
