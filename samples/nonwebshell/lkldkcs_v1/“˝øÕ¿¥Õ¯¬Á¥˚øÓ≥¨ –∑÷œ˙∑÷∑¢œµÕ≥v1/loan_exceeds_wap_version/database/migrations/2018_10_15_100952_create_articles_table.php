<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //资讯
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cover',255)->nullable()->comment('封面图');
            $table->string('title',255)->default('')->comment('标题');
            $table->integer('corner_id')->default(0)->comment('角标id');
            $table->integer('category_id')->default(0)->comment('资讯分类id');
            $table->integer('base_views')->default(0)->comment('阅读基数');
            $table->integer('real_views')->default(0)->comment('真实阅读数');
            $table->string('intro',255)->default('')->comment('摘要');
            $table->integer('praise')->default(0)->comment('点赞数');
            $table->text('content')->comment('内容');
            $table->tinyInteger('status')->default(0)->comment('状态:0=>下架,1=>上架');
            $table->timestamps();
        });

        //资讯分类
        Schema::create('article_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('资讯分类名称');
            $table->integer('sort')->default(0)->commnet('排序');
            $table->timestamps();
        });

        //用户收藏资讯表
        Schema::create('article_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->integer('article_id')->default(0)->comment('文章id');
            $table->timestamps();
        });


        //用户浏览过的资讯
        Schema::create('article_members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->integer('article_id')->default(0)->comment('文章id');
            $table->timestamps();
        });

        //用户点赞记录
        Schema::create('article_praises', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->integer('article_id')->default(0)->comment('文章id');
            $table->timestamps();
        });

        //用户分享记录
        Schema::create('article_shares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->integer('article_id')->default(0)->comment('文章id');
            $table->text('link')->nullable()->comment('分享链接');
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
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_categories');
        Schema::dropIfExists('article_collections');
        Schema::dropIfExists('article_members');
        Schema::dropIfExists('article_praises');
        Schema::dropIfExists('article_shares');
    }
}
