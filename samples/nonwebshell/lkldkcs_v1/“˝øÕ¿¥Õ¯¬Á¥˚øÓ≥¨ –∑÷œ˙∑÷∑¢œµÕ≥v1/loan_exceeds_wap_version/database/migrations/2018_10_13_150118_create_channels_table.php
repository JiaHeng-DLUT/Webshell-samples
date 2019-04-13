<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('role_id')->default(0)->comment('角色id');
            $table->string('channel_name',100)->default('')->comment('渠道名称');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->integer('department_id')->default(0)->comment('部门id');
            $table->string('manager',15)->default('')->comment('渠道负责人');
            $table->enum('reduce_type',['register','apply_register']);
            $table->tinyInteger('redirect_status')->default(1)->comment('跳转状态:0=>伪装,1=>正常');
            $table->integer('ceiling_num')->nullable()->comment('渠道每日查看注册上限,0或null为不限制');
            $table->tinyInteger('status')->default(1)->comment('状态:0=>停用,1=>正常');
            $table->dateTime('deal_at')->nullable()->comment('结算日期');
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
        Schema::dropIfExists('channels');
    }
}
