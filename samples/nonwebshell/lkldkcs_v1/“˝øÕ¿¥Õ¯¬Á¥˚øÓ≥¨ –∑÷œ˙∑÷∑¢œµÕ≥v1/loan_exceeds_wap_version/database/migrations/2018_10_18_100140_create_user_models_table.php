<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //用户模型表
        Schema::create('user_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',10)->default('')->comment('模型名称');
            $table->tinyInteger('register_at_type')->default(0)->comment('注册时间类型:0=>不限,1=>绝对时间,2=>相对时间');
            $table->date('register_at_abstract_start')->nullable()->comment('注册绝对时间开始');
            $table->date('register_at_abstract_end')->nullable()->comment('注册绝对时间结束');
            $table->integer('register_at_relative_num')->nullable()->comment('注册相对时间值');
            $table->enum('register_at_relative_unit',['day','week','month','year'])->nullable()->comment('注册相对时间单位');
            $table->tinyInteger('register_at_relative_type')->nullable()->comment('注册相对时间类型:1=>以前,2=>以内');
            $table->json('register_channels')->nullable()->comment('注册渠道码json合集');
            $table->json('register_platforms')->nullable()->comment('注册平台json合集');
            $table->integer('all_login_day_start')->nullable()->comment('累计登陆天数开始');
            $table->integer('all_login_day_end')->nullable()->comment('累计登陆天数结束');
            $table->integer('all_apply_num_start')->nullable()->comment('累计申请产品数开始');
            $table->integer('all_apply_num_end')->nullable()->comment('累计申请产品数结束');
            $table->json('apply_loans')->nullable()->comment('申请产品的id合集');
            $table->json('not_apply_loans')->nullable()->comment('未申请产品的id合集');
            $table->tinyInteger('last_active_at_type')->default(0)->comment('最后活跃时间类型:0=>不限,1=>绝对时间,2=>相对时间');
            $table->date('last_active_at_abstract_start')->nullable()->comment('最后活跃绝对时间开始');
            $table->date('last_active_at_abstract_end')->nullable()->comment('最后活跃绝对时间结束');
            $table->integer('last_active_at_relative_num')->nullable()->comment('最后活跃相对时间值');
            $table->enum('last_active_at_relative_unit',['day','week','month','year'])->nullable()->comment('最后活跃相对时间单位');
            $table->tinyInteger('last_active_at_relative_type')->nullable()->comment('最后活跃相对时间类型:1=>以前,2=>以内');
            $table->json('last_login_platforms')->nullable()->comment('最后登录平台json合集');
            $table->json('last_apply_loans')->nullable()->comment('最后申请产品id合集');
            $table->tinyInteger('last_apply_loan_at_type')->default(0)->comment('最后申请产品时间类型:0=>不限,1=>绝对时间,2=>相对时间');
            $table->date('last_apply_loan_at_abstract_start')->nullable()->comment('最后申请产品绝对时间开始');
            $table->date('last_apply_loan_at_abstract_end')->nullable()->comment('最后申请产品绝对时间结束');
            $table->integer('last_apply_loan_at_relative_num')->nullable()->comment('最后申请产品相对时间值');
            $table->enum('last_apply_loan_at_relative_unit',['day','week','month','year'])->nullable()->comment('最后申请产品相对时间单位');
            $table->tinyInteger('last_apply_loan_at_relative_type')->nullable()->comment('最后申请产品相对时间类型:1=>以前,2=>以内');
            $table->timestamps();
        });

        //用户模型镜像表
        Schema::create('user_model_snapshots', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_model_id')->default(0)->comment('模型id');
            $table->tinyInteger('refresh_type')->default(0)->comment('刷新类型:1=>新增模型,2=>修改模型规则,3=>列表刷新按钮,4=>凌晨3点定时器');
            $table->json('client_user_ids')->comment('用户id合集');
            $table->integer('client_user_num')->default(0)->comment('当前快照总用户数');
            $table->json('config')->comment('当前快照的条件配置');
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
        Schema::dropIfExists('user_models');
        Schema::dropIfExists('user_model_snapshots');
    }
}
