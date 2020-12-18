<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 数据趋势-手机平台
 *
 * Class CreateUserPlatformsTable
 */
class CreateUserPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_platforms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_portrait_id')->comment('画像数据编号');
            $table->string('name')->comment('平台名称');
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
        Schema::dropIfExists('user_platforms');
    }
}
