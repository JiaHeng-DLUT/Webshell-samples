<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDictionariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictionaries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('function_name')->default('')->comment('功能名称');
            $table->string('field_name')->default('')->comment('字段名称');
            $table->string('slug')->default('')->comment('功能标识');
            $table->text('content')->nullable()->comemnt('详情');
            $table->json('model_ids')->nullable()->comment('各模型ids');
            $table->integer('per_length')->default(10)->comment('单条记录最大长度');
            $table->integer('max_num')->default(20)->comment('最大值');
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
        Schema::dropIfExists('dictionaries');
    }
}
