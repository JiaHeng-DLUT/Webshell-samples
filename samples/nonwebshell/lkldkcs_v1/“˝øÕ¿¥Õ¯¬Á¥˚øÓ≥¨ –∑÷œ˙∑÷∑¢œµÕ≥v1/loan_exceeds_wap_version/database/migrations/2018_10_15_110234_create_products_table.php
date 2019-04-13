<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //产品
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->commnet('产品名称');
            $table->string('logo',255)->default('')->commnet('logo');
            $table->json('market_element')->nullable()->comment('营销元素:fire,money');
            $table->integer('corner_id')->nullable()->default(0)->comment('角标id');
            $table->string('slogan',20)->default('')->comment('产品摘要,即一句话描述');
            $table->enum('rate_unit',['day','month','year'])->comment('利率单位');
            $table->float('rate_value',6,3)->default(0)->comment('利率值');
            $table->enum('repay_unit',['day','month','year'])->comment('还款单位');
            $table->integer('repay_min')->default(0)->comment('还款小值');
            $table->integer('repay_max')->default(0)->comment('还款大值');
            $table->integer('quota_min')->default(0)->comment('贷款额度小值');
            $table->integer('quota_max')->default(0)->comment('贷款额度大值');
            $table->enum('fast_lend_unit',['minute','hour','day'])->comment('最快放款单位');
            $table->integer('fast_lend_value')->default(0)->comment('最快放款时间值');
            $table->integer('fast_lend_sort')->default(0)->comment('最快放款时间乘法排序值');
            $table->integer('success_rate')->default(100)->comment('成功率');
            $table->string('redirect_url',1000)->default('')->comment('跳转申请地址');
            $table->json('platform')->nullable()->comment('上线平台');
            $table->string('apply_condition',1000)->nullable()->comment('申请条件');
            $table->integer('auto_down_sale_num')->nullable()->comment('自动申请下架数');
            $table->tinyInteger('status')->default(0)->comment('状态:0=>下架,1=>上架');
            $table->integer('sort')->default(0)->comment('排序');
            $table->integer('base_apply_num')->default(0)->comment('累计申请基数');
            $table->json('guess_like')->nullable()->comment('猜你喜欢出现位置:product,article');
            $table->enum('deal_type',['cpa','cps'])->comment('结算模式');
            $table->decimal('deal_price',6,2)->default(0)->comment('结算单价');
            $table->dateTime('first_onsale_at')->nullabel()->comment('初次上架时间');
            $table->text('district_limit')->nullable()->comment('产品限制地区,方便回显,纯文本');
            $table->text('district_code')->nullable()->comment('产品限制地区前端编码');
            $table->timestamps();
            $table->softDeletes();
        });

        //产品个人资质表
        Schema::create('product_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('个人资质名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        //产品个人资质中间表
        Schema::create('product_has_materials', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('material_id');

            $table->foreign('material_id')
                ->references('id')
                ->on('product_materials')
                ->onDelete('cascade');
        });


        //产品标签表
        Schema::create('product_labels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('标签名称');
            $table->string('color',50)->default('')->comment('颜色');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();


        });

        //产品标签中间
        Schema::create('product_has_labels', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('label_id');

            $table->foreign('label_id')
                ->references('id')
                ->on('product_labels')
                ->onDelete('cascade');
        });

        //产品分类表
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('标签名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('icon',255)->default('')->comment('icon图标地址');
            $table->string('banner',255)->default('')->comment('banner图片地址');
            $table->enum('redirect_type',['inside','outside'])->nullable()->comment('跳转类型');
            $table->enum('redirect_slug',['product','credit','article','help','about'])->nullable()->comment('跳转页面标识');
            $table->integer('redirect_id')->nullable()->comment('跳转详情id,仅redirect_slug=product/credit/article时有值');
            $table->string('banner_redirect',255)->nullable()->comment('banner跳转地址');
            $table->timestamps();
        });

        //产品分类中间表
        Schema::create('product_has_categories', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('category_id');

            $table->foreign('category_id')
                ->references('id')
                ->on('product_categories')
                ->onDelete('cascade');
        });

        //产品栏目表
        Schema::create('product_columns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->default('')->comment('栏目名称');
            $table->integer('sort')->default(0)->comment('排序');
            $table->json('banners');
            $table->timestamps();
        });

        //产品栏目中间表
        Schema::create('product_has_columns', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('column_id');

            $table->foreign('column_id')
                ->references('id')
                ->on('product_columns')
                ->onDelete('cascade');

        });

        //产品限制地区中间表
        Schema::create('product_has_districts', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('district_id');
        });

        //产品上线平台中间表
        Schema::create('product_has_platforms', function (Blueprint $table) {

            $table->unsignedInteger('product_id');
            $table->enum('platform',['android','ios','wap','pc']);

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

        });

        //产品贷款金额筛选区间表
        Schema::create('product_range_moneys', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->comment('类型:1=>小于,2=>区间,3=>大于');
            $table->integer('min')->default(0)->comment('小值');
            $table->integer('max')->default(0)->comment('大值');
            $table->integer('per_value')->default(0)->comment('单值');
            $table->enum('unit',['yuan','wan'])->comment('单位');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        //产品贷款还款周期筛选区间表
        Schema::create('product_range_periods', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->comment('类型:1=>小于,2=>区间,3=>大于');
            $table->integer('min')->default(0)->comment('小值');
            $table->integer('max')->default(0)->comment('大值');
            $table->integer('per_value')->default(0)->comment('单值');
            $table->enum('unit',['day','week','month','year'])->comment('时间单位');
            $table->integer('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        //产品收藏表
        Schema::create('product_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->integer('product_id')->default(0)->comment('产品id');
            $table->timestamps();
        });

        //用户分享记录
        Schema::create('product_shares', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mid')->default(0)->comment('用户id');
            $table->integer('product_id')->default(0)->comment('产品id');
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_materials');
        Schema::dropIfExists('product_has_materials');
        Schema::dropIfExists('product_labels');
        Schema::dropIfExists('product_has_labels');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_has_categories');
        Schema::dropIfExists('product_columns');
        Schema::dropIfExists('product_has_columns');
        Schema::dropIfExists('product_has_districts');
        Schema::dropIfExists('product_range_moneys');
        Schema::dropIfExists('product_range_periods');
        Schema::dropIfExists('product_collections');
        Schema::dropIfExists('product_shares');
        Schema::dropIfExists('product_has_platforms');

    }
}
