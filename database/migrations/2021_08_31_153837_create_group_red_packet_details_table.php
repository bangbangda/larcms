<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupRedPacketDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_red_packet_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_red_packet_id')->comment('裂变红包主编号');
            $table->string('openid')->comment('领取人');
            $table->integer('amount')->comment('红包金额');
            $table->dateTime('receive_time')->comment('领取时间');
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
        Schema::dropIfExists('group_red_packet_details');
    }
}
