<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCirclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url',255)->default('')->comment('贷袋狐圈子二维码图片地址');
            $table->string('title',255)->default('')->comment('圈子名称');
            $table->string('copy_content',255)->default('')->comment('可复制的内容');
            $table->string('intro',255)->default('')->comment('描述');
            $table->enum('slug',['wechat_public','wechat_person','qq'])->nullable()->comment('标识');
            $table->integer('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('circles');
    }
}
