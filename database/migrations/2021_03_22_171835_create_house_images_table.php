<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->comment('房屋编号');
            $table->string('image_url')->comment('轮博图片地址');
            $table->smallInteger('weight')->comment('排序字段');
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
        Schema::dropIfExists('house_images');
    }
}
