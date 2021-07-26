<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 获取用户关注公众号数据概况
 * Class CreateMpDailySummariesTable
 */
class CreateMpDailySummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_daily_summaries', function (Blueprint $table) {
            $table->id();
            $table->date('ref_date')->comment('数据日期');
            $table->integer('user_source')->comment('用户的渠道');
            $table->integer('new_user')->comment('新增的用户数量');
            $table->integer('cancel_user')->comment('取消关注的用户数量');
            $table->integer('cumulate_user')->default(0)->comment('总用户量');
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
        Schema::dropIfExists('mp_daily_summaries');
    }
}
