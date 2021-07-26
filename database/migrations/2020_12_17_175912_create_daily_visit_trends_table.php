<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 小程序数据趋势
 *
 * Class CreateDailyVisitTrendsTable
 */
class CreateDailyVisitTrendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_visit_trends', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('day')->comment('数据类型  day month week');
            $table->date('ref_date')->comment('数据日期');
            $table->integer('session_cnt')->comment('打开次数');
            $table->integer('visit_pv')->comment('访问次数');
            $table->integer('visit_uv')->comment('访问人数');
            $table->integer('visit_uv_new')->comment('新用户数');
            $table->float('stay_time_uv', 5)->comment('人均停留时长  单位秒');
            $table->float('stay_time_session', 5)->comment('次均停留时长 单位秒');
            $table->float('visit_depth', 4)->comment('平均访问深度');
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
        Schema::dropIfExists('daily_visit_trends');
    }
}
