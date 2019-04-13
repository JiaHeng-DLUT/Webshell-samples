<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessCooperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_cooperations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('department',20)->default('')->comment('部门');
            $table->string('name',20)->default('')->comment('联系人');
            $table->string('phone',20)->default('')->comment('手机号码');
            $table->string('email',20)->default('')->comment('邮箱');
            $table->string('quantum_time')->comment('上班时间');
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
        Schema::dropIfExists('business_cooperations');
    }
}
