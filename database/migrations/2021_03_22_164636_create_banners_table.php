<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('jump_path')->nullable()->comment('点击后跳转路径');
            $table->string('jump_url')->nullable()->comment('点击后跳转链接');
            $table->dateTime('start_time')->nullable()->comment('有效期 开始时间');
            $table->dateTime('end_time')->nullable()->comment('有效期 结束时间');
            $table->string('image_url')->nullable()->comment('轮博图片地址');
            $table->smallInteger('weight')->comment('排序字段');
            $table->string('remark')->nullable()->comment('备注');
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
        Schema::dropIfExists('banners');
    }
}
