<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_images', function (Blueprint $table) {
            $table->id();
            $table->string('url')->comment('图片地址');
            $table->dateTime('start_date')->comment('有效期-开始');
            $table->dateTime('end_date')->comment('有效期-结束');
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
        Schema::dropIfExists('share_images');
    }
}
