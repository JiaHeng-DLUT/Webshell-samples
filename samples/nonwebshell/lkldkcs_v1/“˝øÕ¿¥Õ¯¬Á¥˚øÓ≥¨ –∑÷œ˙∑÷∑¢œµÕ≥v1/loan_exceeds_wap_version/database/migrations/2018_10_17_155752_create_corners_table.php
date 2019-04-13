<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCornersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voi
     */
    public function up()
    {
        Schema::create('corners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',10)->default('')->comment('角标名称');
            $table->string('url',255)->default('')->comment('角标图片地址');
            $table->integer('sort')->default(0)->comment('排序');
            $table->enum('type',['product','credit','article'])->comment('类型');
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
        Schema::dropIfExists('corners');
    }
}
