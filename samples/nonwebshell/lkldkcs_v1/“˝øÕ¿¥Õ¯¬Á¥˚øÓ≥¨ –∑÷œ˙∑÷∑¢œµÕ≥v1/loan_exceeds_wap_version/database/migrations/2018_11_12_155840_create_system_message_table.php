<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemMessageTable extends Migration
{
    /**
     * Run the migrations.
     *  系统消息同步表
     * @return void
     */
    public function up()
    {
        Schema::create('system_message_backs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',255)->comment('消息标题');
            $table->text('content')->comment('消息内容');
            $table->string('message_type',255)->comment('消息类型|system|feedback_reply|comment_reply');
            $table->tinyInteger('send_user_type')->default(2)->comment('发送对象类型|2全部注册用户|3指定用户');
            $table->text('numbers')->comment('接收号码');
            $table->integer('object_id')->comment('消息id');
            $table->tinyInteger('send_type')->default(1)->comment('发送时间|1即时|2自定义');
            $table->dateTime('send_at')->nullable()->comment('自定义发送时间');
            $table->timestamps();
            $table->softDeletes();
        });
        /**
         * 系统消息读取状态表
         */
        Schema::create('system_message_clicks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('system_id')->comment('系统消息id');
            $table->integer('mid')->comment('用户id');
            $table->tinyInteger('is_read')->default(0)->comment('消息已读状态');
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
        Schema::dropIfExists('system_message_backs');
        Schema::dropIfExists('system_message_clicks');
    }
}
