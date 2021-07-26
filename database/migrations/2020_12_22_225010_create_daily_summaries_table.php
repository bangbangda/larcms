<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 用户访问小程序数据概况
 *
 * Class CreateDailySummariesTable
 */
class CreateDailySummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_summaries', function (Blueprint $table) {
            $table->id();
            $table->date('ref_date')->comment('数据日期');
            $table->integer('visit_total')->comment('累计用户数');
            $table->integer('share_pv')->comment('转发次数');
            $table->integer('share_uv')->comment('转发人数');
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
        Schema::dropIfExists('daily_summaries');
    }
}
