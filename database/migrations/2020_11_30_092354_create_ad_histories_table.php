<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('用户编号');
            $table->integer('advertable_id')->comment('广告编号');
            $table->string('advertable_type')->comment('广告类型');
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
        Schema::dropIfExists('ad_histories');
    }
}
