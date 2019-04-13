<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributeTimingUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribute_timing_updates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('encryption_name')->nullable();
            $table->integer('page_id')->nullable();
            $table->integer('template_id')->nullable();
            $table->integer('channel_code')->nullable();
            $table->integer('update_number')->nullable();
            $table->tinyInteger('is_ok')->default(0);
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
        Schema::dropIfExists('distribute_timing_updates');
    }
}
