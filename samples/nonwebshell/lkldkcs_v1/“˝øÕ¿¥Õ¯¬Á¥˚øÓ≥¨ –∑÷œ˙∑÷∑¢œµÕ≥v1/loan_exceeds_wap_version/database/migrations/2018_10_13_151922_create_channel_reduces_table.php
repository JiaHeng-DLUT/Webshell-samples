<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelReducesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_reduces', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('channel_id');
            $table->string('channel_code');
            $table->string('channel_name',50);
            $table->enum('platform',['android','ios','wap','pc']);
            $table->integer('distribute_template_id');
            $table->string('distribute_template_name',100);
            $table->integer('distribute_page_id');
            $table->string('distribute_page_name',100);
            $table->enum('reduce_type',['register','apply_register']);
            $table->integer('reduce_rate')->default(100)->comment('扣量值');
            $table->integer('modifier_id')->default(0)->comment('修改人id');
            $table->string('modifier_name',50)->default('')->comment('修改人姓名');
            $table->tinyInteger('status')->default(1)->comment('状态:0=>停用,1=>启用');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('reduce_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('channel_reduce_id');
            $table->enum('reduce_type',['register','apply_register']);
            $table->integer('reduce_rate');
            $table->tinyInteger('reduce_status');
            $table->dateTime('effect_start')->nullable();
            $table->dateTime('effect_end')->nullable();
            $table->dateTime('effect_on')->nullable();
            $table->string('mark',255)->nullable();
            $table->integer('before_modify');
            $table->integer('after_modify');
            $table->integer('modifier_id');
            $table->string('modifier_name',20);
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
        Schema::dropIfExists('channel_reduces');
        Schema::dropIfExists('channel_reduce_records');
    }
}
