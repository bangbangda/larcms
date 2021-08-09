<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->comment('用户编号');
            $table->foreignId('share_order_id')->nullable()->comment('分享订单编号');
            $table->integer('amount')->comment('支付金额 单位分');
            $table->string('type')->comment('支付类型');
            $table->string('payment_no')->nullable()->comment('微信转账订单号');
            $table->dateTime('payment_time')->nullable()->comment('微信转账时间');
            $table->json('api_result')->comment('接口返回信息');
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
        Schema::dropIfExists('transfer_logs');
    }
}
