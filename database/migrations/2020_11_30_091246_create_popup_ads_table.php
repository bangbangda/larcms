<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popup_ads', function (Blueprint $table) {
            $table->id();
            $table->string('url')->comment('图片地址');
            $table->string('description')->nullable()->comment('描述');
            $table->boolean('auto_close')->default(true)->comment('自动关闭');
            $table->tinyInteger('close_second')->default(5)->comment('自动关闭秒数');
            $table->dateTime('start_date')->nullable()->comment('开始时间');
            $table->dateTime('end_date')->nullable()->comment('结束时间');
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
        Schema::dropIfExists('popup_ads');
    }
}
