<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 获取小程序新增或活跃用户的画像分布数据
 *
 * Class CreateUserPortraitsTable
 */
class CreateUserPortraitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_portraits', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('类型 visit_uv_new visit_uv');
            $table->string('date_type')->default('day')->comment('时间范围支持昨天、最近7天、最近30天');
            $table->date('ref_date')->comment('数据日期');
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
        Schema::dropIfExists('user_portraits');
    }
}
