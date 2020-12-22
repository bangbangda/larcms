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
            $table->string('type')->comment('红包类型');
            $table->float('amount', 3, 2)->comment('红包金额');
            $table->float('step_amount' , 3, 2)->comment('阶梯金额');
            $table->float('hit_rate' , 3, 1)->comment('命中率');
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
