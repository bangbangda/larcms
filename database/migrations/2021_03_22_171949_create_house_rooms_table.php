<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->comment('房屋编号');
            $table->string('name')->comment('名称');
            $table->string('image_url')->comment('图片地址');
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
        Schema::dropIfExists('house_rooms');
    }
}
