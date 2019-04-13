<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //应用名称 如贷袋狐,惠融易
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',10)->default('')->comment('应用标识');
            $table->string('display_name',20)->default('')->comment('应用显示名称');
            $table->string('package_name',255)->default('')->comment('包名');
            $table->json('jpush_config')->nullable()->comment('极光配置');
            $table->timestamps();
        });


        //渠道包app
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',10);
            $table->string('package_name',100);
            $table->integer('application_id')->default(0)->comment('应用id,用于区分贷袋狐 or 惠融易');
            $table->string('logo',255);
            $table->string('download_url',255);
            $table->string('qrcode_url',255);
            $table->enum('platform',['android','ios']);
            $table->string('version',20);
            $table->string('update_log',255)->nullable()->comment('更新日志');
            $table->integer('channel_id');
            $table->string('channel_code',20);
            $table->tinyInteger('status')->default(1)->comment('状态:0=>下架,1=>上架');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('app_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id');
            $table->string('name',50);
            $table->string('slug',50);
            $table->string('icon',255);
            $table->timestamps();
        });

        Schema::create('app_startups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id');
            $table->string('identifier',255)->default('')->comment('设备码');
            $table->string('channel_code',20);
            $table->string('ip',20)->default('')->comment('ip地址');
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
        Schema::dropIfExists('applications');
        Schema::dropIfExists('apps');
        Schema::dropIfExists('app_menus');
        Schema::dropIfExists('app_startups');
    }
}
