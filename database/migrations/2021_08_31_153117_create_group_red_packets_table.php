<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupRedPacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_red_packets', function (Blueprint $table) {
            $table->id();
            $table->string('bill_no')->comment('商户订单号');
            $table->string('red_packet_id')->nullable()->comment('微信支付系统红包单号');
            $table->string('openid')->comment('接收红包的种子用户（首个用户）');
            $table->integer('total_amount')->comment('红包发放总金额');
            $table->string('total_num')->comment('红包发放总人数');
            $table->string('status')->nullable()->comment('红包状态');
            $table->string('type')->default('GROUP')->comment('红包类型');
            $table->string('fail_reason')->nullable()->comment('失败原因');
            $table->dateTime('refund_time')->nullable()->comment('退款时间');
            $table->integer('refund_amount')->nullable()->comment('退款金额');
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
        Schema::dropIfExists('group_red_packets');
    }
}
