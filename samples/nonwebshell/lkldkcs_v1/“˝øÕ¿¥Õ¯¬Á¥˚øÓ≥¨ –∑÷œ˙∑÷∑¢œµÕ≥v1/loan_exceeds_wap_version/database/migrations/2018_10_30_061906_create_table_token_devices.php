<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTokenDevices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identifier')->comment('操作设备码');
            $table->string('platform')->comment('平台');
            $table->string('system')->comment('操作系统版本');
            $table->string('version')->comment('App版本');
            $table->string('token')->comment('token');
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
        Schema::dropIfExists('token_devices');
    }
}
