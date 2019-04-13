<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('名称');
            $table->string('intro')->nullable()->comment('简介');
            $table->tinyInteger('status')->default(0)->comment('状态:0=>下架,1=>上架');
            $table->timestamps();
        });

        //新标签-产品中间
        Schema::create('label_has_products', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('label_id');
            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->onDelete('cascade');
        });
        //新标签-渠道中间
        Schema::create('label_has_channels', function (Blueprint $table) {
            $table->unsignedInteger('channel_id');
            $table->unsignedInteger('label_id');
            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labels');
        Schema::dropIfExists('label_has_products');
        Schema::dropIfExists('label_has_channels');
    }
}
