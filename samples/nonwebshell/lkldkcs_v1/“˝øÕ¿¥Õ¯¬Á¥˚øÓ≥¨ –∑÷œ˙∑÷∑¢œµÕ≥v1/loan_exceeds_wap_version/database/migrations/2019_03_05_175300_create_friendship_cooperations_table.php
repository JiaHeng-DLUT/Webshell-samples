<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendshipCooperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendship_cooperations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('机构名称');
            $table->tinyInteger('type')->default(1)->comment('类型：1合作机构,2友情链接');
            $table->string('url')->default('')->comment('链接');
            $table->enum('redirect_type',['inside','outside'])->comment('跳转类型');
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
        Schema::dropIfExists('friendship_cooperations');
    }
}
