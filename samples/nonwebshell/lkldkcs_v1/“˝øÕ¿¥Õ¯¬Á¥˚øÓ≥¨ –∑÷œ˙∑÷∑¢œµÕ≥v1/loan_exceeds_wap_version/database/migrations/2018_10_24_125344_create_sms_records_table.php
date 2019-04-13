<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone',11)->default('')->comment('手机号');
            $table->string('captcha',10)->default('')->comment('验证码');
            $table->string('content',255)->default('')->comemnt('内容');
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
        Schema::dropIfExists('sms_records');
    }
}
