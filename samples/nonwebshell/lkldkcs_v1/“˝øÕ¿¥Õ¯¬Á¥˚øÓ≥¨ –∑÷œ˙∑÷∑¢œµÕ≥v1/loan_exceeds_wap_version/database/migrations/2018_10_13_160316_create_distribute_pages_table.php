<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribute_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->default('')->comment('模板名称');
            $table->string('html_name',191)->default('')->comment('模板文件名称');
            $table->tinyInteger('support_custom')->default(0)->comment('是否支持定制:0=>否,1=>是');
            $table->tinyInteger('custom_status')->default(0)->comment('是否定制:0=>未定制,1=>已定制');
            $table->json('custom_range')->comment('可定制范围:banner,register,product');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('distribute_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->string('name',50)->default('')->comment('分发页名称');
            $table->integer('template_id')->default(0)->comment('模板id');
            $table->enum('reduce_type',['register','apply_register']);
            $table->tinyInteger('status')->default(0)->comment('状态:0=>停用,1=>正常');
            $table->tinyInteger('support_custom')->default(0)->comment('是否支持定制:0=>否,1=>是');
            $table->tinyInteger('custom_status')->default(0)->comment('是否定制:0=>未定制,1=>已定制');
            $table->json('custom_range')->comment('可定制范围:banner,register,product');
            $table->string('url',255)->default('')->comment('分发页地址');
            $table->string('qrcode_url',255)->default('')->comment('二维码地址');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('distribute_page_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id')->default(0)->comment('分发页id');
            $table->json('custom_range')->comment('可定制范围:banner,register,product');
            $table->string('register_img_url')->nullable()->comment('注册背景图');
            $table->json('banners');
            $table->json('product_ids');
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
        Schema::dropIfExists('distribute_templates');
        Schema::dropIfExists('distribute_pages');
        Schema::dropIfExists('distribute_page_contents');
    }
}
