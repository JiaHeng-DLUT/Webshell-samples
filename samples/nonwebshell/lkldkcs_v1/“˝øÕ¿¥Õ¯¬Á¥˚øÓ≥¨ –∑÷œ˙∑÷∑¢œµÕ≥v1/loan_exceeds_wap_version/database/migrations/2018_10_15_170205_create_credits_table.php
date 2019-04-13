<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',15)->default('')->comment('信用卡名称');
            $table->string('logo',255)->default('')->comment('logo名称');
            $table->integer('credit_bank_id')->default(0)->comment('发卡行');
            $table->integer('corner_id')->default(0)->commnet('角标id');
            $table->integer('credit_level_id')->default(0)->comment('信用卡等级id');
            $table->integer('credit_organization_id')->default(0)->comment('信用卡组织id');
            $table->string('year_fee',30)->default('')->comment('年费');
            $table->string('redirect_url',255)->default('')->comment('申请链接');
            $table->string('free_period',15)->default('')->comment('免息期');
            $table->string('cash_amount',15)->default('')->comment('取现额度');
            $table->integer('status')->default(0)->comment('状态:0=>下架,1=>上架');
            $table->integer('base_apply_num')->default(0)->comment('申请基数');
            $table->integer('sort')->default(0)->comment('排序');
            $table->tinyInteger('guess_like')->default(0)->comment('猜你喜欢:0=>否,1=>是');
            $table->string('introduce',200)->comment('')->comment('特权');
            $table->integer('apply_numbers')->default(0)->comment('实际申请人数');
            $table->timestamps();
            $table->softDeletes();
        });

        //信用卡收藏表
        Schema::create('credit_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->integer('credit_id')->default(0)->comment('信用卡id');
            $table->timestamps();
        });

        //信用卡发卡行表
        Schema::create('credit_banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('银行名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        //信用卡等级表
        Schema::create('credit_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('等级名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        //信用卡组织表
        Schema::create('credit_organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('组织名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        //用户分享记录
        Schema::create('credit_shares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->integer('credit_id')->default(0)->comment('信用卡id');
            $table->text('link')->nullable()->comment('分享链接');
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
        Schema::dropIfExists('credits');
        Schema::dropIfExists('credit_collections');
        Schema::dropIfExists('credit_banks');
        Schema::dropIfExists('credit_levels');
        Schema::dropIfExists('credit_organizations');
        Schema::dropIfExists('credit_shares');
    }
}
