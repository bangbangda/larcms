<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedpackSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redpack_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['basis','newcomer','top'])->comment('红包类型 基础红包 新人红包 裂变红包');
            $table->float('amount', 3, 2)->nullable()->comment('红包金额');
            $table->float('min_random_amount', 3, 2)->nullable()->comment('随机红包区间 最小值');
            $table->float('max_random_amount', 3, 2)->nullable()->comment('随机红包区间 最大值');
            $table->integer('min_people_num')->default(0)->comment('达标人数 最小值');
            $table->integer('max_people_num')->default(0)->comment('达标人数 最大值');
            $table->dateTime('start_date')->nullable()->comment('有效开始时间');
            $table->dateTime('end_date')->nullable()->comment('有效结束时间');
            $table->softDeletes();
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
        Schema::dropIfExists('redpack_settings');
    }
}
