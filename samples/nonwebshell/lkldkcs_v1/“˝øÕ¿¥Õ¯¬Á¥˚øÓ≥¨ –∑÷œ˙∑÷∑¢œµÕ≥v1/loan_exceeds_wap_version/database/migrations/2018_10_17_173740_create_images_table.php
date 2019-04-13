<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['startup','guide','alert','banner','pcbanner'])->comment('图片类型');
            $table->string('url',255)->default('')->comment('图片地址');
            $table->string('redirect_url',255)->default('')->nullable()->comment('点击图片跳转地址');
            $table->enum('redirect_type',['inside','outside'])->comment('点击图片跳转类型:内链外链');
            $table->integer('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('状态:0=>停用,1=>启用');
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
        Schema::dropIfExists('images');
    }
}
