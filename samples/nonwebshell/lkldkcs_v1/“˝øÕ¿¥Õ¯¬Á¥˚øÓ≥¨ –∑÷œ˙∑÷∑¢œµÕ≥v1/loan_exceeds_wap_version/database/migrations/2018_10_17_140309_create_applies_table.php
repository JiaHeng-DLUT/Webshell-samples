<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->enum('platform',['android','ios','wap','pc'])->comment('平台');
            $table->enum('type',['product','credit'])->comment('类型');
            $table->integer('product_id')->default(0)->comment('产品id');
            $table->integer('credit_id')->default(0)->comment('信用卡id');
            $table->integer('channel_id')->default(0)->comment('渠道id');
            $table->string('channel_code')->default('')->comment('渠道码');
            $table->integer('register_page_id')->default(0)->comment('注册时的分发页id,若无则为0');
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
        Schema::dropIfExists('applies');
    }
}
