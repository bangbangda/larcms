<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 数据趋势-年龄分布
 *
 * Class CreateUserAgesTable
 */
class CreateUserAgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_portrait_id')->comment('画像数据编号');
            $table->string('name')->comment('年龄段');
            $table->integer('visit_uv')->comment('UV');
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
        Schema::dropIfExists('user_ages');
    }
}
