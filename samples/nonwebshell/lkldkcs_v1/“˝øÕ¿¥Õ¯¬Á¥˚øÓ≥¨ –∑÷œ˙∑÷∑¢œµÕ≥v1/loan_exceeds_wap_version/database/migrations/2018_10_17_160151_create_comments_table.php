<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //评论表
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('product_type',['product','credit'])->comment('产品类型');
            $table->enum('comment_type',['real','fake'])->comment('评论类型');
            $table->integer('mid')->default(0)->comment('用户id,虚拟用户为0');
            $table->string('phone',11)->default('')->comment('手机号');
            $table->integer('product_id')->default(0)->comment('产品id');
            $table->integer('credit_id')->default(0)->comment('信用卡id');
            $table->string('model_name',50)->default('')->comment('产品名称');
            $table->integer('apply_id')->default(0)->comment('申请记录id');
            $table->float('star',3,1)->default(5.0)->comment('评分');
            $table->tinyInteger('status')->default(0)->comment('状态:-1=>不予显示,0=>待审核,1=>审核通过');
            $table->tinyInteger('is_wonderful')->default(0)->comment('是否是精彩评论:0=>否,1=>是,当status=1时该值才可能为1');
            $table->text('content')->nullable()->comment('评论内容');
            $table->timestamps();
            $table->softDeletes();
        });

        //评论回复表
        Schema::create('comment_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comment_id')->default(0)->comment('评论id');
            $table->text('content')->comment('回复内容');
            $table->integer('user_id')->default(0)->comment('回复人id');
            $table->string('user_name',50)->default('')->comment('回复人姓名');
            $table->timestamps();
        });

        //虚拟评论池
        Schema::create('virtual_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content')->comment('回复内容');
            $table->float('star',3,1)->default(5.0)->comment('评分');
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
        Schema::dropIfExists('comments');
        Schema::dropIfExists('comment_replies');
        Schema::dropIfExists('virtual_comments');
    }
}
