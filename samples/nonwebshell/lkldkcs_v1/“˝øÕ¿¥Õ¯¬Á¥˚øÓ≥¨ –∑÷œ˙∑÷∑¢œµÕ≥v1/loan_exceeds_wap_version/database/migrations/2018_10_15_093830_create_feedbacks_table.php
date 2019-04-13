<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid');
            $table->string('phone',11);
            $table->integer('feedback_category_id')->default(0)->comment('反馈分类id');
            $table->text('content')->comment('反馈内容');
            $table->string('channel_code',20)->default('')->comment('渠道码');
            $table->boolean('status')->default(false)->comment('true:已回复; false:待回复');
            $table->timestamps();
        });

        Schema::create('feedback_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('分类名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        Schema::create('feedback_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feedback_id');
            $table->text('content');
            $table->integer('user_id');
            $table->string('user_name',50);
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
        Schema::dropIfExists('feedbacks');
        Schema::dropIfExists('feedback_categories');
        Schema::dropIfExists('feedback_replies');
    }
}
