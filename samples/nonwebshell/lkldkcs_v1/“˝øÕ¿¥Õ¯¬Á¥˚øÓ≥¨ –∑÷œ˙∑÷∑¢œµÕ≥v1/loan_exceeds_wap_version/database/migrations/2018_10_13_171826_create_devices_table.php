<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id');
            $table->string('push_id',255);
            $table->enum('platform',['android','ios']);
            $table->string('identifier',255)->default('')->comment('设备码');
            $table->string('device_name',255);
            $table->string('system_version',255);
            $table->string('channel_code',20);
            $table->string('app_name',20);
            $table->string('app_version',20);
            $table->text('user_agent')->nullable()->comment('UA');
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
        Schema::dropIfExists('devices');
    }
}
