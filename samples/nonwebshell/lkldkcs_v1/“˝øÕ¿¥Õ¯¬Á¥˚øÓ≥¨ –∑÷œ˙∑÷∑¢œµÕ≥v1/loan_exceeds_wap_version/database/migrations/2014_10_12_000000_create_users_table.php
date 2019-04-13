<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique()->default('')->comment('登录名');
            $table->string('password')->default('')->comment('密码');
            $table->string('phone')->default('')->comment('电话');
            $table->string('email')->default('')->comment('邮箱');
            $table->string('name')->default('')->comment('显示名称');
            $table->string('avatar',255)->default('')->comment('头像');
            $table->rememberToken();
            $table->uuid('uuid')->default('')->comment('uuid');
            $table->enum('role_slug',['admin','channel'])->comment('角色类型');
            $table->tinyInteger('status')->default(0)->comment('状态:0=>禁用,1=>启用');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
