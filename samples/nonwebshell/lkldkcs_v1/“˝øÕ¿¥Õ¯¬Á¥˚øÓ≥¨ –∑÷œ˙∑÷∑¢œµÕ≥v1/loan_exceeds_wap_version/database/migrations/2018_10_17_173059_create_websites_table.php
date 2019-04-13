<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name',50)->default('')->comment('公司名称');
            $table->string('phone',20)->default('')->comment('电话');
            $table->string('record_num',100)->default('')->comment('备案号');
            $table->integer('base_loan')->default(0)->comment('累计借款基数');
            $table->integer('base_today_loan')->default(0)->comment('今日借款基数');
            $table->string('qrcode_weixin',255)->default('')->comment('微信二维码图片地址');
            $table->string('qrcode_app',255)->default('')->comment('app二维码图片地址');
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
        Schema::dropIfExists('websites');
    }
}
